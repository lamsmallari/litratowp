<?php
/**
 * Custom template tags for this theme
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
 * @package litrato
 */

if ( ! function_exists( 'litrato_posted_on' ) ) :
	/**
	 * Prints HTML with meta information for the current post-date/time.
	 */
	function litrato_posted_on() {
		$time_string = '<time class="entry-date published updated" datetime="%1$s">%2$s</time>';
		if ( get_the_time( 'U' ) !== get_the_modified_time( 'U' ) ) {
			$time_string = '<time class="entry-date published" datetime="%1$s">%2$s</time><time class="updated" datetime="%3$s">%4$s</time>';
		}

		$time_string = sprintf( $time_string,
			esc_attr( get_the_date( DATE_W3C ) ),
			esc_html( get_the_date() ),
			esc_attr( get_the_modified_date( DATE_W3C ) ),
			esc_html( get_the_modified_date() )
		);

		$posted_on = sprintf(
			/* translators: %s: post date. */
			'<span>' . esc_html_x( 'Posted on %s', 'post date', 'litrato' ),
			'</span><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">' . $time_string . '</a>'
		);

		echo '<span class="posted-on">' . $posted_on . '</span>'; // WPCS: XSS OK.

	}
endif;

if ( ! function_exists( 'litrato_posted_by' ) ) :
	/**
	 * Prints HTML with meta information for the current author.
	 */
	function litrato_posted_by() {
		$byline = sprintf(
			/* translators: %s: post author. */
			esc_html_x( 'by %s', 'post author', 'litrato' ),
			'<span class="author vcard"><a class="url fn n" href="' . esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ) . '">' . esc_html( get_the_author() ) . '</a></span>'
		);

		echo '<span class="byline"> ' . $byline . '</span>'; // WPCS: XSS OK.

	}
endif;

if ( ! function_exists( 'litrato_entry_footer' ) ) :
	/**
	 * Prints HTML with meta information for the categories, tags and comments.
	 */
	function litrato_entry_footer() {
		// Hide category and tag text for pages.
		if ( 'post' === get_post_type() ) {
			/* translators: used between list items, there is a space after the comma */
			$categories_list = get_the_category_list( esc_html__( ' ', 'litrato' ) );
			if ( $categories_list ) {
				/* translators: 1: list of categories. */
				printf( '<span class="cat-links"><span>' . esc_html__( 'Posted in', 'litrato' ) . ' </span> ' . esc_html__( '%1$s', 'litrato' ) . '</span>', $categories_list ); // WPCS: XSS OK.
			}

			/* translators: used between list items, there is a space after the comma */
			$tags_list = get_the_tag_list( '', esc_html_x( ' ', 'list item separator', 'litrato' ) );
			if ( $tags_list ) {
				/* translators: 1: list of tags. */
				printf( '<span class="tags-links"><span>' . esc_html__( 'Tagged', 'litrato' ) . ' </span> ' . esc_html__( '%1$s', 'litrato' ) . '</span>', $tags_list ); // WPCS: XSS OK.
			}
		}

		if ( ! is_single() && ! post_password_required() && ( comments_open() || get_comments_number() ) ) {
			echo '<span class="comments-link">';
			comments_popup_link(
				sprintf(
					wp_kses(
						/* translators: %s: post title */
						__( 'Leave a Comment<span class="screen-reader-text"> on %s</span>', 'litrato' ),
						array(
							'span' => array(
								'class' => array(),
							),
						)
					),
					get_the_title()
				)
			);
			echo '</span>';
		}

		edit_post_link(
			sprintf(
				wp_kses(
					/* translators: %s: Name of current post. Only visible to screen readers */
					__( 'Edit <span class="screen-reader-text">%s</span>', 'litrato' ),
					array(
						'span' => array(
							'class' => array(),
						),
					)
				),
				get_the_title()
			),
			'<span class="edit-link">',
			'</span>'
		);
	}
endif;

if ( ! function_exists( 'litrato_post_thumbnail' ) ) :
	/**
	 * Displays an optional post thumbnail.
	 *
	 * Wraps the post thumbnail in an anchor element on index views, or a div
	 * element when on single views.
	 */
	function litrato_post_thumbnail() {
		if ( post_password_required() || is_attachment() || ! has_post_thumbnail() ) {
			return;
		}

		if ( is_singular() ) :
			?>

			<div class="post-thumbnail">
				<?php 
				the_post_thumbnail(
					'post-thumbnail', 
					array(
						'class' => 'featured-image-full',
						'title' => 'Feature image'
					)
				); ?>
			</div><!-- .post-thumbnail -->

		<?php else : ?>

		<div class="post-thumbnail" aria-hidden="true" tabindex="-1">
			<?php
			the_post_thumbnail( 'medium_large', array(
				'alt' => the_title_attribute( array(
					'echo' => false,
				) ),
			) );
			?>
		</div>

		<?php
		endif; // End is_singular().
	}
endif;

if ( ! function_exists( 'litrato_display_social_media_links' ) ) :
	/**
	 * Prints Social Media Links from Theme Settings
	 * 
	 * @param string $wrapper_class_name wrapper class name
	 */
	function litrato_display_social_media_links( $wrapper_class_name = 'social-media-icons') {
		echo '<ul class="theme-settings-social-links '. $wrapper_class_name .'">';
      
		if(get_option('facebook')) {
			echo '<li><a target="_blank" rel="noopener" aria-label="facebook" title="facebook" href="'. get_option('facebook') .'">'.
				file_get_contents( get_template_directory_uri() . '/images/facebook.svg' )
			.'</a></li>';
		};
	
		if(get_option('twitter')) {
			echo '<li><a target="_blank" rel="noopener" aria-label="twitter" title="twitter" href="'. get_option('twitter') .'">'.
				file_get_contents( get_template_directory_uri() . '/images/twitter.svg' )
			.'</a></li>';
		};
	
		if(get_option('instagram')) {
			echo '<li><a target="_blank" rel="noopener" aria-label="instagram" title="instagram" href="'. get_option('instagram') .'">'.
				file_get_contents( get_template_directory_uri() . '/images/instagram.svg' )
			.'</a></li>';
		};
    echo '</ul>';
	}

endif;

if ( ! function_exists( 'litrato_footer_pages_links' ) ) :
	/**
	 * Prints banner image for a blog post
	 */
	function litrato_footer_pages_links() {
		$pages = get_option('pages');
		$html  = '';

		foreach ( $pages as $key => $value ) {
			$html .= ' - ' . '<a href="'. esc_url( __( get_the_permalink( $key ), 'litrato' ) )  .'">';
			$html .= get_the_title( $key );
			$html .= '</a>';
		}

		echo $html;
	}
endif;

if ( ! function_exists( 'litrato_blog_post_banner_image' ) ) :
	function litrato_blog_post_banner_image() {
		if( !is_single() ) {
			return;
		}
		
		echo '<div class="single-post-featured-image">';

		if ( has_post_thumbnail( get_the_ID() ) ) {
			$bg_url_full = wp_get_attachment_image_src( get_post_thumbnail_id( get_the_ID() ), 'full' );
			echo '<div class="post-thumbnail">';
			echo '<img class="featured-image-full" alt="'. get_the_title() .'" data-src="'. $bg_url_full[0] .'" />';
			echo '</div>';
		}

		echo '</div>';
		echo '<div class="banner-lightbox">';
			echo '<div class="banner-lightbox-container">';
				echo '<img src="'.$bg_url_full[0].'">';
			echo '</div>';
		echo '</div>';
	}
endif;

if ( ! function_exists( 'litrato_blog_post_banner_image_toggle_lightbox_button' ) ) :
	function litrato_blog_post_banner_image_toggle_lightbox_button() {
		if ( !is_single() && !has_post_thumbnail( get_the_ID() ) ) {
			return;
		}

		echo '<button class="show-image-banner-button">';
			echo '<div>';
			echo '<span><span>Show cover image</span></span> ';
			echo file_get_contents( get_template_directory_uri() . '/images/search-plus.svg' );
			echo '</div>';
		echo '</button>';
	}
endif;