<?php 
/**
 * new WordPress Widget format
 * Wordpress 2.8 and above
 * @see http://codex.wordpress.org/Widgets_API#Developing_Widgets
 */
class Parallel_Our_Clients_Widget extends WP_Widget {

    /**
     * Constructor
     *
     * @return void
     **/
    function __construct() {
        $widget_ops = array( 'classname' => 'wcp_image', 'description' => __('Add a client logo to the homepage clients section.', 'parallel') );
        parent::__construct( 'Parallel_our_clients', __('Parallel - Clients Widget', 'parallel'), $widget_ops );
        
        //setup default widget data
		$this->defaults = array(
			'image_url'    => '',
            'image_link'    => '',
		);
    }

    /**
     * Outputs the HTML for this widget.
     *
     * @param array  An array of standard parameters for widgets in this theme
     * @param array  An array of settings for this widget instance
     * @return void Echoes it's output
     **/
    function widget( $args, $instance ) {
        extract( $args, EXTR_SKIP );
        // these are the widget options
        $image_url = $instance['image_url'];
        $image_link = $instance['image_link'];
        echo $before_widget;
        // Display the widget
        if ( isset( $image_link ) ) {
          echo '<a href="'.$image_link.'" target="_blank">';
        }
        if( isset( $image_url ) ) {
          echo '<img src="'.$image_url.'" class="img-responsive center-block">';
        }
        if ( isset( $image_link ) ) {
          echo '</a>';
        }
        echo $after_widget;
    }

    /**
     * Deals with the settings when they are saved by the admin. Here is
     * where any validation should be dealt with.
     *
     * @param array  An array of new settings as submitted by the admin
     * @param array  An array of the previous settings
     * @return array The validated and (if necessary) amended settings
     **/
    function update( $new_instance, $old_instance ) {

        // update logic goes here
    	$instance = $old_instance;
        // Fields
        $instance['image_url'] = esc_url($new_instance['image_url']);
        $instance['image_link'] = esc_url($new_instance['image_link']);
        return $instance;
    }

    /**
     * Displays the form for this widget on the Widgets page of the WP Admin area.
     *
     * @param array  An array of the current settings for this widget
     * @return void Echoes it's output
     **/
    function form( $instance ) {
        extract($instance);

?>
    <p>
        <label for="<?php echo $this->get_field_id('image_url'); ?>"><?php esc_html_e('Client Logo', 'parallel'); ?></label>
        <input id="<?php echo $this->get_field_id('image_url'); ?>" type="text" class="image-url" name="<?php echo $this->get_field_name('image_url'); ?>" value="<?php echo esc_url($instance['image_url']); ?>" style="width: 100%;" />
        <input data-title="Image in Widget" data-btntext="Select it" class="button upload_image_button" type="button" value="<?php esc_html_e('Upload','parallel') ?>" />
        <input data-title="Image in Widget" data-btntext="Select it" class="button clear_image_button" type="button" value="<?php esc_html_e('Clear','parallel') ?>" />
    </p>
    <p>
        <label for="<?php echo $this->get_field_id('image_link'); ?>"><?php esc_html_e('Client Link', 'parallel'); ?></label>
        <input id="<?php echo $this->get_field_id('image_link'); ?>" type="text" class="image-link" name="<?php echo $this->get_field_name('image_link'); ?>" value="<?php if (isset($image_link)) echo esc_url($instance['image_link']); ?>" style="width: 100%;" />
        <small><?php esc_html_e('Enter a link to the clients website.', 'parallel'); ?></small>
    </p>
    <p class="img-prev">
        <img src="<?php echo esc_url($instance['image_url']); ?>" style="max-width: 100%;">
    </p>
<?php
    }
}
// End of Plugin Class
add_action( 'widgets_init', function() {
    register_widget( 'Parallel_Our_Clients_Widget' );
} );
?>