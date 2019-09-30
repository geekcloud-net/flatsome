<?php

// [gap]
function flatsome_gap_shortcode( $atts, $content = null ){
  extract( shortcode_atts( array(
    'height' => '30px',
    'class' => '',
    'visibility' => '',
  ), $atts ) );

	$classes	= array( 'gap-element' , 'clearfix' );
	
	if( $class ) $classes[] = $class;
	if( $visibility ) $classes[] = $visibility;
	$classes = implode(' ', $classes);

	return '<div class="'.$classes.'" style="display:block; height:auto; padding-top:'.$height.'"></div>';

}
add_shortcode('gap', 'flatsome_gap_shortcode');