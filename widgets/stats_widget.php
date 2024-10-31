<?php 
/**
 * new WordPress Widget format
 * Wordpress 2.8 and above
 * @see http://codex.wordpress.org/Widgets_API#Developing_Widgets
 */
class Parallel_Stat_Widget extends WP_Widget {

    /**
     * Constructor
     *
     * @return void
     **/
    function __construct() {
        $widget_ops = array( 'classname' => 'wcp_image', 'description' => __('Add a stat to the homepage stats section.', 'parallel') );
        parent::__construct( 'Parallel_Stat', __('Parallel - Stat Widget', 'parallel'), $widget_ops );
        
        //setup default widget data
		$this->defaults = array(
			'number'    => '',
			'text'      => '',
			'image_url' => '',
            'prefix'    => '',
            'suffix'   	=> '',
            'textarea'  => '',
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
        wp_reset_postdata();
        extract( $args, EXTR_SKIP );

        // these are the widget options
        $number = apply_filters('widget_number', $instance['number']);
        $text = $instance['text'];
        $image_url = $instance['image_url'];
        $prefix = $instance['prefix'];
        $suffix = $instance['suffix'];
        $textarea = apply_filters( 'widget_textarea', empty( $instance['textarea'] ) ? '' : $instance['textarea'], $instance );
        echo $before_widget;

        // Display the widget
        echo '';

        // Check if text is set
        if( $text ) {
          echo '<i class="fa '.$text.' icon"></i>';
        }
        if( !$text && $image_url) {
          echo '<img  src="'.$image_url.'" class="image">';
        }

        // Check if number is set
        if ( $number ) {
          echo '<div class="number"><p><span class="prefix">'. $prefix .'</span><span class="counter">'. $number .'</span><span class="sufix">'. $suffix .'</span></p></div>';
        }

        // Check if textarea is set
        if( $textarea ) { echo wpautop($textarea); }
        echo '';
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
        $instance['number'] = sanitize_text_field($new_instance['number']);
        $instance['text'] = sanitize_text_field($new_instance['text']);
        $instance['image_url'] = esc_url($new_instance['image_url']);
        $instance['prefix'] = sanitize_text_field($new_instance['prefix']);
        $instance['suffix'] = sanitize_text_field($new_instance['suffix']);
        if ( current_user_can('unfiltered_html') )
        	$instance['textarea'] =  $new_instance['textarea'];
        else $instance['textarea'] = wp_kses_post($new_instance['textarea']);

        return $instance;
    }

    /**
     * Displays the form for this widget on the Widgets page of the WP Admin area.
     *
     * @param array  An array of the current settings for this widget
     * @return void Echoes it's output
     **/
    function form( $instance ) {
        $instance = wp_parse_args( (array) $instance, $this->defaults );

?>
    <p>
        <label for="<?php echo $this->get_field_id('text'); ?>"><?php esc_html_e('Stat Icon Class', 'parallel'); ?></label>
        <input class="widefat" id="<?php echo $this->get_field_id('text'); ?>" name="<?php echo $this->get_field_name('text'); ?>" type="text" value="<?php echo esc_attr($instance['text']); ?>" />
        <?php _e('Copy and paste the required icon prefix and class from the', 'parallel'); ?> <a href="<?php echo esc_url('https://fontawesome.com/icons?d=gallery&m=free'); ?>" target="_blank"><?php _e('FontAwesome Icons list', 'parallel'); ?></a> <?php _e('and choose from 1500+ icons. For example, to use the smiley face icon enter', 'parallel'); ?> <code><?php _e('far fa-smile', 'parallel'); ?></code>
    </p>
    <p>
        <label for="<?php echo $this->get_field_id('image_url'); ?>"><?php esc_html_e('Stat Image', 'parallel'); ?></label>
        <br /><small><?php esc_html_e('Or instead of using an icon you can upload an image.', 'parallel'); ?></small>
        <input id="<?php echo $this->get_field_id('image_url'); ?>" type="text" class="image-url" name="<?php echo $this->get_field_name('image_url'); ?>" value="<?php echo esc_url($instance['image_url']); ?>" style="width: 100%;" />
        <input data-title="Image in Widget" data-btntext="Select it" class="button upload_image_button" type="button" value="<?php esc_html_e('Upload','parallel') ?>" />
        <input data-title="Image in Widget" data-btntext="Select it" class="button clear_image_button" type="button" value="<?php esc_html_e('Clear','parallel') ?>" />
	</p>
	<p class="img-prev">
		<?php if (isset($image_url) && $image_url) { echo '<img src="'.$image_url.'" style="max-width: 100%;">';} ?>
	</p>
    <p>
        <label for="<?php echo $this->get_field_id('number'); ?>"><?php esc_html_e('Stat Number', 'parallel'); ?></label>
        <input class="widefat" id="<?php echo $this->get_field_id('number'); ?>" name="<?php echo $this->get_field_name('number'); ?>" type="text" value="<?php echo esc_attr($instance['number']); ?>" />
    </p>
    <p>
        <label for="<?php echo $this->get_field_id('prefix'); ?>"><?php esc_html_e('Stat Prefix', 'parallel'); ?></label>
        <input class="widefat" id="<?php echo $this->get_field_id('prefix'); ?>" name="<?php echo $this->get_field_name('prefix'); ?>" type="text" value="<?php echo esc_attr($instance['prefix']); ?>" />
    </p>
    <p>
        <label for="<?php echo $this->get_field_id('suffix'); ?>"><?php esc_html_e('Stat Suffix', 'parallel'); ?></label>
        <input class="widefat" id="<?php echo $this->get_field_id('suffix'); ?>" name="<?php echo $this->get_field_name('suffix'); ?>" type="text" value="<?php echo esc_attr($instance['suffix']); ?>" />
    </p>
    <p>
        <label for="<?php echo $this->get_field_id('textarea'); ?>"><?php esc_html_e('Stat Description', 'parallel'); ?></label>
        <textarea class="widefat" rows="5" id="<?php echo $this->get_field_id('textarea'); ?>" name="<?php echo $this->get_field_name('textarea'); ?>"><?php echo wp_kses_post($instance['textarea']); ?></textarea>
    <small><?php esc_html_e('No limit on the amount of text and HTML is allowed.', 'parallel'); ?></small>
    </p>
<?php
    }
}
// End of Widget Class
add_action( 'widgets_init', function() {
    register_widget( 'Parallel_Stat_Widget' );
} );
?>