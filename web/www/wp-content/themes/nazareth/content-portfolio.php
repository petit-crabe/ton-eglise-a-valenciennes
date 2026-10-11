<?php
/**
 * The Portfolio template to display the content
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
		. ( is_sticky() && ! is_paged() ? ' sticky' : '' )
	);
	echo ( ! nazareth_is_off( $nazareth_animation ) && empty( $nazareth_template_args['slider'] ) ? ' data-animation="' . esc_attr( nazareth_get_animation_classes( $nazareth_animation ) ) . '"' : '' );
	?>
>
<?php

// Sticky label
if ( is_sticky() && ! is_paged() ) {
	?>
		<span class="post_label label_sticky"></span>
		<?php
}

	$nazareth_image_hover = ! empty( $nazareth_template_args['hover'] ) && ! nazareth_is_inherit( $nazareth_template_args['hover'] )
								? $nazareth_template_args['hover']
								: nazareth_get_theme_option( 'image_hover' );
	// Featured image
	nazareth_show_post_featured(
		array(
			'singular'      => false,
			'hover'         => $nazareth_image_hover,
			'no_links'      => ! empty( $nazareth_template_args['no_links'] ),
			'thumb_size'    => nazareth_get_thumb_size(
				strpos( nazareth_get_theme_option( 'body_style' ), 'full' ) !== false || $nazareth_columns < 3
								? 'masonry-big'
				: 'masonry'
			),
			'show_no_image' => true,
			'class'         => 'dots' == $nazareth_image_hover ? 'hover_with_info' : '',
			'post_info'     => 'dots' == $nazareth_image_hover ? '<div class="post_info">' . esc_html( get_the_title() ) . '</div>' : '',
		)
	);
	?>
</article></div><?php
// Need opening PHP-tag above, because <article> is a inline-block element (used as column)!