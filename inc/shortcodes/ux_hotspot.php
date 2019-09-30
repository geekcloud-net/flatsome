<?php
// [ux_hotspot]
function ux_hotspot( $atts, $content = null ) {
	extract( shortcode_atts( array(
		'class'          => '',
		'visibility'     => '',
		'type'           => 'text',
		'text'           => 'Enter text here',
		'link'           => '#hotspot',
		'bg_color'       => '',
		'position_x'     => '50',
		'position_x__sm' => '',
		'position_x__md' => '',
		'position_y'     => '50',
		'position_y__sm' => '',
		'position_y__md' => '',
		'size'           => '',
		'icon'           => 'plus',
		'depth'          => '',
		'depth_hover'    => '',
		'animate'        => 'bounceIn',
		'prod_id'        => '149',
	), $atts ) );

	$classes       = array( 'hotspot-wrapper' );
	$classes_inner = array( 'hotspot tooltip' );

	if ( $class ) {
		$classes[] = $class;
	}
	if ( $visibility ) {
		$classes[] = $visibility;
	}

	// Set positions.
	$classes[] = flatsome_position_classes( 'x', $position_x, $position_x__sm, $position_x__md );
	$classes[] = flatsome_position_classes( 'y', $position_y, $position_y__sm, $position_y__md );

	// Size.
	if ( $size ) {
		$classes[] = 'is-' . $size;
	}

	$classes = implode( ' ', $classes );

	if ( $depth ) {
		$classes_inner[] = 'box-shadow-' . $depth;
	}
	if ( $depth_hover ) {
		$classes_inner[] = 'box-shadow-' . $depth . '-hover';
	}

	$classes_inner = implode( ' ', $classes_inner );

	$css_args = array(
		'bg_color' => array(
			'attribute' => 'background-color',
			'value'     => $bg_color,
		),
	);

	// load quick view script for products.
	if ( $type == 'product' && ! get_theme_mod( 'disable_quick_view' ) ) {
		wp_enqueue_script( 'wc-add-to-cart-variation' );
	}
	?>
	<div class="<?php echo $classes; ?> dark">
		<div data-animate="<?php echo $animate; ?>">
			<?php if ( $type == 'text' ) { ?>
				<a href="<?php echo $link; ?>" class="<?php echo $classes_inner; ?>" title="<?php echo $text; ?>" <?php echo get_shortcode_inline_css( $css_args ); ?>>
					<i class="icon-<?php echo $icon; ?>"></i>
				</a>
			<?php } else if ( $type == 'product' ) {
				if ( get_theme_mod( 'disable_quick_view' ) ) : ?>
					<a href="<?php echo esc_url( get_permalink( $prod_id ) ); ?>" class="<?php echo $classes_inner; ?>" title="<?php echo get_the_title( $prod_id ); ?>" <?php echo get_shortcode_inline_css( $css_args ); ?>>
						<i class="icon-<?php echo $icon; ?>"></i>
					</a>
				<?php else : ?>
					<a href="#quick-view" class="<?php echo $classes_inner; ?> quick-view" data-prod="<?php echo $prod_id; ?>" title="<?php echo get_the_title( $prod_id ); ?>" <?php echo get_shortcode_inline_css( $css_args ); ?>>
						<i class="icon-<?php echo $icon; ?>"></i>
					</a>
				<?php endif; ?>
			<?php } ?>
		</div>
	</div>
	<?php
}

add_shortcode( 'ux_hotspot', 'ux_hotspot' );
