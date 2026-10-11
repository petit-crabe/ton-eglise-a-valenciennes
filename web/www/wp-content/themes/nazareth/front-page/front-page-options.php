<?php
/**
 * Setup options for the Front Page
 *
 * @package WordPress
 * @subpackage NAZARETH
 * @since NAZARETH 1.0.31
 */


// Theme init priorities:
// 1 - register filters, that add/remove lists items for the Theme Options
if ( ! function_exists( 'nazareth_front_page_setup1' ) ) {
	add_action( 'after_setup_theme', 'nazareth_front_page_setup1', 1 );
	function nazareth_front_page_setup1() {
		add_filter( 'nazareth_filter_list_sidebars', 'nazareth_front_page_sidebars' );
	}
}


// Theme init priorities:
// 3 - add/remove Theme Options elements
if ( ! function_exists( 'nazareth_front_page_setup3' ) ) {
	add_action( 'after_setup_theme', 'nazareth_front_page_setup3', 3 );
	function nazareth_front_page_setup3() {

		nazareth_storage_set_array_before(
			'options', 'blog', apply_filters(
				'nazareth_filter_front_page_options', array(

					// 'Front Page Sections'
					'front_page'              => array(
						'title'      => esc_html__( 'Front Page Builder', 'nazareth' ),
						'desc'       => wp_kses_data( __( 'More fine tuning component display Front Page (view and menu position, presence and position of the sidebar, header and footer, etc.) you can produce in the section "Page Options" when editing a page, selected as Front Page', 'nazareth' ) ),
						'priority'   => 65,
						'expand_url' => esc_url( home_url( '/' ) ),
						'type'       => 'panel',
					),

					// Front Page Sections - General
					'front_page_general'      => array(
						'title'    => esc_html__( 'General', 'nazareth' ),
						'desc'     => '',
						'priority' => 10,
						'type'     => 'section',
					),
					'front_page_general_info' => array(
						'title' => esc_html__( 'General settings', 'nazareth' ),
						'desc'  => '',
						'type'  => 'info',
					),
					'front_page_enabled'      => array(
						'title' => esc_html__( 'Enable Front Page builder', 'nazareth' ),
						'desc'  => wp_kses_data( __( 'If Front Page Builder is off - native page content will be shown', 'nazareth' ) ),
						'std'   => NAZARETH_THEME_FREE ? 1 : 0,
						'type'  => 'checkbox',
					),
					'body_style_front'        => array(
						'title'   => esc_html__( 'Body style', 'nazareth' ),
						'desc'    => wp_kses_data( __( 'Select width of the body content of the front page', 'nazareth' ) ),
						'refresh' => false,
						'std'     => 'wide',
						'options' => nazareth_get_list_body_styles( true ),
						'type'    => 'select',
					),
					'remove_margins_front'    => array(
						'title'   => esc_html__( 'Remove margins', 'nazareth' ),
						'desc'    => wp_kses_data( __( 'Remove margins above and below the content area on the front page', 'nazareth' ) ),
						'refresh' => false,
						'std'     => 1,
						'type'    => 'checkbox',
					),
					'front_page_sections'     => array(
						'title'      => esc_html__( 'Sections order', 'nazareth' ),
						'desc'       => wp_kses( __( 'Drag and drop sections below to set up their order on the Front Page. You can also enable / disable any section.', 'nazareth' ), 'nazareth_kses_content' ),
						'dependency' => array(
							'front_page_enabled' => array( 1 ),
						),
						'dir'        => 'vertical',
						'sortable'   => true,
						'std'        => '',
						'options'    => array(),
						'type'       => 'checklist',
					),
					'front_page_bg_image'     => array(
						'title'      => esc_html__( 'Background image', 'nazareth' ),
						'desc'       => wp_kses_data( __( 'Select or upload background image for whole Front page', 'nazareth' ) ),
						'refresh'    => false,
						'dependency' => array(
							'front_page_enabled' => array( 1 ),
						),
						'std'        => NAZARETH_THEME_FREE ? nazareth_get_file_url( 'front-page/images/bg.jpg' ) : '',
						'type'       => 'image',
					),
				)
			)
		);

		nazareth_storage_set_array_before(
			'options', 'blog', array(
				'front_page_end' => array(
					'type' => 'panel_end',
				),
			)
		);

	}
}



// Add section 'Title' to the Front Page option
if ( ! function_exists( 'nazareth_front_page_options_title' ) ) {
	add_filter( 'nazareth_filter_front_page_options', 'nazareth_front_page_options_title' );
	function nazareth_front_page_options_title( $options ) {

		$options['front_page_sections']['std']    .= ( ! empty( $options['front_page_sections']['std'] ) ? '|' : '' ) . 'title=1';
		$options['front_page_sections']['options'] = array_merge(
			$options['front_page_sections']['options'],
			array(
				'title' => esc_html__( 'Big title', 'nazareth' ),
			)
		);
		$options                                   = array_merge(
			$options, array(

				// Front Page Sections - Title
				'front_page_title'                 => array(
					'title'    => esc_html__( 'Title', 'nazareth' ),
					'desc'     => '',
					'priority' => 20,
					'type'     => 'section',
				),
				'front_page_title_slider_info'     => array(
					'title' => esc_html__( 'Slider', 'nazareth' ),
					'desc'  => '',
					'type'  => 'info',
				),
				'front_page_title_shortcode'       => array(
					'title'     => esc_html__( 'Slider Shortcode', 'nazareth' ),
					'desc'      => wp_kses_data( __( 'Paste a shortcode generated by any slider plugin. The slider will be used instead of the section title, description and buttons.', 'nazareth' ) ),
					'translate' => true,
					'sanitize'  => 'wp_kses_post',
					'std'       => '',
					'type'      => 'text',
				),
				'front_page_title_layout_info'     => array(
					'title'      => esc_html__( 'Layout', 'nazareth' ),
					'desc'       => '',
					'dependency' => array(
						'front_page_title_shortcode' => array( 'is_empty' ),
					),
					'type'       => 'info',
				),
				'front_page_title_fullheight'      => array(
					'title'      => esc_html__( 'Full height', 'nazareth' ),
					'desc'       => wp_kses_data( __( 'Stretch this section to the window height', 'nazareth' ) ),
					'std'        => 1,
					'refresh'    => false,
					'dependency' => array(
						'front_page_title_shortcode' => array( 'is_empty' ),
					),
					'type'       => 'checkbox',
				),
				'front_page_title_paddings'        => array(
					'title'      => esc_html__( 'Paddings', 'nazareth' ),
					'desc'       => wp_kses_data( __( 'Select paddings inside this section', 'nazareth' ) ),
					'std'        => 'large',
					'options'    => nazareth_get_list_paddings(),
					'refresh'    => false,
					'dependency' => array(
						'front_page_title_shortcode' => array( 'is_empty' ),
					),
					'type'       => 'switch',
				),
				'front_page_title_heading_info'    => array(
					'title'      => esc_html__( 'Title', 'nazareth' ),
					'desc'       => '',
					'dependency' => array(
						'front_page_title_shortcode' => array( 'is_empty' ),
					),
					'type'       => 'info',
				),
				'front_page_title_caption'         => array(
					'title'      => esc_html__( 'Section title', 'nazareth' ),
					'desc'       => '',
					'translate'  => true,
					'refresh'    => false,
					'std'        => wp_kses_data( __( 'Section with Big title', 'nazareth' ) ),
					'sanitize'   => 'wp_kses_post',
					'dependency' => array(
						'front_page_title_shortcode' => array( 'is_empty' ),
					),
					'type'       => 'text',
				),
				'front_page_title_description'     => array(
					'title'      => esc_html__( 'Description', 'nazareth' ),
					'desc'       => wp_kses_data( __( "Short description after the section's title", 'nazareth' ) ),
					'translate'  => true,
					'refresh'    => false,
					'std'        => wp_kses_data( __( 'This text can be changed in the section "Title"', 'nazareth' ) ),
					'sanitize'   => 'wp_kses_post',
					'dependency' => array(
						'front_page_title_shortcode' => array( 'is_empty' ),
					),
					'type'       => 'textarea',
				),
				'front_page_title_buttons_info'    => array(
					'title'      => esc_html__( 'Buttons', 'nazareth' ),
					'desc'       => '',
					'dependency' => array(
						'front_page_title_shortcode' => array( 'is_empty' ),
					),
					'type'       => 'info',
				),
				'front_page_title_button1_link'    => array(
					'title'           => esc_html__( 'Button1 link', 'nazareth' ),
					'desc'            => '',
					'refresh'         => '.front_page_section_title .front_page_section_title_button1',
					'refresh_wrapper' => true,
					'std'             => '#',
					'dependency'      => array(
						'front_page_title_shortcode' => array( 'is_empty' ),
					),
					'type'            => 'text',
				),
				'front_page_title_button1_caption' => array(
					'title'      => esc_html__( 'Button1 caption', 'nazareth' ),
					'desc'       => '',
					'translate'  => true,
					'dependency' => array(
						'front_page_title_button1_link' => array( 'not_empty' ),
						'front_page_title_shortcode'    => array( 'is_empty' ),
					),
					'refresh'    => false,
					'std'        => wp_kses_data( __( 'Customize Button 1', 'nazareth' ) ),
					'type'       => 'text',
				),
				'front_page_title_button2_link'    => array(
					'title'           => esc_html__( 'Button2 link', 'nazareth' ),
					'desc'            => '',
					'refresh'         => '.front_page_section_title .front_page_section_title_button2',
					'refresh_wrapper' => true,
					'std'             => '#',
					'dependency'      => array(
						'front_page_title_shortcode' => array( 'is_empty' ),
					),
					'type'            => 'text',
				),
				'front_page_title_button2_caption' => array(
					'title'      => esc_html__( 'Button2 caption', 'nazareth' ),
					'desc'       => '',
					'translate'  => true,
					'dependency' => array(
						'front_page_title_button2_link' => array( 'not_empty' ),
						'front_page_title_shortcode'    => array( 'is_empty' ),
					),
					'refresh'    => false,
					'std'        => wp_kses_data( __( 'Customize Button 2', 'nazareth' ) ),
					'type'       => 'text',
				),
				'front_page_title_color_info'      => array(
					'title' => esc_html__( 'Colors and images', 'nazareth' ),
					'desc'  => '',
					'type'  => 'info',
				),
				'front_page_title_scheme'          => array(
					'title'   => esc_html__( 'Color scheme', 'nazareth' ),
					'desc'    => wp_kses_data( __( 'Color scheme for this section', 'nazareth' ) ),
					'std'     => NAZARETH_THEME_FREE ? 'dark' : 'inherit',
					'options' => array(),
					'refresh' => false,
					'type'    => 'switch',
				),
				'front_page_title_bg_image'        => array(
					'title'           => esc_html__( 'Background image', 'nazareth' ),
					'desc'            => wp_kses_data( __( 'Select or upload background image for this section', 'nazareth' ) ),
					'refresh'         => '.front_page_section_title',
					'refresh_wrapper' => true,
					'std'             => NAZARETH_THEME_FREE ? nazareth_get_file_url( 'front-page/images/bg-title.jpg' ) : '',
					'type'            => 'image',
				),
				'front_page_title_bg_color_type'   => array(
					'title'   => esc_html__( 'Background color', 'nazareth' ),
					'desc'    => wp_kses_data( __( 'Background color for this section', 'nazareth' ) ),
					'std'     => NAZARETH_THEME_FREE ? 'custom' : 'none',
					'refresh' => false,
					'options' => array(
						'none'            => esc_html__( 'None', 'nazareth' ),
						'scheme_bg_color' => esc_html__( 'Scheme bg color', 'nazareth' ),
						'custom'          => esc_html__( 'Custom', 'nazareth' ),
					),
					'type'    => 'switch',
				),
				'front_page_title_bg_color'        => array(
					'title'      => esc_html__( 'Custom color', 'nazareth' ),
					'desc'       => wp_kses_data( __( 'Custom background color for this section', 'nazareth' ) ),
					'std'        => NAZARETH_THEME_FREE ? '#000' : '',
					'refresh'    => false,
					'dependency' => array(
						'front_page_title_bg_color_type' => array( 'custom' ),
					),
					'type'       => 'color',
				),
				'front_page_title_bg_mask'         => array(
					'title'   => esc_html__( 'Background mask', 'nazareth' ),
					'desc'    => wp_kses_data( __( 'Use Background color as section mask with specified opacity. If 0 - mask is not being used', 'nazareth' ) ),
					'max'     => 1,
					'step'    => 0.1,
					'std'     => NAZARETH_THEME_FREE ? 0.5 : 1,
					'refresh' => false,
					'type'    => 'slider',
				),
				'front_page_title_anchor_info'     => array(
					'title' => esc_html__( 'Anchor', 'nazareth' ),
					'desc'  => wp_kses_data( __( 'You can select icon and/or specify a text to create anchor for this section and show it in the side menu (if selected in the section "Header - Menu").', 'nazareth' ) )
								. '<br>'
								. wp_kses_data( __( 'Attention! Anchors available only if plugin "ThemeREX Addons is installed and activated!', 'nazareth' ) ),
					'type'  => 'info',
				),
				'front_page_title_anchor_icon'     => array(
					'title' => esc_html__( 'Anchor icon', 'nazareth' ),
					'desc'  => '',
					'std'   => '',
					'type'  => 'icon',
				),
				'front_page_title_anchor_text'     => array(
					'title'     => esc_html__( 'Anchor text', 'nazareth' ),
					'desc'      => '',
					'translate' => true,
					'std'       => '',
					'type'      => 'text',
				),
			)
		);
		return $options;
	}
}



// Add section 'Features' to the Front Page option
if ( ! function_exists( 'nazareth_front_page_options_features' ) ) {
	add_filter( 'nazareth_filter_front_page_options', 'nazareth_front_page_options_features' );
	function nazareth_front_page_options_features( $options ) {
		$options['front_page_sections']['std']    .= ( ! empty( $options['front_page_sections']['std'] ) ? '|' : '' ) . 'features=1';
		$options['front_page_sections']['options'] = array_merge(
			$options['front_page_sections']['options'],
			array(
				'features' => esc_html__( 'Features', 'nazareth' ),
			)
		);
		$options                                   = array_merge(
			$options, array(

				// Front Page Sections - Features
				'sidebar-widgets-front_page_features_widgets' => array(
					'title'    => esc_html__( 'Features', 'nazareth' ),
					'desc'     => '',
					'priority' => 30,
					'type'     => 'section',
				),
				'front_page_features_layout_info'  => array(
					'title'    => esc_html__( 'Layout', 'nazareth' ),
					'desc'     => '',
					'priority' => -120,
					'type'     => 'info',
				),
				'front_page_features_fullheight'   => array(
					'title'    => esc_html__( 'Full height', 'nazareth' ),
					'desc'     => wp_kses_data( __( 'Stretch this section to the window height', 'nazareth' ) ),
					'std'      => 0,
					'refresh'  => false,
					'priority' => -110,
					'type'     => 'checkbox',
				),
				'front_page_features_paddings'     => array(
					'title'    => esc_html__( 'Paddings', 'nazareth' ),
					'desc'     => wp_kses_data( __( 'Select paddings inside this section', 'nazareth' ) ),
					'std'      => 'medium',
					'options'  => nazareth_get_list_paddings(),
					'refresh'  => false,
					'priority' => -100,
					'type'     => 'switch',
				),
				'front_page_features_heading_info' => array(
					'title'    => esc_html__( 'Title', 'nazareth' ),
					'desc'     => '',
					'priority' => -90,
					'type'     => 'info',
				),
				'front_page_features_caption'      => array(
					'title'     => esc_html__( 'Section title', 'nazareth' ),
					'desc'      => '',
					'translate' => true,
					'refresh'   => false,
					'std'       => wp_kses_data( __( 'Why our service is the best', 'nazareth' ) ),
					'priority'  => -80,
					'type'      => 'text',
				),
				'front_page_features_description'  => array(
					'title'     => esc_html__( 'Description', 'nazareth' ),
					'desc'      => wp_kses_data( __( "Short description after the section's title", 'nazareth' ) ),
					'translate' => true,
					'refresh'   => false,
					'std'       => wp_kses_data( __( 'This text can be changed in the section "Features"', 'nazareth' ) ),
					'priority'  => -70,
					'type'      => 'textarea',
				),
				'front_page_features_widgets_info' => array(
					'title'    => esc_html__( 'Widgets', 'nazareth' ),
					'desc'     => wp_kses_data( __( 'You can setup widgets in this section in the menu "Appearance - Customize" or "Appearance - Widgets"', 'nazareth' ) )
								. '<br>'
								. wp_kses_data( __( 'Select the widget "ThemeREX Addons - Services". You can also select any other widget, changing thus the purpose of this section', 'nazareth' ) ),
					'priority' => -60,
					'type'     => 'info',
				),
				'front_page_features_color_info'   => array(
					'title'    => esc_html__( 'Colors and images', 'nazareth' ),
					'desc'     => '',
					'priority' => 100,
					'type'     => 'info',
				),
				'front_page_features_scheme'       => array(
					'title'   => esc_html__( 'Color scheme', 'nazareth' ),
					'desc'    => wp_kses_data( __( 'Color scheme for this section', 'nazareth' ) ),
					'std'     => 'inherit',
					'options' => array(),
					'refresh' => false,
					'type'    => 'switch',
				),
				'front_page_features_bg_image'     => array(
					'title'           => esc_html__( 'Background image', 'nazareth' ),
					'desc'            => wp_kses_data( __( 'Select or upload background image for this section', 'nazareth' ) ),
					'refresh'         => '.front_page_section_features',
					'refresh_wrapper' => true,
					'std'             => '',
					'type'            => 'image',
				),
				'front_page_features_bg_color_type' => array(
					'title'   => esc_html__( 'Background color', 'nazareth' ),
					'desc'    => wp_kses_data( __( 'Background color for this section', 'nazareth' ) ),
					'std'     => 'scheme_bg_color',
					'refresh' => false,
					'options' => array(
						'none'            => esc_html__( 'None', 'nazareth' ),
						'scheme_bg_color' => esc_html__( 'Scheme bg color', 'nazareth' ),
						'custom'          => esc_html__( 'Custom', 'nazareth' ),
					),
					'type'    => 'switch',
				),
				'front_page_features_bg_color'     => array(
					'title'      => esc_html__( 'Custom color', 'nazareth' ),
					'desc'       => wp_kses_data( __( 'Custom background color for this section', 'nazareth' ) ),
					'std'        => '',
					'refresh'    => false,
					'dependency' => array(
						'front_page_features_bg_color_type' => array( 'custom' ),
					),
					'type'       => 'color',
				),
				'front_page_features_bg_mask'      => array(
					'title'   => esc_html__( 'Background mask', 'nazareth' ),
					'desc'    => wp_kses_data( __( 'Use Background color as section mask with specified opacity. If 0 - mask is not being used', 'nazareth' ) ),
					'max'     => 1,
					'step'    => 0.1,
					'std'     => 1,
					'refresh' => false,
					'type'    => 'slider',
				),
				'front_page_features_anchor_info'  => array(
					'title' => esc_html__( 'Anchor', 'nazareth' ),
					'desc'  => wp_kses_data( __( 'You can select icon and/or specify a text to create anchor for this section and show it in the side menu (if selected in the section "Header - Menu").', 'nazareth' ) )
								. '<br>'
								. wp_kses_data( __( 'Attention! Anchors available only if plugin "ThemeREX Addons is installed and activated!', 'nazareth' ) ),
					'type'  => 'info',
				),
				'front_page_features_anchor_icon'  => array(
					'title' => esc_html__( 'Anchor icon', 'nazareth' ),
					'desc'  => '',
					'std'   => '',
					'type'  => 'icon',
				),
				'front_page_features_anchor_text'  => array(
					'title'     => esc_html__( 'Anchor text', 'nazareth' ),
					'translate' => true,
					'desc'      => '',
					'std'       => '',
					'type'      => 'text',
				),
			)
		);
		return $options;
	}
}



// Add section 'About Us' to the Front Page option
if ( ! function_exists( 'nazareth_front_page_options_about' ) ) {
	add_filter( 'nazareth_filter_front_page_options', 'nazareth_front_page_options_about' );
	function nazareth_front_page_options_about( $options ) {
		$options['front_page_sections']['std']    .= ( ! empty( $options['front_page_sections']['std'] ) ? '|' : '' ) . 'about=1';
		$options['front_page_sections']['options'] = array_merge(
			$options['front_page_sections']['options'],
			array(
				'about' => esc_html__( 'About Us', 'nazareth' ),
			)
		);
		$options                                   = array_merge(
			$options, array(

				// Front Page Sections - About
				'front_page_about'              => array(
					'title'    => esc_html__( 'About Us', 'nazareth' ),
					'desc'     => '',
					'priority' => 40,
					'type'     => 'section',
				),
				'front_page_about_layout_info'  => array(
					'title' => esc_html__( 'Layout', 'nazareth' ),
					'desc'  => '',
					'type'  => 'info',
				),
				'front_page_about_fullheight'   => array(
					'title'   => esc_html__( 'Full height', 'nazareth' ),
					'desc'    => wp_kses_data( __( 'Stretch this section to the window height', 'nazareth' ) ),
					'std'     => 0,
					'refresh' => false,
					'type'    => 'checkbox',
				),
				'front_page_about_paddings'     => array(
					'title'   => esc_html__( 'Paddings', 'nazareth' ),
					'desc'    => wp_kses_data( __( 'Select paddings inside this section', 'nazareth' ) ),
					'std'     => 'medium',
					'options' => nazareth_get_list_paddings(),
					'refresh' => false,
					'type'    => 'switch',
				),
				'front_page_about_heading_info' => array(
					'title' => esc_html__( 'Title', 'nazareth' ),
					'desc'  => '',
					'type'  => 'info',
				),
				'front_page_about_caption'      => array(
					'title'     => esc_html__( 'Section title', 'nazareth' ),
					'desc'      => '',
					'translate' => true,
					'refresh'   => false, 
					'std'       => wp_kses_data( __( 'About Us', 'nazareth' ) ),
					'type'      => 'text',
				),
				'front_page_about_description'  => array(
					'title'     => esc_html__( 'Description', 'nazareth' ),
					'desc'      => wp_kses_data( __( "Short description after the section's title", 'nazareth' ) ),
					'translate' => true,
					'refresh'   => false, 
					'std'       => wp_kses_data( __( 'This text can be changed in the section "About"', 'nazareth' ) ),
					'type'      => 'textarea',
				),
				'front_page_about_content_info' => array(
					'title' => esc_html__( 'Content', 'nazareth' ),
					'desc'  => '',
					'type'  => 'info',
				),
				'front_page_about_content'      => array(
					'title'     => esc_html__( 'Content', 'nazareth' ),
					'desc'      => wp_kses_data( __( 'The arbitrary content of the current section.', 'nazareth' ) )
								. '<br>'
								. wp_kses_data(
									esc_html__( 'Attention! You can use %%CONTENT%% to insert instead the content of the page, selected as the Front Page in the menu "Settings - Reading" or in the "Customize - Static Front Page"', 'nazareth' )
								),
					'translate' => true,
					'refresh'   => false,
					'std'       => '',
					'teeny'     => false,
					'rows'      => 20,
					'type'      => 'text_editor',
				),
				'front_page_about_color_info'   => array(
					'title' => esc_html__( 'Colors and images', 'nazareth' ),
					'desc'  => '',
					'type'  => 'info',
				),
				'front_page_about_scheme'       => array(
					'title'   => esc_html__( 'Color scheme', 'nazareth' ),
					'desc'    => wp_kses_data( __( 'Color scheme for this section', 'nazareth' ) ),
					'std'     => NAZARETH_THEME_FREE ? 'dark' : 'inherit',
					'options' => array(),
					'refresh' => false,
					'type'    => 'switch',
				),
				'front_page_about_bg_image'     => array(
					'title'           => esc_html__( 'Background image', 'nazareth' ),
					'desc'            => wp_kses_data( __( 'Select or upload background image for this section', 'nazareth' ) ),
					'refresh'         => '.front_page_section_about',
					'refresh_wrapper' => true,
					'std'             => '',
					'type'            => 'image',
				),
				'front_page_about_bg_color_type'   => array(
					'title'   => esc_html__( 'Background color', 'nazareth' ),
					'desc'    => wp_kses_data( __( 'Background color for this section', 'nazareth' ) ),
					'std'     => NAZARETH_THEME_FREE ? 'custom' : 'none',
					'refresh' => false,
					'options' => array(
						'none'            => esc_html__( 'None', 'nazareth' ),
						'scheme_bg_color' => esc_html__( 'Scheme bg color', 'nazareth' ),
						'custom'          => esc_html__( 'Custom', 'nazareth' ),
					),
					'type'    => 'switch',
				),
				'front_page_about_bg_color'        => array(
					'title'      => esc_html__( 'Custom color', 'nazareth' ),
					'desc'       => wp_kses_data( __( 'Custom background color for this section', 'nazareth' ) ),
					'std'        => NAZARETH_THEME_FREE ? '#000' : '',
					'refresh'    => false,
					'dependency' => array(
						'front_page_about_bg_color_type' => array( 'custom' ),
					),
					'type'       => 'color',
				),
				'front_page_about_bg_mask'      => array(
					'title'   => esc_html__( 'Background mask', 'nazareth' ),
					'desc'    => wp_kses_data( __( 'Use Background color as section mask with specified opacity. If 0 - mask is not being used', 'nazareth' ) ),
					'max'     => 1,
					'step'    => 0.1,
					'std'     => NAZARETH_THEME_FREE ? 0.5 : 1,
					'refresh' => false,
					'type'    => 'slider',
				),
				'front_page_about_anchor_info'  => array(
					'title' => esc_html__( 'Anchor', 'nazareth' ),
					'desc'  => wp_kses_data( __( 'You can select icon and/or specify a text to create anchor for this section and show it in the side menu (if selected in the section "Header - Menu").', 'nazareth' ) )
								. '<br>'
								. wp_kses_data( __( 'Attention! Anchors available only if plugin "ThemeREX Addons is installed and activated!', 'nazareth' ) ),
					'type'  => 'info',
				),
				'front_page_about_anchor_icon'  => array(
					'title' => esc_html__( 'Anchor icon', 'nazareth' ),
					'desc'  => '',
					'std'   => '',
					'type'  => 'icon',
				),
				'front_page_about_anchor_text'  => array(
					'title'     => esc_html__( 'Anchor text', 'nazareth' ),
					'desc'      => '',
					'translate' => true,
					'std'       => '',
					'type'      => 'text',
				),
			)
		);
		return $options;
	}
}



// Add section 'Team' to the Front Page option
if ( ! function_exists( 'nazareth_front_page_options_team' ) ) {
	add_filter( 'nazareth_filter_front_page_options', 'nazareth_front_page_options_team' );
	function nazareth_front_page_options_team( $options ) {
		$options['front_page_sections']['std']    .= ( ! empty( $options['front_page_sections']['std'] ) ? '|' : '' ) . 'team=1';
		$options['front_page_sections']['options'] = array_merge(
			$options['front_page_sections']['options'],
			array(
				'team' => esc_html__( 'Our Team', 'nazareth' ),
			)
		);
		$options                                   = array_merge(
			$options, array(

				// Front Page Sections - Team
				'sidebar-widgets-front_page_team_widgets' => array(
					'title'    => esc_html__( 'Team members', 'nazareth' ),
					'desc'     => '',
					'priority' => 50,
					'type'     => 'section',
				),
				'front_page_team_layout_info'             => array(
					'title'    => esc_html__( 'Layout', 'nazareth' ),
					'desc'     => '',
					'priority' => -120,
					'type'     => 'info',
				),
				'front_page_team_fullheight'              => array(
					'title'    => esc_html__( 'Full height', 'nazareth' ),
					'desc'     => wp_kses_data( __( 'Stretch this section to the window height', 'nazareth' ) ),
					'std'      => 0,
					'refresh'  => false,
					'priority' => -110,
					'type'     => 'checkbox',
				),
				'front_page_team_paddings'                => array(
					'title'    => esc_html__( 'Paddings', 'nazareth' ),
					'desc'     => wp_kses_data( __( 'Select paddings inside this section', 'nazareth' ) ),
					'std'      => 'medium',
					'options'  => nazareth_get_list_paddings(),
					'refresh'  => false,
					'priority' => -100,
					'type'     => 'switch',
				),
				'front_page_team_heading_info'            => array(
					'title'    => esc_html__( 'Title', 'nazareth' ),
					'desc'     => '',
					'priority' => -90,
					'type'     => 'info',
				),
				'front_page_team_caption'                 => array(
					'title'     => esc_html__( 'Section title', 'nazareth' ),
					'desc'      => '',
					'translate' => true,
					'refresh'   => false,
					'std'       => wp_kses_data( __( 'Meet our team', 'nazareth' ) ),
					'priority'  => -80,
					'type'      => 'text',
				),
				'front_page_team_description'             => array(
					'title'     => esc_html__( 'Description', 'nazareth' ),
					'desc'      => wp_kses_data( __( "Short description after the section's title", 'nazareth' ) ),
					'translate' => true,
					'refresh'   => false,
					'std'       => wp_kses_data( __( 'This text can be changed in the section "Team members"', 'nazareth' ) ),
					'priority'  => -70,
					'type'      => 'textarea',
				),
				'front_page_team_widgets_info'            => array(
					'title'    => esc_html__( 'Widgets', 'nazareth' ),
					'desc'     => wp_kses_data( __( 'You can setup widgets in this section in the menu "Appearance - Customize" or "Appearance - Widgets"', 'nazareth' ) )
								. '<br>'
								. wp_kses_data( __( 'Select the widget "ThemeREX Addons - Team". You can also select any other widget, changing thus the purpose of this section', 'nazareth' ) ),
					'priority' => -60,
					'type'     => 'info',
				),
				'front_page_team_color_info'              => array(
					'title'    => esc_html__( 'Colors and images', 'nazareth' ),
					'desc'     => '',
					'priority' => 100,
					'type'     => 'info',
				),
				'front_page_team_scheme'                  => array(
					'title'   => esc_html__( 'Color scheme', 'nazareth' ),
					'desc'    => wp_kses_data( __( 'Color scheme for this section', 'nazareth' ) ),
					'std'     => NAZARETH_THEME_FREE ? 'dark' : 'inherit',
					'options' => array(),
					'refresh' => false,
					'type'    => 'switch',
				),
				'front_page_team_bg_image'                => array(
					'title'           => esc_html__( 'Background image', 'nazareth' ),
					'desc'            => wp_kses_data( __( 'Select or upload background image for this section', 'nazareth' ) ),
					'refresh'         => '.front_page_section_team',
					'refresh_wrapper' => true,
					'std'             => NAZARETH_THEME_FREE ? nazareth_get_file_url( 'front-page/images/bg-team.jpg' ) : '',
					'type'            => 'image',
				),
				'front_page_team_bg_color_type'           => array(
					'title'   => esc_html__( 'Background color', 'nazareth' ),
					'desc'    => wp_kses_data( __( 'Background color for this section', 'nazareth' ) ),
					'std'     => NAZARETH_THEME_FREE ? 'custom' : 'none',
					'refresh' => false,
					'options' => array(
						'none'            => esc_html__( 'None', 'nazareth' ),
						'scheme_bg_color' => esc_html__( 'Scheme bg color', 'nazareth' ),
						'custom'          => esc_html__( 'Custom', 'nazareth' ),
					),
					'type'    => 'switch',
				),
				'front_page_team_bg_color'                => array(
					'title'      => esc_html__( 'Custom color', 'nazareth' ),
					'desc'       => wp_kses_data( __( 'Custom background color for this section', 'nazareth' ) ),
					'std'        => NAZARETH_THEME_FREE ? '#000' : '',
					'refresh'    => false,
					'dependency' => array(
						'front_page_team_bg_color_type' => array( 'custom' ),
					),
					'type'       => 'color',
				),
				'front_page_team_bg_mask'                 => array(
					'title'   => esc_html__( 'Background mask', 'nazareth' ),
					'desc'    => wp_kses_data( __( 'Use Background color as section mask with specified opacity. If 0 - mask is not being used', 'nazareth' ) ),
					'max'     => 1,
					'step'    => 0.1,
					'std'     => NAZARETH_THEME_FREE ? 0.5 : 1,
					'refresh' => false,
					'type'    => 'slider',
				),
				'front_page_team_anchor_info'             => array(
					'title' => esc_html__( 'Anchor', 'nazareth' ),
					'desc'  => wp_kses_data( __( 'You can select icon and/or specify a text to create anchor for this section and show it in the side menu (if selected in the section "Header - Menu").', 'nazareth' ) )
								. '<br>'
								. wp_kses_data( __( 'Attention! Anchors available only if plugin "ThemeREX Addons is installed and activated!', 'nazareth' ) ),
					'type'  => 'info',
				),
				'front_page_team_anchor_icon'             => array(
					'title' => esc_html__( 'Anchor icon', 'nazareth' ),
					'desc'  => '',
					'std'   => '',
					'type'  => 'icon',
				),
				'front_page_team_anchor_text'             => array(
					'title'     => esc_html__( 'Anchor text', 'nazareth' ),
					'desc'      => '',
					'translate' => true,
					'std'       => '',
					'type'      => 'text',
				),
			)
		);
		return $options;
	}
}



// Add section 'Testimonials' to the Front Page option
if ( ! function_exists( 'nazareth_front_page_options_testimonials' ) ) {
	add_filter( 'nazareth_filter_front_page_options', 'nazareth_front_page_options_testimonials' );
	function nazareth_front_page_options_testimonials( $options ) {
		$options['front_page_sections']['std']    .= ( ! empty( $options['front_page_sections']['std'] ) ? '|' : '' ) . 'testimonials=1';
		$options['front_page_sections']['options'] = array_merge(
			$options['front_page_sections']['options'],
			array(
				'testimonials' => esc_html__( 'Testimonials', 'nazareth' ),
			)
		);
		$options                                   = array_merge(
			$options, array(

				// Front Page Sections - Testimonials
				'sidebar-widgets-front_page_testimonials_widgets' => array(
					'title'    => esc_html__( 'Testimonials', 'nazareth' ),
					'desc'     => '',
					'priority' => 60,
					'type'     => 'section',
				),
				'front_page_testimonials_layout_info'  => array(
					'title'    => esc_html__( 'Layout', 'nazareth' ),
					'desc'     => '',
					'priority' => -120,
					'type'     => 'info',
				),
				'front_page_testimonials_fullheight'   => array(
					'title'    => esc_html__( 'Full height', 'nazareth' ),
					'desc'     => wp_kses_data( __( 'Stretch this section to the window height', 'nazareth' ) ),
					'std'      => 0,
					'refresh'  => false,
					'priority' => -110,
					'type'     => 'checkbox',
				),
				'front_page_testimonials_paddings'     => array(
					'title'    => esc_html__( 'Paddings', 'nazareth' ),
					'desc'     => wp_kses_data( __( 'Select paddings inside this section', 'nazareth' ) ),
					'std'      => 'medium',
					'options'  => nazareth_get_list_paddings(),
					'refresh'  => false,
					'priority' => -100,
					'type'     => 'switch',
				),
				'front_page_testimonials_heading_info' => array(
					'title'    => esc_html__( 'Title', 'nazareth' ),
					'desc'     => '',
					'priority' => -90,
					'type'     => 'info',
				),
				'front_page_testimonials_caption'      => array(
					'title'     => esc_html__( 'Section title', 'nazareth' ),
					'desc'      => '',
					'translate' => true,
					'refresh'   => false,
					'std'       => wp_kses_data( __( 'What our clients say', 'nazareth' ) ),
					'priority'  => -80,
					'type'      => 'text',
				),
				'front_page_testimonials_description'  => array(
					'title'     => esc_html__( 'Description', 'nazareth' ),
					'desc'      => wp_kses_data( __( "Short description after the section's title", 'nazareth' ) ),
					'translate' => true,
					'refresh'   => false,
					'std'       => wp_kses_data( __( 'This text can be changed in the section "Testimonials"', 'nazareth' ) ),
					'priority'  => -70,
					'type'      => 'textarea',
				),
				'front_page_testimonials_widgets_info' => array(
					'title'    => esc_html__( 'Widgets', 'nazareth' ),
					'desc'     => wp_kses_data( __( 'You can setup widgets in this section in the menu "Appearance - Customize" or "Appearance - Widgets"', 'nazareth' ) )
								. '<br>'
								. wp_kses_data( __( 'Select the widget "ThemeREX Addons - Testimonials". You can also select any other widget, changing thus the purpose of this section', 'nazareth' ) ),
					'priority' => -60,
					'type'     => 'info',
				),
				'front_page_testimonials_color_info'   => array(
					'title'    => esc_html__( 'Colors and images', 'nazareth' ),
					'desc'     => '',
					'priority' => 100,
					'type'     => 'info',
				),
				'front_page_testimonials_scheme'       => array(
					'title'   => esc_html__( 'Color scheme', 'nazareth' ),
					'desc'    => wp_kses_data( __( 'Color scheme for this section', 'nazareth' ) ),
					'std'     => 'inherit',
					'options' => array(),
					'refresh' => false,
					'type'    => 'switch',
				),
				'front_page_testimonials_bg_image'     => array(
					'title'           => esc_html__( 'Background image', 'nazareth' ),
					'desc'            => wp_kses_data( __( 'Select or upload background image for this section', 'nazareth' ) ),
					'refresh'         => '.front_page_section_testimonials',
					'refresh_wrapper' => true,
					'std'             => '',
					'type'            => 'image',
				),
				'front_page_testimonials_bg_color_type' => array(
					'title'   => esc_html__( 'Background color', 'nazareth' ),
					'desc'    => wp_kses_data( __( 'Background color for this section', 'nazareth' ) ),
					'std'     => 'scheme_bg_color',
					'refresh' => false,
					'options' => array(
						'none'            => esc_html__( 'None', 'nazareth' ),
						'scheme_bg_color' => esc_html__( 'Scheme bg color', 'nazareth' ),
						'custom'          => esc_html__( 'Custom', 'nazareth' ),
					),
					'type'    => 'switch',
				),
				'front_page_testimonials_bg_color'     => array(
					'title'      => esc_html__( 'Custom color', 'nazareth' ),
					'desc'       => wp_kses_data( __( 'Custom background color for this section', 'nazareth' ) ),
					'std'        => '',
					'refresh'    => false,
					'dependency' => array(
						'front_page_testimonials_bg_color_type' => array( 'custom' ),
					),
					'type'       => 'color',
				),
				'front_page_testimonials_bg_mask'      => array(
					'title'   => esc_html__( 'Background mask', 'nazareth' ),
					'desc'    => wp_kses_data( __( 'Use Background color as section mask with specified opacity. If 0 - mask is not being used', 'nazareth' ) ),
					'max'     => 1,
					'step'    => 0.1,
					'std'     => 1,
					'refresh' => false,
					'type'    => 'slider',
				),
				'front_page_testimonials_anchor_info'  => array(
					'title' => esc_html__( 'Anchor', 'nazareth' ),
					'desc'  => wp_kses_data( __( 'You can select icon and/or specify a text to create anchor for this section and show it in the side menu (if selected in the section "Header - Menu").', 'nazareth' ) )
								. '<br>'
								. wp_kses_data( __( 'Attention! Anchors available only if plugin "ThemeREX Addons is installed and activated!', 'nazareth' ) ),
					'type'  => 'info',
				),
				'front_page_testimonials_anchor_icon'  => array(
					'title' => esc_html__( 'Anchor icon', 'nazareth' ),
					'desc'  => '',
					'std'   => '',
					'type'  => 'icon',
				),
				'front_page_testimonials_anchor_text'  => array(
					'title'     => esc_html__( 'Anchor text', 'nazareth' ),
					'desc'      => '',
					'translate' => true,
					'std'       => '',
					'type'      => 'text',
				),
			)
		);
		return $options;
	}
}



// Add section 'Latest posts' to the Front Page option
if ( ! function_exists( 'nazareth_front_page_options_blog' ) ) {
	add_filter( 'nazareth_filter_front_page_options', 'nazareth_front_page_options_blog' );
	function nazareth_front_page_options_blog( $options ) {
		$options['front_page_sections']['std']    .= ( ! empty( $options['front_page_sections']['std'] ) ? '|' : '' ) . 'blog=1';
		$options['front_page_sections']['options'] = array_merge(
			$options['front_page_sections']['options'],
			array(
				'blog' => esc_html__( 'Latest posts', 'nazareth' ),
			)
		);
		$options                                   = array_merge(
			$options, array(

				// Front Page Sections - Blog (Latest posts)
				'sidebar-widgets-front_page_blog_widgets' => array(
					'title'    => esc_html__( 'Latest posts', 'nazareth' ),
					'desc'     => '',
					'priority' => 70,
					'type'     => 'section',
				),
				'front_page_blog_layout_info'             => array(
					'title'    => esc_html__( 'Layout', 'nazareth' ),
					'desc'     => '',
					'priority' => -120,
					'type'     => 'info',
				),
				'front_page_blog_fullheight'              => array(
					'title'    => esc_html__( 'Full height', 'nazareth' ),
					'desc'     => wp_kses_data( __( 'Stretch this section to the window height', 'nazareth' ) ),
					'std'      => 0,
					'refresh'  => false,
					'priority' => -110,
					'type'     => 'checkbox',
				),
				'front_page_blog_paddings'                => array(
					'title'    => esc_html__( 'Paddings', 'nazareth' ),
					'desc'     => wp_kses_data( __( 'Select paddings inside this section', 'nazareth' ) ),
					'std'      => 'medium',
					'options'  => nazareth_get_list_paddings(),
					'refresh'  => false,
					'priority' => -100,
					'type'     => 'switch',
				),
				'front_page_blog_heading_info'            => array(
					'title'    => esc_html__( 'Title', 'nazareth' ),
					'desc'     => '',
					'priority' => -90,
					'type'     => 'info',
				),
				'front_page_blog_caption'                 => array(
					'title'     => esc_html__( 'Section title', 'nazareth' ),
					'desc'      => '',
					'translate' => true,
					'refresh'   => false,
					'std'       => wp_kses_data( __( 'Latest posts', 'nazareth' ) ),
					'priority'  => -80,
					'type'      => 'text',
				),
				'front_page_blog_description'             => array(
					'title'     => esc_html__( 'Description', 'nazareth' ),
					'desc'      => wp_kses_data( __( "Short description after the section's title", 'nazareth' ) ),
					'translate' => true,
					'refresh'   => false, 
					'std'       => wp_kses_data( __( 'This text can be changed in the section "Latest posts"', 'nazareth' ) ),
					'priority'  => -70,
					'type'      => 'textarea',
				),
				'front_page_blog_widgets_info'            => array(
					'title'    => esc_html__( 'Widgets', 'nazareth' ),
					'desc'     => wp_kses_data( __( 'You can setup widgets in this section in the menu "Appearance - Customize" or "Appearance - Widgets"', 'nazareth' ) )
								. '<br>'
								. wp_kses_data( __( 'Select the widget "ThemeREX Addons - Blogger". You can also select any other widget, changing thus the purpose of this section', 'nazareth' ) ),
					'priority' => -60,
					'type'     => 'info',
				),
				'front_page_blog_color_info'              => array(
					'title'    => esc_html__( 'Colors and images', 'nazareth' ),
					'desc'     => '',
					'priority' => 100,
					'type'     => 'info',
				),
				'front_page_blog_scheme'                  => array(
					'title'   => esc_html__( 'Color scheme', 'nazareth' ),
					'desc'    => wp_kses_data( __( 'Color scheme for this section', 'nazareth' ) ),
					'std'     => NAZARETH_THEME_FREE ? 'dark' : 'inherit',
					'options' => array(),
					'refresh' => false,
					'type'    => 'switch',
				),
				'front_page_blog_bg_image'                => array(
					'title'           => esc_html__( 'Background image', 'nazareth' ),
					'desc'            => wp_kses_data( __( 'Select or upload background image for this section', 'nazareth' ) ),
					'refresh'         => '.front_page_section_blog',
					'refresh_wrapper' => true,
					'std'             => '',
					'type'            => 'image',
				),
				'front_page_blog_bg_color_type'           => array(
					'title'   => esc_html__( 'Background color', 'nazareth' ),
					'desc'    => wp_kses_data( __( 'Background color for this section', 'nazareth' ) ),
					'std'     => NAZARETH_THEME_FREE ? 'custom' : 'none',
					'refresh' => false,
					'options' => array(
						'none'            => esc_html__( 'None', 'nazareth' ),
						'scheme_bg_color' => esc_html__( 'Scheme bg color', 'nazareth' ),
						'custom'          => esc_html__( 'Custom', 'nazareth' ),
					),
					'type'    => 'switch',
				),
				'front_page_blog_bg_color'                => array(
					'title'      => esc_html__( 'Custom color', 'nazareth' ),
					'desc'       => wp_kses_data( __( 'Custom background color for this section', 'nazareth' ) ),
					'std'        => NAZARETH_THEME_FREE ? '#000' : '',
					'refresh'    => false,
					'dependency' => array(
						'front_page_blog_bg_color_type' => array( 'custom' ),
					),
					'type'       => 'color',
				),
				'front_page_blog_bg_mask'                 => array(
					'title'   => esc_html__( 'Background mask', 'nazareth' ),
					'desc'    => wp_kses_data( __( 'Use Background color as section mask with specified opacity. If 0 - mask is not being used', 'nazareth' ) ),
					'max'     => 1,
					'step'    => 0.1,
					'std'     => NAZARETH_THEME_FREE ? 0.5 : 1,
					'refresh' => false,
					'type'    => 'slider',
				),
				'front_page_blog_anchor_info'             => array(
					'title' => esc_html__( 'Anchor', 'nazareth' ),
					'desc'  => wp_kses_data( __( 'You can select icon and/or specify a text to create anchor for this section and show it in the side menu (if selected in the section "Header - Menu").', 'nazareth' ) )
								. '<br>'
								. wp_kses_data( __( 'Attention! Anchors available only if plugin "ThemeREX Addons is installed and activated!', 'nazareth' ) ),
					'type'  => 'info',
				),
				'front_page_blog_anchor_icon'             => array(
					'title' => esc_html__( 'Anchor icon', 'nazareth' ),
					'desc'  => '',
					'std'   => '',
					'type'  => 'icon',
				),
				'front_page_blog_anchor_text'             => array(
					'title'     => esc_html__( 'Anchor text', 'nazareth' ),
					'desc'      => '',
					'translate' => true,
					'std'       => '',
					'type'      => 'text',
				),
			)
		);
		return $options;
	}
}



// Add section 'Subscribe' to the Front Page option
if ( ! function_exists( 'nazareth_front_page_options_subscribe' ) ) {
	add_filter( 'nazareth_filter_front_page_options', 'nazareth_front_page_options_subscribe' );
	function nazareth_front_page_options_subscribe( $options ) {
		$options['front_page_sections']['std']    .= ( ! empty( $options['front_page_sections']['std'] ) ? '|' : '' ) . 'subscribe=1';
		$options['front_page_sections']['options'] = array_merge(
			$options['front_page_sections']['options'],
			array(
				'subscribe' => esc_html__( 'Subscribe', 'nazareth' ),
			)
		);
		$options                                   = array_merge(
			$options, array(

				// Front Page Sections - Subscribe
				'front_page_subscribe'                => array(
					'title'    => esc_html__( 'Subscribe', 'nazareth' ),
					'desc'     => '',
					'priority' => 80,
					'type'     => 'section',
				),
				'front_page_subscribe_layout_info'    => array(
					'title' => esc_html__( 'Layout', 'nazareth' ),
					'desc'  => '',
					'type'  => 'info',
				),
				'front_page_subscribe_fullheight'     => array(
					'title'   => esc_html__( 'Full height', 'nazareth' ),
					'desc'    => wp_kses_data( __( 'Stretch this section to the window height', 'nazareth' ) ),
					'std'     => 0,
					'refresh' => false,
					'type'    => 'checkbox',
				),
				'front_page_subscribe_paddings'       => array(
					'title'   => esc_html__( 'Paddings', 'nazareth' ),
					'desc'    => wp_kses_data( __( 'Select paddings inside this section', 'nazareth' ) ),
					'std'     => 'medium',
					'options' => nazareth_get_list_paddings(),
					'refresh' => false,
					'type'    => 'switch',
				),
				'front_page_subscribe_heading_info'   => array(
					'title' => esc_html__( 'Title', 'nazareth' ),
					'desc'  => '',
					'type'  => 'info',
				),
				'front_page_subscribe_caption'        => array(
					'title'     => esc_html__( 'Section title', 'nazareth' ),
					'desc'      => '',
					'translate' => true,
					'refresh'   => false,
					'std'       => wp_kses_data( __( 'Subscribe to our Newsletter', 'nazareth' ) ),
					'type'      => 'text',
				),
				'front_page_subscribe_description'    => array(
					'title'     => esc_html__( 'Description', 'nazareth' ),
					'desc'      => wp_kses_data( __( "Short description after the section's title", 'nazareth' ) ),
					'translate' => true,
					'refresh'   => false,
					'std'       => wp_kses_data( __( 'This text can be changed in the section "Subscribe"', 'nazareth' ) ),
					'type'      => 'textarea',
				),
				'front_page_subscribe_shortcode_info' => array(
					'title' => esc_html__( 'Shortcode', 'nazareth' ),
					'desc'  => '',
					'type'  => 'info',
				),
				'front_page_subscribe_shortcode'      => array(
					'title'     => esc_html__( 'Shortcode to insert Subscribe form', 'nazareth' ),
					'desc'      => wp_kses_data( __( 'Paste shortcode, generated with any subscribe plugin (for example, MailChimp)', 'nazareth' ) ),
					'translate' => true,
					'refresh'   => '.front_page_section_subscribe .front_page_section_subscribe_output',
					'std'       => '',
					'type'      => 'text',
				),
				'front_page_subscribe_color_info'     => array(
					'title' => esc_html__( 'Colors and images', 'nazareth' ),
					'desc'  => '',
					'type'  => 'info',
				),
				'front_page_subscribe_scheme'         => array(
					'title'   => esc_html__( 'Color scheme', 'nazareth' ),
					'desc'    => wp_kses_data( __( 'Color scheme for this section', 'nazareth' ) ),
					'std'     => NAZARETH_THEME_FREE ? 'dark' : 'inherit',
					'options' => array(),
					'refresh' => false,
					'type'    => 'switch',
				),
				'front_page_subscribe_bg_image'       => array(
					'title'           => esc_html__( 'Background image', 'nazareth' ),
					'desc'            => wp_kses_data( __( 'Select or upload background image for this section', 'nazareth' ) ),
					'refresh'         => '.front_page_section_subscribe',
					'refresh_wrapper' => true,
					'std'             => NAZARETH_THEME_FREE ? nazareth_get_file_url( 'front-page/images/bg-subscribe.jpg' ) : '',
					'type'            => 'image',
				),
				'front_page_subscribe_bg_color_type'  => array(
					'title'   => esc_html__( 'Background color', 'nazareth' ),
					'desc'    => wp_kses_data( __( 'Background color for this section', 'nazareth' ) ),
					'std'     => NAZARETH_THEME_FREE ? 'custom' : 'none',
					'refresh' => false,
					'options' => array(
						'none'            => esc_html__( 'None', 'nazareth' ),
						'scheme_bg_color' => esc_html__( 'Scheme bg color', 'nazareth' ),
						'custom'          => esc_html__( 'Custom', 'nazareth' ),
					),
					'type'    => 'switch',
				),
				'front_page_subscribe_bg_color'       => array(
					'title'      => esc_html__( 'Custom color', 'nazareth' ),
					'desc'       => wp_kses_data( __( 'Custom background color for this section', 'nazareth' ) ),
					'std'        => NAZARETH_THEME_FREE ? '#000' : '',
					'refresh'    => false,
					'dependency' => array(
						'front_page_subscribe_bg_color_type' => array( 'custom' ),
					),
					'type'       => 'color',
				),
				'front_page_subscribe_bg_mask'        => array(
					'title'   => esc_html__( 'Background mask', 'nazareth' ),
					'desc'    => wp_kses_data( __( 'Use Background color as section mask with specified opacity. If 0 - mask is not being used', 'nazareth' ) ),
					'max'     => 1,
					'step'    => 0.1,
					'std'     => NAZARETH_THEME_FREE ? 0.5 : 1,
					'refresh' => false,
					'type'    => 'slider',
				),
				'front_page_subscribe_anchor_info'    => array(
					'title' => esc_html__( 'Anchor', 'nazareth' ),
					'desc'  => wp_kses_data( __( 'You can select icon and/or specify a text to create anchor for this section and show it in the side menu (if selected in the section "Header - Menu").', 'nazareth' ) )
								. '<br>'
								. wp_kses_data( __( 'Attention! Anchors available only if plugin "ThemeREX Addons is installed and activated!', 'nazareth' ) ),
					'type'  => 'info',
				),
				'front_page_subscribe_anchor_icon'    => array(
					'title' => esc_html__( 'Anchor icon', 'nazareth' ),
					'desc'  => '',
					'std'   => '',
					'type'  => 'icon',
				),
				'front_page_subscribe_anchor_text'    => array(
					'title'     => esc_html__( 'Anchor text', 'nazareth' ),
					'desc'      => '',
					'translate' => true,
					'std'       => '',
					'type'      => 'text',
				),
			)
		);
		return $options;
	}
}



// Add section 'Google map' to the Front Page option
if ( ! function_exists( 'nazareth_front_page_options_googlemap' ) ) {
	if ( ! NAZARETH_THEME_FREE ) {
		add_filter( 'nazareth_filter_front_page_options', 'nazareth_front_page_options_googlemap' );
	}
	function nazareth_front_page_options_googlemap( $options ) {
		$options['front_page_sections']['std']    .= ( ! empty( $options['front_page_sections']['std'] ) ? '|' : '' ) . 'googlemap=1';
		$options['front_page_sections']['options'] = array_merge(
			$options['front_page_sections']['options'],
			array(
				'googlemap' => esc_html__( 'Google map', 'nazareth' ),
			)
		);
		$options                                   = array_merge(
			$options, array(

				// Front Page Sections - Google map
				'sidebar-widgets-front_page_googlemap_widgets' => array(
					'title'    => esc_html__( 'Google map', 'nazareth' ),
					'desc'     => '',
					'priority' => 90,
					'type'     => 'section',
				),
				'front_page_googlemap_layout_info'  => array(
					'title'    => esc_html__( 'Layout', 'nazareth' ),
					'desc'     => '',
					'priority' => -120,
					'type'     => 'info',
				),
				'front_page_googlemap_fullheight'   => array(
					'title'    => esc_html__( 'Full height', 'nazareth' ),
					'desc'     => wp_kses_data( __( 'Stretch this section to the window height', 'nazareth' ) ),
					'std'      => 0,
					'refresh'  => false,
					'priority' => -110,
					'type'     => 'checkbox',
				),
				'front_page_googlemap_paddings'     => array(
					'title'    => esc_html__( 'Paddings', 'nazareth' ),
					'desc'     => wp_kses_data( __( 'Select paddings inside this section', 'nazareth' ) ),
					'std'      => 'medium',
					'options'  => nazareth_get_list_paddings(),
					'refresh'  => false,
					'priority' => -100,
					'type'     => 'switch',
				),
				'front_page_googlemap_layout'       => array(
					'title'           => esc_html__( 'Layout', 'nazareth' ),
					'desc'            => wp_kses_data( __( 'Select layout of this section', 'nazareth' ) ),
					'std'             => 'fullwidth',
					'options'         => array(
						'fullwidth' => esc_html__( 'Fullwidth', 'nazareth' ),
						'boxed'     => esc_html__( 'Boxed', 'nazareth' ),
						'columns'   => esc_html__( '2 columns', 'nazareth' ),
					),
					'refresh'         => '.front_page_section_googlemap',
					'refresh_wrapper' => true,
					'priority'        => -95,
					'type'            => 'switch',
				),
				'front_page_googlemap_heading_info' => array(
					'title'    => esc_html__( 'Title', 'nazareth' ),
					'desc'     => '',
					'priority' => -90,
					'type'     => 'info',
				),
				'front_page_googlemap_caption'      => array(
					'title'     => esc_html__( 'Section title', 'nazareth' ),
					'desc'      => '',
					'translate' => true,
					'refresh'   => false, 
					'std'       => wp_kses_data( __( 'Google map', 'nazareth' ) ),
					'priority'  => -80,
					'type'      => 'text',
				),
				'front_page_googlemap_description'  => array(
					'title'     => esc_html__( 'Description', 'nazareth' ),
					'desc'      => wp_kses_data( __( "Short description after the section's title", 'nazareth' ) ),
					'translate' => true,
					'refresh'   => false,
					'std'       => wp_kses_data( __( 'This text can be changed in the section "Google map"', 'nazareth' ) ),
					'priority'  => -70,
					'type'      => 'textarea',
				),
				'front_page_googlemap_content'      => array(
					'title'     => esc_html__( 'Content', 'nazareth' ),
					'desc'      => wp_kses_data( __( 'Any text at the left side of the map', 'nazareth' ) ),
					'translate' => true,
					'refresh'   => false,
					'std'       => wp_kses_data( __( 'This text can be changed in the section "Google map"', 'nazareth' ) ),
					'priority'  => -65,
					'type'      => 'text_editor',
				),
				'front_page_googlemap_widgets_info' => array(
					'title'    => esc_html__( 'Widgets', 'nazareth' ),
					'desc'     => wp_kses_data( __( 'You can setup widgets in this section in the menu "Appearance - Customize" or "Appearance - Widgets"', 'nazareth' ) )
								. '<br>'
								. wp_kses_data( __( 'Select the widget "ThemeREX Addons - Google map". You can also select any other widget, changing thus the purpose of this section', 'nazareth' ) ),
					'priority' => -60,
					'type'     => 'info',
				),
				'front_page_googlemap_color_info'   => array(
					'title'    => esc_html__( 'Colors and images', 'nazareth' ),
					'desc'     => '',
					'priority' => 100,
					'type'     => 'info',
				),
				'front_page_googlemap_scheme'       => array(
					'title'   => esc_html__( 'Color scheme', 'nazareth' ),
					'desc'    => wp_kses_data( __( 'Color scheme for this section', 'nazareth' ) ),
					'std'     => NAZARETH_THEME_FREE ? 'dark' : 'inherit',
					'options' => array(),
					'refresh' => false,
					'type'    => 'switch',
				),
				'front_page_googlemap_bg_image'     => array(
					'title'           => esc_html__( 'Background image', 'nazareth' ),
					'desc'            => wp_kses_data( __( 'Select or upload background image for this section', 'nazareth' ) ),
					'refresh'         => '.front_page_section_googlemap',
					'refresh_wrapper' => true,
					'std'             => NAZARETH_THEME_FREE ? nazareth_get_file_url( 'front-page/images/bg-googlemap.jpg' ) : '',
					'type'            => 'image',
				),
				'front_page_googlemap_bg_color_type' => array(
					'title'   => esc_html__( 'Background color', 'nazareth' ),
					'desc'    => wp_kses_data( __( 'Background color for this section', 'nazareth' ) ),
					'std'     => NAZARETH_THEME_FREE ? 'custom' : 'none',
					'refresh' => false,
					'options' => array(
						'none'            => esc_html__( 'None', 'nazareth' ),
						'scheme_bg_color' => esc_html__( 'Scheme bg color', 'nazareth' ),
						'custom'          => esc_html__( 'Custom', 'nazareth' ),
					),
					'type'    => 'switch',
				),
				'front_page_googlemap_bg_color'     => array(
					'title'      => esc_html__( 'Custom color', 'nazareth' ),
					'desc'       => wp_kses_data( __( 'Custom background color for this section', 'nazareth' ) ),
					'std'        => NAZARETH_THEME_FREE ? '#000' : '',
					'refresh'    => false,
					'dependency' => array(
						'front_page_googlemap_bg_color_type' => array( 'custom' ),
					),
					'type'       => 'color',
				),
				'front_page_googlemap_bg_mask'      => array(
					'title'   => esc_html__( 'Background mask', 'nazareth' ),
					'desc'    => wp_kses_data( __( 'Use Background color as section mask with specified opacity. If 0 - mask is not being used', 'nazareth' ) ),
					'max'     => 1,
					'step'    => 0.1,
					'std'     => NAZARETH_THEME_FREE ? 0.5 : 1,
					'refresh' => false,
					'type'    => 'slider',
				),
				'front_page_googlemap_anchor_info'  => array(
					'title' => esc_html__( 'Anchor', 'nazareth' ),
					'desc'  => wp_kses_data( __( 'You can select icon and/or specify a text to create anchor for this section and show it in the side menu (if selected in the section "Header - Menu").', 'nazareth' ) )
								. '<br>'
								. wp_kses_data( __( 'Attention! Anchors available only if plugin "ThemeREX Addons is installed and activated!', 'nazareth' ) ),
					'type'  => 'info',
				),
				'front_page_googlemap_anchor_icon'  => array(
					'title' => esc_html__( 'Anchor icon', 'nazareth' ),
					'desc'  => '',
					'std'   => '',
					'type'  => 'icon',
				),
				'front_page_googlemap_anchor_text'  => array(
					'title'     => esc_html__( 'Anchor text', 'nazareth' ),
					'desc'      => '',
					'translate' => true,
					'std'       => '',
					'type'      => 'text',
				),
			)
		);
		return $options;
	}
}



// Add section 'Contact Us' to the Front Page option
if ( ! function_exists( 'nazareth_front_page_options_contacts' ) ) {
	add_filter( 'nazareth_filter_front_page_options', 'nazareth_front_page_options_contacts' );
	function nazareth_front_page_options_contacts( $options ) {
		$options['front_page_sections']['std']    .= ( ! empty( $options['front_page_sections']['std'] ) ? '|' : '' ) . 'contacts=1';
		$options['front_page_sections']['options'] = array_merge(
			$options['front_page_sections']['options'],
			array(
				'contacts' => esc_html__( 'Contact Us', 'nazareth' ),
			)
		);
		$options                                   = array_merge(
			$options, array(

				// Front Page Sections - Contact Us
				'sidebar-widgets-front_page_contacts_widgets' => array(
					'title'    => esc_html__( 'Contact Us', 'nazareth' ),
					'desc'     => '',
					'priority' => 100,
					'type'     => 'section',
				),
				'front_page_contacts_layout_info'    => array(
					'title' => esc_html__( 'Layout', 'nazareth' ),
					'desc'  => '',
					'type'  => 'info',
				),
				'front_page_contacts_fullheight'     => array(
					'title'   => esc_html__( 'Full height', 'nazareth' ),
					'desc'    => wp_kses_data( __( 'Stretch this section to the window height', 'nazareth' ) ),
					'std'     => 0,
					'refresh' => false,
					'type'    => 'checkbox',
				),
				'front_page_contacts_paddings'       => array(
					'title'   => esc_html__( 'Paddings', 'nazareth' ),
					'desc'    => wp_kses_data( __( 'Select paddings inside this section', 'nazareth' ) ),
					'std'     => 'medium',
					'options' => nazareth_get_list_paddings(),
					'refresh' => false,
					'type'    => 'switch',
				),
				'front_page_contacts_layout'         => array(
					'title'           => esc_html__( 'Layout', 'nazareth' ),
					'desc'            => wp_kses_data( __( 'Select layout of this section', 'nazareth' ) ),
					'std'             => 'columns',
					'options'         => array(
						'boxed'   => esc_html__( 'Boxed', 'nazareth' ),
						'columns' => esc_html__( '2 columns', 'nazareth' ),
					),
					'refresh'         => '.front_page_section_contacts',
					'refresh_wrapper' => true,
					'type'            => 'switch',
				),
				'front_page_contacts_heading_info'   => array(
					'title' => esc_html__( 'Title', 'nazareth' ),
					'desc'  => '',
					'type'  => 'info',
				),
				'front_page_contacts_caption'        => array(
					'title'     => esc_html__( 'Section title', 'nazareth' ),
					'desc'      => '',
					'translate' => true,
					'refresh'   => false, 
					'std'       => wp_kses_data( __( 'Contact Us', 'nazareth' ) ),
					'type'      => 'text',
				),
				'front_page_contacts_description'    => array(
					'title'     => esc_html__( 'Description', 'nazareth' ),
					'desc'      => wp_kses_data( __( "Short description after the section's title", 'nazareth' ) ),
					'translate' => true,
					'refresh'   => false,
					'std'       => wp_kses_data( __( 'This text can be changed in the section "Contact Us"', 'nazareth' ) ),
					'type'      => 'textarea',
				),
				'front_page_contacts_content'        => array(
					'title'   => esc_html__( 'Content', 'nazareth' ),
					'desc'    => wp_kses_data( __( 'Any text at the left side of the form', 'nazareth' ) ),
					'refresh' => false, 
					'std'     => wp_kses( __( '<h5><span class="icon-home-2"> </span>Find us at the office:</h5><p>500, Lorem Street,<br />Chicago, IL, 55030<br />Mon - Fri, 09:00 - 18:00</p><h5> <span class="icon-mobile-light"> </span>Give us a call:</h5><p>Michael Jordan<br />+40 (123) 456-78-90<br />Mon - Fri, 08:00 - 22:00</p>', 'nazareth' ), 'nazareth_kses_content' ),
					'type'    => 'text_editor',
				),
				'front_page_contacts_shortcode_info' => array(
					'title' => esc_html__( 'Shortcode', 'nazareth' ),
					'desc'  => '',
					'type'  => 'info',
				),
				'front_page_contacts_shortcode'      => array(
					'title'     => esc_html__( 'Shortcode with contact form', 'nazareth' ),
					'desc'      => wp_kses_data( __( 'Paste shortcode, generated with any form plugin (for example, Contacts Form 7). You can also paste any other shortcodes, changing thus the purpose of this section', 'nazareth' ) ),
					'translate' => true,
					'refresh'   => '.front_page_section_contacts .front_page_section_contacts_output',
					'std'       => '',
					'type'      => 'text',
				),
				'front_page_contacts_color_info'     => array(
					'title'    => esc_html__( 'Colors and images', 'nazareth' ),
					'desc'     => '',
					'priority' => 100,
					'type'     => 'info',
				),
				'front_page_contacts_scheme'         => array(
					'title'   => esc_html__( 'Color scheme', 'nazareth' ),
					'desc'    => wp_kses_data( __( 'Color scheme for this section', 'nazareth' ) ),
					'std'     => NAZARETH_THEME_FREE ? 'dark' : 'inherit',
					'options' => array(),
					'refresh' => false,
					'type'    => 'switch',
				),
				'front_page_contacts_bg_image'       => array(
					'title'           => esc_html__( 'Background image', 'nazareth' ),
					'desc'            => wp_kses_data( __( 'Select or upload background image for this section', 'nazareth' ) ),
					'refresh'         => '.front_page_section_contacts',
					'refresh_wrapper' => true,
					'std'             => '',
					'type'            => 'image',
				),
				'front_page_contacts_bg_color_type'  => array(
					'title'   => esc_html__( 'Background color', 'nazareth' ),
					'desc'    => wp_kses_data( __( 'Background color for this section', 'nazareth' ) ),
					'std'     => NAZARETH_THEME_FREE ? 'custom' : 'none',
					'refresh' => false,
					'options' => array(
						'none'            => esc_html__( 'None', 'nazareth' ),
						'scheme_bg_color' => esc_html__( 'Scheme bg color', 'nazareth' ),
						'custom'          => esc_html__( 'Custom', 'nazareth' ),
					),
					'type'    => 'switch',
				),
				'front_page_contacts_bg_color'       => array(
					'title'      => esc_html__( 'Custom color', 'nazareth' ),
					'desc'       => wp_kses_data( __( 'Custom background color for this section', 'nazareth' ) ),
					'std'        => NAZARETH_THEME_FREE ? '#000' : '',
					'refresh'    => false,
					'dependency' => array(
						'front_page_contacts_bg_color_type' => array( 'custom' ),
					),
					'type'       => 'color',
				),
				'front_page_contacts_bg_mask'        => array(
					'title'   => esc_html__( 'Background mask', 'nazareth' ),
					'desc'    => wp_kses_data( __( 'Use Background color as section mask with specified opacity. If 0 - mask is not being used', 'nazareth' ) ),
					'max'     => 1,
					'step'    => 0.1,
					'std'     => NAZARETH_THEME_FREE ? 0.5 : 1,
					'refresh' => false,
					'type'    => 'slider',
				),
				'front_page_contacts_anchor_info'    => array(
					'title' => esc_html__( 'Anchor', 'nazareth' ),
					'desc'  => wp_kses_data( __( 'You can select icon and/or specify a text to create anchor for this section and show it in the side menu (if selected in the section "Header - Menu").', 'nazareth' ) )
								. '<br>'
								. wp_kses_data( __( 'Attention! Anchors available only if plugin "ThemeREX Addons is installed and activated!', 'nazareth' ) ),
					'type'  => 'info',
				),
				'front_page_contacts_anchor_icon'    => array(
					'title' => esc_html__( 'Anchor icon', 'nazareth' ),
					'desc'  => '',
					'std'   => '',
					'type'  => 'icon',
				),
				'front_page_contacts_anchor_text'    => array(
					'title'     => esc_html__( 'Anchor text', 'nazareth' ),
					'desc'      => '',
					'translate' => true,
					'std'       => '',
					'type'      => 'text',
				),
			)
		);
		return $options;
	}
}

// Add 'active_callback' to all Front Page options
if ( ! function_exists( 'nazareth_front_page_options_add_active_callback' ) ) {
	add_filter( 'nazareth_filter_front_page_options', 'nazareth_front_page_options_add_active_callback', 1000 );
	function nazareth_front_page_options_add_active_callback( $options ) {
		foreach ( $options as $k => $v ) {
			if ( substr( $k, 0, 11 ) == 'front_page_' ) {
				$options[ $k ]['active_callback'] = 'nazareth_front_page_check';
			}
		}
		return $options;
	}
}

// Callback to show/hide Front Page sections in the WP Customizer
if ( ! function_exists( 'nazareth_front_page_check' ) ) {
	function nazareth_front_page_check( $control = null ) {
		return true;   
	}
}

// Add Front Page specific items to the list of sidebars
//------------------------------------------------------------------------
if ( ! function_exists( 'nazareth_front_page_sidebars' ) ) {
	
	function nazareth_front_page_sidebars( $list = array() ) {
		$list['front_page_features_widgets']     = array(
			'name'               => esc_html__( 'Front Page section "Features"', 'nazareth' ),
			'description'        => esc_html__( 'Widgets to be shown only in the section "Features" on the front page', 'nazareth' ),
			'front_page_section' => true,
		);
		$list['front_page_team_widgets']         = array(
			'name'               => esc_html__( 'Front Page section "Team members"', 'nazareth' ),
			'description'        => esc_html__( 'Widgets to be shown only in the section "Team members" on the front page', 'nazareth' ),
			'front_page_section' => true,
		);
		$list['front_page_testimonials_widgets'] = array(
			'name'               => esc_html__( 'Front Page section "Testimonials"', 'nazareth' ),
			'description'        => esc_html__( 'Widgets to be shown only in the section "Testimonials" on the front page', 'nazareth' ),
			'front_page_section' => true,
		);
		$list['front_page_blog_widgets']         = array(
			'name'               => esc_html__( 'Front Page section "Latest Posts"', 'nazareth' ),
			'description'        => esc_html__( 'Widgets to be shown only in the section "Latest Posts" on the front page', 'nazareth' ),
			'front_page_section' => true,
		);
		if ( ! NAZARETH_THEME_FREE ) {
			$list['front_page_googlemap_widgets'] = array(
				'name'               => esc_html__( 'Front Page section "Google map"', 'nazareth' ),
				'description'        => esc_html__( 'Widgets to be shown only in the section "Google map" on the front page', 'nazareth' ),
				'front_page_section' => true,
			);
		}
		return $list;
	}
}




//====================================================================
//== Refresh partials on the Front Page
//====================================================================


// Partial refresh whole section
if ( ! function_exists( 'nazareth_customizer_partial_refresh_section' ) ) {
	function nazareth_customizer_partial_refresh_section( $section ) {
		ob_start();
		get_template_part( apply_filters( 'nazareth_filter_get_template_part', "front-page/section-{$section}" ) );
		$output = ob_get_contents();
		ob_end_clean();
		return nazareth_customizer_partial_refresh_add_init_script( $output, $section );
	}
}


// Add init script to the section's html output
if ( ! function_exists( 'nazareth_customizer_partial_refresh_add_init_script' ) ) {
	function nazareth_customizer_partial_refresh_add_init_script( $output, $section ) {
		return sprintf(
			"%1$s<%2$s>
						setTimeout(function() {
							jQuery(document).trigger('action.init_hidden_elements', [jQuery('.front_page_section_{$section}')]);
						}, 500);
					</%2$s>", $output, 'script'
		);
	}
}


// Section 'Front Page - Title'
//--------------------------------------------------------------------

// Button1 link
if ( ! function_exists( 'nazareth_customizer_partial_refresh_front_page_title_button1_link' ) ) {
	function nazareth_customizer_partial_refresh_front_page_title_button1_link() {
		return nazareth_get_theme_option( 'front_page_title_button1_link' ) != ''
				? '<a href="' . esc_url( nazareth_get_theme_option( 'front_page_title_button1_link' ) ) . '" class="theme_button front_page_section_button front_page_section_title_button1">'
					. esc_html( nazareth_get_theme_option( 'front_page_title_button1_caption' ) )
					. '</a>'
				: '';
	}
}

// Button2 link
if ( ! function_exists( 'nazareth_customizer_partial_refresh_front_page_title_button2_link' ) ) {
	function nazareth_customizer_partial_refresh_front_page_title_button2_link() {
		return nazareth_get_theme_option( 'front_page_title_button2_link' ) != ''
				? '<a href="' . esc_url( nazareth_get_theme_option( 'front_page_title_button2_link' ) ) . '" class="theme_button color_style_link2 front_page_section_button front_page_section_title_button2">'
					. esc_html( nazareth_get_theme_option( 'front_page_title_button2_caption' ) )
					. '</a>'
				: '';
	}
}

// Background image
if ( ! function_exists( 'nazareth_customizer_partial_refresh_front_page_title_bg_image' ) ) {
	function nazareth_customizer_partial_refresh_front_page_title_bg_image() {
		return nazareth_customizer_partial_refresh_section( 'title' );
	}
}


// Section 'Front Page - About'
//--------------------------------------------------------------------

// Background image
if ( ! function_exists( 'nazareth_customizer_partial_refresh_front_page_about_bg_image' ) ) {
	function nazareth_customizer_partial_refresh_front_page_about_bg_image() {
		return nazareth_customizer_partial_refresh_section( 'about' );
	}
}


// Section 'Front Page - Features'
//--------------------------------------------------------------------

// Background image
if ( ! function_exists( 'nazareth_customizer_partial_refresh_front_page_features_bg_image' ) ) {
	function nazareth_customizer_partial_refresh_front_page_features_bg_image() {
		return nazareth_customizer_partial_refresh_section( 'features' );
	}
}


// Section 'Front Page - Team'
//--------------------------------------------------------------------

// Background image
if ( ! function_exists( 'nazareth_customizer_partial_refresh_front_page_team_bg_image' ) ) {
	function nazareth_customizer_partial_refresh_front_page_team_bg_image() {
		return nazareth_customizer_partial_refresh_section( 'team' );
	}
}


// Section 'Front Page - Testimonials'
//--------------------------------------------------------------------

// Background image
if ( ! function_exists( 'nazareth_customizer_partial_refresh_front_page_testimonials_bg_image' ) ) {
	function nazareth_customizer_partial_refresh_front_page_testimonials_bg_image() {
		return nazareth_customizer_partial_refresh_section( 'testimonials' );
	}
}


// Section 'Front Page - Latest posts'
//--------------------------------------------------------------------

// Background image
if ( ! function_exists( 'nazareth_customizer_partial_refresh_front_page_blog_bg_image' ) ) {
	function nazareth_customizer_partial_refresh_front_page_blog_bg_image() {
		return nazareth_customizer_partial_refresh_section( 'blog' );
	}
}


// Section 'Front Page - Subscribe'
//--------------------------------------------------------------------

// Shortcode changed
if ( ! function_exists( 'nazareth_customizer_partial_refresh_front_page_subscribe_shortcode' ) ) {
	function nazareth_customizer_partial_refresh_front_page_subscribe_shortcode() {
		$nazareth_sc = nazareth_get_theme_option( 'front_page_subscribe_shortcode' );
		return ! empty( $nazareth_sc ) ? do_shortcode( $nazareth_sc ) : '';
	}
}

// Background image
if ( ! function_exists( 'nazareth_customizer_partial_refresh_front_page_subscribe_bg_image' ) ) {
	function nazareth_customizer_partial_refresh_front_page_subscribe_bg_image() {
		return nazareth_customizer_partial_refresh_section( 'subscribe' );
	}
}


// Section 'Front Page - Google map'
//--------------------------------------------------------------------

// Layout
if ( ! function_exists( 'nazareth_customizer_partial_refresh_front_page_googlemap_layout' ) ) {
	function nazareth_customizer_partial_refresh_front_page_googlemap_layout() {
		return nazareth_customizer_partial_refresh_section( 'googlemap' );
	}
}

// Background image
if ( ! function_exists( 'nazareth_customizer_partial_refresh_front_page_googlemap_bg_image' ) ) {
	function nazareth_customizer_partial_refresh_front_page_googlemap_bg_image() {
		return nazareth_customizer_partial_refresh_section( 'googlemap' );
	}
}


// Section 'Front Page - Contact Us'
//--------------------------------------------------------------------

// Layout
if ( ! function_exists( 'nazareth_customizer_partial_refresh_front_page_contacts_layout' ) ) {
	function nazareth_customizer_partial_refresh_front_page_contacts_layout() {
		return nazareth_customizer_partial_refresh_section( 'contacts' );
	}
}

// Shortcode changed
if ( ! function_exists( 'nazareth_customizer_partial_refresh_front_page_contacts_shortcode' ) ) {
	function nazareth_customizer_partial_refresh_front_page_contacts_shortcode() {
		$nazareth_sc = nazareth_get_theme_option( 'front_page_contacts_shortcode' );
		return ! empty( $nazareth_sc ) ? do_shortcode( $nazareth_sc ) : '';
	}
}

// Background image
if ( ! function_exists( 'nazareth_customizer_partial_refresh_front_page_contacts_bg_image' ) ) {
	function nazareth_customizer_partial_refresh_front_page_contacts_bg_image() {
		return nazareth_customizer_partial_refresh_section( 'contacts' );
	}
}


// Front Page styles
//--------------------------------------------------------------------

// Merge styles
if ( ! function_exists( 'nazareth_front_page_merge_styles' ) ) {
	add_filter( 'nazareth_filter_merge_styles', 'nazareth_front_page_merge_styles', 9, 1 );
	function nazareth_front_page_merge_styles( $list ) {
		$list[] = 'front-page/_front-page.scss';
		return $list;
	}
}

// Merge responsive styles
if ( ! function_exists( 'nazareth_front_page_merge_styles_responsive' ) ) {
	add_filter( 'nazareth_filter_merge_styles_responsive', 'nazareth_front_page_merge_styles_responsive', 9, 1 );
	function nazareth_front_page_merge_styles_responsive( $list ) {
		$list[] = 'front-page/_front-page-responsive.scss';
		return $list;
	}
}

