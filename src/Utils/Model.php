<?php

/**
 * Created by PhpStorm.
 * User: tobin
 * Date: 15/9/27
 * Time: 上午8:48
 */

namespace Tangerine\Utils;

use Tangerine\Utils\Database;

class Model
{
    protected $db        = null;
    protected $tableName = '';
    protected $condition = '';

    protected $fields    = array();

    public function __construct() {
        $classId         = get_called_class();
        $classIdParts    = explode("\\", $classId);
        $classIdLength   = count($classIdParts);
        $className       = strtolower($classIdParts[$classIdLength - 1]);
        $classLength     = strlen($className);

        $this->db        = Database::get_instance();
        $this->tableName = substr($className, 0, $classLength - 5);
    }

    final public function get_fields() {
        if (empty($this->tableName)) {
            return null;
        }

        if (count($this->fields)) {
            return $this->fields;
        }

        // 获取字段名
        $this->fields = $this->db->get_table_fields($this->tableName);
        return $this->fields;
    }

    final public function where($array) {
        // 判断连接方式
        $connect = 'and';
        if (array_key_exists('_connect', $array)) $connect = $array['_connect'];

        // 拼接条件
        $param = '';
        foreach ($array as $key => $value) {
            // 跳过控制参数
            if ($key[0] == '_') continue;

            if (!empty($param)) $param = "$param $connect ";

            if (is_array($value)) {
                switch ($value[0]) {
                    case 'like':
                        $param = "$param (`$key` like '$value[1]')";
                        break;
                    case 'between':
                        $param = "$param (`$key` between '$value[1]' and '$value[2]')";
                        break;
                    default:
                        break;
                }
            } else {
                $param = "$param (`$key`='$value')";
            }
        }

        if (array_key_exists('_order', $array)) {
            $field = '';
            $order = '';
            if (count($array['_order']) > 1) {
                $field = $array['_order'][0];
                $order = strtoupper($array['_order'][1]);
            } else {
                $field = $array['_order'];
            }
            $param = "$param ORDER BY `$field` $order";
        }
        if (array_key_exists('_limit', $array)) {
            $offset = 0;
            if (count($array['_limit']) > 1) {
                $offset = $array['_limit'][0];
                $rows = $array['_limit'][1];
            } else {
                $rows = $array['_limit'];
            }

            if ($offset == 0) {
                $param = "$param LIMIT $rows";
            } else {
                $param = "$param LIMIT $offset, $rows";
            }
        }

        $this->condition = $param;
        // 满足连贯操作
        return $this;
    }

    public function get_error() {
        return $this->db->get_error();
    }

    public function get_insert_id() {
        return $this->db->get_insert_id();
    }

    public function insert($array) {
        $fields = '';
        $format = '';
        // 构造参数
        foreach ($array as $key => $value) {
            if (!empty($fields)) $fields = "$fields, ";
            if (!empty($format)) $format = "$format, ";

            $fields = "$fields `$key`";
            $format = "$format '$value'";
        }

        $sql = "INSERT INTO `$this->tableName` ($fields) VALUES ($format);";
        return $this->db->insert($sql);
    }

    public function delete() {
        $sql = "DELETE FROM `$this->tableName` WHERE $this->condition;";
        return $this->db->delete($sql);
    }

    public function construct_update_pairs($array) {
        $pairs = '';
        // 构造参数
        foreach ($array as $key => $value) {
            if (!empty($pairs)) $pairs = "$pairs, ";

            if (!is_array($value)) {
                $pairs = "$pairs `$key`='$value'";
            } else {
                if ($value[1] == 'add') {
                    $pairs = "$pairs `$key`=`$key`+'$value[0]'";
                }
            }
        }

        return $pairs;
    }

    public function update($array) {
        $pairs = $this->construct_update_pairs($array);

        $sql = "UPDATE `$this->tableName` SET $pairs WHERE $this->condition;";
        return $this->db->update($sql);
    }

    public function select() {
        $sql = "SELECT * FROM `$this->tableName` WHERE $this->condition;";
        return $this->db->select($sql);
    }

    public function count() {
        $sql = "SELECT COUNT(1) FROM `$this->tableName` WHERE $this->condition;";
        return $this->db->count($sql);
    }

    public function atomic_update($array) {
        $pairs = $this->construct_update_pairs($array);

        // 开启事务
        $this->db->begin();

        // 加锁
        $sql = "SELECT * FROM `$this->tableName` WHERE $this->condition FOR UPDATE;";
        $result = $this->db->select($sql);
        if (count($result) < 1) {
            $this->db->rollback();
            return false;
        }

        // 更新
        $sql = "UPDATE `$this->tableName` SET $pairs WHERE $this->condition;";
        $result = $this->db->update($sql);

        // 结束事务
        if ($result) {
            $this->db->commit();
        } else {
            $this->db->rollback();
        }

        return $result;
    }
}