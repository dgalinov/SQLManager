<?php
include_once 'conn_db_history.php';
class HISTORY {
    public static function updateFavourite() {
        $databasePOST = isset($_SESSION['db']) ? $_SESSION['db'] : '';
        var_dump($databasePOST);
        //$fav = $_SESSION['fav'];
        $db = DBH::getInstance();
        $conn = $db->getConnection();
        $db->getConnection()->select_db($databasePOST);
        for ($i=0;$i<count($fav);$i++) {
            $favInt = (int) $fav[$i];
            echo $favInt;
            //$sql = "UPDATE sqlhistory SET favourite = 1 WHERE id = $favInt";
            //$db->getConnection()->query($sql);
        }
    }
}