<?php
/**
 * Functions that make Gutenberg easier to use
 *
 * @package bring-your-own-blocks
 */

/**
 * Only allow certain blocks to be used.
 *
 * @param array $allowed_blocks Blocks to allow.
 */
function bring_your_own_blocks_allowed_block_types( $allowed_blocks ) {
	return array(
		'core/freeform',
	);
}
add_filter( 'allowed_block_types', 'bring_your_own_blocks_allowed_block_types' );

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
