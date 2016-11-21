<?php
/**
 * Beryl 1.0 functions and definitions
 *
 * Set up the theme and provides some helper functions, which are used in the
 * theme as custom template tags. Others are attached to action and filter
 * hooks in WordPress to change core functionality.
 *
 * When using a child theme you can override certain functions (those wrapped
 * in a function_exists() call) by defining them first in your child theme's
 * functions.php file. The child theme's functions.php file is included before
 * the parent theme's file, so the child theme functions would be used.
 *
 * @link http://codex.wordpress.org/Theme_Development
 * @link http://codex.wordpress.org/Child_Themes
 *
 * Functions that are not pluggable (not wrapped in function_exists()) are
 * instead attached to a filter or action hook.
 *
 * For more information on hooks, actions, and filters,
 * @link http://codex.wordpress.org/Plugin_API
 *
 * @package WordPress
 * @subpackage Beryl
 * @since Beryl 1.0
 */

/**
 * Set up the content width value based on the theme's design.
 *
 * @see beryl_content_width()
 *
 * @since Beryl 1.0
 */
function beryl_set_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'beryl_set_content_width', 800 );
}
add_action( 'after_setup_theme', 'beryl_set_content_width', 0 );

if ( ! function_exists( 'beryl_setup' ) ) :
	/**
	 * Beryl 1.0 setup.
	 *
	 * Set up theme defaults and registers support for various WordPress features.
	 *
	 * Note that this function is hooked into the after_setup_theme hook, which
	 * runs before the init hook. The init hook is too late for some features, such
	 * as indicating support post thumbnails.
	 *
	 * @since Beryl 1.0
	 */
	function beryl_setup() {
		global $wp_version;
		/**
		 * Required: include TGM.
		 */
		require_once( get_template_directory() . '/functions/tgm-activation/class-tgm-plugin-activation.php' );

		/*
		 * Make Beryl 1.0 available for translation.
		 *
		 * Translations can be added to the /languages/ directory.
		 * If you're building a theme based on Beryl 1.0, use a find and
		 * replace to change 'beryl' to the name of your theme in all
		 * template files.
		 */
		load_theme_textdomain( 'beryl' );

		// This theme styles the visual editor to resemble the theme style.
		add_editor_style( array( 'css/editor-style.css' ) );

		// Add RSS feed links to <head> for posts and comments.
		add_theme_support( 'automatic-feed-links' );

		// Enable support for Post Thumbnails, and declare two sizes.
		add_theme_support( 'post-thumbnails' );
		set_post_thumbnail_size( 672, 372, true );
		add_image_size( 'beryl-full-width', 1170 );

		/*
		 * Switch default core markup for search form, comment form, and comments
		 * to output valid HTML5.
		 */
		add_theme_support( 'html5', array(
			'comment-list',
		) );

		// This theme uses wp_nav_menu() in two locations.
		register_nav_menus( array(
			'middle'   => __( 'Middle menu', 'beryl' ),
			'bottom'    => __( 'Bottom menu', 'beryl' ),
		) );

		// This theme uses its own gallery styles.
		add_filter( 'use_default_gallery_style', '__return_false' );

		add_theme_support( 'title-tag' );

		if ( version_compare( $wp_version, '4.5', '>=' ) ) {
			add_theme_support( 'custom-logo', array( 'height' => 60, 'width' => 240, 'flex-width' => true ) );
		} else {
			add_theme_support( 'custom-header' );
		}

		$custom_background_arg = array(
			'default-color' => 'ffffff'
		);
		add_theme_support( "custom-background", $custom_background_arg );
		
	}
endif; // beryl_setup
add_action( 'after_setup_theme', 'beryl_setup' );

function beryl_admin_scripts( $hook ) {
	if ( $hook != 'themes.php' && $hook != 'post-new.php' ) {
		return;
	}
	// Admin Javascript
	wp_enqueue_script('beryl-master', get_template_directory_uri() . '/inc/js/admin-master.js', array('jquery') );

	// Admin CSS
	wp_enqueue_style( 'beryl-admin-css', get_template_directory_uri() . '/css/wp-admin.css' );
}
add_action( 'admin_enqueue_scripts', 'beryl_admin_scripts' );

function beryl_tag_list( $post_id, $return = false ) {
	$entry_utility = '';
	$posttags = get_the_tags( $post_id );
	if ( $posttags ) {
		$entry_utility .= '
		<div class="tag-link">
			<span class="icon-tags"></span>';
				foreach( $posttags as $tag ) {
					$entry_utility .= '<a href="' . esc_url(get_tag_link($tag->term_id)) . '" class="open-tag">' . $tag->name . '</a>, '; 
				}
				$entry_utility = rtrim($entry_utility, ', ');
			$entry_utility .= '
		</div>';
	}

	if ( $return ) {
		return $entry_utility;
	} else {
		echo $entry_utility;
	}
}

add_action( 'wp_head', 'beryl_override_toolbar_margin', 11 );
function beryl_override_toolbar_margin() { ?>
		<style type="text/css" media="screen">
			html { margin-top: 0 !important; }
			* html body { margin-top: 0 !important; }
		</style>
	<?php
}

function beryl_get_pagination( $post_count ) {
	$pagination = '';
	for ($i=0; $i < $post_count; $i++) {
		$extra = '';
		if ( $i == 0 ) {
			$extra = ' active';
		}
		$pagination .= '<a href="javascript:void(0)" class="post-pagination-item' . $extra . '"></a>';
	}

	return $pagination;
}

function beryl_category_list( $post_id, $return = false ) {
	$category_list = get_the_category_list( ', ', '', $post_id );
	$entry_utility = '';
	if ( $category_list ) {
		$entry_utility .= '
		<div class="category-link">
			<span class="entypo_icon icon-folder-open"></span>' . $category_list . '
		</div>';
	}

	if ( $return ) {
		return $entry_utility;
	} else {
		echo $entry_utility;
	}
}

function beryl_comment_count( $post_id ) {
	$comments = wp_count_comments($post_id); 
	return $comments->approved;
}

/**
 * Register one Beryl 1.0 widget area.
 *
 * @since Beryl 1.0
 *
 * @return void
 */
function beryl_widgets_init() {
	register_sidebar( array(
		'name'          => __( 'Footer Widget Area', 'beryl' ),
		'id'            => 'sidebar-1',
		'description'   => __( 'Appears in the post footer section of the site.', 'beryl' ),
		'before_widget' => '<aside id="widget-%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
	) );
}
add_action( 'widgets_init', 'beryl_widgets_init' );

/**
 * Adjust content_width value for image attachment template.
 *
 * @since Beryl 1.0
 *
 * @return void
 */
function beryl_content_width() {
	if ( is_attachment() && wp_attachment_is_image() ) {
		$GLOBALS['content_width'] = 810;
	}
}
add_action( 'template_redirect', 'beryl_content_width' );

/**
 * Register Lato Google font for Beryl 1.0.
 *
 * @since Beryl 1.0
 *
 * @return string
 */
function beryl_font_url() {
	$font_url = '';
	/*
	 * Translators: If there are characters in your language that are not supported
	 * by Lato, translate this to 'off'. Do not translate into your own language.
	 */
	$font_url = add_query_arg( 'family', urlencode( 'Lato:100,300,400' ), "//fonts.googleapis.com/css" );

	return $font_url;
}

function beryl_excerpt_length( $length ) {
	return 15;
}
add_filter( 'excerpt_length', 'beryl_excerpt_length', 999 );

function beryl_excerpt_more( $more ) {
	return '..';
}
add_filter('excerpt_more', 'beryl_excerpt_more');

/**
 * Enqueue scripts and styles for the front end.
 *
 * @since Beryl 1.0
 *
 * @return void
 */
function beryl_scripts() {

	wp_enqueue_style( 'bootstrap', get_template_directory_uri() . '/css/bootstrap.css', array() );

	// Add Google fonts
	wp_register_style('beryl-googleFonts', '//fonts.googleapis.com/css?family=Lato:100,300,400,500,600,700&subset=latin');
	wp_enqueue_style( 'beryl-googleFonts');

	// Add Genericons font, used in the main stylesheet.
	wp_enqueue_style( 'genericons', get_template_directory_uri() . '/fonts/genericons/genericons.css', array(), '3.0.2' );

	// Load our main stylesheet.
	wp_enqueue_style( 'beryl-style', get_stylesheet_uri(), array( 'genericons' ) );

	wp_enqueue_script( 'comment-reply' );

	wp_enqueue_script( 'segment', get_template_directory_uri() . '/js/segment.min.js', array() );
	wp_enqueue_script( 'ease', get_template_directory_uri() . '/js/ease.min.js', array() );

	wp_enqueue_script( 'beryl-script', get_template_directory_uri() . '/js/functions.js', array( 'jquery' ), '20131209', true );
	wp_enqueue_script( 'bootstrap', get_template_directory_uri() . '/js/bootstrap.js', array( 'jquery' ), '20131209', true );

	wp_enqueue_style( 'animate', get_template_directory_uri() . '/css/animate.min.css', array() );

	wp_enqueue_script( 'jquery-ba-hashchange', get_template_directory_uri() . '/js/jquery.ba-hashchange.js', array( 'jquery' ), '', true );

	wp_enqueue_script( 'jquery-ui-draggable' );

	wp_localize_script(
		'beryl-script',
		'beryl_loc',
			array(
				'home_url' => esc_url(home_url())
			)
	);

	wp_add_inline_style( 'beryl-style', '.post-inner-title { background-image: url('.get_template_directory_uri().'/images/post-bg.png) !important; }' );

	// Add html5
	wp_enqueue_script( 'html5shiv', get_template_directory_uri() . '/js/html5.js' );
	wp_script_add_data( 'html5shiv', 'conditional', 'lt IE 9' );
}
add_action( 'wp_enqueue_scripts', 'beryl_scripts' );

if ( ! function_exists( 'beryl_the_attached_image' ) ) :
	/**
	 * Print the attached image with a link to the next attached image.
	 *
	 * @since Beryl 1.0
	 *
	 * @return void
	 */
	function beryl_the_attached_image() {
		$post                = get_post();
		/**
		 * Filter the default Beryl 1.0 attachment size.
		 *
		 * @since Beryl 1.0
		 *
		 * @param array $dimensions {
		 *     An array of height and width dimensions.
		 *
		 *     @type int $height Height of the image in pixels. Default 810.
		 *     @type int $width  Width of the image in pixels. Default 810.
		 * }
		 */
		$attachment_size     = apply_filters( 'beryl_attachment_size', array( 810, 810 ) );
		$next_attachment_url = wp_get_attachment_url();

		/*
		 * Grab the IDs of all the image attachments in a gallery so we can get the URL
		 * of the next adjacent image in a gallery, or the first image (if we're
		 * looking at the last image in a gallery), or, in a gallery of one, just the
		 * link to that image file.
		 */
		$attachment_ids = get_posts( array(
			'post_parent'    => $post->post_parent,
			'fields'         => 'ids',
			'numberposts'    => -1,
			'post_status'    => 'inherit',
			'post_type'      => 'attachment',
			'post_mime_type' => 'image',
			'order'          => 'ASC',
			'orderby'        => 'menu_order ID',
		) );

		// If there is more than 1 attachment in a gallery...
		if ( count( $attachment_ids ) > 1 ) {
			foreach ( $attachment_ids as $attachment_id ) {
				if ( $attachment_id == $post->ID ) {
					$next_id = current( $attachment_ids );
					break;
				}
			}

			// get the URL of the next image attachment...
			if ( $next_id ) {
				$next_attachment_url = get_attachment_link( $next_id );
			}

			// or get the URL of the first image attachment.
			else {
				$next_attachment_url = get_attachment_link( array_shift( $attachment_ids ) );
			}
		}

		printf( '<a href="%1$s" rel="attachment">%2$s</a>',
			esc_url( $next_attachment_url ),
			wp_get_attachment_image( $post->ID, $attachment_size )
		);
	}
endif;

/**
 * Extend the default WordPress body classes.
 *
 * Adds body classes to denote:
 * 1. Single or multiple authors.
 * 2. Presence of header image.
 * 3. Index views.
 * 5. Presence of footer widgets.
 * 6. Single views.
 * 7. Featured content layout.
 *
 * @since Beryl 1.0
 *
 * @param array $classes A list of existing body class values.
 * @return array The filtered body class list.
 */
function beryl_body_classes( $classes ) {
	global $post;
	$beryl_layout = '';

	if ( is_single() || is_page() ) {
		$classes[] = 'post-shown pull-page-content';
	}

	return $classes;
}
add_filter( 'body_class', 'beryl_body_classes' );

// Custom template tags for this theme.
require get_template_directory() . '/inc/template-tags.php';

// Add Theme Customizer functionality.
require get_template_directory() . '/inc/customizer.php';

/**
 * Register the required plugins for this theme.
 *
 * In this example, we register two plugins - one included with the TGMPA library
 * and one from the .org repo.
 *
 * The variable passed to tgmpa_register_plugins() should be an array of plugin
 * arrays.
 *
 * This function is hooked into tgmpa_init, which is fired within the
 * TGM_Plugin_Activation class constructor.
 */
function beryl_register_required_plugins() {

	/**
	 * Array of plugin arrays. Required keys are name and slug.
	 * If the source is NOT from the .org repo, then source is also required.
	 */
	$plugins = array(
		array(
			'name'     				=> __('Bootstrap 3 Shortcodes','beryl'), // The plugin name
			'slug'     				=> 'bootstrap-3-shortcodes', // The plugin slug (typically the folder name)
			'required' 				=> false, // If false, the plugin is only 'recommended' instead of required
			'version' 				=> '3.3.6', // E.g. 1.0.0. If set, the active plugin must be this version or higher, otherwise a notice is presented
			'force_activation' 		=> false, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch
			'force_deactivation' 	=> false, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins
			'external_url' 			=> '', // If set, overrides default API URL and points to an external URL
		)
	);

	/**
	 * Array of configuration settings. Amend each line as needed.
	 * If you want the default strings to be available under your own theme domain,
	 * leave the strings uncommented.
	 * Some of the strings are added into a sprintf, so see the comments at the
	 * end of each line for what each argument will be.
	 */
	$config = array(
		'domain'       		=> 'beryl',         	// Text domain - likely want to be the same as your theme.
		'default_path' 		=> '',                         	// Default absolute path to pre-packaged plugins
		'parent_slug' 	    => 'themes.php', 				// Default parent slug
		'menu'         		=> 'install-required-plugins', 	// Menu slug
		'has_notices'      	=> true,                       	// Show admin notices or not
		'is_automatic'    	=> true,					   	// Automatically activate plugins after installation or not
		'message' 			=> '',							// Message to output right before the plugins table
		'strings'      		=> array(
			'page_title'                       			=> __( 'Install Required Plugins', 'beryl' ),
			'menu_title'                       			=> __( 'Install Plugins', 'beryl' ),
			'installing'                       			=> __( 'Installing Plugin: %s', 'beryl' ), // %1$s = plugin name
			'oops'                             			=> __( 'Something went wrong with the plugin API.', 'beryl' ),
			'notice_can_install_required'     			=> _n_noop( 'This theme requires the following plugin: %1$s.', 'This theme requires the following plugins: %1$s.', 'beryl' ), // %1$s = plugin name(s)
			'notice_can_install_recommended'			=> _n_noop( 'This theme recommends the following plugin: %1$s.', 'This theme recommends the following plugins: %1$s.', 'beryl' ), // %1$s = plugin name(s)
			'notice_cannot_install'  					=> _n_noop( 'Sorry, but you do not have the correct permissions to install the %s plugin. Contact the administrator of this site for help on getting the plugin installed.', 'Sorry, but you do not have the correct permissions to install the %s plugins. Contact the administrator of this site for help on getting the plugins installed.', 'beryl' ), // %1$s = plugin name(s)
			'notice_can_activate_required'    			=> _n_noop( 'The following required plugin is currently inactive: %1$s.', 'The following required plugins are currently inactive: %1$s.', 'beryl' ), // %1$s = plugin name(s)
			'notice_can_activate_recommended'			=> _n_noop( 'The following recommended plugin is currently inactive: %1$s.', 'The following recommended plugins are currently inactive: %1$s.', 'beryl' ), // %1$s = plugin name(s)
			'notice_cannot_activate' 					=> _n_noop( 'Sorry, but you do not have the correct permissions to activate the %s plugin. Contact the administrator of this site for help on getting the plugin activated.', 'Sorry, but you do not have the correct permissions to activate the %s plugins. Contact the administrator of this site for help on getting the plugins activated.', 'beryl' ), // %1$s = plugin name(s)
			'notice_ask_to_update' 						=> _n_noop( 'The following plugin needs to be updated to its latest version to ensure maximum compatibility with this theme: %1$s.', 'The following plugins need to be updated to their latest version to ensure maximum compatibility with this theme: %1$s.', 'beryl' ), // %1$s = plugin name(s)
			'notice_cannot_update' 						=> _n_noop( 'Sorry, but you do not have the correct permissions to update the %s plugin. Contact the administrator of this site for help on getting the plugin updated.', 'Sorry, but you do not have the correct permissions to update the %s plugins. Contact the administrator of this site for help on getting the plugins updated.', 'beryl' ), // %1$s = plugin name(s)
			'install_link' 					  			=> _n_noop( 'Begin installing plugin', 'Begin installing plugins', 'beryl' ),
			'activate_link' 				  			=> _n_noop( 'Activate installed plugin', 'Activate installed plugins', 'beryl' ),
			'return'                           			=> __( 'Return to Required Plugins Installer', 'beryl' ),
			'plugin_activated'                 			=> __( 'Plugin activated successfully.', 'beryl' ),
			'complete' 									=> __( 'All plugins installed and activated successfully. %s', 'beryl' ), // %1$s = dashboard link
			'nag_type'									=> 'updated' // Determines admin notice type - can only be 'updated' or 'error'
		)
	);

	tgmpa( $plugins, $config );
}
add_action( 'tgmpa_register', 'beryl_register_required_plugins' );

function beryl_admin_rating_notice() {
	$current_screen = get_current_screen();
	$user = wp_get_current_user();

	if ( $current_screen->parent_base != 'themes' ) {
		return;
	}
	if ( get_option('beryl_rating_notice') && get_option('beryl_rating_notice') != 'hide' && time() - get_option('beryl_rating_notice') > 432000 ) { ?>
		<div class="beryl-rating-notice">
			<span class="beryl-notice-left">
				<img src="<?php echo get_template_directory_uri(); ?>/images/logo-square.png" alt="">
			</span>
			<div class="beryl-notice-center">
				<p><?php printf( __( 'Hi there, %s, we noticed that you\'ve been using Beryl for a while now.', 'beryl' ), $user->data->display_name ); ?></p>
				<p><?php _e('We spent many hours developing this free theme for you and we would appriciate if you supported us by rating it!', 'beryl'); ?></p>
			</div>
			<div class="beryl-notice-right">
				<a href="https://wordpress.org/support/view/theme-reviews/beryl?rate=5#postform" class="button button-primary button-large beryl-rating-rate"><?php _e('Rate at WordPress', 'beryl'); ?></a>
				<a href="javascript:void(0)" class="button button-large preview beryl-rating-dismiss"><?php _e('No, thanks', 'beryl'); ?></a>
			</div>
			<div class="clearfix"></div>
		</div>
	<?php
	}
}
add_action( 'admin_notices', 'beryl_admin_rating_notice' );


function beryl_dismiss_rating_notice() {
	update_option('beryl_rating_notice', 'hide');

	die(0);
}
add_action( 'wp_ajax_beryl_dismiss_notice', 'beryl_dismiss_rating_notice' );

function beryl_theme_activated() {
	if ( !get_option('beryl_rating_notice') ) {
		update_option('beryl_rating_notice', time());
	}
}
add_action('after_switch_theme', 'beryl_theme_activated');