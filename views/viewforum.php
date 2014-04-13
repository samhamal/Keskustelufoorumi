<div class="navbar navbar-default">
    <div class="list-group">
        <h4 class="list-group-heading"><?php echo $data->forum->get_name(); ?></h4>
        <?php foreach($data->topics as $topic): ?>
        <?php if(!$topic->is_hidden()): ?>
        <a href="viewtopic.php?id=<?php echo $topic->get_id(); ?>" class="list-group-item"><span class="badge">TODO</span>
            <h4 class="list-group-item-heading"><?php echo $topic->get_title(); ?></h4>
            <p class="list-group-item-text"><?php echo $topic->get_sent(); ?> - - <?php echo $topic->get_owner()->get_username(); ?></p>
        </a>
        <?php endif; ?>
        <?php endforeach; ?>
    </div>
</div>

