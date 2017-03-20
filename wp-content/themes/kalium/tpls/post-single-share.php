<?php
/**
 *	Kalium WordPress Theme
 *
 *	Laborator.co
 *	www.laborator.co
 */

global $blog_share_story, $share_story_networks;

if( ! get_data('blog_share_story'))
	return;

?>
<div class="col-xs-12">
	<div class="share-holder">
	    <h4><?php _e('Share.', 'kalium'); ?></h4>

	    <div class="social-links">
	    <?php
		foreach($share_story_networks['visible'] as $network_id => $network):

			if($network_id == 'placebo')
				continue;

			share_story_network_link($network_id, $id);

		endforeach;
		?>
	    </div>
	</div>
</div>