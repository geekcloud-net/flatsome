<?php
/**
 * The template for displaying product search form
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/product-searchform.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 3.3.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

?>
<form role="search" method="get" class="searchform" action="<?php echo esc_url( home_url( '/' ) ); ?>">
	<div class="flex-row relative">
		<?php if ( get_theme_mod( 'header_search_categories' ) ) { ?>
			<div class="flex-col search-form-categories">
				<?php
				$args = array(
					'number'     => '999',
					'orderby'    => 'name',
					'hide_empty' => true,
				);

				$product_categories = get_terms( 'product_cat', $args );
				$selected_category  = isset( $_REQUEST['product_cat'] ) ? $_REQUEST['product_cat'] : '';

				echo '<select class="search_categories resize-select mb-0" name="product_cat">';
				echo '<option value=""' . selected( '', $selected_category, false ) . '>' . esc_html__( 'All', 'flatsome' ) . '</option>';

				foreach ( $product_categories as $value ) {
					if ( $value && ! $value->parent ) {
						echo '<option value="' . $value->slug . '"' . selected( $value->slug, $selected_category, false ) . '>' . $value->name . '</option>';
					}
				}
				echo '</select>';
				?>
			</div><!-- .flex-col -->
		<?php } ?>
		<?php
		$placeholder = __( 'Search', 'woocommerce' ) . '&hellip;';
		if ( get_theme_mod( 'search_placeholder' ) ) {
			$placeholder = get_theme_mod( 'search_placeholder' );
		}
		?>
		<div class="flex-col flex-grow">
			<label class="screen-reader-text" for="woocommerce-product-search-field-<?php echo isset( $index ) ? absint( $index ) : 0; ?>"><?php esc_html_e( 'Search for:', 'woocommerce' ); ?></label>
			<input type="search" id="woocommerce-product-search-field-<?php echo isset( $index ) ? absint( $index ) : 0; ?>" class="search-field mb-0" placeholder="<?php echo esc_attr( $placeholder ); ?>" value="<?php echo get_search_query(); ?>" name="s" />
			<input type="hidden" name="post_type" value="product" />
			<?php if ( defined( 'ICL_LANGUAGE_CODE' ) ): ?>
				<input type="hidden" name="lang" value="<?php echo ICL_LANGUAGE_CODE; ?>" />
			<?php endif ?>
		</div><!-- .flex-col -->
		<div class="flex-col">
			<button type="submit" value="<?php echo esc_attr_x( 'Search', 'submit button', 'woocommerce' ); ?>" class="ux-search-submit submit-button secondary button icon mb-0">
				<?php echo get_flatsome_icon( 'icon-search' ); ?>
			</button>
		</div><!-- .flex-col -->
	</div><!-- .flex-row -->
	<div class="live-search-results text-left z-top"></div>
</form>
