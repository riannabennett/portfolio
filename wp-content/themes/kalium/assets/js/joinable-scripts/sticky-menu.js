;(function($, window, undefined)
{
	"use strict";

	$(document).ready(function()
	{
		if($("header.main-header").length == 0)
		{
			return false;
		}
		
		var $header = $("header.main-header"),
			$menuBar = $header.find('.menu-bar'),
			$headerSpacer = $('<div class="header-spacer"></div>'),
			
			headerTopOffset = $header.offset().top,
			
			menuType = '',
			
			menuBarDefaultSkin = '',
			menuBarSkinClass = $menuBar.attr('class').match(/menu-skin-[a-z]+/);
		
		if($header.hasClass('menu-type-full-bg-menu'))
		{
			menuType = 'full-bg-menu';
		}
		else
		if($header.hasClass('menu-type-standard-menu'))
		{
			menuType = 'standard-menu';
		}
		if($header.hasClass('menu-type-top-menu'))
		{
			menuType = 'top-menu';
		}
		if($header.hasClass('menu-type-sidebar-menu'))
		{
			menuType = 'sidebar-menu';
		}
					
		if(menuBarSkinClass)
		{
			menuBarDefaultSkin = menuBarSkinClass[0];
		}
		
		if($header.hasClass('is-sticky'))
		{
			var currentMenuHeight = $header.outerHeight(),
				stickyMenuHeight = 0;
			
			// Sticky Custom Logo
			if(headerOptions && headerOptions.stickyUseCustomLogo)
			{
				var logo_url = headerOptions.stickyCustomLogo[0],
					logo_sticky_img = new Image();
				
				logo_sticky_img.onload = function()
				{					
					headerWatcher.exitViewport(function()
					{
						if(headerOptions.stickyCustomLogoWidth)
						{
							var width = parseInt(headerOptions.stickyCustomLogoWidth, 10),
								height = (headerOptions.stickyCustomLogoWidth/headerOptions.stickyCustomLogo[1]) * headerOptions.stickyCustomLogo[2];
							
							setHeaderLogo(logo_url, width, height);
						}
						else
						{
							setHeaderLogo(logo_url);
						}
					});
					
					headerWatcher.enterViewport(function()
					{
						revertHeaderLogo();
					});
				};
				
				if(logo_url)
				{
					logo_sticky_img.src = logo_url;
				}
			}
			
			// Header Spacer
			if($("body").hasClass('header-absolute') == false)
			{
				$header.before($headerSpacer);
			}
			
			if(typeof headerTopOffset == 'number')
			{
				$header.css({top: headerTopOffset});
			}
			
			$headerSpacer.height(currentMenuHeight);
			
			// Calculate Height and set it fixed
			$header.addClass('sticky-active no-transitions');
			
			stickyMenuHeight = $header.outerHeight();
			
			$header.data('stickyMenuHeight', stickyMenuHeight);
			
			// Create Watcher
			var headerWatcher = scrollMonitor.create($header[0], {top: stickyMenuHeight/2});
			
			headerWatcher.lock();
			
			$header.removeClass('sticky-active').addClass('fixed');
			
			setTimeout(function(){ 
				$header.removeClass('no-transitions'); 
			}, 1);
			
			
			// Enter Sticky
			headerWatcher.partiallyExitViewport(function()
			{
				$header.addClass('sticky-active');
				TweenMax.to($headerSpacer, 0.3, {css: {height: stickyMenuHeight}, ease: Power1.easeInOut});
				
				// Custom Menu Bar Skin
				if(headerOptions.stickyMenuBarSkin)
				{
					$menuBar.removeClass(menuBarDefaultSkin).addClass(headerOptions.stickyMenuBarSkin);
					
					if(menuType == 'standard-menu')
					{
						$header.find('.standard-menu-container').removeClass(menuBarDefaultSkin).addClass(headerOptions.stickyMenuBarSkin);
					}
				}
			});
			
			// Exit Sticky
			var wasInit = false;
			
			headerWatcher.fullyEnterViewport(function()
			{
				if(wasInit == false)
				{
					wasInit = true;
					return;
				}
				
				$header.removeClass('sticky-active');
				TweenMax.to($headerSpacer, 0.3, {css: {height: currentMenuHeight}, ease: Power1.easeInOut})
				
				// Custom Menu Bar Skin
				if(headerOptions.stickyMenuBarSkin)
				{
					$menuBar.addClass(menuBarDefaultSkin).removeClass(headerOptions.stickyMenuBarSkin);
					
					if(menuType == 'standard-menu')
					{
						$header.find('.standard-menu-container').addClass(menuBarDefaultSkin).removeClass(headerOptions.stickyMenuBarSkin);
					}
				}
			});
		}
	
	});

})(jQuery, window);