<div class="navbar navbar-default">

    <?php if(isset($data->find_user)): ?>
    <form action="find.php" class="form-signin" role="form" method="post">
        <h3>Etsi käyttäjä</h3>
        <input name="user_username" type="text" class="form-control form-start" placeholder="käyttäjän nimi">
        <button class="btn btn-lg btn-primary btn-block" type="submit">Hae</button>
    </form>
    <?php endif; ?>
    <?php if(isset($data->find_topic)): ?>
    <form action="find.php" class="form-signin" role="form" method="post">
        <h3>Etsi viestiketju</h3>
        <input type="topic_username" class="form-control form-start" placeholder="käyttäjän nimi">
        <input type="topic_name" class="form-control form-item" placeholder="viestiketjun nimi">
        <input type="topic_before" class="form-control form-item" placeholder="viestiketju luotu ennen ..">
        <input type="topic_after" class="form-control form-item" placeholder="viestiketju luotu jälkeen ..">
        <input type="topic_forum" class="form-control form-end" placeholder="aihealue">
        <button class="btn btn-lg btn-primary btn-block" type="submit">Hae</button>
    </form>
    <?php endif; ?>
</div>

<div class="navbar navbar-default">
    <div class="panel panel-default">
      <table class="table">
          <tr>
              <td>id</td>
              <td>käyttäjänimi</td>
          </tr>
          <?php foreach($data->users as $one_user): ?>
          <tr>
              <td><a class="navbar-link" href="user.php?id=<?php echo $one_user->get_id(); ?>"><?php echo $one_user->get_id(); ?></a></td>
          <td><a class="navbar-link" href="user.php?id=<?php echo $one_user->get_id(); ?>"><?php echo $one_user->get_username(); ?></a></td>
          </tr>
          <?php endforeach; ?>
      </table>
    </div>
</div>

