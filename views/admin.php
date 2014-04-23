    <?php if (isset($data->error)): ?>
        <div class="alert alert-danger"><?php echo $data->error; ?></div>
    <?php endif; ?>
        
<div class="navbar navbar-default">
    <div class="list-group">
        <?php foreach($data->forums as $one_forum): ?>
        <a href="admin.php?edit=<?php echo $one_forum->get_id(); ?>" class="list-group-item">
            <h4 class="list-group-item-heading"><?php echo $one_forum->get_name(); ?></h4>
            <p class="list-group-item-text"><?php echo $one_forum->get_description(); ?></p>
        </a>
        <?php endforeach; ?>
    </div>
</div>
<?php if(isset($data->target)): ?>
    <div class="navbar navbar-default">
        <h3 style="margin-left: 15px;">Muokkaa aihealuetta</h3>
            <form style="margin: 15px;  margin-top: 0px; float: left;" action="admin.php?edit=<?php echo $data->target->get_id(); ?>" method="post">
                <div class="input-group">
                <span class="input-group-addon">Alueen nimi</span>
                <input name="forum_title" class="form-control" required value="<?php echo $data->target->get_name(); ?>"><br /></div>
                <div class="input-group">
                <span class="input-group-addon">ID</span>
                <input name="forum_id" class="form-control" required value="<?php echo $data->target->get_id(); ?>"><br /></div>
                <div class="input-group">
                <span class="input-group-addon">Alueen kuvaus</span>
                <textarea name="forum_desc" class="form-control" style="width: 500px; height: 200px;" required><?php echo $data->target->get_description(); ?></textarea><br />
                </div>
                <button class="btn btn-lg " style="float:right !important;" type="submit">Lähetä</button>
            </form>
            <form style="margin: 15px;  margin-top: 0px; float: left;" action="admin.php?edit=<?php echo $data->target->get_id(); ?>&amp;remove=1" method="post">
                <button class="btn btn-lg " style="float:right !important;" type="submit">Poista alue</button>
            </form>
    </div>
<?php else: ?>
    <div class="navbar navbar-default">
        <h3 style="margin-left: 15px;">Uusi aihealue</h3>
            <form style="margin: 15px; margin-top: 0px; float: left;" action="admin.php?add" method="post">
                <div class="input-group">
                <span class="input-group-addon">Alueen nimi</span>
                <input name="forum_title" class="form-control" required placeholder="Alueen nimi" <?php if(isset($data->title)){ echo 'value = "' .  $data->title . '"'; }?>><br /></div>
                <div class="input-group">
                <span class="input-group-addon">ID</span>
                <input name="forum_id" class="form-control" required placeholder="ID"><br /></div>
                <div class="input-group">
                <span class="input-group-addon">Alueen kuvaus</span>
                <textarea name="forum_desc" class="form-control" style="width: 500px; height: 200px;" required placeholder="Aihealueen kuvaus"><?php if(isset($data->description)){ echo $data->description; }?></textarea><br />
                </div>
                <button class="btn btn-lg " style="float:right !important;" type="submit">Lähetä</button>
            </form>
    </div>  
<?php endif; ?>
</div>