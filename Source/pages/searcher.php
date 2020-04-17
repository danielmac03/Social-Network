<?php

if(isset($_POST['search'])){
    $search = $_POST['search'];
}elseif(isset($_GET['search'])){
    $search = $_GET['search'];
}

$title = $search;

if (!isset($search) || empty($search)) {
    header('Location: ../../index.php');
}

require_once $_SERVER['DOCUMENT_ROOT'] . '/resources/php-requires/template.php';

$searchsUsers = searchUsers($db, $search);
$searchsEvents = searchEvents($db, $search);
$searchsEntries = searchEntries($db, $search);

?>

<h2>"<?=$title?>"</h2>
<hr>

<?php
    if (!empty($searchsUsers)):
        while ($searchUsers = mysqli_fetch_assoc(($searchsUsers))):
        ?>

        <img width="60" src="/database/social/<?=$searchUsers['profile_picture'];?>" alt="Profile Picture">

        <?php if ($searchUsers['user'] != $_SESSION['user_identify']['user']): ?>
            <a href="user.php?user=<?=$searchUsers['user']?>"><?=$searchUsers['user']?></a>
        <?php endif; ?>

        <?php if ($searchUsers['user'] == $_SESSION['user_identify']['user']): ?>
            <a href="../user_data/my_user.php"><?=$searchUsers['user']?></a>
        <?php endif; ?><hr>

        <?php
        endwhile;
    endif;
?>

<?php
        if (!empty($searchsEvents)) :
            while ($event = mysqli_fetch_assoc($searchsEvents)) :
            if ($event['hide'] == 0) :
                $user = getUserFromID($db, $event['user_host']);
                $user = mysqli_fetch_assoc($user);
                $users = explode(" ", $event['users']);
        ?>
        
        <?php require $_SERVER['DOCUMENT_ROOT'] . '/resources/php-requires/event.php'; ?>    

<?php 
            endif;
        endwhile;
    endif;
?>


<?php
if (!empty($searchsEntries)) :
    while ($entry = mysqli_fetch_assoc($searchsEntries)) :
        if($entry['hide'] == 0):
            $comments = getComments($db, $entry['id']);
            $user = getUserFromId($db, $entry['user_id']);
            $user = mysqli_fetch_assoc($user);
            $ext = pathinfo($entry['file_entry'], PATHINFO_EXTENSION);
            $requests = checkFriends($db, (int)$_SESSION['user_identify']['id'], $user['id']);
            if ((($entry['only_followers'] == 0 && $user['private_account'] == 0) || $user['id'] == $_SESSION['user_identify']['id']) || mysqli_num_rows($requests)) :
?>
                <?php require $_SERVER['DOCUMENT_ROOT'] . '/resources/php-requires/entry.php'; ?>        
<?php
            endif;
        endif;
    endwhile;
endif;
?>

<?php require_once $_SERVER['DOCUMENT_ROOT'] . '/resources/php-requires/sidebar.php'; ?>