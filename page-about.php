<?php
/**
 * Template Name: About Page
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

			<!-- ABOUT SECTION -->
			<div class="courses">

				<div class="agileits_heading_section">
					<h3 class="wthree_head">About</h3>
					<p class="agileinfo_para">
						Nam tempus lobortis sem non ornare in aliquet egestas, nisi mi vestibulum.
					</p>
				</div>

				<div class="agileits_w3layouts_team_grids w3ls_courses_grids">

					<div class="col-md-6 w3ls_banner_bottom_left w3ls_courses_left">
						<div class="w3ls_courses_left_grids">

							<div class="w3ls_courses_left_grid">
								<h3>
									<i class="fa fa-pencil-square-o" aria-hidden="true"></i>
									Pulvinar Neque Pharetra Eget
								</h3>
								<p>
									Pellentesque convallis diam consequat magna vulputate malesuada.
									Cras a ornare elit. Nulla viverra pharetra sem, eget pulvinar neque pharetra ac.
								</p>
							</div>

							<div class="w3ls_courses_left_grid">
								<h3>
									<i class="fa fa-pencil-square-o" aria-hidden="true"></i>
									Consequat Magna Vulputate
								</h3>
								<p>
									Pellentesque convallis diam consequat magna vulputate malesuada.
									Cras a ornare elit. Nulla viverra pharetra sem, eget pulvinar neque pharetra ac.
								</p>
							</div>

							<div class="w3ls_courses_left_grid">
								<h3>
									<i class="fa fa-pencil-square-o" aria-hidden="true"></i>
									Convallis Diam Consequat Magna
								</h3>
								<p>
									Pellentesque convallis diam consequat magna vulputate malesuada.
									Cras a ornare elit. Nulla viverra pharetra sem, eget pulvinar neque pharetra ac.
								</p>
							</div>

						</div>
					</div>

					<div class="col-md-6 agileits_courses_right">
						<img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/5.jpg' ); ?>" alt="About Image" class="img-responsive">
					</div>

					<div class="clearfix"></div>

				</div>
			</div>

			<!-- SKILLS SECTION -->
			<div class="team">

				<div class="w3_agile_team_grid">
					<div class="agileits_heading_section">
						<h3 class="wthree_head">Our Skills</h3>
						<p class="agileinfo_para">
							Nam tempus lobortis sem non ornare in aliquet egestas, nisi mi vestibulum.
						</p>
					</div>
					<div class="clearfix"></div>
				</div>

				<div class="agileits_w3layouts_team_grids">

					<div class="col-md-6 w3l_stats_bottom_grid_left">
						<img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/t1.jpg' ); ?>" alt="Skills Image" class="img-responsive">
					</div>

					<div class="col-md-6 w3l_stats_bottom_grid_right">

					<div class="skill-item">

                            <h4>HTML / CSS Design</h4>
                            <div class="skill-bar">
                                <span data-percent="65">0%</span>
                            </div>

                            <h4>Graphic Design</h4>
                            <div class="skill-bar">
                                <span data-percent="35">0%</span>
                            </div>

                            <h4>SEO</h4>
                            <div class="skill-bar">
                                <span data-percent="45">0%</span>
                            </div>

                            <h4>WordPress</h4>
                            <div class="skill-bar">
                                <span data-percent="100">0%</span>
                            </div>

                        </div>

					</div>

					<div class="clearfix"></div>

				</div>
			</div>

			<!-- TEAM SECTION -->
			<div class="welcome">

				<div class="agileits_heading_section">
					<h3 class="wthree_head">Team</h3>
					<p class="agileinfo_para">
						Nam tempus lobortis sem non ornare in aliquet egestas, nisi mi vestibulum.
					</p>
				</div>

				<div class="w3ls_news_grids w3_agileits_team_grids">

					<div class="col-md-6 w3_agileits_team_grid">
						<div class="w3layouts_news_grid">
							<img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/t2.jpg' ); ?>" alt="Team Member" class="img-responsive">
                            <div class="team-overlay">
                                <a href="#"><i class="fa fa-facebook"></i></a>
                                <a href="#"><i class="fa fa-twitter"></i></a>
                                <a href="#"><i class="fa fa-dribbble"></i></a>
                            </div>
						</div>
						<h4>Andria Carl</h4>
						<p>Field Manager</p>
					</div>

					<div class="col-md-6 w3_agileits_team_grid">
						<div class="w3layouts_news_grid">
							<img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/t1.jpg' ); ?>" alt="Team Member" class="img-responsive">
                            <div class="team-overlay">
		<a href="#"><i class="fa fa-facebook"></i></a>
		<a href="#"><i class="fa fa-twitter"></i></a>
		<a href="#"><i class="fa fa-dribbble"></i></a>
	</div>
						</div>
						<h4>Laura Doe</h4>
						<p>Farmer</p>
					</div>

					<div class="col-md-6 w3_agileits_team_grid">
						<div class="w3layouts_news_grid">
							<img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/t3.jpg' ); ?>" alt="Team Member" class="img-responsive">
                            <div class="team-overlay">
		<a href="#"><i class="fa fa-facebook"></i></a>
		<a href="#"><i class="fa fa-twitter"></i></a>
		<a href="#"><i class="fa fa-dribbble"></i></a>
	</div>
						</div>
						<h4>Rosy Paul</h4>
						<p>Co-Founder</p>
					</div>

					<div class="col-md-6 w3_agileits_team_grid">
						<div class="w3layouts_news_grid">
							<img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/t4.jpg' ); ?>" alt="Team Member" class="img-responsive">
                            <div class="team-overlay">
		<a href="#"><i class="fa fa-facebook"></i></a>
		<a href="#"><i class="fa fa-twitter"></i></a>
		<a href="#"><i class="fa fa-dribbble"></i></a>
	</div>
						</div>
						<h4>Christopher Lii</h4>
						<p>Senior Staff</p>
					</div>

					<div class="clearfix"></div>

				</div>
			</div>

		</div>

		<?php if ( 'right' === $sidebar_position ) : ?>
			<div class="col-md-3 w3agile_blog_left">
				<?php get_sidebar(); ?>
			</div>
		<?php endif; ?>

		<div class="clearfix"></div>

	</div>
</div>

<?php
get_footer();
