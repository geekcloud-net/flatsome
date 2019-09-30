<?php
/**
 * Single Product Image
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/product-image.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 3.5.1
 */

defined( 'ABSPATH' ) || exit;

// FL: Disable check, Note: `wc_get_gallery_image_html` was added in WC 3.3.2 and did not exist prior. This check protects against theme overrides being used on older versions of WC.
//if ( ! function_exists( 'wc_get_gallery_image_html' ) ) {
//	return;
//}

global $product;

$columns           = apply_filters( 'woocommerce_product_thumbnails_columns', 4 );
$post_thumbnail_id = $product->get_image_id();
$wrapper_classes   = apply_filters( 'woocommerce_single_product_image_gallery_classes', array(
	'woocommerce-product-gallery',
	'woocommerce-product-gallery--' . ( $product->get_image_id() ? 'with-images' : 'without-images' ),
	'woocommerce-product-gallery--columns-' . absint( $columns ),
	'images',
) );

$slider_classes = array( 'product-gallery-slider', 'slider', 'slider-nav-circle', 'mb-half', 'slider-style-container', 'slider-nav-light', 'slider-load-first', 'no-overflow' );
$rtl = 'false';
if(is_rtl()) $rtl = 'true';

?>
<?php do_action( 'flatsome_before_product_images' ); ?>

<div class="product-images slider-wrapper relative mb-half has-hover <?php echo esc_attr( implode( ' ', array_map( 'sanitize_html_class', $wrapper_classes ) ) ); ?> " data-columns="<?php echo esc_attr( $columns ); ?>">
	<div class="absolute left right">
		<div class="container relative">
			<?php do_action( 'flatsome_sale_flash' ); ?>
		</div>
	</div>

	<figure class="woocommerce-product-gallery__wrapper <?php echo implode( ' ', $slider_classes ); ?>"
			data-flickity-options='{
				"cellAlign": "center",
				"wrapAround": true,
				"autoPlay": false,
				"prevNextButtons":true,
				"adaptiveHeight": true,
				"imagesLoaded": true,
				"lazyLoad": 1,
				"dragThreshold" : 15,
				"pageDots": false,
				"rightToLeft": <?php echo $rtl; ?>
			}'
			style="background-color: #333;">
		<?php

    if ( $product->get_image_id() ) {
      $html  = flatsome_wc_get_gallery_image_html( $post_thumbnail_id, true, 'full' );
    } else {
      $html  = '<div class="woocommerce-product-gallery__image--placeholder">';
      $html .= sprintf( '<img src="%s" alt="%s" class="wp-post-image" />', esc_url( wc_placeholder_img_src( 'woocommerce_single' ) ), esc_html__( 'Awaiting product image', 'woocommerce' ) );
      $html .= '</div>';
    }

		echo apply_filters( 'woocommerce_single_product_image_thumbnail_html', $html, $post_thumbnail_id ); // phpcs:disable WordPress.XSS.EscapeOutput.OutputNotEscaped

    do_action( 'woocommerce_product_thumbnails' );
		?>
	</figure>

	<div class="loading-spin centered dark"></div>

	<div class="absolute bottom left right">
		<div class="container relative image-tools">
			<div class="image-tools absolute bottom right z-3">
				<?php do_action( 'flatsome_product_image_tools_bottom' ); ?>
				<?php do_action( 'flatsome_product_image_tools_top' ); ?>
			</div>
		</div>
	</div>

</div>
<?php do_action( 'flatsome_after_product_images' ); ?>
