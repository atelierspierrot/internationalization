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


namespace I18n\Generator;

use \I18n\GeneratorInterface;

/**
 * @author  Piero Wbmstr <me@e-piwi.fr>
 */
class Csv
    implements GeneratorInterface
{

    /**
     * @param string $from_file The file to read and parse
     * @param \I18n\I18n $i18n The I18n instance
     * @return array\null
     */
    public function generate($from_file, \I18n\I18n $i18n)
    {
        $default = $i18n->getLoader()->getOption('default_language', 'en');
        $all_lang_strings = $headers = array();

        if (false!==($handle=fopen($from_file, 'r'))) {
            $line_count = 0;
            while (false!==($data = fgetcsv($handle, 0, ';', '"'))) {
                if ($line_count===0) {
                    for ($c=0; $c<count($data); $c++) {
                        $headers[$c] = $data[$c];
                        if ($c!==0) {
                            $all_lang_strings[$data[$c]] = array();
                        }
                        if ($data[$c]===$default) {
                            $default_index = $c;
                        }
                    }
                } else {
                    $index = $data[0];
                    if (empty($index)) {
                        $index = isset($data[$default_index]) ? $data[$default_index] : uniqid();
                    }
                    for ($d=1; $d<count($data); $d++) {
                        $lang = $headers[$d];
                        if (!isset($all_lang_strings[$lang][$index])) {
                            $all_lang_strings[$lang][$index] = $data[$d];
                        } else {
                            trigger_error(
                                sprintf('Language string with index "%s" defined more than one time!', $index)
                                , E_USER_NOTICE);
                        }
                    }
                }
                $line_count++;
            }  
            fclose($handle);  
        }
        
        return $all_lang_strings;
    }

}

// Endfile