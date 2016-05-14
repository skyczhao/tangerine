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
    public static function ajax_render($controller, $operate = 'm')
    {
        $method = '';
        if (isset($_GET[$operate])) {
            $method = $_GET[$operate];
        } else if (isset($_POST[$operate])) {
            $method = $_POST[$operate];
        } else {
            $method = 'index';
        }

        if (!method_exists($controller, $method)) {
            $method = 'error';
        }

        $controller->$method();
    }

    function get_input($name, $default = '', $filter = '')
    {
        // 获取输入方式
        $input = '';
        switch ($_SERVER['REQUEST_METHOD']) {
            case 'POST':
                $input = $_POST;
                break;
//        TODO: 处理'php://input'
//        case 'PUT':
//            $input = $_PUT;
//            break;
            default:
                $input = $_GET;
        }

        // 获取输入
        $data = null;
        if (isset($input[$name])) {
            $data = $input[$name];
            $pass = false;
            // 过滤
            switch (strtolower($filter)) {
                case 'int':
                    $data = (int)$data;
                    $pass = true;
                    break;
                case 'double':
                    $data = (double)$data;
                    $pass = true;
                    break;
                case 'float':
                    $data = (float)$data;
                    $pass = true;
                    break;
                case 'number':
                    if (is_numeric($data)) {
                        $pass = true;
                    }
                    break;
                case 'string':
                    if (is_string($data)) {
                        $pass = true;
                    }
                    break;
                case 'email':
                    if (regex($data, 'email')) {
                        $pass = true;
                    }
                    break;
                default:
                    if (!empty($filter)) {
                        if (preg_match($filter, (string)$data)) $pass = true;
                    } else {
                        $pass = true;
                    }
            }
            if (!$pass) $data = $default;
        } else {
            $data = $default;
        }

        return $data;
    }

    function get_session($name, $default = '')
    {
        $value = $default;
        if (isset($_SESSION[$name])) {
            $value = $_SESSION[$name];
        }

        return $value;
    }

    function set_session($name, $value)
    {
        $_SESSION[$name] = $value;
    }

    function clear_session()
    {
        $_SESSION = array();
        session_unset();
    }

    function regex($value, $rule)
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

    function post_url($url, $param)
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
        //$result = json_decode($result);
        return $result;
    }

    function get_url($url, $param)
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

    function random_string($length)
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