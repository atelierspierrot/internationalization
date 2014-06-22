<?php
/**
 * PHP package to manage i18n by Les Ateliers Pierrot
 * Copyleft (c) 2010-2014 Pierre Cassat and contributors
 * <www.ateliers-pierrot.fr> - <contact@ateliers-pierrot.fr>
 * License GPL-3.0 <http://www.opensource.org/licenses/gpl-3.0.html>
 * Sources <http://github.com/atelierspierrot/internationalization>
 */


namespace I18n;

/**
 * @author  Piero Wbmstr <me@e-piwi.fr>
 */
class Generator
{

    protected $generator;

    protected $db_filepath;

    public function __construct($db_filepath = null, $generator = 'csv')
    {
        if (!empty($db_filepath)) $this->setDbFilepath($db_filepath);
        if (!empty($generator)) $this->setGenerator($generator);
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

    public function getGenerator()
    {
        return $this->generator;
    }

    public function generate()
    {
        $_f = $this->getDbFilepath();
        $i18n = I18n::getInstance();
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
    }

}

// Endfile