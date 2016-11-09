<?php
/**
 * The Header for our theme
 *
 * Displays all of the <head> section and everything up till <div id="main">
 *
 * @package WordPress
 * @subpackage Beryl
 * @since Beryl 1.0
 */
?><!DOCTYPE html>
<!--[if IE 7]>
<html class="ie ie7" <?php language_attributes(); ?>>
<![endif]-->
<!--[if IE 8]>
<html class="ie ie8" <?php language_attributes(); ?>>
<![endif]-->
<!--[if !(IE 7) | !(IE 8) ]><!-->
<html <?php language_attributes(); ?>>
<!--<![endif]-->
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width">
	<link rel="profile" href="http://gmpg.org/xfn/11">
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
	<?php wp_head(); ?>
</head>
<?php
global $beryl_layout_type, $withcomments, $wp_version;
$withcomments = 1;

$form_class    = '';
$class         = '';
$search_string = '';

if ( version_compare( $wp_version, '4.5', '>=' ) ) {
	$beryl_logo = '';
	if ( get_custom_logo() ) {
		$beryl_logo = get_custom_logo();
	};
	if ( is_customize_preview() ) {
		if ( strstr($beryl_logo, '<img class') !== false ) {
			$beryl_logo = '';
		}
	}
} else {
	$beryl_logo_f = get_custom_header();
	$beryl_logo_f = $beryl_logo->url;
	$beryl_logo = '';
	if ( $beryl_logo_f ) {
		$beryl_logo = '<img src="'.esc_url($beryl_logo_f).'" alt="'.__('Site logo', 'beryl').'">';
	}
}

if (get_search_query() == '') {
	$search_string = __('Search', 'beryl');
} else {
	$search_string = get_search_query();
}

?>
<body <?php body_class(); ?>>
<div id="page" class="hfeed site">
	<div id="main" class="site-main container">
		<div class="post-pagination"><?php echo beryl_get_pagination( $GLOBALS['wp_query']->post_count ); ?></div>
		<div class="site-logo <?php if ( !$beryl_logo ) { echo "text"; } ?>">
			<?php
			if ( $beryl_logo ) {
				echo $beryl_logo;
			} else { ?>
				<span class="blog-name"><?php bloginfo( 'name' ); ?></span>
				<span class="blog-description"><?php bloginfo( 'description' ); ?></span>
			<?php } ?>
		</div>
		<div class="navigation-icon">
			<div id="menu-icon-wrapper2" class="menu-icon-wrapper" style="visibility: hidden">
				<svg width="1000px" height="1000px">
					<path id="pathD" d="M 300 400 L 700 400 C 900 400 900 750 600 850 A 400 400 0 0 1 200 200 L 800 800"></path>
					<path id="pathE" d="M 300 500 L 700 500"></path>
					<path id="pathF" d="M 700 600 L 300 600 C 100 600 100 200 400 150 A 400 380 0 1 1 200 800 L 800 200"></path>
				</svg>
				<button id="menu-icon-trigger2" class="menu-icon-trigger"></button>
			</div><!-- menu-icon-wrapper -->
		</div>
		<div class="main-navigation-container">
			<div class="search-form">
				<?php get_search_form(); ?>
			</div>
			<div id="middle-menu">
				<?php
					wp_nav_menu(
						array(
							'theme_location' => 'middle',
							'menu_class'     => 'nav-menu',
							'depth'          => 1
						)
					);
				?>
			</div>
			<div id="bottom-menu">
				<?php
					wp_nav_menu(
						array(
							'theme_location' => 'bottom',
							'menu_class'     => 'nav-menu clearfix',
							'depth'          => 1
						)
					);
				?>
			</div>
		</div>
		<div class="navigation-background"></div>
		<div class="scroll-down-container">
			<span class="scroll-down"></span>
		</div>
		<div class="main-copyright"><?php _e('Theme by', 'beryl'); ?> <a href="https://cohhe.com" target="_blank">Cohhe</a>.</div>
		<input type="hidden" id="current-page-url" value="">