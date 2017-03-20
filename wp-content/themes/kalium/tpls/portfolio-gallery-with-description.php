<?php
/**
 *	Kalium WordPress Theme
 *
 *	Laborator.co
 *	www.laborator.co
 */

?>
<div class="gallery gallery-type-description<?php when_match($image_spacing == 'nospacing', 'no-spacing'); when_match($full_width_gallery, 'full-width-container'); ?>">
	<?php
	foreach($gallery_items as $i => $gallery_item):

		$main_thumbnail_size = 1;

		# General Vars
		$description             = $gallery_item['description'];
		$description_width       = $gallery_item['description_width'];
		$description_alignment   = $gallery_item['description_alignment'];

		$main_thumbnail_size = 'portfolio-single-img-';
		$thumb_size = 2;


			# Column Classes
			$row_classes		 = array('row');
			$description_class   = array('col-sm-5');
			$image_class         = array('col-sm-7');

			switch($description_width)
			{
				case "4-12":
					$description_class = array('col-sm-4');
					$image_class       = array('col-sm-8');
					$thumb_size        = 1;
					break;

				case "6-12":
					$description_class = array('col-sm-6');
					$image_class       = array('col-sm-6');
					break;
			}

			$image_class[] = 'nivo';

			switch($images_reveal_effect)
			{
				case 'slidenfade':
					$row_classes[] = 'wow fadeInLab';
					break;

				case 'fade':
					$row_classes[] = 'wow fadeIn';
					break;
			}

			# Description Alignment
			if($description_alignment == 'right')
			{
				$description_class[] = 'pull-right-md';
			}

		$main_thumbnail_size .= $thumb_size;

		// Row-Start
		?>
		<div class="<?php echo implode(' ', $row_classes); ?>">
		<?php

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
			<div class="<?php echo implode(' ', $description_class); ?>">

				<div class="gallery-item-description hidden<?php when_match($i == 0, 'first-entry'); echo " description-{$description_alignment}"; ?>">
					<div class="post-formatting">
						<?php echo $description; # escaped by ACF plugin ?>
					</div>
				</div>
				<div class="lgrad"></div>

			</div>
			<div class="<?php echo implode(' ', $image_class); ?>">
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
			<div class="<?php echo implode(' ', $description_class); ?>">

				<div class="gallery-item-description hidden<?php when_match($i == 0, 'first-entry'); echo " description-{$description_alignment}"; ?>">
					<div class="post-formatting">
						<?php echo $description; # escaped by ACF plugin ?>
					</div>
				</div>
				<div class="lgrad"></div>

			</div>
			<div class="<?php echo implode(' ', $image_class); ?>">
				<div class="portfolio-images-slider do-lazy-load" data-autoswitch="<?php echo esc_attr($auto_switch); ?>">
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
			<div class="<?php echo implode(' ', $description_class); ?>">

				<div class="gallery-item-description hidden<?php when_match($i == 0, 'first-entry'); echo " description-{$description_alignment}"; ?>">
					<div class="post-formatting">
						<?php echo $description; # escaped by ACF plugin ?>
					</div>
				</div>
				<div class="lgrad"></div>

			</div>
			<div class="<?php echo implode(' ', $image_class); ?>">

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
					$video_poster_url = $video_poster['url'];
			}

			?>
			<div class="<?php echo implode(' ', $description_class); ?>">

				<div class="gallery-item-description hidden<?php when_match($i == 0, 'first-entry'); echo " description-{$description_alignment}"; ?>">
					<div class="post-formatting">
						<?php echo $description; # escaped by ACF plugin ?>
					</div>
				</div>
				<div class="lgrad"></div>

			</div>
			<div class="<?php echo implode(' ', $image_class); ?>">
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
			<div class="<?php echo implode(' ', $description_class); ?>">

				<div class="gallery-item-description hidden<?php when_match($i == 0, 'first-entry'); echo " description-{$description_alignment}"; ?>">
					<div class="post-formatting">
						<?php echo $description; # escaped by ACF plugin ?>
					</div>
				</div>
				<div class="lgrad"></div>

			</div>
			<div class="<?php echo implode(' ', $image_class); ?>">
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
			<div class="<?php echo implode(' ', $description_class); ?>">

				<div class="gallery-item-description hidden<?php when_match($i == 0, 'first-entry'); echo " description-{$description_alignment}"; ?>">
					<div class="post-formatting">
						<?php echo $description; # escaped by ACF plugin ?>
					</div>
				</div>
				<div class="lgrad"></div>

			</div>
			<div class="<?php echo implode(' ', $image_class); ?>">
				<div class="portfolio-video-holder <?php echo esc_attr($video_el_id); ?>">
					<?php echo $video_shortcode; # output generated by [video] shortcode ?>
				</div>
			</div>
			<?php

		endif;
		// End: Self-Hosted Video

		?>
		</div>
		<?php

	endforeach;
	?>
</div>