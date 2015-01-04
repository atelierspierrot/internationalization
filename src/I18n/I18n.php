<?php
/**
 * This file is part of the Internationalization package.
 *
 * Copyleft (ↄ) 2010-2015 Pierre Cassat <me@e-piwi.fr> and contributors
 * 
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 * 
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 * 
 * You should have received a copy of the GNU General Public License
 * along with this program. If not, see <http://www.gnu.org/licenses/>.
 *
 * The source code of this package is available online at 
 * <http://github.com/atelierspierrot/internationalization>.
 */

namespace I18n;

use \Locale;
use \NumberFormatter;
use \IntlDateFormatter;
use \DateTime;
use \Patterns\Abstracts\AbstractSingleton;
use \Patterns\Interfaces\TranslatableInterface;

/**
 * Internationalization class
 *
 * For more information, see:
 * -   <http://www.unicode.org/reports/tr35/>
 * -   <http://userguide.icu-project.org/locale>
 * -   <http://userguide.icu-project.org/formatparse/datetime>
 * -   <http://www.php.net/manual/en/book.intl.php>
 *
 * @author      Piero Wbmstr <me@e-piwi.fr>
 */
class I18n
    extends AbstractSingleton
    implements TranslatableInterface
{

    /**
     * @var \I18n\LoaderInterface The loader object
     */
    protected $loader;

    /**
     * @var string The current language code
     */
    protected $lang;

    /**
     * @var string The current timezone code
     */
    protected $timezone;

    /**
     * @var array The translated strings in the current language code
     */
    protected $language_strings;

    /**
     * An array to cache translated strings once they are loaded in a language
     * to avoid parsing the same db file more than once
     * @var array
     */
    private $language_strings_cache = array();

// --------------------
// Construct / Destruct / Clone
// --------------------

    /**
     * Initialization : the true constructor
     *
     * @param   \I18n\LoaderInterface  $loader
     * @param   string $lang A language code to use by default
     * @param   string $timezone A timezone code to use by default
     * @return  self
     * @throws  \I18n\I18nException if no default locale is defined and the `$lang` argument
     *          is empty, and if no default timezone is defined and the `$timezone` argument
     *          is empty
     */
    protected function init(LoaderInterface $loader, $lang = null, $timezone = null)
    {
        $this->setLoader($loader);
        if (is_null($lang)) {
            $lang = substr(Locale::getDefault(), 0, 2);
            if (empty($lang)) {
                throw new I18nException(
                    'No default locale defined in your system, please define the second argument of method "I18n::getInstance()"!'
                );
            }
        }

        $this->setLanguage($lang, false, $this->getLoader()->getOption('force_rebuild'));
        if (is_null($timezone)) {
            $timezone = @date_default_timezone_get();
            if (empty($timezone)) {
                throw new I18nException(
                    'No default timezone defined in your system, please define the third argument of method "I18n::getInstance()"!'
                );
            }
        }
        $this->setTimezone($timezone);

        if (empty($this->language_strings)) {
            $this->setLanguage(
                $this->getLoader()->getOption('default_language', 'en'), 
                false, 
                $this->getLoader()->getOption('force_rebuild')
            );
        }

        return $this;
    }

    /**
     * Load the current language strings
     *
     * This will parse the current language db files, or take it from the cache if so and load
     * the strings table in `$this->language_strings`.
     *
     * @param   bool $throw_errors Throw errors while re-creating the databases (default is `false`)
     * @param   bool $force_rebuild Force the system to rebuild the databases using `I18n\Generator` if it does not exist (default is `false`)
     * @param   bool $force_rebuild_on_update Force the system to rebuild the databases using `I18n\Generator` if it's more recent than language strings files (default is `false`)
     * @return  self
     * @throws  \I18n\I18nException if the database file seems to be malformed, and a
     * @throws  \I18n\I18nInvalidArgumentException it the file can't be found
     */
    protected function _loadLanguageStrings($throw_errors = true, $force_rebuild = false, $force_rebuild_on_update = false)
    {
        $_fn = $this->getLoader()->buildLanguageFileName($this->lang);
        $_f = $this->getLoader()->buildLanguageFilePath($this->lang);

        if (
            isset($this->language_strings_cache[$_f]) &&
            isset($this->language_strings_cache[$this->lang])
        ) {
            $this->language_strings = $this->language_strings_cache[$this->lang];
            return $this;
        }

        $db_f = $this->getLoader()->buildLanguageDBFilePath();
        if (@file_exists($_f)) {
            if ($force_rebuild_on_update && filemtime($db_f)>filemtime($_f)) {
                return $this
                    ->_rebuildLanguageStringsFiles()
                    ->_loadLanguageStrings();
            } else {
                $_v = $this->getLoader()->buildLanguageVarname($this->lang);
                include $_f;
                if (isset($$_v)) {
                    if (!isset($this->language_strings_cache[$this->lang])) {
                        $this->language_strings_cache[$this->lang] = array();
                    }
                    $this->language_strings_cache[$this->lang] =
                        array_merge($this->language_strings_cache[$this->lang], $$_v);
                    $this->language_strings_cache[$_f] = array(
                        'language'  => $this->lang,
                        'strings'   => $$_v
                    );
                    return $this->_loadLanguageStrings();
                } else {
                    throw new I18nException(
                        sprintf('Language strings seems to be malformed in file "%s" (must be a classic array like "string_index"=>"string in the language")!', $_fn)
                    );
                }
            }
        } elseif ($force_rebuild) {
            return $this
                ->_rebuildLanguageStringsFiles()
                ->_loadLanguageStrings();
        } elseif ($throw_errors) {
            throw new I18nInvalidArgumentException(
                sprintf('Language strings file for language code "%s" not found (searched in "%s")!', $this->lang, $_f)
            );
        }

        return $this;
    }

    /**
     * Rebuild the language strings databases with `I18n\Generator`
     *
     * @return self
     */
    protected function _rebuildLanguageStringsFiles()
    {
        $db_filepath = $this->getLoader()->buildLanguageDBFilePath();
        $generator = new Generator($db_filepath);
        $generator->generate();
        return $this;
    }

// --------------------
// Getters / Setters / Checkers / Builders
// --------------------

    /**
     * Store the loader
     *
     * @param   \I18n\LoaderInterface $loader
     * @return  self
     */
    public function setLoader(LoaderInterface $loader)
    {
        $this->loader = $loader;
        return $this;
    }

    /**
     * Gets the loader
     *
     * @return \I18n\LoaderInterface
     */
    public function getLoader()
    {
        return $this->loader;
    }

    /**
     * Load a new language file
     * @param   string          $file_name
     * @param   null|string     $dir_name
     * @throws  \I18n\I18nException
     * @throws  \Exception
     */
    public function loadFile($file_name, $dir_name = null)
    {
        try {
            $loader = $this->getLoader();
            $file_path = $loader->findLanguageDBFile(
                !empty($file_name) ? basename($file_name) : $file_name,
                !empty($dir_name) ? $dir_name : (
                    !empty($file_name) ? dirname($file_name) : $dir_name
                )
            );
            if ($file_path && file_exists($file_path)) {
                $loader
                    ->setOption('language_strings_db_directory', dirname($file_path))
                    ->setOption('language_strings_db_filename', basename($file_path))
                ;

                $this->_loadLanguageStrings(true, true, true);
            } else {
                throw new I18nInvalidArgumentException(
                    sprintf('Language file "%s" not found!', $file_name)
                );
            }
        } catch (I18nException $e) {
            throw $e;
        }
    }

    /**
     * Loads a new language
     *
     * This will actually define a new default Locale and load the language strings database.
     *
     * @param   string $lang A language code to use by default
     * @param   bool $throw_errors Throw errors while re-creating the databases (default is `false`)
     * @param   bool $force_rebuild Force the system to rebuild the databases using `I18n\Generator` (default is `false`)
     * @return  self Returns `$this` for method chaining
     * @throws  \I18n\I18nInvalidArgumentException it the language is not available
     */
    public function setLanguage($lang, $throw_errors = true, $force_rebuild = false)
    {
        if ($this->isAvailableLanguage($lang)) {
            $this->lang = $lang;
            $this->setLocale($this->getAvailableLocale($lang));
            $this->_loadLanguageStrings( $throw_errors, $force_rebuild );
        } else {
            throw new I18nInvalidArgumentException(
                sprintf('Language "%s" is not available in the application (available languages are %s)!', 
                    $lang, join(', ', $this->getLoader()->getOption('available_languages')))
            );
        }
        return $this;
    }

    /**
     * Get the current language code used
     *
     * @return string The current language code in use
     */
    public function getLanguage()
    {
        return $this->lang;
    }
    
    /**
     * Try to get the browser default locale and use it
     *
     * @return self
     */
    public function setDefaultFromHttp()
    {
        $http_locale = $this->getHttpHeaderLocale();
        if (!empty($http_locale) && $this->isAvailableLanguage($http_locale)) {
            $this->setLanguage($http_locale);
        }
        return $this;
    }
    
    /**
     * Check if a language code is available in the Loader
     *
     * @param string $lang A language code to use by default
     * @return bool Returns `true` if the language code exists, `false` otherwise
     */
    public function isAvailableLanguage($lang)
    {
        return array_key_exists($lang, $this->getLoader()->getOption('available_languages')) ||
            in_array($lang, $this->getLoader()->getOption('available_languages'));
    }
    
    /**
     * Get the full locale info for a language code
     *
     * This will look in the `Loader::available_languages` option to retrieve the full
     * locale string corresponding to a language code.
     *
     * @param string $lang A language code to use by default
     * @return null|string The full locale string if found
     */
    public function getAvailableLocale($lang)
    {
        $langs = $this->getLoader()->getOption('available_languages');
        if (array_key_exists($lang, $langs)) {
            return $langs[$lang];
        } elseif (in_array($lang, $langs)) {
            return $langs[array_search($lang, $langs)];
        }
        return null;
    }
    
    /**
     * Get the list of `Loader::available_languages`
     *
     * @return array The array defined in the Loader
     */
    public function getAvailableLanguages()
    {
        return $this->getLoader()->getOption(
            'available_languages',
            array($this->getLoader()->getOption('default_language', 'en'))
        );
    }
    
    /**
     * Define a new locale for the system
     *
     * @param string $locale The full locale string to define
     * @return self Returns `$this` for method chaining
     */
    public function setLocale($locale)
    {
        Locale::setDefault($locale);
        return $this;
    }
    
    /**
     * Get the current locale used by the system
     *
     * @return string The full locale string currently in use
     */
    public function getLocale()
    {
        return Locale::getDefault();
    }
    
    /**
     * Define a new timezone for the system
     *
     * @param string $timezone The full timezone string to define
     * @return self
     */
    public function setTimezone($timezone)
    {
        $this->timezone = $timezone;
        date_default_timezone_set($this->timezone);
        return $this;
    }
    
    /**
     * Get the current timezone used by the system
     *
     * @return string The full timezone string currently in use
     */
    public function getTimezone()
    {
        return $this->timezone;
    }
    
    /**
     * Check if a translation exists for an index
     *
     * @param string $index The original string or index to find translation of
     * @return bool Returns `true` if the translation exists, `false` otherwise
     */
    public function hasLocalizedString($index)
    {
        return isset($this->language_strings[$index]);
    }
    
    /**
     * Get the translation of an index
     *
     * @param string $index The original string or index to find translation of
     * @return string The translation found if so, `$index` otherwise
     */
    public function getLocalizedString($index)
    {
        return isset($this->language_strings[$index]) ?  $this->language_strings[$index] : $index;
    }

    /**
     * Parse a translated string making some parameters replacements
     *
     * @param string $str The original string to work on
     * @param array $arguments A table of arguments to replace, like `var=>val` pairs for
     *          the replacement of `%var%` by `val` in the final string (by default)
     * @return string The string with replacements
     */
    public function parseString($str, array $arguments = null)
    {
        if (empty($arguments)) return $str;
        $arg_mask = $this->getLoader()->getOption('arg_wrapper_mask');
        foreach($arguments as $name=>$value) {
            if (is_string($name)) {
                $str = strtr($str, array( sprintf($arg_mask, $name) => $value));
            } else {
                $str = sprintf($str, self::translate($value));
            }
        }
        return $str;
    }

    /**
     * Get the meta-data of a language string
     *
     * @param   string  $str
     * @return  array   array( (string) $str , (array) $info )
     */
    public function parseStringMetadata($str)
    {
        $info = array();
        if (0!==preg_match('~^\[([^\]]+)\]~i', $str, $matches)) {
            $str = str_replace($matches[0], '', $str);
            $types = $matches[1];
            $types_items = explode(';', $types);
            foreach ($types_items as $item) {
                $parts = explode(':', $item);
                if (count($parts)>1) {
                    $info[$parts[0]] = $parts[1];
                } else {
                    $info[] = $parts[0];
                }
            }
        }
        return array($str, $info);
    }

    /**
     * Special function to show a string when its translation doesn't exist
     *
     * This will return the original string with its arguments if so.
     *
     * @param string $str The original string to work on
     * @param array $args A table of arguments to replace
     * @return string The string dumped to identify untranslated strings
     */
    protected function _showUntranslated($str = '', array $args = null)
    {
        $arguments = '';
        if (!empty($args)) {
            foreach($args as $var=>$val) {
                $arguments .= '"'.$var.'" => '.str_replace(array("\n", "\t"), '', var_export($val,1)).', ';
            }
        }
        return sprintf($this->getLoader()->getOption('show_untranslated_wrapper', '%s'), $str, $arguments);
    }

// --------------------
// Names, currencies and codes getters
// --------------------

    /**
     * Get the currency of the current locale
     *
     * @param string $lang The language to use
     * @return string The currency code for the current locale
     */
    public function getCurrency($lang = null)
    {
        if (!is_null($lang)) {
            $original_lang = $this->getLanguage();
            $this->setLanguage( $lang );
        }
        $formatter = new NumberFormatter($this->getLocale(), NumberFormatter::CURRENCY);
        $currency = $formatter->getTextAttribute(NumberFormatter::CURRENCY_CODE);
        if (!empty($original_lang)) {
            $this->setLanguage( $original_lang );
        }
        return $currency;
    }
    
    /**
     * Get the browser requested locale if so
     *
     * @return string The browser prefered locale
     */
    public function getHttpHeaderLocale()
    {
        return Locale::acceptFromHttp($_SERVER['HTTP_ACCEPT_LANGUAGE']);
    }

    /**
     * Get the full list of `Loader::available_languages` option like human readable names
     *
     * @param string $lang The language to use
     * @return array The available languages table with the value as the human readable description
     *          of the corresponding locale
     */
    public function getAvailableLanguagesNames($lang = null)
    {
        if (!is_null($lang)) {
            $original_lang = $this->getLanguage();
            $this->setLanguage( $lang );
        }
        $db = $this->getLoader()->getOption('available_languages');
        $full_locales = array();
        if (!empty($db)) {
            foreach($db as $ln=>$locale) {
                $full_locales[$ln] = Locale::getDisplayName($locale);
            }
        }
        if (!empty($original_lang)) {
            $this->setLanguage( $original_lang );
        }
        return $full_locales;
    }
    
    /**
     * Get the language code of the current locale
     *
     * @param string $lang The language to use
     * @return string The language code for the current locale
     */
    public function getLanguageCode($lang = null)
    {
        $parts = $this->_callInternalLocale('parseLocale', null, $lang, false);
        return isset($parts['language']) ? $parts['language'] : null;
    }
    
    /**
     * Get the region code of the current locale
     *
     * @param string $lang The language to use
     * @return string The region code for the current locale
     */
    public function getRegionCode($lang = null)
    {
        return $this->_callInternalLocale('getRegion', null, $lang, false);
    }
    
    /**
     * Get the script code of the current locale
     *
     * @param string $lang The language to use
     * @return string The script code for the current locale
     */
    public function getScriptCode($lang = null)
    {
        return $this->_callInternalLocale('getScript', null, $lang, false);
    }
    
    /**
     * Get the keywords of the current locale
     *
     * @param string $lang The language to use
     * @return array The keywords for the current locale
     */
    public function getKeywords($lang = null)
    {
        return $this->_callInternalLocale('getKeywords', null, $lang, false);
    }
    
    /**
     * Get one keyword value of the current locale
     *
     * @param string $keyword The keyword to search
     * @param string $lang The language to use
     * @return null|string The keyword value for the current locale if found
     */
    public function getKeyword($keyword, $lang = null)
    {
        $parts = $this->_callInternalLocale('getKeywords', null, $lang, false);
        return isset($parts[$keyword]) ? $parts[$keyword] : null;
    }

    /**
     * Get the primary language of a locale
     *
     * @param string $for_locale The locale to work on, by default this will be the current locale
     * @param string $lang The language to use, by default this will be the current locale
     * @return string The primary language for the locale in the requested language
     */
    public function getPrimaryLanguage($for_locale = null, $lang = null)
    {
        return $this->_callInternalLocale('getPrimaryLanguage', $for_locale, $lang);
    }

    /**
     * Get the language name of a locale
     *
     * @param string $for_locale The locale to work on, by default this will be the current locale
     * @param string $lang The language to use, by default this will be the current locale
     * @return string The language name for the locale in the requested language
     */
    public function getLanguageName($for_locale = null, $lang = null)
    {
        return $this->_callInternalLocale('getDisplayLanguage', $for_locale, $lang);
    }
    
    /**
     * Get the country name of a locale
     *
     * @param string $for_locale The locale to work on, by default this will be the current locale
     * @param string $lang The language to use, by default this will be the current locale
     * @return string The country name for the locale in the requested language
     */
    public function getCountryName($for_locale = null, $lang = null)
    {
        return $this->_callInternalLocale('getDisplayRegion', $for_locale, $lang);
    }
    
    /**
     * Get the script name of a locale
     *
     * @param string $for_locale The locale to work on, by default this will be the current locale
     * @param string $lang The language to use, by default this will be the current locale
     * @return string The script name for the locale in the requested language
     */
    public function getLocaleScript($for_locale = null, $lang = null)
    {
        return $this->_callInternalLocale('getDisplayScript', $for_locale, $lang);
    }
    
    /**
     * Get the variant name of a locale
     *
     * @param string $for_locale The locale to work on, by default this will be the current locale
     * @param string $lang The language to use, by default this will be the current locale
     * @return string The variant name for the locale in the requested language
     */
    public function getLocaleVariant($for_locale = null, $lang = null)
    {
        return $this->_callInternalLocale('getDisplayVariant', $for_locale, $lang);
    }
    
    /**
     * Internally factorize the Locale methods
     *
     * @param   string $fct_name The name of the method to execute on `Locale`
     * @param   string $for_locale The locale to work on, by default this will be the current locale
     * @param   string $lang The language to use, by default this will be the current locale
     * @param   bool $do_array Do we have to pass both `$for_locale` and `$lang` arguments (default is `true`)
     * @return  mixed The result of `Locale:: $fct_name ( $for_locale , $lang )`
     */
    protected function _callInternalLocale($fct_name, $for_locale = null, $lang = null, $do_array = true)
    {
        if (!is_null($lang)) {
            $original_lang = $this->getLanguage();
            $this->setLanguage( $lang );
        }
        $locale = !is_null($for_locale) ? $this->getAvailableLocale($for_locale) : $this->getLocale();
        $arguments = $do_array ? array($locale, $this->getLocale()) : array($locale);
        $str = call_user_func_array(array('Locale', $fct_name), $arguments);
        if (!empty($original_lang)) {
            $this->setLanguage( $original_lang );
        }
        return $str;
    }

// --------------------
// Utilities formatter
// --------------------

    /**
     * Get a localized number value
     *
     * This is called by aliases `_N` and `numberify`.
     *
     * @param   int $number The number value to parse
     * @param   string $lang The language to use, by default this will be the current locale
     * @return  string The number value written in the locale
     * @see     _N()
     * @see     numberify()
     */
    public static function getLocalizedNumberString($number, $lang = null)
    {
        $_this = self::getInstance();
        if (!is_null($lang)) {
            $original_lang = $_this->getLanguage();
            $_this->setLanguage( $lang );
        }
        $formatter = new NumberFormatter($_this->getLocale(), NumberFormatter::DEFAULT_STYLE);
        $str =  $formatter->format($number);
        if (!empty($original_lang)) {
            $_this->setLanguage( $original_lang );
        }
        return $str;
    }
    
    /**
     * Get a localized price value
     *
     * This is called by aliases `_C` and `currencify`.
     *
     * @param   int $number The price value to parse
     * @param   string $lang The language to use, by default this will be the current locale
     * @return  string The price value written in the locale with a currency sign
     * @see     _C()
     * @see     currencify()
     */
    public static function getLocalizedPriceString($number, $lang = null)
    {
        $_this = self::getInstance();
        if (!is_null($lang)) {
            $original_lang = $_this->getLanguage();
            $_this->setLanguage( $lang );
        }
        $formatter = new NumberFormatter($_this->getLocale(), NumberFormatter::CURRENCY);
        $str = $formatter->format($number);
        if (!empty($original_lang)) {
            $_this->setLanguage( $original_lang );
        }
        return $str;
    }

    /**
     * Get a localized date value
     *
     * This is called by aliases `_D` and `datify`.
     *
     * @param   \DateTime $date The date value to parse as a `DateTime` object
     * @param   string $mask    A mask to use for date writing (by default, the `datetime_mask_icu` translation
     *                          string will be used, or no mask at all if it is not defined)
     * @param   string $charset The charset to use (default is `utf-8`)
     * @param   string $lang The language to use, by default this will be the current locale
     * @return  string The date value written in the locale
     * @see     _D()
     * @see     datify()
     */
    public static function getLocalizedDateString(DateTime $date, $mask = null, $charset = 'UTF-8', $lang = null)
    {
        $_this = self::getInstance();
        if (!is_null($lang)) {
            $original_lang = $_this->getLanguage();
            $_this->setLanguage( $lang );
        }

        if (is_null($mask)) $mask = $_this->getLocalizedString('datetime_mask_icu');
        if (!empty($mask)) {
            $fmt = new IntlDateFormatter( $_this->getLocale(), IntlDateFormatter::FULL, IntlDateFormatter::FULL,
                $_this->getTimezone(), IntlDateFormatter::GREGORIAN, $mask);
        } else {
            $fmt = new IntlDateFormatter( $_this->getLocale(), IntlDateFormatter::FULL, IntlDateFormatter::FULL,
                $_this->getTimezone(), IntlDateFormatter::GREGORIAN);
        }
        $str = $fmt->format($date);

/*
        if (is_null($mask)) $mask = $_this->getLocalizedString('datetime_mask');
        if (empty($mask)) $mask = '%a %e %m %Y %H:%M:%S';        
        setlocale(LC_TIME, $_this->getLocale().'.'.strtoupper($charset));
        $str = strftime($mask , strtotime($date->format('Y-m-d H:i:s')));
*/
        if (!empty($original_lang)) {
            $_this->setLanguage( $original_lang );
        }
        return $str;
    }

// --------------------
// Translator
// --------------------

    /**
     * Process a translation with arguments
     *
     * This is the core method of the class: it searches the translation of `$index` in the
     * current language, rebuilds it replacing the keys of `$args` by their values and returns
     * the corresponding localized translated string.
     *
     * This is called by aliases `_T` and `translate`.
     *
     * @param   string $index The index of the translation
     * @param   array $args The optional array of arguments for the final string replacements
     * @param   string $lang The language code to load translation from
     * @return  string Returns the translated string if it exists in the current language, with variables replacements
     * @see     _T()
     * @see     translate()
     */
    public static function translate($index, array $args = null, $lang = null)
    {
        $_this = self::getInstance();
        if (!is_null($lang)) {
            $original_lang = $_this->getLanguage();
            $_this->setLanguage( $lang );
        }
        if ($_this->hasLocalizedString($index)) {
            $str = $_this->getLocalizedString($index);
            list($str_tmp, $meta) = $_this->parseStringMetadata($str);
            if (!empty($meta)) {
                $str = $str_tmp;
//                var_export($meta);
            }
            $str = $_this->parseString($str, $args);
        } elseif ($_this->loader->getOption('show_untranslated', false)) {
            $str = $_this->_showUntranslated($index, $args);
        } else {
            $str = $index;
        }
        if (!empty($original_lang)) {
            $_this->setLanguage( $original_lang );
        }
        return $str;
    }

    /**
     * Process a translation with arguments depending on a counter
     *
     * This will first choose in `$indexes` the corresponding value for the counter `$number`
     * and then process the translation of the chosen string with arguments.
     *
     * This is called by aliases `_P` and `pluralize`.
     *
     * @param   array $indexes An array of translation strings indexes to choose in considering the counter value
     * @param   int $number The value of the counter to consider
     * @param   array $args The optional array of arguments for the final string replacements
     * @param   string $lang The language code to load translation from
     * @return  string Returns the translated string fot the counter value if it exists, in the current language and with variables replacements
     * @see     _P()
     * @see     pluralize()
     */
    public static function pluralize(array $indexes = array(), $number = 0, array $args = null, $lang = null)
    {
        $_this = self::getInstance();
        $args['nb'] = $number;
        if (isset($indexes[$number])) {
            return self::translate($indexes[$number], $args, $lang);
        }
        $str = ($number<=1) ? array_shift($indexes) : end($indexes);
        return self::translate($str, $args, $lang);
    }

}

// Endfile
