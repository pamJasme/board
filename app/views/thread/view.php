<h1><?php eh($thread->title); $user_name=$_SESSION['username'];?></h1>

<?php foreach ($comments as $k => $v): ?>
<div class="comment">
  <div class="meta">
    <?php eh($k + 1) ?>: <?php eh($v->username) ?> <?php eh($v->created) ?>
  </div>
  <div>
    <?php eh($v->body) ?>
  </div>
</div>
<?php endforeach ?>

<hr>
<form class="well" method="post" action="<?php eh(url('thread/write')) ?>">
	<label>Your name</label>
  <input type="text" class="span2" name="username" value="<?php echo $user_name; ?>" disabled>
	<label>Comment</label>
	<textarea name="body"><?php eh(Param::get('body'))?></textarea>
	<br/>
  <input type="hidden" name="thread_id" value="<?php eh($thread->id) ?>">
  <input type="hidden" name="page_next" value="write_end">
  <button type="submit" class="btn btn-primary">Submit</button>
</form>
<div>
  <?php 
    error_reporting(E_ALL ^ E_NOTICE);//still looking for alternatives.
    if(is_null($v->body))
    {
        //code
    }
    else
    {
      echo readable_text($v->body);
    }
    ?>
</div>
