<?php
/**
 * Created by PhpStorm.
 * User: tobin
 * Date: 5/14/16
 * Time: 11:44 AM
 */

namespace Tangerine\Tests\Conf;

use Tangerine\Conf\Commons;

class CommonsTest extends \PHPUnit_Framework_TestCase
{
    public function testGetConfig() {
        $config = Commons::getConfig();
        $this->assertEquals("127.0.0.1", $config['DB_HOST']);
    }
}
