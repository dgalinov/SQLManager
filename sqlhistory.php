<?php
include_once 'conn_db_history.php';
class HISTORY {
    public static function updateFavourite() {
        $databasePOST = $_SESSION['database'];
        $fav = $_SESSION['fav'];
        var_dump($fav);
        $db = DBH::getInstance();
        $conn = $db->getConnection();
        $sql = "SELECT * FROM sqlhistory";
        $db->getConnection()->select_db($databasePOST);
        $result = $db->getConnection()->query($sql);
        if ($result->num_rows > 0) {
            echo "Entra 1";
            while($row = $result->fetch_assoc()) {
                for ($i=0;$i<count($fav);$i++) {
                    if ($row['id'] == (int) $fav[$i]) {
                        echo $fav[$i];
                    } else {
                        echo "NO ENTRA WEEEEEE";
                    }
                }
            }
        } else {
            echo "No entra en el result".$conn->error;
        }
    }
}