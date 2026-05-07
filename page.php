<?php
/**
 * Template for all pages
 *
 * @package merotheme
 */

get_header();

$sidebar_position = merotheme_get_sidebar_position();
?>

<!-- -->

<div class="container">
	<div class="banner-btm-agile sidebar-<?php echo esc_attr( $sidebar_position ); ?>">

		<?php if ( 'left' === $sidebar_position ) : ?>
			<div class="col-md-3 w3agile_blog_left">
				<?php get_sidebar(); ?>
			</div>
		<?php endif; ?>

		<div class="col-md-9 btm-wthree-left">

			<?php
			if ( have_posts() ) :
				while ( have_posts() ) :
					the_post();
					?>

					<h1 class="page-title"><?php the_title(); ?></h1>

					<div class="entry-content">
						<?php the_content(); ?>
					</div>

					<?php
				endwhile;
			endif;
			?>

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
