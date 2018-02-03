<?php
/**
 * The template for displaying all single posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package SH_Theme
 */
get_header(); ?>
	<div id="primary" class="content-sidebar-wrap">
		<main id="main" class="site-main" role="main">
		<?php
		while ( have_posts() ) : the_post();
			global $sh_option;
			postview_set(get_the_ID());
			?>
			<article id="post-<?php the_ID(); ?>" <?php post_class(''); ?>>
				<?php if( $sh_option['display-pagetitlebar'] == '0' || empty( $sh_option['display-pagetitlebar'] )) : ?>
					<header class="entry-header">
						<?php
						if ( is_single() ) :
							the_title( '<h1 class="entry-title title-content">'.__('Readers asked','shtheme') . ' <i class="fa fa-angle-double-right"></i> ', '</h1>' );
						else :
							the_title( '<h2 class="entry-title title-content"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' );
						endif;
						?>
					</header><!-- .entry-header -->
				<?php endif;?>
				<div class="entry-meta">
					<span class="entry-time"><i class="fa fa-clock-o" aria-hidden="true"></i> <?php the_time('g:i a d/m/Y') ?></span>
					<span class="entry-view"><i class="fa fa-eye" aria-hidden="true"></i> <?php echo postview_get(get_the_ID());?></span>
				</div>
				<div class="entry-content">
					<?php
						the_content( sprintf(
							/* translators: %s: Name of current post. */
							wp_kses( __( 'Continue reading %s <span class="meta-nav">&rarr;</span>', 'shtheme' ), array( 'span' => array( 'class' => array() ) ) ),
							the_title( '<span class="screen-reader-text">"', '"</span>', false )
						) );
						echo get_the_tag_list('<p>Keywords: ',', ','</p>');
						// wp_link_pages( array(
						// 	'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'shtheme' ),
						// 	'after'  => '</div>',
						// ) );
					?>
					<?php if( $sh_option['display-sharepost'] == '1' ) : ?>
						<div class="socials-share">
							<div id="fb-root"></div>
							<script>(function(d, s, id) {
							  var js, fjs = d.getElementsByTagName(s)[0];
							  if (d.getElementById(id)) return;
							  js = d.createElement(s); js.id = id;
							  js.src = "//connect.facebook.net/vi_VN/sdk.js#xfbml=1&version=v2.10";
							  fjs.parentNode.insertBefore(js, fjs);
							}(document, 'script', 'facebook-jssdk'));</script>
							<div class="fb-like" data-href="<?php the_permalink();?>" data-layout="button" data-action="like" data-size="small" data-show-faces="false" data-share="true"></div>
							<!-- Đặt thẻ này vào phần đầu hoặc ngay trước thẻ đóng phần nội dung của bạn. -->
							<script src="https://apis.google.com/js/platform.js" async defer>{lang: 'vi'}</script>
							<!-- Đặt thẻ này vào nơi bạn muốn nút chia sẻ kết xuất. -->
							<div class="g-plus" data-action="share"></div>
							<script>window.twttr = (function(d, s, id) {
							var js, fjs = d.getElementsByTagName(s)[0],
							t = window.twttr || {};
							if (d.getElementById(id)) return t;
							js = d.createElement(s);
							js.id = id;
							js.src = "https://platform.twitter.com/widgets.js";
							fjs.parentNode.insertBefore(js, fjs);
							t._e = [];
							t.ready = function(f) {
							t._e.push(f);
							};
							return t;
							}(document, "script", "twitter-wjs"));</script>
							<a class="twitter-share-button" href="<?php the_permalink();?>">Tweet</a>
						</div>
					<?php endif;?>
					
				</div><!-- .entry-content -->
				<?php if( $sh_option['display-relatedpost'] == '1' ) : ?>
					<div class="related-posts">
						<h4 class="td-related-title"><span><?php _e( 'Related question', 'shtheme' );?></span></h4>
						<ul>
							<?php
							global $post;
							$category = wp_get_object_terms( 
								$post->ID,
								'topic',
								array(
									'orderby' 	=> 'term_group', 
									'order' 	=> 'DESC'
								)
							);
							$the_query = new WP_Query( array(
								'post_type' 		=> 'question',
			                    'tax_query' 		=> array(
			                        array(
			                            'taxonomy' 	=> 'topic',
			                            'field' 	=> 'id',
			                            'terms' 	=> end( $category )->term_id,
			                        )
			                    ),
					            'showposts' 		=> 6,
					            'post__not_in' 		=> array( $post->ID ),
					        ));
					        if( $the_query->have_posts() ) :
						        while( $the_query->have_posts() ) :
						        $the_query->the_post();
						        	echo '<li>';
						        		echo '<a href=" ' .get_the_permalink().' " title=" ' .get_the_title(). ' ">' .get_the_title(). '</a>';
						        	echo '</li>';
						        endwhile;
					        endif;
					        wp_reset_postdata();
					        ?>
				    	</ul>
					</div>
				<?php endif;?>
			</article><!-- #post-## -->
			<?php
		endwhile; // End of the loop.
		?>
		</main><!-- #main -->

		<aside class="sidebar sidebar-primary" itemscope="" itemtype="https://schema.org/WPSideBar">
			<section class="widget list_topic widget_list_posts">
				<h2 class="widget-title"><?php _e('Topic','shtheme');?></h2>
				<?php
				$taxonomy = 'topic';
				$tax_terms = get_terms(
					array(
				    	'taxonomy' 		=> 'topic',
				    	'hide_empty' 	=> false,
					) 
				);
				if( $tax_terms ) {
					echo '<ul class="list-post-item">';
					foreach($tax_terms as $term_single) {
						// var_dump($term_single);
						$term_id = $term_single->term_id;
						$postsInCat = get_term_by('id',$term_id,'topic');
						$postsInCat = $postsInCat->count;
						echo '<li><h3 class="aaa"><a href="' .get_dm_link( $term_id,'topic' ). '">' .get_dm_name( $term_id,'topic' ). '</a> <span>('. $postsInCat .')</span></h3></li>';
					} 
					echo '</ul>';
				}
				?>
			</section>
		</aside>

	</div><!-- #primary -->
<?php
get_footer();
