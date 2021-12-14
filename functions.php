<?php
/**
 * Functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package bring-your-own-blocks
 */

if ( ! function_exists( 'bring_your_own_blocks_setup' ) ) :
	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 *
	 * Note that this function is hooked into the after_setup_theme hook, which
	 * runs before the init hook. The init hook is too late for some features, such
	 * as indicating support for post thumbnails.
	 */
	function bring_your_own_blocks_setup() {

		/*
		 * Enable support for Post Thumbnails on posts and pages.
		 *
		 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
		 */
		add_theme_support( 'post-thumbnails' );

		// This theme uses wp_nav_menu() in one location.
		register_nav_menus(
			array(
				'menu-1' => esc_html__( 'Primary', 'bring-your-own-blocks' ),
			)
		);
	}
endif;
add_action( 'after_setup_theme', 'bring_your_own_blocks_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 */
function bring_your_own_blocks_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'bring_your_own_blocks_content_width', 640 );
}
add_action( 'after_setup_theme', 'bring_your_own_blocks_content_width', 0 );

/**
 * Remove customizer options.
 */
function ja_remove_customizer_options( $wp_customize ) {
	$wp_customize->remove_section( 'static_front_page' );
	$wp_customize->remove_section( 'title_tagline' );
	$wp_customize->remove_section( 'nav' );
	$wp_customize->remove_section( 'themes' );
	$wp_customize->remove_section( 'custom_css' );
}
add_action( 'customize_register', 'ja_remove_customizer_options', 30 );

/**
 * Register Google Fonts
 */
function bring_your_own_blocks_fonts_url() {
	$fonts_url = '';

	/*
	 *Translators: If there are characters in your language that are not
	 * supported by Noto Serif, translate this to 'off'. Do not translate
	 * into your own language.
	 */
	$notoserif = esc_html_x( 'on', 'Noto Serif font: on or off', 'bring-your-own-blocks' );

	if ( 'off' !== $notoserif ) {
		$font_families   = array();
		$font_families[] = 'Noto Serif:400,400italic,700,700italic';

		$query_args = array(
			'family' => urlencode( implode( '|', $font_families ) ),
			'subset' => urlencode( 'latin,latin-ext' ),
		);

		$fonts_url = add_query_arg( $query_args, 'https://fonts.googleapis.com/css' );
	}

	return $fonts_url;

}

/**
 * Enqueue scripts and styles.
 */
function bring_your_own_blocks_scripts() {
	wp_enqueue_style( 'gutenbergbase-style', get_stylesheet_uri() );

	wp_enqueue_style( 'bring-your-own-blocksblocks-style', get_template_directory_uri() . '/blocks.css' );

	wp_enqueue_style( 'bring-your-own-blocks-fonts', bring_your_own_blocks_fonts_url() );
}
add_action( 'wp_enqueue_scripts', 'bring_your_own_blocks_scripts' );

/**
 * Disable Gutenberg's default fullscreen mode.
 */
function bring_your_own_blocks_disable_editor_fullscreen_mode() {
	$script = "window.onload = function() { const isFullscreenMode = wp.data.select( 'core/edit-post' ).isFeatureActive( 'fullscreenMode' ); if ( isFullscreenMode ) { wp.data.dispatch( 'core/edit-post' ).toggleFeature( 'fullscreenMode' ); } }";
	wp_add_inline_script( 'wp-blocks', $script );
}
add_action( 'enqueue_block_editor_assets', 'bring_your_own_blocks_disable_editor_fullscreen_mode' );

/**
 * Enable custom editor styles.
 */
function bring_your_own_blocks_enable_editor_styles() {
	// Add support for editor styles.
	add_theme_support( 'editor-styles' );
	add_editor_style( 'style-editor.css' );
}
add_action( 'after_setup_theme', 'bring_your_own_blocks_enable_editor_styles' );
