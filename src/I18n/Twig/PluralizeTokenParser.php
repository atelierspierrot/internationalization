<?php
/**
 * This file is part of the Internationalization package.
 *
 * Copyleft (ↄ) 2010-2015 Pierre Cassat <me@e-piwi.fr> and contributors
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
use \I18n\I18n, \I18n\Twig\PluralizeNode;

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
class PluralizeTokenParser
    extends Twig_TokenParser
{

    public function parse(Twig_Token $token)
    {
        $i18n = I18n::getInstance();
        $lineno = $token->getLine();
        $stream = $this->parser->getStream();
        $choices = $counter = $arguments = $lang = null;
        $args = array();

        if (!$stream->test(Twig_Token::BLOCK_END_TYPE)) {
            while (!$stream->test(Twig_Token::BLOCK_END_TYPE)) {
                $args[] = $this->parser->getExpressionParser()->parsePrimaryExpression();
            }
            foreach($args as $i=>$node) {
                if ($node instanceof Twig_Node_Expression_Array) {
                    $arguments = $node;
                } elseif ($node instanceof Twig_Node_Expression_Constant) {
                    if (is_numeric($node->getAttribute('value'))) {
                        $counter = $node;
                    } elseif ($i18n->isAvailableLanguage($node->getAttribute('value'))) {
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

        if (empty($choices)) {
            $value = $body->hasAttribute('value') ? $body->getAttribute('value') : $body->getAttribute('data');
            $value = trim($value, "\n");
            $choices_values = explode('|', $value);
            $choices_table = array();
            foreach($choices_values as $i=>$val) {
                $choices_table[] = new Twig_Node_Expression_Constant($i, $lineno);
                $choices_table[] = new Twig_Node_Expression_Constant(trim($val), $lineno);
            }
            $choices = new Twig_Node_Expression_Array($choices_table, $lineno);
        }

        if (empty($lang)) {
            $lang = new Twig_Node_Expression_Constant($i18n->getLanguage(), $lineno);
        }
        if (empty($arguments)) {
            $arguments = new Twig_Node_Expression_Array(array(), $lineno);
        }

        $stream->expect(Twig_Token::BLOCK_END_TYPE);
/*
var_export($choices);
var_export($counter);
var_export($arguments);
exit('yo');
*/
        return new PluralizeNode($choices, $counter, $arguments, $lang, $lineno, $this->getTag());
    }

    public function getTag()
    {
        return 'pluralize';
    }

    public function isEndTag(Twig_Token $token)
    {
        return $token->test('endpluralize');
    }

}

// Endfile