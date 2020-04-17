<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/configs/isset_sessions.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/configs/connection.php';

$user = $_SESSION['user_identify']['id'];
$entry_id = mysqli_real_escape_string($db, $_GET['id']);

//Check if you have already voted
$sql = "SELECT * FROM votes WHERE user = $user AND clips = $entry_id";
$check = mysqli_query($db, $sql);
$check = mysqli_num_rows($check);

if($check == 0) {

    if (isset($_GET['id'])) {
        
        //Add vote a table in votes
        $sql = "INSERT INTO votes VALUE (null, $entry_id, $user, NOW())";
        $add_vote = mysqli_query($db, $sql);


        //Count Votes
        $sql = "SELECT * FROM votes WHERE clips = $entry_id";
        $count_votes = mysqli_query($db, $sql);
        $count_votes = mysqli_num_rows($count_votes);


        //Update votes
        $sql = "UPDATE entries SET likes = $count_votes WHERE id =" . $entry_id;
        mysqli_query($db, $sql);

    }

    $_SESSION['completed'] = "Has been voted correctly";

} else {
    $_SESSION['errors']['general'] = "You can not vote more than once";
}

header("Location: ../../index.php");

?>