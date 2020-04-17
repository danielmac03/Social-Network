<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/configs/isset_sessions.php';

$title = "Notifications";

require_once $_SERVER['DOCUMENT_ROOT'] . '/resources/php-requires/template.php';

?>

<h2>Notifications</h2><hr>

<?php
    $requests = checkReceiveRequest($db, $_SESSION['user_identify']['id']);
    if (!empty($requests)) :
        while ($request = mysqli_fetch_assoc($requests)) :
            $user = getUserFromId($db, $request['user_send']);
            $user = mysqli_fetch_assoc($user);
?>
                <img width="60" src="/database/social/<?= $user['profile_picture'] ?>" alt="Profile Picture">
                <a href="user.php?user=<?= $user['user'] ?>"><?= $user['user'] ?></a>

                <?php if($request['accept'] == 0): ?>
                    <p class="mt-3"><?= $user['user'] ?> wants follow you</p>
                    <a href="../validate_data/answer_request.php?answer=2&request=<?= $request['id'] ?>">Accept Request</a>
                    <a href="../validate_data/answer_request.php?answer=1&request=<?= $request['id'] ?>">Decline Request</a>
                <?php elseif($request['accept'] == 2 && $request['notify'] == 0): ?>
                    <p class="mt-3"><?= $user['user'] ?> follow you</p>
                    <a href="../validate_data/answer_request.php?answer=1&request=<?= $request['id'] ?>">Okey</a><hr>
                <?php endif; ?>

<?php
        endwhile;
    endif;
?>

<?php require_once $_SERVER['DOCUMENT_ROOT'] . '/resources/php-requires/sidebar.php'; ?>