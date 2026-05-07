<?php
/**
 * The template for displaying all single posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
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

				<?php
				while ( have_posts() ) :
					the_post();

					get_template_part( 'template-parts/content', get_post_type() );

					/*
					the_post_navigation(
						array(
							'prev_text' => '<span class="nav-subtitle">' . esc_html__( 'Previous:', 'merotheme' ) . '</span> <span class="nav-title">%title</span>',
							'next_text' => '<span class="nav-subtitle">' . esc_html__( 'Next:', 'merotheme' ) . '</span> <span class="nav-title">%title</span>',
						)
					);
					*/

					if ( comments_open() || get_comments_number() ) :
						comments_template();
					endif;

				endwhile;
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
