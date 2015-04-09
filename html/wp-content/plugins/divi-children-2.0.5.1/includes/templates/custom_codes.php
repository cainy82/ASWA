<?php
/**
 * Divi Child Theme Custom Selectors and Magic Codes functions
 *
 * Created by Divi Children plugin, http://divi4u.com/divi-children-plugin/ 
 */


function load_custom_metabox_style() {
	// Loads styles for added custom metabox
	wp_register_style( 'custom_metabox_style', get_stylesheet_directory_uri() . '/divi-children-engine/css/custom-metabox.css' );
	wp_enqueue_style( 'custom_metabox_style' );
}
add_action( 'admin_enqueue_scripts', 'load_custom_metabox_style' );


function divi_children_meta_box(){
	add_action( 'add_meta_boxes', 'divi_children_add_custom_boxes' );
}
add_action( 'after_setup_theme', 'divi_children_meta_box' );


function divi_children_add_custom_boxes() {
	$post_types = apply_filters( 'et_pb_builder_post_types', array(
		'page',
		'project',
	) );
	foreach ( $post_types as $post_type ){
		add_meta_box( 'custom_selectors', 'Divi Children Custom Code', 'Divichild_custom_codes', $post_type, 'side', 'default' );
	}
}

/**
 * Custom page box for Divi Children Custom Selectors and Magic Codes
 */
function Divichild_custom_codes() {
	$custom_selectors_classes = array (
		'Sections with Custom Rows (class)' => 'custom_rows_section',
		'Custom Full Width Headers (class)' => 'custom_fullwidth_header',
		'Custom Call To Actions (class)' => 'custom_cta',
	);
	$custom_selectors_ids = array (
		'Custom Sidebars (ID)' => 'custom_sidebar_module',
	);
	$magic_codes = array (
		array ( 'Module'	=>	'Blog module',
				'Codes'		=>	array (
									'newest_post_feed' => 'Forces the blog feed to display the most recent post only.',
									'no_newest_post_feed' => 'Forces the blog feed to display all posts except the most recent one.',
		) ),
	);
	
	?>
	<div id="custom_classes">	
		<h3 class="title_trigger"><span>CUSTOM CSS CLASSES</span><div class="opentrigger" title="Click to toggle"></div><div class="closedtrigger" title="Click to toggle"></div></h3>
		<div class="inside">
			<p><em>Copy any existing Custom CSS class (or create a new one) and paste it on the "CSS Class" field of the Divi module.</em></p>	
			<?php
			foreach ( $custom_selectors_classes as $key => $value ) {
				$custom_selectors = get_custom_selectors($value);
				if ( $custom_selectors ) {
						$next_selector_count = ( count( $custom_selectors ) ) + 1;
					} else {
						$next_selector_count = 1;
				}
				$next_selector = $value . '_' . $next_selector_count;
				?>
				<div id="<?php echo $value;?>">
					<h4><?php echo $key;?></h4>
					<ul>
						<?php
						if ( $custom_selectors ) {		
								foreach ( $custom_selectors as $custom_selector ) {	
									echo '<li><input type="text" style="font-size:13px; background-color:#f8f8ff;" size="23" value="' . $custom_selector . '" /></li>';
								}
							} else {
								echo '<li class="no_custom_selectors">No custom selectors created yet.</li>';
						}
						?>
						<li><input type="text" class="next_selector" style="font-size:13px;" size="23" value="<?php echo $next_selector; ?>" /></li>
					</ul>
					<div class="add_custom_selector">Add a New Class</div>
					<div class="new_selector_created">New class successfully created.</div>
				</div>
				<?php
			}
			?>
		</div>
	</div>

	<div id="custom_ids">	
		<h3 class="title_trigger"><span>CUSTOM CSS IDs</span><div class="opentrigger" title="Click to toggle"></div><div class="closedtrigger" title="Click to toggle"></div></h3>
		<div class="inside">
			<p><em>Copy any existing Custom CSS ID (or create a new one) and paste it on the "CSS ID" field of the Divi section or module.</em></p>	
			<?php
			foreach ( $custom_selectors_ids as $key => $value ) {
				$custom_selectors = get_custom_selectors($value);
				if ( $custom_selectors ) {
						$next_selector_count = ( count( $custom_selectors ) ) + 1;
					} else {
						$next_selector_count = 1;
				}
				$next_selector = $value . '_' . $next_selector_count;
				?>
				<div id="<?php echo $value;?>">
					<h4><?php echo $key;?></h4>
					<ul>
						<?php
						if ( $custom_selectors ) {		
								foreach ( $custom_selectors as $custom_selector ) {	
									echo '<li><input type="text" style="font-size:13px; background-color:#f8f8ff;" size="23" value="' . $custom_selector . '" /></li>';
								}
							} else {
								echo '<li class="no_custom_selectors">No custom selectors created yet.</li>';
						}
						?>
						<li><input type="text" class="next_selector" style="font-size:13px;" size="23" value="<?php echo $next_selector; ?>" /></li>
					</ul>
					<div class="add_custom_selector">Add a New ID</div>
					<div class="new_selector_created">New ID successfully created.</div>
				</div>
				<?php
			}
			?>
		</div>
	</div>	
	
	<div id="magic_selectors">

		<h3 class="title_trigger"><span>MAGIC CODES</span><div class="opentrigger" title="Click to toggle"></div><div class="closedtrigger" title="Click to toggle"></div></h3>
		<div class="inside">
		<p><em>Copy the appropriate Magic Code for the desired functionality and paste it on the "CSS ID" field of the corresponding Divi module.</em></p>
			<div id="magic_codes">
				<?php
				foreach ( $magic_codes as $magic_code_array ) { ?>
					<h4><?php echo $magic_code_array['Module'];?></h4>
					<ul> <?php			
						foreach ( $magic_code_array['Codes'] as $key => $value ) { ?>
							<li><input type="text" style="font-size:13px; background-color:#f8f8ff;" size="20" value="<?php echo $key;?>" /></span><span class="magic_code_info"></span><p class="magic_code_info_text"><?php echo $value;?></p></li> <?php
						} ?>
					</ul> <?php
				} ?>
			</div>
		</div>
	</div> <?php
}


function custom_selectors_action_js() {
	?>
	<script type="text/javascript" >
	jQuery(document).ready(function($) {
	
		$('.next_selector' ).hide();
		$('.add_custom_selector' ).show();
		$('.new_selector_created' ).hide();
		$('.magic_code_info_text' ).hide();
		$('.no_custom_selectors' ).show();
		$('.inside' ).show();		
		$('.opentrigger').show();
		$('.closedtrigger').hide();
		
		$('.add_custom_selector' ).click(function(){
			var affected_id = this.parentNode.id;
			$('#'+affected_id).find('.next_selector' ).show();
			$(this).hide();
			var next_selector = $('#'+affected_id).find('.next_selector' ).val();
			var data = {
				'action': 'custom_selectors_action',
				'selector': next_selector,
			};
			$.post(ajaxurl, data, function() {
				$('#'+affected_id).find('.new_selector_created' ).show();
				$('#'+affected_id).find('.no_custom_selectors' ).hide();			
			});
		});
	
		$(".title_trigger").toggle(
			function() {
				$(this).next(".inside").hide();
				$(this).find(".opentrigger").hide();
				$(this).find('.closedtrigger').show();
			},
			function() {
				$(this).next(".inside").show();
				$(this).find('.opentrigger').show();
				$(this).find('.closedtrigger').hide();
			}		
		) // end of toggle()

		$(".magic_code_info").toggle(
			function() {
				$(this).next(".magic_code_info_text").show();
			},
			function() {
				$(this).next(".magic_code_info_text").hide();
			}		
		) // end of toggle()

	});
	</script>
	<?php
}
add_action( 'admin_head', 'custom_selectors_action_js' );


function custom_selectors_action_callback() {
    $selector = $_POST['selector'];
	set_theme_mod( $selector, 'on' );
    exit();
}
add_action( 'wp_ajax_custom_selectors_action', 'custom_selectors_action_callback' );

