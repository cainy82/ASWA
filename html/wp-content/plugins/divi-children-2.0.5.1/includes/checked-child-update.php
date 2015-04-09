<?php
/*
 * Update Child Theme check results
 */
 


$child_theme = $check_child['child_theme'];
$child_theme_name = $check_child['child_theme_name'];	
$stylesheet_file = $check_child['stylesheet_file'];
$stylesheet_engine_version = $check_child['stylesheet_engine_version'];
$has_engine = $check_child['has_engine'];
$has_functions = $check_child['has_functions'];
$functions_file = $check_child['functions_file'];
$functions_updated = $check_child['functions_updated'];
$has_footer = $check_child['has_footer'];
$footer_engined = $check_child['footer_engined'];
$plugin_version = $check_child['plugin_version'];
$engine_version = $check_child['engine_version'];
$current_plugin_version = $check_child['current_plugin_version'];
$current_engine_version = $check_child['current_engine_version'];


if ( $has_engine ) {
		$version_compare = version_compare( $engine_version, $current_engine_version );
		if ($version_compare == 0) {
				$engine_action = 'ok';
			} elseif ($version_compare == -1) {
				$engine_action = 'update';
			} else {
				$engine_action = 'error';
		}
	} else {
		$engine_action = 'install';
}
if ( $has_functions ) {
		if ($functions_updated) {
				$functions_action = 'ok';
			} else {
				$functions_action = 'update';
		}
	} else {
		$functions_action = 'install';
}
if ( $stylesheet_engine_version ) {
		$stylesheet_version_compare = version_compare( $stylesheet_engine_version, $current_engine_version );
		if ( $stylesheet_version_compare == 0 ){
				$stylesheet_action = 'ok';
			} elseif ($stylesheet_version_compare == -1) {
				$stylesheet_action = 'update';
				$update_stylesheet_from = $stylesheet_engine_version;
			} else {
				$stylesheet_action = 'update';
				$update_stylesheet_from = '0.0.0';
		}
	} else {
		$stylesheet_action = 'update';
		$update_stylesheet_from = '0.0.0';		
}
if ( $has_footer ) {
		if ( $footer_engined ) {
				$footer_action = 'ok';
			} else {
				$footer_action = 'notengined';
		}
	} else {
		$footer_action = 'install';
}

?>

<div id="update_child" class="main-panel">

	<?php
	
	if ( $has_engine ) {	
			if ( $engine_action == 'ok' ) {
					$update_button = false;
					echo '<h3>' . __( 'Your Divi Children Engine is already updated to the newest available version', 'divi-children' ) . ' ('. $current_engine_version .') installable by Divi Children plugin version ' . $current_plugin_version . '</h3>';
					if ( ( $functions_action != 'ok' ) OR ( $stylesheet_action != 'ok' ) OR ( $footer_action != 'ok' ) ) {
							echo '<p>' . __( 'Some of your child theme files may need to be updated though:', 'divi-children' ) . '</p>';
						} else {
							echo '<p>' . __( 'The rest of your child theme files are also updated:', 'divi-children' ) . '</p>';
					}
				} elseif ( $engine_action == 'update' ) {
					$update_button = __( 'Update to version', 'divi-children' ) . ' ' . $current_engine_version;
					echo '<h3>' . __( 'A newer version of the Divi Children Engine is available for your child theme', 'divi-children' ) . ' ' . $child_theme_name . '</h3>';
					if ( ( $functions_action != 'ok' ) OR ( $stylesheet_action != 'ok' ) OR ( $footer_action != 'ok' ) ) {
						echo '<p>' . __( 'Some other files may need to be created or updated in your child theme as well:', 'divi-children' ) . '</p>';
					}
				} elseif ( $engine_action == 'error' ) {
					echo '<h3>' . __( 'There must be an error in your child theme', 'divi-children' ) . ' ' . $child_theme_name . '</h3>';
					echo '<p>' . __( 'The version of the Divi Children Engine currently installed in your child theme seems to be', 'divi-children' ) . ' <b>' . $engine_version . '</b> (' . __( 'created by Divi Children plugin version', 'divi-children' ) . ' ' . $plugin_version . ').</p>';
					echo '<p>' . __( 'That does not make sense because the newest available version of the Divi Children Engine is', 'divi-children' ) . ' <b>' . $current_engine_version . '</b> (' . __( 'included in Divi Children plugin version', 'divi-children' ) . ' ' . $current_plugin_version . ').</p>';
			
			}
		} else {
			$update_button = __( 'Install Divi Children Engine', 'divi-children' ) . ' ' . $current_engine_version;
			echo '<h3>' . __( 'Divi Children Engine was not detected in your child theme', 'divi-children' ) . ' ' . $child_theme_name . '</h3>';
			if ( ( $functions_action != 'ok' ) OR ( $stylesheet_action != 'ok' ) OR ( $footer_action != 'ok' ) ) {
				echo '<p>' . __( 'For the Divi Children Engine to work properly, some other files may need to be created or updated in your child theme as well:', 'divi-children' ) . '</p>';
			}			
	}

	?>
	<table class="dch_table">
		<tr>
		<th class="darkheader"><?php echo __( 'Child theme file', 'divi-children' ); ?></th>
		<th class="darkheader"><?php echo __( 'Update status', 'divi-children' ); ?></th>
		<th class="darkheader"><?php echo __( 'Action needed for the plugin to update your child theme', 'divi-children' ); ?></th>
		</tr>

	<?php
	
	echo '<tr><th>' . __( 'Divi Children Engine files', 'divi-children' ) . '</th>';
	if ( $has_engine ) {	
			if ( $engine_action == 'ok' ) {
					echo '<td>' . __( 'Ok - Updated to version', 'divi-children' ) . ' ' .  $current_engine_version . '</td>';
					echo '<td><em>' . __( 'None', 'divi-children' ) . '</em></td>';
				} elseif ( $engine_action == 'update' ) {
					echo '<td>' . __( 'Outdated (version', 'divi-children' ) . ' ' . $engine_version . ')</td>';
					echo '<td>' . __( 'Divi Children Engine will be updated to version', 'divi-children' ) . ' ' . $current_engine_version . '</td>';
				} elseif ( $engine_action == 'error' ) {
					echo '<td>' . __( 'Error', 'divi-children' ) . $current_engine_version . '</td>';
					echo '<td>' . __( 'Please check why there is a version inconsistence. Maybe you are using an oldest version of the Divi Children Plugin than the one used to create this child theme.', 'divi-children' ) . '</td>';
			}
		} else {
			echo '<td>' . __( 'Divi Children Engine is missing', 'divi-children' ) . '</td>';
			echo '<td>' . __( 'The complete current version of the Divi Children Engine will be installed', 'divi-children' ) . '</td>';
	}
	echo '</tr>';

	echo '<tr><th>' . __( 'style.css', 'divi-children' ) . '</th>';	
	if ( $stylesheet_action == 'ok' ) {
			echo '<td>' . __( 'Ok - Ready for the current version of the Divi Children Engine', 'divi-children' ) . '</td>';
			echo '<td><em>' . __( 'None', 'divi-children' ) . '</em></td>';
		} else {
			$update_files = true;
			echo '<td>' . __( 'Not ready for the current version of the Divi Children Engine', 'divi-children' ) . '</td>';
			if ( $has_engine ) {
					echo '<td>' . __( 'The stylesheet will be updated when you update the Divi Children Engine', 'divi-children' ) . '</td>';
				} else {
					echo '<td>' . __( 'The stylesheet will be updated when you install the Divi Children Engine', 'divi-children' ) . '</td>';
			}
	}
	echo '</tr>';
	
	echo '<tr><th>' . __( 'functions.php', 'divi-children' ) . '</th>';
	if ( $functions_action == 'ok' ) {
			echo '<td>' . __( 'Ok - Supports the Divi Children Engine', 'divi-children' ) . '</td>';
			echo '<td><em>' . __( 'None', 'divi-children' ) . '</em></td>';
		} elseif ( $functions_action == 'update' ) {
			$update_files = true;
			echo '<td>' . __( 'Not ready to support the Divi Children Engine', 'divi-children' ) . '</td>';
			if ( $has_engine ) {
					echo '<td>' . __( 'This file will be updated when you update the Divi Children Engine', 'divi-children' ) . '</td>';
				} else {
					echo '<td>' . __( 'This file will be updated when you install the Divi Children Engine', 'divi-children' ) . '</td>';
			}
		} elseif ( $functions_action == 'install' ) {
			$install_files = true;
			echo '<td>' . __( 'Your child theme does not have a functions.php file', 'divi-children' ) . '</td>';
			echo '<td>' . __( 'A new functions.php file will be created to support the Divi Children Engine', 'divi-children' ) . '</td>';
	}
	echo '</tr>';

	echo '<tr><th>' . __( 'footer.php', 'divi-children' ) . '</th>';		
	if ( $footer_action == 'ok' ) {
			echo '<td>' . __( 'Ok - Ready to support the current version of Divi Children Engine', 'divi-children' ) . '</td>';
			echo '<td><em>' . __( 'None', 'divi-children' ) . '</em></td>';
		} elseif ( $footer_action == 'notengined' ) {
			$update_files = true;
			echo '<td>' . __( 'Not ready to support the Divi Children Engine', 'divi-children' ) . '</td>';
			if ( $has_engine ) {
					echo '<td>' . __( 'This file will be updated when you update the Divi Children Engine', 'divi-children' )  . ' (<b><em>' . __( 'please see Note below', 'divi-children' ) . '</em></b>) </td>';		
				} else {
					echo '<td>' . __( 'This file will be updated when you install the Divi Children Engine', 'divi-children' )  . ' (<b><em>' . __( 'please see Note below', 'divi-children' ) . '</em></b>) </td>';		
			}		
		} elseif ( $footer_action == 'install' ) {
			$install_files = true;
			echo '<td>' . __( 'Your child theme does not have a footer.php file', 'divi-children' ) . '</td>';
			echo '<td>' . __( 'A new footer.php file will be created to support the Divi Children Engine', 'divi-children' ) . '</td>';		
	}	
	echo '</tr>';
	
	?>	
	</table>
	<?php
	
	if ( ! $update_button ) {
		if ( $update_files AND $install_files ) {
			$update_button = __( 'Update and install files', 'divi-children' );
		} elseif ( $update_files AND ( ! $install_files ) ) {
			$update_button = __( 'Update files', 'divi-children' );
		} elseif ( ( ! $update_files ) AND $install_files ) {
			$update_button = __( 'Install files', 'divi-children' );		
		}
	}

	$update_engine = $child_theme . ',' . $child_theme_name . ',' . $engine_action . ',' . $stylesheet_action . ',' . $update_stylesheet_from . ',' . $functions_action . ',' . $footer_action;
	
	if ( $update_button ) {

			if ( ! empty( $install_engine_error )) {
				?>
				<div class="error"><?php echo $install_engine_error; ?></div>
				<?php
			}

			if ( $footer_action == 'notengined' ) {
				echo '<p class="dch_warning">' . __( 'NOTE: If your footer.php includes modifications you made to your footer template, you will need to manually add those tweakings  to the new footer.php that will be created by the plugin. Use the backup copy that will be saved as footer_backup.bak in your child theme folder to copy from it whatever code you need in order to preserve your modifications.', 'divi-children' ) . '</p>';		
			}

			?>		
			<form action="<?php echo admin_url( 'themes.php?page=divi-children-page' ); ?>" method="post" id="update_engine">
			
				<input type="text" style="display:none;" name="update_engine" value="<?php echo $update_engine; ?>" />
				
				<p class="submit">
					<input type="submit" class="button-primary" value="<?php echo $update_button; ?>" />						
				</p>
				
			</form>
			<?php
		
		} else {
			?>
			<p><em><?php echo __( 'Nothing to update or install. You are all set!', 'divi-children' ); ?></em></p>
			<p><a href="<?php echo admin_url( 'themes.php?page=divi-children-page' ); ?>" class="button-primary"><?php _e( 'Back to Divi Children main menu', 'divi-children' ); ?></a></p>
			<?php
	}

	if ( $update_files OR $install_files ) {
		if ( ( $functions_action != 'ok' ) AND ( $stylesheet_action != 'ok' ) AND ( $footer_action != 'ok' ) ) {
				if ( $has_footer ) {
						$backup_files = __( 'backup copies of your style.css, functions.php and footer.php files', 'divi-children' );
						$changing_codes = __( 'CSS and functions (except for footer modifications - see Note above)', 'divi-children' );
					} else {
						$backup_files =  __( 'backup copies of both your style.css and functions.php files', 'divi-children' );
						$changing_codes = __( 'CSS and functions', 'divi-children' );
				}
			} elseif ( ( $functions_action != 'ok' ) AND ( $stylesheet_action == 'ok' ) AND ( $footer_action == 'ok' ) ) {
				$backup_files =  __( 'a backup copy of your functions.php file', 'divi-children' );
				$changing_codes = __( 'functions', 'divi-children' );
			} elseif ( ( $functions_action == 'ok' ) AND ( $stylesheet_action != 'ok' ) AND ( $footer_action == 'ok' ) ) {
				$backup_files =  __( 'a backup copy of your style.css file', 'divi-children' );
				$changing_codes = __( 'CSS', 'divi-children' );
			} elseif ( ( $functions_action == 'ok' ) AND ( $stylesheet_action == 'ok' ) AND ( $footer_action != 'ok' ) ) {
				$backup_files =  __( 'a backup copy of your footer.php file', 'divi-children' );
				$changing_codes = false;
			} elseif ( ( $functions_action = 'ok' ) AND ( $stylesheet_action != 'ok' ) AND ( $footer_action != 'ok' ) ) {
				if ( $has_footer ) {
						$backup_files =  __( 'backup copies of both your style.css and footer.php files', 'divi-children' );
						$changing_codes = __( 'CSS (except for footer modifications - see Note above)', 'divi-children' );
					} else {
						$backup_files =  __( 'a backup copy of your style.css file', 'divi-children' );
						$changing_codes = __( 'CSS', 'divi-children' );
				}
			} elseif ( ( $functions_action != 'ok' ) AND ( $stylesheet_action == 'ok' ) AND ( $footer_action != 'ok' ) ) {
				$backup_files =  __( 'backup copies of both your functions.php and footer.php files', 'divi-children' );
				$changing_codes = __( 'functions (except for footer modifications - see Note above)', 'divi-children' );
			} elseif ( ( $functions_action != 'ok' ) AND ( $stylesheet_action != 'ok' ) AND ( $footer_action == 'ok' ) ) {
				$backup_files =  __( 'backup copies of both your style.css and functions.php files', 'divi-children' );
				$changing_codes = __( 'CSS and functions', 'divi-children' );
		}
		if ( $changing_codes ) {
			echo '<p class="dch_info">' . __( 'Your existing custom', 'divi-children' ) . ' ' . $changing_codes . ' ' . __( 'will not be lost, the plugin will just add the lines required to support the Divi Children Engine.', 'divi-children' ) . '</p>';
		
		}
		echo '<p class="dch_info">' . __( 'To keep everything safe', 'divi-children' ) . ', ' . $backup_files . ' ' .__( 'will be made and saved within your child theme folder.', 'divi-children' ). '</p>';
		if ( ( $footer_action == 'notengined' ) OR ($footer_action == 'install') ) {
			echo '<p class="dch_info">' . __( 'The new footer.php file will be generated from your installed version of Divi and will include a footer credit line customizable by the Divi Children Engine via the WordPress Customizer.', 'divi-children' ) . '</p>';
		}
	}
	?>	

</div>

