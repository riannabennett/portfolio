<?php
/**
 *	Kalium WordPress Theme
 *
 *	Laborator.co
 *	www.laborator.co
 */

# Location Rules for Portfolio Item Types
add_filter('acf/location/rule_types', 'laborator_acf_location_rules_types');
add_filter('acf/location/rule_values/portfolio_item_type', 'laborator_acf_location_rules_values_item_type');
add_filter('acf/location/rule_match/portfolio_item_type', 'laborator_acf_location_rules_item_type', 10, 3);


function laborator_acf_location_rules_types($choices)
{
	$choices['Other']['portfolio_item_type'] = 'Portfolio Item Type';

	return $choices;
}

function laborator_acf_location_rules_values_item_type($choices)
{
	$portfolio_item_types = array(
		'type-1' => 'Portfolio Style 1',
		'type-2' => 'Portfolio Style 2',
		'type-3' => 'Portfolio Style 3',
		'type-4' => 'Portfolio Style 4',
		'type-5' => 'Portfolio Style 5',
	);

	return $portfolio_item_types;
}

function laborator_acf_location_rules_item_type($match, $rule, $options)
{
	$rule_item_type = $rule['value'];

	if($options['post_id'])
	{
		# Current Post
		$current_post = get_post($options['post_id']);
		$item_type = $current_post->item_type;

		if($rule['operator'] == "==")
		{
			return $rule_item_type == $item_type;
		}
	}
}


# Portfolio Like Column
add_filter('manage_edit-portfolio_columns', 'laborator_portfolio_like_column');
add_action('manage_portfolio_posts_custom_column', 'laborator_portfolio_like_column_content', 10, 2);

add_action('wp_ajax_lab_portfolio_reset_likes', 'lab_portfolio_reset_likes_ajax');

function laborator_portfolio_like_column($columns)
{
	$last_column = array_keys($columns);
	$last_column = end($last_column);
	
	$last_column_title = end($columns);
	
	unset($columns[$last_column]);
	
	$columns['likes'] = 'Likes';
	$columns[$last_column] = $last_column_title;
	
	return $columns;
}

function laborator_portfolio_like_column_content($column, $post_id)
{
	global $post;

	switch($column)
	{
		case "likes":
			$likes = get_post_likes();
			echo '<span class="likes-num">' . number_format_i18n($likes['count'], 0) . '</span>';
			
			echo ' <a href="#" data-id="'.$post_id.'" class="portfolio-likes-reset" title="Reset likes for this item"> - <span>Reset</span></a>';
			break;
	}
}

function lab_portfolio_reset_likes_ajax()
{
	if(isset($_POST['post_id']) && is_numeric($_POST['post_id']))
	{
		$post_id = $_POST['post_id'];
		$post = get_post($post_id);
		
		if($post && $post->post_type == 'portfolio')
		{
			update_post_meta($post_id, 'post_likes', array());
			
			die('success');
		}
	}
}