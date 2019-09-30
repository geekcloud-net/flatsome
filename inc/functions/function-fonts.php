<?php // @codingStandardsIgnoreLine

/**
 * Parses the Google Font api link.
 *
 * @return string The link
 */
function flatsome_get_google_fonts_link() {
	$type_headings = get_theme_mod( 'type_headings', array( 'font-family' => 'Lato', 'variant' => '700' ) );
	$type_texts    = get_theme_mod( 'type_texts', array( 'font-family' => 'Lato', 'variant' => '400' ) );
	$type_nav      = get_theme_mod( 'type_nav', array( 'font-family' => 'Lato', 'variant' => '700' ) );
	$type_alt      = get_theme_mod( 'type_alt', array( 'font-family' => 'Dancing Script', 'variant' => '400' ) );

	// Fix old.
	if ( ! is_array( $type_nav ) ) {
		$type_nav = array( 'font-family' => $type_nav, 'variant' => 'default' );
	}
	if ( ! is_array( $type_texts ) ) {
		$type_texts = array( 'font-family' => $type_texts, 'variant' => 'default' );
	}
	if ( ! is_array( $type_alt ) ) {
		$type_alt = array( 'font-family' => $type_alt, 'variant' => 'default' );
	}
	if ( ! is_array( $type_headings ) ) {
		$type_headings = array( 'font-family' => $type_headings, 'variant' => 'default' );
	}

	$fonts     = array( $type_headings, $type_texts, $type_nav, $type_alt );
	$font_list = array();
	$subsets   = array();

	// Insert fonts.
	foreach ( $fonts as $font ) {

		// Add Fonts.
		if ( isset( $font['font-family'] ) ) {
			if ( ! isset( $font['variant'] ) ) {
				$font['variant'] = 'default';
			}
			$font_list[ $font['font-family'] ][] = $font['variant'];
		}

		// Add Subsets.
		if ( isset( $font['subset'] ) ) {
			if ( ! is_array( $font['subset'] ) ) {
				$subsets[] = $font['subset'];
			} else {
				foreach ( $font['subset'] as $subset ) {
					$subsets[] = $subset;
				}
			}
		}
	}

	$link_fonts = array();
	foreach ( $font_list as $font => $variants ) {
		$variants = implode( ',', $variants );

		$link_font = str_replace( ' ', '+', $font );
		if ( ! empty( $variants ) ) {
			// Always include regular variant as a workaround for Kirki
			// not updating the variant when font has only one variant.
			$link_font .= ':regular,' . $variants;
		}
		$link_fonts[] = $link_font;
	}

	$link  = '//fonts.googleapis.com/css?family=';
	$link .= implode( '|', $link_fonts );

	if ( ! empty( $subsets ) ) {
		$subsets = array_unique( $subsets );
		$link   .= '&subset=' . implode( ',', $subsets );
	}

	$link .= '&display=' . get_theme_mod( 'googlefonts_font_display', 'swap' );

	return $link;
}

/**
 * Add google font style when not disabled.
 */
function flatsome_google_fonts() {
	if ( get_theme_mod( 'disable_fonts', 0 ) ) {
		return;
	}

	wp_enqueue_style( 'flatsome-googlefonts', flatsome_get_google_fonts_link(), array(), '3.9' );
}

add_action( 'wp_enqueue_scripts', 'flatsome_google_fonts', 9999 );
