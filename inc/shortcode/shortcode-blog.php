<?php
/**
 * Shortcode Blog
 *
 * @link 
 *
 * @package SH_Theme
 */
class sh_blog_shortcode {
	public static $args;
	public function __construct() {
		add_shortcode( 'shblog', array( $this, 'render' ) );
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
			'style'   						=> '1',
			'posts_per_page'				=> '5',
			'categories'					=> '',
			'custom_text'					=> __( 'Read more', 'shtheme' ),
			'hide_category'					=> '1',
			'hide_viewmore'					=> '1',
			'hide_meta'						=> '1',
			'hide_thumb'					=> '1',
			'hide_desc'						=> '1'
		), $atts ) );
		$args = array(
			'post_type' => 'post',
			'tax_query' => array(
				array(
					'taxonomy' 	=> 'category',
					'field'     => 'id',
					'terms' 	=> $categories
				)
			),
			'posts_per_page'	=> $posts_per_page,
		);
		$the_query = new WP_Query( $args );
		// The Loop
		if ( $the_query->have_posts() ) {
			$html .= '<div class="sh-blog-shortcode style-'. $style .'">';
			switch ( $style ) {
				case '1':
					$html .= $this->sh_blog_style_1( $the_query, $atts );
					break;
				case '2':
					$html .= $this->sh_blog_style_2( $the_query, $atts );
					break;
				case '3':
					$html .= $this->sh_blog_style_3( $the_query, $atts );
					break;
				case '4':
					$html .= $this->sh_blog_style_4( $the_query, $atts );
					break;
				case '5':
					$html .= $this->sh_blog_style_5( $the_query, $atts );
					break;
				case '6':
					$html .= $this->sh_blog_style_6( $the_query, $atts );
					break;
				case '7':
					$html .= $this->sh_blog_style_7( $the_query, $atts );
					break;
				default:
					$html .= $this->sh_general_post_html( $the_query, $atts );
					break;
			}
			$html .= '</div>';
		}
		return $html;
	}
	/**
	 *
	 * Blog style 1
	 *
	 * @param  $the_query: Query get data; $atts: attribute
	 * @return $html: html of blog style 1
	 *
	 */
	function sh_blog_style_1 ( $the_query, $atts ) {
		$i = 0;
		$html = '';
		$image_size = 'sh_thumb300x200';
		$html .= '<div class="row">';
		while ( $the_query->have_posts() ) { $the_query->the_post(); $i++;
			$post_class = array( 'element', 'hentry', 'post-item' );
			$atts['hide_category'] 		= '0';
			$post_class[] 				= 'col-md-12';
			$html .= $this->sh_general_post_html( $post_class, $atts, $image_size );
		}
		wp_reset_postdata();
		$html .= '</div>';
		return $html;
	}
	/**
	 *
	 * Blog style 2
	 *
	 * @param  $the_query: Query get data; $atts: attribute
	 * @return $html: html of blog style 2
	 *
	 */
	function sh_blog_style_2 ( $the_query, $atts ) {
		extract( shortcode_atts( array(
			'style'   						=> '2',
			'posts_per_page'				=> '10',
		), $atts ) );
		$i = 0;
		$html = '';
		$image_size = 'sh_thumb300x200';
		$html .= '<div class="row">';
		while ( $the_query->have_posts() ) { $the_query->the_post(); $i++;
			$post_class = array( 'element', 'hentry', 'post-item' );
			$atts['hide_category'] 		= '0';
			$post_class[] 				= 'col-sm-6';
			$html .= $this->sh_general_post_html( $post_class, $atts, $image_size );
		}
		wp_reset_postdata();
		$html .= '</div>';
		return $html;
	}
	/**
	 *
	 * Blog style 3
	 *
	 * @param  $the_query: Query get data; $atts: attribute
	 * @return $html: html of blog style 3
	 *
	 */
	function sh_blog_style_3 ( $the_query, $atts ) {
		extract( shortcode_atts( array(
			'style'   						=> '3',
			'posts_per_page'				=> '10',
		), $atts ) );
		$i = 0;
		$html = '';
		$image_size = 'sh_thumb300x200';
		$html .= '<div class="row">';
		while ( $the_query->have_posts() ) { $the_query->the_post(); $i++;
			$post_class = array( 'element', 'hentry', 'post-item' );
			$atts['hide_category'] 		= '0';
			$post_class[] 				= 'col-md-4 col-sm-6 col-xs-6';
			$html .= $this->sh_general_post_html( $post_class, $atts, $image_size );
		}
		wp_reset_postdata();
		$html .= '</div>';
		return $html;
	}
	/**
	 *
	 * Blog style 4
	 *
	 * @param  $the_query: Query get data; $atts: attribute
	 * @return $html: html of blog style 4
	 *
	 */
	function sh_blog_style_4 ( $the_query, $atts ) {
		extract( shortcode_atts( array(
			'style'   						=> '4',
			'posts_per_page'				=> '10',
		), $atts ) );
		$i = 0;
		$html = '';
		$image_size = 'sh_thumb300x200';
		$html .= '<div class="row">';
		while ( $the_query->have_posts() ) { $the_query->the_post(); $i++;
			$post_class = array( 'element', 'hentry', 'post-item' );
			$atts['hide_category'] 		= '0';
			$post_class[] 				= 'col-md-3 col-sm-6 col-xs-6';
			$html .= $this->sh_general_post_html( $post_class, $atts, $image_size );
		}
		wp_reset_postdata();
		$html .= '</div>';
		return $html;
	}
	/**
	 *
	 * Blog style 5
	 *
	 * @param  $the_query: Query get data; $atts: attribute
	 * @return $html: html of blog style 5
	 *
	 */
	function sh_blog_style_5 ( $the_query, $atts ) {
		extract( shortcode_atts( array(
			'style'   						=> '5',
			'posts_per_page'				=> '10',
		), $atts ) );
		$i = 0;
		$html = '';
		$image_size = 'sh_thumb300x200';
		$html .= '<div class="row">';
		while ( $the_query->have_posts() ) { $the_query->the_post(); $i++;
			$post_class = array( 'element', 'hentry', 'post-item' );
			$atts['hide_category'] 		= '0';
			$post_class[] 				= 'col-md-6';
			$html .= $this->sh_general_post_html( $post_class, $atts, $image_size );
		}
		wp_reset_postdata();
		$html .= '</div>';
		return $html;
	}
	/**
	 *
	 * Blog style 6
	 *
	 * @param  $the_query: Query get data; $atts: attribute
	 * @return $html: html of blog style 6
	 *
	 */
	function sh_blog_style_6 ( $the_query, $atts ) {
		extract( shortcode_atts( array(
			'style'   						=> '6',
			'posts_per_page'				=> '10',
		), $atts ) );
		$i = 0;
		$html = '';
		$image_size = 'sh_thumb300x200';
		$html .= '<div class="row">';
		while ( $the_query->have_posts() ) { $the_query->the_post(); $i++;
			$post_class = array( 'element', 'hentry', 'post-item' );
			$atts['hide_meta'] 					= '1';
			$atts['hide_viewmore'] 				= '0';
			if ( $i == 1 ) {
				$atts['hide_category'] 			= '0';
				$image_size 					= 'sh_thumb410x270';
				$html .= '<div class="col-md-6 first-element-layout">';
				$html .= $this->sh_general_post_html( $post_class, $atts, $image_size );
				$html .= '</div>';
				if( $posts_per_page > 1 ) {
					$html .= '<div class="col-md-6 second-element-layout">';
				}
			} else {
				$image_size 					= 'thumbnail';
				$atts['hide_category'] 			= '0';
				$atts['hide_desc'] 				= '0';
				$html .= $this->sh_general_post_html( $post_class, $atts, $image_size );
			}
			if ( $i == count( $the_query->posts ) ) {
				$html .= '</div>';
			}
		}
		wp_reset_postdata();
		$html .= '</div>';
		return $html;
	}
	/**
	 *
	 * Blog style 7
	 *
	 * @param  $the_query: Query get data; $atts: attribute
	 * @return $html: html of blog style 7
	 *
	 */
	function sh_blog_style_7 ( $the_query, $atts ) {
		extract( shortcode_atts( array(
			'style'   						=> '7',
			'posts_per_page'				=> '10',
		), $atts ) );
		$i = 0;
		$html = '';
		$image_size = 'sh_thumb300x200';
		$html .= '<div class="row">';
		while ( $the_query->have_posts() ) { $the_query->the_post(); $i++;
			$post_class = array( 'element', 'hentry', 'post-item' );
			$atts['hide_viewmore']				= '0';
			$atts['hide_meta'] 					= '1';
			if ( $i == 1 ) {
				$atts['hide_category'] 			= '0';
				$atts['titlefirst']				= '1';
				$image_size 					= 'sh_thumb200x120';
				$html .= '<div class="col-md-12 first-element-layout">';
				$html .= $this->sh_general_post_html( $post_class, $atts, $image_size );
				$html .= '</div>';
				if( $posts_per_page > 1 ) {
					$html .= '<div class="col-md-12 second-element-layout"><div class="second_inner">';
				}
			} else {
				$atts['titlefirst']				= '0';
				$atts['hide_thumb'] 			= '0';
				$atts['hide_category'] 			= '0';
				$atts['hide_desc'] 				= '0';
				$html .= $this->sh_general_post_html( $post_class, $atts, $image_size );
			}
			if ( $i == count( $the_query->posts ) ) {
				$html .= '</div></div>';
			}
		}
		wp_reset_postdata();
		$html .= '</div>';
		return $html;
	}
	/**
	 *
	 * General post html
	 *
	 * @param  $post_class: class of post
	 * @return $html: html of post
	 *
	 */
	function sh_general_post_html ( $post_class = array(), $atts = array(), $image_size = 'sh_thumb300x200' ) {
		extract( shortcode_atts( array(
			'posts_per_page'				=> '5',
			'categories'					=> '',
			'custom_text'					=> __( 'Read more', 'shtheme' ),
			'hide_category'					=> '0',
			'hide_viewmore'					=> '0',
			'hide_meta'						=> '0',
			'hide_thumb'					=> '1',
			'hide_desc'						=> '1',
			'titlefirst'					=> '0',
		), $atts ) );
		$html = '';
		$html .= '<article id="post-'. get_the_ID() .'" class="'. implode( ' ', get_post_class( $post_class ) ) .'"><div class="post-inner">';
		// Check display thumb of post
		if ( $titlefirst == '1' ) {
			$html .= '<h3 class="entry-title"><a href="'. get_permalink() .'" title="'. get_the_title() .'">'. get_the_title() .'</a></h3>';
		}
		if ( $hide_thumb == '1' && has_post_thumbnail() ) :
			$html .= '<div class="entry-thumb">';
				$html .= '<a href="'. get_permalink() .'" title="'. get_the_title() .'">' . get_the_post_thumbnail( get_the_ID(), $image_size ) . '</a>';
			$html .= '</div>';
		endif;
		$html .= '<div class="entry-content">';
			// Check display category
			if ( $hide_category == '1' ) {
				$categories = wp_get_post_categories( get_the_ID() );
				if ( count( $categories ) > 0 ) {
					$html .= '<div class="entry-cat">';
					foreach ( $categories as $key => $cat_id ) {
						$category = get_category( $cat_id );
						if ( $key == ( count( $categories ) - 1 ) ) {
							$html .= '<a href="'. get_term_link( $category ) .'" title="'. $category->name .'">'. $category->name .'</a>';	
						} else {
							$html .= '<a href="'. get_term_link( $category ) .'" title="'. $category->name .'">'. $category->name .'</a>, ';
						}
					}
					$html .= '</div>';
				}
			}
			if ( $titlefirst == '0' ) {
				$html .= '<h3 class="entry-title"><a href="'. get_permalink() .'" title="'. get_the_title() .'">'. get_the_title() .'</a>';
					if ( $hide_meta == '1' ) {
						// $html .= '<div class="meta">';
							$html .= '<em class="date-time">'. get_the_time('(G:i d/m/Y)') .'</em>';
							// $comments_count = wp_count_comments( get_the_ID() );
							// $html .= '<span class="number-comment"><i class="fa fa-commenting-o" aria-hidden="true"></i>'. $comments_count->approved . ' ' . __( 'Comments', 'shtheme' ) . '</span>';
						// $html .= '</div>';
					}
				$html .= '</h3>';
			}
			// Metadata
			// Check display description
			if ( $hide_desc == '1' ) {
				$html .= '<div class="entry-description">'. get_the_content_limit('140',' ') .'</div>';
			}
			if ( $titlefirst == '1' && $hide_meta == '1' ) {
				// $html .= '<div class="meta">';
					$html .= '<em class="date-time">'. get_the_time('(G:i d/m/Y)') .'</em>';
					// $comments_count = wp_count_comments( get_the_ID() );
					// $html .= '<span class="number-comment"><i class="fa fa-commenting-o" aria-hidden="true"></i>'. $comments_count->approved . ' ' . __( 'Comments', 'shtheme' ) . '</span>';
				// $html .= '</div>';
			}
			// Check display view more button
			if ( $hide_viewmore == '1' ) {
				$html .= '<a href="'. get_permalink() .'" title="'. get_the_title() .'" class="view-more">'. __( 'View more', 'shtheme' ) .' <i class="fa fa-arrow-circle-right" aria-hidden="true"></i></a>';
			}
		$html .= '</div>';
		$html .= '</div></article>';
		return $html;
	}
}
new sh_blog_shortcode();