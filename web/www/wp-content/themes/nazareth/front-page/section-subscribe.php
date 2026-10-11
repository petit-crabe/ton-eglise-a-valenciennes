<div class="front_page_section front_page_section_subscribe<?php
	$nazareth_scheme = nazareth_get_theme_option( 'front_page_subscribe_scheme' );
	if ( ! nazareth_is_inherit( $nazareth_scheme ) ) {
		echo ' scheme_' . esc_attr( $nazareth_scheme );
	}
	echo ' front_page_section_paddings_' . esc_attr( nazareth_get_theme_option( 'front_page_subscribe_paddings' ) );
?>"
		<?php
		$nazareth_css      = '';
		$nazareth_bg_image = nazareth_get_theme_option( 'front_page_subscribe_bg_image' );
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
	$nazareth_anchor_icon = nazareth_get_theme_option( 'front_page_subscribe_anchor_icon' );
	$nazareth_anchor_text = nazareth_get_theme_option( 'front_page_subscribe_anchor_text' );
if ( ( ! empty( $nazareth_anchor_icon ) || ! empty( $nazareth_anchor_text ) ) && shortcode_exists( 'trx_sc_anchor' ) ) {
	echo do_shortcode(
		'[trx_sc_anchor id="front_page_section_subscribe"'
									. ( ! empty( $nazareth_anchor_icon ) ? ' icon="' . esc_attr( $nazareth_anchor_icon ) . '"' : '' )
									. ( ! empty( $nazareth_anchor_text ) ? ' title="' . esc_attr( $nazareth_anchor_text ) . '"' : '' )
									. ']'
	);
}
?>
	<div class="front_page_section_inner front_page_section_subscribe_inner
	<?php
	if ( nazareth_get_theme_option( 'front_page_subscribe_fullheight' ) ) {
		echo ' nazareth-full-height sc_layouts_flex sc_layouts_columns_middle';
	}
	?>
			"
			<?php
			$nazareth_css      = '';
			$nazareth_bg_mask  = nazareth_get_theme_option( 'front_page_subscribe_bg_mask' );
			$nazareth_bg_color_type = nazareth_get_theme_option( 'front_page_subscribe_bg_color_type' );
			if ( 'custom' == $nazareth_bg_color_type ) {
				$nazareth_bg_color = nazareth_get_theme_option( 'front_page_subscribe_bg_color' );
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
		<div class="front_page_section_content_wrap front_page_section_subscribe_content_wrap content_wrap">
			<?php
			// Caption
			$nazareth_caption = nazareth_get_theme_option( 'front_page_subscribe_caption' );
			if ( ! empty( $nazareth_caption ) || ( current_user_can( 'edit_theme_options' ) && is_customize_preview() ) ) {
				?>
				<h2 class="front_page_section_caption front_page_section_subscribe_caption front_page_block_<?php echo ! empty( $nazareth_caption ) ? 'filled' : 'empty'; ?>"><?php echo wp_kses( $nazareth_caption, 'nazareth_kses_content' ); ?></h2>
				<?php
			}

			// Description (text)
			$nazareth_description = nazareth_get_theme_option( 'front_page_subscribe_description' );
			if ( ! empty( $nazareth_description ) || ( current_user_can( 'edit_theme_options' ) && is_customize_preview() ) ) {
				?>
				<div class="front_page_section_description front_page_section_subscribe_description front_page_block_<?php echo ! empty( $nazareth_description ) ? 'filled' : 'empty'; ?>"><?php echo wp_kses( wpautop( $nazareth_description ), 'nazareth_kses_content' ); ?></div>
				<?php
			}

			// Content
			$nazareth_sc = nazareth_get_theme_option( 'front_page_subscribe_shortcode' );
			if ( ! empty( $nazareth_sc ) || ( current_user_can( 'edit_theme_options' ) && is_customize_preview() ) ) {
				?>
				<div class="front_page_section_output front_page_section_subscribe_output front_page_block_<?php echo ! empty( $nazareth_sc ) ? 'filled' : 'empty'; ?>">
				<?php
					nazareth_show_layout( do_shortcode( $nazareth_sc ) );
				?>
				</div>
				<?php
			}
			?>
		</div>
	</div>
</div>
