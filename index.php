<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>M07-UF3-PR01</title>
</head>
<body>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="POST">
        <?php
        include_once 'conn_db.php';
        $username = $password = "";
        $db = DB::getInstance();
        $conn = $db->getConnection();
        ?>
        <select name="database" id="database">
            <?php
            $sql = "SELECT DISTINCT(TABLE_SCHEMA) AS X FROM INFORMATION_SCHEMA.TABLES";
            $result = $db->getConnection()->query($sql);
            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    echo "<option value='".$row[X]."'>".$row[X]."</option>";
                }
            } else {
                echo $conn->error;
            }
            ?>
        </select>
        <textarea name="sentencia" id="sentencia" cols="30" rows="10"></textarea>
        <input type="submit" name="submit" id="submit" value="ENTER">
    </form>
    <textarea name="sqlResult" id="sqlResult" cols="30" rows="10" disabled>
            <?php
            include_once 'sentence.php';
            isset($_SESSION['display']) ? $_SESSION['display'] : array();
            $sentenciaPOST = isset($_POST['sentencia']) ? $_POST['sentencia'] : '';
            $databasePOST = isset($_POST['database']) ? $_POST['database'] : '';
            $sentencia = SENTENCES::getInstance();
            $sentencia->sqlSentence($sentenciaPOST, $databasePOST);
            ?>
    </textarea>
</body>
</html>