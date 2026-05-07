<?php
/**
 * The template for displaying search results pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#search-result
 *
 * @package merotheme
 */

get_header();

$sidebar_position = merotheme_get_sidebar_position();
?>

<div class="container">
	<div class="banner-btm-agile sidebar-<?php echo esc_attr( $sidebar_position ); ?>">

		<?php if ( 'left' === $sidebar_position ) : ?>
			<div class="col-md-3 w3agile_blog_left">
				<?php get_sidebar(); ?>
			</div>
		<?php endif; ?>

		<div class="col-md-9 btm-wthree-left">
			<main id="primary" class="site-main">

				<?php if ( have_posts() ) : ?>

					<?php $show_comments = 1 === (int) $GLOBALS['wp_query']->post_count; ?>

					<header class="page-header">
						<h1 class="page-title">
							<?php
							printf(
								/* translators: %s: search query. */
								esc_html__( 'Search Results for: %s', 'merotheme' ),
								'<span>' . esc_html( get_search_query() ) . '</span>'
							);
							?>
						</h1>
					</header><!-- .page-header -->

					<?php
					while ( have_posts() ) :
						the_post();

						get_template_part( 'template-parts/content', get_post_type() );

						if ( $show_comments ) :
							global $withcomments;
							$withcomments = true;
							comments_template();
						endif;

					endwhile;

					the_posts_navigation();

				else :

					get_template_part( 'template-parts/content', 'none' );

				endif;
				?>

			</main><!-- #main -->
		</div>

		<?php if ( 'right' === $sidebar_position ) : ?>
			<div class="col-md-3 w3agile_blog_left">
				<?php get_sidebar(); ?>
			</div>
		<?php endif; ?>

		<div class="clearfix"></div>

	</div>
</div>

<?php get_footer(); ?>
