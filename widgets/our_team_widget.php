<?php 
/**
 * new WordPress Widget format
 * Wordpress 2.8 and above
 * @see http://codex.wordpress.org/Widgets_API#Developing_Widgets
 */
class Parallel_Our_Team_Widget extends WP_Widget {

    /**
     * Constructor
     *
     * @return void
     **/
    function __construct() {
        $widget_ops = array( 'classname' => 'wcp_image', 'description' => __('Add a team member to the homepage Our Team section.', 'parallel') );
        parent::__construct( 'Parallel_our_team', __('Parallel - Team Member Widget', 'parallel'), $widget_ops );
        
        //setup default widget data
		$this->defaults = array(
			'title'         => '',
			'image_url'     => '',
			'textarea'   	=> '',
            'position'   	=> '',
            'facebook'   	=> '',
            'twitter'   	=> '',
            'google'   	    => '',
            'github'   	    => '',
            'behance'   	=> '',
            'linkedin'   	=> '',
            'instagram'   	=> '',
            'pinterest'   	=> '',
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
        $title = apply_filters( 'widget_title', empty( $instance['title'] ) ? '' : $instance['title'], $instance, $this->id_base );
        $image_url = $instance['image_url'];
        $textarea = apply_filters( 'widget_textarea', empty( $instance['textarea'] ) ? '' : $instance['textarea'], $instance );
        $position = $instance['position'];
        $facebook = $instance['facebook'];
        $twitter = $instance['twitter'];
        $google = $instance['google'];
        $github = $instance['github'];
        $behance = $instance['behance'];
        $linkedin = $instance['linkedin'];
        $instagram = $instance['instagram'];
        $pinterest = $instance['pinterest'];
        echo $before_widget;
        // Display the widget
        echo '<div class="row">';
        if( $image_url) {
            echo '<div class="col-xs-12 col-sm-5 col-md-5">';
            echo '<img src="'.$image_url.'" alt="'.$title.'" class="img-responsive center-block">';
            echo '</div>';
        }
        echo '<div class="col-xs-12 col-sm-7 col-md-7">';
        // Check if title is set
        if ( $title ) {
          echo $before_title . $title . $after_title;
        }
        echo '<div class="position">'.$position.'</div>';
        // Check if textarea is set
        if( $textarea ) { echo '' . wpautop($textarea) . ''; }
        echo '<ul class="socials">';
        if ($facebook) { echo '<li><a target="_blank" href="'.$facebook.'"><i class="fa fa-facebook fa-lg"></i></a></li>';}
        if ($twitter) { echo '<li><a target="_blank" href="'.$twitter.'"><i class="fa fa-twitter fa-lg"></i></a></li>';}
        if ($google) { echo '<li><a target="_blank" href="'.$google.'"><i class="fa fa-google-plus fa-lg"></i></a></li>';}
        if ($github) { echo '<li><a target="_blank" href="'.$github.'"><i class="fa fa-github fa-lg"></i></a></li>';}
        if ($behance) { echo '<li><a target="_blank" href="'.$behance.'"><i class="fa fa-behance fa-lg"></i></a></li>';}
        if ($linkedin) { echo '<li><a target="_blank" href="'.$linkedin.'"><i class="fa fa-linkedin fa-lg"></i></a></li>';}
        if ($instagram) { echo '<li><a target="_blank" href="'.$instagram.'"><i class="fa fa-instagram fa-lg"></i></a></li>';}
        if ($pinterest) { echo '<li><a target="_blank" href="'.$pinterest.'"><i class="fa fa-pinterest fa-lg"></i></a></li>';}
        echo '</ul>';
        echo '</div>';
        echo '</div>';
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
        $instance['title'] = sanitize_text_field($new_instance['title']);
        $instance['image_url'] = esc_url($new_instance['image_url']);
        $instance['position'] = sanitize_text_field($new_instance['position']);
        if ( current_user_can('unfiltered_html') )
            $instance['textarea'] =  $new_instance['textarea'];
        else $instance['textarea'] = wp_kses_post($new_instance['textarea']);
        $instance['facebook'] = esc_url($new_instance['facebook']);
        $instance['twitter'] = esc_url($new_instance['twitter']);
        $instance['google'] = esc_url($new_instance['google']);
        $instance['github'] = esc_url($new_instance['github']);
        $instance['behance'] = esc_url($new_instance['behance']);
        $instance['linkedin'] = esc_url($new_instance['linkedin']);
        $instance['instagram'] = esc_url($new_instance['instagram']);
        $instance['pinterest'] = esc_url($new_instance['pinterest']);
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
        <label for="<?php echo $this->get_field_id('title'); ?>"><?php esc_html_e('Name', 'parallel'); ?></label>
        <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($instance['title']); ?>" />
    </p>
    <p>
        <label for="<?php echo $this->get_field_id('image_url'); ?>"><?php esc_html_e('Profile Image', 'parallel'); ?></label>
        <input id="<?php echo $this->get_field_id('image_url'); ?>" type="text" class="image-url" name="<?php echo $this->get_field_name('image_url'); ?>" value="<?php echo esc_url($instance['image_url']); ?>" style="width: 100%;" />
        <input data-title="Image in Widget" data-btntext="Select it" class="button upload_image_button" type="button" value="<?php esc_html_e('Upload','parallel') ?>" />
        <input data-title="Image in Widget" data-btntext="Select it" class="button clear_image_button" type="button" value="<?php esc_html_e('Clear','parallel') ?>" />
    </p>
    <p class="img-prev">
        <img src="<?php echo esc_url($instance['image_url']); ?>" style="max-width: 100%;">
    </p>
    <p>
        <label for="<?php echo $this->get_field_id('position'); ?>"><?php esc_html_e('Position', 'parallel'); ?></label>
        <input class="widefat" id="<?php echo $this->get_field_id('position'); ?>" name="<?php echo $this->get_field_name('position'); ?>" type="text" value="<?php echo esc_attr($instance['position']); ?>" />
    </p>
    <p>
        <label for="<?php echo $this->get_field_id('textarea'); ?>"><?php esc_html_e('Short Bio', 'parallel'); ?></label>
        <textarea class="widefat" rows="5" id="<?php echo $this->get_field_id('textarea'); ?>" name="<?php echo $this->get_field_name('textarea'); ?>"><?php echo wp_kses_post($instance['textarea']); ?></textarea>
        <small><?php esc_html_e('No limit on the amount of text and HTML is allowed.', 'parallel'); ?></small>
    </p>
    <p>
        <label for="<?php echo $this->get_field_id('facebook'); ?>"><?php esc_html_e('Facebook URL', 'parallel'); ?></label>
        <input class="widefat" id="<?php echo $this->get_field_id('facebook'); ?>" name="<?php echo $this->get_field_name('facebook'); ?>" type="text" value="<?php echo esc_url($instance['facebook']); ?>" />
    </p>
    <p>
        <label for="<?php echo $this->get_field_id('twitter'); ?>"><?php esc_html_e('Twitter URL', 'parallel'); ?></label>
        <input class="widefat" id="<?php echo $this->get_field_id('twitter'); ?>" name="<?php echo $this->get_field_name('twitter'); ?>" type="text" value="<?php echo esc_url($instance['twitter']); ?>" />
    </p>
    <p>
        <label for="<?php echo $this->get_field_id('google'); ?>"><?php esc_html_e('Google+ URL', 'parallel'); ?></label>
        <input class="widefat" id="<?php echo $this->get_field_id('google'); ?>" name="<?php echo $this->get_field_name('google'); ?>" type="text" value="<?php echo esc_url($instance['google']); ?>" />
    </p>
    <p>
        <label for="<?php echo $this->get_field_id('github'); ?>"><?php esc_html_e('Github URL', 'parallel'); ?></label>
        <input class="widefat" id="<?php echo $this->get_field_id('github'); ?>" name="<?php echo $this->get_field_name('github'); ?>" type="text" value="<?php echo esc_url($instance['github']); ?>" />
    </p>
    <p>
        <label for="<?php echo $this->get_field_id('behance'); ?>"><?php esc_html_e('Behance URL', 'parallel'); ?></label>
        <input class="widefat" id="<?php echo $this->get_field_id('behance'); ?>" name="<?php echo $this->get_field_name('behance'); ?>" type="text" value="<?php echo esc_url($instance['behance']); ?>" />
    </p>
    <p>
        <label for="<?php echo $this->get_field_id('linkedin'); ?>"><?php esc_html_e('Linkedin URL', 'parallel'); ?></label>
        <input class="widefat" id="<?php echo $this->get_field_id('linkedin'); ?>" name="<?php echo $this->get_field_name('linkedin'); ?>" type="text" value="<?php echo esc_url($instance['linkedin']); ?>" />
    </p>
    <p>
        <label for="<?php echo $this->get_field_id('instagram'); ?>"><?php esc_html_e('Instagram URL', 'parallel'); ?></label>
        <input class="widefat" id="<?php echo $this->get_field_id('instagram'); ?>" name="<?php echo $this->get_field_name('instagram'); ?>" type="text" value="<?php echo esc_url($instance['instagram']); ?>" />
    </p>
    <p>
        <label for="<?php echo $this->get_field_id('pinterest'); ?>"><?php esc_html_e('Pinterest URL', 'parallel'); ?></label>
        <input class="widefat" id="<?php echo $this->get_field_id('pinterest'); ?>" name="<?php echo $this->get_field_name('pinterest'); ?>" type="text" value="<?php echo esc_url($instance['pinterest']); ?>" />
    </p>
<?php
    }
}
// End of Plugin Class
add_action( 'widgets_init', function() {
    register_widget( 'Parallel_Our_Team_Widget' );
} );
?>