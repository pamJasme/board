<center><div style="background-color: #F8ECDE; height:200px; width:450px"><br>
<form method="post" action="<?php encode_quotes(url('')) ?>">
	<table>
	<tr><td>New username</td><td><input type="text" name="username" placeholder="5-12 characters"></td></tr>
	<tr><td>New password</td><td><input type="password" name="password" placeholder="5-12 characters"></td></tr>
	<tr><td>Confirm password</td><td><input type="password" name="match_password" placeholder="5-12 characters"></td></tr>
	</table>
	<input type="submit" value="Save">
</form>
</div><br>
<div class="alert alert-info">
<i class="icon-exclamation-sign"></i> Page will be redirected to <b>Login Page</b> after every changes.
</div>
<?php echo $status ?>
</center>
