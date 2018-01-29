<?php
/**
 * The main template file
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package SH_Theme
 */

global $sh_option;
get_header(); ?>
	<div id="primary" class="content-sidebar-wrap">
		<main id="main" class="site-main" role="main">

			<!-- ---------------------  --------------------- -->
			<div class="row">
				<div class="col-md-6">
					<div class="last_news">
						<?php
						$args = array(
		                    'post_type'             => 'post',
			                'posts_per_page'        => 1,
			                'ignore_sticky_posts'   => -1,
			                'orderby'               => 'date',
			                'order'                 => 'DESC',
		                );
		                $the_query = new WP_Query($args);
			            while($the_query->have_posts()):
			            $the_query->the_post();
			            ?>
			            	<div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
			            		<div class="entry-thumb">
									<a href="<?php echo get_permalink();?>" title="<?php echo get_the_title();?>">
										<?php echo get_the_post_thumbnail( get_the_ID(), 'sh_thumb410x270' );?>
									</a>
								</div>
			                    <h3>
			                        <a href="<?php the_permalink();?>" title="<?php the_title();?>">
			                            <?php the_title();?>
			                        </a>
			                    </h3>
			                    <?php the_content_limit('180',' ');?>
			                    <div class="text-right">
			                    	<em><a href="<?php echo get_permalink();?>" title="<?php echo get_the_title();?>">
										Xem tất cả <i class="fa fa-angle-double-right" aria-hidden="true"></i>
									</a></em>
			                    </div>
			                </div>
			            <?php
			            endwhile;
		            	wp_reset_postdata();
		            	?>
		            </div>
				</div>
				<div class="col-md-6">
					<div class="tab_news">
						<ul class="nav nav-tabs">
							<li class="active"><a data-toggle="tab" href="#latesthot"><?php _e( 'Latest news HOT', 'shtheme' );?></a></li>
							<li><a data-toggle="tab" href="#latest"><?php _e( 'Latest news', 'shtheme' );?></a></li>
							<li><a data-toggle="tab" href="#featured"><?php _e( 'Featured news', 'shtheme' );?></a></li>
						</ul>

						<div class="tab-content">
							<div id="latesthot" class="element_tab tab-pane fade in active">
								<?php
								function filter_where( $where = '' ) {
					                global $postdate;
					                $where .= " AND post_date > '" . date('Y-m-d', strtotime('-'.$postdate.' days')) . "'";
					                return $where;
					            }
					            add_filter( 'posts_where', 'filter_where' );
								$args = array(
				                    'post_type'             => 'post',
					                'posts_per_page'        => 10,
					                'meta_key'              => 'postview_number',
					                'orderby'               => 'date',
					                'order'                 => 'DESC',
					                'ignore_sticky_posts'   => -1,
				                );
				                $the_query = new WP_Query($args);
					            remove_filter( 'posts_where', 'filter_where' );
					            while($the_query->have_posts()):
					            $the_query->the_post();
					            $new_news = get_field('new_news');
					            if( $new_news ) {
					            	$class = 'element new_news';
					            } else {
					            	$class = 'element ';
					            }
					            ?>
					            	<div id="post-<?php the_ID(); ?>" <?php post_class($class); ?>>
					                    <h3>
					                        <a href="<?php the_permalink();?>" title="<?php the_title();?>">
					                            <?php the_title();?>
					                        </a>
					                    </h3>
					                </div>
					            <?php
					            endwhile;
				            	wp_reset_postdata();
				                ?>
							</div>
							<div id="latest" class="element_tab tab-pane fade">
								<?php
								$args = array(
				                    'post_type'             => 'post',
					                'posts_per_page'        => 10,
					                'orderby'               => 'date',
					                'order'                 => 'DESC',
					                'ignore_sticky_posts'   => -1,
				                );
				                $the_query = new WP_Query($args);
					            remove_filter( 'posts_where', 'filter_where' );
					            while($the_query->have_posts()):
					            $the_query->the_post();
					            $new_news = get_field('new_news');
					            if( $new_news ) {
					            	$class = 'element new_news';
					            } else {
					            	$class = 'element ';
					            }
					            ?>
					            	<div id="post-<?php the_ID(); ?>" <?php post_class($class); ?>>
					                    <h3>
					                        <a href="<?php the_permalink();?>" title="<?php the_title();?>">
					                            <?php the_title();?>
					                        </a>
					                    </h3>
					                </div>
					            <?php
					            endwhile;
				            	wp_reset_postdata();
				            	?>
							</div>
							<div id="featured" class="element_tab tab-pane fade">
								<?php
								add_filter( 'posts_where', 'filter_where' );
								$args = array(
				                    'post_type'             => 'post',
					                'posts_per_page'        => 10,
					                'meta_key'              => 'postview_number',
					                'orderby'               => 'meta_value_num',
					                'order'                 => 'DESC',
					                'ignore_sticky_posts'   => -1,
				                );
				                $the_query = new WP_Query($args);
					            remove_filter( 'posts_where', 'filter_where' );
					            while($the_query->have_posts()):
					            $the_query->the_post();
					            $new_news = get_field('new_news');
					            if( $new_news ) {
					            	$class = 'element new_news';
					            } else {
					            	$class = 'element ';
					            }
					            ?>
					            	<div id="post-<?php the_ID(); ?>" <?php post_class($class); ?>>
					                    <h3>
					                        <a href="<?php the_permalink();?>" title="<?php the_title();?>">
					                            <?php the_title();?>
					                        </a>
					                    </h3>
					                </div>
					            <?php
					            endwhile;
				            	wp_reset_postdata();
				            	?>
							</div>
						</div>
					</div>
				</div>
			</div>
			

			<!-- --------------------- News --------------------- -->
			<?php
			if( $sh_option['number_news'] ) {
				$number_news = $sh_option['number_news'];
			}
			if( $sh_option['type_layout'] ) {
				$type_layout = $sh_option['type_layout'];
			}
			if( $sh_option['list_cat_post'] ) {
				$list_cat_post = $sh_option['list_cat_post'];
				echo '<div class="news-wrap row">';
					foreach ($list_cat_post as $key => $idpost) {
						echo '<div class="col-md-6">';
							echo '<h2 class="heading"><a href="'. get_category_link( $idpost ) .'">'. get_cat_name( $idpost ) .'</a></h2>';
							echo do_shortcode('[shblog posts_per_page="' . $number_news . '" categories="' . $idpost . '" style="' . $type_layout . '"]');
						echo '</div>';
					}
				echo '</div>';
			}
			?>

			<!-- --------------------- News --------------------- -->
			<?php
			if( $sh_option['number_news2'] ) {
				$number_news2 = $sh_option['number_news2'];
			}
			if( $sh_option['type_layout2'] ) {
				$type_layout2 = $sh_option['type_layout2'];
			}
			if( $sh_option['list_cat_post2'] ) {
				$list_cat_post2 = $sh_option['list_cat_post2'];
				echo '<div class="news-wrap news-wrap2">';
					foreach ($list_cat_post2 as $key => $idpost) {
						echo '<h2 class="heading"><a href="'. get_category_link( $idpost ) .'">'. get_cat_name( $idpost ) .'</a></h2>';
						echo do_shortcode('[shblog posts_per_page="' . $number_news2 . '" categories="' . $idpost . '" style="' . $type_layout2 . '"]');
					}
				echo '</div>';
			}
			?>

			
			<?php
			$question = $sh_option['opt-quicklink'];
			if( $question ) {
				echo '<div class="quick-links">';
				foreach ($question as $key => $value) {
					?>
					<div class="qlink">
						<a href="<?php echo $value['url'];?>" class="img" title="<?php echo $value['title'].' '.$value['description'];?>">
							<img src="<?php echo $value['image'];?>"/>
						</a>
					</div>
					<?php
				}
				echo '</div>';
			}
			?>
			

		</main><!-- #main -->

		<?php do_action( 'sh_after_content' );?>

	</div><!-- #primary -->
	
<?php
get_footer();