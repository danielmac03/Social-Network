<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/configs/isset_sessions.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/configs/connection.php';

if (isset($_GET['id']) && isset($_GET['delete'])){
    $user = $_SESSION['user_identify']['id'];
    $delete = mysqli_real_escape_string($db, $_GET['delete']);
    $id = mysqli_real_escape_string($db, $_GET['id']);

    if ($_SESSION['user_identify']['staff'] == 1) {
        $sql = "UPDATE $delete SET hide = 1 WHERE id = $id";
        mysqli_query($db, $sql);
    } else {
        $_SESSION['errors']['general'] = "There was an error sending the data";
    }

    $sql = "INSERT INTO hide VALUE (null, $user, $id, $delete, NOW())";

    mysqli_query($db, $sql);

    $_SESSION['completed'] = "It has been removed correctly";
}

header("Location: ../../index.php");

?>