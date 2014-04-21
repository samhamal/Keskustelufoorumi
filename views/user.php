<!-- käyttäjätietojen vaihto näkyvissä vain käyttäjälle itselleen ja ylläpidolle-->
<?php if(!isset($data->target_user)) {
    $data->target_user = $data->current_user;
}?>
<?php if ((isset($data->target_user) && $data->current_user->is_admin()) || ($data->target_user->get_id() == $data->current_user->get_id())): ?>

<div class="navbar navbar-default">
    <?php if (isset($data->error)): ?>
        <div class="alert alert-danger"><?php echo $data->error; ?></div>
    <?php endif; ?>
    <?php if (isset($data->success)): ?>
        <div class="alert alert-success"><?php echo $data->success; ?></div>
    <?php endif; ?>
    
    <div style="padding-left: 15px">
        <h4 class="list-group-heading">
        <a href="user.php?id=<?php echo $data->target_user->get_id(); ?>" class="navbar-link">Käyttäjä</a> &#0187; <a href="user.php?id=<?php echo $data->target_user->get_id(); ?>" class="navbar-link"><?php echo $data->target_user->get_username(); ?></a>
        </h4>
    </div>
    <?php if ($data->target_user->get_id() != $data->current_user->get_id()): ?>
        <form action="user.php?id=<?php echo $data->target_user->get_id(); ?>" class="form-signin" role="form" method="post">
    <?php else: ?>
        <form action="user.php" class="form-signin" role="form" method="post">
    <?php endif; ?>
        <input name="email" type="email" class="form-control form-item" value="<?php echo $data->target_user->get_email(); ?>">
        <input name="password" type="password" class="form-control form-item" placeholder="salasanan vaihto">
        <input name="password_confirm" type="password" class="form-control form-end" placeholder="salasana uudestaan">
        <button class="btn btn-lg btn-block" type="submit">Tallenna</button>
    </form>
    <?php if($data->current_user->is_admin() && !$data->target_user->is_admin()): ?>
    <a href="user.php?remove=1&id=<?php echo $data->target_user->get_id(); ?>" class="navbar-link navbar-right">Poista käyttäjä</a>
    <?php endif; ?>
</div>
<?php endif; ?>

<div class="navbar navbar-default">
    <div class="list-group">
        <h4 class="list-group-heading"><a href="user.php?id=<?php echo $data->target_user->get_id(); ?>" class="navbar-link">Käyttäjän viestiketjut</a> &#0187; <a href="user.php?id=<?php echo $data->target_user->get_id(); ?>" class="navbar-link"><?php echo $data->target_user->get_username(); ?></a></h4>
        <?php foreach($data->messages as $topic): ?>
        <?php if(!$topic->is_hidden() && $topic->get_parent() == null && $topic->get_title() != null): ?>
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
        <h4 class="list-group-heading"><a href="user.php?id=<?php echo $data->target_user->get_id(); ?>" class="navbar-link">Käyttäjän viestit</a> &#0187; <a href="user.php?id=<?php echo $data->target_user->get_id(); ?>" class="navbar-link"><?php echo $data->target_user->get_username(); ?></a></h4>
        <?php foreach($data->messages as $topic): ?>
        <?php if(!$topic->is_hidden() && $topic->get_parent() != null && $topic->get_title() == null): ?>
        <a href="viewtopic.php?id=<?php echo $topic->get_id(); ?>" class="list-group-item">
            <h4 class="list-group-item-heading"><?php echo $data->forums[$topic->get_forum()]; ?> &#0187; <?php echo $topic->get_body(); ?></h4>
            <p class="list-group-item-text"><?php echo $topic->get_sent(); ?> - - <?php echo $topic->get_owner()->get_username(); ?></p>
        </a>
        <?php endif; ?>
        <?php endforeach; ?>
    </div>
</div>