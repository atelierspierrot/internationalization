<?php
/**
 * PHP package to manage i18n by Les Ateliers Pierrot
 * Copyleft (c) 2010-2014 Pierre Cassat and contributors
 * <www.ateliers-pierrot.fr> - <contact@ateliers-pierrot.fr>
 * License GPL-3.0 <http://www.opensource.org/licenses/gpl-3.0.html>
 * Sources <http://github.com/atelierspierrot/internationalization>
 */


namespace I18n\Generator;

use I18n\GeneratorInterface;

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