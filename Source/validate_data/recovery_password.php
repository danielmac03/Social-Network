<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/configs/connection.php';

$user = mysqli_real_escape_string($db, $_GET['user']);
$token = mysqli_real_escape_string($db, $_GET['token']);

if (!empty($user) && !empty($token)){

    $sql = "SELECT * FROM tokens WHERE token = '$token' AND user = $user";
    $token = mysqli_query($db, $sql);
    $token = mysqli_fetch_assoc($token);
    $token = $token['token'];

    if ($token != null){
        $sql = "UPDATE tokens SET status = 1 WHERE token = '$token' AND user = $user";
        mysqli_query($db, $sql);

        header("Location: ../../recovery_password/recovery_password.php?user=$user&token=$token");

    } else {
        $_SESSION['errors']['recovery_password'] = "The data was not sent correctly, please retry";
        header('Location: ../../index.php');
    }

} else {
    $_SESSION['errors']['recovery_password'] = "The data was not sent correctly, please retry";
    header('Location: ../../index.php');
}

?>