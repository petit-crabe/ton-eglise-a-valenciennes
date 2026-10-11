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
<div class="nazareth_admin_notice nazareth_rate_notice update-nag">
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
	<h3 class="nazareth_notice_title"><a href="<?php echo esc_url( nazareth_storage_get( 'theme_rate_url' ) ); ?>" target="_blank">
		<?php
		echo esc_html(
			sprintf(
				// Translators: Add theme name and version to the 'Welcome' message
				__( 'Rate our theme "%s", please', 'nazareth' ),
				$nazareth_theme_obj->name . ( NAZARETH_THEME_FREE ? ' ' . __( 'Free', 'nazareth' ) : '' )
			)
		);
		?>
	</a></h3>
	<?php

	// Description
	?>
	<div class="nazareth_notice_text">
		<p><?php echo wp_kses_data( __( 'We are glad you chose our WP theme for your website. You’ve done well customizing your website and we hope that you’ve enjoyed working with our theme.', 'nazareth' ) ); ?></p>
		<p><?php echo wp_kses_data( __( 'It would be just awesome if you spend just a minute of your time to rate our theme or the customer service you’ve received from us.', 'nazareth' ) ); ?></p>
		<p class="nazareth_notice_text_info"><?php echo wp_kses_data( __( '* We love receiving your reviews! Every time you leave a review, our CEO Henry Rise gives $5 to homeless dog shelter! Save the planet with us!', 'nazareth' ) ); ?></p>
	</div>
	<?php

	// Buttons
	?>
	<div class="nazareth_notice_buttons">
		<?php
		// Link to the theme download page
		?>
		<a href="<?php echo esc_url( nazareth_storage_get( 'theme_rate_url' ) ); ?>" class="button button-primary" target="_blank"><i class="dashicons dashicons-star-filled"></i> 
			<?php
			// Translators: Add theme name
			echo esc_html( sprintf( __( 'Rate theme %s', 'nazareth' ), $nazareth_theme_obj->name ) );
			?>
		</a>
		<?php
		// Link to the theme support
		?>
		<a href="<?php echo esc_url( nazareth_storage_get( 'theme_support_url' ) ); ?>" class="button" target="_blank"><i class="dashicons dashicons-sos"></i> 
			<?php
			esc_html_e( 'Support', 'nazareth' );
			?>
		</a>
		<?php
		// Link to the theme documentation
		?>
		<a href="<?php echo esc_url( nazareth_storage_get( 'theme_doc_url' ) ); ?>" class="button" target="_blank"><i class="dashicons dashicons-book"></i> 
			<?php
			esc_html_e( 'Documentation', 'nazareth' );
			?>
		</a>
		<?php
		// Dismiss
		?>
		<a href="#" class="nazareth_hide_notice"><i class="dashicons dashicons-dismiss"></i> <span class="nazareth_hide_notice_text"><?php esc_html_e( 'Dismiss', 'nazareth' ); ?></span></a>
	</div>
</div>
