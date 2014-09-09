<h2><?php encode_quotes($thread->title)?></h2>
<p class="alert alert-success">
    You successfully wrote this comment.
</p>

<a href="<?php encode_quotes(url('comment/view', array('thread_id' => $thread->id)))?>">
    &larr; Back to thread
</a>

