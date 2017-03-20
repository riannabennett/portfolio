<?php
/**
 *	Kalium WordPress Theme
 *
 *	Laborator.co
 *	www.laborator.co
 */

global
	$wp_query,
	$page,
	$paged,

	$portfolio_type,
	$portfolio_url,
	$is_page_type,

	$layout_type,
	$columns_count,
	$reveal_effect,
	$show_effect,

	$masonry_items_list,
	$dynamic_image_width,

	$masonry_style_portfolio,

	$portfolio_type_1_dynamic_height,
	$portfolio_type_1_hover_effect,
	$portfolio_type_1_hover_opacity,

	$portfolio_type_2_grid_spacing,
	$portfolio_type_2_hover_effect,
	$portfolio_type_2_hover_text_position,
	$portfolio_type_2_hover_style,
	$portfolio_type_2_hover_opacity,
	$portfolio_type_2_likes_show;

$is_page_type = false;

# Predefined Settings for Portfolio Types
$dynamic_image_height	= false;
$custom_query           = null;

$portfolio_type         = get_data('portfolio_type');
$show_title_description = get_data('portfolio_show_header_title');
$portfolio_title        = get_data('portfolio_title');
$portfolio_description  = get_data('portfolio_description');
$reveal_effect          = get_data('portfolio_reveal_effect');

$portfolio_categories   = get_terms('portfolio_category');

# Visual Composer Settings
if(isset($lab_vc_portfolio_items) && $lab_vc_portfolio_items == true)
{
	$portfolio_type = $atts['portfolio_type'];
	
	if($portfolio_type == 'type-2' && $atts['dynamic_image_height'] == 'yes')
	{
		$portfolio_type = 'type-3';
	}
	
	if($atts['reveal_effect'] != 'inherit')
	{
		$reveal_effect = $atts['reveal_effect'];
	}
}

# type-3 is the same as type-2
if(in_array($portfolio_type, array('type-3')))
{
	$portfolio_type        = 'type-2';
	$dynamic_image_height  = true;
}

	# Portfolio Item Type 1
	$portfolio_type_1_dynamic_height   = get_data('portfolio_type_1_dynamic_height');
	$portfolio_type_1_hover_effect     = get_data('portfolio_type_1_hover_effect');
	$portfolio_type_1_hover_color      = get_data('portfolio_type_1_hover_color');
	
	if(isset($lab_vc_portfolio_items) && $lab_vc_portfolio_items == true && $portfolio_type == 'type-1' && $atts['dynamic_image_height'] == 'yes')
	{
		$portfolio_type_1_dynamic_height = true;
	}
	

	# Portfolio Item Type 2
	$portfolio_type_2_grid_spacing         = get_data('portfolio_type_2_grid_spacing');
	$portfolio_type_2_hover_effect         = get_data('portfolio_type_2_hover_effect');
	$portfolio_type_2_hover_text_position  = get_data('portfolio_type_2_hover_text_position');
	$portfolio_type_2_hover_color          = get_data('portfolio_type_2_hover_color');
	$portfolio_type_2_hover_style          = get_data('portfolio_type_2_hover_style');
	$portfolio_type_2_likes_show           = get_data('portfolio_type_2_likes_show');


	# Based on selected portfolio type set the defaults
	switch($portfolio_type)
	{
		case "type-1":
			$columns_count   = get_data('portfolio_type_1_columns_count');
			$items_per_page  = get_data('portfolio_type_1_items_per_page');
			break;

		case "type-2":
			$columns_count   = get_data('portfolio_type_2_columns_count');
			$items_per_page  = get_data('portfolio_type_2_items_per_page');
			break;
	}
	

# Visual Component
if(isset($lab_vc_portfolio_items) && $lab_vc_portfolio_items == true)
{
	return;
}

# Page Settings (Inherited from page post type)
if(is_page())
{
	$is_page_type 			= true;

	$portfolio_title        = get_the_title();
	$portfolio_description  = get_the_content();
	$portfolio_url          = get_permalink();

	$columns_count          = get_field('columns_count');
	$reveal_effect			= get_field('reveal_effect');
	$layout_type			= get_field('layout_type');

	$show_title_description = get_field('show_title_description');
	$custom_query			= get_field('custom_query');
	$portfolio_items		= get_field('portfolio_items');
	$select_from_category	= get_field('select_from_category');
	$order_by				= get_field('order_by');
	$order					= get_field('order');

	$items_per_page 		= get_field('items_per_page');

	# Masonry Mode Items
	$masonry_style_portfolio   = get_field('masonry_style_portfolio');
	$masonry_items_list        = get_field('masonry_items_list');
	$masonry_items_list_new    = array();
	
	if($masonry_style_portfolio && count($masonry_items_list))
	{
		foreach($masonry_items_list as $row)
		{
			$masonry_items_list_new = array_merge($masonry_items_list_new, $row['items_row']);
		}

		$masonry_items_list = $masonry_items_list_new;
		$layout_type = 'type-2'; # Force Use Portfolio Layout Type Masonry
	}

	# Other Toggles
	if($reveal_effect == 'inherit')
	{
		$reveal_effect = get_data('portfolio_reveal_effect');
	}

	switch($layout_type)
	{
		case "type-1":
			$portfolio_type = $layout_type;

			$use_dynamic_img_h       = get_field('portfolio_type_1_dynamic_image_height');
			$thumbnail_hover_effect  = get_field('portfolio_type_1_thumbnail_hover_effect');
			$custom_hover_bg_color   = get_field('portfolio_type_1_custom_hover_background_color');
			

			if($use_dynamic_img_h != 'inherit')
			{
				$portfolio_type_1_dynamic_height = $use_dynamic_img_h == 'yes';
			}

			if($thumbnail_hover_effect != 'inherit')
			{
				$portfolio_type_1_hover_effect = $thumbnail_hover_effect;
			}

			if($custom_hover_bg_color)
			{
				$portfolio_type_1_hover_color = $custom_hover_bg_color;
			}
			break;

		case "type-2":
			$portfolio_type = $layout_type;

			$grid_spacing            = get_field('portfolio_type_2_grid_spacing');
			$thumbnail_hover_effect  = get_field('portfolio_type_2_thumbnail_hover_effect');
			$thumbnail_hover_style	 = get_field('portfolio_type_2_thumbnail_hover_style');
			$custom_hover_bg_color	 = get_field('portfolio_type_2_custom_hover_background_color');
			$use_dynamic_img_h		 = get_field('portfolio_type_2_dynamic_image_height');
			$thumbnail_text_position = get_field('portfolio_type_2_thumbnail_hover_text_position');
			

			if($use_dynamic_img_h != 'inherit')
			{
				$dynamic_image_height = $use_dynamic_img_h == 'yes';
			}

			if($grid_spacing != 'inherit')
			{
				$portfolio_type_2_grid_spacing = $grid_spacing;
			}

			if($thumbnail_hover_effect != 'inherit')
			{
				$portfolio_type_2_hover_effect = $thumbnail_hover_effect;
			}

			if($thumbnail_text_position != 'inherit')
			{
				$portfolio_type_2_hover_text_position = $thumbnail_text_position;
			}

			if($thumbnail_hover_style != 'inherit')
			{
				$portfolio_type_2_hover_style = $thumbnail_hover_style;
			}

			if($custom_hover_bg_color)
			{
				$portfolio_type_2_hover_color = $custom_hover_bg_color;
			}

			break;
	}
}



# Portfolio Query
$portfolio_query_args = array(
	"post_type" => "portfolio"
);

	# Category
	if(isset($wp_query->is_archive) && is_array($wp_query->query))
	{
		$portfolio_query_args = array_merge($portfolio_query_args, $wp_query->query);
	}

	# Custom Query
	if($custom_query && $masonry_style_portfolio == false)
	{
		# Custom Items to Include
		if($portfolio_items && count($portfolio_items))
			$portfolio_query_args['post__in'] = $portfolio_items;

		# Filter by Category
		if($select_from_category && is_array($select_from_category))
		{
			$portfolio_query_args['tax_query'] = array(
				'relation' => 'OR',

				array(
					'taxonomy' => 'portfolio_category',
					'field'    => 'id',
					'terms'    => $select_from_category,
				)
			);

			if($portfolio_categories)
			{
				foreach($portfolio_categories as $term_i => $term)
				{
					if( ! in_array($term->term_id, $select_from_category))
						unset($portfolio_categories[$term_i]);
				}
			}
		}

		# Ordering
		$portfolio_query_args['orderby'] = $order_by;
		$portfolio_query_args['order'] = $order;
	}

	# Masonry Items List
	if(isset($masonry_style_portfolio) && isset($masonry_items_list) && $masonry_style_portfolio && count($masonry_items_list))
	{
		$portfolio_query_args['post__in'] = array();

		$portfolio_query_args['orderby'] = 'post__in';
		$portfolio_query_args['order'] = 'ASC';

		foreach($masonry_items_list as $item)
		{
			if(isset($item['item']) && $item['item'] instanceof WP_Post)
			{
				$portfolio_query_args['post__in'][] = $item['item']->ID;
			}
		}
	}

	# Posts per page
	if($items_per_page && $items_per_page != 0)
	{
		$portfolio_query_args['posts_per_page'] = $items_per_page;
	}
	else
	{
		$portfolio_query_args['posts_per_page'] = get_option('posts_per_page');
	}
	
	$portfolio_query_args['posts_per_page'] = apply_filters('lab_portfolio_items_per_page', $portfolio_query_args['posts_per_page']);


	# Get Category
	if($category_id = lab_get('portfolio-category'))
	{
		$portfolio_query_args['portfolio_category'] = $category_id;
	}

	# Current Page
	if($page > $paged)
	{
		$paged = $page;
	}

	if($paged > 1)
	{
		$portfolio_query_args['paged'] = $paged;
	}
	
	# Unset unwanted query arguments like page name and id
	if(isset($portfolio_query_args['pagename']))
	{
		unset($portfolio_query_args['pagename']);
	}
	
	if(isset($portfolio_query_args['page_id']))
	{
		unset($portfolio_query_args['page_id']);
	}



# Return in case of ajax requests
if(defined("DOING_AJAX"))
{
	return;
}

$portfolio_query = new WP_Query($portfolio_query_args);

$current_portfolio_category = isset($portfolio_query->query_vars['portfolio_category']) ? $portfolio_query->query_vars['portfolio_category'] : '';

# Pagination
$pagination_type		= get_data('portfolio_pagination_type');
$pagination_position    = get_data('portfolio_pagination_position');

$max_num_pages          = $portfolio_query->max_num_pages;
$paged                  = $portfolio_query->query_vars['paged'];

if($page > $paged)
	$paged = $page;

# Pagination
if($max_num_pages > 1)
{

	$_from               = 1;
	$_to                 = $max_num_pages;
	$current_page        = $paged ? $paged : 1;
	$numbers_to_show     = 5;

	list($from, $to) = generate_from_to($_from, $_to, $current_page, $max_num_pages, $numbers_to_show);
}


# Custom CSS
if($portfolio_type_1_hover_color)
{
	generate_custom_style(".portfolio-holder .product-box .photo .on-hover", "background-color: {$portfolio_type_1_hover_color} !important;");
}

if($portfolio_type_2_hover_color)
{
	generate_custom_style(".product-box .thumb .hover-state", "background-color: {$portfolio_type_2_hover_color} !important;");
}
