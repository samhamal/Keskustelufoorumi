<div class="navbar navbar-default">
    <div class="list-group">
        <h4 class="list-group-heading">Viimeisimmät viestiketjut</h4>
        <?php foreach($data->topics as $topic): ?>
        <?php if(!$topic->is_hidden()): ?>
        <a href="viewtopic.php?id=<?php echo $topic->get_id(); ?>" class="list-group-item">
            <h4 class="list-group-item-heading"><?php echo $data->forums[$topic->get_forum()]; ?> &#0187; <?php echo $topic->get_title(); ?></h4>
            <p class="list-group-item-text"><?php echo $topic->get_sent(); ?> - - <?php echo $topic->get_owner()->get_username(); ?></p>
        </a>
        <?php endif; ?>
        <?php endforeach; ?>
    </div>
</div>

<div class="navbar navbar-default">
    <div class="list-group">
        <h4 class="list-group-heading">Lukemattomat viestiketjut</h4>
        <?php foreach($data->unread as $unread): ?>
        <?php if(!$unread->is_hidden()): ?>
        <a href="viewtopic.php?id=<?php echo $unread->get_id(); ?>" class="list-group-item">
            <h4 class="list-group-item-heading"><?php echo $data->forums[$unread->get_forum()]; ?> &#0187; <?php echo $unread->get_title(); ?></h4>
            <p class="list-group-item-text"><?php echo $unread->get_body(); ?></p>
        </a>
        <div class="list-group-item">
            <p><?php echo $unread->get_sent();?> - - <a href="user.html?id=350" class="navbar-link"><?php echo $unread->get_owner()->get_username(); ?></a></p>
        </div>
        <?php endif; ?>
        <?php endforeach; ?>
    </div>
</div>

