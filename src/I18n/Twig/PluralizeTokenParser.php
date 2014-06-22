<?php
/**
 * PHP package to manage i18n by Les Ateliers Pierrot
 * Copyleft (c) 2010-2014 Pierre Cassat and contributors
 * <www.ateliers-pierrot.fr> - <contact@ateliers-pierrot.fr>
 * License GPL-3.0 <http://www.opensource.org/licenses/gpl-3.0.html>
 * Sources <http://github.com/atelierspierrot/internationalization>
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