<?php
/*
 * Child theme creation results page
 */

?>

<div id="child_created" class="main-panel">
	<h3><?php _e( 'Your child theme was successfully created!', 'divi-children' ); ?></h3>
	<div id="created_theme">
		<div class="theme_screenshot">
			<img src="<?php echo $divichild['new_theme_dir'] . '/screenshot.jpg'; ?>" alt="screenshot">
		</div>
									
		<div class="theme_info">
			<h3><?php echo $divichild['new_theme_name']; ?></h3>
			<h4><?php _e( 'By', 'divi-children' ); ?><?php echo ' ' . $divichild['new_theme_authorname']; ?></h4>									
			<p><em><?php _e( 'Version', 'divi-children' ); ?></em><b><?php echo ': ' . $divichild['new_theme_version']; ?></b></p>
			<p><b><?php echo $divichild['new_theme_description']; ?></b></p>
			<p><em><?php _e( 'Parent Theme', 'divi-children' ); ?></em><b><?php echo ': ' . $divichild['new_theme_parent']; ?></b></p>
			<p><em><?php _e( 'Theme URI', 'divi-children' ); ?></em><b><?php echo ': ' . $divichild['new_theme_uri']; ?></b></p>
			<p><em><?php _e( 'Author URI', 'divi-children' ); ?></em><b><?php echo ': ' . $divichild['new_theme_authoruri']; ?></b></p>									
			<a href="<?php echo admin_url( 'themes.php' ); ?>" class="button-primary"><?php _e( 'You can activate it now in the Themes Manager', 'divi-children' ); ?></a>								
		</div>
	</div>
</div>

<div id="footer_display">
	<h3><?php _e( 'Your footer credits will look like this:', 'divi-children' ); ?></h3>
	<div class="footer-display">
		<?php
		$firstyear = get_option( 'footer_credits_firstyear' );
		$owner = get_option( 'footer_credits_owner' );
		$ownerlink = get_option( 'footer_credits_ownerlink' );
		$developed_text = get_option( 'footer_credits_developed' );
		$developer = get_option( 'footer_credits_developer' );
		$developerlink = get_option( 'footer_credits_developerlink' );	
		$powered_text = get_option( 'footer_credits_powered' );
		$powered_code = get_option( 'footer_credits_poweredcode' );
		$powered_codelink = get_option( 'footer_credits_poweredcodelink' );
		$footer_credits = 'Copyright &copy; ';
		$current_year = date( 'Y' );
		if ( $firstyear AND ($firstyear != 0 )) {
				if( $firstyear != $current_year ) {
					$footer_credits .= $firstyear . ' - ' . $current_year;
				}
			} else {
				$footer_credits .= $current_year;	
		}
		$footer_credits .= ' <a href="' . esc_url( $ownerlink ) . '">' . $owner . '</a>';
		if ( $developed_text ) {
			$footer_credits .= ' | ' . $developed_text . ' ' . '<a href="' . esc_url( $developerlink ) . '">' . $developer . '</a>';
		}
		if ( $powered_text ) {
			$footer_credits .= ' | ' . $powered_text . ' ' . '<a href="' . esc_url( $powered_codelink ) . '">' . $powered_code . '</a>';
		}
		echo $footer_credits;
		?>
	</div>
</div>