<?php
/**
 * @var $this WPBakeryShortCode_VC_Column
 */
$output = $font_color = $el_class = $width = $offset = '';
extract( shortcode_atts( array(
	'font_color' => '',
	'el_class' => '',
	'width' => '1/1',
	'css' => '',
	'offset' => '',
	# start: modified by Arlind Nushi
	'reveal_effect'    => '',
	'reveal_duration'  => '',
	'reveal_delay'     => '',
	# end: modified by Arlind Nushi
), $atts ) );

# start: modified by Arlind Nushi
$has_wow_class = false;

if($reveal_effect != '' && $reveal_effect != 'none'){
	$has_wow_class = true;
}
# end: modified by Arlind Nushi

$el_class = $this->getExtraClass( $el_class );
$width = wpb_translateColumnWidthToSpan( $width );
$width = vc_column_offset_class_merge( $offset, $width );
$el_class .= ' wpb_column vc_column_container';
$style = $this->buildStyle( $font_color );
$css_class = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, $width . $el_class, $this->settings['base'], $atts );
$output .= "\n\t" . '<div class="' . $css_class . ' ' . vc_shortcode_custom_css_class( $css, ' ' ) . '"' . $style . '>';
$output .= "\n\t\t" . '<div class="wpb_wrapper'.($has_wow_class ? " wow {$reveal_effect}" : '').'"'.lab_vc_reveal_effect_params($reveal_effect, $reveal_duration, $reveal_delay).'>'; // Modified by Arlind Nushi
$output .= "\n\t\t\t" . wpb_js_remove_wpautop( $content );
$output .= "\n\t\t" . '</div> ' . $this->endBlockComment( '.wpb_wrapper' );
$output .= "\n\t" . '</div> ' . $this->endBlockComment( $el_class ) . "\n";
echo $output;