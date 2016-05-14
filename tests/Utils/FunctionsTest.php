<?php
/**
 * Created by PhpStorm.
 * User: tobin
 * Date: 5/14/16
 * Time: 3:23 PM
 */

namespace Tangerine\Tests\Utils;

use Tangerine\Utils\Functions;

class FunctionsTest extends \PHPUnit_Framework_TestCase
{
    public function testRegex() {
        $this->assertTrue(Functions::regex("skyc@163.com", "email"));
        $this->assertFalse(Functions::regex("skyc@163.com", "english"));
    }

    public function testGetUrl() {
        $this->assertContains("helloworld", Functions::getUrl("http://www.baidu.com/s", array("wd"=>"helloworld")));
    }

    public function testRandomStr() {
        $str = Functions::randomStr(8);
        $this->assertEquals(8, strlen($str));
    }
}
