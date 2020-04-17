<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/configs/isset_sessions.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/configs/connection.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/configs/functions.php';

if (isset($_GET['id'])){

    $comment = mysqli_real_escape_string($db, $_GET['id']);
    $now_comment = getComment($db, $comment);
    $now_comment = mysqli_fetch_assoc($now_comment);
    $entry = $now_comment['entry_id'];

    if($now_comment['user_id'] == $_SESSION['user_identify']['id']) {
        $sql = "DELETE FROM comments WHERE id = $comment";
        mysqli_query($db, $sql);

        $_SESSION['completed'] = "Your comment has been deleted";
    } else {
        $_SESSION['errors']['general'] = "To be able to delete a comment it must be yours";
    }
}

header("Location: ../../index.php?comment=$entry");

?>