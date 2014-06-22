<?php
/**
 * PHP package to manage i18n by Les Ateliers Pierrot
 * Copyleft (c) 2010-2014 Pierre Cassat and contributors
 * <www.ateliers-pierrot.fr> - <contact@ateliers-pierrot.fr>
 * License GPL-3.0 <http://www.opensource.org/licenses/gpl-3.0.html>
 * Sources <http://github.com/atelierspierrot/internationalization>
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
