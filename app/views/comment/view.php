<div style='float:right; font-size:15px; font-weight:900'>
  Welcome <?php echo $_SESSION['username']; $count=0; ?>
</div><br>

<div style='float:right; font-size:15px; font-weight:900'>
  <a class="btn btn-medium btn-primary" name="logout" href="<?php encode_quotes(url('thread/logout'));?>">Logout</a>
</div>

<h1><?php encode_quotes($thread->title);?></h1>
<fieldset class='well' name="comment_area">
  <?php foreach ($comments as $k => $v): ?>
  
  <div class="comment">
    
    <div class="meta">
      <table  width='70%' border=0>
        <tr><td width='4%'><?php encode_quotes($k+1); $count++; ?></td><td width='25%'>From: <?php encode_quotes($v->username) ?>
        <br>Date: <?php encode_quotes($v->created) ?></td>
    </div>

      <div>
        <td width='48%'><?php encode_quotes($v->body) ?></td></tr>
      </table>
    </div>

  </div>

<?php endforeach ?>


<hr>
<form class="well" method="post" action="<?php encode_quotes(url('thread/write')) ?>">
  <label>Your name</label>
  <input type="text" class="span2" name="username" value="<?php echo $user_name; ?>" disabled>
  <label>Comment</label>
  <textarea name="body"><?php encode_quotes(Param::get('body'))?></textarea>
  <br/>
  <input type="hidden" name="thread_id" value="<?php encode_quotes($thread->id) ?>">
  <input type="hidden" name="page_next" value="write_end">
   <div style="float:right; font-size:20px">&larr;Back to All <a href="<?php encode_quotes(url('thread/index')); ?>">Threads</a><br></div>
  <button type="submit" class="btn btn-primary">Submit</button>
</form>
<div>
