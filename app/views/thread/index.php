<div class="container-">
<ul class="nav nav-list">
    <li class="nav-header">Thread List (<?php echo $row_count; ?>)</li>
        <?php foreach ($threads as $v): ?>
            <li><a href="<?php encode_quotes(url('comment/view', array('thread_id' => $v->id))) ?>">
                <?php encode_quotes($v->title); ?></a>
            </li>
        <?php endforeach ?>
</ul>
</div>
    
<a class="btn btn-mini btn-primary" href="<?php encode_quotes(url('thread/create')) ?>">Create</a><br><br>
<div class = "pagination pagination-centered">
    <ul>
        <li><?php echo $links; ?></li>
    </ul>
</div>


