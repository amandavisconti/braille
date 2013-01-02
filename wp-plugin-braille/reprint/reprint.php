<?php

/*
Plugin Name: Reprint
Plugin URI: http://www.wordpress.org
Description: Takes post text bracketed by shortcode and reprints on screen with styling.
Version: 1.0
Author: Amanda Visconti (literaturegeek)
Author URI: http://literaturegeek.com
*/

// This begins the admin section of the code (setting up the basic Wordpress plugin framework, adding a dashboard menu item, and creating an empty settings config page)

// Pulls any CSS you've added to the css/reprint.css file into the head of the displayed page so can be applied to the shortcoded text
function avreprint_css() {
        echo '<link type="text/css" rel="stylesheet" href="' . plugins_url( 'css/reprint.css', __FILE__ ) . '" />' . "\n";
}

// Adds a menu item to the WP dashboard for the plugin
add_action( 'admin_menu', 'avreprint_menu' );

// As part of the menu item, add an options (settings config) page
function avreprint_menu() {
    add_options_page( 'avreprint Options', 'avreprint', 'manage_options', 'avreprint', 'avreprint_options' );
}

//  Check if you have the correct role to manage plugin options; reject if not.
function avreprint_options() {
    if ( !current_user_can( 'manage_options' ) )  {
        wp_die( __( 'You do not have sufficient permissions to access this page.' ) );
    }
}

// Creates the custom plugin settings menu
add_action('admin_menu', 'avreprint_create_menu');

function avreprint_create_menu() {

// Creates new top-level menu page
	add_menu_page('avreprint Plugin Settings', 'Reprint Settings', 'administrator', __FILE__, 'avreprint_settings_page',plugins_url('/images/icon.png', __FILE__));
}

function avreprint_settings_page() {
// Sets appearance of settings page with a simple, non-functioning "submit" form
// TO DO: edit form to allow settings config
echo '<div class="wrap">
	<h2>Reprint Plugin Options</h2>
	<form method="post" action="options.php">
  		<p>Option config will appear here.</p>
    	    	<?php submit_button(); ?>
	</form>
</div>';
}

// The admin code section ends here. The main plugin function code begins.

// Takes text wrapped in [reprint] shortcode and reprints it somewhere on screen (determined by styling in css/reprint.css)

function getavreprint( $atts, $content = null ) {
// Wraps in CSS class to style
		$content = wpautop(trim($content));
        return '<div class="avreprint">'. do_shortcode($content) .'</div>';
}

// Creates [reprint][/reprint] shortcode
add_shortcode('reprint', 'getavreprint');

// Adds the CSS file to the header when the page loads
add_action('wp_head', 'avreprint_css');

// TO DO: allow uninstall

?>