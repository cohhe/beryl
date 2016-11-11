<?php
/**
 * The template for displaying Search Results pages
 *
 * @package WordPress
 * @subpackage Beryl
 * @since Beryl 1.0
 */

get_header();

?>
<div id="main-content" class="main-content">
	<div class="content-wrapper">
		<?php if ( have_posts() ) :
				// Start the Loop.
				while ( have_posts() ) : the_post();

					/*
					 * Include the post format-specific template for the content. If you want to
					 * use this in a child theme, then include a file called called content-___.php
					 * (where ___ is the post format) and that will be used instead.
					 */
					get_template_part( 'content' );

				endwhile;
			else :
				// If no content, include the "No posts found" template.
				get_template_part( 'content', 'none' );

			endif;
		?>
	</div><!-- .content-wrapper -->
</div><!-- #main-content -->

<?php
get_footer();
