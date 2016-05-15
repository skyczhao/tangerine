<?php
/**
 * Created by PhpStorm.
 * User: tobin
 * Date: 5/15/16
 * Time: 10:01 PM
 */

namespace Tangerine\Tests\Parser;

use Analog;
use Tangerine\Conf\Settings;
use Tangerine\Parser\PdfParser;

class PdfParserTest extends \PHPUnit_Framework_TestCase
{
    public function testGetInfo() {
        Analog\Analog::handler(Analog\Handler\Stderr::init ());
        Settings::setPdfInfoCmd("/Users/tobin/bin/pdfinfo");

        $path = "/Users/tobin/Downloads/Java性能权威指南-CH1.pdf";
        $result = PdfParser::getInfo($path);
        $this->assertNotEquals(1, $result);
        $this->assertEquals(30, $result[0]);
    }
}
