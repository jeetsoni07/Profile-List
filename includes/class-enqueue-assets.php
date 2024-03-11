<?php
/**
 * Enqueue Assets
 *
 * This file contains the Enqueue_Assets class, which is responsible for enqueueing frontend assets like CSS and JavaScript.
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
 * Class Enqueue_Assets
 *
 * This class is responsible for enqueueing frontend assets like CSS and JavaScript.
 *
 * @package ProfileLists\Includes
 */
class Enqueue_Assets {

	/**
	 * The singleton instance of the class.
	 *
	 * @var ClassName|null $instance The singleton instance.
	 */
	private static $instance;

	/**
	 * Get the singleton instance of the Enqueue_Assets class.
	 *
	 * @return Enqueue_Assets The singleton instance.
	 */
	public static function get_instance() {
		if ( ! isset( self::$instance ) ) {
			self::$instance = new self();
		}
		return self::$instance;
	}

	/**
	 * Enqueue_Assets constructor.
	 */
	private function __construct() {
		add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_frontend_assets' ) );
	}

	/**
	 * Enqueue frontend assets.
	 */
	public function enqueue_frontend_assets() {

		wp_register_style( 'profile-lists-style', plugin_dir_url( __FILE__ ) . '../assets/css/style.css', array(), '1.0.0' );
		wp_enqueue_style( 'profile-lists-style' );

		wp_register_style( 'chosen-css', 'https://cdnjs.cloudflare.com/ajax/libs/chosen/1.8.7/chosen.min.css', array(), '1.8.7' );
		wp_enqueue_style( 'chosen-css' );

		wp_register_script( 'chosen-script', 'https://cdnjs.cloudflare.com/ajax/libs/chosen/1.8.7/chosen.jquery.min.js', array( 'jquery' ), '1.8.7', true );
		wp_enqueue_script( 'chosen-script' );

		wp_register_script( 'profile-lists-script', plugin_dir_url( __FILE__ ) . '../assets/js/script.js', array( 'jquery' ), '1.0.0', true );
		wp_enqueue_script( 'profile-lists-script' );

		wp_localize_script(
			'profile-lists-script',
			'profile_lists_ajax',
			array(
				'ajaxurl' => admin_url( 'admin-ajax.php' ),
			)
		);
	}
}

// Instantiate the Enqueue_Assets class.
Enqueue_Assets::get_instance();
