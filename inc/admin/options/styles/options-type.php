<?php

Flatsome_Option::add_section( 'type',
	array(
		'title' => __( 'Typography', 'flatsome-admin' ),
		'panel' => 'style',
	)
);

Flatsome_Option::add_field( 'option',
	array(
		'type'     => 'checkbox',
		'settings' => 'disable_fonts',
		'label'    => __( 'Disable Google Fonts. No fonts will be loaded from Google.', 'flatsome-admin' ),
		'section'  => 'type',
		'default'  => 0,
	)
);

Flatsome_Option::add_field( 'option',
	array(
		'type'            => 'select',
		'settings'        => 'googlefonts_font_display',
		'label'           => __( 'Google Fonts font-display type', 'flatsome-admin' ) . ' (NEW)',
		'description'     => 'Choose how Google Fonts will be loaded.',
		'tooltip'         => '<ul>
								<li><span style="font-weight: bold">block</span> flash of invisible text until the font loads</li>
								<li><span style="font-weight: bold">swap</span> fallback font until custom font loads (flash of unstyled text)</li>
								<li><span style="font-weight: bold">fallback</span> between block and swap, invisible text for a short time</li>
								<li><span style="font-weight: bold">optional</span> like fallback, but the browser can decide to not use the custom font</li>
							</ul>',
		'section'         => 'type',
		'active_callback' => array(
			array(
				'setting'  => 'disable_fonts',
				'operator' => '==',
				'value'    => false,
			),
		),
		'default'         => 'swap',
		'choices'         => array(
			'block'    => __( 'Block', 'flatsome-admin' ),
			'swap'     => __( 'Swap', 'flatsome-admin' ),
			'fallback' => __( 'Fallback', 'flatsome-admin' ),
			'optional' => __( 'Optional', 'flatsome-admin' ),
		),
	)
);

Flatsome_Option::add_field( '',
	array(
		'type'     => 'custom',
		'settings' => 'custom_title_type_headings',
		'label'    => __( '', 'flatsome-admin' ),
		'section'  => 'type',
		'default'  => '<div class="options-title-divider">Headlines</div>',
		'active_callback' => array(
			array(
				'setting'  => 'disable_fonts',
				'operator' => '==',
				'value'    => false,
			),
		),
	)
);

Flatsome_Option::add_field( 'option',
	array(
		'type'        => 'typography',
		'settings'    => 'type_headings',
		'description' => 'This is the font for all H1, H2, H3, H5, H6 titles.',
		'label'       => esc_attr__( 'Font', 'flatsome-admin' ),
		'section'     => 'type',
		'default'     => array(
			'font-family' => 'Lato',
			'variant'     => '700',
		),
		'active_callback' => array(
			array(
				'setting'  => 'disable_fonts',
				'operator' => '==',
				'value'    => false,
			),
		),
	)
);


Flatsome_Option::add_field( '',
	array(
		'type'     => 'custom',
		'settings' => 'custom_title_type_base',
		'label'    => __( '', 'flatsome-admin' ),
		'section'  => 'type',
		'default'  => '<div class="options-title-divider">Base</div>',
		'active_callback' => array(
			array(
				'setting'  => 'disable_fonts',
				'operator' => '==',
				'value'    => false,
			),
		),

	)
);

Flatsome_Option::add_field( 'option',
	array(
		'type'     => 'typography',
		'settings' => 'type_texts',
		'label'    => esc_attr__( 'Base Text Font', 'flatsome-admin' ),
		'section'  => 'type',
		'default'  => array(
			'font-family' => 'Lato',
			'variant'     => '400',
		),
		'active_callback' => array(
			array(
				'setting'  => 'disable_fonts',
				'operator' => '==',
				'value'    => false,
			),
		),
	)
);

Flatsome_Option::add_field( 'option',
	array(
		'type'        => 'slider',
		'settings'    => 'type_size',
		'label'       => __( 'Base Font Size', 'flatsome-admin' ),
		'section'     => 'type',
		'description' => 'Set base font size in %.',
		'default'     => 100,
		'choices'     => array(
			'min'  => 50,
			'max'  => 200,
			'step' => 1,
		),
		'transport'   => 'postMessage',
		'active_callback' => array(
			array(
				'setting'  => 'disable_fonts',
				'operator' => '==',
				'value'    => false,
			),
		),
	)
);

Flatsome_Option::add_field( 'option',
	array(
		'type'        => 'slider',
		'settings'    => 'type_size_mobile',
		'label'       => __( 'Mobile Base Font Size', 'flatsome-admin' ),
		'section'     => 'type',
		'description' => 'Set mobile base font size in %.',
		'default'     => 100,
		'choices'     => array(
			'min'  => 50,
			'max'  => 200,
			'step' => 1,
		),
		'transport'   => 'postMessage',
		'active_callback' => array(
			array(
				'setting'  => 'disable_fonts',
				'operator' => '==',
				'value'    => false,
			),
		),
	)
);

Flatsome_Option::add_field( '',
	array(
		'type'     => 'custom',
		'settings' => 'custom_title_type_nav',
		'label'    => __( '', 'flatsome-admin' ),
		'section'  => 'type',
		'default'  => '<div class="options-title-divider">Navigation</div>',
		'active_callback' => array(
			array(
				'setting'  => 'disable_fonts',
				'operator' => '==',
				'value'    => false,
			),
		),
	)
);

Flatsome_Option::add_field( 'option',
	array(
		'type'      => 'typography',
		'settings'  => 'type_nav',
		'label'     => esc_attr__( 'Font', 'flatsome-admin' ),
		'section'   => 'type',
		'default'   => array(
			'font-family' => 'Lato',
			'variant'     => '700',
		),
		'active_callback' => array(
			array(
				'setting'  => 'disable_fonts',
				'operator' => '==',
				'value'    => false,
			),
		),
	)
);

Flatsome_Option::add_field( '',
	array(
		'type'     => 'custom',
		'settings' => 'custom_title_type_alt',
		'label'    => __( '', 'flatsome-admin' ),
		'section'  => 'type',
		'default'  => '<div class="options-title-divider">Alt Fonts</div>',
		'active_callback' => array(
			array(
				'setting'  => 'disable_fonts',
				'operator' => '==',
				'value'    => false,
			),
		),
	)
);

Flatsome_Option::add_field( 'option',
	array(
		'type'        => 'typography',
		'settings'    => 'type_alt',
		'description' => 'Alt font can be selected in the Format dropdown in Text Editor.',
		'label'       => esc_attr__( 'Alt font (.alt-font)', 'flatsome-admin' ),
		'section'     => 'type',
		'default'     => array(
			'font-family' => 'Dancing Script',
			'variant'     => '400',
		),
		'active_callback' => array(
			array(
				'setting'  => 'disable_fonts',
				'operator' => '==',
				'value'    => false,
			),
		),
	)
);

Flatsome_Option::add_field( '',
	array(
		'type'     => 'custom',
		'settings' => 'custom_title_type_transform',
		'label'    => __( '', 'flatsome-admin' ),
		'section'  => 'type',
		'default'  => '<div class="options-title-divider">Text Transforms</div>',
	)
);

Flatsome_Option::add_field( 'option',
	array(
		'type'      => 'radio-buttonset',
		'settings'  => 'text_transform_breadcrumbs',
		'label'     => esc_attr__( 'Breadcrumbs', 'flatsome-admin' ),
		'section'   => 'type',
		'default'   => '',
		'choices'   => array(
			''     => 'UPPERCASE',
			'none' => 'Normal',
		),
	)
);

Flatsome_Option::add_field( 'option',
	array(
		'type'      => 'radio-buttonset',
		'settings'  => 'text_transform_buttons',
		'label'     => esc_attr__( 'Buttons', 'flatsome-admin' ),
		'section'   => 'type',
		'default'   => '',
		'choices'   => array(
			''     => 'UPPERCASE',
			'none' => 'Normal',
		),
	)
);

Flatsome_Option::add_field( 'option',
	array(
		'type'      => 'radio-buttonset',
		'settings'  => 'text_transform_navigation',
		'label'     => esc_attr__( 'Navigation / Tabs', 'flatsome-admin' ),
		'section'   => 'type',
		'default'   => '',
		'choices'   => array(
			''     => 'UPPERCASE',
			'none' => 'Normal',
		),
	)
);

Flatsome_Option::add_field( 'option',
	array(
		'type'      => 'radio-buttonset',
		'settings'  => 'text_transform_section_titles',
		'label'     => esc_attr__( 'Section Titles', 'flatsome-admin' ),
		'section'   => 'type',
		'default'   => '',
		'choices'   => array(
			''     => 'UPPERCASE',
			'none' => 'Normal',
		),
	)
);

Flatsome_Option::add_field( 'option',
	array(
		'type'      => 'radio-buttonset',
		'settings'  => 'text_transform_widget_titles',
		'label'     => esc_attr__( 'Widget Titles', 'flatsome-admin' ),
		'section'   => 'type',
		'default'   => '',
		'choices'   => array(
			''     => 'UPPERCASE',
			'none' => 'Normal',
		),
	)
);
