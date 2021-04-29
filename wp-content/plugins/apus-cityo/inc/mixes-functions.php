<?php
/**
 * functions
 *
 * @package    apus-cityo
 * @author     ApusTheme <apusthemes@gmail.com >
 * @license    GNU General Public License, version 3
 * @copyright  13/06/2016 ApusTheme
 */
 
if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

/**
 * batch including all files in a path.
 *
 * @param String $path : PATH_DIR/*.php or PATH_DIR with $ifiles not empty
 */
function apuscityo_includes( $path, $ifiles=array() ){

    if( !empty($ifiles) ){
         foreach( $ifiles as $key => $file ){
            $file  = $path.'/'.$file; 
            if(is_file($file)){
                require($file);
            }
         }   
    }else {
        $files = glob($path);
        foreach ($files as $key => $file) {
            if(is_file($file)){
                require($file);
            }
        }
    }
}

function apuscityo_get_config($name, $default = '') {
    global $apus_options;
    if ( isset($apus_options[$name]) ) {
        return $apus_options[$name];
    }
    return $default;
}

function apuscityo_removefilter($tag, $args) {
    remove_filter( $tag, $args );
}

function apuscityo_addmetaboxes($fnc) {
    add_action( 'add_meta_boxes', $fnc );
}

function apuscityo_addmetabox($key, $title, $fnc, $textdomain, $position, $priority, $args = null){
    add_meta_box( $key, $title, $fnc, $textdomain, $position, $priority, $args );
}

function apuscityo_image_srcset($size_array, $src, $image_meta, $attachment_id) {
    return wp_calculate_image_srcset($size_array, $src, $image_meta, $attachment_id);
}

function apus_wjm_send_mail($to, $subject, $message, $headers){
    return wp_mail( $to, $subject, $message, $headers );
}


function apuscityo_get_default_field_types() {
    
    $fields = apply_filters( 'apuscityo_get_default_field_types', array(
        array(
            'title' => esc_html__('Direct Input', 'apuscityo-types'),
            'fields' => array(
                'text' => esc_html__('Text', 'apuscityo-types'),
                'textarea' => esc_html__('Textarea', 'apuscityo-types'),
                'wp-editor' => esc_html__('WP Editor', 'apuscityo-types'),
                'date' => esc_html__('Date', 'apuscityo-types'),
                'number' => esc_html__('Number', 'apuscityo-types'),
                'url' => esc_html__('Url', 'apuscityo-types'),
                'email' => esc_html__('Email', 'apuscityo-types'),
            )
        ),
        array(
            'title' => esc_html__('Choices', 'apuscityo-types'),
            'fields' => array(
                'select' => esc_html__('Select', 'apuscityo-types'),
                'multiselect' => esc_html__('Multiselect', 'apuscityo-types'),
                'checkbox' => esc_html__('Checkbox', 'apuscityo-types'),
                'radio' => esc_html__('Radio Buttons', 'apuscityo-types'),
            )
        ),
        array(
            'title' => esc_html__('Form UI', 'apuscityo-types'),
            'fields' => array(
                'heading' => esc_html__('Heading', 'apuscityo-types')
            )
        ),
        array(
            'title' => esc_html__('Others', 'apuscityo-types'),
            'fields' => array(
                'file' => esc_html__('File', 'apuscityo-types')
            )
        ),
    ));
    
    return $fields;
}

function apuscityo_get_all_field_types() {
    $fields = apuscityo_get_default_field_types();
    $return = array();
    foreach ($fields as $group) {
        foreach ($group['fields'] as $key => $value) {
            $return[] = $key;
        }
    }

    return apply_filters( 'apuscityo_get_all_field_types', $return );
}

function apuscityo_get_listing_type() {
    return get_option('default_listing_type', 'place');
}

function apuscityo_all_types_required_fields($listing_type = null) {
    if ( empty($listing_type) ) {
        $listing_type = apuscityo_get_listing_type();
    }
    return apply_filters( 'apuscityo-'.$listing_type.'-type-required-fields', array() );
}

function apuscityo_all_types_available_fields($listing_type = null) {
    if ( empty($listing_type) ) {
        $listing_type = apuscityo_get_listing_type();
    }
    return apply_filters( 'apuscityo-'.$listing_type.'-type-available-fields', array() );
}

function apuscityo_get_custom_fields_data($listing_type = null) {
    if ( empty($listing_type) ) {
        $listing_type = apuscityo_get_listing_type();
    }
    return apply_filters( 'apuscityo-'.$listing_type.'-get-custom-fields-data', get_option('custom_'.$listing_type.'_fields_data', array()) );
}

// block contents
function apuscityo_get_all_available_blocks_content($listing_type = null) {
    if ( empty($listing_type) ) {
        $listing_type = apuscityo_get_listing_type();
    }
    return apply_filters( 'apuscityo-'.$listing_type.'-get-all-available-blocks-content', array() );
}

function apuscityo_get_blocks_content_data($listing_type = null) {
    if ( empty($listing_type) ) {
        $listing_type = apuscityo_get_listing_type();
    }
    return apply_filters( 'apuscityo-'.$listing_type.'-get-blocks-content-data', get_option('blocks_content_'.$listing_type.'_data', array()) );
}

// block sidebar content
function apuscityo_get_all_available_blocks_sidebar_content($listing_type = null) {
    if ( empty($listing_type) ) {
        $listing_type = apuscityo_get_listing_type();
    }
    return apply_filters( 'apuscityo-'.$listing_type.'-get-all-available-blocks-sidebar-content', array() );
}

function apuscityo_get_blocks_sidebar_content_data($listing_type = null) {
    if ( empty($listing_type) ) {
        $listing_type = apuscityo_get_listing_type();
    }
    return apply_filters( 'apuscityo-'.$listing_type.'-get-sidebar-sidebar-content', get_option('blocks_sidebar_content_'.$listing_type.'_data', array()) );
}


function apuscityo_display_hooks() {
    return apply_filters( 'apuscityo_display_hooks', array() );
}

function apuscityo_icon_picker($value = '', $id = '', $name = '', $class = 'apuscityo-icon-pickerr') {

    $html = "
    <script>
    jQuery(document).ready(function ($) {
        setTimeout(function(){
            var e9_element = $('#icon_picker_".$id."').fontIconPicker({
                theme: 'fip-bootstrap',
                source: all_loaded_icons
            });
        }, 100);
    });
    </script>";

    $html .= '<input type="text" id="icon_picker_' . $id . '" class="' . $class . '" name="' . $name . '" value="' . $value . '">';

    return $html;
}




