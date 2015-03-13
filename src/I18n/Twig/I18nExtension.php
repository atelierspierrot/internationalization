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

namespace I18n\Twig;

use \InvalidArgumentException;
use \Twig_Extension;
use \Twig_SimpleFilter;
use \Twig_SimpleFunction;
use \I18n\I18n;
use \I18n\Loader;
use \I18n\Twig\TranslateTokenParser;
use \I18n\Twig\PluralizeTokenParser;

/**
 * @author  piwi <me@e-piwi.fr>
 */
class I18nExtension
    extends Twig_Extension
{

    /**
     * @var \I18n\I18n
     */
    protected $i18n;

    /**
     * You can construct this extension by passing a `\I18n\I18n` object instance or just
     * a `\I18n\LoaderInterface` object or just an array of options.
     */
    public function __construct($arg)
    {
        if ($arg instanceof Loader) {
            I18n::getInstance($arg);
        } elseif (is_array($arg)) {
            $loader = new Loader($args);
            I18n::getInstance($loader);
        } elseif (!($arg instanceof I18n)) {
            throw new InvalidArgumentException(
                sprintf('The %s class must receive a I18n\I18n or I18n\LoaderInterface instance (received "%s")!', __CLASS__, gettype($arg))
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
