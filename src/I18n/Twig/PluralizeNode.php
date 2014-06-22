<?php
/**
 * PHP package to manage i18n by Les Ateliers Pierrot
 * Copyleft (c) 2010-2014 Pierre Cassat and contributors
 * <www.ateliers-pierrot.fr> - <contact@ateliers-pierrot.fr>
 * License GPL-3.0 <http://www.opensource.org/licenses/gpl-3.0.html>
 * Sources <http://github.com/atelierspierrot/internationalization>
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