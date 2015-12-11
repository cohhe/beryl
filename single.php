<?php
/**
 * The Template for displaying all single posts
 *
 * @package WordPress
 * @subpackage Beryl
 * @since Beryl 1.0
 */

get_header();

global $beryl_site_width;
?>

<div id="main-content" class="main-content row">
	<div class="content-wrapper">
		<?php
			// Start the Loop.
			while ( have_posts() ) : the_post();

				/*
				 * Include the post format-specific template for the content. If you want to
				 * use this in a child theme, then include a file called called content-___.php
				 * (where ___ is the post format) and that will be used instead.
				 */

				get_template_part( 'content', get_post_format() ? get_post_format() : get_post_type() );

			endwhile;
		?>
	</div><!-- .content-wrapper -->
</div><!-- #main-content -->

<?php
get_footer();