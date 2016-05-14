<?php
/**
 * Created by PhpStorm.
 * User: tobin
 * Date: 15/9/27
 * Time: 上午10:15
 */

namespace Tangerine\Utils;

class Functions
{
    public static function regex($value, $rule)
    {
        $validate = array(
            'require' => '/\S+/',
            'email' => '/^\w+([-+.]\w+)*@\w+([-.]\w+)*\.\w+([-.]\w+)*$/',
            'url' => '/^http(s?):\/\/(?:[A-za-z0-9-]+\.)+[A-za-z]{2,4}(:\d+)?(?:[\/\?#][\/=\?%\-&~`@[\]\':+!\.#\w]*)?$/',
            'currency' => '/^\d+(\.\d+)?$/',
            'number' => '/^\d+$/',
            'zip' => '/^\d{6}$/',
            'integer' => '/^[-\+]?\d+$/',
            'double' => '/^[-\+]?\d+(\.\d+)?$/',
            'english' => '/^[A-Za-z]+$/',
        );

        // 检查是否有内置的正则表达式
        if (isset($validate[strtolower($rule)])) $rule = $validate[strtolower($rule)];
        return preg_match($rule, $value) === 1;
    }

    public static function postUrl($url, $param)
    {
        // 创建参数数组
        $array = json_encode($param);

        // 初始化curl
        $ch = curl_init();
        // 参数设置
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $array);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        // 执行发送
        $result = curl_exec($ch);
        curl_close($ch);

        // 返回结果
        return $result;
    }

    public static function getUrl($url, $param)
    {
        // 构造完整url
        $query = http_build_query($param);
        $full_url = $url . "?" . $query;

        // 初始化
        $ch = curl_init();
        // 设置抓取的url
        curl_setopt($ch, CURLOPT_URL, $full_url);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        // 执行
        $result = curl_exec($ch);
        curl_close($ch);

        // 返回结果
        return $result;
    }

    public static function randomStr($length)
    {
        // prepare parameter
        $strPool = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";
        $strSize = strlen($strPool);

        // generate
        $str = "";
        for ($i = 0; $i < $length; $i++) {
            // random index
            $index = rand(0, $strSize - 1);
            // link to be a string
            $str .= $strPool[$index];
        }

        // return result
        return $str;
    }

}