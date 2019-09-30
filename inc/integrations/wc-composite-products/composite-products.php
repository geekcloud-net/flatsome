<?php
/**
 * Composite Products integration
 *
 * @author      UX Themes
 * @package     Flatsome/Integrations
 * @see         https://woocommerce.com/products/composite-products/
 */

/**
 *  Composite products integration script.
 */
function flatsome_wc_composite_products_integration() {
	global $integrations_uri;
	wp_enqueue_script( 'flatsome-composite-products', $integrations_uri . '/wc-composite-products/composite-products.js', array( 'jquery', 'flatsome-js' ), 1.1, true );
}

add_action( 'wp_enqueue_scripts', 'flatsome_wc_composite_products_integration' );
