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


/**
 * Common functions aliases
 */

if (!function_exists('_T')) 
{
    function _T($index, array $args = null, $lang = null)
    {
        return \I18n\I18n::translate($index, $args, $lang);
    }
}

if (!function_exists('translate')) 
{
    function translate($index, array $args = null, $lang = null)
    {
        return \I18n\I18n::translate($index, $args, $lang);
    }
}

if (!function_exists('_P')) 
{
    function _P(array $indexes = array(), $number = 0, array $args = null, $lang = null)
    {
        return \I18n\I18n::pluralize($indexes, $number, $args, $lang);
    }
}

if (!function_exists('pluralize')) 
{
    function pluralize(array $indexes = array(), $number = 0, array $args = null, $lang = null)
    {
        return \I18n\I18n::pluralize($indexes, $number, $args, $lang);
    }
}

if (!function_exists('_D')) 
{
    function _D(DateTime $date, $mask = null, $charset = 'UTF-8', $lang = null)
    {
        return \I18n\I18n::getLocalizedDateString($date, $mask, $charset, $lang);
    }
}

if (!function_exists('datify')) 
{
    function datify(DateTime $date, $mask = null, $charset = 'UTF-8', $lang = null)
    {
        return \I18n\I18n::getLocalizedDateString($date, $mask, $charset, $lang);
    }
}

if (!function_exists('_N')) 
{
    function _N($number, $lang = null)
    {
        return \I18n\I18n::getLocalizedNumberString($number, $lang);
    }
}

if (!function_exists('numberify')) 
{
    function numberify($number, $lang = null)
    {
        return \I18n\I18n::getLocalizedNumberString($number, $lang);
    }
}

if (!function_exists('_C')) 
{
    function _C($number, $lang = null)
    {
        return \I18n\I18n::getLocalizedPriceString($number, $lang);
    }
}

if (!function_exists('currencify')) 
{
    function currencify($number, $lang = null)
    {
        return \I18n\I18n::getLocalizedPriceString($number, $lang);
    }
}

if (!function_exists('getlocale')) 
{
    function getlocale()
    {
        return \Locale::getDefault();
    }
}

// Endfile