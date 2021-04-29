<?php
/**
 * favorite
 *
 * @package    apus-cityo
 * @author     ApusTheme <apusthemes@gmail.com >
 * @license    GNU General Public License, version 3
 * @copyright  13/06/2016 ApusTheme
 */
 
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
 
class ApusCityo_Fields_Manager {

	public static function init() {
        add_action( 'admin_menu', array( __CLASS__, 'register_page' ), 1 );
        add_action( 'init', array(__CLASS__, 'init_hook'), 10 );
	}

    public static function register_page() {
        add_submenu_page( 'edit.php?post_type=job_listing', __( 'Fields Manager', 'apus-cityo' ), __( 'Fields Manager', 'apus-cityo' ), 'manage_options', 'job-manager-fields-manager', array( __CLASS__, 'output' ) );
    }

    public static function init_hook() {

        // custom fields
        add_action( 'wp_ajax_apuscityo_custom_field_html', array( __CLASS__, 'custom_field_html' ) );
        add_action( 'wp_ajax_nopriv_apuscityo_custom_field_html', array( __CLASS__, 'custom_field_html' ) );

        add_action( 'wp_ajax_apuscityo_custom_field_available_html', array( __CLASS__, 'custom_field_available_html' ) );
        add_action( 'wp_ajax_nopriv_apuscityo_custom_field_available_html', array( __CLASS__, 'custom_field_available_html' ) );


        add_action( 'admin_enqueue_scripts', array( __CLASS__, 'scripts' ), 1 );
    }

    public static function scripts() {
        wp_enqueue_style( 'wp-color-picker' );
        wp_enqueue_style('fonticonpicker', APUSCITYO_PLUGIN_URL. 'assets/admin/jquery.fonticonpicker.min.css', array(), '1.0');
        wp_enqueue_style('fonticonpicker.bootstrap', APUSCITYO_PLUGIN_URL. 'assets/admin/jquery.fonticonpicker.bootstrap.min.css', array(), '1.0');

        
        wp_enqueue_style('apuscityo-custom-field-css', APUSCITYO_PLUGIN_URL . 'assets/admin/style.css');
        wp_register_script('apuscityo-custom-field', APUSCITYO_PLUGIN_URL.'assets/admin/functions.js', array('jquery', 'wp-color-picker'), '', true);

        $args = array(
            'plugin_url' => APUSCITYO_PLUGIN_URL,
            'ajax_url' => admin_url('admin-ajax.php'),
        );
        wp_localize_script('apuscityo-custom-field', 'apuscityo_customfield_common_vars', $args);
        wp_enqueue_script('apuscityo-custom-field');

        wp_enqueue_script('apuscityo-custom-field-sortable', APUSCITYO_PLUGIN_URL.'assets/admin/sortable.js', array('jquery'), '', true);
        wp_enqueue_script('apuscityo-custom-field-app', APUSCITYO_PLUGIN_URL.'assets/admin/app.js', array('jquery'), '', true);

        // for range slider
        wp_enqueue_script('jquery-ui', APUSCITYO_PLUGIN_URL. 'assets/admin/jquery-ui.js', array(), '1.0', false);
        wp_enqueue_style('jquery-ui', APUSCITYO_PLUGIN_URL.'assets/admin/jquery-ui.css');
        
        // Localize the script
        wp_localize_script('apuscityo-icons', 'apuscityo_icons_vars', $args);

        wp_enqueue_script('fonticonpicker', APUSCITYO_PLUGIN_URL. 'assets/admin/jquery.fonticonpicker.min.js', array(), '1.0', true);
    }

    public static function output() {

        self::save();
        $listing_types = apply_filters( 'apuscityo-all-listing-types', array() );
        $listing_type_val = get_option('default_listing_type', 'place');
        ?>
        <h1><?php echo esc_html__('Fields manager', 'apus-cityo'); ?></h1>

        <form class="job-manager-options" method="post" action="admin.php?page=job-manager-fields-manager">
            <?php if ( defined('APUSCITYO_DEMO_MODE') && APUSCITYO_DEMO_MODE ) { ?>
                <div class="form-group">
                    <h3 class="title"><?php echo esc_html__('Choose Listing Type', 'apus-cityo'); ?></h3>
                    
                    <div class="style-wrapper">
                        <?php $i = 0; foreach ($listing_types as $key => $value) {
                            $checked = '';
                            if ( ($i == 0 && empty($listing_type_val)) || $listing_type_val == $key ) {
                                $checked = 'checked="checked"';
                            }
                        ?>
                            <div class="style-item <?php echo esc_attr(($i == 0 && empty($listing_type_val)) || $listing_type_val == $key ? 'active' : ''); ?>">
                                <label for="apuscityo-listing-card-style-<?php echo esc_attr($key); ?>">
                                    <img src="<?php echo esc_url($value['img']); ?>">
                                    <h4><?php echo $value['title']; ?></h4>
                                    <input id="apuscityo-listing-card-style-<?php echo esc_attr($key); ?>" type="radio" name="apuscityo-listing-type" value="<?php echo esc_attr($key); ?>" <?php echo trim($checked); ?>>
                                </label>
                            </div>
                        <?php $i++; } ?>
                        <div class="clearfix" style="clear: both;"></div>
                    </div>
                    <br>
                    <div class="show-when-type-changed">
                        <p><?php esc_html_e('Please update your listing type first', 'apus-cityo'); ?></p>
                    </div>
                </div>
            <?php } else {
                if ( isset($listing_types[$listing_type_val]) ) {
                    ?>
                    <div class="form-group hidden">
                        <h3 class="title"><?php echo esc_html__('Your Listing Type', 'apus-cityo'); ?></h3>
                        
                        <div class="style-wrapper">
                            
                            <div class="style-item active">
                                <label for="apuscityo-listing-card-style-<?php echo esc_attr($listing_type_val); ?>">
                                    <img src="<?php echo esc_url($listing_types[$listing_type_val]['img']); ?>">
                                    <h4><?php echo $listing_types[$listing_type_val]['title']; ?></h4>
                                    <input id="apuscityo-listing-card-style-<?php echo esc_attr($listing_type_val); ?>" type="radio" name="apuscityo-listing-type" value="<?php echo esc_attr($listing_type_val); ?>" checked="checked">
                                </label>
                            </div>

                            <div class="clearfix" style="clear: both;"></div>
                        </div>
                    </div>
                    <?php
                }
            } ?>
            <button type="submit" class="button button-primary" name="updateListingType"><?php esc_html_e('Update', 'apus-cityo'); ?></button>
            
            <?php echo ApusCityo_Template_Loader::get_template_part( 'admin/fields-settings', array('listing_type_val' => $listing_type_val) ); ?>
            
        </form>
        <?php
    }

    public static function save() {
        if ( isset( $_POST['updateListingType'] ) ) {

            $listing_type_old = $listing_type = get_option('default_listing_type');
            if ( isset($_POST['apuscityo-listing-type']) ) {
                if ( $listing_type_old != $_POST['apuscityo-listing-type'] ) {
                    update_option('default_listing_type', $_POST['apuscityo-listing-type']);
                    $url =  "//{$_SERVER['HTTP_HOST']}{$_SERVER['REQUEST_URI']}";
                    wp_redirect($url);
                    return;
                }
            }
            $custom_field_final_array = $counts = $contents_counts = $contents_sidebar_counts = $contents_field_final_array = $contents_sidebar_field_final_array = array();
            if (isset($_POST['apuscityo-custom-fields-type']) && sizeof($_POST['apuscityo-custom-fields-type']) > 0) {
                $field_index = 0;

                foreach ($_POST['apuscityo-custom-fields-type'] as $field_type) {
                    $custom_fields_id = isset($_POST['apuscityo-custom-fields-id'][$field_index]) ? $_POST['apuscityo-custom-fields-id'][$field_index] : '';
                    $counter = 0;
                    if ( isset($counts[$field_type]) ) {
                        $counter = $counts[$field_type];
                    }
                    $custom_field_final_array[] = self::custom_field_ready_array($counter, $field_type, $custom_fields_id);
                    $counter++;
                    $counts[$field_type] = $counter;
                    $field_index++;
                }
            }
            
            update_option('custom_'.$listing_type.'_fields_data', $custom_field_final_array);
            
        }
    }

    public static function custom_field_ready_array($array_counter = 0, $field_type = '', $custom_fields_id = '') {
        $custom_field_element_array = array();
        $custom_field_element_array['type'] = $field_type;
        if ( !empty($_POST["apuscityo-custom-fields-{$field_type}"]) ) {
            foreach ($_POST["apuscityo-custom-fields-{$field_type}"] as $field => $value) {
                if ( isset($value[$custom_fields_id]) ) {
                    $custom_field_element_array[$field] = $value[$custom_fields_id];
                } elseif ( isset($value[$array_counter]) ) {
                    $custom_field_element_array[$field] = $value[$array_counter];
                }
            }
        }

        return $custom_field_element_array;
    }

    public static function custom_field_html() {
        $fieldtype = $_POST['fieldtype'];
        $global_custom_field_counter = $_REQUEST['global_custom_field_counter'];
        $li_rand_id = rand(454, 999999);
        $html = '<li class="custom-field-class-' . $li_rand_id . '">';
        $types = apuscityo_get_all_field_types();
        if ( in_array($fieldtype, $types) ) {
            if ( in_array( $fieldtype, array('text', 'textarea', 'wp-editor', 'number', 'url', 'email', 'checkbox') ) ) {
                $html .= apply_filters( 'apuscityo_custom_field_text_html', $fieldtype, $global_custom_field_counter, '' );
            } elseif ( in_array( $fieldtype, array('select', 'multiselect', 'radio') ) ) {
                $html .= apply_filters( 'apuscityo_custom_field_opts_html', $fieldtype, $global_custom_field_counter, '' );
            } else {
                $html .= apply_filters('apuscityo_custom_field_'.$fieldtype.'_html', $fieldtype, $global_custom_field_counter, '');
            }
        }
        // action btns
        $html .= apply_filters('apuscityo_custom_field_actions_html', $li_rand_id, $global_custom_field_counter, $fieldtype);
        $html .= '</li>';
        echo json_encode( array('html' => $html) );
        wp_die();
    }

    public static function custom_field_available_html() {
        $fieldtype = $_POST['fieldtype'];
        $global_custom_field_counter = $_REQUEST['global_custom_field_counter'];
        $li_rand_id = rand(454, 999999);
        $html = '<li class="custom-field-class-' . $li_rand_id . '">';
        $types = apuscityo_all_types_available_fields();

        if ( isset($types[$fieldtype]) ) {

            $dtypes = apply_filters( 'apuscityo_list_simple_type', array('job_title', 'job_hours', 'job_email', 'job_tagline', 'job_location', 'job_email', 'job_website', 'job_phone', 'job_video', 'job_date', 'job_start_date', 'job_finish_date', 'job_socials', 'job_price_from', 'job_price_to', 'job_price_range', 'job_hours', 'job_menu_prices', 'job_tags', 'job_event_schedule', 'job_event_sponsors', 'job_event_speakers', 'job_regions', 'job_categories', /* real estate */  'job_rooms', 'job_beds', 'job_baths', 'job_garages', 'job_home_area', 'job_lot_demensions', 'job_lot_area', 'job_price', 'job_price_prefix', 'job_price_suffix', 'job_floor_plans', 'job_year_built', /* car*/ 'job_nb_of_door', 'job_max_passengers', 'job_fuel_per_100', 'job_mileage', 'job_displacement' ) );
            if ( in_array( $fieldtype, $dtypes ) ) {
                $html .= apply_filters( 'apuscityo_custom_field_available_simple_html', $fieldtype, $global_custom_field_counter, $types[$fieldtype] );
            } elseif ( in_array( $fieldtype, array('job_category', 'job_amenities', 'job_type') ) ) {
                $html .= apply_filters( 'apuscityo_custom_field_available_tax_html', $fieldtype, $global_custom_field_counter, $types[$fieldtype] );
            } elseif ( in_array($fieldtype, array( 'job_logo', 'job_cover_image' ) )) {
                $html .= apply_filters( 'apuscityo_custom_field_available_file_html', $fieldtype, $global_custom_field_counter, $types[$fieldtype] );
            } elseif ( in_array($fieldtype, array( 'job_gallery', 'job_gallery_images') )) {
                $html .= apply_filters( 'apuscityo_custom_field_available_files_html', $fieldtype, $global_custom_field_counter, $types[$fieldtype] );
            } elseif ( in_array($fieldtype, array( 'job_contract', 'job_condition', 'job_fuel_type', 'job_interior_color', 'job_exterior_color', 'job_transmission', 'job_year') )) {
                $html .= apply_filters( 'apuscityo_custom_field_available_select_option_html', $fieldtype, $global_custom_field_counter, $types[$fieldtype] );
            } else {
                $html .= apply_filters( 'apuscityo_custom_field_available_'.$fieldtype.'_html', $fieldtype, $global_custom_field_counter, $types[$fieldtype] );
            }
        }

        // action btns
        $html .= apply_filters('apuscityo_custom_field_actions_html', $li_rand_id, $global_custom_field_counter, $fieldtype);
        $html .= '</li>';
        echo json_encode(array('html' => $html));
        wp_die();
    }

}

ApusCityo_Fields_Manager::init();


