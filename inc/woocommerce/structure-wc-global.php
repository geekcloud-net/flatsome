<?php

function flatsome_woocommerce_setup() {
	// Theme support for default WC gallery.
	if ( get_theme_mod( 'product_gallery_woocommerce') ) {
		add_theme_support( 'wc-product-gallery-slider' );
		// Force default lightbox when default gallery is chosen.
		if ( get_theme_mod( 'product_lightbox','default' ) !== 'default' ) {
			set_theme_mod( 'product_lightbox', 'default' );
		}
	}
	// Theme support for default WC gallery lightbox.
	if ( get_theme_mod( 'product_lightbox','default' ) === 'default' ) {
		add_theme_support( 'wc-product-gallery-lightbox' );
	}
	// Remove default row and column options.
	remove_theme_support( 'product_grid' );
}
add_action( 'after_setup_theme', 'flatsome_woocommerce_setup', 90 );


if ( ! function_exists( 'flatsome_woocommerce_add_notice' ) ) {
	/**
	 * Add wc notices except for the cart page
	 */
	function flatsome_woocommerce_add_notice() {
		if ( is_woocommerce_activated() && ! is_cart() ) {
			wc_print_notices();
		}
	}
}
add_action( 'flatsome_after_header', 'flatsome_woocommerce_add_notice', 100 );

function flatsome_my_account_menu_classes($classes){

    // Add Active Class
    if(in_array('is-active', $classes)){
      array_push($classes, 'active');
    }

    return $classes;
}
add_filter('woocommerce_account_menu_item_classes', 'flatsome_my_account_menu_classes');

/* My Account Dashboard overview */
function flatsome_my_account_dashboard(){
  wc_get_template( 'myaccount/dashboard-links.php' );
}
add_action('woocommerce_account_dashboard','flatsome_my_account_dashboard');


// Remove logout from my account menu
function flatsome_remove_logout_account_item( $items ) {
  unset( $items['customer-logout'] );
  return $items;
}
add_filter( 'woocommerce_account_menu_items', 'flatsome_remove_logout_account_item' );


/**
 * Conditionally remove WooCommerce styles and/or scripts.
 */
function flatsome_woocommerce_scripts_styles() {
	// Remove default WooCommerce Lightbox.
	if ( get_theme_mod( 'product_lightbox', 'default' ) !== 'woocommerce' || ! is_product() ) {
		wp_dequeue_style( 'woocommerce_prettyPhoto_css' );
		wp_deregister_style( 'woocommerce_prettyPhoto_css' );

		wp_dequeue_script( 'prettyPhoto' );
		wp_dequeue_script( 'prettyPhoto-init' );
	}

	if ( ! is_admin() ) {
		wp_dequeue_style( 'woocommerce-layout' );
		wp_deregister_style( 'woocommerce-layout' );
		wp_dequeue_style( 'woocommerce-smallscreen' );
		wp_deregister_style( 'woocommerce-smallscreen' );
		wp_dequeue_style( 'woocommerce-general' );
		wp_deregister_style( 'woocommerce-general' );
	}
}

add_action( 'wp_enqueue_scripts', 'flatsome_woocommerce_scripts_styles', 98 );


// Add Shop  Widgets
function flatsome_shop_widgets_init() {

  register_sidebar( array(
    'name'          => __( 'Shop Sidebar', 'flatsome' ),
    'id'            => 'shop-sidebar',
    'before_widget' => '<aside id="%1$s" class="widget %2$s">',
    'after_widget'  => '</aside>',
    'before_title'  => '<span class="widget-title shop-sidebar">',
    'after_title'   => '</span><div class="is-divider small"></div>',
  ) );

  register_sidebar( array(
    'name'          => __( 'Product Sidebar', 'flatsome' ),
    'id'            => 'product-sidebar',
    'before_widget' => '<aside id="%1$s" class="widget %2$s">',
    'after_widget'  => '</aside>',
    'before_title'  => '<span class="widget-title shop-sidebar">',
    'after_title'   => '</span><div class="is-divider small"></div>',
  ) );


}
add_action( 'widgets_init', 'flatsome_shop_widgets_init' );



/* Modify define(name, value)ault Shop Breadcrumbs */
function flatsome_woocommerce_breadcrumbs() {

    $home = (get_theme_mod('breadcrumb_home',1)) ? _x( 'Home', 'breadcrumb', 'woocommerce' ) : false;

    return array(
        'delimiter'   => '&#47;',
        'wrap_before' => '<nav class="woocommerce-breadcrumb breadcrumbs '.get_theme_mod('breadcrumb_case', 'uppercase').'">',
        'wrap_after'  => '</nav>',
        'before'      => '',
        'after'       => '',
        'home'        => $home
    );
}

add_filter( 'woocommerce_breadcrumb_defaults', 'flatsome_woocommerce_breadcrumbs' );

/**
 * Add default breadcrumbs.
 *
 * @see woocommerce_breadcrumb()
 */
add_action( 'flatsome_breadcrumb' , 'woocommerce_breadcrumb', 20 );

/* Update cart price */
function flatsome_header_add_to_cart_fragment( $fragments ) {
  ob_start();
  ?> <span class="cart-price"><?php echo WC()->cart->get_cart_subtotal(); ?></span><?php
  $fragments['.cart-price'] = ob_get_clean();

  return $fragments;

}
add_filter('woocommerce_add_to_cart_fragments', 'flatsome_header_add_to_cart_fragment');

if ( ! function_exists( 'flatsome_header_add_to_cart_fragment_count' ) ) {
	/**
	 * Update cart number when default cart icon is selected
	 *
	 * @param $fragments
	 *
	 * @return mixed
	 */
	function flatsome_header_add_to_cart_fragment_count( $fragments ) {
		ob_start();
		?>
		<span class="cart-icon image-icon">
			<strong><?php echo WC()->cart->cart_contents_count; ?></strong>
		</span>
		<?php
		$fragments['.header .cart-icon'] = ob_get_clean();

		return $fragments;
	}
}
add_filter( 'woocommerce_add_to_cart_fragments', 'flatsome_header_add_to_cart_fragment_count' );


if ( ! function_exists( 'flatsome_header_add_to_cart_fragment_count_label' ) ) {
	/**
	 * Update cart label when a build-in cart icon is selected
	 *
	 * @param $fragments
	 *
	 * @return mixed
	 */
	function flatsome_header_add_to_cart_fragment_count_label( $fragments ) {
		if ( ! get_theme_mod( 'cart_icon_style' ) ) {
			return $fragments;
		}

		$icon = get_theme_mod( 'cart_icon', 'basket' );
		ob_start();
		?>
		<i class="icon-shopping-<?php echo $icon; ?>" data-icon-label="<?php echo WC()->cart->cart_contents_count; ?>">
		<?php
		$fragments[ 'i.icon-shopping-' . $icon ] = ob_get_clean();

		return $fragments;
	}
}
add_filter( 'woocommerce_add_to_cart_fragments', 'flatsome_header_add_to_cart_fragment_count_label' );

if ( ! function_exists( 'flatsome_header_add_to_cart_custom_icon_fragment_count_label' ) ) {
	/**
	 * Update cart label when custom cart icon is selected
	 *
	 * @param $fragments
	 *
	 * @return mixed
	 */
	function flatsome_header_add_to_cart_custom_icon_fragment_count_label( $fragments ) {
		$custom_cart_icon = get_theme_mod( 'custom_cart_icon' );
		if ( ! $custom_cart_icon ) {
			return $fragments;
		}

		ob_start();
		?>
		<span class="image-icon header-cart-icon" data-icon-label="<?php echo WC()->cart->cart_contents_count; ?>">
			<img class="cart-img-icon" alt="<?php _e( 'Cart', 'woocommerce' ); ?>" src="<?php echo do_shortcode( $custom_cart_icon ); ?>"/>
		</span>
		<?php
		$fragments['.image-icon.header-cart-icon'] = ob_get_clean();

		return $fragments;
	}
}
add_filter( 'woocommerce_add_to_cart_fragments', 'flatsome_header_add_to_cart_custom_icon_fragment_count_label' );

// Add Pages and blog posts to top of search results if set.
function flatsome_pages_in_search_results(){
    if(!is_search() || !get_theme_mod('search_result', 1)) return;
    global $post;
    ?>
    <?php if( get_search_query() ) : ?>
    <?php
      /**
       * Include pages and posts in search
       */
      query_posts( array( 'post_type' => array( 'post'), 's' => get_search_query() ) );

      $posts = array();
      while ( have_posts() ) : the_post();
        array_push($posts, $post->ID);
      endwhile;

      wp_reset_query();

      // Get pages
      query_posts( array( 'post_type' => array( 'page'), 's' => get_search_query() ) );
      $pages = array();
      while ( have_posts() ) : the_post();
        $wc_page = false;
        if($post->post_type == 'page'){
          foreach (array('shop', 'cart', 'checkout', 'view_order', 'terms') as $wc_page_type) {
            if( $post->ID == wc_get_page_id($wc_page_type) ) $wc_page = true;
          }
        }
        if( !$wc_page ) array_push($pages, $post->ID);
      endwhile;

      wp_reset_query();

      if(!empty($posts) || !empty($pages)){
          $list_type = get_theme_mod( 'search_result_style', 'slider' );
          if(!empty($posts)) echo '<hr/><h4 class="uppercase">'.__('Posts found','flatsome').'</h4>'.do_shortcode('[blog_posts columns="3" columns__md="3" columns__sm="2" type="'.$list_type.'" image_height="16-9" ids="'.implode(',',$posts).'"]');
          if(!empty($pages)) echo '<hr/><h4 class="uppercase">'.__('Pages found','flatsome').'</h4>'.do_shortcode('[ux_pages columns="3" columns__md="3" columns__sm="2" type="'.$list_type.'" image_height="16-9" ids="'.implode(',',$pages).'"]');
      }

    ?>
    <?php endif; ?>

    <?php
}
add_action('woocommerce_after_main_content','flatsome_pages_in_search_results', 10);



/**
 * Calculates discount percentage for the product sale bubble for
 * simple, variable or external product types. Returns base bubble text
 * with or without formatting otherwise.
 *
* @param $product
 *
* @return string
 */
function flatsome_presentage_bubble( $product ) {
	$post_id = $product->get_id();

	if ( $product->is_type( 'simple' ) || $product->is_type( 'external' ) ) {
		$regular_price  = $product->get_regular_price();
		$sale_price     = $product->get_sale_price();
		$bubble_content = round( ( ( floatval( $regular_price ) - floatval( $sale_price ) ) / floatval( $regular_price ) ) * 100 );
	} elseif ( $product->is_type( 'variable' ) ) {
		if ( $bubble_content = flatsome_percentage_get_cache( $post_id ) ) {
			return flatsome_percentage_format( $bubble_content );
		}

		$available_variations = $product->get_available_variations();
		$maximumper           = 0;

		for ( $i = 0; $i < count( $available_variations ); ++ $i ) {
			$variation_id     = $available_variations[ $i ]['variation_id'];
			$variable_product = new WC_Product_Variation( $variation_id );
			if ( ! $variable_product->is_on_sale() ) {
				continue;
			}
			$regular_price = $variable_product->get_regular_price();
			$sale_price    = $variable_product->get_sale_price();
			$percentage    = round( ( ( floatval( $regular_price ) - floatval( $sale_price ) ) / floatval( $regular_price ) ) * 100 );
			if ( $percentage > $maximumper ) {
				$maximumper = $percentage;
			}
		}

		$bubble_content = sprintf( __( '%s', 'woocommerce' ), $maximumper );

		// Cache percentage for variable products to reduce database queries.
		flatsome_percentage_set_cache( $post_id, $bubble_content );
	} else {
		// Set default and return if the product type doesn't meet specification.
		$bubble_content = __( 'Sale!', 'woocommerce' );

		return $bubble_content;
	}

	return flatsome_percentage_format( $bubble_content );
}

function flatsome_percentage_get_cache( $post_id ) {
	return get_post_meta( $post_id, '_flatsome_product_percentage', true );
}

function flatsome_percentage_set_cache( $post_id, $bubble_content ) {
	update_post_meta( $post_id, '_flatsome_product_percentage', $bubble_content );
}

// Process custom formatting. Keep mod value double check
// to process % for default parameter (See sprintf()).
function flatsome_percentage_format( $value ) {
	$formatting = get_theme_mod( 'sale_bubble_percentage_formatting' );
	$formatting = $formatting ? $formatting : '-{value}%';

	return str_replace( '{value}', $value, $formatting );
}

// Clear cached percentage whenever a product or variation is saved.
function flatsome_percentage_clear( $object ) {
	if ( ! get_theme_mod( 'sale_bubble_percentage' ) ) return;

	$post_id = 'variation' === $object->get_type()
		? $object->get_parent_id()
		: $object->get_id();

	delete_post_meta( $post_id, '_flatsome_product_percentage' );
}
add_action( 'woocommerce_before_product_object_save', 'flatsome_percentage_clear' );

// Clear all cached percentages when disabling bubble percentage.
function flatsome_percentage_clear_all( $value, $old_value ) {
	if ( ! $value && $old_value ) {
		delete_metadata( 'post', null, '_flatsome_product_percentage', '', true );
	}

	return $value;
}
add_filter( 'pre_set_theme_mod_sale_bubble_percentage', 'flatsome_percentage_clear_all', 10, 2 );

// Account login style
function flatsome_account_login_lightbox(){
  // Show Login Lightbox if selected
  if ( !is_user_logged_in() && get_theme_mod('account_login_style','lightbox') == 'lightbox' && !is_checkout() && !is_account_page() ) {
    $is_facebook_login = is_nextend_facebook_login();
    $is_google_login = is_nextend_google_login();
    wp_enqueue_script( 'wc-password-strength-meter' );

    ?>
    <div id="login-form-popup" class="lightbox-content mfp-hide">
      <?php if(get_theme_mod('social_login_pos','top') == 'top' && ($is_facebook_login || $is_google_login)) wc_get_template('myaccount/header.php'); ?>
      <?php wc_get_template_part('myaccount/form-login'); ?>
      <?php if(get_theme_mod('social_login_pos','top') == 'bottom' && ($is_facebook_login || $is_google_login)) wc_get_template('myaccount/header.php'); ?>
    </div>
  <?php }
}
add_action('wp_footer', 'flatsome_account_login_lightbox', 10);

// Payment icons to footer
function flatsome_footer_payment_icons(){
  $icons = get_theme_mod('payment_icons_placement');
  if(is_array($icons) && !in_array('footer', $icons)) return;
  echo do_shortcode('[ux_payment_icons]');
}
add_action('flatsome_absolute_footer_secondary','flatsome_footer_payment_icons', 10);


/* Disable reviews globally */
if(get_theme_mod('disable_reviews')){
    remove_filter( 'woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_rating', 5 );
    remove_filter( 'woocommerce_single_product_summary','woocommerce_template_single_rating', 10);
    add_filter( 'woocommerce_product_tabs', 'wcs_woo_remove_reviews_tab', 98 );
    function wcs_woo_remove_reviews_tab($tabs) {
     unset($tabs['reviews']);
     return $tabs;
    }
}

if( !function_exists('flatsome_wc_get_gallery_image_html') ) {
  // Copied and modified from woocommerce plugin and wc_get_gallery_image_html helper function.
  function flatsome_wc_get_gallery_image_html( $attachment_id, $main_image = false, $size = 'woocommerce_single' ) {
    $gallery_thumbnail = wc_get_image_size( 'gallery_thumbnail' );
    $thumbnail_size    = apply_filters( 'woocommerce_gallery_thumbnail_size', array( $gallery_thumbnail['width'], $gallery_thumbnail['height'] ) );
    $image_size        = apply_filters( 'woocommerce_gallery_image_size', $size );
    $full_size         = apply_filters( 'woocommerce_gallery_full_size', apply_filters( 'woocommerce_product_thumbnails_large_size', 'full' ) );
    $thumbnail_src     = wp_get_attachment_image_src( $attachment_id, $thumbnail_size );
    $full_src          = wp_get_attachment_image_src( $attachment_id, $full_size );
    $image             = wp_get_attachment_image( $attachment_id, $image_size, false, array(
      'title'                   => get_post_field( 'post_title', $attachment_id ),
      'data-caption'            => get_post_field( 'post_excerpt', $attachment_id ),
      'data-src'                => $full_src[0],
      'data-large_image'        => $full_src[0],
      'data-large_image_width'  => $full_src[1],
      'data-large_image_height' => $full_src[2],
      'class'                   => $main_image ? 'wp-post-image skip-lazy' : 'skip-lazy', // skip-lazy, blacklist for Jetpack's lazy load.
    ) );

    $image_wrapper_class = $main_image ? 'slide first' : 'slide';

    return '<div data-thumb="' . esc_url( $thumbnail_src[0] ) . '" class="woocommerce-product-gallery__image '.$image_wrapper_class.'"><a href="' . esc_url( $full_src[0] ) . '">' . $image . '</a></div>';
  }
}

/* Move demo store notice to top. */
function flatsome_move_store_notice() {
    if ( get_theme_mod( 'woocommerce_store_notice_top' ) ) {
        remove_action( 'wp_footer', 'woocommerce_demo_store' );
        add_action ( 'flatsome_after_body_open', 'woocommerce_demo_store', 0 );
    }
}
add_action( 'wp_loaded', 'flatsome_move_store_notice' );

/**
 * Filter WC Product shortcode attributes,
 *
 * @param array $attrs Attributes.
 *
 * @return array Attributes.
 */
function flatsome_filter_shortcode_atts_products( $attrs ) {
	if ( $attrs['limit'] == '-1' ) {
		$attrs['limit'] = '12';
	}

	if ( $attrs['columns'] == '' ) {
		$attrs['columns'] = '4';
	}

	return $attrs;
}

add_filter( 'shortcode_atts_products', 'flatsome_filter_shortcode_atts_products' );
