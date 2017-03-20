<?php
/**
 *	Kalium WordPress Theme
 *
 *	Laborator.co
 *	www.laborator.co
 */

the_post();

wp_enqueue_script(array('isotope', 'packery'));

get_header();

get_template_part('tpls/portfolio-listing');

get_footer();