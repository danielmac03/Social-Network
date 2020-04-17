<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/configs/isset_sessions.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/configs/connection.php';

if (isset($_POST)) {

    $password_old = isset($_POST['password_old']) ?  mysqli_real_escape_string($db, $_POST['password_old']) : false;
    $password_new = isset($_POST['password_new']) ?  mysqli_real_escape_string($db, $_POST['password_new']) : false;
    $verify = password_verify($password_old, $_SESSION['user_identify']['password']);

    $errors = array();
    
    if (empty($password_old) || $verify == false) {
        $errors['password_old'] = "The last password is wrong";
    }

    if (empty($password_new)) {
        $errors['password_new'] = "The new password is empty";
    }

    if (strlen($password_new) <= 8) {
        $errors['password'] = "The password must have a minimum of 8 characters";
 	}

    $save_users = false;

    if (count($errors) == 0) {
        $save_users = true;

        $password_secure = password_hash($password_new, PASSWORD_BCRYPT, ['cost'=>15]);

        $sql = "UPDATE users SET password = '$password_secure' WHERE id =" . $_SESSION['user_identify']['id'];
        $query_save = mysqli_query($db,$sql);

        if ($query_save){
            $_SESSION['user_identify']['password'] = $password_secure;
            $_SESSION['completed'] = "Your password has been updated successfully";
        } else {
            $_SESSION['errors_data'] = "Your password could not be saved successfully";
        }

    } else {
        $_SESSION['errors_data'] = $errors;
    }

    header('Location: ../../index.php?change_password');

}

?>