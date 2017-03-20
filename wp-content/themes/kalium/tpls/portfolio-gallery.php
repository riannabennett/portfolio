<?php
/**
 *	Kalium WordPress Theme
 *
 *	Laborator.co
 *	www.laborator.co
 */

$masonry_mode_gallery = get_field( 'masonry_mode_gallery' );
?>
<div class="gallery<?php 
	when_match($image_spacing == 'nospacing', 'no-spacing'); 
	when_match($full_width_gallery, 'full-width-container'); 
	when_match($masonry_mode_gallery, 'masonry-mode-gallery'); 
?>">
	<div class="row nivo">
		<?php
		foreach($gallery_items as $i => $gallery_item):

			$main_thumbnail_size = 1;

			# General Vars
			$column_width = $gallery_item['column_width'];

				# Column Classes
				$column_classes = array('col-xs-12');

				if($column_width == '1-2')
				{
					$column_classes = array('col-sm-6 col-xs-12');
					$main_thumbnail_size = 2;
				}
				elseif($column_width == '1-3')
				{
					$column_classes = array('col-sm-4 col-xs-12');
					$main_thumbnail_size = 3;
				}
				elseif($column_width == '2-3')
				{
					$column_classes = array('col-sm-8 col-xs-12');
					$main_thumbnail_size = 2;
				}
				elseif($column_width == '1-4')
				{
					$column_classes = array('col-sm-3 col-xs-12');
					$main_thumbnail_size = 4;
				}

				$main_thumbnail_size = 'portfolio-single-img-' . $main_thumbnail_size;

				switch($images_reveal_effect)
				{
					case 'slidenfade':
						$column_classes[] = 'wow fadeInLab';
						break;

					case 'fade':
						$column_classes[] = 'wow fadeIn';
						break;
				}


			// Image Type
			if($gallery_item['acf_fc_layout'] == 'image'):

				$img          = $gallery_item['image'];
				$caption      = nl2br(esc_html($img['caption']));
				$alt_text 	  = $img['alt'];
				$href		  = $img['url'];

				if( ! $img['id'])
					continue;

				$is_video = $alt_text && preg_match("/(youtube\.com|vimeo\.com)/i", $alt_text);

				?>
				<div class="<?php echo implode(' ', $column_classes); ?>">
					<a href="<?php echo $is_video ? esc_url($alt_text) : esc_url($href); ?>" class="photo" data-lightbox-gallery="post-gallery">
						<?php laborator_show_image_placeholder($img['id'], $main_thumbnail_size, 'do-lazy-load-on-shown'); ?>

						<?php if($caption): ?>
						<div class="caption">
							<h3><?php echo lab_esc_script($caption); ?></h3>
						</div>
						<?php endif; ?>
					</a>

				</div>
				<?php

			endif;
			// End: Image Type


			// Image Slider
			if($gallery_item['acf_fc_layout'] == 'images_slider'):

				$gallery_images = $gallery_item['images'];
				$auto_switch    = $gallery_item['auto_switch'];

				if( ! is_array($gallery_images) || ! $gallery_images)
					continue;

				wp_enqueue_script('slick');
				wp_enqueue_style('slick');

				?>
				<div class="<?php echo implode(' ', $column_classes); ?>">
					<div class="portfolio-images-slider do-lazy-load"<?php if($auto_switch): ?> data-autoswitch="<?php echo esc_attr($auto_switch); ?>"<?php endif; ?>>
						<?php
						foreach($gallery_images as $j => $image):

							$img_class = when_match($j > 0, 'hidden', '', false);
						?>
						<div class="image-slide nivo">
							<a href="<?php echo esc_url($image['url']); ?>" data-lightbox-gallery="post-gallery-<?php echo esc_attr($i); ?>">
								<?php laborator_show_image_placeholder($image['id'], $main_thumbnail_size, $img_class, true, ''); ?>
							</a>
						</div>
						<?php
						endforeach;
						?>
					</div>
				</div>
				<?php

			endif;
			// End: Image Slider


			// Comparison Images
			if($gallery_item['acf_fc_layout'] == 'comparison_images'):

				$image_1            = $gallery_item['image_1'];
				$image_2            = $gallery_item['image_2'];

				$image_1_label		= $image_1['title'];
				$image_2_label		= $image_2['title'];

				$image_1_attachment = wp_get_attachment_image_src($image_1['id'], $main_thumbnail_size);
				$image_1_id         = laborator_generate_as_element(array($image_1_attachment[1], $image_1_attachment[2]));

				wp_enqueue_script('image-comparison-slider');

				?>
				<div class="<?php echo implode(' ', $column_classes); ?>">

					<figure class="comparison-image-slider <?php echo esc_attr($image_1_id); ?>">

						<img data-src="<?php echo esc_url($image_1_attachment[0]); ?>" class="do-lazy-load-on-shown hidden" />

						<?php if($image_1_label): ?>
						<span class="cd-image-label" data-type="original"><?php echo esc_html($image_1_label); ?></span>
						<?php endif;?>

						<div class="cd-resize-img">
							<?php echo wp_get_attachment_image($image_2['id'], $main_thumbnail_size); ?>
							<?php if($image_2_label): ?>
							<span class="cd-image-label" data-type="modified"><?php echo esc_html($image_2_label); ?></span>
							<?php endif;?>
						</div>

						<span class="cd-handle"></span>
					</figure>

				</div>
				<?php

			endif;
			// End: Comparison Images


			// YouTube Video
			if($gallery_item['acf_fc_layout'] == 'youtube_video'):

				$video_url          = $gallery_item['video_url'];
				$video_resolution   = $gallery_item['video_resolution'];
				$player_options     = $gallery_item['player_options'];
				$video_poster       = $gallery_item['video_poster'];

				# Check Type
				parse_str(parse_url($video_url, PHP_URL_QUERY), $video_url_args);

				if( ! is_array($video_url_args) || ! isset($video_url_args['v']))
					continue;

				# Video Resolution
				if( ! preg_match("/^[0-9]+:[0-9]+$/", $video_resolution))
					$video_resolution = "16:9";

				$video_resolution	= explode(":", $video_resolution);

				# Generate Video Height
				$video_el_id = laborator_generate_as_element(array($video_resolution[0], $video_resolution[1]));

				# Player Enqueue
				$video_poster_url = '';

				if($player_options)
				{
					$player_skin = 'vjs-default-skin';

					if($player_options == 'minimal')
						$player_skin = 'vjs-sublime-skin';

					wp_enqueue_script(array('video-js', 'video-js-youtube'));
					wp_enqueue_style('video-js');

					if($video_poster['url'])
					{
						$video_poster_url = $video_poster['url'];
					}
				}

				?>
				<div class="<?php echo implode(' ', $column_classes); ?>">
					<div class="portfolio-video-holder player-<?php echo esc_attr($player_options); ?> <?php echo esc_attr($video_el_id); ?>">
						<?php
						switch($player_options):

							case 'default':
								echo '<iframe width="100%" height="100%" src="https://www.youtube.com/embed/'.$video_url_args['v'].'?rel=0&amp;controls=1&amp;showinfo=0" frameborder="0" allowfullscreen></iframe>';
								break;

							default:

								?>
								<video src="" class="video-js <?php echo esc_attr($player_skin); ?>" controls preload="auto" width="auto" height="auto"<?php if($video_poster_url): ?> poster="<?php echo esc_url($video_poster_url); ?>"<?php endif; ?> data-setup='{ "techOrder": ["youtube"], "src": "<?php echo esc_url($video_url); ?>" }'>
								<?php

						endswitch;
						?>
					</div>
				</div>
				<?php

			endif;
			// End: YouTube Video


			// Vimeo Video
			if($gallery_item['acf_fc_layout'] == 'vimeo_video'):

				$video_url          = $gallery_item['video_url'];
				$video_resolution   = $gallery_item['video_resolution'];

				# Check Type
				$video_path = explode("/", trim(parse_url($video_url, PHP_URL_PATH), '/'));
				$video_id = $video_path[0];

				if( ! is_numeric($video_id))
					continue;

				# Video Resolution
				if( ! preg_match("/^[0-9]+:[0-9]+$/", $video_resolution))
					$video_resolution = "16:9";

				$video_resolution	= explode(":", $video_resolution);

				# Generate Video Height
				$video_el_id = laborator_generate_as_element(array($video_resolution[0], $video_resolution[1]));

				# Enqueue Scripts
				wp_enqueue_script(array('video-js', 'video-js-vimeo'));
				wp_enqueue_style('video-js');

				?>
				<div class="<?php echo implode(' ', $column_classes); ?>">
					<div class="portfolio-video-holder <?php echo esc_attr($video_el_id); ?>">
						<video src="" class="video-js vjs-default-skin" controls preload="auto" width="auto" height="auto" data-setup='{ "techOrder": ["vimeo"], "src": "<?php echo esc_url($video_url); ?>", "loop": true, "autoplay": false }'></video>
					</div>
				</div>
				<?php

			endif;
			// End: Vimeo Video


			// Self-Hosted Video
			if($gallery_item['acf_fc_layout'] == 'selfhosted_video'):

				$video_file             = $gallery_item['video_file'];
				$video_resolution       = $gallery_item['video_resolution'];
				$player_options         = $gallery_item['player_options'];
				$video_poster           = $gallery_item['video_poster'];
				$video_file_pathinfo    = pathinfo($video_file['url']);

				# Check Type
				if( ! isset($video_file_pathinfo['extension']) || ! in_array(strtolower($video_file_pathinfo['extension']), array('mp4', 'webm', 'ogv')))
					continue;

				# Video Resolution
				if( ! preg_match("/^[0-9]+:[0-9]+$/", $video_resolution))
					$video_resolution = "16:9";

				$video_resolution	= explode(":", $video_resolution);

				# Generate Video Height
				$video_el_id = laborator_generate_as_element(array($video_resolution[0], $video_resolution[1]));

				# Player Skin
				$player_skin = 'vjs-default-skin';

				if($player_options == 'minimal')
					$player_skin = 'vjs-sublime-skin';

				# Prepare Video
				$videojs_atts = "data-setup=\"{}\" preload=\"auto\"";

				if($video_poster && $video_poster['url'])
					$videojs_atts .= ' poster="'.$video_poster['url'].'"';

				$video_shortcode = do_shortcode("[video src=\"{$video_file['url']}\"]");
				$video_shortcode = preg_replace(array('/<div.*?>.*?(<video.*?<\/video>).*?<\/div.*?>/s', '/(width|height)=".*?"\s?/'), array('\1', ''), $video_shortcode);
				$video_shortcode = str_replace(array('wp-video-shortcode', '<video'), array('video-js '.$player_skin.' auto-width', '<video ' . $videojs_atts), $video_shortcode);


				# Enqueue Scripts
				wp_enqueue_script(array('video-js'));
				wp_enqueue_style('video-js');
				?>
				<div class="<?php echo implode(' ', $column_classes); ?>">
					<div class="portfolio-video-holder <?php echo esc_attr($video_el_id); ?>">
						<?php echo $video_shortcode; # generated by [video] shortcode ?>
					</div>
				</div>
				<?php

			endif;
			// End: Self-Hosted Video


			// Text Quote
			if($gallery_item['acf_fc_layout'] == 'text_quote'):

				$quote_text = $gallery_item['quote_text'];
				$quote_author = $gallery_item['quote_author'];
				?>
				<div class="<?php echo implode(' ', $column_classes); ?>">
					<blockquote>
						<?php echo esc_html($quote_text); ?>

						<?php if($quote_author): ?>
							<span>- <?php echo esc_html($quote_author); ?></span>
						<?php endif; ?>
					</blockquote>
				</div>
				<?php

			endif;
			// End: Text Quote

		endforeach;
		?>
	</div>
</div>