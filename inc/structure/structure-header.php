<?php
/**
 * Flatsome Structure.
 *
 * Header Structure.
 *
 * @package Flatsome\Structures
 */


/**
 * Header Viewport Meta.
 *
 * @return void
 */
function flatsome_viewport_meta() {
	echo apply_filters( 'flatsome_viewport_meta', '<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
}

add_action( 'wp_head', 'flatsome_viewport_meta', 1 );

/**
 * Header Navigation.
 *
 * @param string $nav    Navigation menu position.
 * @param bool   $walker Navigation Class.
 *
 * @return void
 */
function flatsome_header_nav( $nav, $walker = false ) {

	$admin_url = get_admin_url() . 'customize.php?url=' . get_permalink() . '&autofocus%5Bsection%5D=menu_locations';

	// Check if has Custom mobile menu.
	if ($nav == 'primary' && $walker == 'FlatsomeNavSidebar' && has_nav_menu( 'primary_mobile' )) $nav = 'primary_mobile';

	// If single page
	$page_template = get_post_meta( get_the_ID(), '_wp_page_template', true );
	$default_template = get_theme_mod('pages_template', 'default');

	// Add single page nav helper.
	if((strpos($page_template, 'single-page-nav') !== false || ((empty($page_template) || strpos($page_template, 'default') !== false) && strpos($default_template, 'single-page-nav') !== false)) && $nav == 'primary') { ?>
	<li class="nav-single-page hidden"></li>
	<?php
	} elseif ( has_nav_menu( $nav ) ) {

		wp_nav_menu(array(
			'theme_location' => $nav,
			'container'      => false,
			'items_wrap'     => '%3$s',
			'depth'          => 0,
			'walker'         => new $walker(),
		));

	} else {
		echo '<li><a href="' . $admin_url . '">Assign a menu in Theme Options > Menus</a></li>'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
	}
}

/**
 * Navigation Builder.
 *
 * @param string $options Theme options.
 * @param string $type    Navigation type.
 *
 * @return void
 */
function flatsome_header_elements( $options, $type = '' ) {
	// Get options.
	$get_options = get_theme_mod( $options );

	$walker                         = 'FlatsomeNavDropdown';
	if ($type == 'sidebar') $walker = 'FlatsomeNavSidebar';

	// Set options.
	if ( is_array( $get_options ) ) {

		foreach ( $get_options as $key => $value ) {

			if ( $value == 'divider' || $value == 'divider_2' || $value == 'divider_3' || $value == 'divider_4' || $value == 'divider_5' ) {
				echo '<li class="header-divider"></li>';
			} elseif ( $value == 'html' || $value == 'html-2' || $value == 'html-3' || $value == 'html-4' || $value == 'html-5' ) {
				flatsome_get_header_html_element( $value );
			} elseif ( $value == 'block-1' || $value == 'block-2' ) {
				echo do_shortcode( '<li class="header-block"><div class="header-block-' . $value . '">[block id="' . get_theme_mod( 'header-' . $value ) . '"]</div></li>' );
			} elseif ( $value == 'nav-top' ) {
				flatsome_header_nav( 'top_bar_nav', $walker );
			} elseif ( $value == 'nav' ) {
				flatsome_header_nav( 'primary', $walker );
			} elseif ( $value == 'wpml' ) {
				get_template_part( 'template-parts/header/partials/element-languages', $type );
			} else {
				get_template_part( 'template-parts/header/partials/element-' . $value, $type );
			}
			// Hooked Elements.
			do_action( 'flatsome_header_elements', $value );
		}
	}
}

/**
 * Get Header HTML Elements.
 *
 * @param string $value Header HTML elements.
 *
 * @return void
 */
function flatsome_get_header_html_element( $value ) {
	$html = '';

	if ($value == 'html') $html   = 'topbar_left';
	if ($value == 'html-2') $html = 'topbar_right';
	if ($value == 'html-3') $html = 'top_right_text';
	if ($value == 'html-4') $html = 'nav_position_text_top';
	if ($value == 'html-5') $html = 'nav_position_text';
	if (get_theme_mod( $html )) echo '<li class="html custom html_' . $html . '">' . do_shortcode( get_theme_mod( $html ) ) . '</li>'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
}

/**
 * FlatsomeNavDropdown Class.
 *
 * Extends Walker_Nav_Menu Class.
 */
class FlatsomeNavDropdown extends Walker_Nav_Menu {

	/**
	 * Display Elements.
	 *
	 * @param object $element           Navigation elements.
	 * @param array  $children_elements Child navigation elements.
	 * @param int    $max_depth         Maximum depth level.
	 * @param int    $depth             Depth of menu item. Used for padding.
	 * @param array  $args              wp_nav_menu() arguments.
	 * @param string $output            Element output.
	 *
	 * @return void
	 */
	public function display_element( $element, &$children_elements, $max_depth, $depth = 0, $args, &$output ) {
		// Check, whether there are children for the given ID and append it to the element with a (new) ID.
		$element->has_children = isset( $children_elements[ $element->ID ] ) && ! empty( $children_elements[ $element->ID ] );

		parent::display_element( $element, $children_elements, $max_depth, $depth, $args, $output );
	}

	/**
	 * Start Level.
	 *
	 * @param string $output Element output.
	 * @param int    $depth  Depth of menu item. Used for padding.
	 * @param array  $args   wp_nav_menu() arguments.
	 *
	 * @return void
	 */
	public function start_lvl( &$output, $depth = 0, $args = array() ) {
		$display_depth = ( $depth + 1 );

		if ( $display_depth == '1' ) {$class_names[] = 'nav-dropdown';
		} else { $class_names[] = 'nav-column';}

		// Add Dropdown Styles.
		$class_names[] = 'nav-dropdown-' . get_theme_mod( 'dropdown_style', 'default' );
		if ( get_theme_mod( 'dropdown_text' ) == 'dark' ) {$class_names[] = 'dark';}
		if ( get_theme_mod( 'dropdown_text_style' ) == 'uppercase' ) {$class_names[] = 'dropdown-uppercase';}

		$class_names = implode( ' ', $class_names );

		$indent  = str_repeat( "\t", $depth );
		$output .= "\n$indent<ul class='" . $class_names . "'>\n";
	}

	/**
	 * End Level.
	 *
	 * @param string $output Element output.
	 * @param int    $depth  Depth of menu item. Used for padding.
	 * @param array  $args   wp_nav_menu() arguments.
	 *
	 * @return void
	 */
	public function end_lvl( &$output, $depth = 1, $args = array() ) {
		$indent  = str_repeat( "\t", $depth );
		$output .= "$indent</ul>\n";
	}

	/**
	 * Starts the element output.
	 *
	 * @param string $output Element output.
	 * @param object $item   Menu item data object.
	 * @param int    $depth  Depth of menu item. Used for padding.
	 * @param array  $args   wp_nav_menu() arguments.
	 * @param int    $id     Current item ID.
	 *
	 * @return void
	 */
	public function start_el( &$output, $item, $depth = 0, $args = array(), $id = 0 ) {

		$indent = ( $depth ) ? str_repeat( "\t", $depth ) : '';

		$class_names = $value = ''; // phpcs:ignore

		$classes = empty( $item->classes ) ? array() : (array) $item->classes;

		// Set Active Class.
		if ( in_array( 'current-menu-ancestor', $classes, true ) || in_array( 'current-menu-item', $classes, true ) || in_array( 'current-menu-parent', $classes, true ) ) {
			$classes[] = 'active';
		}

		$classes[] = ' menu-item-' . $item->ID;

		if ( $item->has_children && $depth == 0 ) { $classes[] = 'has-dropdown';}
		if ( $item->has_children && $depth == 1 ) { $classes[] = 'nav-dropdown-col';}

		$menu_icon = '';

		// Add flatsome Icons.
		if ( strpos( $classes[0], 'icon-' ) !== false ) {
			$menu_icon  = get_flatsome_icon( $classes[0] );
			$classes[0] = 'has-icon-left';
		}

		$class_names = join( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item, $args ) );
		$class_names = ' class="' . esc_attr( $class_names ) . '"';

		$id = apply_filters( 'nav_menu_item_id', 'menu-item-' . $item->ID, $item, $args );
		$id = strlen( $id ) ? ' id="' . esc_attr( $id ) . '"' : '';

		$output .= $indent . '<li' . $id . $value . $class_names . '>';

		$attributes  = ! empty( $item->attr_title ) ? ' title="' . esc_attr( $item->attr_title ) . '"' : '';
		$attributes .= ! empty( $item->target ) ? ' target="' . esc_attr( $item->target ) . '"' : '';
		$attributes .= ! empty( $item->xfn ) ? ' rel="' . esc_attr( $item->xfn ) . '"' : '';
		$attributes .= ! empty( $item->url ) ? ' href="' . esc_attr( $item->url ) . '"' : '';

		// Check if menu item is in main menu.
		if ( $depth == 0 ) {
			// These lines adds your custom class and attribute.
			$attributes .= ' class="nav-top-link"';
		}

		// Image Column.
		if ( strpos( $class_names, 'image-column' ) !== false ) {
			$item_output  = '';
			$item_output .= '<a' . $attributes . ' class="dropdown-image-column">';
			$item_output .= '<img width="180" height="480" src="' . $item->description . '" title="' . apply_filters( 'the_title', $item->title, $item->ID ) . '" alt="' . apply_filters( 'the_title', $item->title, $item->ID ) . '"/>';
			$item_output .= '</a>';
		} elseif ( strpos( $class_names, 'category-column' ) !== false ) { // Category Image.
			$item_output = '<div class="category-images-preview">Loading</div>';

		} else {

			// Normal Items.
			$item_output  = $args->before;
			$item_output .= '<a' . $attributes . '>';

			// Add menu.
			if ($menu_icon) $item_output .= $menu_icon;
			$item_output                 .= $args->link_before . apply_filters( 'the_title', $item->title, $item->ID ) . $args->link_after;

			// Add down arrow.
			$icon = '';
			if ($item->has_children && $depth == 0) $icon = get_flatsome_icon( 'icon-angle-down' );

			$item_output .= $icon . '</a>';
			$item_output .= $args->after;
		}

		$output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
	}
}

/**
 * FlatsomeNavSidebar Class.
 *
 * Extends Walker_Nav_Menu Class.
 *
 * Sidebar Navigation Walker.
 */
class FlatsomeNavSidebar extends Walker_Nav_Menu {

	/**
	 * Display Elements.
	 *
	 * @param object $element           Navigation elements.
	 * @param array  $children_elements Child navigation elements.
	 * @param int    $max_depth         Maximum depth level.
	 * @param int    $depth             Depth of menu item. Used for padding.
	 * @param array  $args              wp_nav_menu() arguments.
	 * @param string $output            Element output.
	 *
	 * @return void
	 */
	public function display_element( $element, &$children_elements, $max_depth, $depth = 0, $args, &$output ) {
		// Check, whether there are children for the given ID and append it to the element with a (new) ID.
		$element->has_children = isset( $children_elements[ $element->ID ] ) && ! empty( $children_elements[ $element->ID ] );

		parent::display_element( $element, $children_elements, $max_depth, $depth, $args, $output );
	}

	/**
	 * Start Level.
	 *
	 * @param string $output Element output.
	 * @param int    $depth  Depth of menu item. Used for padding.
	 * @param array  $args   wp_nav_menu() arguments.
	 *
	 * @return void
	 */
	public function start_lvl( &$output, $depth = 0, $args = array() ) {
		$display_depth = ( $depth + 1 ); // because it counts the first submenu as 0.
		$class_names   = '';
		$class_names   = 'nav-sidebar-ul';
		if ( $display_depth == '1' ) {$class_names = 'children';}
		$indent  = str_repeat( "\t", $depth );
		$output .= "\n$indent<ul class=" . $class_names . ">\n";
	}

	/**
	 * End Level.
	 *
	 * @param string $output Element output.
	 * @param int    $depth  Depth of menu item. Used for padding.
	 * @param array  $args   wp_nav_menu() arguments.
	 *
	 * @return void
	 */
	public function end_lvl( &$output, $depth = 1, $args = array() ) {
		$indent  = str_repeat( "\t", $depth );
		$output .= "$indent</ul>\n";
	}

	/**
	 * XXX.
	 *
	 * @param string $output Element output.
	 * @param object $item   Menu item data object.
	 * @param int    $depth  Depth of menu item. Used for padding.
	 * @param array  $args   wp_nav_menu() arguments.
	 * @param int    $id     Current item ID.
	 *
	 * @return void
	 */
	public function start_el( &$output, $item, $depth = 0, $args = array(), $id = 0 ) {
		// Most of this code is copied from original Walker_Nav_Menu.
		$indent = ( $depth ) ? str_repeat( "\t", $depth ) : '';

		$class_names = $value = ''; // phpcs:ignore

		$classes   = empty( $item->classes ) ? array() : (array) $item->classes;
		$classes[] = 'menu-item-' . $item->ID;

		// if icon.
		$menu_icon = '';
		if ( strpos( $classes[0], 'icon-' ) !== false ) {
			$menu_icon  = '<span class="' . $classes[0] . '"></span>';
			$classes[0] = '';
		}

		$class_names = join( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item, $args ) );
		$class_names = ' class="' . esc_attr( $class_names ) . '"';

		$id = apply_filters( 'nav_menu_item_id', 'menu-item-' . $item->ID, $item, $args );
		$id = strlen( $id ) ? ' id="' . esc_attr( $id ) . '"' : '';

		$output .= $indent . '<li' . $id . $value . $class_names . '>';

		$attributes  = ! empty( $item->attr_title ) ? ' title="' . esc_attr( $item->attr_title ) . '"' : '';
		$attributes .= ! empty( $item->target ) ? ' target="' . esc_attr( $item->target ) . '"' : '';
		$attributes .= ! empty( $item->xfn ) ? ' rel="' . esc_attr( $item->xfn ) . '"' : '';
		$attributes .= ! empty( $item->url ) ? ' href="' . esc_attr( $item->url ) . '"' : '';

		// Check if menu item is in main menu.
		if ( $depth == 0 ) {
			// These lines adds your custom class and attribute.
			$attributes .= ' class="nav-top-link"';
		}

		// Normal Items.
		$item_output  = $args->before;
		$item_output .= '<a' . $attributes . '>';

		$item_output .= $args->link_before . apply_filters( 'the_title', $item->title, $item->ID ) . $args->link_after;

		$item_output .= '</a>';

		$item_output .= $args->after;

		$output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
	}
}

/**
 * Flatsome header classes.
 *
 * @return void
 */
function flatsome_header_classes() {
	// Add / remove hooked classes.
	echo implode( ' ', apply_filters( 'flatsome_header_class', array() ) ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
}

/**
 * Flatsome main classes.
 *
 * @return void
 */
function flatsome_main_classes() {
	// Add / remove hooked classes.
	echo implode( ' ', apply_filters( 'flatsome_main_class', array() ) ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
}

/**
 * Flatsome header title classes.
 *
 * @return void
 */
function flatsome_header_title_classes() {
	// Add / remove hooked classes.
	echo implode( ' ', apply_filters( 'flatsome_header_title_class', array() ) ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
}

/**
 * Flatsome add main classes.
 *
 * @param array $classes Current classes.
 *
 * @return array $classes
 */
function flatsome_add_main_classes( $classes ) {
	// Dark content.
	if ( get_theme_mod( 'content_color' ) == 'dark' ) {
		$classes[] = 'dark dark-page-wrapper';
	}

	return $classes;
}
add_filter( 'flatsome_main_class', 'flatsome_add_main_classes', 10 );

/**
 * Flatsome sticky header classes.
 *
 * @param array $classes Current classes.
 *
 * @return array $classes
 */
function flatsome_sticky_headers( $classes ) {

	$disable_sticky = false;

	// Disable if UX Builder is active.
	$disable_sticky = function_exists( 'ux_builder_is_active' ) && ux_builder_is_active();

	// Add Header width class.
	if (get_theme_mod( 'header_width' ) == 'full-width') $classes[] = 'header-full-width';

	// Disable sticky if no header element is set as sticky.
	if ( ! get_theme_mod( 'header_sticky', 1 ) && ! get_theme_mod( 'topbar_sticky' ) && ! get_theme_mod( 'bottombar_sticky', 1 ) ) {
		$disable_sticky = true;
	}

	// Add Sticky class.
	if ( ! $disable_sticky ) {
		$classes[] = 'has-sticky';
		$classes[] = 'sticky-' . get_theme_mod( 'sticky_style', 'jump' );

		if ( get_theme_mod( 'sticky_hide_on_scroll' ) ) {
			$classes[] = 'sticky-hide-on-scroll';
		}
	}

	return $classes;
}

add_filter( 'flatsome_header_class', 'flatsome_sticky_headers', 11 );





/**
 * Checks if top bar has elements for desktop and/or mobile.
 *
 * @return array $screens
 */
function flatsome_has_top_bar() {
	$screens = array(
		'large'  => false,
		'mobile' => false,
	);
	if ( get_theme_mod( 'topbar_show', 1 ) ) {
		if ( get_theme_mod( 'topbar_elements_center' ) || get_theme_mod( 'topbar_elements_left' ) || get_theme_mod( 'topbar_elements_right' ) ) {
			$screens['large'] = true;
		}
		if ( get_theme_mod( 'header_mobile_elements_top' ) ) {
			$screens['mobile'] = true;
		}
	}
	$screens['large_or_mobile'] = $screens['large'] || $screens['mobile'];
	$screens['mobile_only']     = ! $screens['large'] && $screens['mobile'];

	return $screens;
}

/**
 * Checks if bottom bar has elements for desktop and/or mobile.
 *
 * @return array $screens
 */
function flatsome_has_bottom_bar() {
	$screens = array(
		'large'  => false,
		'mobile' => false,
	);
	if ( get_theme_mod( 'header_elements_bottom_left' ) || get_theme_mod( 'header_elements_bottom_center' ) || get_theme_mod( 'header_elements_bottom_right' ) ) {
		$screens['large'] = true;
	}
	if ( get_theme_mod( 'header_mobile_elements_bottom' ) ) {
		$screens['mobile'] = true;
	}
	$screens['large_or_mobile'] = $screens['large'] || $screens['mobile'];
	$screens['mobile_only']     = ! $screens['large'] && $screens['mobile'];

	return $screens;
}

/**
 * Page Header inner classes.
 *
 * @param string $position Menu position.
 *
 * @return void
 */
function header_inner_class( $position ) {

	$classes      = null;
	$current_page = null;

	// Header main.
	if ( $position == 'main' ) {

		if ( get_theme_mod( 'logo_position' ) == 'center' ) {
			$classes[] = 'show-logo-center';
		}

		if ( ! get_theme_mod( 'header_sticky', 1 )) $classes[] = 'hide-for-sticky';

		if ( get_theme_mod( 'site_logo_sticky' ) ) {
			$classes[] = 'has-sticky-logo';
		}

		if (get_theme_mod( 'header_color' ) == 'dark') $classes[] = 'nav-dark';
	}

	// Header top.
	if ( $position == 'top' ) {
		if ( ! get_theme_mod( 'topbar_sticky' )) $classes[]               = 'hide-for-sticky';
		if (get_theme_mod( 'topbar_color', 'dark' ) == 'dark') $classes[] = 'nav-dark';
		if (get_theme_mod( 'topbar_elements_center' )) $classes[]         = 'flex-has-center';
		if ( ! get_theme_mod( 'header_mobile_elements_top' ) ) {
			$classes[] = 'hide-for-medium';
		}
	}

	// Header bottom.
	if ( $position == 'bottom' ) {
		if ( ! get_theme_mod( 'bottombar_sticky', 1 )) $classes[]              = 'hide-for-sticky';
		if (get_theme_mod( 'nav_position_color' ) == 'dark') $classes[]        = 'nav-dark';
		if (get_theme_mod( 'nav_position_color' ) == 'dark-header') $classes[] = 'nav-dark';
		if (get_theme_mod( 'header_elements_bottom_center' )) $classes[]       = 'flex-has-center';
		if ( ! get_theme_mod( 'header_mobile_elements_bottom' ) ) {
			$classes[] = 'hide-for-medium';
		} elseif ( get_theme_mod( 'header_mobile_elements_bottom' ) && flatsome_has_bottom_bar()['mobile_only'] ) {
			$classes[] = 'show-for-medium';
		}
	}

	// Dark nav on light headers.
	$page_template    = get_post_meta( get_the_ID(), '_wp_page_template', true );
	$default_template = get_theme_mod( 'pages_template', 'default' );
	if ( ( strpos( $page_template, 'light' ) !== false ) || ( ( empty( $page_template ) || $page_template == 'default' ) && ( strpos( $default_template, 'light' ) !== false ) ) && $position !== 'top' ) {
		$classes[] = 'nav-dark toggle-nav-dark';
	}

	if ( ! $classes) $classes[] = '';

	echo implode( ' ', $classes ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
}

/**
 * Build Nav Classes.
 *
 * @param string $position Menu position.
 *
 * @return void
 */
function flatsome_nav_classes( $position ) {
	$classes[] = null;

	if ( $position == 'main' ) {
		if (get_theme_mod( 'nav_style' )) $classes[]   = 'nav-' . get_theme_mod( 'nav_style' );
		if (get_theme_mod( 'nav_size' )) $classes[]    = 'nav-size-' . get_theme_mod( 'nav_size' );
		if (get_theme_mod( 'nav_spacing' )) $classes[] = 'nav-spacing-' . get_theme_mod( 'nav_spacing' );
		if ( get_theme_mod( 'nav_uppercase', 1 ) ) {
			$classes[] = 'nav-uppercase';
		}
	}

	if ( $position == 'bottom' ) {
		if (get_theme_mod( 'nav_style_bottom' )) $classes[]   = 'nav-' . get_theme_mod( 'nav_style_bottom' );
		if (get_theme_mod( 'nav_size_bottom' )) $classes[]    = 'nav-size-' . get_theme_mod( 'nav_size_bottom' );
		if (get_theme_mod( 'nav_spacing_bottom' )) $classes[] = 'nav-spacing-' . get_theme_mod( 'nav_spacing_bottom' );

		if ( get_theme_mod( 'nav_uppercase_bottom', 1 ) ) {
			$classes[] = 'nav-uppercase';
		}
	}

	if ( $position == 'top' ) {
		$classes[] = 'nav-' . get_theme_mod( 'nav_style_top', 'divided' );
	}

	echo implode( ' ', $classes ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
}

/**
 * Flatsome HTML classes.
 *
 * @return void
 */
function flatsome_html_classes() {

	// Change Body Layouts.
	$classes[] = 'loading-site no-js';

	// Add background style.
	if (get_theme_mod( 'body_bg_type' ) == 'bg-full-size') $classes[] = 'bg-fill';

	echo implode( ' ', $classes ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
}

/**
 * Adds custom classes to the array of body classes.
 *
 * @param array $classes Current classes.
 *
 * @return array $classes
 */
function flatsome_body_classes( $classes ) {

	// Change Body Layouts.
	if (get_theme_mod( 'body_layout' ))  $classes[]                   = get_theme_mod( 'body_layout' );
	if (get_theme_mod( 'box_shadow_header' )) $classes[]              = 'header-shadow';
	if (get_theme_mod( 'body_bg_type' ) == 'bg-full-size') $classes[] = 'bg-fill';
	if (get_theme_mod( 'box_shadow' )) $classes[]                     = 'box-shadow';
	if (get_theme_mod( 'flatsome_lightbox', 1 )) $classes[]           = 'lightbox';
	if (get_theme_mod( 'dropdown_arrow', 1 )) $classes[]              = 'nav-dropdown-has-arrow';
	if (get_theme_mod( 'parallax_mobile', 0 )) $classes[]             = 'parallax-mobile';

  // Add the selected page template classes if Default Template is selected.
	$page_template =  get_post_meta( get_the_ID(), '_wp_page_template', true );
	$default_template = get_theme_mod('pages_template');
	if ( ( empty( $page_template ) || $page_template == "default" ) && $default_template ) {
		$classes[] = 'page-template-' . $default_template;
		$classes[] = 'page-template-' . $default_template . '-php';
	}

	return $classes;
}
add_filter( 'body_class', 'flatsome_body_classes' );

/**
 * Flatsome Dropdown classes.
 *
 * @return void
 */
function flatsome_dropdown_classes() {
	$class_names = array();

	// Add Dropdown Styles.
	$class_names[] = 'nav-dropdown-' . get_theme_mod( 'dropdown_style', 'default' );
	if ( get_theme_mod( 'dropdown_text' ) == 'dark' ) { $class_names[] = 'dark'; }
	if ( get_theme_mod( 'dropdown_text_style' ) == 'uppercase' ) { $class_names[] = 'dropdown-uppercase'; }

	echo implode( ' ', $class_names ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
}

/**
 * Add Header Backgrounds.
 *
 * @return void
 */
function flatsome_add_header_backgrounds() {
	$page_template = get_post_meta( get_the_ID(), '_wp_page_template', true );

	// Add BG image.
	echo '<div class="header-bg-image fill"></div>';

	// Add BG Color.
	echo '<div class="header-bg-color fill"></div>';

	// Add BG shade to transparent headers.
	if ( ! empty( $page_template ) && strpos( $page_template, 'transparent' ) && get_theme_mod( 'header_bg_transparent_shade' ) ) {
		echo '<div class="shade shade-top hide-for-sticky fill"></div>';
	}
}
add_action( 'flatsome_header_background', 'flatsome_add_header_backgrounds', 10 );

/**
 * Add js class to header if JS is enabled.
 *
 * @return void
 */
function flatsome_javascript_detection() {
	echo "<script>(function(html){html.className = html.className.replace(/\bno-js\b/,'js')})(document.documentElement);</script>\n";
}
add_action( 'wp_head', 'flatsome_javascript_detection', 0 );

/**
 * Insert custom header script.
 *
 * @return void
 */
function flatsome_custom_header_js() {
	if ( get_theme_mod( 'html_scripts_header' ) && ! is_admin() ) {
		echo get_theme_mod( 'html_scripts_header' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
	}
}
add_action( 'wp_head', 'flatsome_custom_header_js' );

/**
 * Insert custom body top script.
 *
 * @return void
 */
function flatsome_after_body_open() {
	if ( get_theme_mod( 'html_scripts_after_body' ) && ! is_admin() ) {
		echo get_theme_mod( 'html_scripts_after_body' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
	}
}
add_action( 'flatsome_after_body_open', 'flatsome_after_body_open' );

/**
 * Set logo position.
 *
 * @return void
 */
function flatsome_logo_position() {
	$classes   = array();
	$classes[] = 'logo-' . get_theme_mod( 'logo_position', 'left' );

	// Mobile logo position.
	if (get_theme_mod( 'logo_position_mobile', 'center' ) == 'center') $classes[] = 'medium-logo-center';

	echo implode( ' ', $classes ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
}

/**
 * HTML after header.
 *
 * @return void
 */
function flatsome_html_after_header() {
	if ( get_theme_mod( 'html_after_header' ) ) {
		// AFTER HEADER HTML BLOCK.
		echo '<div class="header-block block-html-after-header z-1" style="position:relative;top:-1px;">';
		echo do_shortcode( get_theme_mod( 'html_after_header' ) );
		echo '</div>';
	}
}
add_action( 'flatsome_after_header', 'flatsome_html_after_header', 1 );

if ( get_theme_mod( 'site_loader', 0 ) ) {
	/**
	 * Page loader.
	 *
	 * @return void
	 */
	function flatsome_add_page_loader() {
		if ( get_theme_mod( 'site_loader' ) == 'home' && is_front_page() ) {
			get_template_part( 'template-parts/header/page-loader' );
		} elseif ( get_theme_mod( 'site_loader' ) == 'all' ) {
			get_template_part( 'template-parts/header/page-loader' );
		}
	}
	add_action( 'flatsome_before_header', 'flatsome_add_page_loader', 1 );
}
