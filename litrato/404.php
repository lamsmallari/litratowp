<?php
/**
 * The template for displaying 404 pages (not found)
 *
 * @link https://codex.wordpress.org/Creating_an_Error_404_Page
 *
 * @package litrato
 */

get_header();
?>

	<div id="primary" class="content-area error-404-template">
		<main id="main" class="site-main">
			<div class="not-found-text">
				<h1>404</h1>
				<p>"Not all who wander are lost" <br>— <em>J. R. R. Tolkien</em></p>
				<p>Return to <a href="<?php echo site_url() ?>"><strong>Home</strong></a></p>
			</div>
		</main><!-- #main -->
	</div><!-- #primary -->

<?php
get_footer();
