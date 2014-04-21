<div class="navbar navbar-default">
    <div class="list-group">
        <h4 class="list-group-heading">Viimeisimmät viestiketjut</h4>
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

<div class="navbar navbar-default">
    <div class="list-group">
        <h4 class="list-group-heading">Lukemattomat vastaukset</h4>
        <?php foreach($data->unread as $unread): ?>
        <?php if(!$unread->is_hidden()): ?>
        <a href="viewtopic.php?id=3" class="list-group-item">
            <h4 class="list-group-item-heading"><?php echo $data->forums[$unread->get_forum()]; ?> &#0187; <?php echo "unread->get_title()"; ?></h4>
            <p class="list-group-item-text"><?php echo $unread->get_body(); ?></p>
        </a>
        <div class="list-group-item">
            <p>23.3.2014 17:08 - - <a href="user.html?id=350" class="navbar-link"><?php echo $unread->get_owner()->get_username(); ?></a></p>
        </div>
        <?php endif; ?>
        <?php endforeach; ?>
    </div>
</div>

