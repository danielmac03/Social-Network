<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/configs/connection.php';

if ($_POST){

    $email_user = mysqli_real_escape_string($db, trim($_POST['email_user']));
    $password = mysqli_real_escape_string($db, $_POST['password']);

    if (filter_var($email_user, FILTER_VALIDATE_EMAIL)) {
        $sql = "SELECT * FROM users WHERE email = '$email_user';";
    } else {
        $sql = "SELECT * FROM users WHERE user = '$email_user';";
    }

    $login = mysqli_query($db, $sql);

    if (mysqli_num_rows($login)){

        $user_database = mysqli_fetch_assoc($login);

        $verify = password_verify($password, $user_database['password']);

        if ($verify){
            
            $_SESSION['user_identify'] = $user_database;

            $sql = "UPDATE users SET last_connection_datetime = NOW() WHERE id =" . $_SESSION['user_identify']['id'];
            mysqli_query($db, $sql);
            
        } else {
            $_SESSION['errors']['general'] = "Incorrect Login";
        }

    } else {
        $_SESSION['errors']['general'] = "Incorrect Login";
    }

}

header("Location: ../../index.php");

?>