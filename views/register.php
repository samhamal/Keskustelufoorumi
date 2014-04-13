<div class="navbar navbar-default">
    <?php if (isset($data->error)): ?>
        <div class="alert alert-danger"><?php echo $data->error; ?></div>
    <?php endif; ?>
    <form action="register.php" class="form-signin" role="form" method="post">
        <h2 class="form-signin-heading">Rekisteröityminen</h2>
        
        <?php if (isset($data->username)): ?>
            <input name="username" type="text" class="form-control form-start" value="<?php echo $data->username; ?>" required autofocus>
        <?php else: echo '<input name="username" type="text" class="form-control form-start" placeholder="käyttäjänimi" required autofocus>';
        endif; ?>
        <?php if (isset($data->email)): ?>
            <input name="email" type="email" class="form-control form-item" value="<?php echo $data->email; ?>" required>
        <?php else: echo '<input name="email" type="email" class="form-control form-item" placeholder="email" required>';
        endif; ?>
        <input name="password" type="password" class="form-control form-item" placeholder="salasana" required>
        <input name="password_confirm" type="password" class="form-control form-end" placeholder="salasana uudestaan" required>
        <button class="btn btn-lg btn-block" type="submit">Rekisteröidy</button>
    </form>
</div>

