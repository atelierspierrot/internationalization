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