<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/configs/connection.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/configs/functions.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require $_SERVER['DOCUMENT_ROOT'] . '/libraries/PHPMailer/src/Exception.php';
require $_SERVER['DOCUMENT_ROOT'] . '/libraries/PHPMailer/src/PHPMailer.php';
require $_SERVER['DOCUMENT_ROOT'] . '/libraries/PHPMailer/src/SMTP.php';

if (!isset($_GET['user_id'])){
    $_SESSION['errors']['general'] = "There was an error sending the data";
    header("Location: ../../index.php");
}

$user_id = mysqli_real_escape_string($db, $_GET['user_id']);

$token = bin2hex(random_bytes(30));

$sql = "INSERT INTO tokens VALUE (null, $user_id, '$token', NOW());";
mysqli_query($db, $sql);

$user = getUserFromId($db, $user_id);
$user = mysqli_fetch_assoc($user);

// Load Composer's autoloader
require $_SERVER['DOCUMENT_ROOT'] . '/libraries/PHPMailer/vendor/autoload.php';

// Instantiation and passing `true` enables exceptions
$mail = new PHPMailer(true);

try {
    
    $mail->SMTPDebug = 0;
    $mail->isSMTP();
    $mail->Host       = 'null';
    $mail->SMTPAuth   = true;
    $mail->Username   = 'support@social-network.com';
    $mail->Password   = 'null';
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->Port       = 587;

    //Recipients
    $mail->setFrom('support@social-network.com', 'Social-Network');
    $mail->addAddress($user['email'], $user['user']);

    // Content
    $mail->isHTML(true);
    if($action == "verificate"){
        $mail->Subject = 'Verificate Account';
        $mail->Body    = 'Hello '.$user['user'].' <br/> Please, verificate your account do click -> <a href="www.social-network.com/validate_data/verificate_account.php?user='.$user_id.'&token='.$token.'">Verificate Account</a>';
        $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';
    }else{
        $mail->isHTML(true);
        $mail->Subject = 'Recovery Password';
        $mail->Body    = 'Hello '.$user['user'] .' <br/> Please to recovery your password do click -> <a href="www.social-network.com/index.php&user='.$user_id.'&token='.$token.'">Recovery Password</a>';
        $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';
    }

    $mail->send();

    $_SESSION['completed'] = "Please check your email, it may be spam";

} catch (Exception $e) {
    $_SESSION['errors']['general'] = "There was an error sending the email";
}

header('Location: ../../index.php');

?>