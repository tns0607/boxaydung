<?php
/**
 * The template for displaying archive pages
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package SH_Theme
 */
$current_cat_id = get_query_var('cat');
get_header(); ?>

	<div id="primary" class="content-sidebar-wrap">
		<main id="main" class="site-main" role="main">
			
			<?php
			$args = array(
				'parent'                   => $current_cat_id,
				'hide_empty'               => 0,
				'taxonomy'                 => 'category'

			);
			$categories = get_categories($args);
		    if( $categories ) { 
		    	echo '<div class="row row-category-block">';
			    	foreach ( $categories as $vl ) { ?>
		    			<div class="col-md-12 col-xs-12 box-news">
		    				<h1 class="page-title"><a href="<?php echo get_category_link($vl->term_id);?>" ><?php echo get_cat_name($vl->term_id);?></a></h1>
							<div class="box-cat">
								<div class="new-list">
									<?php 
									$i = 0;
									while ( have_posts() ) : the_post(); $i++;
										if ( $i == 1 ) {
									?>
										<article class="<?php echo implode( ' ', get_post_class( $class ) );?>">
											<a class="alignleft" href="<?php the_permalink();?>" title="<?php the_title();?>">
												<?php echo get_the_post_thumbnail( get_the_ID(), 'sh_thumb300x200' );?>
											</a>
											<h3 class="aaaa"><a title="<?php the_title();?>" href="<?php the_permalink();?>" ><?php the_title();?></a> <span><?php the_time('(g:i d/m/Y)') ?></span></h3>
											<?php echo get_the_content_limit( 400 ,' ');?>
										</article>
									<?php } else { ?>
										<article class="post_style_2 <?php echo implode( ' ', get_post_class( $class ) );?>">
											<h3 class="aaaaaass"><a title="<?php the_title();?>" href="<?php the_permalink();?>" ><?php the_title();?></a> <span><?php the_time('(g:i d/m/Y)') ?></span></h3>
										</article>
									<?php } ?>
									<?php endwhile; ?>
								</div>
								<div class="xemtatca"><a title="<?php the_title();?>" href="<?php the_permalink();?>" >Xem tất cả <i class="fa fa-angle-double-right" aria-hidden="true"></i></a></div>
							</div>
						</div>
		    		<?php }
	    		echo '</div>';
		    } else {
		    	?> <h1 class="page-title"><?php echo single_term_title();?></h1> <?php
		    	echo '<div class="new-list box_post_list">';
					while ( have_posts() ) : the_post();
						?>
						<article class="<?php echo implode( ' ', get_post_class( $class ) );?>">
							<a class="alignleft" href="<?php the_permalink();?>" title="<?php the_title();?>">
								<?php echo get_the_post_thumbnail( get_the_ID(), 'sh_thumb300x200' );?>
							</a>
							<h3><a title="<?php the_title();?>" href="<?php the_permalink();?>" ><?php the_title();?></a></h3>
							<?php echo get_the_content_limit( 400 ,' ');?>
						</article>
						<?php
					endwhile;
				echo '</div>';

			shtheme_pagination();
		    }

    	?>

		</main><!-- #main -->

		<?php do_action( 'sh_after_content' );?>

	</div><!-- #primary -->

<?php
get_footer();
