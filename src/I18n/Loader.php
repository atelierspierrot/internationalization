<?php
/**
 * PHP package to manage i18n by Les Ateliers Pierrot
 * Copyleft (ↄ) 2010-2015 Pierre Cassat and contributors
 * <www.ateliers-pierrot.fr> - <contact@ateliers-pierrot.fr>
 * License GPL-3.0 <http://www.opensource.org/licenses/gpl-3.0.html>
 * Sources <http://github.com/atelierspierrot/internationalization>
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
 */

namespace I18n;

use \Patterns\Abstracts\AbstractOptionable;

/**
 * @author  Piero Wbmstr <me@e-piwi.fr>
 */
class Loader
    extends AbstractOptionable
{

    /**
     * The default options
     */
    public static $defaults = array(
        'available_languages'   => array(
            'en' => 'en_US_USD',
            'gb' => 'en_GB_UKP',
            'fr' => 'fr_FR_EUR'
        ),
        'default_language'              => 'en',
        // "%%" will be considered as a literal percent sign
        'arg_wrapper_mask'              => "%%%s%%",
        // paths
        'language_varname'              => 'i18n_%s',
        'language_directory'            => null,
        'language_filename'             => 'i18n.%s.php',
        // for CSV database rebuild
        'language_strings_db_directory' => null,
        'language_strings_db_filename'  => 'i18n.csv',
        'force_rebuild'                 => false,
        'force_rebuild_on_update'       => false,
        // show the untranslated strings for debug
        'show_untranslated'             => false,
        'show_untranslated_wrapper'     => '<span style="color:red"><strong>%s</strong> (%s)</span>',
    );

    /**
     * Creation of a Loader with an optional user defined set of options
     *
     * @param array $user_options An array of options values to over-write defaults
     */
    public function __construct(array $user_options = array())
    {
        $this->setOptions( array_merge(self::$defaults, $user_options) );
    }

    /**
     * Parse an option value replacing `%s` by the actual language code
     *
     * @param   string $name The option name
     * @param   string $lang The language code to use
     * @param   mixed $default The value to return if the option can't be found
     * @return  mixed The value of the option if found, with replacement if so
     */
    public function getParsedOption($name, $lang = null, $default = null)
    {
        $val = $this->getOption($name, $default);
        if (false!==strpos($val, '%s')) {
            if (is_null($lang)) {
                $i18n = I18n::getInstance();
                $lang = $i18n->getLanguage();
            }
            $val = sprintf($val, $lang);
        }
        return $val;
    }

    /**
     * Build the file name for the language database 
     *
     * @param   string $lang The language code to use
     * @return  string The file name for the concerned language
     */
    public function buildLanguageFileName($lang)
    {
        return $this->getParsedOption('language_filename', $lang);
    }

    /**
     * Build the file path for the language database 
     *
     * @param   string  $lang The language code to use
     * @param   string  $path
     * @return  string The file path for the concerned language
     */
    public function buildLanguageFilePath($lang, $path = null)
    {
        return rtrim($this->getParsedOption('language_directory', $lang), '/').'/'.$this->buildLanguageFileName($lang);
    }

    /**
     * Build the variable name for the language database 
     *
     * @param   string $lang The language code to use
     * @return  string The variable name for the concerned language
     */
    public function buildLanguageVarname($lang)
    {
        return $this->getParsedOption('language_varname', $lang);
    }

    /**
     * Build the file name for the language CSV database 
     *
     * @return  string
     */
    public function buildLanguageDBFileName()
    {
        return $this->getParsedOption('language_strings_db_filename');
    }

    /**
     * Build the file path for the language CSV database 
     *
     * @return  string
     */
    public function buildLanguageDBFilePath()
    {
        return rtrim($this->getParsedOption('language_strings_db_directory'), '/')
            .'/'.$this->getParsedOption('language_strings_db_filename');
    }

}

// Endfile