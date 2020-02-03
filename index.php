<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
if (isset($_SESSION['db'])) {
    $dbSESSION = $_SESSION['db'];
} else {
    $dbSESSION = '';
}
var_dump($dbSESSION);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <link rel="stylesheet" href="./style.css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <title>M07-UF3-PR01</title>
</head>
<body>
    <div class="container-sm">
        <div class="row">
            <div class="col">
                <h1>SQL Manager</h1>
                <!--Aqui se realiza el primer formulario para detectar una base de datos
                    donde se realizaran todas las injections con sql-->
                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="POST">
                    <?php
                    //Entramos en el archivo conn_db.php para realizar una conexion en un clase
                    include_once 'conn_db.php';
                    $db = DB::getInstance();
                    $conn = $db->getConnection();
                    $dbSelected = isset($_POST['database']) ? $_POST['database'] : '';
                    $sentence = isset($_POST['sentence']) ? $_POST['sentence'] : '';
                    ?>
                    <select name="database" id="database" class="form-control">
                        <?php
                        $sql = "SELECT DISTINCT(TABLE_SCHEMA) AS X FROM INFORMATION_SCHEMA.TABLES";
                        $result = $db->getConnection()->query($sql);
                        if ($result->num_rows > 0) {
                            while($row = $result->fetch_assoc()) {
                                echo "<option "; if($dbSelected == $row['X']) { echo "selected"; } echo ">".$row['X']."</option>";
                            }
                        } else {
                            echo $conn->error;
                        }
                        ?>
                    </select>
                    <textarea name="sentence" id="sentence" cols="30" rows="10" class="form-control"></textarea>
                    <input type="submit" name="submit" id="submit" value="ENTER" class="btn btn-success">
                </form>
                <div>
                    <?php
                    if ($_SERVER["REQUEST_METHOD"] == "POST") {
                        if (isset($_POST['submit'])) {
                            include_once 'sentence.php';
                            SENTENCES::sqlSentence($sentence, $dbSelected);
                            $_SESSION['db'] = $dbSelected;
                            var_dump($dbSelected);
                        }
                    }
                    ?>
                </div>
            </div>
            <div class="col">
                <form method="POST">
                    <input type="submit" name="update" id="update" value="UPDATE" class="btn btn-success">
                    <table class="table table-dark">
                        <thead>
                            <tr>
                            <th scope="col">#</th>
                            <th scope="col">SENTENCE</th>
                            <th scope="col">EXECUTED_AT</th>
                            <th scope="col">FAVOURITE</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $databasePOST = isset($_POST['database']) ? $_POST['database'] : '';
                            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                                if (isset($_POST['submit'])) {
                                    include_once 'conn_db_history.php';
                                    $database = DBH::getInstance();
                                    $con = $database->getConnection();
                                    $sql2 = "SELECT * FROM sqlhistory ORDER BY executed_at DESC";
                                    $database->getConnection()->select_db($databasePOST);
                                    $result = $database->getConnection()->query($sql2);
                                    if ($result->num_rows > 0) {
                                        while($row = $result->fetch_assoc()) {
                                            echo "<tr>
                                            <th scope='row'>".$row['id']."</th>
                                            <td>";
                                            if ($row['favourite'] == 1) {
                                                echo "<i class='material-icons'>star</i>".$row['sentence'];
                                            } else {
                                                echo "<i class='material-icons'>star_border</i>".$row['sentence'];
                                            }
                                            echo "</td>
                                            <td>".$row['executed_at']."</td>
                                            <td><input type='checkbox' name='favourites[]' value='".$row['id']."'></td>
                                            </tr>";
                                        }
                                    }
                                }
                                if (isset($_POST['update'])) {
                                    include_once 'sqlhistory.php';
                                    HISTORY::updateFavourite($_POST['favourites']);
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