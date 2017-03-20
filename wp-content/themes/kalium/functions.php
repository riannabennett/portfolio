<?php
/**
 *	Kalium WordPress Theme
 *
 *	Laborator.co
 *	www.laborator.co
 */

# Constants
define('THEMEDIR', 		get_template_directory() . '/');
define('THEMEURL', 		get_template_directory_uri() . '/');
define('THEMEASSETS',	THEMEURL . 'assets/');
define('TD', 			'kalium');
define("TS", microtime(true));

# Initial Actions
add_action('after_setup_theme', 	'laborator_after_setup_theme');
add_action('init', 					'laborator_init');

add_action('widgets_init', 			'laborator_widgets_init');

add_action('wp_head', 				'laborator_favicon');
add_action('wp_head', 				'laborator_wp_head', 100);
add_action('wp_enqueue_scripts', 	'laborator_wp_enqueue_scripts');
add_action('wp_print_scripts', 		'laborator_wp_print_scripts');

add_action('admin_print_styles', 	'laborator_admin_print_styles');
add_action('admin_menu', 			'laborator_menu_page');
add_action('admin_menu', 			'laborator_menu_documentation', 1000);
add_action('admin_enqueue_scripts', 'laborator_admin_enqueue_scripts');

add_action('wp_footer', 			'laborator_wp_footer');

# Theme Content Width
if ( ! isset($content_width))
{
	$content_width = 945;
}

# Theme Demo
if(file_exists(THEMEDIR . 'theme-demo/theme-demo.php') && is_readable(THEMEDIR . 'theme-demo/theme-demo.php'))
{
	require 'theme-demo/theme-demo.php';
}

# Core Files
require 'inc/lib/smof/smof.php';
require 'inc/laborator_functions.php';
require 'inc/laborator_actions.php';
require 'inc/laborator_filters.php';
require 'inc/laborator_portfolio.php';
require 'inc/laborator_woocommerce.php';
require 'inc/laborator_vc.php';
require 'inc/acf-fields.php';

# Library
require 'inc/lib/laborator/laborator_custom_css.php';
require 'inc/lib/class-tgm-plugin-activation.php';
require 'inc/lib/BFI_Thumb.php';

if(is_admin())
{
	require 'inc/lib/laborator/laborator-demo-content-importer/laborator_demo_content_importer.php';
}


/****** All Thumbnails ******/

# Thumbnail Sizes
$blog_single_height = get_data('blog_thumbnail_height');

if( ! is_numeric($blog_single_height))
{
	$blog_single_height = 490;
}

add_image_size('blog-thumb-1', 360, 252, true);
add_image_size('blog-thumb-2', 360, 360, true);
add_image_size('blog-thumb-3', 650, 455, true);
add_image_size('blog-single-1', 1140, $blog_single_height, $blog_single_height != 0);

# Portfolio Single Thumbs
$max_portfolio_width = 1680;

add_image_size('portfolio-single-img-1', $max_portfolio_width * 1.00);
add_image_size('portfolio-single-img-2', $max_portfolio_width * 0.70);
add_image_size('portfolio-single-img-3', $max_portfolio_width * 0.50);
add_image_size('portfolio-single-img-4', $max_portfolio_width * 0.35);

# Portfolio Loop Thumbs
$portfolio_thumbnail_size_1 = get_data('portfolio_thumbnail_size_1');
$portfolio_thumbnail_size_1 = $portfolio_thumbnail_size_1 ? $portfolio_thumbnail_size_1 : "505x420";
$portfolio_thumbnail_size_1 = explode("x", $portfolio_thumbnail_size_1);

$portfolio_thumbnail_size_2 = get_data('portfolio_thumbnail_size_2');
$portfolio_thumbnail_size_2 = $portfolio_thumbnail_size_2 ? $portfolio_thumbnail_size_2 : "505x420";
$portfolio_thumbnail_size_2 = explode("x", $portfolio_thumbnail_size_2);

add_image_size('portfolio-img-1', $portfolio_thumbnail_size_1[0], $portfolio_thumbnail_size_1[1], true);
add_image_size('portfolio-img-2', $portfolio_thumbnail_size_2[0], $portfolio_thumbnail_size_2[1], true);
add_image_size('portfolio-img-3', $portfolio_thumbnail_size_2[0]);

# Shop Thumbnails
add_image_size('shop-loop-thumb-1', 360, 460, true);
