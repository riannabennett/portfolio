<?php
/**
 *	Kalium WordPress Theme
 *
 *	Laborator.co
 *	www.laborator.co
 */

global $blog_template, $sidebar_position, $thumb_size, $blog_post_formats, $blog_post_list_lazy_load;

$post_classes = array('box-holder');

# Rounded Blog Template Options
if($blog_template == 'blog-rounded')
{
	$thumb_size = 'blog-thumb-2';
	$post_classes[] = 'blog-rounded';

	$blog_post_formats = false;
}

# Post Classes
if($blog_post_formats)
{
	$post_classes[] = 'supports-formats';
}

if($sidebar_position == 'left')
{
	$post_classes[] = 'sidebar-is-left';
}

if($blog_post_list_lazy_load)
{
	$post_classes[] = 'do-lazy-load-on-shown';
}

# Get post info variables
include locate_template('tpls/post-details.php');

# Other Info
$sidebar_position = get_data('blog_sidebar_position');


# Blog Post Columns
$columns_thumbnail = $sidebar_position == 'hide' ? 4 : 5;
$columns_content = $show_thumbnails? ($sidebar_position == 'hide' ? 8 : 7) : 12;

if($blog_template == 'blog-rounded')
{
	$columns_thumbnail = $sidebar_position == 'hide' ? 3 : 4;
	$columns_content = $show_thumbnails? ($sidebar_position == 'hide' ? 9 : 8) : 12;
}

?>
<div <?php post_class($post_classes); ?>>
	<div class="row">
		<?php if($show_thumbnails): ?>
    	<div class="col-sm-<?php echo esc_attr($columns_thumbnail); ?>">
	    	<div class="post-format">
		    	
		    	<?php include locate_template('tpls/post-thumbnail.php'); ?>
		    	
	    	</div>
    	</div>
    	<?php endif; ?>

    	<div class="col-sm-<?php echo esc_attr($columns_content); ?>">
	    	<div class="post-info">
	    		<h2>
		    		<a href="<?php echo esc_url($permalink); ?>"><?php echo apply_filters('the_title', $post_title); ?></a>
		    	</h2>

	    		<?php echo apply_filters('the_excerpt', $post_excerpt); ?>

	    		<?php include locate_template('tpls/post-category-date.php'); ?>
	    	</div>
    	</div>
	</div>
</div>
