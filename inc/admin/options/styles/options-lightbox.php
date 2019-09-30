<?php

Flatsome_Option::add_section( 'lightbox', array(
	'title' => __( 'Image Lightbox', 'flatsome-admin' ),
	'panel' => 'style',
) );

Flatsome_Option::add_field( 'option', array(
	'type'     => 'checkbox',
	'settings' => 'flatsome_lightbox',
	'label'    => __( 'Enable Flatsome Lightbox', 'flatsome-admin' ),
	'section'  => 'lightbox',
	'default'  => 1,
) );

Flatsome_Option::add_field( 'option', array(
	'type'            => 'color',
	'settings'        => 'flatsome_lightbox_bg',
	'label'           => __( 'Lightbox background color', 'flatsome-admin' ),
	'section'         => 'lightbox',
	'transport'       => $transport,
	'default'         => '',
	'active_callback' => array(
		array(
			'setting'  => 'flatsome_lightbox',
			'operator' => '==',
			'value'    => true,
		),
	),
) );

Flatsome_Option::add_field( '', array(
	'type'            => 'custom',
	'settings'        => 'custom_lightbox_gallery_layout',
	'label'           => '',
	'section'         => 'lightbox',
	'default'         => '<div class="options-title-divider">Gallery</div>',
	'active_callback' => array(
		array(
			'setting'  => 'flatsome_lightbox',
			'operator' => '==',
			'value'    => true,
		),
	),
) );

Flatsome_Option::add_field( 'option', array(
	'type'            => 'checkbox',
	'settings'        => 'flatsome_lightbox_multi_gallery',
	'label'           => __( 'Use multiple galleries on a page', 'flatsome-admin' ) . ' (NEW)',
	'description'     => __( 'When enabled, lightbox galleries on a page are treated separately, else combined in one gallery.', 'flatsome-admin' ),
	'section'         => 'lightbox',
	'default'         => 0,
	'active_callback' => array(
		array(
			'setting'  => 'flatsome_lightbox',
			'operator' => '==',
			'value'    => true,
		),
	),
) );
