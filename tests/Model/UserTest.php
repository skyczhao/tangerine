<?php
/**
 * Created by PhpStorm.
 * User: tobin
 * Date: 5/14/16
 * Time: 5:05 PM
 */

namespace Tangerine\Tests\Model;


use Tangerine\Model\User;

class UserTest extends \PHPUnit_Framework_TestCase
{
    public function testConstruct() {
        $user = new User();
    }

    public function testGetFields() {
        $user = new User();
//        var_dump($user->getFields());
    }

    public function testWhere() {
        $user = new User();
        $condition = Array(
            "id" => array("between", 1, 3)
        );
        $this->assertEquals(3, count($user->where($condition)->select()));
    }

    public function testGetError() {
        $user = new User();
        $res = $user->where(array("i"=>-1))->select();
        $this->assertContains("Unknown column", $user->getError());
    }

    public function testGetInsertId() {
        $user = new User();
        $params = array(
            "username"=>"csvxlsx2",
            "realname"=>"docdocx2"
        );
        if ($user->insert($params)) {
            $this->assertEquals($user->where($params)->select()[0]["id"], $user->getInsertId());
        } else {
            echo $user->getError();
        }
//        $this->assertEquals(0, $user->getInsertId());
    }

    public function testDelete() {
        $user = new User();
        $params = array(
            "username"=>"csvxlsx",
            "realname"=>"docdocx"
        );
        $this->assertTrue($user->where($params)->delete());
    }

    public function testGenUpdatePairs() {
        $user = new User();
        $params = array(
            "username"=>"csvxlsx",
            "realname"=>"docdocx"
        );
        $this->assertEquals(" `username`='csvxlsx', `realname`='docdocx'", $user->genUpdatePairs($params));
    }

    public function testUpdate() {
        $user = new User();
        $rules = array(
            "username"=>"mkl"
        );
        $map = array(
            "realname"=>"poker",
            "email"=>"admin@admin.com"
        );
        $this->assertTrue($user->where($rules)->update($map));
    }

    public function testAtomicUpdate() {
        $user = new User();
        $rules = array(
            "username"=>"mkl"
        );
        $map = array(
            "realname"=>"icc",
            "email"=>"compiler@intel.com"
        );
        $this->assertTrue($user->where($rules)->atomicUpdate($map));
    }
}
