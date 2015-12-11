<?php
/**
 * Beryl 1.0 back compat functionality
 *
 * Prevents Beryl 1.0 from running on WordPress versions prior to 3.6,
 * since this theme is not meant to be backward compatible beyond that
 * and relies on many newer functions and markup changes introduced in 3.6.
 *
 * @package WordPress
 * @subpackage Beryl
 * @since Beryl 1.0
 */

/**
 * Prevent switching to Beryl 1.0 on old versions of WordPress.
 *
 * Switches to the default theme.
 *
 * @since Beryl 1.0
 *
 * @return void
 */
function beryl_switch_theme() {
	switch_theme( WP_DEFAULT_THEME, WP_DEFAULT_THEME );
	unset( $_GET['activated'] );
	add_action( 'admin_notices', 'beryl_upgrade_notice' );
}
add_action( 'after_switch_theme', 'beryl_switch_theme' );

/**
 * Add message for unsuccessful theme switch.
 *
 * Prints an update nag after an unsuccessful attempt to switch to
 * Beryl 1.0 on WordPress versions prior to 3.6.
 *
 * @since Beryl 1.0
 *
 * @return void
 */
function beryl_upgrade_notice() {
	$message = sprintf( __( 'Beryl 1.0 requires at least WordPress version 3.6. You are running version %s. Please upgrade and try again.', 'beryl' ), $GLOBALS['wp_version'] );
	printf( '<div class="error"><p>%s</p></div>', $message );
}

/**
 * Prevent the Theme Customizer from being loaded on WordPress versions prior to 3.6.
 *
 * @since Beryl 1.0
 *
 * @return void
 */
function beryl_customize() {
	wp_die( sprintf( __( 'Beryl 1.0 requires at least WordPress version 3.6. You are running version %s. Please upgrade and try again.', 'beryl' ), $GLOBALS['wp_version'] ), '', array(
		'back_link' => true,
	) );
}
add_action( 'load-customize.php', 'beryl_customize' );

/**
 * Prevent the Theme Preview from being loaded on WordPress versions prior to 3.4.
 *
 * @since Beryl 1.0
 *
 * @return void
 */
function beryl_preview() {
	if ( isset( $_GET['preview'] ) ) {
		wp_die( sprintf( __( 'Beryl 1.0 requires at least WordPress version 3.6. You are running version %s. Please upgrade and try again.', 'beryl' ), $GLOBALS['wp_version'] ) );
	}
}
add_action( 'template_redirect', 'beryl_preview' );
