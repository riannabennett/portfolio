<?php
/**
 *	Custom Row for this theme
 *	
 *	Laborator.co
 *	www.laborator.co 
 */

add_action('vc_after_init', 'laborator_vc_row_options');
add_action('vc_after_init', 'laborator_vc_row_full_width');

function laborator_vc_row_options()
{
	# Parallax Attributes
	$parallax_attributes = array(
	   array(
			'type'           => 'checkbox',
			'heading'        => __( 'Parallax', 'lab_composer' ),
			'param_name'     => 'parallax_enable',
			'value'          => array( __( 'Yes', 'lab_composer' ) => 'yes' ),
			'description'    => 'Check this box if you want to enable parallax for this row.'
		),
		
		array(
			'type'           => 'textfield',
			'heading'        => __( 'Parallax Ratio', 'lab_composer' ),
			'param_name'     => 'parallax_ratio',
			'value'          => '0.8',
			'description'    => __( 'Recommended scale: from 0.00 to 1.00.', 'lab_composer' ),
			'dependency' => array(
				'element'   => 'parallax_enable',
				'value'     => array( 'yes' )
			),
		),
		
		array(
			'type'           => 'textfield',
			'heading'        => __( 'Parallax Opacity', 'lab_composer' ),
			'param_name'     => 'parallax_opacity',
			'value'          => '',
			'description'    => __( 'Opacity to reach while exiting the viewport. Recommended scale: from 0.00 to 1.00. (Optional)', 'lab_composer' ),
			'dependency' => array(
				'element'   => 'parallax_enable',
				'value'     => array( 'yes' )
			),
		),
	);
	
	vc_add_params('vc_row', $parallax_attributes);
}

function laborator_vc_row_full_width() 
{
	# Full Width Param
	$param = WPBMap::getParam('vc_row', 'full_width');
	$param['value'][__('Full width', 'lab_composer')] = 'lab-full-width';

	vc_update_shortcode_param('vc_row', $param);
}