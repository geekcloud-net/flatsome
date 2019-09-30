<?php

/**
 * Generate product structured data at later point.
 * (hook woocommerce_single_product_summary is not always available)
 */
function flatsome_single_product_custom_structured_data() {
	if ( ! class_exists( 'WC_Structured_Data' ) ) {
		return;
	}

	$structured_data = WC()->structured_data;
	if ( ! is_object( $structured_data ) || ! is_a( $structured_data, 'WC_Structured_Data' ) ) {
		return;
	}

	remove_action( 'woocommerce_single_product_summary', [ $structured_data, 'generate_product_data' ], 60 );
	add_action( 'woocommerce_after_single_product', [ $structured_data, 'generate_product_data' ], 60 );
}

add_action( 'init', 'flatsome_single_product_custom_structured_data' );
