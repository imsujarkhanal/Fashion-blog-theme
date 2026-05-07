<?php
/**
 * Header template
 */
?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<!-- <link rel="profile" href="https://gmpg.org/xfn/11"> -->

	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<div id="page" class="site">

	<header id="masthead" class="site-header">

		<!-- Top strip -->
		<div class="w3layouts-top-strip">
			<div class="container">
				<div class="logo">
					<?php if ( is_front_page() && is_home() ) : ?>
						<h1>
							<a href="<?php echo esc_url( home_url( '/' ) ); ?>">
								<?php bloginfo( 'name' ); ?>
							</a>
						</h1>
					<?php else : ?>
						<p>
							<a href="<?php echo esc_url( home_url( '/' ) ); ?>">
								<?php bloginfo( 'name' ); ?>
							</a>
						</p>
					<?php endif; ?>

					<?php if ( get_bloginfo( 'description' ) ) : ?>
						<p><?php bloginfo( 'description' ); ?></p>
					<?php endif; ?>
				</div>

				<div class="w3ls-social-icons">
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
						$url = get_field( $field_name, 'option' );

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
			</div>
		</div>

		<!-- Navigation -->
		<nav class="navbar navbar-default">
			<div class="container">

				<div class="navbar-header">
					<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#main-menu" aria-expanded="false">
						<span class="sr-only">Toggle navigation</span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
					</button>
				</div>

				<div class="collapse navbar-collapse" id="main-menu">
					<?php
					wp_nav_menu(
						array(
							'theme_location' => 'menu-1',
							'container'      => false,
							'menu_class'     => 'nav navbar-nav',
							'fallback_cb'    => false,
						)
					);
					?>
				</div>

				<div class="w3_agile_login">
					<div class="cd-main-header">
						<a class="cd-search-trigger" href="#cd-search"><span></span></a>
					</div>

					<div id="cd-search" class="cd-search">
						<form role="search" method="get" action="<?php echo esc_url( home_url( '/' ) ); ?>">
							<input type="search" name="s" placeholder="Search...">
						</form>
					</div>
				</div>

				<div class="clearfix"></div>
			</div>
		</nav>

		<!-- HEADER WIDGET LOGIC -->

		<?php if ( is_front_page() || is_home() ) : ?>

			<?php if ( is_active_sidebar( 'homepage-header-slider' ) ) : ?>
				<div class="homepage-header-slider-area">
					<?php dynamic_sidebar( 'homepage-header-slider' ); ?>
				</div>
			<?php endif; ?>

	<?php else : ?>

	<?php if ( is_active_sidebar( 'inner-page-hero-section' ) ) : ?>
		<div class="inner-page-hero-area">
			<?php dynamic_sidebar( 'inner-page-hero-section' ); ?>
		</div>
	<?php endif; ?>

<?php endif; ?>

	</header>
