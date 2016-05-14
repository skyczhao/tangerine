<?php
/**
 * Created by PhpStorm.
 * User: tobin
 * Date: 5/14/16
 * Time: 11:26 AM
 */

namespace Tangerine\Tests\Utils;

use Analog;
use Tangerine\Utils\Database;

class DatabaseTest extends \PHPUnit_Framework_TestCase
{
    public function testConnect() {

//        $log_file = '/tmp/log.txt';
//        Analog\Analog::handler (Analog\Handler\File::init ($log_file));
//        echo file_get_contents ($log_file);

        Analog\Analog::handler (Analog\Handler\Stderr::init ());
        Analog\Analog::log("test");

        $db = Database::getInstance();
        $this->assertEquals(0, 0);
    }

    public function testGetInstance() {
        $db = Database::getInstance();
        $this->assertEquals(0, 0);
    }

    public function testGetTableFields() {
        $db = Database::getInstance();
        $fields = $db->getTableFields("user");
        $this->assertEquals("id", $fields[0]);
    }

    public function testGetError() {
        $db = Database::getInstance();
        $fields = $db->getTableFields("user2");
        $this->assertContains("doesn't exist", $db->getError());
    }

    public function testGetInsertId() {
        $db = Database::getInstance();
        $this->assertEquals(0, $db->getInsertId());
    }

    public function testSelect() {
        $db = Database::getInstance();
        $sql = "select * from user limit 10;";
        $this->assertEquals(10, count($db->select($sql)));
    }
}
