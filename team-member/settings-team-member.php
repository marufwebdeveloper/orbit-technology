<?php
	if(isset($_POST['ss00_save_settings'])){
		$success = update_option('ss00_team_member_settings',[
			'post_type_name' => $_POST['ss00_post_type_name'],
			'post_type_url' => $_POST['ss00_post_type_url'],
			'taxonomy_name' => $_POST['ss00_taxonomy_name'],
			'taxonomy_url' => $_POST['ss00_taxonomy_url']
		]);

		//flush_rewrite_rules();

		echo "<script>window.location.href='".admin_url('edit.php?post_type='.ss00_settings('post_type_url').'&page=team-member-settings')."'</script>";
	}


	$settings = get_option('ss00_team_member_settings');
?>


<div class="wrap">
	<form method="post">
		<div>
			<p style="margin:0">Post Type Name</p>
			<input type="text" name="ss00_post_type_name" value="<?php echo  $settings['post_type_name']??''; ?>">
		</div>
		<div>
			<p style="margin:0">Post Type URL</p>
			<input type="text" name="ss00_post_type_url" value="<?php echo  $settings['post_type_url']??''; ?>">
		</div>
		<div>
			<p style="margin:0">Taxonomy Name</p>
			<input type="text" name="ss00_taxonomy_name" value="<?php echo  $settings['taxonomy_name']??''; ?>">
		</div>
		
		<div>
			<p style="margin:0">Taxonomy URL</p>
			<input type="text" name="ss00_taxonomy_url" value="<?php echo  $settings['taxonomy_url']??''; ?>">
		</div>
		
		<div style="margin-top:20px">
			<button name="ss00_save_settings">Save Settings</button>
		</div>
		
	</form>

	<p><b>NB::When you change post type then you have to just update <a href='<?php echo admin_url('options-permalink.php'); ?>'>permalink</a>.</b><p>

</div>