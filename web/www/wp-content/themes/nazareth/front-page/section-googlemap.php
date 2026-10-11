<div class="front_page_section front_page_section_googlemap<?php
	$nazareth_scheme = nazareth_get_theme_option( 'front_page_googlemap_scheme' );
	if ( ! nazareth_is_inherit( $nazareth_scheme ) ) {
		echo ' scheme_' . esc_attr( $nazareth_scheme );
	}
	echo ' front_page_section_paddings_' . esc_attr( nazareth_get_theme_option( 'front_page_googlemap_paddings' ) );
?>"
		<?php
		$nazareth_css      = '';
		$nazareth_bg_image = nazareth_get_theme_option( 'front_page_googlemap_bg_image' );
		if ( ! empty( $nazareth_bg_image ) ) {
			$nazareth_css .= 'background-image: url(' . esc_url( nazareth_get_attachment_url( $nazareth_bg_image ) ) . ');';
		}
		if ( ! empty( $nazareth_css ) ) {
			echo ' style="' . esc_attr( $nazareth_css ) . '"';
		}
		?>
>
<?php
	// Add anchor
	$nazareth_anchor_icon = nazareth_get_theme_option( 'front_page_googlemap_anchor_icon' );
	$nazareth_anchor_text = nazareth_get_theme_option( 'front_page_googlemap_anchor_text' );
if ( ( ! empty( $nazareth_anchor_icon ) || ! empty( $nazareth_anchor_text ) ) && shortcode_exists( 'trx_sc_anchor' ) ) {
	echo do_shortcode(
		'[trx_sc_anchor id="front_page_section_googlemap"'
									. ( ! empty( $nazareth_anchor_icon ) ? ' icon="' . esc_attr( $nazareth_anchor_icon ) . '"' : '' )
									. ( ! empty( $nazareth_anchor_text ) ? ' title="' . esc_attr( $nazareth_anchor_text ) . '"' : '' )
									. ']'
	);
}
?>
	<div class="front_page_section_inner front_page_section_googlemap_inner
	<?php
	if ( nazareth_get_theme_option( 'front_page_googlemap_fullheight' ) ) {
		echo ' nazareth-full-height sc_layouts_flex sc_layouts_columns_middle';
	}
	?>
			"
			<?php
			$nazareth_css      = '';
			$nazareth_bg_mask  = nazareth_get_theme_option( 'front_page_googlemap_bg_mask' );
			$nazareth_bg_color_type = nazareth_get_theme_option( 'front_page_googlemap_bg_color_type' );
			if ( 'custom' == $nazareth_bg_color_type ) {
				$nazareth_bg_color = nazareth_get_theme_option( 'front_page_googlemap_bg_color' );
			} elseif ( 'scheme_bg_color' == $nazareth_bg_color_type ) {
				$nazareth_bg_color = nazareth_get_scheme_color( 'bg_color', $nazareth_scheme );
			} else {
				$nazareth_bg_color = '';
			}
			if ( ! empty( $nazareth_bg_color ) && $nazareth_bg_mask > 0 ) {
				$nazareth_css .= 'background-color: ' . esc_attr(
					1 == $nazareth_bg_mask ? $nazareth_bg_color : nazareth_hex2rgba( $nazareth_bg_color, $nazareth_bg_mask )
				) . ';';
			}
			if ( ! empty( $nazareth_css ) ) {
				echo ' style="' . esc_attr( $nazareth_css ) . '"';
			}
			?>
	>
		<div class="front_page_section_content_wrap front_page_section_googlemap_content_wrap
		<?php
			$nazareth_layout = nazareth_get_theme_option( 'front_page_googlemap_layout' );
		if ( 'fullwidth' != $nazareth_layout ) {
			echo ' content_wrap';
		}
		?>
		">
			<?php
			// Content wrap with title and description
			$nazareth_caption     = nazareth_get_theme_option( 'front_page_googlemap_caption' );
			$nazareth_description = nazareth_get_theme_option( 'front_page_googlemap_description' );
			if ( ! empty( $nazareth_caption ) || ! empty( $nazareth_description ) || ( current_user_can( 'edit_theme_options' ) && is_customize_preview() ) ) {
				if ( 'fullwidth' == $nazareth_layout ) {
					?>
					<div class="content_wrap">
					<?php
				}
					// Caption
				if ( ! empty( $nazareth_caption ) || ( current_user_can( 'edit_theme_options' ) && is_customize_preview() ) ) {
					?>
					<h2 class="front_page_section_caption front_page_section_googlemap_caption front_page_block_<?php echo ! empty( $nazareth_caption ) ? 'filled' : 'empty'; ?>">
					<?php
					echo wp_kses( $nazareth_caption, 'nazareth_kses_content' );
					?>
					</h2>
					<?php
				}

					// Description (text)
				if ( ! empty( $nazareth_description ) || ( current_user_can( 'edit_theme_options' ) && is_customize_preview() ) ) {
					?>
					<div class="front_page_section_description front_page_section_googlemap_description front_page_block_<?php echo ! empty( $nazareth_description ) ? 'filled' : 'empty'; ?>">
					<?php
					echo wp_kses( wpautop( $nazareth_description ), 'nazareth_kses_content' );
					?>
					</div>
					<?php
				}
				if ( 'fullwidth' == $nazareth_layout ) {
					?>
					</div>
					<?php
				}
			}

			// Content (text)
			$nazareth_content = nazareth_get_theme_option( 'front_page_googlemap_content' );
			if ( ! empty( $nazareth_content ) || ( current_user_can( 'edit_theme_options' ) && is_customize_preview() ) ) {
				if ( 'columns' == $nazareth_layout ) {
					?>
					<div class="front_page_section_columns front_page_section_googlemap_columns columns_wrap">
						<div class="column-1_3">
					<?php
				} elseif ( 'fullwidth' == $nazareth_layout ) {
					?>
					<div class="content_wrap">
					<?php
				}

				?>
				<div class="front_page_section_content front_page_section_googlemap_content front_page_block_<?php echo ! empty( $nazareth_content ) ? 'filled' : 'empty'; ?>">
				<?php
					echo wp_kses( $nazareth_content, 'nazareth_kses_content' );
				?>
				</div>
				<?php

				if ( 'columns' == $nazareth_layout ) {
					?>
					</div><div class="column-2_3">
					<?php
				} elseif ( 'fullwidth' == $nazareth_layout ) {
					?>
					</div>
					<?php
				}
			}

			// Widgets output
			?>
			<div class="front_page_section_output front_page_section_googlemap_output">
			<?php
			if ( is_active_sidebar( 'front_page_googlemap_widgets' ) ) {
				dynamic_sidebar( 'front_page_googlemap_widgets' );
			} elseif ( current_user_can( 'edit_theme_options' ) ) {
				if ( ! nazareth_exists_trx_addons() ) {
					nazareth_customizer_need_trx_addons_message();
				} else {
					nazareth_customizer_need_widgets_message( 'front_page_googlemap_caption', 'ThemeREX Addons - Google map' );
				}
			}
			?>
			</div>
			<?php

			if ( 'columns' == $nazareth_layout && ( ! empty( $nazareth_content ) || ( current_user_can( 'edit_theme_options' ) && is_customize_preview() ) ) ) {
				?>
				</div></div>
				<?php
			}
			?>
		</div>
	</div>
</div>
