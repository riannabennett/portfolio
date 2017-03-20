<?php
/** @var $this WPBakeryShortCode_VC_Row */
$output = $el_class = $bg_image = $bg_color = $bg_image_repeat = $font_color = $padding = $margin_bottom = $css = $full_width = '';
extract( shortcode_atts( array(
	'el_class' => '',
	'bg_image' => '',
	'bg_color' => '',
	'bg_image_repeat' => '',
	'font_color' => '',
	'padding' => '',
	'margin_bottom' => '',
	'full_width' => false,
	'css' => '',
), $atts ) );

// wp_enqueue_style( 'js_composer_front' );
wp_enqueue_script( 'wpb_composer_front_js' );
// wp_enqueue_style('js_composer_custom_css');

$el_class = $this->getExtraClass( $el_class );

$css_class = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, 'vc_row wpb_row ' . ( $this->settings( 'base' ) === 'vc_row_inner' ? 'vc_inner ' : '' ) . get_row_css_class() . $el_class, $this->settings['base'], $atts );

$style = $this->buildStyle( $bg_image, $bg_color, $bg_image_repeat, $font_color, $padding, $margin_bottom );

# start: modified by Arlind Nushi
$is_lab_fullwidth = false;

if($full_width == 'lab-full-width')
{
	$is_lab_fullwidth = true;
	$full_width = false;
}

?>
<div class="lab-row-container <?php echo vc_shortcode_custom_css_class( $css, ' ' ); ?>"<?php if( isset( $atts['parallax_enable'] ) && $atts['parallax_enable'] == 'yes' ): ?> data-lab-parallax-ratio="<?php echo is_numeric($atts['parallax_ratio']) ? $atts['parallax_ratio'] : '0.8'; ?>" data-lab-parallax-opacity="<?php echo is_numeric($atts['parallax_opacity']) ? $atts['parallax_opacity'] : ''; ?>"<?php endif; ?>>
<?php

if(empty($full_width) && ! $is_lab_fullwidth):
	?><div class="container"><?php
endif;
# end: modified by Arlind Nushi
?>
	<div <?php
	?>class="<?php echo esc_attr( $css_class ); ?><?php if ( $full_width == 'stretch_row_content_no_spaces' ): echo ' vc_row-no-padding'; endif; ?>" <?php if ( ! empty( $full_width ) ) {
	echo ' data-vc-full-width="true"';
	if ( $full_width == 'stretch_row_content' || $full_width == 'stretch_row_content_no_spaces' ) {
		echo ' data-vc-stretch-content="true"';
	}
} ?> <?php echo $style; ?>><?php
echo wpb_js_remove_wpautop( $content );
?></div><?php echo $this->endBlockComment( 'row' );
echo '<div class="vc_row-full-width"></div>';

# start: modified by Arlind Nushi
if(empty($full_width) && ! $is_lab_fullwidth)
{
	?></div><?php
}

?>
</div>
<?php
# end: modified by Arlind Nushi