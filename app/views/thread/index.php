<fieldset class='well'>
    <div style='float:right; font-size:15px; font-weight:900'>
        Welcome <?php echo $_SESSION['username']; ?>
    </div><br>

    <div style='float:right; font-size:15px; font-weight:900'>
        <a class="btn btn-medium btn-primary" name="logout" href="<?php encode_quotes(url('thread/logout'));?>">
            Logout
        </a>
    </div>

        <h1>All Threads</h1>
        <?php foreach ($threads as $v): ?>
            <li><a href="<?php encode_quotes(url('comment/view', array('thread_id' => $v->id))) ?>">
                <?php encode_quotes($v->title) ?></a></li>
        <?php endforeach ?>
        </ul><br>

        <a class="btn btn-medium btn-primary" href="<?php encode_quotes(url('thread/create')) ?>">Create</a><br><br>
        <?php echo $pagination['control']; ?>
    </div>
</fieldset>


