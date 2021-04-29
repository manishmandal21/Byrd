<?php
/**
 * Plugin Name: Apus Cityo
 * Plugin URI: http://apusthemes.com/apus-cityo/
 * Description: Apus Cityo is a plugin for Cityo directory listing theme
 * Version: 1.2
 * Author: ApusTheme
 * Author URI: http://apusthemes.com
 * Requires at least: 3.8
 * Tested up to: 5.2
 *
 * Text Domain: apus-cityo
 * Domain Path: /languages/
 *
 * @package apus-cityo
 * @category Plugins
 * @author ApusTheme
 */
if ( ! defined( 'ABSPATH' ) ) exit;

if( !class_exists("ApusCityo") ) {
	
	final class ApusCityo {

		private static $instance;

		public static function getInstance() {
			if ( ! isset( self::$instance ) && ! ( self::$instance instanceof ApusCityo ) ) {
				self::$instance = new ApusCityo;
				self::$instance->setup_constants();

				add_action( 'plugins_loaded', array( self::$instance, 'load_textdomain' ) );

				self::$instance->includes();
			}

			return self::$instance;
		}

		/**
		 *
		 */
		public function setup_constants(){
			// Plugin Folder Path
			if ( ! defined( 'APUSCITYO_PLUGIN_DIR' ) ) {
				define( 'APUSCITYO_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
			}

			// Plugin Folder URL
			if ( ! defined( 'APUSCITYO_PLUGIN_URL' ) ) {
				define( 'APUSCITYO_PLUGIN_URL', plugin_dir_url( __FILE__ ) );
			}

			// Plugin Root File
			if ( ! defined( 'APUSCITYO_PLUGIN_FILE' ) ) {
				define( 'APUSCITYO_PLUGIN_FILE', __FILE__ );
			}

			// Prefix
			if ( ! defined( 'APUSCITYO_PREFIX' ) ) {
				define( 'APUSCITYO_PREFIX', 'apus_cityo_' );
			}
		}

		public function includes() {
			global $apus_cityo_listing_type;
			// cmb2 custom field
			if ( ! class_exists( 'Taxonomy_MetaData_CMB2' ) ) {
				require_once APUSCITYO_PLUGIN_DIR . 'inc/vendors/cmb2/taxonomy/Taxonomy_MetaData_CMB2.php';
			}
			require_once APUSCITYO_PLUGIN_DIR . 'inc/mixes-functions.php';
			
			$apus_cityo_listing_type = apuscityo_get_listing_type();

			require_once APUSCITYO_PLUGIN_DIR . 'inc/class-template-loader.php';
			require_once APUSCITYO_PLUGIN_DIR . 'inc/class-claim.php';
			require_once APUSCITYO_PLUGIN_DIR . 'inc/class-fields-manager.php';
			require_once APUSCITYO_PLUGIN_DIR . 'inc/class-custom-fields-html.php';
			require_once APUSCITYO_PLUGIN_DIR . 'inc/class-custom-fields.php';
			require_once APUSCITYO_PLUGIN_DIR . 'inc/class-taxonomies.php';
			require_once APUSCITYO_PLUGIN_DIR . 'inc/class-custom-fields-display.php';
			

			require_once APUSCITYO_PLUGIN_DIR . 'inc/taxonomies/class-taxonomy-job-manager-amenities.php';
			require_once APUSCITYO_PLUGIN_DIR . 'inc/taxonomies/class-taxonomy-job-manager-categories.php';
			require_once APUSCITYO_PLUGIN_DIR . 'inc/taxonomies/class-taxonomy-job-manager-regions.php';
			require_once APUSCITYO_PLUGIN_DIR . 'inc/taxonomies/class-taxonomy-job-manager-tags.php';
			require_once APUSCITYO_PLUGIN_DIR . 'inc/taxonomies/class-taxonomy-job-manager-types.php';

			require_once APUSCITYO_PLUGIN_DIR . 'inc/post-types/class-post-type-job_claim.php';

			add_action( 'wp_enqueue_scripts', array( $this, 'scripts' ) );
		}
		public function scripts() {
			wp_register_script( 'apuscityo-scripts', APUSCITYO_PLUGIN_URL . 'assets/scripts.js', array( 'jquery' ), '', true );

			wp_localize_script( 'apuscityo-scripts', 'apuscityo_vars', array(
				'ajaxurl' => admin_url( 'admin-ajax.php' ),
			));
			wp_enqueue_script( 'apuscityo-scripts' );
		}
		/**
		 *
		 */
		public function load_textdomain() {
			// Set filter for ApusCityo's languages directory
			$lang_dir = dirname( plugin_basename( APUSCITYO_PLUGIN_FILE ) ) . '/languages/';
			$lang_dir = apply_filters( 'apuscityo_languages_directory', $lang_dir );

			// Traditional WordPress plugin locale filter
			$locale = apply_filters( 'plugin_locale', get_locale(), 'apus-cityo' );
			$mofile = sprintf( '%1$s-%2$s.mo', 'apus-cityo', $locale );

			// Setup paths to current locale file
			$mofile_local  = $lang_dir . $mofile;
			$mofile_global = WP_LANG_DIR . '/apus-cityo/' . $mofile;

			if ( file_exists( $mofile_global ) ) {
				// Look in global /wp-content/languages/apus-cityo folder
				load_textdomain( 'apus-cityo', $mofile_global );
			} elseif ( file_exists( $mofile_local ) ) {
				// Look in local /wp-content/plugins/apus-cityo/languages/ folder
				load_textdomain( 'apus-cityo', $mofile_local );
			} else {
				// Load the default language files
				load_plugin_textdomain( 'apus-cityo', false, $lang_dir );
			}
		}
	}
}

function ApusCityo() {
	return ApusCityo::getInstance();
}

ApusCityo();
