(function($) {
  "use strict";
    $=jQuery;
    jQuery(document).ready(function($){
        $('.bk-links-remember').on("click", function(e){
            e.preventDefault();
            $(this).parents('.bk-form-wrapper').hide();
            $(this).parents('.bk-form-wrapper').siblings('.bk-remember-form-wrapper').fadeIn(500);
        });
        $('.bk-back-login').on("click", function(e){
            e.preventDefault();
            if ($(this).parents('.bk-form-wrapper').hasClass('bk-remember-form-wrapper')) {
                $(this).parents('.bk-form-wrapper').siblings('.bk-register-form-wrapper').hide();
            }else if ($(this).parents('.bk-form-wrapper').hasClass('bk-register-form-wrapper')) {
                $(this).parents('.bk-form-wrapper').siblings('.bk-remember-form-wrapper').hide();  
            }
            $(this).parents('.bk-form-wrapper').hide();
            $(this).parents('.bk-form-wrapper').siblings('.bk-login-form-wrapper').fadeIn(500);
        });
        
        $('.bk-links-register-inline').on("click", function(e){
            e.preventDefault();
            $(this).parents('.bk-form-wrapper').hide();
            $(this).parents('.bk-form-wrapper').siblings('.bk-register-form-wrapper').fadeIn(500);
        });
        
        $(".price_slider_amount").css("opacity", "1");
        $("#main-mobile-menu").css("display", "block");    
        $('#mobile-menu > ul > li.menu-item-has-children').prepend('<div class="expand"><i class="fa fa-chevron-down"></i></div>');
        $('#mobile-top-menu > ul > li.menu-item-has-children').prepend('<div class="expand"><i class="fa fa-chevron-down"></i></div>');    
        $('.expand').on("click", function(){
            $(this).siblings('.sub-menu').toggle(300); 
        });
    // display breaking module
        $('.module-breaking-carousel').removeClass('hide');
        $('.module-carousel').removeClass('hide');
        $('.module-carousel-2').removeClass('hide');
        $('.single .article-content').fitVids();
        var bkWindowWidth = $(window).width(),
            bkWindowHeight = $(window).height();
    // Ajax search 
        $('#ajax-form-search').on("click", function(){
            if ($(this).parent().hasClass('activated')) {
                $(this).parent().removeClass('activated');
            }else {
                $(this).parent().addClass('activated');
            }
            if ($(this).siblings('.ajax-form').width() == 0){
                $('.ajax-form').css('padding','0 54px 0 0');
                $('.ajax-form input').css('padding','8px 12px');
                $('.ajax-form input').css('font-size','16px'); 
                $('.ajax-form input').val('');
            } else {
                $('.ajax-form').css('padding','0');
                $('.ajax-form input').css('padding','0');
                $('.ajax-form input').css('font-size','0'); 
            }
            
        });
        
        var delay = (function () {
            var timer = 0;
            return function (callback, ms) {
                clearTimeout(timer);
                timer = setTimeout(callback, ms);
            };
        })();
    // Breaking margin
        if($('#page-content-wrap').children('.bksection:first-child').find('.bkmodule:first-child').hasClass('module-fw-slider') == true) {
            $('#page-content-wrap').css('margin-top', '0px');
        }
    /*** Light Box ***/
        $('.single-page').imagesLoaded(function(){
            if($('.single-page').find('header').attr('id') != 'bk-nomal-feat'){
                var sHeaderHeight = $('.single-page').find('header').height();
                var iconPlayHeight = $('.icon-play').height();
                var iconTop = (sHeaderHeight - iconPlayHeight)/2;
                $('.icon-play').css({'top': iconTop, 'opacity': '1'});
            }else {
                var sHeaderHeight = $('#bk-nomal-feat').height();
                var sFeatIngHeight = $('.s-feat-img').height();
                var iconPlayHeight = $('.icon-play').height();
                var FeatMarginTop = sHeaderHeight - sFeatIngHeight;
                var iconTop = (sFeatIngHeight - iconPlayHeight + FeatMarginTop)/2;
                $('.icon-play').css({'top': iconTop, 'opacity': '1'});
            }
        });
        $('.img-popup-link').magnificPopup({
    		type: 'image',
            removalDelay: 300,
            mainClass: 'mfp-fade',
    		closeOnContentClick: true,
    		closeBtnInside: false,
    		fixedContentPos: true,		
    		image: {
    			verticalFit: true
    		}
    	});
        $('.video-popup-link').magnificPopup({
    		closeBtnInside: false,
    		fixedContentPos: true,
    		disableOn: 700,
    		type: 'iframe',
            removalDelay: 300,
            mainClass: 'mfp-fade',
    		preloader: false,
    	});
        if (typeof justified_ids !== 'undefined') {
            $.each( justified_ids, function( index, justified_id ) {
            	$(".justifiedgall_"+justified_id).justifiedGallery({
            		rowHeight: 200,
            		fixedHeight: false,
            		lastRow: 'justify',
            		margins: 4,
            		randomize: false,
                    sizeRangeSuffixes: {lt100:"",lt240:"",lt320:"",lt500:"",lt640:"",lt1024:""},
            	});
            });        
        }
        $('.zoom-gallery').each(function() { // the containers for all your galleries
            $(this).magnificPopup({
        		delegate: 'a.zoomer',
        		type: 'image',
        		closeOnContentClick: false,
        		closeBtnInside: false,
        		mainClass: 'mfp-with-zoom mfp-img-mobile',
        		image: {
                    tError: '<a href="%url%">The image #%curr%</a> could not be loaded.',
        			verticalFit: true,
        			titleSrc: function(item) {
        			     console.log(item.el[0]);
        				return ' <a class="image-source-link" href="'+item.el.attr('data-source')+'" target="_blank">'+ item.el.attr('title') + '</a>';
        			}
        		},
        		gallery: {
        			enabled: true,
                    navigateByImgClick: true,
                    preload: [0,1]
        		},
                zoom: {
        			enabled: true,
        			duration: 600, // duration of the effect, in milliseconds
                    easing: 'ease', // CSS transition easing function
        			opener: function(element) {
        				return element.find('img');
        			}
        		}
        	});	
    	}); 
         $('#bk-gallery-slider').each(function() { // the containers for all your galleries
            $(this).magnificPopup({
        		delegate: 'a.zoomer',
        		type: 'image',
        		closeOnContentClick: false,
        		closeBtnInside: false,
                removalDelay: 300,
        		//mainClass: 'mfp-with-zoom mfp-img-mobile',
                mainClass: 'mfp-fade',
        		image: {
                    tError: '<a href="%url%">The image #%curr%</a> could not be loaded.',
        			verticalFit: true,
        			titleSrc: function(item) {
        			 console.log(item.el[0]);
        				return ' <a class="image-source-link" href="'+item.src+'" target="_blank">'+ item.el.attr('title') + '</a>';
        			}
        		},
        		gallery: {
        			enabled: true,
                    navigateByImgClick: true,
                    preload: [0,1]
        		}
        	});	
    	});  
    // tiny helper function to add breakpoints
        function getGridSize() {
            return  (window.innerWidth < 500)  ? 1 :
                    (window.innerWidth < 1000) ? 2 :
                    (window.innerWidth < 1170) ? 3 : 4;
        }
        $(window).resize(function() {
            if (typeof flexslider !== 'undefined') {
                var gridSize = getGridSize();
                flexslider.vars.minItems = gridSize;
                flexslider.vars.maxItems = gridSize;
            }
        });
    //FW Slider	
        $('.flexslider').imagesLoaded(function(){		    
            $('.bk-slider-module .flexslider').flexslider({
                animation: 'fade',
                controlNav: false,
                animationLoop: true,
                slideshow: true,
                pauseOnHover: true,
                slideshowSpeed: 10000,
                animationSpeed: 400,
                smoothHeight: true,
                directionNav: true,
                nextText: '<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="50px" height="70px" viewBox="0 0 49 77" xml:space="preserve"><polyline fill="none" stroke="#FFFFFF" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" points="0.375,0.375 45.63,38.087 0.375,75.8 "></polyline></svg>',
                prevText: '<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="50px" height="70px" viewBox="0 0 49 77" xml:space="preserve"><polyline fill="none" stroke="#FFFFFF" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" points="45.63,75.8 0.375,38.087 45.63,0.375 "></polyline></svg>',
            });
    //Feature 2 slider 
            $('.module-feature2 .flexslider').flexslider({
                animation: 'fade',
                controlNav: false,
                animationLoop: true,
                slideshow: true,
                pauseOnHover: true,
                slideshowSpeed: 15000,
                animationSpeed: 400,
                smoothHeight: true,
                directionNav: true,
                nextText: '<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="50px" height="70px" viewBox="0 0 49 77" xml:space="preserve"><polyline fill="none" stroke="#FFFFFF" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" points="0.375,0.375 45.63,38.087 0.375,75.8 "></polyline></svg>',
                prevText: '<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="50px" height="70px" viewBox="0 0 49 77" xml:space="preserve"><polyline fill="none" stroke="#FFFFFF" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" points="45.63,75.8 0.375,38.087 45.63,0.375 "></polyline></svg>',
            });
    // Widget Slider 
            $('.widget_slider .flexslider').flexslider({
                animation: 'fade',
                controlNav: false,
                animationLoop: true,
                slideshow: true,
                pauseOnHover: true,
                slideshowSpeed: 8000,
                animationSpeed: 400,
                smoothHeight: true,
                directionNav: true,
                nextText: '<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="30px" height="40px" viewBox="0 0 49 77" xml:space="preserve"><polyline fill="none" stroke="#FFFFFF" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" points="0.375,0.375 45.63,38.087 0.375,75.8 "></polyline></svg>',
                prevText: '<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="30px" height="40px" viewBox="0 0 49 77" xml:space="preserve"><polyline fill="none" stroke="#FFFFFF" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" points="45.63,75.8 0.375,38.087 45.63,0.375 "></polyline></svg>',

            });
    // Gallery Slider
            $('#bk-gallery-slider').flexslider({
                animation: 'fade',
                controlNav: true,
                animationLoop: true,
                slideshow: false,
                pauseOnHover: true,
                slideshowSpeed: 5000,
                animationSpeed: 400,
                smoothHeight: true,
                directionNav: true,
                nextText: '<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="40px" height="60px" viewBox="0 0 49 77" xml:space="preserve"><polyline fill="none" stroke="#FFFFFF" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" points="0.375,0.375 45.63,38.087 0.375,75.8 "></polyline></svg>',
                prevText: '<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="40px" height="60px" viewBox="0 0 49 77" xml:space="preserve"><polyline fill="none" stroke="#FFFFFF" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" points="45.63,75.8 0.375,38.087 45.63,0.375 "></polyline></svg>',

            }); 
            //Megamenu
            if (typeof(megamenu_carousel_el) !== 'undefined') {
                var bk_megamenu_item;
                $.each( megamenu_carousel_el, function( id, maxitems ) {         
                    bk_megamenu_item = $('#'+id).find('.bk-sub-post').length;
                    if(bk_megamenu_item >= maxitems) {
                        $('#'+id).flexslider({
                            animation: "slide",
                            animationLoop: true,
                            slideshow: false,
                            itemWidth: 10,
                            minItems: maxitems,
                            maxItems: maxitems,
                            controlNav: false,
                            directionNav: true,
                            slideshowSpeed: 3000,
                            nextText: '<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="30px" height="40px" viewBox="0 0 49 77" xml:space="preserve"><polyline fill="none" stroke="#FFFFFF" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" points="0.375,0.375 45.63,38.087 0.375,75.8 "></polyline></svg>',
                            prevText: '<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="30px" height="40px" viewBox="0 0 49 77" xml:space="preserve"><polyline fill="none" stroke="#FFFFFF" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" points="45.63,75.8 0.375,38.087 45.63,0.375 "></polyline></svg>',

                            move: 1,
                            touch: true,
                            useCSS: true,
                        });
                    }else{
                        //console.log(bk_megamenu_item);
                        //console.log(maxitems);
                        $('#'+id).removeClass('flexslider');
                        $('#'+id).addClass('flexslider_destroy');
                    }
                });
            }
            if($('.product.flexslider ul li').length > 3) {
                $('.product.flexslider').flexslider({
                    animation: "slide",
                    animationLoop: false,
                    directionNav: true,
                    controlNav: false,
                    itemWidth: 50,
                    minItems: 1,
                    maxItems: 3,
                    prevText: '',
                    nextText: '',
                });
            }else {
                $('.product').removeClass('flexslider');
            }
        });
        waitForGallerySlider();
    // Breaking Slider 
        $('.module-breaking-carousel .bk-carousel-wrap').flexslider({
            animation: "slide",
            controlNav: false,
            itemWidth: 210,
            columnWidth: 1,
            pauseOnHover: true,
            move: 1,
            animationLoop: true,
            prevText: '',
            nextText: '',
            minItems: getGridSize(), // use function to pull in initial value
            maxItems: getGridSize(), // use function to pull in initial value
            start: function(slider){
                if (typeof flexslider !== 'undefined') {
                    flexslider = slider;
                }
            }
        });
        $('.module-grid .flexslider').flexslider({
            animation: 'fade',
            controlNav: false,
            animationLoop: true,
            slideshow: true,
            pauseOnHover: true,
            slideshowSpeed: 8000,
            animationSpeed: 400,
            smoothHeight: true,
            directionNav: true,
            nextText: '<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="30px" height="40px" viewBox="0 0 49 77" xml:space="preserve"><polyline fill="none" stroke="#FFFFFF" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" points="0.375,0.375 45.63,38.087 0.375,75.8 "></polyline></svg>',
            prevText: '<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="30px" height="40px" viewBox="0 0 49 77" xml:space="preserve"><polyline fill="none" stroke="#FFFFFF" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" points="45.63,75.8 0.375,38.087 45.63,0.375 "></polyline></svg>',

        });
    // Module carousel
        $('.carousel_2 .bk-carousel-wrap').flexslider({
            animation: "slide",
            controlNav: false,
            itemWidth: 245,
            columnWidth: 1,
            pauseOnHover: true,
            move: 1,
            animationLoop: true,
            prevText: '',
            nextText: '',
            minItems: 1, // use function to pull in initial value
            maxItems: 2, // use function to pull in initial value
        });
        $('.carousel_3 .bk-carousel-wrap').flexslider({
            animation: "slide",
            controlNav: false,
            itemWidth: 245,
            columnWidth: 1,
            pauseOnHover: true,
            move: 1,
            animationLoop: true,
            prevText: '',
            nextText: '',
            minItems: 1, // use function to pull in initial value
            maxItems: 3, // use function to pull in initial value
        });
        $('.module-carousel-2 .bk-carousel-wrap').flexslider({
            animation: "slide",
            controlNav: false,
            itemWidth: 310,
            columnWidth: 1,
            pauseOnHover: true,
            move: 1,
            animationLoop: true,
            slideshowSpeed: 8000,
            animationSpeed: 400,
            nextText: '<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="50px" height="70px" viewBox="0 0 49 77" xml:space="preserve"><polyline fill="none" stroke="#FFFFFF" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" points="0.375,0.375 45.63,38.087 0.375,75.8 "></polyline></svg>',
            prevText: '<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="50px" height="70px" viewBox="0 0 49 77" xml:space="preserve"><polyline fill="none" stroke="#FFFFFF" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" points="45.63,75.8 0.375,38.087 45.63,0.375 "></polyline></svg>',
            minItems: 1, // use function to pull in initial value
            maxItems: 3, // use function to pull in initial value
        });
    // Masonry Module Init
        $('#page-wrap').imagesLoaded(function(){
            setTimeout(function() {
                if($('.bk-masonry-content').find('.item').length > 2){
                    $('.bk-masonry-content').masonry({
                        itemSelector: '.item',
                        columnWidth: 1,
                        isAnimated: true,
                        isFitWidth: true,
                     });
                }
                $('.ajax-load-btn').addClass('active');
                $('.bk-masonry-content').find('.post-c-wrap').removeClass('sink');
                $('.bk-masonry-content').find('.post-category').removeClass('sink');
    
             },500);
        });
    
        $('.menu-toggle').toggle(function(){
            $('.open-icon').removeClass('hide');
            $('.close-icon').addClass('hide');
            $('.share-label').addClass('hide');
            $('.top-share').removeClass('hide');
    
        },function(){
            $('.close-icon').removeClass('hide');
            $('.open-icon').addClass('hide');
            $('.share-label').removeClass('hide');
            $('.top-share').addClass('hide');
        });
        
        // Back top
    	$(window).scroll(function () {
    		if ($(this).scrollTop() > 500) {
    			$('#back-top').css('bottom','0');
    		} else {
    			$('#back-top').css('bottom','-34px');
    		}
    	});
        
    	// scroll body to top on click
    	$('#back-top').on("click", function(){
    		$('body,html').animate({
    			scrollTop: 0,
    		}, 1300);
    		return false;
    	});
        if ((typeof fixed_nav !== 'undefined') && (fixed_nav == 2)) {
            var nav = $('nav.main-nav');
            var d = nav.offset().top;
            $(window).scroll(function () {
                if ($(this).scrollTop() > d) {
                    nav.addClass("fixed");
                    //menu fixed if have admin bar
                    var ad_bar = $('#wpadminbar');
                    if(ad_bar.length != 0) {
                        $('.main-nav').css('margin-top',ad_bar.height());
                    }
                } else {
                    nav.removeClass("fixed");
                    $('.main-nav').css('margin-top','0');
                }
            });
        }
        // Single Parallax
        var bkParallaxWrap = $('#bk-parallax-feat'),
            bkParallaxFeatImg = bkParallaxWrap.find('.s-feat-img');
        if ( bkParallaxFeatImg.length !== 0 ) {
            $(window).scroll(function() {
            //console.log(bkParallaxFeatImg.offset().top);
            var bkBgy_p = -( ($(window).scrollTop()) / 3.5),
                bkBgPos = '50% ' + bkBgy_p + 'px';
            
            bkParallaxFeatImg.css( "background-position", bkBgPos );
            
            });
        }
        //Rating canvas
        var canvasArray  = $('.rating-canvas');
        $.each(canvasArray, function(i,canvas){
            var percent = $(canvas).data('rating');
            var ctx     = canvas.getContext('2d');
    
            canvas.width  = $(canvas).parent().width();
            canvas.height = $(canvas).parent().height();
    
            var x = (canvas.width) / 2;
            var y = (canvas.height) / 2;
            if ($(canvas).parents().hasClass('review-score')) {
                var radius = (canvas.width - 6) / 2;
                var lineWidth = 2;
            } else {
                var radius = (canvas.width - 10) / 2;
                var lineWidth = 4;
            }
                    
            var endAngle = (Math.PI * percent * 2 / 100);
            ctx.beginPath();
            ctx.arc(x, y, radius, -(Math.PI/180*90), endAngle - (Math.PI/180*90), false);   
            ctx.lineWidth = lineWidth;
            ctx.strokeStyle = "#fff";
            ctx.stroke();  
        });
        $(".bk-tipper-bottom").tipper({
            direction: "bottom"
        });
    
    
          // Calculate total shares
          var renders = 0;
          var share_items = $('.share-box').find('li').length;
          $(document).on('share-box-rendered', function(){
            renders++;
            if ( renders == share_items ) {
                var total_shares = 0;
                $('.share-box .share-item__value').each(function(i,e){
                  var value = parseInt($(this).text());
                  if ( !isNaN(value) ) {
                    total_shares = total_shares + value;
                  }
                });
                if (total_shares >= 1e6){
                  total_shares = (total_shares / 1e6).toFixed(2) + "M"
                } else if (total_shares >= 1e3){ 
                  total_shares = (total_shares / 1e3).toFixed(1) + "k"
                }
                $('.share-total__value').html(total_shares);
            }
          });
    /* Sidebar stick */    
         var win, tick, curscroll, nextscroll; 
        win = $(window);
        var width = $('.sidebar-wrap').width();
        tick = function() {
            nextscroll = win.scrollTop();
            $(".sidebar-wrap.stick").each(function(){
                var bottom_compare, top_compare, screen_scroll, parent_top, parent_h, parent_bottom, scroll_status = 0, topab; 
                var sbID = "#"+$(this).attr(("id"));
                //var sbID = "#bk_sidebar_4";
                //console.log(sbID);
                bottom_compare = $(sbID).offset().top + $(sbID).outerHeight(true);
                screen_scroll = win.scrollTop() + win.height();
                parent_top = $(sbID).parents('.bksection').offset().top;
                parent_h = $(sbID).parents('.bksection').height();
                parent_bottom = parent_top + parent_h;
                if($(sbID).parents('.bksection').hasClass('bk-in-single-page')) {
                    topab =  parent_h - $(sbID).outerHeight(true) - 50;
                }else {
                    topab =  parent_h - $(sbID).outerHeight(true);                            
                }
                
                if(window.innerWidth > 991) {
                    if(parent_h > $(sbID).outerHeight(true)) {
                        //console.log(win.scrollTop()  + "  " +  (parent_bottom - $(sbID).outerHeight(true)) + "   " + scroll_status);
                        if(win.scrollTop() < parent_top) {
                            scroll_status = 0;
                        }else if((win.scrollTop() >= parent_top) && (screen_scroll < parent_bottom)) {
                            //console.log(curscroll+ "    "+nextscroll);
                            if(curscroll <= nextscroll) {
                                scroll_status = 1;
                            }else if(curscroll > nextscroll) {
                                scroll_status = 3;
                            }
                        }else if(screen_scroll >= parent_bottom) {
                            scroll_status = 2;
                        } 
                        if(scroll_status == 0) {
                            $(sbID).css({
                                "position"  : "static",
                                "top"       : "auto",
                                "bottom"    : "auto"
                            });
                        }else if (scroll_status == 1) {
                            if(win.height() > $(sbID).outerHeight(true)) {
                                var ad_bar = $('#wpadminbar');
                                if (fixed_nav == 2) {
                                    if(ad_bar.length != 0) {
                                        var sb_height_fixed = 16 + ad_bar.height() + $('.main-nav').height() + 'px';
                                    }
                                    else {
                                        var sb_height_fixed = 16 + $('.main-nav').height() + 'px';
                                    }

                                }else {
                                    if(ad_bar.length != 0) {
                                        var sb_height_fixed = 16 + ad_bar.height() + 'px';
                                    }else {
                                        var sb_height_fixed = 16 + 'px';
                                    }
                                }
                                $(sbID).css({
                                    "position"  : "fixed",
                                    "top"       : sb_height_fixed,
                                    "bottom"    : "auto",
                                    "width"     : width
                                });
                            }else {
                                if (screen_scroll < bottom_compare) {
                                    //console.log($(sbID).offset().top + "   " + parent_top);
                                    if($(sbID).parents('.bksection').hasClass('bk-in-single-page')) {
                                        topab = $(sbID).offset().top - parent_top - 50;  
                                    }else {
                                        topab = $(sbID).offset().top - parent_top;                            
                                    }
                                    $(sbID).css({
                                        "position"  : "absolute",
                                        "top"       : topab,
                                        "bottom"    : "auto",
                                        "width"     : width
                                    });
                                }else {
                                    $(sbID).css({
                                        "position"  : "fixed",
                                        "top"       : "auto",
                                        "bottom"    : "16px",
                                        "width"     : width
                                    });
                                }
                            }
                        }else if (scroll_status == 3) {
                            if (win.scrollTop() > ($(sbID).offset().top)) {
                                if($(sbID).parents('.bksection').hasClass('bk-in-single-page')) {
                                    topab = $(sbID).offset().top - parent_top - 50;  
                                }else {
                                    topab = $(sbID).offset().top - parent_top;                            
                                }
                                $(sbID).css({
                                    "position"  : "absolute",
                                    "top"       : topab,
                                    "bottom"    : "auto",
                                    "width"     : width
                                });
                            }else {
                                var ad_bar = $('#wpadminbar');
                                if (fixed_nav == 2) {
                                    if(ad_bar.length != 0) {
                                        var sb_height_fixed = 16 + ad_bar.height() + $('.main-nav').height() + 'px';
                                    }
                                    else {
                                        var sb_height_fixed = 16 + $('.main-nav').height() + 'px';
                                    }

                                }else {
                                    if(ad_bar.length != 0) {
                                        var sb_height_fixed = 16 + ad_bar.height() + 'px';
                                    }else {
                                        var sb_height_fixed = 16 + 'px';
                                    }
                                }
                                $(sbID).css({
                                    "position"  : "fixed",
                                    "top"       : sb_height_fixed,
                                    "bottom"    : "auto",
                                    "width"     : width
                                });
                            }
                        }else if(scroll_status == 2) {
                            if(win.height() > $(sbID).outerHeight(true)) {
                                var status2_inner = 0;
                                if(curscroll <= nextscroll) {
                                    status2_inner = 1;
                                }else if(curscroll > nextscroll) {
                                    status2_inner = 2;
                                }
                                if(((status2_inner == 1) && (bottom_compare < parent_bottom)) || ((status2_inner == 2) && (win.scrollTop() < $(sbID).offset().top))){
                                    var ad_bar = $('#wpadminbar');
                                    if (fixed_nav == 2) {
                                        if(ad_bar.length != 0) {
                                            var sb_height_fixed = 16 + ad_bar.height() + $('.main-nav').height() + 'px';
                                        }
                                        else {
                                            var sb_height_fixed = 16 + $('.main-nav').height() + 'px';
                                        }
    
                                    }else {
                                        if(ad_bar.length != 0) {
                                            var sb_height_fixed = 16 + ad_bar.height() + 'px';
                                        }else {
                                            var sb_height_fixed = 16 + 'px';
                                        }
                                    }
                                    $(sbID).css({
                                        "position"  : "fixed",
                                        "top"       : sb_height_fixed,
                                        "bottom"    : "auto",
                                        "width"     : width
                                    });
                                }else {
                                    $(sbID).css({
                                        "position"  : "absolute",
                                        "top"       : topab,
                                        "bottom"    : "auto",
                                        "width"     : width
                                    });
                                }
                            }else {
                                $(sbID).css({
                                    "position"  : "absolute",
                                    "top"       : topab,
                                    "bottom"    : "auto",
                                    "width"     : width
                                });
                            }
                        }      
                    }
                }   
                $(sbID).parent().css("height", $(sbID).height());   
            });
            curscroll = nextscroll;
        }
        $(".sidebar-wrap.stick").each(function(){
            $(this).wrap("<div class='bk-sticksb-wrapper'></div>");
        });
        delay(function () {
            win.on("scroll", tick);
        }, 2000);
        win.resize(function(){
            $(".sidebar-wrap.stick").each(function(){
                var sbID = "#"+$(this).attr(("id"));
                if(window.innerWidth > 991) {
                    if($(this).parent().hasClass('bk-sticksb-wrapper')){
                        width = $('.bk-sticksb-wrapper').width();
                        $(sbID).css({
                            "width"     : width
                        });
                    }
                }else {
                    $(sbID).css({
                        "position"  : "static",
                        "top"       : "auto",
                        "bottom"    : "auto"
                    });
                }  
            });
        });
        //Short Code 
        $('.module-shortcode').fitVids();
        $('.shortcode-widget-content').fitVids();
        $('.bk_accordions').each(function(){
            var accordions_id=$(this).attr('id');
            if(accordions_id){
                $('#'+accordions_id).accordion({
                    icons:{'header':'ui-icon-plus sprites','activeHeader':'ui-icon-minus sprites'},
                    collapsible:true
                });
            }
        });
        $('.bk_tabs').each(function(){
            var tabs_id=$(this).attr('id');
            if(tabs_id){
                $('#'+tabs_id).tabs();
            }
        });
            
        // Parallax
        // Single Parallax
        var bkscParallax = $('.bkparallaxsc');
        var bkscParallaxImg = new Array();
        $.each( bkscParallax, function( index, value ) {       
            bkscParallaxImg[index] = $(this).find('.parallaximage');
        });
        $(window).scroll(function() {
            $.each( bkscParallaxImg, function( index, value ) {       
                if ( bkscParallaxImg[index].length !== 0 ) {
                    //console.log(bkscParallaxImg.offset().top);
                    var bkBgy_p = -( ($(window).scrollTop() - bkscParallaxImg[index].offset().top) / 3.5),
                        bkBgPos = '50% ' + bkBgy_p + 'px';
                    bkscParallaxImg[index].css( "background-position", bkBgPos );
                }
            });
        });
    });    
    function bkgetFeatureImage() { 
    	var metas = document.getElementsByTagName('meta'); 
        var i;
    	for (i=0; i<metas.length; i++) { 
    	   if (metas[i].getAttribute("property") == "og:image") { 
    		  return metas[i].getAttribute("content"); 
    	   } else if (metas[i].getAttribute("property") == "image") { 
    		  return metas[i].getAttribute("content");  
    	   } else if (metas[i].getAttribute("property") == "twitter:image:src") { 
    		  return metas[i].getAttribute("content");  
    	   }
    	}
    
    	return "";
    }
    
    function waitForGallerySlider() {
     	// if slider is loaded
    	if ($("#bk-gallery-slider").children('div:first').hasClass('flex-viewport')) {
            $(".bk-gallery-item").each(function(){
                if($(this).hasClass('clone')){
                    $(this).children('a').removeClass('zoomer');
                }
            });
            return false;
    	}	
    	else
    	{
    		// Wait another 0,5 seconds
    		setTimeout(waitForGallerySlider, 500); 
    	}	
    }
})(jQuery);