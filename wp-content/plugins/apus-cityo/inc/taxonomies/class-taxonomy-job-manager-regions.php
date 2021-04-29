<?php
/**
 * Regions
 *
 * @package    apus-cityo
 * @author     ApusTheme <apusthemes@gmail.com >
 * @license    GNU General Public License, version 3
 * @copyright  13/06/2016 ApusTheme
 */
 
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
class ApusCityo_Taxonomy_Regions{

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
			'name'              => __( 'Regions', 'apus-cityo' ),
			'singular_name'     => __( 'Region', 'apus-cityo' ),
			'search_items'      => __( 'Search Regions', 'apus-cityo' ),
			'all_items'         => __( 'All Regions', 'apus-cityo' ),
			'parent_item'       => __( 'Parent Region', 'apus-cityo' ),
			'parent_item_colon' => __( 'Parent Region:', 'apus-cityo' ),
			'edit_item'         => __( 'Edit', 'apus-cityo' ),
			'update_item'       => __( 'Update', 'apus-cityo' ),
			'add_new_item'      => __( 'Add New', 'apus-cityo' ),
			'new_item_name'     => __( 'New Region', 'apus-cityo' ),
			'menu_name'         => __( 'Regions', 'apus-cityo' ),
		);

		register_taxonomy( 'job_listing_region', 'job_listing', array(
			'labels'            => apply_filters( 'apuscityo_taxomony_booking_amenities_labels', $labels ),
			'hierarchical'      => true,
			'query_var'         => 'region',
			'rewrite'           => array( 'slug' => __( 'region', 'apus-cityo' ) ),
			'public'            => true,
			'show_ui'           => true,
			'show_in_rest'		=> false
		) );
	}
	
}

ApusCityo_Taxonomy_Regions::init();