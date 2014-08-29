<?php defined('ABSPATH') or die("Nope!");
// Create widget class
class fmqs_widget extends WP_Widget {
	
	function __construct() {
		parent::__construct(
			// Base ID of widget
			'fmqs_widget',
	 		// Widget name will appear in UI
			__('FunkyMonkeys WP_Query Slider', 'fmqs_widget_domain'),
	 		// Widget description
			array( 'description' => __( 'A Free, Queryable, Highly Customizable, Touch Compatible and Responsive Content Slider with Widget', 'fmqs_widget_domain' ), )
		);
    	}
    	
    	// Create widget frontend
	public function widget( $args, $instance ) {
		$title = apply_filters( 'widget_title', $instance['title'] );
		$template = $instance['template'];
		$query = $instance['query'];
		$settings = str_replace("\"","'",$instance['settings']);
		// before and after widget arguments are defined by themes
		echo $args['before_widget'];
		if ( ! empty( $title ) )
			echo $args['before_title'] . $title . $args['after_title'];
		// Frontend display
	 	$the_query = new WP_Query( $query );
		if ( $the_query->have_posts() ) {
			$display = '<div id="owl-'.$this->id.'" class="owl-carousel" data-settings="'.$settings.'">';
			while ( $the_query->have_posts() ) {
				$the_query->the_post();
				ob_start();
    				require(plugin_dir_path( __FILE__ ).'templates/'.$template.'/frame.php');
				$display .= ob_get_clean();
			} // end while ( $the_query->have_posts() )
			$display .= '</div>';
			if (!wp_style_is( $template )) {
				//return;
			//} else {
       				wp_register_style( $template, plugin_dir_url(__FILE__).'templates/'.$template.'/style.css' );
       				wp_enqueue_style( $template );
     			}
		} // end if ( $the_query->have_posts() )
		wp_reset_query();
		// Display
		echo __( $display, 'fmqs_widget_domain' );
		echo $args['after_widget'];
	}
	         
	// Widget Backend
	public function form( $instance ) {
		if ( isset( $instance[ 'title' ] ) ) {
			$title = esc_attr($instance[ 'title' ]);
		} else {
			$title = __( 'New title', 'fmqs_widget_domain' );
		}
		if ( isset( $instance[ 'template' ] ) ) {
			$template = esc_attr($instance[ 'template' ]);
		} else {
			$template = __( 'default', 'fmqs_widget_domain' );
		}
		if ( isset( $instance[ 'query' ] ) ) {
			$query = esc_attr($instance['query']);
		} else {
			$query = "cat=3&orderby=date&sort=DESC";
		}
		if ( isset( $instance[ 'settings' ] ) ) {
			$settings = $instance['settings'];
		} else {
			$settings = "center: true,
loop :true,
margin : 10,
autoplay:true,
responsive:{600:{items:4},1000:{items:1}}";
		}
		// Widget admin form
		?>
		<p>
		<label for="<?php echo $this->get_field_id( 'title' ); ?>"><strong><?php _e( 'Title' ); ?></strong></label>
		<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
		</p>
		<p>
		<label for="<?php echo $this->get_field_id( 'template' ); ?>"><strong><?php _e( 'Template' ); ?></strong></label>
		<select class="widefat" id="<?php echo $this->get_field_id( 'template' ); ?>" name="<?php echo $this->get_field_name( 'template' ); ?>" type='text' value="<?php echo esc_attr( $template ); ?>">
			<?php $directory = plugin_dir_path( __FILE__ ).'/templates';
			$templates =  array_diff(scandir($directory), array('..', '.'));
			foreach ( $templates as $temp ) {
				?><option <?php if ($temp == $template) { echo "selected"; } ?> value='<?php echo $temp ?>'><?php echo $temp ?></option>;
			<?php } ?>
		</select>
		</p>
		<p>
		<label for="<?php echo $this->get_field_id( 'query' ); ?>"><strong><?php _e( 'WP_Query' ); ?></strong></label>
		<input class="widefat" id="<?php echo $this->get_field_id( 'query' ); ?>" name="<?php echo $this->get_field_name( 'query' ); ?>" type="text" value="<?php echo esc_attr( $query ); ?>" />
		</p>
		<p>
		<label for="<?php echo $this->get_field_id( 'settings' ); ?>"><strong><?php _e( 'Carousel Settings' ); ?></strong></label></br>
		<textarea class="widefat" id="<?php echo $this->get_field_id( 'settings' ); ?>" name="<?php echo $this->get_field_name( 'settings' ); ?>" rows="5" style="overflow-y:scroll" value="<?php echo esc_attr( $settings ); ?>"><?php echo esc_attr( $settings ); ?></textarea>
		</p>
		<?php
	}
	     
	// Updating widget replacing old instances with new
	public function update( $new_instance, $old_instance ) {
		$instance = array();
		$instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
		$instance['template'] = ( ! empty( $new_instance['template'] ) ) ? strip_tags( $new_instance['template'] ) : '';
		$instance['query'] = ( ! empty( $new_instance['query'] ) ) ? strip_tags( $new_instance['query'] ) : '';
		$instance['settings'] = ( ! empty( $new_instance['settings'] ) ) ? strip_tags( $new_instance['settings'] ) : '';
		return $instance;
	}
} // Class fmqs_widget ends here
	 
// Register and load the widget
function fmqs_load_widget() {
	register_widget( 'fmqs_widget' );
}
add_action( 'widgets_init', 'fmqs_load_widget' );
?>