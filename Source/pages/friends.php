<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/configs/isset_sessions.php';

$title = "Friends";

require_once $_SERVER['DOCUMENT_ROOT'] . '/resources/php-requires/template.php';

?>

<h2>Friends</h2>
<hr>

<?php
$entries = getEntries($db);
if (mysqli_num_rows($entries)) :
    while ($entry = mysqli_fetch_assoc($entries)) : ?>
        <?php
        if($entry['hide'] == 0):
            $comments = getComments($db, $entry['id']);
            $user = getUserFromId($db, $entry['user_id']);
            $user = mysqli_fetch_assoc($user);
            $ext = pathinfo($entry['file_entry'], PATHINFO_EXTENSION);
            $requests = checkFriends($db, (int)$_SESSION['user_identify']['id'], $user['id']);
            if ((($user['id'] == $_SESSION['user_identify']['id']) || mysqli_num_rows($requests))) :
                $isset_entries = true;
?>
            <?php require $_SERVER['DOCUMENT_ROOT'] . '/resources/php-requires/entry.php'; ?>    
<?php
            endif;
        endif;
    endwhile;
endif;
?>

<?php if (!isset($isset_entries) || empty($entries)) : ?>
    <p>Your followers have not published anything yet</p>
<?php endif; ?>

<?php require_once $_SERVER['DOCUMENT_ROOT'] . '/resources/php-requires/sidebar.php'; ?>