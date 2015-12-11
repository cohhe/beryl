<?php
/**
 * The template for displaying all pages
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages and that
 * other 'pages' on your WordPress site will use a different template.
 *
 * @package WordPress
 * @subpackage Beryl
 * @since Beryl 1.0
 */

get_header();

global $beryl_site_width, $beryl_layout_type;

?>

<div id="main-content" class="main-content ">
	<div class="content-wrapper">

			<?php
				// Start the Loop.
				while ( have_posts() ) : the_post();

					// Include the page content template.
					get_template_part( 'content', 'page' );

				endwhile;
			?>

	</div><!-- .content-wrapper -->
</div><!-- #main-content -->

<?php
get_footer();