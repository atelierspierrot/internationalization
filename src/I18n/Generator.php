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
class Generator
{

    /**
     * @var \I18n\GeneratorInterface
     */
    protected $generator;

    /**
     * @var string
     */
    protected $db_filepath;

    /**
     * @param   string  $db_filepath
     * @param   string  $generator
     */
    public function __construct($db_filepath = null, $generator = 'csv')
    {
        if (!empty($db_filepath)){
            $this->setDbFilepath($db_filepath);
        }
        if (!empty($generator)) {
            $this->setGenerator($generator);
        }
    }

    /**
     * @param $path
     * @return $this
     */
    public function setDbFilepath($path)
    {
        $this->db_filepath = $path;
        return $this;
    }

    /**
     * @return string
     */
    public function getDbFilepath()
    {
        return $this->db_filepath;
    }

    /**
     * @param $name
     * @return $this
     */
    public function setGenerator($name)
    {
        $cls_name = '\I18n\Generator\\'.ucfirst($name);
        if (class_exists($cls_name)) {
            $generator = new $cls_name;
            if ($generator instanceof GeneratorInterface) {
                $this->generator = $generator;
            } else {
                throw new I18nInvalidArgumentException(
                    sprintf('Internationalization database generator "%s" must implement interface "I18n\GeneratorInterface"!', $name)
                );
            }
        } else {
            throw new I18nInvalidArgumentException(
                sprintf('Unknown internationalization database generator named "%s"!', $name)
            );
        }
        return $this;
    }

    /**
     * @return GeneratorInterface
     */
    public function getGenerator()
    {
        return $this->generator;
    }

    /**
     * @return bool
     * @throws I18nException
     */
    public function generate()
    {
        $ok     = false;
        $_f     = $this->getDbFilepath();
        $i18n   = I18n::getInstance();
        if (@file_exists($_f)) {
            $all_lang_strings = $this->getGenerator()->generate($_f, $i18n);
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
        return $ok;
    }

}

// Endfile