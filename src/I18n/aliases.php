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


/**
 * Common functions aliases
 */

if (!function_exists('_T')) 
{
    /**
     * Process a translation with arguments
     * @see     \I18n\I18n::translate()
     */
    function _T($index, array $args = null, $lang = null)
    {
        return \I18n\I18n::translate($index, $args, $lang);
    }
}

if (!function_exists('translate')) 
{
    /**
     * Process a translation with arguments
     * @see     \I18n\I18n::translate()
     */
    function translate($index, array $args = null, $lang = null)
    {
        return \I18n\I18n::translate($index, $args, $lang);
    }
}

if (!function_exists('_P')) 
{
    /**
     * Process a translation with arguments depending on a counter
     * @see     \I18n\I18n::pluralize()
     */
    function _P(array $indexes = array(), $number = 0, array $args = null, $lang = null)
    {
        return \I18n\I18n::pluralize($indexes, $number, $args, $lang);
    }
}

if (!function_exists('pluralize')) 
{
    /**
     * Process a translation with arguments depending on a counter
     * @see     \I18n\I18n::pluralize()
     */
    function pluralize(array $indexes = array(), $number = 0, array $args = null, $lang = null)
    {
        return \I18n\I18n::pluralize($indexes, $number, $args, $lang);
    }
}

if (!function_exists('_D')) 
{
    /**
     * Get a localized date value
     * @see     \I18n\I18n::getLocalizedDateString()
     */
    function _D(DateTime $date, $mask = null, $charset = 'UTF-8', $lang = null)
    {
        return \I18n\I18n::getLocalizedDateString($date, $mask, $charset, $lang);
    }
}

if (!function_exists('datify')) 
{
    /**
     * Get a localized date value
     * @see     \I18n\I18n::getLocalizedDateString()
     */
    function datify(DateTime $date, $mask = null, $charset = 'UTF-8', $lang = null)
    {
        return \I18n\I18n::getLocalizedDateString($date, $mask, $charset, $lang);
    }
}

if (!function_exists('_N')) 
{
    /**
     * Get a localized number value
     * @see     \I18n\I18n::getLocalizedNumberString()
     */
    function _N($number, $lang = null)
    {
        return \I18n\I18n::getLocalizedNumberString($number, $lang);
    }
}

if (!function_exists('numberify')) 
{
    /**
     * Get a localized number value
     * @see     \I18n\I18n::getLocalizedNumberString()
     */
    function numberify($number, $lang = null)
    {
        return \I18n\I18n::getLocalizedNumberString($number, $lang);
    }
}

if (!function_exists('_C')) 
{
    /**
     * Get a localized price value
     * @see     \I18n\I18n::getLocalizedPriceString()
     */
    function _C($number, $lang = null)
    {
        return \I18n\I18n::getLocalizedPriceString($number, $lang);
    }
}

if (!function_exists('currencify')) 
{
    /**
     * Get a localized price value
     * @see     \I18n\I18n::getLocalizedPriceString()
     */
    function currencify($number, $lang = null)
    {
        return \I18n\I18n::getLocalizedPriceString($number, $lang);
    }
}

if (!function_exists('getlocale')) 
{
    /**
     * Get current locale in use
     * @see     \Locale::getDefault()
     */
    function getlocale()
    {
        return \Locale::getDefault();
    }
}

// Endfile