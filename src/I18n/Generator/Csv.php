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


namespace I18n\Generator;

use \I18n\GeneratorInterface;

/**
 * @author  Piero Wbmstr <me@e-piwi.fr>
 */
class Csv
    implements GeneratorInterface
{

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