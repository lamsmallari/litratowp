<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package litrato
 */

?>

	</div><!-- #content -->

	<footer id="colophon" class="site-footer">
		<div class="container">
			<div class="site-info">
			<?php 
				if ( function_exists( 'the_custom_logo' ) ) {
					if (has_custom_logo()) {
						the_custom_logo();
					} else {
						echo '<a href="'. site_url() .'" class="custom-logo-link svg-logo" rel="home">
									<img src="'. get_template_directory_uri() . '/images/logo-png.png' .'" alt="Litrato Logo">
									</a>';
					}
				}
			?>

				<?php 
					// Social Media Links
					litrato_display_social_media_links();
				?>

				<div class="footer-element">
					<span><?php printf( esc_html__( '&copy; %s', 'litrato' ), get_bloginfo('name') ); ?></span> 
					<?php litrato_footer_pages_links() ?>
				</div>

				<div class="footer-element">
					<?php
						/* translators: %s: CMS name, i.e. WordPress. */
						printf( esc_html__( 'Proudly powered by %1$s and %2$s', 'litrato' ), '<a href="https://wordpress.org/">WordPress</a>', '<a href="http://underscores.me/">Underscores.me</a>' );
					?>
				</div>

				<div class="footer-element">
					<?php 
						printf( esc_html__( 'Theme Litrato developed by %s' ), '<a href="https://github.com/lamsmallari" title="Visit Github my profile">lamsmallari</a>' )
					?>
				</div>

			</div><!-- .site-info -->
		</div>
	</footer><!-- #colophon -->
	
</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>
