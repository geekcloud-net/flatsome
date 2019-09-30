<?php
/**
 * Ubermenu plugin integration
 */

/**
 *  Adds a extra separate full width menu header bar with Ubermenu.
 *  Renders: Main menu for desktop and mobile menu (if set) on tablet/mobile.
 */
function flatsome_uber_menu() {
	if ( ! get_theme_mod( 'flatsome_uber_menu', 1 ) ) {
		return;
	}
	$has_mobile_menu = has_nav_menu( 'primary_mobile' );
	$hide_for_medium = $has_mobile_menu ? 'hide-for-medium' : '';
	?>
	<div id="flatsome-uber-menu" class="header-ubermenu-nav relative <?php echo $hide_for_medium; ?>" style="z-index: 9">
		<div class="full-width">
			<?php ubermenu( 'main', array( 'theme_location' => 'primary' ) ); ?>
		</div>
	</div>
	<?php if ( $has_mobile_menu ) : ?>
		<div id="flatsome-uber-menu" class="header-ubermenu-nav relative show-for-medium" style="z-index: 9">
			<div class="full-width">
				<?php ubermenu( 'main', array( 'theme_location' => 'primary_mobile' ) ); ?>
			</div>
		</div>
	<?php endif; ?>
	<?php
}
add_action( 'flatsome_after_header_bottom', 'flatsome_uber_menu', 10 );
