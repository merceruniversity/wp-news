<?php
/*
Template Name: Page Builder
*/
get_header(); ?>

<?php if ( have_posts() ) : the_post(); ?>
	
<div id="page-content-wrap">
    <?php bk_page_builder(); ?>
</div>
<?php endif; ?>

<?php get_footer(); ?>