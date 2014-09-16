<div class="navbar">
	<div class="navbar-inner">
	<form method="get" action="<?php encode_quotes(url('')) ?>">
		<ul class="nav">
			<li style="margin-top: 10px;">Filter by: &nbsp;</li>
			<li style="margin-top: 10px">Category&nbsp;</li>
			<li>
				<select name="filter_threads" style="height:25px; width:100px; margin-top:6px">
					<option <?php if (Param::get('filter_threads') == Thread::DEFAULT_OPTION_ALL) echo "selected='selected'"; ?>
						value="0">All</option>
					<option <?php if (Param::get('filter_threads') == Thread::CATEGORY_JOB) echo "selected='selected'"; ?>
						value="1">Job</option>
					<option <?php if (Param::get('filter_threads') == Thread::CATEGORY_LOVE) echo "selected='selected'"; ?>
						value="2">Love</option>
					<option <?php if (Param::get('filter_threads') == Thread::CATEGORY_OTHERS) echo "selected='selected'"; ?>
						value="3">Others</option>
				</select>
			</li>
			<li style="margin-top: 10px">&nbsp;Date&nbsp;</li>
			<li>
				<select name="date" style="height:25px; width:150px; margin-top:6px">
					<option <?php if (Param::get('date') == Thread::DEFAULT_OPTION_ALL) echo "selected='selected'"; ?>
						value="0">All</option>
					<option <?php if (Param::get('date') == Thread::DATE_FILTER_YESTERDAY) echo "selected='selected'"; ?>
						value="1">1 day from NOW</option>
					<option <?php if (Param::get('date') == Thread::DATE_FILTER_ONE_WEEK) echo "selected='selected'"; ?>
						value="5">5 days from NOW</option>
					<option <?php if (Param::get('date') == Thread::DATE_FILTER_ONE_MONTH) echo "selected='selected'"; ?>
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
<div style="background-color: BlanchedAlmond; height:300px">
<center>
<ul class="nav nav-list">
    <li class="nav-header">Thread List (<?php echo $row_count; ?>)</li>
        <?php foreach ($threads as $v): ?>
            <li><a href="<?php encode_quotes(url('comment/view', array('thread_id' => $v->id))) ?>">
            	<?php encode_quotes($v->title);?>
            	(<?php encode_quotes($v->count);?> Posts)</a>
            	<div style="font-size: 10px; font-style: italic;">
            		&nbsp;&nbsp;By <b><?php encode_quotes($v->username);?></b>
            		<?php encode_quotes($v->created);?>
            	</div>
            	
            </li>
        <?php endforeach ?>
</center>
</div>
<center><a class="btn btn-medium btn-primary" href="<?php encode_quotes(url('thread/create')) ?>">Create</a>
</center>
<div class = "pagination pagination-centered">
    <ul>
        <li><?php echo $links; ?></li>
    </ul>
</div>