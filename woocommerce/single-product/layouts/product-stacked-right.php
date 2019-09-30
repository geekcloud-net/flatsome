<div class="product-container">

<div class="product-main">
	<div class="row content-row mb-0">

		<div class="product-gallery col large-<?php echo flatsome_option('product_image_width'); ?>">
		<?php
			/**
			 * woocommerce_before_single_product_summary hook
			 *
			 * @hooked woocommerce_show_product_images - 20
			 */
			do_action( 'woocommerce_before_single_product_summary' );
		?>
		</div>

		<div class="product-info summary col-fit col entry-summary <?php flatsome_product_summary_classes();?>">
      <div class="is-sticky-column"><div class="is-sticky-column__inner">
        <div class="product-stacked-info">
              <?php if(!get_theme_mod('product_header') && get_theme_mod('product_next_prev_nav',1)) { ?>
                <div class="product-stacked-next-prev-nav absolute top right hide-for-medium">
                  <?php  flatsome_product_next_prev_nav('nav-right'); ?>
                </div>
              <?php } ?>
        			<?php
        				/**
        				 * woocommerce_single_product_summary hook
        				 *
        				 * @hooked woocommerce_template_single_title - 5
        				 * @hooked woocommerce_template_single_rating - 10
        				 * @hooked woocommerce_template_single_price - 10
        				 * @hooked woocommerce_template_single_excerpt - 20
        				 * @hooked woocommerce_template_single_add_to_cart - 30
        				 * @hooked woocommerce_template_single_meta - 40
        				 * @hooked woocommerce_template_single_sharing - 50
        				 */
        				do_action( 'woocommerce_single_product_summary' );
        			?>
          </div>
        </div>
      </div></div>
		</div><!-- .summary -->

	<div id="product-sidebar" class="mfp-hide">
		<div class="sidebar-inner">
			<?php
			do_action( 'flatsome_before_product_sidebar' );
			/**
			 * woocommerce_sidebar hook
			 *
			 * @hooked woocommerce_get_sidebar - 10
			 */
			if ( is_active_sidebar( 'product-sidebar' ) ) {
				dynamic_sidebar( 'product-sidebar' );
			} else if ( is_active_sidebar( 'shop-sidebar' ) ) {
				dynamic_sidebar( 'shop-sidebar' );
			}
			?>
		</div><!-- .sidebar-inner -->
	</div>

	</div><!-- .row -->
</div><!-- .product-main -->

<div class="product-footer">
	<div class="container">
		<?php
			/**
			 * woocommerce_after_single_product_summary hook
			 *
			 * @hooked woocommerce_output_product_data_tabs - 10
			 * @hooked woocommerce_upsell_display - 15
			 * @hooked woocommerce_output_related_products - 20
			 */
			do_action( 'woocommerce_after_single_product_summary' );
		?>
	</div><!-- .container -->
</div><!-- .product-footer -->
</div><!-- .product-container -->
