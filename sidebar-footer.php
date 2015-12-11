<?php
/**
 * The Footer Sidebar
 *
 * @package WordPress
 * @subpackage Zap
 * @since Zap 1.0
 */

if ( !is_active_sidebar( 'sidebar-1' ) ) {
	return;
}
?>

<div id="footer-sidebar" class="footer-sidebar widget-area" role="complementary">
	<?php dynamic_sidebar( 'sidebar-1' ); ?>
</div><!-- #footer-sidebar -->
