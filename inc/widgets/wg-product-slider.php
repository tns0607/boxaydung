<?php
add_action('widgets_init', 'register_gtid_product_by_cat');

function register_gtid_product_by_cat() {
    register_widget('Gtid_Products_Widget');
}

class Gtid_Products_Widget extends WP_Widget {

    function __construct() {
        parent::__construct(
            'slider_products',
            __( '3B - Products Slider', 'shtheme' ),
            array(
                'description'  => __( 'Display vertical slide list product', 'shtheme' )
            )
        );
    }

    function widget($args, $instance) {
        extract($args);
        echo $before_widget;

        if ($instance['title']) echo $before_title . apply_filters('widget_title', $instance['title']) . $after_title;
        ?>

        <div class="slider-products">
            <ul class="owl-carousel" 
                data-item="1" 
                data-margin="0" 
                data-md="1" 
                data-sm="1" 
                data-xs="1" 
                data-dots="false" 
                data-nav="true">
                <?php
                $i = 1;
                $numpro = $instance['numpro'];
                $args = array(
                    'post_type'         => 'product',
                    'tax_query'         => array(
                        array(
                            'taxonomy'  => 'product_cat',
                            'field'     => 'id',
                            'terms'     => $instance['cat'],
                        )
                    ),
                    'showposts'         => 20,
                );
                $the_query = new WP_Query($args);
                $count = $the_query->found_posts;
                while($the_query->have_posts()):
                $the_query->the_post();
                if( $i == 1 ) {
                    echo '<li>';
                }
                ?>
                    <div id="post-<?php the_ID(); ?>" class="item-product">
                        <a class="flex <?php echo $instance['image_alignment'];?>" href="<?php the_permalink();?>" title="<?php the_title();?>">
                            <?php if( has_post_thumbnail() ) the_post_thumbnail( $instance['image_size'],array( "alt" => get_the_title() ) );?>
                        </a>
                        <h3>
                            <a href="<?php the_permalink();?>" title="<?php the_title();?>">
                                <?php the_title();?>
                            </a>
                        </h3>
                        <?php get_price_product();?>
                    </div>
                <?php
                if( $i%$numpro == 0 && $i != $count  ) {
                    echo '</li><li>';
                }
                if( $i%$numpro != 0 && $i == $count  ) {
                    echo '</li>';
                }
                $i++;
                endwhile;
                wp_reset_postdata(); ?>
            </ul>
        </div>
 
        <?php
        wp_enqueue_script( 'owlcarousel-js' );
        wp_enqueue_style( 'owlcarousel-style' );
        wp_enqueue_style( 'owlcarousel-theme-style' );
        echo $after_widget;
    }

    function update($new_instance, $old_instance) {
        return $new_instance;
    }

    function form($instance) {
        $instance = wp_parse_args(
        	(array)$instance, array(
        		'title' 			=> '', 
        		'numpro' 			=> '3',  
        		'cat' 				=> '',
    		)
    	);
        ?>
        <p>
            <label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title', 'shtheme'); ?>:</label>
            <input type="text" class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php  echo $this->get_field_name('title'); ?>" value="<?php  echo esc_attr( $instance['title'] ); ?>" />
        </p>

        <p>
            <label for="<?php echo $this->get_field_id('numpro'); ?>"><?php _e('Number of Posts to Show', 'shtheme'); ?>:</label>
            <input type="text" class="widefat" id="<?php echo $this->get_field_id('numpro'); ?>" name="<?php  echo $this->get_field_name('numpro'); ?>" value="<?php  echo esc_attr( $instance['numpro'] ); ?>" />
        </p>
        
        <p>
            <label for="<?php echo $this-> get_field_id('cat'); ?>"><?php _e('Category','shtheme'); ?>:</label>
            <?php
            wp_dropdown_categories(array('name'=> $this->get_field_name('cat'),'selected'=>$instance['cat'],'orderby'=>'Name','hierarchical'=>1,'show_option_all'=>__('Select category','shtheme'),'hide_empty'=>'0', 'taxonomy' => 'product_cat'));
            ?>
        </p>

        <p>
            <label for="<?php echo $this->get_field_id( 'image_alignment' ); ?>"><?php _e( 'Image Alignment', 'shtheme' ); ?>:</label>
            <select id="<?php echo $this->get_field_id( 'image_alignment' ); ?>" name="<?php echo $this->get_field_name( 'image_alignment' ); ?>">
                <option value="alignnone">- <?php _e( 'None', 'shtheme' ); ?> -</option>
                <option value="alignleft" <?php selected( 'alignleft', $instance['image_alignment'] ); ?>><?php _e( 'Left', 'shtheme' ); ?></option>
                <option value="alignright" <?php selected( 'alignright', $instance['image_alignment'] ); ?>><?php _e( 'Right', 'shtheme' ); ?></option>
                <option value="aligncenter" <?php selected( 'aligncenter', $instance['image_alignment'] ); ?>><?php _e( 'Center', 'shtheme' ); ?></option>
            </select>
        </p>

        <p>
            <label for="<?php echo $this->get_field_id( 'image_size' ); ?>"><?php _e( 'Image Size', 'shtheme' ); ?>:</label>
            <select id="<?php echo $this->get_field_id( 'image_size' ); ?>" class="" name="<?php echo $this->get_field_name( 'image_size' ); ?>">
                <option value="thumbnail">thumbnail (<?php echo get_option( 'thumbnail_size_w' ); ?>x<?php echo get_option( 'thumbnail_size_h' ); ?>)</option>
                <?php
                $sizes = wp_get_additional_image_sizes();
                foreach( (array) $sizes as $name => $size )
                    echo '<option value="'.esc_attr( $name ).'" '.selected( $name, $instance['image_size'], FALSE ).'>'.esc_html( $name ).' ( '.$size['width'].'x'.$size['height'].' )</option>';
                ?>
            </select>
        </p>
    <?php
    }

}
