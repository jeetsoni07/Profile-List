<?php
/**
 * Meta Boxes
 *
 * This file contains the Meta_Boxes class, which handles the creation and management of meta boxes for profiles.
 *
 * @package    ProfileLists
 * @subpackage Includes
 * @since      1.0.0
 */

namespace ProfileLists\Includes;

use ProfileLists\Includes\Meta_Keys_Constants;

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Class Meta_Boxes
 *
 * This class handles the creation and management of meta boxes for profiles.
 *
 * @package ProfileLists\Includes
 */
class Meta_Boxes {

	/**
	 * The singleton instance of the class.
	 *
	 * @var ClassName|null $instance The singleton instance.
	 */
	private static $instance;

	/**
	 * Get the singleton instance of the Meta_Boxes class.
	 *
	 * @return Meta_Boxes The singleton instance.
	 */
	public static function get_instance() {
		if ( ! isset( self::$instance ) ) {
			self::$instance = new self();
		}
		return self::$instance;
	}

	/**
	 * Meta_Boxes constructor.
	 */
	public function __construct() {
		add_action( 'add_meta_boxes', array( $this, 'add_profile_meta_boxes' ) );
		add_action( 'save_post', array( $this, 'save_profile_meta_data' ) );
		add_filter( 'manage_posts_columns', array( $this, 'add_profile_meta_columns' ) );
		add_action( 'manage_posts_custom_column', array( $this, 'populate_profile_meta_columns' ), 10, 2 );
	}

	/**
	 * Add profile meta boxes.
	 */
	public static function add_profile_meta_boxes() {
		add_meta_box(
			'profile_meta_box',
			__( 'Profile Metadata' ),
			array( __CLASS__, 'render_profile_meta_box' ),
			'profile',
			'normal',
			'high'
		);
	}

	/**
	 * Render profile meta box.
	 *
	 * @param WP_Post $post The post object.
	 */
	public static function render_profile_meta_box( $post ) {

		$dob                 = get_post_meta( $post->ID, Meta_Keys_Constants::PROFILE_DOB, true );
		$hobbies             = get_post_meta( $post->ID, Meta_Keys_Constants::PROFILE_HOBBIES, true );
		$interests           = get_post_meta( $post->ID, Meta_Keys_Constants::PROFILE_INTERESTS, true );
		$years_of_experience = get_post_meta( $post->ID, Meta_Keys_Constants::PROFILE_YEARS_OF_EXPERIENCE, true );
		$ratings             = get_post_meta( $post->ID, Meta_Keys_Constants::PROFILE_RATINGS, true );
		$jobs_completed      = get_post_meta( $post->ID, Meta_Keys_Constants::PROFILE_JOBS_COMPLETED, true );

		?>
		<p>
			<label for="profile_dob"><?php esc_html_e( 'Date of Birth:' ); ?></label>
			<input type="date" id="profile_dob" name="profile_dob" value="<?php echo esc_attr( $dob ); ?>" />
		</p>
		<p>
			<label for="profile_hobbies"><?php esc_html_e( 'Hobbies:' ); ?></label>
			<input type="text" id="profile_hobbies" name="profile_hobbies" value="<?php echo esc_attr( $hobbies ); ?>" />
		</p>
		<p>
			<label for="profile_interests"><?php esc_html_e( 'Interests:' ); ?></label>
			<input type="text" id="profile_interests" name="profile_interests" value="<?php echo esc_attr( $interests ); ?>" />
		</p>
		<p>
			<label for="profile_years_of_experience"><?php esc_html_e( 'Years of Experience:' ); ?></label>
			<input type="number" id="profile_years_of_experience" name="profile_years_of_experience" value="<?php echo esc_attr( $years_of_experience ); ?>" />
		</p>
		<p>
			<label for="profile_ratings"><?php esc_html_e( 'Ratings:' ); ?></label>
			<input type="number" id="profile_ratings" name="profile_ratings" value="<?php echo esc_attr( $ratings ); ?>" />
		</p>
		<p>
			<label for="profile_jobs_completed"><?php esc_html_e( 'No. of Jobs Completed:' ); ?></label>
			<input type="number" id="profile_jobs_completed" name="profile_jobs_completed" value="<?php echo esc_attr( $jobs_completed ); ?>" />
		</p>

		<?php
	}

	/**
	 * Save profile meta data.
	 *
	 * @param int $post_id The post ID.
	 */
	public static function save_profile_meta_data( $post_id ) {

		if ( isset( $_POST[ Meta_Keys_Constants::PROFILE_DOB ] ) ) {
			$dob = sanitize_text_field( wp_unslash( $_POST[ Meta_Keys_Constants::PROFILE_DOB ] ) );
			update_post_meta( $post_id, Meta_Keys_Constants::PROFILE_DOB, $dob );
		}
		if ( isset( $_POST[ Meta_Keys_Constants::PROFILE_HOBBIES ] ) ) {
			$hobbies = sanitize_text_field( wp_unslash( $_POST[ Meta_Keys_Constants::PROFILE_HOBBIES ] ) );
			update_post_meta( $post_id, Meta_Keys_Constants::PROFILE_HOBBIES, $hobbies );
		}
		if ( isset( $_POST[ Meta_Keys_Constants::PROFILE_INTERESTS ] ) ) {
			$interests = sanitize_text_field( wp_unslash( $_POST[ Meta_Keys_Constants::PROFILE_INTERESTS ] ) );
			update_post_meta( $post_id, Meta_Keys_Constants::PROFILE_INTERESTS, $interests );
		}
		if ( isset( $_POST[ Meta_Keys_Constants::PROFILE_YEARS_OF_EXPERIENCE ] ) ) {
			$years_of_experience = sanitize_text_field( wp_unslash( $_POST[ Meta_Keys_Constants::PROFILE_YEARS_OF_EXPERIENCE ] ) );
			update_post_meta( $post_id, Meta_Keys_Constants::PROFILE_YEARS_OF_EXPERIENCE, $years_of_experience );
		}
		if ( isset( $_POST[ Meta_Keys_Constants::PROFILE_RATINGS ] ) ) {
			$ratings = sanitize_text_field( wp_unslash( $_POST[ Meta_Keys_Constants::PROFILE_RATINGS ] ) );
			update_post_meta( $post_id, Meta_Keys_Constants::PROFILE_RATINGS, $ratings );
		}
		if ( isset( $_POST[ Meta_Keys_Constants::PROFILE_JOBS_COMPLETED ] ) ) {
			$jobs_completed = sanitize_text_field( wp_unslash( $_POST[ Meta_Keys_Constants::PROFILE_JOBS_COMPLETED ] ) );
			update_post_meta( $post_id, Meta_Keys_Constants::PROFILE_JOBS_COMPLETED, $jobs_completed );
		}
	}

	/**
	 * Add profile meta columns.
	 *
	 * @param  array $columns The existing columns.
	 * @return array The modified columns.
	 */
	public static function add_profile_meta_columns( $columns ) {

		$columns[ Meta_Keys_Constants::PROFILE_DOB ]                 = __( 'Date of Birth' );
		$columns[ Meta_Keys_Constants::PROFILE_HOBBIES ]             = __( 'Hobbies' );
		$columns[ Meta_Keys_Constants::PROFILE_INTERESTS ]           = __( 'Interests' );
		$columns[ Meta_Keys_Constants::PROFILE_YEARS_OF_EXPERIENCE ] = __( 'Years of Experience' );
		$columns[ Meta_Keys_Constants::PROFILE_RATINGS ]             = __( 'Ratings' );
		$columns[ Meta_Keys_Constants::PROFILE_JOBS_COMPLETED ]      = __( 'Jobs Completed' );
		return $columns;
	}

	/**
	 * Populate profile meta columns.
	 *
	 * @param string $column  The column key.
	 * @param int    $post_id The post ID.
	 */
	public static function populate_profile_meta_columns( $column, $post_id ) {

		$dob                 = get_post_meta( $post_id, Meta_Keys_Constants::PROFILE_DOB, true );
		$hobbies             = get_post_meta( $post_id, Meta_Keys_Constants::PROFILE_HOBBIES, true );
		$interests           = get_post_meta( $post_id, Meta_Keys_Constants::PROFILE_INTERESTS, true );
		$years_of_experience = get_post_meta( $post_id, Meta_Keys_Constants::PROFILE_YEARS_OF_EXPERIENCE, true );
		$ratings             = get_post_meta( $post_id, Meta_Keys_Constants::PROFILE_RATINGS, true );
		$jobs_completed      = get_post_meta( $post_id, Meta_Keys_Constants::PROFILE_JOBS_COMPLETED, true );

		switch ( $column ) {
			case Meta_Keys_Constants::PROFILE_DOB:
				echo esc_html( $dob );
				break;
			case Meta_Keys_Constants::PROFILE_HOBBIES:
				echo esc_html( $hobbies );
				break;
			case Meta_Keys_Constants::PROFILE_INTERESTS:
				echo esc_html( $interests );
				break;
			case Meta_Keys_Constants::PROFILE_YEARS_OF_EXPERIENCE:
				echo esc_html( $years_of_experience );
				break;
			case Meta_Keys_Constants::PROFILE_RATINGS:
				echo esc_html( $ratings );
				break;
			case Meta_Keys_Constants::PROFILE_JOBS_COMPLETED:
				echo esc_html( $jobs_completed );
				break;
		}
	}
}

// Instantiate the Meta_Boxes class.
Meta_Boxes::get_instance();
