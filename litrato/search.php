<?php
/**
 * The template for displaying search results pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#search-result
 *
 * @package litrato
 */

get_header();
?>

	<section id="primary" class="content-area">
		<main id="main" class="site-main">

		<?php if ( have_posts() ) : ?>

			<header class="page-header">
				<?php if ( get_header_image() ) : ?>
					<div class="post-thumbnail">
						<img
							class="archive-banner-image"
							data-src="<?php header_image(); ?>" 
							width="<?php echo absint( get_custom_header()->width ); ?>" 
							height="<?php echo absint( get_custom_header()->height ); ?>" 
							alt="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" 
						/>
					</div>
				<?php endif; ?>

				<h1 class="page-title">
					<?php
					/* translators: %s: search query. */
					printf( esc_html__( 'Search Results for: %s', 'litrato' ), '<span>' . get_search_query() . '</span>' );
					?>
				</h1>
			</header><!-- .page-header -->

			<?php
				/* Start the Loop */
				$box_pattern = [1, 1, 2];
				$pattern_counter = 0;

				echo '<div class="container archive-container">';

				while ( have_posts() ) :
					the_post();

					/*
					* Include the Post-Type-specific template for the content.
					* If you want to override this in a child theme, then include a file
					* called content-___.php (where ___ is the Post Type name) and that will be used instead.
					*/

					if( $pattern_counter === count($box_pattern) ) {
						$box_pattern = array_reverse($box_pattern, false);
						$pattern_counter = 0;
					}

					echo '<div class="archive-post archive-box-'. $box_pattern[$pattern_counter] .'">';
						get_template_part( 'template-parts/content');
					echo '</div>';
					$pattern_counter++;

				endwhile;

				numeric_posts_nav();
				echo '</div>';

			else :

				get_template_part( 'template-parts/content', 'none' );

			endif;
			?>

		</main><!-- #main -->
	</section><!-- #primary -->

<?php
get_sidebar();
get_footer();
