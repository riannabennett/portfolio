<?php
/**
 *	Portfolio Items
 *	
 *	Laborator.co
 *	www.laborator.co 
 */

global $dynamic_image_height;

$lab_vc_portfolio_items = true;

# Atts
$defaults = array(
	'portfolio_query'      => '',
	'portfolio_type'       => '',
	'columns'      		   => '',
	'portfolio_spacing'    => '',
	'dynamic_image_height' => '',
	'more_link'            => '',
	'category_filter'      => '',
	'title'                => '',
	'description'          => '',
	'el_class'             => '',
	'css'                  => ''
);

$atts = vc_shortcode_attribute_parse($defaults, $atts);

if(isset($lab_masonry_portfolio) && $lab_masonry_portfolio == true)
{
	$atts['portfolio_type'] = 'type-2';
}

extract( $atts );

# Rebuild query params for Masonry Portfolio
if(isset($lab_masonry_portfolio) && $lab_masonry_portfolio == true)
{
	$portfolio_query = 'size:-1|order_by:post__in|post_type:portfolio|by_id:0';
	
	foreach($lab_vc_portfolio_items_details as $item)
	{
		$portfolio_query .= ",{$item['portfolio_id']}";
	}
}


# Retrieve portfolio main details
include locate_template('tpls/portfolio-query.php');

list($query_args, $portfolio_query) = vc_build_loop_query($portfolio_query);

# Masonry Reorder Items
if(isset($lab_masonry_portfolio) && $lab_masonry_portfolio == true)
{
	$posts_raw = $portfolio_query->posts;
	$posts_by_id = array();
	
	foreach($portfolio_query->posts as $pi)
	{
		$posts_by_id[$pi->ID] = $pi;
	}
	
	$portfolio_query->posts = array();
	
	foreach($lab_vc_portfolio_items_details as $item)
	{
		$portfolio_query->posts[] = $posts_by_id[ $item['portfolio_id'] ];
	}
	
	
}

$more_link = vc_build_link($more_link);

# Enqueue Scrips
wp_enqueue_script('isotope');

# Portfolio Vars
$columns_count = $columns;

if($portfolio_type == 'type-2' && $portfolio_spacing != 'inherit')
{
	$portfolio_type_2_grid_spacing = $portfolio_spacing == 'yes' ? 'normal' : 'merged';
}

# Portfolio Container Class
$portfolio_container_class = array();
$portfolio_container_class[] = 'portfolio-holder';
$portfolio_container_class[] = 'portfolio-' . $portfolio_type;

if(isset($portfolio_type_2_grid_spacing) && $portfolio_type_2_grid_spacing == 'merged')
{
	$portfolio_container_class[] = 'default-horizontal-margin';
}


if(($portfolio_type == 'type-2' && $dynamic_image_height) || (isset($lab_masonry_portfolio) && $lab_masonry_portfolio == true) || $portfolio_type_1_dynamic_height)
{
	wp_enqueue_script('packery');
	
	$portfolio_container_class[] = 'is-masonry-layout';
}

# Element Class
$class = $this->getExtraClass( $el_class );
$css_class = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, $class, $this->settings['base'], $atts );

$css_class = "lab-portfolio-items {$css_class}";

?>
<div class="<?php echo esc_attr($css_class) . vc_shortcode_custom_css_class($css, ' '); ?>">
	
	<?php include locate_template('tpls/portfolio-listing-title.php'); ?>
	
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
			
			wp_reset_postdata();
			?>
		</div>
		
		<?php if($more_link['url'] && $more_link['title']): ?>
		<div class="more-link <?php echo isset($show_effect) && $show_effect ? $show_effect : ''; ?>">
			<div class="show-more">
				<div class="button">
					<a href="<?php echo esc_url($more_link['url']); ?>" target="<?php echo esc_attr($more_link['target']); ?>" class="btn btn-white">
						<?php echo esc_html($more_link['title']); ?>
					</a>
				</div>
			</div>
		</div>
		<?php endif; ?>
		
	</div>
	
</div>
<?php
$lab_vc_portfolio_items = false;
