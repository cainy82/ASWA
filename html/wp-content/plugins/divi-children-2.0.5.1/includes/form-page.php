<?php
/*
 * Child theme creation and update forms
 */
?>

<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+'://platform.twitter.com/widgets.js';fjs.parentNode.insertBefore(js,fjs);}}(document, 'script', 'twitter-wjs');</script>	

<?php

$thissitename = get_bloginfo( 'name' );
$theme_name = strtoupper( $thissitename );
$theme_uri = home_url();
$theme_version = '1.0';
$theme_description = 'A child theme of Divi. This is a custom child theme created for our site ' . $thissitename . '.';
global $current_user;
get_currentuserinfo();
$theme_author = $current_user->display_name;
$theme_authoruri = home_url();
$footerlink_url = $theme_authoruri;
$footerlink_name = $thissitename;
$firstyear = date( 'Y' ) - 1;
$developed_text = 'Developed by';
$developerlink_url = $theme_authoruri;
$developerlink_name = $theme_author;
$powered_text = 'Proudly powered by';
$powered_url = 'http://www.wordpress.org/';
$powered_name = 'WordPress';
$default_credits = 'Copyright &copy; ' . $firstyear . ' - ' . date('Y') . ' ';
 
?>


<div class="wrap">
	
	<div id="dch_title">
		<div id="dch_logo">
			<img src="<?php echo plugins_url( '../images/divi-children-logo.jpg' , __FILE__ ); ?>" />
			<span><?php _e( 'Divi child theme creator plugin', 'divi-children' ); ?></span>
		</div>
	</div>
	
	<div id="share_message">	
		<span><?php _e( 'If you like this free plugin, please tweet about it:', 'divi-children' ) ?></span>
		<a href="https://twitter.com/share" target="_blank" class="twitter-share-button" data-url="http://divi4u.com/divi-children-plugin/" data-text="Divi Children, a free Divi child theme plugin to help you create with Divi customizing your site easily." data-via="Divi_4u" data-count="none">Tweet</a>
		<span><?php // echo ' | '; ?></span>
		<span><?php _e( 'To stay tuned to new versions of this plugin, follow Divi4u on Twitter:', 'divi-children' ) ?></span>
		<a href="https://twitter.com/Divi_4u" class="twitter-follow-button" data-show-count="false" target="_blank">Follow @Divi_4u</a>
		<span>(<?php _e( 'or subscribe to the', 'divi-children') ?><a href="http://divi4u.com/blog/" target="_blank">Divi4u Blog</a> )</span>
	</div>
	
	<?php	
	// Check if Divi is installed in this site before attempting to create a child theme for it
	$Divi_path = get_theme_root() . '/Divi/style.css';
	if ( file_exists( $Divi_path ) ) {
			?>
			<div class="updated"><p><?php _e( 'Great! You have the Divi theme already installed in your site.', 'divi-children' ); ?></p></div>
			<?php		
		} else {
			?>
			<div class="error"><h3><?php _e( 'Wait! You need to install Divi before you can create a child theme for it!', 'divi-children' ); ?></h3></div>
			<?php
	}
	?>
	
	<div id="dch-tabs">

		<ul class="feature-tabs">
		  <li><a href="#create-child"><?php _e( 'Create New Divi Child Theme', 'divi-children' ); ?></a></li>
		  <li><a href="#change-screenshot"><?php _e( 'Change Screenshot', 'divi-children' ); ?></a></li>
		  <li><a href="#update-child"><?php _e( 'Install or Update Divi Children Engine', 'divi-children' ); ?></a></li>
		  <li><a href="#update-footer"><?php _e( 'Update Footer', 'divi-children' ); ?></a></li>	  
		</ul>
		 
		<!-- tabs "panes" -->
		<div id="create-child">
			<h3><?php _e( 'Fill out the following information for your new Divi child theme:', 'divi-children' ); ?></h3>
			
			<?php
			if ( ! empty( $error_string ) ) {
				?>
				<div class="error"><?php echo $error_string; ?></div>
				<?php
			}
			?>

			<form action="<?php echo admin_url( 'themes.php?page=divi-children-page' ); ?>" method="post" id="child_theme_form">
				<table>
					<tr>
						<th scope="row">
							<label for="theme_name">
								<?php _e( 'Theme Name:', 'divi-children' ) ?>
							</label>
						</th>
						<td>
							<input type="text" name="theme_name" size="30" value="<?php echo $theme_name; ?>" />
							<span><em><?php _e( 'This field should not be left blank.', 'divi-children' ) ?></em></span>
						</td>
					</tr>
					<tr>
						<th scope="row">
							<label for="theme_uri">
								<?php _e( 'Theme URI:', 'divi-children' ) ?>
							</label>
						</th>
						<td>
							<input type="text" name="theme_uri" size="30" value="<?php echo $theme_uri; ?>" />
						</td>
					</tr>
					<tr>
						<th scope="row">
							<label for="theme_version">
								<?php _e( 'Version:', 'divi-children' ) ?>
							</label>						
						</th>
						<td>
							<input type="text" name="theme_version" size="6" value="<?php echo $theme_version; ?>" />
						</td>
					<tr>
						<th scope="row">
							<label for="theme_description">
								<?php _e( 'Description:', 'divi-children' ) ?>
							</label>				
						</th>
						<td>
							<textarea name="theme_description" value="<?php echo $theme_description; ?>" rows="3" cols="50"/><?php echo $theme_description; ?></textarea>
						</td>
					</tr>
					<tr>
						<th scope="row">
							<label for="theme_authorname">
								<?php _e( 'Author:', 'divi-children' ) ?>
							</label>				
						</th>
						<td>
							<input type="text" name="theme_authorname" size="30" value="<?php echo $theme_author; ?>" />
						</td>
					</tr>
					<tr>
						<th scope="row">
							<label for="theme_authoruri">
								<?php _e( 'Author URI:', 'divi-children' ) ?>
							</label>				
						</th>
						<td>
							<input type="text" name="theme_authoruri" size="30" value="<?php echo $theme_authoruri; ?>" />
						</td>
					</tr>			
				</table>
				
				<h3><?php _e( 'Settings for the footer credits:', 'divi-children' ); ?></h3>
				<p class="dch_info" style="width:30%; margin:0 0 10px 0;"><?php _e( 'You can change this settings later via the WordPress Customizer', 'divi-children' ); ?></p>
				
				<table>
					<tr>
						<th scope="row">
							<label for="footerlink_url">
								<?php _e( 'Link URL:', 'divi-children' ) ?>
							</label>
						</th>
						<td>
							<input type="text" name="footerlink_url" size="30" value="<?php echo $footerlink_url; ?>" />
						</td>
					</tr>
					<tr>
						<th scope="row">
							<label for="footerlink_name">
								<?php _e( 'Text to show:', 'divi-children' ) ?>
							</label>
						</th>
						<td>
							<input type="text" name="footerlink_name" size="30" value="<?php echo $footerlink_name; ?>" />
						</td>
					</tr>
					<tr>
						<th scope="row">
							<label for="firstyear">
								<?php _e( 'Site began on:', 'divi-children' ) ?>
							</label>
						</th>
						<td>
							<input type="text" name="firstyear" size="4" value="<?php echo $firstyear; ?>" />
							<span><em><?php _e( 'Leave it blank if you do not want to display your starting year (displays only current year instead of the year range).', 'divi-children' ) ?></em></span>
						</td>				
					</tr>
					
					<tr>
						<th scope="row">
							<label for="developed_text">
								<?php _e( 'Developed By text:', 'divi-children' ) ?>
							</label>
						</th>
						<td>
							<input type="text" name="developed_text" size="30" value="<?php echo $developed_text; ?>" />
							<span><em><?php _e( 'Leave it blank if you do not want to display Developer Credits on your footer.', 'divi-children' ) ?></em></span>
						</td>				
					</tr>				
					
					<tr>
						<th scope="row">
							<label for="developerlink_url">
								<?php _e( 'Developer URL:', 'divi-children' ) ?>
							</label>
						</th>
						<td>
							<input type="text" name="developerlink_url" size="30" value="<?php echo $developerlink_url; ?>" />
						</td>
					</tr>				
					
					<tr>
						<th scope="row">
							<label for="developerlink_name">
								<?php _e( 'Developer name:', 'divi-children' ) ?>
							</label>
						</th>
						<td>
							<input type="text" name="developerlink_name" size="30" value="<?php echo $developerlink_name; ?>" />
						</td>
					</tr>				
					
					<tr>
						<th scope="row">
							<label for="powered_text">
								<?php _e( 'Powered By text:', 'divi-children' ) ?>
							</label>
						</th>
						<td>
							<input type="text" name="powered_text" size="30" value="<?php echo $powered_text; ?>" />
							<span><em><?php _e( 'Leave it blank if you do not want to display the "Powered by" part of the footer credits.', 'divi-children' ) ?></em></span>
						</td>				
					</tr>

					<tr>
						<th scope="row">
							<label for="powered_url">
								<?php _e( 'Powered By URL:', 'divi-children' ) ?>
							</label>
						</th>
						<td>
							<input type="text" name="powered_url" size="30" value="<?php echo $powered_url; ?>" />
						</td>				
					</tr>

					<tr>
						<th scope="row">
							<label for="powered_name">
								<?php _e( 'Powered By name:', 'divi-children' ) ?>
							</label>
						</th>
						<td>
							<input type="text" name="powered_name" size="30" value="<?php echo $powered_name; ?>" />
						</td>				
					</tr>				
					
				</table>

				<p><b><?php _e( 'The credits line will be displayed like this on your footer bottom (proposed default values are shown):', 'divi-children' ) ?></b></p>
				
				<p class="footer-display">
						<?php echo $default_credits; ?>
						<a href="<?php echo $footerlink_url; ?>" title="<?php echo $footerlink_name; ?>"><?php echo $footerlink_name; ?></a>
						<?php echo ' | ' . $developed_text; ?>
						<a href="<?php echo $developerlink_url; ?>" title="<?php echo $developerlink_name; ?>"><?php echo $developerlink_name; ?></a>
						<?php echo ' | ' . $powered_text; ?>
						<a href="<?php echo $powered_url; ?>" title="<?php echo $powered_name; ?>"><?php echo $powered_name; ?></a>

				</p>
							
				<p class="submit">
					<input type="submit" class="button-primary" value="<?php _e( 'Create Divi Child Theme', 'divi-children' ); ?>" />
				</p>
					
			</form>
		</div>

		<div id="change-screenshot">
			<?php require('screenshot.php'); ?>
		</div>

		<div id="update-child">
			<?php require('update-child.php'); ?>
		</div>

		<div id="update-footer">
			<?php require('update-footer.php'); ?>
		</div>
		
	</div>
	
</div>

