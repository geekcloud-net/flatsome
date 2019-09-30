<?php
// Get Product Lists
function ux_list_products( $args ) {

	if ( isset( $args ) ) {
		$options = $args;

		$number = 8;
		if ( isset( $options['products'] ) ) {
			$number = $options['products'];
		}

		$show = ''; // featured, onsale.
		if ( isset( $options['show'] ) ) {
			$show = $options['show'];
		}

		$orderby = 'date';
		$order   = 'desc';
		if ( isset( $options['orderby'] ) ) {
			$orderby = $options['orderby'];
		}
		if ( isset( $options['order'] ) ) {
			$order = $options['order'];
		}
		if ( $orderby == 'menu_order' ) {
			$order = 'asc';
		}

		$tags = '';
		if ( isset( $options['tags'] ) ) {
			if ( is_numeric( $options['tags'] ) ) {
				$options['tags'] = get_term( $options['tags'] )->slug;
			}
			$tags = $options['tags'];
		}

		$offset = '';
		if ( isset( $options['offset'] ) ) {
			$offset = $options['offset'];
		}
	} else {
		return false;
	}

	$query_args = array(
		'posts_per_page'      => $number,
		'post_status'         => 'publish',
		'post_type'           => 'product',
		'no_found_rows'       => 1,
		'ignore_sticky_posts' => 1,
		'order'               => $order,
		'product_tag'         => $tags,
		'offset'              => $offset,
		'meta_query'          => WC()->query->get_meta_query(), // @codingStandardsIgnoreLine
		'tax_query'           => WC()->query->get_tax_query(), // @codingStandardsIgnoreLine
	);

	switch ( $show ) {
		case 'featured':
			$query_args['tax_query'][] = array(
				'taxonomy' => 'product_visibility',
				'field'    => 'name',
				'terms'    => 'featured',
				'operator' => 'IN',
			);
			break;
		case 'onsale':
			$query_args['post__in'] = array_merge( array( 0 ), wc_get_product_ids_on_sale() );
			break;
	}

	switch ( $orderby ) {
		case 'menu_order':
			$query_args['orderby'] = 'menu_order';
			break;
		case 'title':
			$query_args['orderby'] = 'name';
			break;
		case 'date':
			$query_args['orderby'] = 'date';
			break;
		case 'price':
			$query_args['meta_key'] = '_price'; // @codingStandardsIgnoreLine
			$query_args['orderby']  = 'meta_value_num';
			break;
		case 'rand':
			$query_args['orderby'] = 'rand'; // @codingStandardsIgnoreLine
			break;
		case 'sales':
			$query_args['meta_key'] = 'total_sales'; // @codingStandardsIgnoreLine
			$query_args['orderby']  = 'meta_value_num';
			break;
		default:
			$query_args['orderby'] = 'date';
	}

	$query_args = ux_maybe_add_category_args( $query_args, $options['cat'], 'IN' );

	if ( isset( $options['out_of_stock'] ) && $options['out_of_stock'] === 'exclude' ) {
		$product_visibility_term_ids = wc_get_product_visibility_term_ids();
		$query_args['tax_query'][]   = array(
			'taxonomy' => 'product_visibility',
			'field'    => 'term_taxonomy_id',
			'terms'    => $product_visibility_term_ids['outofstock'],
			'operator' => 'NOT IN',
		);
	}

	$results = new WP_Query( $query_args );

	return $results;
} // List products

/**
 * Set categories query args if not empty.
 *
 * @param array  $query_args Query args.
 * @param string $category   Shortcode category attribute value.
 * @param string $operator   Query Operator.
 *
 * @return array $query_args
 */
function ux_maybe_add_category_args( $query_args, $category, $operator ) {
	if ( ! empty( $category ) ) {

		if ( empty( $query_args['tax_query'] ) ) {
			$query_args['tax_query'] = array(); // @codingStandardsIgnoreLine
		}

		$categories = array_map( 'sanitize_title', explode( ',', $category ) );
		$field      = 'slug';

		if ( is_numeric( $categories[0] ) ) {
			$field      = 'term_id';
			$categories = array_map( 'absint', $categories );
			// Check numeric slugs.
			foreach ( $categories as $cat ) {
				$the_cat = get_term_by( 'slug', $cat, 'product_cat' );
				if ( false !== $the_cat ) {
					$categories[] = $the_cat->term_id;
				}
			}
		}

		$query_args['tax_query'][] = array(
			'taxonomy' => 'product_cat',
			'terms'    => $categories,
			'field'    => $field,
			'operator' => $operator,
		);
	}

	return $query_args;
}

global $pagenow;
if ( is_admin() && isset( $_GET['activated'] ) && $pagenow == 'themes.php' ) {
	/**
	 * Set Default WooCommerce Image sizes upon theme activation.
	 */
	function flatsome_woocommerce_image_dimensions() {
		$single = array(
			'width'  => '510', // px
			'height' => '600', // px
			'crop'   => 1    // true
		);
		$catalog = array(
			'width'  => '247', // px
			'height' => '300', // px
			'crop'   => 1    // true
		);
		$thumbnail = array(
			'width'  => '114', // px
			'height' => '130', // px
			'crop'   => 1    // true
		);

		update_option( 'woocommerce_single_image_width', $single['width'] );
		update_option( 'woocommerce_thumbnail_image_width', $catalog['width'] );
		update_option( 'woocommerce_thumbnail_cropping', 'custom' );
		update_option( 'woocommerce_thumbnail_cropping_custom_width', 5 );
		update_option( 'woocommerce_thumbnail_cropping_custom_height', 6 );

	}
	add_action( 'init', 'flatsome_woocommerce_image_dimensions', 1 );
}
