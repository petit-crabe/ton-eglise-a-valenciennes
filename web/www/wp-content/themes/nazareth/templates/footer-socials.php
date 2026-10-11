<?php
/**
 * The template to display the socials in the footer
 *
 * @package WordPress
 * @subpackage NAZARETH
 * @since NAZARETH 1.0.10
 */


// Socials
if ( nazareth_is_on( nazareth_get_theme_option( 'socials_in_footer' ) ) ) {
	$nazareth_output = nazareth_get_socials_links();
	if ( '' != $nazareth_output ) {
		?>
		<div class="footer_socials_wrap socials_wrap">
			<div class="footer_socials_inner">
				<?php nazareth_show_layout( $nazareth_output ); ?>
			</div>
		</div>
		<?php
	}
}
