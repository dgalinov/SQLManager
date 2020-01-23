<?php
include_once 'conn_without_db.php';
class SENTENCES {
    private static $_instance;
    private function __construct() {}
    public static function getInstance() {
        if (!self::$_instance) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }
    public function sqlSentence($sentencia, $database) {
        $db = DB2::getInstance();
        $conn = $db->getConnection();
        $sentenciaLetra = substr($sentencia, 0 , 1);
        if ($sentenciaLetra === "i" || $sentenciaLetra === "u" || $sentenciaLetra === "d" || $sentenciaLetra === "I" || $sentenciaLetra === "U" || $sentenciaLetra === "D") {
            $db->getConnection()->select_db($database);
            $db->getConnection()->query($sentencia);
            echo "SQL Sentence [" . $sentencia . "] successfully injected";
        } else if ($sentenciaLetra === "s" || $sentenciaLetra === "S") {
            $db->getConnection()->select_db($database);
            $db->getConnection()->query($sentencia);
            $result = $db->query($sentencia);
            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    foreach($row as $key=>$value) {
                        echo $key;
                    }
                }
            } else {
                echo $db->error;
            }
        } else {
            echo "ERROR with the SQL Sentence [" . $sentencia . "]";
        }
    }
}
