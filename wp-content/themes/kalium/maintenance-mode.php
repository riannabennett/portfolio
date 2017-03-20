<?php
/**
 *	Kalium WordPress Theme
 *
 *	Laborator.co
 *	www.laborator.co
 */

define("KALIUM_NO_HEADER", true);
define("KALIUM_NO_FOOTER", true);

$maintenance_mode_title         = trim(get_data('maintenance_mode_title'));
$maintenance_mode_description   = trim(get_data('maintenance_mode_description'));

add_filter('body_class', create_function('$classes', '$classes[] = "bg-main-color maintenance-mode"; return $classes;'));

if($maintenance_mode_title)
{
	add_filter('wp_title', 'laborator_maintenance_title');

	function laborator_maintenance_title($title, $sep = '&ndash;')
	{
		return " {$sep} " . get_data('maintenance_mode_title');
	}
}

get_header();

?>
<div class="container">
	<div class="page-container">
    	<div class="coming-soon-container">
			<div class="message-container wow fadeIn">
				<i class="icon icon-ecommerce-megaphone"></i>
				<?php echo lab_esc_script(wpautop($maintenance_mode_description)); ?>
			</div>
		</div>
	</div>
</div>
<?php

get_footer();