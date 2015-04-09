<?php
/*
 * Update footer check results
 */
 
$Divi_parent_data = get_theme_data( get_theme_root() . '/Divi/style.css' );
$Divi_parent_version = $Divi_parent_data['Version'];
if ( !$has_engine ) {
	$footer_check = 'no_engine';
	} elseif ( $has_footer ) {
		if ( $footer_engined ) {
			$footer_check = 'ok';
		} else {
			$footer_check = 'not_engined';
		}
	} else {
		$footer_check = 'no_footer';
}
?>

<div id="update_footer" class="main-panel">

	<?php
	if ( $check_footer == 'no_engine' ) {
			$update_button = false;
			$footer_update_action = false;
			echo '<h3>' . __( 'Divi Children Engine is not installed in your child theme', 'divi-children' ) . '</h3>';	
			echo '<p>' . __( 'A footer.php created by this plugin file would not work properly if Divi Children Engine is missing.', 'divi-children' ) . '</p>';
			echo '<p><em>' . __( 'Please install Divi Children Engine in this child theme before creating your footer template file.', 'divi-children' ) . '</em></p>';
		} elseif ( $check_footer == 'ok' ) {
			$update_button = __( 'Update file', 'divi-children' );
			$footer_update_action = 'update';
			$choose = true;			
			echo '<h3>' . __( 'The footer.php file already present in your child theme supports the Divi Children Engine', 'divi-children' ) . '</h3>';	
			echo '<p>' . __( 'You can choose whether to keep your footer.php file as it is or to create a new one from the current Divi version you have installed in this site', 'divi-children' ) . ' (Divi ' . $Divi_parent_version . ').</p>';
		} elseif ( $check_footer == 'not_engined' ) {
			$update_button = __( 'Create a new file', 'divi-children' );
			$footer_update_action = 'update';
			echo '<h3>' . __( 'The footer.php file already present in your child theme does not support the Divi Children Engine', 'divi-children' ) . '</h3>';
			echo '<p>' . __( 'Go ahead and create a footer.php file compatible with Divi Children Engine!', 'divi-children' ) . '</p>';
			echo '<p class="dch_warning">' . __( 'If your footer.php includes modifications you made to your footer template, you will need to manually add those tweakings  to the new footer.php that will be created by the plugin. Use the backup copy that will be saved as footer_backup.bak in your child theme folder to copy from it whatever code you need in order to preserve your modifications.', 'divi-children' ) . '</p>';
		} elseif ( $check_footer == 'no_footer' ) {
			$update_button = __( 'Create file', 'divi-children' );
			$footer_update_action = 'install';
			echo '<h3>' . __( 'Your child theme does not have a footer.php file', 'divi-children' ) . '</h3>';
			echo '<p>' . __( 'Go ahead and create a footer.php file compatible with Divi Children Engine!', 'divi-children' ) . '</p>';
	}

	$update_footer = $divichild_to_check_footer . ',' . $footer_update_action;

	if ( $update_button ) {

			if ( ! empty( $check_footer_error )) {
				?>
				<div class="error"><?php echo $check_footer_error; ?></div>
				<?php
			}

			?>		
			<form action="<?php echo admin_url( 'themes.php?page=divi-children-page' ); ?>" method="post" id="update_footer">
			
				<input type="text" style="display:none;" name="update_footer" value="<?php echo $update_footer; ?>" />
				
				<p class="submit">
					<input type="submit" class="button-primary" value="<?php echo $update_button; ?>" />						
				</p>
				
			</form>
			<?php		
			
			if ( $choose ) {
				echo '<p class="dch_info">' . __( 'Thanks to this feature, you can keep your footer template always updated to both the newest release of the Divi Children Engine and the Divi version you have installed in this site. If your existing footer.php was created or updated for a Divi version older than', 'divi-children' ) . ' ' . $Divi_parent_version . ', ' . __( 'then go ahead and update this file.', 'divi-children' ) . '</p>';		
				echo '<p class="dch_warning">' . __( 'If your footer.php includes modifications you made to your footer template, you will need to manually add those tweakings  to the new footer.php that will be created by the plugin. Use the backup copy that will be saved as footer_backup.bak in your child theme folder to copy from it whatever code you need in order to preserve your modifications.', 'divi-children' ) . '</p>';		
				?>
				<p><a href="<?php echo admin_url( 'themes.php?page=divi-children-page' ); ?>" class="button"><?php _e( 'Back to Divi Children main menu', 'divi-children' ); ?></a></p>
				<?php
				
			}
		
		} else {
			?>
			<p><a href="<?php echo admin_url( 'themes.php?page=divi-children-page' ); ?>" class="button"><?php _e( 'Back to Divi Children main menu', 'divi-children' ); ?></a></p>
			<?php
	}
?>	
</div>

