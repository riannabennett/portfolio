<?php
/**
 *	Kalium WordPress Theme
 *
 *	Laborator.co
 *	www.laborator.co
 */

global $header_logo_class, $force_use_uploaded_logo, $force_custom_logo_image, $force_custom_logo_max_width;

define("KALIUM_NO_HEADER", true);
define("KALIUM_NO_FOOTER", true);

$header_logo_class                  = 'logo';
$force_use_uploaded_logo            = get_data('coming_soon_mode_use_uploaded_logo');
$force_custom_logo_image            = get_data('coming_soon_mode_custom_logo_image');
$force_custom_logo_max_width        = get_data('coming_soon_mode_custom_logo_max_width');

$coming_soon_mode_countdown			= get_data('coming_soon_mode_countdown');

$coming_soon_mode_title             = get_data('coming_soon_mode_title');
$coming_soon_mode_description       = trim(get_data('coming_soon_mode_description'));

$coming_soon_mode_social_networks   = get_data('coming_soon_mode_social_networks');

add_filter('body_class', create_function('$classes', '$classes[] = "bg-main-color coming-soon-mode"; return $classes;'));

if($coming_soon_mode_title)
{
	add_filter('wp_title', 'laborator_coming_soon_title');

	function laborator_coming_soon_title($title, $sep = '&ndash;')
	{
		return " {$sep} " . get_data('coming_soon_mode_title');
	}
}

get_header();

?>
<div class="container">

	<div class="page-container">
    	<div class="coming-soon-container">
			<div class="message-container wow fadeIn">
				<?php get_template_part('tpls/logo'); ?>
				<?php echo lab_esc_script(wpautop($coming_soon_mode_description)); ?>
			</div>

			<?php if($coming_soon_mode_countdown): ?>
			<div class="countdown-holder">
				<div class="col-sm-12">
					<ul class="countdown">
						<div class="row">
							<div data-wow-duration="1.0s" data-wow-delay="0.1" class="col-sm-offset-2 col-sm-2 col-xs-3 wow fadeIn">
				        		<span class="days">&nbsp;</span>
								<p class="timeRefDays">&nbsp;</p>
							</div>
							<div data-wow-duration="1.5s" data-wow-delay="0.2" class="col-sm-2 col-xs-3 wow fadeIn">
								<span class="hours">&nbsp;</span>
								<p class="timeRefHours">&nbsp;</p>
							</div>
							<div data-wow-duration="2.0s" data-wow-delay="0.35" class="col-sm-2 col-xs-3 wow fadeIn">
								<span class="minutes">&nbsp;</span>
								<p class="timeRefMinutes">&nbsp;</p>
							</div>
							<div data-wow-duration="2.5s" data-wow-delay="0.6" class="col-sm-2 col-xs-3 wow fadeIn">
								<span class="seconds">&nbsp;</span>
								<p class="timeRefSeconds">&nbsp;</p>
							</div>
						</div>
					</ul>
				</div>
			</div>
			<script type="text/javascript">
			jQuery(document).ready(function($)
			{
				$(".countdown").countdown({
					date: "<?php echo strtolower(date("d F Y H:i:s", strtotime(get_data('coming_soon_mode_date')))); ?>",
					format: "on"
				});
			});
			</script>
			<?php endif; ?>

			<?php if($coming_soon_mode_social_networks): ?>
			<div class="social-networks-env wow fadeIn" data-wow-delay="0.2">
				<?php echo do_shortcode('[lab_social_networks]'); ?>
			</div>
			<?php endif; ?>
		</div>
	</div>

</div>
<?php

get_footer();