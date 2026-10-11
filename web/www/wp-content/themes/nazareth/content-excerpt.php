<?php
/**
 * The default template to display the content
 *
 * Used for index/archive/search.
 *
 * @package WordPress
 * @subpackage NAZARETH
 * @since NAZARETH 1.0
 */

$nazareth_template_args = get_query_var( 'nazareth_template_args' );
if ( is_array( $nazareth_template_args ) ) {
	$nazareth_columns    = empty( $nazareth_template_args['columns'] ) ? 2 : max( 1, $nazareth_template_args['columns'] );
	$nazareth_blog_style = array( $nazareth_template_args['type'], $nazareth_columns );
	if ( ! empty( $nazareth_template_args['slider'] ) ) {
		?><div class="slider-slide swiper-slide">
		<?php
	} elseif ( $nazareth_columns > 1 ) {
		?>
		<div class="column-1_<?php echo esc_attr( $nazareth_columns ); ?>">
		<?php
	}
}
$nazareth_link        = get_permalink();
$nazareth_expanded    = ! nazareth_sidebar_present() && nazareth_is_on( nazareth_get_theme_option( 'expand_content' ) );
$nazareth_post_format = get_post_format();
$nazareth_post_format = empty( $nazareth_post_format ) ? 'standard' : str_replace( 'post-format-', '', $nazareth_post_format );
$nazareth_animation   = nazareth_get_theme_option( 'blog_animation' );
$nazareth_components = nazareth_array_get_keys_by_value( nazareth_get_theme_option( 'meta_parts' ) );
$nazareth_counters   = nazareth_array_get_keys_by_value( nazareth_get_theme_option( 'counters' ) );

$nazareth_blogger_post_type = get_post_type();

$nazareth_blogger_components = explode(',', $nazareth_components);
$post_meta_top = [];
$post_meta_bottom = [];
if ( $nazareth_blogger_components ) {
	foreach( $nazareth_blogger_components as $post_meta_item ) {
		if ( 'meta_parts' == $post_meta_item || 'date' == $post_meta_item  )
			$post_meta_top[] = $post_meta_item;
		else
			$post_meta_bottom[] = $post_meta_item;
	}
}
$post_meta_top = implode(',', $post_meta_top);
$post_meta_bottom = implode(',', $post_meta_bottom);

?>
<article id="post-<?php the_ID(); ?>" 
	<?php post_class( 'post_item post_layout_excerpt post_format_' . esc_attr( $nazareth_post_format ) ); ?>
	<?php echo ( ! nazareth_is_off( $nazareth_animation ) && empty( $nazareth_template_args['slider'] ) ? ' data-animation="' . esc_attr( nazareth_get_animation_classes( $nazareth_animation ) ) . '"' : '' ); ?>
	>
	<?php

	// Sticky label
	if ( is_sticky() && ! is_paged() ) {
		?>
		<span class="post_label label_sticky"></span>
		<?php
	}

	// Featured image
	$nazareth_hover = ! empty( $nazareth_template_args['hover'] ) && ! nazareth_is_inherit( $nazareth_template_args['hover'] )
						? $nazareth_template_args['hover']
						: nazareth_get_theme_option( 'image_hover' );
	nazareth_show_post_featured(
		array(
			'singular'   => false,
			'no_links'   => ! empty( $nazareth_template_args['no_links'] ),
			'hover'      => $nazareth_hover,
			'thumb_size' => nazareth_get_thumb_size( strpos( nazareth_get_theme_option( 'body_style' ), 'full' ) !== false ? 'full' : ( $nazareth_expanded ? 'huge' : 'big' ) ),
		)
	);
	?>
		<!-- .nazareth_post_info_container -->
		<div class="nazareth_post_info_container">
		<?php
		do_action( 'nazareth_action_before_post_meta' );

		// Post meta
		if ( 'tribe_events' == $nazareth_blogger_post_type ) {
				// Return date of the current event
				$dt = tribe_events_event_schedule_details( get_the_ID(), '', '' );
				?>

				<div class="post_meta">
					<span class="post_meta_item post_date"><?php wp_kses( $dt, 'nazareth_kses_content' ); ?></span>
				</div>	
				<?php
		} else {
				if (in_array('date',explode(',', $post_meta_top))) {
					$date1 = get_the_date( 'j', get_the_ID());
					$date2 = get_the_date( 'M', get_the_ID());
					?>
					<div class="post_meta_custom">
						<div class="post_meta_day">
							<a href="<?php echo esc_url( $nazareth_link ); ?>">
								<?php echo esc_html($date1); ?>									
							</a>
						</div>
						<div class="post_meta_month">
							<?php echo esc_html($date2); ?>							
						</div>
					</div>
				<?php
				}
				if ( ! empty( $post_meta_bottom ) && ! in_array( $nazareth_hover, array( 'border', 'pull', 'slide', 'fade' ) ) ) {
					nazareth_show_post_meta(
						apply_filters(
							'nazareth_filter_post_meta_args', array(
								'components' => $post_meta_bottom,
								'counters'   => $nazareth_counters,
								'seo'        => false,
							), $nazareth_blog_style[0], $nazareth_columns
						)
					);
				}
		}
		// Title
		if ( get_the_title() != '' ) {
			?>
			<div class="post_header entry-header">
				<?php
				do_action( 'nazareth_action_before_post_title' );

				// Post title
				if ( empty( $nazareth_template_args['no_links'] ) ) {
					the_title( sprintf( '<h2 class="post_title entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h2>' );
				} else {
					the_title( '<h2 class="post_title entry-title">', '</h2>' );
				}
				?>
			</div><!-- .post_header -->
			<?php
		}

		// Post content
		if ( empty( $nazareth_template_args['hide_excerpt'] ) ) {

			?>
			<div class="post_content entry-content">
			<?php
			if ( nazareth_get_theme_option( 'blog_content' ) == 'fullpost' ) {
				// Post content area
				?>
					<div class="post_content_inner">
					<?php
					the_content( '' );
					?>
					</div>
					<?php
					// Inner pages
					wp_link_pages(
						array(
							'before'      => '<div class="page_links"><span class="page_links_title">' . esc_html__( 'Pages:', 'nazareth' ) . '</span>',
							'after'       => '</div>',
							'link_before' => '<span>',
							'link_after'  => '</span>',
							'pagelink'    => '<span class="screen-reader-text">' . esc_html__( 'Page', 'nazareth' ) . ' </span>%',
							'separator'   => '<span class="screen-reader-text">, </span>',
						)
					);
			} else {
				// Post content area
				?>
					<div class="post_content_inner">
					<?php
					if ( has_excerpt() ) {
							the_excerpt();
					} elseif ( strpos( get_the_content( '!--more' ), '!--more' ) !== false ) {
							the_content( '' );
					} elseif ( in_array( $nazareth_post_format, array( 'link', 'aside', 'status' ) ) ) {
							the_content();
					} elseif ( 'quote' == $nazareth_post_format ) {
						$quote = nazareth_get_tag( get_the_content(), '<blockquote>', '</blockquote>' );
						if ( ! empty( $quote ) ) {
							nazareth_show_layout( wpautop( $quote ) );
						} else {
							the_excerpt();
						}
					} elseif ( 'audio' == $nazareth_post_format ) {
						
					} elseif ( substr( get_the_content(), 0, 4 ) != '[vc_' ) {
						the_excerpt();
					}
					?>
					</div>
					<?php
					// More button
					if ( empty( $nazareth_template_args['no_links'] ) && ! in_array( $nazareth_post_format, array( 'link', 'aside', 'status', 'quote', 'audio' ) ) ) {
						?>
						<p><a class="nazareth_button" href="<?php echo esc_url( get_permalink() ); ?>"><?php esc_html_e( 'Read More', 'nazareth' ); ?></a></p>
						<?php
					}
			}
			?>
			</div><!-- .entry-content -->
			<?php
		}
		?>
		</div>
		<!-- end of .nazareth_post_info_container -->
	</article>
<?php

if ( is_array( $nazareth_template_args ) ) {
	if ( ! empty( $nazareth_template_args['slider'] ) || $nazareth_columns > 1 ) {
		?>
		</div>
		<?php
	}
}
