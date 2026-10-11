<?php
/**
 * The template to display the widgets area in the header
 *
 * @package WordPress
 * @subpackage NAZARETH
 * @since NAZARETH 1.0
 */

// Header sidebar
$nazareth_header_name    = nazareth_get_theme_option( 'header_widgets' );
$nazareth_header_present = ! nazareth_is_off( $nazareth_header_name ) && is_active_sidebar( $nazareth_header_name );
if ( $nazareth_header_present ) {
	nazareth_storage_set( 'current_sidebar', 'header' );
	$nazareth_header_wide = nazareth_get_theme_option( 'header_wide' );
	ob_start();
	if ( is_active_sidebar( $nazareth_header_name ) ) {
		dynamic_sidebar( $nazareth_header_name );
	}
	$nazareth_widgets_output = ob_get_contents();
	ob_end_clean();
	if ( ! empty( $nazareth_widgets_output ) ) {
		$nazareth_widgets_output = preg_replace( "/<\/aside>[\r\n\s]*<aside/", '</aside><aside', $nazareth_widgets_output );
		$nazareth_need_columns   = strpos( $nazareth_widgets_output, 'columns_wrap' ) === false;
		if ( $nazareth_need_columns ) {
			$nazareth_columns = max( 0, (int) nazareth_get_theme_option( 'header_columns' ) );
			if ( 0 == $nazareth_columns ) {
				$nazareth_columns = min( 6, max( 1, substr_count( $nazareth_widgets_output, '<aside ' ) ) );
			}
			if ( $nazareth_columns > 1 ) {
				$nazareth_widgets_output = preg_replace( '/<aside([^>]*)class="widget/', '<aside$1class="column-1_' . esc_attr( $nazareth_columns ) . ' widget', $nazareth_widgets_output );
			} else {
				$nazareth_need_columns = false;
			}
		}
		?>
		<div class="header_widgets_wrap widget_area<?php echo ! empty( $nazareth_header_wide ) ? ' header_fullwidth' : ' header_boxed'; ?>">
			<div class="header_widgets_inner widget_area_inner">
				<?php
				if ( ! $nazareth_header_wide ) {
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
				nazareth_show_layout( $nazareth_widgets_output );
				do_action( 'nazareth_action_after_sidebar' );
				if ( $nazareth_need_columns ) {
					?>
					</div>	<!-- /.columns_wrap -->
					<?php
				}
				if ( ! $nazareth_header_wide ) {
					?>
					</div>	<!-- /.content_wrap -->
					<?php
				}
				?>
			</div>	<!-- /.header_widgets_inner -->
		</div>	<!-- /.header_widgets_wrap -->
		<?php
	}
}
