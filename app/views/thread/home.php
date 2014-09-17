<div>

</div>

<div style="background-color: BlanchedAlmond; height:300px; ">
<ul class="nav nav-list">
    <li class="nav-header">Timeline (For comments)</li>
        <?php foreach ($comments as $v): ?>
            <li><a href="<?php encode_quotes(url('comment/view', array('thread_id' => $v['id']))) ?>">
                "<?php encode_quotes($v['body']);?>"<br>  </a>
                <small style="font-style: italic"> 
                    <b><?php encode_quotes($v['username']);?></b> commented on a thread
                <b><?php encode_quotes($v['title']);?></b></small>
            </li>
        <?php endforeach ?>
</ul>
</div>
<div class = "pagination pagination-centered">
    <ul>
        <li><?php echo $links; ?></li>
    </ul>
</div>
<div style="background-color: BlanchedAlmond; height:300px; width: 450px; float: right ">
<ul class="nav nav-list">
    <li class="nav-header">Members</li>
        <?php foreach ($members as $v): ?>
            <li><?php echo $v->username;?></li>
        <?php endforeach ?>
</ul>
</div>

<div style="background-color: BlanchedAlmond; height:300px; width: 450px; float: left ">
<ul class="nav nav-list">
    <li class="nav-header">Trending posts</li>
        <?php foreach ($top_threads as $v): ?>
            <li><a href="<?php encode_quotes(url('comment/view', array('thread_id' => $v->id))) ?>">
                <?php encode_quotes($v->title);?>
                <small style="font-style: italic; font-size: 10px;">
                    (<?php encode_quotes($v->comment_count);?> Posts)
                </small>
                </a>
            </li>
        <?php endforeach ?> 
    </li>
</ul>
</div>
</body>