<?php

if (isset($_POST)) {

    require_once $_SERVER['DOCUMENT_ROOT'] . '/configs/isset_sessions.php';
    require_once $_SERVER['DOCUMENT_ROOT'] . '/configs/connection.php';

    $errors = array();

    if(!empty($_FILES['profile_picture']['name'])){
        $type_profile_picture = $_FILES['profile_picture']['type'];
        $size_profile_picture = $_FILES['profile_picture']['size'];
        $ext = pathinfo($_FILES['profile_picture']['name'], PATHINFO_EXTENSION);

        $name_profile_picture = $_SESSION['user_identify']['id'] . "." . $ext;

        if ($type_profile_picture == "image/jpeg" || $type_profile_picture == "image/jpg" || $type_profile_picture == "image/png" || $type_profile_picture == "image/gif") {

            if ($size_profile_picture <= 10000000) {

                $folder_destination = $_SERVER['DOCUMENT_ROOT'] . '/database/social/';

                move_uploaded_file($_FILES['profile_picture']['tmp_name'], $folder_destination . $name_profile_picture);

            } else {
                $_SESSION['errors']['general'] = "The profile picture is too large";
                header('Location: ../../user_data/my_data.php');
            }

        } else {
            $_SESSION['errors']['general'] = "The profile picture is in an incorrect format";
            header('Location: ../../user_data/my_data.php');
        }

    } else {
        $name_profile_picture = null;
    }


    if (count($errors) == 0) {

            if($name_profile_picture != null){
                $sql = "UPDATE users SET profile_picture = '$name_profile_picture' WHERE id = ".$_SESSION['user_identify']['id'];
            } else {
                $sql = "UPDATE users SET profile_picture = DEFAULT WHERE id = ".$_SESSION['user_identify']['id'];
            }
            $query_save = mysqli_query($db,$sql);

            $_SESSION['completed'] = "Your data has been updated successfully";

    } else {
        $_SESSION['general'] = $errors;
    }

    header('Location: ../pages/user.php');

}

?>