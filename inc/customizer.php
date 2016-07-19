<?php
/**
 * Beryl 1.0 Theme Customizer support
 *
 * @package WordPress
 * @subpackage Beryl
 * @since Beryl 1.0
 */

/**
 * Implement Theme Customizer additions and adjustments.
 *
 * @since Beryl 1.0
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function beryl_customize_register( $wp_customize ) {
	// Add custom description to Colors and Background sections.
	$wp_customize->get_section( 'colors' )->description           = __( 'Background may only be visible on wide screens.', 'beryl' );
	$wp_customize->get_section( 'background_image' )->description = __( 'Background may only be visible on wide screens.', 'beryl' );

	// Add postMessage support for site title and description.
	$wp_customize->get_setting( 'blogname' )->transport         = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport  = 'postMessage';
	$wp_customize->get_setting( 'header_textcolor' )->transport = 'postMessage';

	// Rename the label to "Site Title Color" because this only affects the site title in this theme.
	$wp_customize->get_control( 'header_textcolor' )->label = __( 'Site Title Color', 'beryl' );

	// Rename the label to "Display Site Title & Tagline" in order to make this option extra clear.
	$wp_customize->get_control( 'display_header_text' )->label = __( 'Display Site Title &amp; Tagline', 'beryl' );

	$wp_customize->get_section( 'header_image' )->title = __( 'Logo', 'beryl' );

	// Social links
	$wp_customize->add_section( new beryl_Customized_Section( $wp_customize, 'beryl_social_links', array(
		'priority'       => 300,
		'capability'     => 'edit_theme_options'
		) )
	);

	$wp_customize->add_setting( 'beryl_fake_field', array( 'sanitize_callback' => 'sanitize_text_field' ) );

	$wp_customize->add_control(
		'beryl_fake_field',
		array(
			'label'      => '',
			'section'    => 'beryl_social_links',
			'type'       => 'text'
		)
	);
}
add_action( 'customize_register', 'beryl_customize_register' );

if ( class_exists( 'WP_Customize_Section' ) && !class_exists( 'beryl_Customized_Section' ) ) {
	class beryl_Customized_Section extends WP_Customize_Section {
		public function render() {
			$classes = 'accordion-section control-section control-section-' . $this->type;
			?>
			<li id="accordion-section-<?php echo esc_attr( $this->id ); ?>" class="<?php echo esc_attr( $classes ); ?>">
				<style type="text/css">
					.cohhe-social-profiles {
						padding: 14px;
					}
					.cohhe-social-profiles li:last-child {
						display: none !important;
					}
					.cohhe-social-profiles li i {
						width: 20px;
						height: 20px;
						display: inline-block;
						background-size: cover !important;
						margin-right: 5px;
						float: left;
					}
					.cohhe-social-profiles li a {
						height: 20px;
						line-height: 20px;
					}
					#customize-theme-controls>ul>#accordion-section-beryl_social_links {
						margin-top: 10px;
					}
					.cohhe-social-profiles li.documentation {
						text-align: right;
						margin-bottom: 60px;
					}
				</style>
				<ul class="cohhe-social-profiles">
					<li class="documentation"><a href="http://documentation.cohhe.com/beryl" class="button button-primary button-hero" target="_blank"><?php _e( 'Documentation', 'beryl' ); ?></a></li>
				</ul>
			</li>
			<?php
		}
	}
}

function beryl_sanitize_checkbox( $input ) {
	// Boolean check 
	return ( ( isset( $input ) && true == $input ) ? true : false );
}

function beryl_sanitize_textarea( $text ) {
	return wp_kses_post( $text );
}

/**
 * Sanitize the Featured Content layout value.
 *
 * @since Beryl 1.0
 *
 * @param string $layout Layout type.
 * @return string Filtered layout type (grid|slider).
 */
function beryl_sanitize_layout( $layout ) {
	if ( ! in_array( $layout, array( 'slider' ) ) ) {
		$layout = 'slider';
	}

	return $layout;
}

/**
 * Bind JS handlers to make Theme Customizer preview reload changes asynchronously.
 *
 * @since Beryl 1.0
 */
function beryl_customize_preview_js() {
	wp_enqueue_script( 'beryl_customizer', get_template_directory_uri() . '/js/customizer.js', array( 'customize-preview' ), '20131205', true );
}
add_action( 'customize_preview_init', 'beryl_customize_preview_js' );

/**
 * Add contextual help to the Themes and Post edit screens.
 *
 * @since Beryl 1.0
 *
 * @return void
 */
function beryl_contextual_help() {
	if ( 'admin_head-edit.php' === current_filter() && 'post' !== $GLOBALS['typenow'] ) {
		return;
	}

	get_current_screen()->add_help_tab( array(
		'id'      => 'beryl',
		'title'   => __( 'Beryl 1.0', 'beryl' ),
		'content' =>
			'<ul>' .
				'<li>' . sprintf( __( 'The home page features your choice of up to 6 posts prominently displayed in a grid or slider, controlled by the <a href="%1$s">featured</a> tag; you can change the tag and layout in <a href="%2$s">Appearance &rarr; Customize</a>. If no posts match the tag, <a href="%3$s">sticky posts</a> will be displayed instead.', 'beryl' ), admin_url( '/edit.php?tag=featured' ), admin_url( 'customize.php' ), admin_url( '/edit.php?show_sticky=1' ) ) . '</li>' .
				'<li>' . sprintf( __( 'Enhance your site design by using <a href="%s">Featured Images</a> for posts you&rsquo;d like to stand out (also known as post thumbnails). This allows you to associate an image with your post without inserting it. Beryl 1.0 uses featured images for posts and pages&mdash;above the title&mdash;and in the Featured Content area on the home page.', 'beryl' ), 'http://codex.wordpress.org/Post_Thumbnails#Setting_a_Post_Thumbnail' ) . '</li>' .
				'<li>' . sprintf( __( 'For an in-depth tutorial, and more tips and tricks, visit the <a href="%s">Beryl 1.0 documentation</a>.', 'beryl' ), 'http://codex.wordpress.org/Beryl' ) . '</li>' .
			'</ul>',
	) );
}
add_action( 'admin_head-themes.php', 'beryl_contextual_help' );
add_action( 'admin_head-edit.php',   'beryl_contextual_help' );
