<?php
/**
 * merotheme functions and definitions
 *
 * @package merotheme
 */

// Define theme version.
if ( ! defined( '_S_VERSION' ) ) {
	define( '_S_VERSION', '1.0.0' );
}

/**
 * Setup theme defaults and supports.
 */
function merotheme_setup() {

	load_theme_textdomain( 'merotheme', get_template_directory() . '/languages' );

	add_theme_support( 'automatic-feed-links' );
	add_theme_support( 'title-tag' );
	add_theme_support( 'post-thumbnails' );

	register_nav_menus(
		array(
			'menu-1'     => esc_html__( 'Primary', 'merotheme' ),
			'footer-menu' => esc_html__( 'Footer Menu', 'merotheme' ),
		)
	);

	add_theme_support(
		'html5',
		array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
			'style',
			'script',
		)
	);

	add_theme_support(
		'custom-background',
		apply_filters(
			'merotheme_custom_background_args',
			array(
				'default-color' => 'ffffff',
				'default-image' => '',
			)
		)
	);

	add_theme_support( 'customize-selective-refresh-widgets' );

	add_theme_support(
		'custom-logo',
		array(
			'height'      => 250,
			'width'       => 250,
			'flex-width'  => true,
			'flex-height' => true,
		)
	);
}
add_action( 'after_setup_theme', 'merotheme_setup' );

/**
 * Set content width.
 */
function merotheme_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'merotheme_content_width', 640 );
}
add_action( 'after_setup_theme', 'merotheme_content_width', 0 );

/**
 * Get selected sidebar position.
 */
function merotheme_get_sidebar_position() {
	$sidebar_position = '';
	$sidebars_widgets = get_option( 'sidebars_widgets', array() );
	$widget_instances = get_option( 'widget_merotheme_sidebar_position_widget', array() );

	if ( is_array( $sidebars_widgets ) && ! empty( $sidebars_widgets['sidebar-1'] ) && is_array( $widget_instances ) ) {
		foreach ( $sidebars_widgets['sidebar-1'] as $widget_id ) {
			if ( 0 === strpos( $widget_id, 'merotheme_sidebar_position_widget-' ) ) {
				$instance_number = str_replace( 'merotheme_sidebar_position_widget-', '', $widget_id );

				if ( ! empty( $widget_instances[ $instance_number ]['position'] ) ) {
					$sidebar_position = $widget_instances[ $instance_number ]['position'];
					break;
				}
			}
		}
	}

	if ( ! $sidebar_position && is_array( $widget_instances ) ) {
		foreach ( $widget_instances as $instance ) {
			if ( is_array( $instance ) && ! empty( $instance['position'] ) ) {
				$sidebar_position = $instance['position'];
				break;
			}
		}
	}

	if ( ! $sidebar_position ) {
		$sidebar_position = get_option( 'merotheme_sidebar_position', 'right' );
	}

	$sidebar_position = strtolower( $sidebar_position );

	if ( ! in_array( $sidebar_position, array( 'left', 'right' ), true ) ) {
		$sidebar_position = 'right';
	}

	return $sidebar_position;
}

/**
 * Enqueue widget admin media uploader.
 */
function merotheme_enqueue_widget_admin_assets( $hook ) {
	if ( 'widgets.php' !== $hook && 'customize.php' !== $hook ) {
		return;
	}

	wp_enqueue_media();
	wp_enqueue_script(
		'merotheme-widget-media',
		get_template_directory_uri() . '/assets/js/widget-media.js',
		array( 'jquery' ),
		filemtime( get_template_directory() . '/assets/js/widget-media.js' ),
		true
	);
}
add_action( 'admin_enqueue_scripts', 'merotheme_enqueue_widget_admin_assets' );

/**
 * Register widget area.
 */





// slider widget 

class Merotheme_Slider_Widget extends WP_Widget {

	public function __construct() {
		parent::__construct(
			'merotheme_slider_widget',
			esc_html__( 'MeroTheme Slider', 'merotheme' ),
			array(
				'description' => esc_html__( 'Dynamic homepage slider using ACF fields.', 'merotheme' ),
			)
		);
	}

				public function widget( $args, $instance ) {
				echo $args['before_widget'];

				$home_id = get_option( 'page_on_front' );

				if ( function_exists( 'have_rows' ) && have_rows( 'slider_images', $home_id ) ) :
					?>
					<section class="home-slider">
						<div class="slider">
							<div id="demo1">
								<ul class="slides">

									<?php while ( have_rows( 'slider_images', $home_id ) ) : the_row();

										$image = get_sub_field( 'slide_image' );
										$title = get_sub_field( 'slide_title' );
										$desc  = get_sub_field( 'slide_description' );
										?>

										<li>
											<?php if ( ! empty( $image['url'] ) ) : ?>
												<img src="<?php echo esc_url( $image['url'] ); ?>" alt="<?php echo esc_attr( $title ); ?>">
											<?php endif; ?>

											<div class="slide-desc">
												<h3><?php echo esc_html( $title ); ?></h3>
												<p><?php echo esc_html( $desc ); ?></p>
											</div>
										</li>

									<?php endwhile; ?>

								</ul>
							</div>
						</div>
					</section>
					<?php
				endif;

				echo $args['after_widget'];
			}
}

function merotheme_widgets_init() {
	register_sidebar(
		array(
			'name'          => esc_html__( 'Sidebar', 'merotheme' ),
			'id'            => 'sidebar-1',
			'description'   => esc_html__( 'Add sidebar widgets here.', 'merotheme' ),
			'before_widget' => '<div id="%1$s" class="sidebar-section widget %2$s">',
			'after_widget'  => '</div>',
			'before_title'  => '<h4>',
			'after_title'   => '</h4>',
		)
	);

	/*
	 * Header Top Section is not printed anywhere in the current templates.
	 * Keep this commented until header.php includes dynamic_sidebar( 'header-top-section' ).
	 *
	 * register_sidebar(
	 * 	array(
	 * 		'name'          => esc_html__( 'Header Top Section', 'merotheme' ),
	 * 		'id'            => 'header-top-section',
	 * 		'description'   => esc_html__( 'Add header top widgets here.', 'merotheme' ),
	 * 		'before_widget' => '<div id="%1$s" class="header-widget widget %2$s">',
	 * 		'after_widget'  => '</div>',
	 * 		'before_title'  => '<h4 class="header-widget-title">',
	 * 		'after_title'   => '</h4>',
	 * 	)
	 * );
	 */

register_sidebar(
	array(
		'name'          => esc_html__( 'Homepage Header Slider', 'merotheme' ),
		'id'            => 'homepage-header-slider',
		'description'   => esc_html__( 'Add homepage slider widget here.', 'merotheme' ),
		'before_widget' => '<div id="%1$s" class="homepage-slider-widget widget %2$s">',
		'after_widget'  => '</div>',
		'before_title'  => '<h4 class="slider-widget-title">',
		'after_title'   => '</h4>',
	)
);

register_sidebar(
	array(
		'name'          => esc_html__( 'Inner Page Hero Section', 'merotheme' ),
		'id'            => 'inner-page-hero-section',
		'description'   => esc_html__( 'Add hero/breadcrumb widget here for inner pages.', 'merotheme' ),
		'before_widget' => '<div id="%1$s" class="inner-hero-widget widget %2$s">',
		'after_widget'  => '</div>',
		'before_title'  => '<h4 class="hero-widget-title">',
		'after_title'   => '</h4>',
	)
);

	// Footer Column 1
	register_sidebar(array(
		'name' => 'Footer Column 1',
		'id' => 'footer-col-1',
		'before_widget' => '<div class="footer-widget %2$s">',
		'after_widget' => '</div>',
		'before_title' => '<h3>',
		'after_title' => '</h3>',
	));

	// Footer Column 2
	register_sidebar(array(
		'name' => 'Footer Column 2',
		'id' => 'footer-col-2',
		'before_widget' => '<div class="footer-widget %2$s">',
		'after_widget' => '</div>',
		'before_title' => '<h3>',
		'after_title' => '</h3>',
	));

	// Footer Column 3
	register_sidebar(array(
		'name' => 'Footer Column 3',
		'id' => 'footer-col-3',
		'before_widget' => '<div class="footer-widget %2$s">',
		'after_widget' => '</div>',
		'before_title' => '<h3>',
		'after_title' => '</h3>',
	));
}
add_action( 'widgets_init', 'merotheme_widgets_init' );

/**
 * Search Widget.
 */
class Merotheme_Search_Widget extends WP_Widget {
	public function __construct() {
		parent::__construct(
			'merotheme_search_widget',
			esc_html__( 'MeroTheme Search', 'merotheme' ),
			array( 'description' => esc_html__( 'Displays the custom sidebar search form.', 'merotheme' ) )
		);
	}

	public function widget( $args, $instance ) {
		echo $args['before_widget']; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
		?>
		<form class="sidebar-search" role="search" method="get" action="<?php echo esc_url( home_url( '/' ) ); ?>">
			<input type="text" name="s" placeholder="<?php echo esc_attr__( 'Search here', 'merotheme' ); ?>">
			<button type="submit"><i class="fa fa-search"></i></button>
		</form>
		<?php
		echo $args['after_widget']; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
	}
}

/**
 * Social Links Widget.
 */
class Merotheme_Social_Widget extends WP_Widget {
	public function __construct() {
		parent::__construct(
			'merotheme_social_widget',
			esc_html__( 'MeroTheme Social Links', 'merotheme' ),
			array( 'description' => esc_html__( 'Displays social icons from ACF option fields.', 'merotheme' ) )
		);
	}

	public function widget( $args, $instance ) {
		$title = ! empty( $instance['title'] ) ? $instance['title'] : esc_html__( 'Connect Socially', 'merotheme' );

		echo $args['before_widget']; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
		echo $args['before_title'] . esc_html( $title ) . $args['after_title']; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
		?>
		<div class="sidebar-social">
			<?php
			$social_links = array(
				'facebook'    => 'header_facebook_url',
				'twitter'     => 'header_twitter_url',
				'pinterest-p' => 'header_pinterest_url',
				'linkedin'    => 'header_linkedin_url',
				'google-plus' => 'header_google_plus_url',
				'rss'         => 'header_rss_url',
				'behance'     => 'header_behance_url',
			);

			foreach ( $social_links as $icon => $field_name ) :
				$url = function_exists( 'get_field' ) ? get_field( $field_name, 'option' ) : '';

				if ( $url ) :
					?>
					<a href="<?php echo esc_url( $url ); ?>" target="_blank" rel="noopener noreferrer">
						<i class="fa fa-<?php echo esc_attr( $icon ); ?>"></i>
					</a>
					<?php
				endif;
			endforeach;
			?>
		</div>
		<?php
		echo $args['after_widget']; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
	}

	public function form( $instance ) {
		$title = ! empty( $instance['title'] ) ? $instance['title'] : esc_html__( 'Connect Socially', 'merotheme' );
		?>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php esc_html_e( 'Title:', 'merotheme' ); ?></label>
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>">
		</p>
		<?php
	}

	public function update( $new_instance, $old_instance ) {
		$instance          = array();
		$instance['title'] = sanitize_text_field( $new_instance['title'] );
		return $instance;
	}
}

/**
 * Popular Posts Widget.
 */
class Merotheme_Popular_Posts_Widget extends WP_Widget {
	public function __construct() {
		parent::__construct(
			'merotheme_popular_posts_widget',
			esc_html__( 'MeroTheme Popular Posts', 'merotheme' ),
			array( 'description' => esc_html__( 'Displays popular posts using your theme sidebar design.', 'merotheme' ) )
		);
	}

	public function widget( $args, $instance ) {
		$title  = ! empty( $instance['title'] ) ? $instance['title'] : esc_html__( 'Popular Posts', 'merotheme' );
		$number = ! empty( $instance['number'] ) ? absint( $instance['number'] ) : 3;

		echo $args['before_widget']; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
		echo $args['before_title'] . esc_html( $title ) . $args['after_title']; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped

		$popular_posts = new WP_Query(
			array(
				'post_type'           => 'post',
				'posts_per_page'      => $number,
				'ignore_sticky_posts' => true,
			)
		);

		if ( $popular_posts->have_posts() ) :
			while ( $popular_posts->have_posts() ) :
				$popular_posts->the_post();
				?>
				<div class="sidebar-post-large">
					<?php if ( has_post_thumbnail() ) : ?>
						<a href="<?php the_permalink(); ?>">
							<?php the_post_thumbnail( 'medium' ); ?>
						</a>
					<?php endif; ?>

					<h5><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h5>
					<span><i class="fa fa-calendar"></i> <?php echo esc_html( get_the_date( 'M d,Y' ) ); ?></span>
				</div>
				<?php
			endwhile;
			wp_reset_postdata();
		endif;

		echo $args['after_widget']; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
	}

	public function form( $instance ) {
		$title  = ! empty( $instance['title'] ) ? $instance['title'] : esc_html__( 'Popular Posts', 'merotheme' );
		$number = ! empty( $instance['number'] ) ? absint( $instance['number'] ) : 3;
		?>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php esc_html_e( 'Title:', 'merotheme' ); ?></label>
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>">
		</p>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'number' ) ); ?>"><?php esc_html_e( 'Number of posts:', 'merotheme' ); ?></label>
			<input class="tiny-text" id="<?php echo esc_attr( $this->get_field_id( 'number' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'number' ) ); ?>" type="number" step="1" min="1" value="<?php echo esc_attr( $number ); ?>" size="3">
		</p>
		<?php
	}

	public function update( $new_instance, $old_instance ) {
		$instance           = array();
		$instance['title']  = sanitize_text_field( $new_instance['title'] );
		$instance['number'] = absint( $new_instance['number'] );
		return $instance;
	}
}

/**
 * Recent Posts Widget.
 */
class Merotheme_Recent_Posts_Widget extends WP_Widget {
	public function __construct() {
		parent::__construct(
			'merotheme_recent_posts_widget',
			esc_html__( 'MeroTheme Recent Posts', 'merotheme' ),
			array( 'description' => esc_html__( 'Displays recent posts using your theme sidebar design.', 'merotheme' ) )
		);
	}

	public function widget( $args, $instance ) {
		$title  = ! empty( $instance['title'] ) ? $instance['title'] : esc_html__( 'Recent Posts', 'merotheme' );
		$number = ! empty( $instance['number'] ) ? absint( $instance['number'] ) : 3;

		echo $args['before_widget']; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
		echo $args['before_title'] . esc_html( $title ) . $args['after_title']; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped

		$recent_posts = new WP_Query(
			array(
				'post_type'           => 'post',
				'posts_per_page'      => $number,
				'ignore_sticky_posts' => true,
			)
		);

		if ( $recent_posts->have_posts() ) :
			while ( $recent_posts->have_posts() ) :
				$recent_posts->the_post();
				?>
				<div class="sidebar-recent-post">
					<?php if ( has_post_thumbnail() ) : ?>
						<a href="<?php the_permalink(); ?>" class="recent-thumb">
							<?php the_post_thumbnail( 'thumbnail' ); ?>
						</a>
					<?php endif; ?>

					<div>
						<h5><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h5>
						<span><i class="fa fa-calendar"></i> <?php echo esc_html( get_the_date( 'M d,Y' ) ); ?></span>
					</div>
				</div>
				<?php
			endwhile;
			wp_reset_postdata();
		endif;

		echo $args['after_widget']; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
	}

	public function form( $instance ) {
		$title  = ! empty( $instance['title'] ) ? $instance['title'] : esc_html__( 'Recent Posts', 'merotheme' );
		$number = ! empty( $instance['number'] ) ? absint( $instance['number'] ) : 3;
		?>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php esc_html_e( 'Title:', 'merotheme' ); ?></label>
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>">
		</p>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'number' ) ); ?>"><?php esc_html_e( 'Number of posts:', 'merotheme' ); ?></label>
			<input class="tiny-text" id="<?php echo esc_attr( $this->get_field_id( 'number' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'number' ) ); ?>" type="number" step="1" min="1" value="<?php echo esc_attr( $number ); ?>" size="3">
		</p>
		<?php
	}

	public function update( $new_instance, $old_instance ) {
		$instance           = array();
		$instance['title']  = sanitize_text_field( $new_instance['title'] );
		$instance['number'] = absint( $new_instance['number'] );
		return $instance;
	}
}

/**
 * Categories Widget.
 */
class Merotheme_Categories_Widget extends WP_Widget {
	public function __construct() {
		parent::__construct(
			'merotheme_categories_widget',
			esc_html__( 'MeroTheme Categories', 'merotheme' ),
			array( 'description' => esc_html__( 'Displays categories using your theme sidebar design.', 'merotheme' ) )
		);
	}

	public function widget( $args, $instance ) {
		$title  = ! empty( $instance['title'] ) ? $instance['title'] : esc_html__( 'Categories', 'merotheme' );
		$number = ! empty( $instance['number'] ) ? absint( $instance['number'] ) : 6;

		echo $args['before_widget']; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
		echo $args['before_title'] . esc_html( $title ) . $args['after_title']; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
		?>
		<ul class="sidebar-categories">
			<?php
			wp_list_categories(
				array(
					'title_li' => '',
					'number'   => $number,
				)
			);
			?>
		</ul>
		<?php
		echo $args['after_widget']; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
	}

	public function form( $instance ) {
		$title  = ! empty( $instance['title'] ) ? $instance['title'] : esc_html__( 'Categories', 'merotheme' );
		$number = ! empty( $instance['number'] ) ? absint( $instance['number'] ) : 6;
		?>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php esc_html_e( 'Title:', 'merotheme' ); ?></label>
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>">
		</p>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'number' ) ); ?>"><?php esc_html_e( 'Number of categories:', 'merotheme' ); ?></label>
			<input class="tiny-text" id="<?php echo esc_attr( $this->get_field_id( 'number' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'number' ) ); ?>" type="number" step="1" min="1" value="<?php echo esc_attr( $number ); ?>" size="3">
		</p>
		<?php
	}

	public function update( $new_instance, $old_instance ) {
		$instance           = array();
		$instance['title']  = sanitize_text_field( $new_instance['title'] );
		$instance['number'] = absint( $new_instance['number'] );
		return $instance;
	}
}

/**
 * Tags Widget.
 */
class Merotheme_Tags_Widget extends WP_Widget {
	public function __construct() {
		parent::__construct(
			'merotheme_tags_widget',
			esc_html__( 'MeroTheme Tags', 'merotheme' ),
			array( 'description' => esc_html__( 'Displays tags using your theme sidebar design.', 'merotheme' ) )
		);
	}

	public function widget( $args, $instance ) {
		$title  = ! empty( $instance['title'] ) ? $instance['title'] : esc_html__( 'Tags', 'merotheme' );
		$number = ! empty( $instance['number'] ) ? absint( $instance['number'] ) : 8;

		echo $args['before_widget']; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
		echo $args['before_title'] . esc_html( $title ) . $args['after_title']; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
		?>
		<div class="sidebar-tags">
			<?php
			wp_tag_cloud(
				array(
					'smallest' => 12,
					'largest'  => 12,
					'unit'     => 'px',
					'number'   => $number,
					'format'   => 'flat',
				)
			);
			?>
		</div>
		<?php
		echo $args['after_widget']; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
	}

	public function form( $instance ) {
		$title  = ! empty( $instance['title'] ) ? $instance['title'] : esc_html__( 'Tags', 'merotheme' );
		$number = ! empty( $instance['number'] ) ? absint( $instance['number'] ) : 8;
		?>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php esc_html_e( 'Title:', 'merotheme' ); ?></label>
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>">
		</p>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'number' ) ); ?>"><?php esc_html_e( 'Number of tags:', 'merotheme' ); ?></label>
			<input class="tiny-text" id="<?php echo esc_attr( $this->get_field_id( 'number' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'number' ) ); ?>" type="number" step="1" min="1" value="<?php echo esc_attr( $number ); ?>" size="3">
		</p>
		<?php
	}

	public function update( $new_instance, $old_instance ) {
		$instance           = array();
		$instance['title']  = sanitize_text_field( $new_instance['title'] );
		$instance['number'] = absint( $new_instance['number'] );
		return $instance;
	}
}


// inner page hero widget

/**
 * Inner Page Hero Widget
 */
class Merotheme_Inner_Page_Hero_Widget extends WP_Widget {

	public function __construct() {
		parent::__construct(
			'merotheme_inner_page_hero_widget',
			esc_html__( 'MeroTheme Inner Page Hero', 'merotheme' ),
			array(
				'description' => esc_html__( 'Displays inner page hero image.', 'merotheme' ),
			)
		);
	}

	public function widget( $args, $instance ) {
		echo $args['before_widget'];

		$hero_image = ! empty( $instance['hero_image'] ) ? $instance['hero_image'] : '';
		?>

		<div class="agile-banner"<?php echo $hero_image ? ' style="background-image: url(\'' . esc_url( $hero_image ) . '\');"' : ''; ?>></div>

		<?php
		echo $args['after_widget'];
	}

	public function form( $instance ) {
		$hero_image = ! empty( $instance['hero_image'] ) ? $instance['hero_image'] : '';
		?>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'hero_image' ) ); ?>">
				<?php esc_html_e( 'Hero Image', 'merotheme' ); ?>
			</label>
			<input
				class="widefat merotheme-widget-image-url"
				id="<?php echo esc_attr( $this->get_field_id( 'hero_image' ) ); ?>"
				name="<?php echo esc_attr( $this->get_field_name( 'hero_image' ) ); ?>"
				type="url"
				value="<?php echo esc_url( $hero_image ); ?>"
			>
		</p>

		<p>
			<button type="button" class="button merotheme-widget-image-select">
				<?php esc_html_e( 'Select image', 'merotheme' ); ?>
			</button>
			<button type="button" class="button merotheme-widget-image-remove"<?php echo $hero_image ? '' : ' style="display:none;"'; ?>>
				<?php esc_html_e( 'Remove image', 'merotheme' ); ?>
			</button>
		</p>

		<div class="merotheme-widget-image-preview">
			<?php if ( $hero_image ) : ?>
				<img src="<?php echo esc_url( $hero_image ); ?>" alt="" style="max-width:100%;height:auto;">
			<?php endif; ?>
		</div>
		<?php
	}

	public function update( $new_instance, $old_instance ) {
		$instance               = array();
		$instance['hero_image'] = ! empty( $new_instance['hero_image'] ) ? esc_url_raw( $new_instance['hero_image'] ) : '';

		return $instance;
	}
}

class Merotheme_Breadcrumb_Widget extends WP_Widget {

	public function __construct() {
		parent::__construct(
			'merotheme_breadcrumb_widget',
			esc_html__( 'MeroTheme Breadcrumb', 'merotheme' ),
			array(
				'description' => esc_html__( 'Displays breadcrumb section.', 'merotheme' ),
			)
		);
	}

	public function widget( $args, $instance ) {
		echo $args['before_widget'];

		$page_id    = get_queried_object_id();
		$page_title = get_the_title( $page_id );
		?>

		<div class="breadcrumbs">
			<div class="container">
				<ol class="breadcrumb breadcrumb1">
					<li>
						<a href="<?php echo esc_url( home_url( '/' ) ); ?>">Home</a>
					</li>
					<li class="active">
						<?php echo esc_html( $page_title ); ?>
					</li>
				</ol>
			</div>
		</div>

		<?php
		echo $args['after_widget'];
	}
}

/**
 * Sidebar Position Widget.
 */
class Merotheme_Sidebar_Position_Widget extends WP_Widget {

	public function __construct() {
		parent::__construct(
			'merotheme_sidebar_position_widget',
			esc_html__( 'MeroTheme Sidebar Position', 'merotheme' ),
			array(
				'description' => esc_html__( 'Choose whether the site sidebar appears on the left or right.', 'merotheme' ),
			)
		);
	}

	public function widget( $args, $instance ) {
		return;
	}

	public function form( $instance ) {
		$position = ! empty( $instance['position'] ) ? $instance['position'] : get_option( 'merotheme_sidebar_position', 'right' );
		$position = in_array( $position, array( 'left', 'right' ), true ) ? $position : 'right';
		?>
		<p>
			<label>
				<input
					type="radio"
					name="<?php echo esc_attr( $this->get_field_name( 'position' ) ); ?>"
					value="left"
					<?php checked( $position, 'left' ); ?>
				>
				<?php esc_html_e( 'Left sidebar', 'merotheme' ); ?>
			</label>
		</p>
		<p>
			<label>
				<input
					type="radio"
					name="<?php echo esc_attr( $this->get_field_name( 'position' ) ); ?>"
					value="right"
					<?php checked( $position, 'right' ); ?>
				>
				<?php esc_html_e( 'Right sidebar', 'merotheme' ); ?>
			</label>
		</p>
		<p class="description">
			<?php esc_html_e( 'Save this widget after changing the position.', 'merotheme' ); ?>
		</p>
		<?php
	}

	public function update( $new_instance, $old_instance ) {
		$position = ! empty( $new_instance['position'] ) ? sanitize_key( $new_instance['position'] ) : 'right';
		$position = in_array( $position, array( 'left', 'right' ), true ) ? $position : 'right';

		update_option( 'merotheme_sidebar_position', $position );

		return array(
			'position' => $position,
		);
	}
}


/**
 * Register custom widgets.
 */
function merotheme_register_custom_widgets() {

	register_widget( 'Merotheme_Inner_Page_Hero_Widget' );
	register_widget( 'Merotheme_Breadcrumb_Widget' );
	register_widget( 'Merotheme_Slider_Widget' );
	register_widget( 'Merotheme_Search_Widget' );
	register_widget( 'Merotheme_Social_Widget' );
	register_widget( 'Merotheme_Popular_Posts_Widget' );
	register_widget( 'Merotheme_Recent_Posts_Widget' );
	register_widget( 'Merotheme_Categories_Widget' );
	register_widget( 'Merotheme_Tags_Widget' );
	register_widget( 'Merotheme_Sidebar_Position_Widget' );
}
add_action( 'widgets_init', 'merotheme_register_custom_widgets' );

// Load default _s files.
require get_template_directory() . '/inc/custom-header.php';
require get_template_directory() . '/inc/template-tags.php';
require get_template_directory() . '/inc/template-functions.php';
require get_template_directory() . '/inc/customizer.php';
require get_template_directory() . '/inc/enqueue.php';
require get_template_directory() . '/inc/acf-options.php';

// Load Jetpack compatibility if active.
if ( defined( 'JETPACK__VERSION' ) ) {
	require get_template_directory() . '/inc/jetpack.php';
}


/**
 * Disable block widgets (use classic widget UI)
 */
function merotheme_disable_block_widgets() {
	remove_theme_support( 'widgets-block-editor' );
}
add_action( 'after_setup_theme', 'merotheme_disable_block_widgets' );


add_action('admin_menu', function() {
	remove_menu_page('sidebar-settings');
	remove_menu_page('homepage-slider');
	remove_menu_page('homepage-slider1');
	remove_menu_page('theme-settings');

}, 999);

class MeroTheme_Footer_Contact extends WP_Widget {

	function __construct() {
		parent::__construct(
			'merotheme_footer_contact',
			__( 'MeroTheme Footer Contact', 'merotheme' )
		);
	}

	public function widget( $args, $instance ) {
		echo $args['before_widget'];

		echo '<h3>' . esc_html( $instance['title'] ?? '' ) . '</h3>';
		echo '<p><i class="fa fa-map-marker"></i> ' . esc_html( $instance['address'] ?? '' ) . '</p>';
		echo '<p><i class="fa fa-envelope"></i> ' . esc_html( $instance['email'] ?? '' ) . '</p>';
		echo '<p><i class="fa fa-mobile"></i> ' . esc_html( $instance['phone'] ?? '' ) . '</p>';
		echo '<p><i class="fa fa-globe"></i> ' . esc_html( $instance['website'] ?? '' ) . '</p>';

		echo $args['after_widget'];
	}

	public function form( $instance ) {
		?>
		<p><input class="widefat" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" placeholder="Title" value="<?php echo esc_attr( $instance['title'] ?? '' ); ?>"></p>
		<p><input class="widefat" name="<?php echo esc_attr( $this->get_field_name( 'address' ) ); ?>" placeholder="Address" value="<?php echo esc_attr( $instance['address'] ?? '' ); ?>"></p>
		<p><input class="widefat" name="<?php echo esc_attr( $this->get_field_name( 'email' ) ); ?>" placeholder="Email" value="<?php echo esc_attr( $instance['email'] ?? '' ); ?>"></p>
		<p><input class="widefat" name="<?php echo esc_attr( $this->get_field_name( 'phone' ) ); ?>" placeholder="Phone" value="<?php echo esc_attr( $instance['phone'] ?? '' ); ?>"></p>
		<p><input class="widefat" name="<?php echo esc_attr( $this->get_field_name( 'website' ) ); ?>" placeholder="Website" value="<?php echo esc_attr( $instance['website'] ?? '' ); ?>"></p>
		<?php
	}

	public function update( $new_instance, $old_instance ) {
		return array(
			'title'   => sanitize_text_field( $new_instance['title'] ?? '' ),
			'address' => sanitize_text_field( $new_instance['address'] ?? '' ),
			'email'   => sanitize_email( $new_instance['email'] ?? '' ),
			'phone'   => sanitize_text_field( $new_instance['phone'] ?? '' ),
			'website' => sanitize_text_field( $new_instance['website'] ?? '' ),
		);
	}
}

class MeroTheme_Footer_About extends WP_Widget {

	function __construct() {
		parent::__construct(
			'merotheme_footer_about',
			__( 'MeroTheme Footer About', 'merotheme' )
		);
	}

	public function widget( $args, $instance ) {
		echo $args['before_widget'];

		echo '<h3>' . esc_html( $instance['title'] ?? '' ) . '</h3>';
		echo '<p>' . esc_html( $instance['text'] ?? '' ) . '</p>';

		echo $args['after_widget'];
	}

	public function form( $instance ) {
		?>
		<p><input class="widefat" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" placeholder="Title" value="<?php echo esc_attr( $instance['title'] ?? '' ); ?>"></p>
		<p><textarea class="widefat" name="<?php echo esc_attr( $this->get_field_name( 'text' ) ); ?>" placeholder="Text"><?php echo esc_textarea( $instance['text'] ?? '' ); ?></textarea></p>
		<?php
	}

	public function update( $new_instance, $old_instance ) {
		return array(
			'title' => sanitize_text_field( $new_instance['title'] ?? '' ),
			'text'  => sanitize_textarea_field( $new_instance['text'] ?? '' ),
		);
	}
}

class MeroTheme_Footer_Newsletter extends WP_Widget {

	function __construct() {
		parent::__construct(
			'merotheme_footer_newsletter',
			__( 'MeroTheme Newsletter', 'merotheme' )
		);
	}

	public function widget( $args, $instance ) {
		echo $args['before_widget'];

		echo '<h3>' . esc_html( $instance['title'] ?? '' ) . '</h3>';
		echo '<p>' . esc_html( $instance['text'] ?? '' ) . '</p>';

		echo '<form>
				<input type="email" placeholder="Email">
				<input type="submit" value="Send" class="btn-send">
			  </form>';

		echo $args['after_widget'];
	}

	public function form( $instance ) {
		?>
		<p><input class="widefat" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" placeholder="Title" value="<?php echo esc_attr( $instance['title'] ?? '' ); ?>"></p>
		<p><textarea class="widefat" name="<?php echo esc_attr( $this->get_field_name( 'text' ) ); ?>" placeholder="Text"><?php echo esc_textarea( $instance['text'] ?? '' ); ?></textarea></p>
		<?php
	}

	public function update( $new_instance, $old_instance ) {
		return array(
			'title' => sanitize_text_field( $new_instance['title'] ?? '' ),
			'text'  => sanitize_textarea_field( $new_instance['text'] ?? '' ),
		);
	}
}

function merotheme_register_footer_widgets() {
	register_widget( 'MeroTheme_Footer_Contact' );
	register_widget( 'MeroTheme_Footer_About' );
	register_widget( 'MeroTheme_Footer_Newsletter' );
}
add_action( 'widgets_init', 'merotheme_register_footer_widgets' );

/**
 * Handle post like button clicks.
 */
function merotheme_handle_post_like() {
	check_ajax_referer( 'merotheme_like_post', 'nonce' );

	$post_id = isset( $_POST['post_id'] ) ? absint( $_POST['post_id'] ) : 0;

	if ( ! $post_id || 'post' !== get_post_type( $post_id ) ) {
		wp_send_json_error(
			array(
				'message' => esc_html__( 'Invalid post.', 'merotheme' ),
			)
		);
	}

	$likes = absint( get_post_meta( $post_id, 'post_likes', true ) );
	$likes++;

	update_post_meta( $post_id, 'post_likes', $likes );

	wp_send_json_success(
		array(
			'likes' => $likes,
		)
	);
}
add_action( 'wp_ajax_merotheme_like_post', 'merotheme_handle_post_like' );
add_action( 'wp_ajax_nopriv_merotheme_like_post', 'merotheme_handle_post_like' );
