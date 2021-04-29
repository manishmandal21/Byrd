<?php
/**
 * apus cityo
 *
 * @package    cityo
 * @author     ApusTheme <apusthemes@gmail.com >
 * @license    GNU General Public License, version 3
 * @copyright  13/06/2016 ApusTheme
 */
 
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

// for custyom admin 'job_manager_input_' . $type

class Cityo_Type_Place{

	public static function init() {
		
		// required/available form
		add_filter( 'apuscityo-place-type-required-fields', array( __CLASS__, 'required_fields' ), 100 );
		add_filter( 'apuscityo-place-type-available-fields', array( __CLASS__, 'available_fields' ), 100 );
		
		add_filter( 'cityo_get_default_blocks_content', array( __CLASS__, 'blocks_content' ), 10 );
		add_filter( 'cityo_get_default_blocks_sidebar_content', array( __CLASS__, 'blocks_sidebar_content' ), 10 );

		// custom field display
		add_filter( 'apuscityo_display_hooks', array( __CLASS__, 'custom_fields_display_hooks'), 1 );

		if ( did_action( 'elementor/loaded' ) ) {
		    // Finally initialize code
		    self::elementor_widgets();
		}

		add_filter( 'cityo_get_job_listings_query_args', array( __CLASS__, 'get_job_listings_query_args' ), 20, 3 );
	}

	public static function required_fields($dfields) {
		$fields['job_title'] = array(
			'label' => esc_html__('Title', 'cityo'),
			'type' => 'text',
			'required' => true,
			'placeholder' => esc_html__('Title', 'cityo'),
			'disable_check' => true,
			'show_in_submit_form'    => true,
			'show_in_admin_edit'    => true,
		);
		$fields['job_description'] = array(
			'label'       => esc_html__( 'Description', 'cityo' ),
			'type'        => 'wp-editor',
			'required'    => true,
			'show_in_submit_form'    => true,
			'show_in_admin_edit'    => true,
			'disable_check' => true
		);
		return $fields;
	}

	public static function available_fields($dfields) {
		global $wp_taxonomies;

		// general
		$fields['job_tagline'] = array(
			'label' => esc_html__('Tagline', 'cityo'),
			'type' => 'text',
			'required' => false,
			'placeholder' => esc_html__('tagline', 'cityo'),
			'show_in_submit_form'    => true,
			'show_in_admin_edit'    => true,
		);
		$fields['job_location'] = array(
			'label'       => esc_html__( 'Location', 'cityo' ),
			'type' => 'cityo-location',
			'priority' => 2.3,
			'placeholder' => esc_html__( 'e.g 34 Wigmore Street, London', 'cityo' ),
			'description' => esc_html__( 'Leave this blank if the location is not important.', 'cityo' ),
		);

		// taxonomies
		$fields['job_regions'] = array(
			'type'        => 'cityo-regions',
			'default' => '',
			'taxonomy' => 'job_listing_region',
			'placeholder' => esc_html__( 'Add Region', 'cityo' ),
			'label' => esc_html__( 'Listing Region', 'cityo' ),
		);
		$fields['job_category'] = array(
			'type'        => 'job_category',
			'select_type' => 'term-select',
			'default' => '',
			'taxonomy' => 'job_listing_category',
			'placeholder' => esc_html__( 'Add Category', 'cityo' ),
			'label' => esc_html__( 'Listing Category', 'cityo' ),
		);
		$fields['job_amenities'] = array(
			'type'        => 'job_amenities',
			'select_type' => 'term-select',
			'default' => '',
			'taxonomy' => 'job_listing_amenity',
			'placeholder' => esc_html__( 'Add Amenity', 'cityo' ),
			'label' => esc_html__( 'Listing Amenity', 'cityo' ),
		);
		
		if ( isset( $wp_taxonomies['job_listing_tag'] ) ) {
			$fields['job_tags'] = array(
				'label'       => esc_html__( 'Listing tags', 'cityo' ),
				'description' => esc_html__( 'Comma separate tags, such as required skills or technologies, for this listing.', 'cityo' ),
				'type'        => 'text',
				'placeholder' => esc_html__( 'e.g. PHP, Social Media, Management', 'cityo' ),
			);
		}
		
		// price
		$fields['job_price_range'] = array(
			'label' => esc_html__('Price Range', 'cityo'),
			'type' => 'select',
			'required' => false,
			'options' => apply_filters( 'apus_cityo_price_ranges', array() ),
			'description' => '',
		);

		$fields['job_price_from'] = array(
			'label' => esc_html__('Price From', 'cityo'),
			'type' => 'text',
			'required' => false,
			'placeholder' => esc_html__( 'e.g: 100', 'cityo' ),
		);
		$fields['job_price_to'] = array(
			'label' => esc_html__('Price To', 'cityo'),
			'type' => 'text',
			'required' => false,
			'placeholder' => esc_html__( 'e.g: 200', 'cityo' ),
		);

		// hours
		$fields['job_hours'] = array(
			'label'       => esc_html__( 'Hours of Operation', 'cityo' ),
			'type'        => 'cityo-hours',
			'required'    => false,
			'placeholder' => '',
			'default'     => '',
			'sanitize_callback' => 'cityo_sanitize_array_callback'
		);

		// contact
		$fields['job_phone'] = array(
			'label'       => esc_html__( 'Phone', 'cityo' ),
			'type'        => 'text',
			'placeholder' => esc_html__( 'e.g +84-669-996', 'cityo' ),
			'required'    => false,
		);
		$fields['job_email'] = array(
			'label'       => esc_html__( 'Email', 'cityo' ),
			'type'        => 'text',
			'placeholder' => esc_html__( 'e.g youremail@email.com', 'cityo' ),
			'required'    => false,
		);
		$fields['job_website'] = array(
			'label'       => esc_html__( 'Website', 'cityo' ),
			'type'        => 'text',
			'placeholder' => esc_html__( 'e.g yourwebsite.com', 'cityo' ),
			'required'    => false,
		);

		// Menu price
		$fields['job_menu_prices'] = array(
			'label'       => esc_html__( 'Menu Prices', 'cityo' ),
			'type' => 'cityo-menu-prices',
			'priority' => 3.9,
			'placeholder' => '',
			'description' => '',
			'sanitize_callback' => 'cityo_sanitize_array_callback'
		);

		// media
		$fields['job_logo'] = array(
			'label'       => esc_html__( 'Logo', 'cityo' ),
			'type'        => 'file',
			'description' => esc_html__( 'The image will be shown on listing cards.', 'cityo' ),
			'required'    => false,
			'multiple_files'    => false,
			'ajax' 		  => true,
			'allow_types' => array(
				'jpg|jpeg|jpe',
				'jpeg',
				'gif',
				'png',
			),
		);
		$fields['job_cover_image'] = array(
			'label'       => esc_html__( 'Cover Image', 'cityo' ),
			'type'        => 'file',
			'description' => esc_html__( 'The image will be shown on listing cards.', 'cityo' ),
			'required'    => false,
			'multiple_files'    => false,
			'ajax' 		  => true,
			'allow_types' => array(
				'jpg|jpeg|jpe',
				'jpeg',
				'gif',
				'png',
			),
		);
		$fields['job_gallery_images'] = array(
			'label' => esc_html__( 'Gallery Images', 'cityo' ),
			'priority' => 2.9,
			'required' => false,
			'type' => 'file',
			'ajax' => true,
			'placeholder' => '',
			'allow_types' => array(
				'jpg|jpeg|jpe',
				'jpeg',
				'gif',
				'png',
			),
			'multiple_files' => true,
		);
		$fields['job_video'] = array(
			'label'       => esc_html__( 'Video', 'cityo' ),
			'type'        => 'text',
			'required'    => false,
			'placeholder' => esc_html__( 'A link to a video about your company', 'cityo' ),
		);

		// socials
		$fields['job_socials'] = array(
			'label'       => esc_html__( 'Socials Link', 'cityo' ),
			'type'        => 'repeater',
			'required'    => false,
			'fields' => array(
				'network' => array(
					'label'       => esc_html__( 'Network', 'cityo' ),
					'name'        => 'job_socials_network[]',
					'type'        => 'select',
					'description' => '',
					'placeholder' => '',
					'options' => array(
						'' => esc_html__('Select Network', 'cityo'),
						'fab fa-facebook-f' => esc_html__('Facebook', 'cityo'),
						'fab fa-twitter' => esc_html__('Twitter', 'cityo'),
						'fab fa-google-plus-g' => esc_html__('Google+', 'cityo'),
						'fab fa-instagram' => esc_html__('Instagram', 'cityo'),
						'fab fa-youtube' => esc_html__('Youtube', 'cityo'),
						'fab fa-snapchat' => esc_html__('Snapchat', 'cityo'),
						'fab fa-linkedin-in' => esc_html__('LinkedIn', 'cityo'),
						'fab fa-reddit' => esc_html__('Reddit', 'cityo'),
						'fab fa-tumblr' => esc_html__('Tumblr', 'cityo'),
						'fab fa-pinterest' => esc_html__('Pinterest', 'cityo'),
					)
				),
				'network_url' => array(
					'label'       => esc_html__( 'Network Url', 'cityo' ),
					'name'        => 'job_socials_network_url[]',
					'type'        => 'text',
					'description' => '',
					'placeholder' => '',
				),
			),
			'sanitize_callback' => 'cityo_sanitize_array_callback'
		);

		// Products
		$fields['job_products'] = array(
			'label'       => esc_html__( 'Woocommerce Products', 'cityo' ),
			'type'        => 'multiselect',
			'required'    => false
		);

		return $fields;
	}

	public static function blocks_content() {
	    return apply_filters( 'cityo_listing_single_place_content', array(
	        'description' => esc_html__( 'Description', 'cityo' ),
	        'maps' => esc_html__( 'Maps', 'cityo' ),
	        'amenities' => esc_html__( 'Amenities', 'cityo' ),
	        'photos' => esc_html__( 'Photos', 'cityo' ),
	        'menu-prices' => esc_html__( 'Menu Prices', 'cityo' ),
	        'video' => esc_html__( 'Video', 'cityo' ),
	        'hours' => esc_html__( 'Hours', 'cityo' ),
	        'products' => esc_html__( 'Products', 'cityo' ),
	        'comments' => esc_html__( 'Reviews', 'cityo' ),
	    ));
	}

	public static function blocks_sidebar_content() {
	    return apply_filters( 'cityo_listing_single_place_sidebar', array(
	        'amenities' => esc_html__( 'Amenities', 'cityo' ),
	        'business-info' => esc_html__( 'Business Info', 'cityo' ),
	        'contact-form' => esc_html__( 'Contact Business', 'cityo' ),
	        'hours' => esc_html__( 'Hours', 'cityo' ),
	        'nearby' => esc_html__( 'Nearby Places', 'cityo' ),
	        'nearby_browse' => esc_html__( 'Browse Nearby Places', 'cityo' ),
	        'price_range' => esc_html__( 'Price Range', 'cityo' ),
	        'review-avg' => esc_html__( 'Review Average', 'cityo' ),
	        'statistic' => esc_html__( 'Statistic', 'cityo' ),
	        'tags' => esc_html__( 'Tags', 'cityo' ),
	        'claim' => esc_html__( 'Claim Listing', 'cityo' ),
	        'products-sidebar' => esc_html__( 'Products', 'cityo' ),
	    ));
	}

	public static function custom_fields_display_hooks($hooks) {
		$hooks[''] = esc_html__('Choose a position', 'cityo');
		$hooks['cityo-single-listing-description'] = esc_html__('Single Listing - Description', 'cityo');
		$hooks['cityo-single-listing-contact'] = esc_html__('Single Listing - Business Information', 'cityo');
		$hooks['cityo-single-listing-amenities'] = esc_html__('Single Listing - Amenities Box', 'cityo');
		$hooks['cityo-single-listing-contact-form'] = esc_html__('Single Listing - Contact Form', 'cityo');
		$hooks['cityo-single-listing-hours'] = esc_html__('Single Listing - Hours', 'cityo');
		$hooks['cityo-single-listing-maps'] = esc_html__('Single Listing - Maps', 'cityo');
		$hooks['cityo-single-listing-menu-prices'] = esc_html__('Single Listing - Menu Prices', 'cityo');
		$hooks['cityo-single-listing-nearby'] = esc_html__('Single Listing - Nearby', 'cityo');
		$hooks['cityo-single-listing-nearby-browse'] = esc_html__('Single Listing - Browse Nearby', 'cityo');
		$hooks['cityo-single-listing-price-range'] = esc_html__('Single Listing - Price Range', 'cityo');
		$hooks['cityo-single-listing-review-avg'] = esc_html__('Single Listing - Review avg', 'cityo');
		$hooks['cityo-single-listing-statistic'] = esc_html__('Single Listing - Statistic', 'cityo');
		return $hooks;
	}
	
	public static function elementor_widgets() {
		get_template_part( 'inc/vendors/wp-job-manager/place/widgets/listings' );
		get_template_part( 'inc/vendors/wp-job-manager/place/widgets/search_form' );
	}

	public static function get_job_listings_query_args($query_args, $args, $datas) {
		if ( isset($query_args['meta_query']) ) {
			$meta_query = $query_args['meta_query'];
		} else {
			$meta_query = array();
		}

		if (isset($datas['filter_price_range']) && $datas['filter_price_range']) {
			$meta_query[] = array(
	           'key' => '_job_price_range',
	           'value' => $datas['filter_price_range'],
	           'compare' => '=',
	       	);
		}
		if ( isset($datas['filter_price_from']) && isset($datas['filter_price_to']) ) {
			$price_meta_query = array( 'relation' => 'AND' );
			if ( isset($datas['filter_price_from']) ) {
				$price_meta_query[] = array(
		           	'key' => '_job_price_from',
		           	'value' => $datas['filter_price_from'],
		           	'compare'   => '>=',
					'type'      => 'NUMERIC',
		       	);
			}
			if ( isset($datas['filter_price_to']) ) {
				$price_meta_query[] = array(
		           	'key' => '_job_price_to',
		           	'value' => $datas['filter_price_to'],
		           	'compare'   => '<=',
					'type'      => 'NUMERIC',
		       	);
			}
			$meta_query[] = $price_meta_query;
		}
		
		if ( !empty($meta_query) ) {
			$query_args['meta_query'] = $meta_query;
		}
		return $query_args;
	}
}

Cityo_Type_Place::init();