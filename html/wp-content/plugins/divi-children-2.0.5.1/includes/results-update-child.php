<?php
/*
 * Divi Children Engine and child theme files installation or update results page
 */


if ( $installed_engine ) {
	$stylesheet_engine_version = $installed_engine['stylesheet_engine_version'];
	$engine_version = $installed_engine['engine_version'];
}

if ( ( ( $engine_action == 'install' ) OR ( $engine_action == 'update' ) ) AND $installed_engine ) {
		$success = true;
		if ( $engine_action == 'install' ) {
				$engine_success = '<b>' . __( 'Divi Children Engine', 'divi-children' ) . '</b> ' . __( 'version', 'divi-children' ) . ' ' . $engine_version . '</b> ' . __( 'installed. This is a fresh installation of the Divi Children Engine for this child theme', 'divi-children' ) . '</b>.';
			} elseif ( $engine_action == 'update' ) {
				$engine_success = '<b>' . __( 'Your Divi Children Engine was updated to', 'divi-children' ) . '</b> ' . __( 'version', 'divi-children' ) . ' ' . $engine_version . '</b>.';
		}
	} else {
		$success = false;
}
if ( ( $stylesheet_action != 'ok' ) AND $updated_stylesheet ) {
		$success = true;
		if ( $update_stylesheet_from == '0.0.0' ){
				$stylesheet_success = '<b>' . __( 'style.css', 'divi-children' ) . '</b> ' . __( 'updated to support the current version of Divi Children Engine', 'divi-children' ) . '.';
			} else {
				$stylesheet_success = '<b>' . __( 'style.css', 'divi-children' ) . '</b> ' . __( 'updated to support the current version of Divi Children Engine instead of version', 'divi-children' ) . ' ' . $update_stylesheet_from;
		}
	} else {
		$success = false;
}
if ( ( $functions_action == 'update' ) AND ( $updated_functions  ) ) {
		$success = true;
		$functions_success = '<b>' . __( 'functions.php', 'divi-children' ) . '</b> ' . __( 'updated to support Divi Children Engine.', 'divi-children' );
	} else { 
		$success = false;
}
if ( ( $functions_action == 'install' ) AND  $installed_functions ) {
		$success = true;
		$functions_success = '<b>' . __( 'functions.php', 'divi-children' ) . '</b> ' . __( 'file was created with support for Divi Children Engine.', 'divi-children' );
	} else { 
		$success = false;
}
if ( ( ( $footer_action == 'install' ) OR ( $footer_action == 'notengined' ) ) AND ( $updated_footer ) ) {
		$success = true;
		if ( $footer_action == 'install' ) {
				$footer_success = '<b>' . __( 'footer.php', 'divi-children' ) . '</b> ' . __( 'file was created with support for Divi Children Engine version', 'divi-children' ) . ' ' . $engine_version . '.';
			} elseif ( $footer_action == 'notengined' ) {
				$footer_success = '<b>' . __( 'footer.php', 'divi-children' ) . '</b> ' . __( 'updated to support the current version of Divi Children Engine', 'divi-children' ) . '.';
		}
	} else {
		$success = false;
}
?>

<div id="engine_updated" class="main-panel">
	<?php
	if ( $success ) {
			echo '<h3>' . __( 'Your child theme', 'divi-children' ) . ' ' . $divichild_name . ' ' . __( 'was successfully updated', 'divi-children' ) . '</h3>';
		} else {
			echo '<h3>' . __( 'Some error(s) occurred when trying to update Divi Children Engine for your child theme', 'divi-children' ) . '</h3>';
	}
	
	if ( $engine_success ) {
		echo '<div id="engine_success">';
			echo '<p><b>' . __( 'Divi Children Engine files', 'divi-children' ) . '</b>:</p>';
			echo '<ul class="bulleted_green">';
				echo '<li>';
					echo $engine_success;
				echo '</li>';				
			echo '</ul>';
		echo '</div>';
	}
	
	if ( $stylesheet_success OR $functions_success OR $footer_success ) {
		echo '<div id="updated_files">';
			if ( $engine_action != 'ok' ) {
					echo '<p><b>' . __( 'Other files that were updated or created', 'divi-children' ) . '</b>:</p>';
				} else {
					echo '<p><b>' . __( 'Files that were updated or created', 'divi-children' ) . '</b>:</p>';
			}
			echo '<ul class="bulleted_green">';
				if ( $stylesheet_success ) {
					echo '<li>';
						echo $stylesheet_success;
					echo '</li>';
				}
				if ( $functions_success ) {
					echo '<li>';
						echo $functions_success;
					echo '</li>';
				}
				if ( $footer_success ) {
					echo '<li>';
						echo $footer_success;
					echo '</li>';
				}				
			echo '</ul>';
		echo '</div>';
	}
	if ( $stylesheet_backup OR $functions_backup OR $footer_backup ) {
		echo '<div id="backup_files">';			
			echo '<p><b>' . __( 'Backup Files', 'divi-children' ) . '</b>:</p>';
			echo '<p>' . __( 'The following backup files were made from your original child theme files and saved within your child theme folder', 'divi-children' ) . ' (/' . $divichild_to_update . '/):</p>';
			echo '<ul class="bulleted">';
				if ( $stylesheet_backup ) {
					echo '<li>';
						echo 'style_backup.bak';
					echo '</li>';
				}
				if ( $functions_backup ) {
					echo '<li>';
						echo 'functions_backup.bak';
					echo '</li>';
				}
				if ( $footer_backup ) {
					echo '<li>';
						echo 'footer_backup.bak';
					echo '</li>';
				}				
			echo '</ul>';			
		echo '</div>';
	}

	?>

	<p><a href="<?php echo admin_url( 'themes.php?page=divi-children-page' ); ?>" class="button-primary"><?php _e( 'Back to Divi Children main menu', 'divi-children' ); ?></a></p>
	
</div>
