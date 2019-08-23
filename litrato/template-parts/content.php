<?php
/**
 * Template part for displaying posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package litrato
 */
?>

<?php 
	// Single Post: Banner Image 
	litrato_blog_post_banner_image() 
?>

<article id="post-<?php the_ID(); ?>" <?php post_class('main-content'); ?>>
	<?php if( !is_singular()) : ?>
		<!-- Archive Page: thumbnail buttons -->
		<a class="link-wrap" title="<?php echo esc_html__( get_the_title() ) ?>" href="<?php echo esc_url( get_permalink() ) ?>"></a>
	<?php else : ?>
		<!-- Single Post: banner lightbox button -->
		<?php litrato_blog_post_banner_image_toggle_lightbox_button() ?>
	<?php endif; ?>

	<header class="entry-header">
		<?php
		if ( is_singular() ) :
			the_title( '<h1 class="entry-title">', '</h1>' );
		else :
			echo '<h2 class="entry-title">' . wp_trim_words( get_the_title(), 18, '...') . '</h2>';
		endif;

		if ( 'post' === get_post_type() ) :
			?>
			<div class="entry-meta">
				<?php
				litrato_posted_on();
				litrato_posted_by();
				?>
			</div>
			<!-- .entry-meta -->
		<?php endif; ?>
	</header><!-- .entry-header -->

	<?php 
		if( !is_single() ) {
			litrato_post_thumbnail();
		}
	?>

	<div class="entry-content">
		<?php
		the_content( sprintf(
			wp_kses(
				/* translators: %s: Name of current post. Only visible to screen readers */
				__( 'Continue reading<span class="screen-reader-text"> "%s"</span>', 'litrato' ),
				array(
					'span' => array(
						'class' => array(),
					),
				)
			),
			get_the_title()
		) );

		wp_link_pages( array(
			'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'litrato' ),
			'after'  => '</div>',
		) );
		?>
	</div><!-- .entry-content -->

	<footer class="entry-footer">
		<?php litrato_entry_footer(); ?>
	</footer>
	<!-- .entry-footer -->
</article><!-- #post-<?php the_ID(); ?> -->