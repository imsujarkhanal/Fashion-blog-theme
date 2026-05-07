<?php
/**
 * Page Hero Section
 *
 * Shows hero image and breadcrumb on inner pages.
 */

$hero_image = get_field( 'page_hero_image' );
$hero_title = get_field( 'page_hero_title' );

if ( ! $hero_title ) {
	$hero_title = get_the_title();
}
?>

<section class="page-hero" style="background-image: url('<?php echo esc_url( $hero_image['url'] ?? '' ); ?>');">
	<div class="container">
		<div class="page-hero-content">

			<h1><?php echo esc_html( $hero_title ); ?></h1>

			<div class="breadcrumb">
				<a href="<?php echo esc_url( home_url( '/' ) ); ?>">Home</a>
				<span> / </span>
				<span><?php echo esc_html( get_the_title() ); ?></span>
			</div>

		</div>
	</div>
</section>