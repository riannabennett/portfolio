<?php
/**
 *	Kalium WordPress Theme
 *
 *	Laborator.co
 *	www.laborator.co
 */


# Base Functionality
function laborator_init()
{
	$theme_version = wp_get_theme()->get( 'Version' );
	
	# Styles
	wp_register_style('bootstrap', THEMEASSETS . 'css/bootstrap.css', null, null);
	wp_register_style('kalium-main', THEMEASSETS . 'css/kalium.css', null, $theme_version);

	wp_register_style('font-awesome', THEMEASSETS . 'css/fonts/font-awesome/font-awesome.css', null, null);
	wp_register_style('font-flaticons', THEMEASSETS . 'css/fonts/flaticons-custom/flaticon.css', null, null);
	wp_register_style('font-lineaicons', THEMEASSETS . 'css/fonts/linea-iconfont/linea_iconfont.css', null, null);

	wp_register_style('animate-css', THEMEASSETS . 'css/animate.css', null, null);

	wp_register_style('style', get_template_directory_uri() . '/style.css', null, null);


	# Scripts
	wp_register_script('bootstrap', THEMEASSETS . 'js/bootstrap.min.js', null, null, true);
	wp_register_script('modernizr', THEMEASSETS . 'js/modernizr.custom.js', null, null, true);
	wp_register_script('tweenmax', THEMEASSETS . 'js/TweenMax.min.js', null, null, true);
	wp_register_script('joinable', THEMEASSETS . 'js/joinable.min.js', null, null, true);
	wp_register_script('kalium-custom', THEMEASSETS . 'js/kalium-custom.min.js', null, $theme_version, true);

		# Owl Carousel
		wp_register_script('owl-carousel', THEMEASSETS . 'js/owl-carousel/owl.carousel.min.js', null, null, true);
		wp_register_style('owl-carousel', THEMEASSETS . 'js/owl-carousel/owl-carousel.css', null, null);

		# Isotope
		wp_register_script('isotope', THEMEASSETS . 'js/isotope.pkgd.min.js', null, null, true);
		wp_register_script('packery', THEMEASSETS . 'js/packery-mode.pkgd.min.js', null, null, true);

		# Video JS
		wp_register_script('video-js', THEMEASSETS . 'js/video-js/video.js', null, null, true);
		wp_register_script('video-js-youtube', THEMEASSETS . 'js/video-js/youtube.js', null, null, true);
		wp_register_script('video-js-vimeo', THEMEASSETS . 'js/video-js/vimeo.js', null, null, true);
		wp_register_style('video-js', THEMEASSETS . 'js/video-js/video-js.css', null, null);

		# Nivo Lightbox
		wp_register_script('nivo-lightbox', THEMEASSETS . 'js/nivo-lightbox/nivo-lightbox.min.js', null, null, true);
		wp_register_style('nivo-lightbox', THEMEASSETS . 'js/nivo-lightbox/nivo-lightbox.css', null, null);
		wp_register_style('nivo-lightbox-default', THEMEASSETS . 'js/nivo-lightbox/themes/default/default.css', array('nivo-lightbox'), null);

		# Comparison slider
		wp_register_script('image-comparison-slider', THEMEASSETS . 'js/image-comparison-slider.js', null, null, true);
		
		# Owl Carousel
		wp_register_script('slick', THEMEASSETS . 'js/slick/slick.min.js', null, null, true);
		wp_register_style('slick', THEMEASSETS . 'js/slick/slick.css', null, null);
		
		# Fluid Box
		wp_register_script('fluidbox', THEMEASSETS . 'js/fluidbox/jquery.fluidbox.min.js', null, null, true);
		wp_register_style('fluidbox', THEMEASSETS . 'js/fluidbox/css/fluidbox.css', null, null);
		
		# Admin JS & CSS
		wp_register_script('admin-js', THEMEASSETS . 'js/admin-main.js', null, null);
		wp_register_style('admin-css', THEMEASSETS . 'css/admin/main.css', null, null);


	# Google Maps
	wp_enqueue_script('google-maps', '//maps.googleapis.com/maps/api/js?sensor=false', null, null, true);
}


# Enqueue Scritps and other stuff
function laborator_wp_enqueue_scripts()
{
	# Styles
	$rtl_include = '';

	wp_enqueue_style(array('bootstrap', 'kalium-main', 'font-awesome', 'font-flaticons', 'font-lineaicons', 'style'));

	# Scripts
	wp_enqueue_script(array('jquery', 'bootstrap', 'tweenmax', 'modernizr', 'joinable', 'isotope'));

	# Custom Skin
	if(get_data('use_custom_skin'))
	{
		wp_enqueue_style('custom-skin', site_url('?custom-skin'), null, null);
	}
	
	# Single Post
	if(is_single())
	{		
		wp_enqueue_script(array('fluidbox'));
		wp_enqueue_style(array('fluidbox'));
		
		if(comments_open())
		{
			wp_enqueue_script('comment-reply');
		}
	}

	# Fonts
	laborator_load_font();
}


# Custom Skin
if(isset($_GET['custom-skin']))
{
	header("Content-type: text/css; charset: UTF-8");
	echo get_option('kalium_skin_custom_css');
	exit;
}


# Print scripts in the header
function laborator_wp_print_scripts()
{
?>
<script type="text/javascript">
var ajaxurl = ajaxurl || '<?php echo esc_attr( admin_url("admin-ajax.php") ); ?>';
</script>
<?php
}


# After Setup Theme
function laborator_after_setup_theme()
{
	# Theme Support
	add_theme_support('html5');
	add_theme_support('menus');
	add_theme_support('widgets');
	add_theme_support('automatic-feed-links');
	add_theme_support('post-thumbnails');
	add_theme_support('featured-image');
	add_theme_support('woocommerce');
	add_theme_support('post-formats', array('video', 'quote', 'image', 'link', 'gallery', 'audio'));


	# Theme Textdomain
	load_theme_textdomain(TD, get_template_directory() . '/languages');


	# Register Menus
	register_nav_menus(
		array(
			'main-menu'      => 'Main Menu',
			'secondary-menu' => 'Secondary Menu',
			'mobile-menu'    => 'Mobile Menu',
		)
	);
}



# Laborator Menu Page
function laborator_menu_page()
{
	global $menu;

	# Add Separator
	$menu[] = array('', 'read', 'separator-lab', '', 'wp-menu-separator');
	
	add_menu_page('Laborator', 'Laborator', 'edit_theme_options', 'laborator_options', 'laborator_main_page');

	if(lab_get('page') == 'laborator_options')
	{
		wp_redirect( admin_url('themes.php?page=theme-options') );
	}
}


# Redirect to Theme Options
function laborator_options()
{
	wp_redirect( admin_url('themes.php?page=theme-options') );
}


# Theme Options Link in Admin Bar
add_action('admin_bar_menu', 'modify_admin_bar', 10000);

function modify_admin_bar($wp_admin_bar)
{
	$icon = '<i class="wp-menu-image dashicons-before dashicons-admin-generic laborator-admin-bar-menu"></i>';
	
	$wp_admin_bar->add_menu(array(
		'id'      => 'laborator-options',
		'title'   => $icon . wp_get_theme(),
		'href'    => is_admin() ? home_url() : admin_url('themes.php?page=theme-options'),
		'meta'	  => array('target' => is_admin() ? '_blank' : '_self')
	));
	
	$wp_admin_bar->add_menu(array(
		'parent'  => 'laborator-options',
		'id'      => 'laborator-options-sub',
		'title'   => 'Theme Options',
		'href'    => admin_url('themes.php?page=theme-options')
	));
	
	$wp_admin_bar->add_menu(array(
		'parent'  => 'laborator-options',
		'id'      => 'laborator-custom-css',
		'title'   => 'Custom CSS',
		'href'    => admin_url('admin.php?page=laborator_custom_css')
	));
	
	$wp_admin_bar->add_menu(array(
		'parent'  => 'laborator-options',
		'id'      => 'laborator-demo-content-importer',
		'title'   => 'Demo Content Import',
		'href'    => admin_url('admin.php?page=laborator_demo_content_installer')
	));
	
	$wp_admin_bar->add_menu(array(
		'parent'  => 'laborator-options',
		'id'      => 'laborator-help',
		'title'   => 'Theme Help',
		'href'    => admin_url('admin.php?page=laborator_docs')
	));
	
	$wp_admin_bar->add_menu(array(
		'parent'  => 'laborator-options',
		'id'      => 'laborator-themes',
		'title'   => 'Browse Our Themes',
		'href'    => 'http://themeforest.net/user/Laborator/portfolio?ref=Laborator',
		'meta'	  => array('target' => '_blank')
	));
}


# Documentation Page iFrame
function laborator_menu_documentation()
{
	add_submenu_page('laborator_options', 'Documentation', 'Theme Help', 'edit_theme_options', 'laborator_docs', 'laborator_documentation_page');
	add_submenu_page('themes.php', 'Documentation', 'Theme Help', 'edit_theme_options', 'laborator_docs', 'laborator_documentation_page');
}

function laborator_documentation_page()
{
	add_thickbox();
?>
<div class="wrap">
	<h2>Documentation</h2>

	<p>You can read full theme documentation by clicking the button below:</p>

	<p>
		<a href="http://documentation.laborator.co/item/kalium/?theme-inline=true" class="button button-primary" id="lab_read_docs">Read Documentation</a>
	</p>


	<script type="text/javascript">
	jQuery(document).ready(function($)
	{
		$("#lab_read_docs").click(function(ev)
		{
			ev.preventDefault();

			var href = $(this).attr('href');

			tb_show('Theme Documentation' , href + '?TB_iframe=1&width=1280&height=650');
		});
	});
	</script>

	<style>
		.lab-faq-links {

		}

		.lab-faq-links li {
			margin-top: 18px;
			background: #FFF;
			border: 1px solid #E0E0E0;
			padding: 0;
		}

		.lab-faq-links li > strong {
			display: block;
			padding: 10px 15px;
			background: rgba(238,238,238,0.6);
		}

		.lab-faq-links li pre {
			font-size: 13px;
			max-width: 100%;
			word-break: break-word;
			padding: 10px 15px;
			padding-top: 5px;
		}

		.lab-faq-links .warn {
			display: block;
			font-family: Arial, Helvetica, sans-serif;
			border: 1px solid #999;
			padding: 10px;
			font-size: 12px;
			text-transform: uppercase;
		}
	</style>

	<br />
	<h3>Frequently Asked Questions</h3>
	<hr />

	<ul class="lab-faq-links">
		<li id="update-theme">

			<strong>How do I update the theme?</strong>

			<pre>1. Go to Envato Toolkit link in the menu (firstly activate it on: Appearance > Install Plugins)

2. There you type your username i.e. <strong>MyEnvatoUsername</strong> and your <strong>Secret API Key</strong> that can be found on &quot;My Settings&quot; page on ThemeForest,
   example: <a href="http://cl.ly/WT2j" target="_blank">http://cl.ly/WT2j</a>

3. When new update its ready, you'll see a notification under <strong>Envato Toolkit</strong> link. From there you can update the theme.</pre>
		</li>

		<li id="update-visual-composer">

			<strong>How to update Visual Composer (or any other plugin)?</strong>

			<pre>When new theme update is applied it happens often that external plugins needs to be updated too.
This is an extra step you should take in order to keep some plugins up to date (not all necessarily).

To update a specific plugin, for this example we will take "Visual Composer" follow these steps:

1. Go to Plugins, find "WPBakery Visual Composer" plugin (relevant plugin you want to update).

2. Click "Deactivate", when page refreshes click "Delete" on the same plugin.

3. Go to <strong>Appearance > Install Plugins</strong>, find the Visual Composer (or relevant) plugin click Install then Activate.

4. Everything is done.

The same steps can be repeated for other plugins in the <strong>Install Plugins</strong> list.

<strong class="warn">Important Note: You don't have to buy these plugins, they are bundled with the theme</strong></pre>
		</li>

		<li id="regenerate-thumbnails">

			<strong>Regenerate Thumbnails</strong>

			<pre>If your thumbnails are not correctly cropped, you can regenerate them by following these steps:

1. Go to Plugins > Add New

2. Search for "<strong>Regenerate Thumbnails</strong>" (created by <strong>Viper007Bond</strong>)

3. Install and activate that plugin.

4. Go to Tools > Regen. Thumbnails

5. Click "Regenerate All Thumbnails" button and let the process to finish till it reaches 100 percent.</pre>
		</li>
	</ul>
</div>
<?php
}


# Admin Enqueue
function laborator_admin_enqueue_scripts()
{
	wp_enqueue_script('admin-js');
	wp_enqueue_style('admin-css');
	
	echo '<script type="text/javascript">var kalium_assets_dir = "'.THEMEASSETS.'";</script>';
}



# Admin Print Styles
function laborator_admin_print_styles()
{
?>
<style>
	
.laborator-admin-bar-menu {
	position: relative !important;
	display: inline-block;
	width: 16px !important;
	height: 16px !important;
	background: url(<?php echo get_template_directory_uri(); ?>/assets/images/laborator-icon.png) no-repeat 0px 0px !important;
	background-size: 16px !important;
	margin-right: 8px !important;
	top: 3px !important;
}

#wp-admin-bar-laborator-options:hover .laborator-admin-bar-menu {
	background-position: 0 -32px !important;
}

.laborator-admin-bar-menu:before {
	display: none !important;
}

#toplevel_page_laborator_options .wp-menu-image {
	background: url(<?php echo get_template_directory_uri(); ?>/assets/images/laborator-icon.png) no-repeat 11px 8px !important;
	background-size: 16px !important;
}

#toplevel_page_laborator_options .wp-menu-image:before {
	display: none;
}

#toplevel_page_laborator_options .wp-menu-image img {
	display: none;
}

#toplevel_page_laborator_options:hover .wp-menu-image, #toplevel_page_laborator_options.wp-has-current-submenu .wp-menu-image {
	background-position: 11px -24px !important;
}

</style>
<?php
}



function laborator_wp_head()
{
?>

	<!-- IE8 support of HTML5 elements and media queries -->
	<!--[if lt IE 9]>
	  <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
	  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
	<![endif]-->

<?php
}


function laborator_wp_footer()
{
	# Custom.js
	wp_enqueue_script('kalium-custom');

	# Custom Javascript by User
	echo get_data('user_custom_js');
}



# Fav Icon
function laborator_favicon()
{
	$favicon_image = get_data('favicon_image');
	$apple_touch_icon = get_data('apple_touch_icon');

	if($favicon_image || $apple_touch_icon)
	{
		if(is_numeric($favicon_image))
		{
			$favicon_image = wp_get_attachment_image_src($favicon_image, 'full');
			
			if($favicon_image)
			{
				$favicon_image = $favicon_image[0];
			}
		}
		
		if( $favicon_image ) {
			$favicon_image = str_replace( array( 'http:', 'https:' ), '', $favicon_image );
		}
		
		if( $apple_touch_icon ) {
			$apple_touch_icon = str_replace( array( 'http:', 'https:' ), '', $apple_touch_icon );
		}
	?>
	<!-- Favicons -->
	<?php if($favicon_image): ?>
	<link rel="shortcut icon" href="<?php echo esc_attr( $favicon_image ); ?>">
	<?php endif; ?>
	<?php if($apple_touch_icon): ?>
	<link rel="apple-touch-icon-precomposed" href="<?php echo esc_attr($apple_touch_icon); ?>">
	<link rel="apple-touch-icon-precomposed" sizes="72x72" href="<?php echo esc_attr($apple_touch_icon); ?>">
	<link rel="apple-touch-icon-precomposed" sizes="114x114" href="<?php echo esc_attr($apple_touch_icon); ?>">
	<?php endif; ?>
	<?php
	}
}



# Widgets Init
function laborator_widgets_init()
{
	# Blog Sidebar
	$blog_sidebar = array(
		'id' => 'blog_sidebar',
		'name' => 'Blog Widgets',

		'before_widget' => '<div class="sidebar-box-holder wp-widget %1$s %2$s">',
		'after_widget' => '</div>',

		'before_title' => '<h3 class="sidebar-entry-title">',
		'after_title' => '</h3>'
	);

	register_sidebar($blog_sidebar);


	# Footer Sidebar
	$footer_sidebar_column = 'col-xs-12';

	switch(get_data('footer_widgets_columns'))
	{
		case "two":
			$footer_sidebar_column = 'col-sm-6';
			break;

		case "three":
			$footer_sidebar_column = 'col-sm-4';
			break;

		case "four":
			$footer_sidebar_column = 'col-sm-3';
			break;

		case "six":
			$footer_sidebar_column = 'col-sm-2';
			break;
	}

	$footer_sidebar = array(
		'id' => 'footer_sidebar',
		'name' => 'Footer Widgets',

		'before_widget' =>
			'<div class="'.$footer_sidebar_column.'">'
				. '<div class="wp-widget section %2$s %1$s">',

		'after_widget' =>
			'</div>' .
		'</div>',

		'before_title' => '<h3>',
		'after_title' => '</h3>'
	);

	register_sidebar($footer_sidebar);



	# Top Menu Sidebar
	$top_menu_sidebar_column = 'col-md-2 col-sm-4';

	switch(get_data('menu_top_widgets_per_row'))
	{
		case 'six':
			$top_menu_sidebar_column = 'col-sm-6';
			break;

		case 'four':
			$top_menu_sidebar_column = 'col-sm-4';
			break;

		case 'three':
			$top_menu_sidebar_column = 'col-md-3 col-sm-6';
			break;
	}

	$top_menu_sidebar = array(
		'id' => 'top_menu_sidebar',
		'name' => 'Top Menu Widgets',

		'before_widget' =>
			'<div class="'.$top_menu_sidebar_column.'">'
				. '<div class="sidebar-box-holder wp-widget %1$s %2$s">',

		'after_widget' =>
			'</div>' .
		'</div>',

		'before_title' => '<h3 class="sidebar-entry-title">',
		'after_title' => '</h3>'
	);

	register_sidebar($top_menu_sidebar);



	# Sidebar Menu Widgets
	$sidebar_menu_sidebar = array(
		'id' => 'sidebar_menu_sidebar',
		'name' => 'Sidebar Menu Widgets',

		'before_widget' => '<div class="sidebar-box-holder wp-widget %1$s %2$s">',
		'after_widget' => '</div>',

		'before_title' => '<h3 class="sidebar-entry-title">',
		'after_title' => '</h3>'
	);

	register_sidebar($sidebar_menu_sidebar);
	
	
	# Shop Sidebar
	$shop_sidebar = array(
		'id' => 'shop_sidebar',
		'name' => 'Shop Widgets',

		'before_widget' => '<div class="sidebar-box-holder wp-widget %1$s %2$s">',
		'after_widget' => '</div>',

		'before_title' => '<h3 class="sidebar-entry-title">',
		'after_title' => '</h3>'
	);

	register_sidebar($shop_sidebar);

}


# Third party plugins
add_action('tgmpa_register', 'kalium_plugins');

function kalium_plugins()
{
	$plugins = array(

		array(
			'name'               => 'Portfolio Post Type',
			'slug'               => 'portfolio-post-type',
			'required'           => false,
			'version'            => '',
		),

		array(
			'name'               => 'WooCommerce',
			'slug'               => 'woocommerce',
			'required'           => false,
			'version'            => '',
		),

		array(
			'name'               => 'Visual Composer',
			'slug'               => 'js_composer',
			'source'             => get_template_directory() . '/inc/thirdparty-plugins/js_composer.zip',
			'required'           => true,
			'version'            => '4.5.2',
		),

		array(
			'name'               => 'Revolution Slider',
			'slug'               => 'revslider',
			'source'             => get_template_directory() . '/inc/thirdparty-plugins/revslider.zip',
			'required'           => false,
			'version'            => '4.6.93',
		),

		array(
			'name'               => 'Layer Slider',
			'slug'               => 'LayerSlider',
			'source'             => get_template_directory() . '/inc/thirdparty-plugins/layersliderwp.zip',
			'required'           => false,
			'version'            => '5.4.0',
			'minimum_version'	 => null
		),

		array(
			'name'               => 'Envato WordPress Toolkit',
			'slug'               => 'envato-wordpress-toolkit',
			'source'    		 => 'https://github.com/envato/envato-wordpress-toolkit/archive/master.zip',
			'required'           => false,
		),

		array(
			'name'               => 'Advanced Custom Fields',
			'slug'               => 'advanced-custom-fields',
			'required'           => true,
			'force_activation'   => true,
		),

		array(
			'name'               => 'ACF Repeater',
			'slug'               => 'acf-repeater',
			'source'             => get_template_directory() . '/inc/thirdparty-plugins/acf-repeater.zip',
			'required'           => true,
			'force_activation'   => true
		),

		array(
			'name'               => 'ACF Flexible Content',
			'slug'               => 'acf-flexible-content',
			'source'             => get_template_directory() . '/inc/thirdparty-plugins/acf-flexible-content.zip',
			'required'           => true,
			'force_activation'   => true,
		),

		array(
			'name'               => 'ACF Gallery',
			'slug'               => 'acf-gallery',
			'source'             => get_template_directory() . '/inc/thirdparty-plugins/acf-gallery.zip',
			'required'           => true,
			'force_activation'   => true,
		),

	);
	
	if( isset( $_GET[ 'page' ] ) && $_GET[ 'page' ] == 'tgmpa-install-plugins' )
	{		
		wp_enqueue_script('thickbox');
		wp_enqueue_style('thickbox');
		
		add_action('admin_print_styles', create_function('', 'echo "<style> iframe#TB_iframeContent { margin-bottom: -5px !important; width: 100% !important;} </style>";') );
	}
	
	$theme_name = wp_get_theme()->get( 'Name' );
	$theme_version = wp_get_theme()->get( 'Version' );
	
	$config = array(
		'id'           => 'tgmpa',
		'default_path' => '',
		'menu'         => 'tgmpa-install-plugins',
		'parent_slug'  => 'themes.php',
		'capability'   => 'edit_theme_options',
		'has_notices'  => true,
		'dismissable'  => true,
		'dismiss_msg'  => '',
		'is_automatic' => false,
		'message'      => '<div class="notice notice-info is-dismissible" style="margin-top: 20px;">
			<p><strong>Note from Laborator:</strong> To ensure the latest version of theme required plugins, you must have the latest version of ' . $theme_name . ' as well.</p>
			<p>Your current theme version is: <strong>' . $theme_version . '</strong> – <a class="thickbox" href="http://laborator.co/theme-version-check.php?theme=' . basename( get_template_directory_uri() ) . '&version=' . $theme_version . '&ts=' . time() . '&TB_iframe=true" title="Laborator Theme Version Checker" target="_blank">Click here to check if you have the latest version of this theme</a>.</p>
			<p style="font-size: 12px; color: #888;">If any of theme required plugins has released new update after the date that we released ' . "{$theme_name} {$theme_version}" . ', we will include the latest version of that plugin in the next update.</p>
		</div>',
		'strings'         => array(
			'page_title'                         => __( 'Install Required Plugins', 'tgmpa' ),
			'menu_title'                         => __( 'Install Plugins', 'tgmpa' ),
			'installing'                         => __( 'Installing Plugin: %s', 'tgmpa' ),
			'oops'                               => __( 'Something went wrong with the plugin API.', 'tgmpa' ),
			'notice_can_install_required'        => _n_noop( 'This theme requires the following plugin: %1$s.', 'This theme requires the following plugins: %1$s.' ), // %1$s = plugin name(s).
			'notice_can_install_recommended'     => _n_noop( 'This theme recommends the following plugin: %1$s.', 'This theme recommends the following plugins: %1$s.' ), // %1$s = plugin name(s).
			'notice_cannot_install'              => _n_noop( 'Sorry, but you do not have the correct permissions to install the %s plugin. Contact the administrator of this site for help on getting the plugin installed.', 'Sorry, but you do not have the correct permissions to install the %s plugins. Contact the administrator of this site for help on getting the plugins installed.' ), // %1$s = plugin name(s).
			'notice_can_activate_required'       => _n_noop( 'The following required plugin is currently inactive: %1$s.', 'The following required plugins are currently inactive: %1$s.' ), // %1$s = plugin name(s).
			'notice_can_activate_recommended'    => _n_noop( 'The following recommended plugin is currently inactive: %1$s.', 'The following recommended plugins are currently inactive: %1$s.' ), // %1$s = plugin name(s).
			'notice_cannot_activate'             => _n_noop( 'Sorry, but you do not have the correct permissions to activate the %s plugin. Contact the administrator of this site for help on getting the plugin activated.', 'Sorry, but you do not have the correct permissions to activate the %s plugins. Contact the administrator of this site for help on getting the plugins activated.' ), // %1$s = plugin name(s).
			'notice_ask_to_update'               => _n_noop( 'The following plugin needs to be updated to its latest version to ensure maximum compatibility with this theme: %1$s.', 'The following plugins need to be updated to their latest version to ensure maximum compatibility with this theme: %1$s.' ), // %1$s = plugin name(s).
			'notice_cannot_update'               => _n_noop( 'Sorry, but you do not have the correct permissions to update the %s plugin. Contact the administrator of this site for help on getting the plugin updated.', 'Sorry, but you do not have the correct permissions to update the %s plugins. Contact the administrator of this site for help on getting the plugins updated.' ), // %1$s = plugin name(s).
			'install_link'                       => _n_noop( 'Begin installing plugin', 'Begin installing plugins' ),
			'activate_link'                      => _n_noop( 'Begin activating plugin', 'Begin activating plugins' ),
			'return'                             => __( 'Return to Required Plugins Installer', 'tgmpa' ),
			'plugin_activated'                   => __( 'Plugin activated successfully.', 'tgmpa' ),
			'complete'                           => __( 'All plugins installed and activated successfully. %s', 'tgmpa' ),
			'nag_type'                           => 'updated'
		)
	);

	tgmpa( $plugins, $config );
}



# Remove greensock from LayerSlider because it causes theme incompatibility issues
add_action('wp_enqueue_scripts', 'layerslider_remove_greensock');

function layerslider_remove_greensock()
{
	wp_dequeue_script('greensock');
}




# Blog Pagination (endless)
add_action('wp_ajax_laborator_get_paged_blog_posts', 'laborator_get_paged_blog_posts');
add_action('wp_ajax_nopriv_laborator_get_paged_blog_posts', 'laborator_get_paged_blog_posts');

function laborator_get_paged_blog_posts()
{
	$resp = array(
		'content' => ''
	);

	# Query Meta Vars
	$page  = post('page');
	$opts  = post('opts');
	$pp    = post('pp');
	$q 	   = isset($opts['q']) ? $opts['q'] : '';

	# Unserialize Query Details (if has)
	if($q)
	{
		$q = unserialize(rot13decrypt($q));
	}

	$query_args = array(
		'posts_per_page'  => $pp,
		'paged'           => $page,
		'post_status'     => 'publish'
	);

	if($q)
		$query_args = array_merge($q, $query_args);

	# Init query
	$query = new WP_Query($query_args);

	# Import blog options
	include_once(THEMEDIR . 'tpls/blog-query.php');

	# Disable lazy loading for AJAX request
	if($blog_template == 'blog-masonry')
	{
		#$blog_post_list_lazy_load = false;
	}

	# Custom Excerpt length for items
	if($sidebar_position != 'hide')
	{
		add_filter('excerpt_length', 'laborator_short_excerpt_length');
	}

	switch($blog_columns)
	{
		case '_3':
			add_filter('excerpt_length', 'laborator_short_excerpt_length');
			break;

		case '_4':
			add_filter('excerpt_length', 'laborator_supershort_excerpt_length');
			break;
	}

	// Collect posts
	ob_start();

	while($query->have_posts())
	{
		$query->the_post();

		switch($opts['useFormat'])
		{
			case 2:
				get_template_part('tpls/post-format-2');
				break;

			default:
				get_template_part('tpls/post-format-1');
		}
	}

	$content = ob_get_clean();

	# Set up content
	$resp['content'] = $content;

	echo json_encode($resp);

	die();
}


# Portfolio Pagination (endless)
add_action('wp_ajax_laborator_get_paged_portfolio_items', 'laborator_get_paged_portfolio_items');
add_action('wp_ajax_nopriv_laborator_get_paged_portfolio_items', 'laborator_get_paged_portfolio_items');

function laborator_get_paged_portfolio_items()
{
	global $dynamic_image_height;
	
	$resp = array(
		'content' => ''
	);

	# Query Meta Vars
	$page  = post('page');
	$opts  = post('opts');
	$pp    = post('pp');
	$q 	   = isset($opts['q']) ? $opts['q'] : '';

	# Unserialize Query Details (if has)
	if($q)
	{
		$q = unserialize(rot13decrypt($q));
	}

	$query_args = array(
		'post_type'		  => 'portfolio',
		'posts_per_page'  => $pp,
		'paged'           => $page,
		'post_status'     => 'publish'
	);

	if($q)
		$query_args = array_merge($q, $query_args);

	# Init query
	$query = new WP_Query($query_args);

	# Import Portfolio Options
	if($opts['pagename'])
	{
		global $post;

		query_posts("pagename={$opts['pagename']}"); # set as page in order to retrieve options
		$post = get_page_by_path($opts['pagename']);
	}
	
	include_once(THEMEDIR . 'tpls/portfolio-query.php');
	

	// Collect posts
	ob_start();

	$i = 0;
	while($query->have_posts())
	{
		global $i;

		$query->the_post();

		switch($portfolio_type)
		{
			case 'type-1':
				get_template_part('tpls/portfolio-loop-item-type-1');
				break;

			case 'type-2':
				get_template_part('tpls/portfolio-loop-item-type-2');
				break;
		}
		$i++;
	}

	$content = ob_get_clean();

	# Set up content
	$resp['content'] = $content;
	$resp['qq'] = $query_args;

	echo json_encode($resp);

	die();
}


# Coming Mode
add_action('template_redirect', 'laborator_coming_soon_mode');

function laborator_coming_soon_mode()
{
	global $current_user;

	$maintenance_mode  = get_data('maintenance_mode');
	$coming_soon_mode  = get_data('coming_soon_mode');

	$manage_options    = current_user_can('manage_options');

	if($coming_soon_mode && $manage_options == false || lab_get('view-coming-soon'))
	{
		get_template_part('coming-soon-mode');
		die();
	}

	if($maintenance_mode && $manage_options == false || lab_get('view-maintenance'))
	{
		get_template_part('maintenance-mode');
		die();
	}
}


# Like Feature
add_action('wp_ajax_laborator_update_likes', 'laborator_update_like_count');
add_action('wp_ajax_nopriv_laborator_update_likes', 'laborator_update_like_count');

function laborator_update_like_count()
{
	$output    = array(
		'liked' => false,
		'count' => 0
	);

	$post_id   = intval($_GET['post_id']);
	$user_ip   = get_the_user_ip();

	if(filter_var($post_id, FILTER_VALIDATE_INT))
	{
		$the_post = get_post($post_id);

		if($the_post)
		{
			$likes = $the_post->post_likes;
			$likes = is_array($likes) ? $likes : array();

			if( ! in_array($user_ip, $likes))
			{
				// Like Post
				$output['liked'] = true;

				$likes[] = $user_ip;
				$output['count'] = count($likes);

				update_post_meta($post_id, 'post_likes', $likes);
			}
			else
			{
				// Unlike Post
				$output['liked'] = false;

				$key = array_search($user_ip, $likes);

				if (false !== $key)
					unset($likes[$key]);

				$output['count'] = count($likes);

				update_post_meta($post_id, 'post_likes', $likes);
			}
		}

	}

	echo json_encode($output);

	exit();
}

function get_post_likes($post_id = null)
{
	global $post;

	$user_ip   = get_the_user_ip();
	$the_post  = $post_id ? get_post($post_id) : $post;
	$likes     = $the_post->post_likes;

	if( ! is_array($likes))
		$likes = array();

	$output    = array(
		'liked' => in_array($user_ip, $likes),
		'count' => count($likes)
	);

	return $output;
}


# Page Custom CSS
add_action('wp', 'laborator_custom_page_css_wp');
add_action('get_footer', 'laborator_custom_page_css');

function laborator_custom_page_css_wp()
{
	if(is_singular())
	{
		$page_custom_css = get_field('page_custom_css');
		
		if(trim($page_custom_css))
		{
			$post_id = get_the_id();
			$page_custom_css = str_replace('.post-ID', ".page-id-{$post_id}", $page_custom_css);
			
			define("PAGE_CUSTOM_CSS", $page_custom_css);
		}
	}
}

function laborator_custom_page_css()
{
	if(is_singular() && defined("PAGE_CUSTOM_CSS"))
	{
		echo '<style>'.PAGE_CUSTOM_CSS.'</style>';
	}
}



# Search Results Filter
add_action('pre_get_posts', 'laborator_search_pre_get_posts');

function laborator_search_pre_get_posts($wp_query)
{
	global $s;
	
	if(is_search() && is_admin() == false)
	{	
		$search_post_types = get_data('search_post_types');
		$post_types = array();
		
		foreach($search_post_types as $post_type => $include)
		{
			if($include)
			{
				$post_types[] = $post_type;
			}
		}
		
		if( defined( 'WC_INSTALLED' ) && ! isset($search_post_types[ 'product' ]) )
		{
			$post_types[] = 'product';
		}
		
		if(count($post_types))
		{
			$wp_query->set('post_type', $post_types);
		}
		
		remove_action('pre_get_posts', 'laborator_search_pre_get_posts');
	}
}


# Remove ACF menu item from the admin menu
add_action('admin_menu', 'acf_remove_menu_page', 15);

function acf_remove_menu_page() 
{	
	#remove_menu_page('edit.php?post_type=acf');
}



# Remove Post Tag
//add_action('init', 'unregister_portfolio_tag_taxonomy');

function unregister_portfolio_tag_taxonomy()
{
	global $wp_taxonomies;
	
	$taxonomy = 'portfolio_tag';
	
	if(taxonomy_exists($taxonomy))
	{
		unset($wp_taxonomies[$taxonomy]);
	}
}


# Google Meta Theme Color (Phone)
add_action('wp_head', 'laborator_google_theme_color');

function laborator_google_theme_color()
{
	if($google_theme_color = get_data('google_theme_color'))
	{
	?>
	<meta name="theme-color" content="<?php echo $google_theme_color; ?>">
	<?php
	}
}

# Portfolio Category Slug and Remove Tag
add_filter( 'portfolioposttype_category_args', 'laborator_portfolioposttype_category_args', 20 );

function laborator_portfolioposttype_category_args( $args )
{
	$args['rewrite']['slug'] = 'portfolio-category';
	
	return $args;
}


# Revolution Slider set as Theme
define( 'REV_SLIDER_AS_THEME', true );

if( function_exists( 'set_revslider_as_theme' ) )
{
	set_revslider_as_theme();
}