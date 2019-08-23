<?php get_header(); ?>

<div id="home-featured-articles">
  <?php 
    $limit_post = 0;
    $printed_posts = [];

    if( have_posts() ) : while( have_posts() ) : the_post(); 
    if( $limit_post === 3 ) { break; };
  ?>
    <?php
      // Fetch Featured Background Image
      $bg_url_full = '';

      if ( has_post_thumbnail( get_the_ID() ) ) {
        $bg_url_full = wp_get_attachment_image_src( get_post_thumbnail_id( get_the_ID() ), 'large' );
      }
    ?>
    <article 
      id="post-<?php the_ID(); ?>"
      <?php post_class( (!$bg_url_full[0]) ? 'bg-pattern-' . ($limit_post + 1) : '' ); ?>
    >
      <?php
        // Print Featured Background Image
        if ( $bg_url_full[0] ) {
          echo '<img class="article-featured-image article-lazy" alt="'. esc_html__( get_the_title() ) .'" data-src="'. $bg_url_full[0] .'" />';
        }
      ?>

      <div class="article-inner">
        <?php 
          // date
          litrato_posted_on();

          // title
          echo '<h2 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" title="'. esc_html__( get_the_title() ) .'" rel="bookmark">'. esc_html__( wp_trim_words( get_the_title(), 10, '...') ) .'</a></h2>'; 

          // excerpt
          echo '<p class="entry-excerpt">'. wp_trim_words( get_the_excerpt(), 23, '...') .'</p>';

          // permalink
          echo '<a href="'. esc_url( get_the_permalink() ) .'" class="button">View Post</a>';
        ?>
      </div>
    </article><!-- #post-<?php the_ID(); ?> -->
  <?php 
    $limit_post++;
    array_push($printed_posts, get_the_ID());

    endwhile; wp_reset_postdata(); endif; 
  ?>
  
  <div class="home-bottom">
    <div class="container">
      <div id="home-footer">
        <?php litrato_display_social_media_links(); ?>
      
        <div class="home__site-info">
          <span><?php printf( esc_html__( '&copy; %s', 'litrato' ), get_bloginfo('name') ); ?></span> <?php litrato_footer_pages_links() ?>
        </div>
      </div>

      <div id="home-banner-nav" class="imgloaded">
        <?php 
        $btn_bg_fades = 1;
        foreach ($printed_posts as $post_id) : 
          $bg_url_small = wp_get_attachment_image_src( get_post_thumbnail_id( $post_id ), 'medium' );
          $bg_image = 'style="background-image: url('. $bg_url_small[0] .')"';
        ?>
          <div class="button-container">
            <button 
              class="thumbs-lazy <?php echo (!$bg_url_small[0]) ? 'btn-fade-'. $btn_bg_fades : ''; ?>" 
              data-id="<?php echo $post_id ?>" <?php echo ($bg_url_small[0]) ? $bg_image : '' ?> 
              aria-label="Post Link"
            >
              <span>
              <?php printf( esc_html__( '%s', 'litrato' ), wp_trim_words( get_the_title($post_id), 6, '..') ) ?>
              </span>
            </button>
          </div>
        <?php 
          $btn_bg_fades++;
        endforeach; ?>

          <div class="button-container">
            <a 
              href="<?php echo esc_url( site_url() ) . '/' . date('Y'); ?>" 
              class="button view-all"
              aria-label="View all blog post"
            >
              <svg xmlns="http://www.w3.org/2000/svg" width="37" height="21" viewBox="0 0 37 21">
                <g id="Group_4" data-name="Group 4" transform="translate(-1238 -721)">
                  <rect id="Rectangle_15" data-name="Rectangle 15" width="8" height="8" rx="2" transform="translate(1238 721)" fill="#fff"/>
                  <rect id="Rectangle_19" data-name="Rectangle 19" width="8" height="8" rx="2" transform="translate(1267 734)" fill="#fff"/>
                  <rect id="Rectangle_17" data-name="Rectangle 17" width="24" height="8" rx="2" transform="translate(1251 721)" fill="#fff"/>
                  <rect id="Rectangle_18" data-name="Rectangle 18" width="24" height="8" rx="2" transform="translate(1238 734)" fill="#fff"/>
                </g>
              </svg>
              <span>View All</span>
            </a>
          </div>
      </div>
    </div>
  </div>
  
</div>

<?php get_footer(); ?>