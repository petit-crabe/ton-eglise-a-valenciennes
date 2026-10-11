<?php
/**
 * The template to show mobile menu
 *
 * @package WordPress
 * @subpackage NAZARETH
 * @since NAZARETH 1.0
 */
?>
<div class="menu_mobile_overlay"></div>
<div class="menu_mobile menu_mobile_<?php echo esc_attr( nazareth_get_theme_option( 'menu_mobile_fullscreen' ) > 0 ? 'fullscreen' : 'narrow' ); ?> scheme_dark">
	<div class="menu_mobile_inner">
		<a class="menu_mobile_close icon-cancel"></a>
		<?php

		// Logo
		set_query_var( 'nazareth_logo_args', array( 'type' => 'mobile' ) );
		get_template_part( apply_filters( 'nazareth_filter_get_template_part', 'templates/header-logo' ) );
		set_query_var( 'nazareth_logo_args', array() );

		// Mobile menu
		$nazareth_menu_mobile = nazareth_get_nav_menu( 'menu_mobile' );
		if ( empty( $nazareth_menu_mobile ) ) {
			$nazareth_menu_mobile = apply_filters( 'nazareth_filter_get_mobile_menu', '' );
			if ( empty( $nazareth_menu_mobile ) ) {
				$nazareth_menu_mobile = nazareth_get_nav_menu( 'menu_main' );
			}
			if ( empty( $nazareth_menu_mobile ) ) {
				$nazareth_menu_mobile = nazareth_get_nav_menu();
			}
		}
		if ( ! empty( $nazareth_menu_mobile ) ) {
			$nazareth_menu_mobile = str_replace(
				array( 'menu_main',   'id="menu-',        'sc_layouts_menu_nav', 'sc_layouts_menu ', 'sc_layouts_hide_on_mobile', 'hide_on_mobile' ),
				array( 'menu_mobile', 'id="menu_mobile-', '',                    ' ',                '',                          '' ),
				$nazareth_menu_mobile
			);
			if ( strpos( $nazareth_menu_mobile, '<nav ' ) === false ) {
				$nazareth_menu_mobile = sprintf( '<nav class="menu_mobile_nav_area">%s</nav>', $nazareth_menu_mobile );
			}
			nazareth_show_layout( apply_filters( 'nazareth_filter_menu_mobile_layout', $nazareth_menu_mobile ) );
		}

		// Search field
		do_action(
			'nazareth_action_search',
			array(
				'style' => 'normal',
				'class' => 'search_mobile',
				'ajax'  => false
			)
		);

		// Social icons
		nazareth_show_layout( nazareth_get_socials_links(), '<div class="socials_mobile">', '</div>' );
		?>
	</div>
</div>
