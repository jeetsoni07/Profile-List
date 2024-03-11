<?php
/**
 * Profile Listing Table Html
 *
 * This file contains the get_profile_table_html class, which returns data of post in table.
 *
 * @package    ProfileLists
 * @subpackage Includes
 * @since      1.0.0
 */

namespace ProfileLists\Includes;

/**
 * Class ProfileTable
 *
 * This class contains HTML / data for table view.
 *
 * @package ProfileLists\Includes
 */
class ProfileTable {
	/**
	 * Get HTML for the profile list table.
	 *
	 * @param int $posts_query The query for post.
	 * @return string The HTML output for the profile list table.
	 */
	public static function get_profile_table_html( $posts_query ) {

		if ( $posts_query->have_posts() ) {
			$output  = '<table class="profile-table">';
			$output .= '<tr>';
			$output .= '<th>No.</th>';
			$output .= '<th class="short" data-value="DESE">Profile Name</th>';
			$output .= '<th>Age</th>';
			$output .= '<th>Years of Experience</th>';
			$output .= '<th>No of jobs competed</th>';
			$output .= '<th>Ratings</th>';
			$output .= '</tr>';

			$index = 1;
			while ( $posts_query->have_posts() ) {
				$posts_query->the_post();
				$title  = '<a href="' . get_permalink() . '">' . get_the_title() . '</a>';
				$postid = get_the_ID();
				$dob    = get_post_meta( $postid, Meta_Keys_Constants::PROFILE_DOB, true );

				$age = '-';
				if ( ! empty( $dob ) ) {
					$dob_timestamp     = strtotime( $dob );
					$current_timestamp = current_time( 'timestamp' );
					$age               = gmdate( 'Y', $current_timestamp ) - gmdate( 'Y', $dob_timestamp );
				}

				// Update post meta for age.
				update_post_meta( $postid, 'profile_age', $age );

				$years_of_experience = get_post_meta( $postid, Meta_Keys_Constants::PROFILE_YEARS_OF_EXPERIENCE, true );
				$jobs_completed      = get_post_meta( $postid, Meta_Keys_Constants::PROFILE_JOBS_COMPLETED, true );
				$ratings             = get_post_meta( $postid, Meta_Keys_Constants::PROFILE_RATINGS, true );

				$filled_stars = ! empty( $ratings ) ? min( $ratings, 5 ) : 0;
				$empty_stars  = max( 5 - $filled_stars, 0 );

				$stars  = str_repeat( '<span class="filled-star">&#9733;</span>', $filled_stars );
				$stars .= str_repeat( '<span class="empty-star">&#9734;</span>', $empty_stars );

				$output .= '<tr>';
				$output .= '<td>' . $index . '</td>';
				$output .= '<td>' . $title . '</td>';
				$output .= '<td>' . $age . '</td>';
				$output .= '<td>' . $years_of_experience . '</td>';
				$output .= '<td>' . $jobs_completed . '</td>';
				$output .= '<td>' . $stars . '</td>';
				$output .= '</tr>';

				++$index;
			}

			$output .= '</table>';
		} else {
			$output = 'No profiles found.';
		}

		wp_reset_postdata();

		return $output;
	}
}
