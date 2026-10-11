<?php
/**
 * Setup theme-specific fonts and colors
 *
 * @package WordPress
 * @subpackage NAZARETH
 * @since NAZARETH 1.0.22
 */

// If this theme is a free version of premium theme
if ( ! defined( 'NAZARETH_THEME_FREE' ) ) {
	define( 'NAZARETH_THEME_FREE', false );
}
if ( ! defined( 'NAZARETH_THEME_FREE_WP' ) ) {
	define( 'NAZARETH_THEME_FREE_WP', false );
}

// If this theme uses multiple skins
if ( ! defined( 'NAZARETH_ALLOW_SKINS' ) ) {
	define( 'NAZARETH_ALLOW_SKINS', false );
}
if ( ! defined( 'NAZARETH_DEFAULT_SKIN' ) ) {
	define( 'NAZARETH_DEFAULT_SKIN', 'default' );
}

// Theme storage
// Attention! Must be in the global namespace to compatibility with WP CLI
$GLOBALS['NAZARETH_STORAGE'] = array(

	// Theme required plugin's slugs
	'required_plugins'   => array_merge(

		// List of plugins for both - FREE and PREMIUM versions
		//-----------------------------------------------------
		array(
			// Required plugins
			// DON'T COMMENT OR REMOVE NEXT LINES!
			'trx_addons'         => esc_html__( 'ThemeREX Addons', 'nazareth' ),
			'trx_updater'             => esc_html__( 'ThemeREX Updater', 'nazareth' ),
			// Recommended (supported) plugins for both (lite and full) versions
			// If plugin not need - comment (or remove) it
			'elementor'          => esc_html__( 'Elementor', 'nazareth' ),
			'contact-form-7'     => esc_html__( 'Contact Form 7', 'nazareth' ),			
			// GDPR Support: uncomment only one of two following plugins
			'wp-gdpr-compliance' => esc_html__( 'WP GDPR Compliance', 'nazareth' ),

		),
		// List of plugins for the FREE version only
		//-----------------------------------------------------
		NAZARETH_THEME_FREE
			? array(
				// Recommended (supported) plugins for the FREE (lite) version
				
			)

		// List of plugins for the PREMIUM version only
		//-----------------------------------------------------
			: array(
				// Recommended (supported) plugins for the PRO (full) version
				// If plugin not need - comment (or remove) it
				'essential-grid'             => esc_html__( 'Essential Grid', 'nazareth' ),
				'give'                       => esc_html__( 'Give', 'nazareth' ),		
				'revslider'                  => esc_html__( 'Revolution Slider', 'nazareth' ),
				'the-events-calendar'        => esc_html__( 'The Events Calendar', 'nazareth' ),
				'mp-timetable'				 => esc_html__( 'MP Time Table', 'nazareth' ),
			)
	),

	// Theme-specific blog layouts
	'blog_styles'        => array_merge(
		// Layouts for both - FREE and PREMIUM versions
		//-----------------------------------------------------
		array(
			'excerpt' => array(
				'title'   => esc_html__( 'Standard', 'nazareth' ),
				'archive' => 'index-excerpt',
				'item'    => 'content-excerpt',
				'styles'  => 'excerpt',
			),
			'classic' => array(
				'title'   => esc_html__( 'Classic', 'nazareth' ),
				'archive' => 'index-classic',
				'item'    => 'content-classic',
				'columns' => array( 2, 3 ),
				'styles'  => 'classic',
			),
		),
		// Layouts for the FREE version only
		//-----------------------------------------------------
		NAZARETH_THEME_FREE
		? array()

		// Layouts for the PREMIUM version only
		//-----------------------------------------------------
		: array(
			'masonry'   => array(
				'title'   => esc_html__( 'Masonry', 'nazareth' ),
				'archive' => 'index-classic',
				'item'    => 'content-classic',
				'columns' => array( 2, 3 ),
				'styles'  => 'masonry',
			),
			'portfolio' => array(
				'title'   => esc_html__( 'Portfolio', 'nazareth' ),
				'archive' => 'index-portfolio',
				'item'    => 'content-portfolio',
				'columns' => array( 2, 3, 4 ),
				'styles'  => 'portfolio',
			),
			'gallery'   => array(
				'title'   => esc_html__( 'Gallery', 'nazareth' ),
				'archive' => 'index-portfolio',
				'item'    => 'content-portfolio-gallery',
				'columns' => array( 2, 3, 4 ),
				'styles'  => array( 'portfolio', 'gallery' ),
			),
			'chess'     => array(
				'title'   => esc_html__( 'Chess', 'nazareth' ),
				'archive' => 'index-chess',
				'item'    => 'content-chess',
				'columns' => array( 1, 2, 3 ),
				'styles'  => 'chess',
			),
		)
	),

	// Key validator: market[env|loc]-vendor[axiom]
	'theme_pro_key'      => 'env-axiom',

	// Generate Personal token from Envato to automatic upgrade theme
	'upgrade_token_url'  => nazareth_get_protocol() . '://build.envato.com/create-token/?default=t&purchase:download=t&purchase:list=t',

	// Theme-specific URLs (will be escaped in place of the output)
	'theme_demo_url'     => nazareth_get_protocol() . '://nazareth.axiomthemes.com',
	'theme_doc_url'      => nazareth_get_protocol() . '://nazareth.axiomthemes.com/doc',
	
	'theme_rate_url'     => nazareth_get_protocol() . '://themeforest.net/download',

	'theme_download_url' => nazareth_get_protocol() . '://themeforest.net/item/nazareth-church-religion-wordpress-theme/23227501',        

	'theme_custom_url' 	 => nazareth_get_protocol() . '://themerex.net/offers/?utm_source=offers&utm_medium=click&utm_campaign=themedash',                   

	'theme_support_url'  => nazareth_get_protocol() . '://themerex.net/support',                    		

	'theme_video_url'    => nazareth_get_protocol() . '://www.youtube.com/channel/UCBjqhuwKj3MfE3B6Hg2oA8Q',  

	'theme_privacy_url'  => nazareth_get_protocol() . '://axiomthemes.com/privacy-policy/',                   

	// Comma separated slugs of theme-specific categories (for get relevant news in the dashboard widget)
	// (i.e. 'children,kindergarten')
	'theme_categories'   => '',

	// Responsive resolutions
	// Parameters to create css media query: min, max
	'responsive'         => array(
		// By device
		'wide'       => array(
			'min' => 2160
		),
		'desktop'    => array(
			'min' => 1680,
			'max' => 2159,
		),
		'notebook'   => array(
			'min' => 1280,
			'max' => 1679,
		),
		'tablet'     => array(
			'min' => 768,
			'max' => 1279,
		),
		'not_mobile' => array( 'min' => 768 ),
		'mobile'     => array( 'max' => 767 ),
		// By size
		'xxl'        => array( 'max' => 1679 ),
		'xl'         => array( 'max' => 1439 ),
		'lg'         => array( 'max' => 1279 ),
		'md_over'    => array( 'min' => 1024 ),
		'md'         => array( 'max' => 1023 ),
		'sm'         => array( 'max' => 767 ),
		'sm_wp'      => array( 'max' => 600 ),
		'xs'         => array( 'max' => 479 ),
	),
);

// Theme init priorities:
// Action 'after_setup_theme'
// 1 - register filters to add/remove lists items in the Theme Options
// 2 - create Theme Options
// 3 - add/remove Theme Options elements
// 5 - load Theme Options. Attention! After this step you can use only basic options (not overriden)
// 9 - register other filters (for installer, etc.)
//10 - standard Theme init procedures (not ordered)
// Action 'wp_loaded'
// 1 - detect override mode. Attention! Only after this step you can use overriden options (separate values for the shop, courses, etc.)

if ( ! function_exists( 'nazareth_customizer_theme_setup1' ) ) {
	add_action( 'after_setup_theme', 'nazareth_customizer_theme_setup1', 1 );
	function nazareth_customizer_theme_setup1() {

		// -----------------------------------------------------------------
		// -- ONLY FOR PROGRAMMERS, NOT FOR CUSTOMER
		// -- Internal theme settings
		// -----------------------------------------------------------------
		nazareth_storage_set(
			'settings', array(

				'duplicate_options'      => 'child',            // none  - use separate options for the main and the child-theme
																// child - duplicate theme options from the main theme to the child-theme only
																// both  - sinchronize changes in the theme options between main and child themes

				'customize_refresh'      => 'auto',             // Refresh method for preview area in the Appearance - Customize:
																// auto - refresh preview area on change each field with Theme Options
																// manual - refresh only obn press button 'Refresh' at the top of Customize frame

				'max_load_fonts'         => 5,                  // Max fonts number to load from Google fonts or from uploaded fonts

				'comment_after_name'     => true,               // Place 'comment' field after the 'name' and 'email'

				'show_author_avatar'     => true,               // Display author's avatar in the post meta

				'icons_selector'         => 'internal',         // Icons selector in the shortcodes:
																
																// internal - internal popup with plugin's or theme's icons list (fast and support images and svg)

				'icons_type'             => 'icons',            // Type of icons (if 'icons_selector' is 'internal'):
																// icons  - use font icons to present icons
																// images - use images from theme's folder trx_addons/css/icons.png
																// svg    - use svg from theme's folder trx_addons/css/icons.svg

				'socials_type'           => 'icons',            // Type of socials icons (if 'icons_selector' is 'internal'):
																// icons  - use font icons to present social networks
																// images - use images from theme's folder trx_addons/css/icons.png
																// svg    - use svg from theme's folder trx_addons/css/icons.svg

				'check_min_version'      => true,               // Check if exists a .min version of .css and .js and return path to it
																// instead the path to the original file
																// (if debug_mode is off and modification time of the original file < time of the .min file)

				'autoselect_menu'        => false,              // Show any menu if no menu selected in the location 'main_menu'
																// (for example, the theme is just activated)

				'disable_jquery_ui'      => false,              // Prevent loading custom jQuery UI libraries in the third-party plugins

				'use_mediaelements'      => true,               // Load script "Media Elements" to play video and audio

				'tgmpa_upload'           => false,              // Allow upload not pre-packaged plugins via TGMPA

				'allow_no_image'         => false,              // Allow use image placeholder if no image present in the blog, related posts, post navigation, etc.

				'separate_schemes'       => true,               // Save color schemes to the separate files __color_xxx.css (true) or append its to the __custom.css (false)

				'allow_fullscreen'       => false,              // Allow cases 'fullscreen' and 'fullwide' for the body style in the Theme Options
																// In the Page Options this styles are present always
																// (can be removed if filter 'nazareth_filter_allow_fullscreen' return false)

				'attachments_navigation' => false,              // Add arrows on the single attachment page to navigate to the prev/next attachment
				
				'gutenberg_safe_mode'    => array(),            // 'vc', 'elementor' - Prevent simultaneous editing of posts for Gutenberg and other PageBuilders (VC, Elementor)

				'allow_gutenberg_blocks' => true,               // Allow our shortcodes and widgets as blocks in the Gutenberg (not ready yet - in the development now)

				'subtitle_above_title'   => true,               // Put subtitle above the title in the shortcodes

				'add_hide_on_xxx'        => 'replace',          // Add our breakpoints to the Responsive section of each element
																// 'add' - add our breakpoints after Elementor's
																// 'replace' - add our breakpoints instead Elementor's
																// 'none' - don't add our breakpoints (using only Elementor's)
			)
		);

		// -----------------------------------------------------------------
		// -- Theme fonts (Google and/or custom fonts)
		// -----------------------------------------------------------------

		// Fonts to load when theme start
		// It can be Google fonts or uploaded fonts, placed in the folder /css/font-face/font-name inside the theme folder
		// Attention! Font's folder must have name equal to the font's name, with spaces replaced on the dash '-'
		
		nazareth_storage_set(
			'load_fonts', array(
				// Google font
				array(
					'name'   => 'Roboto',
					'family' => 'sans-serif',
					'styles' => '300,300italic,400,400italic,700,700italic',     // Parameter 'style' used only for the Google fonts
				),
				// Font-face packed with theme
				array(
					'name'   => 'Yeseva One',
					'family' => 'sans-serif',
					'styles' => '400',
				),
				array(
					'name'   => 'Reenie Beanie',
					'family' => 'sans-serif',
					'styles' => '400',
				),
			)
		);

		// Characters subset for the Google fonts. Available values are: latin,latin-ext,cyrillic,cyrillic-ext,greek,greek-ext,vietnamese
		nazareth_storage_set( 'load_fonts_subset', 'latin,latin-ext' );

		nazareth_storage_set(
			'theme_fonts', array(
				'p'       => array(
					'title'           => esc_html__( 'Main text', 'nazareth' ),
					'description'     => esc_html__( 'Font settings of the main text of the site. Attention! For correct display of the site on mobile devices, use only units "rem", "em" or "ex"', 'nazareth' ),
					'font-family'     => '"Roboto",sans-serif',
					'font-size'       => '1.2143rem',
					'font-weight'     => '300',
					'font-style'      => 'normal',
					'line-height'     => '1.5424em',
					'text-decoration' => 'none',
					'text-transform'  => 'none',
					'letter-spacing'  => '',
					'margin-top'      => '1.45em',
					'margin-bottom'   => '1.6em',
				),
				'h1'      => array(
					'title'           => esc_html__( 'Heading 1', 'nazareth' ),
					'font-family'     => '"Yeseva One",sans-serif',
					'font-size'       => '4.2857rem',
					'font-weight'     => '400',
					'font-style'      => 'normal',
					'line-height'     => '1.05em',
					'text-decoration' => 'none',
					'text-transform'  => 'none',
					'letter-spacing'  => '',
					'margin-top'      => '2.1em',
					'margin-bottom'   => '0.65em',
				),
				'h2'      => array(
					'title'           => esc_html__( 'Heading 2', 'nazareth' ),
					'font-family'     => '"Yeseva One",sans-serif',
					'font-size'       => '3.43rem',
					'font-weight'     => '400',
					'font-style'      => 'normal',
					'line-height'     => '1.271em',
					'text-decoration' => 'none',
					'text-transform'  => 'none',
					'letter-spacing'  => '',
					'margin-top'      => '2.08em',
					'margin-bottom'   => '0.6em',
				),
				'h3'      => array(
					'title'           => esc_html__( 'Heading 3', 'nazareth' ),
					'font-family'     => '"Yeseva One",sans-serif',
					'font-size'       => '2.571rem',
					'font-weight'     => '400',
					'font-style'      => 'normal',
					'line-height'     => '1.28em',
					'text-decoration' => 'none',
					'text-transform'  => 'none',
					'letter-spacing'  => '',
					'margin-top'      => '2.7em',
					'margin-bottom'   => '0.9em',
				),
				'h4'      => array(
					'title'           => esc_html__( 'Heading 4', 'nazareth' ),
					'font-family'     => '"Roboto",sans-serif',
					'font-size'       => '2.143rem',
					'font-weight'     => '700',
					'font-style'      => 'normal',
					'line-height'     => '1.2em',
					'text-decoration' => 'none',
					'text-transform'  => 'none',
					'letter-spacing'  => '',
					'margin-top'      => '3.2em',
					'margin-bottom'   => '0.8em',
				),
				'h5'      => array(
					'title'           => esc_html__( 'Heading 5', 'nazareth' ),
					'font-family'     => '"Roboto",sans-serif',
					'font-size'       => '1.743rem',
					'font-weight'     => '700',
					'font-style'      => 'normal',
					'line-height'     => '1.25em',
					'text-decoration' => 'none',
					'text-transform'  => 'none',
					'letter-spacing'  => '',
					'margin-top'      => '3.75em',
					'margin-bottom'   => '1.25em',
				),
				'h6'      => array(
					'title'           => esc_html__( 'Heading 6', 'nazareth' ),
					'font-family'     => '"Roboto",sans-serif',
					'font-size'       => '1.2857rem',
					'font-weight'     => '700',
					'font-style'      => 'normal',
					'line-height'     => '1.28em',
					'text-decoration' => 'none',
					'text-transform'  => 'none',
					'letter-spacing'  => '',
					'margin-top'      => '4.6em',
					'margin-bottom'   => '1em',
				),
				'logo'    => array(
					'title'           => esc_html__( 'Logo text', 'nazareth' ),
					'description'     => esc_html__( 'Font settings of the text case of the logo', 'nazareth' ),
					'font-family'     => '"Yeseva One",sans-serif',
					'font-size'       => '2.5214rem',
					'font-weight'     => '400',
					'font-style'      => 'normal',
					'line-height'     => '1em',
					'text-decoration' => 'none',
					'text-transform'  => 'uppercase',
					'letter-spacing'  => '',
				),
				'button'  => array(
					'title'           => esc_html__( 'Buttons', 'nazareth' ),
					'font-family'     => '"Roboto",sans-serif',
					'font-size'       => '1.29rem',
					'font-weight'     => '700',
					'font-style'      => 'normal',
					'line-height'     => '1em',
					'text-decoration' => 'none',
					'text-transform'  => 'none',
					'letter-spacing'  => '',
				),
				'input'   => array(
					'title'           => esc_html__( 'Input fields', 'nazareth' ),
					'description'     => esc_html__( 'Font settings of the input fields, dropdowns and textareas', 'nazareth' ),
					'font-family'     => '"Roboto",sans-serif',
					'font-size'       => '1.2143rem',
					'font-weight'     => '300',
					'font-style'      => 'normal',
					'line-height'     => '1.5em', // Attention! Firefox don't allow line-height less then 1.5em in the select
					'text-decoration' => 'none',
					'text-transform'  => 'none',
					'letter-spacing'  => '',
				),
				'info'    => array(
					'title'           => esc_html__( 'Post meta', 'nazareth' ),
					'description'     => esc_html__( 'Font settings of the post meta: date, counters, share, etc.', 'nazareth' ),
					'font-family'     => '"Yeseva One",sans-serif',
					'font-size'       => '2.5714rem',  // Old value '13px' don't allow using 'font zoom' in the custom blog items
					'font-weight'     => '400',
					'font-style'      => 'normal',
					'line-height'     => '1em',
					'text-decoration' => 'none',
					'text-transform'  => 'uppercase',
					'letter-spacing'  => '',
					'margin-top'      => '',
					'margin-bottom'   => '',
				),
				'menu'    => array(
					'title'           => esc_html__( 'Main menu', 'nazareth' ),
					'description'     => esc_html__( 'Font settings of the main menu items', 'nazareth' ),
					'font-family'     => '"Roboto",sans-serif',
					'font-size'       => '1.143rem',
					'font-weight'     => '700',
					'font-style'      => 'normal',
					'line-height'     => '1em',
					'text-decoration' => 'none',
					'text-transform'  => 'none',
					'letter-spacing'  => '',
				),
				'submenu' => array(
					'title'           => esc_html__( 'Dropdown menu', 'nazareth' ),
					'description'     => esc_html__( 'Font settings of the dropdown menu items', 'nazareth' ),
					'font-family'     => '"Roboto",sans-serif',
					'font-size'       => '1.143rem',
					'font-weight'     => '700',
					'font-style'      => 'normal',
					'line-height'     => '1em',
					'text-decoration' => 'none',
					'text-transform'  => 'none',
					'letter-spacing'  => '',
				),
			)
		);

		// -----------------------------------------------------------------
		// -- Theme colors for customizer
		// -- Attention! Inner scheme must be last in the array below
		// -----------------------------------------------------------------
		nazareth_storage_set(
			'scheme_color_groups', array(
				'main'    => array(
					'title'       => esc_html__( 'Main', 'nazareth' ),
					'description' => esc_html__( 'Colors of the main content area', 'nazareth' ),
				),
				'alter'   => array(
					'title'       => esc_html__( 'Alter', 'nazareth' ),
					'description' => esc_html__( 'Colors of the alternative blocks (sidebars, etc.)', 'nazareth' ),
				),
				'extra'   => array(
					'title'       => esc_html__( 'Extra', 'nazareth' ),
					'description' => esc_html__( 'Colors of the extra blocks (dropdowns, price blocks, table headers, etc.)', 'nazareth' ),
				),
				'inverse' => array(
					'title'       => esc_html__( 'Inverse', 'nazareth' ),
					'description' => esc_html__( 'Colors of the inverse blocks - when link color used as background of the block (dropdowns, blockquotes, etc.)', 'nazareth' ),
				),
				'input'   => array(
					'title'       => esc_html__( 'Input', 'nazareth' ),
					'description' => esc_html__( 'Colors of the form fields (text field, textarea, select, etc.)', 'nazareth' ),
				),
			)
		);
		nazareth_storage_set(
			'scheme_color_names', array(
				'bg_color'    => array(
					'title'       => esc_html__( 'Background color', 'nazareth' ),
					'description' => esc_html__( 'Background color of this block in the normal state', 'nazareth' ),
				),
				'bg_hover'    => array(
					'title'       => esc_html__( 'Background hover', 'nazareth' ),
					'description' => esc_html__( 'Background color of this block in the hovered state', 'nazareth' ),
				),
				'bd_color'    => array(
					'title'       => esc_html__( 'Border color', 'nazareth' ),
					'description' => esc_html__( 'Border color of this block in the normal state', 'nazareth' ),
				),
				'bd_hover'    => array(
					'title'       => esc_html__( 'Border hover', 'nazareth' ),
					'description' => esc_html__( 'Border color of this block in the hovered state', 'nazareth' ),
				),
				'text'        => array(
					'title'       => esc_html__( 'Text', 'nazareth' ),
					'description' => esc_html__( 'Color of the plain text inside this block', 'nazareth' ),
				),
				'text_dark'   => array(
					'title'       => esc_html__( 'Text dark', 'nazareth' ),
					'description' => esc_html__( 'Color of the dark text (bold, header, etc.) inside this block', 'nazareth' ),
				),
				'text_light'  => array(
					'title'       => esc_html__( 'Text light', 'nazareth' ),
					'description' => esc_html__( 'Color of the light text (post meta, etc.) inside this block', 'nazareth' ),
				),
				'text_link'   => array(
					'title'       => esc_html__( 'Link', 'nazareth' ),
					'description' => esc_html__( 'Color of the links inside this block', 'nazareth' ),
				),
				'text_hover'  => array(
					'title'       => esc_html__( 'Link hover', 'nazareth' ),
					'description' => esc_html__( 'Color of the hovered state of links inside this block', 'nazareth' ),
				),
				'text_link2'  => array(
					'title'       => esc_html__( 'Link 2', 'nazareth' ),
					'description' => esc_html__( 'Color of the accented texts (areas) inside this block', 'nazareth' ),
				),
				'text_hover2' => array(
					'title'       => esc_html__( 'Link 2 hover', 'nazareth' ),
					'description' => esc_html__( 'Color of the hovered state of accented texts (areas) inside this block', 'nazareth' ),
				),
				'text_link3'  => array(
					'title'       => esc_html__( 'Link 3', 'nazareth' ),
					'description' => esc_html__( 'Color of the other accented texts (buttons) inside this block', 'nazareth' ),
				),
				'text_hover3' => array(
					'title'       => esc_html__( 'Link 3 hover', 'nazareth' ),
					'description' => esc_html__( 'Color of the hovered state of other accented texts (buttons) inside this block', 'nazareth' ),
				),
			)
		);
		nazareth_storage_set(
			'schemes', array(

				// Color scheme: 'default'
				'default' => array(
					'title'    => esc_html__( 'Default', 'nazareth' ),
					'internal' => true,
					'colors'   => array(

						// Whole block border and background
						'bg_color'         => '#ffffff',
						'bd_color'         => '#eee9e4',

						// Text and links colors
						'text'             => '#5b6b6f',
						'text_light'       => '#6e7d81',
						'text_dark'        => '#062e36',
						'text_link'        => '#f26837',
						'text_hover'       => '#ffbd11',
						'text_link2'       => '#2d11ff',
						'text_hover2'      => '#a3a2a2',
						'text_link3'       => '#ff11e6',
						'text_hover3'      => '#ff11e6',

						// Alternative blocks (sidebar, tabs, alternative blocks, etc.)
						'alter_bg_color'   => '#ffffff',
						'alter_bg_hover'   => '#f7f3ee',
						'alter_bd_color'   => '#eae7e4',
						'alter_bd_hover'   => '#f7f3ee',
						'alter_text'       => '#5b6b6f',
						'alter_light'      => '#5b6b6f',
						'alter_dark'       => '#062e36',
						'alter_link'       => '#f26837',
						'alter_hover'      => '#ffbd11',
						'alter_link2'      => '#ff11e6',
						'alter_hover2'     => '#ff11e6',
						'alter_link3'      => '#ff11e6',
						'alter_hover3'     => '#ff11e6',

						// Extra blocks (submenu, tabs, color blocks, etc.)
						'extra_bg_color'   => '#1a1411',
						'extra_bg_hover'   => '#ff11e6',
						'extra_bd_color'   => '#0f3f49',
						'extra_bd_hover'   => '#ff11e6',
						'extra_text'       => '#5b6b6f',
						'extra_light'      => '#5b6b6f',
						'extra_dark'       => '#5b6b6f',
						'extra_link'       => '#ffffff',
						'extra_hover'      => '#062e36',
						'extra_link2'      => '#f7f3ee',
						'extra_hover2'     => '#ff11e6',
						'extra_link3'      => '#ff11e6',
						'extra_hover3'     => '#ff11e6',

						// Input fields (form's fields and textarea)
						'input_bg_color'   => '#f7f3ee',
						'input_bg_hover'   => '#f7f3ee',
						'input_bd_color'   => '#f7f3ee',
						'input_bd_hover'   => '#eee9e4',
						'input_text'       => '#5b6b6f',
						'input_light'      => '#ff11e6',
						'input_dark'       => '#062e36',

						// Inverse blocks (text and links on the 'text_link' background)
						'inverse_bd_color' => '#eee9e4',
						'inverse_bd_hover' => '#ff11e6',
						'inverse_text'     => '#ffffff',
						'inverse_light'    => '#ff11e6',
						'inverse_dark'     => '#062e36',
						'inverse_link'     => '#ffffff',
						'inverse_hover'    => '#ffffff',
					),
				),

				// Color scheme: 'dark'
				'dark'    => array(
					'title'    => esc_html__( 'Dark', 'nazareth' ),
					'internal' => true,
					'colors'   => array(

						// Whole block border and background
						'bg_color'         => '#1a1411',
						'bd_color'         => '#1a1411',

						// Text and links colors
						'text'             => '#a3a2a2',
						'text_light'       => '#a3a2a2',
						'text_dark'        => '#ffffff',
						'text_link'        => '#f26837',
						'text_hover'       => '#ffbd11',
						'text_link2'       => '#2d11ff',
						'text_hover2'      => '#a3a2a2',
						'text_link3'       => '#2d11ff',
						'text_hover3'      => '#2d11ff',

						// Alternative blocks (sidebar, tabs, alternative blocks, etc.)
						'alter_bg_color'   => '#1a1411',
						'alter_bg_hover'   => '#1a1411',
						'alter_bd_color'   => '#1a1411',
						'alter_bd_hover'   => '#ffffff',
						'alter_text'       => '#a3a2a2',
						'alter_light'      => '#a3a2a2',
						'alter_dark'       => '#ffffff',
						'alter_link'       => '#f26837',
						'alter_hover'      => '#ffbd11',
						'alter_link2'      => '#2d11ff',
						'alter_hover2'     => '#2d11ff',
						'alter_link3'      => '#2d11ff',
						'alter_hover3'     => '#2d11ff',

						// Extra blocks (submenu, tabs, color blocks, etc.)
						'extra_bg_color'   => '#ffffff',
						'extra_bg_hover'   => '#f3f5f7',
						'extra_bd_color'   => '#f2f0ee',
						'extra_bd_hover'   => '#2d11ff',
						'extra_text'       => '#1e2f3c',
						'extra_light'      => '#a3a2a2',
						'extra_dark'       => '#a3a2a2',
						'extra_link'       => '#1e2f3c',
						'extra_hover'      => '#a3a2a2',
						'extra_link2'      => '#f7f3ee',
						'extra_hover2'     => '#2d11ff',
						'extra_link3'      => '#2d11ff',
						'extra_hover3'     => '#2d11ff',

						// Input fields (form's fields and textarea)
						'input_bg_color'   => '#292929',
						'input_bg_hover'   => '#292929',
						'input_bd_color'   => '#292929',
						'input_bd_hover'   => '#292929',
						'input_text'       => '#a3a2a2',
						'input_light'      => '#2d11ff',
						'input_dark'       => '#ffffff',

						// Inverse blocks (text and links on the 'text_link' background)
						'inverse_bd_color' => '#eee9e4',
						'inverse_bd_hover' => '#2d11ff',
						'inverse_text'     => '#ffffff',
						'inverse_light'    => '#6f6f6f',
						'inverse_dark'     => '#1e2f3c',
						'inverse_link'     => '#ffffff',
						'inverse_hover'    => '#ffffff',
					),
				),

			)
		);
		
		nazareth_storage_set( 'schemes_original', nazareth_storage_get( 'schemes' ) );

		// Simple scheme editor: lists the colors to edit in the "Simple" mode.
		// For each color you can set the array of 'slave' colors and brightness factors that are used to generate new values,
		// when 'main' color is changed
		// Leave 'slave' arrays empty if your scheme does not have a color dependency
		nazareth_storage_set(
			'schemes_simple', array(
				'text_link'        => array(
					'alter_hover'      => 1,
					'extra_link'       => 1,
					'inverse_bd_color' => 0.85,
					'inverse_bd_hover' => 0.7,
				),
				'text_hover'       => array(
					'alter_link'  => 1,
					'extra_hover' => 1,
				),
				'text_link2'       => array(
					'alter_hover2' => 1,
					'extra_link2'  => 1,
				),
				'text_hover2'      => array(
					'alter_link2'  => 1,
					'extra_hover2' => 1,
				),
				'text_link3'       => array(
					'alter_hover3' => 1,
					'extra_link3'  => 1,
				),
				'text_hover3'      => array(
					'alter_link3'  => 1,
					'extra_hover3' => 1,
				),
				'alter_link'       => array(),
				'alter_hover'      => array(),
				'alter_link2'      => array(),
				'alter_hover2'     => array(),
				'alter_link3'      => array(),
				'alter_hover3'     => array(),
				'extra_link'       => array(),
				'extra_hover'      => array(),
				'extra_link2'      => array(),
				'extra_hover2'     => array(),
				'extra_link3'      => array(),
				'extra_hover3'     => array(),
				'inverse_bd_color' => array(),
				'inverse_bd_hover' => array(),
			)
		);

		// Additional colors for each scheme
		// Parameters:	'color' - name of the color from the scheme that should be used as source for the transformation
		//				'alpha' - to make color transparent (0.0 - 1.0)
		//				'hue', 'saturation', 'brightness' - inc/dec value for each color's component
		nazareth_storage_set(
			'scheme_colors_add', array(
				'bg_color_0'        => array(
					'color' => 'bg_color',
					'alpha' => 0,
				),
				'bg_color_02'       => array(
					'color' => 'bg_color',
					'alpha' => 0.2,
				),
				'bg_color_05'       => array(
					'color' => 'bg_color',
					'alpha' => 0.5,
				),
				'bg_color_07'       => array(
					'color' => 'bg_color',
					'alpha' => 0.7,
				),
				'bg_color_08'       => array(
					'color' => 'bg_color',
					'alpha' => 0.8,
				),
				'bg_color_09'       => array(
					'color' => 'bg_color',
					'alpha' => 0.9,
				),
				'alter_bg_color_07' => array(
					'color' => 'alter_bg_color',
					'alpha' => 0.7,
				),
				'alter_bg_color_04' => array(
					'color' => 'alter_bg_color',
					'alpha' => 0.4,
				),
				'alter_bg_hover_01' => array(
					'color' => 'alter_bg_hover',
					'alpha' => 0.1,
				),
				'alter_bg_color_02' => array(
					'color' => 'alter_bg_color',
					'alpha' => 0.2,
				),
				'alter_bd_color_02' => array(
					'color' => 'alter_bd_color',
					'alpha' => 0.2,
				),
				'alter_link_02'     => array(
					'color' => 'alter_link',
					'alpha' => 0.2,
				),
				'alter_link_07'     => array(
					'color' => 'alter_link',
					'alpha' => 0.7,
				),
				'extra_bg_color_05' => array(
					'color' => 'extra_bg_color',
					'alpha' => 0.5,
				),
				'extra_bg_color_07' => array(
					'color' => 'extra_bg_color',
					'alpha' => 0.7,
				),
				'extra_link_02'     => array(
					'color' => 'extra_link',
					'alpha' => 0.2,
				),
				'extra_link2_015'     => array(
					'color' => 'extra_link',
					'alpha' => 0.15,
				),
				'extra_link_07'     => array(
					'color' => 'extra_link',
					'alpha' => 0.7,
				),
				'text_dark_07'      => array(
					'color' => 'text_dark',
					'alpha' => 0.7,
				),
				'text_link_02'      => array(
					'color' => 'text_link',
					'alpha' => 0.2,
				),
				'text_link_07'      => array(
					'color' => 'text_link',
					'alpha' => 0.7,
				),
				'text_link_blend'   => array(
					'color'      => 'text_link',
					'hue'        => 2,
					'saturation' => -5,
					'brightness' => 5,
				),
				'alter_link_blend'  => array(
					'color'      => 'alter_link',
					'hue'        => 2,
					'saturation' => -5,
					'brightness' => 5,
				),
				'inverse_dark_07' => array(
					'color' => 'inverse_dark',
					'alpha' => 0.7,
				),
				'inverse_link_02' => array(
					'color' => 'inverse_link',
					'alpha' => 0.2,
				),
				'inverse_link_015' => array(
					'color' => 'inverse_link',
					'alpha' => 0.15,
				),
			)
		);

		// Parameters to set order of schemes in the css
		nazareth_storage_set(
			'schemes_sorted', array(
				'color_scheme',
				'header_scheme',
				'sidebar_scheme',
				'footer_scheme',
			)
		);

		// -----------------------------------------------------------------
		// -- Theme specific thumb sizes
		// -----------------------------------------------------------------
		nazareth_storage_set(
			'theme_thumbs', apply_filters(
				'nazareth_filter_add_thumb_sizes', array(
					// Width of the image is equal to the content area width (without sidebar)
					// Height is fixed
					'nazareth-thumb-huge'        => array(
						'size'  => array( 1170, 658, true ),
						'title' => esc_html__( 'Huge image', 'nazareth' ),
						'subst' => 'trx_addons-thumb-huge',
					),
					// Width of the image is equal to the content area width (with sidebar)
					// Height is fixed
					'nazareth-thumb-big'         => array(
						'size'  => array( 840, 428, true ),
						'title' => esc_html__( 'Large image', 'nazareth' ),
						'subst' => 'trx_addons-thumb-big',
					),
					// Size for Give img
					'nazareth-thumb-give'         => array(
						'size'  => array( 638, 467, true ),
						'title' => esc_html__( 'Give image', 'nazareth' ),
						'subst' => 'trx_addons-thumb-give',
					),
					// Width of the image is equal to the 1/3 of the content area width (without sidebar)
					// Height is fixed
					'nazareth-thumb-med'         => array(
						'size'  => array( 370, 208, true ),
						'title' => esc_html__( 'Medium image', 'nazareth' ),
						'subst' => 'trx_addons-thumb-medium',
					),
					'nazareth-thumb-team'         => array(
						'size'  => array( 400, 460, true ),
						'title' => esc_html__( 'Team image', 'nazareth' ),
						'subst' => 'trx_addons-thumb-team',
					),

					// Small square image (for avatars in comments, etc.)
					'nazareth-thumb-tiny'        => array(
						'size'  => array( 70, 70, true ),
						'title' => esc_html__( 'Small square avatar', 'nazareth' ),
						'subst' => 'trx_addons-thumb-tiny',
					),

					// Width of the image is equal to the content area width (with sidebar)
					// Height is proportional (only downscale, not crop)
					'nazareth-thumb-masonry-big' => array(
						'size'  => array( 760, 0, false ),     // Only downscale, not crop
						'title' => esc_html__( 'Masonry Large (scaled)', 'nazareth' ),
						'subst' => 'trx_addons-thumb-masonry-big',
					),

					// Width of the image is equal to the 1/3 of the full content area width (without sidebar)
					// Height is proportional (only downscale, not crop)
					'nazareth-thumb-masonry'     => array(
						'size'  => array( 407, 0, false ),     // Only downscale, not crop
						'title' => esc_html__( 'Masonry (scaled)', 'nazareth' ),
						'subst' => 'trx_addons-thumb-masonry',
					),
				)
			)
		);
	}
}




//------------------------------------------------------------------------
// One-click import support
//------------------------------------------------------------------------

// Set theme specific importer options
if ( ! function_exists( 'nazareth_importer_set_options' ) ) {
	add_filter( 'trx_addons_filter_importer_options', 'nazareth_importer_set_options', 9 );
	function nazareth_importer_set_options( $options = array() ) {
		if ( is_array( $options ) ) {
			// Save or not installer's messages to the log-file
			$options['debug'] = false;
			// Allow import/export functionality
			$options['allow_import'] = true;
			$options['allow_export'] = false;
			// Prepare demo data
			$options['demo_url'] = esc_url( nazareth_get_protocol() . '://demofiles.axiomthemes.com/nazareth/' );
			// Required plugins
			$options['required_plugins'] = array_keys( nazareth_storage_get( 'required_plugins' ) );
			// Set number of thumbnails (usually 3 - 5) to regenerate at once when its imported (if demo data was zipped without cropped images)
			// Set 0 to prevent regenerate thumbnails (if demo data archive is already contain cropped images)
			$options['regenerate_thumbnails'] = 0;
			// Default demo
			$options['files']['default']['title']       = esc_html__( 'Nazareth Demo', 'nazareth' );
			$options['files']['default']['domain_dev']  = esc_url( nazareth_get_protocol() . '://nazareth.axiomthemes.com' );       // Developers domain
			$options['files']['default']['domain_demo'] = esc_url( nazareth_get_protocol() . '://nazareth.axiomthemes.com' );
			// Banners
			$options['banners'] = array(
				array(
					'image'        => nazareth_get_file_url( 'theme-specific/theme-about/images/frontpage.png' ),
					'title'        => esc_html__( 'Front Page Builder', 'nazareth' ),
					'content'      => wp_kses_data( __( "Create your front page right in the WordPress Customizer. There's no need in any page builder. Simply enable/disable sections, fill them out with content, and customize to your liking.", 'nazareth' ) ),
					'link_url'     => esc_url( '//www.youtube.com/watch?v=VT0AUbMl_KA' ),
					'link_caption' => esc_html__( 'Watch Video Introduction', 'nazareth' ),
					'duration'     => 20,
				),
				array(
					'image'        => nazareth_get_file_url( 'theme-specific/theme-about/images/layouts.png' ),
					'title'        => esc_html__( 'Layouts Builder', 'nazareth' ),
					'content'      => wp_kses_data( __( 'Use Layouts Builder to create and customize header and footer styles for your website. With a flexible page builder interface and custom shortcodes, you can create as many header and footer layouts as you want with ease.', 'nazareth' ) ),
					'link_url'     => esc_url( '//www.youtube.com/watch?v=pYhdFVLd7y4' ),
					'link_caption' => esc_html__( 'Learn More', 'nazareth' ),
					'duration'     => 20,
				),
				array(
					'image'        => nazareth_get_file_url( 'theme-specific/theme-about/images/documentation.png' ),
					'title'        => esc_html__( 'Read Full Documentation', 'nazareth' ),
					'content'      => wp_kses_data( __( 'Need more details? Please check our full online documentation for detailed information on how to use Nazareth.', 'nazareth' ) ),
					'link_url'     => esc_url( nazareth_storage_get( 'theme_doc_url' ) ),
					'link_caption' => esc_html__( 'Online Documentation', 'nazareth' ),
					'duration'     => 15,
				),
				array(
					'image'        => nazareth_get_file_url( 'theme-specific/theme-about/images/video-tutorials.png' ),
					'title'        => esc_html__( 'Video Tutorials', 'nazareth' ),
					'content'      => wp_kses_data( __( 'No time for reading documentation? Check out our video tutorials and learn how to customize Nazareth in detail.', 'nazareth' ) ),
					'link_url'     => esc_url( nazareth_storage_get( 'theme_video_url' ) ),
					'link_caption' => esc_html__( 'Video Tutorials', 'nazareth' ),
					'duration'     => 15,
				),
				array(
					'image'        => nazareth_get_file_url( 'theme-specific/theme-about/images/studio.png' ),
					'title'        => esc_html__( 'Website Customization', 'nazareth' ),
					'content'      => wp_kses_data( __( "Need a website fast? Order our custom service, and we'll build a website based on this theme for a very fair price. We can also implement additional functionality such as website translation, setting up WPML, and much more.", 'nazareth' ) ),
					'link_url'     => esc_url( '//themerex.net/offers/?utm_source=offers&utm_medium=click&utm_campaign=themedash' ),
					'link_caption' => esc_html__( 'Contact Us', 'nazareth' ),
					'duration'     => 25,
				),
			);
		}
		return $options;
	}
}


//------------------------------------------------------------------------
// OCDI support
//------------------------------------------------------------------------

// Set theme specific OCDI options
if ( ! function_exists( 'nazareth_ocdi_set_options' ) ) {
	add_filter( 'trx_addons_filter_ocdi_options', 'nazareth_ocdi_set_options', 9 );
	function nazareth_ocdi_set_options( $options = array() ) {
		if ( is_array( $options ) ) {
			// Prepare demo data
			$options['demo_url'] = esc_url( nazareth_get_protocol() . '://demofiles.axiomthemes.com/nazareth/' );
			// Required plugins
			$options['required_plugins'] = array_keys( nazareth_storage_get( 'required_plugins' ) );
			// Demo-site domain
			$options['files']['ocdi']['title']       = esc_html__( 'Nazareth OCDI Demo', 'nazareth' );
			$options['files']['ocdi']['domain_demo'] = esc_url( nazareth_get_protocol() . '://nazareth.axiomthemes.com' );
		}
		return $options;
	}
}


// -----------------------------------------------------------------
// -- Theme options for customizer
// -----------------------------------------------------------------
if ( ! function_exists( 'nazareth_create_theme_options' ) ) {

	function nazareth_create_theme_options() {

		// Message about options override.
		// Attention! Not need esc_html__() here, because this message put in wp_kses_data() below
		$msg_override = esc_html__( 'Attention! Some of these options can be overridden in the following sections (Blog, Plugins settings, etc.) or in the settings of individual pages. If you changed such parameter and nothing happened on the page, this option may be overridden in the corresponding section or in the Page Options of this page. These options are marked with an asterisk (*) in the title.', 'nazareth' );

		// Color schemes number: if < 2 - hide fields with selectors
		$hide_schemes = count( nazareth_storage_get( 'schemes' ) ) < 2;

		nazareth_storage_set(
			'options', array(

				// 'Logo & Site Identity'
				'title_tagline'                 => array(
					'title'    => esc_html__( 'Logo & Site Identity', 'nazareth' ),
					'desc'     => '',
					'priority' => 10,
					'type'     => 'section',
				),
				'logo_info'                     => array(
					'title'    => esc_html__( 'Logo Settings', 'nazareth' ),
					'desc'     => '',
					'priority' => 20,
					'qsetup'   => esc_html__( 'General', 'nazareth' ),
					'type'     => 'info',
				),
				'logo_text'                     => array(
					'title'    => esc_html__( 'Use Site Name as Logo', 'nazareth' ),
					'desc'     => wp_kses_data( __( 'Use the site title and tagline as a text logo if no image is selected', 'nazareth' ) ),
					'class'    => 'nazareth_column-1_2 nazareth_new_row',
					'priority' => 30,
					'std'      => 1,
					'qsetup'   => esc_html__( 'General', 'nazareth' ),
					'type'     => NAZARETH_THEME_FREE ? 'hidden' : 'checkbox',
				),
				'logo_retina_enabled'           => array(
					'title'    => esc_html__( 'Allow retina display logo', 'nazareth' ),
					'desc'     => wp_kses_data( __( 'Show fields to select logo images for Retina display', 'nazareth' ) ),
					'class'    => 'nazareth_column-1_2',
					'priority' => 40,
					'refresh'  => false,
					'std'      => 0,
					'type'     => NAZARETH_THEME_FREE ? 'hidden' : 'checkbox',
				),
				'logo_zoom'                     => array(
					'title'   => esc_html__( 'Logo zoom', 'nazareth' ),
					'desc'    => wp_kses(
									esc_html__( 'Zoom the logo (set 1 to leave original size).', 'nazareth' )
									. ' <br>'
									. esc_html__( 'Attention! For this parameter to affect images, their max-height should be specified in "em" instead of "px" when creating a header.', 'nazareth' )
									. ' <br>'
									. esc_html__( 'In this case maximum size of logo depends on the actual size of the picture.', 'nazareth' ), 
									'nazareth_kses_content'),
					'std'     => 1,
					'min'     => 0.2,
					'max'     => 2,
					'step'    => 0.1,
					'refresh' => false,
					'type'    => NAZARETH_THEME_FREE ? 'hidden' : 'slider',
				),
				// Parameter 'logo' was replaced with standard WordPress 'custom_logo'
				'logo_retina'                   => array(
					'title'      => esc_html__( 'Logo for Retina', 'nazareth' ),
					'desc'       => wp_kses_data( __( 'Select or upload site logo used on Retina displays (if empty - use default logo from the field above)', 'nazareth' ) ),
					'class'      => 'nazareth_column-1_2',
					'priority'   => 70,
					'dependency' => array(
						'logo_retina_enabled' => array( 1 ),
					),
					'std'        => '',
					'type'       => NAZARETH_THEME_FREE ? 'hidden' : 'image',
				),
				'logo_mobile_header'            => array(
					'title' => esc_html__( 'Logo for the mobile header', 'nazareth' ),
					'desc'  => wp_kses_data( __( 'Select or upload site logo to display it in the mobile header (if enabled in the section "Header - Header mobile"', 'nazareth' ) ),
					'class' => 'nazareth_column-1_2 nazareth_new_row',
					'std'   => '',
					'type'  => 'image',
				),
				'logo_mobile_header_retina'     => array(
					'title'      => esc_html__( 'Logo for the mobile header on Retina', 'nazareth' ),
					'desc'       => wp_kses_data( __( 'Select or upload site logo used on Retina displays (if empty - use default logo from the field above)', 'nazareth' ) ),
					'class'      => 'nazareth_column-1_2',
					'dependency' => array(
						'logo_retina_enabled' => array( 1 ),
					),
					'std'        => '',
					'type'       => NAZARETH_THEME_FREE ? 'hidden' : 'image',
				),
				'logo_mobile'                   => array(
					'title' => esc_html__( 'Logo for the mobile menu', 'nazareth' ),
					'desc'  => wp_kses_data( __( 'Select or upload site logo to display it in the mobile menu', 'nazareth' ) ),
					'class' => 'nazareth_column-1_2 nazareth_new_row',
					'std'   => '',
					'type'  => 'image',
				),
				'logo_mobile_retina'            => array(
					'title'      => esc_html__( 'Logo mobile on Retina', 'nazareth' ),
					'desc'       => wp_kses_data( __( 'Select or upload site logo used on Retina displays (if empty - use default logo from the field above)', 'nazareth' ) ),
					'class'      => 'nazareth_column-1_2',
					'dependency' => array(
						'logo_retina_enabled' => array( 1 ),
					),
					'std'        => '',
					'type'       => NAZARETH_THEME_FREE ? 'hidden' : 'image',
				),

				// 'General settings'
				'general'                       => array(
					'title'    => esc_html__( 'General Settings', 'nazareth' ),
					'desc'     => wp_kses_data( $msg_override ),
					'priority' => 20,
					'type'     => 'section',
				),

				'general_layout_info'           => array(
					'title'  => esc_html__( 'Layout', 'nazareth' ),
					'desc'   => '',
					'qsetup' => esc_html__( 'General', 'nazareth' ),
					'type'   => 'info',
				),
				'body_style'                    => array(
					'title'    => esc_html__( 'Body style', 'nazareth' ),
					'desc'     => wp_kses_data( __( 'Select width of the body content', 'nazareth' ) ),
					'override' => array(
						'mode'    => 'page,cpt_team,cpt_services,cpt_dishes,cpt_competitions,cpt_rounds,cpt_matches,cpt_cars,cpt_properties,cpt_courses,cpt_portfolio',
						'section' => esc_html__( 'Content', 'nazareth' ),
					),
					'qsetup'   => esc_html__( 'General', 'nazareth' ),
					'refresh'  => false,
					'std'      => 'wide',
					'options'  => nazareth_get_list_body_styles( false ),
					'type'     => 'select',
				),
				'body_paddings'					=> array(
					'title' => esc_html__( 'Enable body paddings', 'nazareth' ),
					'desc'  => wp_kses_data( __( 'Allow content paddings at the right and left sides', 'nazareth' ) ),
					'override' => array(
						'mode'    => 'page,cpt_team,cpt_services,cpt_dishes,cpt_competitions,cpt_rounds,cpt_matches,cpt_cars,cpt_properties,cpt_courses,cpt_portfolio',
						'section' => esc_html__( 'Content', 'nazareth' ),
					),
					'refresh'  => false,
					'std'   => 0,
					'type'  => 'checkbox',
				),
				'page_width'                    => array(
					'title'      => esc_html__( 'Page width', 'nazareth' ),
					'desc'       => wp_kses_data( __( 'Total width of the site content and sidebar (in pixels). If empty - use default width', 'nazareth' ) ),
					'dependency' => array(
						'body_style' => array( 'boxed', 'wide' ),
					),
					'std'        => 1280,
					'min'        => 1000,
					'max'        => 1620,
					'step'       => 10,
					'refresh'    => false,
					'customizer' => 'page',         // SASS variable's name to preview changes 'on fly'
					'type'       => NAZARETH_THEME_FREE ? 'hidden' : 'slider',
				),
				'boxed_bg_image'                => array(
					'title'      => esc_html__( 'Boxed bg image', 'nazareth' ),
					'desc'       => wp_kses_data( __( 'Select or upload image, used as background in the boxed body', 'nazareth' ) ),
					'dependency' => array(
						'body_style' => array( 'boxed' ),
					),
					'override'   => array(
						'mode'    => 'page,cpt_team,cpt_services,cpt_dishes,cpt_competitions,cpt_rounds,cpt_matches,cpt_cars,cpt_properties,cpt_courses,cpt_portfolio',
						'section' => esc_html__( 'Content', 'nazareth' ),
					),
					'std'        => '',
					'qsetup'     => esc_html__( 'General', 'nazareth' ),
					'type'       => 'image',
				),
				'remove_margins'                => array(
					'title'    => esc_html__( 'Remove margins', 'nazareth' ),
					'desc'     => wp_kses_data( __( 'Remove margins above and below the content area', 'nazareth' ) ),
					'override' => array(
						'mode'    => 'page,cpt_team,cpt_services,cpt_dishes,cpt_competitions,cpt_rounds,cpt_matches,cpt_cars,cpt_properties,cpt_courses,cpt_portfolio',
						'section' => esc_html__( 'Content', 'nazareth' ),
					),
					'refresh'  => false,
					'std'      => 0,
					'type'     => 'checkbox',
				),

				'general_sidebar_info'          => array(
					'title' => esc_html__( 'Sidebar', 'nazareth' ),
					'desc'  => '',
					'type'  => 'info',
				),
				'sidebar_position'              => array(
					'title'    => esc_html__( 'Sidebar position', 'nazareth' ),
					'desc'     => wp_kses_data( __( 'Select position to show sidebar', 'nazareth' ) ),
					'override' => array(
						'mode'    => 'page',		// Override parameters for single posts moved to the 'sidebar_position_single'
						'section' => esc_html__( 'Widgets', 'nazareth' ),
					),
					'std'      => 'right',
					'qsetup'   => esc_html__( 'General', 'nazareth' ),
					'options'  => array(),
					'type'     => 'switch',
				),
				'sidebar_position_mobile'       => array(
					'title'    => esc_html__( 'Sidebar position on mobile', 'nazareth' ),
					'desc'     => wp_kses_data( __( 'Select position to show sidebar on mobile devices - above or below the content', 'nazareth' ) ),
					'override' => array(
						'mode'    => 'page',		// Override parameters for single posts moved to the 'sidebar_position_mobile_single'
						'section' => esc_html__( 'Widgets', 'nazareth' ),
					),
					'dependency' => array(
						'sidebar_position' => array( '^hide' ),
					),
					'std'      => 'below',
					'qsetup'   => esc_html__( 'General', 'nazareth' ),
					'options'  => array(),
					'type'     => 'switch',
				),
				'sidebar_widgets'               => array(
					'title'      => esc_html__( 'Sidebar widgets', 'nazareth' ),
					'desc'       => wp_kses_data( __( 'Select default widgets to show in the sidebar', 'nazareth' ) ),
					'override'   => array(
						'mode'    => 'page',		// Override parameters for single posts moved to the 'sidebar_widgets_single'
						'section' => esc_html__( 'Widgets', 'nazareth' ),
					),
					'dependency' => array(
						'sidebar_position' => array( 'left', 'right' ),
					),
					'std'        => 'sidebar_widgets',
					'options'    => array(),
					'qsetup'     => esc_html__( 'General', 'nazareth' ),
					'type'       => 'select',
				),
				'sidebar_width'                 => array(
					'title'      => esc_html__( 'Sidebar width', 'nazareth' ),
					'desc'       => wp_kses_data( __( 'Width of the sidebar (in pixels). If empty - use default width', 'nazareth' ) ),
					'std'        => 330,
					'min'        => 150,
					'max'        => 500,
					'step'       => 10,
					'refresh'    => false,
					'customizer' => 'sidebar',      // SASS variable's name to preview changes 'on fly'
					'type'       => NAZARETH_THEME_FREE ? 'hidden' : 'slider',
				),
				'sidebar_gap'                   => array(
					'title'      => esc_html__( 'Sidebar gap', 'nazareth' ),
					'desc'       => wp_kses_data( __( 'Gap between content and sidebar (in pixels). If empty - use default gap', 'nazareth' ) ),
					'std'        => 110,
					'min'        => 0,
					'max'        => 100,
					'step'       => 1,
					'refresh'    => false,
					'customizer' => 'gap',          // SASS variable's name to preview changes 'on fly'
					'type'       => NAZARETH_THEME_FREE ? 'hidden' : 'slider',
				),
				'expand_content'                => array(
					'title'   => esc_html__( 'Expand content', 'nazareth' ),
					'desc'    => wp_kses_data( __( 'Expand the content width if the sidebar is hidden', 'nazareth' ) ),
					'refresh' => false,
					'override'   => array(
						'mode'    => 'page,post,product,cpt_team,cpt_services,cpt_dishes,cpt_competitions,cpt_rounds,cpt_matches,cpt_cars,cpt_properties,cpt_courses,cpt_portfolio',
						'section' => esc_html__( 'Widgets', 'nazareth' ),
					),
					'std'     => 1,
					'type'    => 'checkbox',
				),

				'general_effects_info'          => array(
					'title' => esc_html__( 'Design & Effects', 'nazareth' ),
					'desc'  => '',
					'type'  => 'info',
				),
				'border_radius'                 => array(
					'title'      => esc_html__( 'Border radius', 'nazareth' ),
					'desc'       => wp_kses_data( __( 'Specify the border radius of the form fields and buttons in pixels', 'nazareth' ) ),
					'std'        => '31',
					'min'        => 0,
					'max'        => 35,
					'step'       => 1,
					'refresh'    => false,
					'customizer' => 'rad',      // SASS name to preview changes 'on fly'
					'type'       => NAZARETH_THEME_FREE ? 'hidden' : 'slider',
				),

				'general_misc_info'             => array(
					'title' => esc_html__( 'Miscellaneous', 'nazareth' ),
					'desc'  => '',
					'type'  => NAZARETH_THEME_FREE ? 'hidden' : 'info',
				),
				'seo_snippets'                  => array(
					'title' => esc_html__( 'SEO snippets', 'nazareth' ),
					'desc'  => wp_kses_data( __( 'Add structured data markup to the single posts and pages', 'nazareth' ) ),
					'std'   => 0,
					'type'  => NAZARETH_THEME_FREE ? 'hidden' : 'checkbox',
				),
				

				// 'Header'
				'header'                        => array(
					'title'    => esc_html__( 'Header', 'nazareth' ),
					'desc'     => wp_kses_data( $msg_override ),
					'priority' => 30,
					'type'     => 'section',
				),

				'header_style_info'             => array(
					'title' => esc_html__( 'Header style', 'nazareth' ),
					'desc'  => '',
					'type'  => 'info',
				),
				'header_type'                   => array(
					'title'    => esc_html__( 'Header style', 'nazareth' ),
					'desc'     => wp_kses_data( __( 'Choose whether to use the default header or header Layouts (available only if the ThemeREX Addons is activated)', 'nazareth' ) ),
					'override' => array(
						'mode'    => 'page,post,product,cpt_team,cpt_services,cpt_dishes,cpt_competitions,cpt_rounds,cpt_matches,cpt_cars,cpt_properties,cpt_courses,cpt_portfolio',
						'section' => esc_html__( 'Header', 'nazareth' ),
					),
					'std'      => 'default',
					'options'  => nazareth_get_list_header_footer_types(),
					'type'     => NAZARETH_THEME_FREE || ! nazareth_exists_trx_addons() ? 'hidden' : 'switch',
				),
				'header_style'                  => array(
					'title'      => esc_html__( 'Select custom layout', 'nazareth' ),
					'desc'       => wp_kses_data( __( 'Select custom header from Layouts Builder', 'nazareth' ) ),
					'override'   => array(
						'mode'    => 'page,post,product,cpt_team,cpt_services,cpt_dishes,cpt_competitions,cpt_rounds,cpt_matches,cpt_cars,cpt_properties,cpt_courses,cpt_portfolio',
						'section' => esc_html__( 'Header', 'nazareth' ),
					),
					'dependency' => array(
						'header_type' => array( 'custom' ),
					),
					'std'        => NAZARETH_THEME_FREE ? 'header-custom-elementor-header-default' : 'header-custom-header-default',
					'options'    => array(),
					'type'       => 'select',
				),
				'header_position'               => array(
					'title'    => esc_html__( 'Header position', 'nazareth' ),
					'desc'     => wp_kses_data( __( 'Select position to display the site header', 'nazareth' ) ),
					'override' => array(
						'mode'    => 'page,post,product,cpt_team,cpt_services,cpt_dishes,cpt_competitions,cpt_rounds,cpt_matches,cpt_cars,cpt_properties,cpt_courses,cpt_portfolio',
						'section' => esc_html__( 'Header', 'nazareth' ),
					),
					'std'      => 'default',
					'options'  => array(),
					'type'     => NAZARETH_THEME_FREE ? 'hidden' : 'switch',
				),
				'header_fullheight'             => array(
					'title'    => esc_html__( 'Header fullheight', 'nazareth' ),
					'desc'     => wp_kses_data( __( 'Enlarge header area to fill whole screen. Used only if header have a background image', 'nazareth' ) ),
					'override' => array(
						'mode'    => 'page,post,product,cpt_team,cpt_services,cpt_dishes,cpt_competitions,cpt_rounds,cpt_matches,cpt_cars,cpt_properties,cpt_courses,cpt_portfolio',
						'section' => esc_html__( 'Header', 'nazareth' ),
					),
					'std'      => 0,
					'type'     => NAZARETH_THEME_FREE ? 'hidden' : 'checkbox',
				),
				'header_wide'                   => array(
					'title'      => esc_html__( 'Header fullwidth', 'nazareth' ),
					'desc'       => wp_kses_data( __( 'Do you want to stretch the header widgets area to the entire window width?', 'nazareth' ) ),
					'override'   => array(
						'mode'    => 'page,post,product,cpt_team,cpt_services,cpt_dishes,cpt_competitions,cpt_rounds,cpt_matches,cpt_cars,cpt_properties,cpt_courses,cpt_portfolio',
						'section' => esc_html__( 'Header', 'nazareth' ),
					),
					'dependency' => array(
						'header_type' => array( 'default' ),
					),
					'std'        => 1,
					'type'       => NAZARETH_THEME_FREE ? 'hidden' : 'checkbox',
				),
				'header_zoom'                   => array(
					'title'   => esc_html__( 'Header zoom', 'nazareth' ),
					'desc'    => wp_kses_data( __( 'Zoom the header title. 1 - original size', 'nazareth' ) ),
					'std'     => 1,
					'min'     => 0.3,
					'max'     => 2,
					'step'    => 0.1,
					'refresh' => false,
					'type'    => NAZARETH_THEME_FREE ? 'hidden' : 'slider',
				),

				'header_widgets_info'           => array(
					'title' => esc_html__( 'Header widgets', 'nazareth' ),
					'desc'  => wp_kses_data( __( 'Here you can place a widget slider, advertising banners, etc.', 'nazareth' ) ),
					'type'  => 'info',
				),
				'header_widgets'                => array(
					'title'    => esc_html__( 'Header widgets', 'nazareth' ),
					'desc'     => wp_kses_data( __( 'Select set of widgets to show in the header on each page', 'nazareth' ) ),
					'override' => array(
						'mode'    => 'page,cpt_team,cpt_services,cpt_dishes,cpt_competitions,cpt_rounds,cpt_matches,cpt_cars,cpt_properties,cpt_courses,cpt_portfolio',
						'section' => esc_html__( 'Header', 'nazareth' ),
						'desc'    => wp_kses_data( __( 'Select set of widgets to show in the header on this page', 'nazareth' ) ),
					),
					'std'      => 'hide',
					'options'  => array(),
					'type'     => 'select',
				),
				'header_columns'                => array(
					'title'      => esc_html__( 'Header columns', 'nazareth' ),
					'desc'       => wp_kses_data( __( 'Select number columns to show widgets in the Header. If 0 - autodetect by the widgets count', 'nazareth' ) ),
					'override'   => array(
						'mode'    => 'page,cpt_team,cpt_services,cpt_dishes,cpt_competitions,cpt_rounds,cpt_matches,cpt_cars,cpt_properties,cpt_courses,cpt_portfolio',
						'section' => esc_html__( 'Header', 'nazareth' ),
					),
					'dependency' => array(
						'header_type'    => array( 'default' ),
						'header_widgets' => array( '^hide' ),
					),
					'std'        => 0,
					'options'    => nazareth_get_list_range( 0, 6 ),
					'type'       => 'select',
				),

				'menu_info'                     => array(
					'title' => esc_html__( 'Main menu', 'nazareth' ),
					'desc'  => wp_kses_data( __( 'Select main menu style, position and other parameters', 'nazareth' ) ),
					'type'  => NAZARETH_THEME_FREE ? 'hidden' : 'info',
				),
				'menu_style'                    => array(
					'title'    => esc_html__( 'Menu position', 'nazareth' ),
					'desc'     => wp_kses_data( __( 'Select position of the main menu', 'nazareth' ) ),
					'override' => array(
						'mode'    => 'page,cpt_team,cpt_services,cpt_dishes,cpt_competitions,cpt_rounds,cpt_matches,cpt_cars,cpt_properties,cpt_courses,cpt_portfolio',
						'section' => esc_html__( 'Header', 'nazareth' ),
					),
					'std'      => 'top',
					'options'  => array(
						'top'   => esc_html__( 'Top', 'nazareth' ),
					),
					'type'     => NAZARETH_THEME_FREE || ! nazareth_exists_trx_addons() ? 'hidden' : 'switch',
				),
				'menu_side_stretch'             => array(
					'title'      => esc_html__( 'Stretch sidemenu', 'nazareth' ),
					'desc'       => wp_kses_data( __( 'Stretch sidemenu to window height (if menu items number >= 5)', 'nazareth' ) ),
					'override'   => array(
						'mode'    => 'page,cpt_team,cpt_services,cpt_dishes,cpt_competitions,cpt_rounds,cpt_matches,cpt_cars,cpt_properties,cpt_courses,cpt_portfolio',
						'section' => esc_html__( 'Header', 'nazareth' ),
					),
					'dependency' => array(
						'menu_style' => array( 'left', 'right' ),
					),
					'std'        => 0,
					'type'       => NAZARETH_THEME_FREE ? 'hidden' : 'checkbox',
				),
				'menu_side_icons'               => array(
					'title'      => esc_html__( 'Iconed sidemenu', 'nazareth' ),
					'desc'       => wp_kses_data( __( 'Get icons from anchors and display it in the sidemenu or mark sidemenu items with simple dots', 'nazareth' ) ),
					'override'   => array(
						'mode'    => 'page,cpt_team,cpt_services,cpt_dishes,cpt_competitions,cpt_rounds,cpt_matches,cpt_cars,cpt_properties,cpt_courses,cpt_portfolio',
						'section' => esc_html__( 'Header', 'nazareth' ),
					),
					'dependency' => array(
						'menu_style' => array( 'left', 'right' ),
					),
					'std'        => 1,
					'type'       => NAZARETH_THEME_FREE ? 'hidden' : 'checkbox',
				),
				'menu_mobile_fullscreen'        => array(
					'title' => esc_html__( 'Mobile menu fullscreen', 'nazareth' ),
					'desc'  => wp_kses_data( __( 'Display mobile and side menus on full screen (if checked) or slide narrow menu from the left or from the right side (if not checked)', 'nazareth' ) ),
					'std'   => 1,
					'type'  => NAZARETH_THEME_FREE ? 'hidden' : 'checkbox',
				),

				'header_image_info'             => array(
					'title' => esc_html__( 'Header image', 'nazareth' ),
					'desc'  => '',
					'type'  => NAZARETH_THEME_FREE ? 'hidden' : 'info',
				),
				'header_image_override'         => array(
					'title'    => esc_html__( 'Header image override', 'nazareth' ),
					'desc'     => wp_kses_data( __( "Allow override the header image with the page's/post's/product's/etc. featured image", 'nazareth' ) ),
					'override' => array(
						'mode'    => 'page',
						'section' => esc_html__( 'Header', 'nazareth' ),
					),
					'std'      => 0,
					'type'     => NAZARETH_THEME_FREE ? 'hidden' : 'checkbox',
				),

				'header_mobile_info'            => array(
					'title'      => esc_html__( 'Mobile header', 'nazareth' ),
					'desc'       => wp_kses_data( __( 'Configure the mobile version of the header', 'nazareth' ) ),
					'priority'   => 500,
					'dependency' => array(
						'header_type' => array( 'default' ),
					),
					'type'       => NAZARETH_THEME_FREE ? 'hidden' : 'info',
				),
				'header_mobile_enabled'         => array(
					'title'      => esc_html__( 'Enable the mobile header', 'nazareth' ),
					'desc'       => wp_kses_data( __( 'Use the mobile version of the header (if checked) or relayout the current header on mobile devices', 'nazareth' ) ),
					'dependency' => array(
						'header_type' => array( 'default' ),
					),
					'std'        => 0,
					'type'       => NAZARETH_THEME_FREE ? 'hidden' : 'checkbox',
				),
				'header_mobile_additional_info' => array(
					'title'      => esc_html__( 'Additional info', 'nazareth' ),
					'desc'       => wp_kses_data( __( 'Additional info to show at the top of the mobile header', 'nazareth' ) ),
					'std'        => '',
					'dependency' => array(
						'header_type'           => array( 'default' ),
						'header_mobile_enabled' => array( 1 ),
					),
					'refresh'    => false,
					'teeny'      => false,
					'rows'       => 20,
					'type'       => NAZARETH_THEME_FREE ? 'hidden' : 'text_editor',
				),
				'header_mobile_hide_info'       => array(
					'title'      => esc_html__( 'Hide additional info', 'nazareth' ),
					'std'        => 0,
					'dependency' => array(
						'header_type'           => array( 'default' ),
						'header_mobile_enabled' => array( 1 ),
					),
					'type'       => NAZARETH_THEME_FREE ? 'hidden' : 'checkbox',
				),
				'header_mobile_hide_logo'       => array(
					'title'      => esc_html__( 'Hide logo', 'nazareth' ),
					'std'        => 0,
					'dependency' => array(
						'header_type'           => array( 'default' ),
						'header_mobile_enabled' => array( 1 ),
					),
					'type'       => NAZARETH_THEME_FREE ? 'hidden' : 'checkbox',
				),
				'header_mobile_hide_login'      => array(
					'title'      => esc_html__( 'Hide login/logout', 'nazareth' ),
					'std'        => 0,
					'dependency' => array(
						'header_type'           => array( 'default' ),
						'header_mobile_enabled' => array( 1 ),
					),
					'type'       => NAZARETH_THEME_FREE ? 'hidden' : 'checkbox',
				),
				'header_mobile_hide_search'     => array(
					'title'      => esc_html__( 'Hide search', 'nazareth' ),
					'std'        => 0,
					'dependency' => array(
						'header_type'           => array( 'default' ),
						'header_mobile_enabled' => array( 1 ),
					),
					'type'       => NAZARETH_THEME_FREE ? 'hidden' : 'checkbox',
				),
				'header_mobile_hide_cart'       => array(
					'title'      => esc_html__( 'Hide cart', 'nazareth' ),
					'std'        => 0,
					'dependency' => array(
						'header_type'           => array( 'default' ),
						'header_mobile_enabled' => array( 1 ),
					),
					'type'       => NAZARETH_THEME_FREE ? 'hidden' : 'checkbox',
				),

				// 'Footer'
				'footer'                        => array(
					'title'    => esc_html__( 'Footer', 'nazareth' ),
					'desc'     => wp_kses_data( $msg_override ),
					'priority' => 50,
					'type'     => 'section',
				),
				'footer_type'                   => array(
					'title'    => esc_html__( 'Footer style', 'nazareth' ),
					'desc'     => wp_kses_data( __( 'Choose whether to use the default footer or footer Layouts (available only if the ThemeREX Addons is activated)', 'nazareth' ) ),
					'override' => array(
						'mode'    => 'page,cpt_team,cpt_services,cpt_dishes,cpt_competitions,cpt_rounds,cpt_matches,cpt_cars,cpt_properties,cpt_courses,cpt_portfolio',
						'section' => esc_html__( 'Footer', 'nazareth' ),
					),
					'std'      => 'default',
					'options'  => nazareth_get_list_header_footer_types(),
					'type'     => NAZARETH_THEME_FREE || ! nazareth_exists_trx_addons() ? 'hidden' : 'switch',
				),
				'footer_style'                  => array(
					'title'      => esc_html__( 'Select custom layout', 'nazareth' ),
					'desc'       => wp_kses_data( __( 'Select custom footer from Layouts Builder', 'nazareth' ) ),
					'override'   => array(
						'mode'    => 'page,cpt_team,cpt_services,cpt_dishes,cpt_competitions,cpt_rounds,cpt_matches,cpt_cars,cpt_properties,cpt_courses,cpt_portfolio',
						'section' => esc_html__( 'Footer', 'nazareth' ),
					),
					'dependency' => array(
						'footer_type' => array( 'custom' ),
					),
					'std'        => NAZARETH_THEME_FREE ? 'footer-custom-elementor-footer-default' : 'footer-custom-footer-default',
					'options'    => array(),
					'type'       => 'select',
				),
				'footer_widgets'                => array(
					'title'      => esc_html__( 'Footer widgets', 'nazareth' ),
					'desc'       => wp_kses_data( __( 'Select set of widgets to show in the footer', 'nazareth' ) ),
					'override'   => array(
						'mode'    => 'page,cpt_team,cpt_services,cpt_dishes,cpt_competitions,cpt_rounds,cpt_matches,cpt_cars,cpt_properties,cpt_courses,cpt_portfolio',
						'section' => esc_html__( 'Footer', 'nazareth' ),
					),
					'dependency' => array(
						'footer_type' => array( 'default' ),
					),
					'std'        => 'footer_widgets',
					'options'    => array(),
					'type'       => 'select',
				),
				'footer_columns'                => array(
					'title'      => esc_html__( 'Footer columns', 'nazareth' ),
					'desc'       => wp_kses_data( __( 'Select number columns to show widgets in the footer. If 0 - autodetect by the widgets count', 'nazareth' ) ),
					'override'   => array(
						'mode'    => 'page,cpt_team,cpt_services,cpt_dishes,cpt_competitions,cpt_rounds,cpt_matches,cpt_cars,cpt_properties,cpt_courses,cpt_portfolio',
						'section' => esc_html__( 'Footer', 'nazareth' ),
					),
					'dependency' => array(
						'footer_type'    => array( 'default' ),
						'footer_widgets' => array( '^hide' ),
					),
					'std'        => 0,
					'options'    => nazareth_get_list_range( 0, 6 ),
					'type'       => 'select',
				),
				'footer_wide'                   => array(
					'title'      => esc_html__( 'Footer fullwidth', 'nazareth' ),
					'desc'       => wp_kses_data( __( 'Do you want to stretch the footer to the entire window width?', 'nazareth' ) ),
					'override'   => array(
						'mode'    => 'page,cpt_team,cpt_services,cpt_dishes,cpt_competitions,cpt_rounds,cpt_matches,cpt_cars,cpt_properties,cpt_courses,cpt_portfolio',
						'section' => esc_html__( 'Footer', 'nazareth' ),
					),
					'dependency' => array(
						'footer_type' => array( 'default' ),
					),
					'std'        => 0,
					'type'       => 'checkbox',
				),
				'logo_in_footer'                => array(
					'title'      => esc_html__( 'Show logo', 'nazareth' ),
					'desc'       => wp_kses_data( __( 'Show logo in the footer', 'nazareth' ) ),
					'refresh'    => false,
					'dependency' => array(
						'footer_type' => array( 'default' ),
					),
					'std'        => 0,
					'type'       => 'checkbox',
				),
				'logo_footer'                   => array(
					'title'      => esc_html__( 'Logo for footer', 'nazareth' ),
					'desc'       => wp_kses_data( __( 'Select or upload site logo to display it in the footer', 'nazareth' ) ),
					'dependency' => array(
						'footer_type'    => array( 'default' ),
						'logo_in_footer' => array( 1 ),
					),
					'std'        => '',
					'type'       => 'image',
				),
				'logo_footer_retina'            => array(
					'title'      => esc_html__( 'Logo for footer (Retina)', 'nazareth' ),
					'desc'       => wp_kses_data( __( 'Select or upload logo for the footer area used on Retina displays (if empty - use default logo from the field above)', 'nazareth' ) ),
					'dependency' => array(
						'footer_type'         => array( 'default' ),
						'logo_in_footer'      => array( 1 ),
						'logo_retina_enabled' => array( 1 ),
					),
					'std'        => '',
					'type'       => NAZARETH_THEME_FREE ? 'hidden' : 'image',
				),
				'socials_in_footer'             => array(
					'title'      => esc_html__( 'Show social icons', 'nazareth' ),
					'desc'       => wp_kses_data( __( 'Show social icons in the footer (under logo or footer widgets)', 'nazareth' ) ),
					'dependency' => array(
						'footer_type' => array( 'default' ),
					),
					'std'        => 0,
					'type'       => ! nazareth_exists_trx_addons() ? 'hidden' : 'checkbox',
				),
				'copyright'                     => array(
					'title'      => esc_html__( 'Copyright', 'nazareth' ),
					'desc'       => wp_kses_data( __( 'Copyright text in the footer. Use {Y} to insert current year and press "Enter" to create a new line', 'nazareth' ) ),
					'translate'  => true,
					'std'        => esc_html__( 'Copyright &copy; {Y} by AxiomThemes. All rights reserved.', 'nazareth' ),
					'dependency' => array(
						'footer_type' => array( 'default' ),
					),
					'refresh'    => false,
					'type'       => 'textarea',
				),

				// 'Blog'
				'blog'                          => array(
					'title'    => esc_html__( 'Blog', 'nazareth' ),
					'desc'     => wp_kses_data( __( 'Options of the the blog archive', 'nazareth' ) ),
					'priority' => 70,
					'type'     => 'panel',
				),

				// Blog - Posts page
				'blog_general'                  => array(
					'title' => esc_html__( 'Posts page', 'nazareth' ),
					'desc'  => wp_kses_data( __( 'Style and components of the blog archive', 'nazareth' ) ),
					'type'  => 'section',
				),
				'blog_general_info'             => array(
					'title'  => esc_html__( 'Posts page settings', 'nazareth' ),
					'desc'   => '',
					'qsetup' => esc_html__( 'General', 'nazareth' ),
					'type'   => 'info',
				),
				'blog_style'                    => array(
					'title'      => esc_html__( 'Blog style', 'nazareth' ),
					'desc'       => '',
					'override'   => array(
						'mode'    => 'page',
						'section' => esc_html__( 'Content', 'nazareth' ),
					),
					'dependency' => array(
						'compare' => 'or',
						'#page_template' => array( 'blog.php' ),
						'.editor-page-attributes__template select' => array( 'blog.php' ),
					),
					'std'        => 'excerpt',
					'qsetup'     => esc_html__( 'General', 'nazareth' ),
					'options'    => array(),
					'type'       => 'select',
				),
				'first_post_large'              => array(
					'title'      => esc_html__( 'First post large', 'nazareth' ),
					'desc'       => wp_kses_data( __( 'Make your first post stand out by making it bigger', 'nazareth' ) ),
					'override'   => array(
						'mode'    => 'page',
						'section' => esc_html__( 'Content', 'nazareth' ),
					),
					'dependency' => array(
						'compare' => 'or',
						'#page_template' => array( 'blog.php' ),
						'.editor-page-attributes__template select' => array( 'blog.php' ),
						'blog_style' => array( 'classic', 'masonry' ),
					),
					'std'        => 0,
					'type'       => 'checkbox',
				),
				'blog_content'                  => array(
					'title'      => esc_html__( 'Posts content', 'nazareth' ),
					'desc'       => wp_kses_data( __( 'Display either post excerpts or the full post content', 'nazareth' ) ),
					'std'        => 'excerpt',
					'dependency' => array(
						'blog_style' => array( 'excerpt' ),
					),
					'options'    => array(
						'excerpt'  => esc_html__( 'Excerpt', 'nazareth' ),
						'fullpost' => esc_html__( 'Full post', 'nazareth' ),
					),
					'type'       => 'switch',
				),
				'excerpt_length'                => array(
					'title'      => esc_html__( 'Excerpt length', 'nazareth' ),
					'desc'       => wp_kses_data( __( 'Length (in words) to generate excerpt from the post content. Attention! If the post excerpt is explicitly specified - it appears unchanged', 'nazareth' ) ),
					'dependency' => array(
						'blog_style'   => array( 'excerpt' ),
						'blog_content' => array( 'excerpt' ),
					),
					'std'        => 39,
					'type'       => 'text',
				),
				'blog_columns'                  => array(
					'title'   => esc_html__( 'Blog columns', 'nazareth' ),
					'desc'    => wp_kses_data( __( 'How many columns should be used in the blog archive (from 2 to 4)?', 'nazareth' ) ),
					'std'     => 2,
					'options' => nazareth_get_list_range( 2, 4 ),
					'type'    => 'hidden',      // This options is available and must be overriden only for some modes (for example, 'shop')
				),
				'post_type'                     => array(
					'title'      => esc_html__( 'Post type', 'nazareth' ),
					'desc'       => wp_kses_data( __( 'Select post type to show in the blog archive', 'nazareth' ) ),
					'override'   => array(
						'mode'    => 'page',
						'section' => esc_html__( 'Content', 'nazareth' ),
					),
					'dependency' => array(
						'compare' => 'or',
						'#page_template' => array( 'blog.php' ),
						'.editor-page-attributes__template select' => array( 'blog.php' ),
					),
					'linked'     => 'parent_cat',
					'refresh'    => false,
					'hidden'     => true,
					'std'        => 'post',
					'options'    => array(),
					'type'       => 'select',
				),
				'parent_cat'                    => array(
					'title'      => esc_html__( 'Category to show', 'nazareth' ),
					'desc'       => wp_kses_data( __( 'Select category to show in the blog archive', 'nazareth' ) ),
					'override'   => array(
						'mode'    => 'page',
						'section' => esc_html__( 'Content', 'nazareth' ),
					),
					'dependency' => array(
						'compare' => 'or',
						'#page_template' => array( 'blog.php' ),
						'.editor-page-attributes__template select' => array( 'blog.php' ),
					),
					'refresh'    => false,
					'hidden'     => true,
					'std'        => '0',
					'options'    => array(),
					'type'       => 'select',
				),
				'posts_per_page'                => array(
					'title'      => esc_html__( 'Posts per page', 'nazareth' ),
					'desc'       => wp_kses_data( __( 'How many posts will be displayed on this page', 'nazareth' ) ),
					'override'   => array(
						'mode'    => 'page',
						'section' => esc_html__( 'Content', 'nazareth' ),
					),
					'dependency' => array(
						'compare' => 'or',
						'#page_template' => array( 'blog.php' ),
						'.editor-page-attributes__template select' => array( 'blog.php' ),
					),
					'hidden'     => true,
					'std'        => '',
					'type'       => 'text',
				),
				'blog_pagination'               => array(
					'title'      => esc_html__( 'Pagination style', 'nazareth' ),
					'desc'       => wp_kses_data( __( 'Show Older/Newest posts or Page numbers below the posts list', 'nazareth' ) ),
					'override'   => array(
						'mode'    => 'page',
						'section' => esc_html__( 'Content', 'nazareth' ),
					),
					'std'        => 'pages',
					'qsetup'     => esc_html__( 'General', 'nazareth' ),
					'dependency' => array(
						'compare' => 'or',
						'#page_template' => array( 'blog.php' ),
						'.editor-page-attributes__template select' => array( 'blog.php' ),
					),
					'options'    => array(
						'pages'    => esc_html__( 'Page numbers', 'nazareth' ),
						'links'    => esc_html__( 'Older/Newest', 'nazareth' ),
						'more'     => esc_html__( 'Load more', 'nazareth' ),
						'infinite' => esc_html__( 'Infinite scroll', 'nazareth' ),
					),
					'type'       => 'select',
				),
				'blog_animation'                => array(
					'title'      => esc_html__( 'Animation for the posts', 'nazareth' ),
					'desc'       => wp_kses_data( __( 'Select animation to show posts in the blog. Attention! Do not use any animation on pages with the "wheel to the anchor" behaviour (like a "Chess 2 columns")!', 'nazareth' ) ),
					'override'   => array(
						'mode'    => 'page',
						'section' => esc_html__( 'Content', 'nazareth' ),
					),
					'dependency' => array(
						'compare' => 'or',
						'#page_template' => array( 'blog.php' ),
						'.editor-page-attributes__template select' => array( 'blog.php' ),
					),
					'std'        => 'fadeInLeft',
					'options'    => array(),
					'type'       => NAZARETH_THEME_FREE ? 'hidden' : 'select',
				),
				'show_filters'                  => array(
					'title'      => esc_html__( 'Show filters', 'nazareth' ),
					'desc'       => wp_kses_data( __( 'Show categories as tabs to filter posts', 'nazareth' ) ),
					'override'   => array(
						'mode'    => 'page',
						'section' => esc_html__( 'Content', 'nazareth' ),
					),
					'dependency' => array(
						'compare' => 'or',
						'#page_template' => array( 'blog.php' ),
						'.editor-page-attributes__template select' => array( 'blog.php' ),
						'blog_style'     => array( 'portfolio', 'gallery' ),
					),
					'hidden'     => true,
					'std'        => 0,
					'type'       => NAZARETH_THEME_FREE ? 'hidden' : 'checkbox',
				),

				'blog_header_info'              => array(
					'title' => esc_html__( 'Header', 'nazareth' ),
					'desc'  => '',
					'type'  => 'info',
				),
				'header_type_blog'              => array(
					'title'    => esc_html__( 'Header style', 'nazareth' ),
					'desc'     => wp_kses_data( __( 'Choose whether to use the default header or header Layouts (available only if the ThemeREX Addons is activated)', 'nazareth' ) ),
					'std'      => 'inherit',
					'options'  => nazareth_get_list_header_footer_types( true ),
					'type'     => NAZARETH_THEME_FREE || ! nazareth_exists_trx_addons() ? 'hidden' : 'switch',
				),
				'header_style_blog'             => array(
					'title'      => esc_html__( 'Select custom layout', 'nazareth' ),
					'desc'       => wp_kses_data( __( 'Select custom header from Layouts Builder', 'nazareth' ) ),
					'dependency' => array(
						'header_type_blog' => array( 'custom' ),
					),
					'std'        => NAZARETH_THEME_FREE ? 'header-custom-elementor-header-default' : 'header-custom-header-default',
					'options'    => array(),
					'type'       => 'select',
				),
				'header_position_blog'          => array(
					'title'    => esc_html__( 'Header position', 'nazareth' ),
					'desc'     => wp_kses_data( __( 'Select position to display the site header', 'nazareth' ) ),
					'std'      => 'inherit',
					'options'  => array(),
					'type'     => NAZARETH_THEME_FREE ? 'hidden' : 'switch',
				),
				'header_fullheight_blog'        => array(
					'title'    => esc_html__( 'Header fullheight', 'nazareth' ),
					'desc'     => wp_kses_data( __( 'Enlarge header area to fill whole screen. Used only if header have a background image', 'nazareth' ) ),
					'std'      => 0,
					'type'     => NAZARETH_THEME_FREE ? 'hidden' : 'checkbox',
				),
				'header_wide_blog'              => array(
					'title'      => esc_html__( 'Header fullwidth', 'nazareth' ),
					'desc'       => wp_kses_data( __( 'Do you want to stretch the header widgets area to the entire window width?', 'nazareth' ) ),
					'dependency' => array(
						'header_type_blog' => array( 'default' ),
					),
					'std'        => 1,
					'type'       => NAZARETH_THEME_FREE ? 'hidden' : 'checkbox',
				),

				'blog_sidebar_info'             => array(
					'title' => esc_html__( 'Sidebar', 'nazareth' ),
					'desc'  => '',
					'type'  => 'info',
				),
				'sidebar_widgets_blog'          => array(
					'title'      => esc_html__( 'Sidebar widgets', 'nazareth' ),
					'desc'       => wp_kses_data( __( 'Select default widgets to show in the sidebar', 'nazareth' ) ),
					'dependency' => array(
						'sidebar_position_blog' => array( '^hide' ),
					),
					'std'        => 'sidebar_widgets',
					'options'    => array(),
					'qsetup'     => esc_html__( 'General', 'nazareth' ),
					'type'       => 'select',
				),
				'expand_content_blog'           => array(
					'title'   => esc_html__( 'Expand content', 'nazareth' ),
					'desc'    => wp_kses_data( __( 'Expand the content width if the sidebar is hidden', 'nazareth' ) ),
					'refresh' => false,
					'std'     => 1,
					'type'    => 'checkbox',
				),
				'blog_advanced_info'            => array(
					'title' => esc_html__( 'Advanced settings', 'nazareth' ),
					'desc'  => '',
					'type'  => 'info',
				),
				'no_image'                      => array(
					'title' => esc_html__( 'Image placeholder', 'nazareth' ),
					'desc'  => wp_kses_data( __( 'Select or upload an image used as placeholder for posts without a featured image', 'nazareth' ) ),
					'std'   => '',
					'type'  => 'image',
				),
				'time_diff_before'              => array(
					'title' => esc_html__( 'Easy Readable Date Format', 'nazareth' ),
					'desc'  => wp_kses_data( __( "For how many days to show the easy-readable date format (e.g. '3 days ago') instead of the standard publication date", 'nazareth' ) ),
					'std'   => 5,
					'type'  => 'text',
				),
				'sticky_style'                  => array(
					'title'   => esc_html__( 'Sticky posts style', 'nazareth' ),
					'desc'    => wp_kses_data( __( 'Select style of the sticky posts output', 'nazareth' ) ),
					'std'     => 'inherit',
					'options' => array(
						'inherit' => esc_html__( 'Decorated posts', 'nazareth' ),					
					),
					'type'    => NAZARETH_THEME_FREE ? 'hidden' : 'select',
				),
				'meta_parts'                    => array(
					'title'      => esc_html__( 'Post meta', 'nazareth' ),
					'desc'       => wp_kses_data( __( "If your blog page is created using the 'Blog archive' page template, set up the 'Post Meta' settings in the 'Theme Options' section of that page. Post counters and Share Links are available only if plugin ThemeREX Addons is active", 'nazareth' ) )
								. '<br>'
								. wp_kses_data( __( '<b>Tip:</b> Drag items to change their order.', 'nazareth' ) ),
					'override'   => array(
						'mode'    => 'page',
						'section' => esc_html__( 'Content', 'nazareth' ),
					),
					'dependency' => array(
						'compare' => 'or',
						'#page_template' => array( 'blog.php' ),
						'.editor-page-attributes__template select' => array( 'blog.php' ),
					),
					'dir'        => 'vertical',
					'sortable'   => true,
					'std'        => 'categories=0|date=1|counters=0|author=0|share=0|edit=0',
					'options'    => nazareth_get_list_meta_parts(),
					'type'       => NAZARETH_THEME_FREE ? 'hidden' : 'checklist',
				),
				'counters'                      => array(
					'title'      => esc_html__( 'Post counters', 'nazareth' ),
					'desc'       => wp_kses_data( __( 'Show only selected counters. Attention! Likes and Views are available only if ThemeREX Addons is active', 'nazareth' ) ),
					'override'   => array(
						'mode'    => 'page',
						'section' => esc_html__( 'Content', 'nazareth' ),
					),
					'dependency' => array(
						'compare' => 'or',
						'#page_template' => array( 'blog.php' ),
						'.editor-page-attributes__template select' => array( 'blog.php' ),
					),
					'dir'        => 'vertical',
					'sortable'   => true,
					'std'        => 'views=0|likes=0|comments=0',
					'options'    => nazareth_get_list_counters(),
					'type'       => NAZARETH_THEME_FREE || ! nazareth_exists_trx_addons() ? 'hidden' : 'checklist',
				),

				// Blog - Single posts
				'blog_single'                   => array(
					'title' => esc_html__( 'Single posts', 'nazareth' ),
					'desc'  => wp_kses_data( __( 'Settings of the single post', 'nazareth' ) ),
					'type'  => 'section',
				),

				'blog_single_header_info'       => array(
					'title' => esc_html__( 'Header', 'nazareth' ),
					'desc'  => '',
					'type'  => 'info',
				),
				'header_type_post'              => array(
					'title'    => esc_html__( 'Header style', 'nazareth' ),
					'desc'     => wp_kses_data( __( 'Choose whether to use the default header or header Layouts (available only if the ThemeREX Addons is activated)', 'nazareth' ) ),
					'std'      => 'inherit',
					'options'  => nazareth_get_list_header_footer_types( true ),
					'type'     => NAZARETH_THEME_FREE || ! nazareth_exists_trx_addons() ? 'hidden' : 'switch',
				),
				'header_style_post'             => array(
					'title'      => esc_html__( 'Select custom layout', 'nazareth' ),
					'desc'       => wp_kses_data( __( 'Select custom header from Layouts Builder', 'nazareth' ) ),
					'dependency' => array(
						'header_type_post' => array( 'custom' ),
					),
					'std'        => NAZARETH_THEME_FREE ? 'header-custom-elementor-header-default' : 'header-custom-header-default',
					'options'    => array(),
					'type'       => 'select',
				),
				'header_position_post'          => array(
					'title'    => esc_html__( 'Header position', 'nazareth' ),
					'desc'     => wp_kses_data( __( 'Select position to display the site header', 'nazareth' ) ),
					'std'      => 'inherit',
					'options'  => array(),
					'type'     => NAZARETH_THEME_FREE ? 'hidden' : 'switch',
				),
				'header_fullheight_post'        => array(
					'title'    => esc_html__( 'Header fullheight', 'nazareth' ),
					'desc'     => wp_kses_data( __( 'Enlarge header area to fill whole screen. Used only if header have a background image', 'nazareth' ) ),
					'std'      => 0,
					'type'     => NAZARETH_THEME_FREE ? 'hidden' : 'checkbox',
				),
				'header_wide_post'              => array(
					'title'      => esc_html__( 'Header fullwidth', 'nazareth' ),
					'desc'       => wp_kses_data( __( 'Do you want to stretch the header widgets area to the entire window width?', 'nazareth' ) ),
					'dependency' => array(
						'header_type_post' => array( 'default' ),
					),
					'std'        => 1,
					'type'       => NAZARETH_THEME_FREE ? 'hidden' : 'checkbox',
				),

				'blog_single_sidebar_info'      => array(
					'title' => esc_html__( 'Sidebar', 'nazareth' ),
					'desc'  => '',
					'type'  => 'info',
				),
				'sidebar_position_single'       => array(
					'title'   => esc_html__( 'Sidebar position', 'nazareth' ),
					'desc'    => wp_kses_data( __( 'Select position to show sidebar on the single posts', 'nazareth' ) ),
					'std'     => 'right',
					'override'   => array(
						'mode'    => 'post,product,cpt_team,cpt_services,cpt_dishes,cpt_competitions,cpt_rounds,cpt_matches,cpt_cars,cpt_properties,cpt_courses,cpt_portfolio',
						'section' => esc_html__( 'Widgets', 'nazareth' ),
					),
					'options' => array(),
					'type'    => 'switch',
				),
				'sidebar_position_mobile_single'=> array(
					'title'    => esc_html__( 'Sidebar position on mobile', 'nazareth' ),
					'desc'     => wp_kses_data( __( 'Select position to show sidebar on the single posts on mobile devices - above or below the content', 'nazareth' ) ),
					'override' => array(
						'mode'    => 'post,product,cpt_team,cpt_services,cpt_dishes,cpt_competitions,cpt_rounds,cpt_matches,cpt_cars,cpt_properties,cpt_courses,cpt_portfolio',
						'section' => esc_html__( 'Widgets', 'nazareth' ),
					),
					'dependency' => array(
						'sidebar_position_single' => array( '^hide' ),
					),
					'std'      => 'below',
					'options'  => array(),
					'type'     => 'switch',
				),
				'sidebar_widgets_single'        => array(
					'title'      => esc_html__( 'Sidebar widgets', 'nazareth' ),
					'desc'       => wp_kses_data( __( 'Select default widgets to show in the sidebar on the single posts', 'nazareth' ) ),
					'override'   => array(
						'mode'    => 'post,product,cpt_team,cpt_services,cpt_dishes,cpt_competitions,cpt_rounds,cpt_matches,cpt_cars,cpt_properties,cpt_courses,cpt_portfolio',
						'section' => esc_html__( 'Widgets', 'nazareth' ),
					),
					'dependency' => array(
						'sidebar_position_single' => array( '^hide' ),
					),
					'std'        => 'sidebar_widgets',
					'options'    => array(),
					'type'       => 'select',
				),
				'expand_content_post'           => array(
					'title'   => esc_html__( 'Expand content', 'nazareth' ),
					'desc'    => wp_kses_data( __( 'Expand the content width on the single posts if the sidebar is hidden', 'nazareth' ) ),
					'refresh' => false,
					'std'     => 1,
					'type'    => 'checkbox',
				),

				'blog_single_title_info'      => array(
					'title' => esc_html__( 'Featured image and title', 'nazareth' ),
					'desc'  => '',
					'type'  => 'info',
				),
				'hide_featured_on_single'       => array(
					'title'    => esc_html__( 'Hide featured image on the single post', 'nazareth' ),
					'desc'     => wp_kses_data( __( "Hide featured image on the single post's pages", 'nazareth' ) ),
					'override' => array(
						'mode'    => 'page,post',
						'section' => esc_html__( 'Content', 'nazareth' ),
					),
					'std'      => 0,
					'type'     => 'checkbox',
				),
				'post_thumbnail_type'      => array(
					'title'      => esc_html__( 'Type of post thumbnail', 'nazareth' ),
					'desc'       => wp_kses_data( __( "Select type of post thumbnail on the single post's pages", 'nazareth' ) ),
					'override'   => array(
						'mode'    => 'post',
						'section' => esc_html__( 'Content', 'nazareth' ),
					),
					'dependency' => array(
						'hide_featured_on_single' => array( 'is_empty', 0 ),
					),
					'std'        => 'default',
					'options'    => array(						
						'default'     => esc_html__( 'Default', 'nazareth' ),
					),
					'type'       => NAZARETH_THEME_FREE ? 'hidden' : 'select',
				),
				'post_header_position'          => array(
					'title'      => esc_html__( 'Post header position', 'nazareth' ),
					'desc'       => wp_kses_data( __( "Select post header position on the single post's pages", 'nazareth' ) ),
					'override'   => array(
						'mode'    => 'post',
						'section' => esc_html__( 'Content', 'nazareth' ),
					),
					'dependency' => array(
						'hide_featured_on_single' => array( 'is_empty', 0 ),
					),
					'std'        => 'under',
					'options'    => array(						
						'default'    => esc_html__( 'Default', 'nazareth' ),
					),
					'type'       => NAZARETH_THEME_FREE ? 'hidden' : 'select',
				),
				'post_header_align'             => array(
					'title'      => esc_html__( 'Align of the post header', 'nazareth' ),
					'override'   => array(
						'mode'    => 'post',
						'section' => esc_html__( 'Content', 'nazareth' ),
					),
					'dependency' => array(
						'post_header_position' => array( 'on_thumb' ),
					),
					'std'        => 'mc',
					'options'    => array(
						'ts' => esc_html__('Top Stick Out', 'nazareth'),
						'tl' => esc_html__('Top Left', 'nazareth'),
						'tc' => esc_html__('Top Center', 'nazareth'),
						'tr' => esc_html__('Top Right', 'nazareth'),
						'ml' => esc_html__('Middle Left', 'nazareth'),
						'mc' => esc_html__('Middle Center', 'nazareth'),
						'mr' => esc_html__('Middle Right', 'nazareth'),
						'bl' => esc_html__('Bottom Left', 'nazareth'),
						'bc' => esc_html__('Bottom Center', 'nazareth'),
						'br' => esc_html__('Bottom Right', 'nazareth'),
						'bs' => esc_html__('Bottom Stick Out', 'nazareth'),
					),
					'type'       => NAZARETH_THEME_FREE ? 'hidden' : 'select',
				),
				'post_subtitle'                 => array(
					'title' => esc_html__( 'Post subtitle', 'nazareth' ),
					'desc'  => wp_kses_data( __( "Specify post subtitle to display it under the post title.", 'nazareth' ) ),
					'override' => array(
						'mode'    => 'post',
						'section' => esc_html__( 'Content', 'nazareth' ),
					),
					'std'   => '',
					'hidden' => true,
					'type'  => 'text',
				),
				'show_post_meta'                => array(
					'title' => esc_html__( 'Show post meta', 'nazareth' ),
					'desc'  => wp_kses_data( __( "Display block with post's meta: date, categories, counters, etc.", 'nazareth' ) ),
					'std'   => 1,
					'type'  => 'checkbox',
				),
				'meta_parts_post'               => array(
					'title'      => esc_html__( 'Post meta', 'nazareth' ),
					'desc'       => wp_kses_data( __( 'Meta parts for single posts. Post counters and Share Links are available only if plugin ThemeREX Addons is active', 'nazareth' ) )
								. '<br>'
								. wp_kses_data( __( '<b>Tip:</b> Drag items to change their order.', 'nazareth' ) ),
					'dependency' => array(
						'show_post_meta' => array( 1 ),
					),
					'dir'        => 'vertical',
					'sortable'   => true,
					'std'        => 'categories=0|date=1|counters=0|author=0|share=0|edit=0',
					'options'    => nazareth_get_list_meta_parts(),
					'type'       => NAZARETH_THEME_FREE ? 'hidden' : 'checklist',
				),
				'counters_post'                 => array(
					'title'      => esc_html__( 'Post counters', 'nazareth' ),
					'desc'       => wp_kses_data( __( 'Show only selected counters. Attention! Likes and Views are available only if plugin ThemeREX Addons is active', 'nazareth' ) ),
					'dependency' => array(
						'show_post_meta' => array( 1 ),
					),
					'dir'        => 'vertical',
					'sortable'   => true,
					'std'        => 'views=0|likes=0|comments=0',
					'options'    => nazareth_get_list_counters(),
					'type'       => NAZARETH_THEME_FREE || ! nazareth_exists_trx_addons() ? 'hidden' : 'checklist',
				),
				'show_share_links'              => array(
					'title' => esc_html__( 'Show share links', 'nazareth' ),
					'desc'  => wp_kses_data( __( 'Display share links on the single post', 'nazareth' ) ),
					'std'   => 1,
					'type'  => ! nazareth_exists_trx_addons() ? 'hidden' : 'checkbox',
				),
				'show_author_info'              => array(
					'title' => esc_html__( 'Show author info', 'nazareth' ),
					'desc'  => wp_kses_data( __( "Display block with information about post's author", 'nazareth' ) ),
					'std'   => 1,
					'type'  => 'checkbox',
				),

				'blog_single_related_info'      => array(
					'title' => esc_html__( 'Related posts', 'nazareth' ),
					'desc'  => '',
					'type'  => 'info',
				),
				'show_related_posts'            => array(
					'title'    => esc_html__( 'Show related posts', 'nazareth' ),
					'desc'     => wp_kses_data( __( "Show section 'Related posts' on the single post's pages", 'nazareth' ) ),
					'override' => array(
						'mode'    => 'page',
						'section' => esc_html__( 'Content', 'nazareth' ),
					),
					'std'      => 1,
					'type'     => 'checkbox',
				),
				'related_posts'                 => array(
					'title'      => esc_html__( 'Related posts', 'nazareth' ),
					'desc'       => wp_kses_data( __( 'How many related posts should be displayed in the single post? If 0 - no related posts are shown.', 'nazareth' ) ),
					'dependency' => array(
						'show_related_posts' => array( 1 ),
					),
					'std'        => 2,
					'options'    => nazareth_get_list_range( 1, 6 ),
					'type'       => NAZARETH_THEME_FREE ? 'hidden' : 'select',
				),
				'related_columns'               => array(
					'title'      => esc_html__( 'Related columns', 'nazareth' ),
					'desc'       => wp_kses_data( __( 'How many columns should be used to output related posts in the single page (from 1 to 2)?', 'nazareth' ) ),
					'dependency' => array(
						'show_related_posts' => array( 1 ),
					),
					'std'        => 2,
					'options'    => nazareth_get_list_range( 1, 2 ),
					'type'       => NAZARETH_THEME_FREE ? 'hidden' : 'switch',
				),
				'related_style'                 => array(
					'title'      => esc_html__( 'Related posts style', 'nazareth' ),
					'desc'       => wp_kses_data( __( 'Select style of the related posts output', 'nazareth' ) ),
					'dependency' => array(
						'show_related_posts' => array( 1 ),
					),
					'std'        => 2,
					'options'    => nazareth_get_list_styles( 2 ),
					'type'       => NAZARETH_THEME_FREE ? 'hidden' : 'switch',
				),				
				'related_position'              => array(
					'title'      => esc_html__( 'Related posts position', 'nazareth' ),
					'desc'       => wp_kses_data( __( 'Select position to display the related posts', 'nazareth' ) ),
					'dependency' => array(
						'show_related_posts' => array( 1 ),
					),
					'std'        => 'below_content',
					'options'    => array (
						'below_content' => esc_html__( 'After content', 'nazareth' ),						
					),
					'type'       => NAZARETH_THEME_FREE ? 'hidden' : 'switch',
				),
				'blog_end'                      => array(
					'type' => 'panel_end',
				),

				// 'Colors'
				'panel_colors'                  => array(
					'title'    => esc_html__( 'Colors', 'nazareth' ),
					'desc'     => '',
					'priority' => 300,
					'type'     => 'section',
				),

				'color_schemes_info'            => array(
					'title'  => esc_html__( 'Color schemes', 'nazareth' ),
					'desc'   => wp_kses_data( __( 'Color schemes for various parts of the site. "Inherit" means that this block is used the Site color scheme (the first parameter)', 'nazareth' ) ),
					'hidden' => $hide_schemes,
					'type'   => 'info',
				),
				'color_scheme'                  => array(
					'title'    => esc_html__( 'Site Color Scheme', 'nazareth' ),
					'desc'     => '',
					'override' => array(
						'mode'    => 'page,cpt_team,cpt_services,cpt_dishes,cpt_competitions,cpt_rounds,cpt_matches,cpt_cars,cpt_properties,cpt_courses,cpt_portfolio',
						'section' => esc_html__( 'Colors', 'nazareth' ),
					),
					'std'      => 'default',
					'options'  => array(),
					'refresh'  => false,
					'type'     => $hide_schemes ? 'hidden' : 'switch',
				),
				'header_scheme'                 => array(
					'title'    => esc_html__( 'Header Color Scheme', 'nazareth' ),
					'desc'     => '',
					'override' => array(
						'mode'    => 'page,cpt_team,cpt_services,cpt_dishes,cpt_competitions,cpt_rounds,cpt_matches,cpt_cars,cpt_properties,cpt_courses,cpt_portfolio',
						'section' => esc_html__( 'Colors', 'nazareth' ),
					),
					'std'      => 'inherit',
					'options'  => array(),
					'refresh'  => false,
					'type'     => $hide_schemes ? 'hidden' : 'switch',
				),
				
				'sidebar_scheme'                => array(
					'title'    => esc_html__( 'Sidebar Color Scheme', 'nazareth' ),
					'desc'     => '',
					'override' => array(
						'mode'    => 'page,cpt_team,cpt_services,cpt_dishes,cpt_competitions,cpt_rounds,cpt_matches,cpt_cars,cpt_properties,cpt_courses,cpt_portfolio',
						'section' => esc_html__( 'Colors', 'nazareth' ),
					),
					'std'      => 'inherit',
					'options'  => array(),
					'refresh'  => false,
					'type'     => $hide_schemes ? 'hidden' : 'switch',
				),
				'footer_scheme'                 => array(
					'title'    => esc_html__( 'Footer Color Scheme', 'nazareth' ),
					'desc'     => '',
					'override' => array(
						'mode'    => 'page,cpt_team,cpt_services,cpt_dishes,cpt_competitions,cpt_rounds,cpt_matches,cpt_cars,cpt_properties,cpt_courses,cpt_portfolio',
						'section' => esc_html__( 'Colors', 'nazareth' ),
					),
					'std'      => 'dark',
					'options'  => array(),
					'refresh'  => false,
					'type'     => $hide_schemes ? 'hidden' : 'switch',
				),

				'color_scheme_editor_info'      => array(
					'title' => esc_html__( 'Color scheme editor', 'nazareth' ),
					'desc'  => wp_kses_data( __( 'Select color scheme to modify. Attention! Only those sections in the site will be changed which this scheme was assigned to', 'nazareth' ) ),
					'type'  => 'info',
				),
				'scheme_storage'                => array(
					'title'       => esc_html__( 'Color scheme editor', 'nazareth' ),
					'desc'        => '',
					'std'         => '$nazareth_get_scheme_storage',
					'refresh'     => false,
					'colorpicker' => 'tiny',
					'type'        => 'scheme_editor',
				),

				// Internal options.
				// Attention! Don't change any options in the section below!
				// Use huge priority to call render this elements after all options!
				'reset_options'                 => array(
					'title'    => '',
					'desc'     => '',
					'std'      => '0',
					'priority' => 10000,
					'type'     => 'hidden',
				),

				'last_option'                   => array(     // Need to manually call action to include Tiny MCE scripts
					'title' => '',
					'desc'  => '',
					'std'   => 1,
					'type'  => 'hidden',
				),

			)
		);

		// Prepare panel 'Fonts'
		// -------------------------------------------------------------
		$fonts = array(

			// 'Fonts'
			'fonts'             => array(
				'title'    => esc_html__( 'Typography', 'nazareth' ),
				'desc'     => '',
				'priority' => 200,
				'type'     => 'panel',
			),

			// Fonts - Load_fonts
			'load_fonts'        => array(
				'title' => esc_html__( 'Load fonts', 'nazareth' ),
				'desc'  => wp_kses_data( __( 'Specify fonts to load when theme start. You can use them in the base theme elements: headers, text, menu, links, input fields, etc.', 'nazareth' ) )
						. '<br>'
						. wp_kses_data( __( 'Attention! Press "Refresh" button to reload preview area after the all fonts are changed', 'nazareth' ) ),
				'type'  => 'section',
			),
			'load_fonts_subset' => array(
				'title'   => esc_html__( 'Google fonts subsets', 'nazareth' ),
				'desc'    => wp_kses_data( __( 'Specify comma separated list of the subsets which will be load from Google fonts', 'nazareth' ) )
						. '<br>'
						. wp_kses_data( __( 'Available subsets are: latin,latin-ext,cyrillic,cyrillic-ext,greek,greek-ext,vietnamese', 'nazareth' ) ),
				'class'   => 'nazareth_column-1_3 nazareth_new_row',
				'refresh' => false,
				'std'     => '$nazareth_get_load_fonts_subset',
				'type'    => 'text',
			),
		);

		for ( $i = 1; $i <= nazareth_get_theme_setting( 'max_load_fonts' ); $i++ ) {
			if ( nazareth_get_value_gp( 'page' ) != 'theme_options' ) {
				$fonts[ "load_fonts-{$i}-info" ] = array(
					// Translators: Add font's number - 'Font 1', 'Font 2', etc
					'title' => esc_html( sprintf( esc_html__( 'Font %s', 'nazareth' ), $i ) ),
					'desc'  => '',
					'type'  => 'info',
				);
			}
			$fonts[ "load_fonts-{$i}-name" ]   = array(
				'title'   => esc_html__( 'Font name', 'nazareth' ),
				'desc'    => '',
				'class'   => 'nazareth_column-1_3 nazareth_new_row',
				'refresh' => false,
				'std'     => '$nazareth_get_load_fonts_option',
				'type'    => 'text',
			);
			$fonts[ "load_fonts-{$i}-family" ] = array(
				'title'   => esc_html__( 'Font family', 'nazareth' ),
				'desc'    => 1 == $i
							? wp_kses_data( __( 'Select font family to use it if font above is not available', 'nazareth' ) )
							: '',
				'class'   => 'nazareth_column-1_3',
				'refresh' => false,
				'std'     => '$nazareth_get_load_fonts_option',
				'options' => array(
					'inherit'    => esc_html__( 'Inherit', 'nazareth' ),
					'serif'      => esc_html__( 'serif', 'nazareth' ),
					'sans-serif' => esc_html__( 'sans-serif', 'nazareth' ),
					'monospace'  => esc_html__( 'monospace', 'nazareth' ),
					'cursive'    => esc_html__( 'cursive', 'nazareth' ),
					'fantasy'    => esc_html__( 'fantasy', 'nazareth' ),
				),
				'type'    => 'select',
			);
			$fonts[ "load_fonts-{$i}-styles" ] = array(
				'title'   => esc_html__( 'Font styles', 'nazareth' ),
				'desc'    => 1 == $i
							? wp_kses_data( __( 'Font styles used only for the Google fonts. This is a comma separated list of the font weight and styles. For example: 400,400italic,700', 'nazareth' ) )
								. '<br>'
								. wp_kses_data( __( 'Attention! Each weight and style increase download size! Specify only used weights and styles.', 'nazareth' ) )
							: '',
				'class'   => 'nazareth_column-1_3',
				'refresh' => false,
				'std'     => '$nazareth_get_load_fonts_option',
				'type'    => 'text',
			);
		}
		$fonts['load_fonts_end'] = array(
			'type' => 'section_end',
		);

		// Fonts - H1..6, P, Info, Menu, etc.
		$theme_fonts = nazareth_get_theme_fonts();
		foreach ( $theme_fonts as $tag => $v ) {
			$fonts[ "{$tag}_section" ] = array(
				'title' => ! empty( $v['title'] )
								? $v['title']
								// Translators: Add tag's name to make title 'H1 settings', 'P settings', etc.
								: esc_html( sprintf( esc_html__( '%s settings', 'nazareth' ), $tag ) ),
				'desc'  => ! empty( $v['description'] )
								? $v['description']
								// Translators: Add tag's name to make description
								: wp_kses( sprintf( esc_html__( 'Font settings of the "%s" tag.', 'nazareth' ), $tag ), 'nazareth_kses_content' ),
				'type'  => 'section',
			);

			foreach ( $v as $css_prop => $css_value ) {
				if ( in_array( $css_prop, array( 'title', 'description' ) ) ) {
					continue;
				}
				$options    = '';
				$type       = 'text';
				$load_order = 1;
				$title      = ucfirst( str_replace( '-', ' ', $css_prop ) );
				if ( 'font-family' == $css_prop ) {
					$type       = 'select';
					$options    = array();
					$load_order = 2;        // Load this option's value after all options are loaded (use option 'load_fonts' to build fonts list)
				} elseif ( 'font-weight' == $css_prop ) {
					$type    = 'select';
					$options = array(
						'inherit' => esc_html__( 'Inherit', 'nazareth' ),
						'100'     => esc_html__( '100 (Light)', 'nazareth' ),
						'200'     => esc_html__( '200 (Light)', 'nazareth' ),
						'300'     => esc_html__( '300 (Thin)', 'nazareth' ),
						'400'     => esc_html__( '400 (Normal)', 'nazareth' ),
						'500'     => esc_html__( '500 (Semibold)', 'nazareth' ),
						'600'     => esc_html__( '600 (Semibold)', 'nazareth' ),
						'700'     => esc_html__( '700 (Bold)', 'nazareth' ),
						'800'     => esc_html__( '800 (Black)', 'nazareth' ),
						'900'     => esc_html__( '900 (Black)', 'nazareth' ),
					);
				} elseif ( 'font-style' == $css_prop ) {
					$type    = 'select';
					$options = array(
						'inherit' => esc_html__( 'Inherit', 'nazareth' ),
						'normal'  => esc_html__( 'Normal', 'nazareth' ),
						'italic'  => esc_html__( 'Italic', 'nazareth' ),
					);
				} elseif ( 'text-decoration' == $css_prop ) {
					$type    = 'select';
					$options = array(
						'inherit'      => esc_html__( 'Inherit', 'nazareth' ),
						'none'         => esc_html__( 'None', 'nazareth' ),
						'underline'    => esc_html__( 'Underline', 'nazareth' ),
						'overline'     => esc_html__( 'Overline', 'nazareth' ),
						'line-through' => esc_html__( 'Line-through', 'nazareth' ),
					);
				} elseif ( 'text-transform' == $css_prop ) {
					$type    = 'select';
					$options = array(
						'inherit'    => esc_html__( 'Inherit', 'nazareth' ),
						'none'       => esc_html__( 'None', 'nazareth' ),
						'uppercase'  => esc_html__( 'Uppercase', 'nazareth' ),
						'lowercase'  => esc_html__( 'Lowercase', 'nazareth' ),
						'capitalize' => esc_html__( 'Capitalize', 'nazareth' ),
					);
				}
				$fonts[ "{$tag}_{$css_prop}" ] = array(
					'title'      => $title,
					'desc'       => '',
					'class'      => 'nazareth_column-1_5',
					'refresh'    => false,
					'load_order' => $load_order,
					'std'        => '$nazareth_get_theme_fonts_option',
					'options'    => $options,
					'type'       => $type,
				);
			}

			$fonts[ "{$tag}_section_end" ] = array(
				'type' => 'section_end',
			);
		}

		$fonts['fonts_end'] = array(
			'type' => 'panel_end',
		);

		// Add fonts parameters to Theme Options
		nazareth_storage_set_array_before( 'options', 'panel_colors', $fonts );

		// Add Header Video if WP version < 4.7
		// -----------------------------------------------------
		if ( ! function_exists( 'get_header_video_url' ) ) {
			nazareth_storage_set_array_after(
				'options', 'header_image_override', 'header_video', array(
					'title'    => esc_html__( 'Header video', 'nazareth' ),
					'desc'     => wp_kses_data( __( 'Select video to use it as background for the header', 'nazareth' ) ),
					'override' => array(
						'mode'    => 'page',
						'section' => esc_html__( 'Header', 'nazareth' ),
					),
					'std'      => '',
					'type'     => 'video',
				)
			);
		}

		// Add option 'logo' if WP version < 4.5
		// or 'custom_logo' if current page is not 'Customize'
		// ------------------------------------------------------
		if ( ! function_exists( 'the_custom_logo' ) || ! nazareth_check_current_url( 'customize.php' ) ) {
			nazareth_storage_set_array_before(
				'options', 'logo_retina', function_exists( 'the_custom_logo' ) ? 'custom_logo' : 'logo', array(
					'title'    => esc_html__( 'Logo', 'nazareth' ),
					'desc'     => wp_kses_data( __( 'Select or upload the site logo', 'nazareth' ) ),
					'class'    => 'nazareth_column-1_2 nazareth_new_row',
					'priority' => 60,
					'std'      => '',
					'qsetup'   => esc_html__( 'General', 'nazareth' ),
					'type'     => 'image',
				)
			);
		}

	}
}


// Returns a list of options that can be overridden for CPT
if ( ! function_exists( 'nazareth_options_get_list_cpt_options' ) ) {
	function nazareth_options_get_list_cpt_options( $cpt, $title = '' ) {
		if ( empty( $title ) ) {
			$title = ucfirst( $cpt );
		}
		return array(
			"content_info_{$cpt}"           => array(
				'title' => esc_html__( 'Content', 'nazareth' ),
				'desc'  => '',
				'type'  => 'info',
			),
			"body_style_{$cpt}"             => array(
				'title'    => esc_html__( 'Body style', 'nazareth' ),
				'desc'     => wp_kses_data( __( 'Select width of the body content', 'nazareth' ) ),
				'std'      => 'inherit',
				'options'  => nazareth_get_list_body_styles( true ),
				'type'     => 'select',
			),
			"boxed_bg_image_{$cpt}"         => array(
				'title'      => esc_html__( 'Boxed bg image', 'nazareth' ),
				'desc'       => wp_kses_data( __( 'Select or upload image, used as background in the boxed body', 'nazareth' ) ),
				'dependency' => array(
					"body_style_{$cpt}" => array( 'boxed' ),
				),
				'std'        => 'inherit',
				'type'       => 'image',
			),
			"header_info_{$cpt}"            => array(
				'title' => esc_html__( 'Header', 'nazareth' ),
				'desc'  => '',
				'type'  => 'info',
			),
			"header_type_{$cpt}"            => array(
				'title'   => esc_html__( 'Header style', 'nazareth' ),
				'desc'    => wp_kses_data( __( 'Choose whether to use the default header or header Layouts (available only if the ThemeREX Addons is activated)', 'nazareth' ) ),
				'std'     => 'inherit',
				'options' => nazareth_get_list_header_footer_types( true ),
				'type'    => NAZARETH_THEME_FREE ? 'hidden' : 'switch',
			),
			"header_style_{$cpt}"           => array(
				'title'      => esc_html__( 'Select custom layout', 'nazareth' ),
				// Translators: Add CPT name to the description
				'desc'       => wp_kses_data( sprintf( esc_html__( 'Select custom layout to display the site header on the %s pages', 'nazareth' ), $title ) ),
				'dependency' => array(
					"header_type_{$cpt}" => array( 'custom' ),
				),
				'std'        => 'inherit',
				'options'    => array(),
				'type'       => NAZARETH_THEME_FREE ? 'hidden' : 'select',
			),
			"header_position_{$cpt}"        => array(
				'title'   => esc_html__( 'Header position', 'nazareth' ),
				// Translators: Add CPT name to the description
				'desc'    => wp_kses_data( sprintf( esc_html__( 'Select position to display the site header on the %s pages', 'nazareth' ), $title ) ),
				'std'     => 'inherit',
				'options' => array(),
				'type'    => NAZARETH_THEME_FREE ? 'hidden' : 'switch',
			),
			"header_image_override_{$cpt}"  => array(
				'title'   => esc_html__( 'Header image override', 'nazareth' ),
				'desc'    => wp_kses_data( __( "Allow override the header image with the post's featured image", 'nazareth' ) ),
				'std'     => 'inherit',
				'options' => array(
					'inherit' => esc_html__( 'Inherit', 'nazareth' ),
					1         => esc_html__( 'Yes', 'nazareth' ),
					0         => esc_html__( 'No', 'nazareth' ),
				),
				'type'    => NAZARETH_THEME_FREE ? 'hidden' : 'switch',
			),

			"sidebar_info_{$cpt}"           => array(
				'title' => esc_html__( 'Sidebar', 'nazareth' ),
				'desc'  => '',
				'type'  => 'info',
			),
			"sidebar_position_{$cpt}"       => array(
				'title'   => sprintf( esc_html__( 'Sidebar position on the %s list', 'nazareth' ), $title ),
				// Translators: Add CPT name to the description
				'desc'    => wp_kses_data( sprintf( esc_html__( 'Select position to show sidebar on the %s list', 'nazareth' ), $title ) ),
				'std'     => 'left',
				'options' => array(),
				'type'    => 'switch',
			),
			"sidebar_position_mobile_{$cpt}"=> array(
				'title'    => sprintf( esc_html__( 'Sidebar position on the %s list on mobile', 'nazareth' ), $title ),
				'desc'     => wp_kses_data( __( 'Select position to show sidebar on mobile devices - above or below the content', 'nazareth' ) ),
				'std'      => 'below',
				'dependency' => array(
					"sidebar_position_{$cpt}" => array( '^hide' ),
				),
				'options'  => array(),
				'type'     => 'switch',
			),
			"sidebar_widgets_{$cpt}"        => array(
				'title'      => sprintf( esc_html__( 'Sidebar widgets on the %s list', 'nazareth' ), $title ),
				// Translators: Add CPT name to the description
				'desc'       => wp_kses_data( sprintf( esc_html__( 'Select sidebar to show on the %s list', 'nazareth' ), $title ) ),
				'dependency' => array(
					"sidebar_position_{$cpt}" => array( '^hide' ),
				),
				'std'        => 'hide',
				'options'    => array(),
				'type'       => 'select',
			),
			"sidebar_position_single_{$cpt}"       => array(
				'title'   => sprintf( esc_html__( 'Sidebar position on the single post', 'nazareth' ), $title ),
				// Translators: Add CPT name to the description
				'desc'    => wp_kses_data( sprintf( esc_html__( 'Select position to show sidebar on the single posts of the %s', 'nazareth' ), $title ) ),
				'std'     => 'left',
				'options' => array(),
				'type'    => 'switch',
			),
			"sidebar_position_mobile_single_{$cpt}"=> array(
				'title'    => esc_html__( 'Sidebar position on the single post on mobile', 'nazareth' ),
				'desc'     => wp_kses_data( __( 'Select position to show sidebar on mobile devices - above or below the content', 'nazareth' ) ),
				'dependency' => array(
					"sidebar_position_single_{$cpt}" => array( '^hide' ),
				),
				'std'      => 'below',
				'options'  => array(),
				'type'     => 'switch',
			),
			"sidebar_widgets_single_{$cpt}"        => array(
				'title'      => sprintf( esc_html__( 'Sidebar widgets on the single post', 'nazareth' ), $title ),
				// Translators: Add CPT name to the description
				'desc'       => wp_kses_data( sprintf( esc_html__( 'Select widgets to show in the sidebar on the single posts of the %s', 'nazareth' ), $title ) ),
				'dependency' => array(
					"sidebar_position_single_{$cpt}" => array( '^hide' ),
				),
				'std'        => 'hide',
				'options'    => array(),
				'type'       => 'select',
			),
			"expand_content_{$cpt}"         => array(
				'title'   => esc_html__( 'Expand content', 'nazareth' ),
				'desc'    => wp_kses_data( __( 'Expand the content width if the sidebar is hidden', 'nazareth' ) ),
				'refresh' => false,
				'std'     => 'inherit',
				'options' => array(
					'inherit' => esc_html__( 'Inherit', 'nazareth' ),
					1         => esc_html__( 'Expand', 'nazareth' ),
					0         => esc_html__( 'No', 'nazareth' ),
				),
				'type'    => 'switch',
			),

			"footer_info_{$cpt}"            => array(
				'title' => esc_html__( 'Footer', 'nazareth' ),
				'desc'  => '',
				'type'  => 'info',
			),
			"footer_type_{$cpt}"            => array(
				'title'   => esc_html__( 'Footer style', 'nazareth' ),
				'desc'    => wp_kses_data( __( 'Choose whether to use the default footer or footer Layouts (available only if the ThemeREX Addons is activated)', 'nazareth' ) ),
				'std'     => 'inherit',
				'options' => nazareth_get_list_header_footer_types( true ),
				'type'    => NAZARETH_THEME_FREE ? 'hidden' : 'switch',
			),
			"footer_style_{$cpt}"           => array(
				'title'      => esc_html__( 'Select custom layout', 'nazareth' ),
				'desc'       => wp_kses_data( __( 'Select custom layout to display the site footer', 'nazareth' ) ),
				'std'        => 'inherit',
				'dependency' => array(
					"footer_type_{$cpt}" => array( 'custom' ),
				),
				'options'    => array(),
				'type'       => NAZARETH_THEME_FREE ? 'hidden' : 'select',
			),
			"footer_widgets_{$cpt}"         => array(
				'title'      => esc_html__( 'Footer widgets', 'nazareth' ),
				'desc'       => wp_kses_data( __( 'Select set of widgets to show in the footer', 'nazareth' ) ),
				'dependency' => array(
					"footer_type_{$cpt}" => array( 'default' ),
				),
				'std'        => 'footer_widgets',
				'options'    => array(),
				'type'       => 'select',
			),
			"footer_columns_{$cpt}"         => array(
				'title'      => esc_html__( 'Footer columns', 'nazareth' ),
				'desc'       => wp_kses_data( __( 'Select number columns to show widgets in the footer. If 0 - autodetect by the widgets count', 'nazareth' ) ),
				'dependency' => array(
					"footer_type_{$cpt}"    => array( 'default' ),
					"footer_widgets_{$cpt}" => array( '^hide' ),
				),
				'std'        => 0,
				'options'    => nazareth_get_list_range( 0, 6 ),
				'type'       => 'select',
			),
			"footer_wide_{$cpt}"            => array(
				'title'      => esc_html__( 'Footer fullwidth', 'nazareth' ),
				'desc'       => wp_kses_data( __( 'Do you want to stretch the footer to the entire window width?', 'nazareth' ) ),
				'dependency' => array(
					"footer_type_{$cpt}" => array( 'default' ),
				),
				'std'        => 0,
				'type'       => 'checkbox',
			),
		);
	}
}


// Return lists with choises when its need in the admin mode
if ( ! function_exists( 'nazareth_options_get_list_choises' ) ) {
	add_filter( 'nazareth_filter_options_get_list_choises', 'nazareth_options_get_list_choises', 10, 2 );
	function nazareth_options_get_list_choises( $list, $id ) {
		if ( is_array( $list ) && count( $list ) == 0 ) {
			if ( strpos( $id, 'header_style' ) === 0 ) {
				$list = nazareth_get_list_header_styles( strpos( $id, 'header_style_' ) === 0 );
			} elseif ( strpos( $id, 'header_position' ) === 0 ) {
				$list = nazareth_get_list_header_positions( strpos( $id, 'header_position_' ) === 0 );
			} elseif ( strpos( $id, 'header_widgets' ) === 0 ) {
				$list = nazareth_get_list_sidebars( strpos( $id, 'header_widgets_' ) === 0, true );
			} elseif ( strpos( $id, '_scheme' ) > 0 ) {
				$list = nazareth_get_list_schemes( 'color_scheme' != $id );
			} elseif ( strpos( $id, 'sidebar_widgets' ) === 0 ) {
				$list = nazareth_get_list_sidebars( 'sidebar_widgets_single' != $id && ( strpos( $id, 'sidebar_widgets_' ) === 0 || strpos( $id, 'sidebar_widgets_single_' ) === 0 ), true );
			} elseif ( strpos( $id, 'sidebar_position_mobile' ) === 0 ) {
				$list = nazareth_get_list_sidebars_positions_mobile( strpos( $id, 'sidebar_position_mobile_' ) === 0 );
			} elseif ( strpos( $id, 'sidebar_position' ) === 0 ) {
				$list = nazareth_get_list_sidebars_positions( strpos( $id, 'sidebar_position_' ) === 0 );
			} elseif ( strpos( $id, 'widgets_above_page' ) === 0 ) {
				$list = nazareth_get_list_sidebars( strpos( $id, 'widgets_above_page_' ) === 0, true );
			} elseif ( strpos( $id, 'widgets_above_content' ) === 0 ) {
				$list = nazareth_get_list_sidebars( strpos( $id, 'widgets_above_content_' ) === 0, true );
			} elseif ( strpos( $id, 'widgets_below_page' ) === 0 ) {
				$list = nazareth_get_list_sidebars( strpos( $id, 'widgets_below_page_' ) === 0, true );
			} elseif ( strpos( $id, 'widgets_below_content' ) === 0 ) {
				$list = nazareth_get_list_sidebars( strpos( $id, 'widgets_below_content_' ) === 0, true );
			} elseif ( strpos( $id, 'footer_style' ) === 0 ) {
				$list = nazareth_get_list_footer_styles( strpos( $id, 'footer_style_' ) === 0 );
			} elseif ( strpos( $id, 'footer_widgets' ) === 0 ) {
				$list = nazareth_get_list_sidebars( strpos( $id, 'footer_widgets_' ) === 0, true );
			} elseif ( strpos( $id, 'blog_style' ) === 0 ) {
				$list = nazareth_get_list_blog_styles( strpos( $id, 'blog_style_' ) === 0 );
			} elseif ( strpos( $id, 'post_type' ) === 0 ) {
				$list = nazareth_get_list_posts_types();
			} elseif ( strpos( $id, 'parent_cat' ) === 0 ) {
				$list = nazareth_array_merge( array( 0 => esc_html__( '- Select category -', 'nazareth' ) ), nazareth_get_list_categories() );
			} elseif ( strpos( $id, 'blog_animation' ) === 0 ) {
				$list = nazareth_get_list_animations_in();
			} elseif ( 'color_scheme_editor' == $id ) {
				$list = nazareth_get_list_schemes();
			} elseif ( strpos( $id, '_font-family' ) > 0 ) {
				$list = nazareth_get_list_load_fonts( true );
			}
		}
		return $list;
	}
}