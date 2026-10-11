<?php
/**
 * The Sidebar containing the main widget areas.
 *
 * @package WordPress
 * @subpackage NAZARETH
 * @since NAZARETH 1.0
 */

if ( nazareth_sidebar_present() ) {
	ob_start();
	$nazareth_sidebar_name = nazareth_get_theme_option( 'sidebar_widgets' . ( is_single() ? '_single' : '' ) );
	nazareth_storage_set( 'current_sidebar', 'sidebar' );
	if ( is_active_sidebar( $nazareth_sidebar_name ) ) {
		dynamic_sidebar( $nazareth_sidebar_name );
	}
	$nazareth_out = trim( ob_get_contents() );
	ob_end_clean();
	if ( ! empty( $nazareth_out ) ) {
		$nazareth_sidebar_position = nazareth_get_theme_option( 'sidebar_position' . ( is_single() ? '_single' : '' ) );
		$nazareth_sidebar_mobile   = nazareth_get_theme_option( 'sidebar_position_mobile' . ( is_single() ? '_single' : '' ) );
		?>
		<div class="sidebar widget_area
			<?php
			echo ' ' . esc_attr( $nazareth_sidebar_position );
			echo ' sidebar_' . esc_attr( $nazareth_sidebar_mobile );

			if ( 'above' == $nazareth_sidebar_mobile ) {
			} else if ( 'float' == $nazareth_sidebar_mobile ) {
				echo ' sidebar_float';
			}
			if ( ! nazareth_is_inherit( nazareth_get_theme_option( 'sidebar_scheme' ) ) ) {
				echo ' scheme_' . esc_attr( nazareth_get_theme_option( 'sidebar_scheme' ) );
			}
			?>
		" role="complementary">
			<?php
			// Single posts banner before sidebar
			nazareth_show_post_banner( 'sidebar' );
			// Button to show/hide sidebar on mobile
			if ( in_array( $nazareth_sidebar_mobile, array( 'above', 'float' ) ) ) {
				$nazareth_title = apply_filters( 'nazareth_filter_sidebar_control_title', 'float' == $nazareth_sidebar_mobile ? esc_html__( 'Show Sidebar', 'nazareth' ) : '' );
				$nazareth_text  = apply_filters( 'nazareth_filter_sidebar_control_text', 'above' == $nazareth_sidebar_mobile ? esc_html__( 'Show Sidebar', 'nazareth' ) : '' );
				?>
				<a href="#" class="sidebar_control" title="<?php echo esc_attr( $nazareth_title ); ?>"><?php echo esc_html( $nazareth_text ); ?></a>
				<?php
			}
			?>
			<div class="sidebar_inner">
				<?php
				do_action( 'nazareth_action_before_sidebar' );
				nazareth_show_layout( preg_replace( "/<\/aside>[\r\n\s]*<aside/", '</aside><aside', $nazareth_out ) );
				do_action( 'nazareth_action_after_sidebar' );
				?>
			</div><!-- /.sidebar_inner -->
		</div><!-- /.sidebar -->
		<div class="clearfix"></div>
		<?php
	}
}
