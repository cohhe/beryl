<?php
/**
 * Custom template tags for Beryl 1.0
 *
 * @package WordPress
 * @subpackage Beryl
 * @since Beryl 1.0
 */

if ( ! function_exists( 'beryl_posted_on' ) ) :
/**
 * Print HTML with meta information for the current post-date/time and author.
 *
 * @since Beryl 1.0
 *
 * @return void
 */
function beryl_posted_on( $post_id = '' ) {
	global $post;

	// Check if post id given
	if ( $post_id != '' ) {
		$post = get_post( $post_id );
	}

	// if ( is_sticky() && is_home() && ! is_paged() ) {
	// 	echo '<span class="sticky-featured-post">' . __( 'Sticky', 'beryl' ) . '</span>';
	// }

	// Set up and print post meta information.
	printf( '<span class="byline"><span class="author vcard"><a class="url fn n icon-user" href="%4$s" rel="author">%5$s</a></span></span>',
		esc_url( get_permalink() ),
		esc_attr( get_the_date( 'c' ) ),
		esc_html( get_the_date() ),
		esc_url( get_author_posts_url( $post->post_author ) ),
		get_the_author_meta( 'display_name' , $post->post_author)
	);
}
endif;

/**
 * Find out if blog has more than one category.
 *
 * @since Beryl 1.0
 *
 * @return boolean true if blog has more than 1 category
 */
function beryl_categorized_blog() {
	if ( false === ( $all_the_cool_cats = get_transient( 'beryl_category_count' ) ) ) {
		// Create an array of all the categories that are attached to posts
		$all_the_cool_cats = get_categories( array(
			'hide_empty' => 1,
		) );

		// Count the number of categories that are attached to the posts
		$all_the_cool_cats = count( $all_the_cool_cats );

		set_transient( 'beryl_category_count', $all_the_cool_cats );
	}

	if ( 1 !== (int) $all_the_cool_cats ) {
		// This blog has more than 1 category so beryl_categorized_blog should return true
		return true;
	} else {
		// This blog has only 1 category so beryl_categorized_blog should return false
		return false;
	}
}

/**
 * Flush out the transients used in beryl_categorized_blog.
 *
 * @since Beryl 1.0
 *
 * @return void
 */
function beryl_category_transient_flusher() {
	// Like, beat it. Dig?
	delete_transient( 'beryl_category_count' );
}
add_action( 'edit_category', 'beryl_category_transient_flusher' );
add_action( 'save_post',     'beryl_category_transient_flusher' );

/**
 * Display an optional post thumbnail.
 *
 * Wraps the post thumbnail in an anchor element on index
 * views, or a div element when on single views.
 *
 * @since Beryl 1.0
 *
 * @return void
*/
function beryl_post_thumbnail() {
	if ( post_password_required() || ! has_post_thumbnail() ) {
		return;
	}

	if ( is_single() ) :
	?>
	<?php
		the_post_thumbnail( 'beryl-huge-width' );
	?>

	<?php else : ?>

	<a class="post-thumbnail animated bounceIn" href="<?php the_permalink(); ?>">
	<?php
		the_post_thumbnail( 'beryl-full-width' );
	?>
	</a>

	<?php endif; // End is_singular()
}
