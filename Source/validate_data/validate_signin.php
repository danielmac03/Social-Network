<?php

 if (isset($_POST)) {

    require_once $_SERVER['DOCUMENT_ROOT'] . '/configs/connection.php';
    require_once $_SERVER['DOCUMENT_ROOT'] . '/configs/functions.php';

    $user = isset($_POST['user']) ?  mysqli_real_escape_string($db, $_POST['user']) : false;
    $email = isset($_POST['email']) ?  mysqli_real_escape_string($db, trim($_POST['email'])) : false;
    $password = isset($_POST['password']) ?  mysqli_real_escape_string($db, $_POST['password']) : false;
    $password_verify = isset($_POST['password_verify']) ?  mysqli_real_escape_string($db, $_POST['password_verify']) : false;
    
    if (empty($private_account)){
        $private_account = 0;
    }

    $errors = array();

 	if (empty($user)) {
        $errors['user'] = "The user is invalid";
 	}

 	if (empty($email) && !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = "The email is invalid";
 	}

 	if (strlen($password) <= 8) {
        $errors['password'] = "The password must have a minimum of 8 characters";
 	}

 	if (empty($password_verify) && $password != $password_verify) {
        $errors['password_verify'] = "The passwords do not match";
 	}

 	$sql = "SELECT * FROM users WHERE user = '$user'";
    $checkuser = mysqli_query($db, $sql);

    if (mysqli_num_rows($checkuser)){
        $errors['user'] = "The user already exists";
    }

    $sql = "SELECT * FROM users WHERE email = '$email'";
    $checkemail = mysqli_query($db, $sql);

 	if (mysqli_num_rows($checkemail)){
 	    $errors['email'] = "The email already exists";
    }
    
    if (count($errors) == 0) {

        $password_secure = password_hash($password, PASSWORD_BCRYPT, ['cost' => 15]);

        $sql = "INSERT INTO users VALUE (null, '$user', '$email', '$password_secure', null, null, null, DEFAULT, NOW(), null, $private_account, 0, 0);";
        $query_save = mysqli_query($db, $sql);

        $user_id = getLastIDEntries($db, "users");
        $user_id = $user_id++;

        //Automatic login after registration
        $sql = "SELECT * FROM users WHERE email = '$email'";
        $login = mysqli_query($db, $sql);

        $user_database = mysqli_fetch_assoc($login);
        $_SESSION['user_identify'] = $user_database;

        header("Location: ../validate_data/send_email?action=verificate&user_id=$user_id");

    } else {
        $_SESSION['errors_signin'] = $errors;
        header("Location: ../../index.php");
    }

} else {
    $_SESSION['errors_signin'] = "There was an error sending the data";
    header("Location: ../../index.php");
}

?>