<?php
add_action('widgets_init', 'register_widget_social');

function register_widget_social() {
    register_widget('Gtid_Social_Widget');
}

class Gtid_Social_Widget extends WP_Widget {

    function __construct() {

        parent::__construct(
            'social',
            __( '3B - Social', 'shtheme' ),
            array(
                'description'  =>  __( 'Display information social', 'shtheme' )
            )
        );
        
    }

    function widget($args, $instance) {
        extract($args);
        echo $before_widget;

        if ($instance['title']) echo $before_title . apply_filters('widget_title', $instance['title']) . $after_title;
        global $sh_option;
        ?>
        <ul>
            <?php
            if( ! empty( $sh_option['social-facebook'] ) ) {
                echo '<li class="icon_social icon_facebook"><a href="'.$sh_option['social-facebook'].'" rel="nofollow" target="_blank"><i class="fa fa-facebook" aria-hidden="true"></i></a></li>';
            }
            if( ! empty( $sh_option['social-twitter'] ) ) {
                echo '<li class="icon_social icon_twitter"><a href="'.$sh_option['social-twitter'].'" rel="nofollow" target="_blank"><i class="fa fa-twitter" aria-hidden="true"></i></a></li>';
            }
            if( ! empty( $sh_option['social-google'] ) ) {
                echo '<li class="icon_social icon_google"><a href="'.$sh_option['social-google'].'" rel="nofollow" target="_blank"><i class="fa fa-google-plus" aria-hidden="true"></i></a></li>';
            }
            if( ! empty( $sh_option['social-youtube'] ) ) {
                echo '<li class="icon_social icon_youtube"><a href="'.$sh_option['social-youtube'].'" rel="nofollow" target="_blank"><i class="fa fa-youtube" aria-hidden="true"></i></a></li>';
            }
            if( ! empty( $sh_option['social-linkedin'] ) ) {
                echo '<li class="icon_social icon_linkedin"><a href="'.$sh_option['social-linkedin'].'" rel="nofollow" target="_blank"><i class="fa fa-linkedin" aria-hidden="true"></i></a></li>';
            }
            if( ! empty( $sh_option['social-pinterest'] ) ) {
                echo '<li class="icon_social icon_pinterest"><a href="'.$sh_option['social-pinterest'].'" rel="nofollow" target="_blank"><i class="fa fa-pinterest" aria-hidden="true"></i></a></li>';
            }
            if( ! empty( $sh_option['social-instagram'] ) ) {
                echo '<li class="icon_social icon_instagram"><a href="'.$sh_option['social-instagram'].'" rel="nofollow" target="_blank"><i class="fa fa-instagram" aria-hidden="true"></i></a></li>';
            }
            ?>
        </ul>
 
        <?php
        echo $after_widget;
    }

    function update($new_instance, $old_instance) {
        return $new_instance;
    }

    function form($instance) {
        $instance = wp_parse_args(
            (array)$instance, array(
                // 'title'             => '', 
                // 'numpro'            => '3',  
                // 'cat'               => '',
            )
        );
        ?>
        <p>
            <label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title', 'shtheme' ); ?>:</label>
            <input type="text" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo esc_attr( $instance['title'] ); ?>" class="widefat" />
        </p>
        <?php _e('<p>This widget content is displayed from <strong>Theme Options -> Social</strong></p>');?>
    <?php
    }

}
