<?php
/**
 * The template for displaying archive pages
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package SH_Theme
 */

get_header(); ?>
	<div id="primary" class="content-sidebar-wrap">
		<main id="main" class="site-main" role="main">

			<?php
			if ( have_posts() ) : ?>
				
				<?php
					if( $sh_option['display-pagetitlebar'] != '1' ) {
						echo '<h1 class="page-title">'. __('Readers asked','shtheme') . ' <i class="fa fa-angle-double-right"></i> ';
						single_term_title( );
						echo '</h1>';
					}
					the_archive_description( '<div class="archive-description">', '</div>' );
				?>

				<?php
				/* Start the Loop */

				echo '<div class="new-list box_post_list">';

				while ( have_posts() ) : the_post();
					$nguoigui = get_field('nguoigui');
					?>
					<article class="<?php echo implode( ' ', get_post_class( $class ) );?>">
						<a class="alignleft" href="<?php the_permalink();?>" title="<?php the_title();?>">
							<?php echo get_the_post_thumbnail( get_the_ID(), 'sh_thumb300x200' );?>
						</a>
						<h3><a title="<?php the_title();?>" href="<?php the_permalink();?>" ><?php the_title();?></a> - <?php echo __('Sender','shtheme').': '.$nguoigui ?></h3>
						<?php echo get_the_content_limit( 450 ,' ');?>
						<div class="clearfix"></div>
					</article>
					<?php

				endwhile;

				echo '</div>';

				shtheme_pagination();

			else :

				
			endif; ?>

		</main><!-- #main -->
		<?php //do_action( 'sh_after_content' );?>

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
						echo '<li><h3><a href="' .get_dm_link( $term_id,'topic' ). '">' .get_dm_name( $term_id,'topic' ). '</a> <span>('. $postsInCat .')</span></h3></li>';
					} 
					echo '</ul>';
				}
				?>
			</section>
		</aside>
	</div><!-- #primary -->
<?php
get_footer();
