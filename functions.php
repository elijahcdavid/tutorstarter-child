<?php
/**
 * TutorStarter Child Theme Functions
 *
 * @package TutorStarter_Child
 */

defined( 'ABSPATH' ) || exit;

/**
 * Enqueue parent and child theme styles
 */
function tutorstarter_child_enqueue_styles() {
    // Enqueue parent theme stylesheet
    wp_enqueue_style( 'tutorstarter-style', 
        get_template_directory_uri() . '/style.css',
        array(),
        wp_get_theme( get_template() )->get( 'Version' )
    );
    
    // Enqueue child theme stylesheet
    wp_enqueue_style( 'tutorstarter-child-style',
        get_stylesheet_directory_uri() . '/style.css',
        array( 'tutorstarter-style' ),
        wp_get_theme()->get( 'Version' )
    );
}
add_action( 'wp_enqueue_scripts', 'tutorstarter_child_enqueue_styles' );

/**
 * Add your custom functions below
 */

/**
 * Load child theme traits and components
 */
function tutorstarter_child_load_components() {
    // Load the Header_Components trait from child theme
    if ( file_exists( get_stylesheet_directory() . '/inc/Traits/Header_Components.php' ) ) {
        require_once get_stylesheet_directory() . '/inc/Traits/Header_Components.php';
    }
}
add_action( 'after_setup_theme', 'tutorstarter_child_load_components' );
