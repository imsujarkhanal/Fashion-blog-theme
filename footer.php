<footer class="footer-agile-info">
	<div class="container">
		<div class="row">

			<div class="col-md-4 footer-left">
				<?php dynamic_sidebar( 'footer-col-1' ); ?>
			</div>

			<div class="col-md-4 footer-middle">
				<?php dynamic_sidebar( 'footer-col-2' ); ?>
			</div>

			<div class="col-md-4 footer-right">
				<?php dynamic_sidebar( 'footer-col-3' ); ?>
			</div>

		</div>
	</div>
</footer>

<div class="copyright">
	<div class="container">

		<div class="w3agile-list">
			<?php
			wp_nav_menu(
				array(
					'theme_location' => 'footer-menu',
					'container'      => false,
					'menu_class'     => 'footer-menu',
					'fallback_cb'    => false,
					'depth'          => 1,
				)
			);
			?>
		</div>

		<div class="agileinfo">
			<p>
				&copy; 2026 Fashion Blog . All Rights Reserved . Design by
				<span class="author-name">imsujarkhanal</span>
			</p>
		</div>

	</div>
</div>

<?php if ( get_field( 'enable_back_to_top', 'option' ) ) : ?>

	<a href="<?php echo esc_url( get_field( 'back_to_top_link', 'option' ) ?: '#top' ); ?>"
	   id="backToTop"
	   class="back-to-top">

		<i class="<?php echo esc_attr( get_field( 'icon_class', 'option' ) ?: 'fa fa-chevron-up' ); ?>"
		   style="font-size: <?php echo esc_attr( get_field( 'icon_size', 'option' ) ?: 24 ); ?>px;">
		</i>

	</a>

<?php endif; ?>
<?php wp_footer(); ?>

</body>
</html>
