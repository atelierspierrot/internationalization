<?php
/**
 * PHP package to manage i18n by Les Ateliers Pierrot
 * Copyleft (ↄ) 2010-2015 Pierre Cassat and contributors
 * <www.ateliers-pierrot.fr> - <contact@ateliers-pierrot.fr>
 * License GPL-3.0 <http://www.opensource.org/licenses/gpl-3.0.html>
 * Sources <http://github.com/atelierspierrot/internationalization>
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
 */


namespace I18n\Twig;

use \InvalidArgumentException;
use \Twig_Extension;
use \Twig_SimpleFilter;
use \Twig_SimpleFunction;
use \I18n\I18n;
use \I18n\Loader;
use \I18n\Twig\TranslateTokenParser;
use \I18n\Twig\PluralizeTokenParser;

class I18nExtension
    extends Twig_Extension
{

    protected $i18n;

    /**
     * You can construct this extension by passing a `I18n\I18n` object instance or just
     * a `I18n\Loader` object ar just an array of options.
     */
    public function __construct($arg)
    {
        if ($arg instanceof Loader) {
            I18n::getInstance($arg);
        } elseif (is_array($arg)) {
            $loader = new Loader($args);
            I18n::getInstance($loader);
        } elseif (!$arg instanceof I18n) {
            throw new InvalidArgumentException(
                sprintf('The %s class must receive a I18n\I18n or I18n\Loader instance (received "%s")!', __CLASS__, gettype($arg))
            );
        }
    }

    public function getName()
    {
        return 'Internationalization';
    }

    public function getGlobals()
    {
        return array(
            'i18n' => I18n::getInstance()
        );
    }

    public function getFilters()
    {
        return array(
            new Twig_SimpleFilter('translate', '\I18n\I18n::translate'),
            new Twig_SimpleFilter('pluralize', '\I18n\I18n::pluralize'),
            new Twig_SimpleFilter('datify', '\I18n\I18n::getLocalizedDateString'),
        );
    }

    public function getFunctions()
    {
        return array(
            new Twig_SimpleFunction('translate', '\I18n\I18n::translate'),
            new Twig_SimpleFunction('pluralize', '\I18n\I18n::pluralize'),
            new Twig_SimpleFunction('datify', '\I18n\I18n::getLocalizedDateString'),
        );
    }

    public function getTokenParsers()
    {
        return array(
            new TranslateTokenParser(),
            new PluralizeTokenParser()
        );
    }

}

// Endfile
