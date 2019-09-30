<?php

$repeater_type = 'row';
$default_text_align = 'left';

$options = array(
'pages_options' => array(
    'type' => 'group',
    'heading' => __( 'Options' ),
    'options' => array(
      'ids' => array(
        'type' => 'gallery',
        'heading' => __( 'Images' ),
      ),
     'style' => array(
            'type' => 'select',
            'heading' => __( 'Style' ),
            'default' => 'overlay',
            'options' => require( __DIR__ . '/values/box-layouts.php' )
     ),
    'lightbox' => array(
          'type' => 'radio-buttons',
          'heading' => __('Open in Lightbox'),
          'default' => 'true',
          'options' => array(
              'false'  => array( 'title' => 'Off'),
              'true'  => array( 'title' => 'On'),
          ),
      ),

	'lightbox_image_size' => array(
	    'type'       => 'select',
	    'heading'    => __( 'Lightbox Image Size' ),
	    'conditions' => 'lightbox == "true"',
	    'default'    => '',
	    'options'    => array(
	        ''          => 'Default',
	        'large'     => 'Large',
	        'medium'    => 'Medium',
	        'thumbnail' => 'Thumbnail',
	        'original'  => 'Original',
	    ),
    ),

  ),
),
'layout_options' => require( __DIR__ . '/commons/repeater-options.php' ),
'layout_options_slider' => require( __DIR__ . '/commons/repeater-slider.php' ),
);

$box_styles = require( __DIR__ . '/commons/box-styles.php' );
$options = array_merge($options, $box_styles);

add_ux_builder_shortcode( 'ux_gallery', array(
  'name' => __( 'Gallery','ux-builder'),
  'category' => __( 'Content' ),
  'thumbnail' => flatsome_ux_builder_thumbnail( 'ux_gallery' ),
  'scripts' => array(
    'flatsome-masonry-js' => get_template_directory_uri() .'/assets/libs/packery.pkgd.min.js',
  ),
  'presets' => array(
    array(
      'name' => __( 'Default' ),
      'content' => '[ux_gallery]',
      ),
    ),
    'options' => $options
) );
