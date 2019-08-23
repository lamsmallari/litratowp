<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package litrato
 */

?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="https://gmpg.org/xfn/11">
	<meta name="description" content="<?php if ( is_single() ) {  
   echo wp_trim_words( get_the_excerpt(), 23, '...');  
   } else {  
      bloginfo('name'); echo " - "; bloginfo('description'); 
   }  
	 ?>" />
	 
	<?php wp_head(); ?>
	<?php
		if( get_option('site_icon') == false ) :
	?>
		<link rel="shortcut icon" href="<?php echo get_stylesheet_directory_uri() ?>/images/favicon.ico" />
	<?php endif; ?>
</head>

<body <?php body_class(); ?>>
<div id="page" class="site">
	<a class="skip-link screen-reader-text" href="#content"><?php esc_html_e( 'Skip to content', 'litrato' ); ?></a>

	<header id="masthead" class="site-header">
		<div class="container">
			<div class="flex-row">
				<div class="flex-small site-branding">
					<?php 
						if ( function_exists( 'the_custom_logo' ) ) {
							if (has_custom_logo()) {
								the_custom_logo();
							} else {
								echo '<a href="'. site_url() .'" class="custom-logo-link" rel="home">
											'. file_get_contents( get_template_directory_uri() . '/images/logo-colored.svg' ) .'
											</a>';
							}
						}
					?>
				</div><!-- .site-branding -->

				<div class="flex-small site-navigation-container">
					<nav id="site-navigation" class="main-navigation text-right">
						<?php
							wp_nav_menu( array(
								'theme_location' => 'menu-1',
								'menu_id'        => 'primary-menu',
							) );
						?>
					</nav><!-- #site-navigation -->

					<a href="#my-menu" class="mobile-menu-navigation" aria-label="Mobile menu toggler">
						<span></span>
					</a>
				</div><!-- .site-navigation-container -->
				
				<?php
					wp_nav_menu( array(
						'theme_location' => 'menu-1',
						'menu_id'        => 'mobile-menu',
						'container_id'   => 'mobile-menu-container',
					) );
				?>
				
			</div>
		</div>
	</header><!-- #masthead -->

	<div id="content" class="site-content">
