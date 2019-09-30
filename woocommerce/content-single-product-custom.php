<?php
/**
 * The template for displaying product content in the single-product.php template
 *
 * Override this template by copying it to yourtheme/woocommerce/content-single-product.php
 *
 * @author        WooThemes
 * @package       WooCommerce/Templates
 * @version       3.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

?>
<div class="container">
	<?php
	/**
	 * Hook Woocommerce_before_single_product.
	 *
	 * @hooked wc_print_notices - 10
	 */
	do_action( 'woocommerce_before_single_product' );
	if ( post_password_required() ) {
		echo get_the_password_form(); // WPCS: XSS ok.

		return;
	}
	?>
</div><!-- /.container -->
<div id="product-<?php the_ID(); ?>" <?php post_class(); ?>>

	<div class="custom-product-page">

		<?php
		if ( get_theme_mod( 'product_custom_layout' ) ) :
			echo do_shortcode( '[block id="' . get_theme_mod( 'product_custom_layout' ) . '"]' );
			?>
			<div id="product-sidebar" class="mfp-hide">
				<div class="sidebar-inner">
					<?php
					do_action( 'flatsome_before_product_sidebar' );
					/**
					 * woocommerce_sidebar hook
					 *
					 * @hooked woocommerce_get_sidebar - 10
					 */
					if ( is_active_sidebar( 'product-sidebar' ) ) {
						dynamic_sidebar( 'product-sidebar' );
					} elseif ( is_active_sidebar( 'shop-sidebar' ) ) {
						dynamic_sidebar( 'shop-sidebar' );
					}
					?>
				</div><!-- .sidebar-inner -->
			</div>
			<?php
		else :
			echo '<p class="lead shortcode-error">Create a custom product layout by using the UX Builder. You need to select a Block as custom product layout and then open it in the UX Builder from the product page.</p>';
		endif;
		?>

	</div>

	<?php do_action( 'woocommerce_after_single_product' ); ?>

</div>
