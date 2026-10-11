<?php
/**
 * The Gallery template to display posts
 *
 * Used for index/archive/search.
 *
 * @package WordPress
 * @subpackage NAZARETH
 * @since NAZARETH 1.0
 */

$nazareth_template_args = get_query_var( 'nazareth_template_args' );
if ( is_array( $nazareth_template_args ) ) {
	$nazareth_columns    = empty( $nazareth_template_args['columns'] ) ? 2 : max( 1, $nazareth_template_args['columns'] );
	$nazareth_blog_style = array( $nazareth_template_args['type'], $nazareth_columns );
} else {
	$nazareth_blog_style = explode( '_', nazareth_get_theme_option( 'blog_style' ) );
	$nazareth_columns    = empty( $nazareth_blog_style[1] ) ? 2 : max( 1, $nazareth_blog_style[1] );
}
$nazareth_post_format = get_post_format();
$nazareth_post_format = empty( $nazareth_post_format ) ? 'standard' : str_replace( 'post-format-', '', $nazareth_post_format );
$nazareth_animation   = nazareth_get_theme_option( 'blog_animation' );
$nazareth_image       = wp_get_attachment_image_src( get_post_thumbnail_id( get_the_ID() ), 'full' );

?><div class="
<?php
if ( ! empty( $nazareth_template_args['slider'] ) ) {
	echo ' slider-slide swiper-slide';
} else {
	echo 'masonry_item masonry_item-1_' . esc_attr( $nazareth_columns );
}
?>
"><article id="post-<?php the_ID(); ?>" 
	<?php
	post_class(
		'post_item post_format_' . esc_attr( $nazareth_post_format )
		. ' post_layout_portfolio'
		. ' post_layout_portfolio_' . esc_attr( $nazareth_columns )
		. ' post_layout_gallery'
		. ' post_layout_gallery_' . esc_attr( $nazareth_columns )
	);
	echo ( ! nazareth_is_off( $nazareth_animation ) && empty( $nazareth_template_args['slider'] ) ? ' data-animation="' . esc_attr( nazareth_get_animation_classes( $nazareth_animation ) ) . '"' : '' );
	?>
	data-size="
		<?php
		if ( ! empty( $nazareth_image[1] ) && ! empty( $nazareth_image[2] ) ) {
			echo intval( $nazareth_image[1] ) . 'x' . intval( $nazareth_image[2] );}
		?>
	"
	data-src="
		<?php
		if ( ! empty( $nazareth_image[0] ) ) {
			echo esc_url( $nazareth_image[0] );}
		?>
	"
>
<?php

	// Sticky label
if ( is_sticky() && ! is_paged() ) {
	?>
		<span class="post_label label_sticky"></span>
		<?php
}

	// Featured image
	$nazareth_image_hover = 'icon';  
if ( in_array( $nazareth_image_hover, array( 'icons', 'zoom' ) ) ) {
	$nazareth_image_hover = 'dots';
}
$nazareth_components = nazareth_array_get_keys_by_value( nazareth_get_theme_option( 'meta_parts' ) );
$nazareth_counters   = nazareth_array_get_keys_by_value( nazareth_get_theme_option( 'counters' ) );
nazareth_show_post_featured(
	array(
		'hover'         => $nazareth_image_hover,
		'singular'      => false,
		'no_links'      => ! empty( $nazareth_template_args['no_links'] ),
		'thumb_size'    => nazareth_get_thumb_size( strpos( nazareth_get_theme_option( 'body_style' ), 'full' ) !== false || $nazareth_columns < 3 ? 'masonry-big' : 'masonry' ),
		'thumb_only'    => true,
		'show_no_image' => true,
		'post_info'     => '<div class="post_details">'
						. '<h2 class="post_title">'
							. ( empty( $nazareth_template_args['no_links'] )
								? '<a href="' . esc_url( get_permalink() ) . '">' . esc_html( get_the_title() ) . '</a>'
								: esc_html( get_the_title() )
								)
						. '</h2>'
						. '<div class="post_description">'
							. ( ! empty( $nazareth_components )
								? nazareth_show_post_meta(
									apply_filters(
										'nazareth_filter_post_meta_args', array(
											'components' => $nazareth_components,
											'counters' => $nazareth_counters,
											'seo'      => false,
											'echo'     => false,
										), $nazareth_blog_style[0], $nazareth_columns
									)
								)
								: ''
								)
							. ( empty( $nazareth_template_args['hide_excerpt'] )
								? '<div class="post_description_content">' . get_the_excerpt() . '</div>'
								: ''
								)
							. ( empty( $nazareth_template_args['no_links'] )
								? '<a href="' . esc_url( get_permalink() ) . '" class="theme_button post_readmore"><span class="post_readmore_label">' . esc_html__( 'Learn more', 'nazareth' ) . '</span></a>'
								: ''
								)
						. '</div>'
					. '</div>',
	)
);
?>
</article></div><?php
// Need opening PHP-tag above, because <article> is a inline-block element (used as column)!
