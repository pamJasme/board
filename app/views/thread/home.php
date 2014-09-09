<div class="container-threads">
<ul class="nav nav-list">
    <li class="nav-header">Thread List</li>
        <?php foreach ($threads as $v): ?>
            <li><a href="<?php encode_quotes(url('comment/view', array('thread_id' => $v->id))) ?>">
                <?php encode_quotes($v->title);?>
            </li>
        <?php endforeach ?>
</ul>
</div>
<div class="container-members">
<ul class="nav nav-list">
    <li class="nav-header">Members</li>
        <?php foreach ($members as $v): ?>
            <li><?php encode_quotes($v->username);?></li>
        <?php endforeach ?>
</ul>
</div>

<div class="container-hotthreads">
<ul class="nav nav-list">
    <li class="nav-header">Trending posts</li>
        <?php foreach ($trend_title as $v): ?>
            <li><?php encode_quotes($v['title']);?></li>
        <?php endforeach ?>
</ul>
</div>
