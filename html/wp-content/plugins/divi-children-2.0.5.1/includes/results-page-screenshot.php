<?php
/*
 * Changed child theme screenshot results page
 */
 

?>

<div id="screenshot_changed" class="main-panel">

	<h3><?php _e( 'The screenshot was successfully changed!', 'divi-children' ); ?></h3>
		
	<div id="new_screenshot">
		<p><?php _e( 'This is the new screenshot for your child theme', 'divi-children' ); ?><b><?php echo ' ' . $screenshot_changed['theme_changed'] . ': '; ?></b></p>
		<div class="theme_screenshot">
			<img src="<?php echo $screenshot_changed['new_screenshot']; ?>" alt="screenshot">
		</div>	
	</div>	
	
	
</div>

