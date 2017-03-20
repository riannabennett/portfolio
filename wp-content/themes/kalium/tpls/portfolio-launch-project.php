<?php
/**
 *	Kalium WordPress Theme
 *
 *	Laborator.co
 *	www.laborator.co
 */


if($launch_link_href): ?>
<div class="link">
	<a href="<?php echo esc_url($launch_link_href); ?>"<?php if($new_window): ?> target="_blank"<?php endif; ?>><?php echo esc_html($launch_link_title); ?></a>
</div>
<?php endif; ?>