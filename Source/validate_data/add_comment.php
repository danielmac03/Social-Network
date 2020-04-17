<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/configs/isset_sessions.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/configs/connection.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/configs/functions.php';

if (isset($_POST)) {

    $comment = isset($_POST['comment']) ?  mysqli_real_escape_string($db, $_POST['comment']) : false;
    $user = $_SESSION['user_identify']['id'];
    $entry = mysqli_real_escape_string($db, $_GET['id']);

    $errors = array();

    if (empty($comment)) {
        $errors['comment'] = "The comment is empty";
    }


    if (count($errors) == 0) {

        $sql = "INSERT INTO comments VALUE (null, $user, $entry, '$comment',  NOW(), null, 0, 0);";
        $query_save = mysqli_query($db, $sql);

        if ($query_save){
            $_SESSION['completed'] = "The comment is publish";
        }

    } else {
        $_SESSION['errors_comment'] = $errors;
    }

    header("Location: ../../index.php?comment=$entry");

}

?>