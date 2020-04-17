<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/configs/isset_sessions.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/configs/connection.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/configs/functions.php';

if (isset($_GET['id'])){
    $user = $_SESSION['user_identify']['id'];
    $entry_id = mysqli_real_escape_string($db, $_GET['id']);

    $entry = getEntry($db, $_GET['id']);
    $entry = mysqli_fetch_assoc($entry);

    if($entry['user_id'] == $user) {

        $sql = "DELETE FROM votes WHERE clips = $entry_id";
        mysqli_query($db, $sql);

        $sql = "DELETE FROM entries WHERE user_id = $user AND id = $entry_id";
        mysqli_query($db, $sql);

    } else {
        $_SESSION['errors']['general'] = "To be able to delete a entry it must be yours";
    }
}

header("Location: ../../index.php");

?>