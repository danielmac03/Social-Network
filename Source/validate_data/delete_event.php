<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/configs/isset_sessions.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/configs/connection.php';

if (isset($_GET['id'])){
    $event = mysqli_real_escape_string($db, $_GET['id']);
    $user = $_SESSION['user_identify']['id'];

    $sql = "DELETE FROM events WHERE user_host = $user AND id = $event";
    mysqli_query($db, $sql);

    $_SESSION['completed'] = "Your comment has been deleted";
}

header("Location: ../pages/events.php");

?>