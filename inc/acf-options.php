<?php
/**
 * ACF options pages.
 *
 * @package merotheme
 */

if ( function_exists( 'acf_add_options_page' ) ) {
	acf_add_options_page(
		array(
			'page_title' => 'Header Settings',
			'menu_title' => 'Header Settings',
			'menu_slug'  => 'header-settings',
			'capability' => 'edit_posts',
			'redirect'   => false,
		)
	);

	acf_add_options_page(
		array(
			'page_title' => 'Footer Settings',
			'menu_title' => 'Footer Settings',
			'menu_slug'  => 'footer-settings',
			'capability' => 'edit_posts',
			'redirect'   => false,
		)
	);

	acf_add_options_page(
		array(
			'page_title' => 'Sidebar Settings',
			'menu_title' => 'Sidebar Settings',
			'menu_slug'  => 'sidebar-settings',
			'capability' => 'edit_posts',
			'redirect'   => false,
		)
	);
}
