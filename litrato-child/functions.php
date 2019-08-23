<?php
function hook_css_child_theme() {
	$critical_css = file_get_contents( get_stylesheet_directory() . '/style.css' );
	echo '<style type="text/css">' . $critical_css . '</style>';
}

add_action('wp_head','hook_css_child_theme', 40);