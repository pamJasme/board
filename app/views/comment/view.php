<h1><?php encode_quotes($thread->title);?></h1>
<div style="background-color: BlanchedAlmond; height:350px;">
  <?php foreach ($comments as $k => $v): ?>
  <div class="comment">
    <div class="meta">
      <table  width='70%' border=0>
        <tr>
          <td width='4%'><?php encode_quotes($k+1); ?></td>
          

          <td width='25%'>From: <?php encode_quotes($v->username)?>
          <br>Date: <?php encode_quotes($v->created) ?></td>
    </div>
    <div>
          <td width='55%'><?php encode_quotes($v->body) ?></td>
          <td>
            <?php if ($v->user_id == $_SESSION['user_id']) :?>
            <input type="hidden" name="id" value="<?php encode_quotes($v->id) ?>">
          <a href="<?php encode_quotes(url('comment/update', array('id' => $v->id, 'task' => 'edit')))?>">
            <input type="button" class="btn btn-primary" value="Edit">
          </a>
          <a href="<?php encode_quotes(url('comment/update', array('id' => $v->id, 'task' => 'delete')))?>">
            <input type="button" class="btn btn-primary" value="Delete">
          </a>

        <?php endif ?>
          </td>       
        </tr>
      </table>
    </div>
  </div>
<?php endforeach ?>
</div>
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
   <div style="float:right; font-size:20px">&larr;<?php echo "<a href=\"javascript:history.go(-1)\">Back</a>"; ?></div>
  <button type="submit" class="btn btn-primary">Submit</button>
</form>
<div>


