<?php

/*
 * Controls plugin CSS and js
 */


function divichildren_admin_scripts() {

	$plugin_dir = plugin_dir_url( __FILE__ );

	wp_enqueue_style( 'divichildren_admin_styles', $plugin_dir . '../css/admin_styles.css' );

	wp_register_script( 'jquerytabs', $plugin_dir . '../js/jquery-ui-tabs.min.js', array( 'jquery' ) );
	wp_enqueue_script( 'jquerytabs' );

	wp_register_script( 'jquerypanes', $plugin_dir . '../js/tabs-panes.js', array( 'jquerytabs' ) );
	wp_enqueue_script( 'jquerypanes' );

	wp_enqueue_media();

	wp_register_script( 'mediaup', $plugin_dir . '../js/mediaup.js', array( 'jquery' ) );
	wp_enqueue_script( 'mediaup' );

}
add_action( 'admin_enqueue_scripts', 'divichildren_admin_scripts' );


// function divichildren__init() {
	// load_plugin_textdomain( 'divi-children', false, dirname( plugin_basename( __FILE__ ) ) . '/lang' );
// }
// add_action('plugins_loaded', 'divichildren__init'); 

?>
