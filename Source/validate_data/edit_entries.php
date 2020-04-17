<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/configs/isset_sessions.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/configs/connection.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/configs/functions.php';

if(isset($_POST)){

    $errors = array();

    $id = mysqli_real_escape_string($db, $_GET['id']);
    $user_id = $_SESSION['user_identify']['id'];
    $now_entry = getEntry($db, $_GET['id']);
    $now_entry = mysqli_fetch_assoc($now_entry);

    if($now_entry['user_id'] == $user_id){

        $entry = $_POST['entry'];

        $only_followers = isset($_POST['only_followers']) ? $_POST['only_followers'] : 0;

        if(!empty($_FILES['file_entry']['name'])){

            $type_file_entry = $_FILES['file_entry']['type'];
            $size_file_entry = $_FILES['file_entry']['size'];            
            $ext = pathinfo($_FILES['file_entry']['name'], PATHINFO_EXTENSION);

            $name_file_entry = $id . "." . $ext;

            if ($type_file_entry == "image/jpeg" || $type_file_entry == "image/jpg" || $type_file_entry == "image/png" || $type_file_entry == "image/gif" || $type_file_entry == "video/mp4") {

                if ($size_file_entry <= 50000000) {

                    $folder_destination = $_SERVER['DOCUMENT_ROOT'] . '/database/entries/';

                    move_uploaded_file($_FILES['file_entry']['tmp_name'], $folder_destination . $name_file_entry);

                } else {
                    $errors['file_entry'] = "The file is too large";
                }

            } else {
                $errors['file_entry'] = "The file is in an incorrect format";
            }

        } else {
            $name_file_entry = $now_entry['file_entry'];
        }

        if(isset($_GET['delete_file']) && empty($_FILES['file_entry']['name'])){
            unlink($_SERVER['DOCUMENT_ROOT'] . '/database/entries/' . $now_entry['file_entry']);
            $name_file_entry = null;
        }

        if(strlen($entry) >= 200){
            $errors['entries'] = "Maximum 200 characters";
        }

        if (empty($name_file_entry) && empty($entry)) {
            $errors['file_entry'] = "You must post something";
        }

        if(count($errors) == 0){

            $sql = "UPDATE entries SET entry = '$entry', edit_datetime = NOW(), file_entry = '$name_file_entry', only_followers = $only_followers WHERE id = $id AND user_id = $user_id";
            $query_save = mysqli_query($db, $sql);

            $_SESSION['completed'] = "It has been published correctly";

        } else {
            $_SESSION['errors_entry_edit'] = $errors;
        }

    } else {
        $_SESSION['errors']['general'] = "You must be the creator to modify an entry";
    }
    
}

header('Location: ../../index.php?entry='.$id);

?>