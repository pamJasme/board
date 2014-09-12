<div class="navbar">
	<div class="navbar-inner">
	<form method="get" action="<?php encode_quotes(url('')) ?>">
		<ul class="nav">
			<li style="margin-top: 10px;">Filter by: &nbsp;</li>
			<li style="margin-top: 10px">Category&nbsp;</li>
			<li>
				<select name="filter" style="height:25px; width:100px; margin-top:6px">
					<option value="0">All</option>
					<option value="1">Job</option>
					<option value="2">Love</option>
					<option value="3">Others</option>
				</select>
			</li>
			<li style="margin-top: 10px">&nbsp;Date&nbsp;</li>
			<li>
				<select name="date" style="height:25px; width:100px; margin-top:6px">
					<option selected="0" value="ALL">All</option>
					<option value="1">1 day from NOW</option>
					<option value="5">5 days from NOW</option>
					<option value="10">10 days from NOW</option>
					<option value="30">1 month from NOW</option>
				</select>
			</li>
			<li>&nbsp;&nbsp;</li>
			<li style="margin-top:5px;">
				<input text="text" name="search" placeholder="Search threads 'keyword'"></input>
			</li>
			<li>&nbsp;&nbsp;</li>
			<li style="margin-top:5px"><input type="submit" value="Filter/Search"></li>
			</form>
		</ul>
	</div>
</div>
 
<div class="container-threads">   
<ul class="nav nav-list">
    <li class="nav-header">Thread List (<?php echo $row_count; ?>)</li>
        <?php foreach ($threads as $v): ?>
            <li><a href="<?php encode_quotes(url('comment/view', array('thread_id' => $v->id))) ?>">
            	<?php encode_quotes($v->title);?><br>
            	<div style="font-size: 10px; font-style: italic;">
            		&nbsp;&nbsp;By <?php encode_quotes($v->user);?>
            		<?php encode_quotes($v->created);?>
            	</div>
            	</a>
            </li>
        <?php endforeach ?>
        <a class="btn btn-medium btn-primary" href="<?php encode_quotes(url('thread/create')) ?>">Create</a><br><br>
        <div class = "pagination pagination-centered">
    <ul>
        <li><?php echo $links; ?></li>
    </ul>
</div>
</div>

<div class="container-hotthreads">
<ul class="nav nav-list">
    <li class="nav-header">Trending posts</li>
        <?php foreach ($trend_title as $v): ?>
            <li><a href="<?php encode_quotes(url('comment/view', array('thread_id' => $v['id']))) ?>">
            	<?php encode_quotes($v['title']);?>
            	<small style="font-style: italic; font-size: 10px;">
            		(<?php encode_quotes($v['count']);?> Posts)
            	</small>
            	</a>
            </li>
        <?php endforeach ?> 
    </li>
</ul>
</div>

