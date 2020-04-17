<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/configs/isset_sessions.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/configs/connection.php';

if (isset($_POST)) {

    $user = $_SESSION['user_identify']['id'];
    $max_users = isset($_POST['max_users']) ?  $_POST['max_users'] : false;
    $description = isset($_POST['description']) ?  mysqli_real_escape_string($db, $_POST['description']) : false;
    $voice_channel = isset($_POST['voice_channel']) ?  mysqli_real_escape_string($db, $_POST['voice_channel']) : false;
    $max_users = (int)$_POST['max_users'];
    $id = isset($_GET['id']) ? $_GET['id'] : false;

    $errors = array();

    if ($max_users == 0 || !is_int($max_users) || $max_users > 5) {
        $errors['max_users'] = "Put number of players";
    }

    if (empty($description)) {
        $errors['description'] = "Put a description";
    }

    if (strlen($description) >= 200) {
        $errors['description'] = "Maximum 200 characters";
    }

    if (empty($voice_channel)) {
        $errors['voice_channel'] = "Put a url on the voice channel";
    }

    if (count($errors) == 0) {
        if (!isset($_GET['edit'])){
            $sql = "INSERT INTO events VALUE (null, $user, '$description', '$voice_channel', $max_users, null, NOW(), null, 0, 0)";
        } else {
            $sql = "UPDATE events SET description = '$description', voice_channel = '$voice_channel', edit_datetime = NOW() WHERE id = $id";
        }

        $query_save = mysqli_query($db, $sql);

        if (!$query_save){
            $errors = $_SESSION['errors']['general'] = "There was an errors in the publication";
        }

    } else {

        if(!isset($_GET['edit'])){
            $_SESSION['errors_create_entries'] = $errors;
        } else {
            $_SESSION['errors_edit_entries'] = $errors;
        }
    }

}

if(!isset($_GET['edit'])){
    header('Location: ../pages/events.php');
} else {
    header('Location: ../pages/events.php?id=' . $id);
}

?>