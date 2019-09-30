<?php
/**
 * Accordion Shortcode
 *
 * Accordion and Accordion Item Shortcode builder.
 *
 * @author UX Themes
 * @package Flatsome/Shortcodes/Accordion
 * @version 3.9.0
 */

/**
 * Output the accordion shortcode.
 *
 * @param array  $atts Shortcode attributes.
 * @param string $content Accordion content.
 *
 * @return string.
 */
function ux_accordion( $atts, $content = null ) {
	extract(shortcode_atts(array(
		'auto_open' => '',
		'open'      => '',
		'title'     => '',
		'class'     => '',
	), $atts));

	if ($auto_open) $open = 1;

	$classes                 = array( 'accordion' );
	if ( $class ) $classes[] = $class;

	if ($title) $title = '<h3 class="accordion_title">' . $title . '</h3>';
	return $title . '<div class="' . implode( ' ', $classes ) . '" rel="' . $open . '">' . flatsome_contentfix( $content ) . '</div>';
}
add_shortcode( 'accordion', 'ux_accordion' );


/**
 * Output the accordion-item shortcode.
 *
 * @param array  $atts Shortcode attributes.
 * @param string $content Accordion content.
 *
 * @return string.
 */
function ux_accordion_item( $atts, $content = null ) {
	extract(shortcode_atts(array(
		'title' => 'Accordion Panel',
		'class' => '',
	), $atts));
	$classes                 = array( 'accordion-item' );
	if ( $class ) $classes[] = $class;
	return '<div class="' . implode( ' ', $classes ) . '"><a href="#" class="accordion-title plain"><button class="toggle"><i class="icon-angle-down"></i></button><span>' . $title . '</span></a><div class="accordion-inner">' . flatsome_contentfix( $content ) . '</div></div>';
}
add_shortcode( 'accordion-item', 'ux_accordion_item' );
