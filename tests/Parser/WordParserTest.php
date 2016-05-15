<?php
/**
 * Created by PhpStorm.
 * User: tobin
 * Date: 5/15/16
 * Time: 11:54 AM
 */

namespace Tangerine\Tests\Parser;


use Tangerine\Parser\WordParser;

class WordParserTest extends \PHPUnit_Framework_TestCase
{
    public function testReadDocx() {
        $path = '/Users/tobin/Downloads/地址.docx';
        $word = WordParser::readDocx($path);
        var_dump($word->getDocInfo());
    }
}
