<?php
/**
 * The template to display the Structured Data Snippets
 *
 * @package WordPress
 * @subpackage NAZARETH
 * @since NAZARETH 1.0.30
 */

// Structured data snippets
if ( nazareth_is_on( nazareth_get_theme_option( 'seo_snippets' ) ) ) {
	?>
	<div class="structured_data_snippets">
		<meta itemprop="headline" content="<?php the_title_attribute(); ?>">
		<meta itemprop="datePublished" content="<?php echo esc_attr( get_the_date( 'Y-m-d' ) ); ?>">
		<meta itemprop="dateModified" content="<?php echo esc_attr( get_the_modified_date( 'Y-m-d' ) ); ?>">
		<div itemscope itemprop="publisher" itemtype="https://schema.org/Organization">
			<meta itemprop="name" content="<?php echo esc_attr( get_bloginfo( 'name' ) ); ?>">
			<meta itemprop="telephone" content="">
			<meta itemprop="address" content="">
			<?php
			$nazareth_logo_image = nazareth_get_logo_image();
			if ( ! empty( $nazareth_logo_image ) ) {
				?>
				<meta itemprop="logo" itemtype="//schema.org/ImageObject" content="<?php echo esc_url( $nazareth_logo_image ); ?>">
				<?php
			}
			?>
		</div>
		<?php
		if ( nazareth_get_theme_option( 'show_author_info' ) != 1 || ! is_single() || is_attachment() || ! get_the_author_meta( 'description' ) ) { 
			?>
			<div itemscope itemprop="author" itemtype="//schema.org/Person">
				<meta itemprop="name" content="<?php echo esc_attr( get_the_author() ); ?>">
			</div>
			<?php
		}
		?>
	</div>
	<?php
}
