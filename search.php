<?php
/**
 * The template for displaying search results pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#search-result
 *
 * @package SH_Theme
 */

get_header(); ?>

	<div id="primary" class="content-sidebar-wrap">
		<main id="main" class="site-main" role="main">

		<?php
		if ( have_posts() ) : ?>

				<h1 class="page-title"><?php printf( esc_html__( 'Search for keyword: %s', 'shtheme' ), '<span>' . get_search_query() . '</span>' ); ?></h1>

			<?php
			/* Start the Loop */
			echo '<div class="new-list">';

			while ( have_posts() ) : the_post();

				?>
				<article class="<?php echo implode( ' ', get_post_class( $class ) );?>">
					<a class="alignleft" href="<?php the_permalink();?>" title="<?php the_title();?>">
						<?php echo get_the_post_thumbnail( get_the_ID(), 'sh_thumb300x200' );?>
					</a>
					<h3><a title="<?php the_title();?>" href="<?php the_permalink();?>" ><?php the_title();?></a></h3>
					<?php echo get_the_content_limit( 400 ,' ');?>
					<div class="clearfix"></div>
					<div class="ps-meta-info">
					   <div class="ps-alignleft">
					   		<span><?php the_time('j F Y') ?></span><span class="ps-inline-sep">|</span>
					   		<?php echo get_the_category_list(', ');?>
					   </div>
					   <div class="ps-alignright">
					   		<a href="<?php the_permalink();?>" class="ps-read-more"><?php _e('Read more', 'shtheme');?></a>
					   	</div>
					</div>
				</article>
				<?php

			endwhile;

			echo '</div>';

			shtheme_pagination();

		else :

			get_template_part( 'template-parts/content', 'none' );

		endif; ?>

		</main><!-- #main -->

		<?php do_action( 'sh_after_content' );?>
		
	</div><!-- #primary -->

<?php
get_footer();
