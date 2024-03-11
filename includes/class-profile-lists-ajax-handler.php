<?php
/**
 * Profile Filter Ajax Handler
 *
 * This file contains the Profile_Lists_AJAX_Handler class, which defines ajax for profile lists.
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

use ProfileLists\Includes\Profile_Lists_Shortcode;

/**
 * Class Profile_Lists_AJAX_Handler
 *
 * This class handles AJAX requests for filtering profile posts.
 *
 * @package ProfileLists\Includes
 */
class Profile_Lists_AJAX_Handler {

	/**
	 * The singleton instance of the class.
	 *
	 * @var ClassName|null $instance The singleton instance.
	 */
	private static $instance = null;

	/**
	 * Private constructor to prevent direct instantiation.
	 */
	private function __construct() {

		add_action( 'wp_ajax_profile_lists_filter_posts', array( $this, 'profile_lists_filter_posts' ) );
		add_action( 'wp_ajax_nopriv_profile_lists_filter_posts', array( $this, 'profile_lists_filter_posts' ) );
	}

	/**
	 * Get the single instance of the class.
	 *
	 * @return Profile_Lists_AJAX_Handler|null The single instance of the class.
	 */
	public static function get_instance() {
		if ( ! isset( self::$instance ) ) {
			self::$instance = new self();
		}
		return self::$instance;
	}

	/**
	 * AJAX handler function for filtering profile posts.
	 */
	public function profile_lists_filter_posts() {

		$nonce = isset( $_POST['nonce'] ) ? sanitize_text_field( wp_unslash( $_POST['nonce'] ) ) : '';
		if ( ! isset( $nonce ) || ! wp_verify_nonce( $nonce, 'profile_lists_nonce' ) ) {
			wp_send_json_error( 'Invalid nonce' );
		}

		$rating         = isset( $_POST['rating'] ) ? intval( $_POST['rating'] ) : 0;
		$jobs_completed = isset( $_POST['jobsCompleted'] ) ? intval( $_POST['jobsCompleted'] ) : 0;
		$experience     = isset( $_POST['experience'] ) ? intval( $_POST['experience'] ) : 0;
		$age            = isset( $_POST['age'] ) ? intval( $_POST['age'] ) : 0;
		$skills         = isset( $_POST['skills'] ) ? sanitize_text_field( wp_unslash( $_POST['skills'] ) ) : '';
		$education      = isset( $_POST['education'] ) ? sanitize_text_field( wp_unslash( $_POST['education'] ) ) : '';
		$title          = isset( $_POST['title'] ) ? sanitize_text_field( wp_unslash( $_POST['title'] ) ) : '';
		$short_val      = isset( $_POST['shortVal'] ) ? sanitize_text_field( wp_unslash( $_POST['shortVal'] ) ) : 'ASC';
		$offset         = isset( $_POST['offset'] ) ? absint( wp_unslash( $_POST['offset'] ) ) : 0;

		$args = array(
			'post_type'      => 'profile',
			'posts_per_page' => 5,
			'orderby'        => 'title',
			'offset'         => $offset,
		);

		if ( ! empty( $title ) ) {
			$args['s'] = $title;
		}

		if ( ! empty( $short_val ) ) {
			$args['order'] = $short_val;
		}

		$args['meta_query'] = array();

		if ( ! empty( $rating ) ) {
			$args['meta_query'][] = array(
				'key'     => 'profile_ratings',
				'value'   => $rating,
				'compare' => '=',
				'type'    => 'NUMERIC',
			);
		}

		if ( ! empty( $jobs_completed ) ) {
			$args['meta_query'][] = array(
				'key'     => 'profile_jobs_completed',
				'value'   => $jobs_completed,
				'compare' => '=',
				'type'    => 'NUMERIC',
			);
		}

		if ( ! empty( $experience ) ) {
			$args['meta_query'][] = array(
				'key'     => 'profile_years_of_experience',
				'value'   => $experience,
				'compare' => '=',
				'type'    => 'NUMERIC',
			);
		}

		if ( ! empty( $age ) ) {
			$args['meta_query'][] = array(
				'key'     => 'profile_age',
				'value'   => $age,
				'compare' => '=',
				'type'    => 'NUMERIC',
			);
		}
		$args['meta_query']['relation'] = 'OR';

		$args['tax_query'] = array();

		if ( ! empty( $skills ) ) {
			$args['tax_query'][] = array(
				'taxonomy' => 'skills',
				'field'    => 'slug',
				'terms'    => $skills,
			);
		}

		if ( ! empty( $education ) ) {
			$args['tax_query'][] = array(
				'taxonomy' => 'education',
				'field'    => 'slug',
				'terms'    => $education,
			);
		}
		$args['tax_query']['relation'] = 'OR';

		$posts_query = new \WP_Query( $args );
		ob_start();

		$table_html = ProfileTable::get_profile_table_html( $posts_query );
		echo $table_html;

		wp_reset_postdata();
		$response = ob_get_clean();
		wp_send_json_success( $response );
	}
}

Profile_Lists_AJAX_Handler::get_instance();
