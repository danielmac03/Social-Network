<?php
$server = 'localhost';
$username = 'phpmyadmin';
$password = 'root';
$database = 'socialnetwork';
$db = mysqli_connect($server, $username, $password, $database);

mysqli_query($db, "SET NAMES 'utf8");

if(session_status() == 1){
    session_start();
}

if (!$db) {
    echo "Error: Sorry for the inconvenience an error has occurred, come back later";
}

if (!isset($_SESSION['user_identify'])) {
    $_SESSION['user_identify']['id'] = false;
    $_SESSION['user_identify']['user'] = false;
    $_SESSION['user_identify']['private_account'] = false;
    $_SESSION['user_identify']['staff'] = false;
}

//Refresh Session
if ($_SESSION['user_identify']['id'] != false) {
    $sql = "SELECT * FROM users WHERE id =".$_SESSION['user_identify']['id'];
    $refresh = mysqli_query($db, $sql);
    $_SESSION['user_identify'] = mysqli_fetch_assoc($refresh);
}

?>