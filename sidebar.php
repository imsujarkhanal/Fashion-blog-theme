<?php
/**
 * Sidebar template
 *
 * @package merotheme
 */
?>

<aside class="sidebar">

	<?php if ( is_active_sidebar( 'sidebar-1' ) ) : ?>

		<?php dynamic_sidebar( 'sidebar-1' ); ?>

	<?php else : ?>

		<div class="sidebar-section">
			<h4><?php esc_html_e( 'Sidebar', 'merotheme' ); ?></h4>
			<p><?php esc_html_e( 'Add widgets from Appearance → Widgets.', 'merotheme' ); ?></p>
		</div>

	<?php endif; ?>

	

</aside>
