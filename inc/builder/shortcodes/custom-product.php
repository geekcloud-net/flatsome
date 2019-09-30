<?php

$sizes = array(
	'xxsmall' => 'XX-Small',
	'xsmall'  => 'X-Small',
	'smaller' => 'Smaller',
	'small'   => 'Small',
	''        => 'Normal',
	'large'   => 'Large',
	'larger'  => 'Larger',
	'xlarge'  => 'X-Large',
	'xxlarge' => 'XX-Large',
);

add_ux_builder_shortcode( 'ux_product_gallery', array(
	'name'      => __( 'Product Gallery' ),
	'category'  => __( 'Product Page' ),
	'thumbnail' => flatsome_ux_builder_thumbnail( 'woo_products' ),
	'overlay'   => true,
	'wrap'      => true,
	'priority'  => 9999,
	'options'   => array(
		'style' => array(
			'type'    => 'select',
			'heading' => 'Style',
			'default' => 'normal',
			'options' => array(
				'normal'     => __( 'Normal', 'flatsome-admin' ),
				'vertical'   => __( 'Vertical', 'flatsome-admin' ),
				'full-width' => __( 'Full Width', 'flatsome-admin' ),
			),
		),
	),
) );

add_ux_builder_shortcode( 'ux_product_title', array(
	'name'      => __( 'Product Title' ),
	'thumbnail' => flatsome_ux_builder_thumbnail( 'woo_products' ),
	'category'  => __( 'Product Page' ),
	'options'   => array(
		'size'      => array(
			'type'    => 'select',
			'heading' => 'Size',
			'default' => '',
			'options' => $sizes,
		),
		'divider'   => array(
			'type'    => 'checkbox',
			'heading' => 'Divider',
			'default' => 'true',
		),
		'uppercase' => array(
			'type'    => 'checkbox',
			'heading' => 'Uppercase',
			'default' => 'false',
		),
	),
) );

add_ux_builder_shortcode( 'ux_product_rating', array(
	'name'      => __( 'Product Rating' ),
	'thumbnail' => flatsome_ux_builder_thumbnail( 'woo_products' ),
	'wrap'      => false,
	'category'  => __( 'Product Page' ),
	'options'   => array(
		'count'      => array(
			'type'    => 'checkbox',
			'heading' => 'Review Count',
			'default' => 'false',
		),
		'style'      => array(
			'type'    => 'select',
			'heading' => 'Review Count Style',
			'default' => 'inline',
			'options' => array(
				'tooltip' => __( 'Tooltip', 'flatsome-admin' ),
				'stacked' => __( 'Stacked', 'flatsome-admin' ),
				'inline'  => __( 'Inline', 'flatsome-admin' ),
			),
		),
	),
) );

add_ux_builder_shortcode( 'ux_product_price', array(
	'name'      => __( 'Product Price' ),
	'thumbnail' => flatsome_ux_builder_thumbnail( 'woo_products' ),
	'wrap'      => false,
	'category'  => __( 'Product Page' ),
	'options'   => array(
		'size' => array(
			'type'    => 'select',
			'heading' => 'Size',
			'default' => '',
			'options' => $sizes,
		),
	),
) );

add_ux_builder_shortcode( 'ux_product_excerpt', array(
	'name'      => __( 'Product Short Description' ),
	'thumbnail' => flatsome_ux_builder_thumbnail( 'woo_products' ),
	'wrap'      => false,
	'category'  => __( 'Product Page' ),
) );

add_ux_builder_shortcode( 'ux_product_add_to_cart', array(
	'name'      => __( 'Product Add To Cart' ),
	'thumbnail' => flatsome_ux_builder_thumbnail( 'woo_products' ),
	'category'  => __( 'Product Page' ),
	'options'   => array(
		'style' => array(
			'type'    => 'select',
			'heading' => 'Form Style',
			'default' => 'normal',
			'options' => array(
				'normal' => __( 'Normal', 'flatsome-admin' ),
				'flat'   => __( 'Flat', 'flatsome-admin' ),
				'minimal'   => __( 'Minimal', 'flatsome-admin' ),
			),
		),
		'size'  => array(
			'type'    => 'select',
			'heading' => 'Size',
			'default' => '',
			'options' => $sizes,
		),
	),
) );

add_ux_builder_shortcode( 'ux_product_meta', array(
	'name'      => __( 'Product Meta' ),
	'thumbnail' => flatsome_ux_builder_thumbnail( 'woo_products' ),
	'category'  => __( 'Product Page' ),
) );

add_ux_builder_shortcode( 'ux_product_upsell', array(
	'name'      => __( 'Product Up-sells' ),
	'category'  => __( 'Product Page' ),
	'thumbnail' => flatsome_ux_builder_thumbnail( 'woo_products' ),
	'options'   => array(
		'style' => array(
			'type'    => 'select',
			'heading' => 'Style',
			'default' => 'sidebar',
			'options' => array(
				'sidebar' => __( 'List', 'flatsome-admin' ),
				'grid'    => __( 'Grid', 'flatsome-admin' ),
			),
		),
	),
) );

add_ux_builder_shortcode( 'ux_product_tabs', array(
	'name'      => __( 'Product Tabs' ),
	'category'  => __( 'Product Page' ),
	'thumbnail' => flatsome_ux_builder_thumbnail( 'woo_products' ),
	'options'   => array(
		'style' => array(
			'type'    => 'select',
			'heading' => 'Style',
			'default' => 'tabs',
			'options' => array(
				'tabs'          => __( 'Line Tabs', 'flatsome-admin' ),
				'tabs_normal'   => __( 'Tabs Normal', 'flatsome-admin' ),
				'line-grow'     => __( 'Line Tabs - Grow', 'flatsome-admin' ),
				'tabs_vertical' => __( 'Tabs vertical', 'flatsome-admin' ),
				'tabs_pills'    => __( 'Pills', 'flatsome-admin' ),
				'tabs_outline'  => __( 'Outline', 'flatsome-admin' ),
				'sections'      => __( 'Sections', 'flatsome-admin' ),
				'accordian'     => __( 'Accordian', 'flatsome-admin' ),
			),
		),
		'align' => array(
			'type'    => 'select',
			'heading' => 'Align',
			'default' => 'left',
			'options' => array(
				'left'   => __( 'Left', 'flatsome-admin' ),
				'center' => __( 'Center', 'flatsome-admin' ),
				'right'  => __( 'Right', 'flatsome-admin' ),
			),
		),
	),
) );

add_ux_builder_shortcode( 'ux_product_related', array(
	'name'      => __( 'Product Related' ),
	'category'  => __( 'Product Page' ),
	'thumbnail' => flatsome_ux_builder_thumbnail( 'woo_products' ),
	'options'   => array(
		'style' => array(
			'type'    => 'select',
			'heading' => 'Style',
			'default' => 'slider',
			'options' => array(
				'slider' => __( 'Slider', 'flatsome-admin' ),
				'grid'   => __( 'Grid', 'flatsome-admin' ),
			),
		),
	),
) );

add_ux_builder_shortcode( 'ux_product_hook', array(
	'name'      => __( 'Product Hooks' ),
	'category'  => __( 'Product Page' ),
	'thumbnail' => flatsome_ux_builder_thumbnail( 'woo_products' ),
	'options'   => array(
		'hook' => array(
			'type'    => 'select',
			'heading' => 'Hook',
			'default' => 'woocommerce_single_product_summary',
			'options' => apply_filters( 'flatsome_custom_product_single_product_hooks', array(
				'woocommerce_before_single_product_summary' => 'woocommerce_before_single_product_summary',
				'woocommerce_single_product_summary'        => 'woocommerce_single_product_summary',
				'woocommerce_after_single_product_summary'  => 'woocommerce_after_single_product_summary',
				'flatsome_custom_single_product_1'          => 'flatsome_custom_single_product_1',
				'flatsome_custom_single_product_2'          => 'flatsome_custom_single_product_2',
				'flatsome_custom_single_product_3'          => 'flatsome_custom_single_product_3',
			) ),
		),
	),
) );

add_ux_builder_shortcode( 'ux_product_breadcrumbs', array(
	'name'      => __( 'Product Breadcrumbs' ),
	'thumbnail' => flatsome_ux_builder_thumbnail( 'woo_products' ),
	'category'  => __( 'Product Page' ),
	'options'   => array(
		'size' => array(
			'type'    => 'select',
			'heading' => 'Size',
			'default' => '',
			'options' => $sizes,
		),
	),
) );

add_ux_builder_shortcode( 'ux_product_next_prev_nav', array(
	'name'      => __( 'Product Next/Prev' ),
	'thumbnail' => flatsome_ux_builder_thumbnail( 'woo_products' ),
	'category'  => __( 'Product Page' ),
	'options'   => array(
		'class' => array(
			'type'    => 'textfield',
			'heading' => 'Class',
			'default' => '',
		),
	),
) );
