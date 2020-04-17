<?php

function showErrors ($errors, $field){
	$alert = '';
	if(isset($errors[$field]) && !empty($field)) {
		$alert = "<div class='errors'>".$errors[$field].'</div>';
	}

	return $alert; 
}



function deleteErrors (){
    $deleted = false;

    if (isset($_SESSION['errors_signin'])){
        $_SESSION['errors_signin'] = null;
        $deleted = true;
    }

    if (isset($_SESSION['errors_login'])){
        $_SESSION['errors_login'] = null;
        $deleted = true;
    }

    if (isset($_SESSION['errors_entry_edit'])){
        $_SESSION['errors_entry_edit'] = null;
        $deleted = true;
    }

    if (isset($_SESSION['errors_data'])){
        $_SESSION['errors_data'] = null;
        $deleted = true;
    }

    if (isset($_SESSION['errors_create_entries'])){
        $_SESSION['errors_create_entries'] = null;
        $deleted = true;
    }

    if (isset($_SESSION['errors_edit_entries'])){
        $_SESSION['errors_edit_entries'] = null;
        $deleted = true;
    }

    if (isset($_SESSION['errors_comment'])){
        $_SESSION['errors_comment'] = null;
        $deleted = true;
    }

    if (isset($_SESSION['errors'])){
        $_SESSION['errors'] = null;
        $deleted = true;
    }

    if (isset($_SESSION['completed'])){
        $_SESSION['completed']= null;
        $deleted = true;
    }

    return $deleted;
}

function getEntries($connection){
    $sql = "SELECT * FROM entries ORDER BY create_datetime DESC";
    $entries = mysqli_query($connection, $sql);

    $result =  array();
    if($entries && mysqli_num_rows($entries) >= 1){
        $result = $entries;
    }

    return $entries;
}

function getEntriesByDate($connection, $date){
    $sql = "SELECT * FROM entries WHERE create_datetime >= '$date'";
    $entries = mysqli_query($connection, $sql);

    $result =  array();
    if($entries && mysqli_num_rows($entries) >= 1){
        $result = $entries;
    }

    return $entries;
}

function getComments($connection, $id){
    $sql = "SELECT * FROM comments WHERE entry_id = $id ORDER BY create_datetime DESC ";
    $comments = mysqli_query($connection, $sql);

    $result =  array();
    if($comments && mysqli_num_rows($comments) >= 1){
        $result = $comments;
    }

    return $comments;
}

function getComment($connection, $comment_id){
    $sql = "SELECT * FROM comments WHERE id = $comment_id";
    $comments = mysqli_query($connection, $sql);

    $result =  array();
    if($comments && mysqli_num_rows($comments) >= 1){
        $result = $comments;
    }

    return $comments;
}

function getEntriesByIDUser($connection, $id){
    $sql = "SELECT * FROM entries WHERE user_id = $id ORDER BY create_datetime DESC";
    $entry = mysqli_query($connection, $sql);

    $result = array();
     if($entry && mysqli_num_rows($entry) >= 1){
         $result = $entry;
     }

    return $entry;
}

function getEntry($connection, $id){
    $sql = "SELECT * FROM entries WHERE id = $id";
    $entry = mysqli_query($connection, $sql);

    $result = array();
    if($entry && mysqli_num_rows($entry) >= 1){
        $result = $entry;
    }

    return $entry;
}

function checkUser($connection, $user){
    $sql = "SELECT * FROM users WHERE user = $user";
    $user = mysqli_query($connection, $sql);

    $result = array();
    if($user && mysqli_num_rows($user) >= 1){
        $result = $user;
    }

    return $user;
}


function getEvents($connection){
    $sql = "SELECT * FROM events ORDER BY create_datetime DESC";
    $events = mysqli_query($connection, $sql);

    $result =  array();
    if($events && mysqli_num_rows($events) >= 1){
        $result = $events;
    }

    return $events;
}

function getEvent($connection, $id){
    $sql = "SELECT * FROM events WHERE id = $id";
    $entry = mysqli_query($connection, $sql);

    $result = array();
    if($entry && mysqli_num_rows($entry) >= 1){
        $result = $entry;
    }

    return $entry;
}

function getUserFromId($connection, $id){
    $sql = "SELECT * FROM users WHERE id = $id";
    $user = mysqli_query($connection, $sql);

    $result =  array();
    if($user && mysqli_num_rows($user) >= 1){
        $result = $user;
    }

    return $user;
}

function getUserFromUser($connection, $user){
    $sql = "SELECT * FROM users WHERE user = '$user'";
    $user = mysqli_query($connection, $sql);

    $result =  array();
    if($user && mysqli_num_rows($user) >= 1){
        $result = $user;
    }

    return $user;
}

function searchEntries($connection, $search){
    $sql = "SELECT * FROM entries WHERE entry LIKE '%$search%' ORDER BY create_datetime DESC";
    $entries = mysqli_query($connection, $sql);

    $result =  array();
    if($entries && mysqli_num_rows($entries) >= 1){
        $result = $entries;
    }

    return $entries;

}

function searchEvents($connection, $search){
    $sql = "SELECT * FROM events WHERE description LIKE '%$search%' OR voice_channel LIKE '%$search%' ORDER BY create_datetime DESC";
    $entries = mysqli_query($connection, $sql);

    $result =  array();
    if($entries && mysqli_num_rows($entries) >= 1){
        $result = $entries;
    }

    return $entries;

}

function searchUsers($connection, $search){
    $sql = "SELECT * FROM users WHERE user LIKE '%$search%'";
    $entries = mysqli_query($connection, $sql);

    $result =  array();
    if($entries && mysqli_num_rows($entries) >= 1){
        $result = $entries;
    }

    return $entries;

}

function getLastIDEntries($connection, $table){
    $sql = "SELECT id FROM $table ORDER BY id DESC LIMIT 1";
    $result = mysqli_query($connection, $sql);

    while($row = mysqli_fetch_array($result)){
        $id = $row['id'];
    }

    return $id;
}

function checkReceiveRequest($connection, $user){
    $sql = "SELECT * FROM friends WHERE user_receive = $user";
    $request = mysqli_query($connection, $sql);

    $result =  array();
    if($request && mysqli_num_rows($request) >= 1){
        $result = $request;
    }

    return $request;

}

function checkSendRequest($connection, $user_send, $user_receive){
    $sql = "SELECT * FROM friends WHERE user_send = $user_send AND user_receive = $user_receive";
    $request = mysqli_query($connection, $sql);

    $result =  array();
    if($request && mysqli_num_rows($request) >= 1){
        $result = $request;
    }

    return $request;

}

function checkFriends($connection, $user1, $user2){
    $sql = "SELECT * FROM friends WHERE user_send = $user1 AND accept = 2 AND user_receive = $user2";
    $request = mysqli_query($connection, $sql);

    $result =  array();
    if($request && mysqli_num_rows($request) >= 1){
        $result = $request;
    }

    return $request;

}

function checkRecovery($connection, $user, $token){
    $sql = "SELECT * FROM tokens WHERE user = $user AND token = '$token'";
    $request = mysqli_query($connection, $sql);

    $result =  array();
    if($request && mysqli_num_rows($request) >= 1){
        $result = $request;
    }

    return $request;

}

function getTrends($connection){
    $sql = "SELECT * FROM trends ORDER BY create_datetime LIMIT 1";
    $request = mysqli_query($connection, $sql);

    $result =  array();
    if($request && mysqli_num_rows($request) >= 1){
        $result = $request;
    }

    return $request;

}

?>