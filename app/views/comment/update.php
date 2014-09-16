<form method = "post" action = "<?php encode_quotes(url('')) ?>">
	Change to: 
	<input type = "hidden" name = "id" value="<?php encode_quotes(Param::get('id')) ?>">
	<input type = "text" name = "body"><br>
	<input type = "submit" value = "Change">
</form>
<?php echo $status ?>
