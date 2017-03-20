<?php
/**
 *	Kalium WordPress Theme
 *
 *	Laborator.co
 *	www.laborator.co
 */


# GET/POST getter
function lab_get($var)
{
	return isset($_GET[$var]) ? $_GET[$var] : (isset($_REQUEST[$var]) ? $_REQUEST[$var] : '');
}

function post($var)
{
	return isset($_POST[$var]) ? $_POST[$var] : null;
}

function cookie($var)
{
	return isset($_COOKIE[$var]) ? $_COOKIE[$var] : null;
}

# Echo
function when_match($bool, $str = '', $otherwise_str = '', $echo = true)
{
	$str = ' ' . trim($bool ? $str : $otherwise_str);
	$str = esc_attr($str);
	
	if($echo)
	{
		echo $str;
		return;
	}

	return $str;
}


# Generate From-To numbers borders
function generate_from_to($from, $to, $current_page, $max_num_pages, $numbers_to_show = 5)
{
	if($numbers_to_show > $max_num_pages)
		$numbers_to_show = $max_num_pages;


	$add_sub_1 = round($numbers_to_show/2);
	$add_sub_2 = round($numbers_to_show - $add_sub_1);

	$from = $current_page - $add_sub_1;
	$to = $current_page + $add_sub_2;

	$limits_exceeded_l = FALSE;
	$limits_exceeded_r = FALSE;

	if($from < 1)
	{
		$from = 1;
		$limits_exceeded_l = TRUE;
	}

	if($to > $max_num_pages)
	{
		$to = $max_num_pages;
		$limits_exceeded_r = TRUE;
	}


	if($limits_exceeded_l)
	{
		$from = 1;
		$to = $numbers_to_show;
	}
	else
	if($limits_exceeded_r)
	{
		$from = $max_num_pages - $numbers_to_show + 1;
		$to = $max_num_pages;
	}
	else
	{
		$from += 1;
	}

	if($from < 1)
		$from = 1;

	if($to > $max_num_pages)
	{
		$to = $max_num_pages;
	}

	return array($from, $to);
}

# Laborator Pagination
function laborator_show_pagination($current_page, $max_num_pages, $from, $to, $pagination_position = 'full', $numbers_to_show = 5)
{
	$current_page = $current_page ? $current_page : 1;

	?>
	<div class="clear"></div>

	<!-- pagination -->
	<div class="pagination-holder<?php echo " pagination-holder-{$pagination_position}"; ?>">

		<ul class="pagination">

		<?php /*TMP
	if($current_page > 1): ?>
			<li class="first_page"><a href="<?php echo get_pagenum_link(1); ?>"><?php _e('&laquo; First's); ?></a></li>
		<?php endif;
	*/ ?>

		<?php if($current_page > 1): ?>
			<li class="first_page"><a href="<?php echo get_pagenum_link($current_page - 1); ?>"><i class="flaticon-arrow427"></i> <?php _e('Previous', 'kalium'); ?></a></li>
		<?php endif; ?>

		<?php

		if($from > floor($numbers_to_show / 2))
		{
			?>
			<li><a href="<?php echo get_pagenum_link(1); ?>"><?php echo 1; ?></a></li>
			<li class="dots"><span>...</span></li>
			<?php
		}

		for($i=$from; $i<=$to; $i++):

			$link_to_page = get_pagenum_link($i);
			$is_active = $current_page == $i;

		?>
			<li<?php echo $is_active ? ' class="active"' : ''; ?>><a href="<?php echo esc_url($link_to_page); ?>"><?php echo esc_html($i); ?></a></li>
		<?php
		endfor;


		if($max_num_pages > $to)
		{
			if($max_num_pages != $i):
			?>
				<li class="dots"><span>...</span></li>
			<?php
			endif;

			?>
			<li><a href="<?php echo get_pagenum_link($max_num_pages); ?>"><?php echo esc_html($max_num_pages); ?></a></li>
			<?php
		}
		?>

		<?php if($current_page + 1 <= $max_num_pages): ?>
			<li class="last_page"><a href="<?php echo get_pagenum_link($current_page + 1); ?>"><?php _e('Next', 'kalium'); ?> <i class="flaticon-arrow413"></i></a></li>
		<?php endif; ?>

		<?php /*TMPif($current_page < $max_num_pages): ?>
			<li class="last_page"><a href="<?php echo get_pagenum_link($max_num_pages); ?>"><?php _e('Last &raquo;', TD); ?></a></li>
		<?php endif;*/ ?>
		</ul>

	</div>
	<!-- end: pagination -->
	<?php

	# Deprecated (the above function displays pagination)
	if(false):

		posts_nav_link();

	endif;
}



# Get SMOF data
$data_cached			= array();
$smof_filters		   = array();
$data				   = function_exists('of_get_options') ? of_get_options() : array();
$data_iteration_count   = 0;

function get_data($var = '', $default = '')
{
	global $data, $data_cached, $data_iteration_count;

	$data_iteration_count++;

	if( ! function_exists('of_get_options'))
		return null;

	if(isset($data_cached[$var]))
	{
		return apply_filters("get_data_{$var}", $data_cached[$var]);
	}

	if( ! empty($var) && isset($data[$var]))
	{
		if(empty($data[$var]) && $default)
		{
			$data[$var] = $default;
		}
		
		$data_cached[$var] = $data[$var];

		return apply_filters("get_data_{$var}", $data[$var]);
	}

	return $default;
}


# Compress Text Function
function compress_text($buffer)
{
	/* remove comments */
	$buffer = preg_replace('!/\*[^*]*\*+([^/][^*]*\*+)*/!', '', $buffer);
	/* remove tabs, spaces, newlines, etc. */
	$buffer = str_replace(array("\r\n", "\r", "\n", "\t", '	', '	', '	'), '', $buffer);
	return $buffer;
}




# Share Network Story
function share_story_network_link($network, $id, $class = '', $icon = false)
{
	global $post;

	$networks = array(
		'fb' => array(
			'url'		=> 'http://www.facebook.com/sharer.php?m2w&s=100&p&#91;url&#93;=' . get_permalink() . '&p&#91;title&#93;=' . esc_attr( get_the_title() ),
			'tooltip'	=> __('Facebook', 'kalium'),
			'icon'		=> 'facebook'
		),

		'tw' => array(
			'url'		=> 'http://twitter.com/home?status=' . esc_attr( get_the_title() ) . ' – ' . get_permalink(),
			'tooltip'	=> __('Twitter', 'kalium'),
			'icon'		 => 'twitter'
		),

		'gp' => array(
			'url'		=> 'https://plus.google.com/share?url=' . get_permalink(),
			'tooltip'	=> __('Google+', 'kalium'),
			'icon'		 => 'google-plus'
		),

		'tlr' => array(
			'url'		=> 'http://www.tumblr.com/share/link?url=' . get_permalink() . '&name=' . esc_attr( get_the_title() ) . '&description=' . esc_attr( get_the_excerpt() ),
			'tooltip'	=> __('Tumblr', 'kalium'),
			'icon'		 => 'tumblr'
		),

		'lin' => array(
			'url'		=> 'http://linkedin.com/shareArticle?mini=true&amp;url=' . get_permalink() . '&amp;title=' . esc_attr( get_the_title() ),
			'tooltip'	=> __('LinkedIn', 'kalium'),
			'icon'		 => 'linkedin'
		),

		'pi' => array(
			'url'		=> 'http://pinterest.com/pin/create/button/?url=' . get_permalink() . '&amp;description=' . esc_attr( get_the_title() ) . '&amp;' . ($id ? ('media=' . wp_get_attachment_url( get_post_thumbnail_id($id) )) : ''),
			'tooltip'	=> __('Pinterest', 'kalium'),
			'icon'	 	 => 'pinterest'
		),

		'vk' => array(
			'url'		=> 'http://vkontakte.ru/share.php?url=' . get_permalink(),
			'tooltip'	=> __('VKontakte', 'kalium'),
			'icon'	 	 => 'vk'
		),

		'em' => array(
			'url'		=> 'mailto:?subject=' . esc_attr( get_the_title() ) . '&amp;body=' . esc_attr(sprintf(__('Check out what I just spotted: %s', 'kalium'), get_permalink())),
			'tooltip'	=> __('Email', 'kalium'),
			'icon'		 => 'envelope-o'
		),

		'pr' => array(
			'url'		=> 'javascript:window.print();',
			'tooltip'	=> __('Print', 'kalium'),
			'icon'		 => 'print'
		),
	);

	$network_entry = $networks[ $network ];

	ob_start();
	?>
	<a class="<?php echo esc_attr($network_entry['icon']); echo $class ? esc_attr(" $class") : ''; ?>" href="<?php echo $network_entry['url']; ?>" target="_blank">
		<?php if($icon): ?>
			<i class="icon fa fa-<?php echo esc_attr($network_entry['icon']); ?>"></i>
		<?php else: ?>
			<?php echo esc_html($network_entry['tooltip']); ?>
		<?php endif; ?>
	</a>
	<?php
		
	$social_network_link = ob_get_clean();
	
	echo compress_text($social_network_link);
}



# In case when GET_FIELD function doesn't exists
if( ! in_array('advanced-custom-fields/acf.php', apply_filters('active_plugins', get_option('active_plugins'))) && ! is_admin())
{
	function get_field($field_id, $post_id = null)
	{
		global $post;

		if(is_numeric($post_id))
			$post = get_post($post_id);

		return $post->{$field_id};
	}
}




# Load Laborator Font from Theme Options
function laborator_load_font()
{
	$use_custom_font = get_data('use_custom_font');
	$use_tykekit_font = get_data('use_tykekit_font');
	
	if($use_tykekit_font)
	{
		add_action('wp_print_scripts', 'laborator_typekit_embed_code');
	}
	
	if( ! $use_custom_font)
	{
		return;
	}
	
	$primary_font_provider     = THEMEASSETS;
	$primary_font_path         = 'css/fonts/tex-gyre-heros/fonts.css';

	$secondary_font_provider   = '';
	$secondary_font_path       = '';

	$font_variants = '300,400,500,700';

		# Google Font
		$font_primary	 = get_data('font_primary');
		$font_heading   = get_data('font_heading');

		if($font_primary && $font_primary != 'none')
		{
			$primary_font_provider = 'http://fonts.googleapis.com/css?family=';
			$primary_font_path = urlencode($font_primary) . ':' . $font_variants;
		}

		if($font_heading && $font_heading != 'none')
		{
			$secondary_font_provider = 'http://fonts.googleapis.com/css?family=';
			$secondary_font_path = urlencode($font_heading) . ':' . $font_variants;
		}
		

		# Custom Font
		$custom_primary_font_url  = get_data('custom_primary_font_url');
		$custom_heading_font_url  = get_data('custom_heading_font_url');

		if($custom_primary_font_url)
		{
			$primary_font_provider = '';
			$primary_font_path = $custom_primary_font_url;
		}

		if($custom_heading_font_url)
		{
			$secondary_font_provider = '';
			$secondary_font_path = $custom_heading_font_url;
		}
		

	# Font Resource URI
	$primary_font_resource_uri	 = $primary_font_provider . $primary_font_path;
	$secondary_font_resource_uri = $secondary_font_provider . $secondary_font_path;

	# Load Fonts
	$duplicate_fonts = $primary_font_resource_uri == $secondary_font_resource_uri;
	
	if($primary_font_path)
	{
		wp_enqueue_style('primary-font', $primary_font_resource_uri, null, null);
	}

	if($secondary_font_path && $duplicate_fonts == false)
	{
		wp_enqueue_style('secondary-font', $secondary_font_resource_uri, null, null);
	}

	# Show Custom CSS
	if($primary_font_path || $secondary_font_path)
	{
		add_action('wp_print_scripts', 'laborator_show_custom_font');
	}
}

function laborator_show_custom_font()
{
	?><style><?php echo get_option('kalium_font_custom_css'); ?></style><?php
}

function laborator_typekit_embed_code()
{
	echo get_data('typekit_embed_code');
}


# Get Excerpt
function laborator_get_excerpt($text)
{
	$excerpt_length	= apply_filters('excerpt_length', 55);
	$excerpt_more	  = apply_filters('excerpt_more', ' [&hellip;]');
	$text			  = apply_filters('the_excerpt', apply_filters('get_the_excerpt', wp_trim_words($text, $excerpt_length, $excerpt_more)));

	return $text;
}


# Post Formats | Extract Content
function laborator_extract_post_content($type, $replace_original = false, $meta = array())
{
	global $post, $post_title, $post_excerpt, $post_content, $blog_post_formats;

	$content = array(
		'content' => '',
		'data' => array()
	);

	if( ! ($post && $blog_post_formats))
		return $content;

	//$post_content = apply_filters('the_content', $post->post_content); # Currently Removed

	switch($type)
	{
		case 'quote':

			if(preg_match("/^\s*<blockquote.*?>(.*?)<\/blockquote>/s", $post_content, $matches))
			{
				$blockquote = lab_esc_script(wpautop($matches[1]));

				# Replace Original Content
				if($replace_original)
				{
					$post_excerpt = laborator_get_excerpt(str_replace($matches[0], '', $post_content));
					$post_content = str_replace($matches[0], '', $post_content);
				}

				if(preg_match("/(<br.*?>\s*)?<cite>(.*?)<\/cite>/s", $blockquote, $blockquote_matches))
				{
					$cite = $blockquote_matches[2];
					$blockquote = str_replace($blockquote_matches[0], '', $blockquote);

					# Add attributes
					$content['data']['cite'] = $cite;
				}

				# Set content
				$content['content'] = $blockquote;
			}
			else
			{
				$post_content_lines = explode(PHP_EOL, $post_content);
				$blockquote = reset($post_content_lines);

				$content['content'] = $blockquote;

				# Replace Original Content
				if($replace_original)
				{
					$post_content = str_replace($blockquote, '', $post_content);
					$post_excerpt = laborator_get_excerpt($post_content);
				}
			}

			break;

		case 'image':

			if(preg_match("/<img(.*?)>/s", $post_content, $matches))
			{
				$image_args = wp_parse_args(str_replace(" ", "&", $matches[1]));

				if(isset($image_args['src']))
				{
					$src = trim($image_args['src'], "\"'");
					$content['content'] = $src;
				}

				# Is inside a href
				$img = $matches[0];

				if(preg_match("/((<a.*?>)(.*)?(<img.*?>)(.*)?<\/a>)/s", $post_content, $a_matches))
				{
					if($a_matches[4] == $img)
					{
						$a_args = wp_parse_args(trim(str_replace(array('<a', '>'), array('', '', '&'), $a_matches[2])));

						if(isset($a_args['href']))
						{
							$a_href = trim($a_args['href'], "\"'");

							$content['data']['href'] = $a_href;
						}
					}
				}

				if($replace_original)
				{
					$what_to_replace = $matches[0];

					if(isset($content['data']['href']))
					{
						$what_to_replace = $a_matches[0];
					}

					$post_content = str_replace(array($matches[0], '<p></p>'), '', $post_content);
				}
			}
			else
			{
				$post_content_lines = explode(PHP_EOL, $post_content);
				$first_line = strip_tags(trim(reset($post_content_lines)));

				if(preg_match("/https?:\/\/.*/s", $first_line, $matches))
				{
					$content['content'] = $matches[0];
				}

				if($replace_original && count($matches))
				{
					$post_content = str_replace($first_line, '', $post_content);
					$post_excerpt = laborator_get_excerpt($post_content);
				}
			}

			break;

		case 'link':

			$has_url = get_url_in_content(get_the_content());
			$has_url = $has_url ? $has_url : apply_filters('the_permalink', get_permalink());

			$content['content'] = $has_url;

			break;

		case 'video':

			switch(get_data('blog_post_formats_video_player_skin'))
			{
				case '_2':
					$player_skin = 'vjs-sublime-skin';
					break;

				case '_1':
				default:
					$player_skin = 'vjs-default-skin';
					break;
			}

			if(preg_match("/\[video.*?\[\/video\]/s", $post->post_content, $matches))
			{
				$videojs_atts = "data-setup=\"{}\" preload=\"auto\"";

				if(isset($meta['poster']))
				{
					$videojs_atts .= ' poster="'.$meta['poster'].'"';
				}

				$video_shortcode = do_shortcode($matches[0]);
				$video_shortcode = preg_replace(array('/<div.*?>.*?(<video.*?<\/video>).*?<\/div.*?>/s', '/(width|height)=".*?"\s?/'), array('\1', ''), $video_shortcode);
				$video_shortcode = str_replace(array('wp-video-shortcode', '<video'), array('video-js '.$player_skin, '<video ' . $videojs_atts), $video_shortcode);

				$content['content'] = $video_shortcode;
				$content['data']['type'] = 'native';

				if($replace_original && count($matches))
				{
					$post_content = str_replace($matches[0], '', $post->post_content);
					$post_content = apply_filters('the_content', $post_content);
				}
			}
			else
			{
				$post_content_lines = explode(PHP_EOL, $post->post_content);
				$first_line = strip_tags(trim(reset($post_content_lines)));

				$videojs_atts = '';

				if(isset($meta['poster']) && isset($meta['uploadedPoster']) && $meta['uploadedPoster'])
				{
					$videojs_atts .= ' poster="'.$meta['poster'].'"';
				}

				if(preg_match("/(https?:\/\/(www\.)?youtube.com[^\s]+)/s", $first_line, $matches))
				{
					$youtube_url = $matches[1];

					$content['data']['type'] = 'youtube';
					$content['content'] = '<video src="" class="video-js '.$player_skin.'" controls preload="auto" data-setup=\'{ "techOrder": ["youtube"], "src": "' . $youtube_url . '" }\' ' . $videojs_atts . '>';
				}
				else
				if(preg_match("/(https?:\/\/(www\.)?vimeo.com[^\s]+)/s", $first_line, $matches))
				{
					$vimeo_url = $matches[1];

					$content['data']['type'] = 'vimeo';
					$content['content'] = '<video src="" class="video-js '.$player_skin.'" controls preload="auto" data-setup=\'{ "techOrder": ["vimeo"], "src": "' . $vimeo_url . '" }\' ' . $videojs_atts . '>';
				}

				if($replace_original && count($matches))
				{
					$post_content = str_replace($matches[0], '', $post->post_content);
					$post_content = apply_filters('the_content', $post_content);
				}
			}

			break;

		case 'audio':

			switch(get_data('blog_post_formats_video_player_skin'))
			{
				case '_2':
					$player_skin = 'vjs-sublime-skin';
					break;

				case '_1':
				default:
					$player_skin = 'vjs-default-skin';
					break;
			}

			if(preg_match("/\[audio.*?(https?[^\s]+?)\](\[\/audio\])?/s", $post->post_content, $matches))
			{
				$audio_url = $matches[1];
				$videojs_atts = "data-setup=\"{}\" preload=\"auto\"";

				if(isset($meta['poster']))
				{
					$videojs_atts .= ' poster="'.$meta['poster'].'"';
				}

				$content['content'] = '<audio id="audio_example" class="video-js '.$player_skin.'" controls '.$videojs_atts.'><source src="'.$audio_url.'" type=\'audio/mp3\'/></audio>';


				if($replace_original)
				{
					$post_content = str_replace($matches[0], '', $post->post_content);
					$post_content = apply_filters('the_content', $post_content);
				}
			}

			break;
	}

	return $content;
}


# Endless Pagination
function laborator_show_endless_pagination($args = array())
{
	$defaults = array(
		'per_page'	  => get_option('posts_per_page'),

		'opts'		  => array(),
		'action'	  => '',
		'callback'	  => '',

		'class'	   => 'text-' . get_data('blog_pagination_position'),
		'reveal'	  => false,

		'current'	 => 1,
		'maxpages'	=> 1,

		'more'		=> __('Show More', 'kalium'),
		'finished'	  => __('No more posts to show', 'kalium'),

		'type'		  => 1
	);

	if(is_array($args))
		$args = array_merge($defaults, $args);

	extract($args);

	$type = str_replace('_', '', $type);
	?>
	<div class="endless-pagination<?php echo " {$class}"; ?>">
		<div class="show-more<?php echo " type-{$type}"; echo esc_attr($reveal) ? ' auto-reveal' : ''; ?>" data-cb="<?php echo esc_attr($callback); ?>" data-action="<?php echo esc_attr($action); ?>" data-current="<?php echo esc_attr($current); ?>" data-max="<?php echo esc_attr($maxpages); ?>" data-pp="<?php echo esc_attr($per_page); ?>" data-opts="<?php echo esc_attr(json_encode($opts)); ?>">
			<div class="button">
				<a href="#" class="btn btn-white">
					<?php echo esc_html($more); ?>

					<span class="loading">
					<?php
					switch($type):
						case 2:
							echo '<i class="loading-spinner-1"></i>';
							break;

						default:
							echo '<i class="fa fa-circle-o-notch fa-spin"></i>';
					endswitch;
					?>
					</span>

					<span class="finished">
						<?php echo esc_html($finished); ?>
					</span>
				</a>
			</div>
		</div>
	</div>
	<?php
}

# Rot 13 Encrypt/Descript
function rot13encrypt($str)
{
	return str_rot13(base64_encode($str));
}

function rot13decrypt($str)
{
	return base64_decode(str_rot13($str));
}


# Generate Aspect Ratio Padding for an element, suitable for responsive also
function laborator_generate_aspect_ratio_css($selector, $size = array())
{
	if( ! (is_array($size) && count($size) == 2 || is_numeric($size[0]) || is_numeric($size[1]) && $size[0] > 0))
		return;

	$css  = 'padding-top: ' . number_format($size[1]/$size[0] * 100, 6) . '%;';
	$css .= 'margin-top: -' . number_format($size[1]/$size[0] * 100, 6) . '%;';

	generate_custom_style($selector, $css);
}

# Aspect Ratio Element Generator
global $as_element_id;

$as_element_id = 1;

function laborator_generate_as_element($size)
{
	global $as_element_id;
	
	if(isset($size['width']))
		$size[0] = $size['width'];
	
	if(isset($size['height']))
		$size[1] = $size['height'];

	if($size[0] == 0)
		return null;

	$element_id = "arel-" . $as_element_id;
	$padding_top = 'padding-top: ' . number_format($size[1]/$size[0] * 100, 6) . '% !important;';
	$as_element_id++;

	if(defined("DOING_AJAX"))
	{
		$element_id .= '-' . time() . mt_rand(10000, 999999);
	}

	generate_custom_style(".{$element_id}", $padding_top);

	return $element_id;
}


# Load Image with Aspect Ratio Container
function laborator_show_image_placeholder($attachment_id, $size = 'original', $class = '', $lazy_load = true, $img_class = 'visibility-hidden')
{
	if(is_string($size) && preg_match("/^[0-9]+(x[0-9]+)?$/", $size))
	{
		$size = explode('x', $size);
	}

	if(is_array($size))
	{
		if(count($size) == 2)
		{
			$size['bfi_thumb'] = true;
			$size['crop'] = true;
		}
	}

	$image = wp_get_attachment_image_src($attachment_id, $size);
	
	// Show gifs in original size
	if(pathinfo($image[0], PATHINFO_EXTENSION) == 'gif')
	{
		$image = wp_get_attachment_image_src($attachment_id, 'full');
	}

	$thumb_size	= array($image[1], $image[2]);
	$element_id	= laborator_generate_as_element($thumb_size);

	$placeholder_class = array();
	$placeholder_class[] = 'image-placeholder';
	$placeholder_class[] = $element_id;

	if($class)
	{
		$placeholder_class[] = trim($class);
	}
	
	if( ! $lazy_load)
	{
		$img_class = str_replace('visibility-hidden', '', $img_class); 
	}
	?>
	<span class="<?php echo implode(' ', $placeholder_class); ?>">
		<img <?php echo $lazy_load ? 'data-' : ''; ?>src="<?php echo esc_url($image[0]); ?>" width="<?php echo esc_attr($thumb_size[0]); ?>" height="<?php echo esc_attr($thumb_size[1]); ?>" class="<?php echo esc_attr($img_class); ?>" alt="<?php echo esc_attr("img-{$attachment_id}"); ?>" />
	</span>
	<?php
}

function get_laborator_show_image_placeholder($attachment_id, $size = 'original', $class = '', $lazy_load = true, $img_class = 'visibility-hidden')
{
	ob_start();
	
	laborator_show_image_placeholder( $attachment_id, $size, $class, $lazy_load, $img_class );
	
	$image = ob_get_clean();
	
	return $image;
}


# Custom Style Generator
global $bottom_styles;

$bottom_styles = array();

function generate_custom_style($selector, $props = '', $media = '', $footer = false)
{
	global $bottom_styles;

	$css = '';

		# Selector Start
		$css .= $selector . ' {' . PHP_EOL;

			# Selector Properties
		$css .= str_replace(';', ';' . PHP_EOL, $props);

		$css .= PHP_EOL . '}';
		# Selector end


	if( ! $footer || defined("DOING_AJAX"))
	{
		echo "<style>{$css}</style>";
		return;
	}

	$bottom_styles[] = $css;
}

add_action('wp_footer', create_function('', 'global $bottom_styles; if( ! count($bottom_styles)) return; echo "<style>\n" . compress_text(implode(PHP_EOL . PHP_EOL, $bottom_styles)) . "\n</style>"; '));


# User IP
function get_the_user_ip()
{
	if( ! empty($_SERVER['HTTP_CLIENT_IP']))
	{
		$ip = $_SERVER['HTTP_CLIENT_IP'];
	}
	elseif( ! empty( $_SERVER['HTTP_X_FORWARDED_FOR'] ) )
	{
		$ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
	}
	else
	{
		$ip = $_SERVER['REMOTE_ADDR'];
	}

	return $ip;
}





# Get SVG
function lab_get_svg($svg_path, $id = null, $size = array(24, 24), $is_asset = true)
{
	if($is_asset)
		$svg_path = get_template_directory() . '/assets/' .  $svg_path;

	if( ! $id)
		$id = sanitize_title(basename($svg_path));

	if(is_numeric($size))
		$size = array($size, $size);

	ob_start();

	echo file_get_contents($svg_path);

	$svg = ob_get_clean();

	$svg = preg_replace(
		array(
			'/^.*<svg/s',
			'/id=".*?"/i',
			'/width=".*?"/',
			'/height=".*?"/'
		),
		array(
			'<svg', 'id="'.$id.'"',
			'width="'.$size[0].'px"',
			'height="'.$size[0].'px"'
		),
		$svg
	);

	return $svg;
}






# Get Image Size from HTML
function laborator_get_image_size_from_html($html)
{
	$size = array(
		'width' => '',
		'height' => ''
	);
	
	if(preg_match("/width=.([0-9]+)./", $html, $matches))
	{
		$size['width'] = $matches[1];
	}
	
	if(preg_match("/height=.([0-9]+)./", $html, $matches))
	{
		$size['height'] = $matches[1];
	}
	
	return $size;
}




# Get Main Menu
function laborator_get_main_menu($menu_location = 'main-menu')
{
	if($menu_location == '' || $menu_location == '-')
	{
		return '';
	}
	
	$args = array(
		'container'       => '',
		'theme_location'  => $menu_location,
		'echo'            => false
	);
	
	if(is_numeric($menu_location))
	{
		$args['menu'] = $menu_location;
		unset($args['theme_location']);
	}
	
	return wp_nav_menu($args);
}


# Less Generator
function kalium_generate_less_style($files = array(), $vars = array())
{
	if( ! class_exists('Less_Parser'))
	{
		include_once THEMEDIR . 'inc/lib/lessphp/Less.php';
	}
	
	$skin_generator = file_get_contents(THEMEDIR . 'assets/less/skin-generator.less');
	
	
	# Compile Less
	$less_options = array(
		'compress' => true
	);
	
	$css = '';
	
	try {
		
		$less = new Less_Parser($less_options);
		
		foreach($files as $file => $type)
		{
			if($type == 'parse')
			{
				$css_contents = file_get_contents($file);
				
				# Replace Vars
				foreach($vars as $var => $value)
				{
					if(trim($value))
					{
						$css_contents = preg_replace("/(@{$var}):\s*.*?;/", '$1: ' . $value . ';', $css_contents);
					}
				}
				
				$less->parse($css_contents);
			}
			else
			{
				$less->parseFile($file);
			}
		}
		
		$css = $less->getCss();
	}
	catch(Exception $e){
	}
	
	return $css;
}



# Hex to Rgb with Alpha
function hex2rgba($color, $opacity = false)
{
	$default = 'rgb(0,0,0)';
 
	if(empty($color))
		return $default; 
 
	if ($color[0] == '#' ) {
		$color = substr( $color, 1 );
	}

	if (strlen($color) == 6) {
			$hex = array( $color[0] . $color[1], $color[2] . $color[3], $color[4] . $color[5] );
	} elseif ( strlen( $color ) == 3 ) {
			$hex = array( $color[0] . $color[0], $color[1] . $color[1], $color[2] . $color[2] );
	} else {
			return $default;
	}

	$rgb =  array_map('hexdec', $hex);

	if($opacity){
		if(abs($opacity) > 1)
			$opacity = 1.0;
		$output = 'rgba('.implode(",",$rgb).','.$opacity.')';
	} else {
		$output = 'rgb('.implode(",",$rgb).')';
	}

	return $output;
}


# Escape script tag
function lab_esc_script($str = '')
{
	$str = str_ireplace(array('<script', '</script>'), array('&lt;script', '&lt;/script&gt;'), $str);
	
	return $str;
}

# Escape script plus strip tags
function lab_strip_script($str = '', $tags = '')
{
	$str = strip_tags($str, $tags);
	return lab_esc_script($str);
}

# Round Up To Any
function roundUpToAny($n, $x = 5)
{
	return (ceil($n) % $x === 0) ? floor($n) : round(($n+$x/2)/$x)*$x;
}


# Shop Supported
function is_shop_supported()
{
	return in_array('woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option('active_plugins')));
}