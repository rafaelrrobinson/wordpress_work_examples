<?php
/**
* Plugin Name: Featured Video
* Plugin URI:
* Description: This creates a video shortcode to be inserted into articles.
* Version: 1.0
* Author: Rafael Robinson
* Author URI: https://www.rafaelrobinson.com/
*/


// Adds a hook for a shortcode tag
function video_shortcodes_init(){
	add_shortcode( 'video_video', 'video_videos' );
}
add_action('init', 'video_shortcodes_init');


// Register a shortcode
function video_videos( $atts ){
	$atts = array_change_key_case( (array)$atts, CASE_LOWER );
	extract( shortcode_atts(
		array(
			'service'		=> '',
			'videoid'		=> ''
		),
			$atts,
			'video_video'
	));

	if( $service == 'youtube' ){
		$output = '<div class="videoWrapper">
      <iframe width="560" height="315" src="https://www.youtube.com/embed/'.esc_attr($videoid).'" frameborder="0" allow="autoplay; encrypted-media" allowfullscreen></iframe>
		</div>';
	};
	if( $service == 'vimeo' ){
		$output = '<div class="videoWrapper">
      <iframe src="https://player.vimeo.com/video/'.esc_attr($videoid).'" width="640" height="384" frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>
		</div>';
	};

	return $output;
}


// Enqueue scripts and styles
function video_enqueue_scripts() {
	global $post;

  if( is_a( $post, 'WP_Post' ) ) {
		wp_register_style( 'stylesheet',  plugin_dir_url( __FILE__ ) . 'css/style.css' );
		wp_enqueue_style( 'stylesheet' );
	}
}
add_action( 'wp_enqueue_scripts', 'video_enqueue_scripts');


// Register TinyMCE buttons
function video_register_mce_buttons( $buttons ) {
	$buttons[] = 'video';
	return $buttons;
}


// Add new buttons
function video_register_mce_plugin( $plugin_array ) {
  $plugin_array['video'] = plugins_url( '/mce/video/plugin.js', __FILE__ );
  return $plugin_array;
}
add_filter( 'mce_buttons', 'video_register_mce_buttons' );


// Load the TinyMCE plugin
add_filter( 'mce_external_plugins', 'video_register_mce_plugin' );
