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

/**
 * @author  Piero Wbmstr <me@e-piwi.fr>
 */
interface LoaderInterface
{

    /**
     * Get the value of a specific option
     *
     * @param   string  $name       The index of the option to get
     * @param   mixed   $default    The default value to return if the option is not defined
     * @return  array   The current option's value if defined, `$default` otherwise
     */
    public function getOption($name, $default = null);

    /**
     * Build the file name for the language database 
     *
     * @param   string  $lang           The language code to use
     * @param   string  $db_filename    A base filename to use
     * @return  string  The file name for the concerned language
     */
    public function buildLanguageFileName($lang, $db_filename = null);

    /**
     * Build the directory name for the language database
     *
     * @param   string  $lang   The language code to use
     * @return  string  The directory name for the concerned language with trailing slash
     */
    public function buildLanguageDirName($lang);

    /**
     * Build the absolute file path for the language database
     *
     * @param   string  $lang The language code to use
     * @return  string  The file path for the concerned language
     */
    public function buildLanguageFilePath($lang);

    /**
     * Build the variable name for the language database 
     *
     * @param   string $lang The language code to use
     * @return  string The variable name for the concerned language
     */
    public function buildLanguageVarname($lang);

    /**
     * Build the file name for the language CSV database 
     *
     * @return  string
     */
    public function buildLanguageDBFileName();

    /**
     * Build the directory name for the language CSV database
     *
     * @return  string
     */
    public function buildLanguageDBDirName();

    /**
     * Build the absolute file path for the language CSV database
     *
     * @return  string
     */
    public function buildLanguageDBFilePath();

    /**
     * Find a language file from options directories
     *
     * @param   string  $db_filename
     * @param   string  $db_directory
     * @return  null|string
     */
    public function findLanguageDBFile($db_filename = null, $db_directory = null);

}

// Endfile