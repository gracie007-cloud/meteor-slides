<?php // Add slideshow widget
class meteorslides_widget extends WP_Widget {

	// Setup slideshow widget
	function __construct() {
		parent::__construct(
			'meteor-slides-widget', // Base ID
			__( 'Meteor Slides Widget', 'meteor-slides' ), // Name
			array( 'Add a slideshow widget to a sidebar' => __( 'A Foo Widget', 'meteor-slides' ), ) // Args
		);
	}

	// Load slideshow widget on frontend
	public function widget( $args, $instance ) {
		// WordPress core handles escaping for widget wrapper HTML
		echo wp_kses_post( $args['before_widget'] );
		if ( ! empty( $instance['title'] ) ) {
			// WordPress core handles escaping for widget title HTML, but we should escape the title content
			echo wp_kses_post( $args['before_title'] ) . esc_html( apply_filters( 'widget_title', $instance['title'] ) ) . wp_kses_post( $args['after_title'] );
		}

		// Get options from widget for meteor_slideshow function arguments
		$slideshow_arg = $instance['slideshow'];
		$metadata_arg  = $instance['metadata'];

		// Load slideshow
		meteor_slideshow( $slideshow=$slideshow_arg, $metadata=$metadata_arg );
		// WordPress core handles escaping for widget wrapper HTML
		echo wp_kses_post( $args['after_widget'] );
	}

	// Setup slideshow widget form for the widget admin
	public function form( $instance ) {
	
		// Set blank default values for the widget options
		$defaults = array(
			'title'     => '',
			'slideshow' => '',
			'metadata'  => ''
		);
		$instance = wp_parse_args( (array) $instance, $defaults );
	
		echo '<p><label for="' . esc_attr( $this->get_field_id( 'title' ) ) . '">' . esc_html__('Title:', 'meteor-slides') . '</label>
		<input type="text" class="widefat" id="' . esc_attr( $this->get_field_id( 'title' ) ) . '" name="' . esc_attr( $this->get_field_name( 'title' ) ) . '" value="' . esc_attr( $instance['title'] ) . '" /></p>';
		
		// If the slideshow taxonomy has terms, create a select list of those terms
		$slideshow_terms       = get_terms( 'slideshow' );
		$slideshow_terms_count = count( $slideshow_terms );
		$slideshow_value       = $instance['slideshow'];
		
		if ( $slideshow_terms_count > 0 ) {
			echo '<p><label for="' . esc_attr( $this->get_field_id( 'slideshow' ) ) . '">' . esc_html__('Slideshow:', 'meteor-slides') . '</label>';
			echo '<select name="' . esc_attr( $this->get_field_name( 'slideshow' ) ) . '" id="' . esc_attr( $this->get_field_id( 'slideshow' ) ) . '" class="widefat">';
			echo '<option value="">' . esc_html__( 'All Slides', 'meteor-slides' ) . '</option>';
			
			foreach ( $slideshow_terms as $slideshow_terms ) {
				if ( $slideshow_terms->slug == $slideshow_value ) {
					echo '<option selected="selected" value="' . esc_attr( $slideshow_terms->slug ) . '">' . esc_html( $slideshow_terms->name ) . '</option>';
				} else {
					echo '<option value="' . esc_attr( $slideshow_terms->slug ) . '">' . esc_html( $slideshow_terms->name ) . '</option>';
				}
			}
				
			echo '</select>';	
		}
		echo '<p><label for="' . esc_attr( $this->get_field_id( 'metadata' ) ) . '">' . esc_html__('Metadata:', 'meteor-slides') . '</label>
		<input type="text" class="widefat" id="' . esc_attr( $this->get_field_id( 'metadata' ) ) . '" name="' . esc_attr( $this->get_field_name( 'metadata' ) ) . '" value="' . esc_attr( $instance['metadata'] ) . '" /></p>';
	}

	// Update widget form options when saved
	public function update( $new_instance, $old_instance ) {
		$instance = array();
		$instance['title']     = ( ! empty( $new_instance['title'] ) ) ? wp_strip_all_tags( $new_instance['title'] ) : '';
		$instance['slideshow'] = ( ! empty( $new_instance['slideshow'] ) ) ? wp_strip_all_tags( $new_instance['slideshow'] ) : '';
		$instance['metadata']  = ( ! empty( $new_instance['metadata'] ) ) ? wp_strip_all_tags( $new_instance['metadata'] ) : '';

		return $instance;
	}

}

// Register slideshow widget
function meteorslides_register_widget() {
	register_widget( 'meteorslides_widget' );
}
add_action( 'widgets_init', 'meteorslides_register_widget' );