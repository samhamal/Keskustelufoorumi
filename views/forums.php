    <?php if (isset($data->error)): ?>
        <div class="alert alert-danger"><?php echo $data->error; ?></div>
    <?php endif; ?>
<div class="navbar navbar-default">
    <div class="list-group">
        <?php foreach($data->forums as $one_forum): ?>
        <a href="viewforum.php?id=<?php echo $one_forum->get_id(); ?>" class="list-group-item">
            <h4 class="list-group-item-heading"><?php echo $one_forum->get_name(); ?></h4>
            <p class="list-group-item-text"><?php echo $one_forum->get_description(); ?></p>
        </a>
        <?php endforeach; ?>
    </div>
</div>