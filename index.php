<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
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
    <div>
        <?php var_dump($_SERVER["REQUEST_METHOD"]);
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            include_once 'sentence.php';
            $sentenciaPOST = isset($_POST['sentencia']) ? $_POST['sentencia'] : '';
            $databasePOST = isset($_POST['database']) ? $_POST['database'] : '';
            SENTENCES::sqlSentence($sentenciaPOST, $databasePOST);
        }
        ?>
    </div>
</body>
</html>