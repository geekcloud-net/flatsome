<?php

global $wc;

Flatsome_Option::add_section( 'fl-my-account', array(
	'title'       => __( 'My Account', 'flatsome-admin' ),
	'panel' => 'woocommerce'
) );

Flatsome_Option::add_field( 'option',  array(
	'type'        => 'image',
	'settings'     => 'facebook_login_bg',
	'label'       => __( 'Title background', 'flatsome-admin' ),
	'section'     => 'fl-my-account',
	'transport' => $transport,
	'default'     => ''
));

Flatsome_Option::add_field( 'option',  array(
	'type'        => 'text',
	'settings'     => 'facebook_login_text',
	'transport' => $transport,
	'label'       => __( 'Login Text', 'flatsome-admin' ),
	'description' => __( '', 'flatsome-admin' ),
	'section'     => 'fl-my-account',
	'sanitize_callback' => 'flatsome_custom_sanitize',
));

Flatsome_Option::add_field( 'option',  array(
  'type'        => 'select',
  'settings'     => 'account_login_style',
  'label'       => __( 'Login Style', 'flatsome-admin' ),
  'section'     => 'fl-my-account',
  'transport' => $transport,
  'default'     => 'lightbox',
  'choices'     => array(
    'link' => __( 'Link', 'flatsome-admin' ),
    'lightbox' => __( 'Lightbox', 'flatsome-admin' ),
  ),
));

Flatsome_Option::add_field( 'option',  array(
  'type'        => 'select',
  'settings'     => 'social_login_pos',
  'label'       => __( 'Social Button', 'flatsome-admin' ),
  'description' => __( 'Change position of Social Login Buttons in lightbox.', 'flatsome-admin' ),
  'section'     => 'fl-my-account',
  'default'     => 'top',
  'choices'     => array(
    'top' => __( 'Top', 'flatsome-admin' ),
    'bottom' => __( 'Bottom', 'flatsome-admin' ),
  ),
));


Flatsome_Option::add_field( 'option',  array(
  'type'        => 'checkbox',
  'settings'     => 'wc_account_links',
  'label'       => __( 'Enable default WooCommerce Account links in Dropdown and Account Sidebar. You can create a custom my account menu instead if you want.', 'flatsome-admin' ),
  'section'     => 'fl-my-account',
  'default'     => 1,
));


Flatsome_Option::add_field( '', array(
  'type'        => 'custom',
  'settings' => 'custom_html_account_shortcut',
  'label'       => __( '', 'flatsome-admin' ),
  'section'     => 'fl-my-account',
  'default'     => '<button style="margin-top:30px; margin-bottom:15px" class="button button-primary" data-to-section="header_account">Header Element →</button>',
) );
