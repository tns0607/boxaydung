<?php
/**
 * Register Shop Widget Area
 *
 */
function shtheme_add_sidebar_shop() {
	register_sidebar( array(
		'name'          => esc_html__( 'Shop Sidebar', 'shtheme' ),
		'id'            => 'sidebar-shop',
		'description'   => esc_html__( 'Add widgets here.', 'shtheme' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );
}
add_action( 'widgets_init', 'shtheme_add_sidebar_shop' );

/**
 * Setup layout page woocommerce
 */
function woocommerce_support() {
    add_theme_support( 'woocommerce' );
}
add_action( 'after_setup_theme', 'woocommerce_support' );

remove_action( 'woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10);
remove_action( 'woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10);

function my_theme_wrapper_start() {
	echo '<div class="content-sidebar-wrap">';
	echo '<div id="main" class="site-main" role="main">';
}

function my_theme_wrapper_end() {
	global $sh_option;
	echo '</div>';
	echo '<aside class="sidebar sidebar-shop" itemscope itemtype="https://schema.org/WPSideBar">';
		if( $sh_option['display-shopsidebar'] == 1 ) {
			dynamic_sidebar( 'sidebar-shop' );
		} else {
			dynamic_sidebar( 'sidebar-1' );
		}
	echo '</aside>';
	echo '</div>';
}

add_action('woocommerce_before_main_content', 'my_theme_wrapper_start', 10);
add_action('woocommerce_after_main_content', 'my_theme_wrapper_end', 10);

/**
 * Enable Gallery
 */
add_theme_support( 'wc-product-gallery-zoom' );
// add_theme_support( 'wc-product-gallery-lightbox' );
add_theme_support( 'wc-product-gallery-slider' );

/**
 * Show image category product
 */
function woocommerce_category_image($products) {
    $thumbnail_id = get_woocommerce_term_meta( $products, 'thumbnail_id', true );
    $arr = wp_get_attachment_image_src( $thumbnail_id, 'full' );
    $image = $arr[0];
    if ( $image ) {
	    echo '<img src="' . $image . '" alt="" />';
	}
}

/**
 * Edit number product show per page in category product
 */
function woocommerce_edit_loop_shop_per_page( $cols ) {
	global $sh_option;
	if ( ! empty( $sh_option['number-products-cate'] ) ) {
		$cols = $sh_option['number-products-cate'];
	} else {
		$cols = get_option( 'posts_per_page' );
	}
	return $cols;
}
add_filter( 'loop_shop_per_page', 'woocommerce_edit_loop_shop_per_page', 20 );

/**
 * Add percent sale in content product template
 */
function add_percent_sale(){
	global $product;
	if ( $product->is_on_sale() && $product->is_type( 'simple' ) ) {
		$per = round( ( ( $product->regular_price - $product->sale_price ) / $product->regular_price ) * 100 );
		echo "<span class='percent'>-$per%</span>";
	}
}
add_action( 'woocommerce_after_shop_loop_item','add_percent_sale',15 );

/**
 * Overwrite field checkout
 */
function custom_override_checkout_fields( $fields ) {
    unset($fields['billing']['billing_company']);
    return $fields;
}
add_filter( 'woocommerce_checkout_fields' , 'custom_override_checkout_fields' );

/**
 * Return class layout product
 */
function get_column_product($numcol) {
	global $sh_option;
	switch ($numcol) {
	    case '1':
	        $post_class = 'col-md-12';
	        break;
	    case '2':
	        $post_class = 'col-xs-6';
	        break;
	    case '3':
	        $post_class = 'col-md-4 col-sm-6 col-xs-6';
	        break;
	    case '4':
	        $post_class = 'col-md-3 col-sm-4 col-xs-6';
	        break;
	    case '5':
	        $post_class = 'col-lg-15 col-md-3 col-sm-4 col-xs-6';
	        break;
	    case '6':
	        $post_class = 'col-lg-2 col-md-3 col-sm-4 col-xs-6';
	        break;
	}
	return $post_class;
}

/**
 * Tab Woocommerce
 */
function woo_remove_product_tabs( $tabs ) {
    // unset( $tabs['reviews'] );
    unset( $tabs['additional_information'] );
    return $tabs;
}
add_filter( 'woocommerce_product_tabs', 'woo_remove_product_tabs', 98 );

function woo_rename_tabs( $tabs ) {
	$tabs['description']['title'] 	= __( 'Information', 'shtheme' );
	$tabs['image']['title'] 		= __( 'Gallery', 'shtheme' );
	$tabs['video']['title'] 		= __( 'Video', 'shtheme' );
	$tabs['document']['title'] 		= __( 'Attachments', 'shtheme' );

	$tabs['image']['priority']		= 50;
	$tabs['video']['priority']		= 60;
	$tabs['document']['priority']	= 70;

	$tabs['image']['callback']		= 'content_tab_image';
	$tabs['video']['callback']		= 'content_tab_video';
	$tabs['document']['callback']	= 'content_tab_document';
	return $tabs;
}
// add_filter( 'woocommerce_product_tabs', 'woo_rename_tabs', 98 );

function custom_numberpro_related_products_args( $args ) {
	global $sh_option;
	$numpro_related = $sh_option['number-product-related'];
	$args['posts_per_page'] = $numpro_related; // number related products
	// $args['columns'] 	= 2; // arranged in number columns
	return $args;
}
add_filter( 'woocommerce_output_related_products_args', 'custom_numberpro_related_products_args' );

/**
 * Get Price Product
 */
function get_price_product(){
	global $product;
	$regular_price 	= $product->regular_price;
	$sale_price 	= $product->sale_price;
	if( empty( $regular_price ) ) {
		echo '<p class="price">'.__( 'Contact', 'shtheme' ).'</p>';
	} elseif ( ! empty( $regular_price ) && empty( $sale_price ) ) {
		echo '<p class="price">'. number_format( $regular_price, 0, '', '.' ) . ' đ</p>';
	} elseif ( ! empty( $regular_price ) && ! empty( $sale_price ) ) {
		echo '<p class="price"><ins>'. number_format( $sale_price, 0, '', '.' ) .' đ</ins><del>'. number_format( $regular_price,0,'','.' ) .' đ</del></p>';
	}
}
add_action( 'woocommerce_after_shop_loop_item','get_price_product',10 );

/**
 * Title Product content-product.php
 */
function add_title_name_product(){
	echo '<h3 class="woocommerce-loop-product__title"><a 
	title="' . get_the_title() . '" 
	href=" '. get_the_permalink() .' ">' . get_the_title() . '</a></h3>';
}
add_action( 'woocommerce_shop_loop_item_title','add_title_name_product',10 );

/**
 * Dev Disable Cart
**/
function dev_disable_cart(){
	global $sh_option;
	if( $sh_option['woocommerce-disable-cart'] == '0' ) {
		remove_action( 'woocommerce_after_shop_loop_item','woocommerce_template_loop_add_to_cart',10 );
		remove_action( 'woocommerce_single_product_summary','woocommerce_template_single_add_to_cart',30 );
	}
}
add_action( 'init','dev_disable_cart' );

function shtheme_lib_woocommerce_scripts(){

	// Main js
	wp_enqueue_script( 'main-woo-js', SH_DIR . '/lib/js/main-woo.js', array(), '1.0', true );
	// wp_localize_script( 'main-woo-js', 'ajax_object', array( 'ajax_url' => admin_url( 'admin-ajax.php' ) ) );

	// Woocommerce
	if ( class_exists( 'WooCommerce' ) ) {
		wp_enqueue_style( 'woocommerce-css-style', SH_DIR .'/lib/css/custom-woocommerce.css' );
	}

	// Dev Tooltip
	wp_register_style( 'hover-zoom-style', SH_DIR .'/lib/css/stickytooltip.css' );
    wp_register_script( 'hover-zoom-js', SH_DIR .'/lib/js/stickytooltip.js' );
}
add_action( 'wp_enqueue_scripts', 'shtheme_lib_woocommerce_scripts' , 1 );

/**
 * Dev Tooltip
**/
function code_hover_zoom_class_img() {
	global $sh_option;
    if( ! wp_is_mobile() && $sh_option['woocommerce-tooltip'] == '1' ) {
		wp_enqueue_style( 'hover-zoom-style' );
	    wp_enqueue_script('hover-zoom-js' );
    	?>
	    <div id="mystickytooltip" class="stickytooltip">
	        <div style="padding: 5px;">
	            <div id="stickyzoom" class="atip" style="min-width: 200px;">
	            	<img class="img-zoom" src="" />
	            	<div class="description-zoom"></div>
	            </div>
	        </div>
	    </div>
	    <script type="text/javascript">
	    	jQuery(document).ready(function(){
	    		jQuery('.image-product a.img').hover(function(){
			        var value = jQuery(this).data('img-full');
			        jQuery('.stickytooltip .img-zoom').attr('src', value);
			    });
	    	});
	    </script>
		<?php
    }
}
add_action('wp_footer','code_hover_zoom_class_img', 1);

/**
 * Insert button share single product
 */
function insert_share_product(){
	?>
	<script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-57e482b2e67c850b"></script>
	<div class="addthis_inline_share_toolbox_4524"></div>
	<?php
}
add_action( 'woocommerce_share','insert_share_product' );

/**
 * Returns string with shopping basket icon and content in VERTICAL menu
 *
 * @return string
 */
if( ! function_exists('sh_woocommerce_get__cart_menu_item__content') ) {
	function sh_woocommerce_get__cart_menu_item__content() {
		// ob_start();
		echo '<div class="navbar-actions">';
			echo '<div class="navbar-actions-shrink shopping-cart">';
				echo '<a href="javascript:void(0);" class="shopping-cart-icon-container ffb-cart-menu-item">';
					echo '<span class="shopping-cart-icon-wrapper" title="' . WC()->cart->get_cart_contents_count() . '">';
					echo '<span class="shopping-cart-menu-title">';
						echo get_the_title( wc_get_page_id('cart') );
						echo '&nbsp;';
					echo '</span><i class="fa fa-shopping-cart" aria-hidden="true"></i> </span>';
				echo '</a>';
				echo '<div class="shopping-cart-menu-wrapper">';
					wc_get_template( 'cart/mini-cart.php', array('list_class' => ''));
				echo '</div>';
			echo '</div>';
		echo '</div>';
		// return ob_get_clean();
	}
	add_action( 'sh_after_menu', 'sh_woocommerce_get__cart_menu_item__content');
}

/**
 * Adds rule after product(s) is added to shopping basket. Rule is that everything with class .shopping-cart is
 * refreshed / reloaded with ajax
 *
 * @param array $fragments
 * @return array
 */
if( ! function_exists('woocommerce_ark__cart_menu_item__fragment') ) {
	function woocommerce_ark__cart_menu_item__fragment($fragments) {
		$fragments['.shopping-cart'] = sh_woocommerce_get__cart_menu_item__content();
		return $fragments;
	}
}
add_filter('woocommerce_add_to_cart_fragments', 'woocommerce_ark__cart_menu_item__fragment');

/**
 * Button Detail content-product.php
 */
function insert_btn_detail(){
	?>
	<div class="text-center wrap-detail">
		<a href="<?php the_permalink( );?>" title="<?php the_title( );?>"><?php _e( 'View detail', 'shtheme' );?></a>
	</div>
	<?php
}
// add_action( 'woocommerce_after_shop_loop_item','insert_btn_detail',15 );

// archive-product.php
remove_action( 'woocommerce_before_shop_loop','woocommerce_result_count',20 );
remove_action( 'woocommerce_before_shop_loop','woocommerce_catalog_ordering',30 );
remove_action( 'woocommerce_sidebar','woocommerce_get_sidebar',10 );

// content-product.php
remove_action( 'woocommerce_after_shop_loop_item','woocommerce_template_loop_add_to_cart',10 );
remove_action( 'woocommerce_after_shop_loop_item_title','woocommerce_template_loop_rating',5 );
remove_action( 'woocommerce_after_shop_loop_item_title','woocommerce_template_loop_price',10 );
remove_action( 'woocommerce_shop_loop_item_title','woocommerce_template_loop_product_title',10 );

// content-single-product.php
remove_action( 'woocommerce_single_product_summary','woocommerce_template_single_meta',40 );
