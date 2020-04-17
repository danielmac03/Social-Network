<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/configs/functions.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/configs/connection.php';

if (isset($_GET['user'])) {
    $title = $_GET['user'];
    $user = getUserFromUser($db, $_GET['user']);
} else {
    $title = $_SESSION['user_identify']['user'];
    $user = getUserFromUser($db, $_SESSION['user_identify']['user']);
}

require_once $_SERVER['DOCUMENT_ROOT'] . '/resources/php-requires/template.php';

$user = mysqli_fetch_assoc($user);
$requests = checkSendRequest($db, (int)$_SESSION['user_identify']['id'], $user['id']);
$requests = mysqli_fetch_assoc($requests);
?>

<?php if (isset($_GET['delete_profile_picture'])) : ?>
    <script type="text/javascript">
        $(window).on('load', function() {
            $('#update_profile_picture').modal('show');
        });
    </script>
<?php endif; ?>

<div class="row">

    <ul class="nav list-unstyled col-lg-6">

        <?php if ($_SESSION['user_identify']['id'] == $user['id']) : ?>
            <li class="m-auto ml-auto mr-0"><a href="" data-toggle="modal" data-target="#update_profile_picture" class="btn"><img width="60" src="/database/social/<?= $user['profile_picture'] ?>" alt="Profile Picture"></a></li>
        <?php else : ?>
            <li class="m-auto ml-auto mr-0"><img width="60" src="/database/social/<?= $user['profile_picture'] ?>" alt="Profile Picture"></li>
        <?php endif; ?>

        <li class="m-auto ml-3"><h2><?= $title ?></h2></li>

    </ul>

    <ul class="nav list-unstyled col-lg-6 mt-1 text-center d-none d-xl-block d-lg-block">

        <?php if (!empty($user['steam'])) : ?>
            <li class="social-icons m-auto"><a href="https://<?= $user['steam'] ?>" target="_blank"><i class="fa fa-steam"></i></a></li>
        <?php endif; ?>

        <?php if (!empty($user['twitter'])) : ?>
            <li class="social-icons m-auto"><a href="https://<?= $user['twitter'] ?>" target="_blank"><i class="fa fa-twitter"></i></a></li>
        <?php endif; ?>

        <?php if (!empty($user['youtube'])) : ?>
            <li class="social-icons m-auto"><a href="<?= $user['youtube'] ?>" target="_blank"><i class="fa fa-youtube-play"></i></a></li>
        <?php endif; ?>

    </ul>

</div>

<?php if ($_SESSION['user_identify']['id'] != false && $_SESSION['user_identify']['id'] != $user['id']) : ?>
    <br>
    <?php if ($requests == null) : ?>
        <a href="../validate_data/add_follow.php?id_send=<?= $_SESSION['user_identify']['id']; ?>&id_receive=<?= $user['id'] ?>&private_account=<?= $user['private_account']; ?>">Follow</a>
    <?php elseif ($requests['accept'] == 0 && $user['private_account'] == 1): ?>
        <a href="../validate_data/answer_request.php?answer=1&request=<?= $requests['id'] ?>&user=<?=$user['id']?>">Cancel Follow</a>
    <?php else: ?>
        <a href="../validate_data/delete_follow.php?id_send=<?= $_SESSION['user_identify']['id']; ?>&id_receive=<?= $user['id'] ?>">Unfollow</a>
    <?php endif; ?>
<?php endif; ?>
<hr>

<?php
$entries = getEntriesByIDUser($db, $user['id']);
if (mysqli_num_rows($entries)) :
    while ($entry = mysqli_fetch_assoc($entries)):
        if($entry['hide'] == 0):
            $comments = getComments($db, $entry['id']);
            $user = getUserFromId($db, $entry['user_id']);
            $user = mysqli_fetch_assoc($user);
            $ext = pathinfo($entry['file_entry'], PATHINFO_EXTENSION);
            if ((($entry['only_followers'] == 0 && $user['private_account'] == 0) || $user['id'] == $_SESSION['user_identify']['id']) || mysqli_num_rows($requests)) :
?>
        <?php require $_SERVER['DOCUMENT_ROOT'] . '/resources/php-requires/entry.php'; ?>
<?php
            endif;
        endif;
    endwhile;
endif;
?>

<?php if($_SESSION['user_identify']['id'] == $user['id']): ?>
    <!-- Modal My Data -->
    <div id="update_profile_picture" class="modal fade" role="dialog">
        <div class="modal-dialog modal-lg">

            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title">My data</h3>
                    <a href="user.php" class="btn close">&times;</a>
                </div>

                <div class="modal-body">

                    <form method="POST" action="../validate_data/update_profile_picture.php" enctype="multipart/form-data">

                        <?php if ($_SESSION['user_identify']['profile_picture'] != "default.png" && !isset($_GET['delete_profile_picture'])) : ?>
                            <div class="form-group">
                                <img src="/database/social/<?= $_SESSION['user_identify']['profile_picture'] ?>" class="img-fluid" alt="Profile Picture">
                            </div>
                        <?php endif; ?>

                        <?php if ($_SESSION['user_identify']['profile_picture'] != "default.png" && !isset($_GET['delete_profile_picture'])) : ?>
                            <div class="form-group">
                                <a href="user.php?delete_profile_picture">Delete profile picture</a>
                            </div>
                        <?php endif; ?>

                        <?php if (isset($_GET['delete_profile_picture']) || $_SESSION['user_identify']['profile_picture'] == "default.png") : ?>
                            <div class="form-group">
                                <input type="file" name="profile_picture" accept="image/*,video/mp4" class="custom-file-input">
                            </div>
                        <?php endif; ?>

                        <div class="form-group">
                            <input type="submit" value="Update" name="submit" class="btn btn-primary" />
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
<?php endif; ?>

<?php if ($user == NULL) : ?>
    <label>This user does not exist</label>
<?php endif; ?>

<?php require_once $_SERVER['DOCUMENT_ROOT'] . '/resources/php-requires/sidebar.php'; ?>