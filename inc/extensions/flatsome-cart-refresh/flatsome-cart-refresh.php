<?php
/**
 * Flatsome Cart refresh extension
 *
 * @author     UX Themes
 * @category   Extension
 * @package    Flatsome/Extensions
 * @since      3.6.0
 */

/**
 * To be enqueued refresh script.
 */
function flatsome_cart_refresh_script() {
	global $extensions_uri;
	$theme   = wp_get_theme( get_template() );
	$version = $theme->get( 'Version' );
	wp_enqueue_script( 'flatsome-cart-refresh', $extensions_uri . '/flatsome-cart-refresh/flatsome-cart-refresh.js', array( 'jquery', 'flatsome-js' ), $version, true );
}

/**
 * Add extension script if on cart page.
 */
function flatsome_add_cart_refresh_script() {
	if ( is_cart() ) {
		add_action( 'wp_enqueue_scripts', 'flatsome_cart_refresh_script' );
	}
}

add_action( 'wp', 'flatsome_add_cart_refresh_script' );

