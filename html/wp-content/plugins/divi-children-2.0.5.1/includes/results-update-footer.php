<?php
/*
 * Footer template installation or update results page
 */


?>

<div id="footer_updated" class="main-panel">
	
	<?php
	if ( ( ( $footer_update_action == 'install' ) OR ( $footer_update_action == 'update' ) ) AND $updated_footer ) {
		if ( $footer_update_action == 'install' ) {
				echo '<h3>' . __( 'Your new footer.php file was successfully created ', 'divi-children' ) . '</h3>';
			} elseif ( $footer_update_action == 'update' ) {
				echo '<h3>' . __( 'Your footer.php file was successfully updated', 'divi-children' ) . '</h3>';
		}
		} else {
			echo '<h3>' . __( 'Some error occurred when trying to update your footer.php', 'divi-children' ) . '</h3>';
	}

	if ( $footer_backup ) {
		echo '<div id="backup_files">';	
		echo '<p>' . __( 'A backup copy of your original child theme footer.php was made and saved within your child theme folder', 'divi-children' ) . ' (/' . $divichild_to_update . '/):</p>';
			echo '<ul class="bulleted">';
				echo '<li>';
					echo 'footer_backup.bak';
				echo '</li>';			
			echo '</ul>';			
		echo '</div>';
	}

	?>

	<p><a href="<?php echo admin_url( 'themes.php?page=divi-children-page' ); ?>" class="button-primary"><?php _e( 'Back to Divi Children main menu', 'divi-children' ); ?></a></p>
	
</div>
