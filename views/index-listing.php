<div class="navbar navbar-default">
    <div class="list-group">
        <h4 class="list-group-heading">Lukemattomat vastaukset</h4>
        <a href="viewtopic.php?id=3" class="list-group-item"><span class="badge">TODO</span>
            <h4 class="list-group-item-heading">Yleinen keskustelu &#0187; Lorem ipsum?</h4>
            <p class="list-group-item-text">Aenean vitae turpis a augue posuere adipiscing. Fusce dignissim a enim eu varius. Sed venenatis nunc libero, vel vehicula augue fringilla quis. Vivamus eu placerat mauris. Sed tempus tincidunt urna, at egestas est vestibulum eu. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Vestibulum id dictum nisl. Aliquam ut dui vitae nibh imperdiet cursus at sit amet mauris....</p>
        </a>
        <div class="list-group-item">
            <p>23.3.2014 17:08 - - <a href="user.html?id=350" class="navbar-link">JokuToinenKäyttäjä</a></p>
        </div>
    </div>
</div>

<div class="navbar navbar-default">
    <div class="list-group">
        <h4 class="list-group-heading">Viimeisimmät viestiketjut</h4>
        <?php foreach($data->topics as $topic): ?>
        <?php if(!$topic->is_hidden()): ?>
        <a href="viewtopic.php?id=<?php echo $topic->get_id(); ?>" class="list-group-item"><span class="badge">TODO</span>
            <h4 class="list-group-item-heading"><?php echo $topic->get_title(); ?></h4>
            <p class="list-group-item-text"><?php echo $topic->get_sent(); ?> - - <?php echo $topic->get_owner()->get_username(); ?></p>
        </a>
        <?php endif; ?>
        <?php endforeach; ?>
    </div>
</div>