<?php
/*
 * Generates or updates the footer.php file for any existing child theme from your installed version of Divi to fit the latest version of the Divi Children Engine
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
		<h3><?php _e( 'Create or update the footer.php template file for any of your existing Divi child themes', 'divi-children' ); ?></h3>
		
		<p><em><?php _e( '(You do not need to use this feature if you have just created a child theme using this plugin, an updated footer.php file was already created in that case)', 'divi-children' ); ?></em></p>

		
		<?php
		if ( ! empty( $check_footer_error )) {
			?>
			<div class="error"><?php echo $check_footer_error; ?></div>
			<?php
		}
		?>		
		<form action="<?php echo admin_url( 'themes.php?page=divi-children-page' ); ?>" method="post" id="update_footer_form">


						<label for="divichild_to_check_footer">
							<?php _e( 'Select child theme:', 'divi-children' ) ?>
						</label>

						<select name="divichild_to_check_footer" >
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
		<p class="dch_info"><?php _e( 'Thanks to this feature, you can keep your footer template always updated to both the newest release of the Divi Children Engine and the Divi version you have installed in this site. This works not just for child themes created by a previous version of Divi Children, but even for Divi child themes you created manually.', 'divi-children' ); ?></p>

		<p class="dch_info"><?php _e( 'The new footer template file will be generated from your installed version of Divi and will include a footer credit line customizable by the Divi Children Engine via the WordPress Customizer.', 'divi-children' ); ?></p>

		<?php
}
									
?>