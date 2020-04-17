<article class="mt-4">
        <img width="50" src="/database/social/<?= $user['profile_picture'] ?>" alt="Profile Picture">
        <a href="../pages/user.php?user=<?=$user['user']?>"><?= $user['user'] ?><span> - <?= explode(" ", $entry['create_datetime'])[0] ?></span><span class="d-none d-xl-inline d-lg-inline"> <?= explode(" ", $entry['create_datetime'])[1]?></span></a>
        
        <div class="mt-3"></div>

        <?php if($entry['entry']): ?>
            <h4 class="entry"><?= $entry['entry'] ?></h4>
        <?php endif; ?>

        <ul class="nav list-unstyled">

            <?php if (!empty($entry['file_entry']) && $ext != "mp4") : ?>
                <li class="m-auto"><img src="/database/entries/<?= $entry['file_entry'] ?>" class="img-fluid" alt="Entry image"></li>
            <?php endif; ?>

            <?php if (!empty($entry['file_entry']) && $ext == "mp4") : ?>
                <li class="m-auto">
                    <video controls class="embed-responsive">
                        <source src="/database/entries/<?= $entry['file_entry'] ?>" type="video/mp4">
                    </video>
                <li>
            <?php endif; ?>

        </ul>

        <ul class="nav list-unstyled mt-3">
            <li class="m-auto"><a href="../validate_data/add_point_plays.php?id=<?= $entry['id'] ?>"><i class="far fa-heart"><span> <?= $entry['likes'] ?></span></i></a></li>
            <li class="m-auto"><a href="../../index.php?comment=<?= $entry['id'] ?>"><i class="far fa-comment"><span> <?= mysqli_num_rows($comments) ?></span></i></a></li>

            <?php if ($_SESSION['user_identify'] != false && $_SESSION['user_identify']['id'] == $user['id']) : ?>
                <li class="m-auto"><a href="../../index.php?entry=<?=$entry['id']?>"><i class="fas fa-pen"></i></a></li>
                <li class="m-auto"><a href="../validate_data/delete_entry.php?id=<?= $entry['id'] ?>"><i class="far fa-trash-alt"></i></a></li>
            <?php endif; ?>

            <?php if ($_SESSION['user_identify'] != false && $_SESSION['user_identify']['id'] != $user['id']) : ?>
                <li class="m-auto"><a href="../validate_data/report.php?id=<?= $entry['id'] ?>&report=entries"><i class="fas fa-exclamation-triangle"></i></a></li>
            <?php endif; ?>

            <?php if ($_SESSION['user_identify']['staff'] == 1 && $_SESSION['user_identify']['id'] != $user['id']) : ?>
                <li class="m-auto"><a href="../validate_data/hide_staff.php?id=<?= $entry['id'] ?>&delete=entries"><i class="far fa-trash-alt"></i></a></li>
            <?php endif; ?>

        </ul>

        <hr>
</article>