<?php
/**
 * Template Name: Request Page
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package SH_Theme
 */
get_header(); ?>
	<div id="primary" class="content-sidebar-wrap">
		<main id="main" class="site-main" role="main">

			<?php
			while ( have_posts() ) : the_post();

				?>
				<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
					<?php if( $sh_option['display-pagetitlebar'] == '0' || empty( $sh_option['display-pagetitlebar'] )) : ?>
						<header class="entry-header">
							<?php the_title( '<h1 class="page-title">', '</h1>' ); ?>
						</header><!-- .entry-header -->
					<?php endif;?>

					<div class="entry-content">
						<?php
							the_content();
						?>
					</div><!-- .entry-content -->
					
				</article><!-- #post-## -->
				<?php

				// If comments are open or we have at least one comment, load up the comment template.
				if ( comments_open() || get_comments_number() ) :
					comments_template();
				endif;

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
