<?php
add_action( 'after_setup_theme', 'bk_setup_page_builder' );
function bk_setup_page_builder() {
	add_action( 'admin_enqueue_scripts', 'bk_init_sections' );
	add_action( 'edit_form_after_title', 'bk_page_builder_temp' );
	add_action( 'save_post', 'bk_save_page' );
}