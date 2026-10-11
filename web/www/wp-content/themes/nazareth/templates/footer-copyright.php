<?php
/**
 * The template to display the copyright info in the footer
 *
 * @package WordPress
 * @subpackage NAZARETH
 * @since NAZARETH 1.0.10
 */

// Copyright area
?> 
<div class="footer_copyright_wrap
<?php
if ( ! nazareth_is_inherit( nazareth_get_theme_option( 'copyright_scheme' ) ) ) {
	echo ' scheme_' . esc_attr( nazareth_get_theme_option( 'copyright_scheme' ) );
}
?>
				">
	<div class="footer_copyright_inner">
		<div class="content_wrap">
			<div class="copyright_text">
			<?php
				$nazareth_copyright = nazareth_get_theme_option( 'copyright' );
			if ( ! empty( $nazareth_copyright ) ) {
				// Replace {{Y}} or {Y} with the current year
				$nazareth_copyright = str_replace( array( '{{Y}}', '{Y}' ), date( 'Y' ), $nazareth_copyright );
				// Replace {{...}} and ((...)) on the <i>...</i> and <b>...</b>
				$nazareth_copyright = nazareth_prepare_macros( $nazareth_copyright );
				// Display copyright
				echo wp_kses_post( nl2br( $nazareth_copyright ) );
			}
			?>
			</div>
		</div>
	</div>
</div>
