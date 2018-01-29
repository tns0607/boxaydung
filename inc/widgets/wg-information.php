<?php
add_action('widgets_init', 'register_widget_information');

function register_widget_information() {
    register_widget('Gtid_Information_Widget');
}

class Gtid_Information_Widget extends WP_Widget {

    function __construct() {

        parent::__construct(
            'information',
            __( '3B - Information contact', 'shtheme' ),
            array( 
                'description'  => __( 'Display information contact', 'shtheme' ),
            )
        );
        
    }

    function widget($args, $instance) {
        extract($args);
        echo $before_widget;

        if ($instance['title']) echo $before_title . apply_filters('widget_title', $instance['title']) . $after_title;
        ?>
        <ul>
            <?php 
            if( $instance['address'] ) {
                echo '<li><i class="fa fa-map-marker" aria-hidden="true"></i>'. __( 'Address', 'shtheme' ) .': '. $instance['address'] .'</li>';
            }
            if( $instance['tel'] ) {
                echo '<li><i class="fa fa-phone-square" aria-hidden="true"></i>'. __( 'Telephone', 'shtheme' ) .': '. $instance['tel'] .'</li>';
            }
            if( $instance['email'] ) {
                echo '<li><i class="fa fa-envelope" aria-hidden="true"></i>'. __( 'Email', 'shtheme' ) .': '. $instance['email'] .'</li>';
            }
            if( $instance['website'] ) {
                echo '<li><i class="fa fa-globe" aria-hidden="true"></i>'. __( 'Website', 'shtheme' ) .': '. $instance['website'] .'</li>';
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
        		'title' 	 => '', 
        		'address'    => '',  
        		'tel' 	     => '',
                'email'      => '',
                'website'    => '',
    		) 
    	);
        ?>
        <p>
            <label for="<?php  echo $this->get_field_id('title'); ?>"><?php _e('Title', 'shtheme'); ?>:</label>
            <input type="text" class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php  echo $this->get_field_name('title'); ?>" value="<?php  echo esc_attr( $instance['title'] ); ?>" />
        </p>
        <p>
            <label for="<?php  echo $this->get_field_id('address'); ?>"><?php _e('Address', 'shtheme'); ?>:</label>
            <input type="text" class="widefat" id="<?php echo $this->get_field_id('address'); ?>" name="<?php  echo $this->get_field_name('address'); ?>" value="<?php  echo esc_attr( $instance['address'] ); ?>" />
        </p>
        <p>
            <label for="<?php  echo $this->get_field_id('tel'); ?>"><?php _e('Telephone', 'shtheme'); ?>:</label>
            <input type="text" class="widefat" id="<?php echo $this->get_field_id('tel'); ?>" name="<?php  echo $this->get_field_name('tel'); ?>" value="<?php  echo esc_attr( $instance['tel'] ); ?>" />
        </p>
        <p>
            <label for="<?php  echo $this->get_field_id('email'); ?>"><?php _e('Email', 'shtheme'); ?>:</label>
            <input type="text" class="widefat" id="<?php echo $this->get_field_id('email'); ?>" name="<?php  echo $this->get_field_name('email'); ?>" value="<?php  echo esc_attr( $instance['email'] ); ?>" />
        </p>
        <p>
            <label for="<?php  echo $this->get_field_id('website'); ?>"><?php _e('Website', 'shtheme'); ?>:</label>
            <input type="text" class="widefat" id="<?php echo $this->get_field_id('website'); ?>" name="<?php  echo $this->get_field_name('website'); ?>" value="<?php  echo esc_attr( $instance['website'] ); ?>" />
        </p>
    <?php
    }
}
