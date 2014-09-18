<h1><?php encode_quotes($thread->title);?></h1>
<div style="background-color: #F8ECDE; height:280px;">
  <?php if ($comments != 'none') { ?>
  <?php foreach ($comments as $k => $v): ?>
  <div class="comment">
    <div class="meta">
      <table  width='70%' border=0>
        <tr>
          <td width='25%'><small>From: <?php encode_quotes($v->username)?>
          <br>Date: <?php encode_quotes($v->created) ?></small></td>
    </div>
    <div>
          <td width='55%'><?php encode_quotes($v->body) ?></td>
          <td>
            <?php if ($v->user_id == $_SESSION['user_id']) :?>
            <input type="hidden" name="id" value="<?php encode_quotes($v->id) ?>">
          <a href="<?php encode_quotes(url('comment/update', array('id' => $v->id, 'task' => 'edit', 'thread_id' => $v->thread_id)))?>">
            <i class="icon-pencil"></i>
          </a></td><td>
          <a href="<?php encode_quotes(url('comment/update', array('id' => $v->id, 'task' => 'delete', 'thread_id' => $v->thread_id)))?>">
            <i class="icon-trash"></i>
          </a></td>
        <?php endif ?>
          </td>       
        </tr>
      </table>
    </div>
  </div>
<?php endforeach ?>
</div>
<?php } else { ?>
    <div class="alert alert-info">
      <h4>Info!</h4>
    There are no comments on this thread!
    </div>
    <?php } ?>
<div class = "pagination pagination-centered">
    <ul>
        <li><?php echo $links; ?></li>
    </ul>
</div>
<form class="well" method="post" action="<?php encode_quotes(url('thread/write')) ?>">
  <label>Your name</label>
  <input type="text" class="span2" name="username" value="<?php echo $_SESSION['username'] ?>" disabled>
  <label>Comment</label>
  <textarea name="body"><?php encode_quotes(Param::get('body'))?></textarea>
  <br/>
  <input type="hidden" name="thread_id" value="<?php encode_quotes($thread->id) ?>">
  <input type="hidden" name="page_next" value="write_end">
   <div style="float:right; font-size:20px">&larr;
    <a href="<?php encode_quotes(url('thread/index'))?>">
    Back</a></div>
  <button type="submit" class="btn btn-primary">Submit</button>
</form>
<div>


