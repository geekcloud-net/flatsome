<?php
/**
 * Sensei plugin integration
 */

/** @var $woothemes_sensei Sensei_Main */
global $woothemes_sensei;

remove_action( 'sensei_before_main_content', array( $woothemes_sensei->frontend, 'sensei_output_content_wrapper' ), 10 );
remove_action( 'sensei_after_main_content', array( $woothemes_sensei->frontend, 'sensei_output_content_wrapper_end' ), 10 );
remove_action( 'pre_get_posts', array( $woothemes_sensei->course, 'allow_course_archive_on_front_page' ), 9 );

add_action( 'sensei_before_main_content', 'fl_sensei_theme_wrapper_start', 10 );
add_action( 'sensei_after_main_content', 'fl_sensei_theme_wrapper_end', 10 );

/**
 * Theme wrapper start for sensei.
 */
function fl_sensei_theme_wrapper_start() {
	echo '<div class="sensei-page page-wrapper"><div class="row"><div class="large-12 col">';
}

/**
 * Theme wrapper end for sensei.
 */
function fl_sensei_theme_wrapper_end() {
	echo '</div></div></div>';
}
