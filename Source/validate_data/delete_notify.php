<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/configs/isset_sessions.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/configs/connection.php';

$request = mysqli_real_escape_string($db, $_GET['request']);

if (isset($request)) {

    $sql = "DELETE FROM friends WHERE id = $request";
    $query_save = mysqli_query($db, $sql);

} else {
    $_SESSION['errors']['general'] = "There was an error sending the data";
}

header("Location: ../../index.php");

?>