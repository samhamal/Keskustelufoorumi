<div class="navbar navbar-default">
    <div class="list-group">
        <h4 class="list-group-heading"><a href="viewforum.php?id=<?php echo $data->forum->get_id(); ?>" class="navbar-link"><?php echo $data->forum->get_name(); ?></a> &#0187; <a href="viewtopic.php?id=<?php echo $data->topic->get_id(); ?>" class="navbar-link"><?php if(!$data->topic->is_hidden()): ?><?php echo $data->topic->get_title(); ?><?php endif; ?></a></h4>
        <a class="list-group-item">
            <p class="list-group-item-msgbody"><?php if(!$data->topic->is_hidden()): ?><?php echo $data->topic->get_body(); ?><?php endif; ?></p>

        </a>
        <div class="list-group-item">
            <?php if(!$data->topic->is_hidden()): ?>
            <p><?php echo $data->topic->get_sent(); ?> - - <a href="user.php?id=<?php echo $data->topic->get_owner()->get_id(); ?>" class="navbar-link"><?php echo $data->topic->get_owner()->get_username(); ?></a><br/>
                <?php if($data->current_user->is_admin() || $data->current_user->get_id() == $data->topic->get_owner()->get_id()): ?>
                <a href="message_edit.php?topic=<?php echo $data->topic->get_id(); ?>&amp;edit=<?php echo $data->topic->get_id(); ?>" class="navbar-link">muokkaa</a>
                <?php endif; ?>
            </p>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php
    foreach($data->replies as $reply): ?>
    <div class="navbar navbar-default navbar-reply">
        <div class="list-group">
            <a class="list-group-item">
                <p class="list-group-item list-group-item-msgbody"><?php if(!$reply->is_hidden()): ?> <?php echo $reply->get_body(); ?> <?php endif; ?></p>
            </a>
            <div class="list-group-item">
                <p><?php if(!$reply->is_hidden()): ?><?php echo $reply->get_sent(); ?> - - <a href="user.php?id=<?php echo $reply->get_owner()->get_id(); ?>" class="navbar-link"><?php echo $reply->get_owner()->get_username(); ?></a><br/>
                    <?php if($data->current_user->is_admin() || $data->current_user->get_id() == $reply->get_owner()->get_id()): ?>
                        <a href="message_edit.php?topic=<?php echo $data->topic->get_id(); ?>&amp;edit=<?php echo $reply->get_id(); ?>" class="navbar-link">muokkaa</a>
                    <?php endif; ?>
                        <?php endif; ?>
                </p>
            </div>
        </div>
    </div>
<?php endforeach; ?>
    
    <div class="navbar navbar-default navbar-reply">
        <form style="margin: 15px; float: left;" action="message_reply.php?topic=<?php echo $data->topic->get_id(); ?>&amp;parent=<?php echo $data->topic->get_id(); ?>" method="post">
            <textarea name="reply" style="width: 500px; height: 200px;" required></textarea><br />
            <button class="btn btn-lg" style="float:right !important;" type="submit">Lähetä</button>
        </form>
    </div>
<!--
    <div class="navbar navbar-default navbar-reply">
        <div class="list-group">
            <a href="#" class="list-group-item">
                <p class="list-group-item-msgbody">Morbi auctor molestie facilisis. Donec ac tempor elit. Aliquam erat volutpat. Suspendisse congue sit amet quam dignissim accumsan. Proin eu auctor nibh. Integer metus justo, congue vel nisl eu, viverra congue nunc. Cras mi elit, mattis vel volutpat non, fringilla vitae ligula. Morbi in elit gravida, interdum leo nec, euismod leo. Vestibulum tempus quis mi in ullamcorper. Vestibulum auctor est sit amet tellus tincidunt suscipit. Curabitur volutpat, felis ut feugiat hendrerit, urna turpis ultrices tortor, fermentum tincidunt augue lacus non enim. Duis id orci et lectus semper aliquet id nec ipsum. Ut consequat egestas urna eget malesuada. </p>
            </a>
            <div class="list-group-item">
                <p>23.3.2014 17:05 - - <a href="user.php?id=350" class="navbar-link">JokuKäyttäjä</a>
                    <a href="#reply" class="navbar-link navbar-right">vastaa</a>
                </p>
            </div>
        </div>
        <div class="navbar navbar-default navbar-reply">
            <div class="list-group">
                <a href="#" class="list-group-item">
                    <p class="list-group-item-msgbody">Aenean vitae turpis a augue posuere adipiscing. Fusce dignissim a enim eu varius. Sed venenatis nunc libero, vel vehicula augue fringilla quis. Vivamus eu placerat mauris. Sed tempus tincidunt urna, at egestas est vestibulum eu. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Vestibulum id dictum nisl. Aliquam ut dui vitae nibh imperdiet cursus at sit amet mauris. Fusce venenatis tincidunt fermentum. Maecenas ac rutrum purus, quis dictum odio. Duis turpis felis, iaculis at quam quis, posuere cursus ipsum. Donec vestibulum tempor ullamcorper. Vestibulum ornare, sapien sit amet dapibus elementum, purus sapien tincidunt tellus, adipiscing ornare mi erat vitae dui.  </p>
                </a>
                <div class="list-group-item">
                    <p>23.3.2014 17:08 - - <a href="user.php?id=350" class="navbar-link">JokuToinenKäyttäjä</a>
                        <a href="#reply" class="navbar-link navbar-right">vastaa</a>
                    </p>
                </div>
            </div>
        </div>
    </div>-->


