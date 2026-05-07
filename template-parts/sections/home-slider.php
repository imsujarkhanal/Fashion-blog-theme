<section class="home-slider">
	<div class="slider">
		<div id="demo1">
			<ul class="slides">

					<?php if ( have_rows( 'slider_images', get_queried_object_id() ) ) : ?>
					<?php while ( have_rows( 'slider_images' ) ) : the_row();

						$image = get_sub_field( 'slide_image' );
						$title = get_sub_field( 'slide_title' );
						$desc  = get_sub_field( 'slide_description' );
					?>

						<li>
							<?php if ( $image ) : ?>
								<img src="<?php echo esc_url( $image['url'] ); ?>" alt="">
							<?php endif; ?>

							<div class="slide-desc">
								<h3><?php echo esc_html( $title ); ?></h3>
								<p><?php echo esc_html( $desc ); ?></p>
							</div>
						</li>

					<?php endwhile; ?>
				<?php endif; ?>

			</ul>
		</div>
	</div>
</section>