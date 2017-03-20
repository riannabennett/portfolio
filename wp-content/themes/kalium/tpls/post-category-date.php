<?php
/**
 *	Kalium WordPress Theme
 *
 *	Laborator.co
 *	www.laborator.co
 */

if($blog_post_date || $blog_category):
?>
<div class="details">
<?php
	if($blog_post_date):
?>
	<div class="date">
		<i class="icon icon-basic-calendar"></i><?php the_time('d F Y'); ?>
	</div>
	<?php endif; ?>
	<?php if($blog_category): ?>
	<div class="category">
		<i class="icon icon-basic-folder-multiple"></i>
		<?php the_category(', '); ?>
	</div>
	<?php endif; ?>

	<?php if(false && is_single() && $blog_tags): ?>
	<div class="tags-list">
		<i class="icon icon-ecommerce-sales"></i>
		<?php the_tags('', ', ', ''); ?>
	</div>
	<?php endif; ?>
</div>
<?php endif; ?>