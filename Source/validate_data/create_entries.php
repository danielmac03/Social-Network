<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/configs/isset_sessions.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/configs/connection.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/configs/functions.php';

if(isset($_POST)){

    $errors = array();

    $last_id = getLastIDEntries($db, "entries");
    $last_id = $last_id + 1;

    $user_id = $_SESSION['user_identify']['id'];
    $only_followers = isset($_POST['only_followers']) ? $_POST['only_followers'] : 0;
    $entry = isset($_POST['entry']) ?  mysqli_real_escape_string($db, $_POST['entry']) : false;

    if(!empty($_FILES['file_entry']['name'])){
        $type_file_entry = $_FILES['file_entry']['type'];
        $size_file_entry = $_FILES['file_entry']['size'];
        $ext = pathinfo($_FILES['file_entry']['name'], PATHINFO_EXTENSION);

        $name_file_entry = $last_id . "." . $ext;

    } else {
        $name_file_entry = null;
    }

    if(strlen($entry) >= 200){
        $errors['entries'] = "Maximum 200 characters";
    }

    if ($name_file_entry != null){

        if ($type_file_entry == "image/jpeg" || $type_file_entry == "image/jpg" || $type_file_entry == "image/png" || $type_file_entry == "image/gif" || $type_file_entry == "video/mp4") {

            if ($size_file_entry <= 50000000) {

                $folder_destination = $_SERVER['DOCUMENT_ROOT'] . '/database/entries/';

                move_uploaded_file($_FILES['file_entry']['tmp_name'], $folder_destination . $name_file_entry);

            } else {
                $errors['file_entry'] = "The file is too large";
            }

        } else {
            $errors['file_entry'] = "The file is in an incorrect format";
            header('Location: ../../index.php');
        }
    }

        if ($name_file_entry == null && empty($entry)) {
            $errors = "You must post something";
            header('Location: ../../index.php');
        }

    if(count($errors) == 0){
        
        $sql = "INSERT INTO entries VALUES(null, '$user_id', '$entry', '$name_file_entry', 0, $only_followers, NOW(), null, 0, 0)";

        $query_save = mysqli_query($db, $sql);

        $_SESSION['completed'] = "It has been published correctly";

    } else {
        $_SESSION['errors_entry'] = $errors;
    }
    
}

header('Location: ../../index.php');

?>