<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/configs/isset_sessions.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/configs/connection.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/configs/functions.php';

$answer = mysqli_real_escape_string($db, $_GET['answer']);
$request = mysqli_real_escape_string($db, $_GET['request']);
$user = mysqli_real_escape_string($db, $_GET['user']);

$check_send_request = checkSendRequest($db, $_SESSION['user_identify']['id'], $user);
$check_receive_request = checkReceiveRequest($db, $_SESSION['user_identify']['id']);

if (mysqli_num_rows($check_send_request) || mysqli_num_rows($check_receive_request)){

    if (isset($answer) && isset($request)) {

        if($answer == 1){
            $sql = "DELETE FROM friends WHERE id = $request";
        }

        if($answer == 2){
            $sql = "UPDATE friends SET accept = $answer,  notify = 2 WHERE id = $request";
        }

        $query_save = mysqli_query($db, $sql);

    } else {
        $_SESSION['errors']['general'] = "There was an error sending the data";
    }

} else {
    $_SESSION['errors']['general'] = "There was an error sending the data";
}

header("Location: ../../index.php");

?>