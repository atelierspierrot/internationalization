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

namespace I18n\Twig;

use \Twig_Node, \Twig_NodeInterface, \Twig_Node_Expression, \Twig_Compiler,
    \Twig_Node_Expression_Constant, \Twig_Node_Expression_Array;

class PluralizeNode extends Twig_Node
{

    public function __construct(
        Twig_Node_Expression_Array $choices,
        Twig_Node_Expression_Constant $counter,
        Twig_Node_Expression_Array $params,
        Twig_Node_Expression_Constant $lang,
        $lineno, $tag = null
    ) {
        parent::__construct(array('choices'=>$choices, 'counter'=>$counter, 'params'=>$params, 'lang'=>$lang), array(), $lineno, $tag);
    }

    public function compile(Twig_Compiler $compiler)
    {
        $compiler
            ->raw('echo pluralize(')
            ->subcompile($this->getNode('choices'))
            ->raw(', ')
            ->subcompile($this->getNode('counter'))
            ->raw(', ')
            ->subcompile($this->getNode('params'))
            ->raw(', ')
            ->subcompile($this->getNode('lang'))
            ->raw(')."\n";'."\n");

        if (defined('I18N_TWIGTAGS_DEBUG') && I18N_TWIGTAGS_DEBUG) {
            echo '<pre>'.var_export($compiler->getSource(),1).'</pre>';
        }
    }

}

// Endfile