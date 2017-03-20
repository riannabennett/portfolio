<?php
/**
 *	Kalium WordPress Theme
 *
 *	Laborator.co
 *	www.laborator.co
 */

global $post, $wp_roles;

if( ! $blog_author_info)
	return;

$user_id	  = $post->post_author;
$author       = get_userdata($user_id);
$role         = array_shift($author->roles);
$role_title   = $wp_roles->roles[$role]['name'];

$link 		  = site_url();

?>
<div class="blog-author-holder">
<?php

	if($link)
	{
		echo '<a href="'.$link.'" class="author-link" target="_blank">';
	}

	echo get_avatar($user_id, 96 * 2);
	
	if($link)
	{
		echo '</a>';
	}

	if($link)
	{
		echo '<a href="'.$link.'" class="author-link" target="_blank">';
	}
?>

	<span class="author-name">
		<?php the_author(); ?>
		<em><?php _e($role_title, TD); ?></em>
	</span>
	<?php

	if($link)
	{
		echo '</a>';
	}
	?>
</div>