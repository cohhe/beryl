<?php
/**
 * The main template file
 *
 * This is the most generic template file in a WordPress theme and one
 * of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query,
 * e.g., it puts together the home page when no home.php file exists.
 *
 * @link http://codex.wordpress.org/Template_Hierarchy
 *
 * @package WordPress
 * @subpackage Beryl
 * @since Beryl 1.0
 */

get_header();
?>

<div id="main-content" class="main-content">
	<div class="content-wrapper">
		<?php
			if ( have_posts() ) {
				// Start the Loop.
				while ( have_posts() ) { the_post();

					/*
					 * Include the post format-specific template for the content. If you want to
					 * use this in a child theme, then include a file called called content-___.php
					 * (where ___ is the post format) and that will be used instead.
					 */
					get_template_part( 'content', get_post_format() );

				};
			} else {
				// If no content, include the "No posts found" template.
				get_template_part( 'content', 'none' );
			}
		?>
	</div><!-- .content-wrapper -->
</div><!-- #main-content -->

<?php

// Previous/next page navigation.
the_posts_pagination( array(
	'prev_text'          => __( 'Previous page', 'beryl' ),
	'next_text'          => __( 'Next page', 'beryl' ),
	'before_page_number' => '<span class="meta-nav screen-reader-text">' . __( 'Page', 'beryl' ) . ' </span>',
) );

?>

<?php
get_footer();