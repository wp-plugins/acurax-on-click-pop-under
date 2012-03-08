<?php 
	if($_POST['acurax_popunder_hidden'] == 'Y') {
		//Form data sent
		$acurax_popunder_url = $_POST['acurax_popunder_url'];
		update_option('acurax_popunder_url', $acurax_popunder_url);
		$acurax_time_out = $_POST['acurax_popunder_timeout'];
		update_option('acurax_popunder_timeout', $acurax_time_out);
		
		?>
		<div class="updated"><p><strong><?php _e('Acurax Popunder Settings Saved!.' ); ?></strong></p></div>
		<?php
	} else {
		//Normal page display
		$acurax_popunder_url = get_option('acurax_popunder_url');
		$acurax_time_out = "60";
	}
?>

<div class="wrap">
<?php    echo "<h2>" . __( 'Acurax Popunder Options', 'acx_popunder_config' ) . "</h2>"; ?>

<form name="acurax_popunder_form" method="post" action="<?php echo str_replace( '%7E', '~', $_SERVER['REQUEST_URI']); ?>">
	<input type="hidden" name="acurax_popunder_hidden" value="Y">
	<?php    echo "<h4>" . __( 'Popunder Settings', 'acx_popunder_config' ) . "</h4>"; ?>
	<p><?php _e("Popunder URL: " ); ?><input type="text" name="acurax_popunder_url" value="<?php echo $acurax_popunder_url; ?>" size="20"><?php _e(" ex: <a href='http://www.acurax.com' target='_blank'>http://www.acurax.com</a>" ); ?></p>
	<hr />
	
	<p><?php _e("Popunder Cookie Expire Timeout: " ); ?><input type="text" name="acurax_popunder_timeout" value="<?php echo $acurax_time_out; ?>" size="20"><?php _e("<b>Minutes</b>. Needs to Define in Minutes, For Eg: '60' for 1 Hour" ); ?></p>
	<hr />
	
	
	<p class="submit">
	<input type="submit" name="Submit" value="<?php _e('Update Acurax Popunder Options', 'acx_popunder_config' ) ?>" />
	</p>
</form>
</div>