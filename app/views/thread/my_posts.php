<div style="background-color: BlanchedAlmond; height:400px; width: 450px; float:left ">
    <table border=0><tr>
        <?php foreach ($own_threads as $v => $value): ?>
            <td style="font-style: italic" width=100px><small>Thread Title</small></td>
            <td width=150px>
                <a href="<?php encode_quotes(url('comment/view', array('thread_id' => $value->id))) ?>">
                    <?php encode_quotes($value->title)?></td>
                </a>
            <td width=35px>
                <a href="<?php encode_quotes(url('thread/update', array('id' => $value->id, 'task' => 'edit')));?>">
                    <i class="icon-pencil"></i>
                </a>
            </td>
            <td>
                <a href="<?php encode_quotes(url('thread/update', array('id' => $value->id, 'task' => 'delete')));?>">
                    <i class="icon-trash"></i>
                </a>
            </td>
        </tr>
        <?php endforeach ?>
    </table>
    <a href="<?php encode_quotes(url('thread/create')) ?>">
        <input class="btn btn-alert" type="button" value="Create">
    </a>
</div>
<div style="background-color: BlanchedAlmond; height:600px; width: 450px; float:right ">
    <span style="font-style:italic; font-color: gray">Your latest activities:</span><br><br>
<?php foreach ($own_comments as $v): ?>
            <a href="<?php encode_quotes(url('comment/view', array('thread_id' => $v->id))) ?>">
                "<?php encode_quotes($v->body);?>"<br>  </a>
                <small style="font-style: italic"> 
                    <b>You</b>  commented on thread
                <b><?php encode_quotes($v->title);?></b></small><br>
        <?php endforeach ?>
</div>
