<?php
/**
 * bookmark
 *
 * @package    cityo
 * @author     ApusTheme <apusthemes@gmail.com >
 * @license    GNU General Public License, version 3
 * @copyright  13/06/2016 ApusTheme
 */
 
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
 
class Cityo_Bookmark {
	
	public static function init() {
		add_action( 'wp_ajax_cityo_add_bookmark', array(__CLASS__, 'add_bookmark') );
		add_action( 'wp_ajax_nopriv_cityo_add_bookmark', array(__CLASS__, 'add_bookmark') );
		add_action( 'wp_ajax_cityo_remove_bookmark', array(__CLASS__, 'remove_bookmark') );
		add_action( 'wp_ajax_nopriv_cityo_remove_bookmark', array(__CLASS__, 'remove_bookmark') );

		add_filter( 'job_manager_settings', array(__CLASS__, 'settings'), 10, 1 );
	}

	public static function add_bookmark() {
		check_ajax_referer( 'cityo-ajax-nonce', 'security' );

		do_action('cityo_before_add_bookmak');
		if ( isset($_GET['post_id']) && $_GET['post_id'] ) {
			self::save_wishlist($_GET['post_id']);
			$result['status'] = 'success';
			$result['msg'] = esc_html__('Added bookmark successful.', 'cityo');
		} else {
			$result['status'] = 'error';
			$result['msg'] = esc_html__('Add bookmark error.', 'cityo');
		}
		echo json_encode($result);
		die();
	}

	public static function remove_bookmark() {
		check_ajax_referer( 'cityo-ajax-nonce', 'security' );
		do_action('cityo_before_remove_bookmak');
		if ( isset($_GET['post_id']) && $_GET['post_id'] ) {
			$user_id = get_current_user_id();
			$data = get_user_meta($user_id, '_bookmark', true);
			if (is_array($data)) {
				foreach ($data as $key => $value) {
					if ( $_GET['post_id'] == $value ) {
						unset($data[$key]);
					}
				}
			}
			update_user_meta( $user_id, '_bookmark', $data );
			// count bookmark
			$counts = intval( get_post_meta($_GET['post_id'], '_bookmark_count', true) );
		    if( $counts != '' ) {
		        $counts--;
		    } else {
		        $counts = 0;
		    }
		    update_post_meta( $_GET['post_id'], '_bookmark_count', $counts );
			$result['status'] = 'success';
			$result['msg'] = esc_html__('Removed bookmark successful.', 'cityo');
		} else {
			$result['status'] = 'error';
			$result['msg'] = esc_html__('Remove bookmark error.', 'cityo');
		}
		echo json_encode($result);
		die();
	}

	public static function get_bookmark() {
		$user_id = get_current_user_id();
		$data = get_user_meta($user_id, '_bookmark', true);
		return $data;
	}

	public static function save_wishlist($post_id) {
		$user_id = get_current_user_id();
		$data = get_user_meta($user_id, '_bookmark', true);
		if ( is_array($data) ) {
			if ( !in_array($post_id, $data) ) {
				$data[] = $post_id;
				update_user_meta( $user_id, '_bookmark', $data );
				// count bookmark
				$counts = intval( get_post_meta($post_id, '_bookmark_count', true) );
			    if( $counts != '' ) {
			        $counts++;
			    } else {
			        $counts = 1;
			    }
			    update_post_meta( $post_id, '_bookmark_count', $counts );
			}
		} else {
			$data = array($post_id);
			update_user_meta( $user_id, '_bookmark', $data );
			// count bookmark
			$counts = 1;
		    update_post_meta( $post_id, '_bookmark_count', $counts );
		}
	}

	public static function check_listing_added($post_id) {
		$data = self::get_bookmark();
		if ( !is_array($data) || !in_array($post_id, $data) ) {
			return false;
		}
		return true;
	}


	public static function get_bookmark_page() {
		return get_option('job_manager_bookmark_page_id');
	}

	public static function settings($args) {
		$args['job_pages'][1][] = array(
			'name' 		=> 'job_manager_bookmark_page_id',
			'std' 		=> '',
			'label' 	=> esc_html__( 'Apus Bookmark Listings Page', 'cityo' ),
			'desc'		=> esc_html__( 'Select the page where you have placed the visual composer element "Apus My Bookmark". This lets the plugin know where the job listings page is located.', 'cityo' ),
			'type'      => 'page'
		);
		return $args;
	}

	public static function get_listings( $ids, $post_per_page = -1, $paged = 1 ) {
		if ( empty($ids) || !is_array($ids) ) {
			return false;
		}
		$args = array(
			'post_type' => 'job_listing',
			'posts_per_page' => $post_per_page,
			'ignore_sticky_posts' => true,
			'paged' => $paged,
			'post__in' => $ids
		);

		$wp_query = new WP_Query( $args );
		return $wp_query;
	}

	public static function display_bookmark_btn( $post ) {
		$post_id = $post->ID;
		$class = '';
		$icon_class = 'flaticon-like';
		if ( !is_user_logged_in() ) {
			$class = 'apus-bookmark-not-login';
		} else {
			$added = Cityo_Bookmark::check_listing_added($post_id);
			if ($added) {
				$class = 'apus-bookmark-added';
				$icon_class = 'flaticon-like';
			} else {
				$class = 'apus-bookmark-add';
			}
		}
		?>
		<div class="listing-btn-wrapper listing-bookmark">
			<a href="#apus-bookmark-add" class="<?php echo esc_attr($class); ?>" data-id="<?php echo esc_attr($post_id); ?>">
				<i class="<?php echo esc_attr($icon_class); ?>"></i><span class="bookmark-text"><?php esc_html_e( 'Save', 'cityo' ); ?></span>
			</a>
		</div>
		<?php
	}

	public static function display_bookmark_btn_detail() {
		$post_id = get_the_ID();
		$class = '';
		$icon_class = 'flaticon-like';
		if ( !is_user_logged_in() ) {
			$class = 'apus-bookmark-not-login';
		} else {
			$added = Cityo_Bookmark::check_listing_added($post_id);
			if ($added) {
				$class = 'apus-bookmark-added';
				$icon_class = 'flaticon-like';
			} else {
				$class = 'apus-bookmark-add';
			}
		}
		?>
		<a href="#apus-bookmark-add" class="<?php echo esc_attr($class); ?> btn-bookmark btn" data-id="<?php echo esc_attr($post_id); ?>">
			<i class="<?php echo esc_attr($icon_class); ?>"></i>
			<span class="bookmark-text"><?php esc_html_e( 'Save', 'cityo' ); ?></span>
		</a>
		<?php
	}
}

Cityo_Bookmark::init();