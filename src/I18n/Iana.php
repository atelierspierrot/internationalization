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

use \Library\Helper\Directory as DirectoryHelper;

/**
 * Locale codes DB from <http://www.iana.org/assignments/language-subtag-registry>
 *
 * Construction of a code like the ICU project:
 *
 *     <language code>_<script code>_<country code>_<variant code>@keyword1:value;keyword2:value
 *
 * @author  piwi <me@e-piwi.fr>
 */
class Iana
{

    protected $db_filepath = '/tmp';
    protected $db_filename = 'iana-language-subtag-registry.php';
    protected $locales_db;

    const IANA_LANGUAGE_SUBTAG_REGISTRY = 'http://www.iana.org/assignments/language-subtag-registry';

    public function __construct($db_file = null, $db_dir = null)
    {
        if (!empty($db_file)) {
            $this->setDbFilename($db_file);
        }
        if (!empty($db_dir)) {
            $this->setDbFilepath($db_dir);
        }
    }

    public function setDbFilepath($path)
    {
        $this->db_filepath = $path;
        return $this;
    }

    public function getDbFilepath()
    {
        return $this->db_filepath;
    }

    public function setDbFilename($name)
    {
        $this->db_filename = $name;
        return $this;
    }

    public function getDbFilename()
    {
        return $this->db_filename;
    }

    public function getDbRealpath()
    {
        return DirectoryHelper::slashDirname($this->getDbFilepath()).$this->getDbFilename();
    }

    protected function _getOrigin()
    {
        $ch = curl_init(self::IANA_LANGUAGE_SUBTAG_REGISTRY);
        if ($ch) {
            $tmpfname = tempnam("/tmp", "ianadb.txt");
            if ($fp = @fopen($tmpfname, "w")) {
                curl_setopt($ch, CURLOPT_FILE, $fp);
                curl_setopt($ch, CURLOPT_HEADER, 0);
                if (false!==curl_exec($ch)) {
                    curl_close($ch);
                    fclose($fp);
                } else {
                    throw new \RuntimeException(
                        sprintf('cURL error "%s"!', curl_error($ch))
                    );
                }
            } else {
                throw new \RuntimeException(
                    sprintf('Can not open file "%s" to write IANA db!', $this->getDbRealpath())
                );
            }
        } else {
            throw new \RuntimeException(
                sprintf('cURL error trying to load URL "%s": "%s"!', self::IANA_LANGUAGE_SUBTAG_REGISTRY, curl_error($ch))
            );
        }
        return $tmpfname;
    }

    protected function _writeDb($from_file)
    {
        $db_content = file_get_contents($from_file);
        $parts = explode('%%', $db_content);
        $db = array();
        foreach ($parts as $i=>$block) {
            $block_parts = explode("\n", $block);
            $type = null;
            $subtag = array();
            foreach ($block_parts as $j=>$lineblock) {
                if (false!==strpos($lineblock, ':')) {
                    $items = explode(':', $lineblock);
                    $index = strtolower($items[0]);
                    $value = trim($items[1]);
                    if ($index==='type') {
                        $type = $value;
                    } elseif ($index==='comments') {
                        if (!isset($subtag[$index])) {
                            $subtag[$index] = '';
                        }
                        $subtag[$index] .= ' '.$value;
                    } else {
                        if (isset($subtag[$index]) && !is_array($subtag[$index])) {
                            $subtag[$index] = array( $subtag[$index] );
                        }
                        if (isset($subtag[$index]) && is_array($subtag[$index])) {
                            $subtag[$index][] = $value;
                        } else {
                            $subtag[$index] = $value;
                        }
                    }
                }
            }
            if (!isset($db[$type])) {
                $db[$type] = array();
            }
            $db[$type][] = $subtag;
        }


        $php_def = '<'.'?php'."\n".'define(\'I18N_LOCALES_IANADB\', serialize('."\n";
        $php_def .= var_export($db, true);
        $php_def .= "\n".'));'."\n".'?'.'>';
        if (false===file_put_contents($this->getDbRealpath(), $php_def, LOCK_EX)) {
            throw new \RuntimeException(
                sprintf('Can not open file "%s" to write IANA db!', $this->getDbRealpath())
            );
        }
    }

    public function update()
    {
        $tmpfile = $this->_getOrigin();
        $this->_writeDb($tmpfile);
    }
    
    public function read()
    {
        $db_file = $this->getDbRealpath();
        if (!file_exists($db_file)) {
            $this->update();
        }
        include $db_file;
        $this->locales_db = unserialize(I18N_LOCALES_IANADB);
    }

    public function getDb()
    {
        if (empty($this->locales_db)) {
            $this->read();
        }
        return $this->locales_db;
    }
    
    public function getLanguages()
    {
        $db = $this->getDb();
        $languages = array();
        foreach ($db['language'] as $item) {
            if (!isset($item['preferred-value']) && (
                !isset($item['scope']) || $item['scope']!=='macrolanguage'
            )) {
                $languages[$item['subtag']] = $item['description'];
            }
        }
        return $languages;
    }
    
    public function getRegions()
    {
        $db = $this->getDb();
        $regions = array();
        foreach ($db['region'] as $item) {
            if (!isset($item['preferred-value']) && (
                !isset($item['scope']) || $item['scope']!=='macrolanguage'
            )) {
                $regions[$item['subtag']] = $item['description'];
            }
        }
        return $regions;
    }

    public function getScripts()
    {
        $db = $this->getDb();
        $scripts = array();
        foreach ($db['script'] as $item) {
            if (!isset($item['preferred-value']) && (
                !isset($item['scope']) || $item['scope']!=='macrolanguage'
            )) {
                $scripts[$item['subtag']] = $item['description'];
            }
        }
        return $scripts;
    }

    public function getExtlangs()
    {
        $db = $this->getDb();
        $extlangs = array();
        foreach ($db['extlang'] as $item) {
            if (!isset($item['preferred-value']) && (
                !isset($item['scope']) || $item['scope']!=='macrolanguage'
            )) {
                $extlangs[$item['subtag']] = $item['description'];
            }
        }
        return $extlangs;
    }
}
