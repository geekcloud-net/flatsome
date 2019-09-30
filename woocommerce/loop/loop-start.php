<?php
/**
 * Product Loop Start
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     3.3.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$cols = esc_attr( wc_get_loop_prop( 'columns' ) );
?>
<div class="products <?php echo flatsome_product_row_classes( $cols ); ?>">
<?php

