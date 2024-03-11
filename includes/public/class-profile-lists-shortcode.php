<?php
/**
 * Profile Lists Shortcode
 *
 * This file contains the Profile_Lists_Shortcode class, which defines a shortcode to display profiles in a table format.
 *
 * @package    ProfileLists
 * @subpackage Includes
 * @since      1.0.0
 */

namespace ProfileLists\Includes;

use ProfileLists\Includes\Meta_Keys_Constants;
use ProfileLists\Includes\ProfileTable;

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Class Profile_Lists_Shortcode
 *
 * This class defines a shortcode to display profiles in a table format.
 *
 * @package ProfileLists\Includes
 */
class Profile_Lists_Shortcode {

	/**
	 * The singleton instance of the class.
	 *
	 * @var ClassName|null $instance The singleton instance.
	 */
	private static $instance;

	/**
	 * Get the singleton instance of the Profile_Lists_Shortcode class.
	 *
	 * @return Profile_Lists_Shortcode The singleton instance.
	 */
	public static function get_instance() {
		if ( ! isset( self::$instance ) ) {
			self::$instance = new self();
		}
		return self::$instance;
	}

	/**
	 * Profile_Lists_Shortcode constructor.
	 */
	private function __construct() {
		add_shortcode( 'profile_lists', array( $this, 'profile_lists_shortcode' ) );
	}

	/**
	 * Callback function for the profile_lists shortcode.
	 *
	 * @return string The HTML output for the profile list table.
	 */
	public static function profile_lists_shortcode() {
		$dropdowns_html = self::get_filter_html();

		$table_html = self::get_profile_table_html();
		$pagination = self::get_profile_table_pagination();

		return $dropdowns_html . $table_html . $pagination;
	}

	/**
	 * Callback function for the get_filter_html.
	 *
	 * @return string The HTML output for the filter dropdown.
	 */
	private static function get_filter_html() {
		$nonce = wp_create_nonce( 'profile_lists_nonce' );

		$skills = get_terms(
			array(
				'taxonomy'   => 'skills',
				'hide_empty' => false,
			)
		);

		$educations = get_terms(
			array(
				'taxonomy'   => 'education',
				'hide_empty' => false,
			)
		);

		$skills_options = '<option value="">Select Skills</option>';
		foreach ( $skills as $skill ) {
			$skills_options .= '<option value="' . $skill->slug . '">' . $skill->name . '</option>';
		}

		$education_options = '<option value="">Select Education</option>';
		foreach ( $educations as $education ) {
			$education_options .= '<option value="' . $education->slug . '">' . $education->name . '</option>';
		}

		$output = '<div class="profile-lists-container">';

		$output .= '<div class="profile-lists-search">';
		$output .= '<div>Keyword</div>';
		$output .= '<input type="text" id="title" name="title" placeholder="Enter Title">';
		$output .= '</div>';
		$output .= '<input type="hidden" id="profile_lists_nonce" name="profile_lists_nonce" value="' . esc_attr( $nonce ) . '">';
		$output .= '<div class="profile-lists-dropdowns">';
		$output .= '<div>Skills</div><select id="skills-dropdown" name="skills[]" multiple>' . $skills_options . '</select>';
		$output .= '<div>Education</div><select id="education-dropdown" name="education[]" multiple>' . $education_options . '</select>';
		$output .= '</div>';

		$output .= '<div class="profile-lists-filters">';
		$output .= '<div>Years of experience </div>';
		$output .= '<input type="number" id="experience" name="age" min="0">';
		$output .= '<div>No of jobs competed</div>';
		$output .= '<input type="number" id="jobs-completed-select" name="jobsCompleted" min="0">';
		$output .= '<div class="ageslider">Age <p id="rangeValue">0</p></div>';
		$output .= '<input type="range" min="0" max="100" value="0" class="slider" id="myRange">';
		$output .= '<div>Ratings</div>';
		$output .= '<select id="rating-select">';
		$output .= '<option value="">Select Rating</option>';
		$output .= '<option value="1">1 Star</option>';
		$output .= '<option value="2">2 Stars</option>';
		$output .= '<option value="3">3 Stars</option>';
		$output .= '<option value="4">4 Stars</option>';
		$output .= '<option value="5">5 Stars</option>';
		$output .= '</select>';
		$output .= '</div>';

		$output .= '<div class="filter-btn">';
		$output .= '<button id="filter-button">SEARCH</button>';
		$output .= '</div>';
		$output .= '</div>';

		return $output;
	}

	/**
	 * Callback function for the get_profile_table_html.
	 *
	 * @return string The HTML output for the profile list table.
	 */
	private static function get_profile_table_html() {

		$args = array(
			'post_type'      => 'profile',
			'posts_per_page' => 5,
			'orderby'        => 'title',
			'order'          => 'ASC',
			'offset'         => 0,
		);

		$posts_query = new \WP_Query( $args );

		$table_html = ProfileTable::get_profile_table_html( $posts_query );

		wp_reset_postdata();

		return $table_html;
	}

	/**
	 * Callback function for the get_profile_table_pagination.
	 *
	 * @return string The HTML output for the pagination for rofile list table.
	 */
	private static function get_profile_table_pagination() {

		$args = array(
			'post_type' => 'profile',
		);

		$posts_query = new \WP_Query( $args );
		$total_posts = $posts_query->found_posts;

		$paginate_pgae = ceil( $total_posts / 5 );
		
		$output = '';
		if ( 5 < $total_posts ) {
			$output = '<div class="theplus-pagination">';
			for ( $i = 1; $i <= $paginate_pgae; $i++ ) {
				if ( 1 === $i ) {
					$output .= '<a href="#" class="ajax-paginate active" data-page="' . esc_attr( $i ) . '">' . $i . '</a>';
				} else {
					$output .= '<a href="#" class="ajax-paginate" data-page="' . esc_attr( $i ) . '">' . $i . '</a>';
				}
			}
			$output .= '</div>';
		}

		return $output;
	}
}

Profile_Lists_Shortcode::get_instance();
