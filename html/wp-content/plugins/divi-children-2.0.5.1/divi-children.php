<?php

/*
Plugin Name: Divi Children
Version: 2.0.5.1
Plugin URI: http://divi4u.com
Description: Easily creates highly customizable child themes of Divi, directly from your WordPress admin area.
Author: Luis Alejandre
Text Domain: divi-children
Domain Path: /lang

Divi Children plugin
Copyright (C) 2014-2015, Luis Alejandre - luis@divi4u.com

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.

*/
 
include( 'includes/scripts.php' );


class DiviChildTheme {

	public $current_plugin_version = '2.0.5.1';
	
	public $current_engine_version = '1.0.0';

	function __construct() {
		add_filter( 'admin_menu', array( $this, 'DiviChildMenu' ) );
	}
	
	function DiviChildMenu() {
		add_theme_page( 'Make a Child Theme for your Divi Theme', 'Divi Children', 'install_themes', 'divi-children-page', array( $this, 'DiviChildForm' ) );
	}

	function DiviChildForm() {
		if ( ! empty( $_POST['theme_name'] ) ) {		
			$divichild_to_create = array(
				'theme_name' => $_POST['theme_name'],
				'theme_uri' => $_POST['theme_uri'],
				'theme_version' => $_POST['theme_version'],
				'theme_description' => $_POST['theme_description'],
				'theme_authorname' => $_POST['theme_authorname'],
				'theme_authoruri' => $_POST['theme_authoruri'],
				'footerlink_url' => $_POST['footerlink_url'],
				'footerlink_name' => $_POST['footerlink_name'],
				'developed_text' => $_POST['developed_text'],
				'developerlink_url' => $_POST['developerlink_url'],
				'developerlink_name' => $_POST['developerlink_name'],
				'firstyear' => $_POST['firstyear'],
				'powered_text' => $_POST['powered_text'],
				'powered_url' => $_POST['powered_url'],
				'powered_name' => $_POST['powered_name'],
			);
			if ( ! empty( $divichild_to_create['theme_name'] ) ) {
				$divichild = $this->create_child_theme( $divichild_to_create );
			}
			if ( is_wp_error( $divichild ) ) {
				$error_string = $divichild->get_error_message();
				} else {
					require( 'includes/results-page.php' );
					exit;
			}
		}
		if ( ! empty( $_POST['ad_image'] ) ) {
			$screenshot_url = $_POST['ad_image'];
			$divi_child = $_POST['divi_child'];
			if ( ! empty( $screenshot_url ) ) {
				$screenshot_changed = $this->change_screenshot( $screenshot_url,  $divi_child );
			}
			if ( is_wp_error( $screenshot_changed ) ) {
				$screenshot_error = $screenshot_changed->get_error_message();
				} else {
					require( 'includes/results-page-screenshot.php' );
					exit;
			}
		}
		if ( ! empty( $_POST['divichild_to_check'] ) ) {
			$divichild_to_check = $_POST['divichild_to_check'];
			if ( ! empty( $divichild_to_check ) ) {
				$check_child = $this->divichild_update_check( $divichild_to_check );
			}
			if ( is_wp_error( $check_child ) ) {
				$check_child_error = $check_child->get_error_message();
				} else {
					require( 'includes/checked-child-update.php' );
					exit;
			}			
		}
		if ( ! empty( $_POST['divichild_to_check_footer'] ) ) {
			$divichild_to_check_footer = $_POST['divichild_to_check_footer'];
			if ( ! empty( $divichild_to_check_footer ) ) {
				$check_footer = $this->divichild_footer_check( $divichild_to_check_footer );
			}
			if ( is_wp_error( $check_footer ) ) {
				$check_footer_error = $check_footer->get_error_message();
				} else {
					require( 'includes/checked-footer-update.php' );
					exit;
			}
		}
		if ( ! empty( $_POST['update_engine'] ) ) {
			$update_engine = explode ( "," , $_POST['update_engine'] );
			$divichild_to_update = $update_engine[0];
			$divichild_name = $update_engine[1];
			$engine_action = $update_engine[2];
			$stylesheet_action = $update_engine[3];
			$update_stylesheet_from = $update_engine[4];
			$functions_action = $update_engine[5];
			$footer_action = $update_engine[6];
			$divichild_path = get_theme_root() . '/' . $divichild_to_update;
			$divichild_functions_file = $divichild_path . '/functions.php';
			$divichild_stylesheet_file = $divichild_path . '/style.css';			
			if ( ! empty( $divichild_to_update ) ) {
				if ( $engine_action != 'ok' ) {
					$installed_engine = $this->install_engine( $divichild_to_update );
				}
				if ( $stylesheet_action == 'update' ) {
					$divichild_stylesheet = file( $divichild_stylesheet_file, FILE_IGNORE_NEW_LINES );
					$stylesheet_backup = rename ( $divichild_stylesheet_file , $divichild_path . '/style_backup.bak' );
					$engine_css = file( dirname( __FILE__ ) . '/includes/templates/engine-css.css', FILE_IGNORE_NEW_LINES );
					$divichild_stylesheet = array_merge( $divichild_stylesheet, $engine_css );
					$divichild_stylesheet = implode ( "\n" , $divichild_stylesheet );
					$updated_stylesheet = file_put_contents( $divichild_stylesheet_file, $divichild_stylesheet );
				}
				if ( $functions_action == 'install' ) {
						$installed_functions = copy( dirname( __FILE__ ) . '/includes/templates/functions-basic.php', $divichild_path . '/functions.php' );
					} elseif ( $functions_action == 'update' ) {
						$divichild_functions = file( $divichild_functions_file, FILE_IGNORE_NEW_LINES );
						$functions_backup = rename ( $divichild_functions_file , $divichild_path . '/functions_backup.bak' );
						$divichild_functions = $this->functions_closing_php( $divichild_functions );
						$engine_require = file( dirname( __FILE__ ) . '/includes/templates/engine-require.php', FILE_IGNORE_NEW_LINES );
						$divichild_functions = array_merge( $divichild_functions, $engine_require );
						$divichild_functions = implode ( "\n" , $divichild_functions );
						$updated_functions = file_put_contents( $divichild_functions_file, $divichild_functions );
				}
				if ( $footer_action != 'ok' ) {
					if ( $footer_action == 'notengined' ) {
						$footer_backup = copy( $divichild_path . '/footer.php', $divichild_path . '/footer_backup.bak' );
					}
					$updated_footer = $this->create_divichild_footer( $divichild_path );
				}
			}
			if ( is_wp_error( $installed_engine ) ) {
					$installed_engine_error = $install_engine->get_error_message();
				} else {
					$update_results = array(
						'divichild_to_update'		=>	$divichild_to_update,
						'divichild_name'			=>	$divichild_name,
						'engine_action'				=>	$engine_action,
						'stylesheet_action'			=>	$stylesheet_action,
						'update_stylesheet_from'	=>	$update_stylesheet_from,
						'functions_action'			=>	$functions_action,
						'footer_action'				=>	$footer_action,
						'installed_engine'			=>	$installed_engine,
						'updated_stylesheet'		=>	$updated_stylesheet,
						'updated_functions'			=>	$updated_functions,
						'installed_functions'		=>	$installed_functions,
						'updated_footer'			=>	$updated_footer,
						'stylesheet_backup'			=>	$stylesheet_backup,						
						'functions_backup'			=>	$functions_backup,
						'footer_backup'				=>	$footer_backup,
					);
					require( 'includes/results-update-child.php' );
					exit;
			}			
		}
		
		if ( ! empty( $_POST['update_footer'] ) ) {
			$update_footer = explode ( "," , $_POST['update_footer'] );
			$divichild_to_update = $update_footer[0];
			$footer_update_action = $update_footer[1];
			$divichild_path = get_theme_root() . '/' . $divichild_to_update;
			if ( ! empty( $footer_update_action ) ) {
				if ( $footer_update_action == 'update') {
					$footer_backup = copy( $divichild_path . '/footer.php', $divichild_path . '/footer_backup.bak' );
				}
				if ( ( $footer_update_action == 'update' )  OR  ( $footer_update_action == 'install' ) ){
					$updated_footer = $this->create_divichild_footer( $divichild_path );
				}
			}
			if ( is_wp_error( $update_footer ) ) {
				$update_footer_error = $check_footer->get_error_message();
				} else {
					$update_footer_results = array(
						'divichild_to_update'	=>	$divichild_to_update,
						'footer_update_action'	=>	$footer_update_action,
						'updated_footer'		=>	$updated_footer,
						'footer_backup'			=>	$footer_backup,
					);
					require( 'includes/results-update-footer.php' );
					exit;
			}
		}
		
		require( 'includes/form-page.php' );
		
	}

	private function change_screenshot( $Divi_child_screenshot, $Divi_child_slug ) {		
		// Check if the new screenshot exists
		$screenshot_exists = @fopen( $Divi_child_screenshot, "r" );
		@fclose( $screenshot_exists );
		// Check if it is an image file (only for PHP versions supporting exif_imagetype)
		if ( function_exists( 'exif_imagetype' ) ) {
				if ( $screenshot_exists ) {
					$screenshot_isimage = exif_imagetype( $Divi_child_screenshot );
				}
			} else {
				$screenshot_isimage = true; // caution: It has not really been checked if it is a image file
		}
		if ( empty( $Divi_child_screenshot ) OR ( $Divi_child_screenshot == 'http://') ) {
			$screenshot_error = '<h3>' . __( 'You have not selected any image for your new screenshot!', 'divi-children' ) . '</h3><p><b>' . __( 'The screenshot was not changed', 'divi-children' ) . '.</b></p>';
			return new WP_Error( 'no_screenshot', $screenshot_error );
		}
		if ( !$screenshot_exists ) {
			$screenshot_error = '<h3>' . __( 'The file URL you provided for your new screenshot is not valid', 'divi-children' ) . '</h3><p><b>' . __( 'The screenshot was not changed', 'divi-children' ) . '.</b></p><p>There is not such file at <em>' . $Divi_child_screenshot . '</em></p>';
			return new WP_Error( 'no_screenshot', $screenshot_error );
		}		
		if (!$screenshot_isimage) {
			$screenshot_error = '<h3>' . __( 'The file you chose for your new screenshot is not an image file', 'divi-children' ) . ' (<em>' . $Divi_child_screenshot . '</em>)</h3><p><b>' . __( 'The screenshot was not changed', 'divi-children' ) . '.</b></p>';
			return new WP_Error( 'no_screenshot', $screenshot_error );
		}		
		$Divi_child_path = get_theme_root() . '/' . $Divi_child_slug;		
		// Get the extension (.jpg, .png, etc) of the screenshot
		$pos = strpos( strrev( $Divi_child_screenshot ), '.' );
		$extension = substr( $Divi_child_screenshot, ( strlen( $Divi_child_screenshot ) - $pos ) );		
		// Delete existing screenshots with any extension
		foreach ( glob( $Divi_child_path . '/screenshot.*' ) as $filename ) {
		   unlink( $filename );
		}
		// Copy selected screenshot
		copy( $Divi_child_screenshot, $Divi_child_path . '/screenshot.' . $extension );
		$theme_changed = wp_get_theme( $Divi_child_slug )->get( 'Name' );
		return array(
			'new_screenshot'	=>	get_theme_root_uri() . '/' . $Divi_child_slug . '/screenshot.' . $extension,
			'origin_screenshot'	=>	$Divi_child_screenshot,
			'theme_changed'		=>	$theme_changed,	
		);
	}	

	private function divichild_update_check( $Divi_child_slug ) {
		$child_theme_name = wp_get_theme( $Divi_child_slug )->get( 'Name' );
		$engine_main = get_theme_root() .'/' . $Divi_child_slug . '/divi-children-engine/divi_children_engine.php';
		$stylesheet_file = get_theme_root() . '/' . $Divi_child_slug . '/style.css';
		$functions_file = get_theme_root() .'/' . $Divi_child_slug . '/functions.php';
		$footer_file = get_theme_root() . '/' . $Divi_child_slug . '/footer.php';
		$stylesheet_engine_version = $this->get_stylesheet_engine_version( $stylesheet_file );	
		$has_engine = is_readable( $engine_main );
		if ( $has_engine ) {
			$engine_array = file( $engine_main, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES );
			$plugin_version = $this->info_header_decode( 'Plugin version:' , $engine_array );
			$engine_version = $this->info_header_decode( 'Engine version:' , $engine_array );
		}
		$has_functions = is_readable( $functions_file );
		if ( $has_functions ) {
			$functions_array = file( $functions_file, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES );
			$functions_check = $this->info_header_decode( 'divi-children-engine/' , $functions_array );
			if ( false !== strpos( $functions_check, 'divi_children_engine.php' ) ) {
				$functions_updated = true;
			}
		}
		$has_footer = is_readable( $footer_file );
		if ( $has_footer ) {
			$footer_string = file_get_contents($footer_file);
			if ( false !== strpos( $footer_string, 'Divichild_footer_credits_generator' ) ) {
				$footer_engined = true;
			}
		}
		return array(
			'child_theme'				=>	$Divi_child_slug,
			'child_theme_name'			=>	$child_theme_name,
			'stylesheet_file'			=>	$stylesheet_file,
			'stylesheet_engine_version'	=>	$stylesheet_engine_version,
			'has_engine'				=>	$has_engine,
			'has_functions'				=>	$has_functions,
			'functions_file'			=>	$functions_file,
			'functions_updated'			=>	$functions_updated,
			'has_footer'				=>	$has_footer,
			'footer_engined'			=>	$footer_engined,
			'plugin_version'			=>	$plugin_version,
			'engine_version'			=>	$engine_version,
			'current_plugin_version'	=>	$this->current_plugin_version,
			'current_engine_version'	=>	$this->current_engine_version,
		);
	}	

	private function divichild_footer_check( $Divi_child_slug ) {
		$update_check_data = $this->divichild_update_check( $Divi_child_slug );
		$has_engine = $update_check_data['has_engine'];
		$has_footer = $update_check_data['has_footer'];
		$footer_engined = $update_check_data['footer_engined'];
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
		return $footer_check;
	}

	private function get_stylesheet_engine_version( $stylesheet_file ) {
		$string = file_get_contents( $stylesheet_file );
		$engined = strpos( $string, 'Updated to Divi Children Engine version' );
		if ( false !== $engined ) {
				$pos = ( strpos( $string, 'Updated to Divi Children Engine version' ) + 39 );
				$string = trim ( substr( $string, $pos ) );
				$pos = strpos( $string, ']' );
				$version = substr( $string, 0, $pos );
				return $version;
			} else {
				return false;
		}
	}
	
	private function info_header_decode( $field_header , $array ) {
		foreach( $array as $value ) {
			if ( false !== stripos( $value, $field_header ) ) {
				$field_pos = ( stripos( $value, $field_header ) + strlen( $field_header ) );
				$field = trim ( substr( $value, $field_pos ) );
				$field = filter_var( $field, FILTER_SANITIZE_STRING );
				break;
			}
		}
		return $field;
	}

	private function install_engine( $Divi_child_slug ) {
		$engine_path = get_theme_root() . '/' . $Divi_child_slug . '/divi-children-engine';
		if ( ! is_dir( $engine_path ) ) {
			mkdir( $engine_path );         
		}
		if ( ! is_dir( $engine_path . '/includes' ) ) {
			mkdir( $engine_path . '/includes' );         
		}
		if ( ! is_dir( $engine_path . '/css' ) ) {
			mkdir( $engine_path . '/css' );         
		}
		if ( ! is_dir( $engine_path . '/includes/divi-mods' ) ) {
			mkdir( $engine_path . '/includes/divi-mods' );         
		}
		copy( dirname( __FILE__ ) . '/includes/templates/divi_children_engine.php', $engine_path . '/divi_children_engine.php' );	
		copy( dirname( __FILE__ ) . '/includes/templates/divi_children_functions.php', $engine_path . '/includes/divi_children_functions.php' );		
		copy( dirname( __FILE__ ) . '/includes/templates/custom_codes.php', $engine_path . '/includes/custom_codes.php' );		
		copy( dirname( __FILE__ ) . '/includes/templates/divi_mod_functions.php', $engine_path . '/includes/divi-mods/divi_mod_functions.php' );
		copy( dirname( __FILE__ ) . '/includes/templates/custom-metabox.css', $engine_path . '/css/custom-metabox.css' );
		$result_check = $this->divichild_update_check( $Divi_child_slug );
		return $result_check;
	}
	
	private function create_child_theme( $Divi_child ) {
		$Divi_child_name = $Divi_child['theme_name'];
		$Divi_child_uri = $Divi_child['theme_uri'];
		$Divi_child_version = $Divi_child['theme_version'];
		$Divi_child_description = $Divi_child['theme_description'];
		$Divi_child_authorname = $Divi_child['theme_authorname'];
		$Divi_child_authoruri = $Divi_child['theme_authoruri'];
		$Divi_child_footerlink_url = $Divi_child['footerlink_url'];
		$Divi_child_footerlink_name = $Divi_child['footerlink_name'];
		$Divi_child_dev_text = $Divi_child['developed_text'];
		$Divi_child_devlink_url = $Divi_child['developerlink_url'];
		$Divi_child_devlink_name = $Divi_child['developerlink_name'];
		$Divi_child_firstyear = $Divi_child['firstyear'];
		$Divi_child_powered_text = $Divi_child['powered_text'];
		$Divi_child_powered_url = $Divi_child['powered_url'];
		$Divi_child_powered_name = $Divi_child['powered_name'];				
		$Divi_child_slug = sanitize_title( $Divi_child_name );
		// Check if a similar child theme already exists
		$Divi_child_path = get_theme_root() . '/' . $Divi_child_slug;		
		$error_message = __( '<h3>The child theme could not be created. A theme directory with that name already exists.</h3>
							  <p>Please change your child theme name if you want to create yet another Divi child theme.</p>', 'divi-children' );
		if ( file_exists( $Divi_child_path ) ) {
			return new WP_Error( 'repeated', $error_message );
		}
		// Create child theme folder
		mkdir( $Divi_child_path );
		// Create stylesheet
		ob_start();
		require( 'includes/templates/child-stylesheet.php' );
		$new_stylesheet = ob_get_clean();
		file_put_contents( $Divi_child_path . '/style.css', $new_stylesheet );
		// Create screenshot
		copy( dirname( __FILE__ ) . '/images/screenshot.jpg', $Divi_child_path . '/screenshot.jpg' );
		// Create functions.php
		copy( dirname( __FILE__ ) . '/includes/templates/functions.php', $Divi_child_path . '/functions.php' );
		// Create footer.php
		$new_footer = $this->create_divichild_footer($Divi_child_path);
		// Create Divi Children Engine
		$this->install_engine( $Divi_child_slug );
		// Enable the new child theme for multisite installs
		$allowed_themes = get_site_option( 'allowedthemes' );
		$allowed_themes[$Divi_child_slug] = true;
		update_site_option( 'allowedthemes', $allowed_themes );
		// Add options for the footer credits
		update_option( 'footer_credits_firstyear', $Divi_child_firstyear );		
		update_option( 'footer_credits_owner', $Divi_child_footerlink_name );
		update_option( 'footer_credits_ownerlink', $Divi_child_footerlink_url );
		update_option( 'footer_credits_developed', $Divi_child_dev_text );
		update_option( 'footer_credits_developer', $Divi_child_devlink_name );
		update_option( 'footer_credits_developerlink', $Divi_child_devlink_url );
		update_option( 'footer_credits_powered', $Divi_child_powered_text );
		update_option( 'footer_credits_poweredcode', $Divi_child_powered_name );
		update_option( 'footer_credits_poweredcodelink', $Divi_child_powered_url );
		return array(
			'new_theme'				=>	$Divi_child_slug,
			'new_theme_dir'			=>	get_theme_root_uri() . '/'.$Divi_child_slug,
			'new_theme_name'		=>	$Divi_child_name,
			'new_theme_uri'			=>	$Divi_child_uri,
			'new_theme_version'		=>	$Divi_child_version,
			'new_theme_description'	=>	$Divi_child_description,
			'new_theme_authorname'	=>	$Divi_child_authorname,			
			'new_theme_authoruri'	=>	$Divi_child_authoruri,
			'new_theme_parent'		=>	'Divi',
		);
	}

	private function create_divichild_footer( $Divi_child_path ) {
		$divi_footer = get_theme_root() . '/Divi/footer.php';
		$divi_footer_array = file( $divi_footer, FILE_IGNORE_NEW_LINES );
		foreach ( $divi_footer_array as $key => $value ) {
			$pos = strpos( $value, '<p id="footer-info">' );
			if ( false !== $pos ) {
				$line_start = substr( $value, 0, $pos );
				$divi_footer_array[$key] = $line_start . '<p id="footer-info"><?php echo Divichild_footer_credits_generator(); ?></p>';
				$found = true;
				break;
			}
		}
		if ( $found ) {
			$divichild_footer = implode ( "\n" , $divi_footer_array );
			$installed = file_put_contents ( $Divi_child_path . '/footer.php', $divichild_footer );
		}
		return $installed;
	}

	private function functions_closing_php( $functions_array ) {
		$inverted_functions = array_reverse($functions_array);
		foreach ( $inverted_functions as $key => $value ) {
			$value = trim( $value );
			$value = substr( $value, -2 );						
			if ( $value == '' ) {
					continue;
				} elseif ( $value == '?>' ) {
					$found = true;
					break;
				} else {
					$found = false;
					break;							
			}
		}
		if ( ! $found ) {
			$functions_array[] = '?>';	
		}
		return $functions_array;
	}

	public function get_divi_childs() {
		$themes = wp_get_themes();
		foreach ( $themes as $theme ) {
			$theme_n = $theme[0];
			$parent = $theme->get( 'Template' );
			$dirname = $theme->get_stylesheet();
			if ( $parent == 'Divi' ) {
				if ( ! $divi_childs ) {
					$divi_childs = array ( $dirname );
					} else {
						$divi_childs[] = $dirname;
				}
			}
		}
		return $divi_childs;
	}
	
}

new DiviChildTheme();

?>
