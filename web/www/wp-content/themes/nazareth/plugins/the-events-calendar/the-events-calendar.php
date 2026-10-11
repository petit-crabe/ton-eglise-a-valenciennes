<?php
/* Tribe Events Calendar support functions
------------------------------------------------------------------------------- */

// Theme init priorities:
// 1 - register filters, that add/remove lists items for the Theme Options
if ( ! function_exists( 'nazareth_tribe_events_theme_setup1' ) ) {
	add_action( 'after_setup_theme', 'nazareth_tribe_events_theme_setup1', 1 );
	function nazareth_tribe_events_theme_setup1() {
		add_filter( 'nazareth_filter_list_sidebars', 'nazareth_tribe_events_list_sidebars' );
	}
}

// Theme init priorities:
// 3 - add/remove Theme Options elements
if ( ! function_exists( 'nazareth_tribe_events_theme_setup3' ) ) {
	add_action( 'after_setup_theme', 'nazareth_tribe_events_theme_setup3', 3 );
	function nazareth_tribe_events_theme_setup3() {
		if ( nazareth_exists_tribe_events() ) {

			// Section 'Tribe Events'
			nazareth_storage_merge_array(
				'options', '', array_merge(
					array(
						'events' => array(
							'title' => esc_html__( 'Events', 'nazareth' ),
							'desc'  => wp_kses_data( __( 'Select parameters to display the events pages', 'nazareth' ) ),
							'type'  => 'section',
						),
					),
					nazareth_options_get_list_cpt_options( 'events' )
				)
			);
		}
	}
}

// Theme init priorities:
// 9 - register other filters (for installer, etc.)
if ( ! function_exists( 'nazareth_tribe_events_theme_setup9' ) ) {
	add_action( 'after_setup_theme', 'nazareth_tribe_events_theme_setup9', 9 );
	function nazareth_tribe_events_theme_setup9() {

		add_filter( 'nazareth_filter_merge_styles', 'nazareth_tribe_events_merge_styles' );
		add_filter( 'nazareth_filter_merge_styles_responsive', 'nazareth_tribe_events_merge_styles_responsive' );

		if ( nazareth_exists_tribe_events() ) {
			add_filter( 'nazareth_filter_post_type_taxonomy', 'nazareth_tribe_events_post_type_taxonomy', 10, 2 );
			if ( ! is_admin() ) {
				add_filter( 'nazareth_filter_detect_blog_mode', 'nazareth_tribe_events_detect_blog_mode' );
				add_filter( 'nazareth_filter_get_post_categories', 'nazareth_tribe_events_get_post_categories' );
				add_filter( 'nazareth_filter_get_post_date', 'nazareth_tribe_events_get_post_date' );
			}
		}
		if ( is_admin() ) {
			add_filter( 'nazareth_filter_tgmpa_required_plugins', 'nazareth_tribe_events_tgmpa_required_plugins' );
		}

	}
}

// Filter to add in the required plugins list
if ( ! function_exists( 'nazareth_tribe_events_tgmpa_required_plugins' ) ) {
	
	function nazareth_tribe_events_tgmpa_required_plugins( $list = array() ) {
		if ( nazareth_storage_isset( 'required_plugins', 'the-events-calendar' ) ) {
			$list[] = array(
				'name'     => nazareth_storage_get_array( 'required_plugins', 'the-events-calendar' ),
				'slug'     => 'the-events-calendar',
				'required' => false,
			);
		}
		return $list;
	}
}


// Remove 'Tribe Events' section from Customizer
if ( ! function_exists( 'nazareth_tribe_events_customizer_register_controls' ) ) {
	add_action( 'customize_register', 'nazareth_tribe_events_customizer_register_controls', 100 );
	function nazareth_tribe_events_customizer_register_controls( $wp_customize ) {
		$wp_customize->remove_panel( 'tribe_customizer' );
	}
}


// Check if Tribe Events is installed and activated
if ( ! function_exists( 'nazareth_exists_tribe_events' ) ) {
	function nazareth_exists_tribe_events() {
		return class_exists( 'Tribe__Events__Main' );
	}
}

// Return true, if current page is any tribe_events page
if ( ! function_exists( 'nazareth_is_tribe_events_page' ) ) {
	function nazareth_is_tribe_events_page() {
		$rez = false;
		if ( nazareth_exists_tribe_events() ) {
			if ( ! is_search() ) {
				$rez = tribe_is_event() || tribe_is_event_query() || tribe_is_event_category() || tribe_is_event_venue() || tribe_is_event_organizer();
			}
		}
		return $rez;
	}
}

// Detect current blog mode
if ( ! function_exists( 'nazareth_tribe_events_detect_blog_mode' ) ) {
	
	function nazareth_tribe_events_detect_blog_mode( $mode = '' ) {
		if ( nazareth_is_tribe_events_page() ) {
			$mode = 'events';
		}
		return $mode;
	}
}

// Return taxonomy for current post type
if ( ! function_exists( 'nazareth_tribe_events_post_type_taxonomy' ) ) {
	
	function nazareth_tribe_events_post_type_taxonomy( $tax = '', $post_type = '' ) {
		if ( nazareth_exists_tribe_events() && Tribe__Events__Main::POSTTYPE == $post_type ) {
			$tax = Tribe__Events__Main::TAXONOMY;
		}
		return $tax;
	}
}

// Show categories of the current event
if ( ! function_exists( 'nazareth_tribe_events_get_post_categories' ) ) {
	
	function nazareth_tribe_events_get_post_categories( $cats = '' ) {
		if ( get_post_type() == Tribe__Events__Main::POSTTYPE ) {
			$cats = nazareth_get_post_terms( ', ', get_the_ID(), Tribe__Events__Main::TAXONOMY );
		}
		return $cats;
	}
}

// Return date of the current event
if ( ! function_exists( 'nazareth_tribe_events_get_post_date' ) ) {
	
	function nazareth_tribe_events_get_post_date( $dt = '' ) {
		if ( get_post_type() == Tribe__Events__Main::POSTTYPE ) {
			$dt = tribe_events_event_schedule_details( get_the_ID(), '', '' );
		}
		return $dt;
	}
}

// Merge custom styles
if ( ! function_exists( 'nazareth_tribe_events_merge_styles' ) ) {
	
	function nazareth_tribe_events_merge_styles( $list ) {
		if ( nazareth_exists_tribe_events() ) {
			$list[] = 'plugins/the-events-calendar/_the-events-calendar.scss';
		}
		return $list;
	}
}


// Merge responsive styles
if ( ! function_exists( 'nazareth_tribe_events_merge_styles_responsive' ) ) {
	
	function nazareth_tribe_events_merge_styles_responsive( $list ) {
		if ( nazareth_exists_tribe_events() ) {
			$list[] = 'plugins/the-events-calendar/_the-events-calendar-responsive.scss';
		}
		return $list;
	}
}



// Add Tribe Events specific items into lists
//------------------------------------------------------------------------

// Add sidebar
if ( ! function_exists( 'nazareth_tribe_events_list_sidebars' ) ) {
	
	function nazareth_tribe_events_list_sidebars( $list = array() ) {
		$list['tribe_events_widgets'] = array(
			'name'        => esc_html__( 'Tribe Events Widgets', 'nazareth' ),
			'description' => esc_html__( 'Widgets to be shown on the Tribe Events pages', 'nazareth' ),
		);
		return $list;
	}
}

// Plural
if ( ! function_exists( 'nazareth_event_display_name_plural' ) ) {
	add_filter( 'tribe_event_label_plural', 'nazareth_event_display_name_plural' );
	function nazareth_event_display_name_plural() {
		return esc_html__('Tribe Events', 'nazareth');
	}
}

// Add plugin-specific colors and fonts to the custom CSS
if ( nazareth_exists_tribe_events() ) {
	require_once NAZARETH_THEME_DIR . 'plugins/the-events-calendar/the-events-calendar-styles.php'; 
}