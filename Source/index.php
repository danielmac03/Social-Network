<?php

$title = "The social network";

require_once $_SERVER['DOCUMENT_ROOT'] . '/resources/php-requires/template.php';

?>

<h2>Entries</h2>
<hr>

<?php if ($_SESSION['user_identify']['id'] != false) : ?>

    <form action="validate_data/create_entries.php" method="POST" enctype="multipart/form-data">

        <div class="form-group">
            <input type="text" name="entry" class="form-control mt-1" placeholder="Write the entry" autocomplete="off">
            <span><?=isset($_SESSION['errors_entry']) ? showErrors($_SESSION['errors_entry'], 'entries') : ''; ?></span>
        </div>

        <ul class="form-group nav list-unstyled friends pt-1">
            <li class="form-group pt-1">
                <input type="file" name="file_entry" accept="image/*,video/mp4" class="custom-file-input">
                <span><?=isset($_SESSION['errors_entry']) ? showErrors($_SESSION['errors_entry'], 'file_entry') : ''; ?></span>
            </li>

            <li class="form-group mx-3 d-block pt-2">
                <input type="checkbox" value="1" name="only_followers">
                <span><i class="fas fa-user-friends"></i></span>
            </li>

            <li><input type="submit" value="Publish" class="btn btn-primary"></li>

        </ul>

    </form>

<?php endif; ?>

<?php
$entries = getEntries($db);
if ($entries) :
    while ($entry = mysqli_fetch_assoc($entries)) : ?>
            <?php
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