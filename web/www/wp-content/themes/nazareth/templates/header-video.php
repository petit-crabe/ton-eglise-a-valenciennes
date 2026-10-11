<?php
/**
 * The template to display the background video in the header
 *
 * @package WordPress
 * @subpackage NAZARETH
 * @since NAZARETH 1.0.14
 */
$nazareth_header_video = nazareth_get_header_video();
$nazareth_embed_video  = '';
if ( ! empty( $nazareth_header_video ) && ! nazareth_is_from_uploads( $nazareth_header_video ) ) {
	if ( nazareth_is_youtube_url( $nazareth_header_video ) && preg_match( '/[=\/]([^=\/]*)$/', $nazareth_header_video, $matches ) && ! empty( $matches[1] ) ) {
		?><div id="background_video" data-youtube-code="<?php echo esc_attr( $matches[1] ); ?>"></div>
		<?php
	} else {
		?>
		<div id="background_video"><?php nazareth_show_layout( nazareth_get_embed_video( $nazareth_header_video ) ); ?></div>
		<?php
	}
}
