<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/configs/connection.php';

$user = mysqli_real_escape_string($db, $_GET['user']);
$token = mysqli_real_escape_string($db, $_GET['token']);

if (isset($user) && isset($token)) {

    $sql = "SELECT * FROM tokens WHERE token = '$token' AND user = $user";
    $token = mysqli_query($db, $sql);
    $token = mysqli_fetch_assoc($token);
    $token = $token['token'];

    if ($token != null){

        $sql = "UPDATE users SET verificate = 1 WHERE id = $user";
        $query_save = mysqli_query($db, $sql);
        
        
        //Delete Table
        $sql = "DELETE FROM tokens WHERE token = '$token' AND user = $user";
        mysqli_query($db, $sql);

    } else {
        $_SESSION['errors']['general'] = "There was an error sending the data";
    }

} else {
    $_SESSION['errors']['general'] = "There was an error sending the data";
}

$_SESSION['completed'] = "Your account has been verified";
header('Location: ../../index.php');

?>