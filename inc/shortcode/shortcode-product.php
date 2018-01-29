<?php
/**
 * Shortcode news
 *
 * @link 
 *
 * @package SH_Theme
 */

class sh_product_shortcode {

	public static $args;

	public function __construct() {

		add_shortcode( 'shproduct', array( $this, 'render' ) );

	}

	/**
	 * Render the shortcode
	 * @param  array $args	 Shortcode paramters
	 * @param  string $content Content between shortcode
	 * @return string		  HTML output
	 */
	function render( $atts, $content = '') {
		$html = '';

		extract( shortcode_atts( array(
			'posts_per_page'				=> '5',
			'categories'					=> '',
			'numcol'						=> '3',
		), $atts ) );

		$post_class = get_column_product($numcol);

		$args = array(
			'post_type' => 'product',
			'tax_query' => array(
				array(
					'taxonomy' 	=> 'product_cat',
					'field'     => 'id',
					'terms' 	=> $categories
				)
			),
			'posts_per_page'	=> $posts_per_page,
		);

		$the_query = new WP_Query( $args );

		// The Loop

		if ( $the_query->have_posts() ) {

			$html .= '<div class="sh-product-shortcode column-'. $numcol .'"><ul class="row list-products">';

			ob_start();

			while ( $the_query->have_posts() ) {

				$the_query->the_post();

				global $product;

				if ( empty( $product ) || ! $product->is_visible() ) {
					return;
				}
				?>
				<li <?php post_class($post_class); ?>>
					<div class="wrap-product">
						<?php
						/**
						 * woocommerce_before_shop_loop_item hook.
						 *
						 * @hooked woocommerce_template_loop_product_link_open - 10
						 */
						// do_action( 'woocommerce_before_shop_loop_item' );

						/**
						 * woocommerce_before_shop_loop_item_title hook.
						 *
						 * @hooked woocommerce_show_product_loop_sale_flash - 10
						 * @hooked woocommerce_template_loop_product_thumbnail - 10
						 */
						// do_action( 'woocommerce_before_shop_loop_item_title' );

						echo '<div class="image-product">';
							echo '<a class="img hover-zoom" data-tooltip="stickyzoom" data-img-full="'. wp_get_attachment_url(get_post_thumbnail_id( $post->ID,'full' )) .'" href="'. get_permalink( ) .'" title="'. get_the_title( ) .'">';
								echo woocommerce_get_product_thumbnail( );
							echo '</a>';
						echo '</div>';

						/**
						 * woocommerce_shop_loop_item_title hook.
						 *
						 * @hooked woocommerce_template_loop_product_title - 10
						 */
						do_action( 'woocommerce_shop_loop_item_title' );

						/**
						 * woocommerce_after_shop_loop_item_title hook.
						 *
						 * @hooked woocommerce_template_loop_rating - 5
						 * @hooked woocommerce_template_loop_price - 10
						 */
						do_action( 'woocommerce_after_shop_loop_item_title' );

						/**
						 * woocommerce_after_shop_loop_item hook.
						 *
						 * @hooked woocommerce_template_loop_product_link_close - 5
						 * @hooked woocommerce_template_loop_add_to_cart - 10
						 */
						do_action( 'woocommerce_after_shop_loop_item' );
						?>
					</div>
				</li>
				<?php

			}

			wp_reset_postdata();

			$html .= ob_get_contents();

			ob_end_clean();

			$html .= '</ul></div>';

		}

		return $html;
		
	}

}
new sh_product_shortcode();