<?php defined('ABSPATH') or die("Nope!");
// Add Shortcode
function fmqs_shortcode( $atts ) {

	// Attributes
	extract( shortcode_atts(
		array(
			'title' => '',
			'template' => '',
			'query' => '',
			'settings' => '',
		), $atts )
	);

	// Code
	$the_query = new WP_Query( $query );
		if ( $the_query->have_posts() ) {
			$display = '<div id="owl-fmqs-'.$title.'" class="owl-carousel" data-settings="'.$settings.'">';
			
			while ( $the_query->have_posts() ) {
				$the_query->the_post();
				ob_start();
    				include(plugin_dir_path( __FILE__ ).'templates/'.$template.'/frame.php');
				$display .= ob_get_clean();
			} // end while ( $the_query->have_posts() )
			$display .= '</div>';
			if (!wp_style_is( $template )) {
       				wp_register_style( $template, plugin_dir_url(__FILE__).'templates/'.$template.'/style.css' );
       				wp_enqueue_style( $template );
     			}
		} // end if ( $the_query->have_posts() )
		wp_reset_query();

	return $display;
}
add_shortcode( 'fm_query_slider', 'fmqs_shortcode' );
?>