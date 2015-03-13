<?php
/**
 * This file is part of the Internationalization package.
 *
 * Copyright (c) 2010-2015 Pierre Cassat <me@e-piwi.fr> and contributors
 * 
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 * 
 *      http://www.apache.org/licenses/LICENSE-2.0
 * 
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 *
 * The source code of this package is available online at 
 * <http://github.com/atelierspierrot/internationalization>.
 */

namespace I18n;

use \Patterns\Abstracts\AbstractOptionable;
use \Library\Helper\Directory as DirectoryHelper;

/**
 * @author  piwi <me@e-piwi.fr>
 */
class Loader
    extends AbstractOptionable
    implements LoaderInterface
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
        'language_filename'             => '%s.%s.php',
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
     * @var array A special registry to store various paths of languages DBs
     */
    protected $_paths = array(
        'language_strings_db_directory' => array(),
        'language_strings_db_filename'  => array(),
        'loaded_files'                  => array(),
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
     * Add a path to the registry
     * @param   null|string     $db_filename
     * @param   null|string     $db_directory
     * @param   null|string     $file
     * @return  $this
     */
    public function addPath($db_filename = null, $db_directory = null, $file = null)
    {
        if (!empty($db_filename) && !in_array($db_filename, $this->_paths['language_strings_db_filename'])) {
            $this->_paths['language_strings_db_filename'][] = $db_filename;
        }
        if (!empty($db_directory) && !in_array($db_directory, $this->_paths['language_strings_db_directory'])) {
            $this->_paths['language_strings_db_directory'][] = $db_directory;
        }
        if (!empty($file) && !in_array($file, $this->_paths['loaded_files'])) {
            $this->_paths['loaded_files'][] = $file;
        }
        return $this;
    }

    /**
     * Parse an option value replacing `%s` by the actual language code
     *
     * @param   string $name The option name
     * @param   string|array $lang The language code to use or an array to pass to
     *          the 'sprintf()' method
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
            if (is_array($lang)) {
                array_unshift($lang, $val);
                $val = call_user_func_array('sprintf', $lang);
            } else {
                $val = sprintf($val, $lang);
            }
        }
        return $val;
    }

// ------------------
// LoaderInterface
// ------------------

    /**
     * Build the file name for the language database 
     *
     * @param   string  $lang           The language code to use
     * @param   string  $db_filename    A base filename to use
     * @return  string  The file name for the concerned language
     */
    public function buildLanguageFileName($lang, $db_filename = null)
    {
        if (empty($db_filename)) {
            $db_filename = $this->getParsedOption('language_strings_db_filename');
        }
        $filename = pathinfo($db_filename,  PATHINFO_FILENAME);
        return $this->getParsedOption('language_filename', array($filename, $lang));
    }

    /**
     * Build the directory name for the language database
     *
     * @param   string  $lang   The language code to use
     * @return  string  The directory name for the concerned language with trailing slash
     */
    public function buildLanguageDirName($lang)
    {
        return DirectoryHelper::slashDirname($this->getParsedOption('language_directory', $lang));
    }

    /**
     * Build the absolute file path for the language database
     *
     * @param   string  $lang The language code to use
     * @return  string  The file path for the concerned language
     */
    public function buildLanguageFilePath($lang)
    {
        return $this->buildLanguageDirName($lang).$this->buildLanguageFileName($lang);
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
     * Build the directory name for the language CSV database
     *
     * @return  string
     */
    public function buildLanguageDBDirName()
    {
        return DirectoryHelper::slashDirname($this->getParsedOption('language_strings_db_directory'));
    }

    /**
     * Build the file path for the language CSV database
     *
     * @return  string
     */
    public function buildLanguageDBFilePath()
    {
        return $this->findLanguageDBFile();
    }

    /**
     * Find (and add if needed) a language file from options directories
     *
     * @param   string  $db_filename
     * @param   string  $db_directory
     * @return  null|string
     */
    public function findLanguageDBFile($db_filename = null, $db_directory = null)
    {
        if (empty($db_filename)) {
            $db_filename = $this->buildLanguageDBFileName();
        }
        if (empty($db_directory)) {
            $db_directory = $this->buildLanguageDBDirName();
        }

        $_file = null;
        $tmp_file = DirectoryHelper::slashDirname($db_directory).$db_filename;
        if (file_exists($tmp_file)) {
            $_file = $tmp_file;
        } else {
            foreach ($this->_paths['language_strings_db_directory'] as $dir) {
                $tmp_file = DirectoryHelper::slashDirname($dir).$db_filename;
                if (file_exists($tmp_file)) {
                    $_file = $tmp_file;
                }
            }
        }

        $this->addPath($db_filename, $db_directory, $_file);
        return $_file;
    }

}

// Endfile