<?php
/**
 *	Kalium WordPress Theme
 *
 *	Laborator.co
 *	www.laborator.co
 */

# If its not active disable these functions
if( ! in_array('js_composer/js_composer.php', apply_filters('active_plugins', get_option('active_plugins'))))
{
	return;
}

# Set Visual Composer As Theme Mode
add_action('vc_before_init', 'laborator_visual_composer_init');

function laborator_visual_composer_init()
{
    vc_set_as_theme();
}

# General Attributes
$laborator_vc_general_params = array(
	
	# Reveal Effect (Extended)
	'reveal_effect_x' => array(
		'type'        => 'dropdown',
		'heading'     => __('Reveal Effect', 'lab_composer'),
		'param_name'  => 'reveal_effect',
		'std'         => 'fadeInLab',
		'value'       => array(
			__('None','lab_composer')                           => 'none',
			__('Fade In','lab_composer')                        => 'fadeIn',
			__('Slide and Fade','lab_composer')                 => 'fadeInLab',
			__('Fade In (one by one)','lab_composer')           => 'fadeIn-one',
			__('Slide and Fade (one by one)','lab_composer')    => 'fadeInLab-one',
		),
		'description' => __('Set reveal effect for this element.', 'lab_composer')
	),
);


# Support for Shortcodes
$lab_vc_templates_path = THEMEDIR . 'inc/lib/vc/';
$lab_vc_shortcodes = array(
	'lab_team_members', 
	'lab_service_box', 
	'lab_heading', 
	'lab_scroll_box', 
	'lab_clients', 
	'lab_vc_social_networks', 
	'lab_message', 
	'lab_button',
	'lab_contact_form',
	'lab_google_map',
	'lab_portfolio_items',
	'lab_masonry_portfolio',
	'lab_dribbble_gallery',
	'lab_text_autotype',
);

if( is_shop_supported() ) {
	$lab_vc_shortcodes[] = 'lab_products_carousel';
}

foreach($lab_vc_shortcodes as $shortcode_template)
{
	include_once $lab_vc_templates_path . $shortcode_template . '/init.php';
}


# Customizations
require_once $lab_vc_templates_path . 'custom-rows.php';
require_once $lab_vc_templates_path . 'custom-columns.php';
require_once $lab_vc_templates_path . 'custom-tabs.php';
require_once $lab_vc_templates_path . 'custom-font-icons.php';

# Reveal Effect Params Generator
function lab_vc_reveal_effect_params($effect, $duration = '', $delay = '')
{
	if($effect == '' || $effect == 'none')
	{
		return;
	}
	
	$atts = '';
	
	if($duration)
	{	
		$atts .= ' data-wow-duration="' . $duration . 's"';
	}
	
	if($delay)
	{	
		$atts .= ' data-wow-delay="' . $delay . 's"';
	}
	
	return $atts;
}