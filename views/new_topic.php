<div class="navbar navbar-default navbar-reply">
    <h3 style="margin-left: 15px">Uusi viestiketju</h3>
    <form style="margin: 15px; float: left;" action="message_new.php?create" method="post">
        <input type="text" name="title" class="form-start" style="width: 500px" placeholder="otsikko" required><br/>
        <textarea name="message" style="width: 500px; height: 200px;" type="text" placeholder="viesti" required></textarea><br />
        <select name="forum">
            <?php foreach($data->forums as $forum): ?>
            <option value="<?php echo $forum->get_id(); ?>"><?php echo $forum->get_name(); ?></option>
            <?php endforeach; ?>
        </select>
        <button class="btn btn-lg" style="float:right !important;" type="submit">Lähetä</button>
    </form>
</div>

