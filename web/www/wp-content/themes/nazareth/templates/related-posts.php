<?php
/**
 * The template 'Style 1' to displaying related posts
 *
 * @package WordPress
 * @subpackage NAZARETH
 * @since NAZARETH 1.0
 */

$nazareth_link        = get_permalink();
$nazareth_post_format = get_post_format();
$nazareth_post_format = empty( $nazareth_post_format ) ? 'standard' : str_replace( 'post-format-', '', $nazareth_post_format );
?><div id="post-<?php the_ID(); ?>" <?php post_class( 'related_item related_item_style_1 post_format_' . esc_attr( $nazareth_post_format ) ); ?>>
	<?php
	nazareth_show_post_featured(
		array(
			'thumb_size'    => apply_filters( 'nazareth_filter_related_thumb_size', nazareth_get_thumb_size( (int) nazareth_get_theme_option( 'related_posts' ) == 1 ? 'huge' : 'big' ) ),
			'show_no_image' => nazareth_get_theme_setting( 'allow_no_image' ),
			'singular'      => false,
			'post_info'     => '<div class="post_header entry-header">'
						. '<div class="post_categories">' . wp_kses( nazareth_get_post_categories( '' ), 'nazareth_kses_content' ) . '</div>'
						. '<h6 class="post_title entry-title"><a href="' . esc_url( $nazareth_link ) . '">' . wp_kses_data( get_the_title() ) . '</a></h6>'
						. ( in_array( get_post_type(), array( 'post', 'attachment' ) )
								? '<span class="post_date"><a href="' . esc_url( $nazareth_link ) . '">' . wp_kses_data( nazareth_get_date() ) . '</a></span>'
								: '' )
					. '</div>',
		)
	);
	?>
</div>
