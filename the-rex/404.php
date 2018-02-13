<?php
/**
 * The template for 404 page (Not Found).
 *
 */
?>
<?php 
    get_header();
?>
<div class="page-wrap bkwrapper container">
    <div class="row">
        <div class="bk-404-header">
            <section class="error-number">
                <h4>404</h4>
            </section>              
            <h1 class="bk-error-title"><?php esc_html_e('Page not found', 'the-rex'); ?></h1>
        </div>
        
        <div id="bk-404-wrap">
            
        	<div class="entry-content">			
        		
                <h2><?php esc_html_e("Oops! The page you were looking for was not found. Perhaps searching can help.", 'the-rex'); ?></h2>
                
        	</div>
        
        	<div class="search">
        
        	    <?php get_search_form(); ?>
        
        	</div>
            
            <div class="redirect-home">
                <i class="fa fa-home"></i>
                <a href="<?php echo esc_url( home_url('/') );?>"><?php esc_html_e('Back to Homepage','the-rex'); ?></a>
            </div>
        
        	
        </div> <!-- end #bk-404-wrap -->
    </div>
</div>
<?php get_footer(); ?>
