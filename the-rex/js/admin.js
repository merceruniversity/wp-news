/* -----------------------------------------------------------------------------
 * Page Template Meta-box
 * -------------------------------------------------------------------------- */
;(function( $, window, document, undefined ){
	"use strict";
	
	$( document ).ready( function () {
        function selectAndScrollToOption(select) {
            var $select;
            var $selectedOptions
            $select = $(select);
            $select.each(function(index,el){
                // Store the currently selected options
                $selectedOptions = $(el).find("option[selected]");
                       
                // Re-select the original options
                $selectedOptions.prop("selected", true);
            });
        }
        var select = $('.bk-category-field');

        selectAndScrollToOption(select);
		/* -----------------------------------------------------------------------------
		 * Page template
		 * -------------------------------------------------------------------------- */
		$( '#page_template' ).change( function() {
			var template = $( '#page_template' ).val();

			// Page Composer Template
			if ( 'page_builder.php' == template ) {
				
				$.page_builder( 'show' );
				$( '#bk_page_options' ).hide();

			} else {
				$.page_builder( 'hide' );
				$( '#bk_page_options' ).show();
			}
		} ).triggerHandler( 'change' );

		// -----------------------------------------------------------------------------
		// Fitvids - keep video ratio
		// 
//		$( '.postbox .embed-code' ).fitVids( { customSelector: "iframe[src*='maps.google.'], iframe[src*='soundcloud.']" });
        /*
        $(function() {
            $( ".datepicker" ).datepicker();
            $('.timepicker').timepicker({
                minuteStep: 5,
                showInputs: false,
                disableFocus: true
            });
         });
         */
        $(function() {
            if ($('input[name=post_format]:checked', '#post-formats-select').val() == 0) {
                $("#bk_format_options").hide();
            }else {
                var value = $('input[name=post_format]:checked', '#post-formats-select').val(); 
                $("#bk_format_options").show();
                if (value == "gallery"){
                    $("#bk_media_embed_code_post_description").parents(".rwmb-field").css("display", "none");
                    $("#bk_image_upload_description").parents(".rwmb-field").css("display", "none");
                    $("#bk_gallery_content_description").parents(".rwmb-field").css("display", "block");
                    $("#bk_popup_frame_description").parents(".rwmb-field").css("display", "none");
                }else if ((value == "video")||(value == "audio")){
                    $("#bk_media_embed_code_post_description").parents(".rwmb-field").css("display", "block");
                    $("#bk_image_upload_description").parents(".rwmb-field").css("display", "none");
                    $("#bk_gallery_content_description").parents(".rwmb-field").css("display", "none");
                    $("#bk_popup_frame_description").parents(".rwmb-field").css("display", "block");
                }else if (value == "image"){
                    $("#bk_media_embed_code_post_description").parents(".rwmb-field").css("display", "none");
                    $("#bk_image_upload_description").parents(".rwmb-field").css("display", "block");
                    $("#bk_gallery_content_description").parents(".rwmb-field").css("display", "none");
                    $("#bk_popup_frame_description").parents(".rwmb-field").css("display", "none");
                }
            }
            $('#post-formats-select input').on('change', function() { 
                var value = $('input[name=post_format]:checked', '#post-formats-select').val(); 
                if (value == 0){
                    $("#bk_format_options").hide();
                }else {
                    $("#bk_format_options").show();
                } 
                if (value == "gallery"){
                    $("#bk_media_embed_code_post_description").parents(".rwmb-field").css("display", "none");
                    $("#bk_image_upload_description").parents(".rwmb-field").css("display", "none");
                    $("#bk_gallery_content_description").parents(".rwmb-field").css("display", "block");
                    $("#bk_popup_frame_description").parents(".rwmb-field").css("display", "none");
                }else if ((value == "video")||(value == "audio")){
                    $("#bk_media_embed_code_post_description").parents(".rwmb-field").css("display", "block");
                    $("#bk_image_upload_description").parents(".rwmb-field").css("display", "none");
                    $("#bk_gallery_content_description").parents(".rwmb-field").css("display", "none");
                    $("#bk_popup_frame_description").parents(".rwmb-field").css("display", "block");
                }else if (value == "image"){
                    $("#bk_media_embed_code_post_description").parents(".rwmb-field").css("display", "none");
                    $("#bk_image_upload_description").parents(".rwmb-field").css("display", "block");
                    $("#bk_gallery_content_description").parents(".rwmb-field").css("display", "none");
                    $("#bk_popup_frame_description").parents(".rwmb-field").css("display", "none");
                }
            });
        });
	} );
})( jQuery, window , document );
/* -----------------------------------------------------------------------------
 * UUID
 * https://github.com/eburtsev/jquery-uuid/blob/master/jquery-uuid.js
 * -------------------------------------------------------------------------- */
;(function( $, window, document, undefined ){
	$.uuid = function() {
		return 'xxxxxxxx-xxxx-4xxx-yxxx-xxxxxxxxxxxx'.replace(/[xy]/g, function(c) {
			var r = Math.random()*16|0, v = c == 'x' ? r : (r&0x3|0x8);
			return v.toString(16);
		});
	};
})( jQuery, window , document );
