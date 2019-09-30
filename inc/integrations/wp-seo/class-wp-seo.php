<?php
/**
 * WP SEO integration
 *
 * @author      UX Themes
 * @package     Flatsome/Integrations
 * @since       3.7.0
 */

namespace Flatsome\Inc\Integrations;

/**
 * Class WP_Seo
 *
 * @package Flatsome\Inc\Integrations
 */
class WP_Seo {

	/**
	 * Static instance
	 *
	 * @var WP_Seo $instance
	 */
	private static $instance = null;

	/**
	 * WP_Seo constructor.
	 */
	public function __construct() {
		add_action( 'wp', [ $this, 'integrate' ] );
	}

	/**
	 * Setting based integration.
	 */
	public function integrate() {
		// Primary term.
		if ( get_theme_mod( 'wpseo_primary_term' ) ) {
			add_filter( 'flatsome_woocommerce_shop_loop_category', [ $this, 'get_primary_term' ], 10, 2 );
		}
		// Breadcrumb.
		if ( get_theme_mod( 'wpseo_breadcrumb' ) ) {
			remove_action( 'flatsome_breadcrumb', 'woocommerce_breadcrumb', 20 );
			add_action( 'flatsome_breadcrumb', [ $this, 'yoast_breadcrumb' ], 20, 2 );

			// Manipulate last crumb.
			if ( get_theme_mod( 'wpseo_breadcrumb_remove_last', 1 ) && apply_filters( 'flatsome_wpseo_breadcrumb_remove_last', is_product() ) ) {
				add_filter( 'wpseo_breadcrumb_links', [ $this, 'remove_last_crumb' ] );
				add_filter( 'wpseo_breadcrumb_single_link', [ $this, 'add_link_to_last_crumb' ], 10, 2 );
			}

			add_filter( 'wpseo_breadcrumb_separator', [ $this, 'wrap_crumb_separator' ] );
		}
	}

	/**
	 * Retrieve primary product term, set through YOAST.
	 *
	 * @param string $term    The original term string.
	 * @param object $product Product.
	 *
	 * @return string
	 */
	public function get_primary_term( $term, $product ) {
		if ( function_exists( 'yoast_get_primary_term' ) ) {
			$primary_term = yoast_get_primary_term( 'product_cat', $product->get_Id() );
		}
		if ( ! empty( $primary_term ) ) {
			return $primary_term;
		}

		return $term;
	}

	/**
	 * Yoast breadcrumbs.
	 * TODO: See if we want to add the before and after hooks.
	 *
	 * @param string|array $class   One or more classes to add to the class list.
	 * @param bool         $display Whether to display the breadcrumb (true) or return it (false).
	 */
	public function yoast_breadcrumb( $class = '', $display = true ) {
		if ( function_exists( 'yoast_breadcrumb' ) ) {
			$classes   = is_array( $class ) ? $class : array_map( 'trim', explode( ' ', $class ) );
			$classes[] = 'yoast-breadcrumb';
			$classes[] = 'breadcrumbs';
			$classes[] = get_theme_mod( 'breadcrumb_case', 'uppercase' );
			$classes   = array_unique( array_filter( $classes ) );
			$classes   = implode( ' ', $classes );

			// do_action( 'flatsome_before_breadcrumb' );
			yoast_breadcrumb( '<nav id="breadcrumbs" class="' . esc_attr( $classes ) . '">', '</nav>', $display );
			// do_action( 'flatsome_after_breadcrumb' );
		}
	}

	/**
	 * Removes last crumb in the crumbs array.
	 *
	 * @param array $crumbs The crumbs array.
	 *
	 * @return mixed
	 */
	public function remove_last_crumb( $crumbs ) {
		if ( count( $crumbs ) > 1 ) {
			array_pop( $crumbs );
		}

		return $crumbs;
	}

	/**
	 * Adds a link to last crumb, use in conjunction with remove_last_crumb()
	 *
	 * @param string $output The output string.
	 * @param array  $crumb  The link array.
	 *
	 * @return string
	 */
	public function add_link_to_last_crumb( $output, $crumb ) {
		$output  = '<a property="v:title" rel="v:url" href="' . $crumb['url'] . '" >';
		$output .= $crumb['text'];
		$output .= '</a>';

		return $output;
	}

	/**
	 * Wrap breadcrumb separator.
	 *
	 * @param string $separator Breadcrumbs separator.
	 *
	 * @return string
	 */
	public function wrap_crumb_separator( $separator ) {
		return '<span class="divider">' . $separator . '</span>';
	}

	/**
	 * Initializes the object and returns its instance.
	 *
	 * @return WP_Seo The object instance
	 */
	public static function get_instance() {
		if ( ! isset( self::$instance ) ) {
			self::$instance = new self();
		}

		return self::$instance;
	}
}

WP_Seo::get_instance();
