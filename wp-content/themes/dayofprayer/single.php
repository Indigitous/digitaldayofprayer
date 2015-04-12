<?php
/**
 * The template for displaying all single posts.
 *
 * @package dxl
 */
return;
get_header(); ?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">
			<div class="container">
				<div class="row">
					<div class="col-sm-8">

						<?php while ( have_posts() ) : the_post(); ?>

							<?php get_template_part( 'content', 'single' ); ?>

							<?php the_post_navigation(); ?>

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
			</div>
		</main><!-- #main -->
	</div><!-- #primary -->

<?php get_footer(); ?>
