<?php

function get_flatsome_icon($name, $size = null){
  if($size) $size = 'style="font-size:'.$size.';"';
  return '<i class="'.$name.'" '.$size.'></i>';
}

function flatsome_add_icons_css() {
  wp_enqueue_style( 'flatsome-icons', get_template_directory_uri() .'/assets/css/fl-icons.css', array(), '3.3', 'all' );
}
add_action( 'wp_enqueue_scripts', 'flatsome_add_icons_css' );