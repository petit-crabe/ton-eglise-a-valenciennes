<?php
/**
 * The template to display Admin notices
 *
 * @package WordPress
 * @subpackage NAZARETH
 * @since NAZARETH 1.0.1
 */

$nazareth_theme_obj = wp_get_theme();
?>
<div class="nazareth_admin_notice nazareth_welcome_notice update-nag">
	<?php
	// Theme image
	$nazareth_theme_img = nazareth_get_file_url( 'screenshot.jpg' );
	if ( '' != $nazareth_theme_img ) {
		?>
		<div class="nazareth_notice_image"><img src="<?php echo esc_url( $nazareth_theme_img ); ?>" alt="<?php esc_attr_e( 'Theme screenshot', 'nazareth' ); ?>"></div>
		<?php
	}

	// Title
	?>
	<h3 class="nazareth_notice_title">
		<?php
		echo esc_html(
			sprintf(
				// Translators: Add theme name and version to the 'Welcome' message
				__( 'Welcome to %1$s v.%2$s', 'nazareth' ),
				$nazareth_theme_obj->name . ( NAZARETH_THEME_FREE ? ' ' . __( 'Free', 'nazareth' ) : '' ),
				$nazareth_theme_obj->version
			)
		);
		?>
	</h3>
	<?php

	// Description
	?>
	<div class="nazareth_notice_text">
		<p class="nazareth_notice_text_description">
			<?php
			echo str_replace( '. ', '.<br>', wp_kses_data( $nazareth_theme_obj->description ) );
			?>
		</p>
		<p class="nazareth_notice_text_info">
			<?php
			echo wp_kses_data( __( 'Attention! Plugin "ThemeREX Addons" is required! Please, install and activate it!', 'nazareth' ) );
			?>
		</p>
	</div>
	<?php

	// Buttons
	?>
	<div class="nazareth_notice_buttons">
		<?php
		// Link to the page 'About Theme'
		?>
		<a href="<?php echo esc_url( admin_url() . 'themes.php?page=nazareth_about' ); ?>" class="button button-primary"><i class="dashicons dashicons-nametag"></i> 
			<?php
			echo esc_html__( 'Install plugin "ThemeREX Addons"', 'nazareth' );
			?>
		</a>
		<?php		
		// Dismiss this notice
		?>
		<a href="#" class="nazareth_hide_notice"><i class="dashicons dashicons-dismiss"></i> <span class="nazareth_hide_notice_text"><?php esc_html_e( 'Dismiss', 'nazareth' ); ?></span></a>
	</div>
</div>
