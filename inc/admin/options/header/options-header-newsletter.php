<?php
/**
 * Newsletter Element
 */

Flatsome_Option::add_section( 'header_newsletter',
	array(
		'title' => __( 'Newsletter', 'flatsome-admin' ),
		'panel' => 'header',
	)
);

Flatsome_Option::add_field( '',
	array(
		'type'     => 'custom',
		'settings' => 'custom_title_header_newsletter_layout',
		'label'    => __( '', 'flatsome-admin' ),
		'section'  => 'header_newsletter',
		'default'  => '<div class="options-title-divider">Layout</div>',
	)
);

Flatsome_Option::add_field( 'option',
	array(
		'type'      => 'radio-image',
		'settings'  => 'newsletter_icon_style',
		'label'     => __( 'Icon Style', 'flatsome-admin' ),
		'section'   => 'header_newsletter',
		'transport' => $transport,
		'default'   => 'plain',
		'choices'   => array(
			''              => $image_url . 'disabled.svg',
			'plain'         => $image_url . 'account-icon-plain.svg',
			'fill'          => $image_url . 'account-icon-fill.svg',
			'fill-round'    => $image_url . 'account-icon-fill-round.svg',
			'outline'       => $image_url . 'account-icon-outline.svg',
			'outline-round' => $image_url . 'account-icon-outline-round.svg',
		),
	)
);

Flatsome_Option::add_field( 'option',
	array(
		'type'      => 'text',
		'settings'  => 'header_newsletter_label',
		'label'     => __( 'Label', 'flatsome-admin' ),
		'section'   => 'header_newsletter',
		'transport' => $transport,
		'default'   => 'Newsletter',
	)
);

Flatsome_Option::add_field( 'option',
	array(
		'type'        => 'select',
		'settings'    => 'header_newsletter_block',
		'label'       => __( 'Newsletter Block', 'flatsome-admin' ),
		'description' => __( 'Replace newsletter pop-up content with a custom Block that can be edited in UX Builder.' ),
		'section'     => 'header_newsletter',
		'default'     => false,
		'choices'     => $blocks,
	)
);

Flatsome_Option::add_field( 'option',
	array(
		'type'            => 'text',
		'settings'        => 'header_newsletter_title',
		'active_callback' => array(
			array(
				'setting'  => 'header_newsletter_block',
				'operator' => '==',
				'value'    => false,
			),
		),
		'label'           => __( 'Title', 'flatsome-admin' ),
		'section'         => 'header_newsletter',
		'transport'       => $transport,
		'default'         => 'Sign up for Newsletter',
	)
);

Flatsome_Option::add_field( 'option',
	array(
		'type'              => 'text',
		'settings'          => 'header_newsletter_sub_title',
		'active_callback'   => array(
			array(
				'setting'  => 'header_newsletter_block',
				'operator' => '==',
				'value'    => false,
			),
		),
		'label'             => __( 'Sub Title', 'flatsome-admin' ),
		'section'           => 'header_newsletter',
		'transport'         => $transport,
		'sanitize_callback' => 'flatsome_custom_sanitize',
		'default'           => 'Signup for our newsletter to get notified about sales and new products. Add any text here or remove it.',
	)
);

Flatsome_Option::add_field( 'option',
	array(
		'type'              => 'text',
		'settings'          => 'header_newsletter_shortcode',
		'active_callback'   => array(
			array(
				'setting'  => 'header_newsletter_block',
				'operator' => '==',
				'value'    => false,
			),
		),
		'label'             => __( 'Form Shortcode', 'flatsome-admin' ),
		'description'       => __( 'Insert any form shortcode here.', 'flatsome-admin' ),
		'section'           => 'header_newsletter',
		'sanitize_callback' => 'flatsome_custom_sanitize',
		'transport'         => $transport,
	)
);

Flatsome_Option::add_field( 'option',
	array(
		'type'            => 'image',
		'settings'        => 'header_newsletter_bg',
		'active_callback' => array(
			array(
				'setting'  => 'header_newsletter_block',
				'operator' => '==',
				'value'    => false,
			),
		),
		'label'           => __( 'Background Image', 'flatsome-admin' ),
		'section'         => 'header_newsletter',
		'transport'       => $transport,
	)
);

Flatsome_Option::add_field( 'option',
	array(
		'type'            => 'text',
		'settings'        => 'header_newsletter_height',
		'active_callback' => array(
			array(
				'setting'  => 'header_newsletter_block',
				'operator' => '==',
				'value'    => false,
			),
		),
		'label'           => __( 'Height', 'flatsome-admin' ),
		'section'         => 'header_newsletter',
		'default'         => '500px',
		'transport'       => $transport,
	)
);

Flatsome_Option::add_field( '',
	array(
		'type'     => 'custom',
		'settings' => 'custom_title_header_newsletter_behavior',
		'label'    => __( '', 'flatsome-admin' ),
		'section'  => 'header_newsletter',
		'default'  => '<div class="options-title-divider">Behavior</div>',
	)
);

Flatsome_Option::add_field( 'option',
	array(
		'type'      => 'checkbox',
		'settings'  => 'header_newsletter_auto_open',
		'label'     => __( 'Auto Open', 'flatsome-admin' ),
		'section'   => 'header_newsletter',
		'transport' => $transport,
		'default'   => false,
	)
);

Flatsome_Option::add_field( 'option',
	array(
		'type'            => 'slider',
		'settings'        => 'header_newsletter_auto_timer',
		'active_callback' => array(
			array(
				'setting'  => 'header_newsletter_auto_open',
				'operator' => '==',
				'value'    => true,
			),
		),
		'label'           => __( 'Auto Timer', 'flatsome-admin' ),
		'description'     => __( 'In milliseconds (1000ms = 1sec).', 'flatsome-admin' ),
		'section'         => 'header_newsletter',
		'transport'       => $transport,
		'default'         => 3000,
		'choices'         => array(
			'min'  => 1000,
			'max'  => 60000,
			'step' => 500,
		),
	)
);

Flatsome_Option::add_field( 'option',
	array(
		'type'            => 'select',
		'settings'        => 'header_newsletter_auto_show',
		'active_callback' => array(
			array(
				'setting'  => 'header_newsletter_auto_open',
				'operator' => '==',
				'value'    => true,
			),
		),
		'label'           => __( 'Auto Show', 'flatsome-admin' ),
		'section'         => 'header_newsletter',
		'transport'       => $transport,
		'default'         => 'always',
		'multiple'        => 0,
		'choices'         => array(
			'always' => __( 'Always', 'flatsome-admin' ),
			'once'   => __( 'Once', 'flatsome-admin' ),
		),
	)
);

function flatsome_refresh_header_newsletter_partials( WP_Customize_Manager $wp_customize ) {

	// Abort if selective refresh is not available.
	if ( ! isset( $wp_customize->selective_refresh ) ) {
		return;
	}

	$wp_customize->selective_refresh->add_partial( 'header-newsletter',
		array(
			'selector'            => '.header-newsletter-item',
			'container_inclusive' => true,
			'settings'            => array(
				'header_newsletter_height',
				'header_newsletter_bg',
				'header_newsletter_sub_title',
				'header_newsletter_label',
				'header_newsletter_shortcode',
				'newsletter_icon_style',
				'header_newsletter_title',
			),
			'render_callback'     => function () {
				get_template_part( 'template-parts/header/partials/element', 'newsletter' );
			},
		)
	);
}

add_action( 'customize_register', 'flatsome_refresh_header_newsletter_partials' );
