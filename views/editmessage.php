    <div class="navbar navbar-default navbar-reply">
        <h3>Muokkaa viestiä</h3>
        <form style="margin: 15px; float: left;" action="message_edit.php?topic=<?php echo $data->topic->get_id(); ?>&amp;edit=<?php echo $data->target->get_id(); ?>" method="post">
            <textarea name="message" style="width: 500px; height: 200px;" type="text" required><?php echo $data->target->get_body(); ?></textarea><br />
            <button class="btn btn-lg" style="float:right !important;" type="submit">Tallenna</button>
        </form>
    </div>

