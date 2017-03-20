var publicVars = publicVars || {};

;(function($, window, undefined)
{
	"use strict";

	$(document).ready(function()
	{
		publicVars.hash = window.location.hash.toString();

		publicVars.$body = $("body");
		publicVars.$wrapper = $("#main-wrapper");
		publicVars.$showMore = $(".show-more[data-action]");
		publicVars.$mainHeader = $("header.main-header");
		publicVars.$mainFooter = $("footer.main-footer");
		
		publicVars.$products = $(".products");
		
		publicVars.$fullScreenMenu = publicVars.$body.find('.menu-type-full-bg-menu .full-screen-menu');
		publicVars.$standardMenu = publicVars.$body.find('.menu-type-standard-menu .standard-menu-container');
		publicVars.$topMenu = publicVars.$body.find('.top-menu-container');
		publicVars.$sidebarMenu = publicVars.$body.find('.sidebar-menu-wrapper');
		publicVars.$sidebarMenuBar = publicVars.$body.find('.menu-type-sidebar-menu .menu-bar');
		publicVars.$mobileMenu = publicVars.$body.find('.mobile-menu-wrapper');
		
		publicVars.topBorderHeight = $(".top-border").length ? $(".top-border").outerHeight() : 0;

		if(publicVars.hash.length)
		{
			publicVars.hash = publicVars.hash.substring(1, publicVars.hash.length);
		}


		// Add Submenu Indicator for Items that have children in the menu
		$(".page_item_has_children").addClass('menu-item-has-children');

		if(publicVars.$fullScreenMenu.hasClass('submenu-indicator'))
		{
			publicVars.$fullScreenMenu.find('.menu-item-has-children > a').each(function(i, el)
			{
				$(el).append(' <i class="fa fa-angle-down"></i>');
			});
		}


		// FullScreen Menu
		setupFullScreenMenu();

		function setupFullScreenMenu()
		{
			publicVars.fullScreenMenuOptions = {
				toBeAnimatedClass: 'to-be-animated',
				expandAnimation: 'animate-fade-slide'
			};

			if(publicVars.$fullScreenMenu.length)
			{
				// Submenus
				publicVars.$fullScreenMenu.find('li:has(> ul)').each(function(i, el)
				{
					var $li = $(el),
						$a = $li.find('> a'),
						$ul = $li.find('> ul');

					$li.hoverIntent({
						over: function(e)
						{
							doExpandSubmenu($ul);
						},

						out: function()
						{
							doCollapseSubmenu($ul);
						},

						interval: 100,
						timeout: 250
					});
				});

				publicVars.$fullScreenMenu.on('click', function(ev)
				{	
					var $target = $(ev.target);
					
					if(publicVars.$fullScreenMenu[0] == $target[0] || $target.hasClass('container'))
					{
						fullScreenMenuHide();
					}
				});

				// Open Menu Event
				publicVars.$fullScreenMenuBar = $(".menu-type-full-bg-menu .menu-bar");
				
				publicVars.$fullScreenMenuBar.on('click', function(ev)
				{
					ev.preventDefault();
								
					if(isMobileView())
					{
						mobileMenuOpen();
						return;
					}

					// Close Menu
					if(publicVars.$fullScreenMenuBar.hasClass('exit'))
					{
						fullScreenMenuHide();
					}
					// Show Menu
					else
					{
						fullScreenMenuShow();
					}
					
				});
				
				
				// Search field
				publicVars.$fullScreenMenu.find('form.search-form').each(function(i, searchForm)
				{
					var $searchForm = $(searchForm),
						$input = $searchForm.find('.search-field'),
						$label = $searchForm.find('label');
						
					$input.on('keyup blur', function()
					{
						if($input.val().length > 0)
						{
							$searchForm.addClass('search-filled');
						}
						else
						{
							$searchForm.removeClass('search-filled');
						}
					});
					
				});
			}
		}

		function doExpandSubmenu($ul)
		{
			var expandDuration = 0.25,
				$li = $ul.parent();

			$ul.show();
			$li.addClass(publicVars.fullScreenMenuOptions.toBeAnimatedClass + ' ' + publicVars.fullScreenMenuOptions.expandAnimation + '-in');

			// Calc Height
			var submenu_height = $ul.outerHeight();

			$ul.height(0);

			TweenMax.to($ul, expandDuration, {css: {height: submenu_height}, onComplete: function(){
				$ul.attr('style', '');
			}});

			setTimeout(function(){
				$li.addClass(publicVars.fullScreenMenuOptions.expandAnimation + '-out');
			}, 10);
		}

		function doCollapseSubmenu($ul)
		{
			var collapseDuration = 0.25,
				$li = $ul.parent();

			$li.removeClass(publicVars.fullScreenMenuOptions.expandAnimation + '-out');

			TweenMax.to($ul, collapseDuration, {css: {height: 0}, onComplete: function(){
				$li.removeClass(publicVars.fullScreenMenuOptions.toBeAnimatedClass + ' ' + publicVars.fullScreenMenuOptions.expandAnimation + '-in');
				$ul.attr('style', '');
			}});
		}
		
		function fullScreenMenuShow()
		{
			if(publicVars.$fullScreenMenu.data('is-busy'))
			{
				return;
			}
			
			publicVars.$fullScreenMenu.data('is-busy', true).fadeIn();
			publicVars.$fullScreenMenuBar.addClass('exit');
			
/*
			var mbOffset = publicVars.$fullScreenMenuBar.offset();
			
			publicVars.$fullScreenMenuBar.addClass('is-fixed').css({
				top: mbOffset.top,
				left: mbOffset.left,
			});
*/
			
			publicVars.$fullScreenMenuBar.removeClass(publicVars.$fullScreenMenuBar.data('menu-skin-default'));
			publicVars.$fullScreenMenuBar.addClass(publicVars.$fullScreenMenuBar.data('menu-skin-active'));
			
			
			setTimeout(function()
			{
				publicVars.$fullScreenMenu.data('is-busy', false).addClass('menu-is-open');
				//publicVars.$fullScreenMenu.find('form.search-form input').focus();
				
			}, 200);
		}
		
		function fullScreenMenuHide()
		{
			if(publicVars.$fullScreenMenu.data('is-busy'))
			{
				return;
			}
			
			publicVars.$fullScreenMenu.data('is-busy', true).removeClass('menu-is-open');
			publicVars.$fullScreenMenuBar.removeClass('exit');
			
			setTimeout(function(){
				publicVars.$fullScreenMenuBar.removeClass(publicVars.$fullScreenMenuBar.data('menu-skin-active'));
				publicVars.$fullScreenMenuBar.addClass(publicVars.$fullScreenMenuBar.data('menu-skin-default'));
				
				publicVars.$fullScreenMenuBar.removeClass('is-fixed').removeAttr('style');
				
				publicVars.$fullScreenMenu.data('is-busy', false).fadeOut();
			}, 400);
		}
		
		
		// Standard Menu
		var smWinWidth = $( window ).width();
		
		publicVars.$standardMenu.find('li:has(> ul)').add( publicVars.$topMenu.find('li:has(> ul)') ).each(function(i, el)
		{
			var $el = $(el),
				$ul = $el.find( '> ul' );
			
			if( smWinWidth < ( $ul.offset().left + $ul.outerWidth() ) ) {
				$ul.addClass( 'open-from-left' );
			}
			
			
			$el.hoverIntent({
				over: function()
				{
					$el.addClass('sub-visible');
				},
				out: function()
				{
					$el.removeClass('sub-visible');
				},
				timeout: 200,
				interval: 50
			});
		});
		
		publicVars.$standardMenu.find('.menu-bar').on('click', function(ev)
		{
			ev.preventDefault();
			
			if(isMobileView())
			{
				mobileMenuOpen();
				return;
			}
			
			var $menuBar = $(this);
			
			if(publicVars.$standardMenu.hasClass('items-visible'))
			{
				$menuBar.removeClass('exit');
				publicVars.$standardMenu.removeClass('items-visible');
			}
			else
			{
				$menuBar.addClass('exit');
				publicVars.$standardMenu.addClass('items-visible');
			}
		});
		
		
		// Top Menu
		publicVars.$topMenu.find('.menu > li > ul.sub-menu').each(function(i, el)
		{
			var $el = $(el),
				$a = $el.prev(),
				top = $el.outerHeight();
			
			$el.css({
				left: $a.outerWidth(),
				marginTop: -top/2 + 18
			});
		});
		
		$(".menu-type-top-menu .menu-bar").on('click', function(ev)
		{
			ev.preventDefault();
			
			if(isMobileView())
			{
				mobileMenuOpen();
				return;
			}
			
			var $el = $(this);
				
			topMenuToggle($el);
		});
		
		window.topMenuToggle = function($el)
		{
			var animationDelay = 0.6,
				topMenuHeight = publicVars.$topMenu.actual('outerHeight');
				
			if(publicVars.$topMenu.data('is-busy'))
			{
				return;
			}
			
			// Scroll to Top to open this menu
			if($(window).scrollTop() > publicVars.$topMenu.height() * 0.5 && ! publicVars.$topMenu.hasClass('is-visible'))
			{
				var currScroll = {
					y: $(window).scrollTop()
				};
				
				TweenMax.to(currScroll, 0.5, {
					y: 0, 
					roundProps: ['y'], 
					ease: Quad.easeInOut,
					onUpdate: function(){
						$(window).scrollTop(currScroll.y);
					}, 
					onComplete: function()
					{
						topMenuToggle($el);
					}
				});
				
				return;
			}
			
			if(publicVars.$topMenu.hasClass('is-visible'))
			{
				topMenuHeight = 0;
			}
			
			if( ! publicVars.$topMenu.hasClass('is-visible'))
			{	
				publicVars.$mainHeader.addClass('no-transitions');
				publicVars.$mainHeader.css('top', '0px');
				
				// Prevent bouncing effect
				setTimeout(function(){
					publicVars.$mainHeader.removeClass('no-transitions');
				}, 1);
			}
			
			publicVars.$topMenu.data('is-busy', true).addClass('is-visible');
			
			$el.toggleClass('exit-arrow');
			
			if($(".portfolio-full-bg-slider").length)
			{
				if(topMenuHeight)
				{
					publicVars.$topMenu.css({
						zIndex: 500,
						top: -topMenuHeight
					});
					
					TweenMax.to(publicVars.$topMenu, animationDelay, {css: {top: 0}});
				}
				else
				{
					TweenMax.to(publicVars.$topMenu, animationDelay, {css: {top: -publicVars.$topMenu.actual('outerHeight')}});
				}
				
			}
			
			TweenMax.to(publicVars.$wrapper, animationDelay, {css: {marginTop: topMenuHeight}, ease: Power3.easeInOut, onComplete: function(){
				
				publicVars.$topMenu.data('is-busy', false);
				
				if(topMenuHeight == 0)
				{
					publicVars.$topMenu.removeClass('is-visible');
				}
			}});
		};
		
		
		// Sidebar Menu
		var $sidebarDisabler = publicVars.$body.find(".sidebar-menu-disabler");
		
		publicVars.$sidebarMenu.find('.sidebar-main-menu ul').first().find('> li:has(> ul)').each(function(i, el)
		{
			var $rootEl = $(el);
			
			setupSidebarMenuHover($rootEl, true);
			
			$rootEl.find('li:has(> ul)').each(function(j, subEl)
			{
				setupSidebarMenuHover($(subEl));
			});
		});
		
		publicVars.$sidebarMenu.on('click', '.sidebar-menu-close', function(ev)
		{
			ev.preventDefault();
			sidebarMenuClose();
		});
		
		publicVars.$sidebarMenuBar.on('click', function(ev)
		{
			ev.preventDefault();
			
			if(isMobileView())
			{
				mobileMenuOpen();
				return;
			}
			
			sidebarMenuOpen();
		});
		
		$sidebarDisabler.on('click', sidebarMenuClose);
		
		publicVars.$sidebarMenu.find('.sidebar-menu-container').perfectScrollbar({
			wheelPropagation: true,
			scrollYMarginOffset: 20,
			suppressScrollX: true
		});
		
		function setupSidebarMenuHover($el)
		{
			var $link = $el.children('a'),
				$sub = $el.children('ul');
				
			$el.addClass('sub-visible');
			
			var height = $sub.innerHeight();
			
			$el.removeClass('sub-visible');
			
			$link.hoverIntent({
				over: function()
				{
					TweenMax.to($sub, 0.4, {css: {height: height}, ease: Power2.easeInOut, onComplete: function(){
						$el.addClass('sub-visible');
						$sub.removeAttr('style');
					}});
				},
				out: function(){}
			});
			
			$el.hoverIntent({
				over: function(){},
				out: function()
				{
					TweenMax.to($sub, 0.2, {css: {height: 0}, ease: Sine.easeInOut, onComplete: function(){
						$el.removeClass('sub-visible');
						$sub.removeAttr('style');
					}});
				},
				interval: 100,
				timeout: 250
			});
		}
		
		window.sidebarMenuOpen = function()
		{
			requestAnimationFrame(function(){
				
				publicVars.$body.addClass('sidebar-is-opened');
				
				var propDir = 1;
				
				if(publicVars.$sidebarMenu.hasClass('sidebar-alignment-left'))
				{
					publicVars.$body.addClass('sidebar-is-opened-left');
					propDir = -1;
				}
				
				publicVars.$sidebarMenu.css('transform', 'translate3d('+(-publicVars.$sidebarMenu.outerWidth() * propDir)+'px,0px,0px)');
				
			}, publicVars.$wrapper);
			
			$(window).on('keydown', sidebarMenuCheckExitOnKeyDown);
		}
		
		function sidebarMenuClose()
		{
			requestAnimationFrame(function(){
			
				publicVars.$body.removeClass('sidebar-is-opened');
				
				if(publicVars.$sidebarMenu.hasClass('sidebar-alignment-left'))
				{
					publicVars.$body.removeClass('sidebar-is-opened-left');
				}
				
				publicVars.$sidebarMenu.css('transform', 'translate3d(0px,0px,0px)');
			
			}, publicVars.$wrapper);
			
			$(window).off('keydown', sidebarMenuCheckExitOnKeyDown);
		}
		
		function sidebarMenuCheckExitOnKeyDown(ev)
		{
			if(ev.keyCode == 27)
			{
				sidebarMenuClose();
			}
		}
		
		function isMobileView()
		{
			var smMin = 768;
			
			return $(window).width() <= smMin;
		}
		
		
		// Mobile Menu
		var mobileMenuOpen = function()
		{
			if(isMobileView())
			{	
				publicVars.$body.addClass('mobile-menu-open');
				$(".main-header .menu-bar").addClass('exit');
			}
		}
		
		var mobileMenuClose = function()
		{
			publicVars.$body.removeClass('mobile-menu-open');
			$(".main-header .menu-bar").removeClass('exit');
		}
			
		publicVars.$mobileMenu.find('.mobile-menu-container li:has(> ul)').each(function(i, el)
		{
			var $el = $(el),
				$a = $el.find('> a'),
				$sub = $el.find('> ul');
			
			$el.hoverIntent({
				over: function()
				{
					$sub.addClass('is-visible');
					
					var sub_height = $sub.height();
					
					TweenMax.set($sub, {css: {height: 0}});
					
					TweenMax.to($sub, 0.25, {css: {height: sub_height}, ease: Sine.easeInOut, onComplete: function(){
						$sub.removeAttr('style');
					}});
				},
				out: function()
				{
					TweenMax.to($sub, 0.25, {css: {height: 0}, ease: Sine.easeInOut, onComplete: function(){
						$sub.removeAttr('style').removeClass('is-visible');
					}});
				},
				timeout: 300,
				interval: 50
			});
			
			$a.on('click', function(ev)
			{
				if( ! $el.hasClass('sub-visible'))
				{
					ev.preventDefault();
					$el.addClass('sub-visible');
				}
			});
		});
		
		publicVars.$mobileMenu.on('click', function(ev)
		{
			if(ev.target == publicVars.$mobileMenu[0])
			{
				ev.preventDefault();
				mobileMenuClose();
			}
		});
		
		publicVars.$body.on('click', '.mobile-menu-overlay', function(ev)
		{
			mobileMenuClose();
		});
		
		publicVars.$body.on('swiperight', function()
		{
			//mobileMenuOpen();
		});
		
		publicVars.$body.on('swipeleft', function()
		{
			//mobileMenuClose();
		});
		
		publicVars.$mobileMenu.find('.mobile-menu-container').perfectScrollbar({
			wheelPropagation: true
		});


		// Owl Carousel
		window.setupOwlCarousel = function($els, cb)
		{
			if( ! $.isFunction($.fn.owlCarousel))
				return;

			$els.each(function(i, el)
			{
				var $el = $(el),
					owlOptions = {
						loop: true,
						nav: true,
						items: 1,
						margin: 0,
						stagePadding: 0,
						smartSpeed: 450,
						autoHeight: true,
						navText: ['<i class="flaticon-arrow427"></i>', '<i class="flaticon-arrow413"></i>']
					},
					autoswitch = $el.data('autoswitch');

				if(typeof autoswitch == 'number')
				{
					$.extend(owlOptions, {
						autoplay: true,
						autoplayTimeout: autoswitch * 1000,
						autoplayHoverPause: true
					});
				}

				imagesLoaded($el, function()
				{
					$el.find('.hidden').removeClass('hidden');
					$el.owlCarousel(owlOptions);

					if(typeof cb == 'function')
					{
						cb();
					}
				});
			});
		};


		// Slick Carousel
		window.setupSlickCarousel = function($els, options)
		{
			if( ! $.isFunction($.fn.slick))
			{
				return;
			}

			$els.each(function(i, el)
			{
				var $el = $(el),
					autoswitch = $el.data('autoswitch'),
					slickOptions = {
						slidesToShow: 1,
						infinite: true,
						adaptiveHeight: true,
						prevArrow: '<button type="button" class="slick-prev"><i class="flaticon-arrow427"></i></button>',
						nextArrow: '<button type="button" class="slick-next"><i class="flaticon-arrow413"></i></button>',
						responsive: [
							{
								breakpoint: 768,
								settings: {
									arrows: true
								}
							}
						]
					};
				
				if(typeof options == 'object')
				{
					$.extend(slickOptions, options);
				}

				if(typeof autoswitch == 'number')
				{
					$.extend(slickOptions, {
						autoplay: true,
						autoplaySpeed: autoswitch * 1000
					});
				}

				imagesLoaded($el.find('img').first(), function()
				{
					$el.find('.hidden').removeClass('hidden');
					$el.slick(slickOptions);
				});
			});
		}


		if($.isFunction($.fn.owlCarousel))
		{
			// Default Carousel
			$('.owl-carousel').each(function(i, el)
			{
				var $el = $(el);

				setupOwlCarousel($el);
			});
		}


		// SWF Video JS
		if(typeof videojs != 'undefined')
		{
			videojs.options.flash.swf = "http://vjs.zencdn.net/c/video-js.swf";
		}
		

		// Music Player Holder Hide the Icon when video is playing
		$(".post.format-video").each(function(i, el)
		{
			var $el = $(el),
				interval;

			$el.on('click', '.music-video-holder .video-js', function(ev)
			{
				var $this = $(this),
					delay = 100;

				window.clearTimeout(interval);

				interval = setTimeout(function()
				{
					var playing = $this.is('.vjs-playing') || $this.is('.vjs-user-active');

					$el[playing ? 'addClass' : 'removeClass']('is-playing');

				}, delay);
			});
		});


		// Image Loader (used for Lazy Loading)
		var startLoadingImage = function($img, $parent, className)
		{
			var src = $img.data('src'),
				img = new Image();

			img.onload = function()
			{
				$parent.addClass(className);
				$img.attr('src', src).removeAttr('data-src', '');
			}

			img.src = src;
		};


		// Lazy Load Everything (inline)
		$(".do-lazy-load").each(function(i, el)
		{
			var $this = $(el),
				$images = $this.find('img[data-src]'),

				do_resize = true,
				loaded = 0,
				imagesArr = [];

			$this.addClass('is-loading');

			$images.each(function(j, el2)
			{
				imagesArr.push({
					src: $(el2).data('src'),
					el: el2
				});
			});

			// Start Loading Images
			for(var k in imagesArr)
			{
				(function(index, $container)
				{
					var src = imagesArr[index].src,
						img = new Image();

					img.onload = function()
					{
						var $img = $(imagesArr[index].el),
							old_height = $container.height();

						loaded++;
						$img.removeAttr('data-src').attr('src', src);

						if(loaded == imagesArr.length)
						{
							if(do_resize)
							{
								$img = $(imagesArr[0].el);
								$img.addClass('hidden');

								// Animate Height
								setTimeout(function()
								{
									$img.removeClass('hidden');

									var height = $container.height();
									$img.addClass('hidden');

									$container.height(old_height);

									TweenMax.to($container, 0.3, {css: {height: height}, onComplete: function()
									{
										$img.removeClass('hidden');
										$container.attr('style', '').removeClass('is-loading').trigger('lazyLoaded');
										setTimeout(function(){ $container.addClass('is-finished'); }, 1);
									}});

								}, 100);

								return true;
							}

							$container.removeClass('is-loading').addClass('is-finished').trigger('lazyLoaded');

							return true;
						}
					}

					img.src = src;

				})(k, $this);
			}
		});


		// Lazy Load in Visible Viewport (Most commonly used in this theme)
		function doLazyloadOnShown()
		{
			$(".do-lazy-load-on-shown").each(function(i, el)
			{
				var $this = $(el),
					$images = $this.find('img[data-src]'),

					do_resize = true,
					loaded = 0,
					imagesArr = [];
				
				if($this.data('lab-lazy-loaded') == true)
				{
					return;
				}

				if($this.prop('tagName') == 'IMG')
				{
					$images = $this;
				}

				$this.addClass('is-loading').data('lab-lazy-loaded', true);

				$images.each(function(j, el2)
				{
					imagesArr.push({
						src: $(el2).data('src'),
						el: el2
					});
				});

				// Start Loading Images when they appear in Viewport
				for(var k in imagesArr)
				{
					(function(index, $container)
					{
						var src = imagesArr[index].src,
							watcher = scrollMonitor.create($container[0], -$container.outerHeight() / 10);
						
						watcher.enterViewport(function()
						{
							var $img = $(imagesArr[index].el),
								img = new Image(),
								src = imagesArr[index].src;

							$container.addClass('is-loading');

							img.onload = function()
							{
								$img.attr('src', src).removeAttr('data-src');
								
								setTimeout(function()
								{
									$container.removeClass('is-loading');
									
									$img.addClass('img-loaded');
									$container.addClass('loading-finished');
									
									var args = [imagesArr[index].el, src];
									
									$container.trigger('lazyLoadedOnShown', args);
									$(window).trigger('globalLazyLoadShown', args);
								}, 50);
							}

							img.src = src;
						});

					})(k, $this);
				}
			});

		}


		// Masonry Blog Isotope
		var $blogMasonryContainer = $('#isotope-container.blog-posts-holder');

		if($blogMasonryContainer.length && $.isFunction($.fn.isotope))
		{			
			var $loader = $(".masonry-still-loading"),
				options = {
					itemSelector: '.isotope-item'
				};
			
			TweenMax.to($loader, 0.15, {css: {autoAlpha: 0}, onComplete: function()
			{
				$loader.remove();
						
				$blogMasonryContainer.isotope(options);
				$blogMasonryContainer.isotope('reveal', $blogMasonryContainer.data('isotope').items);

				// Auto Reveal
				if(publicVars.$showMore.hasClass('auto-reveal'))
				{
					var watcher = scrollMonitor.create(publicVars.$showMore[0]);

					if(watcher.isFullyInViewport)
					{
						publicVars.$showMore.data('loadNextPage')();
					}
				}
				
				// On Reveal Shown
				$(window).on('globalLazyLoadShown', function()
				{
					$blogMasonryContainer.isotope('layout');
				});
				
				// Posts Gallery
				$blogMasonryContainer.find(".post-gallery").each(function(i, el)
				{
					setupSlickCarousel($(el));
				});
				
			}});
			
			/*TMP$blogMasonryContainer.imagesLoaded(function()
			{
				var $loader = $(".masonry-still-loading"),
					options = {
						itemSelector: '.isotope-item'
					};

				if($loader.length)
				{
					TweenMax.to($loader, 0.15, {css: {autoAlpha: 0}, onComplete: function()
					{
						$loader.remove();
						$blogMasonryContainer.isotope(options);
						
						// Refresh Slick Sliders
						if($.isFunction($.fn.slick))
						{
							$(".post-gallery").slick('refresh');
							$blogMasonryContainer.isotope('layout');
						}

						// Auto Reveal Action
						if(publicVars.$showMore.hasClass('auto-reveal'))
						{
							var watcher = scrollMonitor.create(publicVars.$showMore[0]);

							if(watcher.isFullyInViewport)
							{
								publicVars.$showMore.data('loadNextPage')();
							}
						}
					}});
				}
				else
				{
					$blogMasonryContainer.isotope(options);
				}

			});*/
		}


		// Endless Loader
		var onTransitionEnd = function()
		{
			var t;
			var el = document.createElement('fakeelement');
			var transitions = {
			  'transition':'transitionend',
			  'OTransition':'oTransitionEnd',
			  'MozTransition':'transitionend',
			  'WebkitTransition':'webkitTransitionEnd'
			}
		
			for(t in transitions){
				if( el.style[t] !== undefined ){
					return transitions[t];
				}
			}
		}
		
		window.showMoreReleased = function($el)
		{
			var current = $el.data('current');

			$el
			.removeClass('is-loading')
			.data('is-busy', false)
			.data('current', current + 1);

			if($el.data('current') > $el.data('max'))
			{
				showMoreFinished($el);
			}
			else
			{
				var watcher = scrollMonitor.create($el[0]);

				if(watcher.isFullyInViewport)
				{
					$el.data('loadNextPage')();
					watcher.destroy();
				}
			}
		}

		window.showMoreFinished = function($el)
		{
			$el.addClass('is-finished');

			var trh = 0;

			$el.on(onTransitionEnd(), function()
			{
				window.clearTimeout(trh);

				TweenMax.to($el.parent(), 0.35, {css: {height: 0, marginTop: 0}, delay: 1.8});
			});
		}

		window.laboratorGetBlogPosts = function($el, resp, current, maxPages, postsPerPage, ajaxAction, opts)
		{
			var $blogContainer = $(".blog-posts-holder"),
				$loader = $('<div />'),
				content = resp.content;

			publicVars.$body.append( $loader );
			$loader.hide().append(content);

			// Blog Type Normal
			if(opts.useFormat == 1)
			{
				imagesLoaded($loader, function()
				{
					var $newItems = $loader.children();

					$blogContainer.append($newItems);

					$newItems.addClass('is-appended initialy-hidden');

					$newItems.each(function(i, el)
					{
						var $el = $(el),
							$img = $el.find('.thumb img'),
							watcher = scrollMonitor.create(el),
							delay = 100 * i;

						setTimeout(function()
						{
							$el.addClass('now-visible');

							setTimeout(function(){
								$el.removeClass('now-visible initialy-hidden');
							}, 500);

						}, delay);
					});

					// VideoJS
					var $vjs = $newItems.find(".video-js");

					$vjs.each(function(i, el){
						videojs(el);
					});

					// Owl Carousel
					setupOwlCarousel($newItems.find('.owl-carousel'));
					
					// Slick Slider Carousel
					setupSlickCarousel($newItems.find('.post-gallery'));

					// Lazy Load On Shown
					doLazyloadOnShown();

					// Release
					showMoreReleased($el);
				});
			}
			else
			// Blog Type Masonry
			if(opts.useFormat == 2)
			{
				$loader.imagesLoaded(function()
				{
					var $newItems = $loader.children().addClass('is-appended');
					$loader.remove();

					setTimeout(function()
					{
						$blogContainer.isotope('insert', $newItems);

						// VideoJS
						var $vjs = $newItems.find(".video-js");

						$vjs.each(function(i, el){
							videojs(el);
						});
						
						// Slick Slider Carousel
						setupSlickCarousel($newItems.find('.post-gallery'));

						// Owl Carousel
						setupOwlCarousel($newItems.find('.owl-carousel'));

						// Lazy Load On Shown
						doLazyloadOnShown();

						// Release
						showMoreReleased($el);

					}, 100);
				});
			}
		}

		window.laboratorGetPortfolioItems = function($el, resp, current, maxPages, postsPerPage, ajaxAction, opts)
		{
			var $portfolio_items = $("#isotope-portfolio-items"),
				$loader = $('<div />'),
				content = resp.content;

			publicVars.$body.append($loader);
			$loader.hide().append(content);
			
			var $newItems = $loader.children().addClass('is-appended'),
				$styles = $loader.find('style');
			
			publicVars.$body.append($styles);
			$loader.remove();

			$portfolio_items.isotope('insert', $newItems);

			doLazyloadOnShown();
			showMoreReleased($el);
		}

		publicVars.$showMore.each(function(i, el)
		{
			var $el	  	= $(el),
				watcher		= scrollMonitor.create(el),
				cb		  = $el.data('cb'),
				pp		  = $el.data('pp'),
				action	  = $el.data('action'),
				opts		= $el.data('opts');

			if(cb == '')
				cb = 'laborator_load_paged_content';

			$el.find('a').on('click', function(ev)
			{
				ev.preventDefault();

				$el.data('loadNextPage')();
			});

			// Get Next Page Function
			$el.data('loadNextPage', function()
			{
				var current	 = $el.data('current'),
					maxpages	= $el.data('max');

				if($el.data('is-busy') || current > maxpages)
					return false;

				$el.data('is-busy', true).addClass('is-loading');

				var data = {
					action: action,
					opts: opts,
					page: current,
					maxPages: maxpages,
					pp: pp
				};
				
				data = jQuery.extend($.getQueryParameters(), data);

				$.post(ajaxurl, data, function(resp)
				{
					window[cb]($el, resp, current, maxpages, pp, action, opts);

				}, 'json');

				return true;
			});

			// Show with ScrollMonitor
			if($el.hasClass('auto-reveal'))
			{
				watcher.fullyEnterViewport(function(ev)
				{
					if($(".masonry-still-loading").length == 0)
						$el.data('loadNextPage')();
				});
			}
		});


		// Lightbox
		if($.isFunction($.fn.nivoLightbox))
		{
			$(".nivo a, a.nivo").nivoLightbox({
				effect: 'fade',
				theme: 'default',
			});
		}


		// Reply to Connector
		$(".comment[data-replied-to]:has(.comment-connector)").each(function(i, el)
		{
			var $comment = $(el),
				$commentAvatar = $comment.find('.commenter-image'),
				$commentConnector = $comment.find('.comment-connector'),

				$parentComment = $('#'+$comment.data('replied-to')),
				$parentCommentAvatar = $parentComment.find('.commenter-image'),
				$parentCommentText = $parentComment.find('.comment-text'),

				padd = 28,

				verticalDifference = $commentAvatar.offset().top - $parentCommentText.offset().top + padd,
				horizontalDifferenceWidth = $commentAvatar.offset().left - $parentCommentAvatar.offset().left + padd,
				horizontalDifference = (horizontalDifferenceWidth ) / 2;

			$commentConnector.css({
				paddingTop: verticalDifference,
				width: horizontalDifference - 1
			}).addClass('visible');

			$(window).resize(function()
			{
				var verticalDifference = $commentAvatar.offset().top - $parentCommentText.offset().top + padd,
					horizontalDifferenceWidth = $commentAvatar.offset().left - $parentCommentAvatar.offset().left + padd,
					horizontalDifference = (horizontalDifferenceWidth ) / 2;

				$commentConnector.css({
					paddingTop: verticalDifference,
					width: horizontalDifference - 1
				});
			});
		});

		// Live change search keyword
		var $csk = $(".change-search-keyword");

		if($csk.length == 1)
		{
			$csk.after('<input type="text" class="search-input-live-type no-style-input color-main" /><span class=""></span>');

			var $csk_input = $csk.next(),
				$csk_sample = $csk_input.next(),
				csk_default = $csk.html(),
				csk_search = $csk.data('search-url'),
				cskCalculateStringWidth = function(q, plus)
				{
					$csk_sample.text(q);

					return $csk_sample.outerWidth() + (plus ? plus : 0);
				};

			$csk_input.val(csk_default);

			$csk_sample.css({
				position: 'absolute',
				visibility: 'hidden',
				top: -100,
				whiteSpace: 'pre'
			});

			$csk.on('click', function(ev)
			{
				ev.preventDefault();

				var width = cskCalculateStringWidth($csk_input.val(), 8);
				$csk_input.width(width).focus();

				$csk.addClass('hidden');
			});

			$csk_input
			.on('keypress', function(e)
			{
				var new_val = $csk_input.val() + String.fromCharCode(e.which),
					width = cskCalculateStringWidth(new_val, 8 + 1);

				$csk_input.width(width);

				setTimeout(function(){
					$csk_input.width( cskCalculateStringWidth($csk_input.val(), 1) );
				}, 0);
			})
			.on('blur', function()
			{
				$csk.removeClass('hidden');
				$csk_input.attr({style: '', value: csk_default});
			})
			.on('keydown', function(e)
			{
				if( e.which == 13)
				{
					if($.trim($csk_input.val()).length > 0 && csk_default != $csk_input.val())
					{
						window.location.href = csk_search + $csk_input.val();
					}
				}
			});
		}


		// Post Likes
		publicVars.$body.on('click', '.like-btn[data-id]', function(ev)
		{
			ev.preventDefault();

			var $el      = $(this),
				$i      = $el.find('i'),
				$span   = $el.find('span');
			
			if($el.hasClass('is-loading'))
			{
				return;
			}

			$el.addClass('is-loading');

			$.getJSON(ajaxurl, {action: 'laborator_update_likes', post_id: $el.data('id')}, function(resp)
			{
				$el.removeClass('is-loading is-liked');

				if(resp.liked)
				{
					$el.addClass('is-liked');
					$i.removeClass('fa-heart-o').addClass('fa-heart');

					var timeline = new TimelineMax({delay: 0.05}),
						timeline2 = new TimelineMax({delay: 0.05});

					timeline.append( TweenMax.to($i, 0.2, {css: {scale: 1.25}, onComplete: function(){ $span.html(resp.count); }}) );
					timeline.append( TweenMax.to($i, 0.2, {css: {scale: 1.0}}) );

					timeline2.append( TweenMax.to($span, 0.3, {css: {autoAlpha: 0}, onComplete: function(){
						$i.add($span).removeAttr('style');
					}}) );
				}
				else
				{
					$i.removeClass('fa-heart').addClass('fa-heart-o');

					var timeline = new TimelineMax({delay: 0.05}),
						timeline2 = new TimelineMax({delay: 0.05});

					timeline.append( TweenMax.to($i, 0.2, {css: {scale: 0.75}, onComplete: function(){ $span.html(resp.count); }}) );
					timeline.append( TweenMax.to($i, 0.2, {css: {scale: 1.0}}) );

					timeline2.append( TweenMax.to($span, 0.3, {css: {autoAlpha: 0}, onComplete: function(){
						$i.add($span).removeAttr('style');
					}}) );
				}
			});

		});


		// Full Backgroun Gallery
		var $gtb = $(".gallery-type-fullbg .gallery"),
			gtp_no_stick = $(".gallery-no-top-stick").length > 0;

		if($gtb.length)
		{
			window.setupPortfolioFullBGGallery = function()
			{
				$gtb.css({marginLeft: 0, marginTop: 0, marginRight: 0});

				var offset             = $gtb.offset(),
					win_width		   = $(window).width(),
					top_offset         = offset.top,
					left_offset        = offset.left,
					right_offset       = win_width - (left_offset + $gtb.outerWidth()),
					is_left_aligned    = $('.details.pull-right-md').length > 0;

				if(win_width < 992)
				{
					return;
				}

				if(gtp_no_stick)
					top_offset = 0;
					
				top_offset -= publicVars.topBorderHeight;
				left_offset -= publicVars.topBorderHeight;
				
				if(publicVars.$topMenu.hasClass('is-visible'))
				{
					top_offset -= (publicVars.$topMenu.outerHeight() - publicVars.topBorderHeight);
				}

				if(is_left_aligned)
				{
					$gtb.css({
						marginTop: -top_offset,
						marginLeft: -left_offset
					});
				}
				else
				{
					$gtb.css({
						marginTop: -top_offset,
						marginRight: -right_offset
					});
				}
			}

			setupPortfolioFullBGGallery();

			$(window).resize(setupPortfolioFullBGGallery);
		}


		// Portfolio Sticky Elements
		$(".single-portfolio-holder.is-sticky").each(function(i, el)
		{
			var $sp_holder = $(el),
				active_from = 992;
			
			if($sp_holder.length && $(window).width() > active_from)
			{
				var $mh							   = $("header.main-header"),
					$sticky_portfolio_details      = $sp_holder.find(".details > .row"),
					$gallery                       = $sp_holder.find(".gallery"),
					$details                       = $sp_holder.find(".details"),
					$project_description           = $details.find(".project-description"),
					extraTopOffset			   = 0;
					
				if($mh.hasClass('is-sticky'))
				{
					$details.addClass('has-sticky-header');
					
					extraTopOffset = parseInt($mh.data('stickyMenuHeight'), 10);
				}
					
				// Check if scroller is needed
				var win_height = $(window).height();

				// Add Scrollbar
				if($details.outerHeight() > win_height)
				{
					var scroll_height = win_height - ($details.outerHeight() - $project_description.outerHeight()),
						desc_height = parseInt(scroll_height - $sticky_portfolio_details.offset().top - 25, 10);
					
					desc_height -= extraTopOffset;
					
					if(desc_height < 80)
					{
						desc_height = 150;
					}

					$project_description.css({
						height: desc_height
					});

					$project_description.perfectScrollbar({
						wheelPropagation: true,
						suppressScrollX: true
					});//TMP.after('<div class="lgrad"></div>');
				}
				
				$details.addClass('shown');
				
				// Stick the description
				partiallyStickyElement( $sticky_portfolio_details, $( '.gallery-column-env' ), { top: 20 } );
			}

		});


		// Portfolio Navigation
		var $portfolio_navigation = $('.portfolio-navigation');

		if($portfolio_navigation.length && publicVars.$mainFooter.is(':visible') && publicVars.$mainFooter.offset().top > $(window).height())
		{
			if($portfolio_navigation.is('.portfolio-navigation-type-fixed'))
			{
				var pn_footer_watcher = scrollMonitor.create(publicVars.$mainFooter[0], {bottom: $portfolio_navigation.outerHeight()});

				pn_footer_watcher.enterViewport(function()
				{
					$portfolio_navigation.addClass('is-not-visible');
				});

				pn_footer_watcher.exitViewport(function()
				{
					$portfolio_navigation.removeClass('is-not-visible');
				});
			}
		}


		// Comparison Image Setup
		if(typeof sliderComparison == 'function')
		{
			$(".comparison-image-slider:has(img[data-src])").each(function(i, el)
			{
				var $el = $(el),
					$img = $el.find('> img');

				$img.on('lazyLoadedOnShown', function()
				{
					$el.css('paddingTop', '0px');

					$img.removeClass('hidden').addClass('fadeIn animated');
					sliderComparison($el);
				});
			});
		}


		// Images Slider in Portfolio
		$(".portfolio-images-slider").each(function(i, el)
		{
			var $el = $(el),
				has_lazy_load = $el.find('img[data-src]').length > 0;

			if(has_lazy_load)
			{
				$el.on('lazyLoaded', function()
				{
					setTimeout(function()
					{
						setupSlickCarousel($el);
						
						$el.on('init', function(slick)
						{
							if($.isFunction($.fn.nivoLightbox))
							{
								$el.find(".nivo a, a.nivo").nivoLightbox({
									effect: 'fade',
									theme: 'default',
								});
							}
						});
						
					}, 500);
				});
			}
			else
			{
				setupSlickCarousel($el);
			}
		});


		// Full Width Gallery
		$(".full-width-container").each(function(i, el)
		{
			var $container = $(el),
				top_stick = $container.hasClass('stick-to-top'),
				fitFullwidthContainer = function()
				{
					$container.css({
						marginLeft: '',
						marginRight: ''
					});

					if(top_stick)
					{
						$container.css({
							marginTop: ''
						});
					}

					var move_back = $(window).width() / 2 - $container.outerWidth(true) / 2;

					$container.css({
						marginLeft: -move_back,
						marginRight: -move_back
					});

					if(top_stick)
					{
						var top_offset = $container.offset().top;

						$container.css({
							marginTop: -top_offset
						});
					}
				};

			fitFullwidthContainer();

			$(window).on('resize', fitFullwidthContainer);
		});


		// Gallery Slider Carousel
		var $gallery_slider_carousel = $('.gallery-slider');

		if($gallery_slider_carousel.length && $.isFunction($.fn.slick))
		{
			$gallery_slider_carousel.find('.hidden').removeClass('hidden');

			var gs_autoplay = $gallery_slider_carousel.data('autoplay');

			if(gs_autoplay == 0)
				gs_autoplay = 4000;

			$gallery_slider_carousel.slick({
				centerMode: true,
				centerPadding: '150px',
				slidesToShow: 1,
				infinite: $gallery_slider_carousel.data('infinite') == 1,
				autoplay: $gallery_slider_carousel.data('autoplay') > 0,
				autoplaySpeed: gs_autoplay,
				adaptiveHeight: true,
				prevArrow: '<button type="button" class="slick-prev"><i class="flaticon-arrow427"></i></button>',
				nextArrow: '<button type="button" class="slick-next"><i class="flaticon-arrow413"></i></button>',
				responsive: [
					{
						breakpoint: 768,
						settings: {
							arrows: false,
							centerPadding: '0px',
							autoplay: true,
							autoplaySpeed: gs_autoplay
						}
					}
				]
			});
		}


		// Gallery with Description (Height Fix)
		$(".gallery .gallery-item-description").each(function(i, el)
		{
			var $description = $(el),
				image_height = $description.parent().next().height(),
				no_spacing = $(".gallery-type-description").hasClass('no-spacing');

			$description.removeClass('hidden');

			if($(window).width() < 768)
				return;

			if($description.outerHeight() > image_height)
			{
				var distancer = 45;

				if(no_spacing)
				{
					image_height -= distancer;

					if( ! $description.hasClass('first-entry'))
						image_height -= distancer;
				}
				else
				{
					image_height -= 30;
				}

				if(image_height > 0)
				{
					$description.css({height: image_height});

					$description.perfectScrollbar({
						wheelPropagation: true,
						suppressScrollX: true
					});
				}
			}
		});



		// Portfolio Full Background Gallery Slider
		var $pfb_slider = $(".portfolio-full-bg-slider");

		if($pfb_slider.length)
		{
			var $pfb_images = $pfb_slider.find('.image-entry'),
				$pfb_nav = $(".portfolio-slider-nav"),
				$pdb_description = $(".portfolio-description-container"),
				pfb_autoswitch = null;

			// Setup Slider
			$pfb_images.each(function(i, el)
			{
				var $li        = $(el),
					load_uri   = $li.data('load'),
					img        = new Image(),
					last_i     = $pfb_images.length - 1;

				img.onload = function()
				{
					$li.css('background-image', 'url('+load_uri+')').removeAttr('data-load');

					if(i == 0)
					{
						$li.addClass('active');
						$pfb_slider.addClass('is-finished');
					}
				};

				img.src = load_uri;
			});

			// Slider Function
			$pfb_slider.data('goTo', function(index)
			{
				index = index % $pfb_images.length;

				if(index < 0)
					index = $pfb_images.length + index;

				var $current  = $pfb_nav.find('.current'),
					$next  	  = $pfb_nav.find('a').eq(index);

				if($current.index() != index)
				{
					$current.removeClass('current');
					$next.addClass('current');

					$pfb_images.filter('.active').removeClass('active');
					$pfb_images.eq(index).addClass('active');
				}
			});

			// Slider Nav goTo
			$pfb_nav.on('click', 'a', function(ev)
			{
				$pfb_slider.data('goTo')($(this).data('index'));

				window.clearInterval(pfb_autoswitch);
				pfb_autoswitch = null;
			});

			// Keyboard Navigate Slide
			$(window).on('keydown', function(ev)
			{
				if(ev.keyCode == 37)
				{
					$pfb_slider.trigger('swiperight');
				}
				else
				if(ev.keyCode == 39)
				{
					$pfb_slider.trigger('swipeleft');
				}
			});

			// Swipe Events Slide
			$pfb_slider.on('swipeleft', function()
			{
				$pfb_slider.data('goTo')( $pfb_nav.find('.current').index() + 1);

				window.clearInterval(pfb_autoswitch);
				pfb_autoswitch = null;
			});

			$pfb_slider.on('swiperight', function()
			{
				$pfb_slider.data('goTo')( $pfb_nav.find('.current').index() - 1);

				window.clearInterval(pfb_autoswitch);
				pfb_autoswitch = null;
			});


			// AutoSwitch Slider
			if($pfb_slider.data('autoswitch') > 0)
			{
				pfb_autoswitch = setInterval(function()
				{
					$pfb_slider.data('goTo')( $pfb_nav.find('.current').index() + 1);
				}, $pfb_slider.data('autoswitch') * 1000);
			}

			var pfbToggleDescription = function(do_collapse)
			{
				if($pdb_description.data('is-busy'))
					return false;

				var $items = $pdb_description.find(".title, .project-description, .link, .services, .social-buttons, .social-links-plain"),
					$collapse = $pdb_description.find('.collapse-project-info');

				$pdb_description.data('is-busy', true);

				// Extend Animation
				if( ! do_collapse)
				{
					var $collapsed_title = $pdb_description.find('.portfolio-description-showinfo h3'),
						$collapsed_text = $pdb_description.find('.portfolio-description-showinfo p'),
						$expand_icon = $pdb_description.find('.expand-project-info');

					$pdb_description.removeClass('is-collapsed');

					var expanded_width = $pdb_description.outerWidth(),
						expanded_height = $pdb_description.outerHeight();

					$pdb_description.addClass('is-collapsed');

					TweenMax.to($collapsed_title, 0.25, {css: {autoAlpha: 0}, delay: 0.2});
					TweenMax.to($collapsed_text, 0.2, {css: {autoAlpha: 0}});
					TweenMax.to($expand_icon, 0.25, {css: {autoAlpha: 0}});

					TweenMax.to($pdb_description, 0.5, {css: {width: expanded_width, height: expanded_height}, delay: 0.3, ease: Quad.easeInOut, onComplete: function()
					{
						$collapsed_title.add($collapsed_text).add($expand_icon).removeAttr('style');
						$pdb_description.removeClass('is-collapsed');

						TweenMax.set($items, {css: {autoAlpha: 0}});
						TweenMax.set($collapse, {css: {autoAlpha: 0, top: -50, right: -50}});

						TweenMax.to($collapse, 0.25, {css: {autoAlpha: 1, top: 0, right: 0}});
						TweenMax.to($items, 0.5, {css: {autoAlpha: 1}, onComplete: function()
						{
							$items.add($collapse).add($pdb_description).removeAttr('style');
							$pdb_description.data('is-busy', false);

							$pdb_description.perfectScrollbar({
								wheelPropagation: true,
								suppressScrollX: true
							});
						}});
					}});
				}
				// Collapse Animation
				else
				{
					$pdb_description.addClass('is-collapsed');

					var collapsed_width = $pdb_description.outerWidth(),
						collapsed_height = $pdb_description.outerHeight();

					$pdb_description.removeClass('is-collapsed');

					$($items.get().reverse()).each(function(i, el)
					{
						TweenMax.to(el, 0.25, {css: {autoAlpha: 0}, delay: 0.2 + (i * 0.1)})
					});

					TweenMax.to($collapse, 0.5, {css: {top: 30, right: 30, autoAlpha: 0}});

					TweenMax.to($pdb_description, 0.5, {css: {width: collapsed_width, height: collapsed_height}, delay: 0.8, ease: Quad.easeInOut, onComplete: function()
					{
						$pdb_description.addClass('is-collapsed');
						$items.add($collapse).add($pdb_description).removeAttr('style');
						$pdb_description.perfectScrollbar('destroy');

						var $collapsed_title = $pdb_description.find('.portfolio-description-showinfo h3'),
							$collapsed_text = $pdb_description.find('.portfolio-description-showinfo p'),
							$expand_icon = $pdb_description.find('.expand-project-info');

						TweenMax.set($collapsed_title, {css: {autoAlpha: 0, top: 15}});
						TweenMax.set($collapsed_text, {css: {autoAlpha: 0, top: 25}});
						TweenMax.set($expand_icon, {css: {autoAlpha: 0}});

						TweenMax.to($collapsed_title, 0.4, {css: {autoAlpha: 1, top: 0}});
						TweenMax.to($collapsed_text, 0.4, {css: {autoAlpha: 1, top: 0}});
						TweenMax.to($expand_icon, 0.4, {css: {autoAlpha: 1}, onComplete: function()
							{
								$collapsed_title.add($collapsed_text).add($expand_icon).removeAttr('style');
								$pdb_description.data('is-busy', false);
							}
						});
					}});
				}
			}

			$pdb_description.on('click', '.collapse-project-info', function(ev)
			{
				ev.preventDefault();
				pfbToggleDescription(true);
			});

			$pdb_description.on('click', '.expand-project-info', function(ev)
			{
				ev.preventDefault();
			});

			$pdb_description.on('click', function(ev)
			{
				if($pdb_description.hasClass('is-collapsed'))
				{
					pfbToggleDescription(false);
				}
			});

			$pdb_description.perfectScrollbar({
				wheelPropagation: true,
				suppressScrollX: true
			});
			
			if($pdb_description.hasClass('is-collapsed'))
			{
				$pdb_description.perfectScrollbar('destroy');
			}
		}


		// Portfolio Items Isotope
		var $portfolio_items = $("#isotope-portfolio-items");

		if($.isFunction($.fn.isotope) && $portfolio_items.length)
		{
			var $portfolio_filter = $(".product-filter li a");

			$portfolio_filter.each(function(i, el)
			{
				var $el = $(el),
					term = $el.data('term');


				$el.on('click', function(ev)
				{
					ev.preventDefault();

					$portfolio_filter.parent().removeClass('active');
					$el.parent().addClass('active');

					filterPortfolioItems(term);
				});
			});

			var isotopeOptions = {
				itemSelector: '.isotope-item',
				layoutMode: 'fitRows'
			}

			if($portfolio_items.hasClass('is-masonry-layout'))
			{
				var gridWidth = 1140,
					gridCols = 4,
					gutterWidth = 30
					
				$.extend(isotopeOptions, {
					layoutMode: 'packery'
				});
			}

			$portfolio_items.isotope(isotopeOptions);

			$portfolio_items.isotope( 'on', 'layoutComplete', function(isoInstance, laidOutItems)
			{
				scrollMonitor.recalculateLocations();
				scrollMonitor.update();
			});

			var filterPortfolioItems = function(term)
			{
				$portfolio_items.isotope({
					filter: function()
					{
						var $item = $(this),
							terms = $item.data('terms');

						// Set Hash
						var top = $(window).scrollTop();
						window.location.hash = term != '*' ? ('cat:' + term) : '';
						$(window).scrollTop(top);


						// Filter Terms
						if(term == '*')
							return true;

						if(terms)
						{
							terms = terms.split(' ');
							return $.inArray(term, terms) != -1;
						}

						return false;
					}
				});
			};

			// Select Category from Hash
			var term_matches = [];

			if(term_matches = publicVars.hash.match(/cat:([a-z0-9\-_]+)/i))
			{
				$portfolio_filter.filter('[data-term="'+term_matches[1]+'"]').click();
			}
		}


		// Hover State Click Entire Area
		publicVars.$body.on('click', '.portfolio-holder .product-box .thumb .hover-state', function(ev)
		{	
			if( ! $(ev.target).is('a') && $(ev.target).closest('.like-btn').length == 0)
			{
				if($("html").is('.touch') == false)
				{
					var $link = $(this).next();
					
					if($link.attr('target') == '_blank' || ( macKeys.ctrlKey || macKeys.cmdKey ))
					{
						window.open($link.attr('href'));	
					}
					else
					{
						window.location.href = $link.attr('href');
					}
				}
			}
		});
		
		
		
		// ScrollBox
		$(".lab-scroll-box[data-height]").each(function(i, el)
		{
			var $el = $(el),
				$scroll_area = $el.find('> .lab-scroll-box-content'),
				maxHeight = $el.data('height');
			
			$scroll_area.perfectScrollbar({
				wheelPropagation: true,
				suppressScrollX: true
			});
		});
		
		
		
		// Clients Logos fit height
		$(".logos-holder[id]:not(.alt-height)").each(function(i, el)
		{
			var $el = $(el),
				$items = $el.find('.c-logo'),
				max_height = 0;
			
			$el.addClass('is-visible');
			
			$items.each(function(j, item)
			{
				max_height = max_height < $(item).outerHeight() ? $(item).outerHeight() : max_height; 
			});
			
			$items.css({
				height: max_height,
				lineHeight: max_height + 'px'
			});
		});
		
		$(".client-logos-col.with-link").on('click', '.hover-state', function(ev)
		{
			var $mainHref = $(this).find('a').first(),
				mainHref = $mainHref.attr('href');
			
			if(ev.target.tagName != 'A')
			{
				if( $mainHref.attr( 'target' ).toLowerCase().trim() == '_blank' ) {
					window.open( mainHref );	
				} else {
					window.location.href = mainHref;
				}
			}
		});
		
		
		
		// Contact Form
		$("form.contact-form[id]").each(function(i, cf)
		{
			var $cf       = $(cf),
				$name     = $cf.find('input[name="name"]'),
				$email    = $cf.find('input[name="email"]'),
				$subject  = $cf.find('input[name="subject"]'),
				$message  = $cf.find('textarea[name="message"]'),
				
				$submit	   = $cf.find('button[name="send"]'),
				$loadingBar = $submit.find('.loading-bar span');
			
			$cf.submit(function(ev){
				
				ev.preventDefault();
				
				if($submit.data('is-busy'))
				{
					return false;
				}
				
				var data = {
					id: $cf.attr('id'),
					check: $cf.data('check'),
					name: $name.val(),
					email: $email.val(),
					subject: $subject.val(),
					message: $message.val(),
				};
				
				
				if(is.empty($name.val()))
				{
					$name.focus();
					return false;
				}
				
				if(is.empty($email.val()))
				{
					$email.focus();
					return false;
				}
				
				if(is.empty($message.val()))
				{
					$message.focus();
					return false;
				}
				
				if(is.not.email($email.val()))
				{
					$email.select();
					return false;
				}
				
				data.request = $cf.find('input[name="request"]').val();
				data.action = 'lab_contact_form_request';
				
				
				// Submit Form
				$submit.addClass('is-loading').data('is-busy', true);
				
				TweenMax.to($loadingBar, 4, {css: {width: '90%'}, delay: 0.5, ease: Power2.easeOut});
				
				$.post(ajaxurl, data, function(resp){
					
					if(resp.success)
					{
						var $fields = $name.add($email).add($subject).add($message);
						
						$fields.attr('readonly', true);
						$fields.parent().fadeTo(300, 0.5);
						
						TweenMax.to($loadingBar, 0.5, {css: {width: '100%'}, onComplete: function()
						{
							var regex = new RegExp('\<script', 'gi');
 
							$submit.html($submit.html().replace('#', '<strong>'+$name.val()+'</strong>').replace(regex, '&lt;script'));
							
							$submit.removeClass('is-loading').addClass('is-finished');
							
							
							var $preSubmitMsg 	 = $submit.find('.pre-submit'),
								$successMsg      = $submit.find('.success-msg'),
								$successMsgIcon  = $successMsg.find('i'),
								buttonWidth 	 = $submit.outerWidth();
							
							$submit.removeClass('is-finished');
							
							TweenMax.to($submit, 0.3, {css: {width: buttonWidth}, delay: 0.4, onComplete: function(){
								$submit.css({width: ''});
							}});
							
							TweenMax.to($preSubmitMsg, 0.1, {css: {autoAlpha: 0}, delay: 0.6, onComplete: function(){
								$preSubmitMsg.hide();
								
								TweenMax.set($successMsg, {css: {display: 'block', autoAlpha: 0}});
								TweenMax.set($successMsgIcon, {css: {autoAlpha: 0}});
								
								TweenMax.to($successMsg, 0.4, {css: {autoAlpha: 1}});
								TweenMax.to($successMsgIcon, 0.4, {css: {autoAlpha: 1}});
							}});
						}});
					}
					else
					{
						alert("Invalid token, your message couldn't be sent!");
						
						TweenMax.to($loadingBar, 0.3, {css: {width: 0}, onComplete: function(){
							$submit.removeClass('is-loading');
						}});
						$submit.data('is-busy', false);
					}
					
				}, 'json');
			});
			
			$cf.find('.form-group.absolute:has(input)').each(function(j, el){
				$(el).find("input").css('paddingLeft', $(el).find(".placeholder").outerWidth() + 20);
			});
		});
		
		
		// Dribbble Gallery
		$(".lab-dribbble-gallery div[data-dribbble-user]").each(function(i, el)
		{
			var $el = $(el),
				user = $el.data('dribbble-user'),
				count = $el.data('dribbble-count');
			
			getShotsForID([user], $el.prop('id'), count);
		});
		
		
		// Post Gallery
		$(".post-gallery").each(function(i, el)
		{
			var $el = $(el);
			
			if($el.closest('#isotope-container').length == 0)
			{
				setupSlickCarousel($el, {
					infinite: false
				});
			}
		});
		
		
		// Fluid Box
		if($.isFunction($.fn.fluidbox))
		{
			// Lightbox for Gallery items inside blog post
			$(".post-content a:has(img), a.fluid-box:has(img), .fluid-box a:has(img)").each(function(i, item)
			{
				var $item = $(item);
	
				if($item.attr('href').match(/(jpg|jpeg|png|gif)$/i))
				{
					$item.fluidbox();
				}
			});
		}

		
		// Header Logo Switcher
		window.setHeaderLogo = function(logoUrl, customWidth, customHeight)
		{
			var $headerImageContainer = $(".logo-and-menu-container .logo-image"),
				$imgElement = $('<span class="switched-logo"><img  /></span>');
			
			if($headerImageContainer.find('.switched-logo').length == 0)
			{
				$headerImageContainer.append($imgElement).data({
					currWidth: $headerImageContainer.outerWidth(),
					currHeight: $headerImageContainer.outerHeight(),
				});
			}
			
			$imgElement = $headerImageContainer.find('.switched-logo');
			
			var img = new Image();

			img.src = logoUrl;
			img.onload = function()
			{
				var $img = $imgElement.find('img'),
				
					currWidth = $headerImageContainer.data('currWidth'),
					currHeight = $headerImageContainer.data('currWidth'),
					
					toWidth = this.width,
					toHeight = this.height;
				
				if(customWidth)
				{
					toWidth = customWidth;
				}
				
				if(customHeight)
				{
					toHeight = customHeight;
				}
					
				$img.attr('src', logoUrl);
				
				setTimeout(function()
				{
					$headerImageContainer.addClass('logo-switched');
					TweenMax.to($headerImageContainer, 0.2, {css: {width: toWidth, height: toHeight}});
				}, 1);
			}
		};
		
		window.revertHeaderLogo = function()
		{
			var $headerImageContainer = $(".logo-and-menu-container .logo-image"),
			
				currWidth = $headerImageContainer.data('currWidth'),
				currHeight = $headerImageContainer.data('currWidth'),
				
				removeStyleAttribute = function()
				{
					$headerImageContainer.removeAttr('style');
				};
			
			$headerImageContainer.removeClass('logo-switched');
			
			if(currWidth || currHeight)
			{
				if(currWidth && currHeight)
				{
					TweenMax.to($headerImageContainer, 0.2, {css: {width: currWidth, height: currHeight}, onComplete: removeStyleAttribute});
				}
				else
				if(currWidth)
				{
					TweenMax.to($headerImageContainer, 0.2, {css: {width: currWidth}, onComplete: removeStyleAttribute});
				}
				else
				if(currHeight)
				{
					TweenMax.to($headerImageContainer, 0.2, {css: {height: currHeight}, onComplete: removeStyleAttribute});
				}
			}
		};
		
		
		// Parallax
		$('[data-lab-parallax-ratio]').each(function(i, el)
		{
			var $el = $(el),
				win = $(window),
				
				factor = 1 - parseFloat($el.data('lab-parallax-ratio')),
				opacity = $el.data('lab-parallax-opacity'),
				
				elOpacity = $el.css('opacity'),
				elHeight = $el.outerHeight(),
				elOffset = $el.offset().top,
				
				scrollTop = 0,
				factorMult = 0,
				opacityFactor = 0,
				
				setOpacity = elOpacity,
				
				moveEl = null,
				
				watcher = scrollMonitor.create(el);
			
			// Move Element
			moveEl = function(){
				
				if(watcher.isInViewport == false)
				{
					return false;
				}

				scrollTop = win.scrollTop();
				factorMult = parseInt(factor * scrollTop, 10);
				
				requestAnimationFrame(function(){
					
					if(opacity !== '')
					{
						opacityFactor = Math.max(0, parseFloat(Math.min(scrollTop / (elHeight + elOffset), 1).toFixed(2)));
						setOpacity = 1 - opacityFactor;
						
						if(opacity > 0)
						{
							setOpacity = 1 - (opacityFactor * ( 1- opacity));
						}
					}
					
					$el.css({
						'transform': 'translate3d(0px,'+ factorMult +'px,0px)',
						'opacity': setOpacity
					});
					
				}, $el);
				
				return true;
			};
			
			setInterval(moveEl, 10);
		});
		
		
		// Top Menu Toggle
		$("a.top-menu-toggle, .top-menu-toggle > a").each(function(i, el)
		{
			var $el = $(el);
			
			if(publicVars.$topMenu.find('.close-top-menu').length == 0)
			{
				publicVars.$topMenu.append('<a href="#" class="close-top-menu">&times;</a>');
				
				$("body").on('click', '.close-top-menu', function(ev)
				{
					ev.preventDefault();
					
					topMenuToggle($(null));
					$(".menu-bar").removeClass('exit-arrow');
				});
			}
			
			$el.on('click', function(ev)
			{
				ev.preventDefault();
				
				topMenuToggle($(null));
			});
		});
		
		
		// Sidebar Menu Toggle
		$("a.sidebar-menu-toggle, .sidebar-menu-toggle > a").each(function(i, el)
		{
			var $el = $(el);
			
			$el.unbind().on('click', function(ev)
			{
				ev.preventDefault();
				
				sidebarMenuOpen();
			});
		});
		
		
		// Footer Collapse Link
		$(".footer-collapse-link").on('click', function(ev)
		{
			ev.preventDefault();
			$(this).remove();
		});
		
		
		// Fixed Footer
		var $fixedFooter = $("footer.main-footer.fixed-footer");
		
		if($fixedFooter.length)
		{
			var enoughWrapperSpace = $(window).height() < (publicVars.$wrapper.outerHeight() + publicVars.$mainFooter.outerHeight());
			
			if(enoughWrapperSpace && isMobileView() == false)
			{
				var footerHeight = $fixedFooter.outerHeight(),
					$footerSpacer = $('<div class="footer-spacer"></div>');
					
				publicVars.$body.append($footerSpacer);
				
				/*
				publicVars.$wrapper.css({
					marginBottom: footerHeight
				});
				*/
				
				$footerSpacer.css({
					height: footerHeight
				});
				
				imagesLoaded($fixedFooter, function()
				{
					footerHeight = $fixedFooter.outerHeight();
					
					/*
					publicVars.$wrapper.css({
						marginBottom: footerHeight
					});
					*/
									
					$footerSpacer.css({
						height: footerHeight
					});
				});
				
				// Footer Shown
				var fixedFooterWatcher = scrollMonitor.create(publicVars.$wrapper);
				
				fixedFooterWatcher.partiallyExitViewport(function()
				{
					$fixedFooter.addClass('shown');
				});
				
				fixedFooterWatcher.fullyEnterViewport(function()
				{
					$fixedFooter.removeClass('shown');
				});
			}
			else
			{
				$fixedFooter.addClass('shown by-default');
			}
		}
		
		
		// Shop
			$(".woocommerce-ordering .dropdown-menu li a").each(function(i, el)
			{
				var $el = $(el),
					$select = $(".woocommerce-ordering select.orderby");
				
				$el.on('click', function(ev)
				{
					ev.preventDefault();
					
					$el.closest('.woocommerce-ordering').fadeTo(220, 0.5).find('.dropdown .btn span').html( $el.html() );
					
					$select.find('option[value="' + $el.attr('href').replace('#', '') + '"]').prop('selected', true);
					$select.trigger('change');
				});
			});
			
			// Product Hovering
			var initProductHovering = function()
			{
				$( '.products .product' ).each( function( i, el ) {
					
					var $product = $( el );
					
					if( $product.data('hoverSetup') )
					{
						return;
					}
					
					$product.hoverIntent( {
						over: function() {
							$product.addClass( 'hover' );
						},
						
						out: function() {
							
							if( $product.hasClass( 'adding-to-cart' ) == false && $product.hasClass( 'product-added-to-cart' ) == false )
							{
								$product.removeClass( 'hover' );
							}
						},
						
						interval: 30,
						timeout: 150
					} );
					
					$product.data('hoverSetup', true);
				} );
			}
			
			initProductHovering();
			
			
			// Adding product to cart
			$( 'body' ).on( 'adding_to_cart', function( ev, $button, data ) {
				
				var $product = $button.closest( '.product' ),
					id = $product.data( 'id' );
				
				$product.addClass( 'adding-to-cart' );
				
				if( typeof addToCartTimeoutObj[ id ] == 'undefined' )
				{
					window.clearTimeout( addToCartTimeoutObj[ id ] );
				}
			} );
			
			// Added To Cart
			var $currentAddToCartButton = {},
				addToCartTimeoutObj = {};
			
			$( 'body' ).on( 'added_to_cart', function(ev, fragments, hash, $button) {
				
				var $product = $button.closest( '.product' ),
					$priceCol = $product.find( '.product-price-col' ),
					id = $product.data( 'id' ),
					addedToCartText = $button.data('added_to_cart_text');
				
				$product.removeClass( 'adding-to-cart' ).addClass( 'atc-disable-images product-added-to-cart' );
				
				$priceCol.addClass( 'cart-added' );
				
				if( ! $button.data('originalText'))
				{
					$button.data('originalText', $button.html());
				}
				
				$button.fadeTo( 200, 0, function() {
					$button.html( addedToCartText + ' <i class="flaticon-verification24"></i> ' ).fadeTo( 200, 1 ).addClass( 'nh' );
				} );
				
				
				// Add to Cart Tooltip
				if( $product.hasClass( 'catalog-layout-full-bg' ) || $product.hasClass( 'catalog-layout-transparent-bg' ) )
				{
					var $atcLink = $button.closest( '.add-to-cart-link' );
					
					if( $product.data( 'tooltip-initialized' ) != true )
					{
						$atcLink.attr('data-original-title', addedToCartText);
						
						$atcLink.tooltip( {
							placement: 'left'
						} );
						
						$product.data( 'tooltip-initialized', true );
					}
					
					$atcLink.tooltip( 'show' );
				}
				
				// After a little timeout bring back the original text
				addToCartTimeoutObj[ id ] = setTimeout( function() {
					$button.fadeTo( 200, 0, function() {
						
						$button.html( $button.data( 'originalText' ) ).fadeTo( 200, 1 ).removeClass( 'nh' );
						$priceCol.removeClass( 'cart-added' );
						
						setTimeout( function() {
							$product.removeClass( 'atc-disable-images hover product-added-to-cart' );
							
							if( typeof $atcLink != 'undefined' )
							{
								$atcLink.tooltip( 'destroy' );
								$product.data( 'tooltip-initialized', false );
							}
						}, 1000 );
					} );
				}, 2200 );
			} );
			
			
			// Shop Product Init
			var initShopProduct = function( $product )
			{
				if( $product.data( 'init' ) )
				{
					return;
				}
				
				var hoverType = 'none',
					$imagesGallery = $product.find( '.item-images' );
				
				if( $imagesGallery.hasClass( 'preview-type-fade' ) )
				{
					hoverType = 'fade';
				}
				else if( $imagesGallery.hasClass( 'preview-type-gallery' ) )
				{
					hoverType = 'gallery';
				}
				
				// Setup Fade Hover Effect
				if( hoverType == 'fade' )
				{
					$imagesGallery.hoverIntent( {
						over: function() {
							$imagesGallery.addClass( 'gallery-hover' );
						},
						
						out: function() {
							$imagesGallery.removeClass( 'gallery-hover' );
						},
						
						interval: 20,
						timeout: 100
					} );
				}
				else
				if( hoverType == 'gallery' )
				{
					var $itemImages = $product.find( '.item-images' ),
						$galleryImages = $itemImages.find( '.product-gallery-image' ),
						totalImages = $galleryImages.length + 1;
						
					$product.data({
						currentGalleryImage: 0,
						imagesHeight: $itemImages.actual( 'outerHeight' )
					});
					
					$product.on( 'click', '.product-gallery-navigation a', function( ev ) {
						
						ev.preventDefault();
						
						var isPrev = $( this ).hasClass( 'gallery-prev' ),
							currentIndex = $product.data( 'currentGalleryImage' ),
							nextIndex = currentIndex + ( isPrev ? -1 : 1 );
						
						$galleryImages.removeClass( 'current' );
						
						if( isPrev && currentIndex == 0 )
						{
							nextIndex = totalImages - 1;
						}
						
						// Relayout Items
						var relayoutMasonry = function() {
							
							if( publicVars.$products.hasClass( 'products-masonry' ) )
							{
								publicVars.$products.isotope( 'layout' );
							}
						}
						
						// Switch Images
						if( totalImages > nextIndex && nextIndex > 0 )
						{
							var $nextImage = $galleryImages.eq( nextIndex - 1 ),
								currentHeight = $itemImages.outerHeight(),
								nextHeight = $nextImage.outerHeight();
							
							if( currentHeight != nextHeight )
							{
								$itemImages.height( nextHeight );
								relayoutMasonry();
								$itemImages.height( '' );
								
								TweenMax.to( $itemImages, 0.2, { css: { height: nextHeight } } );
							}
							
							$nextImage.addClass( 'current' );
						}
						else
						if( totalImages >= nextIndex )
						{
							var currentHeight = $itemImages.outerHeight();
							
							$itemImages.height( '' );
							relayoutMasonry();
							$itemImages.height( currentHeight );
							
							TweenMax.to( $itemImages, 0.2, { css: { height: $product.data( 'imagesHeight' ) } } );
							nextIndex = 0;	
						}
						
						$product.data( 'currentGalleryImage', nextIndex );
						
					} );
				}
				
				// Show Tooltips for Full Bg + Transparent Bg items with Select Options
				if( $product.hasClass( 'catalog-layout-full-bg' ) || $product.hasClass( 'catalog-layout-transparent-bg' ) )
				{
					if( $product.hasClass( 'product-type-variable' ) || $product.hasClass( 'product-type-external' ) )
					{
						var $atcLink = $product.find( '.add-to-cart-link' );
					
						$atcLink.attr('data-original-title', $atcLink.find( 'a' ).html() );
						
						$atcLink.tooltip( {
							placement: 'left'
						} );
					}
				}
				
				$product.data( 'init', true );
			};
			
			window.initShopProduct = initShopProduct;
			
			$( '.products .product ').each( function( i, el ) {
				
				var $product = $( el );
				
				initShopProduct( $product );
				
			} );
			
			
			// Internal Product Info Clickable
			$( document ).on( 'click', '.product-internal-info', function( ev ) {
				
				var $this = $( this );
				
				if( $( ev.target ).is( 'a' ) !== true )
				{
					var $link = $this.find( 'h3 a' );
					
					if( $link.attr( 'target' ) && $link.attr( 'target' ).toLowerCase() == '_blank' || ( macKeys.ctrlKey || macKeys.cmdKey ) )
					{
						window.open( $link.attr( 'href' ) );
					}
					else
					{
						window.location.href = $link.attr( 'href' );
					}
				}
				
			} );
			
			
			// Shop Masonry
			$( '.products.products-masonry' ).each( function( i, el ) {
				
				var $this = $( el );
				
				if( $this.parent().is( '.lab-vc-products-carousel' ) ) {
					return;
				}
				
				$this.removeClass( 'hidden ');
				
				if( $this.prev().is( '.shop-loading-products' ) )
				{
					$this.prev().remove();
				}
				
				$this.not( '.product-category' ).isotope({
					itemSelector: '.product',
					layoutMode: $this.data('layoutMode')
				});
				
			} );
		

			// Products Pagination
			window.laboratorGetProducts = function($el, resp, current, maxPages, postsPerPage, ajaxAction, opts)
			{
				var $products = $( '.products' ),
					$loader = $('<div />'),
					isMasonry = $products.is( '.products-masonry' ),
					$newItems = $( resp.content );
				
				if( isMasonry )
				{	
					$products.isotope( 'insert', $newItems );
				}
				else
				{
					$products.append( $newItems );
				}
				
				// Init products and do some stuff after products are appended
				$products.find( '.product' ).each( function( i, el ) {
					
					var $el = $( el );

					initShopProduct( $el );
				} );
					
				initProductHovering();
				doLazyloadOnShown();
				showMoreReleased( $el );
			}
			
			
			// Variations Select Modify
			$( '.variations select.form-control' ).each( function( i, el ) {

				var $select = $( el ),
					$tpl = $( '<div class="select-option-ui"><span></span><i class="flaticon-bottom4"></i></div>' ),
					$span = $tpl.find( 'span' ),
					changeEv = function() {
						$span.html( $select.find( 'option:selected' ).text() );
					};
				
				changeEv();
				
				if( $select.next().is('.select-option-ui') == false )
				{
					$select.after( $tpl );
				}
				
				$select.on( 'change', changeEv ).data( 'changeEv', changeEv );
				$tpl.append( $select );
			} );
			
			$( '.variations_form' ).on( 'check_variations', function( ev) {
				
				$( this ).find( '.select' ).each( function( i, el ) {
					
					$( el ).data( 'changeEv' )();
				} );
			} );
			
			
			// Rewriting Tab Animation
			$( '.woocommerce-tabs ul.tabs li a' ).unbind( 'click' ).click( function() {
				
				var $tab = $( this ),
					$tabs_wrapper = $tab.closest( '.woocommerce-tabs' );
		
				$( 'ul.tabs li', $tabs_wrapper ).removeClass( 'active' );
				$( 'div.panel', $tabs_wrapper ).hide();
				$( 'div' + $tab.attr( 'href' ), $tabs_wrapper).fadeIn( 'fast' );
				$tab.parent().addClass( 'active' );
		
				return false;
			});
		
			
			// Reviews Link Single Product
			$( '.woocommerce-review-link' ).on( 'click', function() {
				
				var scrollTop = $( window ).scrollTop();
				
				window.location.hash = '#reviews';
				$( window ).scrollTop( scrollTop );
				
				$( 'html, body' ).animate( {
					scrollTop: $( '.woocommerce-tabs' ).offset().top + 60
				}, 800 );
				
				return false;
			} );
			
			
			// Partially Sticky Element
			var $productImagesCarousel = $( '.product-images-carousel'),
				$productSummary = $( '.product .summary' );
			
			if( $productImagesCarousel.is( '.plain.sticky' ) )
			{
				var psEl = partiallyStickyElement( $productSummary, $productImagesCarousel, {
					top: 20
				} );
				
				// Reposition the sticky product description after the height of description changes
				var svTm = 0;
				
				$( 'body' ).on( 'check_variations', '.variations_form', function( ev, variation ) {
					
					var currentHeight = $productSummary.outerHeight();
					
					if( $productSummary.hasClass( 'is-absolute' ) )
					{	
						window.clearTimeout( svTm );
						
						svTm = setTimeout( function() {
							var afterTransitionHeight = $productSummary.outerHeight();
							
							if( afterTransitionHeight != currentHeight)
							{
								var heightDiff = afterTransitionHeight - currentHeight,
									currentTop = parseInt( $productSummary.css( 'top' ), 10 );
								
								TweenMax.to( $productSummary, 0.3, { css: { top: currentTop - heightDiff }, onComplete: psEl.recalculateLocation } );
							}
						}, 220 );
					}
				} );
				
				$( 'body' ).on( 'found_variation', '.variations_form', function( ev, variation ) {
					
					if( variation.image_src )
					{	
						var img = new Image();
						
						img.src = variation.image_src;
						img.onload = function() {
							
							setTimeout( function() {
								$productSummary.data( 'psEl' ).recalculateLocation;
							}, 100 );
						}
					}
				} );
			}
			
			// Show Login Form
			$( 'a.showlogin' ).unbind( 'click' ).on( 'click', function( ev ) {
				ev.preventDefault();
				
				$( '#checkout-login-form-container' ).slideToggle();
				
				return false;
			} );
			
			
			// Mini-Cart
			var $miniCart = $( '.menu-cart-icon-container' ),
				$miniCartLink = $miniCart.find( '.cart-icon-link' ),
				$miniCartItemsCount = $miniCartLink.find( '.items-count' ),
				$miniCartContents = $miniCart.find( '.lab-wc-mini-cart-contents' ),
				
				$miniCartMobile = $( '.cart-icon-link-mobile-container .cart-icon-link-mobile' ),
				$miniCartMobileItemsCount = $miniCartMobile.find( '.items-count' ),
				
				miniCartIsOpen = false;
			
			if( $miniCart.length )
			{
				var miniCartRefresh = function()
					{
						var $cartItems = $miniCartContents.find( '.cart-items' );
						
						if( $cartItems.data( 'psId' ) )
						{
							$cartItems.perfectScrollbar( 'update' );
						}
						else
						{
							$cartItems.perfectScrollbar({
								wheelPropagation: true,
								suppressScrollX: true
							});
						}
					},
					miniCartOpen = function()
					{
						if( $miniCartContents.length == 0 ) {
							window.location.href = $miniCartLink.attr( 'href' );
						}
						
						$miniCart.addClass( 'open' );
						miniCartRefresh();
						miniCartIsOpen = true;
					},
					miniCartClose = function()
					{
						$miniCart.removeClass( 'open' );
						miniCartIsOpen = false;
					},
					miniCartUpdateNumber = function(count)
					{
						$miniCartItemsCount.add( $miniCartMobileItemsCount ).attr( 'class', 'items-count' );
						
						$miniCartMobileItemsCount.html(count);
						
						TweenMax.to( $miniCartItemsCount, 0.15, { css: { scale: 1.25}, onComplete: function() {
							$miniCartItemsCount.html(count);
							TweenMax.to( $miniCartItemsCount, 0.15, { css: { scale: 1 } } );
						} } );
					};
				
				if( $miniCartContents.length )
				{
					$miniCartLink.on( 'click', function( ev ) {
						
						ev.preventDefault();
						
						if( $miniCart.hasClass( 'open' ) ) {
							miniCartClose();
						} else {
							miniCartOpen();
						}
					} );
					
					// Show MiniCart On Hover
					if( $miniCart.hasClass( 'hover-show' ) )
					{
						$miniCart.hoverIntent( {
							over: miniCartOpen,
							
							out: miniCartClose,
							interval: 50,
							timeout: 150
						} );
					}
					
					// Bootstrap Dropdown
					$( '.dropdown' ).on( 'show.bs.dropdown', function() {
						miniCartClose();
					} );
				}
				
				// MiniCart Fragments Refresh
				$( 'body' ).on( 'adding_to_cart', function( ev, $button, data ) {
					$miniCart.addClass( 'is-loading' );
				} );
				
				$( 'body' ).on( 'added_to_cart', function(ev, fragments, hash, $button) {
					$miniCart.removeClass( 'hidden is-loading' );
					
					$miniCartContents.html( fragments.labMiniCart );
					miniCartUpdateNumber( fragments.labMiniCartCount );
					
					if( $miniCart.hasClass( 'open' ) ) {
						miniCartRefresh();
					}
				} );
				
				// Mini Cart Load Data From AJAX
				if( $miniCart.hasClass( 'ajax-mode' ) )
				{
					$.post( ajaxurl, { action: 'lab_wc_get_mini_cart_fragments' }, function( fragments ) {
						
						$miniCartItemsCount.html( fragments.labMiniCartCount );
						$miniCartContents.html( fragments.labMiniCart );
						
						miniCartUpdateNumber( fragments.labMiniCartCount );
						
					}, 'json' );
				}
				
				// Hide Cart When Clicking Outside the area
				$( window ).click( function( ev ) {
					
					if( miniCartIsOpen ) {
						
						if( $( ev.target ).closest( '.menu-cart-icon-container' ).length == 0 ) {
							miniCartClose();
						}
					}
				} );
			}
		
		// End of: Shop
		
		
		// Portfolio Fix for Videos
		$('.portfolio-video-holder').each(function(i, el)
		{
			var $el = $(el);
			
			$el.on('mouseover', function()
			{
				var $animated = $el.closest('.animated'),
					fn = this;
				
				if($animated.length)
				{
					$animated.removeClass('animated');
					$el.off('mouseover', fn);
				}
			});
		});
		
		// Portfolio Item Gallery Masonry Mode
		if( $.isFunction($.fn.isotope) ) {
			$( '.gallery.masonry-mode-gallery .row' ).isotope();
		}
		
		
		// Lazy Loading (last thing)
		doLazyloadOnShown();

		
		// Update Scroll Monitor Watchers
		scrollMonitor.update();
		
	});

})(jQuery, window);


// Wow Initialize
if(WOW && typeof WOW != 'undefined')
{
	var wowLab = new WOW();
	
	wowLab.sync();
	
	wowLab.init({
		mobile: false
	});
}


/**
 *	Partially Sticky Element
 *
 *	@author:	Arlind Nushi
 *	@version:	1.0
 *	@requires:	enquires.js
 */
 
function partiallyStickyElement( $el, $rowEl, opts ) {
	
	var sticked = false,
		blockSticky = false,
		
		// Scroll Monitor Vars
		tw,
		bw,
		
		// Main Settings
		settings = {
			top: 0,
			maxViewportWidth: 768, // If the window width is smaller than value the elements will not be sticky
		};
	
	if( typeof opts == 'object' ) {
		jQuery.extend( settings, opts );
	}
	
	/***** Sticky Menu Check *****/
	var stickyTop = 0;
	
	if( publicVars.$mainHeader.is( '.is-sticky' ) ) {
		
		stickyTop = parseInt( publicVars.$mainHeader.data( 'stickyMenuHeight' ), 0 );
		
		if( stickyTop == NaN ) {
			stickyTop = 0;
		}
		
		settings.top += stickyTop;
	}
	
	
	// Reset Current Element (release from sticky or absolute position)
	settings.resetElement = function() {
		sticked = false;
		
		$el.removeClass( 'is-fixed is-absolute' ).removeAttr( 'style' );
	}
	
	// Make the current element sticky on viewport
	settings.makeItSticky = function() {
		
		sticked = true;
		
		var offset = $el.offset(),
			currentWidth = $el.width();
	
		$el.addClass( 'is-fixed' ).css( { 
			left: offset.left - $el.css( 'marginLeft' ),
			top: settings.top,
			width: currentWidth
		} );
	}
	
	// Put the element to the end line of rowElement
	settings.stickToRowEl = function() {
		
		sticked = false;
		
		var topVal = $rowEl.outerHeight() - $el.outerHeight(),
			currentWidth = $el.width();
		
		$el.addClass( 'is-absolute' ).css( {
			top: topVal,
			width: currentWidth
		} );
	}
	
	// Check window width
	settings.checkWinWidth = function() {
		
		if( jQuery( window ).width() < settings.maxViewportWidth ) {
			settings.destroy();
			
			return false;
		}
		
		return true;
	}
	
	// Destroy the scrollMonitor events (used when rebuilding the
	settings.destroy = function() {
		sticked = false;
		blockSticky = false;
		
		if( tw ) {
			tw.destroy();
			tw = null;
		}
		
		if( bw ) {
			bw.destroy();
			bw = null;
		}
		
		settings.resetElement();
	}
	
	// Check the current position/location
	settings.checkLocation = function() {
		
		if( tw && tw.isAboveViewport ) {
			settings.makeItSticky();
			
			// Its Below the rowEl
			if( bw.isAboveViewport ) {
				settings.resetElement();
				settings.stickToRowEl();
			}
		}
	}
	
	// Recalculate Position
	settings.recalculateLocation = function() {
		settings.destroy();
		settings.setupScrollMonitor();
		settings.checkLocation();
	}
	
	// Set up The Scroll Monitor
	settings.setupScrollMonitor = function() {
		
		if( ! settings.checkWinWidth() ) {
			return false;
		}
			
		// Top Watcher
		var twOptions = {
				top: settings.top
			};
			
		tw = scrollMonitor.create( $el, twOptions );
		
		tw.lock();
		
		tw.stateChange( function() {
			
			if( sticked == true && ! blockSticky && tw.isFullyInViewport ) {
				settings.resetElement();
			}
			
			if( sticked == false && ! blockSticky && tw.isAboveViewport ) {
				settings.resetElement();
				settings.makeItSticky();
				
				if( bw.isBelowViewport ) {
					settings.resetElement();
				} else if( bw.isAboveViewport && ! tw.isBelowViewport ) {
					settings.stickToRowEl();
				}
				
			}
		} );
		
		// Bottom Watcher
		var bwOptions = {
				top: $el.outerHeight() - $rowEl.outerHeight() +  settings.top
			};
		
		if( stickyTop > 0 ) {
			bwOptions.top += publicVars.$mainHeader.outerHeight() - stickyTop;
		}
			
		bw = scrollMonitor.create( $el, bwOptions );
		
		bw.lock();
		
		bw.partiallyExitViewport( function() {
			settings.resetElement();
			settings.stickToRowEl();
		} );
		
		bw.stateChange( function() {
			
			if( bw.isAboveViewport == false ) {
				blockSticky = false;
				
				settings.resetElement();
				settings.makeItSticky();
				
				if( ! tw.isAboveViewport ) {
					settings.resetElement();
				}
				
				if( tw.isInViewport && ! bw.isInViewport ) {
					settings.resetElement();

					if( tw.isAboveViewport ) {
						settings.makeItSticky();
					}
				}
			}
		} );
		
		return true;
	}
	
	
	/***** On Init *****/
	
	// Setup partiallyStickyElement for the first time
	settings.setupScrollMonitor();
	
	// When loading the page for the first time
	settings.checkLocation();
	
	if( jQuery( window ).scrollTop() > 0 ) {
		setTimeout( function() {
			settings.recalculateLocation();
		}, 100 );
	}
	
	
	
	/***** Set Events *****/
	
	// Destroy on Smaller Screens
	enquire.register( 'screen and (max-width: ' + settings.maxViewportWidth + 'px)', {
		match: function() {
			settings.destroy();
		},
		unmatch: function() {
			settings.setupScrollMonitor();
		}
	} );
	
	// When Resizing the window
	var resTm = 0;
	
	jQuery( window ).on( 'resize', function() {
		
		window.clearTimeout( resTm );
		
		resTm = setTimeout( settings.recalculateLocation, 220 );
	} ).on( 'load', function() {
		settings.recalculateLocation();
	} );

	
	/***** Assign instance object to the element *****/
	
	$el.data( 'psEl', settings );
	
	return settings;
}