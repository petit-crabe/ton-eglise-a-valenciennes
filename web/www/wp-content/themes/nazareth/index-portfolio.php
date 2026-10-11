<?php
/**
 * The template for homepage posts with "Portfolio" style
 *
 * @package WordPress
 * @subpackage NAZARETH
 * @since NAZARETH 1.0
 */

nazareth_storage_set( 'blog_archive', true );

get_header();

if ( have_posts() ) {

	nazareth_blog_archive_start();

	$nazareth_stickies   = is_home() ? get_option( 'sticky_posts' ) : false;
	$nazareth_sticky_out = nazareth_get_theme_option( 'sticky_style' ) == 'columns'
							&& is_array( $nazareth_stickies ) && count( $nazareth_stickies ) > 0 && get_query_var( 'paged' ) < 1;

	// Show filters
	$nazareth_cat          = nazareth_get_theme_option( 'parent_cat' );
	$nazareth_post_type    = nazareth_get_theme_option( 'post_type' );
	$nazareth_taxonomy     = nazareth_get_post_type_taxonomy( $nazareth_post_type );
	$nazareth_show_filters = nazareth_get_theme_option( 'show_filters' );
	$nazareth_tabs         = array();
	if ( ! nazareth_is_off( $nazareth_show_filters ) ) {
		$nazareth_args           = array(
			'type'         => $nazareth_post_type,
			'child_of'     => $nazareth_cat,
			'orderby'      => 'name',
			'order'        => 'ASC',
			'hide_empty'   => 1,
			'hierarchical' => 0,
			'taxonomy'     => $nazareth_taxonomy,
			'pad_counts'   => false,
		);
		$nazareth_portfolio_list = get_terms( $nazareth_args );
		if ( is_array( $nazareth_portfolio_list ) && count( $nazareth_portfolio_list ) > 0 ) {
			$nazareth_tabs[ $nazareth_cat ] = esc_html__( 'All', 'nazareth' );
			foreach ( $nazareth_portfolio_list as $nazareth_term ) {
				if ( isset( $nazareth_term->term_id ) ) {
					$nazareth_tabs[ $nazareth_term->term_id ] = $nazareth_term->name;
				}
			}
		}
	}
	if ( count( $nazareth_tabs ) > 0 ) {
		$nazareth_portfolio_filters_ajax   = true;
		$nazareth_portfolio_filters_active = $nazareth_cat;
		$nazareth_portfolio_filters_id     = 'portfolio_filters';
		?>
		<div class="portfolio_filters nazareth_tabs nazareth_tabs_ajax">
			<ul class="portfolio_titles nazareth_tabs_titles">
				<?php
				foreach ( $nazareth_tabs as $nazareth_id => $nazareth_title ) {
					?>
					<li><a href="<?php echo esc_url( nazareth_get_hash_link( sprintf( '#%s_%s_content', $nazareth_portfolio_filters_id, $nazareth_id ) ) ); ?>" data-tab="<?php echo esc_attr( $nazareth_id ); ?>"><?php echo esc_html( $nazareth_title ); ?></a></li>
					<?php
				}
				?>
			</ul>
			<?php
			$nazareth_ppp = nazareth_get_theme_option( 'posts_per_page' );
			if ( nazareth_is_inherit( $nazareth_ppp ) ) {
				$nazareth_ppp = '';
			}
			foreach ( $nazareth_tabs as $nazareth_id => $nazareth_title ) {
				$nazareth_portfolio_need_content = $nazareth_id == $nazareth_portfolio_filters_active || ! $nazareth_portfolio_filters_ajax;
				?>
				<div id="<?php echo esc_attr( sprintf( '%s_%s_content', $nazareth_portfolio_filters_id, $nazareth_id ) ); ?>"
					class="portfolio_content nazareth_tabs_content"
					data-blog-template="<?php echo esc_attr( nazareth_storage_get( 'blog_template' ) ); ?>"
					data-blog-style="<?php echo esc_attr( nazareth_get_theme_option( 'blog_style' ) ); ?>"
					data-posts-per-page="<?php echo esc_attr( $nazareth_ppp ); ?>"
					data-post-type="<?php echo esc_attr( $nazareth_post_type ); ?>"
					data-taxonomy="<?php echo esc_attr( $nazareth_taxonomy ); ?>"
					data-cat="<?php echo esc_attr( $nazareth_id ); ?>"
					data-parent-cat="<?php echo esc_attr( $nazareth_cat ); ?>"
					data-need-content="<?php echo ( false === $nazareth_portfolio_need_content ? 'true' : 'false' ); ?>"
				>
					<?php
					if ( $nazareth_portfolio_need_content ) {
						nazareth_show_portfolio_posts(
							array(
								'cat'        => $nazareth_id,
								'parent_cat' => $nazareth_cat,
								'taxonomy'   => $nazareth_taxonomy,
								'post_type'  => $nazareth_post_type,
								'page'       => 1,
								'sticky'     => $nazareth_sticky_out,
							)
						);
					}
					?>
				</div>
				<?php
			}
			?>
		</div>
		<?php
	} else {
		nazareth_show_portfolio_posts(
			array(
				'cat'        => $nazareth_cat,
				'parent_cat' => $nazareth_cat,
				'taxonomy'   => $nazareth_taxonomy,
				'post_type'  => $nazareth_post_type,
				'page'       => 1,
				'sticky'     => $nazareth_sticky_out,
			)
		);
	}

	nazareth_blog_archive_end();

} else {

	if ( is_search() ) {
		get_template_part( apply_filters( 'nazareth_filter_get_template_part', 'content', 'none-search' ), 'none-search' );
	} else {
		get_template_part( apply_filters( 'nazareth_filter_get_template_part', 'content', 'none-archive' ), 'none-archive' );
	}
}

get_footer();
