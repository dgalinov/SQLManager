<?php
include_once 'conn_without_db.php';
class SENTENCES {
    public static function sqlSentence($sentencia, $database) {
        $db = DB2::getInstance();
        $conn = $db->getConnection();
        $sentenciaLetra = substr($sentencia, 0 , 1);
        if ($sentenciaLetra === "i" || $sentenciaLetra === "u" || $sentenciaLetra === "d" || $sentenciaLetra === "I" || $sentenciaLetra === "U" || $sentenciaLetra === "D") {
            $db->getConnection()->select_db($database);
            $sql = "CREATE TABLE SqlHistory (
                id INT(255) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                sentence VARCHAR(255) NOT NULL,
                executed_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
                favourite TINYINT(255) DEFAULT 0
                )";
            $db->getConnection()->query($sql);
            $insert = "INSERT INTO sqlhistory(sentence) VALUES ('$sentencia')";
            var_dump($insert);
            $db->getConnection()->query($insert);
            $db->getConnection()->query($sentencia);
            echo "SQL Sentence [" . $sentencia . "] successfully injected";
        } else if ($sentenciaLetra === "s" || $sentenciaLetra === "S") {
            $db->getConnection()->select_db($database);
            $sql = "CREATE TABLE SqlHistory (
                id INT(255) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                sentence VARCHAR(255) NOT NULL,
                executed_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
                favourite TINYINT(255) DEFAULT 0
                )";
            $db->getConnection()->query($sql);
            $insert = "INSERT INTO sqlhistory(sentence) VALUES ('$sentencia')";
            var_dump($insert);
            $db->getConnection()->query($insert);
            $db->getConnection()->query($sentencia);
            $result = $db->getConnection()->query($sentencia);
            if ($result->num_rows > 0) {
                echo "<table class='table'>
                <tbody>";
                while($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    foreach($row as $key=>$value) {
                        echo "<td>$value</td>";
                    }
                    echo "</tr>";
                }
                echo "</tbody>
                </table>";
            } else {
                echo $db->error;
            }
        } else {
            echo "ERROR with the SQL Sentence [" . $sentencia . "]";
        }
    }
}
