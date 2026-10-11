<?php
/**
 * The template 'Style 2' to displaying related posts
 *
 * @package WordPress
 * @subpackage NAZARETH
 * @since NAZARETH 1.0
 */

$nazareth_link        = get_permalink();
$nazareth_post_format = get_post_format();
$nazareth_post_format = empty( $nazareth_post_format ) ? 'standard' : str_replace( 'post-format-', '', $nazareth_post_format );
$nazareth_components = nazareth_array_get_keys_by_value( nazareth_get_theme_option( 'meta_parts' ) );
?><div id="post-<?php the_ID(); ?>" 
	<?php post_class( 'related_item related_item_style_2 post_format_' . esc_attr( $nazareth_post_format ) ); ?>>
						<?php
						nazareth_show_post_featured(
							array(
								'thumb_size'    => apply_filters( 'nazareth_filter_related_thumb_size', nazareth_get_thumb_size( (int) nazareth_get_theme_option( 'related_posts' ) == 1 ? 'huge' : 'big' ) ),
								'show_no_image' => nazareth_get_theme_setting( 'allow_no_image' ),
								'singular'      => false,
							)
						);
						?>
	<div class="post_header entry-header">
	<?php
	if (in_array('date',explode(',', $nazareth_components))) {
			$date1 = get_the_date( 'j', get_the_ID());
			$date2 = get_the_date( 'M', get_the_ID());
			?><div class="post_meta_related"><a href="<?php echo esc_url( $nazareth_link ); ?>"><div class="post_meta_day"><?php echo esc_html($date1); ?></a></div>
			<div class="post_meta_month"><?php echo esc_html($date2); ?></div></div><?php
	}
	?>
		<h6 class="post_title entry-title"><a href="<?php echo esc_url( $nazareth_link ); ?>"><?php the_title(); ?></a></h6>
	</div>
</div>
