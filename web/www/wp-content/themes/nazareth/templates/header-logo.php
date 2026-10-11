<?php
/**
 * The template to display the logo or the site name and the slogan in the Header
 *
 * @package WordPress
 * @subpackage NAZARETH
 * @since NAZARETH 1.0
 */

$nazareth_args = get_query_var( 'nazareth_logo_args' );

// Site logo
$nazareth_logo_type   = isset( $nazareth_args['type'] ) ? $nazareth_args['type'] : '';
$nazareth_logo_image  = nazareth_get_logo_image( $nazareth_logo_type );
$nazareth_logo_text   = nazareth_is_on( nazareth_get_theme_option( 'logo_text' ) ) ? get_bloginfo( 'name' ) : '';
$nazareth_logo_slogan = get_bloginfo( 'description', 'display' );
if ( ! empty( $nazareth_logo_image ) || ! empty( $nazareth_logo_text ) ) {
	?><a class="sc_layouts_logo" href="<?php echo esc_url( home_url( '/' ) ); ?>">
		<?php
		if ( ! empty( $nazareth_logo_image ) ) {
			if ( empty( $nazareth_logo_type ) && function_exists( 'the_custom_logo' ) && (int) $nazareth_logo_image > 0 ) {
				the_custom_logo();
			} else {
				$nazareth_attr = nazareth_getimagesize( $nazareth_logo_image );
				echo '<img src="' . esc_url( $nazareth_logo_image ) . '" alt="' . esc_attr( $nazareth_logo_text ) . '"' . ( ! empty( $nazareth_attr[3] ) ? ' ' . wp_kses_data( $nazareth_attr[3] ) : '' ) . '>';
			}
		} else {
			nazareth_show_layout( nazareth_prepare_macros( $nazareth_logo_text ), '<span class="logo_text">', '</span>' );
			nazareth_show_layout( nazareth_prepare_macros( $nazareth_logo_slogan ), '<span class="logo_slogan">', '</span>' );
		}
		?>
	</a>
	<?php
}
