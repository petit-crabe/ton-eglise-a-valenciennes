<?php
/**
 * The Sticky template to display the sticky posts
 *
 * Used for index/archive
 *
 * @package WordPress
 * @subpackage NAZARETH
 * @since NAZARETH 1.0
 */

$nazareth_columns     = max( 1, min( 3, count( get_option( 'sticky_posts' ) ) ) );
$nazareth_post_format = get_post_format();
$nazareth_post_format = empty( $nazareth_post_format ) ? 'standard' : str_replace( 'post-format-', '', $nazareth_post_format );
$nazareth_animation   = nazareth_get_theme_option( 'blog_animation' );

?><div class="column-1_<?php echo esc_attr( $nazareth_columns ); ?>"><article id="post-<?php the_ID(); ?>" 
	<?php post_class( 'post_item post_layout_sticky post_format_' . esc_attr( $nazareth_post_format ) ); ?>
	<?php echo ( ! nazareth_is_off( $nazareth_animation ) ? ' data-animation="' . esc_attr( nazareth_get_animation_classes( $nazareth_animation ) ) . '"' : '' ); ?>
	>

	<?php
	if ( is_sticky() && is_home() && ! is_paged() ) {
		?>
		<span class="post_label label_sticky"></span>
		<?php
	}

	// Featured image
	nazareth_show_post_featured(
		array(
			'thumb_size' => nazareth_get_thumb_size( 1 == $nazareth_columns ? 'big' : ( 2 == $nazareth_columns ? 'med' : 'avatar' ) ),
		)
	);

	if ( ! in_array( $nazareth_post_format, array( 'link', 'aside', 'status', 'quote' ) ) ) {
		?>
		<div class="post_header entry-header">
			<?php
			// Post title
			the_title( sprintf( '<h6 class="post_title entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h6>' );
			// Post meta
			nazareth_show_post_meta( apply_filters( 'nazareth_filter_post_meta_args', array(), 'sticky', $nazareth_columns ) );
			?>
		</div><!-- .entry-header -->
		<?php
	}
	?>
</article></div><?php

// div.column-1_X is a inline-block and new lines and spaces after it are forbidden
