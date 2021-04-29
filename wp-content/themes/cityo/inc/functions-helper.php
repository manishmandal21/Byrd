<?php

if ( ! function_exists( 'cityo_body_classes' ) ) {
	function cityo_body_classes( $classes ) {
		global $post, $apus_cityo_listing_type;
		$classes[] = 'listing-type-'.$apus_cityo_listing_type;
		if ( is_page() && is_object($post) ) {
			$class = get_post_meta( $post->ID, 'apus_page_extra_class', true );
			if ( !empty($class) ) {
				$classes[] = trim($class);
			}

			if ( $post->ID == get_option('job_manager_jobs_page_id') || basename( get_page_template() ) == 'page-listing.php') {
				$version = cityo_get_listing_archive_version();
				$halfmaps = cityo_get_listing_all_half_map_version();
				if ( in_array($version, $halfmaps) ) {
					$classes[] = 'no-footer fix-header';
				}
				$sidebar_position = cityo_get_archive_layout();
				if ($version == 'default' && $sidebar_position == 'main') {
					$classes[] = 'listings-default-main';
				}
				
			} else {
				$transparent = get_post_meta( $post->ID, 'apus_page_header_transparent', true );
				if ( $transparent == 'yes' ) {
					$classes[] = 'header_transparent';
				}
			}
		}
		if ( cityo_get_config('image_lazy_loading') ) {
			$classes[] = 'image-lazy-loading';
		}
		if ( cityo_get_config('preload', true) ) {
			$classes[] = 'apus-body-loading';
		}
		// no breadscrumb
		$post_type = get_query_var('post_type');
		if ( is_singular('post') || is_category() ) {
			$show = cityo_get_config('show_blog_breadcrumbs', true);
			if ( !$show  ) {
				$classes[] = 'no-breadscrumb';
			}
		} elseif ( is_post_type_archive('job_listing') || is_tax('job_listing_tag') || is_tax('job_listing_amenity') || is_tax('job_listing_category') || is_tax('job_listing_region') || is_tax('job_listing_type') || ( is_search() && $post_type == 'job_listing' )) {
			$classes[] = ' archive-jobs-listings ';
			$show_bread = cityo_get_config('show_listing_breadcrumbs', true);
			$show = true;
			if ( !is_singular('job_listing') ) {
				$version = cityo_get_listing_archive_version();
				$halfmaps = cityo_get_listing_all_half_map_version();
				if ( in_array($version, $halfmaps) ) {
					$show = false;
					$classes[] = 'no-footer fix-header';
				} else {
					$classes[] = 'listings-default-layout';
				}
				$sidebar_position = cityo_get_archive_layout();
				if ($version == 'default' && $sidebar_position == 'main') {
					$classes[] = 'listings-default-main';
				}
			} else {
				$show = false;
				
			}
			if ( !$show_bread || !$show  ) {
				$classes[] = 'no-breadscrumb';
			}

		} elseif ( is_singular('job_listing') ) {
			$version = cityo_get_listing_single_version();
			$classes[] = $version;
			if ( in_array($version, apply_filters( 'cityo_single_listing_v1', array('place-v1', 'event-v1', 'car-v1', 'real-estate-v1') ) ) ) {
				$classes[] = 'header_transparent';
			}
		}
		return $classes;
	}
	add_filter( 'body_class', 'cityo_body_classes' );
}

if ( ! function_exists( 'cityo_get_shortcode_regex' ) ) {
	function cityo_get_shortcode_regex( $tagregexp = '' ) {
		// WARNING! Do not change this regex without changing do_shortcode_tag() and strip_shortcode_tag()
		// Also, see shortcode_unautop() and shortcode.js.
		return
			'\\['                                // Opening bracket
			. '(\\[?)'                           // 1: Optional second opening bracket for escaping shortcodes: [[tag]]
			. "($tagregexp)"                     // 2: Shortcode name
			. '(?![\\w-])'                       // Not followed by word character or hyphen
			. '('                                // 3: Unroll the loop: Inside the opening shortcode tag
			. '[^\\]\\/]*'                   // Not a closing bracket or forward slash
			. '(?:'
			. '\\/(?!\\])'               // A forward slash not followed by a closing bracket
			. '[^\\]\\/]*'               // Not a closing bracket or forward slash
			. ')*?'
			. ')'
			. '(?:'
			. '(\\/)'                        // 4: Self closing tag ...
			. '\\]'                          // ... and closing bracket
			. '|'
			. '\\]'                          // Closing bracket
			. '(?:'
			. '('                        // 5: Unroll the loop: Optionally, anything between the opening and closing shortcode tags
			. '[^\\[]*+'             // Not an opening bracket
			. '(?:'
			. '\\[(?!\\/\\2\\])' // An opening bracket not followed by the closing shortcode tag
			. '[^\\[]*+'         // Not an opening bracket
			. ')*+'
			. ')'
			. '\\[\\/\\2\\]'             // Closing shortcode tag
			. ')?'
			. ')'
			. '(\\]?)';                          // 6: Optional second closing brocket for escaping shortcodes: [[tag]]
	}
}

if ( ! function_exists( 'cityo_tagregexp' ) ) {
	function cityo_tagregexp() {
		return apply_filters( 'cityo_custom_tagregexp', 'video|audio|playlist|video-playlist|embed|cityo_media' );
	}
}

if ( !function_exists('cityo_get_header_layouts') ) {
	function cityo_get_header_layouts() {
		$headers = array();
		$args = array(
			'posts_per_page'   => -1,
			'offset'           => 0,
			'orderby'          => 'date',
			'order'            => 'DESC',
			'post_type'        => 'apus_header',
			'post_status'      => 'publish',
			'suppress_filters' => true 
		);
		$posts = get_posts( $args );
		foreach ( $posts as $post ) {
			$headers[$post->post_name] = $post->post_title;
		}
		return $headers;
	}
}

if ( !function_exists('cityo_get_header_layout') ) {
	function cityo_get_header_layout() {
		global $post;
		if ( is_page() && is_object($post) && isset($post->ID) ) {
			global $post;
			$header = get_post_meta( $post->ID, 'apus_page_header_type', true );
			if ( empty($header) || $header == 'global' ) {
				return cityo_get_config('header_type');
			}
			return $header;
		}
		return cityo_get_config('header_type');
	}
	add_filter( 'cityo_get_header_layout', 'cityo_get_header_layout' );
}

if ( !function_exists('cityo_display_header_builder') ) {
	function cityo_display_header_builder($header_slug) {
		$args = array(
			'name'        => $header_slug,
			'post_type'   => 'apus_header',
			'post_status' => 'publish',
			'numberposts' => 1
		);
		$posts = get_posts($args);
		foreach ( $posts as $post ) {
			$classes = array('apus-header visible-lg');
			$classes[] = $post->post_name.'-'.$post->ID;
			if ( !cityo_get_config('keep_header') ) {
				$classes[] = 'no-sticky';
			}
			echo '<div id="apus-header" class="'.esc_attr(implode(' ', $classes)).'">';
			if ( cityo_get_config('keep_header') ) {
				echo '<div class="main-sticky-header-wrapper">';
		        echo '<div class="main-sticky-header">';
		    }
				echo apply_filters( 'cityo_generate_post_builder', do_shortcode( $post->post_content ), $post, $post->ID);
			if ( cityo_get_config('keep_header') ) {
				echo '</div>';
		        echo '</div>';
		    }
			echo '</div>';
		}
	}
}

if ( !function_exists('cityo_get_footer_layouts') ) {
	function cityo_get_footer_layouts() {
		$footers = array();
		$args = array(
			'posts_per_page'   => -1,
			'offset'           => 0,
			'orderby'          => 'date',
			'order'            => 'DESC',
			'post_type'        => 'apus_footer',
			'post_status'      => 'publish',
			'suppress_filters' => true 
		);
		$posts = get_posts( $args );
		foreach ( $posts as $post ) {
			$footers[$post->post_name] = $post->post_title;
		}
		return $footers;
	}
}

if ( !function_exists('cityo_get_footer_layout') ) {
	function cityo_get_footer_layout() {
		if ( is_page() ) {
			global $post;
			$footer = '';
			if ( is_object($post) && isset($post->ID) ) {
				$footer = get_post_meta( $post->ID, 'apus_page_footer_type', true );
				if ( empty($footer) || $footer == 'global' ) {
					return cityo_get_config('footer_type', '');
				}
			}
			return $footer;
		}
		return cityo_get_config('footer_type', '');
	}
	add_filter('cityo_get_footer_layout', 'cityo_get_footer_layout');
}

if ( !function_exists('cityo_display_footer_builder') ) {
	function cityo_display_footer_builder($footer_slug) {
		$show_footer_desktop_mobile = cityo_get_config('show_footer_desktop_mobile', false);
		$args = array(
			'name'        => $footer_slug,
			'post_type'   => 'apus_footer',
			'post_status' => 'publish',
			'numberposts' => 1
		);
		$posts = get_posts($args);
		foreach ( $posts as $post ) {
			$classes = array('apus-footer footer-builder-wrapper');
			if ( !$show_footer_desktop_mobile ) {
				$classes[] = '';
			}
			$classes[] = $post->post_name;


			echo '<div id="apus-footer-inner" class="'.esc_attr(implode(' ', $classes)).'">';
			echo '<div class="apus-footer-inner">';
			echo apply_filters( 'cityo_generate_post_builder', do_shortcode( $post->post_content ), $post, $post->ID);
			echo '</div>';
			echo '</div>';
		}
	}
}

if ( !function_exists('cityo_blog_content_class') ) {
	function cityo_blog_content_class( $class ) {
		$page = 'archive';
		if ( is_singular( 'post' ) ) {
            $page = 'single';
        }
		if ( cityo_get_config('blog_'.$page.'_fullwidth') ) {
			return 'container-fluid no-padding';
		}
		return $class;
	}
}
add_filter( 'cityo_blog_content_class', 'cityo_blog_content_class', 1 , 1  );


if ( !function_exists('cityo_get_blog_layout_configs') ) {
	function cityo_get_blog_layout_configs() {
		$page = 'archive';
		$addition_class = '';
		if ( is_singular( 'post' ) ) {
            $page = 'single';
            $addition_class = 'main-content-only';
        }
		$left = cityo_get_config('blog_'.$page.'_left_sidebar');
		$right = cityo_get_config('blog_'.$page.'_right_sidebar');

		switch ( cityo_get_config('blog_'.$page.'_layout') ) {
		 	case 'left-main':
		 		if ( is_active_sidebar( $left ) ) {
			 		$configs['left'] = array( 'sidebar' => $left, 'class' => 'col-md-4 sidebar-blog col-sm-12 col-xs-12'  );
			 		$configs['main'] = array( 'class' => 'col-md-8 col-sm-12 col-xs-12 pull-right' );
			 	}
		 		break;
		 	case 'main-right':
		 		if ( is_active_sidebar( $right ) ) {
			 		$configs['right'] = array( 'sidebar' => $right,  'class' => 'col-md-4 sidebar-blog col-sm-12 col-xs-12 pull-right' ); 
			 		$configs['main'] = array( 'class' => 'col-md-8 col-sm-12 col-xs-12' );
			 	}
		 		break;
	 		case 'main':
	 			$configs['main'] = array( 'class' => 'col-md-12 col-sm-12 col-xs-12 '.$addition_class );
	 			break;
		 	default:
		 		if ( is_active_sidebar( 'sidebar-default' ) ) {
			 		$configs['right'] = array( 'sidebar' => 'sidebar-default',  'class' => 'col-md-4 sidebar-blog col-sm-12 col-xs-12 pull-right' ); 
			 		$configs['main'] = array( 'class' => 'col-md-8 col-sm-12 col-xs-12' );
			 	}
		 		break;
		}

		if ( empty($configs) ) {
			if ( is_active_sidebar( 'sidebar-default' ) ) {
				$configs['right'] = array( 'sidebar' => 'sidebar-default',  'class' => 'col-md-4 sidebar-blog col-sm-12 col-xs-12 pull-right' ); 
		 		$configs['main'] = array( 'class' => 'col-md-8 col-sm-12 col-xs-12' );
		 	} else {
		 		$configs['main'] = array( 'class' => 'col-md-12 col-sm-12 col-xs-12 '.$addition_class );
		 	}
		}

		return $configs; 
	}
}

if ( !function_exists('cityo_page_content_class') ) {
	function cityo_page_content_class( $class ) {
		global $post;
		if (is_object($post)) {
			$fullwidth = get_post_meta( $post->ID, 'apus_page_fullwidth', true );

			if ( !$fullwidth || $fullwidth == 'no' ) {
				return $class;
			}
		}
		return 'container-fluid';
	}
}
add_filter( 'cityo_page_content_class', 'cityo_page_content_class', 1 , 1  );

if ( !function_exists('cityo_get_page_layout_configs') ) {
	function cityo_get_page_layout_configs() {
		global $post;
		if ( is_object($post) ) {
			$sidebar = get_post_meta( $post->ID, 'apus_page_sidebar', true );

			switch ( get_post_meta( $post->ID, 'apus_page_layout', true ) ) {
			 	case 'left-main':
			 		if ( is_active_sidebar( $sidebar ) ) {
				 		$configs['left'] = array( 'sidebar' => $sidebar, 'class' => 'col-md-4 col-sm-12 col-xs-12'  );
				 		$configs['main'] = array( 'class' => 'col-md-8 col-sm-12 col-xs-12' );
				 	}
			 		break;
			 	case 'main-right':
			 		if ( is_active_sidebar( $sidebar ) ) {
				 		$configs['right'] = array( 'sidebar' => $sidebar,  'class' => 'col-md-4 col-sm-12 col-xs-12' ); 
				 		$configs['main'] = array( 'class' => 'col-md-8 col-sm-12 col-xs-12' );
				 	}
			 		break;
		 		case 'main':
		 			$configs['main'] = array( 'class' => 'col-xs-12' );
		 			break;
			 	default:
			 		if ( cityo_is_woocommerce_activated() && (is_cart() || is_checkout()) ) {
			 			$configs['main'] = array( 'class' => 'col-xs-12' );
			 		} elseif ( is_active_sidebar( 'sidebar-default' ) ) {
				 		$configs['right'] = array( 'sidebar' => 'sidebar-default',  'class' => 'col-md-4 col-sm-12 col-xs-12 pull-right' ); 
			 			$configs['main'] = array( 'class' => 'col-md-8 col-sm-12 col-xs-12' );
			 		}
			 		break;
			}

			if ( empty($configs) ) {
				if ( is_active_sidebar( 'sidebar-default' ) ) {
					$configs['right'] = array( 'sidebar' => 'sidebar-default',  'class' => 'col-md-4 col-sm-12 col-xs-12 pull-right' ); 
			 		$configs['main'] = array( 'class' => 'col-md-8 col-sm-12 col-xs-12' );
			 	} else {
			 		$configs['main'] = array( 'class' => 'col-xs-12' );
			 	}
			}
		} else {
			$configs['main'] = array( 'class' => 'col-md-12 col-xs-12' );
		}
		return $configs; 
	}
}

if ( !function_exists('cityo_page_header_layout') ) {
	function cityo_page_header_layout() {
		global $post;
		$header = get_post_meta( $post->ID, 'apus_page_header_type', true );
		if ( $header == 'global' ) {
			return cityo_get_config('header_type');
		}
		return $header;
	}
}

if ( ! function_exists( 'cityo_get_first_url_from_string' ) ) {
	function cityo_get_first_url_from_string( $string ) {
		$pattern = "/^\b(?:(?:https?|ftp):\/\/)[-a-z0-9+&@#\/%?=~_|!:,.;]*[-a-z0-9+&@#\/%=~_|]/i";
		preg_match( $pattern, $string, $link );

		$link_return = ( ! empty( $link[0] ) ) ? $link[0] : false;
		$content = str_replace($link_return, "", $string);
        $content = apply_filters( 'the_content', $content);
        return array( 'link' => $link_return, 'content' => $content );
	}
}

if ( !function_exists( 'cityo_get_link_attributes' ) ) {
	function cityo_get_link_attributes( $string ) {
		preg_match( '/<a href="(.*?)">/i', $string, $atts );

		return ( ! empty( $atts[1] ) ) ? $atts[1] : '';
	}
}

if ( !function_exists( 'cityo_post_media' ) ) {
	function cityo_post_media( $content ) {
		$is_video = ( get_post_format() == 'video' ) ? true : false;
		$media = cityo_get_first_url_from_string( $content );
		$media = $media['link'];
		if ( ! empty( $media ) ) {
			global $wp_embed;
			$content = do_shortcode( $wp_embed->run_shortcode( '[embed]' . $media . '[/embed]' ) );
		} else {
			$pattern = cityo_get_shortcode_regex( cityo_tagregexp() );
			preg_match( '/' . $pattern . '/s', $content, $media );
			if ( ! empty( $media[2] ) ) {
				if ( $media[2] == 'embed' ) {
					global $wp_embed;
					$content = do_shortcode( $wp_embed->run_shortcode( $media[0] ) );
				} else {
					$content = do_shortcode( $media[0] );
				}
			}
		}
		if ( ! empty( $media ) ) {
			$output = '<div class="entry-media">';
			$output .= ( $is_video ) ? '<div class="pro-fluid"><div class="pro-fluid-inner">' : '';
			$output .= $content;
			$output .= ( $is_video ) ? '</div></div>' : '';
			$output .= '</div>';

			return $output;
		}

		return false;
	}
}

if ( !function_exists( 'cityo_post_gallery' ) ) {
	function cityo_post_gallery( $content, $args = array() ) {
		$output = '';
		$defaults = array( 'size' => 'large' );
		$args = wp_parse_args( $args, $defaults );
	    $gallery_filter = cityo_gallery_from_content( $content );
	    if (count($gallery_filter['ids']) > 0) {
        	$output .= '<div class="slick-carousel post-gallery-slick" data-carousel="slick" data-smallmedium="2" data-extrasmall="1" data-items="3" data-pagination="false" data-nav="true">';
                foreach($gallery_filter['ids'] as $attach_id) {
                    $output .= '<div class="gallery-item">';
                    $output .= wp_get_attachment_image($attach_id, $args['size'] );
                    $output .= '</div>';
                }
            $output .= '</div>';
        }
        return $output;
	}
}

if (!function_exists('cityo_gallery_from_content')) {
    function cityo_gallery_from_content($content) {

        $result = array(
            'ids' => array(),
            'filtered_content' => ''
        );

        preg_match('/\[gallery.*ids=.(.*).\]/', $content, $ids);
        if(!empty($ids)) {
            $result['ids'] = explode(",", $ids[1]);
            $content =  str_replace($ids[0], "", $content);
            $result['filtered_content'] = apply_filters( 'the_content', $content);
        }

        return $result;

    }
}

if ( !function_exists( 'cityo_random_key' ) ) {
    function cityo_random_key($length = 5) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $return = '';
        for ($i = 0; $i < $length; $i++) {
            $return .= $characters[rand(0, strlen($characters) - 1)];
        }
        return $return;
    }
}

if ( !function_exists('cityo_substring') ) {
    function cityo_substring($string, $limit, $afterlimit = '[...]') {
        if ( empty($string) ) {
        	return $string;
        }
       	$string = explode(' ', strip_tags( $string ), $limit);

        if (count($string) >= $limit) {
            array_pop($string);
            $string = implode(" ", $string) .' '. $afterlimit;
        } else {
            $string = implode(" ", $string);
        }
        $string = preg_replace('`[[^]]*]`','',$string);
        return strip_shortcodes( $string );
    }
}

function cityo_get_user_url($user_id, $nicename, $tags = array()) {
	$url = get_author_posts_url( $user_id, $nicename );
	if ( !empty($tags) ) {
		foreach ($tags as $tag => $value) {
			$url = add_query_arg( $tag, $value, remove_query_arg( $tag, $url ) );
		}
	}
	return apply_filters('cityo_get_user_url', $url, $user_id, $tags);
}


function cityo_is_apus_framework_activated() {
	return defined('APUS_FRAMEWORK_VERSION') ? true : false;
}

function cityo_is_cmb2_activated() {
	return defined('CMB2_LOADED') ? true : false;
}

function cityo_is_woocommerce_activated() {
	return class_exists( 'woocommerce' ) ? true : false;
}

function cityo_is_revslider_activated() {
	return function_exists( 'putRevSlider' );
}

function cityo_is_dokan_activated() {
	return class_exists( 'WeDevs_Dokan' ) ? true : false;
}

function cityo_is_wp_job_manager_activated() {
	return class_exists( 'WP_Job_Manager' ) ? true : false;
}

function cityo_is_apus_wc_paid_listings_activated() {
	return class_exists( 'ApusWJMWCPaidListings' ) ? true : false;
}

function cityo_is_mailchimp_activated() {
	return class_exists( 'MC4WP_Form_Manager' ) ? true : false;
}

function cityo_is_wp_private_message() {
	return class_exists( 'WP_Private_Message' ) ? true : false;
}

function cityo_marital_status_defaults() {
	return apply_filters( 'cityo_marital_status_defaults', array(
		'single' => esc_html__('Single', 'cityo'),
		'engaged' => esc_html__('Engaged', 'cityo'),
		'married' => esc_html__('Married', 'cityo'),
		'separated' => esc_html__('Separated', 'cityo'),
		'divorced' => esc_html__('Divorced', 'cityo'),
		'widow' => esc_html__('Widow', 'cityo'),
		'widower' => esc_html__('Widower', 'cityo'),
	) );
}

function cityo_sex_defaults() {
	return apply_filters( 'cityo_sex_defaults', array(
		'male' => esc_html__('Male', 'cityo'),
		'female' => esc_html__('Female', 'cityo'),
		'other' => esc_html__('Other', 'cityo')
	) );
}

function cityo_user_social_defaults() {
	return apply_filters( 'cityo_user_social_defaults', array(
		'facebook' => esc_html__('Facebook', 'cityo'),
		'twitter' => esc_html__('Twitter', 'cityo'),
		'google-plus' => esc_html__('Google+', 'cityo'),
		'pinterest' => esc_html__('Pinterest', 'cityo'),
		'linkedin' => esc_html__('Linkedin', 'cityo'),
		'instagram' => esc_html__('Instagram', 'cityo'),
	) );
}

function cityo_get_attachment_id_from_url( $attachment_url = '' ) {

	global $wpdb;
	$attachment_id = false;

	// If there is no url, bail.
	if ( '' == $attachment_url ) {
		return false;
	}

	// Get the upload directory paths
	$upload_dir_paths = wp_upload_dir();

	// Make sure the upload path base directory exists in the attachment URL, to verify that we're working with a media library image
	if ( false !== strpos( $attachment_url, $upload_dir_paths['baseurl'] ) ) {

		// If this is the URL of an auto-generated thumbnail, get the URL of the original image
		$attachment_url = preg_replace( '/-\d+x\d+(?=\.(jpg|jpeg|png|gif)$)/i', '', $attachment_url );

		// Remove the upload path base directory from the attachment URL
		$attachment_url = str_replace( $upload_dir_paths['baseurl'] . '/', '', $attachment_url );

		// Finally, run a custom database query to get the attachment ID from the modified attachment URL
		$attachment_id = $wpdb->get_var( $wpdb->prepare( "SELECT wposts.ID FROM $wpdb->posts wposts, $wpdb->postmeta wpostmeta WHERE wposts.ID = wpostmeta.post_id AND wpostmeta.meta_key = '_wp_attached_file' AND wpostmeta.meta_value = '%s' AND wposts.post_type = 'attachment'", $attachment_url ) );

	}

	return $attachment_id;
}

function cityo_create_attachment( $attachment_url, $post_id = 0 ) {
	include_once ABSPATH . 'wp-admin/includes/image.php';
	include_once ABSPATH . 'wp-admin/includes/media.php';

	$upload_dir     = wp_upload_dir();
	$attachment_url = esc_url( $attachment_url, array( 'http', 'https' ) );
	if ( empty( $attachment_url ) ) {
		return 0;
	}

	$attachment_url = str_replace( array( $upload_dir['baseurl'], WP_CONTENT_URL, site_url( '/' ) ), array( $upload_dir['basedir'], WP_CONTENT_DIR, ABSPATH ), $attachment_url );
	if ( empty( $attachment_url ) || ! is_string( $attachment_url ) ) {
		return 0;
	}

	$attachment = array(
		'post_title'   => esc_html__('Attachment Image', 'cityo'),
		'post_content' => '',
		'post_status'  => 'inherit',
		'post_parent'  => $post_id,
		'guid'         => $attachment_url,
	);

	$info = wp_check_filetype( $attachment_url );
	if ( $info ) {
		$attachment['post_mime_type'] = $info['type'];
	}

	$attachment_id = wp_insert_attachment( $attachment, $attachment_url, $post_id );

	if ( ! is_wp_error( $attachment_id ) ) {
		wp_update_attachment_metadata( $attachment_id, wp_generate_attachment_metadata( $attachment_id, $attachment_url ) );
		return $attachment_id;
	}

	return 0;
}
