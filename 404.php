<?php
/**
 * The template for displaying 404 pages (not found)
 *
 * @link https://codex.wordpress.org/Creating_an_Error_404_Page
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

				<section class="error-404 not-found">
					<header class="page-header">
						<h1 class="page-title"><?php esc_html_e( 'Oops! That page can&rsquo;t be found.', 'merotheme' ); ?></h1>
					</header><!-- .page-header -->

					<div class="page-content">
						<p><?php esc_html_e( 'It looks like nothing was found at this location. Maybe try one of the links below or a search?', 'merotheme' ); ?></p>

						<?php
						get_search_form();

						the_widget( 'WP_Widget_Recent_Posts' );
						?>

						<div class="widget widget_categories">
							<h2 class="widget-title"><?php esc_html_e( 'Most Used Categories', 'merotheme' ); ?></h2>
							<ul>
								<?php
								wp_list_categories(
									array(
										'orderby'    => 'count',
										'order'      => 'DESC',
										'show_count' => 1,
										'title_li'   => '',
										'number'     => 10,
									)
								);
								?>
							</ul>
						</div><!-- .widget -->

						<?php
						/* translators: %1$s: smiley */
						$merotheme_archive_content = '<p>' . sprintf( esc_html__( 'Try looking in the monthly archives. %1$s', 'merotheme' ), convert_smilies( ':)' ) ) . '</p>';
						the_widget( 'WP_Widget_Archives', 'dropdown=1', "after_title=</h2>$merotheme_archive_content" );

						the_widget( 'WP_Widget_Tag_Cloud' );
						?>

					</div><!-- .page-content -->
				</section><!-- .error-404 -->

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
