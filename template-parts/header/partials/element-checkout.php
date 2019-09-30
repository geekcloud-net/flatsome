<?php
if ( ! is_woocommerce_activated() ) {
	fl_header_element_error( 'woocommerce' );
	return;
}
?>
<li>
	<div class="cart-checkout-button header-button">
		<a href="<?php echo esc_url( wc_get_checkout_url() ); ?>" class="<?php if ( is_checkout() ) { ?>disabled<?php } ?> button cart-checkout secondary is-small circle">
			<span class="hide-for-small"><?php esc_html_e( 'Checkout', 'woocommerce' ); ?></span>
			<span class="show-for-small">+</span>
		</a>
	</div>
</li>
