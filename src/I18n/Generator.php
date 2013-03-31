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

/**
 * @author 		Piero Wbmstr <piero.wbmstr@gmail.com>
 */
class Generator
{

    protected $db_filepath;

    public function __construct($db_filepath = null)
    {
        if (!empty($db_filepath)) $this->setDbFilepath($db_filepath);
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

    public function generate()
    {
        $_f = $this->getDbFilepath();
        $i18n = I18n::getInstance();
        if (@file_exists($_f)) {
            $all_lang_strings = $headers = array();
            if (false!==($handle=fopen($_f, 'r'))) {
                $line_count = 0;
                while (false!==($data = fgetcsv($handle, 0, ';', '"'))) {
                    if ($line_count===0) {
                        for ($c=0; $c<count($data); $c++) {
                            $headers[$c] = $data[$c];
                            if ($c!==0) {
                                $all_lang_strings[$data[$c]] = array();
                            }
                        }
                    } else {
                        $index = $data[0];
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
            
            foreach($all_lang_strings as $lang=>$strings) {
                $_lf = $i18n->getLoader()->buildLanguageFilePath($lang);
                $dir = dirname($_lf);
                if (!file_exists($dir)) {
                    $ok = mkdir($dir, 0777, true);
                    if (false===$ok) {
                        throw new I18nRuntimeException(
                            sprintf('Directory "%s" can not be created!', $dir)
                        );
                    }
                }
                $_lv = $i18n->getLoader()->buildLanguageVarname($lang);
                $_lctt = '<'.'?'.'php'."\n".'$'.$_lv.'='.var_export($strings,true).';'."\n".'?'.'>';
                $ok = file_put_contents($_lf, $_lctt);
                if (false===$ok) {
                    throw new I18nRuntimeException(
                        sprintf('Language strings database file "%s" can not be written!', $_lf)
                    );
                }
            }
        } else {
            throw new I18nException(
                sprintf('Language strings database file "%s" not found!', $_f)
            );
        }        
    }

}

// Endfile