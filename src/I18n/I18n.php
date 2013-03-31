<?php
/*
# ***** BEGIN LICENSE BLOCK *****
# This file is part of the Internationalization package
# Copyleft (c) 2010 Pierre Cassat and contributors
#
# <http://www.ateliers-pierrot.fr> - <contact@ateliers-pierrot.fr>
#
# Internationalization package is a free software; you can redistribute it and/or modify it under the terms 
# of the GNU General Public License as published by the Free Software Foundation; either version 
# 3 of the License, or (at your option) any later version.
#
# Internationalization package is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; 
# without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
# See the GNU General Public License for more details.
#
# You should have received a copy of the GNU General Public License along with this program; 
# if not, write to the :
#     Free Software Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
# or see the page :
#    <http://www.opensource.org/licenses/gpl-3.0.html>
#
# Ce programme est un logiciel libre distribué sous licence GNU/GPL.
#
# ***** END LICENSE BLOCK ***** */

namespace I18n;

use \Locale,
    \NumberFormatter,
    \IntlDateFormatter,
    \DateTime;

use Patterns\Abstracts\AbstractSingleton,
    Patterns\Interfaces\TranslatableInterface;

use I18n\Loader;

/**
 * Internationalization class
 *
 * @author 		Piero Wbmstr <piero.wbmstr@gmail.com>
 */
class I18n extends AbstractSingleton implements TranslatableInterface
{

    protected $loader;

    protected $lang;

    protected $timezone;

    protected $language_strings;

    private $language_strings_cache = array();

// --------------------
// Singleton Interface
// --------------------

    public static function getInstance(Loader $loader = null, $lang = null, $timezone = null)
    {
        return parent::getInstance($loader, $lang, $timezone);
    }

// --------------------
// Construct / Destruct / Clone
// --------------------

    protected function init(Loader $loader, $lang = null, $timezone = null)
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
        $this->setLanguage($lang, false, $this->loader->getOption('force_rebuild'));
        if (is_null($timezone)) {
            $timezone = date_default_timezone_get();
            if (empty($timezone)) {
                throw new I18nException(
                    'No default timezone defined in your system, please define the third argument of method "I18n::getInstance()"!'
                );
            }
        }
        $this->setTimezone($timezone);
        if (empty($this->language_strings)) {
            $this->setLanguage($this->loader->getOption('default_language', 'en'), false, $this->loader->getOption('force_rebuild'));
        }
    }

    protected function _loadLanguageStrings($throw_errors = true, $force_rebuild = false)
    {
        $_fn = $this->loader->buildLanguageFileName($this->lang);
        $_f = $this->loader->buildLanguageFilePath($this->lang);
        if (isset($this->language_strings_cache[$_f])) {
            $this->language_strings = $this->language_strings_cache[$_f];
            return;
        }

        if (@file_exists($_f)) {
            $_v = $this->loader->buildLanguageVarname($this->lang);
            include $_f;
            if (isset($$_v)) {
                $this->language_strings = $$_v;
                $this->language_strings_cache[$_f] = $this->language_strings;
            } else {
                throw new I18nException(
                    sprintf('Language strings seems to be malformed in file "%s" (must be a classic array like "string_index"=>"string in the language")!', $_fn)
                );
            }
        } elseif ($force_rebuild) {
            $this->_rebuildLanguageStringsFiles();
            $this->_loadLanguageStrings();
        } elseif ($throw_errors) {
            throw new I18nInvalidArgumentException(
                sprintf('Language strings file for language code "%s" not found (searched in "%s")!', $this->lang, $_f)
            );
        }
    }

    protected function _rebuildLanguageStringsFiles()
    {
        $db_filepath = rtrim($this->loader->getOption('language_strings_db_directory'), '/')
            .'/'.$this->loader->getOption('language_strings_db_filename');
        $generator = new Generator($db_filepath);
        $generator->generate();
    }

// --------------------
// Getters / Setters / Checkers / Builders
// --------------------

    public function setLoader(Loader $loader)
    {
        $this->loader = $loader;
        return $this;
    }

    public function getLoader()
    {
        return $this->loader;
    }

    public function setLanguage($lang, $throw_errors = true, $force_rebuild = false)
    {
        if ($this->isAvailableLanguage($lang)) {
            $this->lang = $lang;
            $this->setLocale($this->getAvailableLocale($lang));
            $this->_loadLanguageStrings( $throw_errors, $force_rebuild );
            return $this;
        } else {
            throw new I18nInvalidArgumentException(
                sprintf('Language "%s" is not available in the application (available languages are %s)!', 
                    $lang, join(', ', $this->loader->getOption('available_languages')))
            );
        }
    }

    public function getLanguage()
    {
        return $this->lang;
    }
    
    public function setDefaultFromHttp()
    {
        $http_locale = $this->getHttpHeaderLocale();
        if ($this->isAvailableLanguage($http_locale)) {
            $this->setLanguage($http_locale);
        }
    }
    
    public function isAvailableLanguage($lang)
    {
        return array_key_exists($lang, $this->loader->getOption('available_languages')) ||
            in_array($lang, $this->loader->getOption('available_languages'));
    }
    
    public function getAvailableLocale($lang)
    {
        $langs = $this->loader->getOption('available_languages');
        if (array_key_exists($lang, $langs)) {
            return $langs[$lang];
        } elseif (in_array($lang, $langs)) {
            return $langs[array_search($lang, $langs)];
        }
        return null;
    }
    
    public function getAvailableLanguages()
    {
        return $this->loader->getOption('available_languages', array($this->loader->getOption('default_language', 'en')));
    }
    
    public function setLocale($locale)
    {
        Locale::setDefault($locale);
        return $this;
    }
    
    public function getLocale()
    {
        return Locale::getDefault();
    }
    
    public function setTimezone($timezone)
    {
        $this->timezone = $timezone;
        date_default_timezone_set($this->timezone);
        return $this;
    }
    
    public function getTimezone()
    {
        return $this->timezone;
    }
    
    public function hasLocalizedString($index)
    {
        return isset($this->language_strings[$index]);
    }
    
    public function getLocalizedString($index)
    {
        return isset($this->language_strings[$index]) ?  $this->language_strings[$index] : $index;
    }

    public function parseString($str, array $arguments = null)
    {
        if (empty($arguments)) return $str;
        $arg_mask = $this->loader->getOption('arg_wrapper_mask');
        foreach($arguments as $name=>$value) {
            $str = strtr($str, array( sprintf($arg_mask, $name) => $value));
        }
        return $str;
    }

    protected function _showUntranslated($str = '', array $args = null)
    {
        $arguments = '';
        if (!empty($args)) {
            foreach($args as $var=>$val) {
                $arguments .= '"'.$var.'" => '.str_replace(array("\n", "\t"), '', var_export($val,1)).', ';
            }
        }
        return sprintf($this->loader->getOption('show_untranslated_wrapper', '%s'), $str, $arguments);
    }

// --------------------
// Names, currencies and codes getters
// --------------------

    public function getCurrency($lang = null)
    {
        if (!is_null($lang)) {
            $original_lang = $this->getLanguage();
            $this->setLanguage( $lang );
        }
        $formater = new NumberFormatter($this->getLocale(), NumberFormatter::CURRENCY);
        $currency = $formater->getTextAttribute(NumberFormatter::CURRENCY_CODE);
        if (!empty($original_lang)) {
            $this->setLanguage( $original_lang );
        }
        return $currency;
    }
    
    public function getHttpHeaderLocale()
    {
        return Locale::acceptFromHttp($_SERVER['HTTP_ACCEPT_LANGUAGE']);
    }

    public function getLanguageCode($lang = null)
    {
        $parts = $this->_callInternalLocale('parseLocale', null, $lang, false);
        return isset($parts['language']) ? $parts['language'] : null;
    }
    
    public function getRegionCode($lang = null)
    {
        return $this->_callInternalLocale('getRegion', null, $lang, false);
    }
    
    public function getScriptCode($lang = null)
    {
        return $this->_callInternalLocale('getScript', null, $lang, false);
    }
    
    public function getKeywords($lang = null)
    {
        return $this->_callInternalLocale('getKeywords', null, $lang, false);
    }
    
    public function getKeyword($keyword, $lang = null)
    {
        $parts = $this->_callInternalLocale('getKeywords', null, $lang, false);
        return isset($parts[$keyword]) ? $parts[$keyword] : null;
    }

    public function getPrimaryLanguage($for_locale = null, $lang = null)
    {
        return $this->_callInternalLocale('getPrimaryLanguage', $for_locale, $lang);
    }

    public function getLanguageName($for_locale = null, $lang = null)
    {
        return $this->_callInternalLocale('getDisplayLanguage', $for_locale, $lang);
    }
    
    public function getCountryName($for_locale = null, $lang = null)
    {
        return $this->_callInternalLocale('getDisplayRegion', $for_locale, $lang);
    }
    
    public function getLocaleScript($for_locale = null, $lang = null)
    {
        return $this->_callInternalLocale('getDisplayScript', $for_locale, $lang);
    }
    
    public function getLocaleVariant($for_locale = null, $lang = null)
    {
        return $this->_callInternalLocale('getDisplayVariant', $for_locale, $lang);
    }
    
    protected function _callInternalLocale($fct_name, $for_locale = null, $lang = null, $do_array = true)
    {
        if (!is_null($lang)) {
            $original_lang = $this->getLanguage();
            $this->setLanguage( $lang );
        }
        $locale = !is_null($for_locale) ? $this->getAvailableLocale($for_locale) : $this->getLocale();
        $arguments = $fo_array ? array($locale, $this->getLocale()) : array($locale);
        $str = call_user_func_array(array('Locale', $fct_name), $arguments);
        if (!empty($original_lang)) {
            $this->setLanguage( $original_lang );
        }
        return $str;
    }

// --------------------
// Utilities formatter
// --------------------

    public static function getLocalizedNumberString($number, $lang = null)
    {
        $_this = self::getInstance();
        if (!is_null($lang)) {
            $original_lang = $_this->getLanguage();
            $_this->setLanguage( $lang );
        }
        $formater = new NumberFormatter($_this->getLocale(), NumberFormatter::DEFAULT_STYLE);
        $str =  $formater->format($number);
        if (!empty($original_lang)) {
            $_this->setLanguage( $original_lang );
        }
        return $str;
    }
    
    public static function getLocalizedPriceString($number, $lang = null)
    {
        $_this = self::getInstance();
        if (!is_null($lang)) {
            $original_lang = $_this->getLanguage();
            $_this->setLanguage( $lang );
        }
        $formater = new NumberFormatter($_this->getLocale(), NumberFormatter::CURRENCY);
        $str = $formater->format($number);
        if (!empty($original_lang)) {
            $_this->setLanguage( $original_lang );
        }
        return $str;
    }

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
     * @param string $index The index of the translation
     * @param array $args The optional array of arguments for the final string replacements
     * @param str $lang The language code to load translation from
     * @return str Returns the translated string if it exists in the current language, with variables replacements
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
     * @param array $indexes An array of translation strings indexes to choose in considering the counter value
     * @param num $number The value of the counter to consider
     * @param array $args The optional array of arguments for the final string replacements
     * @param str $lang The language code to load translation from
     * @return str Returns the translated string fot the counter value if it exists, in the current language and with variables replacements
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