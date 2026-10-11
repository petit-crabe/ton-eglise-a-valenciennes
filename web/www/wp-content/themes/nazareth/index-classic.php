<?php
/**
 * The template for homepage posts with "Classic" style
 *
 * @package WordPress
 * @subpackage NAZARETH
 * @since NAZARETH 1.0
 */

nazareth_storage_set( 'blog_archive', true );

get_header();

if ( have_posts() ) {

	nazareth_blog_archive_start();

	$nazareth_classes    = 'posts_container '
						. ( substr( nazareth_get_theme_option( 'blog_style' ), 0, 7 ) == 'classic'
							? 'columns_wrap columns_padding_bottom'
							: 'masonry_wrap'
							);
	$nazareth_stickies   = is_home() ? get_option( 'sticky_posts' ) : false;
	$nazareth_sticky_out = nazareth_get_theme_option( 'sticky_style' ) == 'columns'
							&& is_array( $nazareth_stickies ) && count( $nazareth_stickies ) > 0 && get_query_var( 'paged' ) < 1;
	if ( $nazareth_sticky_out ) {
		?>
		<div class="sticky_wrap columns_wrap">
		<?php
	}
	if ( ! $nazareth_sticky_out ) {
		if ( nazareth_get_theme_option( 'first_post_large' ) && ! is_paged() && ! in_array( nazareth_get_theme_option( 'body_style' ), array( 'fullwide', 'fullscreen' ) ) ) {
			the_post();
			get_template_part( apply_filters( 'nazareth_filter_get_template_part', 'content', 'excerpt' ), 'excerpt' );
		}

		?>
		<div class="<?php echo esc_attr( $nazareth_classes ); ?>">
		<?php
	}
	while ( have_posts() ) {
		the_post();
		if ( $nazareth_sticky_out && ! is_sticky() ) {
			$nazareth_sticky_out = false;
			?>
			</div><div class="<?php echo esc_attr( $nazareth_classes ); ?>">
			<?php
		}
		$nazareth_part = $nazareth_sticky_out && is_sticky() ? 'sticky' : 'classic';
		get_template_part( apply_filters( 'nazareth_filter_get_template_part', 'content', $nazareth_part ), $nazareth_part );
	}

	?>
	</div>
	<?php

	nazareth_show_pagination();

	nazareth_blog_archive_end();

} else {

	if ( is_search() ) {
		get_template_part( apply_filters( 'nazareth_filter_get_template_part', 'content', 'none-search' ), 'none-search' );
	} else {
		get_template_part( apply_filters( 'nazareth_filter_get_template_part', 'content', 'none-archive' ), 'none-archive' );
	}
}

get_footer();
