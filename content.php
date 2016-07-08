<?php
/**
 * The default template for displaying content
 *
 * Used for both single and index/archive/search.
 *
 * @package WordPress
 * @subpackage Beryl
 * @since Beryl 1.0
 */

$img = wp_get_attachment_image_src( get_post_thumbnail_id(), 'beryl-full-width' );
$img_html = '';
if ( !empty($img) ) {
	$img_html .= '<div class="post-middle-picture"><div class="post-image-container" style="background: url(' . esc_url( $img['0'] ) . ');"></div></div>';
} else {
	$img_html .= '<div class="post-middle-picture no-image icon-picture"></div>';
}

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<div class="post-wrapper">
		<div class="post-left-content">
			<div class="post-left-inner">
				<h1 class="post-title"><?php echo get_the_title(); ?></h1>
				<div class="post-excerpt"><?php echo get_the_excerpt(); ?></div>
				<a href="<?php the_permalink(); ?>" class="post-read-more icon-angle-right"><?php _e('Read more', 'beryl'); ?></a>
			</div>
		</div>
		<?php echo $img_html; ?>
		<div class="post-right-content">
			<div class="post-inner-title">
				<h1><?php echo get_the_title(); ?></h1>
			</div>
			<div class="post-content-wrapper">
				<div class="post-meta">
					<?php beryl_category_list( get_the_ID() ); ?>
					<?php beryl_tag_list( get_the_ID() ); ?>
				</div>
				<?php the_content(); ?>
				<?php comments_template( '/comments.php', true ); ?>
				<?php
					wp_link_pages( array(
						'before'      => '<div class="page-links"><span class="page-links-title">' . __( 'Pages:', 'beryl' ) . '</span>',
						'after'       => '<div class="clearfix"></div></div>',
						'link_before' => '<span>',
						'link_after'  => '</span>',
					) );
				?>
			</div>
			<div class="post-footer-wrapper">
				<div class="post-footer-inner">
					<?php if ( is_active_sidebar( 'sidebar-1' ) ) { ?>
						<div id="footer-sidebar" class="footer-sidebar widget-area" role="complementary">
							<?php dynamic_sidebar( 'sidebar-1' ); ?>
						</div><!-- #footer-sidebar -->
					<?php } ?>
					<div class="post-copyright">&copy; <?php echo date('Y') ?> <a href="https://cohhe.com" target="_blank">Cohhe Themes</a>. All rights reserved.</div>
				</div>
			</div>
		</div>
	</div>
</article>