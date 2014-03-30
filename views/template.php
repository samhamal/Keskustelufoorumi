<!DOCTYPE html>
<html>
    <head>
        <title>Keskustelufoorumi</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width">
        <link href="../css/bootstrap.css" rel="stylesheet">
        <link href="../css/bootstrap-theme.css" rel="stylesheet">
        <link href="../css/stylesheet.css" rel="stylesheet">
    </head>
  <body>
    <div class="container">
      <div class="navbar navbar-default" role="navigation">
        <div class="container-fluid">
          <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
              <span class="sr-only">Toggle navigation</span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="index.php">Keskustelufoorumi</a>
          </div>
          <div class="navbar-collapse collapse">
            <ul class="nav navbar-nav">
              <li <?php if (in_array($page, array("index-login", "index-listing", "index-admin"))): ?>class="active"<?php endif; ?>><a href="index.php">Etusivu</a></li>
              <?php if(isset($_SESSION["current_user"])): ?>
              <li <?php if ($page == "forums"): ?>class="active"<?php endif; ?>><a href="forums.php">Aihealueet</a></li>
              <li <?php if ($page == "find"): ?>class="active"<?php endif; ?>><a href="find.php">Etsi</a></li>
              <li <?php if ($page == "user"): ?>class="active"<?php endif; ?>><a href="user.php">Asetukset</a></li>

              <?php $user = $_SESSION["current_user"]; if ($user->is_admin()): ?>
              <li <?php if ($page == "admin"): ?>class="active"<?php endif; ?>><a href="admin.php">Hallinta</a></li>
              <?php endif; ?>
              <?php endif; ?>
            </ul>
            <ul class="nav navbar-nav navbar-right">
              <?php if (!isset($_SESSION["current_user"])): ?>
              <li <?php if ($page == "register"): ?>class="active"<?php endif; ?>><a href="register.php">Rekisteröidy</a></li>
              <?php else: ?>
              <li><a href="index.php?logout">Kirjaudu ulos</a></li>
              <?php endif; ?>
            </ul>
          </div>
        </div>
      </div>

        <?php
            require 'views/' . $page . ".php";
        ?>

    </div>

    <!-- Bootstrap core JavaScript -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
    <script src="../js/bootstrap.min.js"></script>
  </body>
</html>