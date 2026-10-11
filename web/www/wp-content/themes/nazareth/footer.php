<?php
/**
 * The Footer: widgets area, logo, footer menu and socials
 *
 * @package WordPress
 * @subpackage NAZARETH
 * @since NAZARETH 1.0
 */

						// Widgets area inside page content
						nazareth_create_widgets_area( 'widgets_below_content' );
						?>
					</div><!-- </.content> -->

					<?php
					// Show main sidebar
					get_sidebar();

					$nazareth_body_style = nazareth_get_theme_option( 'body_style' );
					if ( 'fullscreen' != $nazareth_body_style ) {
						?>
						</div><!-- </.content_wrap> -->
						<?php
					}

					// Widgets area below page content and related posts below page content
					$nazareth_widgets_name = nazareth_get_theme_option( 'widgets_below_page' );
					$nazareth_show_widgets = ! nazareth_is_off( $nazareth_widgets_name ) && is_active_sidebar( $nazareth_widgets_name );
					$nazareth_show_related = is_single() && nazareth_get_theme_option( 'related_position' ) == 'below_page';
					if ( $nazareth_show_widgets || $nazareth_show_related ) {
						if ( 'fullscreen' != $nazareth_body_style ) {
							?>
							<div class="content_wrap">
							<?php
						}
						// Show related posts before footer
						if ( $nazareth_show_related ) {
							do_action( 'nazareth_action_related_posts' );
						}

						// Widgets area below page content
						if ( $nazareth_show_widgets ) {
							nazareth_create_widgets_area( 'widgets_below_page' );
						}
						if ( 'fullscreen' != $nazareth_body_style ) {
							?>
							</div><!-- </.content_wrap> -->
							<?php
						}
					}
					?>
			</div><!-- </.page_content_wrap> -->

			<?php
			// Single posts banner before footer
			if ( is_singular( 'post' ) ) {
				nazareth_show_post_banner('footer');
			}
			// Footer
			$nazareth_footer_type = nazareth_get_theme_option( 'footer_type' );
			if ( 'custom' == $nazareth_footer_type && ! nazareth_is_layouts_available() ) {
				$nazareth_footer_type = 'default';
			}
			get_template_part( apply_filters( 'nazareth_filter_get_template_part', "templates/footer-{$nazareth_footer_type}" ) );
			?>

		</div><!-- /.page_wrap -->

	</div><!-- /.body_wrap -->

	<?php wp_footer(); ?>

</body>
</html>