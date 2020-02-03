<?php
include_once 'conn_db_history.php';
class HISTORY {
    public static function updateFavourite($id) {
        $databasePOST = isset($_SESSION['db']) ? $_SESSION['db'] : '';
        $db = DBH::getInstance();
        $conn = $db->getConnection();
        $db->getConnection()->select_db($databasePOST);
        $sql = "SELECT id, favourite FROM sqlhistory";
        $result = $db->getConnection()->query($sql);
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                foreach($id as $value) {
                    if ($value == $row['id']) {
                        if ($row['favourite'] == 1) {
                            $sqlUpdate = "UPDATE sqlhistory SET favourite = 0 WHERE id = $value";
                        } else {
                            $sqlUpdate = "UPDATE sqlhistory SET favourite = 1 WHERE id = $value";
                        }
                        $db->getConnection()->query($sqlUpdate);
                    }
                }
            }
        }
    }
}