<?php
/**
 *	Kalium WordPress Theme
 *
 *	Laborator.co
 *	www.laborator.co
 */

# ACF Tab
add_filter('acf/settings/show_admin', '__return_false');


# Add Do-shortcode for text widgets
add_filter('widget_text', 'widget_text_do_shortcodes');

function widget_text_do_shortcodes($text)
{
	return do_shortcode($text);
}


# Date Shortcode
if( ! shortcode_exists('date'))
{
	add_shortcode('date', 'laborator_shortcode_date');
}

function laborator_shortcode_date($atts = array(), $content = '')
{
	return date_i18n(get_option('date_format'));
}


# Shortcode for Social Networks [lab_social_networks]
add_shortcode('lab_social_networks', 'shortcode_lab_social_networks');

function shortcode_lab_social_networks($atts = array(), $content = '')
{
	$social_order = get_data('social_order');

	$social_order_list = array(
		"fb"  => array("title" => __("Facebook", 'kalium'), 		"icon" => "fa fa-facebook"),
		"tw"  => array("title" => __("Twitter", 'kalium'), 			"icon" => "fa fa-twitter"),
		"lin" => array("title" => __("LinkedIn", 'kalium'), 		"icon" => "fa fa-linkedin"),
		"yt"  => array("title" => __("YouTube", 'kalium'), 			"icon" => "fa fa-youtube-play"),
		"vm"  => array("title" => __("Vimeo", 'kalium'), 			"icon" => "fa fa-vimeo-square"),
		"drb" => array("title" => __("Dribbble", 'kalium'), 		"icon" => "fa fa-dribbble"),
		"ig"  => array("title" => __("Instagram", 'kalium'), 		"icon" => "fa fa-instagram"),
		"pi"  => array("title" => __("Pinterest", 'kalium'), 		"icon" => "fa fa-pinterest"),
		"gp"  => array("title" => __("Google+", 'kalium'), 			"icon" => "fa fa-google-plus"),
		"vk"  => array("title" => __("VKontakte", 'kalium'), 		"icon" => "fa fa-vk"),

		"fl"  => array("title" => __("Flickr", 'kalium'), 			"icon" => "fa fa-flickr"),
		"be"  => array("title" => __("Behance", 'kalium'), 			"icon" => "fa fa-behance"),
		"vi"  => array("title" => __("Vine", 'kalium'), 			"icon" => "fa fa-vine"),
		"fs"  => array("title" => __("Foursquare", 'kalium'), 		"icon" => "fa fa-foursquare"),
		"sk"  => array("title" => __("Skype", 'kalium'), 			"icon" => "fa fa-skype"),
		"tu"  => array("title" => __("Tumblr", 'kalium'), 			"icon" => "fa fa-tumblr"),
		"da"  => array("title" => __("DeviantArt", 'kalium'), 		"icon" => "fa fa-deviantart"),
		"gh"  => array("title" => __("GitHub", 'kalium'), 			"icon" => "fa fa-github"),
		
		"custom"  => array(
			"title"  => get_data('social_network_custom_link_title'), 			
			"href"   => get_data('social_network_custom_link_link'),
			"icon"   => "fa fa-plus", 
		),
		
		// 	""  => array("title" => __("", TD), 			"icon" => ""),
	);


	$html = '<ul class="social-networks list-unstyled list-inline social">';

	foreach($social_order['visible'] as $key => $title)
	{
		if($key == 'placebo')
			continue;

		$sn = $social_order_list[$key];
		
		$href = get_data("social_network_link_{$key}");
		$class = sanitize_title($title);
		
		if($key == 'custom')
		{
			$title   = $sn['title'];
			$href    = $sn['href'];
			$class 	 = 'custom';
		}
			
		$html .= '<li>';
			$html .= '<a href="'.$href.'" class="color '.$class.'" title="'.$title.'">';//" target="_blank">';
				$html .= '<i class="'.$sn['icon'].'"></i>';
				$html .= '<span class="name">'.$title.'.</span>';
			$html .= '</a>';
		$html .= '</li>';
	}

	$html .= '</ul>';


	return $html;

}


# Excerpt Length & More
add_filter('excerpt_length', 'laborator_default_excerpt_length');
add_filter('excerpt_more', 'laborator_default_excerpt_more');

function laborator_default_excerpt_length()
{
	return 55;
}

function laborator_short_excerpt_length()
{
	return 32;
}

function laborator_supershort_excerpt_length()
{
	return 18;
}

function laborator_default_excerpt_more()
{
	return "&hellip;";
}


# Laborator Theme Options Translate
add_filter('admin_menu', 'laborator_add_menu_classes', 100);

function laborator_add_menu_classes($items)
{
	global $submenu;

	foreach($submenu as $menu_id => $sub)
	{
		if($menu_id == 'laborator_options')
		{
			$submenu[$menu_id][0][0] = __('Theme Options', 'kalium');
		}
	}

	return $submenu;
}


# Body Class
add_action('wp', 'laborator_header_spacing');

function laborator_header_spacing()
{
	global $wp_query;
	
	$header_position = get_data('header_position');
	$header_spacing = get_data('header_spacing');
	
	if(is_singular())
	{
		$post_id = get_the_id();
	}
	
	# Custom Post
	if(isset($post_id))
	{
		$page_header_position = get_field('header_position', $post_id);
		$page_header_spacing = get_field('header_spacing', $post_id);
		
		if( ! empty($page_header_position))
		{
			$header_position = $page_header_position;
			$header_spacing = $page_header_spacing;
		}
	}
	
	if($header_position == 'absolute')
	{
		$header_spacing = intval($header_spacing);
		
		define("HEADER_ABSOLUTE_SPACING", $header_spacing);
		add_filter('body_class', 'laborator_header_spacing_body_class');
	}
}



function laborator_header_spacing_body_class($classes)
{
	if(defined("HEADER_ABSOLUTE_SPACING"))
	{
		$classes[] = 'header-absolute';
		
		$header_spacing = HEADER_ABSOLUTE_SPACING;
		generate_custom_style(".wrapper", "padding-top: {$header_spacing}px", '', true);
	}
	
	return $classes;
}


# Comments Open/Close
function laborator_list_comments_open($comment, $args, $depth)
{
	global $post, $wpdb, $comment_index;

	$comment_ID 			= $comment->comment_ID;
	$comment_author 		= $comment->comment_author;
	$comment_author_url		= $comment->comment_author_url;
	$comment_author_email	= $comment->comment_author_email;
	$comment_date 			= $comment->comment_date;
	$comment_parent_ID 		= $comment->comment_parent;

	$avatar					= get_avatar($comment);

	$comment_time 			= strtotime($comment_date);
	$comment_timespan 		= human_time_diff($comment_time, time());

	$link 					= '<a href="' . esc_url($comment_author_url) . '" target="_blank">';

	$comment_classes = array('comment-holder');

	$comment_classes[] = 'col-xs-12';

	if($depth > 3)
		$comment_classes[] = 'col-sm-9';
	elseif($depth > 2)
		$comment_classes[] = 'col-sm-10';
	elseif($depth > 1)
		$comment_classes[] = 'col-sm-11';


	# In reply to Get
	$parent_comment = null;

	if($comment_parent_ID)
	{
		$parent_comment = get_comment($comment_parent_ID);
	}

?>
<div <?php echo comment_class($comment_classes); ?> id="comment-<?php echo esc_attr($comment_ID); ?>"<?php echo $depth > 1 && $parent_comment ? (" data-replied-to=\"comment-".esc_attr($comment_parent_ID)."\"") : ''; ?>>
	<div class="row">
		<div class="commenter-image">
			<?php echo $comment_author_url ? ("{$link}{$avatar}</a>") : $avatar; ?>

			<?php if($parent_comment): ?>
			<div class="comment-connector"></div>
			<?php endif; ?>
		</div>
		<div class="commenter-details col-xs-10">
			<div class="name">
				<?php

				# Comment Author
				echo esc_html($comment_author);

				# Reply Link
				comment_reply_link(
					array_merge(
						$args,
						array(
							'reply_text' => __('reply', 'kalium'),
							'depth' => $depth,
							'max_depth' => $args['max_depth'],
							'before' => ''
						)
					),
					$comment,
					$post
				);
				?>
			</div>

			<div class="date">
				<?php echo date_i18n('l', $comment_time) . ' ' . __('at', 'kalium') . ' ' . date_i18n('h:m A', $comment_time); ?>

				<?php if($parent_comment): ?>
				<div class="in-reply-to">
					&ndash; <?php echo sprintf(__('In reply to: <span class="replied-to">%s</span>', 'kalium'), $parent_comment->comment_author); ?>
				</div>
				<?php endif; ?>
			</div>

			<div class="comment-text post-formatting">
				<?php comment_text(); ?>
			</div>
		</div> <!-- commenter-details -->
	</div> <!-- row-->
</div> <!-- comment-holder -->
<?php
}

function laborator_list_comments_close()
{
}


# Comment Form
add_action('comment_form_top', 'laborator_comment_form_top');
add_action('comment_form_after', 'laborator_comment_form_after');
add_filter('comment_form_default_fields', 'laborator_comment_form_default_fields');
add_filter('comment_form_logged_in', 'laborator_comment_form_logged_in');


function laborator_comment_form_top()
{
	?>
	<div class="message-form">
		<div class="row">
	<?php
}

function laborator_comment_form_after()
{
	?>
		</div>
	</div>
	<?php
}

function laborator_comment_form_default_fields($fields)
{
	foreach($fields as $field => $field_markup)
	{
		$field_markup = preg_replace('/(<label(.*?)<\/label>)/i', '<div class="placeholder">\1</div>', $field_markup); // Wrap label with kalium style markup
		$field_markup = preg_replace('/<p.*?>(.*?)<\/p>/i', '\1', $field_markup); // Remove Paragraph tag

		$fields[$field] = '<div class="col-sm-4"><div class="form-group absolute">' . $field_markup . '</div></div>';
	}
	return $fields;
}

function laborator_comment_form_logged_in($html)
{
	$html = '<div class="col-xs-12 section-sub-title">' . $html . '</div>';

	return $html;
}


# Skin Compiler
#of_ajax_post_action
add_filter('of_options_before_save', 'laborator_custom_skin_generate');

function laborator_custom_skin_generate($data)
{
	if( ! defined("DOING_AJAX"))
	{
		return $data;
	}
	elseif( $_REQUEST['action'] != 'of_ajax_post_action' )
	{
		return $data;
	}
	
	if(isset($data['use_custom_skin']) && $data['use_custom_skin'] )
	{
		update_option('kalium_skin_custom_css', '');
	
		$colors = array();
		
		$custom_skin_bg_color         = $data['custom_skin_bg_color'];
		$custom_skin_link_color       = $data['custom_skin_link_color'];
		$custom_skin_headings_color   = $data['custom_skin_headings_color'];
		$custom_skin_paragraph_color  = $data['custom_skin_paragraph_color'];
		$custom_skin_footer_bg_color  = $data['custom_skin_footer_bg_color'];
		$custom_skin_borders_color    = $data['custom_skin_borders_color'];
		
		$custom_skin_bg_color         = $custom_skin_bg_color 			? 	$custom_skin_bg_color 			: '#FFFFFF';
		$custom_skin_link_color       = $custom_skin_link_color 		? 	$custom_skin_link_color 		: '#F6364D';
		$custom_skin_headings_color   = $custom_skin_headings_color 	? 	$custom_skin_headings_color 	: '#F6364D';
		$custom_skin_paragraph_color  = $custom_skin_paragraph_color 	? 	$custom_skin_paragraph_color	: '#777777';
		$custom_skin_footer_bg_color  = $custom_skin_footer_bg_color	? 	$custom_skin_footer_bg_color	: '#FAFAFA';
		$custom_skin_borders_color    = $custom_skin_borders_color 		? 	$custom_skin_borders_color		: '#EEEEEE';
		
		$files = array(
			THEMEDIR . "assets/less/other-less/lesshat.less" => "include",
			THEMEDIR . "assets/less/skin-generator.less"     => "parse",
		);
		
		$vars = array(
			'bg-color'   => $custom_skin_bg_color,
			'link-color' => $custom_skin_link_color,
			'heading'    => $custom_skin_headings_color,
			'paragraph'  => $custom_skin_paragraph_color,
			'footer'     => $custom_skin_footer_bg_color,
			'border'     => $custom_skin_borders_color,
		);
		
		$css_stype = kalium_generate_less_style($files, $vars);
		
		update_option('kalium_skin_custom_css', $css_stype);
		
	}
	
	return $data;
}


# Font Compiler
add_filter('of_options_before_save', 'laborator_custom_font_generate');

function laborator_custom_font_generate($data)
{
	if( ! defined("DOING_AJAX"))
	{
		return $data;
	}
	elseif( $_REQUEST['action'] != 'of_ajax_post_action' )
	{
		return $data;
	}
	
	if(isset($data['use_custom_font']) && $data['use_custom_font'])
	{
		update_option('kalium_font_custom_css', '');
		
		$default_font_family = '"texgyreherosregular", Arial, sans-serif';
		
		$font_primary             = $data['font_primary'];
		$font_primary_weight      = $data['font_primary_weight'];
		$font_primary_transform   = $data['font_primary_transform'];
		
		$font_heading             = $data['font_heading'];
		$font_heading_weight      = $data['font_heading_weight'];
		$font_heading_transform   = $data['font_heading_transform'];
		
		$font_primary   = in_array($font_primary, array('none'))	 ? $default_font_family : "'{$font_primary}', sans-serif";
		$font_heading   = in_array($font_heading, array('none')) ? $default_font_family : "'{$font_heading}', sans-serif";
		
		$files = array(
			THEMEDIR . "assets/less/typo-generator.less" => "parse",
		);
		
		# Custom Fonts 
		if($data['custom_primary_font_url'] && $data['custom_primary_font_name'])
		{
			$font_primary            = $data['custom_primary_font_name'];
			$font_primary_weight     = $data['custom_primary_font_weight'];
			$font_primary_transform  = $data['custom_primary_font_transform'];
		}
		
		if($data['custom_heading_font_url'] && $data['custom_heading_font_name'])
		{
			$font_heading              = $data['custom_heading_font_name'];
			$font_heading_weight       = $data['custom_heading_font_weight'];
			$font_heading_transform    = $data['custom_heading_font_transform'];
		}
		
		$vars = array(
			'primary-font'           => $font_primary,
			'primary-font-weight'    => $font_primary_weight,
			'primary-transform'      => $font_primary_transform,
			
			'heading-font'           => $font_heading,
			'heading-font-weight'    => $font_heading_weight,
			'heading-transform'      => $font_heading_transform,
		);
		
		$css_stype = kalium_generate_less_style($files, $vars);
		
		update_option('kalium_font_custom_css', $css_stype);
	}
	
	return $data;
}


# WP Title Filter
function lab_wp_title($title, $sep)
{
	global $paged, $page;

	if(is_feed())
	{
		return $title;
	}

	$site_description = get_bloginfo('description', 'display');
	
	if ($site_description && (is_home() || is_front_page()))
	{
		$title = " $sep $site_description";
	}

	if( $paged >= 2 || $page >= 2 )
	{
		$title = "$title $sep " . sprintf(__('Page %s', 'kalium'), max($paged, $page));
	}

	return lab_esc_script($title);

}

add_filter('wp_title', 'lab_wp_title', 10, 2);


# WP Content Escape Scripts
add_filter('the_title', 'laborator_escape_content_xss');
add_filter('the_content', 'laborator_escape_content_xss');
add_filter('comment_text', 'laborator_escape_content_xss');
add_filter('widget_text', 'laborator_escape_content_xss');

function laborator_escape_content_xss($content)
{
	return lab_esc_script($content);
}


# General Body Class Filter
add_filter('body_class', 'laborator_body_class');

function laborator_body_class($classes)
{
	if(get_data('theme_borders'))
	{
		$classes[] = 'has-page-borders';
	}
	
	if(get_data('footer_fixed'))
	{
		$classes[] = 'has-fixed-footer';
	}
	
	return $classes;
}


# Widget sidebar Visual Composer
add_filter( 'vc_shortcodes_css_class', 'lab_wc_vc_shortcodes_css_class_widgets_sidebar', 10, 3 );

function lab_wc_vc_shortcodes_css_class_widgets_sidebar( $el_class, $base = '', $atts = array() )
{
	if( $base == 'vc_widget_sidebar' )
	{
		$el_class .= ' blog-sidebar shop-sidebar';
	}
	
	return $el_class;
}

# Visual Composer Update
add_action( 'admin_init', 'vc_updater_drop' );

function vc_updater_drop() {
	
	if( isset( $_GET['page'] ) && $_GET['page'] != 'tgmpa-install-plugins' ) {
		return false;
	}
	
	if( ! isset( $_GET['plugin'] ) || $_GET['plugin'] != 'js_composer' ) {
		return false;
	}
	
	remove_all_actions( 'upgrader_pre_download' );
	remove_all_actions( 'upgrader_process_complete' );
}