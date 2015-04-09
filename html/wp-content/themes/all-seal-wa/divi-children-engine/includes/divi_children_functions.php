<?php
/**
 * Divi Child Theme customizing functions
 *
 * Created by Divi Children plugin, http://divi4u.com/divi-children-plugin/ 
 */

 
/**
 * Footer credits
 */
function Divichild_footer_credits_generator() {
	$firstyear_default = date( 'Y' ) - 1;
	$firstyear = get_theme_mod( 'footer_credits_firstyear', get_option( 'footer_credits_firstyear' ) );
	$owner = get_theme_mod( 'footer_credits_owner', get_option( 'footer_credits_owner' ) );
	$ownerlink = get_theme_mod( 'footer_credits_ownerlink', get_option( 'footer_credits_ownerlink' ) );
	$developed_text = get_theme_mod( 'footer_credits_developed', get_option( 'footer_credits_developed' ) );
	$developer = get_theme_mod( 'footer_credits_developer', get_option( 'footer_credits_developer' ) );
	$developerlink = get_theme_mod( 'footer_credits_developerlink', get_option( 'footer_credits_developerlink' ) );		
	$powered_text = get_theme_mod( 'footer_credits_powered', get_option( 'footer_credits_powered' ) );
	$powered_code = get_theme_mod( 'footer_credits_poweredcode', get_option( 'footer_credits_poweredcode' ) );
	$powered_codelink = get_theme_mod( 'footer_credits_poweredcodelink', get_option( 'footer_credits_poweredcodelink' ) );		
	$footer_credits = 'Copyright &copy; ';
	$current_year = date( 'Y' );
		if ( $firstyear AND ($firstyear != $current_year ) AND ($firstyear != 0 ) ) {
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
	return $footer_credits;
}


/**
 * Post meta with or without icons
 */
function et_postinfo_meta( $postinfo, $date_format, $comment_zero, $comment_one, $comment_more ){
	$postinfo_meta = '';
	if (get_theme_mod( 'postmeta_with_icons' )) {
			if (get_theme_mod( 'postmeta_same_icons_color' )) {
					$postmeta_author_color = get_theme_mod( 'postmeta_icon_color', '#318EC3' );
					$postmeta_date_color = get_theme_mod( 'postmeta_icon_color', '#318EC3' );
					$postmeta_categories_color = get_theme_mod( 'postmeta_icon_color', '#318EC3' );
					$postmeta_comments_color = get_theme_mod( 'postmeta_icon_color', '#318EC3' );				
				} else {
					$postmeta_author_color = get_theme_mod( 'postmeta_author_color', '#318EC3' );
					$postmeta_date_color = get_theme_mod( 'postmeta_date_color', '#318EC3' );
					$postmeta_categories_color = get_theme_mod( 'postmeta_categories_color', '#318EC3' );
					$postmeta_comments_color = get_theme_mod( 'postmeta_comments_color', '#318EC3' );
			}
			$postmeta_icon_color = get_theme_mod( 'postmeta_icon_color', '#318EC3' );
			if ( in_array( 'author', $postinfo ) ) $postinfo_meta .= '<span class="icon_profile" style="color:'.$postmeta_author_color.'"></span>' . et_get_the_author_posts_link();
			if ( in_array( 'date', $postinfo ) ) $postinfo_meta .= '<span class="icon_calendar" style="color:'.$postmeta_date_color.'"></span>' . get_the_time( $date_format );
			if ( in_array( 'categories', $postinfo ) ) $postinfo_meta .= '<span class="icon_clipboard" style="color:'.$postmeta_categories_color.'"></span>' . get_the_category_list(', ' );
			if ( in_array( 'comments', $postinfo ) ) $postinfo_meta .= '<span class="icon_chat" style="color:'.$postmeta_comments_color.'"></span>' . et_get_comments_popup_link( $comment_zero, $comment_one, $comment_more );
		} else {
			global $themename;
			if ( in_array( 'author', $postinfo ) ) $postinfo_meta .= ' ' . esc_html__('by', $themename) . ' ' . et_get_the_author_posts_link() . ' | ';
			if ( in_array( 'date', $postinfo ) ) $postinfo_meta .= get_the_time( $date_format ) . ' | ';
			if ( in_array( 'categories', $postinfo ) ) $postinfo_meta .= get_the_category_list(', ' )  . ' | ';
			if ( in_array( 'comments', $postinfo ) ) $postinfo_meta .= et_get_comments_popup_link( $comment_zero, $comment_one, $comment_more );		
	}
	echo $postinfo_meta;
}


/**
 * Post meta tags with icon at end of post
 */
function Divichild_post_tags( $content ) {
	if ( get_theme_mod( 'tags_after_content' ) ) {
		if( is_single() ) {		
			$posttags = get_the_tags();
			if ( $posttags ) {		
				$content .= '<p>';
				if ( get_theme_mod( 'postmeta_with_icons' ) ) {
						if ( get_theme_mod( 'postmeta_same_icons_color' ) ) {
							$postmeta_tags_color = get_theme_mod( 'postmeta_icon_color', '#318EC3' );
							} else {
								$postmeta_tags_color = get_theme_mod( 'postmeta_tags_color', '#318EC3' );
						}				
						$content .= '<span class="icon_tags" style="color:'.$postmeta_tags_color.'"></span>';
					} else {
						$content .= '<em>Tagged: </em>';
				}
				$count = 0;
				foreach( $posttags as $tag ) {
					if ($count > 0) {
						$content .= ', ';
					}
					$content .= '<a href="' . get_home_url() . '/tag/' . $tag->slug . '">' . $tag->name . '</a>';
					$count++;
				}
				$content .= '</p>';
			}
		}
	}
	return $content;	
}
add_filter( 'the_content', 'Divichild_post_tags', 1 );

 
/**
 * Adds Divi Children sections, settings and controls to the Theme Customizer
 */
function Divichild_customizer( $wp_customize ) {

    $wp_customize->add_section( 'divi_children_settings_control', array(
		'title' => 'Divi Child Settings Control',
		'description' => 'Once you have finished customizing some parts of your site you may want those settings to be hidden, so you get a less cluttered Customizer. Here you can check any section and it will not appear the next time you open the Customizer (you can uncheck it back at any time).',
		'capability' => 'edit_theme_options',
		'priority' => 200,
	) );
	
	if (  ! get_theme_mod( 'hide_settings_main_footer', false ) ) {
		$wp_customize->add_section( 'divi_children_main_footer', array(
			'title' => 'Divi Child - Main Footer',
			'description' => 'Options for the main footer of your child theme powered by the Divi Children Engine.',
			'capability' => 'edit_theme_options',
			'priority' => 201,
		) );
	}

	if (  ! get_theme_mod( 'hide_settings_footer_bottom', false ) ) {
		$wp_customize->add_section( 'divi_children_footer_bottom', array(
			'title' => 'Divi Child - Footer Bottom',
			'description' => 'Options for the footer bottom of your child theme powered by the Divi Children Engine.',
			'capability' => 'edit_theme_options',
			'priority' => 202,
		) );	
	}

	if (  ! get_theme_mod( 'hide_settings_footer_credits', false ) ) {
		$wp_customize->add_section( 'divi_children_footer_credits', array(
			'title' => 'Divi Child - Footer Credits',
			'description' => 'Options for the footer credits of your child theme powered by the Divi Children Engine. Leaving blank the fields marked as (optional) will prevent the affected part of the credits from being displayed.',
			'capability' => 'edit_theme_options',
			'priority' => 203,
		) );	
	}

	if (  ! get_theme_mod( 'hide_settings_sidebar', false ) ) {
		$wp_customize->add_section( 'divi_children_sidebar', array(
			'title' => 'Divi Child - Main Sidebar',
			'description' => 'Options for the main sidebar of your child theme powered by the Divi Children Engine.',
			'capability' => 'edit_theme_options',
			'priority' => 204,
		) );
	}
	
	if (  ! get_theme_mod( 'hide_settings_posts_meta', false ) ) {
		$wp_customize->add_section( 'divi_children_posts_meta', array(
			'title' => 'Divi Child - Post Meta Data',
			'description' => 'Options for the post meta data of your child theme powered by the Divi Children Engine.',
			'capability' => 'edit_theme_options',
			'priority' => 205,
		) );
	}
	
	$custom_rows_sections = get_custom_selectors( 'custom_rows_section' );
	if ( $custom_rows_sections ) {
		foreach ( $custom_rows_sections as $key => $value ) {
			$key++;
			if (  ! get_theme_mod( 'hide_settings_custom_rows_section_' . $key, false ) ) {
				$wp_customize->add_section( 'divi_children_custom_rows_section_' . $key, array(
					'title' => 'Divi Child - Custom Rows Section ' . $key,
					'description' => 'Settings for the custom rows of sections with the custom class <b>custom_rows_section_' . $key . '</b>',
					'capability' => 'edit_theme_options',
					'priority' => 210+$key,
				) );
			}
		}
	}
	
	$custom_fw_headers = get_custom_selectors( 'custom_fullwidth_header' );
	if ( $custom_fw_headers ) {
		foreach ( $custom_fw_headers as $key => $value ) {
			$key++;
			if (  ! get_theme_mod( 'hide_settings_custom_fullwidth_header_' . $key, false ) ) {
				$wp_customize->add_section( 'divi_children_custom_headers_' . $key, array(
					'title' => 'Divi Child - Full Width Header ' . $key,
					'description' => 'Settings for Full Witdh Headers with the custom class <b>custom_fullwidth_header_' . $key . '</b>',
					'capability' => 'edit_theme_options',
					'priority' => 220+$key,
				) );
			}
		}
	}
	
	$custom_sidebar_modules = get_custom_selectors( 'custom_sidebar_module' );
	if ( $custom_sidebar_modules ) {
		foreach ( $custom_sidebar_modules as $key => $value ) {
			$key++;
			if (  ! get_theme_mod( 'hide_settings_custom_sidebar_module_' . $key, false ) ) {
				$wp_customize->add_section( 'divi_children_custom_sidebars_' . $key, array(
					'title' => 'Divi Child - Custom Sidebar ' . $key,
					'description' => 'Settings for Custom Sidebars with the custom class <b>custom_sidebar_module_' . $key . '</b>',
					'capability' => 'edit_theme_options',
					'priority' => 230+$key,
				) );
			}
		}
	}
	
	$custom_ctas = get_custom_selectors( 'custom_cta' );
	if ( $custom_ctas ) {
		foreach ( $custom_ctas as $key => $value ) {
			$key++;
			if (  ! get_theme_mod( 'hide_settings_custom_cta_' . $key, false ) ) {			
				$wp_customize->add_section( 'divi_children_custom_ctas_' . $key, array(
					'title' => 'Divi Child - Call To Action ' . $key,
					'description' => 'Settings for Call To Actions with the custom class <b>custom_cta_' . $key . '</b>',
					'capability' => 'edit_theme_options',
					'priority' => 240+$key,
				) );
			}
		}
	}

	$divi_children_customizer_settings = array (
		'Hide Main Footer' => 'hide_settings_main_footer',
		'Hide Footer Bottom' => 'hide_settings_footer_bottom',
		'Hide Footer Credits' => 'hide_settings_footer_credits',		
		'Hide Main Sidebar' => 'hide_settings_sidebar',
		'Hide Post Meta Data' => 'hide_settings_posts_meta',
		'Hide Custom Rows Section' => $custom_rows_sections,
		'Hide Full Width Header' => $custom_fw_headers,
		'Hide Custom Sidebar' => $custom_sidebar_modules,
		'Hide Call To Action' => $custom_ctas,
	);
	$divi_children_settings_count = 1;
	foreach ( $divi_children_customizer_settings as $key => $value ) {
		if ( is_array( $value ) ) {
				foreach ( $value as $subkey => $subvalue ) {
					$subkey++;
					$wp_customize->add_setting( 'hide_settings_' . $subvalue, array(
						'default' => false,
					) ); 				
					$wp_customize->add_control( 'hide_settings_' . $subvalue, array(
						'type' => 'checkbox',
						'label' => $key . ' ' . $subkey . ' section',
						'section' => 'divi_children_settings_control',
						'priority' => $divi_children_settings_count . $subkey,		
					) );
				}
			} elseif ( $value ) {
				$divi_children_settings_count++;
				$wp_customize->add_setting( $value, array(
					'default' => false,
				) ); 
				$wp_customize->add_control( $value, array(
					'type' => 'checkbox',
					'label' => $key . ' section',
					'section' => 'divi_children_settings_control',
					'priority' => $divi_children_settings_count,		
				) );
		}
	}
	
	// Post meta Data
	
	$wp_customize->add_setting( 'postmeta_with_icons', array(
		'default' => true,
	) ); 
	$wp_customize->add_control( 'postmeta_with_icons', array(
		'type' => 'checkbox',
		'label' => 'Display Post Meta with icons',
		'section' => 'divi_children_posts_meta',
		'settings' => 'postmeta_with_icons',
		'priority' => 10,
	) );

	$wp_customize->add_setting( 'tags_after_content', array(
		'default' => true,
	) ); 
	$wp_customize->add_control( 'tags_after_content', array(
		'type' => 'checkbox',
		'label' => 'Display Tags below content',
		'section' => 'divi_children_posts_meta',
		'settings' => 'tags_after_content',
		'priority' => 20,
	) );

	$wp_customize->add_setting( 'postmeta_icon_color', array(
		'default' => '#318ec3',
		'sanitize_callback' => 'sanitize_hex_color',
	) );
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'postmeta_icon_color', array(
		'label' => 'Post Meta Data icons color',
		'section' => 'divi_children_posts_meta',
		'settings' => 'postmeta_icon_color',
		'priority' => 30,		
	) ) );

	$wp_customize->add_setting( 'postmeta_same_icons_color', array(
		'default' => true,
	) ); 
	$wp_customize->add_control( 'postmeta_same_icons_color', array(
		'type' => 'checkbox',
		'label' => 'Use the same color for all icons',
		'section' => 'divi_children_posts_meta',
		'settings' => 'postmeta_same_icons_color',
		'priority' => 40,
	) );

	$wp_customize->add_setting( 'postmeta_author_color', array(
		'default' => '#318ec3',
		'sanitize_callback' => 'sanitize_hex_color',
	) );
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'postmeta_author_color', array(
		'label' => 'Author icon color',
		'section' => 'divi_children_posts_meta',
		'settings' => 'postmeta_author_color',
		'priority' => 50,		
	) ) );
	
	$wp_customize->add_setting( 'postmeta_date_color', array(
		'default' => '#318ec3',
		'sanitize_callback' => 'sanitize_hex_color',
	) );
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'postmeta_date_color', array(
		'label' => 'Date icon color',
		'section' => 'divi_children_posts_meta',
		'settings' => 'postmeta_date_color',
		'priority' => 60,		
	) ) );
	
	$wp_customize->add_setting( 'postmeta_categories_color', array(
		'default' => '#318ec3',
		'sanitize_callback' => 'sanitize_hex_color',
	) );
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'postmeta_categories_color', array(
		'label' => 'Categories icon color',
		'section' => 'divi_children_posts_meta',
		'settings' => 'postmeta_categories_color',
		'priority' => 70,		
	) ) );

	$wp_customize->add_setting( 'postmeta_comments_color', array(
		'default' => '#318ec3',
		'sanitize_callback' => 'sanitize_hex_color',
	) );
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'postmeta_comments_color', array(
		'label' => 'Comments icon color',
		'section' => 'divi_children_posts_meta',
		'settings' => 'postmeta_comments_color',
		'priority' => 80,		
	) ) );

	$wp_customize->add_setting( 'postmeta_tags_color', array(
		'default' => '#318ec3',
		'sanitize_callback' => 'sanitize_hex_color',
	) );
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'postmeta_tags_color', array(
		'label' => 'Tags icon color',
		'section' => 'divi_children_posts_meta',
		'settings' => 'postmeta_tags_color',
		'priority' => 90,		
	) ) );

	// Sections with Custom Rows
	if ($custom_rows_sections) {
		foreach ($custom_rows_sections as $key => $value) {
			$key++;

			$wp_customize->add_setting( 'crs_section_top_padding_' . $key, array(
				'default' => '50px',
			) );
			$wp_customize->add_control( 'crs_section_top_padding_' . $key, array(
				'type' => 'select',
				'label' => 'Section top padding',
				'section' => 'divi_children_custom_rows_section_' . $key,
				'choices' => array(
									'100px' => '100px',
									'90px' => '90px',				
									'80px' => '80px',
									'70px' => '70px',
									'60px' => '60px',
									'50px' => '50px',
									'40px' => '40px',
									'30px' => '30px',
									'25px' => '25px',
									'20px' => '20px',
									'15px' => '15px',
									'10px' => '10px',
									'5px' => '5px',
									'0px' => '0px',
									),
				'priority' => 10,
			) );
			$wp_customize->add_setting( 'crs_section_bottom_padding_' . $key, array(
				'default' => '50px',
			) );
			
			$wp_customize->add_control( 'crs_section_bottom_padding_' . $key, array(
				'type' => 'select',
				'label' => 'Section bottom padding',
				'section' => 'divi_children_custom_rows_section_' . $key,
				'choices' => array(
									'100px' => '100px',
									'90px' => '90px',									
									'80px' => '80px',
									'70px' => '70px',
									'60px' => '60px',
									'50px' => '50px',
									'40px' => '40px',
									'30px' => '30px',
									'25px' => '25px',
									'20px' => '20px',
									'15px' => '15px',
									'10px' => '10px',
									'5px' => '5px',
									'0px' => '0px',
									),
				'priority' => 20,
			) );			
			
			$wp_customize->add_setting( 'crs_top_margin_' . $key, array(
				'default' => '50px',
			) );
			$wp_customize->add_control( 'crs_top_margin_' . $key, array(
				'type' => 'select',
				'label' => 'Rows top margin',
				'section' => 'divi_children_custom_rows_section_' . $key,
				'choices' => array(
									'100px' => '100px',
									'90px' => '90px',
									'80px' => '80px',
									'70px' => '70px',
									'60px' => '60px',
									'50px' => '50px',
									'40px' => '40px',
									'30px' => '30px',
									'20px' => '20px',
									'10px' => '10px',																						
									),
				'priority' => 30,
			) );
			
			$wp_customize->add_setting( 'crs_padding_' . $key, array(
				'default' => 15,
			) );
			$wp_customize->add_control( 'crs_padding_' . $key, array(
				'type' => 'select',
				'label' => 'Rows padding',
				'section' => 'divi_children_custom_rows_section_' . $key,
				'choices' => array(
									25 => '25px',
									20 => '20px',
									15 => '15px',
									10 => '10px',
									5 => '5px',
									0 => '0px',									
									),
				'priority' => 40,
			) );
			
			$wp_customize->add_setting( 'crs_background_color_' . $key, array(
				'default' => '#ffffff',
				'sanitize_callback' => 'sanitize_hex_color',
			) );
			$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'crs_background_color_' . $key, array(
				'label' => 'Rows background color',
				'section' => 'divi_children_custom_rows_section_' . $key,
				'settings' => 'crs_background_color_' . $key,
				'priority' => 50,
			) ) );
			
			$wp_customize->add_setting( 'crs_background_opacity_' . $key, array(
				'default' => '1',
			) );
			$wp_customize->add_control( 'crs_background_opacity_' . $key, array(
				'type' => 'select',
				'label' => 'Rows background opacity',
				'section' => 'divi_children_custom_rows_section_' . $key,
				'choices' => array(
									'1' => 'No Transparency',
									'0.9' => '10%',
									'0.8' => '20%',
									'0.7' => '30%',
									'0.6' => '40%',
									'0.5' => '50%',
									'0.4' => '60%',
									'0.3' => '70%',
									'0.2' => '80%',
									'0.1' => '90%',
									'0' => 'Fully Transparent',
									),																		
				'priority' => 60,
			) );

		}
	}	

	// Custom Full Width Headers
	if ( $custom_fw_headers ) {
		foreach ( $custom_fw_headers as $key => $value ) {
			$key++;	
			
			$wp_customize->add_setting( 'custom_header_top_padding_' . $key, array(
				'default' => '50px',
			) );
			$wp_customize->add_control( 'custom_header_top_padding_' . $key, array(
				'type' => 'select',
				'label' => 'Top padding',
				'section' => 'divi_children_custom_headers_' . $key,
				'choices' => array(
									'70px' => '70px',
									'60px' => '60px',
									'50px' => '50px',
									'45px' => '45px',
									'40px' => '40px',
									'35px' => '35px',
									'30px' => '30px',
									'25px' => '25px',
									'20px' => '20px',
									'15px' => '15px',
									'10px' => '10px',																						
									),
				'priority' => 10,
			) );
			
			$wp_customize->add_setting( 'custom_header_bottom_padding_' . $key, array(
				'default' => '50px',
			) );
			$wp_customize->add_control( 'custom_header_bottom_padding_' . $key, array(
				'type' => 'select',
				'label' => 'Bottom padding',
				'section' => 'divi_children_custom_headers_' . $key,
				'choices' => array(
									'70px' => '70px',
									'60px' => '60px',
									'50px' => '50px',
									'45px' => '45px',
									'40px' => '40px',
									'35px' => '35px',
									'30px' => '30px',
									'25px' => '25px',
									'20px' => '20px',
									'15px' => '15px',
									'10px' => '10px',																						
									),
				'priority' => 20,
			) );			

			$wp_customize->add_setting( 'ch_header_color_' . $key, array(
				'default' => '#999999',
				'sanitize_callback' => 'sanitize_hex_color',
			) );
			$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'ch_header_color_' . $key, array(
				'label' => 'Header font color',
				'section' => 'divi_children_custom_headers_' . $key,
				'settings' => 'ch_header_color_' . $key,
				'priority' => 30,
			) ) );
			
			$wp_customize->add_setting( 'ch_header_size_' . $key, array(
				'default' => '30px',
			) );
			$wp_customize->add_control( 'ch_header_size_' . $key, array(
				'type' => 'select',
				'label' => 'Header font size',
				'section' => 'divi_children_custom_headers_' . $key,
				'choices' => array(
									'40px' => '40px',
									'38px' => '38px',
									'36px' => '36px',
									'34px' => '34px',
									'32px' => '32px',
									'30px' => '30px',
									'28px' => '28px',
									'26px' => '26px',
									'24px' => '24px',
									'22px' => '22px',
									'20px' => '20px',
									),
				'priority' => 40,
			) );			
			
			$wp_customize->add_setting( 'ch_subheader_color_' . $key, array(
				'default' => '#999999',
				'sanitize_callback' => 'sanitize_hex_color',
			) );
			$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'ch_subheader_color_' . $key, array(
				'label' => 'Subheader font color',
				'section' => 'divi_children_custom_headers_' . $key,
				'settings' => 'ch_subheader_color_' . $key,
				'priority' => 50,
			) ) );
			
			$wp_customize->add_setting( 'ch_subheader_size_' . $key, array(
				'default' => '16px',
			) );
			$wp_customize->add_control( 'ch_subheader_size_' . $key, array(
				'type' => 'select',
				'label' => 'Subheader font size',
				'section' => 'divi_children_custom_headers_' . $key,
				'choices' => array(
									'20px' => '20px',
									'19px' => '19px',
									'18px' => '18px',
									'17px' => '17px',
									'16px' => '16px',
									'15px' => '15px',
									'14px' => '14px',
									'13px' => '13px',
									'12px' => '12px',						
									),
				'priority' => 60,
			) );

		}
	}	

	// Custom Sidebars
	if ($custom_sidebar_modules) {
		foreach ($custom_sidebar_modules as $key => $value) {
			$key++;	
			$wp_customize->add_setting( 'sidebar_widget_leftmargin_' . $key, array(
				'default' => '30px',
			) );
			$wp_customize->add_control( 'sidebar_widget_leftmargin_' . $key, array(
				'type' => 'select',
				'label' => 'Sidebar left margin',
				'section' => 'divi_children_custom_sidebars_' . $key,
				'choices' => array(
									'50px' => '50px',
									'45px' => '45px',
									'40px' => '40px',
									'35px' => '35px',
									'30px' => '30px',
									'25px' => '25px',
									'20px' => '20px',
									'15px' => '15px',
									'10px' => '10px',
									'5px' => '5px',
									'0px' => '0px',							
									),
				'priority' => 10,
			) );
			
			$wp_customize->add_setting( 'sidebar_no_vertical_divider_' . $key, array(
				'default' => false,
			) ); 
			$wp_customize->add_control( 'sidebar_no_vertical_divider_' . $key, array(
				'type' => 'checkbox',
				'label' => 'Hide vertical divider line',
				'section' => 'divi_children_custom_sidebars_' . $key,
				'priority' => 20,		
			) );

			$wp_customize->add_setting( 'sidebar_widget_bottommargin_' . $key, array(
				'default' => '30px',
			) );
			$wp_customize->add_control( 'sidebar_widget_bottommargin_' . $key, array(
				'type' => 'select',
				'label' => 'Widgets bottom margin',
				'section' => 'divi_children_custom_sidebars_' . $key,
				'choices' => array(
									'50px' => '50px',
									'45px' => '45px',
									'40px' => '40px',
									'35px' => '35px',
									'30px' => '30px',
									'25px' => '25px',
									'20px' => '20px',
									'15px' => '15px',
									'10px' => '10px',
									'5px' => '5px',
									'0px' => '0px',							
									),
				'priority' => 30,
			) );

			$wp_customize->add_setting( 'sidebar_widgettitle_color_' . $key, array(
				'default' => '#333',
				'sanitize_callback' => 'sanitize_hex_color',
			) );
			$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'sidebar_widgettitle_color_' . $key, array(
				'label' => 'Widget Titles color',
				'section' => 'divi_children_custom_sidebars_' . $key,
				'settings' => 'sidebar_widgettitle_color_' . $key,
				'priority' => 40,
			) ) );

			$wp_customize->add_setting( 'sidebar_widgettitle_size_' . $key, array(
				'default' => '18px',
			) );
			$wp_customize->add_control( 'sidebar_widgettitle_size_' . $key, array(
				'type' => 'select',
				'label' => 'Widget Titles font size',
				'section' => 'divi_children_custom_sidebars_' . $key,
				'choices' => array(								
									'22px' => '22px',
									'21px' => '21px',
									'20px' => '20px',
									'19px' => '19px',
									'18px' => '18px',
									'17px' => '17px',
									'16px' => '16px',
									'15px' => '15px',
									'14px' => '14px',																					
									),
				'priority' => 50,
			) );

			$wp_customize->add_setting( 'sidebar_widgettitle_uppercase_' . $key, array(
				'default' => false,
			) ); 
			$wp_customize->add_control( 'sidebar_widgettitle_uppercase_' . $key, array(
				'type' => 'checkbox',
				'label' => 'Uppercase titles',
				'section' => 'divi_children_custom_sidebars_' . $key,
				'priority' => 60,		
			) );

			$wp_customize->add_setting( 'sidebar_boxed_widgettitle_' . $key, array(
				'default' => false,
			) ); 
			$wp_customize->add_control( 'sidebar_boxed_widgettitle_' . $key, array(
				'type' => 'checkbox',
				'label' => 'Boxed titles with background',
				'section' => 'divi_children_custom_sidebars_' . $key,
				'priority' => 70,		
			) );

			$wp_customize->add_setting( 'sidebar_boxed_widgettitle_backcolor_' . $key, array(
				'default' => '#eee',
				'sanitize_callback' => 'sanitize_hex_color',
			) );
			$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'sidebar_boxed_widgettitle_backcolor_' . $key, array(
				'label' => 'Boxed titles background color',
				'section' => 'divi_children_custom_sidebars_' . $key,
				'settings' => 'sidebar_boxed_widgettitle_backcolor_' . $key,
				'priority' => 80,
			) ) );

			$wp_customize->add_setting( 'sidebar_boxed_widgettitle_vertpadding_' . $key, array(
				'default' => '10px',
			) );
			$wp_customize->add_control( 'sidebar_boxed_widgettitle_vertpadding_' . $key, array(
				'type' => 'select',
				'label' => 'Boxed titles vertical padding',
				'section' => 'divi_children_custom_sidebars_' . $key,
				'choices' => array(
									'30px' => '30px',
									'25px' => '25px',
									'20px' => '20px',
									'18px' => '18px',
									'16px' => '16px',
									'14px' => '14px',
									'12px' => '12px',
									'10px' => '10px',
									'8px' => '8px',
									'6px' => '6px',
									'4px' => '4px',
									'2px' => '2px',																						
									),
				'priority' => 90,
			) );

			$wp_customize->add_setting( 'sidebar_widget_elements_type_' . $key, array(
				'default' => 'Divi original without bullets',
			) );
			$wp_customize->add_control( 'sidebar_widget_elements_type_' . $key, array(
				'type' => 'select',
				'label' => 'Widget elements style:',
				'section' => 'divi_children_custom_sidebars_' . $key,
				'choices' => array(
									'original' => 'Divi original without bullets',
									'bullets' => 'Round bullets',
									'squares' => 'Square bullets',
									'arrows' => 'Arrow Head bullets',
									'line' => 'Left vertical line',
									'background' => 'Boxed with background',
									'line-background' => 'Background + left vertical line',																					
									),
				'priority' => 100,
			) );

			$wp_customize->add_setting( 'sidebar_widget_elements_bkgndcolor_' . $key, array(
				'default' => '#f4f4f4',
				'sanitize_callback' => 'sanitize_hex_color',
			) );
			$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'sidebar_widget_elements_bkgndcolor_' . $key, array(
				'label' => 'Widget elements background color',
				'section' => 'divi_children_custom_sidebars_' . $key,
				'settings' => 'sidebar_widget_elements_bkgndcolor_' . $key,
				'priority' => 110,
			) ) );

			$wp_customize->add_setting( 'sidebar_widgettext_color_' . $key, array(
				'default' => '#666',
				'sanitize_callback' => 'sanitize_hex_color',
			) );
			$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'sidebar_widgettext_color_' . $key, array(
				'label' => 'Widget text and links color',
				'section' => 'divi_children_custom_sidebars_' . $key,
				'settings' => 'sidebar_widgettext_color_' . $key,
				'priority' => 120,
			) ) );

			$wp_customize->add_setting( 'sidebar_widgethover_color_' . $key, array(
				'default' => '#2ea3f2',
				'sanitize_callback' => 'sanitize_hex_color',
			) );
			$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'sidebar_widgethover_color_' . $key, array(
				'label' => 'Widget links hover color',
				'section' => 'divi_children_custom_sidebars_' . $key,
				'settings' => 'sidebar_widgethover_color_' . $key,
				'priority' => 130,
			) ) );
			
			$wp_customize->add_setting( 'sidebar_widgettext_size_' . $key, array(
				'default' => '14px',
			) );	
			$wp_customize->add_control( 'sidebar_widgettext_size_' . $key, array(
				'type' => 'select',
				'label' => 'Widget text and links font size',
				'section' => 'divi_children_custom_sidebars_' . $key,
				'choices' => array(	
									'16px' => '16px',
									'15px' => '15px',
									'14px' => '14px',
									'13px' => '13px',
									'12px' => '12px',							
									),
				'priority' => 140,
			) );

			$wp_customize->add_setting( 'sidebar_bullets_color_' . $key, array(
				'default' => get_theme_mod( 'sidebar_widgettitle_color_' . $key, '#333' ),
				'sanitize_callback' => 'sanitize_hex_color',
			) );
			$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'sidebar_bullets_color_' . $key, array(
				'label' => 'Widget bullets color',
				'section' => 'divi_children_custom_sidebars_' . $key,
				'settings' => 'sidebar_bullets_color_' . $key,
				'priority' => 150,
			) ) );
			
		}
	}
	
	// Custom Call to Actions
	if ($custom_ctas) {
		foreach ($custom_ctas as $key => $value) {
			$key++;
			
			$wp_customize->add_setting( 'ccta_width_' . $key, array(
				'default' => 'Full Column',
			) );
			$wp_customize->add_control( 'ccta_width_' . $key, array(
				'type' => 'select',
				'label' => 'Module width',
				'section' => 'divi_children_custom_ctas_' . $key,
				'choices' => array(
									'100%' => 'Full Column',
									'80%' => '80%',
									'70%' => '70%',
									'60%' => '60%',
									'50%' => '50%',
									'40%' => '40%',
									'30%' => '30%',
									'20%' => '20%',
									),																		
				'priority' => 10,
			) );

			$wp_customize->add_setting( 'ccta_vertical_padding_' . $key, array(
				'default' => '40px',
			) );
			$wp_customize->add_control( 'ccta_vertical_padding_' . $key, array(
				'type' => 'select',
				'label' => 'Module vertical padding',
				'section' => 'divi_children_custom_ctas_' . $key,
				'choices' => array(
									'70px' => '70px',
									'65px' => '65px',
									'60px' => '60px',
									'55px' => '55px',
									'50px' => '50px',
									'45px' => '45px',
									'40px' => '40px',
									'35px' => '35px',
									'30px' => '30px',
									'25px' => '25px',
									'20px' => '20px',
									'15px' => '15px',
									'10px' => '10px',																						
									),
				'priority' => 20,
			) );
			
			$wp_customize->add_setting( 'ccta_horizontal_padding_' . $key, array(
				'default' => '60px',
			) );
			$wp_customize->add_control( 'ccta_horizontal_padding_' . $key, array(
				'type' => 'select',
				'label' => 'Module horizontal padding',
				'section' => 'divi_children_custom_ctas_' . $key,
				'choices' => array(
									'110px' => '110px',
									'100px' => '100px',
									'90px' => '90px',
									'80px' => '80px',
									'70px' => '70px',
									'60px' => '60px',
									'50px' => '50px',
									'40px' => '40px',
									'30px' => '30px',
									'20px' => '20px',
									'10px' => '10px',																						
									),
				'priority' => 30,
			) );
			
			$wp_customize->add_setting( 'ccta_background_color_' . $key, array(
				'default' => '#7ebec5',
				'sanitize_callback' => 'sanitize_hex_color',
			) );
			$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'ccta_background_color_' . $key, array(
				'label' => 'Module background color',
				'section' => 'divi_children_custom_ctas_' . $key,
				'settings' => 'ccta_background_color_' . $key,
				'priority' => 40,
			) ) );
			
			$wp_customize->add_setting( 'ccta_background_opacity_' . $key, array(
				'default' => '1',
			) );
			$wp_customize->add_control( 'ccta_background_opacity_' . $key, array(
				'type' => 'select',
				'label' => 'Background opacity',
				'section' => 'divi_children_custom_ctas_' . $key,
				'choices' => array(
									'1' => 'No Transparency',
									'0.9' => '10%',
									'0.8' => '20%',
									'0.7' => '30%',
									'0.6' => '40%',
									'0.5' => '50%',
									'0.4' => '60%',
									'0.3' => '70%',
									'0.2' => '80%',
									'0.1' => '90%',
									'0' => 'Fully Transparent',
									),																		
				'priority' => 50,
			) );

			$wp_customize->add_setting( 'ccta_radius_' . $key, array(
				'default' => '0',
			) );
			$wp_customize->add_control( 'ccta_radius_' . $key, array(
				'type' => 'select',
				'label' => 'Module corner radius',
				'section' => 'divi_children_custom_ctas_' . $key,
				'choices' => array(
									'0' => 'Square Corners',
									'1px' => '1px radius',
									'2px' => '2px radius',
									'3px' => '3px radius',
									'4px' => '4px radius',
									'5px' => '5px radius',
									'6px' => '6px radius',
									'7px' => '7px radius',
									'8px' => '8px radius',
									'9px' => '9px radius',
									'10px' => '10px radius',
									'15px' => '15px radius',
									'20px' => '20px radius',
									'30px' => '30px radius',
									),																		
				'priority' => 60,
			) );

			$wp_customize->add_setting( 'ccta_title_color_' . $key, array(
				'default' => '#999999',
				'sanitize_callback' => 'sanitize_hex_color',
			) );
			$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'ccta_title_color_' . $key, array(
				'label' => 'Title font color',
				'section' => 'divi_children_custom_ctas_' . $key,
				'settings' => 'ccta_title_color_' . $key,
				'priority' => 70,
			) ) );
			
			$wp_customize->add_setting( 'ccta_title_size_' . $key, array(
				'default' => '26px',
			) );
			$wp_customize->add_control( 'ccta_title_size_' . $key, array(
				'type' => 'select',
				'label' => 'Title font size',
				'section' => 'divi_children_custom_ctas_' . $key,
				'choices' => array(
									'30px' => '30px',
									'29px' => '29px',
									'28px' => '28px',
									'27px' => '27px',
									'26px' => '26px',
									'25px' => '25px',
									'24px' => '24px',
									'23px' => '23px',
									'22px' => '22px',
									'21px' => '21px',
									'20px' => '20px',									
									),
				'priority' => 80,
			) );
			
			$wp_customize->add_setting( 'ccta_button_size_' . $key, array(
				'default' => 20,
			) );
			$wp_customize->add_control( 'ccta_button_size_' . $key, array(
				'type' => 'select',
				'label' => 'Button size (font size)',
				'section' => 'divi_children_custom_ctas_' . $key,
				'choices' => array(
									24 => '24px',
									22 => '22px',
									20 => '20px',
									18 => '18px',
									16 => '16px',
									14 => '14px',
									),
				'priority' => 90,
			) );			


			$wp_customize->add_setting( 'ccta_button_padding_' . $key, array(
				'default' => 20,
			) );
			$wp_customize->add_control( 'ccta_button_padding_' . $key, array(
				'type' => 'select',
				'label' => 'Button width (horizontal padding)',
				'section' => 'divi_children_custom_ctas_' . $key,
				'choices' => array(
									100 => '100px',
									90 => '90px',
									80 => '80px',
									70 => '70px',
									60 => '60px',
									50 => '50px',
									40 => '40px',
									30 => '30px',
									20 => '20px',
									15 => '15px',
									10 => '10px',
									5 => '5px',
									),
				'priority' => 100,
			) );

		}
	}	
	
	// Main Footer
	
	$wp_customize->add_setting( 'main_footer_toppadding', array(
		'default' => '80px',
	) );
	$wp_customize->add_control( 'main_footer_toppadding', array(
		'type' => 'select',
		'label' => 'Main Footer top padding',
		'section' => 'divi_children_main_footer',
		'choices' => array(
							'100px' => '100px',
							'90px' => '90px',
							'80px' => '80px',
							'70px' => '70px',
							'60px' => '60px',
							'50px' => '50px',
							'40px' => '40px',
							'30px' => '30px',
							'20px' => '20px',
							'10px' => '10px',
							'0px' => '0px',																						
							),
		'priority' => 10,
	) );
	
	$wp_customize->add_setting( 'footer_widget_bottommargin', array(
		'default' => '50px',
	) );
	$wp_customize->add_control( 'footer_widget_bottommargin', array(
		'type' => 'select',
		'label' => 'Footer widgets bottom margin',
		'section' => 'divi_children_main_footer',
		'choices' => array(
							'100px' => '100px',
							'90px' => '90px',
							'80px' => '80px',
							'70px' => '70px',
							'60px' => '60px',
							'50px' => '50px',
							'40px' => '40px',
							'30px' => '30px',
							'20px' => '20px',
							'10px' => '10px',
							'0px' => '0px',																						
							),
		'priority' => 20,
	) );
	
	$wp_customize->add_setting( 'main_footer_bkgcolor', array(
		'default' => '#2e2e2e',
		'sanitize_callback' => 'sanitize_hex_color',
	) );
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'main_footer_bkgcolor', array(
		'label' => 'Main Footer background color',
		'section' => 'divi_children_main_footer',
		'settings' => 'main_footer_bkgcolor',
		'priority' => 30,
	) ) );
	
	$wp_customize->add_setting( 'main_footer_title_color', array(
		'default' => et_get_option( 'accent_color', '#2ea3f2' ),
		'sanitize_callback' => 'sanitize_hex_color',
	) );
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'main_footer_title_color', array(
		'label' => 'Main Footer Titles color',
		'section' => 'divi_children_main_footer',
		'settings' => 'main_footer_title_color',
		'priority' => 40,
	) ) );
	
	$wp_customize->add_setting( 'main_footer_title_size', array(
		'default' => '18px',
	) );
	$wp_customize->add_control( 'main_footer_title_size', array(
		'type' => 'select',
		'label' => 'Footer Titles font size',
		'section' => 'divi_children_main_footer',
		'choices' => array(								
							'22px' => '22px',
							'21px' => '21px',
							'20px' => '20px',
							'19px' => '19px',
							'18px' => '18px',
							'17px' => '17px',
							'16px' => '16px',
							'15px' => '15px',
							'14px' => '14px',
							'13px' => '13px',
							'12px' => '12px',							
							),
		'priority' => 50,
	) );
	
	$wp_customize->add_setting( 'main_footer_title_uppercase', array(
		'default' => false,
	) ); 
	$wp_customize->add_control( 'main_footer_title_uppercase', array(
		'type' => 'checkbox',
		'label' => 'Uppercase Footer Titles',
		'section' => 'divi_children_main_footer',
		'priority' => 60,		
	) );
	
	$wp_customize->add_setting( 'main_footer_title_padding', array(
		'default' => '10px',
	) );
	$wp_customize->add_control( 'main_footer_title_padding', array(
		'type' => 'select',
		'label' => 'Main Footer Titles bottom padding',
		'section' => 'divi_children_main_footer',
		'choices' => array(
							'50px' => '50px',
							'45px' => '45px',		
							'40px' => '40px',
							'35px' => '35px',
							'30px' => '30px',
							'25px' => '25px',
							'20px' => '20px',
							'15px' => '15px',
							'10px' => '10px',
							'5px' => '5px',
							'0px' => '0px',																						
							),
		'priority' => 70,
	) );
	
	$wp_customize->add_setting( 'main_footer_textcolor', array(
		'default' => '#ffffff',
		'sanitize_callback' => 'sanitize_hex_color',
	) );
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'main_footer_textcolor', array(
		'label' => 'Main Footer text and links color',
		'section' => 'divi_children_main_footer',
		'settings' => 'main_footer_textcolor',
		'priority' => 80,
	) ) );

	$wp_customize->add_setting( 'main_footer_text_size', array(
		'default' => '14px',
	) );	
	$wp_customize->add_control( 'main_footer_text_size', array(
		'type' => 'select',
		'label' => 'Text and links font size',
		'section' => 'divi_children_main_footer',
		'choices' => array(	
							'16px' => '16px',
							'15px' => '15px',
							'14px' => '14px',
							'13px' => '13px',
							'12px' => '12px',							
							),
		'priority' => 90,
	) );
	
	$wp_customize->add_setting( 'main_footer_hovercolor', array(
		'default' => et_get_option( 'accent_color', '#2ea3f2' ),
		'sanitize_callback' => 'sanitize_hex_color',
	) );
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'main_footer_hovercolor', array(
		'label' => 'Main Footer links hover color',
		'section' => 'divi_children_main_footer',
		'settings' => 'main_footer_hovercolor',
		'priority' => 100,
	) ) );

	$wp_customize->add_setting( 'main_footer_bulletstype', array(
		'default' => 'Divi original round bullets',
	) );
	$wp_customize->add_control( 'main_footer_bulletstype', array(
		'type' => 'select',
		'label' => 'Main Footer bullets style:',
		'section' => 'divi_children_main_footer',
		'choices' => array(
							'bullets' => 'Divi original round bullets',
							'squares' => 'Square bullets',
							'arrows' => 'Arrow Head bullets',
							'line' => 'Left vertical line',
							),
		'priority' => 110,
	) );
	
	$wp_customize->add_setting( 'main_footer_bulletscolor', array(
		'default' => et_get_option( 'accent_color', '#2ea3f2' ),
		'sanitize_callback' => 'sanitize_hex_color',
	) );
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'main_footer_bulletscolor', array(
		'label' => 'Main Footer bullets color',
		'section' => 'divi_children_main_footer',
		'settings' => 'main_footer_bulletscolor',
		'priority' => 120,
	) ) );
	
	// Footer Bottom
	
	$wp_customize->add_setting( 'footer_bottom_bkgcolor', array(
		'default' => '#1f1f1f',
		'sanitize_callback' => 'sanitize_hex_color',
	) );
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'footer_bottom_bkgcolor', array(
		'label' => 'Footer Bottom background color',
		'section' => 'divi_children_footer_bottom',
		'settings' => 'footer_bottom_bkgcolor',
		'priority' => 10,
	) ) );
	
	$wp_customize->add_setting( 'footer_bottom_textcolor', array(
		'default' => '#666666',
		'sanitize_callback' => 'sanitize_hex_color',
	) );
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'footer_bottom_textcolor', array(
		'label' => 'Footer Bottom text color',
		'section' => 'divi_children_footer_bottom',
		'settings' => 'footer_bottom_textcolor',
		'priority' => 20,
	) ) );

	$wp_customize->add_setting( 'footer_bottom_textsize', array(
		'default' => '14px',
	) );	
	$wp_customize->add_control( 'footer_bottom_textsize', array(
		'type' => 'select',
		'label' => 'Footer Bottom text size',
		'section' => 'divi_children_footer_bottom',
		'choices' => array(	
							'16px' => '16px',
							'15px' => '15px',
							'14px' => '14px',
							'13px' => '13px',
							'12px' => '12px',
							'11px' => '11px',
							'10px' => '10px',							
							),
		'priority' => 30,
	) );
	
	$wp_customize->add_setting( 'footer_bottom_iconcolor', array(
		'default' => '#666666',
		'sanitize_callback' => 'sanitize_hex_color',
	) );
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'footer_bottom_iconcolor', array(
		'label' => 'Footer Bottom social icons color',
		'section' => 'divi_children_footer_bottom',
		'settings' => 'footer_bottom_iconcolor',
		'priority' => 40,
	) ) );
	$wp_customize->add_setting( 'footer_bottom_iconcolor_hover', array(
		'default' => '#7ebec5',
		'sanitize_callback' => 'sanitize_hex_color',
	) );
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'footer_bottom_iconcolor_hover', array(
		'label' => 'Social icons hover color',
		'section' => 'divi_children_footer_bottom',
		'settings' => 'footer_bottom_iconcolor_hover',
		'priority' => 50,
	) ) );	
	$wp_customize->add_setting( 'footer_bottom_serviceiconcolor', array(
		'default' => false,
	) ); 
	$wp_customize->add_control( 'footer_bottom_serviceiconcolor', array(
		'type' => 'checkbox',
		'label' => 'Use original colors from each service',
		'section' => 'divi_children_footer_bottom',
		'priority' => 60,		
	) );
	 
	$wp_customize->add_setting( 'footer_bottom_iconsize', array(
		'default' => '24px',
	) ); 
	$wp_customize->add_control( 'footer_bottom_iconsize', array(
		'type' => 'select',
		'label' => 'Footer Bottom social icons size',
		'section' => 'divi_children_footer_bottom',
		'choices' => array(	
							'30px' => '30px',
							'29px' => '29px',
							'28px' => '28px',
							'27px' => '27px',
							'26px' => '26px',
							'25px' => '25px',
							'24px' => '24px',
							'23px' => '23px',
							'22px' => '22px',
							'21px' => '21px',
							'20px' => '20px',
							'19px' => '19px',
							'18px' => '18px',
							),
		'priority' => 70,
	) );
	 
	$wp_customize->add_setting( 'footer_bottom_toppadding', array(
		'default' => '15px',
	) );
	$wp_customize->add_control( 'footer_bottom_toppadding', array(
		'type' => 'select',
		'label' => 'Footer Bottom top padding',
		'section' => 'divi_children_footer_bottom',
		'choices' => array(
							'100px' => '100px',
							'90px' => '90px',
							'80px' => '80px',
							'70px' => '70px',
							'60px' => '60px',
							'50px' => '50px',
							'45px' => '45px',							
							'40px' => '40px',
							'35px' => '35px',
							'30px' => '30px',
							'20px' => '20px',
							'15px' => '15px',
							'10px' => '10px',
							'5px' => '5px',
							'0px' => '0px',																						
							),
		'priority' => 80,
	) );
	$wp_customize->add_setting( 'footer_bottom_bottompadding', array(
		'default' => '5px',
	) );
	$wp_customize->add_control( 'footer_bottom_bottompadding', array(
		'type' => 'select',
		'label' => 'Footer Bottom bottom padding',
		'section' => 'divi_children_footer_bottom',
		'choices' => array(
							'100px' => '100px',
							'90px' => '90px',
							'80px' => '80px',
							'70px' => '70px',
							'60px' => '60px',
							'50px' => '50px',
							'45px' => '45px',							
							'40px' => '40px',
							'35px' => '35px',
							'30px' => '30px',
							'20px' => '20px',
							'15px' => '15px',
							'10px' => '10px',
							'5px' => '5px',
							'0px' => '0px',																						
							),
		'priority' => 90,
	) );
	
	// Footer Credits

	$wp_customize->add_setting( 'footer_credits_owner', array(
		'default' => get_option( 'footer_credits_owner' ),
		'sanitize_callback' => 'sanitize_text_field',	
	) ); 
	$wp_customize->add_control( 'footer_credits_owner', array(
		'type' => 'text',
		'label' => 'Copyright Owner:',
		'section' => 'divi_children_footer_credits',
		'priority' => 10,		
	) );
	
	$wp_customize->add_setting( 'footer_credits_ownerlink', array(
		'default' => get_option( 'footer_credits_ownerlink' ),
	) ); 
	$wp_customize->add_control( 'footer_credits_ownerlink', array(
		'type' => 'text',
		'label' => 'Copyright Owner URL:',
		'section' => 'divi_children_footer_credits',
		'priority' => 20,		
	) );

	$wp_customize->add_setting( 'footer_credits_developed', array(
		'default' => get_option( 'footer_credits_developed' ),
		'sanitize_callback' => 'sanitize_text_field',
	) ); 
	$wp_customize->add_control( 'footer_credits_developed', array(
		'type' => 'text',
		'label' => 'Developed By text (optional):',
		'section' => 'divi_children_footer_credits',
		'priority' => 30,		
	) );
	
	$wp_customize->add_setting( 'footer_credits_developer', array(
		'default' => get_option( 'footer_credits_developer' ),
		'sanitize_callback' => 'sanitize_text_field',
	) ); 
	$wp_customize->add_control( 'footer_credits_developer', array(
		'type' => 'text',
		'label' => 'Developer:',
		'section' => 'divi_children_footer_credits',
		'priority' => 40,		
	) );	
	
	$wp_customize->add_setting( 'footer_credits_developerlink', array(
		'default' => get_option( 'footer_credits_developerlink' ),
	) ); 
	$wp_customize->add_control( 'footer_credits_developerlink', array(
		'type' => 'text',
		'label' => 'Developer URL:',
		'section' => 'divi_children_footer_credits',
		'priority' => 50,		
	) );
	
	$wp_customize->add_setting( 'footer_credits_powered', array(
		'default' => get_option( 'footer_credits_powered' ),
		'sanitize_callback' => 'sanitize_text_field',
	) ); 
	$wp_customize->add_control( 'footer_credits_powered', array(
		'type' => 'text',
		'label' => 'Powered by text (optional):',
		'section' => 'divi_children_footer_credits',
		'priority' => 60,		
	) );

	$wp_customize->add_setting( 'footer_credits_poweredcode', array(
		'default' => get_option( 'footer_credits_poweredcode' ),
		'sanitize_callback' => 'sanitize_text_field',
	) ); 
	$wp_customize->add_control( 'footer_credits_poweredcode', array(
		'type' => 'text',
		'label' => 'Powered by:',
		'section' => 'divi_children_footer_credits',
		'priority' => 70,		
	) );

	$wp_customize->add_setting( 'footer_credits_poweredcodelink', array(
		'default' => get_option( 'footer_credits_poweredcodelink' ),
	) ); 
	$wp_customize->add_control( 'footer_credits_poweredcodelink', array(
		'type' => 'text',
		'label' => 'Powered by URL:',
		'section' => 'divi_children_footer_credits',
		'priority' => 80,		
	) );

	$wp_customize->add_setting( 'footer_credits_firstyear', array(
		'default' => get_option( 'footer_credits_firstyear' ),
		'sanitize_callback' => 'absint',
	) ); 
	$wp_customize->add_control( 'footer_credits_firstyear', array(
		'type' => 'text',
		'label' => 'Site began on:',
		'section' => 'divi_children_footer_credits',
		'priority' => 90,		
	) );	

	// Main Sidebar
	
	$wp_customize->add_setting( 'sidebar_widget_leftmargin', array(
		'default' => '30px',
	) );
	$wp_customize->add_control( 'sidebar_widget_leftmargin', array(
		'type' => 'select',
		'label' => 'Sidebar left margin',
		'section' => 'divi_children_sidebar',
		'choices' => array(
							'50px' => '50px',
							'45px' => '45px',
							'40px' => '40px',
							'35px' => '35px',
							'30px' => '30px',
							'25px' => '25px',
							'20px' => '20px',
							'15px' => '15px',
							'10px' => '10px',
							'5px' => '5px',
							'0px' => '0px',							
							),
		'priority' => 10,
	) );
	
	$wp_customize->add_setting( 'sidebar_no_vertical_divider', array(
		'default' => false,
	) ); 
	$wp_customize->add_control( 'sidebar_no_vertical_divider', array(
		'type' => 'checkbox',
		'label' => 'Hide vertical divider line',
		'section' => 'divi_children_sidebar',
		'priority' => 20,		
	) );

	$wp_customize->add_setting( 'sidebar_widget_bottommargin', array(
		'default' => '30px',
	) );
	$wp_customize->add_control( 'sidebar_widget_bottommargin', array(
		'type' => 'select',
		'label' => 'Widgets bottom margin',
		'section' => 'divi_children_sidebar',
		'choices' => array(
							'50px' => '50px',
							'45px' => '45px',
							'40px' => '40px',
							'35px' => '35px',
							'30px' => '30px',
							'25px' => '25px',
							'20px' => '20px',
							'15px' => '15px',
							'10px' => '10px',
							'5px' => '5px',
							'0px' => '0px',							
							),
		'priority' => 30,
	) );
	
	$wp_customize->add_setting( 'sidebar_widgettitle_color', array(
		'default' => '#333',
		'sanitize_callback' => 'sanitize_hex_color',
	) );
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'sidebar_widgettitle_color', array(
		'label' => 'Widget Titles color',
		'section' => 'divi_children_sidebar',
		'settings' => 'sidebar_widgettitle_color',
		'priority' => 40,
	) ) );

	$wp_customize->add_setting( 'sidebar_widgettitle_size', array(
		'default' => '18px',
	) );
	$wp_customize->add_control( 'sidebar_widgettitle_size', array(
		'type' => 'select',
		'label' => 'Widget Titles font size',
		'section' => 'divi_children_sidebar',
		'choices' => array(								
							'22px' => '22px',
							'21px' => '21px',
							'20px' => '20px',
							'19px' => '19px',
							'18px' => '18px',
							'17px' => '17px',
							'16px' => '16px',
							'15px' => '15px',
							'14px' => '14px',
							'13px' => '13px',
							'12px' => '12px',							
							),
		'priority' => 50,
	) );

	$wp_customize->add_setting( 'sidebar_widgettitle_uppercase', array(
		'default' => false,
	) ); 
	$wp_customize->add_control( 'sidebar_widgettitle_uppercase', array(
		'type' => 'checkbox',
		'label' => 'Uppercase titles',
		'section' => 'divi_children_sidebar',
		'priority' => 60,		
	) );

	$wp_customize->add_setting( 'sidebar_boxed_widgettitle', array(
		'default' => false,
	) ); 
	$wp_customize->add_control( 'sidebar_boxed_widgettitle', array(
		'type' => 'checkbox',
		'label' => 'Boxed titles with background',
		'section' => 'divi_children_sidebar',
		'priority' => 70,		
	) );

	$wp_customize->add_setting( 'sidebar_boxed_widgettitle_backcolor', array(
		'default' => '#eee',
		'sanitize_callback' => 'sanitize_hex_color',
	) );
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'sidebar_boxed_widgettitle_backcolor', array(
		'label' => 'Boxed titles background color',
		'section' => 'divi_children_sidebar',
		'settings' => 'sidebar_boxed_widgettitle_backcolor',
		'priority' => 80,
	) ) );

	$wp_customize->add_setting( 'sidebar_boxed_widgettitle_vertpadding', array(
		'default' => '10px',
	) );
	$wp_customize->add_control( 'sidebar_boxed_widgettitle_vertpadding', array(
		'type' => 'select',
		'label' => 'Boxed titles vertical padding',
		'section' => 'divi_children_sidebar',
		'choices' => array(
							'30px' => '30px',
							'25px' => '25px',
							'20px' => '20px',
							'18px' => '18px',
							'16px' => '16px',
							'14px' => '14px',
							'12px' => '12px',
							'10px' => '10px',
							'8px' => '8px',
							'6px' => '6px',
							'4px' => '4px',
							'2px' => '2px',																						
							),
		'priority' => 90,
	) );

	$wp_customize->add_setting( 'sidebar_widget_elements_type', array(
		'default' => 'Divi original without bullets',
	) );
	$wp_customize->add_control( 'sidebar_widget_elements_type', array(
		'type' => 'select',
		'label' => 'Widget elements style:',
		'section' => 'divi_children_sidebar',
		'choices' => array(
							'original' => 'Divi original without bullets',
							'bullets' => 'Round bullets',
							'squares' => 'Square bullets',
							'arrows' => 'Arrow Head bullets',
							'line' => 'Left vertical line',
							'background' => 'Boxed with background',
							'line-background' => 'Background + left vertical line',																					
							),
		'priority' => 100,
	) );

	$wp_customize->add_setting( 'sidebar_widget_elements_bkgndcolor', array(
		'default' => '#f4f4f4',
		'sanitize_callback' => 'sanitize_hex_color',
	) );
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'sidebar_widget_elements_bkgndcolor', array(
		'label' => 'Widget elements background color',
		'section' => 'divi_children_sidebar',
		'settings' => 'sidebar_widget_elements_bkgndcolor',
		'priority' => 110,
	) ) );
	
	$wp_customize->add_setting( 'sidebar_widgettext_color', array(
		'default' => '#666',
		'sanitize_callback' => 'sanitize_hex_color',
	) );
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'sidebar_widgettext_color', array(
		'label' => 'Widget text and links color',
		'section' => 'divi_children_sidebar',
		'settings' => 'sidebar_widgettext_color',
		'priority' => 120,
	) ) );	
	
	$wp_customize->add_setting( 'sidebar_widgethover_color', array(
		'default' => '#2ea3f2',
		'sanitize_callback' => 'sanitize_hex_color',
	) );
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'sidebar_widgethover_color', array(
		'label' => 'Widget links hover color',
		'section' => 'divi_children_sidebar',
		'settings' => 'sidebar_widgethover_color',
		'priority' => 130,
	) ) );		
	
	$wp_customize->add_setting( 'sidebar_widgettext_size', array(
		'default' => '14px',
	) );	
	$wp_customize->add_control( 'sidebar_widgettext_size', array(
		'type' => 'select',
		'label' => 'Widget text and links font size',
		'section' => 'divi_children_sidebar',
		'choices' => array(	
							'16px' => '16px',
							'15px' => '15px',
							'14px' => '14px',
							'13px' => '13px',
							'12px' => '12px',							
							),
		'priority' => 140,
	) ); 

	$wp_customize->add_setting( 'sidebar_bullets_color', array(
		'default' => get_theme_mod( 'sidebar_widgettitle_color', '#333' ),
		'sanitize_callback' => 'sanitize_hex_color',
	) );
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'sidebar_bullets_color', array(
		'label' => 'Widget bullets color',
		'section' => 'divi_children_sidebar',
		'settings' => 'sidebar_bullets_color',
		'priority' => 150,
	) ) );	

}
add_action( 'customize_register', 'Divichild_customizer' );


/**
 * Outputs Customizer controlled Divi Children custom CSS.
 */
function Divichild_customizer_css(){
	$custom_fw_headers = get_custom_selectors( 'custom_fullwidth_header' );
	$custom_ctas = get_custom_selectors( 'custom_cta' );
	$custom_rows_sections = get_custom_selectors( 'custom_rows_section' );
	$custom_sidebar_modules = get_custom_selectors( 'custom_sidebar_module' );

	echo '<!-- Child theme custom CSS created by Divi Children - http://divi4u.com/divi-children-plugin/ -->' . "\n";
	echo '<style type="text/css" media="screen">' . "\n";

	if ( get_theme_mod( 'main_footer_toppadding' ) != '80px' ) echo ' #footer-widgets {padding-top:' . get_theme_mod( 'main_footer_toppadding' ) . ';}' . "\n";	
	if ( get_theme_mod( 'footer_widget_bottommargin' ) != '50px' ) echo ' .footer-widget {margin-bottom:' . get_theme_mod( 'footer_widget_bottommargin' ) . ';}' . "\n";		
	if ( get_theme_mod( 'main_footer_bkgcolor' ) != '#2e2e2e' ) echo ' #main-footer { background-color:' . get_theme_mod( 'main_footer_bkgcolor' ) . '!important;}' . "\n";
	if ( get_theme_mod( 'main_footer_title_color' ) != et_get_option( 'accent_color', '#2ea3f2' ) ) echo ' .footer-widget .title {color:' . get_theme_mod( 'main_footer_title_color' ) . '!important;}' . "\n";
	if ( get_theme_mod( 'main_footer_title_size' ) != '18px' ) echo ' .footer-widget .title {font-size:' . get_theme_mod( 'main_footer_title_size' ) . ';}' . "\n";
	if ( get_theme_mod( 'main_footer_title_padding' ) != '10px' ) echo ' .footer-widget .title {padding-bottom:' . get_theme_mod( 'main_footer_title_padding' ) . ';}' . "\n";
	if ( get_theme_mod( 'main_footer_title_uppercase' ) ) echo ' .footer-widget .title {text-transform:uppercase;}' . "\n";
	if ( ( get_theme_mod( 'main_footer_textcolor' ) != '#ffffff' ) OR ( get_theme_mod( 'main_footer_text_size' ) != '14px' ) ) echo ' .footer-widget, .footer-widget li, .footer-widget li a {color:' . get_theme_mod( 'main_footer_textcolor' ) . '!important; font-size:'. get_theme_mod( 'main_footer_text_size' ) . ';}' . "\n";	
	if ( get_theme_mod( 'main_footer_hovercolor' ) != et_get_option( 'accent_color', '#2ea3f2' ) ) echo ' .footer-widget li a:hover, #footer-widgets .et_pb_widget li a:hover {color:' . get_theme_mod( 'main_footer_hovercolor' ) . '!important;}' . "\n";
	if ( get_theme_mod( 'main_footer_bulletscolor' ) != et_get_option( 'accent_color', '#2ea3f2' ) ) echo ' .footer-widget li:before {border-color:' . get_theme_mod( 'main_footer_bulletscolor' ) . '!important;}' . "\n";
	if ( get_theme_mod( 'main_footer_bulletstype' ) == 'squares' ) echo ' .footer-widget li:before {-moz-border-radius: 0!important; -webkit-border-radius: 0!important;  border-radius: 0!important;}' . "\n";
	if ( get_theme_mod( 'main_footer_bulletstype' ) == 'arrows' ) echo ' .footer-widget li:before {border-width:0!important; font-family: "ETmodules"; content: "\45"!important; font-size: 18px; position: absolute; top: 0px!important;  left: -5px!important; color:' . get_theme_mod( 'main_footer_bulletscolor', et_get_option( 'accent_color', '#2ea3f2' ) ) . '!important;}' . "\n";
	if ( get_theme_mod( 'main_footer_bulletstype' ) == 'line' ) echo ' .footer-widget li:before {display:none!important;} .footer-widget li {padding: 0px 0px 0px 10px!important; position: relative; margin: 15px 0; border-color:' . get_theme_mod( 'main_footer_bulletscolor', et_get_option( 'accent_color', '#2ea3f2' ) ) . '; border-left-style: solid; border-left-width: 2px;}' . "\n";
	
	if ( get_theme_mod( 'footer_bottom_bkgcolor' ) != '#1f1f1f' ) echo ' #footer-bottom { background-color:' . get_theme_mod( 'footer_bottom_bkgcolor' ) . ';}' . "\n";
	if ( ( get_theme_mod( 'footer_bottom_toppadding' ) != '15px' ) OR ( get_theme_mod( 'footer_bottom_bottompadding' ) != '5px' ) ) echo ' #footer-bottom {padding:' . get_theme_mod( 'footer_bottom_toppadding', '15px' ) . ' 0 '. get_theme_mod( 'footer_bottom_bottompadding', '5px' ) . ';}' . "\n";
	if ( get_theme_mod( 'footer_bottom_textcolor' ) != '#666666' ) echo ' #footer-info, #footer-info a {color:' . get_theme_mod( 'footer_bottom_textcolor' ) . ';}' . "\n";
	if ( get_theme_mod( 'footer_bottom_textsize' ) != '14px' ) echo ' #footer-info, #footer-info a {font-size:' . get_theme_mod( 'footer_bottom_textsize' ) . ';}' . "\n";
	if ( get_theme_mod( 'footer_bottom_serviceiconcolor' ) ) {		
			echo ' #footer-bottom .et-social-twitter a {color:#55acee;}' . "\n";
			echo ' #footer-bottom .et-social-twitter a:hover {color:#2795e9!important;}' . "\n";
			echo ' #footer-bottom .et-social-facebook a {color:#3b5998;}' . "\n";
			echo ' #footer-bottom .et-social-facebook  a:hover {color:#2d4373!important;}' . "\n";
			echo ' #footer-bottom .et-social-google-plus a {color:#d34836;}' . "\n";
			echo ' #footer-bottom .et-social-google-plus a:hover {color:#b03626!important;;}' . "\n";
			echo ' #footer-bottom .et-social-rss a {color:#ff6600;}' . "\n";
			echo ' #footer-bottom .et-social-rss a:hover {color:#cc5200!important;}' . "\n";			
		} else {
			if ( get_theme_mod( 'footer_bottom_iconcolor' ) != '#666666' ) echo ' #footer-bottom ul.et-social-icons li a {color:' . get_theme_mod( 'footer_bottom_iconcolor' ) . ';}' . "\n";
			if ( get_theme_mod( 'footer_bottom_iconcolor_hover' ) != '#7ebec5' ) echo ' #footer-bottom ul.et-social-icons li a:hover {color:' . get_theme_mod( 'footer_bottom_iconcolor_hover' ) . '!important;}' . "\n";
	}
	
	if ( get_theme_mod( 'footer_bottom_iconsize' ) != '24px' ) {
		$socialicon_leftmargin = strval( get_theme_mod( 'footer_bottom_iconsize' ) - 6 ) . 'px';
		echo ' #footer-bottom ul.et-social-icons li a {font-size:' . get_theme_mod( 'footer_bottom_iconsize' ) . ';}' . "\n";
		echo ' #footer-bottom ul.et-social-icons li {margin-left:' . $socialicon_leftmargin . ';}' . "\n";
	}

	if ( ( get_theme_mod( 'sidebar_widget_bottommargin' ) != '30px' ) OR ( get_theme_mod( 'sidebar_widget_leftmargin' ) != '30px' ) )echo ' #sidebar .et_pb_widget {margin: 0 0 ' . get_theme_mod( 'sidebar_widget_bottommargin' ) .' '. get_theme_mod( 'sidebar_widget_leftmargin' ) . ';}' . "\n";
	if ( false != get_theme_mod( 'sidebar_no_vertical_divider' ) ) echo ' #main-content .container:before {display:none;}' . "\n";
	if ( get_theme_mod( 'sidebar_widgettitle_color' ) != '#333' ) echo ' #sidebar h4.widgettitle {color:' . get_theme_mod( 'sidebar_widgettitle_color' ) . ';}' . "\n";
	if ( get_theme_mod( 'sidebar_widgettitle_size' ) != '18px' ) echo ' #sidebar h4.widgettitle {font-size:' . get_theme_mod( 'sidebar_widgettitle_size' ) . ';}' . "\n";
	if ( false != get_theme_mod( 'sidebar_widgettitle_uppercase' ) ) echo ' #sidebar h4.widgettitle {text-transform:uppercase;}' . "\n";	
	if ( false != get_theme_mod( 'sidebar_boxed_widgettitle' ) ) echo ' #sidebar h4.widgettitle {background:' . get_theme_mod( 'sidebar_boxed_widgettitle_backcolor' ) . '; padding: ' . get_theme_mod( 'sidebar_boxed_widgettitle_vertpadding' ) . ' 5px ' . get_theme_mod( 'sidebar_boxed_widgettitle_vertpadding' ) . ' 12px; margin-bottom: 10px;}' . "\n";
	if ( get_theme_mod( 'sidebar_widget_elements_type' ) == 'bullets' ) echo ' #sidebar li {padding: 0 0 4px 14px; position: relative; }' . "\n" . '	#sidebar li:before {color:' . get_theme_mod( 'sidebar_bullets_color', get_theme_mod( 'sidebar_widgettitle_color', '#333' ) ) . '; -moz-border-radius: 3px; -webkit-border-radius: 3px; border-radius: 3px; border-style: solid; border-width: 3px; content: ""; position: absolute; top: 9px;  left: 0;}' . "\n";
	if ( get_theme_mod( 'sidebar_widget_elements_type' ) == 'squares' ) echo ' #sidebar li {padding: 0 0 4px 14px; position: relative; }' . "\n" . '	#sidebar li:before {color:' . get_theme_mod( 'sidebar_bullets_color', get_theme_mod( 'sidebar_widgettitle_color', '#333' ) ) . '; -moz-border-radius: 0; -webkit-border-radius: 0; border-radius: 0; border-style: solid; border-width: 3px; content: ""; position: absolute; top: 9px;  left: 0;}' . "\n";
	if ( get_theme_mod( 'sidebar_widget_elements_type' ) == 'arrows' ) echo ' #sidebar li {padding: 0 0 4px 14px; position: relative; }' . "\n" . '	#sidebar li:before {color:' . get_theme_mod( 'sidebar_bullets_color', get_theme_mod( 'sidebar_widgettitle_color', '#333' ) ) . '; font-family: "ETmodules"; content: "\45"; font-size: 18px; position: absolute; top: 0px;  left: -5px;}' . "\n";
	if ( get_theme_mod( 'sidebar_widget_elements_type' ) == 'line' ) echo ' #sidebar li {padding: 0px 0px 0px 10px; position: relative; margin: 14px 0; border-color:' . get_theme_mod( 'sidebar_bullets_color', get_theme_mod( 'sidebar_widgettitle_color', '#333' ) ) . '; border-left-style: solid; border-left-width: 3px;}' . "\n";
	if ( get_theme_mod( 'sidebar_widget_elements_type' ) == 'background' ) echo ' #sidebar li {padding: 6px 10px 6px 10px; position: relative; margin: 10px 0; background: ' . get_theme_mod( 'sidebar_widget_elements_bkgndcolor' ) . ';}' . "\n";
	if ( get_theme_mod( 'sidebar_widget_elements_type' ) == 'line-background' ) echo ' #sidebar li {padding: 6px 10px 6px 10px; position: relative; margin: 14px 0; border-color:' . get_theme_mod( 'sidebar_bullets_color', get_theme_mod( 'sidebar_widgettitle_color', '#333' ) ) . '; border-left-style: solid; border-left-width: 3px; background: ' . get_theme_mod( 'sidebar_widget_elements_bkgndcolor' ) . ';}' . "\n";	
	if ( get_theme_mod( 'sidebar_widgettext_size' ) != '14px' ) echo ' #sidebar li, #sidebar li a {font-size:' . get_theme_mod( 'sidebar_widgettext_size' ) . ';}' . "\n";
	if ( get_theme_mod( 'sidebar_widgettext_color' ) != '#666' ) echo ' #sidebar li, #sidebar li a {color:' . get_theme_mod( 'sidebar_widgettext_color' ) . ';}' . "\n";
	if ( get_theme_mod( 'sidebar_widgethover_color' ) != '#2ea3f2' ) echo ' #sidebar li a:hover {color:' . get_theme_mod( 'sidebar_widgethover_color' ) . '!important;}' . "\n";	

	if ($custom_rows_sections) {
		foreach ($custom_rows_sections as $key => $value) {
			$key++;
			$crs_background_rgb = hex2rgb(get_theme_mod( 'crs_background_color_' . $key));
			$crs_background_rgba = $crs_background_rgb . ',' . get_theme_mod( 'crs_background_opacity_' . $key);
			$column_separation = 60 - ( 2 * get_theme_mod( 'crs_padding_' . $key) );
			$column_separation = strval( $column_separation ) . 'px';
			$crs_padding = strval( get_theme_mod( 'crs_padding_' . $key ) ) . 'px';			
			if ( ( get_theme_mod( 'crs_section_top_padding_' . $key ) != '50px' ) OR ( get_theme_mod( 'crs_section_bottom_padding_' . $key ) != '50px' ) ) echo ' .custom_rows_section_' . $key . ' {padding: ' . get_theme_mod( 'crs_section_top_padding_' . $key ) . ' 0 ' . get_theme_mod( 'crs_section_bottom_padding_' . $key ) . ' 0;}' . "\n";
			if ( ( get_theme_mod( 'crs_background_color_' . $key ) != '#ffffff' ) OR ( get_theme_mod( 'crs_background_opacity_' . $key ) != '1' ) ) echo ' .custom_rows_section_' . $key . ' .et_pb_row {background:rgba(' . $crs_background_rgba . ');}' . "\n";		
			if ( ( get_theme_mod( 'crs_padding_' . $key ) != 15 ) OR ( get_theme_mod( 'crs_top_margin_' . $key ) != '50px' ) ){
				echo ' .custom_rows_section_' . $key . ' .et_pb_column {margin-right: ' . $column_separation . '; margin-bottom: -35px;}' . "\n";
				echo ' .custom_rows_section_' . $key . ' .et_pb_row {padding: ' . $crs_padding . '; margin-top: ' . ( get_theme_mod( 'crs_top_margin_' . $key ) ) . '; -webkit-box-sizing: border-box; -moz-box-sizing: border-box; box-sizing: border-box;}' . "\n";
			}
		}
	}
	
	if ($custom_fw_headers) {
		foreach ($custom_fw_headers as $key => $value) {
			$key++;			
			if ( ( get_theme_mod( 'custom_header_top_padding_' . $key ) != '50px' ) OR ( get_theme_mod( 'custom_header_bottom_padding_' . $key ) != '50px' ) ) echo ' .custom_fullwidth_header_' . $key . ' {padding: ' . get_theme_mod( 'custom_header_top_padding_' . $key ). ' 0 ' . get_theme_mod( 'custom_header_bottom_padding_' . $key ) . ' 0;}' . "\n";			
			if ( ( get_theme_mod( 'ch_header_size_' . $key ) != '30px' ) OR ( get_theme_mod( 'ch_header_color_' . $key ) !=  '#999999' ) ) echo ' .custom_fullwidth_header_' . $key . ' h1 {font-size: ' . get_theme_mod( 'ch_header_size_' . $key ) . '; color: ' . get_theme_mod( 'ch_header_color_' . $key ) . '!important;}' . "\n";
			if ( ( get_theme_mod( 'ch_subheader_size_' . $key ) != '16px' ) OR ( get_theme_mod( 'ch_subheader_color_' . $key ) !=  '#999999' ) ) echo ' .et_pb_fullwidth_header_subhead {font-size: ' . get_theme_mod( 'ch_subheader_size_' . $key ) . '; color: ' . get_theme_mod( 'ch_subheader_color_' . $key ) . ';}' . "\n";
		}
	}
	
	if ($custom_sidebar_modules) {
		foreach ($custom_sidebar_modules as $key => $value) {
			$key++;
			if ( ( get_theme_mod( 'sidebar_widget_bottommargin_' . $key) != '30px' ) OR ( get_theme_mod( 'sidebar_widget_leftmargin_' . $key) != '30px' ) )echo ' #custom_sidebar_module_' . $key . ' .et_pb_widget {margin: 0 0 ' . get_theme_mod( 'sidebar_widget_bottommargin_' . $key) .' '. get_theme_mod( 'sidebar_widget_leftmargin_' . $key) . ';}' . "\n";
			if ( false != get_theme_mod( 'sidebar_no_vertical_divider_' . $key) ) echo ' #custom_sidebar_module_' . $key . ' {border-left: 0px; border-right: 0px;}' . "\n";
			if ( get_theme_mod( 'sidebar_widgettitle_color_' . $key) != '#333' ) echo ' #custom_sidebar_module_' . $key . ' h4.widgettitle {color:' . get_theme_mod( 'sidebar_widgettitle_color_' . $key) . ';}' . "\n";
			if ( get_theme_mod( 'sidebar_widgettitle_size_' . $key) != '18px' ) echo ' #custom_sidebar_module_' . $key . ' h4.widgettitle {font-size:' . get_theme_mod( 'sidebar_widgettitle_size_' . $key) . ';}' . "\n";
			if ( false != get_theme_mod( 'sidebar_widgettitle_uppercase_' . $key) ) echo ' #custom_sidebar_module_' . $key . ' h4.widgettitle {text-transform:uppercase;}' . "\n";	
			if ( false != get_theme_mod( 'sidebar_boxed_widgettitle_' . $key) ) echo ' #custom_sidebar_module_' . $key . ' h4.widgettitle {background:' . get_theme_mod( 'sidebar_boxed_widgettitle_backcolor_' . $key) . '; padding: ' . get_theme_mod( 'sidebar_boxed_widgettitle_vertpadding_' . $key) . ' 5px ' . get_theme_mod( 'sidebar_boxed_widgettitle_vertpadding_' . $key) . ' 12px; margin-bottom: 10px;}' . "\n";
			if ( get_theme_mod( 'sidebar_widget_elements_type_' . $key) == 'bullets' ) echo ' #custom_sidebar_module_' . $key . ' li {padding: 0 0 4px 14px; position: relative; }' . "\n" . ' #custom_sidebar_module_' . $key . ' li:before {color:' . get_theme_mod( 'sidebar_bullets_color_' . $key) . '; -moz-border-radius: 3px; -webkit-border-radius: 3px; border-radius: 3px; border-style: solid; border-width: 3px; content: ""; position: absolute; top: 9px;  left: 0;}' . "\n";
			if ( get_theme_mod( 'sidebar_widget_elements_type_' . $key) == 'squares' ) echo ' #custom_sidebar_module_' . $key . ' li {padding: 0 0 4px 14px; position: relative; }' . "\n" . ' #custom_sidebar_module_' . $key . ' li:before {color:' . get_theme_mod( 'sidebar_bullets_color_' . $key) . '; -moz-border-radius: 0; -webkit-border-radius: 0; border-radius: 0; border-style: solid; border-width: 3px; content: ""; position: absolute; top: 9px;  left: 0;}' . "\n";
			if ( get_theme_mod( 'sidebar_widget_elements_type_' . $key) == 'arrows' ) echo ' #custom_sidebar_module_' . $key . ' li {padding: 0 0 4px 14px; position: relative; }' . "\n" . ' #custom_sidebar_module_' . $key . ' li:before {color:' . get_theme_mod( 'sidebar_bullets_color_' . $key) . '; font-family: "ETmodules"; content: "\45"; font-size: 18px; position: absolute; top: 0px;  left: -5px;}' . "\n";
			if ( get_theme_mod( 'sidebar_widget_elements_type_' . $key) == 'line' ) echo ' #custom_sidebar_module_' . $key . ' li {padding: 0px 0px 0px 10px; position: relative; margin: 14px 0; border-color:' . get_theme_mod( 'sidebar_bullets_color_' . $key) . '; border-left-style: solid; border-left-width: 3px;}' . "\n";
			if ( get_theme_mod( 'sidebar_widget_elements_type_' . $key) == 'background' ) echo ' #custom_sidebar_module_' . $key . ' li {padding: 6px 10px 6px 10px; position: relative; margin: 10px 0; background: ' . get_theme_mod( 'sidebar_widget_elements_bkgndcolor_' . $key) . ';}' . "\n";
			if ( get_theme_mod( 'sidebar_widget_elements_type_' . $key) == 'line-background' ) echo ' #custom_sidebar_module_' . $key . ' li {padding: 6px 10px 6px 10px; position: relative; margin: 14px 0; border-color:' . get_theme_mod( 'sidebar_bullets_color_' . $key) . '; border-left-style: solid; border-left-width: 3px; background: ' . get_theme_mod( 'sidebar_widget_elements_bkgndcolor_' . $key) . ';}' . "\n";	
			if ( get_theme_mod( 'sidebar_widgettext_size_' . $key) != '14px' ) echo ' #custom_sidebar_module_' . $key . ' li, #custom_sidebar_module_' . $key . ' li a {font-size:' . get_theme_mod( 'sidebar_widgettext_size_' . $key) . ';}' . "\n";
			if ( get_theme_mod( 'sidebar_widgettext_color_' . $key) != '#666' ) echo ' #custom_sidebar_module_' . $key . ' li, #custom_sidebar_module_' . $key . ' li a {color:' . get_theme_mod( 'sidebar_widgettext_color_' . $key) . ';}' . "\n";
			if ( get_theme_mod( 'sidebar_widgethover_color_' . $key) != '#2ea3f2' ) echo ' #custom_sidebar_module_' . $key . ' li a:hover {color:' . get_theme_mod( 'sidebar_widgethover_color_' . $key) . '!important;}' . "\n";
		}
	}
	
	if ($custom_ctas) {
		foreach ($custom_ctas as $key => $value) {
			$key++;
			$ccta_background_rgb = hex2rgb(get_theme_mod( 'ccta_background_color_' . $key));
			$ccta_background_rgba = $ccta_background_rgb.','.get_theme_mod( 'ccta_background_opacity_' . $key);
			if ( get_theme_mod( 'ccta_width_' . $key) != '100%' ) echo ' .custom_cta_' . $key . ' {width:' . get_theme_mod( 'ccta_width_' . $key) . '; margin: 0 auto; -webkit-box-sizing: border-box; -moz-box-sizing: border-box; box-sizing: border-box;}' . "\n";
			if ( ( get_theme_mod( 'ccta_vertical_padding_' . $key) != '40px' ) OR ( get_theme_mod( 'ccta_horizontal_padding_' . $key) != '60px' ) ) echo ' .custom_cta_' . $key . ' {padding:' . get_theme_mod( 'ccta_vertical_padding_' . $key) . ' ' . get_theme_mod( 'ccta_horizontal_padding_' . $key).' !important;}' . "\n";
			if ( get_theme_mod( 'ccta_radius_' . $key) != '0' ) echo ' .custom_cta_' . $key . ' {-moz-border-radius:' . get_theme_mod( 'ccta_radius_' . $key) . '; -webkit-border-radius:' . get_theme_mod( 'ccta_radius_' . $key) . '; border-radius:' . get_theme_mod( 'ccta_radius_' . $key) . ';}' . "\n";
			if ( ( get_theme_mod( 'ccta_background_color_' . $key) != '#7ebec5' ) OR ( get_theme_mod( 'ccta_background_opacity_' . $key) != '1' ) ) echo ' .custom_cta_' . $key . ' {background: rgba(' . $ccta_background_rgba . ')!important;}' . "\n";
			if ( ( get_theme_mod( 'ccta_title_color_' . $key) != '#999999' ) OR ( get_theme_mod( 'ccta_title_size_' . $key) != '26px' ) ) echo ' .custom_cta_' . $key . ' h2 {color:' . get_theme_mod( 'ccta_title_color_' . $key) . '!important; font-size:' . get_theme_mod( 'ccta_title_size_' . $key) . ';}' . "\n";
			if ( get_theme_mod( 'ccta_button_size_' . $key) != 20 ) {
				$ccta_button_size = strval( get_theme_mod( 'ccta_button_size_' . $key) ).'px';
				$ccta_button_arrow_size = strval( get_theme_mod( 'ccta_button_size_' . $key) + 12 ).'px';
				echo ' .custom_cta_' . $key . ' .et_pb_promo_button {font-size:' . $ccta_button_size . ';}' . "\n";
				echo ' .custom_cta_' . $key . ' .et_pb_promo_button:after {font-size:' . $ccta_button_arrow_size . ';}' . "\n";
			}
			if ( get_theme_mod( 'ccta_button_padding_' . $key) != 20 ) {
				$ccta_button_hor_padding = strval( get_theme_mod( 'ccta_button_padding_' . $key) ).'px';
				$ccta_button_right_padding = strval( get_theme_mod( 'ccta_button_padding_' . $key) + 14 ).'px';
				$ccta_button_left_padding = strval( get_theme_mod( 'ccta_button_padding_' . $key) - 6 ).'px';
				echo ' .custom_cta_' . $key . ' .et_pb_promo_button {padding: 6px ' . $ccta_button_hor_padding . ';}' . "\n";
				echo ' .custom_cta_' . $key . ' .et_pb_promo_button:hover {padding: 6px ' . $ccta_button_right_padding . ' 6px ' . $ccta_button_left_padding . '!important;}' . "\n";
			}
		}
	}

	echo '</style>' . "\n";
	echo '<!-- End Child theme custom CSS -->' . "\n";
	echo "\n";
}
add_action( 'wp_head', 'Divichild_customizer_css' );


/**
 * Get existing Custom Selectors
 */
function get_custom_selectors( $type ) {
	$custom_selectors = false;
	if ( get_theme_mod( $type . '_1', 'off' ) == 'on' ) {
		$count = 1;
		$custom_selectors = array ( $type . '_1' );
		while ( true ) {
			$count++;
			$custom_selector_n = $type . '_' . $count;
			if ( get_theme_mod( $custom_selector_n, 'off' ) == 'on' ) {
				$custom_selectors[] = $custom_selector_n;
				} else {
					break;		
			}
		}
	}
	return $custom_selectors;
}


/**
 * Color hex to rgb converter
 */
function hex2rgb( $hex ) {
   $hex = str_replace( "#", "", $hex );
   if(strlen($hex) == 3) {
		  $r = hexdec( substr( $hex, 0, 1 ) . substr( $hex, 0, 1 ) );
		  $g = hexdec( substr( $hex, 1, 1 ) . substr( $hex, 1, 1 ) );
		  $b = hexdec( substr( $hex, 2, 1 ) . substr( $hex, 2, 1 ) );
	   } else {
		  $r = hexdec( substr( $hex, 0, 2 ) );
		  $g = hexdec( substr( $hex, 2, 2 ) );
		  $b = hexdec( substr( $hex, 4, 2 ) );
   }
   $rgb = array( $r, $g, $b );
   return implode( ",", $rgb );
}

