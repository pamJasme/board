<div style='float:right; font-size:15px; font-weight:900'>
  Welcome <?php echo $_SESSION['username']; ?>
</div><br>

<div style='float:right; font-size:15px; font-weight:900'>
  <a class="btn btn-medium btn-primary" name="logout" href="<?php eh(url('thread/logout'));?>">Logout</a>
</div>

<h1><?php eh($thread->title); $user_name=$_SESSION['username'];?></h1>
<fieldset class='well' name="comment_area">
  <?php foreach ($comments as $k => $v): ?>
  
  <div class="comment">
    
    <div class="meta">
      <table  width='70%' border=0>
        <tr><td width='4%'><?php eh($k+1) ?></td><td width='25%'>From: <?php eh($v->username) ?>
        <br>Date: <?php eh($v->created) ?></td>
    </div>

      <div>
        <td width='48%'><?php eh($v->body) ?></td></tr>
      </table>
    </div>

  </div>

<?php endforeach ?>
</fieldset>
<hr>
<form class="well" method="post" action="<?php eh(url('thread/write')) ?>">
	<label>Your name</label>
  <input type="text" class="span2" name="username" value="<?php echo $user_name; ?>" disabled>
	<label>Comment</label>
	<textarea name="body"><?php eh(Param::get('body'))?></textarea>
	<br/>
  <input type="hidden" name="thread_id" value="<?php eh($thread->id) ?>">
  <input type="hidden" name="page_next" value="write_end">
   <div style="float:right; font-size:20px">&larr;Back to All <a href="index">Threads</a><br></div>
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
