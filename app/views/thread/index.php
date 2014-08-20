<div style='float:right; font-size:15px; font-weight:900'>
	Welcome <?php echo $_SESSION['username']; ?>
</div><br>
<div style='float:right; font-size:15px; font-weight:900'><a class="btn btn-medium btn-primary" name="logout" href="<?php eh(url('thread/logout'));?>">Logout</a></div>
<h1>All Threads</h1>
  <?php foreach ($threads as $v): ?>
  <li><a href="<?php eh(url('thread/view', array('thread_id' => $v->id))) ?>"><?php eh($v->title) ?></a></li>
  <?php endforeach ?>
</ul>
<a class="btn btn-medium btn-primary" href="<?php eh(url('thread/create')) ?>">Create</a>
</div>

