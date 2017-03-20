<?php
/**
 *	Kalium WordPress Theme
 *
 *	Laborator.co
 *	www.laborator.co
 */

global $portfolio_type, $portfolio_item_terms, $is_page_type, $portfolio_url;

switch($portfolio_type)
{
	case "type-1":
		$category_supported = get_data('portfolio_type_1_categories');
		break;

	case "type-2":
		$category_supported = get_data('portfolio_type_2_categories');
		break;
}

if($category_supported && $portfolio_item_terms): ?>
<p>
<?php
# Terms / Categories
$j = 0;
foreach($portfolio_item_terms as $term):

	$term_link = get_term_link($term, 'portfolio_category');

	if($is_page_type)
	{
		$term_link = $portfolio_url . '?portfolio-category=' . $term->slug;
	}

	echo $j > 0 ? ', ' : '';

	?><a href="<?php echo esc_url($term_link); ?>" data-term="<?php echo esc_attr($term->slug); ?>"><?php echo esc_html($term->name); ?></a><?php

	$j++;

endforeach;
?></p>
<?php endif; ?>