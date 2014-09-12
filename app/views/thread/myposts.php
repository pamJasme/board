<div class="container-threads">
    <table border=1><tr>
        <?php foreach ($own_threads as $v => $value): ?>
            <td><?php encode_quotes($value->title)?></td>
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
</div>