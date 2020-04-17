<?php

if (isset($_POST)) {

    require_once $_SERVER['DOCUMENT_ROOT'] . '/configs/isset_sessions.php';
    require_once $_SERVER['DOCUMENT_ROOT'] . '/configs/connection.php';

    $errors = array();

    $user = isset($_POST['user']) ?  mysqli_real_escape_string($db, $_POST['user']) : $_SESSION['user_identify']['user'];
    $email = isset($_POST['email']) ?  mysqli_real_escape_string($db, trim($_POST['email'])) : $_SESSION['user_identify']['email'];
    $steam = isset($_POST['steam']) ?  mysqli_real_escape_string($db, trim($_POST['steam'])) : false;
    $twitter = isset($_POST['twitter']) ?  mysqli_real_escape_string($db, trim($_POST['twitter'])) : false;
    $youtube = isset($_POST['youtube']) ?  mysqli_real_escape_string($db, trim($_POST['youtube'])) : false;
    $private_account = isset($_POST['private_account']) ? isset($_POST['private_account']) : $_SESSION['user_identify']['private_account'];

    if ($private_account == null){
        $private_account = 0;
    }

    if (empty($user)) {
        $errors['user'] = "The user is invalid";
    }

    if (empty($email) && !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = "The email is invalid";
    }

    $sql = "SELECT * FROM users WHERE user = '$user'";
    $checkuser = mysqli_query($db, $sql);

    if (mysqli_num_rows($checkuser) && $user != $_SESSION['user_identify']['user']){
        $errors['user'] = "The user already exists";
    }

    $sql = "SELECT * FROM users WHERE email = '$email'";
    $checkemail = mysqli_query($db, $sql);

 	if (mysqli_num_rows($checkemail) && $email != $_SESSION['user_identify']['email']){
        $errors['email'] = "The email already exists";
    }

    if (count($errors) == 0) {

        $sql = "UPDATE users SET user = '$user', email = '$email', steam ='$steam', twitter = '$twitter', youtube = '$youtube', private_account = $private_account WHERE id = ".$_SESSION['user_identify']['id'];
        $query_save = mysqli_query($db,$sql);

        if ($query_save){
            $_SESSION['completed'] = "Your data has been updated successfully";
        }

    } else {
        $_SESSION['errors_data'] = $errors;
    }

    header('Location: ../../index.php');

}

?>