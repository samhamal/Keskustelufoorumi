<div class="navbar navbar-default">

    <?php if(isset($data->find_user)): ?>
    <form action="find.php" class="form-signin" role="form" method="post">
        <h3>Etsi käyttäjä</h3>
        <input name="user_username" type="text" class="form-control form-start" placeholder="käyttäjän nimi">
        <button class="btn btn-lg btn-block" type="submit">Hae</button>
    </form>
    <?php endif; ?>
    <?php if(isset($data->find_topic)): ?>
    <form action="find.php" class="form-signin" role="form" method="post">
        <h3>Etsi viestiketju</h3>
        <input name="topic_username" type="topic_username" class="form-control form-start" placeholder="käyttäjän nimi">
        <input name="topic_title" type="topic_title" class="form-control form-item" placeholder="viestiketjun otsikko">
        <input name="topic_forum" type="topic_forum" class="form-control form-end" placeholder="aihealueen nimi">
        <button class="btn btn-lg btn-block" type="submit">Hae</button>
    </form>
    <?php endif; ?>
</div>

<?php if(isset($data->find_user)): ?>
<div class="navbar navbar-default">
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
<?php endif; ?>
<?php if(isset($data->find_topic)): ?>
<div class="navbar navbar-default">
      <table class="table">
          <tr>
              <td>Viestiketjun nimi</td>
              <td>Viestiketjun aloittaja</td>
              <td>Aihealue</td>
          </tr>
          <?php foreach($data->topics as $topic): ?>
          <?php if(!$topic->is_hidden()): ?>
          <tr>
          <td><a class="navbar-link" href="viewtopic.php?id=<?php echo $topic->get_id(); ?>"><?php echo $topic->get_title(); ?></a></td>
          <td><a class="navbar-link" href="user.php?id=<?php echo $topic->get_owner()->get_id(); ?>"><?php echo $topic->get_owner()->get_username(); ?></a></td>
          <td><a class="navbar-link" href="viewforum.php?id=<?php echo $topic->get_forum(); ?>"><?php echo $data->forums[$topic->get_forum()]; ?></a></td>
          </tr>
          <?php endif; ?>
          <?php endforeach; ?>
      </table>
</div>
<?php endif; ?>


