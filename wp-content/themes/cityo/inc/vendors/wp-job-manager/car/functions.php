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

class Cityo_Type_Car{

	public static function init() {
		
		// required/available form
		add_filter( 'apuscityo-car-type-required-fields', array( __CLASS__, 'required_fields' ), 100 );
		add_filter( 'apuscityo-car-type-available-fields', array( __CLASS__, 'available_fields' ), 100 );
		
		add_action( 'job_manager_input_cityo-select', array( __CLASS__, 'input_category_fields' ), 10, 2 );

		add_filter( 'apuscityo-types-render_field', array( __CLASS__, 'render_fields' ), 10, 5 );
		add_filter( 'apuscityo_list_simple_type', array( __CLASS__, 'simple_type' ), 10 );
		

		add_filter( 'apuscityo-types-add_custom_fields', array( __CLASS__, 'admin_custom_fields' ), 10, 2 );

		// region field
		add_action( 'wp_ajax_cityo_process_change_category', array( __CLASS__, 'process_change_category' ) );
		add_action( 'wp_ajax_nopriv_cityo_process_change_category', array( __CLASS__, 'process_change_category' ) );


		add_filter( 'cityo_get_default_blocks_content', array( __CLASS__, 'blocks_content' ), 10 );
		add_filter( 'cityo_get_default_blocks_sidebar_content', array( __CLASS__, 'blocks_sidebar_content' ), 10 );

		// custom field display
		add_filter( 'apuscityo_display_hooks', array( __CLASS__, 'custom_fields_display_hooks'), 1 );
		add_filter( 'apus-cityo-display_field_data', array( __CLASS__, 'display_custom_field_data'), 10, 6);

		if ( did_action( 'elementor/loaded' ) ) {
		    // Finally initialize code
		    self::elementor_widgets();
		}

		add_filter( 'cityo_get_job_listings_query_args', array( __CLASS__, 'get_job_listings_query_args' ), 20, 3 );
	}

	public static function admin_custom_fields($fields, $old_fields) {
		if ( isset($fields['_job_category']) ) {
			unset($fields['_job_category']);
		}
		if ( isset($fields['_job_type']) ) {
			unset($fields['_job_type']);
		}
		if ( isset($fields['_job_amenities']) ) {
			unset($fields['_job_amenities']);
		}
		return $fields;
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
		$fields['job_c_category'] = array(
			'type'        => 'cityo-select',
			'select_type' => 'term-select',
			'default' => '',
			'taxonomy' => 'job_listing_category',
			'placeholder' => esc_html__( 'Choose a Brand', 'cityo' ),
			'label' => esc_html__( 'Car Brand', 'cityo' ),
		);
		$fields['job_c_type'] = array(
			'type'        => 'cityo-select',
			'select_type' => 'term-select',
			'default' => '',
			'taxonomy' => 'job_listing_type',
			'placeholder' => esc_html__( 'Choose a Model', 'cityo' ),
			'label' => esc_html__( 'Car Model', 'cityo' ),
		);
		$fields['job_amenities'] = array(
			'type'        => 'job_amenities',
			'select_type' => 'term-select',
			'default' => '',
			'taxonomy' => 'job_listing_amenity',
			'placeholder' => esc_html__( 'Add Amenities', 'cityo' ),
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
		$fields['job_price'] = array(
			'label' => esc_html__('Price', 'cityo'),
			'type' => 'text',
			'required' => false,
			'placeholder' => esc_html__( 'e.g. 100', 'cityo' ),
		);
		$fields['job_price_prefix'] = array(
			'label' => esc_html__('Price Prefix', 'cityo'),
			'type' => 'text',
			'required' => false,
			'placeholder' => esc_html__( 'e.g. from', 'cityo' ),
			'description' => esc_html__('Any text shown before price (e.g: from).', 'cityo'),
		);
		$fields['job_price_suffix'] = array(
			'label' => esc_html__('Price Suffix', 'cityo'),
			'type' => 'text',
			'required' => false,
			'placeholder' => esc_html__( 'e.g. per night', 'cityo' ),
			'description' => esc_html__('Any text shown after price (e.g: per night).', 'cityo'),
		);

		// contact
		$fields['job_phone'] = array(
			'label'       => esc_html__( 'Phone', 'cityo' ),
			'type'        => 'text',
			'placeholder' => esc_html__( 'e.g. +84-669-996', 'cityo' ),
			'required'    => false,
		);
		$fields['job_email'] = array(
			'label'       => esc_html__( 'Email', 'cityo' ),
			'type'        => 'text',
			'placeholder' => esc_html__( 'e.g. youremail@email.com', 'cityo' ),
			'required'    => false,
		);
		$fields['job_website'] = array(
			'label'       => esc_html__( 'Website', 'cityo' ),
			'type'        => 'text',
			'placeholder' => esc_html__( 'e.g. yourwebsite.com', 'cityo' ),
			'required'    => false,
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
		
		// Car Fields
		$fields['job_contract'] = array(
			'label'       => esc_html__( 'Contract', 'cityo' ),
			'type'        => 'select',
			'required'    => false,
			'placeholder' => esc_html__( 'Choose a contract', 'cityo' ),
			'options' => 'For Rent
For Buy',
		);

		$fields['job_year'] = array(
			'label'       => esc_html__( 'Year', 'cityo' ),
			'type'        => 'select',
			'required'    => false,
			'options' => '2005
2006
2007
2008
2009
2010
2011
2012
2013
2014
2015
2016
2017
2018
2019',
			'placeholder' => esc_html__( 'Select Year', 'cityo' ),
		);

		$fields['job_nb_of_door'] = array(
			'label'       => esc_html__( 'Number of Door', 'cityo' ),
			'type'        => 'text',
			'required'    => false,
			'placeholder' => esc_html__( 'e.g. 4', 'cityo' ),
		);

		$fields['job_max_passengers'] = array(
			'label'       => esc_html__( 'Max passengers', 'cityo' ),
			'type'        => 'text',
			'required'    => false,
			'placeholder' => esc_html__( 'e.g. 3', 'cityo' ),
		);

		$fields['job_condition'] = array(
			'label'       => esc_html__( 'Condition', 'cityo' ),
			'type'        => 'select',
			'required'    => false,
			'options' => 'Certified Used
New
Used',
			'placeholder' => esc_html__( 'Select Condition', 'cityo' ),
		);

		$fields['job_fuel_type'] = array(
			'label'       => esc_html__( 'Fuel Type', 'cityo' ),
			'type'        => 'select',
			'required'    => false,
			'options' => 'Diesel
Electric
Ethanol
Fuel
Gasoline
Hybrid
LPG Autogas',
			'placeholder' => esc_html__( 'Select Fuel Type', 'cityo' ),
		);

		$fields['job_fuel_per_100'] = array(
			'label'       => esc_html__( 'Fuel usage per 100km', 'cityo' ),
			'type'        => 'text',
			'required'    => false,
			'placeholder' => esc_html__( 'e.g. 9L', 'cityo' ),
		);

		$fields['job_mileage'] = array(
			'label'       => esc_html__( 'Mileage', 'cityo' ),
			'type'        => 'number',
			'required'    => false,
			'placeholder' => sprintf(esc_html__( 'e.g. 49993 (%s)', 'cityo' ), cityo_get_config('listing_area_unit', 'ft') ),
		);

		$fields['job_interior_color'] = array(
			'label'       => esc_html__( 'Interior Color', 'cityo' ),
			'type'        => 'select',
			'required'    => false,
			'options' => 'Beige
Brown
Grey
Jet Black
Jet Red
Multi-pattern',
			'placeholder' => esc_html__( 'Select Exterior Color', 'cityo' ),
		);

		$fields['job_exterior_color'] = array(
			'label'       => esc_html__( 'Exterior Color', 'cityo' ),
			'type'        => 'select',
			'required'    => false,
			'options' => 'Deep Blue Pearl
Midnight Silver Metallic
Obsidian Black Metallic
Pearl White
Red Multi-Coat
Silver Metallic
Solid Black
Solid White
Titanium Metallic',
			'placeholder' => esc_html__( 'Select Exterior Color', 'cityo' ),
		);

		$fields['job_transmission'] = array(
			'label'       => esc_html__( 'Transmission', 'cityo' ),
			'type'        => 'select',
			'required'    => false,
			'options' => 'Automatic
Manual
Semi-automatic',
			'placeholder' => esc_html__( 'Select Transmission', 'cityo' ),
		);

		$fields['job_displacement'] = array(
			'label'       => esc_html__( 'Displacement', 'cityo' ),
			'type'        => 'text',
			'required'    => false,
			'placeholder' => esc_html__( 'e.g. 1781 cc', 'cityo' ),
		);
		

		// Products
		$fields['job_products'] = array(
			'label'       => esc_html__( 'Woocommerce Products', 'cityo' ),
			'type'        => 'multiselect',
			'required'    => false
		);

		return $fields;
	}

	public static function input_category_fields($key, $field) {
		global $wp_locale, $post, $thepostid;
		
		$thepostid = $post->ID;
		?>

		<div class="form-field">
			<label for="<?php echo esc_attr( $key ); ?>"><?php echo esc_html( $field['label'] ) ; ?>:</label>
			<?php
			if ( empty( $field[ 'value' ] ) ) {
				$terms = wp_get_post_terms( $thepostid, $field['taxonomy'] );
				if ( !empty($terms) ) {
					$term_slugs = array();
					foreach ($terms as $term) {
						$term_slugs[] = $term->slug;
					}
					$field[ 'value' ] = $term_slugs;
				}
			}
			get_job_manager_template( 'form-fields/cityo-select-field.php', array('key' => $key, 'field' => $field) );
			?>
		</div>

		<?php
	}

	public static function render_fields( $field, $field_data, $fieldkey, $fieldtype, $priority ) {
		switch ($fieldkey) {
			case 'job_c_category':
			case 'job_c_type':
				$field['taxonomy'] = !empty($field_data['taxonomy']) ? $field_data['taxonomy'] : '';
				break;
		}
		return $field;
	}

	public static function simple_type($types) {
		$types[] = 'job_c_category';
		$types[] = 'job_c_type';
		return $types;
	}

	public static function process_change_category() {
		check_ajax_referer( 'cityo-ajax-nonce', 'security' );
		
		$category_parent = !empty($_POST['category_parent']) ? $_POST['category_parent'] : '';
		$name = !empty($_POST['name']) ? $_POST['name'] : 'job_c_type';
		$e_id = !empty($_POST['id']) ? $_POST['id'] : 'job_c_type';
		$placeholder = !empty($_POST['placeholder']) ? $_POST['placeholder'] : sprintf(esc_html__('Please select %s', 'cityo'), esc_html__('Model', 'cityo') );
		
		
		$html = '';
		if ( $category_parent ) {
			$cat_id = is_numeric($category_parent) ? true : false;
			if ( $cat_id ) {
				$term_parent = get_term_by('term_id', $category_parent, 'job_listing_category');
				if ( !empty($term_parent) ) {
					$category_slug = $term_parent->slug;
	            }
	        } else {
	        	$category_slug = $category_parent;
	        }
		}
		$args = array(
            'orderby' => 'count',
            'hide_empty' => 0,
        );
        if ( !empty($category_slug) ) {
	        $meta_query = array(
				'relation' => 'OR',
				array(
					'key' => 'apus_category_parent',
					'value' => '"' . $category_slug . '"',
					'compare' => 'LIKE',
				),
				array(
					'key' => 'apus_category_parent',
					'value' => '',
				),
				array(
					'key' => 'apus_category_parent',
					'compare' => 'NOT EXISTS',
				)
			);
			$args['meta_query'] = $meta_query;
	    }
		
		$types = get_terms('job_listing_type', $args);

        if ( ! empty( $types ) && ! is_wp_error( $types ) ) {
        	ob_start();
        	
        	?>
        	<?php if ( $name == '_job_types[]' || $name == 'job_types[]' ) { ?>
            	<label><?php echo trim($type_text); ?></label>
            <?php } ?>
        	<select autocomplete="off" id="<?php echo esc_attr($e_id); ?>" name="<?php echo esc_attr($name); ?>" data-placeholder="<?php echo esc_attr($placeholder); ?>">
        		<option value=""><?php echo esc_attr($placeholder); ?></option>
        		<?php
            	foreach ($types as $type) {
			      	?>
			      	<option value="<?php echo esc_attr($type->slug); ?>"><?php echo esc_html($type->name); ?></option>
			      	<?php  
			    }
			    ?>
			</select>
		    <?php
		    $html = ob_get_clean();
        } else {
        	ob_start();
        	
        	?>
        	<?php if ( $name == '_job_types[]' || $name == 'job_types[]' ) { ?>
            	<label><?php echo trim($type_text); ?></label>
            <?php } ?>
        	<select autocomplete="off" id="<?php echo esc_attr($e_id); ?>" name="<?php echo esc_attr($name); ?>" data-placeholder="<?php echo esc_attr($placeholder); ?>">
        		<option value=""><?php echo esc_attr($placeholder); ?></option>
			</select>
		    <?php
		    $html = ob_get_clean();
        }
		echo trim($html);
		die();
	}

	public static function custom_fields_display_hooks($hooks) {
		$hooks[''] = esc_html__('Choose a position', 'cityo');
		$hooks['cityo-single-listing-description'] = esc_html__('Single Listing - Description', 'cityo');
		$hooks['cityo-single-listing-car-detail'] = esc_html__('Single Listing - Detail', 'cityo');

		$hooks['cityo-single-listing-contact'] = esc_html__('Single Listing - Business Information', 'cityo');
		$hooks['cityo-single-listing-amenities'] = esc_html__('Single Listing - Amenities Box', 'cityo');
		$hooks['cityo-single-listing-contact-form'] = esc_html__('Single Listing - Contact Form', 'cityo');
		$hooks['cityo-single-listing-hours'] = esc_html__('Single Listing - Hours', 'cityo');
		$hooks['cityo-single-listing-maps'] = esc_html__('Single Listing - Maps', 'cityo');
		$hooks['cityo-single-listing-nearby'] = esc_html__('Single Listing - Nearby', 'cityo');
		$hooks['cityo-single-listing-nearby-browse'] = esc_html__('Single Listing - Browse Nearby', 'cityo');
		$hooks['cityo-single-listing-price-range'] = esc_html__('Single Listing - Price Range', 'cityo');
		$hooks['cityo-single-listing-review-avg'] = esc_html__('Single Listing - Review avg', 'cityo');
		$hooks['cityo-single-listing-statistic'] = esc_html__('Single Listing - Statistic', 'cityo');
		return $hooks;
	}

	public static function display_custom_field_data($html, $custom_field, $post, $field_label, $output_value, $current_hook) {
		if ( $current_hook === 'cityo-single-listing-car-detail' ) {
			ob_start();
			?>
			<li class="custom-field-data">
	        	<?php if ( $field_label ) { ?>
		        	<span class="text-label"><?php echo trim($field_label); ?></span>
		        <?php } ?>
		        <span class="text-value"><?php echo trim($output_value); ?></span>
	        </li>
			<?php
			$html = ob_get_clean();
		}
		return $html;
	}

	public static function blocks_content() {
	    return apply_filters( 'cityo_listing_single_place_content', array(
	        'description' => esc_html__( 'Description', 'cityo' ),
	        'maps' => esc_html__( 'Maps', 'cityo' ),
	        'amenities' => esc_html__( 'Amenities', 'cityo' ),
	        'photos' => esc_html__( 'Photos', 'cityo' ),
	        'video' => esc_html__( 'Video', 'cityo' ),
	        'products' => esc_html__( 'Products', 'cityo' ),
	        'comments' => esc_html__( 'Reviews', 'cityo' ),
	    ));
	}

	public static function blocks_sidebar_content() {
	    return apply_filters( 'cityo_listing_single_place_sidebar', array(
	        'detail-car' => esc_html__( 'Detail', 'cityo' ),
	        'business-info' => esc_html__( 'Business Info', 'cityo' ),
	        'contact-form' => esc_html__( 'Contact Business', 'cityo' ),
	        'nearby' => esc_html__( 'Nearby Places', 'cityo' ),
	        'nearby_browse' => esc_html__( 'Browse Nearby Places', 'cityo' ),
	        'review-avg' => esc_html__( 'Review Average', 'cityo' ),
	        'statistic' => esc_html__( 'Statistic', 'cityo' ),
	        'tags' => esc_html__( 'Tags', 'cityo' ),
	        'claim' => esc_html__( 'Claim Listing', 'cityo' ),
	        'products-sidebar' => esc_html__( 'Products', 'cityo' ),
	    ));
	}
	
	public static function elementor_widgets() {
		get_template_part( 'inc/vendors/wp-job-manager/car/widgets/listings' );
		get_template_part( 'inc/vendors/wp-job-manager/car/widgets/search_form' );
	}

	public static function get_job_listings_query_args($query_args, $args, $datas) {
		if ( isset($query_args['meta_query']) ) {
			$meta_query = $query_args['meta_query'];
		} else {
			$meta_query = array();
		}

		if (isset($datas['search_contract']) && $datas['search_contract']) {
			$meta_query[] = array(
	           'key' => '_job_contract',
	           'value' => $datas['search_contract'],
	           'compare' => '=',
		   	);
		}

		if (isset($datas['search_year']) && $datas['search_year']) {
			$meta_query[] = array(
	           'key' => '_job_year',
	           'value' => $datas['search_year'],
	           'compare' => '=',
		   	);
		}
		if (isset($datas['search_transmission']) && $datas['search_transmission']) {
			$meta_query[] = array(
	           'key' => '_job_transmission',
	           'value' => $datas['search_transmission'],
	           'compare' => '=',
		   	);
		}
		if (isset($datas['search_mileage']) && $datas['search_mileage']) {
			$mileages = explode('-', $datas['search_mileage']);
			$mileages = array_map('trim', $mileages);
			if ( count($mileages) == 2 ) {
				$meta_query[] = array(
		           'key' => '_job_mileage',
		           'value' => $mileages,
		           'type'    => 'NUMERIC',
		           'compare' => 'BETWEEN',
			   	);
			}
		}
		if (isset($datas['search_interior_color']) && $datas['search_interior_color']) {
			$meta_query[] = array(
	           'key' => '_job_interior_color',
	           'value' => $datas['search_interior_color'],
	           'compare' => '=',
		   	);
		}
		if (isset($datas['search_exterior_color']) && $datas['search_exterior_color']) {
			$meta_query[] = array(
	           'key' => '_job_exterior_color',
	           'value' => $datas['search_exterior_color'],
	           'compare' => '=',
		   	);
		}
		if (isset($datas['search_fuel_type']) && $datas['search_fuel_type']) {
			$meta_query[] = array(
	           'key' => '_job_fuel_type',
	           'value' => $datas['search_fuel_type'],
	           'compare' => '=',
		   	);
		}
		if (isset($datas['search_condition']) && $datas['search_condition']) {
			$meta_query[] = array(
	           'key' => '_job_condition',
	           'value' => $datas['search_condition'],
	           'compare' => '=',
		   	);
		}

		if ( isset($datas['filter_price_from']) && isset($datas['filter_price_to']) ) {
			$price_meta_query = array( 'relation' => 'AND' );
			if ( isset($datas['filter_price_from']) ) {
				$price_meta_query[] = array(
		           	'key' => '_job_price',
		           	'value' => $datas['filter_price_from'],
		           	'compare'   => '>=',
					'type'      => 'NUMERIC',
		       	);
			}
			if ( isset($datas['filter_price_to']) ) {
				$price_meta_query[] = array(
		           	'key' => '_job_price',
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

Cityo_Type_Car::init();