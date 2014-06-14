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

namespace I18n\Twig;

use \Twig_TokenParser, \Twig_Token, \Twig_NodeInterface,
    \Twig_Node_Text, \Twig_Node_Print, \Twig_Node_Expression_Name,
    \Twig_Node_Expression_Constant, \Twig_Node_Expression_Array,
    \Twig_Error_Syntax;

use \I18n\I18n, \I18n\Twig\TranslateNode;

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
class TranslateTokenParser extends Twig_TokenParser
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