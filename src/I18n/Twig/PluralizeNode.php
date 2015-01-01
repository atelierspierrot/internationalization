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

use \Twig_Node;
use \Twig_NodeInterface;
use \Twig_Node_Expression;
use \Twig_Compiler;
use \Twig_Node_Expression_Constant;
use \Twig_Node_Expression_Array;

class PluralizeNode
    extends Twig_Node
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