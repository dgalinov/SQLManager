<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <link rel="stylesheet" href="./style.css">
    <title>M07-UF3-PR01</title>
</head>
<body>
    <div class="container-sm">
        <div class="row">
            <div class="col">
                <h1>SQL Manager</h1>
                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="POST">
                    <?php
                    include_once 'conn_db.php';
                    $username = $password = "";
                    $db = DB::getInstance();
                    $conn = $db->getConnection();
                    ?>
                    <select name="database" id="database" class="form-control">
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
                    <textarea name="sentencia" id="sentencia" cols="30" rows="10" class="form-control"></textarea>
                    <input type="submit" name="submit" id="submit" value="ENTER" class="btn btn-success">
                </form>
                <div>
                    <?php
                    if ($_SERVER["REQUEST_METHOD"] == "POST") {
                        include_once 'sentence.php';
                        $sentenciaPOST = isset($_POST['sentencia']) ? $_POST['sentencia'] : '';
                        $databasePOST = isset($_POST['database']) ? $_POST['database'] : '';
                        SENTENCES::sqlSentence($sentenciaPOST, $databasePOST);
                    }
                    ?>
                </div>
            </div>
            <div class="col">
                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="POST">
                    <input type="submit" name="update" id="update" value="UPDATE" class="btn btn-success">
                    <table class="table table-dark">
                        <thead>
                            <tr>
                            <th scope="col">#</th>
                            <th scope="col">SENTENCE</th>
                            <th scope="col">EXECUTED_AT</th>
                            <th scope="col">FAVOURITE</th>
                            <th scope="col">ADD FAV</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                                include_once 'conn_db_history.php';
                                $databasePOST = isset($_POST['database']) ? $_POST['database'] : '';
                                $database = DBH::getInstance();
                                $con = $database->getConnection();
                                $sql2 = "SELECT * FROM sqlhistory";
                                $database->getConnection()->select_db($databasePOST);
                                $result = $database->getConnection()->query($sql2);
                                if ($result->num_rows > 0) {
                                    while($row = $result->fetch_assoc()) {
                                        echo "<tr>
                                        <th scope='row'>".$row['id']."</th>
                                        <td>".$row['sentence']."</td>
                                        <td>".$row['executed_at']."</td>
                                        <td>".$row['favourite']."</td>
                                        <td><input type='checkbox'></td>
                                        </tr>";
                                    }
                                }
                            }
                            ?>
                        </tbody>
                    </table>
                </form>
            </div>
        </div>
    </div>
    
</body>
</html>