<?php
	function flatsome_checkout_breadcrumb_class($endpoint){
		$classes = array();
		if($endpoint == 'cart' && is_cart() ||
			$endpoint == 'checkout' && is_checkout() && !is_wc_endpoint_url('order-received') ||
			$endpoint == 'order-received' && is_wc_endpoint_url('order-received')) {
			$classes[] = 'current';
		} else{
			$classes[] = 'hide-for-small';
		}
		return implode(' ', $classes);
	}
	$steps = get_theme_mod('cart_steps_numbers', 0);
?>

<div class="checkout-page-title page-title">
	<div class="page-title-inner flex-row medium-flex-wrap container">
	  <div class="flex-col flex-grow medium-text-center">
	 	 <nav class="breadcrumbs flex-row flex-row-center heading-font checkout-breadcrumbs text-center strong <?php echo get_theme_mod('cart_steps_size','h2'); ?> <?php echo get_theme_mod('cart_steps_case','uppercase'); ?>">
  	   <a href="<?php echo esc_url( wc_get_cart_url() ); ?>" class="<?php echo flatsome_checkout_breadcrumb_class('cart'); ?>">
   			<?php if($steps) { echo '<span class="breadcrumb-step hide-for-small">1</span>'; } ?>
  	   	<?php _e('Shopping Cart', 'flatsome'); ?>
  	   	</a>
  	   <span class="divider hide-for-small"><?php echo get_flatsome_icon('icon-angle-right');?></span>
  	   <a href="<?php echo esc_url( wc_get_checkout_url() ); ?>" class="<?php echo flatsome_checkout_breadcrumb_class('checkout') ?>">
   			<?php if($steps) { echo '<span class="breadcrumb-step hide-for-small">2</span>'; } ?>
  	   	<?php _e('Checkout details', 'flatsome'); ?>
  	   </a>
  	   <span class="divider hide-for-small"><?php echo get_flatsome_icon('icon-angle-right');?></span>
  	   <a href="#" class="no-click <?php echo flatsome_checkout_breadcrumb_class('order-received'); ?>">
  	   	<?php if($steps) { echo '<span class="breadcrumb-step hide-for-small">3</span>'; } ?>
  	   	<?php _e('Order Complete', 'flatsome'); ?>
  	   </a>
		 </nav>
	  </div><!-- .flex-left -->
	</div><!-- flex-row -->
</div><!-- .page-title -->
