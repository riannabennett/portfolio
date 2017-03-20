<?php
/**
 *	Kalium WordPress Theme
 *
 *	Laborator.co
 *	www.laborator.co
 */

?>
<?php if($blog_show_header && ($blog_title || $blog_description)): ?>
<div class="section-title">

	<?php if($blog_title): ?>
	<h1><?php echo esc_html($blog_title) ?></h1>
	<?php endif; ?>

	<?php if($blog_description): ?>
	<p><?php echo nl2br(esc_html($blog_description)); ?></p>
	<?php endif; ?>
</div>
<?php endif; ?>