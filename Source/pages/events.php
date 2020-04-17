<?php

$title = "Events";

require_once $_SERVER['DOCUMENT_ROOT'] . '/resources/php-requires/template.php';

?>

<?php if (isset($_GET['id']) || isset($_SESSION['errors_edit_entries'])) : ?>
    <script type="text/javascript">
        $(window).on('load', function() {
            $('#edit_event').modal('show');
        });
    </script>
<?php endif; ?>

<h2>Events</h2><hr>

<?php if($_SESSION['user_identify']['id'] != false): ?>
    <form  method="POST" action="../validate_data/create_events.php">

        <div class="form-group">
            <input type="text" placeholder="What are you thinking to do?" name="description" class="form-control" autocomplete="off">
            <span><?=isset($_SESSION['errors_create_entries']) ? showErrors($_SESSION['errors_create_entries'], 'description') : ''; ?></span>
        </div>

        <div class="form-group events1 d-inline-block">
            <input type="text" placeholder="Voice channel: " name="voice_channel" class="form-control" autocomplete="off">
            <span><?=isset($_SESSION['errors_create_entries']) ? showErrors($_SESSION['errors_create_entries'], 'voice_channel') : ''; ?></span>
        </div>

        <div class="form-group events2 d-inline-block">
            <select name="max_users" class="form-control">
                <option disabled selected>Participants in the event</option>
                <option value="2">2</option>
                <option value="3">3</option>
                <option value="4">4</option>
                <option value="5">5</option>
            </select>
            <span><?=isset($_SESSION['errors_create_entries']) ? showErrors($_SESSION['errors_create_entries'], 'max_users') : ''; ?></span>
        </div>

        <div class="form-group d-inline-block">
            <input type="submit" value="Publicar" class="btn btn-primary">
        </div>

    </form><hr>
<?php endif; ?>

<div class="event mt-3">

    <?php
    $events = getEvents($db);
    if (!empty($events)) :
        while ($event = mysqli_fetch_assoc($events)) :
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

</div>

<!-- Modal My Data -->
<div id="edit_event" class="modal fade" role="dialog">
<div class="modal-dialog modal-lg">

    <div class="modal-content">
        <div class="modal-header">
            <h3 class="modal-title">My data</h3>
            <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>

        <div class="modal-body">
            <?php
                $event = getEvent($db, $_GET['id']);
                if($event):
                    $event = mysqli_fetch_assoc($event);
            ?>

                    <form method="POST" action="../validate_data/create_events.php?edit&id=<?=$event['id']?>">

                        <div class="form-group">
                            <?php if(!empty($event['description'])): ?>
                                <input type="text" value="<?=$event['description']?>" name="description" class="form-control">
                            <?php else: ?>
                                <input type="text" placeholder="What are you thinking to do?" name="description" class="form-control">
                            <?php endif; ?>
                            <span><?=isset($_SESSION['errors_edit_entries']) ? showErrors($_SESSION['errors_edit_entries'], 'description') : ''; ?></span>
                        </div>

                        <div class="form-group">
                            <?php if(!empty($event['voice_channel'])): ?>
                                <input type="text" value="<?=$event['voice_channel']?>" name="voice_channel" class="form-control">
                            <?php else: ?>
                                <input type="text" placeholder="Voice channel: " name="voice_channel" class="form-control">
                            <?php endif; ?>
                            <span><?=isset($_SESSION['errors_edit_entries']) ? showErrors($_SESSION['errors_edit_entries'], 'voice_channel') : ''; ?></span>
                        </div>

                        <div class="form-group d-inline-block">
                            <input type="submit" value="Publicar" class="btn btn-primary">
                        </div>

                    </form>

                <?php else: ?>
                    <label>Event not found</label>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>


<?php require_once $_SERVER['DOCUMENT_ROOT'] . '/resources/php-requires/sidebar.php'; ?>