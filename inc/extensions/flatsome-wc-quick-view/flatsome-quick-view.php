<?php

/**
 * Add Button to Grid Tools
 */
function flatsome_lightbox_button() {
	if ( get_theme_mod( 'disable_quick_view', 0 ) ) {
		return;
	}

	// Run Quick View Script.
	wp_enqueue_script( 'wc-add-to-cart-variation' );

	global $product;
	echo '  <a class="quick-view" data-prod="' . $product->get_id() . '" href="#quick-view">' . __( 'Quick View', 'flatsome' ) . '</a>';
}

add_action( 'flatsome_product_box_actions', 'flatsome_lightbox_button', 50 );

/* Add stuff to lightbox */
add_action( 'woocommerce_single_product_lightbox_summary', 'woocommerce_template_single_price', 10 );
add_action( 'woocommerce_single_product_lightbox_summary', 'woocommerce_template_single_excerpt', 20 );
add_action( 'woocommerce_single_product_lightbox_summary', 'woocommerce_template_single_add_to_cart', 30 );
add_action( 'woocommerce_before_single_product_lightbox_summary', 'woocommerce_show_product_sale_flash', 20 );

if ( get_theme_mod( 'product_info_meta', 1 ) ) {
	add_action( 'woocommerce_single_product_lightbox_summary', 'woocommerce_template_single_meta', 40 );
}

/**
 * Quick View Output
 */
function flatsome_quickview() {
	global $post, $product;
	$prod_id = $_POST["product"];
	$post    = get_post( $prod_id );
	$product = wc_get_product( $prod_id );
	ob_start();

	add_filter( 'woocommerce_add_to_cart_form_action', '__return_empty_string' ); // Disable form action that causes redirect.
	wc_get_template( 'content-single-product-lightbox.php' );
	remove_filter( 'woocommerce_add_to_cart_form_action', '__return_empty_string' );

	$output = ob_get_contents();
	ob_end_clean();
	echo $output;
	die();
}

add_action( 'wp_ajax_flatsome_quickview', 'flatsome_quickview' );
add_action( 'wp_ajax_nopriv_flatsome_quickview', 'flatsome_quickview' );
