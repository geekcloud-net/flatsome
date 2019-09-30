<?php

// Get Mobile Sidebar Menu
function flatsome_mobile_menu(){
   get_template_part('template-parts/overlays/overlay','menu');
}
add_action('wp_footer', 'flatsome_mobile_menu', 7);


function flatsome_footer_row_style($footer){
	$classes = array('row');
	if($footer == 'footer-1'){
		$columns = get_theme_mod('footer_1_columns', 4);

		if($columns == 'large-3'){
			$columns = '4';
		}
		if($columns == 'large-2'){
			$columns = '6';
		}
		if($columns == 'large-12'){
			$columns = '1';
		}
		if($columns == 'large-4'){
			$columns = '3';
		}

		if(get_theme_mod('footer_1_color') == 'dark') $classes[] = 'dark';
		 $classes[] = 'large-columns-'.$columns;
	}
	if($footer == 'footer-2'){
		$columns = get_theme_mod('footer_2_columns', 4);
		if($columns == 'large-3'){
			$columns = '4';
		}
		if($columns == 'large-2'){
			$columns = '6';
		}
		if($columns == 'large-12'){
			$columns = '1';
		}
		if($columns == 'large-4'){
			$columns = '3';
		}
		if(get_theme_mod('footer_2_color', 'dark') == 'dark') $classes[] = 'dark';
		$classes[] = 'large-columns-'.$columns;
	}

	return implode(' ', $classes);
}

function flatsome_page_footer(){
	$block = get_theme_mod( 'footer_block' );

	if ( is_page() ) {
		// Custom Page footers.
		$page_footer = get_post_meta( get_the_ID(), '_footer', true );
		$default     = empty( $page_footer ) || $page_footer == 'normal';

		if ( $page_footer !== 'disabled' ) {
			if ( ! $block ) {
				if ( $default ) {
					get_template_part( 'template-parts/footer/footer' );
				} elseif ( ! empty( $page_footer ) ) {
					get_template_part( 'template-parts/footer/footer', $page_footer );
				}
			} else {
				echo do_shortcode( '[block id="' . $block . '"]' );
				get_template_part( 'template-parts/footer/footer-absolute' );
			}
		}
	} else {
		// Global footer.
		if ( $block ) {
			echo do_shortcode( '[block id="' . $block . '"]' );
			get_template_part( 'template-parts/footer/footer-absolute' );
		} else {
			get_template_part( 'template-parts/footer/footer' );
		}
	}
}

add_action( 'flatsome_footer', 'flatsome_page_footer', 10 );


// Add Top Link
function flatsome_go_to_top(){
	if(!get_theme_mod('back_to_top', 1)) return;
	get_template_part('template-parts/footer/back-to-top');
}
add_action( 'flatsome_footer', 'flatsome_go_to_top');


/* Custom footer scripts */
function flatsome_footer_scripts(){
  echo do_shortcode(get_theme_mod('html_scripts_footer'));
}
add_action('wp_footer', 'flatsome_footer_scripts');

/* Insert custom body bottom script */
function flatsome_before_body_close() {
	if ( get_theme_mod( 'html_scripts_before_body' ) && ! is_admin() ) {
		echo get_theme_mod( 'html_scripts_before_body' ); // WPCS: XSS ok.
	}
}

add_action( 'wp_footer', 'flatsome_before_body_close', apply_filters( 'flatsome_before_body_close_priority', 9999 ) );


// Custom HTML Before footer
function flatsome_html_before_footer(){
  $html_before = get_theme_mod('html_before_footer');
  if($html_before){
    echo do_shortcode($html_before);
  }
}
add_action('flatsome_before_footer', 'flatsome_html_before_footer');

// Custom HMTL After footer
function flatsome_html_after_footer(){
	$html_after = get_theme_mod('html_after_footer');
	if($html_after){
	 echo do_shortcode($html_after);
	}
}
add_action('flatsome_after_footer', 'flatsome_html_after_footer');
