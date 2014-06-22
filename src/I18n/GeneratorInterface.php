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
interface GeneratorInterface
{

    /**
     * @param string $from_file The file to read and parse
     * @param \I18n\I18n $i18n The I18n instance
     */
    public function generate($from_file, \I18n\I18n $i18n);

}

// Endfile