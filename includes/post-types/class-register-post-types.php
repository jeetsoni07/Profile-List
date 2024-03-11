<?php
/**
 * Post Types Registration
 *
 * This file contains the Register_Post_Types class, which is responsible for registering custom post types.
 *
 * @package    ProfileLists
 * @subpackage Includes
 * @since      1.0.0
 */

namespace ProfileLists\Includes;

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Class Register_Post_Types
 *
 * This class registers custom post types.
 *
 * @package ProfileLists\Includes
 */
class Register_Post_Types {

	/**
	 * The singleton instance of the class.
	 *
	 * @var ClassName|null $instance The singleton instance.
	 */
	private static $instance;

	/**
	 * Get the singleton instance of the Register_Post_Types class.
	 *
	 * @return Register_Post_Types The singleton instance.
	 */
	public static function get_instance() {
		if ( ! isset( self::$instance ) ) {
			self::$instance = new self();
		}
		return self::$instance;
	}

	/**
	 * Register_Post_Types constructor.
	 */
	private function __construct() {
		add_action( 'init', array( $this, 'register_custom_post_type' ) );
	}

	/**
	 * Register custom post type.
	 */
	public function register_custom_post_type() {
		// Register custom post type.
		register_post_type(
			'profile',
			array(
				'labels'      => array(
					'name'          => __( 'Profiles' ),
					'singular_name' => __( 'Profile' ),
				),
				'public'      => true,
				'has_archive' => true,
				'menu_icon'   => 'dashicons-id',
				'rewrite'     => array( 'slug' => 'profiles' ),
			)
		);
	}
}

// Instantiate the Register_Post_Types class.
Register_Post_Types::get_instance();
