<?php
/**
 * Advanced Theme Options
 *
 * @package Flatsome/Admin/Options/Advanced
 */

add_action( 'init', 'of_options' );

if ( ! function_exists( 'of_options' ) ) {
	/**
	 * Advance Theme Options.
	 *
	 * @global array $of_options Description.
	 *
	 * @return void.
	 */
	function of_options() {
		// Access the WordPress Categories via an Array.
		$of_categories     = array();
		$of_categories_obj = get_categories( 'hide_empty=0' );
		foreach ( $of_categories_obj as $of_cat ) {
			$of_categories[ $of_cat->cat_ID ] = $of_cat->cat_name;
		}

		// Access the WordPress Pages via an Array.
		$of_pages      = array();
		$of_pages_obj  = get_pages( 'sort_column=post_parent,menu_order' );
		$of_pages['0'] = 'Select a page:';
		foreach ( $of_pages_obj as $of_page ) {
			$of_pages[ $of_page->ID ] = $of_page->post_title;
		}

		// Access the Blocks via an Array.
		$of_blocks     = array( false => '-- None --' );
		$of_blocks_obj = flatsome_get_post_type_items( 'blocks' );
		if ( $of_blocks_obj ) {
			foreach ( $of_blocks_obj as $of_block ) {
				$of_blocks[ $of_block->post_name ] = $of_block->post_title;
			}
		}

		// Set the Options Array.
		global $of_options;
		$of_options = array();

		$of_options[] = array(
			'name' => 'Global Settings',
			'type' => 'heading',
		);

		$of_options[] = array(
			'name' => 'Header Scripts',
			'desc' => 'Add custom scripts inside HEAD tag. You need to have a SCRIPT tag around scripts.',
			'id'   => 'html_scripts_header',
			'std'  => '',
			'type' => 'textarea',
		);

		$of_options[] = array(
			'name' => 'Footer Scripts',
			'desc' => 'Add custom scripts you might want to be loaded in the footer of your website. You need to have a SCRIPT tag around scripts.',
			'id'   => 'html_scripts_footer',
			'std'  => '',
			'type' => 'textarea',
		);

		$of_options[] = array(
			'name' => 'Body Scripts - Top',
			'desc' => 'Add custom scripts just after the BODY tag opened. You need to have a SCRIPT tag around scripts.',
			'id'   => 'html_scripts_after_body',
			'std'  => '',
			'type' => 'textarea',
		);

		$of_options[] = array(
			'name' => 'Body Scripts - Bottom',
			'desc' => 'Add custom scripts just before the BODY tag closed. You need to have a SCRIPT tag around scripts.',
			'id'   => 'html_scripts_before_body',
			'std'  => '',
			'type' => 'textarea',
		);

		$of_options[] = array(
			'name' => 'Flatsome 2.0 Content Support',
			'id'   => 'flatsome_fallback',
			'desc' => 'Support content made in Flatsome 2.0. Disable to speed up site.',
			'std'  => 1,
			'type' => 'checkbox',
		);

		$of_options[] = array(
			'name' => 'Custom CSS',
			'type' => 'heading',
		);

		$of_options[] = array(
			'name' => 'All screens',
			'desc' => 'Add custom CSS here',
			'id'   => 'html_custom_css',
			'std'  => '',
			'type' => 'textarea',
		);

		$of_options[] = array(
			'name' => 'Tablets and down',
			'desc' => 'Add custom CSS here for tablets and mobile',
			'id'   => 'html_custom_css_tablet',
			'std'  => '',
			'type' => 'textarea',
		);

		$of_options[] = array(
			'name' => 'Mobile only',
			'desc' => 'Add custom CSS here for mobile view',
			'id'   => 'html_custom_css_mobile',
			'std'  => '',
			'type' => 'textarea',
		);

		// Performance.
		$of_options[] = array(
			'name' => 'Performance',
			'type' => 'heading',
			'desc' => ' <strong>Use with caution! Disable if you have plugin compatibility problems.</strong>',
		);

		$of_options[] = array(
			'name' => 'Preload pages',
			'id'   => 'perf_instant_page',
			'desc' => 'Preload pages right before a user clicks on it for blazing fast browsing between pages.',
			'std'  => 0,
			'type' => 'checkbox',
		);

		$of_options[] = array(
			'name' => 'Lazy Load Banner and Section backgrounds',
			'id'   => 'lazy_load_backgrounds',
			'desc' => 'Enable lazy loading of banner and section backgrounds.',
			'std'  => 1,
			'type' => 'checkbox',
		);

		$of_options[] = array(
			'name' => 'Lazy Load Images',
			'id'   => 'lazy_load_images',
			'desc' => 'Enable lazy loading for images. It will generate an inline blank Base64 image with the same aspect ratio as the original image.',
			'std'  => 0,
			'type' => 'checkbox',
		);

		$of_options[] = array(
			'name' => 'Disable theme style.css',
			'type' => 'checkbox',
			'id'   => 'flatsome_disable_style_css',
			'std'  => 0,
			'desc' => 'Disable loading of theme style.css. This file is only needed if you have added custom CSS to that file.',
		);

		$of_options[] = array(
			'name' => 'Disable Emoji script',
			'type' => 'checkbox',
			'id'   => 'disable_emoji',
			'std'  => 0,
			'desc' => 'Remove WP emoji scripts from front-end.',
		);

		$of_options[] = array(
			'name' => 'Disable Block library css',
			'type' => 'checkbox',
			'id'   => 'disable_blockcss',
			'std'  => 0,
			'desc' => 'Remove default block library css coming from WordPress',
		);

		$of_options[] = array(
			'name' => 'Site Loader',
			'type' => 'heading',
		);

		$of_options[] = array(
			'name'    => 'Site Loader',
			'id'      => 'site_loader',
			'desc'    => 'Enable Site Loader overlay when loading the site.',
			'type'    => 'select',
			'std'     => 0,
			'options' => array(
				0      => 'Disabled',
				'home' => 'Enable on homepage',
				'all'  => 'Enable on all pages',
			),
		);

		$of_options[] = array(
			'name'    => 'Color',
			'id'      => 'site_loader_color',
			'type'    => 'select',
			'std'     => 'light',
			'options' => array(
				'light' => 'Light',
				'dark'  => 'Dark',
			),
		);

		$of_options[] = array(
			'name' => 'Background Color',
			'id'   => 'site_loader_bg',
			'std'  => '',
			'type' => 'color',
		);

		$of_options[] = array(
			'name' => 'Site Search',
			'type' => 'heading',
		);

		$of_options[] = array(
			'name' => 'Live Search',
			'id'   => 'live_search',
			'desc' => 'Enable live search for products and pages.',
			'std'  => 1,
			'type' => 'checkbox',
		);

		$of_options[] = array(
			'name' => 'Search placeholder',
			'desc' => 'Change the search field placeholder',
			'id'   => 'search_placeholder',
			'type' => 'text',
		);

		if ( is_woocommerce_activated() ) {

			$of_options[] = array(
				'name' => 'Show Blog and pages in search results',
				'id'   => 'search_result',
				'desc' => 'Enable blog and pages in search results',
				'std'  => 1,
				'type' => 'checkbox',
			);

			$of_options[] = array(
				'name'    => 'Search Products Order By',
				'id'      => 'search_products_order_by',
				'type'    => 'select',
				'std'     => 'relevance',
				'options' => array(
					'relevance' => 'Relevance',
					'title'     => 'Title',
					'price'     => 'Price',
				),
			);

			$of_options[] = array(
				'name' => 'Search Product SKU',
				'desc' => 'Allow searching by SKU in live search.',
				'id'   => 'search_by_sku',
				'std'  => 0,
				'type' => 'checkbox',
			);

			$of_options[] = array(
				'name' => 'Search Product Tag',
				'desc' => 'Allow searching by product tags in live search.',
				'id'   => 'search_by_product_tag',
				'std'  => 0,
				'type' => 'checkbox',
			);
		}

		$of_options[] = array(
			"name" => "Instagram",
			"type" => "heading",
		);

		$of_options[] = array(
			"name" => "Accounts",
			"std"  => flatsome_facebook_accounts_html(),
			"desc" => flatsome_facebook_login_button_html(),
			"type" => "info"
		);

		$of_options[] = array(
			'name' => 'Google APIs',
			'type' => 'heading',
		);

		$of_options[] = array(
			'name' => 'Google Maps API',
			'desc' => "Enter Google Maps API key here to enable Maps. You can generate one here: <a target='_blank' href='https://developers.google.com/maps/documentation/javascript/get-api-key'>Google Maps API</a>",
			'id'   => 'google_map_api',
			'std'  => '',
			'type' => 'text',
		);

		$of_options[] = array(
			'name' => 'Maintenance Mode',
			'type' => 'heading',
		);

		$of_options[] = array(
			'name' => 'Maintenance Mode',
			'id'   => 'maintenance_mode',
			'desc' => 'Enable Maintenance Mode for all users except admins.',
			'std'  => 0,
			'type' => 'checkbox',
		);

		$of_options[] = array(
			'name' => 'Admin Notice',
			'id'   => 'maintenance_mode_admin_notice',
			'desc' => 'Show admin notice when Maintenance Mode is enabled.',
			'std'  => 1,
			'type' => 'checkbox',
		);

		$of_options[] = array(
			'name'    => 'Custom Maintenance Page',
			'id'      => 'maintenance_mode_page',
			'desc'    => 'Set a custom page as maintenance page. Only this page will be visible for visitors.',
			'std'     => 0,
			'type'    => 'select',
			'options' => $of_pages,
		);

		$of_options[] = array(
			'name' => 'Maintenance Mode Text',
			'desc' => 'The text that will be visible to your customers when accessing maintenance screen.',
			'id'   => 'maintenance_mode_text',
			'std'  => 'Please check back soon..',
			'type' => 'text',
		);

		$of_options[] = array(
			'name' => '404 Page',
			'type' => 'heading',
		);

		$of_options[] = array(
			'name'    => 'Custom 404 Block',
			'id'      => '404_block',
			'desc'    => 'Replace 404 page content with a Custom Block that you can edit in the Page Builder.',
			'std'     => 0,
			'type'    => 'select',
			'options' => $of_blocks,
		);

		if ( is_woocommerce_activated() ) {

			$of_options[] = array(
				'name' => 'WooCommerce',
				'type' => 'heading',
			);

			$of_options[] = array(
				'name' => 'Disable Reviews Global',
				'id'   => 'disable_reviews',
				'desc' => 'Disable reviews globally.',
				'std'  => 0,
				'type' => 'checkbox',
			);

			$of_options[] = array(
				'name' => 'Enable default WooCommerce product gallery',
				'id'   => 'product_gallery_woocommerce',
				'desc' => 'Use the default WooCommerce gallery slider for plugin compatibility, such as "Additional Variation Images".',
				'std'  => 0,
				'type' => 'checkbox',
			);

			$of_options[] = array(
				'name' => 'Shop header',
				'desc' => 'Enter HTML that should be placed on top of main shop page. Shortcodes are allowed. ',
				'id'   => 'html_shop_page',
				'std'  => '',
				'type' => 'textarea',
			);

			$of_options[] = array(
				'name' => 'Additional Global tab/section title',
				'id'   => 'tab_title',
				'std'  => '',
				'type' => 'text',
			);

			$of_options[] = array(
				'name' => 'Additional Global tab/section content',
				'id'   => 'tab_content',
				'std'  => '',
				'type' => 'textarea',
				'desc' => 'Add additional tab content here... Like Size Charts etc.',
			);

			$of_options[] = array(
				'name' => 'HTML before Add To Cart button (Global)',
				'desc' => 'Enter HTML and shortcodes that will show before Add to cart selections.',
				'id'   => 'html_before_add_to_cart',
				'std'  => ' ',
				'type' => 'textarea',
			);

			$of_options[] = array(
				'name' => 'HTML after Add To Cart button (Global)',
				'desc' => 'Enter HTML and shortcodes that will show after Add to cart button.',
				'id'   => 'html_after_add_to_cart',
				'std'  => '',
				'type' => 'textarea',
			);

			$of_options[] = array(
				'name' => 'Thank You Page Content / Scripts',
				'desc' => 'Enter scripts or custom HTML content for the thank you page here',
				'id'   => 'html_thank_you',
				'std'  => '',
				'type' => 'textarea',
			);

			$of_options[] = array(
				'name' => 'Catalog Mode',
				'type' => 'heading',
			);

			$of_options[] = array(
				'name' => 'Enable catalog mode',
				'id'   => 'catalog_mode',
				'desc' => 'Enable catalog mode. This will disable Add To Cart buttons / Checkout and Shopping cart.',
				'std'  => 0,
				'type' => 'checkbox',
			);

			$of_options[] = array(
				'name' => 'Disable prices',
				'id'   => 'catalog_mode_prices',
				'desc' => 'Select to disable prices on category pages and product page.',
				'std'  => 0,
				'type' => 'checkbox',
			);

			$of_options[] = array(
				'name' => 'Cart / Account replacement (header)',
				'id'   => 'catalog_mode_header',
				'std'  => '',
				'type' => 'textarea',
				'desc' => "Enter content you want to display instead of Account / Cart. Shortcodes are allowed. For search box enter <b>[search]</b>. For social icons enter: <b>[follow twitter='http://' facebook='http://' email='post@email.com' pinterest='http://']</b>",
			);

			$of_options[] = array(
				'name' => 'Add to cart replacement - Product page',
				'id'   => 'catalog_mode_product',
				'std'  => '',
				'type' => 'textarea',
				'desc' => 'Enter contact information or enquiry form shortcode here.',
			);

			$of_options[] = array(
				'name' => 'Add to cart replacement - Product Quick View',
				'id'   => 'catalog_mode_lightbox',
				'std'  => '',
				'type' => 'textarea',
				'desc' => 'Enter text that will show in product quick view',
			);

			$of_options[] = array(
				'name' => 'Infinite Scroll',
				'type' => 'heading',
			);

			$of_options[] = array(
				'name' => 'Infinite scroll category/products',
				'id'   => 'flatsome_infinite_scroll',
				'desc' => 'Enable infinite scroll for WooCommerce category/product archive.',
				'std'  => 0,
				'type' => 'checkbox',
			);

			$of_options[] = array(
				'name'    => 'Loading type',
				'id'      => 'infinite_scroll_loader_type',
				'desc'    => 'Select loading type animation or on button click.',
				'std'     => 'spinner',
				'type'    => 'select',
				'options' => array(
					'button'  => 'Button (On click)',
					'spinner' => 'Spinner',
					'image'   => 'Custom Image',
				),
			);

			$of_options[] = array(
				'name' => 'Custom loader image',
				'desc' => "Upload or choose a custom loader image (for loading type 'Custom Image').",
				'id'   => 'infinite_scroll_loader_img',
				'std'  => '',
				'type' => 'upload',
			);
		}

		// Portfolio.
		$of_options[] = array(
			'name' => 'Portfolio',
			'type' => 'heading',
		);

		$of_options[] = array(
			'name' => 'Enable Portfolio',
			'id'   => 'fl_portfolio',
			'desc' => 'Enable portfolio',
			'std'  => 1,
			'type' => 'checkbox',
		);

		// Mobile.
		$of_options[] = array(
			'name' => 'Mobile',
			'type' => 'heading',
		);

		$of_options[] = array(
			'name' => 'Parallax Mobile Support',
			'id'   => 'parallax_mobile',
			'desc' => 'Enable parallax for mobile devices',
			'std'  => 0,
			'type' => 'checkbox',
		);

		// Integrations.
		$of_options[] = array(
			'name' => 'Integrations',
			'type' => 'heading',
		);

		$of_options[] = array(
			'name' => '',
			'type' => 'info',
			'desc' => '<p style="font-size:14px">Additional options for integrated plugins will be shown here if they are activated.</p>',
		);

		$of_options[] = array(
			'name' => 'Flatsome Studio',
			'id'   => 'flatsome_studio',
			'desc' => 'Enable access to Flatsome Studio in UX Builder',
			'std'  => 1,
			'type' => 'checkbox',
		);


		if ( function_exists( 'ubermenu' ) ) {
			$of_options[] = array(
				'name' => 'Ubermenu',
				'id'   => 'flatsome_uber_menu',
				'desc' => 'Enable full width UberMenu. You can also insert this elsewhere by using the UberMenu options.',
				'std'  => 1,
				'type' => 'checkbox',
			);
		}

		// Yoast options.
		if ( class_exists( 'WPSEO_Frontend' ) ) {
			$of_options[] = array(
				'name' => 'Yoast Primary Category',
				'id'   => 'wpseo_primary_term',
				'desc' => 'Use Yoast primary category on product category pages and elements.',
				'std'  => 0,
				'type' => 'checkbox',
			);

			$of_options[] = array(
				'name'  => 'Yoast Breadcrumbs',
				'id'    => 'wpseo_breadcrumb',
				'desc'  => 'Use Yoast breadcrumbs on product category pages, single product pages and elements.',
				'std'   => 0,
				'folds' => 1,
				'type'  => 'checkbox',
			);

			$of_options[] = array(
				'name' => '',
				'id'   => 'wpseo_breadcrumb_remove_last',
				'desc' => 'Remove the last static crumb on single product pages (product title).',
				'std'  => 1,
				'fold' => 'wpseo_breadcrumb',
				'type' => 'checkbox',
			);
		}

		// Backup Options.
		$of_options[] = array(
			'name' => 'Backup and Import',
			'type' => 'heading',
		);

		$of_options[] = array(
			'name' => 'Backup and Restore Options',
			'id'   => 'of_backup',
			'std'  => '',
			'type' => 'backup',
			'desc' => 'You can use the two buttons below to backup your current options, and then restore it back at a later time. This is useful if you want to experiment on the options but would like to keep the old settings in case you need it back.',
		);

		$of_options[] = array(
			'name' => 'Transfer Theme Options Data',
			'id'   => 'of_transfer',
			'std'  => '',
			'type' => 'transfer',
			'desc' => 'You can transfer the saved options data between different installs by copying the text inside the text box. To import data from another install, replace the data in the text box with the one from another install and click "Import Options".',
		);

	} // End of 'of_options()' function.
} // End check if function exists: of_options()
