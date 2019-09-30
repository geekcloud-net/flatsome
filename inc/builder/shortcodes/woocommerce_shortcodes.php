<?php

$options = array(
	'per_page' => array(
		'type'    => 'slider',
		'heading' => 'Number',
		'default' => '12',
		'max'     => '99',
		'min'     => '4',
	),
	'columns'  => array(
		'type'    => 'slider',
		'heading' => 'Columns',
		'default' => '4',
		'max'     => '8',
		'min'     => '1',
	),
	'orderby'  => array(
		'type'    => 'select',
		'heading' => __( 'Order By' ),
		'default' => 'title',
		'options' => array(
			'menu_order' => 'Menu Order',
			'title'      => 'Title',
			'date'       => 'Date',
			'rand'       => 'Random',
			//'id' => 'ID', // Valid but Disabled
		),
	),
	'order'    => array(
		'type'    => 'select',
		'heading' => __( 'Order' ),
		'default' => 'asc',
		'options' => array(
			'asc'  => 'ASC',
			'desc' => 'DESC',
		),
	),
);

$options_custom = array(
	'ids'      => array(
		'type'       => 'select',
		'heading'    => 'Products',
		'param_name' => 'ids',
		'config'     => array(
			'multiple'    => true,
			'placeholder' => 'Select..',
			'postSelect'  => array(
				'post_type' => array( 'product' ),
			),
		),
	),
	'per_page' => array(
		'type'    => 'slider',
		'heading' => 'Number',
		'default' => '12',
		'max'     => '99',
		'min'     => '4',
	),
	'columns'  => array(
		'type'    => 'slider',
		'heading' => 'Columns',
		'default' => '4',
		'max'     => '8',
		'min'     => '1',
	),
	'orderby'  => array(
		'type'    => 'select',
		'heading' => __( 'Order By' ),
		'default' => 'title',
		'options' => array(
			'menu_order' => 'Menu Order',
			'title'      => 'Title',
			'date'       => 'Date',
			'rand'       => 'Random',
			'price'      => 'Price',
			'popularity' => 'Popularity',
			'rating'     => 'Rating',
			//'id' => 'ID', // Valid but Disabled
		),
	),
	'order'    => array(
		'type'    => 'select',
		'heading' => __( 'Order' ),
		'default' => 'asc',
		'options' => array(
			'asc'  => 'ASC',
			'desc' => 'DESC',
		),
	),
);

add_ux_builder_shortcode( 'products',
	array(
		'name'      => 'Products - Custom',
		'category'  => __( 'Shop' ),
		'thumbnail' => flatsome_ux_builder_thumbnail( 'woo_products' ),
		'wrap'      => false,
		'options'   => $options_custom,
	)
);

add_ux_builder_shortcode( 'featured_products',
	array(
		'name'      => 'Products - Featured',
		'category'  => __( 'Shop' ),
		'thumbnail' => flatsome_ux_builder_thumbnail( 'woo_products' ),
		'wrap'      => false,
		'options'   => $options,
	)
);

add_ux_builder_shortcode( 'recent_products',
	array(
		'name'      => 'Products - Recent',
		'category'  => __( 'Shop' ),
		'thumbnail' => flatsome_ux_builder_thumbnail( 'woo_products' ),
		'wrap'      => false,
		'options'   => $options,
	)
);

add_ux_builder_shortcode( 'sale_products',
	array(
		'name'      => 'Products - On Sale',
		'category'  => __( 'Shop' ),
		'thumbnail' => flatsome_ux_builder_thumbnail( 'woo_products' ),
		'wrap'      => false,
		'options'   => $options,
	)
);

add_ux_builder_shortcode( 'best_selling_products',
	array(
		'name'      => 'Products - Best Selling',
		'category'  => __( 'Shop' ),
		'thumbnail' => flatsome_ux_builder_thumbnail( 'woo_products' ),
		'wrap'      => false,
		'options'   => $options,
	)
);

add_ux_builder_shortcode( 'top_rated_products',
	array(
		'name'      => 'Products - Top Rated',
		'category'  => __( 'Shop' ),
		'thumbnail' => flatsome_ux_builder_thumbnail( 'woo_products' ),
		'wrap'      => false,
		'options'   => $options,
	)
);
