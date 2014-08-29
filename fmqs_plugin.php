<?php defined('ABSPATH') or die("Nope!");
/**
 * Plugin Name: Funky-Monkeys WP_Query Slider
 * Plugin URI: http://funky-monkeys.org/wordpress/plugins/content_slider
 * Description: A Free, Highly Customizable, Touch Compatible and Responsive Content Slider with Widget.
 * Version: 0.1
 * Author: Funkey-Monkeys
 * Author URI: http://funky-monkeys.org
 * License: GPL2
 **/
 
// Que required scripts
function que_fmqs_scripts() {
	wp_enqueue_style( 'fmqs-owl',  plugin_dir_url( __FILE__ ).'owl/owl.carousel.css', 'null', '2.4' );
	wp_enqueue_script( 'fmqs-owl',  plugin_dir_url( __FILE__ ).'owl/owl.carousel.min.js', 'null', '2.4', true );
	//wp_enqueue_script( 'fmqs',  plugin_dir_url( __FILE__ ).'dev/fmqs_initiate.js', 'fmqs-owl-js', '0.1', true );
}
add_action( 'wp_enqueue_scripts', 'que_fmqs_scripts' );

// Include Widget
include plugin_dir_path( __FILE__ ).'fmqs_widget.php';
// Include Shortcode
include plugin_dir_path( __FILE__ ).'fmqs_shortcode.php';
?>