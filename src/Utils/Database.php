<?php

/**
 * Created by PhpStorm.
 * User: tobin
 * Date: 15/9/27
 * Time: 上午10:25
 */

namespace Tangerine\Utils;

use Analog\Analog;
use Tangerine\Conf\Commons;

class Database
{
    private static $instance = null;
    private $config          = null;
    private $conn            = null;

    private function connect() {
        if (is_null($this->config)) {
            Analog::error("database config is null");
            return 1;
        }

        // parse config
        $host = $this->config["DB_HOST"];
        $port = $this->config["DB_PORT"];
        $user = $this->config["DB_USER"];
        $pass = $this->config["DB_PASS"];
        $db   = $this->config["DB_NAME"];

        // connect
        $conn = mysql_connect($host.":".$port, $user, $pass);
        if (!$conn) {
            Analog::error(mysql_error());
            return 1;
        }

        // select database
        $db = mysql_select_db($db, $conn);
        if (!$db) {
            Analog::error(mysql_error());
            return 1;
        }

        // set encoding
        $enc = mysql_query('SET NAMES UTF8', $conn);
        if (!$enc) {
            Analog::error(mysql_error());
            return 1;
        }

        $this->conn = $conn;
        return 0;
    }

    private function __construct($config) {
        $this->config = $config;
        $this->connect();
    }

    private function __clone(){
        Analog::error("clone is not allow");
    }

    public static function getInstance() {
        if(!(self::$instance instanceof self)){
            $config = Commons::getConfig();

            self::$instance = new self($config);
        }
        return self::$instance;
    }

    public function __destruct() {
        if (is_resource($this->conn)) {
            mysql_close($this->conn);
            $this->conn = null;
        }
    }

    public function getTableFields($tableName) {
        $sql = "desc `" . $tableName . "`;";
        $res = mysql_query($sql, $this->conn);

        // check query state
        if (!$res) {
            return 1;
        }

        $fields = array();
        while ($array = mysql_fetch_array($res)) {
            array_push($fields, $array['Field']);
        }

        return $fields;
    }

    public function getError() {
        return mysql_error();
    }

    public function getInsertId() {
        $rows = mysql_query("SELECT LAST_INSERT_ID();", $this->conn);
        $row = mysql_fetch_array($rows);
        return $row[0];
    }

    public function insert($sql) {
        $result = mysql_query($sql, $this->conn);

        if ($result) return true;
        else return false;
    }

    public function delete($sql) {
        $result = mysql_query($sql, $this->conn);

        if ($result) return true;
        else return false;
    }

    public function update($sql) {
        $result = mysql_query($sql, $this->conn);

        if ($result) return true;
        else return false;
    }

    public function select($sql) {
        // execute sql
        $result = mysql_query($sql, $this->conn);

        $rows = array();
        if ($result) {
            while ($row = mysql_fetch_array($result)) {
                $info = array();
                foreach ($row as $key => $value) {
                    if (is_integer($key)) continue;

                    $info[$key] = $value;
                }
                array_push($rows, $info);
            }
        }

        return $rows;
    }

    public function count($sql) {
        $result = mysql_query($sql, $this->conn);
        $row = mysql_fetch_array($result);
        return $row[0];
    }

    public function query($sql) {
        return mysql_query($sql, $this->conn);
    }

    public function begin() {
        return mysql_query("begin;", $this->conn);
    }

    public function commit() {
        return mysql_query("commit;", $this->conn);
    }

    public function rollback() {
        return mysql_query("rollback;", $this->conn);
    }
}