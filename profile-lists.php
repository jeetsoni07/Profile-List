<?php
/**
 *
 * @package ProfileLists
 * @link    https://profile-lists.com
 * @since   1.0.0
 *
 * @wordpress-plugin
 * Plugin Name:       Profile Lists
 * Plugin URI:
 * Description:       This will adds a list of profiles.
 * Version:           1.0.1
 * Author:            Profile Lists INC
 * Author URI:        https://profile-lists.com
 * Text Domain:       profile-lists
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

require_once plugin_dir_path( __FILE__ ) . 'includes/class-profile-lists.php';
require_once plugin_dir_path( __FILE__ ) . 'includes/class-enqueue-assets.php';
require_once plugin_dir_path( __FILE__ ) . 'includes/post-types/class-register-post-types.php';
require_once plugin_dir_path( __FILE__ ) . 'includes/taxonomies/class-register-taxonomies.php';
require_once plugin_dir_path( __FILE__ ) . 'includes/class-meta-boxes.php';
require_once plugin_dir_path( __FILE__ ) . 'includes/public/class-profile-lists-shortcode.php';
require_once plugin_dir_path( __FILE__ ) . 'includes/public/class-profiletable.php';
require_once plugin_dir_path( __FILE__ ) . 'includes/class-meta-keys-constants.php';
require_once plugin_dir_path( __FILE__ ) . 'includes/class-profile-lists-ajax-handler.php';

use ProfileLists\Includes\Profile_Lists;

if ( class_exists( 'ProfileLists\Includes\Profile_Lists' ) ) {
	$profile_lists = new Profile_Lists();
}

function load_profile_lists_textdomain() {
    load_plugin_textdomain( 'profile-lists', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' );
}
add_action( 'plugins_loaded', 'load_profile_lists_textdomain' );
