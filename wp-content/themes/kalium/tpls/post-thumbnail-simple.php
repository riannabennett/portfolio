<?php
/**
 *	Kalium WordPress Theme
 *	
 *	Laborator.co
 *	www.laborator.co 
 */

// When There is no post thumbnail
if(is_single() && ! $post_thumbnail_id)
{
	return;
}

$post_image = wp_get_attachment_image_src($post_thumbnail_id, $thumb_size);

?>
<a href="<?php echo is_single() && is_array($post_image) ? $post_image[0] : $permalink; ?>">
<?php 
if($post_thumbnail_id):
	laborator_show_image_placeholder($post_thumbnail_id, $thumb_size, '', $blog_post_list_lazy_load);
else:
	$element_id = laborator_generate_as_element($default_image_size);
	
	?>
	<span class="default-thumbnail-placeholder <?php echo esc_attr($element_id); ?>"></span>
	<?php
endif; 

// Hover State
include locate_template('tpls/post-hover.php');
?>
</a>