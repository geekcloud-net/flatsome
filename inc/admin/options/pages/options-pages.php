<?php
/**
 * Adds Pages Panel and options to the Customizer for Flatsome.
 *
 * @package Flatsome
 */

Flatsome_Option::add_section( 'pages', array(
	'title'       => __( 'Pages', 'flatsome-admin' ),
	'description' => __( 'Change the default page layout for all pages. You can also override some of these options per page in the page editor.', 'flatsome-admin' ),
) );

Flatsome_Option::add_field( 'option', array(
	'type'     => 'select',
	'settings' => 'pages_template',
	'label'    => __( 'Default - Page Template', 'flatsome-admin' ),
	'section'  => 'pages',
	'default'  => 'default',
	'choices'  => array(
		'default'                           => __( 'Container (Default)', 'flatsome-admin' ),
		'blank-title-center'                => __( 'Container - Center Title', 'flatsome-admin' ),
		'blank'                             => __( 'Full-Width', 'flatsome-admin' ),
		'header-on-scroll'                  => __( 'Full-Width - Header On Scroll', 'flatsome-admin' ),
		'blank-featured'                    => __( 'Full-Width - Parallax Title', 'flatsome-admin' ),
		'transparent-header'                => __( 'Full-Width - Transparent Header', 'flatsome-admin' ),
		'transparent-header-light'          => __( 'Full-Width - Transparent Header Light', 'flatsome-admin' ),
		'left-sidebar'                      => __( 'Sidebar Left', 'flatsome-admin' ),
		'blank-landingpage'                 => __( 'No Header / No Footer', 'flatsome-admin' ),
		'right-sidebar'                     => __( 'Sidebar Right', 'flatsome-admin' ),
		'single-page-nav'                   => __( 'Single Page Navigation', 'flatsome-admin' ),
		'single-page-nav-transparent'       => __( 'Single Page Navigation - Transparent Header', 'flatsome-admin' ),
		'single-page-nav-transparent-light' => __( 'Single Page Navigation - Transparent Header - Light', 'flatsome-admin' ),
		'blank-sub-nav-vertical'            => __( 'Vertical Sub Navigation', 'flatsome-admin' ),
	),
));

Flatsome_Option::add_field( 'option', array(
	'type'     => 'checkbox',
	'settings' => 'default_title',
	'label'    => __( 'Show H1 Page title on the container (default), left sidebar and right sidebar templates.', 'flatsome-admin' ),
	'section'  => 'pages',
	'default'  => 0,
));

Flatsome_Option::add_field( 'option', array(
	'type'     => 'checkbox',
	'settings' => 'page_top_excerpt',
	'label'    => __( 'Add excerpt content to top of pages.', 'flatsome-admin' ),
	'section'  => 'pages',
	'default'  => 1,
));
