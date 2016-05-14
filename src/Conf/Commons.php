<?php
/**
 * Created by PhpStorm.
 * User: tobin
 * Date: 5/14/16
 * Time: 11:36 AM
 */

namespace Tangerine\Conf;

class Commons
{
    public static function getConfig()
    {
        return array(
            "DB_HOST" => "127.0.0.1",
            "DB_PORT" => "3306",
            "DB_USER" => "root",
            "DB_PASS" => "",
            "DB_NAME" => "printit"
        );
    }

}