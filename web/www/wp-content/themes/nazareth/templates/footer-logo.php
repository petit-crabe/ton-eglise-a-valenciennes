<?php
/**
 * The template to display the site logo in the footer
 *
 * @package WordPress
 * @subpackage NAZARETH
 * @since NAZARETH 1.0.10
 */

// Logo
if ( nazareth_is_on( nazareth_get_theme_option( 'logo_in_footer' ) ) ) {
	$nazareth_logo_image = nazareth_get_logo_image( 'footer' );
	$nazareth_logo_text  = get_bloginfo( 'name' );
	if ( ! empty( $nazareth_logo_image ) || ! empty( $nazareth_logo_text ) ) {
		?>
		<div class="footer_logo_wrap">
			<div class="footer_logo_inner">
				<?php
				if ( ! empty( $nazareth_logo_image ) ) {
					$nazareth_attr = nazareth_getimagesize( $nazareth_logo_image );
					echo '<a href="' . esc_url( home_url( '/' ) ) . '">'
							. '<img src="' . esc_url( $nazareth_logo_image ) . '"'
								. ' class="logo_footer_image"'
								. ' alt="' . esc_attr__( 'Site logo', 'nazareth' ) . '"'
								. ( ! empty( $nazareth_attr[3] ) ? ' ' . wp_kses_data( $nazareth_attr[3] ) : '' )
							. '>'
						. '</a>';
				} elseif ( ! empty( $nazareth_logo_text ) ) {
					echo '<h1 class="logo_footer_text">'
							. '<a href="' . esc_url( home_url( '/' ) ) . '">'
								. esc_html( $nazareth_logo_text )
							. '</a>'
						. '</h1>';
				}
				?>
			</div>
		</div>
		<?php
	}
}
