<?php
/**
 *	Kalium WordPress Theme
 *
 *	Laborator.co
 *	www.laborator.co
 */

global $pagename, $dynamic_image_height;

# Retrieve portfolio query
include_once THEMEDIR . 'tpls/portfolio-query.php';

# Portfolio Container Class
$portfolio_container_class = array();
$portfolio_container_class[] = 'portfolio-holder';
$portfolio_container_class[] = 'portfolio-' . $portfolio_type;

if(isset($portfolio_type_2_grid_spacing) && $portfolio_type_2_grid_spacing == 'merged')
{
	$portfolio_container_class[] = 'default-horizontal-margin';
}

if(($portfolio_type == 'type-2' && $masonry_style_portfolio) || ($portfolio_type == 'type-2' && $dynamic_image_height) || $portfolio_type_1_dynamic_height)
{
	$portfolio_container_class[] = 'is-masonry-layout';
}
?>

<div class="container">

	<?php include locate_template('tpls/portfolio-listing-title.php'); ?>

	<div class="page-container">
		<div class="row">
			<div id="isotope-portfolio-items" class="<?php echo implode(' ', $portfolio_container_class); ?>">
			<?php
			$i = 0;
			while($portfolio_query->have_posts()): $portfolio_query->the_post();

				global $i;

				switch($portfolio_type)
				{
					case 'type-1':
						get_template_part('tpls/portfolio-loop-item-type-1');
						break;

					case 'type-2':
						get_template_part('tpls/portfolio-loop-item-type-2');
						break;
				}
				$i++;

			endwhile;
			?>
			</div>

			<?php
			if($max_num_pages > 1):

				switch($pagination_type)
				{
					case 'endless':
					case 'endless-reveal':
						$endless_opts = array(
							'per_page'	   => $portfolio_query->query_vars['posts_per_page'],
							'current'      => $current_page + 1,
							'maxpages'     => $max_num_pages,

							'reveal'       => $pagination_type == 'endless-reveal',

							'action'       => 'laborator_get_paged_portfolio_items',
							'callback'     => 'laboratorGetPortfolioItems',

							'type'  	   => get_data('portfolio_endless_pagination_style'),

							'finished'	   => __('No more portfolio items to show', 'kalium'),

							'opts'         => array(
								'pagename' => $pagename,
								'q' => rot13encrypt(serialize($portfolio_query->query))
							)
						);

						laborator_show_endless_pagination($endless_opts);
						break;

					default:
						laborator_show_pagination($current_page, $max_num_pages, $from, $to, $pagination_position);
				}

			endif;
			?>
		</div>
	</div>

</div>
