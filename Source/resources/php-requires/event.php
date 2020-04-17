<article class="mt-4">

        <img width="20" src="/database/social/<?= $user['profile_picture']; ?>" alt="Profile Picture"/>
        <a href="../pages/user.php?user=<?=$user['user']?>"><?= $user['user'] ?><span> - <?= explode(" ", $event['create_datetime'])[0] ?></span></a>

        <div class="mt-3"></div>

        <p><?= $event['description'] ?></p>

        <p>Voice Channel: <?=$event['voice_channel']?></p>

        <?php if($event['users'] < $event['max_users'] && !empty($event['users'])): ?>
            <label>Users:</label><br>
            <ul>
                <?php for($i = 0; $i <= (count($users)-1); $i++): 
                    $user = getUserFromID($db, $users[$i]); 
                    $user = mysqli_fetch_assoc($user);
                ?>
                    <li>
                        <img width="20" src="/database/social/<?= $user['profile_picture']; ?>" alt="Profile Picture"/>
                        <a href="../social/user.php?user=<?= $user['user'] ?>"><?= $user['user'] ?></a>
                    </li>
                <?php endfor; ?>
            </ul>
        <?php endif; ?>

        <ul class="nav list-unstyled mt-3">
        
            <?php if ($_SESSION['user_identify'] != false && $_SESSION['user_identify']['id'] == $event['user_host']) : ?>
                <li class="m-auto"><a href="events.php?id=<?= $event['id'] ?>" ><i class="fas fa-pen"></i></a></li>
                <li class="m-auto"><a href="../validate_data/delete_event.php?id=<?= $event['id'] ?>" ><i class="far fa-trash-alt"></i></a></li>
            <?php endif; ?>

            <?php if ($_SESSION['user_identify'] != false && $_SESSION['user_identify']['id'] != $event['user_host']) : ?>
                <li class="m-auto"><a href="../validate_data/report.php?id=<?= $event['id'] ?>&report=events" ><i class="fas fa-exclamation-triangle"></i></a></li>
            <?php endif; ?>

            <?php if ($_SESSION['user_identify']['staff'] == 1 && $_SESSION['user_identify']['id'] != $event['user_host']) : ?>
                <li class="m-auto"><a href="../validate_data/hide_staff.php?id=<?= $event['id'] ?>&delete=events" ><i class="far fa-trash-alt"></i></a></li>
            <?php endif; ?>

            <?php if($_SESSION['user_identify']['id'] != false && $_SESSION['user_identify']['id'] != $event['user_host']): ?>
                <?php if(count($users) < $event['max_users']): ?>
                    <?php for($i = 0; $i <= (count($users)-1); $i++): ?>
                        <?php if($users[$i] != $_SESSION['user_identify']['id']): ?>
                            <li class="m-auto"><a href="../validate_data/join_event.php?id=<?= $event['id'] ?>" >Join</a></li>
                        <?php else: ?>
                            <li class="m-auto"><a href="../validate_data/exit_event.php?id=<?= $event['id'] ?>" >Unjoin</a></li>
                        <?php endif; ?>
                    <?php endfor; ?>
                <?php endif; ?>
            <?php endif; ?>

            <?php if(count($users) < $event['max_users'] && $_SESSION['user_identify'] == false): ?>
                <li class="m-auto"><a a href="" data-toggle="modal" data-target="#login">Join</a></li>
            <?php endif; ?>

        </ul><hr>

</article>