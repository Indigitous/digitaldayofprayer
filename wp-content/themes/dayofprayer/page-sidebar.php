<?php
/**
 * Template Name: Right Sidebar
 *
 * @package dxl
 */

get_header(); ?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">
			<div class="container">

			<?php
				if( function_exists( 'yoast_breadcrumb' ) ) {
					yoast_breadcrumb('<p id="breadcrumbs">','</p>');
				}
			?>

				<div class="row">
					<div class="col-sm-8">
						<?php while ( have_posts() ) : the_post(); ?>

							<?php get_template_part( 'content', 'page' ); ?>

							<?php
								// If comments are open or we have at least one comment, load up the comment template
								if ( comments_open() || get_comments_number() ) :
									comments_template();
								endif;
							?>

						<?php endwhile; // end of the loop. ?>
					</div>
					<div class="col-sm-4">
						<?php get_sidebar(); ?>
					</div>
				</div>
			</div><!-- .container -->
		</main><!-- #main -->
	</div><!-- #primary -->

<?php get_footer(); ?>
