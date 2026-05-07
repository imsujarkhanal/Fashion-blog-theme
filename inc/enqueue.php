<?php

	// Enqueue theme styles and scripts.
	function merotheme_enqueue_assets() {

	// Main WordPress theme stylesheet (root style.css).
	wp_enqueue_style( 'merotheme-style', get_stylesheet_uri(), array(), _S_VERSION );
	wp_style_add_data( 'merotheme-style', 'rtl', 'replace' );

	//  CSS.
		wp_enqueue_style( 'bootstrap', get_template_directory_uri() . '/assets/css/bootstrap.min.css', array(), null );
			wp_enqueue_style(
			'font-awesome',
			'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css',
			array(),
			'4.7.0'
		);
		wp_enqueue_style( 'flexslider', get_template_directory_uri() . '/assets/css/flexslider.css', array(), null );
		wp_enqueue_style( 'skdslider', get_template_directory_uri() . '/assets/css/skdslider.css', array(), null );
		wp_enqueue_style( 'smoothbox', get_template_directory_uri() . '/assets/css/smoothbox.css', array(), null );
		wp_enqueue_style(
			'mero-custom-style',
			get_template_directory_uri() . '/assets/css/style.css',
			array(),
			filemtime( get_template_directory() . '/assets/css/style.css' )
		);

	// WordPress bundled jQuery.
	wp_enqueue_script( 'jquery' );

	//  JS.
	wp_enqueue_script( 'bootstrap-js', get_template_directory_uri() . '/assets/js/bootstrap.js', array( 'jquery' ), null, true );
	wp_enqueue_script( 'easing-js', get_template_directory_uri() . '/assets/js/easing.js', array( 'jquery' ), null, true );
	wp_enqueue_script( 'move-top-js', get_template_directory_uri() . '/assets/js/move-top.js', array( 'jquery' ), null, true );
	wp_enqueue_script( 'flexslider-js', get_template_directory_uri() . '/assets/js/jquery.flexslider.js', array( 'jquery' ), null, true );
	wp_enqueue_script( 'skdslider-js', get_template_directory_uri() . '/assets/js/skdslider.min.js', array( 'jquery' ), null, true );
	wp_enqueue_script( 'smoothbox-js', get_template_directory_uri() . '/assets/js/smoothbox.jquery2.js', array( 'jquery' ), null, true );
	wp_enqueue_script( 'main-js', get_template_directory_uri() . '/assets/js/main.js', array( 'jquery' ), null, true );
	wp_localize_script(
		'main-js',
		'merothemeLikes',
		array(
			'ajaxUrl' => admin_url( 'admin-ajax.php' ),
			'nonce'   => wp_create_nonce( 'merotheme_like_post' ),
		)
	);

	// Load comment-reply only when needed.
	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'merotheme_enqueue_assets' );
