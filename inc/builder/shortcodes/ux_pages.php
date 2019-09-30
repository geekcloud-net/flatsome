<?php

$repeater_type        = 'row';
$default_text_align   = 'left';
$repeater_col_spacing = 'normal';

$options = array(
	'pages_options'   => array(
		'type'    => 'group',
		'heading' => __( 'Options' ),
		'options' => array(
			'style'   => array(
				'type'    => 'select',
				'heading' => __( 'Style' ),
				'default' => 'normal',
				'options' => require( __DIR__ . '/values/box-layouts.php' ),
			),
			'parent'  => array(
				'type'    => 'select',
				'heading' => 'Parent',
				'default' => '',
				'options' => ux_builder_get_page_parents(),
			),
			'orderby' => array(
				'type'    => 'select',
				'heading' => __( 'Order By' ),
				'default' => 'menu_order',
				'options' => array(
					'post_title'    => 'Title',
					'post_date'     => 'Date',
					'menu_order'    => 'Menu Order',
					'post_modified' => 'Last Modified',
				),
			),
			'order'   => array(
				'type'    => 'select',
				'heading' => __( 'Order' ),
				'default' => 'asc',
				'options' => array(
					'asc'  => 'ASC',
					'desc' => 'DESC',
				),
			),
		),
	),
	'layout_options'        => require( __DIR__ . '/commons/repeater-options.php' ),
	'layout_options_slider' => require( __DIR__ . '/commons/repeater-slider.php' ),
);

$box_styles = require( __DIR__ . '/commons/box-styles.php' );
$options    = array_merge( $options, $box_styles );

$advanced = array('advanced_options' => require( __DIR__ . '/commons/advanced.php'));
$options = array_merge($options, $advanced);

add_ux_builder_shortcode( 'ux_pages',
	array(
		'name'      => __( 'Pages', 'ux-builder' ),
		'category'  => __( 'Content' ),
		'thumbnail' => flatsome_ux_builder_thumbnail( 'pages' ),
		'scripts'   => array(
			'flatsome-masonry-js' => get_template_directory_uri() . '/assets/libs/packery.pkgd.min.js',
		),
		'presets'   => array(
			array(
				'name'    => __( 'Default' ),
				'content' => '[ux_pages]',
			),
		),
		'options'   => $options,
	)
);
