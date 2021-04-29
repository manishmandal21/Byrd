<?php
/**
 * Shows the `text` form field on job listing forms.
 *
 * This template can be overridden by copying it to yourtheme/job_manager/form-fields/text-field.php.
 *
 * @see         https://wpjobmanager.com/document/template-overrides/
 * @author      Automattic
 * @package     WP Job Manager
 * @category    Template
 * @version     1.27.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
global $post, $thepostid;
if ( is_admin() ) {
	wp_enqueue_script( 'jquery-highlight', get_template_directory_uri() . '/js/jquery.highlight.js', array( 'jquery' ), '5', true );
	wp_enqueue_script( 'leaflet', get_template_directory_uri() . '/js/leaflet/leaflet.js', array( 'jquery' ), '1.5.1', true );
	wp_enqueue_script( 'leaflet-GoogleMutant', get_template_directory_uri() . '/js/leaflet/Leaflet.GoogleMutant.js', array( 'jquery' ), '1.5.1', true );
	wp_enqueue_script( 'control-geocoder', get_template_directory_uri() . '/js/leaflet/Control.Geocoder.js', array( 'jquery' ), '1.5.1', true );
	wp_enqueue_script( 'esri-leaflet', get_template_directory_uri() . '/js/leaflet/esri-leaflet.js', array( 'jquery' ), '1.5.1', true );
    wp_enqueue_script( 'esri-leaflet-geocoder', get_template_directory_uri() . '/js/leaflet/esri-leaflet-geocoder.js', array( 'jquery' ), '1.5.1', true );

	wp_enqueue_script( 'leaflet-markercluster', get_template_directory_uri() . '/js/leaflet/leaflet.markercluster.js', array( 'jquery' ), '1.5.1', true );
	wp_enqueue_script( 'leaflet-HtmlIcon', get_template_directory_uri() . '/js/leaflet/LeafletHtmlIcon.js', array( 'jquery' ), '1.5.1', true );
}
wp_enqueue_script( 'listing-location', get_template_directory_uri() . '/js/listing-location.js', array('jquery'), '20141010', true );
$mapbox_token = '';
$mapbox_style = '';
$custom_style = '';
$map_service = cityo_get_config('listing_map_style_type', '');
if ( $map_service == 'mapbox' ) {
	$mapbox_token = cityo_get_config('listing_mapbox_token', '');
	$mapbox_style = cityo_get_config('listing_mapbox_style', 'streets-v11');
	if ( empty($mapbox_style) || !in_array($mapbox_style, array( 'streets-v11', 'light-v10', 'dark-v10', 'outdoors-v11', 'satellite-v9' )) ) {
		$mapbox_style = 'streets-v11';
	}
} else {
	$custom_style = cityo_get_config('listing_map_custom_style', '');
}
wp_localize_script( 'listing-location', 'cityo_listing_map_opts', array(
	'map_service' => $map_service,
	'mapbox_token' => $mapbox_token,
	'mapbox_style' => $mapbox_style,
	'custom_style' => $custom_style,
	'geocoder_country' => cityo_get_config('listing_map_geocoder_country', ''),
));

if ( $thepostid ) {
	$job_id = $thepostid;
} else {
	$job_id = ! empty( $_REQUEST['job_id'] ) ? absint( $_REQUEST['job_id'] ) : 0;
}

$geo_latitude = get_post_meta( $job_id, 'geolocation_lat', true );
$geo_longitude = get_post_meta( $job_id, 'geolocation_long', true );
?>
<div class="cityo-location-field">
	<div class="row flex-middle-sm">
		<div class="col-md-6 col-xs-12">
			<?php if ( ! empty( $field['label'] ) ) : ?>
				<fieldset>
					<label><?php echo wp_kses_post($field['label']); ?></label>
				</fieldset>
			<?php endif; ?>
			
			<div class="cityo-location-field-inner">
				<input type="text" class="input-text input-location-field" name="<?php echo esc_attr( isset( $field['name'] ) ? $field['name'] : $key ); ?>"<?php if ( isset( $field['autocomplete'] ) && false === $field['autocomplete'] ) { echo ' autocomplete="off"'; } ?> id="<?php echo esc_attr( $key ); ?>" placeholder="<?php echo esc_attr( $field['placeholder'] ); ?>" value="<?php echo isset( $field['value'] ) ? esc_attr( $field['value'] ) : ''; ?>" maxlength="<?php echo ! empty( $field['maxlength'] ) ? $field['maxlength'] : ''; ?>" <?php if ( ! empty( $field['required'] ) ) echo 'required'; ?> />

				<span class="find-me-location" title="<?php echo esc_attr__('Find Me', 'cityo'); ?>"><?php get_template_part( 'images/icon/location' ); ?></span>
				<span class="loading-me"></span>
				
			</div>
			<fieldset>
				<label><?php esc_html_e( 'Latitude', 'cityo' ); ?></label>
				<div class="field">
					<input class="geo_latitude" placeholder="<?php esc_attr_e('51.4980073', 'cityo'); ?>"  name="geo_latitude" value="<?php echo esc_attr( $geo_latitude); ?>" type="text">
				</div>
			</fieldset>
			<fieldset>
				<label><?php esc_html_e( 'Longitude', 'cityo' ); ?></label>
				<div class="field">
					<input class="geo_longitude" placeholder="<?php esc_attr_e('51.4980073', 'cityo'); ?>" name="geo_longitude" value="<?php echo esc_attr( $geo_longitude ); ?>" type="text">
				</div>
			</fieldset>
		</div>
		<div class="col-md-6 col-xs-12">
			<div id="cityo-location-field-map" class="cityo-location-field-map"></div>
		</div>
	</div>
</div>
<?php if ( ! empty( $field['description'] ) ) : ?><small class="description"><?php echo trim($field['description']); ?></small><?php endif; ?>