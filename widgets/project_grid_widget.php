<?php 
/**
 * new WordPress Widget format
 * Wordpress 2.8 and above
 * @see http://codex.wordpress.org/Widgets_API#Developing_Widgets
 */
class Parallel_Projects_Grid_Widget extends WP_Widget {

    /**
     * Constructor
     *
     * @return void
     **/
    function __construct() {
        $widget_ops = array( 'classname' => 'wcp_image', 'description' => __('Add a project to the homepage projects grid section.', 'parallel') );
        parent::__construct( 'Parallel_projects_grid', __('Parallel - Grid Project Widget', 'parallel'), $widget_ops );
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
        $title = apply_filters('widget_title', $instance['title']);
        $image_url = $instance['image_url'];
        $image_link = $instance['image_link'];
        $link_target = $instance['link_target'] ? 'true' : 'false';
        $textarea = apply_filters('widget_textarea', empty( $instance['textarea'] ) ? '' : $instance['textarea'], $instance );
        echo $before_widget;
        // Display the widget
        if (isset($image_url) && !$image_link) {
          echo '<a href="'.$image_url.'" rel="prettyPhoto" title="'.$title.'" class="fancybox-thumb hovereffect">';
          echo '<img src="'.$image_url.'" alt="'.$title.'" class="img-responsive center-block"><span></span></a>';
        }
        elseif (isset($image_url) && $image_link && $link_target === 'false') {
          echo '<a href="'.$image_link.'" title="'.$title.'" class="fancybox-thumb hovereffect">';
          echo '<img src="'.$image_url.'" alt="'.$title.'" class="img-responsive center-block"><span></span></a>';
        }
        elseif (isset($image_url) && $image_link && $link_target === 'true') {
          echo '<a href="'.$image_link.'" target="_blank" title="'.$title.'" class="fancybox-thumb hovereffect">';
          echo '<img src="'.$image_url.'" alt="'.$title.'" class="img-responsive center-block"><span></span></a>';
        }

        // Check if title is set
        if ( $title ) {
          echo $before_title . $title . $after_title;
        }

        // Check if textarea is set
        if( $textarea ) { echo '<p>' . wpautop($textarea) . '</p>'; }
        
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
        $instance['image_link'] = esc_url($new_instance['image_link']);
        $instance['link_target'] = esc_attr($new_instance[ 'link_target' ]);
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
        extract($instance);
?>
	<p>
        <label for="<?php echo $this->get_field_id('title'); ?>"><?php esc_html_e('Project Title', 'parallel'); ?></label>
        <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($instance['title']); ?>" />
    </p>
    <p>
        <label for="<?php echo $this->get_field_id('image_url'); ?>"><?php esc_html_e('Project Image', 'parallel'); ?></label>
        <input id="<?php echo $this->get_field_id('image_url'); ?>" type="text" class="image-url" name="<?php echo $this->get_field_name('image_url'); ?>" value="<?php if (isset($image_url)) echo esc_url($instance['image_url']); ?>" style="width: 100%;" />
        <input data-title="Image in Widget" data-btntext="Select it" class="button upload_image_button" type="button" value="<?php esc_html_e('Upload','parallel') ?>" />
        <input data-title="Image in Widget" data-btntext="Select it" class="button clear_image_button" type="button" value="<?php esc_html_e('Clear','parallel') ?>" />
	</p>
	<p class="img-prev">
		<?php if (isset($image_url) && $image_url) { echo '<img src="'.$image_url.'" style="max-width: 100%;">';} ?>
	</p>
    <p>
        <label for="<?php echo $this->get_field_id('image_link'); ?>"><?php esc_html_e('Project Link', 'parallel'); ?></label>
        <input id="<?php echo $this->get_field_id('image_link'); ?>" type="text" class="image-link" name="<?php echo $this->get_field_name('image_link'); ?>" value="<?php echo esc_url($instance['image_link']); ?>" style="width: 100%;" />
        <small><?php esc_html_e('Enter a link to the project or a seperate page.', 'parallel'); ?></small>
    </p>
    <p>
        <input class="checkbox" type="checkbox" <?php checked( $instance[ 'link_target' ], 'on' ); ?> id="<?php echo $this->get_field_id( 'link_target' ); ?>" name="<?php echo $this->get_field_name( 'link_target' ); ?>" /> 
        <label for="<?php echo $this->get_field_id( 'link_target' ); ?>"><?php esc_html_e('Open link in new window/tab', 'parallel'); ?></label>
    </p>
    <p>
        <label for="<?php echo $this->get_field_id('textarea'); ?>"><?php esc_html_e('Project Description', 'parallel'); ?></label>
        <textarea class="widefat" rows="5" id="<?php echo $this->get_field_id('textarea'); ?>" name="<?php echo $this->get_field_name('textarea'); ?>"><?php echo wp_kses_post($instance['textarea']); ?></textarea>
        <small><?php esc_html_e('No limit on the amount of text and HTML is allowed.', 'parallel'); ?></small>
    </p>
<?php
    }
}
// End of Plugin Class
add_action( 'widgets_init', function() {
    register_widget( 'Parallel_Projects_Grid_Widget' );
} );
?>