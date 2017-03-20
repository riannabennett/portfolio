<?php
/**
 *	Kalium WordPress Theme
 *
 *	Laborator.co
 *	www.laborator.co
 */

the_post();

$item_type = get_field('item_type');

if(get_field('item_linking') == 'external')
{
	$launch_link_href = get_field('launch_link_href');
	
	if($launch_link_href && $launch_link_href != '#')
	{
		wp_redirect($launch_link_href);
		exit;
	}
}

get_header();

switch($item_type)
{
	case "type-1":
		get_template_part('tpls/portfolio-single-1');
		break;

	case "type-2":
		get_template_part('tpls/portfolio-single-2');
		break;

	case "type-3":
		get_template_part('tpls/portfolio-single-3');
		break;

	case "type-4":
		get_template_part('tpls/portfolio-single-4');
		break;

	case "type-5":
		get_template_part('tpls/portfolio-single-5');
		break;
}

get_footer();