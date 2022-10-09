<?php
// get user data
if ($_GET['user'] && is_numeric($_GET['user'])) {
    $user_id = $_GET['user'];

    $hostName = "localhost";
    $dbUserName = "root";
    $dbPass = "";
    $dbName = "php_lab4";
    $conn = mysqli_connect($hostName, $dbUserName, $dbPass, $dbName);
    $sql = "DELETE FROM users WHERE id = $user_id ";
    $result = mysqli_query($conn, $sql);
    if ($result) {
        mysqli_close($conn);
        header("Location:index.php");
    }
} else {
    echo "moshkla";
    die;
}