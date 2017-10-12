<?php
 
/*
* DoctrineExtensions Oracle Function Pack
*
* LICENSE
*
* This source file is subject to the new BSD license that is bundled
* with this package in the file LICENSE.txt.
* If you did not receive a copy of the license and are unable to
* obtain it through the world-wide-web, please send an email
* to kontakt@beberlei.de so I can send you a copy immediately.
*/
namespace Arii\CoreBundle\DQL\oci8;
 
use Doctrine\ORM\Query\AST\Functions\FunctionNode;
use Doctrine\ORM\Query\Lexer;
use Doctrine\ORM\Query\Parser;
use Doctrine\ORM\Query\SqlWalker;
 
/**
* "getDBDate" "(" SimpleArithmeticExpression ")"
*/
class Date extends FunctionNode
{
    public $date;
    
    public function getSql(\Doctrine\ORM\Query\SqlWalker $sqlWalker)
    {
        return "TRUNC(" . $sqlWalker->walkArithmeticPrimary($this->date) . " )";
    }
    
    public function parse(\Doctrine\ORM\Query\Parser $parser)
    {
        $parser->match(Lexer::T_IDENTIFIER);
        $parser->match(Lexer::T_OPEN_PARENTHESIS);
        $this->date = $parser->ArithmeticExpression();
        $parser->match(Lexer::T_COMMA);
        $this->fmt = $parser->StringExpression();
        $parser->match(Lexer::T_CLOSE_PARENTHESIS);
    }
}