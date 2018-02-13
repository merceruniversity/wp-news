<?php get_header(); ?>
<?php global $bk_option;?>
<div id="body-wrapper" class="wp-page bkwrapper container">
	<?php if (have_posts()) : ?>
		<?php while ( have_posts() ) : the_post(); ?>
            <?php if ( is_page() && ! is_front_page() || ( function_exists( 'bp_current_component' ) && bp_current_component() )  ) : ?>
            <div class="page-title">
                <div class="main-title">
                    <h2 itemprop="name"><span><?php the_title(); ?></span></h2>
                </div>
            </div>
			<?php endif; ?>
			<article id="post-<?php the_ID(); ?>" <?php post_class( 'clearfix' ); ?>>
				<div class="post-content"><?php the_content(); ?></div>
			</article>

        <?php
            if (function_exists("bk_paginate")) {
                bk_paginate();
            }
        ?>  
        <?php if(($bk_option['bk-comment-sw']) && (comments_open())) {?>
            <div class="comment-box clearfix">
                <?php comments_template(); ?>
            </div> <!-- End Comment Box -->
        <?php }?>
    <?php endwhile; ?>
	<?php else : ?>

		<h2><?php esc_html_e('Not Found', 'the-rex') ?></h2>

	<?php endif; ?>
</div>
		
<?php get_footer(); ?>