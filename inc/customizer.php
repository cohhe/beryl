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

function beryl_customizer_style() {
	wp_enqueue_style( 'beryl-customizer-css', get_template_directory_uri() . '/inc/css/customizer.css', array() );
}
add_action( 'customize_controls_print_styles', 'beryl_customizer_style' );