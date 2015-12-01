<?php
/**
 * _s Theme Customizer
 *
 * @package _s
 */

/**
 * Add postMessage support for site title and description for the Theme Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function _s_customize_register( $wp_customize ) {
	$wp_customize->get_setting( 'blogname' )->transport         = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport  = 'postMessage';
	$wp_customize->get_setting( 'header_textcolor' )->transport = 'postMessage';

    /**
     * add a section to the customizer
     
     */
    // $wp_customize->add_section( '_s_hero_text_section' , array(
    //     'title'      => __( 'Homepage hero text', 'mytheme' ),
    //     'priority'   => 60,
    // ) );

    // $wp_customize->add_setting( '_s_hero_text', array(
    //     'default' => 'Default copyright text',
    // ));

    // $wp_customize->add_control('_s_hero_text', array(
    //     'label' => 'Copyright text',
    //     'section' => '_s_hero_text_section',
    //     'type' => 'text',
    // ));


    /**
     * add a section for the logo to the customizer
     */
    $wp_customize->add_section( '_s_branding' , array(
        'title'    => __( '_s Branding', '_s' ),
        'priority' => 60,
    ) );

    // @usage get_theme_mod('_s_logo')
    $wp_customize->add_setting('_s_logo', array(
        'default'   => '',
        'transport' => 'postMessage'
    ));

    $wp_customize->add_control(
        new WP_Customize_Image_Control(
            $wp_customize,
            '_s_logo',
            array(
                'label'      => __( 'Upload a logo', '_s' ),
                'section'    => '_s_branding',
                'settings'   => '_s_logo',
            )
        )
    );


    /**
     * section for footer text
     */
    $wp_customize->add_section( '_s_copyright' , array(
        'title'    => __( 'Footer Copyright', '_s' ),
        'priority' => 60,
    ) );

    // @usage get_theme_mod('_s_copyright_text')
    $wp_customize->add_setting('_s_copyright_text', array(
        'default'   => '',
        'transport' => 'postMessage'
    ));

    $wp_customize->add_control('_s_copyright_text', array(
        'label'   => __('Footer copyright text', '_s'),
        'type'    => 'text',
        'section' => '_s_copyright',
    ));
}
add_action( 'customize_register', '_s_customize_register' );

/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 */
function _s_customize_preview_js() {
	wp_enqueue_script( '_s_customizer', get_template_directory_uri() . '/js/customizer.js', array( 'customize-preview' ), false, true );
}
add_action( 'customize_preview_init', '_s_customize_preview_js' );
