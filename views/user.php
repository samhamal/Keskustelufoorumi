<!-- käyttäjätietojen vaihto näkyvissä vain käyttäjälle itselleen ja ylläpidolle-->
<div class="navbar navbar-default">
    <?php if (isset($data->error)): ?>
        <div class="alert alert-danger"><?php echo $data->error; ?></div>
    <?php endif; ?>
    <div class="list-group">
        <h4 class="list-group-heading"><a href="user.php?id=<?php echo $data->user->get_id(); ?>" class="navbar-link">Käyttäjä</a> &#0187; <a href="user.php?id=<?php echo $data->user->get_id(); ?>" class="navbar-link"><?php echo $data->user->get_username(); ?></a></h4>
    </div>
    <form action="user.php" class="form-signin" role="form" method="post">
        <input name="email" type="email" class="form-control form-item" value="<?php echo $data->user->get_email(); ?>">
        <input name="password" type="password" class="form-control form-item" placeholder="salasanan vaihto">
        <input name="password_confirm" type="password" class="form-control form-end" placeholder="salasana uudestaan">
        <button class="btn btn-lg btn-primary btn-block" type="submit">Tallenna</button>
    </form>
</div>

<div class="navbar navbar-default">
    <div class="list-group">
        <h4 class="list-group-heading"><a href="user.php?id=<?php echo $data->user->get_id(); ?>" class="navbar-link">Käyttäjän viestiketjut</a> &#0187; <a href="user.php?id=<?php echo $data->user->get_id(); ?>" class="navbar-link"><?php echo $data->user->get_username(); ?></a></h4>
        <a href="viewtopic.php?id=3" class="list-group-item">
            <h4 class="list-group-item-heading">Yleinen keskustelu &#0187; Lorem ipsum?</h4>
            <p class="list-group-item-text">23.3.2014 17:00 - - JokuKäyttäjä</p>
        </a>
        <a href="viewtopic.php?id=2" class="list-group-item">
            <h4 class="list-group-item-heading">Random &#0187; Toisen viestiketjun nimi</h4>
            <p class="list-group-item-text">23.3.2014 16:15 - - Admin</p>
        </a>
        <a href="viewtopic.php?id=1" class="list-group-item">
            <h4 class="list-group-item-heading">Random  &#0187; Eka viestiketju</h4>
            <p class="list-group-item-text">23.3.2014 16:10 - - JokuKäyttäjä</p>
        </a>
    </div>
</div>
