<?php 
// Theme settings add on menu
function custom_settings_add_menu() {
	add_menu_page( 
    'Theme Settings', 
    'Theme Settings', 
    'manage_options', 
    'custom-settings', 
    'custom_settings_page', 
    null, 
    99 
  );
}
add_action( 'admin_menu', 'custom_settings_add_menu' );

// Create Custom Global Settings
function custom_settings_page() { ?>
	<div class="wrap">
		<h1>Theme Settings</h1>
		<form method="post" action="options.php">
				<?php
						settings_fields( 'settings-group' );
						do_settings_sections( 'theme-options' );
						submit_button();
				?>
		</form>
	</div>
<?php }

// SETUP FIELDS

// Facebook Field
function setting_facebook() {
  echo '<input type="text" name="facebook" id="facebook" value="'. get_option( 'facebook' ) .'" />';
}

// Twitter Field
function setting_twitter() {
  echo '<input type="text" name="twitter" id="twitter" value="'. get_option( 'twitter' ) .'" />';
}

// GitHub Field
function setting_instagram() {
  echo '<input type="text" name="instagram" id="instagram" value="'. get_option( 'instagram' ) .'" />';
}

// Footer Page links
function footer_page_links() {

  $options = get_option( 'pages' );

  $html  = '';
  $pages = get_pages(); 

  foreach ( $pages as $page ) {
    $html .= '<div class="checkbox-set">';
      $html .= '<input 
                type="checkbox" 
                id="'. $page->ID .'" 
                name="pages['. $page->ID .']" 
                value="1"' . checked( 1, $options[ $page->ID ], false ) . 
              '/>';
      $html .= '<label for="'. $page->ID .'">'.$page->post_title.'</label>';
    $html .= '</div>';
  }

  echo $html;
}


// RENDER FIELDS in Custom Settings admin menu
function custom_settings_page_setup() {
  add_settings_section( 'socials', 'Social Media Links', null, 'theme-options' );
	add_settings_field( 'facebook', 'Facebook URL', 'setting_facebook', 'theme-options', 'socials' );
	add_settings_field( 'twitter', 'Twitter URL', 'setting_twitter', 'theme-options', 'socials' );
  add_settings_field( 'instagram', 'Instagram URL', 'setting_instagram', 'theme-options', 'socials' );

  add_settings_section( 'footer-page-links', 'Footer Settings', null, 'theme-options' );
  add_settings_field( 'pages', 'Footer Page Links', 'footer_page_links', 'theme-options', 'footer-page-links' );

  // register settings
  register_setting( 'settings-group', 'facebook', 'handle_sanitization_validation_escaping_text' );
  register_setting( 'settings-group', 'twitter', 'handle_sanitization_validation_escaping_text' );
  register_setting( 'settings-group', 'instagram', 'handle_sanitization_validation_escaping_text' );
  register_setting( 'settings-group', 'pages' );
  // register_setting( 'settings-group', 'swup_activation' );
}

add_action( 'admin_init', 'custom_settings_page_setup' );
// Custom settings ----- END -----


// Text Fields Sanitization
function handle_sanitization_validation_escaping_text($option)
{
  $option = sanitize_text_field($option);
  
  return $option;
}