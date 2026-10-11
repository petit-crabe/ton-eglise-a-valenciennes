<?php
/**
 * The template for homepage posts with custom style
 *
 * @package WordPress
 * @subpackage NAZARETH
 * @since NAZARETH 1.0.50
 */

nazareth_storage_set( 'blog_archive', true );

get_header();

if ( have_posts() ) {

	$nazareth_blog_style = nazareth_get_theme_option( 'blog_style' );
	$nazareth_parts      = explode( '_', $nazareth_blog_style );
	$nazareth_columns    = ! empty( $nazareth_parts[1] ) ? max( 1, min( 6, (int) $nazareth_parts[1] ) ) : 1;
	$nazareth_blog_id    = nazareth_get_custom_blog_id( $nazareth_blog_style );
	$nazareth_blog_meta  = nazareth_get_custom_layout_meta( $nazareth_blog_id );
	if ( ! empty( $nazareth_blog_meta['margin'] ) ) {
		nazareth_add_inline_css( sprintf( '.page_content_wrap{padding-top:%s}', esc_attr( nazareth_prepare_css_value( $nazareth_blog_meta['margin'] ) ) ) );
	}
	$nazareth_custom_style = ! empty( $nazareth_blog_meta['scripts_required'] ) ? $nazareth_blog_meta['scripts_required'] : 'none';

	nazareth_blog_archive_start();

	$nazareth_classes    = 'posts_container blog_custom_wrap' 
							. ( ! nazareth_is_off( $nazareth_custom_style )
								? sprintf( ' %s_wrap', $nazareth_custom_style )
								: ( $nazareth_columns > 1 
									? ' columns_wrap columns_padding_bottom' 
									: ''
									)
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
		$nazareth_part = $nazareth_sticky_out && is_sticky() ? 'sticky' : 'custom';
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
