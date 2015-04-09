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

add_action( 'after_setup_theme', 'remove_parent_theme_features', 10 );
function remove_parent_theme_features() {
    // remove the parent shortcode
    remove_shortcode( 'et_pb_contact_form' );
    // add our shortcode
    add_shortcode( 'et_pb_contact_form', 'child_et_pb_contact_form' );
}

// create our shortcode that overwrites the parent one
function child_et_pb_contact_form( $atts, $content = null ) {
global $et_pb_contact_form_num;

	extract( shortcode_atts( array(
			'module_id' => '',
			'module_class' => '',
			'captcha' => 'on',
			'email' => '',
			'title' => '',
		), $atts
	) );

	$et_error_message = '';
	$et_contact_error = false;
	$contact_email = isset( $_POST['et_pb_contact_email'] ) ? sanitize_email( $_POST['et_pb_contact_email'] ) : '';

	if ( isset( $_POST['et_pb_contactform_submit'] ) ) {
		if ( 'on' === $captcha && ( ! isset( $_POST['et_pb_contact_captcha'] ) || empty( $_POST['et_pb_contact_captcha'] ) ) ) {
			$et_error_message .= sprintf( '<p>%1$s</p>', esc_html__( 'Make sure you entered the captcha.', 'Divi' ) );
			$et_contact_error = true;
		} else if ( 'on' === $captcha && ( $_POST['et_pb_contact_captcha'] <> ( $_SESSION['et_pb_first_digit'] + $_SESSION['et_pb_second_digit'] ) ) ) {
			$et_error_message .= sprintf( '<p>%1$s</p>', esc_html__( 'You entered the wrong number in captcha.', 'Divi' ) );

			unset( $_SESSION['et_pb_first_digit'] );
			unset( $_SESSION['et_pb_second_digit'] );

			$et_contact_error = true;
		} else if ( empty( $_POST['et_pb_contact_name'] ) || empty( $contact_email ) || empty( $_POST['et_pb_contact_message'] ) ) {
			$et_error_message .= sprintf( '<p>%1$s</p>', esc_html__( 'Make sure you fill all fields.', 'Divi' ) );
			$et_contact_error = true;
		}

		if ( ! is_email( $contact_email ) ) {
			$et_error_message .= sprintf( '<p>%1$s</p>', esc_html__( 'Invalid email address.', 'Divi' ) );
			$et_contact_error = true;
		}
	} else {
		$et_contact_error = true;
		if ( isset( $_SESSION['et_pb_first_digit'] ) )
			unset( $_SESSION['et_pb_first_digit'] );
		if ( isset( $_SESSION['et_pb_second_digit'] ) )
			unset( $_SESSION['et_pb_second_digit'] );
	}

	if ( ! isset( $_SESSION['et_pb_first_digit'] ) )
		$_SESSION['et_pb_first_digit'] = $et_pb_first_digit = rand(1, 15);
	else
		$et_pb_first_digit = $_SESSION['et_pb_first_digit'];

	if ( ! isset( $_SESSION['et_pb_second_digit'] ) )
		$_SESSION['et_pb_second_digit'] = $et_pb_second_digit = rand(1, 15);
	else
		$et_pb_second_digit = $_SESSION['et_pb_second_digit'];

	if ( ! $et_contact_error && isset( $_POST['_wpnonce-et-pb-contact-form-submitted'] ) && wp_verify_nonce( $_POST['_wpnonce-et-pb-contact-form-submitted'], 'et-pb-contact-form-submit' ) ) {
		$et_email_to = '' !== $email
			? $email
			: get_site_option( 'admin_email' );

		$et_site_name = get_option( 'blogname' );

		$contact_name 	= stripslashes( sanitize_text_field( $_POST['et_pb_contact_name'] ) );

		$headers[] = "From: \"{$contact_name}\" <{$contact_email}>";
		$headers[] = "Reply-To: <{$contact_email}>";

		wp_mail( apply_filters( 'et_contact_page_email_to', $et_email_to ),
			sprintf( __( 'New Message From %1$s%2$s', 'Divi' ),
				sanitize_text_field( $et_site_name ),
				( '' !== $title ? sprintf( _x( ' - %s', 'contact form title separator', 'Divi' ), sanitize_text_field( $title ) ) : '' )
			),  
            sprintf(__( 'Name: %1$s\r\nPhone: %2$s\r\nSuburb: %3$s\r\nMessage: %4$s\r\n', 'Divi' ), 
                $contact_name,
                stripslashes( sanitize_text_field( $_POST['et_pb_contact_phone'] ) ),
                stripslashes( sanitize_text_field( $_POST['et_pb_contact_suburb'] ) ),
                stripslashes( wp_strip_all_tags( $_POST['et_pb_contact_message'] ) )
            ), 
            apply_filters( 'et_contact_page_headers', $headers, $contact_name, $contact_email ) );

		$et_error_message = sprintf( '<p>%1$s</p>', esc_html__( 'Thanks for contacting us', 'Divi' ) );
	}

	$form = '';

	$name_label = __( 'Name', 'Divi' );
	$email_label = __( 'Email Address', 'Divi' );
	$message_label = __( 'Message', 'Divi' );
    $suburb_label = __( 'Suburb', 'Divi' );
    $phone_label = __( 'Phone', 'Divi' );

	$et_pb_contact_form_num = ! isset( $et_pb_contact_form_num ) ? 1 : $et_pb_contact_form_num++;

	$et_pb_captcha = sprintf( '
		<div class="et_pb_contact_right">
			<p class="clearfix">
				%1$s = <input type="text" size="2" class="input et_pb_contact_captcha" value="" name="et_pb_contact_captcha">
			</p>
		</div> <!-- .et_pb_contact_right -->',
		sprintf( '%1$s + %2$s', esc_html( $et_pb_first_digit ), esc_html( $et_pb_second_digit ) )
	);

	if ( $et_contact_error )
			$form = sprintf( '
			<div class="et_pb_contact">
				<!--<div class="et-pb-contact-message">%11$s</div>-->
				<form class="et_pb_contact_form clearfix" method="post" action="%1$s">
					<div class="et_pb_contact_left">
						<p class="clearfix">
							<label class="et_pb_contact_form_label">%2$s</label>
							<input type="text" class="input et_pb_contact_name" value="%3$s" name="et_pb_contact_name">
						</p>
						<p class="clearfix">
							<label class="et_pb_contact_form_label">%12$s</label>
							<input type="text" class="input et_pb_contact_suburb" value="%13$s" name="et_pb_contact_suburb">
						</p>
					</div> <!-- .et_pb_contact_left -->

					<div class="clear"></div>
                    <div class="et_pb_contact_left">
                        <p class="clearfix">
							<label class="et_pb_contact_form_label">%4$s</label>
							<input type="text" class="input et_pb_contact_email" value="%5$s" name="et_pb_contact_email">
						</p>
						<p class="clearfix">
							<label class="et_pb_contact_form_label">%14$s</label>
							<input type="text" class="input et_pb_contact_phone" value="%15$s" name="et_pb_contact_phone">
						</p>
					</div> <!-- .et_pb_contact_left -->

					<div class="clear"></div>
					<p class="clearfix">
						<label class="et_pb_contact_form_label">%7$s</label>
						<textarea name="et_pb_contact_message" class="et_pb_contact_message input">%8$s</textarea>
					</p>

					<input type="hidden" value="et_contact_proccess" name="et_pb_contactform_submit">

					<input type="submit" value="%9$s" class="et_pb_contact_submit">

					%6$s

					%10$s
				</form>
			</div> <!-- .et_pb_contact -->',
			esc_url( get_permalink( get_the_ID() ) ),
			$name_label,
			( isset( $_POST['et_pb_contact_name'] ) ? esc_attr( $_POST['et_pb_contact_name'] ) : $name_label ),
			$email_label,
			( isset( $_POST['et_pb_contact_email'] ) ? esc_attr( $_POST['et_pb_contact_email'] ) : $email_label ),
			(  'on' === $captcha ? $et_pb_captcha : '' ),
			$message_label,
			( isset( $_POST['et_pb_contact_message'] ) ? esc_attr( $_POST['et_pb_contact_message'] ) : $message_label ),
			__( 'Submit', 'Divi' ),
			wp_nonce_field( 'et-pb-contact-form-submit', '_wpnonce-et-pb-contact-form-submitted', true, false ),
			$et_error_message,
            $suburb_label,
			( isset( $_POST['et_pb_contact_suburb'] ) ? esc_attr( $_POST['et_pb_contact_suburb'] ) : $suburb_label ),
			$phone_label,
			( isset( $_POST['et_pb_contact_phone'] ) ? esc_attr( $_POST['et_pb_contact_phone'] ) : $phone_label )
		);

	$output = sprintf( '
		<div id="%4$s" class="et_pb_contact_form_container clearfix%5$s">
			%1$s
			%2$s
			%3$s
		</div> <!-- .et_pb_contact_form_container -->
		',
		( '' !== $title ? sprintf( '<h1 class="et_pb_contact_main_title">%1$s</h1>', esc_html( $title ) ) : '' ),
		( '' !== $et_error_message ? sprintf( '<div class="et-pb-contact-message">%1$s</div>', $et_error_message ) : '' ),
		$form,
		( '' !== $module_id
			? esc_attr( $module_id )
			: esc_attr( 'et_pb_contact_form_' . $et_pb_contact_form_num )
		),
		( '' !== $module_class ? sprintf( ' %1$s', esc_attr( $module_class ) ) : '' )
	);

	return $output;
}

?>