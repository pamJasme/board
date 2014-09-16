<div class="container-threads">
<ul class="nav nav-list">
    <li class="nav-header">Thread List</li>
        <?php foreach ($threads as $v): ?>
            <li><a href="<?php encode_quotes(url('comment/view', array('thread_id' => $v->id))) ?>">
                <?php encode_quotes($v->title);?>
            </a>
            </li>
        <?php endforeach ?>
</ul>
</div>
<div class="container-members">
<ul class="nav nav-list">
    <li class="nav-header">Members</li>
        <?php foreach ($members as $v): ?>
            <li><?php echo $v->username;?></li>
        <?php endforeach ?>
</ul>
</div>

<div class="container-hotthreads">
<ul class="nav nav-list">
    <li class="nav-header">Trending posts</li>
        <?php foreach ($trend_title as $v): ?>
            <li><a href="<?php encode_quotes(url('comment/view', array('thread_id' => $v['id']))) ?>">
                <?php encode_quotes($v['title']);?>
                <small style="font-style: italic; font-size: 10px;">
                    (<?php encode_quotes($v['count']);?> Posts)
                </small>
                </a>
            </li>
        <?php endforeach ?> 
    </li>
</ul>
</div>
</body>