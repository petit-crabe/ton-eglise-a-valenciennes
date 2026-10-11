<?php
/**
 * The Header: Logo and main menu
 *
 * @package WordPress
 * @subpackage NAZARETH
 * @since NAZARETH 1.0
 */
?><!DOCTYPE html>
<html <?php language_attributes(); ?> class="no-js
									<?php
										// Class scheme_xxx need in the <html> as context for the <body>!
										echo ' scheme_' . esc_attr( nazareth_get_theme_option( 'color_scheme' ) );
									?>
										">
<head>
	<?php wp_head(); ?>
</head>

<body <?php	body_class(); ?>>

	<?php do_action( 'nazareth_action_before_body' ); ?>

	<div class="body_wrap">

		<div class="page_wrap">
			<?php
			// Desktop header
			$nazareth_header_type = nazareth_get_theme_option( 'header_type' );
			if ( 'custom' == $nazareth_header_type && ! nazareth_is_layouts_available() ) {
				$nazareth_header_type = 'default';
			}
			get_template_part( apply_filters( 'nazareth_filter_get_template_part', "templates/header-{$nazareth_header_type}" ) );

			// Side menu
			if ( in_array( nazareth_get_theme_option( 'menu_style' ), array( 'left', 'right' ) ) ) {
				get_template_part( apply_filters( 'nazareth_filter_get_template_part', 'templates/header-navi-side' ) );
			}

			// Mobile menu
			get_template_part( apply_filters( 'nazareth_filter_get_template_part', 'templates/header-navi-mobile' ) );
			
			// Single posts banner after header
			nazareth_show_post_banner( 'header' );
			?>

			<div class="page_content_wrap">
				<?php
				// Single posts banner on the background
				if ( is_singular( 'post' ) ) {

					nazareth_show_post_banner( 'background' );

					$nazareth_post_thumbnail_type  = nazareth_get_theme_option( 'post_thumbnail_type' );
					$nazareth_post_header_position = nazareth_get_theme_option( 'post_header_position' );
					$nazareth_post_header_align    = nazareth_get_theme_option( 'post_header_align' );

					// Boxed post thumbnail
					if ( in_array( $nazareth_post_thumbnail_type, array( 'boxed', 'fullwidth') ) ) {
						?>
						<div class="header_content_wrap header_align_<?php echo esc_attr( $nazareth_post_header_align ); ?>">
							<?php
							if ( 'boxed' === $nazareth_post_thumbnail_type ) {
								?>
								<div class="content_wrap">
								<?php
							}

							// Post title and meta
							if ( 'above' === $nazareth_post_header_position ) {
								nazareth_show_post_title_and_meta();
							}

							// Featured image
							nazareth_show_post_featured_image();

							// Post title and meta
							if ( in_array( $nazareth_post_header_position, array( 'under', 'on_thumb' ) ) ) {
								nazareth_show_post_title_and_meta();
							}

							if ( 'boxed' === $nazareth_post_thumbnail_type ) {
								?>
								</div>
								<?php
							}
							?>
						</div>
						<?php
					}
				}

				if ( 'fullscreen' != nazareth_get_theme_option( 'body_style' ) ) {
					?>
					<div class="content_wrap">
						<?php
				}

				// Widgets area above page content
				nazareth_create_widgets_area( 'widgets_above_page' );
				?>

				<div class="content">
					<?php
					// Widgets area inside page content
					nazareth_create_widgets_area( 'widgets_above_content' );
