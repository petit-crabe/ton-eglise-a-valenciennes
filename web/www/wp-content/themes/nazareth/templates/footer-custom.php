<?php
/**
 * The template to display default site footer
 *
 * @package WordPress
 * @subpackage NAZARETH
 * @since NAZARETH 1.0.10
 */

$nazareth_footer_id = nazareth_get_custom_footer_id();
$nazareth_footer_meta = get_post_meta( $nazareth_footer_id, 'trx_addons_options', true );
if ( ! empty( $nazareth_footer_meta['margin'] ) ) {
	nazareth_add_inline_css( sprintf( '.page_content_wrap{padding-bottom:%s}', esc_attr( nazareth_prepare_css_value( $nazareth_footer_meta['margin'] ) ) ) );
}
?>
<footer class="footer_wrap footer_custom footer_custom_<?php echo esc_attr( $nazareth_footer_id ); ?> footer_custom_<?php echo esc_attr( sanitize_title( get_the_title( $nazareth_footer_id ) ) ); ?>
						<?php
						if ( ! nazareth_is_inherit( nazareth_get_theme_option( 'footer_scheme' ) ) ) {
							echo ' scheme_' . esc_attr( nazareth_get_theme_option( 'footer_scheme' ) );
						}
						?>
						">
	<?php
	// Custom footer's layout
	do_action( 'nazareth_action_show_layout', $nazareth_footer_id );
	?>
</footer><!-- /.footer_wrap -->
