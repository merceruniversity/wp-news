<?php 
if ( ! function_exists( 'bk_page_builder_temp' ) ) {
	function bk_page_builder_temp() {
		global $post;

		if ( isset( $post->ID ) && 'page_builder.php' == get_post_meta( $post->ID,'_wp_page_template',TRUE ) ) : ?>
			<style>#postdivrich{ display:none; }</style>
		<?php else : ?>
			<style>#bk-container{ display:none; }</style>
		<?php endif; ?>

		<div id="bk-container">
			<div class="bk-toolbox">
			     <ul class="menu clearfix" aria-labelledby="add-section-button"></ul>
			</div>

			<div class="bk-sections">
				<div class="bk-section-empty"><?php esc_html_e(  'Choose <strong>Layout section</strong> to add new section.', 'the-rex') ?></div>
				<div class="bk-section-loading"><?php esc_html_e(  'Loading ...', 'the-rex') ?></div>
			</div>
            
			<!-- Module -->
			<script id="bk-template-module" type="text/template">
				<div class="bk-module-item">
					<input type="hidden" class="bk_module_order">
					<input type="hidden" class="bk-module-type">
					<div class="bk-module-bar">
						<div class="bk-module-toolbox">
							<a class="bk-module-open-option" href="#"></a>
							<a class="bk-module-delete" href="#"><i class="fa fa-times"></i></a>
						</div>
						<i class="bk-module-handle fa fa-cog"></i>
						<div class="bk-module-label"></div>
					</div>
					<div class="bk-module-options hidden"></div>
				</div>
			</script>

			<script id="bk-template-module-option" type="text/template">
				<div class="bk-module-option-wrap">
					<div class="bk-module-option-label-wrapper">
						<label class="bk-module-option-label"></label>
						<div class="bk-module-option-description"></div>
					</div>
					<div class="bk-module-option-field-wrapper"></div>
				</div>
			</script>

			<!-- Fields Template -->
            
            <!-- Text -->                        
			<script id="bk-template-field-text" type="text/template">
				<input class="bk-field" type="text">
			</script>
            
            <!-- Textarea -->                        
			<script id="bk-template-field-textarea" type="text/template">
				<textarea rows="4" cols="50" class="bk-field textarea-animated" type="text">
                </textarea rows="10" cols="50">                
			</script>
            
            <!-- Color -->                        
            <script id="bk-template-field-color" type="text/template">
				<input class="bk-color-picker" type="text">
			</script>

            <!-- Number -->
			<script id="bk-template-field-number" type="text/template">
				<input class="bk-field" type="number" name="quantity" min="0">
			</script>
            
            <!-- Checkbox -->                        

			<script id="bk-template-field-checkbox" type="text/template">
				<input class="bk-field" type="hidden">
				<label>
					<input class="bk-field" type="checkbox">
					<span></span>
				</label>
			</script>
            
            <!-- Date Picker -->            
            <script id="bk-template-field-datepicker" type="text/template">
				<input class="bk-field datepicker" type="text" name="datepicker"/>
			</script>
            
            <!-- Time Picker -->            
            <script id="bk-template-field-timepicker" type="text/template">
				    <input class="bk-field timepicker input-small" type="text" name="timepicker"/>
			</script>
                              
            <!-- Select -->
			<script id="bk-template-field-select" type="text/template">
				<select class="bk-field"></select>
			</script>
            
            <!-- Category Multiple Select -->            
			<script id="bk-template-field-category" type="text/template">
				<?php 
                    $select_cats = wp_dropdown_categories( array(
                        'show_option_all'    => 'All Categories',
    					'hide_empty' => 1,
    					'class' => 'bk-field',
    					'hierarchical' => true,
                        'echo' => false )
	               );
                    $select_cats = str_replace( "class='bk-field'", "class='bk-field bk-category-field' multiple='multiple' size='6'", $select_cats );
                    echo $select_cats;    
                ?>            
			</script>
            <!-- Sidebar -->
			<script id="bk-sidebar-template" type="text/template">
                <div class='sidebar'><label>Choose a sidebar</label>
    				<select class = 'bk-sidebar-order'>
    					<option value="0"><?php echo esc_html__( 'None', 'the-rex'); ?></option>
    				<?php foreach ( $GLOBALS['wp_registered_sidebars'] as $sidebar ) : ?>
    					<option value="<?php echo esc_attr( $sidebar['id'] ); ?>">
    						<?php echo ucwords( $sidebar['name'] ); ?>
    					</option>
    				<?php endforeach; ?>
    				</select>
                </div>
			</script>

			<script id="bk-template-field-html" type="text/template">
				<textarea class="bk-field"></textarea>
			</script>
            
            <script id="bk-template-fullwidth-html" type="text/template">
                <div class="bk-section fullwidth">
      			
                    <div class="bk-section-bar">
						<div class="bk-section-toolbox">
							<a class="bk-section-open-option" href="#"></a>
							<a class="bk-section-delete" href="#"><i class="fa fa-times"></i></a>
						</div>
						<i class="bk-sec-sort-ctrl fa fa-cogs"></i>
						<div class="bk-sec-label"></div>
					</div>
                    <div class='bk-modules-wrap'>
                        <input type="hidden" class="bk-section-nth">
                        <div class="bk-fullwidth-module-menu">
            				<div class="dropdown">
            					<button class="button button-primary button-large dropdown-toggle" type="button" id="add-module-button" data-toggle="dropdown">
            						<?php esc_html_e(  'Add Module', 'the-rex') ?>
            						<span class="caret"></span>
            					</button>
            					<ul class="dropdown-menu" role="menu" aria-labelledby="add-section-button"></ul>
            				</div>
            			</div>
                        
            			<div class="bk-modules">
          					<input type="hidden" class="bk-section-order" name="bk_section_order[]">
                            <input type="hidden" class="bk-section-type">
            				<div class="bk-section-empty"><?php esc_html_e(  'Click <strong>Add Module</strong> button to add new module.', 'the-rex') ?></div>
            				<div class="bk-section-loading"><?php esc_html_e(  'Loading ...', 'the-rex') ?></div>
            			</div>
                    </div>
                </div>
            </script>
            
            <script id="bk-template-rsb-html" type="text/template">
                <div class="bk-section has-rsb">
                    
                    <div class="bk-section-bar">
						<div class="bk-section-toolbox">
							<a class="bk-section-open-option" href="#"></a>
							<a class="bk-section-delete" href="#"><i class="fa fa-times"></i></a>
						</div>
						<i class="bk-sec-sort-ctrl fa fa-cogs"></i>
						<div class="bk-sec-label"></div>
					</div>
                    
                    <div class='bk-modules-wrap'>
                        <input type="hidden" class="bk-section-nth">
                        <div class="bk-has-rsb-module-menu">
            				<div class="dropdown">
            					<button class="button button-primary button-large dropdown-toggle" type="button" id="add-module-button" data-toggle="dropdown">
            						<?php esc_html_e(  'Add Module', 'the-rex') ?>
            						<span class="caret"></span>
            					</button>
            					<ul class="dropdown-menu" role="menu" aria-labelledby="add-section-button"></ul>
            				</div>
            			</div>
                        
            			<div class="bk-modules">
          					<input type="hidden" class="bk-section-order" name="bk_section_order[]">
                            <input type="hidden" class="bk-section-type">
            				<div class="bk-section-empty"><?php esc_html_e(  'Click <strong>Add Module</strong> button to add new module.', 'the-rex') ?></div>
            				<div class="bk-section-loading"><?php esc_html_e(  'Loading ...', 'the-rex') ?></div>
            			</div>
                    </div>
                </div>
            </script>
            
            <script id="bk-template-has-innersb-html" type="text/template">
                <div class="bk-section has-innersb clearfix">
                    <div class="bk-section-bar">
						<div class="bk-section-toolbox">
							<a class="bk-section-open-option" href="#"></a>
							<a class="bk-section-delete" href="#"><i class="fa fa-times"></i></a>
						</div>
						<i class="bk-sec-sort-ctrl fa fa-cogs"></i>
						<div class="bk-sec-label"></div>
					</div>
                    
                    <div class='bk-modules-wrap'>
                        <input type="hidden" class="bk-section-nth">
              			<input type="hidden" class="bk-section-order" name="bk_section_order[]">
                        <div class="leftsec">
                			<div class="bk-has-innersb-module-menu">
                				<div class="dropdown">
                					<button class="button button-primary button-large dropdown-toggle" type="button" id="add-module-button" data-toggle="dropdown">
                						<?php esc_html_e(  'Add Module', 'the-rex') ?>
                						<span class="caret"></span>
                					</button>
                					<ul class="dropdown-menu" role="menu" aria-labelledby="add-section-button"></ul>
                				</div>
                			</div>
                			<div class="bk-modules leftsec_placeholder">
                                <input type="hidden" class="bk-section-type">
                				<div class="bk-section-empty"><?php esc_html_e(  'Click <strong>Add Module</strong> button to add new section.', 'the-rex') ?></div>
                				<div class="bk-section-loading"><?php esc_html_e(  'Loading ...', 'the-rex') ?></div>
                			</div>
                            
                        </div>
                        <div class="rightsec">
                			<div class="bk-has-innersb-module-menu">
                				<div class="dropdown">
                					<button class="button button-primary button-large dropdown-toggle" type="button" id="add-module-button" data-toggle="dropdown">
                						<?php esc_html_e(  'Add Module', 'the-rex') ?>
                						<span class="caret"></span>
                					</button>
                					<ul class="dropdown-menu" role="menu" aria-labelledby="add-section-button"></ul>
                				</div>
                			</div>
                			<div class="bk-modules rightsec_placeholder">
                                <input type="hidden" class="bk-section-type">
                				<div class="bk-section-empty"><?php esc_html_e(  'Click <strong>Add Module</strong> button to add new module.', 'the-rex') ?></div>
                				<div class="bk-section-loading"><i class="icon-entypo-arrows-ccw"></i> <?php esc_html_e(  'Loading ...', 'the-rex') ?></div>
                			</div>
                            
                        </div>
                   </div>
                </div>
            </script>
		</div>
		<?php
	}
}