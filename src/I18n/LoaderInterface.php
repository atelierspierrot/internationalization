<?php
/**
 * This file is part of the Internationalization package.
 *
 * Copyright (c) 2010-2016 Pierre Cassat <me@e-piwi.fr> and contributors
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

/**
 * @author  piwi <me@e-piwi.fr>
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
