<?php
include_once 'conn_db_history.php';
class HISTORY {
    public static function updateFavourite() {
        $databasePOST = $_SESSION['database'];
        var_dump($databasePOST);
        $fav = $_SESSION['fav'];
        $db = DBH::getInstance();
        $conn = $db->getConnection();
        $db->getConnection()->select_db($databasePOST);
        /*for ($i=0;$i<count($fav);$i++) {
            $favInt = (int) $fav[$i];
            $sql = "UPDATE sqlhistory SET favourite = 1 WHERE id = $favInt";
            $db->getConnection()->query($sql);
        }*/
    }
}

/*
En index.php al realizar dos actions "POST" se reinician los datos del "droplist" al default y para ello tendre que
recoger el último valor cogido del "droplista" para ponerlo en "selected"
*/