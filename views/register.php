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

      <!-- Static navbar -->
      <div class="navbar navbar-default" role="navigation">
        <div class="container-fluid">
          <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
              <span class="sr-only">Toggle navigation</span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="#">Keskustelufoorumi</a>
          </div>
          <div class="navbar-collapse collapse">
            <ul class="nav navbar-nav">
                <li><a href="index.html">Etusivu</a></li>
            </ul>
            <ul class="nav navbar-nav navbar-right">
              <li class="active"><a href="register.html">Rekisteröidy</a></li>
            </ul>
          </div><!--/.nav-collapse -->
        </div><!--/.container-fluid -->
      </div>

      <!-- Main component for a primary marketing message or call to action -->
      <div class="navbar navbar-default">

      <form class="form-signin" role="form">
        <h2 class="form-signin-heading">Rekisteröityminen</h2>
        <input type="text" class="form-control form-start" placeholder="käyttäjänimi" required autofocus>
        <input type="email" class="form-control form-item" placeholder="email" required>
        <input type="password" class="form-control form-item" placeholder="salasana" required>
        <input type="password" class="form-control form-end" placeholder="salasana uudestaan" required>
        <button class="btn btn-lg btn-primary btn-block" type="submit">Rekisteröidy</button>
      </form>
      </div>

    </div> <!-- /container -->


    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
    <script src="../js/bootstrap.min.js"></script>
  </body>
</html>

