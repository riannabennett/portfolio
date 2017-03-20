<?php
/**
 *	Kalium WordPress Theme
 *
 *	Laborator.co
 *	www.laborator.co
 */

if( ! get_data('portfolio_prev_next'))
	return;


$include_categories = get_data('portfolio_prev_next_category') ? true : false;

$portfolio_archive_link = get_post_type_archive_link('portfolio');
$prev_next_type         = get_data('portfolio_prev_next_type');
$navigation_position    = get_data('portfolio_prev_next_position');

if(get_data('portfolio_archive_url'))
{
	$portfolio_archive_link = get_data('portfolio_archive_url');
}

$prev = get_next_post($include_categories, '', 'portfolio_category');
$next = get_previous_post($include_categories, '', 'portfolio_category');

$prev_title = get_the_title($prev);
$next_title = get_the_title($next);

if(isset($portfolio_type_full_bg) && $portfolio_type_full_bg)
{
	$prev_next_type = 'fixed';
	$navigation_position = 'right-side';
}

if($prev_next_type == 'simple'):

	$prev_link = get_permalink($prev);
	$next_link = get_permalink($next);

	?>
	<div class="row">
		<div class="col-xs-12">
			<div class="portfolio-big-navigation portfolio-navigation-type-simple wow fadeIn<?php echo $image_spacing == 'nospacing' ? ' with-margin' : ''; ?>">
				<div class="row">
		    		<div class="col-xs-5">
			    		<a class="previous pc-only<?php echo ! $prev ? ' not-clickable' : ''; ?>" href="<?php echo esc_url($prev_link); ?>"><?php _e('Previous project', 'kalium'); ?></a>
			    		<a class="previous mobile-only<?php echo ! $prev ? ' not-clickable' : ''; ?>" href="<?php echo esc_url($prev_link); ?>"><i class="fa flaticon-arrow427"></i></a>
		    		</div>

		    		<div class="col-xs-2 text-on-center">
			    		<a class="back-to-portfolio" href="<?php echo esc_url($portfolio_archive_link); ?>">
							<i class="fa flaticon-four60"></i>
						</a>
		    		</div>

		    		<div class="col-xs-5">
			    		<a class="next pc-only<?php echo ! $next ? ' not-clickable' : ''; ?>" href="<?php echo esc_url($next_link); ?>"><?php _e('Next project', 'kalium'); ?></a>
			    		<a class="next mobile-only<?php echo ! $next ? ' not-clickable' : ''; ?>" href="<?php echo esc_url($next_link); ?>"><i class="fa flaticon-arrow427"></i></a>
		    		</div>
				</div>
			</div>
		</div>
	</div>
	<?php

endif;


if($prev_next_type == 'fixed'):

	?>
	<div class="portfolio-navigation portfolio-navigation-type-fixed <?php echo esc_attr($navigation_position); ?> wow fadeIn" data-wow-duration="0.5s" data-wow-delay="0.9s">

		<a class="previous<?php echo ! $prev ? ' not-clickable' : ''; ?>" href="<?php echo get_permalink($prev); ?>" title="<?php echo esc_attr($prev_title); ?>">
			<i class="fa flaticon-arrow413"></i>
		</a>

		<a class="back-to-portfolio" href="<?php echo esc_url($portfolio_archive_link); ?>" title="<?php _e('Go to portfolio archive', 'kalium'); ?>">
			<i class="fa flaticon-four60"></i>
		</a>

		<a class="next<?php echo ! $next ? ' not-clickable' : ''; ?>" href="<?php echo get_permalink($next); ?>" title="<?php echo esc_attr($next_title); ?>">
			<i class="fa flaticon-arrow413"></i>
		</a>
	</div>
	<?php

endif;
