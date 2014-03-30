<div class="navbar navbar-default">
    <?php if (isset($data->error)): ?>
        <div class="alert alert-danger"><?php echo $data->error; ?></div>
    <?php endif; ?>
    <form action="index.php" class="form-signin" role="form" method="post">
        <h2 class="form-signin-heading">Kirjaudu sisään</h2>

        <?php if (isset($data->username)): ?>
            <input name="username" type="text" class="form-control form-start" value="<?php echo $data->username; ?>" required autofocus>
        <?php else: echo '<input name="username" type="text" class="form-control form-start" placeholder="käyttäjänimi" required autofocus>';
        endif; ?>
        <input name="password" type="password" class="form-control form-end" placeholder="salasana" required>
        <button class="btn btn-lg btn-primary btn-block" type="submit">Kirjaudu</button>
    </form>
</div>