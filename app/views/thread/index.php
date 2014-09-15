<div class="navbar">
	<div class="navbar-inner">
	<form method="get" action="<?php encode_quotes(url('')) ?>">
		<ul class="nav">
			<li style="margin-top: 10px;">Filter by: &nbsp;</li>
			<li style="margin-top: 10px">Category&nbsp;</li>
			<li>
				<select name="filter_threads" style="height:25px; width:100px; margin-top:6px">
					<option <?php if (Param::get('filter_threads') == 0) echo "selected='selected'"; ?>
						value="0">All</option>
					<option <?php if (Param::get('filter_threads') == 1) echo "selected='selected'"; ?>
						value="1">Job</option>
					<option <?php if (Param::get('filter_threads') == 2) echo "selected='selected'"; ?>
						value="2">Love</option>
					<option <?php if (Param::get('filter_threads') == 3) echo "selected='selected'"; ?>
						value="3">Others</option>
				</select>
			</li>
			<li style="margin-top: 10px">&nbsp;Date&nbsp;</li>
			<li>
				<select name="date" style="height:25px; width:150px; margin-top:6px">
					<option <?php if (Param::get('date') == 0) echo "selected='selected'"; ?>
						value="0">All</option>
					<option <?php if (Param::get('date') == 1) echo "selected='selected'"; ?>
						value="1">1 day from NOW</option>
					<option <?php if (Param::get('date') == 5) echo "selected='selected'"; ?>
						value="5">5 days from NOW</option>
					<option <?php if (Param::get('date') == 10) echo "selected='selected'"; ?>
						value="10">10 days from NOW</option>
					<option <?php if (Param::get('date') == 30) echo "selected='selected'"; ?>
						value="30">1 month from NOW</option>
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
            		&nbsp;&nbsp;By <?php encode_quotes($v->username);?>
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

