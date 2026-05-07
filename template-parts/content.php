<?php
/**
 * Template part for displaying posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package merotheme
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<header class="entry-header">
		<?php
		if ( is_singular() ) :
			the_title( '<h1 class="entry-title">', '</h1>' );
		else :
			the_title( '<h2 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' );
		endif;

		if ( 'post' === get_post_type() ) :
			?>
			<div class="entry-meta">
				<?php
				merotheme_posted_on();
				merotheme_posted_by();
				?>
			</div><!-- .entry-meta -->
		<?php endif; ?>
	</header><!-- .entry-header -->

	<?php merotheme_post_thumbnail(); ?>

	<div class="entry-content">
		<?php
		the_content(
			sprintf(
				wp_kses(
					/* translators: %s: Name of current post. Only visible to screen readers */
					__( 'Continue reading<span class="screen-reader-text"> "%s"</span>', 'merotheme' ),
					array(
						'span' => array(
							'class' => array(),
						),
					)
				),
				wp_kses_post( get_the_title() )
			)
		);

		wp_link_pages(
			array(
				'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'merotheme' ),
				'after'  => '</div>',
			)
		);
		?>
	</div><!-- .entry-content -->

	<?php if ( is_singular( 'post' ) ) : ?>
		<?php
		$post_id = get_the_ID();
		?>
		<div class="single-post-like">
			<button
				type="button"
				class="post-like-button"
				data-post-id="<?php echo esc_attr( $post_id ); ?>"
			>
				<i class="fa fa-thumbs-up"></i>
				<span><?php esc_html_e( 'Like', 'merotheme' ); ?></span>
			</button>
		</div>
	<?php endif; ?>

	<?php
	/*
	<footer class="entry-footer">
		<?php merotheme_entry_footer(); ?>
	</footer><!-- .entry-footer -->
	*/
	?>
</article><!-- #post-<?php the_ID(); ?> -->
