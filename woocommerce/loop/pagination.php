<?php
/**
 * Pagination - Show numbered pagination for catalog pages
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     3.3.1
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$total   = isset( $total ) ? $total : wc_get_loop_prop( 'total_pages' );
$current = isset( $current ) ? $current : wc_get_loop_prop( 'current_page' );
$base    = isset( $base ) ? $base : esc_url_raw( str_replace( 999999999, '%#%', remove_query_arg( 'add-to-cart', get_pagenum_link( 999999999, false ) ) ) );
$format  = isset( $format ) ? $format : '';

if ( $total <= 1 ) {
	return;
}
?>
<div class="container">
<nav class="woocommerce-pagination">
	<?php
		$pages = paginate_links( apply_filters( 'woocommerce_pagination_args', array( // WPCS: XSS ok.
			'base'      => $base,
			'format'    => $format,
			'add_args'  => false,
			'current'   => max( 1, $current ),
			'total'     => $total,
			'prev_text' => '<i class="icon-angle-left"></i>',
			'next_text' => '<i class="icon-angle-right"></i>',
			'type'      => 'array',
			'end_size'  => 3,
			'mid_size'  => 3,
		) ) );

		if ( is_array( $pages ) ) {
			$paged = ( get_query_var( 'paged' ) == 0 ) ? 1 : get_query_var( 'paged' );
			echo '<ul class="page-numbers nav-pagination links text-center">';
			foreach ( $pages as $page ) {
				$page = str_replace( 'page-numbers', 'page-number', $page );
				echo '<li>' . $page . '</li>';
			}
			echo '</ul>';
		}
	?>
</nav>
</div>
