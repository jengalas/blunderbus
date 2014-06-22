<?php
/**
 * The template for displaying Search Results pages.
 *
 * @package Surveymarks
 */

get_header(); ?>

	<?php if ( have_posts() ) : ?>

		<header class="page-header">
			<h2 class="page-title"><?php printf( __( 'Search Results for: %s', 'surveymarks' ), '<span>' . get_search_query() . '</span>' ); ?></h2>
		</header><!-- .page-header -->

		<?php // start the loop. ?>
		<?php while ( have_posts() ) : the_post(); ?>

			<?php get_template_part( 'content', 'search' ); ?>

		<?php endwhile; ?>

		<?php surveymarks_content_nav( 'nav-below' ); ?>

	<?php else : ?>

		<?php get_template_part( 'no-results', 'search' ); ?>

	<?php endif; // end of loop. ?>

<?php get_footer(); ?>