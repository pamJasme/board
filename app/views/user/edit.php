<form method="post" action="<?php encode_quotes(url('')) ?>">
	<table>
	<tr><td>New username</td><td><input type="text" name="username" placeholder="5-12 characters"></td></tr>
	<tr><td>New password</td><td><input type="password" name="password" placeholder="5-12 characters"></td></tr>
	<tr><td>Confirm password</td><td><input type="password" name="match_password" placeholder="5-12 characters"></td></tr>
	</table>
	<input type="submit" value="Save">
</form>
<div style="background-color: BlanchedAlmond; height:25px;">
<i class="icon-exclamation-sign"></i> The page will be redirected to Login Page after every changes.
</div>
<?php echo $status ?>
