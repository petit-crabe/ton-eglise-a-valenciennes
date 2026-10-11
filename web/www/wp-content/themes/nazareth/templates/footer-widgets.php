<?php
/**
 * The template to display the widgets area in the footer
 *
 * @package WordPress
 * @subpackage NAZARETH
 * @since NAZARETH 1.0.10
 */

// Footer sidebar
$nazareth_footer_name    = nazareth_get_theme_option( 'footer_widgets' );
$nazareth_footer_present = ! nazareth_is_off( $nazareth_footer_name ) && is_active_sidebar( $nazareth_footer_name );
if ( $nazareth_footer_present ) {
	nazareth_storage_set( 'current_sidebar', 'footer' );
	$nazareth_footer_wide = nazareth_get_theme_option( 'footer_wide' );
	ob_start();
	if ( is_active_sidebar( $nazareth_footer_name ) ) {
		dynamic_sidebar( $nazareth_footer_name );
	}
	$nazareth_out = trim( ob_get_contents() );
	ob_end_clean();
	if ( ! empty( $nazareth_out ) ) {
		$nazareth_out          = preg_replace( "/<\\/aside>[\r\n\s]*<aside/", '</aside><aside', $nazareth_out );
		$nazareth_need_columns = true; 
		if ( $nazareth_need_columns ) {
			$nazareth_columns = max( 0, (int) nazareth_get_theme_option( 'footer_columns' ) );
			if ( 0 == $nazareth_columns ) {
				$nazareth_columns = min( 4, max( 1, substr_count( $nazareth_out, '<aside ' ) ) );
			}
			if ( $nazareth_columns > 1 ) {
				$nazareth_out = preg_replace( '/<aside([^>]*)class="widget/', '<aside$1class="column-1_' . esc_attr( $nazareth_columns ) . ' widget', $nazareth_out );
			} else {
				$nazareth_need_columns = false;
			}
		}
		?>
		<div class="footer_widgets_wrap widget_area<?php echo ! empty( $nazareth_footer_wide ) ? ' footer_fullwidth' : ''; ?> sc_layouts_row sc_layouts_row_type_normal">
			<div class="footer_widgets_inner widget_area_inner">
				<?php
				if ( ! $nazareth_footer_wide ) {
					?>
					<div class="content_wrap">
					<?php
				}
				if ( $nazareth_need_columns ) {
					?>
					<div class="columns_wrap">
					<?php
				}
				do_action( 'nazareth_action_before_sidebar' );
				nazareth_show_layout( $nazareth_out );
				do_action( 'nazareth_action_after_sidebar' );
				if ( $nazareth_need_columns ) {
					?>
					</div><!-- /.columns_wrap -->
					<?php
				}
				if ( ! $nazareth_footer_wide ) {
					?>
					</div><!-- /.content_wrap -->
					<?php
				}
				?>
			</div><!-- /.footer_widgets_inner -->
		</div><!-- /.footer_widgets_wrap -->
		<?php
	}
}
