<?php
get_header();

$sidebar_position = merotheme_get_sidebar_position();
?>

<main id="primary" class="site-main">



	<div class="banner-btm-agile sidebar-<?php echo esc_attr( $sidebar_position ); ?>">
		<div class="container">
			<div class="row">

				<?php if ( 'left' === $sidebar_position ) : ?>
					<div class="col-md-4 w3agile_blog_left">
						<?php get_sidebar(); ?>
					</div>
				<?php endif; ?>

				<div class="col-md-8">
					<section class="home-posts">
						<h2>Latest Posts</h2>

						<?php
						$home_posts = new WP_Query(
							array(
								'post_type'      => 'post',
								'posts_per_page' => 4,
							)
						);

						if ( $home_posts->have_posts() ) :
							while ( $home_posts->have_posts() ) :
								$home_posts->the_post();

								$post_id = get_the_ID();
								$likes   = absint( get_post_meta( $post_id, 'post_likes', true ) );
								?>

								<article class="blog-post">

									<?php if ( has_post_thumbnail() ) : ?>
										<div class="post-image">
											<a href="<?php the_permalink(); ?>">
												<?php the_post_thumbnail( 'large' ); ?>
											</a>
										</div>
									<?php endif; ?>

									<div class="post-meta">
										<span>
											<i class="fa fa-calendar"></i>
											<?php echo esc_html( get_the_date() ); ?>
										</span>

										<span>
											<i class="fa fa-thumbs-up"></i>
											<span class="post-like-count"><?php echo esc_html( $likes ); ?></span> likes
										</span>
									<br>
									<span>
										<i class="fa fa-comments"></i>
										<?php echo esc_html( get_comments_number() ); ?> comments
									</span>
									</div>

									<h3 class="post-title">
										<a href="<?php the_permalink(); ?>">
											<?php the_title(); ?>
										</a>
									</h3>

									<div class="post-excerpt">
										<?php the_excerpt(); ?>
									</div>

								</article>

								<?php
							endwhile;
							wp_reset_postdata();
						else :
							echo '<p>No posts found.</p>';
						endif;
						?>

					</section>
				</div>

				<?php if ( 'right' === $sidebar_position ) : ?>
					<div class="col-md-4 w3agile_blog_left">
						<?php get_sidebar(); ?>
					</div>
				<?php endif; ?>

			</div>
		</div>
	</div>

</main>

<?php
get_footer();
