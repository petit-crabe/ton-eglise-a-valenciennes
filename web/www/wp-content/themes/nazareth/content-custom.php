<?php
/**
 * The custom template to display the content
 *
 * Used for index/archive/search.
 *
 * @package WordPress
 * @subpackage NAZARETH
 * @since NAZARETH 1.0.50
 */

$nazareth_template_args = get_query_var( 'nazareth_template_args' );
if ( is_array( $nazareth_template_args ) ) {
	$nazareth_columns    = empty( $nazareth_template_args['columns'] ) ? 2 : max( 1, $nazareth_template_args['columns'] );
	$nazareth_blog_style = array( $nazareth_template_args['type'], $nazareth_columns );
} else {
	$nazareth_blog_style = explode( '_', nazareth_get_theme_option( 'blog_style' ) );
	$nazareth_columns    = empty( $nazareth_blog_style[1] ) ? 2 : max( 1, $nazareth_blog_style[1] );
}
$nazareth_blog_id       = nazareth_get_custom_blog_id( join( '_', $nazareth_blog_style ) );
$nazareth_blog_style[0] = str_replace( 'blog-custom-', '', $nazareth_blog_style[0] );
$nazareth_expanded      = ! nazareth_sidebar_present() && nazareth_is_on( nazareth_get_theme_option( 'expand_content' ) );
$nazareth_animation     = nazareth_get_theme_option( 'blog_animation' );
$nazareth_components    = nazareth_array_get_keys_by_value( nazareth_get_theme_option( 'meta_parts' ) );
$nazareth_counters      = nazareth_array_get_keys_by_value( nazareth_get_theme_option( 'counters' ) );

$nazareth_post_format   = get_post_format();
$nazareth_post_format   = empty( $nazareth_post_format ) ? 'standard' : str_replace( 'post-format-', '', $nazareth_post_format );

$nazareth_blog_meta     = nazareth_get_custom_layout_meta( $nazareth_blog_id );
$nazareth_custom_style  = ! empty( $nazareth_blog_meta['scripts_required'] ) ? $nazareth_blog_meta['scripts_required'] : 'none';

if ( ! empty( $nazareth_template_args['slider'] ) || $nazareth_columns > 1 || ! nazareth_is_off( $nazareth_custom_style ) ) {
	?><div class="
		<?php
		if ( ! empty( $nazareth_template_args['slider'] ) ) {
			echo 'slider-slide swiper-slide';
		} else {
			echo ( nazareth_is_off( $nazareth_custom_style ) ? 'column' : sprintf( '%1$s_item %1$s_item', $nazareth_custom_style ) ) . '-1_' . esc_attr( $nazareth_columns );
		}
		?>
	">
	<?php
}
?>
<article id="post-<?php the_ID(); ?>" 
<?php
	post_class(
			'post_item post_format_' . esc_attr( $nazareth_post_format )
					. ' post_layout_custom post_layout_custom_' . esc_attr( $nazareth_columns )
					. ' post_layout_' . esc_attr( $nazareth_blog_style[0] )
					. ' post_layout_' . esc_attr( $nazareth_blog_style[0] ) . '_' . esc_attr( $nazareth_columns )
					. ( ! nazareth_is_off( $nazareth_custom_style )
						? ' post_layout_' . esc_attr( $nazareth_custom_style )
							. ' post_layout_' . esc_attr( $nazareth_custom_style ) . '_' . esc_attr( $nazareth_columns )
						: ''
						)
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
	// Custom header's layout
	do_action( 'nazareth_action_show_layout', $nazareth_blog_id );
	?>
</article><?php
if ( ! empty( $nazareth_template_args['slider'] ) || $nazareth_columns > 1 || ! nazareth_is_off( $nazareth_custom_style ) ) {
	?></div><?php
	// Need opening PHP-tag above just after </div>, because <div> is a inline-block element (used as column)!
}
