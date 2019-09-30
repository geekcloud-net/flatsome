<?php
// [logo img=""]
function ux_logo( $atts, $content = null ){
    extract( shortcode_atts( array(
      'class' => '',
      'visibility' => '',
      'img' => '',
      'padding' => '15px',
      'title' => '',
      'hover' => '',
      'link' => '',
      'target' => '_self',
      'rel' => '',
      'height' => '50',
    ), $atts ) );

    $classes = array('ux-logo', 'has-hover', 'align-middle', 'ux_logo', 'inline-block');
    if ( $class ) $classes[] = $class;
    if ( $visibility ) $classes[] = $visibility;
    
  	$height    = intval( $height );
  	$width     = 'auto';
  	$link_atts = array(
  		'target' => $target,
  		'rel'    => array( $rel ),
  	);

    if(!$img){
      $org_img = get_template_directory_uri().'/assets/img/logo.png';
      $width = ($height / 84) * 400 + (intval($padding)*2).'px';
    }

    if ($img && !is_numeric($img)) {
      $org_img = $img;
    } else if($img) {
      $img = wp_get_attachment_image_src($img, 'small');
      $org_img = $img[0];
      $org_height = $img[2];
      // Check if width and height is set, because svg images has no size.
      if ( $img[1] > 0 && $img[2] > 0 ) {
        $width = $img[1];
        $width = (intval($height) / intval($org_height)) * intval($width) + (intval($padding)*2).'px';
      } else {
        $width = 'auto';
      }
    }

    // Set inner tag
    $inner_tag = $link ? 'a' : 'div';

    $content = '<div class="'.implode(' ', $classes).'" style="max-width: 100%!important; width: '.$width.'!important"><'.$inner_tag.' class="ux-logo-link block image-'.$hover.'" title="'.$title.'"' . flatsome_parse_target_rel( $link_atts ) . 'href="'.$link.'" style="padding: '.$padding.';"><img src="'.$org_img.'" title="'.$title.'" alt="'.$title.'" class="ux-logo-image block" style="height:'.$height.'px;" /></'.$inner_tag.'></div>';

    return $content;
}
add_shortcode('logo', 'ux_logo');
