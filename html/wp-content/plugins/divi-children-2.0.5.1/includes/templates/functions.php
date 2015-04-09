<?php
/**
 * Functions - Child theme custom functions
 */


/*****************************************************************************************************************
Caution: do not remove this or you will lose all the customization capabilities created by Divi Children plugin */
require_once('divi-children-engine/divi_children_engine.php');
/****************************************************************************************************************/


/**
 * Patch to fix Divi issue: Duplicated Predefined Layouts.
 */
remove_action( 'admin_init', 'et_pb_update_predefined_layouts' );
function Divichild_pb_update_predefined_layouts() {
		if ( 'on' === get_theme_mod( 'et_pb_predefined_layouts_updated_2_0' ) ) {
			return;
		}
		if ( ! get_theme_mod( 'et_pb_predefined_layouts_added' ) OR ( 'on' === get_theme_mod( 'et_pb_predefined_layouts_added' ) )) {	
			et_pb_delete_predefined_layouts();
		}
		et_pb_add_predefined_layouts();
		set_theme_mod( 'et_pb_predefined_layouts_updated_2_0', 'on' );
}
add_action( 'admin_init', 'Divichild_pb_update_predefined_layouts' );



?>