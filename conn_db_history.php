<?php
class DBH {
    private $_servername = 'localhost';
    private $_username = 'root';
    private $_password = '';
    private $_connection;
    private static $_instance;
    private function __construct() {
        $this->_connection = new mysqli($this->_servername, $this->_username, $this->_password);
        if (mysqli_connect_error()) {
            trigger_error('Failed to connect to MySQL: '.mysqli_connect(), E_USER_ERROR);
        }
    }
    public static function getInstance() {
        if (!self::$_instance) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }
    private function __clone() {}
    public function getConnection() {
        return $this->_connection;
    }
}
