<?php
/*
 * Update an existing child theme to the latest version of the Divi Children Engine
 */


$divi_childs = new DiviChildTheme;
$divi_childs = $divi_childs->get_divi_childs();

if ( ! $divi_childs ){
		?>
		<h3><?php _e( 'No Divi child theme found.', 'divi-children' ); ?></h3>
		<p><?php _e( 'You need to create a Divi child theme before you can update it.', 'divi-children' ); ?></p>
		<p><a href="#create-child" class="button-primary" ><?php _e( 'Create a Divi Child Theme', 'divi-children' ); ?></a></p>
		<?php
	} else {
		?>
		<h3><?php _e( 'Update any existing Divi child theme to the latest version of the Divi Children Engine', 'divi-children' ); ?></h3>

		<p><?php _e( 'Check if your existing child themes have the latest customization functionalities provided by the newest version of the Divi Children Engine.', 'divi-children' ); ?></p>
		
		<?php
		if ( ! empty( $check_child_error )) {
			?>
			<div class="error"><?php echo $check_child_error; ?></div>
			<?php
		}
		?>		
		<form action="<?php echo admin_url( 'themes.php?page=divi-children-page' ); ?>" method="post" id="update_child_form">


						<label for="divichild_to_check">
							<?php _e( 'Select child theme:', 'divi-children' ) ?>
						</label>

						<select name="divichild_to_check" >
							<?php
							foreach ( $divi_childs as $divi_child ) {
								echo '<option value="' . $divi_child . '">' . $divi_child . '</option>';
							}
							?>
						</select>
						
						<span class="submit">
							<input type="submit" class="button" value="<?php _e( 'Check Update Status', 'divi-children' ); ?>" />						
						</span>			
			
		</form>
		<p class="dch_info"><?php _e( 'Thanks to this feature, you can keep your child themes always updated to the newest release of the Divi Children Engine. This works not just for child themes created by a previous version of Divi Children, but even for Divi child themes you created manually. Some of your files, like your stylesheet or functions.php, may need to be updated by the plugin.', 'divi-children' ); ?></p>		
		<?php
}
									
?>