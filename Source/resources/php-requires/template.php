<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/configs/connection.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/configs/functions.php';

$user_id = $_SESSION['user_identify']['id'];

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="title" content="Social-Network">
    <meta name="keywords" content="social, network, Social-Network">
    <meta name="robots" content="index, follow, all">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">

    <!-- jQuery library -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>

    <!-- Popper JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>

    <!-- Latest compiled JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>

    <!-- Custom CSS -->
    <link rel="stylesheet" type="text/css" href="../../resources/custom.css">

    <!-- Icons -->
    <script src='https://kit.fontawesome.com/a076d05399.js'></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <title>Social-Network | <?= $title ?></title>

    <?php if (!isset($_SESSION['errors']['general']) && !isset($_SESSION['completed'])) : ?>

        <?php if (isset($_SESSION['errors_signin'])) : ?>

            <script type="text/javascript">
                $(window).on('load', function() {
                    $('#signin').modal('show');
                });
            </script>

        <?php endif; ?>

        <?php if (isset($_SESSION['errors_comment'])) : ?>
            <script type="text/javascript">
                $(window).on('load', function() {
                    $('#comment').modal('show');
                });
            </script>
        <?php endif; ?>

        <?php if (isset($_SESSION['errors_update_password'])) : ?>
            <script type="text/javascript">
                $(window).on('load', function() {
                    $('#update_password').modal('show');
                });
            </script>
        <?php endif; ?>

        <?php if (isset($_SESSION['errors_entry_edit'])) : ?>
            <script type="text/javascript">
                $(window).on('load', function() {
                    $('#edit_entry').modal('show');
                });
            </script>
        <?php endif; ?>

        <?php if (isset($_SESSION['errors_data']) || isset($_GET['data']) || isset($_GET['change_password'])) : ?>
            <script type="text/javascript">
                $(window).on('load', function() {
                    $('#settings').modal('show');
                });
            </script>
        <?php endif; ?>

        <?php if (isset($_GET['comment'])) : ?>
            <script type="text/javascript">
                $(window).on('load', function() {
                    $('#comment').modal('show');
                });
            </script>
        <?php endif; ?>

        <?php if (isset($_GET['entry']) && $_SESSION['user_identify']['id'] != false) : ?>
            <script type="text/javascript">
                $(window).on('load', function() {
                    $('#edit_entry').modal('show');
                });
            </script>
        <?php endif; ?>

        <?php if (isset($_GET['user']) && isset($_GET['token'])) : ?>
            <script type="text/javascript">
                $(window).on('load', function() {
                    $('#update_password').modal('show');
                });
            </script>
        <?php endif; ?>

    <?php endif; ?>

</head>

<body>

    <nav class="navbar navbar-expand-sm mb-4 list-unstyled row mx-0">

        <ul class="nav ml-auto col-lg-5 pr-0">

            <li>
                <h1 class="d-flex mb-0"><a href="../../index.php">Social-Network</a></h1>
            </li>

        </ul>
        
        <div class="col-lg-7 mb-1 mt-1">

            <ul class="float-right list-unstyled d-flex flex-wrap">

                <li class="mr-2 mt-2 mx-auto pr-2">
                    <form action="../pages/searcher.php" method="POST" class="input-group">
                        <input type="text" name="search" class="form-control" placeholder="Search:">

                        <div class="input-group-append">
                            <span class="input-group-text fa fa-search pt-2"></span>
                        </div>
                    </form>
                </li>
                
                <div class="d-inline-flex mt-2 mx-auto">

                    <?php if ($_SESSION['user_identify']['id'] != false) : ?>
                        <li class="mr-1 mt-1"><img width="30" src="/database/social/<?= $_SESSION['user_identify']['profile_picture']; ?>" alt="Profile Picture"/></li>
                        <li class="mr-2"><a href="../pages/user.php" class="btn pl-1 pr-1"><?= $_SESSION['user_identify']['user']; ?></a></li>
                        <li class="mr-1"><a href="../pages/notifications.php" class="btn btn-primary"><i class="far fa-bell"></i></a></li>
                        <li class="mr-1"><a href="" class="btn btn-primary" data-toggle="modal" data-target="#settings"><i class="fas fa-sliders-h"></i></a></li>
                        <li class="mr-1"><a href="../../configs/logout.php" class="btn btn-primary"><i class="fas fa-sign-out-alt"></i></a></li>
                    <?php else : ?>
                        <li class="mr-1"><a class="btn btn-primary" data-toggle="modal" data-target="#login">Log In</a></li>
                        <li class="mr-1"><a class="btn btn-primary" data-toggle="modal" data-target="#signin">Sign In</a></li>
                    <?php endif; ?>

                </div>

            </ul>
            
        </div>

    </nav>

    <div class="mx-0 row">

        <div class="col-lg-1"></div>
        
        <div class="col-lg-2 mb-4 d-inline-flex d-xl-block d-lg-block">

            <ul class="list-unstyled sidebar d-inline-flex d-xl-block d-lg-block">

                <li class="mr-1 mb-1"><a href="../../index.php">HOME</a></li>

                <li class="mr-1 mb-1"><a href="../pages/events.php">EVENTS</a></li>

                <?php if ($_SESSION['user_identify']['id'] != false) : ?>
                    <li class="mr-1 mb-1"><a href="../pages/friends.php">FRIENDS</a></li>
                <?php else : ?>
                    <li class="mr-1 mb-1"><a href="" data-toggle="modal" data-target="#login">FRIENDS</a></li>
                <?php endif; ?>

                <?php if ($_SESSION['user_identify']['id'] != false) : ?>
                    <li class="mb-1"><a href="../pages/user.php">PROFILE</a></li>
                <?php else : ?>
                    <li class="mb-1"><a href="" data-toggle="modal" data-target="#login">PROFILE</a></li>
                <?php endif; ?>

            </ul>

        </div>

        <!-- Modal Sign In -->
        <div id="signin" class="modal fade" role="dialog">
            <div class="modal-dialog modal-lg">

                <div class="modal-content">
                    <div class="modal-header">
                        <h3 class="modal-title">Sign In</h3>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>

                    <div class="modal-body">
                        <form method="POST" action="../validate_data/validate_signin">
                            <div class="form-group">
                                <input type="text" name="user" autofocus class="form-control" placeholder="User:" />
                                <span><?= isset($_SESSION['errors_signin']) ? showErrors($_SESSION['errors_signin'], 'user') : ''; ?></span>
                            </div>

                            <div class="form-group">
                                <input type="email" name="email" class="form-control" placeholder="Email:" />
                                <span><?= isset($_SESSION['errors_signin']) ? showErrors($_SESSION['errors_signin'], 'email') : ''; ?></span>
                            </div>

                            <div class="form-group">
                                <input type="password" name="password" class="form-control" placeholder="Password:" />
                                <span><?= isset($_SESSION['errors_signin']) ? showErrors($_SESSION['errors_signin'], 'password') : ''; ?></span>
                            </div>

                            <div class="form-group">
                                <input type="password" name="password_verify" class="form-control" placeholder="Password verification:" />
                                <span><?= isset($_SESSION['errors_signin']) ? showErrors($_SESSION['errors_signin'], 'password_verify') : ''; ?></span>
                            </div>

                            <div class="form-group mb-0">
                                <label>Private account:</label>
                                <input type="checkbox" name="private_account" value="1" />
                            </div>

                            <input type="submit" value="Sign Up" name="submit" class="btn btn-primary" /><br><br>

                            <p>By clicking on Sign Up you accept the <a href="../pages/cookies_policy.php">Cookies Policy</a>, also accept <a href="../pages/terms_and_conditions.php">Terms and Conditions</a>.</p>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal Login -->
        <div id="login" class="modal fade" role="dialog">
            <div class="modal-dialog modal-lg">

                <div class="modal-content">
                    <div class="modal-header">
                        <h3 class="modal-title">Log In</h3>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>

                    <div class="modal-body">
                        <form method="POST" action="../validate_data/validate_login">
                            <div class="form-group">
                                <input type="text" name="email_user" placeholder="Email or User:" class="form-control" />
                            </div>

                            <div class="form-group">
                                <input type="password" name="password" placeholder="Password:" class="form-control" />
                            </div>

                            <div class="form-group">
                                <a href="" data-dismiss="modal" data-toggle="modal" data-target="#forgot_password">Forgot Password?</a>
                            </div>

                            <input type="submit" value="Log In" name="submit" class="btn btn-primary" />
                        </form>

                    </div>
                </div>
            </div>
        </div>

        <!-- Modal Forgot Password -->
        <div id="forgot_password" class="modal fade" role="dialog">
            <div class="modal-dialog modal-lg">

                <div class="modal-content">
                    <div class="modal-header">
                        <h3 class="modal-title">Forgot Password</h3>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>

                    <div class="modal-body">
                        <form method="POST" action="../validate_data/send_email.php?action=forgot_password">
                            <div class="form-group">
                                <input type="text" name="email_user" placeholder="Email" class="form-control" />
                            </div>

                            <input type="submit" value="Forgot Password" name="submit" class="btn btn-primary" />
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal My Data -->
        <div id="settings" class="modal fade" role="dialog">
            <div class="modal-dialog modal-lg">

                <div class="modal-content">
                    <div class="modal-header">
                        <h3 class="modal-title">Settings</h3>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>

                    <div class="modal-body">

                        <div class="nav">
                            <a href="../../index.php?data">My data</a>
                            <a class="ml-1" href="../../index.php?change_password">Change Password</a>
                        </div><hr>

                        <?php if(isset($_GET['change_password'])): ?>

                            <h3 class="mt-3">Change password</h3>

                            <form class="mt-4" method="POST" action="../validate_data/change_password.php">
                                <div class="form-group">
                                    <input type="password" name="password_old" placeholder="Last password:" class="form-control"/>
                                    <span><?=isset($_SESSION['errors_data']) ? showErrors($_SESSION['errors_data'], 'password_old') : ''; ?></span>
                                </div>

                                <div class="form-group">
                                    <input type="password" name="password_new" placeholder="New password:" class="form-control"/>
                                    <span><?=isset($_SESSION['errors_data']) ? showErrors($_SESSION['errors_data'], 'password_new') : ''; ?></span>
                                </div>

                                <input type="submit" value="Actualizar" name="submit" class="btn btn-primary"/>
                            </form>

                        <?php else: ?>

                            <h3 class="mt-3">My data</h3>

                            <form class="mt-4" method="POST" action="../validate_data/change_my_data.php" enctype="multipart/form-data">

                            <div class="form-group">
                                <input type="text" name="user" value="<?= $_SESSION['user_identify']['user']; ?>" class="form-control" />
                                <span><?= isset($_SESSION['errors_data']) ? showErrors($_SESSION['errors_data'], 'user') : ''; ?></span>
                            </div>

                            <div class="form-group">
                                <input type="email" name="email" value="<?= $_SESSION['user_identify']['email']; ?>" class="form-control" />
                                <span><?= isset($_SESSION['errors_data']) ? showErrors($_SESSION['errors_data'], 'email') : ''; ?></span>
                            </div>

                            <div class="form-group">
                                <?php if (empty($_SESSION['user_identify']['steam'])) : ?>
                                    <input type="text" name="steam" placeholder="steamcommunity.com/id/*" class="form-control" />
                                <?php else : ?>
                                    <input type="text" name="steam" value="<?= $_SESSION['user_identify']['steam'] ?>" class="form-control" />
                                <?php endif; ?>

                                <span><?= isset($_SESSION['errors_data']) ? showErrors($_SESSION['errors_data'], 'steam') : ''; ?></span>
                            </div>

                            <div class="form-group">
                                <?php if (empty($_SESSION['user_identify']['twitter'])) : ?>
                                    <input type="text" name="twitter" placeholder="twitter.com/*" class="form-control" />
                                <?php else : ?>
                                    <input type="text" name="twitter" value="<?= $_SESSION['user_identify']['twitter'] ?>" class="form-control" />
                                <?php endif; ?>

                                <span><?= isset($_SESSION['errors_data']) ? showErrors($_SESSION['errors_data'], 'twitter') : ''; ?></span>
                            </div>

                            <div class="form-group">
                                <?php if (empty($_SESSION['user_identify']['youtube'])) : ?>
                                    <input type="text" name="youtube" placeholder="youtube.com/channel/*" class="form-control" />
                                <?php else : ?>
                                    <input type="text" name="youtube" value="<?= $_SESSION['user_identify']['youtube'] ?>" class="form-control" />
                                <?php endif; ?>

                                <span><?= isset($_SESSION['errors_data']) ? showErrors($_SESSION['errors_data'], 'youtube') : ''; ?></span>
                            </div>

                            <?php if ($_SESSION['user_identify']['private_account'] == 0) : ?>
                                <div class="form-group">
                                    <label>Private account:</label>
                                    <input type="checkbox" name="private_account" value="1" class="form-check-input ml-2" />
                                </div>
                            <?php endif; ?>

                            <?php if ($_SESSION['user_identify']['private_account'] == 1) : ?>
                                <div class="form-group">
                                    <label>Private account:</label>
                                    <input type="checkbox" name="private_account" value="1" class="form-check-input ml-2" />
                                </div>
                            <?php endif; ?>

                            <div class="form-group">
                                <input type="submit" value="Update" name="submit" class="btn btn-primary" />
                            </div>

                        </form>

                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal Update Password -->
        <div id="update_password" class="modal fade" role="dialog">
            <div class="modal-dialog modal-lg">

                <div class="modal-content">
                    <div class="modal-header">
                        <h3 class="modal-title">Update Password</h3>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>

                    <div class="modal-body">

                        <?php
                        $status = checkRecovery($db, $_GET['user'], $_GET['token']);
                        if (mysqli_num_rows($status)) :
                        ?>

                            <form method="POST" action="../validate_data/update_password.php?user=<?= $_GET['user'] ?>&token=<?= $_GET['token'] ?>">
                                <div class="form-group">
                                    <input type="password" name="password" placeholder="New Password" class="form-control" />
                                    <span><?= isset($_SESSION['errors_update_password']) ? showErrors($_SESSION['errors_update_password'], 'password') : ''; ?></span>
                                </div>

                                <div class="form-group">
                                    <input type="password" name="password_verify" placeholder="Verify Password" class="form-control" />
                                    <span><?= isset($_SESSION['errors_update_password']) ? showErrors($_SESSION['errors_update_password'], 'password_verify') : ''; ?></span>
                                </div>

                                <input type="submit" value="Update Password" name="submit" class="btn btn-primary" />
                            </form>

                        <?php else : ?>
                            <label>Restart the password recovery process</label>
                        <?php endif; ?>

                    </div>
                </div>
            </div>
        </div>

        <!-- Modal Edit Entry -->
        <div id="edit_entry" class="modal fade" role="dialog">
            <div class="modal-dialog modal-lg">

                <div class="modal-content">
                    <div class="modal-header">
                        <h3 class="modal-title">Edit entry</h3>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>

                    <div class="modal-body">

                        <?php
                        $now_entry = getEntry($db, $_GET['entry']);
                        $now_entry = mysqli_fetch_assoc($now_entry);
                        $ext = pathinfo($now_entry['file_entry'], PATHINFO_EXTENSION);

                        ?>
                        <?php if (isset($_GET['delete_file'])) : ?>
                            <form action="../validate_data/edit_entries.php?id=<?= $now_entry['id'] ?>&delete_file" method="POST" enctype="multipart/form-data">
                        <?php else : ?>
                            <form action="../validate_data/edit_entries.php?id=<?= $now_entry['id'] ?>" method="POST" enctype="multipart/form-data">
                        <?php endif; ?>

                                <div class="form-group">
                                    <textarea name="entry" class="form-control mt-1"><?= $now_entry['entry'] ?></textarea>
                                    <span><?= isset($_SESSION['errors_entry_edit']) ? showErrors($_SESSION['errors_entry_edit'], 'entries') : ''; ?></span>
                                </div>

                                <?php if (!isset($_GET['delete_file']) && !empty($now_entry['file_entry'])) : ?>

                                    <ul class="nav list-unstyled">

                                        <?php if (!empty($now_entry['file_entry']) && $ext != "mp4") : ?>
                                            <li class="m-auto"><img src="/database/entries/<?= $now_entry['file_entry'] ?>" class="img-fluid" alt="Entry image"></li>
                                        <?php endif; ?>

                                        <?php if (!empty($now_entry['file_entry']) && $ext == "mp4") : ?>
                                            <li class="m-auto">
                                                <video controls class="embed-responsive">
                                                    <source src="/database/entries/<?= $now_entry['file_entry'] ?>" type="video/mp4">
                                                </video>
                                            </li>
                                        <?php endif; ?>

                                    </ul>

                                <?php endif; ?>

                                <ul class="form-group nav list-unstyled pt-2 d-inline-flex">

                                    <?php if (!isset($_GET['delete_file']) && !empty($now_entry['file_entry'])) : ?>
                                        <li class="mt-2"><a href=".?entry=<?= $now_entry['id'] ?>&delete_file">Delete file</a></li>
                                    <?php endif; ?>

                                    <?php if (isset($_GET['delete_file']) || empty($now_entry['file_entry'])) : ?>
                                        <li class="form-group pt-1">
                                            <input type="file" name="file_entry" accept="image/*,video/mp4" class="custom-file-input">
                                        </li>
                                    <?php endif; ?>

                                    <li class="form-group mx-3 d-block pt-2">
                                        <?php if($now_entry['only_followers'] == 1): ?>
                                            <input type="checkbox" value="1" name="only_followers" checked>
                                        <?php else: ?>
                                            <input type="checkbox" value="1" name="only_followers">
                                        <?php endif;?>

                                        <span><i class="fas fa-user-friends"></i></span>
                                    </li>

                                    <li><input type="submit" value="Publish" class="btn btn-primary"></li>

                                </ul>

                                <span><?= isset($_SESSION['errors_entry_edit']) ? showErrors($_SESSION['errors_entry_edit'], 'file_entry') : ''; ?></span>

                                </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal Comment -->
        <div id="comment" class="modal fade" role="dialog">
            <div class="modal-dialog modal-lg">

                <?php
                    $now_entry = getEntry($db, $_GET['comment']);
                    $now_entry = mysqli_fetch_assoc($now_entry);
                ?>

                <div class="modal-content">
                    <div class="modal-header">
                        <h3 class="modal-title">Comments</h3>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>

                    <div class="modal-body">

                        <p><?= $now_entry['entry'] ?></p>
                        <hr>

                        <form method="POST" action="../validate_data/add_comment.php?id=<?= $now_entry['id'] ?>">
                            <div class="form-group">
                                <input type="text" name="comment" placeholder="Write the comment" class="form-control d-inline-block reduced">

                                <input type="submit" value="Publish!" class="btn btn-primary d-inline-flex">

                                <span><?= isset($_SESSION['errors_comment']) ? showErrors($_SESSION['errors_comment'], 'comment') : ''; ?></span>
                            </div>
                        </form>
                        <hr>

                        <?php
                        $comments = getComments($db, $_GET['comment']);
                        if (!empty($comments)) :
                            while ($comment = mysqli_fetch_assoc($comments)) :
                                $user = getUserFromId($db, $comment['user_id']);
                                $user = mysqli_fetch_assoc($user);
                                if ($comment['hide'] == 0) :
                        ?>
                                    <div class="float-right">
                                        <?php if ($_SESSION['user_identify'] != false && $_SESSION['user_identify']['id'] == $user['id']) : ?>
                                            <a href="../validate_data/delete_comment.php?id=<?= $comment['id'] ?>&entry=<?= $_GET['comment'] ?>"><i class="far fa-trash-alt"></i></a>
                                        <?php endif; ?>

                                        <?php if ($_SESSION['user_identify'] != false && $_SESSION['user_identify']['id'] != $user['id']) : ?>
                                            <a href="../validate_data/report.php?id=<?= $comment['id'] ?>&report=comments"><i class="fas fa-exclamation-triangle"></i></a>
                                        <?php endif; ?>

                                        <?php if ($_SESSION['user_identify']['staff'] == 1 && $_SESSION['user_identify']['id'] != $user['id']) : ?>
                                            <a href="../validate_data/hide_staff.php?id=<?= $comment['id'] ?>&delete=comments"><i class="far fa-trash-alt"></i></a>
                                        <?php endif; ?>
                                    </div>

                                    <img width="30" src="../database/social/<?= $user['profile_picture'] ?>" alt="Profile Picture">
                                    <?php if ($comment['edit_datetime'] == null) : ?>
                                        <a href="../pages/user.php"><?= $user['user'] ?><span> - <?= explode(" ", $comment['create_datetime'])[0] ?></span></a>
                                    <?php else : ?>
                                        <a href="../pages/user.php"><?= $user['user'] ?><span> - <?= explode(" ", $comment['edit_datetime'])[0] ?></span></a>
                                    <?php endif; ?>

                                    <p class="mt-3"><?= $comment['comment'] ?></p>

                                    <hr>
                        <?php
                                endif;
                            endwhile;
                        endif;
                        ?>

                    </div>
                </div>
            </div>
        </div>

        <main class="container col-lg-6">

            <?php if (isset($_SESSION['completed'])) : ?>
                <div class="alert alert-success m-auto text-center">
                    <?= $_SESSION['completed'] ?>
                </div><br>
            <?php endif; ?>

            <?php if (isset($_SESSION['errors']['general'])) : ?>
                <div class="alert alert-danger m-auto text-center">
                    <?= $_SESSION['errors']['general'] ?>
                </div><br>
            <?php endif; ?>