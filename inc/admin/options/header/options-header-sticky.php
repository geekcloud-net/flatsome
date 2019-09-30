<?php
/**
 * Header Sticky
 *
 * @package Flatsome/Admin/Options/Header
 */

Flatsome_Option::add_section( 'header_sticky', array(
	'title' => __( 'Sticky Header', 'flatsome-admin' ),
	'panel' => 'header',
) );

Flatsome_Option::add_field( 'option', array(
	'type'      => 'slider',
	'settings'  => 'header_height_sticky',
	'label'     => __( 'Header Height on Sticky', 'flatsome-admin' ),
	'section'   => 'header_sticky',
	'transport' => $transport,
	'default'   => 70,
	'choices'   => array(
		'min'  => 30,
		'max'  => 300,
		'step' => 1,
	),
) );

Flatsome_Option::add_field( 'option', array(
	'type'      => 'slider',
	'settings'  => 'sticky_logo_padding',
	'label'     => __( 'Sticky Logo Padding', 'flatsome-admin' ),
	'section'   => 'header_sticky',
	'default'   => 0,
	'choices'   => array(
		'min'  => 0,
		'max'  => 30,
		'step' => 1,
	),
	'transport' => 'postMessage',
) );

Flatsome_Option::add_field( 'option', array(
	'type'      => 'slider',
	'settings'  => 'nav_height_sticky',
	'label'     => __( 'Nav Height on Sticky', 'flatsome-admin' ),
	'section'   => 'header_sticky',
	'default'   => '',
	'choices'   => array(
		'min'  => 0,
		'max'  => 100,
		'step' => 1,
	),
	'transport' => 'postMessage',
) );

Flatsome_Option::add_field( 'option', array(
	'type'     => 'checkbox',
	'settings' => 'topbar_sticky',
	'label'    => __( 'Top Bar - Sticky on Scroll', 'flatsome-admin' ),
	'section'  => 'header_sticky',
	'default'  => 0,
) );

Flatsome_Option::add_field( 'option', array(
	'type'     => 'checkbox',
	'settings' => 'header_sticky',
	'label'    => __( 'Header Main - Sticky on Scroll', 'flatsome-admin' ),
	'section'  => 'header_sticky',
	'default'  => 1,
) );

Flatsome_Option::add_field( 'option', array(
	'type'     => 'checkbox',
	'settings' => 'bottombar_sticky',
	'label'    => __( 'Header Bottom - Sticky on Scroll', 'flatsome-admin' ),
	'section'  => 'header_sticky',
	'default'  => 1,
) );

Flatsome_Option::add_field( 'option', array(
	'type'     => 'select',
	'settings' => 'sticky_style',
	'label'    => __( 'Sticky Style', 'flatsome-admin' ),
	'section'  => 'header_sticky',
	'default'  => 'jump',
	'choices'  => array(
		'jump'   => __( 'Jump Down', 'flatsome-admin' ),
		'fade'   => __( 'Fade', 'flatsome-admin' ),
		'shrink' => __( 'Shrink', 'flatsome-admin' ),
	),
) );

Flatsome_Option::add_field( 'option', array(
	'type'     => 'checkbox',
	'settings' => 'sticky_hide_on_scroll',
	'label'    => __( 'Hide sticky when scrolling down', 'flatsome-admin' ) . ' (NEW)',
	'section'  => 'header_sticky',
	'default'  => 0,
) );

Flatsome_Option::add_field( 'option', array(
	'type'      => 'image',
	'settings'  => 'site_logo_sticky',
	'label'     => __( 'Custom Sticky Logo', 'flatsome-admin' ),
	'section'   => 'header_sticky',
	'transport' => $transport,
	'default'   => '',
) );
