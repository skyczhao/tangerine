<?php
/**
 * Created by PhpStorm.
 * User: tobin
 * Date: 5/12/16
 * Time: 11:24 PM
 */

date_default_timezone_set('UTC');

$vendor = realpath(__DIR__ . '/../vendor');
if (file_exists($vendor . '/autoload.php')) {
    require $vendor . '/autoload.php';
} else {
    throw new Exception('Unable to load dependencies');
}