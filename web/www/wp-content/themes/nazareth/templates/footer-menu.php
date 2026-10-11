<?php
/**
 * The template to display menu in the footer
 *
 * @package WordPress
 * @subpackage NAZARETH
 * @since NAZARETH 1.0.10
 */

// Footer menu
$nazareth_menu_footer = nazareth_get_nav_menu(
	array(
		'location' => 'menu_footer',
		'class'    => 'sc_layouts_menu sc_layouts_menu_default',
	)
);
if ( ! empty( $nazareth_menu_footer ) ) {
	?>
	<div class="footer_menu_wrap">
		<div class="footer_menu_inner">
			<?php nazareth_show_layout( $nazareth_menu_footer ); ?>
		</div>
	</div>
	<?php
}
