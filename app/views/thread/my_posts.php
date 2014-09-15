<div class="container-threads">
    <table border=0><tr>
        <?php foreach ($own_threads as $v => $value): ?>
            <td style="font-style: italic" width=100px><small>Thread Title</small></td>
            <td width=150px>
                <a href="<?php encode_quotes(url('comment/view', array('thread_id' => $value->id))) ?>">
                    <?php encode_quotes($value->title)?></td>
                </a>
            <td>
                <a href="<?php encode_quotes(url('thread/update', array('id' => $value->id, 'task' => 'edit')));?>">
                    <input type="button" class ="btn btn-primary" value="Edit">
                </a>
            </td>
            <td>
                <a href="<?php encode_quotes(url('thread/update', array('id' => $value->id, 'task' => 'delete')));?>">
                    <input type="button" class ="btn btn-primary" value="Delete">
                </a>
            </td>
        </tr>
        <?php endforeach ?>
    </table>
    <a href="<?php encode_quotes(url('thread/create')) ?>">
        <input class="btn btn-alert" type="button" value="Create">
    </a>
</div>