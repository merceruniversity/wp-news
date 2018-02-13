(function($) {
  "use strict";
  $=jQuery;
  	function isWysiwygareaAvailable() {
		// If in development mode, then the wysiwygarea must be available.
		// Split REV into two strings so builder does not replace it :D.
		if ( CKEDITOR.revision == ( '%RE' + 'V%' ) ) {
			return true;
		}

		return !!CKEDITOR.plugins.get( 'wysiwygarea' );
	}
    $( document ).ready( function() {
        var $this;
        var MAX_CHILD = 100;
        if ( CKEDITOR.env.ie && CKEDITOR.env.version < 9 )
        	CKEDITOR.tools.enableHtml5Elements( document );
        
        // The trick to keep the editor in the sample quite small
        // unless user specified own height.
        CKEDITOR.config.height = 150;
        CKEDITOR.config.width = 'auto';
        $.extend( {
    		page_builder: function( action ) {
    			if ( 'show' == action ) {
    				BK_PAGE_BUILDER.show();
    			} else if ( 'hide' == action ) {
    				BK_PAGE_BUILDER.hide();
    			}
    		},
    	} );
    	var BK_PAGE_BUILDER = {
    		bk_wrapper: {
    			wrapper: '#bk-container',
    		},
    
    		run_cfg: function( options ) {
                $this = this;
    
                $this.section_nth = 1;
                
    			$this.options = $.extend( {}, $this.bk_wrapper, options );
    
    			$this.$bkcontainer = $( $this.options.wrapper );
    
    			$this.sec_menu_cfg();
    	
        		$this.bk_sec_cfg();
    		},
    
    		bk_sec_cfg: function() {
    			$this.$bk_sections = $this.$bkcontainer.find( '.bk-sections' );
    			for ( var i = 1; i <= MAX_CHILD; i++ ) {
    				var blk_order = 'bk_section_'+i;
    				var bk_sec_format = $this.bk_get_blk_val( blk_order );
                    //console.log(bk_sec_format);
                                
    				if ( ! bk_sec_format ) break;
    
    				var $section = $this.add_section( bk_sec_format, blk_order );
                    //console.log(bk_sec_format);
                    if (bk_sec_format =='has-rsb') {
                        $this.$bk_modules = $section.find(".bk-modules-wrap");
                        var $sidebar = $( $( '#bk-sidebar-template' ).html() ); //get template module
                        $sidebar.find( '.bk-sidebar-order').attr( 'name', 'bk_sidebar_order_'+($this.section_nth - 1) ).val($this.bk_get_blk_val( 'bk_sidebar_'+i )); 
                        $this.$bk_modules.append ($sidebar);
                        $this.$bk_modules = $section.find(".bk-modules");
                    }else if(bk_sec_format =='has-innersb') {
                        //console.log($section.find(".bk-modules-wrap"));
                        $this.$bk_modules = $section.find(".bk-modules-wrap");
                        var $sidebar = $( $( '#bk-sidebar-template' ).html() ); //get template module
                        $sidebar.find( '.bk-sidebar-order').attr( 'name', 'bk_sidebar_order_'+($this.section_nth - 1) ).val($this.bk_get_blk_val( 'bk_sidebar_'+i )); 
                        $this.$bk_modules.append ($sidebar);
                        $this.$bk_modules = $section.find(".bk-modules");
                    }
                    
                    for ( var j = 1; j <= MAX_CHILD; j++ ) {
        				var blk_order = 'bk_fullwidth_module_'+i+'_'+j;
        				var bk_sec_format = $this.bk_get_blk_val( blk_order );
        				if ( ! bk_sec_format ) break;
        
        				$this.module_append( bk_sec_format, blk_order, 'fullwidth' );
        			}
                    for ( var j = 1; j <= MAX_CHILD; j++ ) {
        				var blk_order = 'bk_has_rsb_module_'+i+'_'+j;
        				var bk_sec_format = $this.bk_get_blk_val( blk_order );         
        				if ( ! bk_sec_format ) break;
        
        				$this.module_append( bk_sec_format, blk_order, 'has-rsb' );
        			}
                    for ( var j = 1; j <= MAX_CHILD; j++ ) {
        				var blk_order = 'bk_leftsec_module_'+i+'_'+j;
        				var bk_sec_format = $this.bk_get_blk_val( blk_order );           
        				if ( ! bk_sec_format ) break;
        
        				$this.module_append( bk_sec_format, blk_order, 'has-innersb' );
        			}
                    for ( var j = 1; j <= MAX_CHILD; j++ ) {
        				var blk_order = 'bk_rsec_module_'+i+'_'+j;
        				var bk_sec_format = $this.bk_get_blk_val( blk_order );         
        				if ( ! bk_sec_format ) break;
        
        				$this.module_append( bk_sec_format, blk_order, 'has-innersb' );
        			}
    			}
    
    			$this.$bk_sections.sortable( { handle: ".bk-sec-sort-ctrl, .bk-sec-label", placeholder: 'bk-sec-placeholder', forcePlaceholderSize: true, 
                    update: function(e, ui) {
                        var new_sectionid, new_moduleid;
                        var module_el;
                        var i, module_elorder = Array ;
                        ui.item.parent().find(".bk-section-nth").each(function(item, element){
                            new_sectionid = item+1;
                            element.setAttribute("id",new_sectionid); 
                        });
                        
                        ui.item.parent().find(".bk-section").each(function(item, element){
                            new_moduleid = item+1;
                            module_el = element.getElementsByClassName("bk-module-item");
                            //Arrange Modules
                            for(i=0; i < (module_el.length); i++){
                                module_elorder = module_el.item(i).getElementsByClassName("bk_module_order")[0];
                                //console.log(module_elorder.name);
                                if(module_elorder.name.substring(0,25) == 'bk_fullwidth_module_order'){
                                    module_elorder.name = "bk_fullwidth_module_order_"+new_moduleid+"[]";
                                }else if(module_elorder.name.substring(0,23) == 'bk_leftsec_module_order'){
                                    module_elorder.name = "bk_leftsec_module_order_"+new_moduleid+"[]";                             
                                }else if(module_elorder.name.substring(0,20) == 'bk_rsec_module_order'){
                                    module_elorder.name = "bk_rsec_module_order_"+new_moduleid+"[]";                             
                                }else if(module_elorder.name.substring(0,23) == 'bk_has_rsb_module_order'){
                                    module_elorder.name = "bk_has_rsb_module_order_"+new_moduleid+"[]";                            
                                }                               
                            }
                            // Arrange sidebar
                            var sectionName = element.className.split(' ')[1];
                            if((sectionName == 'has-rsb') || (sectionName == 'has-innersb')) {
                                element.getElementsByClassName('bk-sidebar-order')[0].name = 'bk_sidebar_order_'+new_moduleid ;
                            }   
                        });
                     },
                } );
    			$this.$bk_sections.find( '.bk-section-loading' ).remove();
    		},
    
    		sec_menu_cfg: function() {
    			$this.$append_sec_btn = $this.$bkcontainer.find( '#add-section-button' ).dropdown();
    			var $menu_list = $this.$bkcontainer.find( '.bk-toolbox .menu' );
    			
    			$.each( bk_sections, function( bk_sec_format, section_settings ) {
    				var $menu_item = $( '<li role="presentation"><a role="menuitem" tabindex="-1" href="#"></a></li>' );  //get menu list
    				$menu_item.find( 'a' )
    					.data( 'bk-section-type', bk_sec_format );
    //                    console.log(bk_sec_format); 
                    $menu_item.addClass (bk_sec_format);
                    $menu_list.append( $menu_item );
    			} );
    			$menu_list.find( 'a' ).click( $this.add_sec_event );
    		},
    
    		init_section: function( $new_section ) {
    			$new_section.find( '.bk-section-bar, .bk-section-open-option' ).click( $this.on_click_open_section );
    			$new_section.find( '.bk-section-delete' ).click( $this.on_click_delete_section );
    		},
    
    		add_section: function( bk_sec_format, blk_order ) {
    			if ( 'undefined' === typeof bk_sections[bk_sec_format] ) return;
    			
    			var uuid = $.uuid();
    			var id = 'bk_sections['+uuid+']';
                //console.log(bk_sec_format);
                //alert (bk_sec_format);
                if(bk_sec_format =='fullwidth'){
                    var $new_section = $( $( '#bk-template-fullwidth-html' ).html() ); //get template section
                    $new_section.find( '.bk-sec-label' ).html( bk_sections[bk_sec_format] );  
                }else if(bk_sec_format =='has-innersb'){
                    var $new_section = $( $( '#bk-template-has-innersb-html' ).html() ); //get template section
                    $new_section.find( '.bk-sec-label' ).html( bk_sections[bk_sec_format] );  
                }else if(bk_sec_format =='has-rsb'){
                    var $new_section = $( $( '#bk-template-rsb-html' ).html() ); //get template section
                    $new_section.find( '.bk-sec-label' ).html( bk_sections[bk_sec_format] );  
                }
    			//var $new_option = $this.render_section_options( bk_sec_format, id, blk_order );
                
    			//$new_section.find( '.bk-section-options' ).append( $new_option );
                $new_section.find( '.bk-section-nth').attr( 'id', $this.section_nth );            
    			$new_section.find( '.bk-section-type' ).attr( 'name', id+'[_type]' ).val( bk_sec_format );
    			$new_section.find( '.bk-section-order' ).val( uuid );
    
    			$this.$bk_sections.append( $new_section );       //append to placeholder
    
                $this.module_menu_cfg($new_section);
                
                $this.init_modules();
                
    			$this.init_section( $new_section );           //init to slidetoggle, delete
                
                $this.section_nth ++;
                
    			return $new_section;
    		},
    
            bk_get_blk_val: function( blk_order ) {
    			if ( ! blk_order ) return false;
    			var $custom_field = $( '#postcustom input[value='+blk_order+']' );
    			if ( ! $custom_field.length ) return false;
    
    			var meta_id = $custom_field.attr( 'id' ).match(/[0-9]+/);                      
                                        
    			return $( '#postcustom *[name=meta\\['+meta_id+'\\]\\[value\\]]' ).val();
    		},        
    
    		add_sec_event: function( e ) {
    //		  console.log($this);
    			var bk_sec_format = $( e.target ).data( 'bk-section-type' );
    			var $new_section = $this.add_section( bk_sec_format, false );
                if (bk_sec_format =='has-rsb'){
                    $this.$bk_modules = $new_section.find(".bk-modules-wrap");
                    //console.log($this.$bk_modules);
                    var $sidebar = $( $( '#bk-sidebar-template' ).html() ); //get template module
                    $sidebar.find( '.bk-sidebar-order').attr( 'name', 'bk_sidebar_order_'+($this.section_nth - 1) );
                    //console.log($sidebar.find( '.bk-sidebar-order'));    
                    $this.$bk_modules.append ($sidebar);
                    $this.$bk_modules = $new_section.find(".bk-modules");
                }else if(bk_sec_format =='has-innersb') {
                    $this.$bk_modules = $new_section.find(".bk-modules-wrap");
                    //console.log($this.$bk_modules);
                    var $sidebar = $( $( '#bk-sidebar-template' ).html() ); //get template module
                    $sidebar.find( '.bk-sidebar-order').attr( 'name', 'bk_sidebar_order_'+($this.section_nth - 1) );
                    //console.log($sidebar.find( '.bk-sidebar-order'));    
                    $this.$bk_modules.append ($sidebar);
                    $this.$bk_modules = $new_section.find(".bk-modules");
                }
    			$new_section.find( '.bk-section-open-option' ).trigger( 'click' );
    			$this.$append_sec_btn.dropdown( 'toggle' );
    			return false;
    		},
            
            hasClass: function(element, cls) {
                return (' ' + element.className + ' ').indexOf(' ' + cls + ' ') > -1;
            },        
    		on_click_delete_section: function( e ) {
                var nth = 1, i;
                var section_container;
                var module_element;
                var module_elorder;
                var new_moduleid = 0;
    		    $( e.target ).parents( '.bk-section' ).addClass("beremoved");
                section_container = $(e.target).parents('.bk-sections');
                section_container.find(".bk-section").each(function(sectionitem, sectionelement){
                    new_moduleid = new_moduleid + 1;
                    if($this.hasClass(sectionelement, 'beremoved')){
                        sectionelement.remove();
                        new_moduleid = new_moduleid - 1;
                        $this.section_nth--;                    
                    }else{
                        sectionelement.getElementsByClassName("bk-section-nth")[0].id=nth;
                        module_element = sectionelement.getElementsByClassName("bk-module-item");
                        //Arrange modules
                        for(i=0; i < (module_element.length); i++){
                            module_elorder = module_element.item(i).getElementsByClassName("bk_module_order")[0];
                            if(module_elorder.name.substring(0,25) == 'bk_fullwidth_module_order'){
                                module_elorder.name = "bk_fullwidth_module_order_"+new_moduleid+"[]";
                            }else if(module_elorder.name.substring(0,23) == 'bk_leftsec_module_order'){
                                module_elorder.name = "bk_leftsec_module_order_"+new_moduleid+"[]";                             
                            }else if(module_elorder.name.substring(0,20) == 'bk_rsec_module_order'){
                                module_elorder.name = "bk_rsec_module_order_"+new_moduleid+"[]";                             
                            }else if(module_elorder.name.substring(0,23) == 'bk_has_rsb_module_order'){
                                module_elorder.name = "bk_has_rsb_module_order_"+new_moduleid+"[]";                           
                            }       
                        }
                        // Arrange sidebar
                        var sectionName = sectionelement.className.split(' ')[1];
                        if((sectionName == 'has-rsb') || (sectionName == 'has-innersb')) {
                            sectionelement.getElementsByClassName('bk-sidebar-order')[0].name = 'bk_sidebar_order_'+new_moduleid ;
                        }
                        nth++;
                    }    
                });
                //console.log(section_container.find(".fullwidth"));
    			return false;
    		},
    
    		on_click_open_section: function( e ) {
    			var $section_options = $( e.target ).parents( '.bk-section' ).find( '.bk-modules-wrap' );
    			$section_options.slideToggle();
    			return false;
    		},
            
    		show: function() {
    			$( '#postdivrich' ).hide();
    			$this.$bkcontainer.show();
    		},
    
    		hide: function() {
    			$( '#postdivrich' ).show();
    			$this.$bkcontainer.hide();
    		},
    
    		render_field: {
    
    			select: function( option, id, value ) {
    				var $field = $( $( '#bk-template-field-select' ).html() );
    				$.each( option.options, function( value, label ) {
    					$field.append( $( '<option>' ).attr( 'value', value ).html( label ) );
    				} );
    				$field.attr( 'name', id ).val( value || option.default );
    				return $field;
    			},
    
    			number: function( option, id, value ) {
    				var $field = $( $( '#bk-template-field-number' ).html() );
    				$field.attr( 'name', id ).val( value || option.default );
    				return $field;
    			},
    
    			text: function( option, id, value ) {
    				var $field = $( $( '#bk-template-field-text' ).html() );
    				$field.attr( 'name', id ).val( value || option.default );
    				return $field;
    			},
                
                textarea: function( option, id, value ) {
    				var $field = $( $( '#bk-template-field-textarea' ).html() );
    				$field.attr( 'name', id ).val( value || option.default );
    				return $field;
    			},
                color: function( option, id, value ) {
    				var $field = $( $( '#bk-template-field-color' ).html() );
    				$field.attr( 'name', id ).val( value || option.default );
    				return $field;
    			},
    			html: function( option, id, value ) {
    				var $field = $( $( '#bk-template-field-html' ).html() );
    				$field.attr( 'name', id ).val( value || option.default );
    				return $field;
    			},
                category: function( option, id, value ) {
    				var $field = $( $( '#bk-template-field-category' ).html() );
                    if ( ! value ) value = '';
                    $.each( $field.find( 'option'), function( i, cat_option) {
                        $(cat_option).removeAttr("selected"); 
                        $(cat_option).removeAttr("class");                    
                    });
                    var $cat_array;
                    $cat_array = value.split(",");                
                    $.each( $cat_array, function( i, cat_id ) { 
                        $field.find( "option[value='"+cat_id+"']" ).attr('selected','selected');
                        if(cat_id == 0) {
                            return false;
                        }
                    });
                    
    				$field.attr( 'name', id ).val( value || option.default );
    				return $field;
    			},
    
    			sidebar: function( option, id, value ) {
    				var $field = $( $( '#bk-sidebar-template' ).html() );
    				$field.attr( 'name', id ).val( value || option.default );
    				return $field;
    			},
                
                datepicker: function( option, id, value ) {
    				var $field = $( $( '#bk-template-field-datepicker' ).html() );
    				$field.attr( 'name', id ).val( value || option.default );
    				return $field;
    			},
                timepicker: function( option, id, value ) {
    				var $field = $( $( '#bk-template-field-timepicker' ).html() );
    				$field.attr( 'name', id ).val( value || option.default );
    				return $field;
    			},
    		},
    /*============ Module ===============*/        
    		init_modules: function() {
                $this.$bk_modules.find( '.bk-section-loading' ).remove();
    			$this.$bk_modules.sortable( { handle: ".bk-module-handle, .bk-module-label", placeholder: 'bk-module-placeholder', forcePlaceholderSize: true } );
    		},
                    
            module_menu_cfg: function($new_section) {
    			$this.$add_module_button = $new_section.find( '#add-module-button' ).dropdown();
    			$this.$bk_modules = $new_section.find( '.bk-modules' );
                $this.$leftsec = $new_section.find( '.leftsec_placeholder' );
                $this.$rightsec = $new_section.find( '.rightsec_placeholder' );
    			var $fullwidth_menu_list = $new_section.find( '.bk-fullwidth-module-menu .dropdown-menu' );
    			var $has_rsb_menu_list = $new_section.find( '.bk-has-rsb-module-menu .dropdown-menu' );
                var $has_innersb_left_menu_list = $new_section.find( '.leftsec .bk-has-innersb-module-menu .dropdown-menu' );
                var $has_innersb_right_menu_list = $new_section.find( '.rightsec .bk-has-innersb-module-menu .dropdown-menu' );
                
                //Fullwidth
    			$.each( bk_fullwidth_modules, function( module_type, module_settings ) {
    				var $menu_item = $( '<li role="presentation"><a role="menuitem" tabindex="-1" href="#"></a></li>' );  //get menu list
    				$menu_item.find( 'a' )
    					.data( 'bk-module-type', module_type )
    					.html( module_settings.title );
    //                    console.log(module_settings.title);                                                                                                    
    				$fullwidth_menu_list.append( $menu_item );
    			} );
    			$fullwidth_menu_list.find( 'a' ).click( $this.add_module_event );
    			$.each( bk_has_rsb_modules, function( module_type, module_settings ) {
    				var $menu_item = $( '<li role="presentation"><a role="menuitem" tabindex="-1" href="#"></a></li>' );  //get menu list
    				$menu_item.find( 'a' )
    					.data( 'bk-module-type', module_type )
    					.html( module_settings.title );
    //                    console.log(module_settings.title);                                                                                                    
    				$has_rsb_menu_list.append( $menu_item );
    			} );
    			$has_rsb_menu_list.find( 'a' ).click( $this.add_module_event );
                $.each( bk_has_innersb_left_modules, function( module_type, module_settings ) {
    				var $menu_item = $( '<li role="presentation"><a role="menuitem" tabindex="-1" href="#"></a></li>' );  //get menu list
    				$menu_item.find( 'a' )
    					.data( 'bk-module-type', module_type )
    					.html( module_settings.title );
    //                    console.log(module_settings.title);                                                                                                    
    				$has_innersb_left_menu_list.append( $menu_item );
    			} );
    			$has_innersb_left_menu_list.find( 'a' ).click( $this.add_module_event );
                $.each( bk_has_innersb_right_modules, function( module_type, module_settings ) {
    				var $menu_item = $( '<li role="presentation"><a role="menuitem" tabindex="-1" href="#"></a></li>' );  //get menu list
    				$menu_item.find( 'a' )
    					.data( 'bk-module-type', module_type )
    					.html( module_settings.title );
    //                    console.log(module_settings.title);                                                                                                    
    				$has_innersb_right_menu_list.append( $menu_item );
    			} );
    			$has_innersb_right_menu_list.find( 'a' ).click( $this.add_module_event );
    		},       
    		module_append: function( module_type, blk_order, insection ) {
                var section_nth = $this.section_nth - 1;
    			var uuid = $.uuid();
                var id;
    			var $new_module = $( $( '#bk-template-module' ).html() ); //get template module
                if (insection == 'fullwidth'){
                    id = 'bk_fullwidth_modules['+uuid+']';
        			$new_module.find( '.bk-module-type' ).attr( 'name', id+'[_type]' ).val( module_type ); //append module_type to .bk-module-type
        			$new_module.find( '.bk_module_order' ).val( uuid );                                     //
                    $new_module.find( '.bk_module_order' ).attr( 'name', 'bk_fullwidth_module_order_' + section_nth+'[]' );
        			$new_module.find( '.bk-module-label' ).html( bk_fullwidth_modules[module_type].title );       //
                }else if (insection == 'has-rsb'){
                    id = 'bk_has_rsb_modules['+uuid+']';
        			$new_module.find( '.bk-module-type' ).attr( 'name', id+'[_type]' ).val( module_type ); //append module_type to .bk-module-type
        			$new_module.find( '.bk_module_order' ).val( uuid );                                     //
                    $new_module.find( '.bk_module_order' ).attr( 'name', 'bk_has_rsb_module_order_' + section_nth+'[]' );
        			$new_module.find( '.bk-module-label' ).html( bk_has_rsb_modules[module_type].title );       //
                }else if(insection == 'has-innersb'){
                    if (blk_order != false){                                
                        if (blk_order.substring(3,10) == 'leftsec'){  
                            id = 'bk_has_innersb_left_modules['+uuid+']';
                			$new_module.find( '.bk-module-type' ).attr( 'name', id+'[_type]' ).val( module_type ); //append module_type to .bk-module-type
                			$new_module.find( '.bk_module_order' ).val( uuid );
    
                            $new_module.find( '.bk_module_order' ).attr( 'name', 'bk_leftsec_module_order_' + section_nth+'[]' );
                            $new_module.find( '.bk-module-label' ).html( bk_has_innersb_left_modules[module_type].title );  
            			}else if(blk_order.substring(3,7) == 'rsec'){
                            id = 'bk_has_innersb_right_modules['+uuid+']';
                			$new_module.find( '.bk-module-type' ).attr( 'name', id+'[_type]' ).val( module_type ); //append module_type to .bk-module-type
                			$new_module.find( '.bk_module_order' ).val( uuid );
                            
                            $new_module.find( '.bk_module_order' ).attr( 'name', 'bk_rsec_module_order_' + section_nth+'[]' );
                            $new_module.find( '.bk-module-label' ).html( bk_has_innersb_right_modules[module_type].title );
            			}
                    }else {
                        if ($this.$bk_modules.parent().attr('class') == 'leftsec'){                                     //
                            id = 'bk_has_innersb_left_modules['+uuid+']';
                			$new_module.find( '.bk-module-type' ).attr( 'name', id+'[_type]' ).val( module_type ); //append module_type to .bk-module-type
                			$new_module.find( '.bk_module_order' ).val( uuid );
                            
                            $new_module.find( '.bk_module_order' ).attr( 'name', 'bk_leftsec_module_order_' + section_nth+'[]' );
                            $new_module.find( '.bk-module-label' ).html( bk_has_innersb_left_modules[module_type].title );  
            			}else if($this.$bk_modules.parent().attr('class') == 'rightsec'){
                            id = 'bk_has_innersb_right_modules['+uuid+']';
                			$new_module.find( '.bk-module-type' ).attr( 'name', id+'[_type]' ).val( module_type ); //append module_type to .bk-module-type
                			$new_module.find( '.bk_module_order' ).val( uuid );
                            
                            $new_module.find( '.bk_module_order' ).attr( 'name', 'bk_rsec_module_order_' + section_nth+'[]' );
                            $new_module.find( '.bk-module-label' ).html( bk_has_innersb_right_modules[module_type].title );
            			}                                    
                    }
                }
    			var $new_option = $this.render_module_options( module_type, id, blk_order, insection );
    			$new_module.find( '.bk-module-options' ).append( $new_option );
                if (blk_order != false){
                    if(blk_order.substring(3,10) == 'leftsec'){
                        $this.$leftsec.append( $new_module );
                    }else if(blk_order.substring(3,7) == 'rsec'){
                        $this.$rightsec.append( $new_module );       //append to placeholder
                    }else{
                        $this.$bk_modules.append( $new_module );       //append to placeholder
                    }
                    
                }else{
                    $this.$bk_modules.append( $new_module );       //append to placeholder
                }
                if (($new_module.find( '.bk-module-type' ).val() == 'carousel') || ($new_module.find( '.bk-module-type' ).val() == 'feature2') ||
                    ($new_module.find( '.bk-module-type' ).val() == 'carousel_type2')
                ) {
                    $('.bk-color-picker').colorpicker();
                }
                if ($new_module.find( '.bk-module-type' ).val() == 'comming_soon'){
                    $new_module.find('.datepicker').datepicker();
                    $new_module.find('.timepicker').timepicker();
                }
                if (($new_module.find( '.bk-module-type' ).val() == 'shortcode') || ($new_module.find( '.bk-module-type' ).val() == 'adsense')) {
                    $('.textarea-animated').autosize();
                }
                if ($new_module.find( '.bk-module-type' ).val() == 'custom_html') {
                    var uuid = $.uuid();
                    var wysiwygareaAvailable = isWysiwygareaAvailable();
                    $new_module.find('.textarea-animated').attr("id",uuid);
                    
                    if ( wysiwygareaAvailable ) {
            			CKEDITOR.replace( uuid );
            		} else {
            			editorElement.setAttribute( 'contenteditable', 'true' );
            			CKEDITOR.inline( uuid );
            
            			// TODO we can consider displaying some info box that
            			// without wysiwygarea the classic editor may not work.
            		}
                }
    			$this.init_module( $new_module );           //init to slidetoggle, delete
    
    			return $new_module;
    		},
    		init_module: function( $new_module ) {
    			$new_module.find( '.bk-module-bar, .bk-module-open-option' ).click( $this.on_click_open_option_module );
    			$new_module.find( '.bk-module-delete' ).click( $this.on_click_delete_module );
    		},
    
    		add_module_event: function( e ) {
                var module_type = $( e.target ).data( 'bk-module-type' );
                $this.section_nth = $(e.target).parents(".bk-modules-wrap").children(".bk-section-nth").attr('id');
                $this.section_nth ++;
                if($(e.target).parents(".bk-section").hasClass('fullwidth')){
                    $this.$add_module_button = $(e.target).parents(".bk-fullwidth-module-menu").find( '#add-module-button' ).dropdown();
                    $this.$bk_modules = $(e.target).parents(".bk-fullwidth-module-menu").siblings(".bk-modules");
                    var $new_module = $this.module_append( module_type, false, 'fullwidth' );
                }else if($(e.target).parents(".bk-section").hasClass('has-rsb')){
                    $this.$add_module_button = $(e.target).parents(".bk-has-rsb-module-menu").find( '#add-module-button' ).dropdown();
                    $this.$bk_modules = $(e.target).parents(".bk-has-rsb-module-menu").siblings(".bk-modules");
                    var $new_module = $this.module_append( module_type, false, 'has-rsb' );
                }else if($(e.target).parents(".bk-section").hasClass('has-innersb')){
                    $this.$add_module_button = $(e.target).parents(".bk-has-innersb-module-menu").find( '#add-module-button' ).dropdown();
                    $this.$bk_modules = $(e.target).parents(".bk-has-innersb-module-menu").siblings(".bk-modules");
                    var $new_module = $this.module_append( module_type, false, 'has-innersb' );
                }
    			//$new_module.find( '.bk-section-open-option' ).trigger( 'click' );
    			$this.$add_module_button.dropdown( 'toggle' );
    			return false;			
    		},
            
    		on_click_open_option_module: function( e ) {
    			var $module_options = $( e.target ).parents( '.bk-module-item' ).find( '.bk-module-options' );
    			$module_options.slideToggle();
    			return false;
    		},
    
    		on_click_delete_module: function( e ) {
    			$( e.target ).parents( '.bk-module-item' ).remove();
    			return false;
    		},
    
    		render_module_options: function( module_type, id, blk_order, insection ) {
    			var module_setting;
                if (insection == 'fullwidth') {
                    module_setting = bk_fullwidth_modules[ module_type ];
                }else if (insection == 'has-rsb') {
                    module_setting = bk_has_rsb_modules[ module_type ];
                }
                else if (insection == 'has-innersb'){
                    if (blk_order != false){                                
                        if (blk_order.substring(3,10) == 'leftsec'){                                     //
                            module_setting = bk_has_innersb_left_modules[ module_type ];
            			}else if(blk_order.substring(3,7) == 'rsec'){
                            module_setting = bk_has_innersb_right_modules[ module_type ];
            			}
                    }else {
                        if ($this.$bk_modules.parent().attr('class') == 'leftsec'){                                     //
                            module_setting = bk_has_innersb_left_modules[ module_type ]; 
            			}else if($this.$bk_modules.parent().attr('class') == 'rightsec'){
                            module_setting = bk_has_innersb_right_modules[ module_type ];
            			}                                    
                    }
                }
    			var options = [];
    			$.each( module_setting.options, function( name, option ) {
                //console.log(option);
    				var $new_option = $( $( '#bk-template-module-option' ).html() );	
    				$new_option.find( '.bk-module-option-label' ).html( option.title );              // append title 
    				$new_option.find( '.bk-module-option-description' ).html( option.description );  // append description 
                    if (name == 'category') {
        				$new_option.find( '.bk-module-option-field-wrapper' ).append(                    //append field
        					$this.render_field[ option.field ].call( $this, option, id+'['+name+']'+'[]', $this.bk_get_blk_val( blk_order+'_'+name ) )
        				);	
                    }else {
                        $new_option.find( '.bk-module-option-field-wrapper' ).append(                    //append field
    					   $this.render_field[ option.field ].call( $this, option, id+'['+name+']', $this.bk_get_blk_val( blk_order+'_'+name ) )
    				    );
                    }
                    //console.log($new_option);
    				options.push( $new_option );
    			} );
    
    			return options;
    		},
                            
    	}
    
    	BK_PAGE_BUILDER.run_cfg();
    } );
})(jQuery);