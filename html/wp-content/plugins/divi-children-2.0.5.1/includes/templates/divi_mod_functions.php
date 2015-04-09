<?php
/**
 * Functions - Child theme custom functions which modify non-pluggable Divi functions
 *
 * Created by Divi Children plugin, http://divi4u.com/divi-children-plugin/ 
 */


function Divichild_theme_setup() {
   remove_shortcode( 'et_pb_blog' );
   add_shortcode( 'et_pb_blog', 'et_pb_blog_Divichild' );
}
add_action( 'after_setup_theme', 'Divichild_theme_setup' );


function et_pb_blog_Divichild( $atts ) {
	extract( shortcode_atts( array(
			'module_id' => '',
			'module_class' => '',
			'fullwidth' => 'on',
			'posts_number' => 10,
			'include_categories' => '',
			'meta_date' => 'M j, Y',
			'show_thumbnail' => 'on',
			'show_content' => 'off',
			'show_author' => 'on',
			'show_date' => 'on',
			'show_categories' => 'on',
			'show_pagination' => 'on',
			'background_layout' => 'light',
			'show_more' => 'off',
		), $atts
	) );
	global $paged;
	$container_is_closed = false;
	if ( 'on' !== $fullwidth ){
		wp_enqueue_script( 'jquery-masonry-3' );
	}
	if ( $module_id != 'newest_post_feed' ) {
		$args = array( 'posts_per_page' => (int) $posts_number );
		} else {
			$args = array( 'posts_per_page' => 1 );
	}
	$et_paged = is_front_page() ? get_query_var( 'page' ) : get_query_var( 'paged' );
	if ( is_front_page() ) {
		$paged = $et_paged;
	}
	if ( '' !== $include_categories )
		$args['cat'] = $include_categories;
	if ( ! is_search() ) {
		$args['paged'] = $et_paged;
	}
	ob_start();
	query_posts( $args );
	$newest_post = wp_get_recent_posts('1');
	$newest_post_ID = $newest_post['0']['ID'];	
	if ( have_posts() ) {
		while ( have_posts() ) {
			the_post();
			if ( ( $module_id != 'no_newest_post_feed' ) OR ( ( $module_id == 'no_newest_post_feed' ) AND ( $newest_post_ID != get_the_ID() ) ) ) {
				$post_format = get_post_format();
				$thumb = '';
				$width = 'on' === $fullwidth ? 1080 : 400;
				$width = (int) apply_filters( 'et_pb_blog_image_width', $width );
				$height = 'on' === $fullwidth ? 675 : 250;
				$height = (int) apply_filters( 'et_pb_blog_image_height', $height );
				$classtext = 'on' === $fullwidth ? 'et_pb_post_main_image' : '';
				$titletext = get_the_title();
				$thumbnail = get_thumbnail( $width, $height, $classtext, $titletext, $titletext, false, 'Blogimage' );
				$thumb = $thumbnail["thumb"];
				$no_thumb_class = '' === $thumb || 'off' === $show_thumbnail ? ' et_pb_no_thumb' : '';
				if ( in_array( $post_format, array( 'video', 'gallery' ) ) ) {
					$no_thumb_class = '';
				} ?>
			<article id="post-<?php the_ID(); ?>" <?php post_class( 'et_pb_post' . $no_thumb_class ); ?>>
			<?php
				et_divi_post_format_content();
				if ( ! in_array( $post_format, array( 'link', 'audio', 'quote' ) ) ) {
					if ( 'video' === $post_format && false !== ( $first_video = et_get_first_video() ) ) :
						printf(
							'<div class="et_main_video_container">
								%1$s
							</div>',
							$first_video
						);
					elseif ( 'gallery' === $post_format ) :
						et_gallery_images();
					elseif ( '' !== $thumb && 'on' === $show_thumbnail ) :
						if ( 'on' !== $fullwidth ) echo '<div class="et_pb_image_container">'; ?>
							<a href="<?php the_permalink(); ?>">
								<?php print_thumbnail( $thumb, $thumbnail["use_timthumb"], $titletext, $width, $height ); ?>
							</a>
					<?php
						if ( 'on' !== $fullwidth ) echo '</div> <!-- .et_pb_image_container -->';
					endif;
				} ?>
			<?php if ( 'off' === $fullwidth || ! in_array( $post_format, array( 'link', 'audio', 'quote', 'gallery' ) ) ) { ?>
				<?php if ( ! in_array( $post_format, array( 'link', 'audio' ) ) ) { ?>
					<h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
				<?php } ?>
				<?php
					if ( 'on' === $show_author || 'on' === $show_date || 'on' === $show_categories ) {
						printf( '<p class="post-meta">%1$s %2$s %3$s %4$s %5$s</p>',
							(
								'on' === $show_author
									? sprintf( __( 'by %s', 'Divi' ), et_get_the_author_posts_link() )
									: ''
							),
							(
								( 'on' === $show_author && 'on' === $show_date )
									? ' | '
									: ''
							),
							(
								'on' === $show_date
									? sprintf( __( '%s', 'Divi' ), get_the_date( $meta_date ) )
									: ''
							),
							(
								(( 'on' === $show_author || 'on' === $show_date ) && 'on' === $show_categories)
									? ' | '
									: ''
							),
							(
								'on' === $show_categories
									? get_the_category_list(', ')
									: ''
							)
						);
					}
					if ( 'on' === $show_content ) {
						global $more;
						$more = null;
						the_content( __( 'read more...', 'Divi' ) );
					} else {
						if ( has_excerpt() ) {
							the_excerpt();
						} else {
							truncate_post( 270 );
						}
						$more = 'on' == $show_more ? sprintf( ' <a href="%1$s" class="more-link" >%2$s</a>' , esc_url( get_permalink() ), __( 'read more', 'Divi' ) )  : '';
						echo $more;
					} ?>
			<?php } // 'off' === $fullwidth || ! in_array( $post_format, array( 'link', 'audio', 'quote', 'gallery' ?>
			</article> <!-- .et_pb_post -->
			<?php
			}
		} // endwhile
		if ( 'on' === $show_pagination && ! is_search() ) {
			echo '</div> <!-- .et_pb_posts -->';
			$container_is_closed = true;
			if ( function_exists( 'wp_pagenavi' ) )
				wp_pagenavi();
			else
				get_template_part( 'includes/navigation', 'index' );
		}
		wp_reset_query();
	} else {
		get_template_part( 'includes/no-results', 'index' );
	}
	$posts = ob_get_contents();	
	ob_end_clean();
	$class = " et_pb_bg_layout_{$background_layout}";
	$output = sprintf(
		'<div%5$s class="%1$s%3$s%6$s">
			%2$s
		%4$s',
		( 'on' === $fullwidth ? 'et_pb_posts' : 'et_pb_blog_grid clearfix' ),
		$posts,
		esc_attr( $class ),
		( ! $container_is_closed ? '</div> <!-- .et_pb_posts -->' : '' ),
		( '' !== $module_id ? sprintf( ' id="%1$s"', esc_attr( $module_id ) ) : '' ),
		( '' !== $module_class ? sprintf( ' %1$s', esc_attr( $module_class ) ) : '' )
	);
	if ( 'on' !== $fullwidth )
		$output = sprintf( '<div class="et_pb_blog_grid_wrapper">%1$s</div>', $output );
	return $output;
}

?>