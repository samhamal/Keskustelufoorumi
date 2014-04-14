    <?php if (isset($data->error)): ?>
        <div class="alert alert-danger"><?php echo $data->error; ?></div>
    <?php endif; ?>
<div class="navbar navbar-default">
    <div class="list-group">
        <?php foreach($data->forums as $one_forum): ?>
        <div class="list-group-item">
            <h4 class="list-group-item-heading"><?php echo $one_forum->get_name(); ?> <a href="admin.php?remove=id">(muokkaa)</a></h4>
            <p class="list-group-item-text"><?php echo $one_forum->get_description(); ?></p>
        </div>
        <?php endforeach; ?>
    </div>
</div>