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
  <label>Category</label>
    <select class="span2" name="select">
      <option selected="selected" value="none"></option>
      <option value="1">Job</option>
      <option value="2">Love</option>
      <option value="3">Others</option>
    </select> 
  <br />
  <input type="hidden" name="page_next" value="create_end">
  <div style="float:right; font-size:20px">&larr;<?php echo "<a href=\"javascript:history.go(-1)\">Back</a>"; ?></div>
  <button type="submit" class="btn btn-primary">Submit</button>
</form> 


