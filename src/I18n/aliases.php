<?php
/*
# ***** BEGIN LICENSE BLOCK *****
# This file is part of the Internationalization package
# Copyleft (c) 2010-2014 Pierre Cassat and contributors
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