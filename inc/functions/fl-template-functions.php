<?php

/**
 * Display placeholder with tooltip message on header elements when they miss a resource.
 *
 * @param string $resource Name of the resource.
 */
function fl_header_element_error( $resource ) {
	$title = '';
	switch ( $resource ) {
		case 'woocommerce':
			$title = 'WooCommerce needed';
	}
	echo '<li><a class="element-error tooltip" title="' . esc_attr( $title ) . '">-</a></li>';
}

/**
 * Get flatsome_breadcrumb hooked content.
 *
 * @param string|array $class   One or more classes to add to the class list.
 * @param bool         $display Whether to display the breadcrumb (true) or return it (false).
 */
function flatsome_breadcrumb( $class = '', $display = true ) {
	do_action( 'flatsome_breadcrumb', $class, $display );
}

/**
 * @deprecated 3.7
 */
function get_flatsome_breadcrumbs() {
	_deprecated_function( __FUNCTION__, '3.7', 'flatsome_breadcrumb' );
	flatsome_breadcrumb();
}
