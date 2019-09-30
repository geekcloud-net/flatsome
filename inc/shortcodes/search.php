<?php

// [search]
function search_shortcode($atts) {
	extract(shortcode_atts(array(
		'size' => 'normal',
		'style' => '',
		'class' => '',
		'visibility' => ''
	), $atts));

		$classes	= array( 'searchform-wrapper' , 'ux-search-box', 'relative' );
		
		if( $class ) $classes[] = $class;
		if( $visibility ) $classes[] = $visibility;
		if( $style ) $classes[] = 'form-'.$style;
		if( $size ) $classes[] = 'is-'.$size;
		$classes = implode(' ', $classes);

    ob_start();

    echo '<div class="'. $classes. '">';
	 	 if(function_exists('get_product_search_form')) {
	        get_product_search_form();
	    } else {
	        get_search_form();
	    }
 	echo '</div>';
 	
 	$content = ob_get_contents();
    ob_end_clean();
    return $content;
}
add_shortcode("search", "search_shortcode");