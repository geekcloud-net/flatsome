<?php
/**
 * Flatsome Conditional Functions
 *
 * @author   UX Themes
 * @package  Flatsome/Functions
 */

if ( ! function_exists( 'is_nextend_facebook_login' ) ) {
	/**
	 * Returns true if Nextend facebook provider is enabled for v3
	 *
	 * @return bool
	 */
	function is_nextend_facebook_login() {
		if ( class_exists( 'NextendSocialLogin', false ) && ! class_exists( 'NextendSocialLoginPRO', false ) ) {
			return NextendSocialLogin::isProviderEnabled( 'facebook' );
		}
		return false;
	}
}

if ( ! function_exists( 'is_nextend_google_login' ) ) {
	/**
	 * Returns true if Nextend google provider is enabled for v3
	 *
	 * @return bool
	 */
	function is_nextend_google_login() {
		if ( class_exists( 'NextendSocialLogin', false ) && ! class_exists( 'NextendSocialLoginPRO', false ) ) {
			return NextendSocialLogin::isProviderEnabled( 'google' );
		}
		return false;
	}
}

if ( ! function_exists( 'is_yith_wishlist_premium' ) ) {
	/**
	 * Returns true if YITH Wishlist Premium is installed and free version is not activated.
	 *
	 * @return bool
	 */
	function is_yith_wishlist_premium() {
		return ! defined( 'YITH_WCWL_FREE_INIT' ) && file_exists( WP_PLUGIN_DIR . '/yith-woocommerce-wishlist-premium/init.php' );
	}
}

if ( ! function_exists( 'is_woocommerce_activated' ) ) {
	/**
	 * Returns true if WooCommerce plugin is activated
	 *
	 * @return bool
	 */
	function is_woocommerce_activated() {
		return class_exists( 'woocommerce' );
	}
}

if ( ! function_exists( 'is_portfolio_activated' ) ) {
	/**
	 * Returns "1" if Flatsome Portfolio option is enabled
	 *
	 * @return string
	 */
	function is_portfolio_activated() {
		return get_theme_mod( 'fl_portfolio', 1 );
	}
}

if ( ! function_exists( 'is_extension_activated' ) ) {
	/**
	 * Returns true if extension is activated
	 *
	 * @param string $extension The class name. The name is matched in a case-insensitive manner.
	 * @param bool   $autoload  Whether or not to call __autoload by default.
	 *
	 * @return bool
	 */
	function is_extension_activated( $extension, $autoload = true ) {
		return class_exists( $extension, $autoload );
	}
}
