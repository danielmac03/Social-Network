<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/configs/isset_sessions.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/configs/connection.php';

$user = $_SESSION['user_identify']['id'];
$id = mysqli_real_escape_string($db, $_GET['id']);
$report = mysqli_real_escape_string($db, $_GET['report']);

//Check if you have already voted
$sql = "SELECT * FROM reports WHERE user = $user AND report = $id AND type_report = '$report'";
$check = mysqli_query($db, $sql);
$check = mysqli_num_rows($check);

if($check == 0) {

    if (isset($_GET['id'])) {

        //Add vote a table in votes
        $sql = "INSERT INTO reports VALUE (null, $id, $user, '$report', NOW())";
        $add_vote = mysqli_query($db, $sql);

        //Count Votes
        $sql = "SELECT * FROM reports WHERE report = $id AND type_report = '$report'";
        $count_reports = mysqli_query($db, $sql);
        $count_reports = mysqli_num_rows($count_reports);

        //Update votes
        $sql = "UPDATE $report SET reports = $count_reports WHERE id = $id";
        mysqli_query($db, $sql);

        $_SESSION['completed'] = "It has already been reported";

    }

} else {
    $_SESSION['errors']['general'] = "You can not report more than once";
}

header("Location: ../../index.php");

?>