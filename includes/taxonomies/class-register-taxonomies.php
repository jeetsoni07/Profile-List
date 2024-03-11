<?php
/**
 * Taxonomies Registration
 *
 * This file contains the Register_Taxonomies class, which is responsible for registering custom taxonomies.
 *
 * @package    ProfileLists
 * @subpackage Includes\Taxonomies
 * @since      1.0.0
 */

namespace ProfileLists\Includes;

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Class Register_Taxonomies
 *
 * This class registers custom taxonomies.
 *
 * @package ProfileLists\Includes
 */
class Register_Taxonomies {

	/**
	 * The singleton instance of the class.
	 *
	 * @var ClassName|null $instance The singleton instance.
	 */
	private static $instance;

	/**
	 * Get the singleton instance of the Register_Taxonomies class.
	 *
	 * @return Register_Taxonomies The singleton instance.
	 */
	public static function get_instance() {
		if ( ! isset( self::$instance ) ) {
			self::$instance = new self();
		}
		return self::$instance;
	}

	/**
	 * Register_Taxonomies constructor.
	 */
	public function __construct() {
		add_action( 'init', array( $this, 'register_custom_taxonomies' ) );
	}

	/**
	 * Register custom taxonomies.
	 */
	public function register_custom_taxonomies() {

		// Register custom taxonomy for skills.
		register_taxonomy(
			'skills',
			'profile',
			array(
				'labels'       => array(
					'name'          => __( 'Skills' ),
					'singular_name' => __( 'Skill' ),
				),
				'hierarchical' => true,
				'public'       => true,
				'rewrite'      => array( 'slug' => 'skills' ),
			)
		);

		// Register custom taxonomy for education.
		register_taxonomy(
			'education',
			'profile',
			array(
				'labels'       => array(
					'name'          => __( 'Education' ),
					'singular_name' => __( 'Education' ),
				),
				'hierarchical' => true,
				'public'       => true,
				'rewrite'      => array( 'slug' => 'education' ),
			)
		);
	}
}

Register_Taxonomies::get_instance();
