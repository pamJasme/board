<div class="container-threads">
<form method="post" action="<?php encode_quotes(url('thread/update'))?>">
    Thread:
    <select name="othreads">
        <?php foreach ($own_threads as $v => $value): ?>
            <option value="<?php echo $value->id ?>"><?php echo $value->title ?></option>
        <?php endforeach ?>
    </select><br>
    New title:    
        <input type="text" name="new_title"><br>
    Delete
        <input type="checkbox" name="delete" value="0"><br>
        <input type="submit" value="change">
        <div class="container-threads">
    </div>
</form>
</div>

<div class="container-threads">
<form method="post" action="<?php encode_quotes(url('comment/update'))?>">
        <?php foreach ($merge as $v => $value): ?>
            <li><?php echo $value['title'] ?><br>
                Comment: <?php echo $value['body'] ?></li>
        <?php endforeach ?>
</form>
    </div>
    