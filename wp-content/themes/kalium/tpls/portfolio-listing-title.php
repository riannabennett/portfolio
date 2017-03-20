<?php
/**
 *	Kalium WordPress Theme
 *
 *	Laborator.co
 *	www.laborator.co
 */

$portfolio_category_filter = get_data('portfolio_category_filter');

if(isset($lab_vc_portfolio_items) && $lab_vc_portfolio_items == true)
{
	$portfolio_title = $title;
	$portfolio_description = $description;
	
	$show_title_description = empty($portfolio_title) == false || empty($portfolio_description) == false;
	
	# Categories
	$current_portfolio_category    = '';
	$post_ids                      = array();
	$portfolio_category_filter     = $category_filter == 'yes';
	
	foreach($portfolio_query->posts as $post_entry)
	{
		$post_ids[] = $post_entry->ID;
	}
	
	$portfolio_categories = wp_get_object_terms($post_ids, 'portfolio_category');
}

if( ! $show_title_description && ! ($portfolio_category_filter && $portfolio_categories))
{
	return;
}
?>
<div class="portfolio-title-holder">
	<?php if($show_title_description): ?>
	<div class="pt-column">
		<div class="section-title no-bottom-margin">
			<?php if($portfolio_title): ?>
			<h1><?php echo esc_html($portfolio_title); ?></h1>
			<?php endif; ?>
			<?php echo lab_esc_script(wpautop($portfolio_description)); ?>
		</div>
	</div>
	<?php endif; ?>

	<?php if($portfolio_category_filter && $portfolio_categories): ?>
	<div class="pt-column">
		<div class="product-filter">
			<ul>
				<li class="<?php when_match($current_portfolio_category == '', 'active'); ?>">
					<a href="<?php echo esc_url($portfolio_url); ?>" data-term="*"><?php _e('All', 'kalium'); ?></a>
				</li>
			<?php
			foreach($portfolio_categories as $i => $term):

				$is_active = $current_portfolio_category && $current_portfolio_category == $term->slug;
				$term_link = get_term_link($term, 'portfolio_category');

				if($is_page_type)
				{
					$term_link = $portfolio_url . '?portfolio-category=' . $term->slug;
				}
			?>
			<li class="<?php when_match($is_active, 'active'); ?>">
				<a href="<?php echo esc_url($term_link); ?>" data-term="<?php echo esc_attr($term->slug); ?>"><?php echo esc_html($term->name); ?></a>
			</li>
			<?php
			endforeach;
			?>
			</ul>
		</div>
	</div>
	<?php endif; ?>
</div>