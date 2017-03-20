<?php

add_action('init','of_options');

if (!function_exists('of_options'))
{
	function of_options()
	{


/*-----------------------------------------------------------------------------------*/
/* The Options Array */
/*-----------------------------------------------------------------------------------*/

// Set the Options Array
global $of_options;

$of_options = array();

$show_sidebar_options = array(
	"hide"     => "Hide Sidebar",
	"right"    => "Show Sidebar on Right",
	"left"     => "Show Sidebar on Left",
);

$endless_pagination_style = array(
	'_1' => 'Spinning loader',
	'_2' => 'Pulsating loader',
);

$menu_type_skins = array(
	'menu-skin-main'   => 'Default (Primary Theme Color)',
	'menu-skin-dark'   => 'Black (Dark)',
	'menu-skin-light'  => 'White (Light)',
);

### KALIUM ###

/*
$of_options[] = array( 	"name" 		=> "General Settings",
						"type" 		=> "heading",
						"icon"		=> "fa fa-cog"
				);
*/


/***** LOGO ****/
$of_options[] = array( 	"name" 		=> "Branding",
						"type" 		=> "heading",
						"icon"		=> "fa fa-cube"
				);

$of_options[] = array(  "name"   	=> "Site Brand",
						"desc"   	=> "Enter the text that will appear as logo",
						"id"   		=> "logo_text",
						"std"   	=> get_bloginfo('title'),
						"type"   	=> "text"
					);

$of_options[] = array(
						"desc"   	=> "Upload Custom Logo",
						"id"   		=> "use_uploaded_logo",
						"std"   	=> 0,
						"on"  		=> "Yes",
						"off"  		=> "No",
						"type"   	=> "switch",
						"folds"  	=> 1,
					);

$of_options[] = array(	"name" 		=> "Custom Logo",
						"desc" 		=> "Upload/choose your custom logo image from gallery if you want to use it instead of the default site title text",
						"id" 		=> "custom_logo_image",
						"std" 		=> "",
						"type" 		=> "media",
						"mod" 		=> "min",
						"fold" 		=> "use_uploaded_logo"
					);

$of_options[] = array( 	"desc" 		=> "You can the set maximum width for the uploaded logo, mostly used when you use upload retina (@2x) logo. Pixels unit",
						"id" 		=> "custom_logo_max_width",
						"std" 		=> "",
						"plc"		=> "Logo Width",
						"type" 		=> "text",
						"fold" 		=> "use_uploaded_logo"
				);


$of_options[] = array(	"name" 		=> "Favicon",
						"desc" 		=> "Select 16x16 favicon of the PNG format",
						"id" 		=> "favicon_image",
						"std" 		=> "",
						"type" 		=> "media",
						"mod" 		=> "min"
					);


$of_options[] = array(	"name" 		=> "Apple Touch Icon",
						"desc" 		=> "Required image size 114x114 (png only)",
						"id" 		=> "apple_touch_icon",
						"std" 		=> "",
						"type" 		=> "media",
						"mod" 		=> "min"
					);
/***** END OF: LOGO ****/

$of_options[] = array( 	"name" 		=> "Header and Menu",
						"type" 		=> "heading",
						"icon"		=> "fa fa-header"
				);

$of_options[] = array( 	"name"		=> "Header Settings",
						"desc" 		=> "Header Position (logo and menu container)",
						"id" 		=> "header_position",
						"std" 		=> 'static',
						"options"	=> array(
							'static' => 'Static',
							'absolute' => 'Absolute',
						),
						"type" 		=> "select"
				);

$of_options[] = array( 	"desc" 		=> "Header Spacing<br><small>Note: If Header Position is set to absolute this setting will take effect.</small>",
						"id" 		=> "header_spacing",
						"std" 		=> "",
						"plc"		=> "Default is: 0. Unit is pixels",
						"type" 		=> "text",
				);

$of_options[] = array( 	"name"		=> "Main Menu Type",
						"desc" 		=> "Set default menu style as general site navigation: <br /><small>1. Full Background Menu <br>2. Standard Menu <br>3. Top Menu <br>4. Sidebar Menu</small>",
						"id" 		=> "main_menu_type",
						"std" 		=> 'full-bg-menu',
						"options"	=> array(							
							'full-bg-menu'   => THEMEASSETS . 'images/admin/menu-full-bg.png',
							'standard-menu'  => THEMEASSETS . 'images/admin/menu-standard.png',
							'top-menu'       => THEMEASSETS . 'images/admin/menu-top.png',
							'sidebar-menu'   => THEMEASSETS . 'images/admin/menu-sidebar.png',
						),
						"type" 		=> "images"
				);

$of_options[] = array( 	"name" 		=> "<span>1. Settings</span> Full Background Menu",
						"desc" 		=> "Submenu indicator icon",
						"id" 		=> "menu_full_bg_submenu_indicator",
						"std" 		=> 0,
						"type" 		=> "checkbox",
				);

$of_options[] = array( 	"desc" 		=> "Search field after the last menu item",
						"id" 		=> "menu_full_bg_search_field",
						"std" 		=> 1,
						"type" 		=> "checkbox",
				);

$of_options[] = array( 	"desc" 		=> "Show copyrights and social networks (bottom)",
						"id" 		=> "menu_full_bg_footer_block",
						"std" 		=> 1,
						"type" 		=> "checkbox",
				);

$of_options[] = array( 	"desc" 		=> "Menu alignment (when toggled)",
						"id" 		=> "menu_full_bg_alignment",
						"std" 		=> '',
						"type" 		=> "select",
						"options"	=> array(
							'left'       => 'Left',
							'centered'   => 'Centered',
						)
				);

$of_options[] = array( 	"desc" 		=> "Select color palette for this menu type",
						"id" 		=> "menu_full_bg_skin",
						"std" 		=> '',
						"type" 		=> "select",
						"options"	=> $menu_type_skins
				);


$of_options[] = array( 	"name" 		=> "<span>2. Settings</span> Standard Menu",
						"desc" 		=> "Show menu items only when clicking <strong>menu bar</strong> link",
						"id" 		=> "menu_standard_menu_bar_visible",
						"std" 		=> 1,
						"type" 		=> "checkbox",
				);

$of_options[] = array( 	"desc" 		=> "Reveal effect on <strong>menu bar</strong> click",
						"id" 		=> "menu_standard_menu_bar_effect",
						"std" 		=> '',
						"type" 		=> "select",
						"options"	=> array(
							'reveal-from-top'    => 'Slide from Top',
							'reveal-from-right'  => 'Slide from Right',
							'reveal-from-left'   => 'Slide from Left',
							'reveal-from-bottom' => 'Slide from Bottom',
							'reveal-fade'        => 'Fade Only',
						)
				);

$of_options[] = array( 	"desc" 		=> "Select color palette for this menu type",
						"id" 		=> "menu_standard_skin",
						"std" 		=> '',
						"type" 		=> "select",
						"options"	=> $menu_type_skins
				);


$of_options[] = array( 	"name" 		=> "<span>3. Settings</span> Top Menu",
						"desc" 		=> "Show top menu widgets (<a href=\"".admin_url("widgets.php")."\">manage widgets here</a>)",
						"id" 		=> "menu_top_show_widgets",
						"std" 		=> 1,
						"type" 		=> "checkbox",
						"folds"		=> true
				);

$of_options[] = array( 	"desc" 		=> "Center menu items links (first level only)",
						"id" 		=> "menu_top_nav_links_center",
						"std" 		=> 0,
						"type" 		=> "checkbox",
						"folds"		=> true
				);

$menus_list = array(
	'default'  => '- Main Menu (Default) -'
);

if(is_admin())
{
	$nav_menus = wp_get_nav_menus();
	
	foreach($nav_menus as $item)
	{
		$menus_list["menu-{$item->term_id}"] = $item->name;
	}
}

$of_options[] = array( 	"desc" 		=> "Select menu to use for top menu",
						"id" 		=> "menu_top_menu_id",
						"std" 		=> 'default',
						"type" 		=> "select",
						"options"	=> array_merge($menus_list, array("-" => "(Show no menu)"))
				);

$of_options[] = array( 	"desc" 		=> "Menu items per row (applied to root level only)",
						"id" 		=> "menu_top_items_per_row",
						"std" 		=> 'items-3',
						"type" 		=> "select",
						"options"	=> array(
							'items-1'  => '1 Menu Item per Row',
							'items-2'  => '2 Menu Items per Row',
							'items-3'  => '3 Menu Items per Row',
							'items-4'  => '4 Menu Items per Row',
							'items-5'  => '5 Menu Items per Row',
							'items-6'  => '6 Menu Items per Row',
							'items-7'  => '7 Menu Items per Row',
							'items-8'  => '8 Menu Items per Row',
						)
				);

$of_options[] = array( 	"desc" 		=> "Widgets container width",
						"id" 		=> "menu_top_widgets_container_width",
						"std" 		=> 'col-6',
						"type" 		=> "select",
						"options"	=> array(
							'col-3' => '25% of row width',
							'col-4' => '33% of row width',
							'col-5' => '40% of row width',
							'col-6' => '50% of row width',
							'col-7' => '60% of row width',
							'col-8' => '65% of row width',
						),
						"fold"		=> 'menu_top_show_widgets'
				);

$of_options[] = array( 	"desc" 		=> "Set number of widgets per row for top menu",
						"id" 		=> "menu_top_widgets_per_row",
						"std" 		=> '',
						"type" 		=> "select",
						"options"	=> array(
							'six'    => '2 Widgets per Row',
							'four'   => '3 Widgets per Row',
							'three'  => '4 Widgets per Row',
						),
						"fold"		=> 'menu_top_show_widgets'
				);

$of_options[] = array( 	"desc" 		=> "Select color palette for this menu type",
						"id" 		=> "menu_top_skin",
						"std" 		=> '',
						"type" 		=> "select",
						"options"	=> $menu_type_skins
				);

$of_options[] = array( 	"desc" 		=> "Force top menu include in header
										<br>
										<small class=\"nowrap\">
											When you are not using Top Menu as main menu you can alternatively include it by enabling this option
											<br>
											Enable this option when you separately want to show this menu type by clicking an element with <strong>.top-menu-toggle</strong> class.
										</small>",
						"id" 		=> "menu_top_force_include",
						"std" 		=> 0,
						"type" 		=> "checkbox",
						"folds"		=> true
				);


$of_options[] = array( 	"name" 		=> "<span>4. Settings</span> Sidebar Menu",
						"desc" 		=> "Show sidebar menu widgets (<a href=\"".admin_url("widgets.php")."\">manage widgets here</a>)",
						"id" 		=> "menu_sidebar_show_widgets",
						"std" 		=> 1,
						"type" 		=> "checkbox"
				);


$of_options[] = array( 	"desc" 		=> "Select primary menu to use for sidebar",
						"id" 		=> "menu_sidebar_menu_id",
						"std" 		=> 'default',
						"type" 		=> "select",
						"options"	=> array_merge($menus_list, array("-" => "(Show no menu)"))
				);

$of_options[] = array( 	"desc" 		=> "Sidebar alignment in browser viewport",
						"id" 		=> "menu_sidebar_alignment",
						"std" 		=> 'right',
						"type" 		=> "select",
						"options"	=> array(
							'left'   => 'Left',
							'right'  => 'Right',
						),
						"fold"		=> 'menu_top_show_widgets'
				);

$of_options[] = array( 	"desc" 		=> "Select color palette for this menu type",
						"id" 		=> "menu_sidebar_skin",
						"std" 		=> '',
						"type" 		=> "select",
						"options"	=> $menu_type_skins
				);

$of_options[] = array( 	"desc" 		=> "Force sidebar menu include in header
										<br>
										<small class=\"nowrap\">
											When you are not using Sidebar Menu as main menu you can alternatively include it by enabling this option
											<br>
											Enable this option when you separately want to show this menu type by clicking an element with <strong>.sidebar-menu-toggle</strong> class.
										</small>",
						"id" 		=> "menu_sidebar_force_include",
						"std" 		=> 0,
						"type" 		=> "checkbox",
						"folds"		=> true
				);

$of_options[] = array( 	"name" 		=> "Sticky Menu",
						"desc" 		=> "Enable or disable sticky menu (if supported by menu type)",
						"id" 		=> "header_sticky_menu",
						"std" 		=> 0,
						"on" 		=> "Enable",
						"off" 		=> "Disable",
						"type" 		=> "switch",
						"folds"		=> 1
				);

$of_options[] = array( 	"desc" 		=> "Vertical padding when sticky is active<br /><small>Note: Only numeric value is accepted</small>",
						"id" 		=> "header_sticky_vpadding",
						"plc" 		=> 'Leave empty if you want to let is the same size',
						"type" 		=> "text",
						"fold"		=> "header_sticky_menu"
				);

$of_options[] = array( 	"desc" 		=> "You can apply background color when sticky menu is active",
						"id" 		=> "header_sticky_bg",
						"std" 		=> '',
						"type" 		=> "color",
						"fold"		=> "header_sticky_menu"
				);

$of_options[] = array( 	"desc" 		=> "Sticky menu background opacity (percentage unit)",
						"id" 		=> "header_sticky_bg_alpha",
						"std" 		=> "90",
						"min" 		=> "1",
						"step"		=> "1",
						"max" 		=> "100",
						"type" 		=> "sliderui",
						"fold"		=> "header_sticky_menu"
				);

$of_options[] = array(	"name"		=> "Custom Logo for Sticky Menu",
						"desc"   	=> "Sticky menu custom logo",
						"id"   		=> "header_sticky_custom_logo",
						"std"   	=> 0,
						"on"  		=> "Yes",
						"off"  		=> "No",
						"type"   	=> "switch",
						"folds"  	=> 1,
						"fold"		=> "header_sticky_menu"
					);

$of_options[] = array(	"desc" 		=> "Upload/choose your custom logo image for sticky menu",
						"id" 		=> "header_sticky_logo_image_id",
						"std" 		=> "",
						"type" 		=> "media",
						"mod" 		=> "min",
						"fold" 		=> "header_sticky_custom_logo"
					);

$of_options[] = array( 	"desc" 		=> "You can the set maximum width for the uploaded logo, mostly used when you use upload retina (@2x) logo. Pixels unit",
						"id" 		=> "header_sticky_logo_width",
						"std" 		=> "",
						"plc"		=> "Logo Width",
						"type" 		=> "text",
						"fold" 		=> "header_sticky_custom_logo"
				);

$of_options[] = array( 	"name"		=> "Menu Bar Skin for Sticky Menu",
						"desc" 		=> "Set menu skin to use in sticky mode",
						"id" 		=> "header_sticky_menu_skin",
						"std" 		=> '',
						"type" 		=> "select",
						"options"	=> array_merge(array('' => 'Use Default'), $menu_type_skins),
						"fold" 		=> "header_sticky_menu"
				);

$of_options[] = array( 	"name" 		=> "Footer",
						"type" 		=> "heading",
						"icon"		=> "fa fa-sort-amount-asc"
				);
				
$of_options[] = array( 	"name" 		=> "Footer Style",
						"desc" 		=> "Select footer style color. Inverted will turn font color to white",
						"id" 		=> "footer_style",
						"std" 		=> '',
						"type" 		=> "select",
						"options"	=> array(
							''           => 'Default',
							'inverted'   => 'Inverted',
						)
				);

$of_options[] = array( 	"desc" 		=> "Set the background color. Leave empty for transparent background",
						"id" 		=> "footer_bg",
						"std" 		=> '#eeeeee',
						"type" 		=> "color",
						"fold"		=> "footer_bg_transparent"
				);

$of_options[] = array( 	"name" 		=> "Footer Widgets",
						"desc" 		=> "Show or hide footer widgets",
						"id" 		=> "footer_widgets",
						"std" 		=> 1,
						"on" 		=> "Show",
						"off" 		=> "Hide",
						"type" 		=> "switch",
						"folds"		=> 1
				);

$of_options[] = array( 	"desc" 		=> "Select the size of footer columns to show",
						"id" 		=> "footer_widgets_columns",
						"std" 		=> "three",
						"type" 		=> "select",
						"options" 	=> array(
							"one"    => "One Column per Row (1/1)",
							"two"    => "Two Columns per Row (1/2)",
							"three"  => "Three Columns per Row (1/3)",
							"four"   => "Four Columns per Row (1/4)",
							"six"    => "Six Columns per Row (1/6)"
						),
						"fold"		=> "footer_widgets"
				);

$of_options[] = array( 	"desc" 		=> "Collapse or expand footer widgets in mobile devices<br><small>Note: Users still can see footer widgets (if collapsed) when they click <strong>three dots (...)</strong> link</small>",
						"id" 		=> "footer_collapse_mobile",
						"std" 		=> 0,
						"on" 		=> "Collapsed",
						"off" 		=> "Expanded",
						"type" 		=> "switch",
						"fold"		=> "footer_widgets"
				);

$of_options[] = array( 	"name" 		=> "Footer Bottom Section",
						"desc" 		=> "Enable or remove the bottom footer with copyrights text",
						"id" 		=> "footer_bottom_visible",
						"std" 		=> 1,
						"on" 		=> "Show",
						"off" 		=> "Hide",
						"type" 		=> "switch",
						"folds"		=> 1
				);

$of_options[] = array( 	"name" 		=> "Footer Bottom Style",
						"desc" 		=> "Select which type of bottom footer you want to use",
						"id" 		=> "footer_bottom_style",
						"std" 		=> "horizontal",
						"type" 		=> "images",
						"options" 	=> array(
							'horizontal' => THEMEASSETS . 'images/admin/footer-style-horizontal.png',
							'vertical'   => THEMEASSETS . 'images/admin/footer-style-vertical.png',
						),
						"fold"		=> "footer_bottom_visible"
				);

$of_options[] = array( 	"name" 		=> "Fixed Footer",
						"desc" 		=> "Setting this setting to fixed will stick footer to bottom edge of window behind the wrapper",
						"id" 		=> "footer_fixed",
						"std" 		=> '',
						"type" 		=> "select",
						"options"	=> array(
							''               => 'Normal',
							'fixed'          => 'Fixed to Bottom (No animations)',
							'fixed-fade'     => 'Fixed to Bottom with Fade Animation',
							'fixed-slide'    => 'Fixed to Bottom with Slide Animation',
						)
				);

$of_options[] = array( 	"name" 		=> "Footer Text",
						"desc" 		=> "Footer Left - Copyrights text in the footer",
						"id" 		=> "footer_text",
						"std" 		=> "&copy; Copyright ".date("Y").". All Rights Reserved",
						"type" 		=> "textarea",
						"fold"		=> "footer_bottom_visible"
				);

$of_options[] = array( 	"desc" 		=> "Footer Right - Content for the right block in the footer bottom",
						"id" 		=> "footer_text_right",
						"std" 		=> "[lab_social_networks]",
						"type" 		=> "textarea",
						"fold"		=> "footer_bottom_visible"
				);

$of_options[] = array( 	"name" 		=> "Custom Javascript",
						"desc" 		=> "Put JavaScript code here. This will be added into the footer template, you can also add analytics code here.<br /><small>Note: &lt;script&gt;&lt;/script&gt; wrapping is required</small>",
						"id" 		=> "user_custom_js",
						"std" 		=> "",
						"type" 		=> "textarea"
				);


// BLOG SETTINGS
$of_options[] = array( 	"name" 		=> "Blog Settings",
						"type" 		=> "heading",
						"icon"		=> "fa fa-newspaper-o"
				);
				

$of_options[] = array( 	"name" 		=> "Blog Title & Description",
						"desc" 		=> "Show header title and description in blog page",
						"id" 		=> "blog_show_header_title",
						"std" 		=> 1,
						"on" 		=> "Show",
						"off" 		=> "Hide",
						"type" 		=> "switch",
						"folds"		=> 1
				);

$of_options[] = array( 	"desc" 		=> "Blog header title (optional)",
						"id" 		=> "blog_title",
						"std" 		=> "Blog",
						"plc"		=> "",
						"type" 		=> "text",
						"fold"		=> "blog_show_header_title"
				);

$of_options[] = array( 	"desc" 		=> "Blog description in header (optional)",
						"id" 		=> "blog_description",
						"std"		=> "Our everyday thoughts are presented here".PHP_EOL."Music, video presentations, photo-shootings and more",
						"plc" 		=> "",
						"type" 		=> "textarea",
						"type" 		=> "textarea",
						"fold"		=> "blog_show_header_title",
 				);

$of_options[] = array( 	"name"		=> "Default Blog Template",
						"desc" 		=> "Select your preferred blog template to show blog posts",
						"id" 		=> "blog_template",
						"std" 		=> 'blog-squared',
						"options"	=> array(
							
							'blog-squared' => THEMEASSETS . 'images/admin/blog-template-squared.png',
							'blog-rounded'   => THEMEASSETS . 'images/admin/blog-template-rounded.png',
							'blog-masonry'   => THEMEASSETS . 'images/admin/blog-template-masonry.png',
						),
						"type" 		=> "images"
				);

$of_options[] = array( 	"name" 		=> "Blog Sidebar",
					 	"desc" 		=> "Set blog sidebar position, you can even hide it",
						"id" 		=> "blog_sidebar_position",
						"std" 		=> "right",
						"type" 		=> "select",
						"options" 	=> $show_sidebar_options
				);

$of_options[] = array( 	"name" 		=> "Toggle Blog Functionality",
						"desc" 		=> "Thumbnails (catalog page)",
						"id" 		=> "blog_thumbnails",
						"std" 		=> 1,
						"type" 		=> "checkbox"
				);

$of_options[] = array( 	"desc" 		=> "Single post thumbnail (single page)",
						"id" 		=> "blog_single_thumbnails",
						"std" 		=> 1,
						"type" 		=> "checkbox"
				);

$of_options[] = array( 	"desc" 		=> "Author info (single post)",
						"id" 		=> "blog_author_info",
						"std" 		=> 0,
						"type" 		=> "checkbox"
				);

$of_options[] = array( 	"desc" 		=> "Post date (where applied)",
						"id" 		=> "blog_post_date",
						"std" 		=> 1,
						"type" 		=> "checkbox"
				);

$of_options[] = array( 	"desc" 		=> "Category (single post)",
						"id" 		=> "blog_category",
						"std" 		=> 1,
						"type" 		=> "checkbox"
				);

$of_options[] = array( 	"desc" 		=> "Tags (single post)",
						"id" 		=> "blog_tags",
						"std" 		=> 1,
						"type" 		=> "checkbox"
				);

$of_options[] = array( 	"desc" 		=> "Post type icon (where applied)",
						"id" 		=> "blog_post_type_icon",
						"std" 		=> 1,
						"type" 		=> "checkbox"
				);

$of_options[] = array( 	"desc" 		=> "Support for post formats (catalog page)",
						"id" 		=> "blog_post_formats",
						"std" 		=> 1,
						"type" 		=> "checkbox"
				);

$of_options[] = array( 	"desc" 		=> "Lazy loading for thumbnails (catalog page)",
						"id" 		=> "blog_post_list_lazy_load",
						"std" 		=> 1,
						"type" 		=> "checkbox"
				);

$of_options[] = array( 	"desc" 		=> "Show next-previous post links (single page)",
						"id" 		=> "blog_post_prev_next",
						"std" 		=> 1,
						"type" 		=> "checkbox"
				);

$of_options[] = array( 	"desc" 		=> "Columns count (applied for masonry blog only)",
						"id" 		=> "blog_columns",
						"std" 		=> '_3',
						"options"	=> array(
							'_1' => '1 Column',
							'_2' => '2 Columns',
							'_3' => '3 Columns',
							'_4' => '4 Columns'
						),
						"type" 		=> "select"
				);

$of_options[] = array( 	"desc" 		=> "Thumbnail hover effect (where applied)",
						"id" 		=> "blog_thumbnail_hover_effect",
						"std" 		=> 'full-cover',
						"options"	=> array(
							''						 => 'No hover effect',
							'full-cover'             => 'Full cover with small transparency',
							'distanced'              => 'Distanced cover with small transparency',
							'full-cover-no-opacity'  => 'Full cover (no transparent bg)',
							'distanced-no-opacity'   => 'Distanced cover (no transparent bg)',
						),
						"type" 		=> "select"
				);

$of_options[] = array( 	"desc" 		=> "Select default video &amp; audio player skin (when supported)",
						"id" 		=> "blog_post_formats_video_player_skin",
						"std" 		=> '_1',
						"options"	=> array(
							'_1' => 'Full Control',
							'_2' => 'Minimal',
						),
						"type" 		=> "select"
				);

$of_options[] = array( 	"desc" 		=> "Featured image placement (single post)",
						"id" 		=> "blog_featured_image_placement",
						"std" 		=> 'container',
						"options"	=> array(
							'container' => 'Within Container',
							'full-width' => 'Full Width',
						),
						"type" 		=> "select"
				);

$of_options[] = array( 	"desc" 		=> "Featured image size (single post)",
						"id" 		=> "blog_featured_image_size_type",
						"std" 		=> 'default',
						"options"	=> array(
							'default' => 'Default Thumbnail Size',
							'full' 	  => 'Original Image Size',
						),
						"type" 		=> "select"
				);

$of_options[] = array( 	"desc" 		=> "Interval of auto-switch for gallery images (0 - disable)",
						"id" 		=> "blog_gallery_autoswitch",
						"std" 		=> "",
						"plc"		=> "Default: 5 (seconds)",
						"type" 		=> "text"
				);

$of_options[] = array( 	"desc" 		=> "Featured image thumbnail height (applied on single post only). If you change this value, you need to regenerate thumbnails again",
						"id" 		=> "blog_thumbnail_height",
						"std" 		=> "",
						"plc"		=> "Default value is applied if set to empty: 490",
						"type" 		=> "text"
				);

$of_options[] = array( 	"name" 		=> "Pagination",
						"desc" 		=> "Select pagination type",
						"id" 		=> "blog_pagination_type",
						"std" 		=> "center",
						"type" 		=> "select",
						"options" 	=> array(
							"normal"         => "Normal Pagination",
							"endless"        => "Endless Scroll",
							"endless-reveal" => "Endless Scroll + Auto Reveal"
						)
				);

$of_options[] = array( 	"desc" 		=> "Pagination style for endless scroll while loading",
						"id" 		=> "blog_endless_pagination_style",
						"std" 		=> "_1",
						"type" 		=> "select",
						"options" 	=> $endless_pagination_style
				);

$of_options[] = array( 	"desc" 		=> "Set pagination position",
						"id" 		=> "blog_pagination_position",
						"std" 		=> "center",
						"type" 		=> "select",
						"options" 	=> array("left" => "Left", "center" => "Center", "right" => "Right")
				);

$of_options[] = array( 	"name" 		=> "Share Story",
						"desc" 		=> "Enable or disable sharing the story in popular Social Networks",
						"id" 		=> "blog_share_story",
						"std" 		=> 0,
						"on" 		=> "Allow Share",
						"off" 		=> "No",
						"type" 		=> "switch",
						"folds"		=> 1
				);

$share_story_networks = array(
			"visible" => array (
				"placebo"	=> "placebo",
				"fb"   	 	=> "Facebook",
				"tw"   	 	=> "Twitter",
				"lin"       => "LinkedIn",
				"pi"        => "Pinterest",
				"tlr"       => "Tumblr",
				"gp"       	=> "Google Plus",
			),

			"hidden" => array (
				"placebo"   => "placebo",
				"pi"       	=> "Pinterest",
				"em"       	=> "Email",
				"vk"       	=> "VKontakte",
			),
);

$of_options[] = array( 	"name" 		=> "Share Story Networks",
						"desc" 		=> "Select social networks that you allow users to share the content of your blog posts",
						"id" 		=> "blog_share_story_networks",
						"std" 		=> $share_story_networks,
						"type" 		=> "sorter",
						"fold"		=> "blog_share_story"
				);
// END OF BLOG SETTINGS


// PORTFOLIO SETTINGS
$of_options[] = array( 	"name" 		=> "Portfolio Settings",
						"type" 		=> "heading",
						"icon"		=> "fa fa-th"
				);

$of_options[] = array( 	"name" 		=> "Toggle Portfolio Functionality",
						"desc" 		=> "Like feature for portfolio items",
						"id" 		=> "portfolio_likes",
						"std" 		=> 1,
						"type" 		=> "checkbox"
				);

$of_options[] = array( 	"desc" 		=> "Category filter for portfolio items",
						"id" 		=> "portfolio_category_filter",
						"std" 		=> 1,
						"type" 		=> "checkbox",
				);

$of_options[] = array( 	"desc" 		=> "<strong>Next-Prev</strong> navigation in single item",
						"id" 		=> "portfolio_prev_next",
						"std" 		=> 1,
						"type" 		=> "checkbox",
						"folds"		=> 1
				);

$of_options[] = array( 	"desc" 		=> "Next-Prev links to the current category items",
						"id" 		=> "portfolio_prev_next_category",
						"std" 		=> 1,
						"type" 		=> "checkbox",
						"folds"		=> 1
				);

$of_options[] = array( 	"desc" 		=> "Select default Next-Prev design layout",
						"id" 		=> "portfolio_prev_next_type",
						"std" 		=> "simple",
						"type" 		=> "select",
						"options" 	=> array(
							"simple" => "Simple Next-Prev (in the end of page)",
							"fixed"  => "Fixed Position Next-Prev",
						),
						"fold"		=> "portfolio_prev_next"
				);

$of_options[] = array( 	"desc" 		=> "Next-Prev alignment in the browser.<br /><small>Note: This setting is supported for Fixed Position Next-Prev Type only.</small>",
						"id" 		=> "portfolio_prev_next_position",
						"std" 		=> "right-side",
						"type" 		=> "select",
						"options" 	=> array(
							"left-side"  => "Next-Prev - Left",
							"centered"   => "Next-Prev - Center",
							"right-side" => "Next-Prev - Right",
						),
						"fold"		=> "portfolio_prev_next"
				);

$of_options[] = array( 	"desc" 		=> "Portfolio archive url (if empty default portfolio archive url will be used).<br><small>Note: This URL will be used in Next-Prev navigation</small>",
						"id" 		=> "portfolio_archive_url",
						"std" 		=> "",
						"plc"		=> get_post_type_archive_link("portfolio"),
						"type" 		=> "text",
						"fold"		=> "portfolio_prev_next"
				);

$of_options[] = array( 	"desc" 		=> "Like &amp; share design layout",
						"id" 		=> "portfolio_like_share_layout",
						"std" 		=> "default",
						"type" 		=> "select",
						"options" 	=> array(
							"default"    => "Plain links",
							"rounded"    => "Rounded links (circles)",
						)
				);

$of_options[] = array( 	"desc" 		=> "Reveal effect for portfolio items",
						"id" 		=> "portfolio_reveal_effect",
						"std" 		=> "slidenfade",
						"type" 		=> "select",
						"options" 	=> array(
							"none"			 => "None",
							"fade"           => "Fade",
							"slidenfade"     => "Slide and Fade",
							"zoom"           => "Zoom In",
							"fade-one"       => "Fade (one by one)",
							"slidenfade-one" => "Slide and Fade (one by one)",
							"zoom-one"       => "Zoom In (one by one)"
						)
				);


$of_options[] = array( 	"name" 		=> "Portfolio Title & Description",
						"desc" 		=> "Show header title and description in portfolio page. <br /><small>Note: You can override this setting for individual portfolio pages.</small>",
						"id" 		=> "portfolio_show_header_title",
						"std" 		=> 1,
						"on" 		=> "Show",
						"off" 		=> "Hide",
						"type" 		=> "switch",
						"folds"		=> 1
				);

$of_options[] = array( 	"desc" 		=> "Portfolio header title (optional)",
						"id" 		=> "portfolio_title",
						"std" 		=> "Portfolio",
						"plc"		=> "",
						"type" 		=> "text",
						"fold"		=> "portfolio_show_header_title"
				);

$of_options[] = array( 	"desc" 		=> "Portfolio description in header (optional)",
						"id" 		=> "portfolio_description",
						"std"		=> "Our everyday work is presented here, we do what we love,".PHP_EOL."Case studies, video presentations and photo-shootings below",
						"plc" 		=> "",
						"type" 		=> "textarea",
						"fold"		=> "portfolio_show_header_title"
				);


$of_options[] = array( 	"name" 		=> "Portfolio Layout Type",
						"desc" 		=> "Select default type to show portfolio items.<br /><small>Note: You can override this setting for individual portfolio pages.</small><br><br>",
						"id" 		=> "portfolio_type",
						"std" 		=> "type-1",
						"type" 		=> "images",
						"options" 	=> array(
							'type-1' => THEMEASSETS . 'images/admin/portfolio-grid/portfolio-type-1.png',
							'type-2' => THEMEASSETS . 'images/admin/portfolio-grid/portfolio-type-2.png',
							'type-3' => THEMEASSETS . 'images/admin/portfolio-grid/portfolio-type-3.png',
							//'type-4' => THEMEASSETS . 'images/admin/portfolio-grid/portfolio-type-4.png',
						),
						"descrs"	=> array(
							'type-1' => 'Thumbnails with Visible Titles',
							'type-2' => 'Thumbnails with Titles Inside',
							'type-3' => 'Thumbnails with Titles Inside (Masonry)',
						)
				);

$of_options[] = array( 	"name" 		=> "Thumbnails with Visible Titles <span class='padding-left'>Settings</span>",
						"desc" 		=> "Show categories below the titles",
						"id" 		=> "portfolio_type_1_categories",
						"std" 		=> 1,
						"type" 		=> "checkbox"
				);

$of_options[] = array( 	"desc" 		=> "Use dynamic thumbnail height (not cropped)",
						"id" 		=> "portfolio_type_1_dynamic_height",
						"std" 		=> 0,
						"type" 		=> "checkbox"
				);

$of_options[] = array( 	"desc" 		=> "Columns to show portfolio items",
						"id" 		=> "portfolio_type_1_columns_count",
						"std" 		=> "four",
						"type" 		=> "select",
						"options" 	=> array(
							"six"    => "2 Items per Row",
							"four"   => "3 Items per Row",
							"three"  => "4 Items per Row"
						)
				);


$of_options[] = array( 	"desc" 		=> "Thumbnail hover effect",
						"id" 		=> "portfolio_type_1_hover_effect",
						"std" 		=> "full",
						"type" 		=> "select",
						"options" 	=> array(
							"none"       => "No hover effect",
							"full"       => "Full background hover",
							"distanced"  => "Distanced background hover"
						)
				);

$of_options[] = array( 	"desc" 		=> "Thumbnail hover transparency",
						"id" 		=> "portfolio_type_1_hover_transparency",
						"std" 		=> "opacity",
						"type" 		=> "select",
						"options" 	=> array(
							"opacity"    => "Apply Transparency",
							"no-opacity" => "No Transparency",
						)
				);

$of_options[] = array( 	"desc" 		=> "Hover color background for this type",
						"id" 		=> "portfolio_type_1_hover_color",
						"std" 		=> "",
						"type" 		=> "color"
				);

$of_options[] = array( 	"desc" 		=> "Portfolio items per page for this type",
						"id" 		=> "portfolio_type_1_items_per_page",
						"std" 		=> "",
						"plc"		=> "(leave empty to use WordPress default)",
						"type" 		=> "text"
				);

$of_options[] = array( 	"desc" 		=> "Thumbnail size for this type",
						"id" 		=> "portfolio_thumbnail_size_1",
						"std" 		=> "",
						"plc"		=> "Leave empty to use default: 505x420",
						"type" 		=> "text"
				);


$of_options[] = array( 	"name" 		=> "Thumbnails with Titles Inside + Masonry <span class='padding-left'>Settings</span>",
						"desc" 		=> "Show categories below the titles",
						"id" 		=> "portfolio_type_2_categories",
						"std" 		=> 1,
						"type" 		=> "checkbox"
				);


$of_options[] = array( 	"desc" 		=> "Show like button for portfolio items",
						"id" 		=> "portfolio_type_2_likes_show",
						"std" 		=> 1,
						"type" 		=> "checkbox"
				);

$of_options[] = array( 	"desc" 		=> "Columns count for the current view type",
						"id" 		=> "portfolio_type_2_columns_count",
						"std" 		=> "four",
						"type" 		=> "select",
						"options" 	=> array(
							"six"    => "2 Items per Row",
							"four"   => "3 Items per Row",
							"three"  => "4 Items per Row"
						)
				);

$of_options[] = array( 	"desc" 		=> "Spacing between portfolio items",
						"id" 		=> "portfolio_type_2_grid_spacing",
						"std" 		=> "four",
						"type" 		=> "select",
						"options" 	=> array(
							"normal" => "Default spacing",
							"merged" => "Merged (no spacing)"
						)
				);

$of_options[] = array( 	"desc" 		=> "Thumbnail hover effect",
						"id" 		=> "portfolio_type_2_hover_effect",
						"std" 		=> "full",
						"type" 		=> "select",
						"options" 	=> array(
							"none"       => "No hover effect",
							"full"       => "Full background hover",
							"distanced"  => "Distanced background hover"
						)
				);

$of_options[] = array( 	"desc" 		=> "Thumbnail hover text position",
						"id" 		=> "portfolio_type_2_hover_text_position",
						"std" 		=> "bottom-left",
						"type" 		=> "select",
						"options" 	=> array(
							"top-left"       => "Top Left",
							"top-right"      => "Top Right",
							"center"         => "Center",
							"bottom-left"    => "Bottom Left",
							"bottom-right"   => "Bottom Right",
						)
				);

$of_options[] = array( 	"desc" 		=> "Thumbnail hover transparency",
						"id" 		=> "portfolio_type_2_hover_transparency",
						"std" 		=> "opacity",
						"type" 		=> "select",
						"options" 	=> array(
							"opacity"    => "Apply Transparency",
							"no-opacity" => "No Transparency",
						)
				);

$of_options[] = array( 	"desc" 		=> "Thumbnail hover background style",
						"id" 		=> "portfolio_type_2_hover_style",
						"std" 		=> "primary",
						"type" 		=> "select",
						"options" 	=> array(
							"primary"=> "Primary theme color",
							"black"  => "Black background",
							"white"  => "White background"
						)
				);

$of_options[] = array( 	"desc" 		=> "Hover color background for this type",
						"id" 		=> "portfolio_type_2_hover_color",
						"std" 		=> "",
						"type" 		=> "color"
				);

$of_options[] = array( 	"desc" 		=> "Portfolio items per page for this type",
						"id" 		=> "portfolio_type_2_items_per_page",
						"std" 		=> "",
						"plc"		=> "(leave empty to use WordPress default)",
						"type" 		=> "text"
				);

$of_options[] = array( 	"desc" 		=> "Thumbnail size for this type",
						"id" 		=> "portfolio_thumbnail_size_2",
						"std" 		=> "",
						"plc"		=> "Leave empty to use default: 505x420",
						"type" 		=> "text"
				);


$of_options[] = array( 	"name" 		=> "Pagination",
						"desc" 		=> "Select pagination type",
						"id" 		=> "portfolio_pagination_type",
						"std" 		=> "center",
						"type" 		=> "select",
						"options" 	=> array(
							"normal"         => "Normal Pagination",
							"endless"        => "Endless Scroll",
							"endless-reveal" => "Endless Scroll + Auto Reveal"
						)
				);

$of_options[] = array( 	"desc" 		=> "Pagination style for endless scroll while loading",
						"id" 		=> "portfolio_endless_pagination_style",
						"std" 		=> "_1",
						"type" 		=> "select",
						"options" 	=> $endless_pagination_style
				);

$of_options[] = array( 	"desc" 		=> "Set pagination position",
						"id" 		=> "portfolio_pagination_position",
						"std" 		=> "center",
						"type" 		=> "select",
						"options" 	=> array("left" => "Left", "center" => "Center", "right" => "Right")
				);


$of_options[] = array( 	"name" 		=> "Share Item",
						"desc" 		=> "Enable or disable sharing portfolio item in popular Social Networks",
						"id" 		=> "portfolio_share_item",
						"std" 		=> 0,
						"on" 		=> "Allow Share",
						"off" 		=> "No",
						"type" 		=> "switch",
						"folds"		=> 1
				);


$share_portfolio_networks = array(
			"visible" => array (
				"placebo"	=> "placebo",
				"fb"   	 	=> "Facebook",
				"tw"   	 	=> "Twitter",
				"pr"   	 	=> "Print Page",
			),

			"hidden" => array (
				"placebo"   => "placebo",
				"pi"       	=> "Pinterest",
				"em"       	=> "Email",
				"tlr"       => "Tumblr",
				"lin"       => "LinkedIn",
				"pi"        => "Pinterest",
				"gp"       	=> "Google Plus",
				"vk"       	=> "VKontakte",
			),
);

$of_options[] = array( 	"name" 		=> "Share Story Networks",
						"desc" 		=> "Select social networks that you allow users to share portfolio items",
						"id" 		=> "portfolio_share_item_networks",
						"std" 		=> $share_portfolio_networks,
						"type" 		=> "sorter",
						"fold"		=> "portfolio_share_item"
				);
// END OF PORTFOLIO SETTINGS


// SHOP SETTINGS
$of_options[] = array( 	"name" 		=> "Shop Settings",
						"type" 		=> "heading",
						"icon"		=> "fa fa-shopping-cart"
				);

$of_options[] = array( 	"name"		=> "Shop Catalog Layout",
						"desc" 		=> "",
						"id" 		=> "shop_catalog_layout",
						"std" 		=> 'default',
						"options"	=> array(
							'default'            => THEMEASSETS . 'images/admin/shop-loop-layout-1.png',
							'full-bg'            => THEMEASSETS . 'images/admin/shop-loop-layout-2.png',
							'distanced-centered' => THEMEASSETS . 'images/admin/shop-loop-layout-3.png',
							'transparent-bg'     => THEMEASSETS . 'images/admin/shop-loop-layout-4.png',
						),
						"descrs"	=> array(
							'default'            => 'Default',
							'full-bg'            => 'Full Background',
							'distanced-centered' => 'Distanced Bg – Centered',
							'transparent-bg'     => 'Minimal',
						),
						"type" 		=> "images"
				);

$of_options[] = array( 	"name" 		=> "<span>Shop Loop</span> Listing Settings",
						"desc" 		=> "Shop head title and results count",
						"id" 		=> "shop_title_show",
						"std" 		=> 1,
						"type" 		=> "checkbox"
				);

$of_options[] = array( 	"desc" 		=> "Product sorting in catalog page",
						"id" 		=> "shop_sorting_show",
						"std" 		=> 1,
						"type" 		=> "checkbox"
				);

$of_options[] = array( 	"desc" 		=> "Show <strong>sale</strong> badge",
						"id" 		=> "shop_sale_ribbon_show",
						"std" 		=> 1,
						"type" 		=> "checkbox"
				);

$of_options[] = array( 	"desc" 		=> "Show <strong>out of stock</strong> badge",
						"id" 		=> "shop_oos_ribbon_show",
						"std" 		=> 1,
						"type" 		=> "checkbox"
				);

$of_options[] = array( 	"desc" 		=> "Show <strong>featured</strong> badge",
						"id" 		=> "shop_featured_ribbon_show",
						"std" 		=> 1,
						"type" 		=> "checkbox"
				);

$of_options[] = array( 	"desc" 		=> "Item category",
						"id" 		=> "shop_product_category_listing",
						"std" 		=> 1,
						"type" 		=> "checkbox"
				);

$of_options[] = array( 	"desc" 		=> "Item price",
						"id" 		=> "shop_product_price_listing",
						"std" 		=> 1,
						"type" 		=> "checkbox"
				);

$of_options[] = array( 	"desc" 		=> "Add to cart product",
						"id" 		=> "shop_add_to_cart_listing",
						"std" 		=> 1,
						"type" 		=> "checkbox"
				);

$of_options[] = array( 	"desc" 		=> "Enable <font color='#dd1f26'><strong>catalog</strong></font> mode",
						"id" 		=> "shop_catalog_mode",
						"std" 		=> 0,
						"type" 		=> "checkbox",
						"folds"		=> true
				);

$of_options[] = array( 	"desc" 		=> "<strong>Catalog mode</strong> &ndash; hide prices",
						"id" 		=> "shop_catalog_mode_hide_prices",
						"std" 		=> 0,
						"type" 		=> "checkbox",
						"fold"		=> "shop_catalog_mode"
				);

$of_options[] = array( 	"desc" 		=> "Masonry mode",
						"id" 		=> "shop_loop_masonry",
						"std" 		=> 1,
						"type" 		=> "checkbox",
						"folds"		=> 1
				);

$of_options[] = array( 	"desc" 		=> "Use proportional thumbnail height",
						"id" 		=> "shop_loop_thumb_proportional",
						"std" 		=> 0,
						"type" 		=> "checkbox",
						"folds"		=> 1
				);

$of_options[] = array( 	"desc" 		=> "Masonry Layout Mode<br /><small>Note: When <strong>Masonry Mode</strong> is activated you can choose layout renderer.</small>",
						"id" 		=> "shop_loop_masonry_layout_mode",
						"std" 		=> "fitRows",
						"type" 		=> "select",
						"options" 	=> array(
							"masonry"    => "Default Masonry",
							"fitRows"    => "Fit Rows"
						),
						"fold"		=> "shop_loop_masonry"
				);

$of_options[] = array( 	"desc" 		=> "Catalog thumbnail size<br /><small>Note: You can choose between size variants you wont to show as item thumbnail.</small>",
						"id" 		=> "shop_loop_thumb_proportional_size",
						"std" 		=> "large",
						"type" 		=> "select",
						"options" 	=> array(
							"original"   => "Original (Full size)",
							"large"      => "Large",
							"medium"     => "Medium"
						),
						"fold"		=> "shop_loop_thumb_proportional"
				);

$of_options[] = array( 	"desc" 		=> "Item thumbnail preview type<br /><small>This option is applied only if <strong>Catalog Layout</strong> option is set to <strong>Default</strong>.</small>",
						"id" 		=> "shop_item_preview_type",
						"std" 		=> "fade",
						"type" 		=> "select",
						"options" 	=> array(
							"fade"       => "Second Image on Hover",
							"gallery"    => "Product Gallery Slider",
							"none"       => "None"
						)
				);

$of_options[] = array( 	"desc" 		=> "Shop sidebar visibility<br /><small>Select whether you want to show sidebar on shop show no sidebar.</small>",
						"id" 		=> "shop_sidebar",
						"std" 		=> "hide",
						"type" 		=> "select",
						"options" 	=> $show_sidebar_options
				);

$of_options[] = array( 	"name" 		=> "<span>Single Page</span> Product Details",
						"desc" 		=> "",
						"id" 		=> "shop_single_product_images_layout",
						"std" 		=> 'default',
						"options"	=> array(
							'default'        => THEMEASSETS . 'images/admin/shop-single-product-image-layout-default.png',
							'plain'          => THEMEASSETS . 'images/admin/shop-single-product-image-layout-plain.png',
							'plain-sticky'   => THEMEASSETS . 'images/admin/shop-single-product-image-layout-plain-sticky.png',
						),
						"descrs"	=> array(
							"default"        => "Main Image with Thumbnails Below",
							"plain"          => "Plain Images List",
							"plain-sticky"   => "Plain Images List with Sticky Description"
						),
						"type" 		=> "images"
				);

$of_options[] = array( "desc" 		=> "Enable product sharing on popular social networks",
						"id" 		=> "shop_single_share_product",
						"std" 		=> 1,
						"type" 		=> "checkbox",
						"folds"		=> 1
				);

$of_options[] = array( 	"desc" 		=> "Product Images Column Size<br /><small>Note: Set the size for product images container.</small>",
						"id" 		=> "shop_single_image_column_size",
						"std" 		=> "medium",
						"type" 		=> "select",
						"options" 	=> array(
							"small"   => "Small (4/12)",
							"medium"  => "Medium (5/12)",
							"large"  => "Large (6/12)",
							"xlarge"  => "Extra Large (8/12)",
						)
				);

$of_options[] = array( 	"desc" 		=> "Product Images Alignment<br /><small>Note: Set product images container alignment – left or right.</small>",
						"id" 		=> "shop_single_image_alignment",
						"std" 		=> "left",
						"type" 		=> "select",
						"options" 	=> array(
							"left"   => "Left",
							"right"  => "Right"
						)
				);

$of_options[] = array( 	"desc" 		=> "Product Image Size<br /><small>Note: Default WooCommerce image dimensions will be applied until you choose different image size.</small>",
						"id" 		=> "shop_single_image_size",
						"std" 		=> "default",
						"type" 		=> "select",
						"options" 	=> array(
							"default"    => "WooCommerce Default",
							"large"      => "Large",
							"full"       => "Original (Full size)",
						)
				);

$of_options[] = array( 	"desc" 		=> "Auto-Rotate Product Images<br><small>Note: Unit is seconds, default value is <strong>5</strong> seconds, enter <strong>0</strong> to disable auto-rotation.</small>",
						"id" 		=> "shop_single_auto_rotate_image",
						"std" 		=> "",
						"plc"		=> "Default value: 5",
						"type" 		=> "text"
				);

$of_options[] = array( 	"desc" 		=> "Rating Style<br /><small>Note: Select rating style to show for products.</small>",
						"id" 		=> "shop_single_rating_style",
						"std" 		=> "circles",
						"type" 		=> "select",
						"options" 	=> array(
							"stars"      => "Stars",
							"circles"    => "Circles",
							"rectangles" => "Rectangles"
						)
				);

$of_options[] = array( 	"desc" 		=> "Related Products Count<br><small>Note: Number of related products shown on single product page.</small>",
						"id" 		=> "shop_related_products_per_page",
						"std" 		=> 4,
						"type" 		=> "select",
						"options" 	=> range(12, 0)
				);

$share_product_networks = array(
			"visible" => array (
				"placebo"	=> "placebo",
				"fb"   	 	=> "Facebook",
				"tw"   	 	=> "Twitter",
				"gp"       	=> "Google Plus",
				"pi"        => "Pinterest",
				"em"       	=> "Email",
			),

			"hidden" => array (
				"placebo"   => "placebo",
				"lin"       => "LinkedIn",
				"tlr"       => "Tumblr",
			),
);

$of_options[] = array( 	"desc" 		=> "Share Product Networks<br><small>Note: Select social networks that you allow users to share the products of your shop</small>",
						"id" 		=> "shop_share_product_networks",
						"std" 		=> $share_product_networks,
						"type" 		=> "sorter",
						"options" 	=> array(
							'rows-1' => "1 row",
							'rows-2' => "2 rows",
						),
						"fold"		=> "shop_single_share_product"
				);

$shop_columns_count = array(
	"two"    => "2 products per row",
	"three"  => "3 products per row",
	"four"   => "4 products per row",
	"decide" => "Decide when sidebar is present"
);

function lab_wc_product_categories_name_replace($item)
{
	return str_replace( 'products per row', 'categories per row', $item);
}

$of_options[] = array( 	"name" 		=> "Product Categories",
						"desc" 		=> "Set number of columns for product categories",
						"id" 		=> "shop_category_columns",
						"std" 		=> "decide",
						"options"	=> array_map( 'lab_wc_product_categories_name_replace', $shop_columns_count ),
						"type" 		=> "select"
				);

$of_options[] = array( 	"desc" 		=> "Category Image Size <br /><small>If you change dimensions you must <a href=\"admin.php?page=laborator_docs#regenerate-thumbnails\">regenerate thumbnails</a>.</small>",
						"id" 		=> "shop_category_image_size",
						"std" 		=> "",
						"plc"		=> "Default: 500x290",
						"type" 		=> "text"
				);

$of_options[] = array( 	"name" 		=> "Mini Cart",
						"desc" 		=> "Show cart icon in menu",
						"id" 		=> "shop_cart_icon_menu",
						"std" 		=> 0,
						"type" 		=> "checkbox",
						"folds"		=> 1
				);

$of_options[] = array( 	"desc" 		=> "Items count indicator",
						"id" 		=> "shop_cart_icon_menu_count",
						"std" 		=> 1,
						"type" 		=> "checkbox",
						"fold"		=> "shop_cart_icon_menu"
				);

$of_options[] = array( 	"desc" 		=> "Hide cart icon when its empty",
						"id" 		=> "shop_cart_icon_menu_hide_empty",
						"std" 		=> 0,
						"type" 		=> "checkbox",
						"fold"		=> "shop_cart_icon_menu"
				);

$of_options[] = array( 	"desc" 		=> "AJAX mode (load data after page is loaded)",
						"id" 		=> "shop_cart_icon_menu_ajax",
						"std" 		=> 0,
						"type" 		=> "checkbox",
						"fold"		=> "shop_cart_icon_menu"
				);

$of_options[] = array( 	"desc" 		=> "Mini cart contents popup<br><small>Note: Cart popup contains items current items in the cart, Checkout and Cart url.</small>",
						"id" 		=> "shop_cart_contents",
						"std" 		=> "click",
						"type" 		=> "select",
						"options" 	=> array(
							'hide' => "Do not show cart contents popup",
							'show-on-click' => "Show cart contents on click",
							'show-on-hover' => "Show cart contents on hover",
						),
						"fold"		=> "shop_cart_icon_menu"
				);

$of_options[] = array( 	"desc" 		=> "Cart Icon <br /><small>Select cart icon you want to display in the menu</small>",
						"id" 		=> "shop_cart_icon",
						"std" 		=> 'ecommerce-cart-content',
						"options"	=> array(							
							'ecommerce-cart-content' => THEMEASSETS . 'images/admin/cart-menu-icon-1.png',
							'ecommerce-bag'          => THEMEASSETS . 'images/admin/cart-menu-icon-2.png',
							'ecommerce-basket'       => THEMEASSETS . 'images/admin/cart-menu-icon-3.png',
						),
						"type" 		=> "images",
						"fold"		=> "shop_cart_icon_menu"
				);

$of_options[] = array( 	"name" 		=> "Product Columns &amp; Rows",
						"desc" 		=> "Products per page<br /><small>Number of rows is calculated with number of columns and provides the total products per page.</small>",
						"id" 		=> "shop_products_per_page",
						"std" 		=> 'rows-4',
						"type" 		=> "select",
						"options" 	=> array(
							'rows-1' => "1 row",
							'rows-2' => "2 rows",
							'rows-3' => "3 rows",
							'rows-4' => "4 rows",
							'rows-5' => "5 rows",
							'rows-6' => "6 rows",
							'rows-7' => "7 rows",
							'rows-8' => "8 rows",
							'rows-9' => "9 rows",
							'rows-10'=> "10 rows",
						)
				);

$of_options[] = array( 	"desc" 		=> "Set how many products per row you want to display<br /><small>If you choose <strong>Decide when sidebar is present</strong> will switch to 3 columns of products when sidebar is present otherwise it shows 4 products per row.</small>",
						"id" 		=> "shop_product_columns",
						"std" 		=> "decide",
						"type" 		=> "select",
						"options" 	=> $shop_columns_count
				);
				

$of_options[] = array( 	"name" 		=> "Pagination",
					 	"desc" 		=> "Select pagination type",
						"id" 		=> "shop_pagination_type",
						"std" 		=> "normal",
						"type" 		=> "select",
						"options" 	=> array(
							"normal"         => "Normal Pagination",
							"endless"        => "Endless Scroll",
							"endless-reveal" => "Endless Scroll + Auto Reveal"
						)
				);

$of_options[] = array( 	"desc" 		=> "Pagination style for endless scroll while loading",
						"id" 		=> "shop_endless_pagination_style",
						"std" 		=> "_1",
						"type" 		=> "select",
						"options" 	=> $endless_pagination_style
				);

$of_options[] = array( 	"desc" 		=> "Set pagination position",
						"id" 		=> "shop_pagination_position",
						"std" 		=> "center",
						"type" 		=> "select",
						"options" 	=> array("left" => "Left", "center" => "Center", "right" => "Right")
				);
				

if( defined( 'WC_INSTALLED' ) )
{					
	$shop_catalog_image_size        = get_option( 'shop_catalog_image_size' );
	$shop_single_image_size         = get_option( 'shop_single_image_size' );
	$shop_thumbnail_image_size      = get_option( 'shop_thumbnail_image_size' );
	$woocommerce_enable_lightbox    = get_option( 'woocommerce_enable_lightbox' );
	
	if( is_array( $shop_catalog_image_size ) )
	{
		$shop_catalog_image_size = $shop_catalog_image_size['width'] . 'x' . $shop_catalog_image_size['height'] . ($shop_catalog_image_size['crop'] ? ' (Cropped)' : '');
	}
	
	if( is_array( $shop_single_image_size ) )
	{
		$shop_single_image_size = $shop_single_image_size['width'] . 'x' . $shop_single_image_size['height'] . ($shop_single_image_size['crop'] ? ' (Cropped)' : '');
	}
	
	if( is_array( $shop_thumbnail_image_size ) )
	{
		$shop_thumbnail_image_size = $shop_thumbnail_image_size['width'] . 'x' . $shop_thumbnail_image_size['height'] . ($shop_thumbnail_image_size['crop'] ? ' (Cropped)' : '');
	}
	
	$of_options[] = array( 	"name" 		=> "Image Dimensions Info",
							"desc" 		=> "",
							"id" 		=> "shop_image_dimensions_info",
							"std" 		=> "<h3 style=\"margin: 0 0 10px;\">Shop Image Dimensions</h3>
							<p>
								Here are the current image dimensions being used for shop images:
								<span style='display:block; height: 10px;'></span>
								<span class='shop-imgd-info'>
									<em>Catalog Image Size:</em>
									<strong>{$shop_catalog_image_size}</strong>
								</span>
								
								<span class='shop-imgd-info'>
									<em>Single Image Size:</em>
									<strong>{$shop_single_image_size}</strong>
								</span class='shop-imgd-info'>
								
								<span class='shop-imgd-info'>
									<em>Thumbnail Image Size:</em>
									<strong>{$shop_thumbnail_image_size}</strong>
								</span>
								
								<span class='shop-imgd-info'>
									<em>Lightbox Status:</em>
									<strong>".($woocommerce_enable_lightbox ? 'Enabled <abbr title="This theme already has a built-in lightbox">(Not recommended)</abbr>' : 'Disabled')."</strong>
								</span>
								
								<br>
								
								Note: After changing image dimensions (or importing demo shop content) you may need to <a href=\"http://wordpress.org/extend/plugins/regenerate-thumbnails/\" target=\"_blank\">regenerate your thumbnails</a>.
							</p>
							<a href=\"".admin_url( 'admin.php?page=wc-settings&tab=products&section=display' ) ."\" class=\"button button-inline button-small\">Edit WooCommerce Image Settings</a> 
							<a href=\"#\" id=\"restore-default-shop-image-dimensions\" class=\"button button-inline button-small button-primary\"><span class=\"loading-spinner\"><i class=\"fa fa-circle-o-notch fa-spin\"></i></span> <em data-success=\"Image dimensions have been reset\">Restore Default Image Dimensions</em></a>",
							"icon" 		=> true,
							"type" 		=> "info"
					);
}
/*

$of_options[] = array( 	"desc" 		=> "Sidebar visibility (single page)",
						"id" 		=> "shop_single_sidebar",
						"std" 		=> "hide",
						"type" 		=> "select",
						"options" 	=> $show_sidebar_options
				);

$of_options[] = array( 	//"name" 		=> "Footer Sidebar Columns",
					 	"desc" 		=> "Set the number of columns to show in <strong>footer</strong> sidebar",
						"id" 		=> "shop_sidebar_footer_columns",
						"std" 		=> "4",
						"type" 		=> "select",
						"options" 	=> array("2", "3", "4"),
						"fold"		=> "shop_sidebar_footer"
				);

$of_options[] = array( 	"desc" 		=> "Show <strong>footer</strong> sidebar",
						"id" 		=> "shop_sidebar_footer",
						"std" 		=> 0,
						"type" 		=> "checkbox",
						"folds"		=> 1
				);


$of_options[] = array( 	"name" 		=> "Single Item Settings",
						"desc" 		=> "Show <strong>sale</strong> badge (single page)",
						"id" 		=> "shop_single_sale_ribbon_show",
						"std" 		=> 1,
						"type" 		=> "checkbox"
				);

$of_options[] = array( 	"desc" 		=> "Show <strong>out of stock</strong> badge (single page)",
						"id" 		=> "shop_single_oos_ribbon_show",
						"std" 		=> 1,
						"type" 		=> "checkbox"
				);

$of_options[] = array( 	"desc" 		=> "Show <strong>featured</strong> badge (single page)",
						"id" 		=> "shop_single_featured_ribbon_show",
						"std" 		=> 1,
						"type" 		=> "checkbox"
				);

$of_options[] = array( 	"desc" 		=> "Product <strong>Next-Prev</strong> navigation",
						"id" 		=> "shop_single_next_prev",
						"std" 		=> 1,
						"type" 		=> "checkbox"
				);

$of_options[] = array( 	"desc" 		=> "Show product <strong>rating</strong> (below title)",
						"id" 		=> "shop_single_rating",
						"std" 		=> 1,
						"type" 		=> "checkbox"
				);

$of_options[] = array( 	"desc" 		=> "Show product category (below title)",
						"id" 		=> "shop_single_product_category",
						"std" 		=> 1,
						"type" 		=> "checkbox"
				);

$of_options[] = array( 	"desc" 		=> "Product meta (id, sku, category and tags)",
						"id" 		=> "shop_single_meta_show",
						"std" 		=> 1,
						"type" 		=> "checkbox"
				);

$of_options[] = array( 	"desc" 		=> "Product image size. <br /><small>If you change dimensions you must <a href=\"admin.php?page=laborator_docs#regenerate-thumbnails\">regenerate thumbnails</a>.</small>",
						"id" 		=> "shop_single_image_size",
						"std" 		=> "",
						"plc"		=> "Default: 555x710",
						"type" 		=> "text"
				);

$of_options[] = array( 	"desc" 		=> "Auto rotate product images",
						"id" 		=> "shop_single_auto_rotate_image",
						"std" 		=> "",
						"plc"		=> "Default: 5 (seconds) - 0 to disable",
						"type" 		=> "text"
				);

$of_options[] = array( 	"desc" 		=> "Product aside thumbnails to show (they will be splitted)",
						"id" 		=> "shop_single_aside_thumbnails_count",
						"std" 		=> 5,
						"type" 		=> "select",
						"options" 	=> range(1, 10)
				);


$of_options[] = array( 	"name" 		=> "Share Product Networks",
						"desc" 		=> "Select social networks that you allow users to share the products of your shop",
						"id" 		=> "shop_share_product_networks",
						"std" 		=> $share_product_networks,
						"type" 		=> "sorter",
						"fold"		=> "shop_share_product"
				);

$of_options[] = array( 	"name"		=> "Category Settings",
						"desc" 		=> "Category columns per row",
						"id" 		=> "shop_category_columns",
						"std" 		=> 4,
						"type" 		=> "select",
						"options" 	=> range(2, 4)
				);

$of_options[] = array( 	"desc" 		=> "Show items count for category (category page)",
						"id" 		=> "shop_category_count",
						"std" 		=> 1,
						"type" 		=> "checkbox"
				);
*/
// END OF SHOP SETTINGS


// OTHER SETTINGS
$of_options[] = array( 	"name" 		=> "Other Settings",
						"type" 		=> "heading",
						"icon"		=> "fa fa-gears"
				);

$post_types_obj = get_post_types(array('_builtin' => false, 'publicly_queryable' => true, 'exclude_from_search' => false), 'objects');

$post_types = array();

$post_types['post'] = __('Posts', TD);
$post_types['page'] = __('Pages', TD);

foreach($post_types_obj as $pt => $obj)
{
	$post_types[$pt] = $obj->labels->name;
}


$of_options[] = array( 	"name"		=> "Search Results",
						"desc" 		=> "Select allowed post types in search results",
						"id" 		=> "search_post_types",
						"std" 		=> array('post', 'page', 'product'),
						"type" 		=> "multicheck",
						"options" 	=> $post_types
				);

$of_options[] = array(	"name"		=> "Google Theme Color",
						"desc"   	=> "Applied only on mobile devices, <a href=\"http://updates.html5rocks.com/2014/11/Support-for-theme-color-in-Chrome-39-for-Android\" target=\"_blank\">click here</a> to learn more about this",
						"id"   		=> "google_theme_color",
						"std"   	=> '',
						"type"   	=> "color",
					);
// END OF OTHER SETTINGS


$fonts_list = array(
	"ABeeZee" => "ABeeZee",
	"Abel" => "Abel",
	"Abril Fatface" => "Abril Fatface",
	"Aclonica" => "Aclonica",
	"Acme" => "Acme",
	"Actor" => "Actor",
	"Adamina" => "Adamina",
	"Advent Pro" => "Advent Pro",
	"Aguafina Script" => "Aguafina Script",
	"Akronim" => "Akronim",
	"Aladin" => "Aladin",
	"Aldrich" => "Aldrich",
	"Alef" => "Alef",
	"Alegreya" => "Alegreya",
	"Alegreya SC" => "Alegreya SC",
	"Alegreya Sans" => "Alegreya Sans",
	"Alegreya Sans SC" => "Alegreya Sans SC",
	"Alex Brush" => "Alex Brush",
	"Alfa Slab One" => "Alfa Slab One",
	"Alice" => "Alice",
	"Alike" => "Alike",
	"Alike Angular" => "Alike Angular",
	"Allan" => "Allan",
	"Allerta" => "Allerta",
	"Allerta Stencil" => "Allerta Stencil",
	"Allura" => "Allura",
	"Almendra" => "Almendra",
	"Almendra Display" => "Almendra Display",
	"Almendra SC" => "Almendra SC",
	"Amarante" => "Amarante",
	"Amaranth" => "Amaranth",
	"Amatic SC" => "Amatic SC",
	"Amethysta" => "Amethysta",
	"Anaheim" => "Anaheim",
	"Andada" => "Andada",
	"Andika" => "Andika",
	"Angkor" => "Angkor",
	"Annie Use Your Telescope" => "Annie Use Your Telescope",
	"Anonymous Pro" => "Anonymous Pro",
	"Antic" => "Antic",
	"Antic Didone" => "Antic Didone",
	"Antic Slab" => "Antic Slab",
	"Anton" => "Anton",
	"Arapey" => "Arapey",
	"Arbutus" => "Arbutus",
	"Arbutus Slab" => "Arbutus Slab",
	"Architects Daughter" => "Architects Daughter",
	"Archivo Black" => "Archivo Black",
	"Archivo Narrow" => "Archivo Narrow",
	"Arimo" => "Arimo",
	"Arizonia" => "Arizonia",
	"Armata" => "Armata",
	"Artifika" => "Artifika",
	"Arvo" => "Arvo",
	"Asap" => "Asap",
	"Asset" => "Asset",
	"Astloch" => "Astloch",
	"Asul" => "Asul",
	"Atomic Age" => "Atomic Age",
	"Aubrey" => "Aubrey",
	"Audiowide" => "Audiowide",
	"Autour One" => "Autour One",
	"Average" => "Average",
	"Average Sans" => "Average Sans",
	"Averia Gruesa Libre" => "Averia Gruesa Libre",
	"Averia Libre" => "Averia Libre",
	"Averia Sans Libre" => "Averia Sans Libre",
	"Averia Serif Libre" => "Averia Serif Libre",
	"Bad Script" => "Bad Script",
	"Balthazar" => "Balthazar",
	"Bangers" => "Bangers",
	"Basic" => "Basic",
	"Battambang" => "Battambang",
	"Baumans" => "Baumans",
	"Bayon" => "Bayon",
	"Belgrano" => "Belgrano",
	"Belleza" => "Belleza",
	"BenchNine" => "BenchNine",
	"Bentham" => "Bentham",
	"Berkshire Swash" => "Berkshire Swash",
	"Bevan" => "Bevan",
	"Bigelow Rules" => "Bigelow Rules",
	"Bigshot One" => "Bigshot One",
	"Bilbo" => "Bilbo",
	"Bilbo Swash Caps" => "Bilbo Swash Caps",
	"Bitter" => "Bitter",
	"Black Ops One" => "Black Ops One",
	"Bokor" => "Bokor",
	"Bonbon" => "Bonbon",
	"Boogaloo" => "Boogaloo",
	"Bowlby One" => "Bowlby One",
	"Bowlby One SC" => "Bowlby One SC",
	"Brawler" => "Brawler",
	"Bree Serif" => "Bree Serif",
	"Bubblegum Sans" => "Bubblegum Sans",
	"Bubbler One" => "Bubbler One",
	"Buda" => "Buda",
	"Buenard" => "Buenard",
	"Butcherman" => "Butcherman",
	"Butterfly Kids" => "Butterfly Kids",
	"Cabin" => "Cabin",
	"Cabin Condensed" => "Cabin Condensed",
	"Cabin Sketch" => "Cabin Sketch",
	"Caesar Dressing" => "Caesar Dressing",
	"Cagliostro" => "Cagliostro",
	"Calligraffitti" => "Calligraffitti",
	"Cambo" => "Cambo",
	"Candal" => "Candal",
	"Cantarell" => "Cantarell",
	"Cantata One" => "Cantata One",
	"Cantora One" => "Cantora One",
	"Capriola" => "Capriola",
	"Cardo" => "Cardo",
	"Carme" => "Carme",
	"Carrois Gothic" => "Carrois Gothic",
	"Carrois Gothic SC" => "Carrois Gothic SC",
	"Carter One" => "Carter One",
	"Caudex" => "Caudex",
	"Cedarville Cursive" => "Cedarville Cursive",
	"Ceviche One" => "Ceviche One",
	"Changa One" => "Changa One",
	"Chango" => "Chango",
	"Chau Philomene One" => "Chau Philomene One",
	"Chela One" => "Chela One",
	"Chelsea Market" => "Chelsea Market",
	"Chenla" => "Chenla",
	"Cherry Cream Soda" => "Cherry Cream Soda",
	"Cherry Swash" => "Cherry Swash",
	"Chewy" => "Chewy",
	"Chicle" => "Chicle",
	"Chivo" => "Chivo",
	"Cinzel" => "Cinzel",
	"Cinzel Decorative" => "Cinzel Decorative",
	"Clicker Script" => "Clicker Script",
	"Coda" => "Coda",
	"Coda Caption" => "Coda Caption",
	"Codystar" => "Codystar",
	"Combo" => "Combo",
	"Comfortaa" => "Comfortaa",
	"Coming Soon" => "Coming Soon",
	"Concert One" => "Concert One",
	"Condiment" => "Condiment",
	"Content" => "Content",
	"Contrail One" => "Contrail One",
	"Convergence" => "Convergence",
	"Cookie" => "Cookie",
	"Copse" => "Copse",
	"Corben" => "Corben",
	"Courgette" => "Courgette",
	"Cousine" => "Cousine",
	"Coustard" => "Coustard",
	"Covered By Your Grace" => "Covered By Your Grace",
	"Crafty Girls" => "Crafty Girls",
	"Creepster" => "Creepster",
	"Crete Round" => "Crete Round",
	"Crimson Text" => "Crimson Text",
	"Croissant One" => "Croissant One",
	"Crushed" => "Crushed",
	"Cuprum" => "Cuprum",
	"Cutive" => "Cutive",
	"Cutive Mono" => "Cutive Mono",
	"Damion" => "Damion",
	"Dancing Script" => "Dancing Script",
	"Dangrek" => "Dangrek",
	"Dawning of a New Day" => "Dawning of a New Day",
	"Days One" => "Days One",
	"Delius" => "Delius",
	"Delius Swash Caps" => "Delius Swash Caps",
	"Delius Unicase" => "Delius Unicase",
	"Della Respira" => "Della Respira",
	"Denk One" => "Denk One",
	"Devonshire" => "Devonshire",
	"Dhurjati" => "Dhurjati",
	"Didact Gothic" => "Didact Gothic",
	"Diplomata" => "Diplomata",
	"Diplomata SC" => "Diplomata SC",
	"Domine" => "Domine",
	"Donegal One" => "Donegal One",
	"Doppio One" => "Doppio One",
	"Dorsa" => "Dorsa",
	"Dosis" => "Dosis",
	"Dr Sugiyama" => "Dr Sugiyama",
	"Droid Sans" => "Droid Sans",
	"Droid Sans Mono" => "Droid Sans Mono",
	"Droid Serif" => "Droid Serif",
	"Duru Sans" => "Duru Sans",
	"Dynalight" => "Dynalight",
	"EB Garamond" => "EB Garamond",
	"Eagle Lake" => "Eagle Lake",
	"Eater" => "Eater",
	"Economica" => "Economica",
	"Ek Mukta" => "Ek Mukta",
	"Electrolize" => "Electrolize",
	"Elsie" => "Elsie",
	"Elsie Swash Caps" => "Elsie Swash Caps",
	"Emblema One" => "Emblema One",
	"Emilys Candy" => "Emilys Candy",
	"Engagement" => "Engagement",
	"Englebert" => "Englebert",
	"Enriqueta" => "Enriqueta",
	"Erica One" => "Erica One",
	"Esteban" => "Esteban",
	"Euphoria Script" => "Euphoria Script",
	"Ewert" => "Ewert",
	"Exo" => "Exo",
	"Exo 2" => "Exo 2",
	"Expletus Sans" => "Expletus Sans",
	"Fanwood Text" => "Fanwood Text",
	"Fascinate" => "Fascinate",
	"Fascinate Inline" => "Fascinate Inline",
	"Faster One" => "Faster One",
	"Fasthand" => "Fasthand",
	"Fauna One" => "Fauna One",
	"Federant" => "Federant",
	"Federo" => "Federo",
	"Felipa" => "Felipa",
	"Fenix" => "Fenix",
	"Finger Paint" => "Finger Paint",
	"Fira Mono" => "Fira Mono",
	"Fira Sans" => "Fira Sans",
	"Fjalla One" => "Fjalla One",
	"Fjord One" => "Fjord One",
	"Flamenco" => "Flamenco",
	"Flavors" => "Flavors",
	"Fondamento" => "Fondamento",
	"Fontdiner Swanky" => "Fontdiner Swanky",
	"Forum" => "Forum",
	"Francois One" => "Francois One",
	"Freckle Face" => "Freckle Face",
	"Fredericka the Great" => "Fredericka the Great",
	"Fredoka One" => "Fredoka One",
	"Freehand" => "Freehand",
	"Fresca" => "Fresca",
	"Frijole" => "Frijole",
	"Fruktur" => "Fruktur",
	"Fugaz One" => "Fugaz One",
	"GFS Didot" => "GFS Didot",
	"GFS Neohellenic" => "GFS Neohellenic",
	"Gabriela" => "Gabriela",
	"Gafata" => "Gafata",
	"Galdeano" => "Galdeano",
	"Galindo" => "Galindo",
	"Gentium Basic" => "Gentium Basic",
	"Gentium Book Basic" => "Gentium Book Basic",
	"Geo" => "Geo",
	"Geostar" => "Geostar",
	"Geostar Fill" => "Geostar Fill",
	"Germania One" => "Germania One",
	"Gidugu" => "Gidugu",
	"Gilda Display" => "Gilda Display",
	"Give You Glory" => "Give You Glory",
	"Glass Antiqua" => "Glass Antiqua",
	"Glegoo" => "Glegoo",
	"Gloria Hallelujah" => "Gloria Hallelujah",
	"Goblin One" => "Goblin One",
	"Gochi Hand" => "Gochi Hand",
	"Gorditas" => "Gorditas",
	"Goudy Bookletter 1911" => "Goudy Bookletter 1911",
	"Graduate" => "Graduate",
	"Grand Hotel" => "Grand Hotel",
	"Gravitas One" => "Gravitas One",
	"Great Vibes" => "Great Vibes",
	"Griffy" => "Griffy",
	"Gruppo" => "Gruppo",
	"Gudea" => "Gudea",
	"Habibi" => "Habibi",
	"Halant" => "Halant",
	"Hammersmith One" => "Hammersmith One",
	"Hanalei" => "Hanalei",
	"Hanalei Fill" => "Hanalei Fill",
	"Handlee" => "Handlee",
	"Hanuman" => "Hanuman",
	"Happy Monkey" => "Happy Monkey",
	"Headland One" => "Headland One",
	"Henny Penny" => "Henny Penny",
	"Herr Von Muellerhoff" => "Herr Von Muellerhoff",
	"Hind" => "Hind",
	"Holtwood One SC" => "Holtwood One SC",
	"Homemade Apple" => "Homemade Apple",
	"Homenaje" => "Homenaje",
	"IM Fell DW Pica" => "IM Fell DW Pica",
	"IM Fell DW Pica SC" => "IM Fell DW Pica SC",
	"IM Fell Double Pica" => "IM Fell Double Pica",
	"IM Fell Double Pica SC" => "IM Fell Double Pica SC",
	"IM Fell English" => "IM Fell English",
	"IM Fell English SC" => "IM Fell English SC",
	"IM Fell French Canon" => "IM Fell French Canon",
	"IM Fell French Canon SC" => "IM Fell French Canon SC",
	"IM Fell Great Primer" => "IM Fell Great Primer",
	"IM Fell Great Primer SC" => "IM Fell Great Primer SC",
	"Iceberg" => "Iceberg",
	"Iceland" => "Iceland",
	"Imprima" => "Imprima",
	"Inconsolata" => "Inconsolata",
	"Inder" => "Inder",
	"Indie Flower" => "Indie Flower",
	"Inika" => "Inika",
	"Irish Grover" => "Irish Grover",
	"Istok Web" => "Istok Web",
	"Italiana" => "Italiana",
	"Italianno" => "Italianno",
	"Jacques Francois" => "Jacques Francois",
	"Jacques Francois Shadow" => "Jacques Francois Shadow",
	"Jim Nightshade" => "Jim Nightshade",
	"Jockey One" => "Jockey One",
	"Jolly Lodger" => "Jolly Lodger",
	"Josefin Sans" => "Josefin Sans",
	"Josefin Slab" => "Josefin Slab",
	"Joti One" => "Joti One",
	"Judson" => "Judson",
	"Julee" => "Julee",
	"Julius Sans One" => "Julius Sans One",
	"Junge" => "Junge",
	"Jura" => "Jura",
	"Just Another Hand" => "Just Another Hand",
	"Just Me Again Down Here" => "Just Me Again Down Here",
	"Kalam" => "Kalam",
	"Kameron" => "Kameron",
	"Kantumruy" => "Kantumruy",
	"Karla" => "Karla",
	"Karma" => "Karma",
	"Kaushan Script" => "Kaushan Script",
	"Kavoon" => "Kavoon",
	"Kdam Thmor" => "Kdam Thmor",
	"Keania One" => "Keania One",
	"Kelly Slab" => "Kelly Slab",
	"Kenia" => "Kenia",
	"Khand" => "Khand",
	"Khmer" => "Khmer",
	"Kite One" => "Kite One",
	"Knewave" => "Knewave",
	"Kotta One" => "Kotta One",
	"Koulen" => "Koulen",
	"Kranky" => "Kranky",
	"Kreon" => "Kreon",
	"Kristi" => "Kristi",
	"Krona One" => "Krona One",
	"La Belle Aurore" => "La Belle Aurore",
	"Laila" => "Laila",
	"Lancelot" => "Lancelot",
	"Lato" => "Lato",
	"League Script" => "League Script",
	"Leckerli One" => "Leckerli One",
	"Ledger" => "Ledger",
	"Lekton" => "Lekton",
	"Lemon" => "Lemon",
	"Libre Baskerville" => "Libre Baskerville",
	"Life Savers" => "Life Savers",
	"Lilita One" => "Lilita One",
	"Lily Script One" => "Lily Script One",
	"Limelight" => "Limelight",
	"Linden Hill" => "Linden Hill",
	"Lobster" => "Lobster",
	"Lobster Two" => "Lobster Two",
	"Londrina Outline" => "Londrina Outline",
	"Londrina Shadow" => "Londrina Shadow",
	"Londrina Sketch" => "Londrina Sketch",
	"Londrina Solid" => "Londrina Solid",
	"Lora" => "Lora",
	"Love Ya Like A Sister" => "Love Ya Like A Sister",
	"Loved by the King" => "Loved by the King",
	"Lovers Quarrel" => "Lovers Quarrel",
	"Luckiest Guy" => "Luckiest Guy",
	"Lusitana" => "Lusitana",
	"Lustria" => "Lustria",
	"Macondo" => "Macondo",
	"Macondo Swash Caps" => "Macondo Swash Caps",
	"Magra" => "Magra",
	"Maiden Orange" => "Maiden Orange",
	"Mako" => "Mako",
	"Mallanna" => "Mallanna",
	"Mandali" => "Mandali",
	"Marcellus" => "Marcellus",
	"Marcellus SC" => "Marcellus SC",
	"Marck Script" => "Marck Script",
	"Margarine" => "Margarine",
	"Marko One" => "Marko One",
	"Marmelad" => "Marmelad",
	"Marvel" => "Marvel",
	"Mate" => "Mate",
	"Mate SC" => "Mate SC",
	"Maven Pro" => "Maven Pro",
	"McLaren" => "McLaren",
	"Meddon" => "Meddon",
	"MedievalSharp" => "MedievalSharp",
	"Medula One" => "Medula One",
	"Megrim" => "Megrim",
	"Meie Script" => "Meie Script",
	"Merienda" => "Merienda",
	"Merienda One" => "Merienda One",
	"Merriweather" => "Merriweather",
	"Merriweather Sans" => "Merriweather Sans",
	"Metal" => "Metal",
	"Metal Mania" => "Metal Mania",
	"Metamorphous" => "Metamorphous",
	"Metrophobic" => "Metrophobic",
	"Michroma" => "Michroma",
	"Milonga" => "Milonga",
	"Miltonian" => "Miltonian",
	"Miltonian Tattoo" => "Miltonian Tattoo",
	"Miniver" => "Miniver",
	"Miss Fajardose" => "Miss Fajardose",
	"Modern Antiqua" => "Modern Antiqua",
	"Molengo" => "Molengo",
	"Molle" => "Molle",
	"Monda" => "Monda",
	"Monofett" => "Monofett",
	"Monoton" => "Monoton",
	"Monsieur La Doulaise" => "Monsieur La Doulaise",
	"Montaga" => "Montaga",
	"Montez" => "Montez",
	"Montserrat" => "Montserrat",
	"Montserrat Alternates" => "Montserrat Alternates",
	"Montserrat Subrayada" => "Montserrat Subrayada",
	"Moul" => "Moul",
	"Moulpali" => "Moulpali",
	"Mountains of Christmas" => "Mountains of Christmas",
	"Mouse Memoirs" => "Mouse Memoirs",
	"Mr Bedfort" => "Mr Bedfort",
	"Mr Dafoe" => "Mr Dafoe",
	"Mr De Haviland" => "Mr De Haviland",
	"Mrs Saint Delafield" => "Mrs Saint Delafield",
	"Mrs Sheppards" => "Mrs Sheppards",
	"Muli" => "Muli",
	"Mystery Quest" => "Mystery Quest",
	"NTR" => "NTR",
	"Neucha" => "Neucha",
	"Neuton" => "Neuton",
	"New Rocker" => "New Rocker",
	"News Cycle" => "News Cycle",
	"Niconne" => "Niconne",
	"Nixie One" => "Nixie One",
	"Nobile" => "Nobile",
	"Nokora" => "Nokora",
	"Norican" => "Norican",
	"Nosifer" => "Nosifer",
	"Nothing You Could Do" => "Nothing You Could Do",
	"Noticia Text" => "Noticia Text",
	"Noto Sans" => "Noto Sans",
	"Noto Serif" => "Noto Serif",
	"Nova Cut" => "Nova Cut",
	"Nova Flat" => "Nova Flat",
	"Nova Mono" => "Nova Mono",
	"Nova Oval" => "Nova Oval",
	"Nova Round" => "Nova Round",
	"Nova Script" => "Nova Script",
	"Nova Slim" => "Nova Slim",
	"Nova Square" => "Nova Square",
	"Numans" => "Numans",
	"Nunito" => "Nunito",
	"Odor Mean Chey" => "Odor Mean Chey",
	"Offside" => "Offside",
	"Old Standard TT" => "Old Standard TT",
	"Oldenburg" => "Oldenburg",
	"Oleo Script" => "Oleo Script",
	"Oleo Script Swash Caps" => "Oleo Script Swash Caps",
	"Open Sans" => "Open Sans",
	"Open Sans Condensed" => "Open Sans Condensed",
	"Oranienbaum" => "Oranienbaum",
	"Orbitron" => "Orbitron",
	"Oregano" => "Oregano",
	"Orienta" => "Orienta",
	"Original Surfer" => "Original Surfer",
	"Oswald" => "Oswald",
	"Over the Rainbow" => "Over the Rainbow",
	"Overlock" => "Overlock",
	"Overlock SC" => "Overlock SC",
	"Ovo" => "Ovo",
	"Oxygen" => "Oxygen",
	"Oxygen Mono" => "Oxygen Mono",
	"PT Mono" => "PT Mono",
	"PT Sans" => "PT Sans",
	"PT Sans Caption" => "PT Sans Caption",
	"PT Sans Narrow" => "PT Sans Narrow",
	"PT Serif" => "PT Serif",
	"PT Serif Caption" => "PT Serif Caption",
	"Pacifico" => "Pacifico",
	"Paprika" => "Paprika",
	"Parisienne" => "Parisienne",
	"Passero One" => "Passero One",
	"Passion One" => "Passion One",
	"Pathway Gothic One" => "Pathway Gothic One",
	"Patrick Hand" => "Patrick Hand",
	"Patrick Hand SC" => "Patrick Hand SC",
	"Patua One" => "Patua One",
	"Paytone One" => "Paytone One",
	"Peralta" => "Peralta",
	"Permanent Marker" => "Permanent Marker",
	"Petit Formal Script" => "Petit Formal Script",
	"Petrona" => "Petrona",
	"Philosopher" => "Philosopher",
	"Piedra" => "Piedra",
	"Pinyon Script" => "Pinyon Script",
	"Pirata One" => "Pirata One",
	"Plaster" => "Plaster",
	"Play" => "Play",
	"Playball" => "Playball",
	"Playfair Display" => "Playfair Display",
	"Playfair Display SC" => "Playfair Display SC",
	"Podkova" => "Podkova",
	"Poiret One" => "Poiret One",
	"Poller One" => "Poller One",
	"Poly" => "Poly",
	"Pompiere" => "Pompiere",
	"Pontano Sans" => "Pontano Sans",
	"Port Lligat Sans" => "Port Lligat Sans",
	"Port Lligat Slab" => "Port Lligat Slab",
	"Prata" => "Prata",
	"Preahvihear" => "Preahvihear",
	"Press Start 2P" => "Press Start 2P",
	"Princess Sofia" => "Princess Sofia",
	"Prociono" => "Prociono",
	"Prosto One" => "Prosto One",
	"Puritan" => "Puritan",
	"Purple Purse" => "Purple Purse",
	"Quando" => "Quando",
	"Quantico" => "Quantico",
	"Quattrocento" => "Quattrocento",
	"Quattrocento Sans" => "Quattrocento Sans",
	"Questrial" => "Questrial",
	"Quicksand" => "Quicksand",
	"Quintessential" => "Quintessential",
	"Qwigley" => "Qwigley",
	"Racing Sans One" => "Racing Sans One",
	"Radley" => "Radley",
	"Rajdhani" => "Rajdhani",
	"Raleway" => "Raleway",
	"Raleway Dots" => "Raleway Dots",
	"Ramabhadra" => "Ramabhadra",
	"Rambla" => "Rambla",
	"Rammetto One" => "Rammetto One",
	"Ranchers" => "Ranchers",
	"Rancho" => "Rancho",
	"Rationale" => "Rationale",
	"Redressed" => "Redressed",
	"Reenie Beanie" => "Reenie Beanie",
	"Revalia" => "Revalia",
	"Ribeye" => "Ribeye",
	"Ribeye Marrow" => "Ribeye Marrow",
	"Righteous" => "Righteous",
	"Risque" => "Risque",
	"Roboto" => "Roboto",
	"Roboto Condensed" => "Roboto Condensed",
	"Roboto Slab" => "Roboto Slab",
	"Rochester" => "Rochester",
	"Rock Salt" => "Rock Salt",
	"Rokkitt" => "Rokkitt",
	"Romanesco" => "Romanesco",
	"Ropa Sans" => "Ropa Sans",
	"Rosario" => "Rosario",
	"Rosarivo" => "Rosarivo",
	"Rouge Script" => "Rouge Script",
	"Rozha One" => "Rozha One",
	"Rubik Mono One" => "Rubik Mono One",
	"Rubik One" => "Rubik One",
	"Ruda" => "Ruda",
	"Rufina" => "Rufina",
	"Ruge Boogie" => "Ruge Boogie",
	"Ruluko" => "Ruluko",
	"Rum Raisin" => "Rum Raisin",
	"Ruslan Display" => "Ruslan Display",
	"Russo One" => "Russo One",
	"Ruthie" => "Ruthie",
	"Rye" => "Rye",
	"Sacramento" => "Sacramento",
	"Sail" => "Sail",
	"Salsa" => "Salsa",
	"Sanchez" => "Sanchez",
	"Sancreek" => "Sancreek",
	"Sansita One" => "Sansita One",
	"Sarina" => "Sarina",
	"Sarpanch" => "Sarpanch",
	"Satisfy" => "Satisfy",
	"Scada" => "Scada",
	"Schoolbell" => "Schoolbell",
	"Seaweed Script" => "Seaweed Script",
	"Sevillana" => "Sevillana",
	"Seymour One" => "Seymour One",
	"Shadows Into Light" => "Shadows Into Light",
	"Shadows Into Light Two" => "Shadows Into Light Two",
	"Shanti" => "Shanti",
	"Share" => "Share",
	"Share Tech" => "Share Tech",
	"Share Tech Mono" => "Share Tech Mono",
	"Shojumaru" => "Shojumaru",
	"Short Stack" => "Short Stack",
	"Siemreap" => "Siemreap",
	"Sigmar One" => "Sigmar One",
	"Signika" => "Signika",
	"Signika Negative" => "Signika Negative",
	"Simonetta" => "Simonetta",
	"Sintony" => "Sintony",
	"Sirin Stencil" => "Sirin Stencil",
	"Six Caps" => "Six Caps",
	"Skranji" => "Skranji",
	"Slabo 13px" => "Slabo 13px",
	"Slabo 27px" => "Slabo 27px",
	"Slackey" => "Slackey",
	"Smokum" => "Smokum",
	"Smythe" => "Smythe",
	"Sniglet" => "Sniglet",
	"Snippet" => "Snippet",
	"Snowburst One" => "Snowburst One",
	"Sofadi One" => "Sofadi One",
	"Sofia" => "Sofia",
	"Sonsie One" => "Sonsie One",
	"Sorts Mill Goudy" => "Sorts Mill Goudy",
	"Source Code Pro" => "Source Code Pro",
	"Source Sans Pro" => "Source Sans Pro",
	"Source Serif Pro" => "Source Serif Pro",
	"Special Elite" => "Special Elite",
	"Spicy Rice" => "Spicy Rice",
	"Spinnaker" => "Spinnaker",
	"Spirax" => "Spirax",
	"Squada One" => "Squada One",
	"Stalemate" => "Stalemate",
	"Stalinist One" => "Stalinist One",
	"Stardos Stencil" => "Stardos Stencil",
	"Stint Ultra Condensed" => "Stint Ultra Condensed",
	"Stint Ultra Expanded" => "Stint Ultra Expanded",
	"Stoke" => "Stoke",
	"Strait" => "Strait",
	"Sue Ellen Francisco" => "Sue Ellen Francisco",
	"Sunshiney" => "Sunshiney",
	"Supermercado One" => "Supermercado One",
	"Suwannaphum" => "Suwannaphum",
	"Swanky and Moo Moo" => "Swanky and Moo Moo",
	"Syncopate" => "Syncopate",
	"Tangerine" => "Tangerine",
	"Taprom" => "Taprom",
	"Tauri" => "Tauri",
	"Teko" => "Teko",
	"Telex" => "Telex",
	"Tenor Sans" => "Tenor Sans",
	"Text Me One" => "Text Me One",
	"The Girl Next Door" => "The Girl Next Door",
	"Tienne" => "Tienne",
	"Tinos" => "Tinos",
	"Titan One" => "Titan One",
	"Titillium Web" => "Titillium Web",
	"Trade Winds" => "Trade Winds",
	"Trocchi" => "Trocchi",
	"Trochut" => "Trochut",
	"Trykker" => "Trykker",
	"Tulpen One" => "Tulpen One",
	"Ubuntu" => "Ubuntu",
	"Ubuntu Condensed" => "Ubuntu Condensed",
	"Ubuntu Mono" => "Ubuntu Mono",
	"Ultra" => "Ultra",
	"Uncial Antiqua" => "Uncial Antiqua",
	"Underdog" => "Underdog",
	"Unica One" => "Unica One",
	"UnifrakturCook" => "UnifrakturCook",
	"UnifrakturMaguntia" => "UnifrakturMaguntia",
	"Unkempt" => "Unkempt",
	"Unlock" => "Unlock",
	"Unna" => "Unna",
	"VT323" => "VT323",
	"Vampiro One" => "Vampiro One",
	"Varela" => "Varela",
	"Varela Round" => "Varela Round",
	"Vast Shadow" => "Vast Shadow",
	"Vesper Libre" => "Vesper Libre",
	"Vibur" => "Vibur",
	"Vidaloka" => "Vidaloka",
	"Viga" => "Viga",
	"Voces" => "Voces",
	"Volkhov" => "Volkhov",
	"Vollkorn" => "Vollkorn",
	"Voltaire" => "Voltaire",
	"Waiting for the Sunrise" => "Waiting for the Sunrise",
	"Wallpoet" => "Wallpoet",
	"Walter Turncoat" => "Walter Turncoat",
	"Warnes" => "Warnes",
	"Wellfleet" => "Wellfleet",
	"Wendy One" => "Wendy One",
	"Wire One" => "Wire One",
	"Yanone Kaffeesatz" => "Yanone Kaffeesatz",
	"Yellowtail" => "Yellowtail",
	"Yeseva One" => "Yeseva One",
	"Yesteryear" => "Yesteryear",
	"Zeyada" => "Zeyada",
);

$font_preview = array(
	"text" => "<span class=\"nums\">1234567890</span><span class=\"uppers\">ABCDEFGHIKLMNOPQRSTVXYZ</span><span class=\"lowers\">abcdefghiklmnopqrstvxyz</span>",
	"size" => "25px"
);

$font_primary_list      = array_merge(array("none" => "Use default"), $fonts_list);
$font_heading_list    = array_merge(array("none" => "Use default"), $fonts_list);

$font_weights = array(
	'' => 'Use Default',
	300, 
	400, 
	500, 
	600, 
	700, 
	'bold' => 'Bold'
);

$text_transforms = array(
	''             => 'Use Default',
	'none'         => 'None', 
	'uppercase'    => 'Upper Case', 
	'lowercase'    => 'Lower Case', 
	'capitalize'   => 'Capitalize', 
);


$of_options[] = array( 	"name" 		=> "Typography",
						"type" 		=> "heading",
						"icon"		=> "fa fa-font"
				);
				
$of_options[] = array(  "name"		=> "Use Custom Font",
						"desc"   	=> "Replace the default theme font with your preferred font",
						"id"   		=> "use_custom_font",
						"std"   	=> 0,
						"folds"  	=> 1,
						"on"  		=> "Yes",
						"off"  		=> "No",
						"type"   	=> "switch"
					);

$of_options[] = array( 	"name" 		=> "Primary Font",
						"desc" 		=> "Font type that is used for body and paragraphs",
						"id" 		=> "font_primary",
						"std" 		=> "Select a font",
						"type" 		=> "select_google_font",
						"preview" 	=> $font_preview,
						"options" 	=> $font_primary_list,
						"fold"		=> "use_custom_font"
				);

$of_options[] = array( 	"desc" 		=> "Primary font weight",
						"id" 		=> "font_primary_weight",
						"std" 		=> "",
						"type" 		=> "select",
						"options" 	=> $font_weights,
						"fold"		=> "use_custom_font"
				);

$of_options[] = array( 	"desc" 		=> "Primary font text case",
						"id" 		=> "font_primary_transform",
						"std" 		=> "",
						"type" 		=> "select",
						"options" 	=> $text_transforms,
						"fold"		=> "use_custom_font"
				);

$of_options[] = array( 	"name" 		=> "Heading Font",
						"desc" 		=> "Select main font to be used for menus and headings",
						"id" 		=> "font_heading",
						"std" 		=> "Select a font",
						"type" 		=> "select_google_font",
						"preview" 	=> $font_preview,
						"options" 	=> $font_heading_list,
						"fold"		=> "use_custom_font"
				);

$of_options[] = array( 	"desc" 		=> "Heading font weight",
						"id" 		=> "font_heading_weight",
						"std" 		=> "",
						"type" 		=> "select",
						"options" 	=> $font_weights,
						"fold"		=> "use_custom_font"
				);

$of_options[] = array( 	"desc" 		=> "Heading font text case",
						"id" 		=> "font_heading_transform",
						"std" 		=> "",
						"type" 		=> "select",
						"options" 	=> $text_transforms,
						"fold"		=> "use_custom_font"
				);

$of_options[] = array( 	"name" 		=> "Custom Fonts",
						"desc" 		=> "",
						"id" 		=> "custom_gf",
						"std" 		=> "<h3 style=\"margin: 0 0 10px;\">Including Custom Web Fonts</h3>
						If you want to add your personal font to your site (from Google Webfonts or any web font provider) you can apply the font parameters in the fields below.<br />
						Firstly include the font URL resource, then enter the name of that font (without <em>font-family:</em>) next to that field.<br />
						Otherwise, leave the field empty to use default font selected in the list above",
						"icon" 		=> true,
						"type" 		=> "info",
						"fold"		=> "use_custom_font"
				);


$of_options[] = array( 	"name" 		=> "Custom Primary Font",
						"desc" 		=> "Primary font URL",
						"id" 		=> "custom_primary_font_url",
						"std" 		=> "",
						"plc"		=> "i.e. http://fonts.googleapis.com/css?family=Oswald",
						"type" 		=> "text",
						"fold"		=> "use_custom_font"
				);


$of_options[] = array( 	"desc" 		=> "Primary font name",
						"id" 		=> "custom_primary_font_name",
						"std" 		=> "",
						"plc"		=> "'Oswald', sans-serif",
						"type" 		=> "text",
						"fold"		=> "use_custom_font"
				);

$of_options[] = array( 	"desc" 		=> "Primary font weight",
						"id" 		=> "custom_primary_font_weight",
						"std" 		=> "",
						"type" 		=> "select",
						"options" 	=> $font_weights,
						"fold"		=> "use_custom_font"
				);

$of_options[] = array( 	"desc" 		=> "Primary font text case",
						"id" 		=> "custom_primary_font_transform",
						"std" 		=> "",
						"type" 		=> "select",
						"options" 	=> $text_transforms,
						"fold"		=> "use_custom_font"
				);


$of_options[] = array( 	"name" 		=> "Custom Heading Font",
						"desc" 		=> "Heading font URL",
						"id" 		=> "custom_heading_font_url",
						"std" 		=> "",
						"plc"		=> "i.e. http://fonts.googleapis.com/css?family=Oswald",
						"type" 		=> "text",
						"fold"		=> "use_custom_font"
				);


$of_options[] = array( 	"desc" 		=> "Heading font name",
						"id" 		=> "custom_heading_font_name",
						"std" 		=> "",
						"plc"		=> "'Oswald', sans-serif",
						"type" 		=> "text",
						"fold"		=> "use_custom_font"
				);

$of_options[] = array( 	"desc" 		=> "Heading font weight",
						"id" 		=> "custom_heading_font_weight",
						"std" 		=> "",
						"type" 		=> "select",
						"options" 	=> $font_weights,
						"fold"		=> "use_custom_font"
				);

$of_options[] = array( 	"desc" 		=> "Heading font text case",
						"id" 		=> "custom_heading_font_transform",
						"std" 		=> "",
						"type" 		=> "select",
						"options" 	=> $text_transforms,
						"fold"		=> "use_custom_font"
				);
				
$of_options[] = array(  "name"		=> "Typekit Font",
						"desc"   	=> "If you want to use Typekit font, enable this setting",
						"id"   		=> "use_tykekit_font",
						"std"   	=> 0,
						"folds"  	=> 1,
						"on"  		=> "Enable",
						"off"  		=> "Disable",
						"type"   	=> "switch"
					);

$of_options[] = array( 	"desc" 		=> "Paste Typekit embed code here",
						"id" 		=> "typekit_embed_code",
						"std" 		=> "",
						"type" 		=> "textarea",
						"fold"		=> "use_tykekit_font"
				);



$of_options[] = array( 	"name" 		=> "Theme Styling",
						"type" 		=> "heading",
						"icon"		=> "fa fa-tint"
				);
				
$of_options[] = array(  "name"		=> "Custom Skin Builder",
						"desc"   	=> "Create your own skin for this theme",
						"id"   		=> "use_custom_skin",
						"std"   	=> 0,
						"folds"  	=> 1,
						"on"  		=> "Yes",
						"off"  		=> "No",
						"type"   	=> "switch"
					);

$of_options[] = array(	"name"		=> "Skin Colors",
						"desc"   	=> "Background color",
						"id"   		=> "custom_skin_bg_color",
						"std"   	=> '#FFF',
						"type"   	=> "color",
						"fold"  	=> 'use_custom_skin',
					);

$of_options[] = array(	"desc"   	=> "Link color",
						"id"   		=> "custom_skin_link_color",
						"std"   	=> '#F6364D',
						"type"   	=> "color",
						"fold"  	=> 'use_custom_skin',
					);

$of_options[] = array(	"desc"   	=> "Headings color",
						"id"   		=> "custom_skin_headings_color",
						"std"   	=> '#F6364D',
						"type"   	=> "color",
						"fold"  	=> 'use_custom_skin',
					);

$of_options[] = array(	"desc"   	=> "Paragraph color",
						"id"   		=> "custom_skin_paragraph_color",
						"std"   	=> '#777777',
						"type"   	=> "color",
						"fold"  	=> 'use_custom_skin',
					);

$of_options[] = array(	"desc"   	=> "Footer background color",
						"id"   		=> "custom_skin_footer_bg_color",
						"std"   	=> '#FAFAFA',
						"type"   	=> "color",
						"fold"  	=> 'use_custom_skin',
					);

$of_options[] = array(	"desc"   	=> "Borders color",
						"id"   		=> "custom_skin_borders_color",
						"std"   	=> '#EEEEEE',
						"type"   	=> "color",
						"fold"  	=> 'use_custom_skin',
					);
					

$of_options[] = array( 	"name" 		=> "Custom CSS",
						"desc" 		=> "",
						"id" 		=> "skin_palettes_list",
						"std" 		=> "
						<h3 style=\"margin: 0 0 10px;\">Our selection of predefined skin palettes</h3>".
						'
						<a href="#" class="skin-palette">
							<span style="background-color: #FFF;"></span>
							<span style="background-color: #F6364D;"></span>
							<span style="background-color: #F6364D;"></span>
							<span style="background-color: #777;"></span>
							<span style="background-color: #FAFAFA;"></span>
							<span style="background-color: #EEE;"></span>
							
							<em>Pink</em>
						</a>
						
						<a href="#" class="skin-palette">
							<span style="background-color: #f2f0ec;"></span>
							<span style="background-color: #e09a0e;"></span>
							<span style="background-color: #242321;"></span>
							<span style="background-color: #242321;"></span>
							<span style="background-color: #ece9e4;"></span>
							<span style="background-color: #FFF;"></span>
							
							<em>Gold</em>
						</a>
						
						<a href="#" class="skin-palette">
							<span style="background-color: #FFF;"></span>
							<span style="background-color: #a58f60;"></span>
							<span style="background-color: #222;"></span>
							<span style="background-color: #555;"></span>
							<span style="background-color: #EAEAEA;"></span>
							<span style="background-color: #EEE;"></span>
							
							<em>Creme</em>
						</a>
						
						<a href="#" class="skin-palette">
							<span style="background-color: #333333;"></span>
							<span style="background-color: #FBC441;"></span>
							<span style="background-color: #FFF;"></span>
							<span style="background-color: #CCC;"></span>
							<span style="background-color: #222;"></span>
							<span style="background-color: #333;"></span>
							
							<em>Dark Skin</em>
						</a>
						'
						,
						"icon" 		=> true,
						"type" 		=> "info",
						"fold"  	=> 'use_custom_skin',
				);
					

$of_options[] = array( 	"name" 		=> "Custom CSS",
						"desc" 		=> "",
						"id" 		=> "custom_css_feature",
						"std" 		=> "<h3 style=\"margin: 0 0 10px;\">Custom CSS</h3>
						<p>You can still add your own Custom CSS for this theme, click on the below button and start applying custom styling to this theme.</p>
						<a href=\"admin.php?page=laborator_custom_css\" class=\"button\">Go to Custom CSS Editor</a>",
						"icon" 		=> true,
						"type" 		=> "info"
				);


				

// BORDERS
$of_options[] = array( 	"name" 		=> "Borders",
						"type" 		=> "heading",
						"icon"		=> "fa fa-square-o"
				);
				
$of_options[] = array(  "name"		=> "Theme Borders",
						"desc"   	=> "Show or hide theme borders",
						"id"   		=> "theme_borders",
						"std"   	=> 0,
						"folds"  	=> 1,
						"on"  		=> "Show",
						"off"  		=> "Hide",
						"type"   	=> "switch"
					);
				
$of_options[] = array(  "name"		=> "Border Settings",
						"desc"   	=> "Show borders with animation",
						"id"   		=> "theme_borders_animation",
						"std"   	=> 'fade',
						"options"	=> array(
							'none'   => 'No Animations',
							'fade'   => 'Fade In',
							'slide'  => 'Slide In',
						),
						"type"   	=> "select",
						"fold"  	=> "theme_borders",
					);
				
$of_options[] = array(  "desc"   	=> "Borders animation duration in seconds (if animations are enabled)",
						"id"   		=> "theme_borders_animation_duration",
						"std"   	=> '1',
						"type"   	=> "text",
						"fold"  	=> "theme_borders",
					);
				
$of_options[] = array(  "desc"   	=> "Borders animation delay in seconds (if animations are enabled)",
						"id"   		=> "theme_borders_animation_delay",
						"std"   	=> '0.2',
						"type"   	=> "text",
						"fold"  	=> "theme_borders",
					);
				
$of_options[] = array(  "desc"   	=> "Border thickness in pixels",
						"id"   		=> "theme_borders_thickness",
						"std"   	=> '',
						'plc'		=> 'If not set, default is used: 22',
						"type"   	=> "text",
						"fold"  	=> "theme_borders",
					);

$of_options[] = array(	"desc"   	=> "Set borders color",
						"id"   		=> "theme_borders_color",
						"std"   	=> '#f3f3ef',
						"type"   	=> "color",
						"fold"  	=> "theme_borders",
					);
// END OF BORDERS



$of_options[] = array( 	"name" 		=> "Social Networks",
						"type" 		=> "heading",
						"icon"		=> "fa fa-share-alt"
				);

$social_networks_ordering = array(
			"visible" => array (
				"placebo"	=> "placebo",
				"fb"   	 	=> "Facebook",
				"tw"   	 	=> "Twitter",
				"ig"        => "Instagram",
				"vm"        => "Vimeo",
				"be"        => "Behance",
				"fs"        => "Foursquare",
				"custom"    => "Custom Link",
			),

			"hidden" => array (
				"placebo"   => "placebo",
				"gp"        => "Google+",
				"lin"       => "LinkedIn",
				"yt"        => "YouTube",
				"drb"       => "Dribbble",
				"pi"        => "Pinterest",
				"vk"        => "VKontakte",
				"da"        => "DeviantArt",
				"fl"        => "Flickr",
				"vi"        => "Vine",
				"tu"        => "Tumblr",
				"sk"        => "Skype",
				"gh"        => "GitHub",
			),
);

$of_options[] = array( 	"name" 		=> "Social Networks Ordering",
						"desc" 		=> "Set the appearing order of social networks in the footer. To use social networks links list copy this shortcode: <code style='font-size: 10px; display: inline-block; margin-top: 10px;'>[lab_social_networks]</code>",
						"id" 		=> "social_order",
						"std" 		=> $social_networks_ordering,
						"type" 		=> "sorter"
				);

$of_options[] = array( 	"name" 		=> "Social Networks",
						"desc" 		=> "Facebook",
						"id" 		=> "social_network_link_fb",
						"std" 		=> "",
						"plc"		=> "http://facebook.com/username",
						"type" 		=> "text"
				);

$of_options[] = array( 	"name" 		=> "",
						"desc" 		=> "Twitter",
						"id" 		=> "social_network_link_tw",
						"std" 		=> "",
						"plc"		=> "http://twitter.com/username",
						"type" 		=> "text"
				);

$of_options[] = array( 	"name" 		=> "",
						"desc" 		=> "LinkedIn",
						"id" 		=> "social_network_link_lin",
						"std" 		=> "",
						"plc"		=> "http://linkedin.com/in/username",
						"type" 		=> "text"
				);

$of_options[] = array( 	"name" 		=> "",
						"desc" 		=> "YouTube",
						"id" 		=> "social_network_link_yt",
						"std" 		=> "",
						"plc"		=> "http://youtube.com/username",
						"type" 		=> "text"
				);

$of_options[] = array( 	"name" 		=> "",
						"desc" 		=> "Vimeo",
						"id" 		=> "social_network_link_vm",
						"std" 		=> "",
						"plc"		=> "http://vimeo.com/username",
						"type" 		=> "text"
				);

$of_options[] = array( 	"name" 		=> "",
						"desc" 		=> "Dribbble",
						"id" 		=> "social_network_link_drb",
						"std" 		=> "",
						"plc"		=> "http://dribbble.com/username",
						"type" 		=> "text"
				);

$of_options[] = array( 	"name" 		=> "",
						"desc" 		=> "Instagram",
						"id" 		=> "social_network_link_ig",
						"std" 		=> "",
						"plc"		=> "http://instagram.com/username",
						"type" 		=> "text"
				);

$of_options[] = array( 	"name" 		=> "",
						"desc" 		=> "Pinterest",
						"id" 		=> "social_network_link_pi",
						"std" 		=> "",
						"plc"		=> "http://pinterest.com/username",
						"type" 		=> "text"
				);

$of_options[] = array( 	"name" 		=> "",
						"desc" 		=> "Google Plus",
						"id" 		=> "social_network_link_gp",
						"std" 		=> "",
						"plc"		=> "http://plus.google.com/username",
						"type" 		=> "text"
				);

$of_options[] = array( 	"name" 		=> "",
						"desc" 		=> "VKontakte",
						"id" 		=> "social_network_link_vk",
						"std" 		=> "",
						"plc"		=> "http://vk.com/username",
						"type" 		=> "text"
				);

$of_options[] = array( 	"name" 		=> "",
						"desc" 		=> "DeviantArt",
						"id" 		=> "social_network_link_da",
						"std" 		=> "",
						"plc"		=> "http://username.deviantart.com",
						"type" 		=> "text"
				);

$of_options[] = array( 	"name" 		=> "",
						"desc" 		=> "Tumblr",
						"id" 		=> "social_network_link_tu",
						"std" 		=> "",
						"plc"		=> "http://username.tumblr.com",
						"type" 		=> "text"
				);

$of_options[] = array( 	"name" 		=> "",
						"desc" 		=> "Vine",
						"id" 		=> "social_network_link_vi",
						"std" 		=> "",
						"plc"		=> "http://vine.co/username",
						"type" 		=> "text"
				);

$of_options[] = array( 	"name" 		=> "",
						"desc" 		=> "Behance",
						"id" 		=> "social_network_link_be",
						"std" 		=> "",
						"plc"		=> "http://www.behance.net/username",
						"type" 		=> "text"
				);

$of_options[] = array( 	"name" 		=> "",
						"desc" 		=> "Flickr",
						"id" 		=> "social_network_link_fl",
						"std" 		=> "",
						"plc"		=> "http://www.flickr.com/photos/username",
						"type" 		=> "text"
				);

$of_options[] = array( 	"name" 		=> "",
						"desc" 		=> "Foursquare",
						"id" 		=> "social_network_link_fs",
						"std" 		=> "",
						"plc"		=> "http://foursquare.com/username",
						"type" 		=> "text"
				);

$of_options[] = array( 	"name" 		=> "",
						"desc" 		=> "Skype",
						"id" 		=> "social_network_link_sk",
						"std" 		=> "",
						"plc"		=> "skype:username",
						"type" 		=> "text"
				);

$of_options[] = array( 	"name" 		=> "",
						"desc" 		=> "GitHub",
						"id" 		=> "social_network_link_gh",
						"std" 		=> "",
						"plc"		=> "https://github.com/username",
						"type" 		=> "text"
				);

$of_options[] = array( 	"name" 		=> "Custom Link",
						"desc" 		=> "Link Title",
						"id" 		=> "social_network_custom_link_title",
						"std" 		=> "",
						"plc"		=> "My Custom Link",
						"type" 		=> "text"
				);

$of_options[] = array( 	"desc" 		=> "Link",
						"id" 		=> "social_network_custom_link_link",
						"std" 		=> "",
						"plc"		=> "http://www.mywebsite.com/",
						"type" 		=> "text"
				);



$of_options[] = array( 	"name" 		=> "Coming Soon Mode",
						"type" 		=> "heading",
						"icon"		=> "fa fa-clock-o",
				);

$of_options[] = array(	"name"		=> "Coming Soon Mode",
						"desc"   	=> "Activate coming soon mode page with countdown timer. <br /><small>Note that as an administrator you will not see the coming soon page unless you <a href=\"".site_url("?view-coming-soon=true")."\" target=\"_blank\">click here</a>.</small>",
						"id"   		=> "coming_soon_mode",
						"std"   	=> 0,
						"on"  		=> "Enable",
						"off"  		=> "Disable",
						"type"   	=> "switch"
					);

$of_options[] = array( 	"name" 		=> "Title and description",
						"desc" 		=> "Set page title to show in this page (leave empty to use site slogan)",
						"id" 		=> "coming_soon_mode_title",
						"std" 		=> "",
						"type" 		=> "text"
				);

$of_options[] = array( 	"desc" 		=> "Description  text that explains your visitors why or when the site is back",
						"id" 		=> "coming_soon_mode_description",
						"std" 		=> "We are currently working on the back-end,
our team is working hard and we’ll be back within the time",
						"type" 		=> "textarea"
				);

$of_options[] = array(	"name"   	=> "Countdown timer",
						"desc"   	=> "Show or hide countdown timer",
						"id"   		=> "coming_soon_mode_countdown",
						"std"   	=> 1,
						"on"  		=> "Show",
						"off"  		=> "Hide",
						"type"   	=> "switch",
						"folds"  	=> 1,
					);

$of_options[] = array( 	"name"		=> "Release date",
						"desc" 		=> "Enter the date when site will be online (format YYYY-MM-DD HH:MM:SS)",
						"id" 		=> "coming_soon_mode_date",
						"std" 		=> date("Y-m-d", strtotime("+3 months")) . " 18:00:00",
						"plc"		=> "http://plus.google.com/username",
						"type" 		=> "text",
						"fold"		=> "coming_soon_mode_countdown"
				);

$of_options[] = array(	"name"   	=> "Custom logo for this page",
						"desc"   	=> "Use Custom Logo",
						"id"   		=> "coming_soon_mode_use_uploaded_logo",
						"std"   	=> 0,
						"on"  		=> "Yes",
						"off"  		=> "No",
						"type"   	=> "switch",
						"folds"  	=> 1,
					);

$of_options[] = array(	"name" 		=> "Custom logo",
						"desc" 		=> "Upload/choose your custom logo image from gallery if you want to use it instead of the default logo uploaded in <strong>Logo</strong> section",
						"id" 		=> "coming_soon_mode_custom_logo_image",
						"std" 		=> "",
						"type" 		=> "media",
						"mod" 		=> "min",
						"fold" 		=> "coming_soon_mode_use_uploaded_logo"
					);

$of_options[] = array( 	"desc" 		=> "You can the set maximum width for the uploaded logo, mostly used when you use upload retina (@2x) logo. Pixels unit",
						"id" 		=> "coming_soon_mode_custom_logo_max_width",
						"std" 		=> "",
						"plc"		=> "Logo Width",
						"type" 		=> "text",
						"fold" 		=> "coming_soon_mode_use_uploaded_logo"
				);

$of_options[] = array(	"name"   	=> "Social networks",
						"desc"   	=> "Show or hide social networks in the footer of this page",
						"id"   		=> "coming_soon_mode_social_networks",
						"std"   	=> 0,
						"on"  		=> "Show",
						"off"  		=> "Hide",
						"type"   	=> "switch",
					);



$of_options[] = array( 	"name" 		=> "Maintenance Mode",
						"type" 		=> "heading",
						"icon"		=> "fa fa-wrench",
				);

$of_options[] = array(	"name"   	=> "Maintenance Mode",
						"desc"   	=> "Enable or disable maintenance mode. Note that if coming soon mode is enabled this page will not be visible. <br /><small>Note that as an administrator you will not see the coming soon page unless you <a href=\"".site_url("?view-maintenance=true")."\" target=\"_blank\">click here</a>.</small>",
						"id"   		=> "maintenance_mode",
						"std"   	=> 0,
						"on"  		=> "Enable",
						"off"  		=> "Disable",
						"type"   	=> "switch",
						"folds"		=> 1
					);

$of_options[] = array( 	"name" 		=> "Title and description",
						"desc" 		=> "Set page title to show in this page (leave empty to use site slogan)",
						"id" 		=> "maintenance_mode_title",
						"std" 		=> "",
						"type" 		=> "text",
						"fold"		=> "maintenance_mode"
				);

$of_options[] = array( 	"desc" 		=> "Description text that explains your visitors why this site is under maintenance",
						"id" 		=> "maintenance_mode_description",
						"std" 		=> "We are currently working on the back-end,
our team is working hard and we’ll be back within the time",
						"type" 		=> "textarea",
						"fold"		=> "maintenance_mode"
				);

### END: KALIUM ###


// Backup Options
$of_options[] = array( 	"name" 		=> "Backup Options",
						"type" 		=> "heading",
						"icon"		=> "fa fa-download"
				);

$of_options[] = array( 	"name" 		=> "Backup and Restore Options",
						"id" 		=> "of_backup",
						"std" 		=> "",
						"type" 		=> "backup",
						"desc" 		=> 'You can use the two buttons below to backup your current options, and then restore it back at a later time. This is useful if you want to experiment on the options but would like to keep the old settings in case you need it back',
				);

$of_options[] = array( 	"name" 		=> "Transfer Theme Options Data",
						"id" 		=> "of_transfer",
						"std" 		=> "",
						"type" 		=> "transfer",
						"desc" 		=> 'You can tranfer the saved options data between different installs by copying the text inside the text box. To import data from another install, replace the data in the text box with the one from another install and click "Import Options"',
				);



$of_options[] = array( 	"name" 		=> "Documentation",
						"type" 		=> "heading",
						"icon"		=> "fa fa-life-ring",
						"redirect"	=> admin_url('admin.php?page=laborator_docs')
				);

	}//End function: of_options()
}//End chack if function exists: of_options()
?>
