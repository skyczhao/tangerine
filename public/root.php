<?php
/**
 * Created by PhpStorm.
 * User: tobin
 * Date: 5/15/16
 * Time: 11:23 AM
 */

if(version_compare(PHP_VERSION, '5.3.0', '<'))  die('require PHP > 5.3.0 !');

date_default_timezone_set('PRC');

define("ROOT",           dirname(__FILE__));
define('REQUEST_METHOD', $_SERVER['REQUEST_METHOD']);
define('IS_GET',         REQUEST_METHOD == 'GET' ? true : false);
define('IS_POST',        REQUEST_METHOD == 'POST' ? true : false);
define('IS_PUT',         REQUEST_METHOD == 'PUT' ? true : false);
define('IS_DELETE',      REQUEST_METHOD == 'DELETE' ? true : false);

// TODO: 配置加载到commons
// TODO: analog的配置