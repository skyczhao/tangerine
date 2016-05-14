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
            "DB_HOST" => "[HOST]",
            "DB_PORT" => "[PORT]",
            "DB_USER" => "[USERNAME]",
            "DB_PASS" => "[PASSWORD]",
            "DB_NAME" => "[DATABASE]"
        );
    }

}