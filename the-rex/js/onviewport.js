(function($){"use strict";

  /**
   * Copyright 2012, Digital Fusion
   * Licensed under the MIT license.
   * http://teamdf.com/jquery-plugins/license/
   *
   * @author Sam Sehnert
   * @desc A small plugin that checks whether elements are within
   *     the user visible viewport of a web browser.
   *     only accounts for vertical position, not horizontal.
   */

  $.fn.visible = function(partial) {
    if (typeof ($(this).offset()) !== 'undefined') {
        
        var $t            = $(this),
          $w            = $(window),
          viewTop       = $w.scrollTop(),
          viewBottom    = viewTop + $w.height(),
          _top          = $t.offset().top,
          _bottom       = _top + $t.height(),
          compareTop    = partial === true ? _bottom : _top,
          compareBottom = partial === true ? _top : _bottom;
        
        return (((compareBottom <= viewBottom) && (compareTop >= viewTop)) || ((compareBottom <= viewBottom) && (compareTop >= viewTop)));
    }

  };
  jQuery(document).ready(function($) {
    
        var bkWindow = $(window),
            bkRatingBars = $('.bk-overlay').find('.bk-zero-trigger'),
            bkthumbnail, bkcalendarmeta;
        
        $('#body-wrapper').imagesLoaded(function(){
            setTimeout(function() {
                bkthumbnail = $('#page-wrap').find('.thumb');
                $.each(bkthumbnail, function(i, value) {
                    var bkValue = $(value);
                    if (( bkValue.visible(true) )&& ( bkValue.hasClass('hide-thumb'))) {
                        bkValue.removeClass('hide-thumb');                
                    } 
                });
                bkcalendarmeta = $('#page-wrap').find('.bk-calendar-meta');
                $.each(bkcalendarmeta, function(i, value) {
                    var bkCalendarMeta = $(value);
                    if (( bkCalendarMeta.visible(true) )&& ( bkCalendarMeta.hasClass('bk-hide-calendar'))) {
                        bkCalendarMeta.removeClass('bk-hide-calendar');                
                    } 
                });
                $.each(bkRatingBars, function(i, value) {
                    var bkValue = $(value);
                    if ( bkValue.visible(true) ) {
                        bkValue.removeClass('bk-zero-trigger'); 
                        bkValue.addClass('bk-bar-ani'); 
                   
                    } 
                });
            },1200);
        });   
     
        setTimeout(function() {
            bkWindow.scroll(function(event) {
                bkthumbnail = $('#page-wrap').find('.thumb');
                $.each(bkthumbnail, function(i, value) {
                    var bkValue = $(value);
                    if ( ( bkValue.visible(true) ) && ( bkValue.hasClass('hide-thumb') ) ) {
                        bkValue.removeClass('hide-thumb');  
                    } 
                });    
                bkcalendarmeta = $('#page-wrap').find('.bk-calendar-meta');
                $.each(bkcalendarmeta, function(i, value) {
                    var bkCalendarMeta = $(value);
                    if (( bkCalendarMeta.visible(true) )&& ( bkCalendarMeta.hasClass('bk-hide-calendar'))) {
                        bkCalendarMeta.removeClass('bk-hide-calendar');                
                    } 
                }); 
                $.each(bkRatingBars, function(i, value) {
                    var bkValue = $(value);
                    if ( ( bkValue.visible(true) ) && ( bkValue.hasClass('bk-zero-trigger') ) ) {
        
                      bkValue.removeClass('bk-zero-trigger'); 
                      bkValue.addClass('bk-bar-ani'); 
                    } 
                });
            });
        },2000);  
        
          	/* Show bottom single post recommend box */
    	if ($('.recommend-box')[0]) {
    		var random_post = $('.recommend-box');
            bkWindow.scroll(function(event) {
        		if ($('.footer').visible(true)){
        			random_post.addClass('recommend-box-on');
        		} else {
        			random_post.removeClass('recommend-box-on');
        		}
            });
    		
    		$('.recommend-box .close').on("click", function(e){
    			e.preventDefault();
    			$('.recommend-box').toggleClass('recommend-box-on recommend-box-off');
    		});
    	}
    }); 
})(jQuery);