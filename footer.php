<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package SH_Theme
 */

do_action( 'sh_after_content_sidebar_wrap' );
?>
		</div>
	</div><!-- #content -->

	<div class="menu_footer hidden-sm hidden-xs">
		<div class="container">
			<nav id="site-navigation" class="secondary-navigation">
				<?php wp_nav_menu( array( 'theme_location' => 'menu-1', 'menu_id' => 'primary-menu' ) ); ?>
			</nav><!-- #site-navigation -->
		</div>
	</div>

	<footer id="footer" class="site-footer" itemscope itemtype="https://schema.org/WPFooter">
		
		<div class="footer-widgets">
			<div class="container">
				<div class="wrap">
					<div class="row">
						<?php do_action( 'sh_footer' );?>
					</div>
					<p class="text-right" id="copyright">Copyright @ CDMI       *     Thiết kế bởi:  <a href="http://thietkeweb3b.com/" target="_blank" rel="nofollow">3B Việt Nam</a></p>
				</div>
			</div>
		</div><!-- .footer-widgets -->
		<p id="back-top"><a href="#top" target="_blank"><span></span></a></p>
		
	</footer><!-- #colophon -->

	<?php do_action( 'sh_after_footer' );?>
	
</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>
