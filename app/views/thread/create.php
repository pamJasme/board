<div style='float:right; font-size:15px; font-weight:900'><a class="btn btn-medium btn-primary" name="logout" href="<?php encode_quotes(url('thread/logout'));?>">Logout</a></div>

<h1>Create a thread</h1>
                
<?php if ($thread->hasError() || $comment->hasError()): ?>
<div class="alert alert-block">
                    
<h4 class="alert-heading">Validation error!</h4>
<?php if ($thread->validation_errors['title']['length']): ?>    
   <div><em>Title</em> must be between
     <?php encode_quotes($thread->validation['title']['length'][1]) ?> and
     <?php encode_quotes($thread->validation['title']['length'][2]) ?> characters in length.
    </div>
<?php endif ?>

<?php if ($comment->validation_errors['username']['length']): ?>                
   <div><em>Your name</em> must be between    
     <?php encode_quotes($comment->validation['username']['length'][1]) ?> and
     <?php encode_quotes($comment->validation['username']['length'][2]) ?> characters in length.
    </div>
<?php endif ?>
<?php if ($comment->validation_errors['body']['length']): ?>
   <div><em>Comment</em> must be between
     <?php encode_quotes($comment->validation['body']['length'][1]) ?> and
     <?php encode_quotes($comment->validation['body']['length'][2]) ?> characters in length.
    </div>
 <?php endif ?>
</div>
                
<?php endif ?>

                    
<form class="well" method="post" action="<?php encode_quotes(url('')) ?>">
  <label>Title</label>
  <input type="text" class="span2" name="title" value="<?php encode_quotes(Param::get('title')) ?>">
  <label>Your name</label>
  <input type="text" class="span2" name="username" value="<?php echo $username; ?>" disabled>
  <label>Comment</label>
  <textarea name="body"><?php encode_quotes(Param::get('body')) ?></textarea>
  <br />
  <input type="hidden" name="page_next" value="create_end">
   <div style="float:right; font-size:20px">&larr;Back to All <a href="index">Threads</a><br></div>
  <button type="submit" class="btn btn-primary">Submit</button>
</form> 
