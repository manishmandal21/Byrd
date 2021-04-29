<?php
/**
 * Amenities
 *
 * @package    apus-cityo
 * @author     ApusTheme <apusthemes@gmail.com >
 * @license    GNU General Public License, version 3
 * @copyright  13/06/2016 ApusTheme
 */
 
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
class ApusCityo_Taxonomy_Amenities{

	/**
	 *
	 */
	public static function init() {
		add_action( 'init', array( __CLASS__, 'definition' ), 1 );
	}

	/**
	 *
	 */
	public static function definition() {
		$labels = array(
			'name'              => __( 'Amenities', 'apus-cityo' ),
			'singular_name'     => __( 'Amenity', 'apus-cityo' ),
			'search_items'      => __( 'Search Amenities', 'apus-cityo' ),
			'all_items'         => __( 'All Amenities', 'apus-cityo' ),
			'parent_item'       => __( 'Parent Amenity', 'apus-cityo' ),
			'parent_item_colon' => __( 'Parent Amenity:', 'apus-cityo' ),
			'edit_item'         => __( 'Edit', 'apus-cityo' ),
			'update_item'       => __( 'Update', 'apus-cityo' ),
			'add_new_item'      => __( 'Add New', 'apus-cityo' ),
			'new_item_name'     => __( 'New Amenity', 'apus-cityo' ),
			'menu_name'         => __( 'Amenities', 'apus-cityo' ),
		);

		register_taxonomy( 'job_listing_amenity', 'job_listing', array(
			'labels'            => apply_filters( 'apus_cityo_taxomony_booking_amenities_labels', $labels ),
			'hierarchical'      => true,
			'query_var'         => 'amenity',
			'rewrite'           => array( 'slug' => __( 'amenity', 'apus-cityo' ) ),
			'public'            => true,
			'show_ui'           => true,
			'show_in_rest'		=> true
		) );
	}

}

ApusCityo_Taxonomy_Amenities::init();