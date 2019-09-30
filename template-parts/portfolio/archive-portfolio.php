<?php get_template_part('template-parts/portfolio/archive-portfolio-title', flatsome_option('portfolio_archive_title')); ?>

<div id="content" role="main" class="page-wrapper">
	<?php
		$cat = false;
		$filter = get_theme_mod( 'portfolio_archive_filter', 'left' );
		$filter_nav = get_theme_mod( 'portfolio_archive_filter_style', 'line-grow' );

		if($filter == 'disabled' || is_tax()){
			$filter = 'disabled';
		}

		// Check if category
		if(is_tax()){
			$cat = get_queried_object()->term_id;
		}

    // Height
    $height = '';
    if(get_theme_mod('portfolio_height')) $height = get_theme_mod('portfolio_height');

		echo do_shortcode('[featured_items_grid image_height="'.$height.'" filter="'.$filter.'" filter_nav="'.$filter_nav.'" type="row" cat="'.$cat.'"]');
	?>

<?php wp_reset_query(); ?>

</div><!-- #content -->
