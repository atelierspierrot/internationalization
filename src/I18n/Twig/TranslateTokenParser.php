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

use \Twig_TokenParser;
use \Twig_Token;
use \Twig_NodeInterface;
use \Twig_Node_Text;
use \Twig_Node_Print;
use \Twig_Node_Expression_Name;
use \Twig_Node_Expression_Constant;
use \Twig_Node_Expression_Array;
use \Twig_Error_Syntax;
use \I18n\I18n;
use \I18n\Twig\TranslateNode;

/**
 * Use the I18n\I18n::translate function
 *
 * <pre>
 * {% translate %}
 *   your string index
 * {% endtranslate %}
 *
 * {% translate "your string index" %}
 *
 * {% translate 'fr' %}
 *   your string index
 * {% endtranslate %}
 *
 * {% translate 'fr' "your string index" %}
 *
 * {% translate { 'arg1': "value1", 'arg2': 567 } %}
 *   your string index
 * {% endtranslate %}
 *
 * {% translate { 'arg1': "value1", 'arg2': 567 } "your string index" %}
 * </pre>
 */
class TranslateTokenParser
    extends Twig_TokenParser
{

    public function parse(Twig_Token $token)
    {
        $i18n = I18n::getInstance();
        $lineno = $token->getLine();
        $stream = $this->parser->getStream();
        $body = $arguments = $lang = null;
        $args = array();

        if (!$stream->test(Twig_Token::BLOCK_END_TYPE)) {
            while (!$stream->test(Twig_Token::BLOCK_END_TYPE)) {
                $args[] = $this->parser->getExpressionParser()->parsePrimaryExpression();
            }
            foreach($args as $i=>$node) {
                if ($node instanceof Twig_Node_Expression_Array) {
                    $arguments = $node;
                } elseif ($node instanceof Twig_Node_Expression_Constant) {
                    if ($i18n->isAvailableLanguage($node->getAttribute('value'))) {
                        $lang = $node;
                    } else {
                        $body = $node;
                    }
                } else {
                    throw new Twig_Error_Syntax(
                        sprintf('Unexpected argument of type "%s" to the "translate" tag.', get_class($node)),
                        $stream->getCurrent()->getLine(), $stream->getFilename()
                    );
                }
            }

            if (empty($body)) {
                $stream->expect(Twig_Token::BLOCK_END_TYPE);
                $body = $this->parser->subparse(array($this, 'isEndTag'), true);
            }

        } else {
            $stream->expect(Twig_Token::BLOCK_END_TYPE);
            $body = $this->parser->subparse(array($this, 'isEndTag'), true);
        }

        if (empty($lang)) {
            $lang = new Twig_Node_Expression_Constant($i18n->getLanguage(), $lineno);
        }
        if (empty($arguments)) {
            $arguments = new Twig_Node_Expression_Array(array(), $lineno);
        }

        $stream->expect(Twig_Token::BLOCK_END_TYPE);
        return new TranslateNode($body, $arguments, $lang, $lineno, $this->getTag());
    }

    public function getTag()
    {
        return 'translate';
    }

    public function isEndTag(Twig_Token $token)
    {
        return $token->test('endtranslate');
    }

}

// Endfile