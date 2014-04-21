<div class="navbar navbar-default">
    <div class="list-group">
        <a class="navbar-link navbar-right" style="margin-right: 15px;" href="message_new.php">Uusi viestiketju</a>
        <h4 class="list-group-heading"><?php echo $data->forum->get_name(); ?></h4>
        <?php foreach($data->topics as $topic): ?>
        <?php if(!$topic->is_hidden()): ?>
        <a href="viewtopic.php?id=<?php echo $topic->get_id(); ?>" class="list-group-item">
            <h4 class="list-group-item-heading"><?php echo $topic->get_title(); ?></h4>
            <p class="list-group-item-text"><?php echo $topic->get_sent(); ?> - - <?php echo $topic->get_owner()->get_username(); ?></p>
        </a>
        <?php endif; ?>
        <?php endforeach; ?>
    </div>
</div>

