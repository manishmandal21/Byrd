<?php 

class Cityo_Apus_Userinfo{

	/**
	 * Constructor 
	 */
	public function __construct() {
		
		add_action( 'init', array($this, 'setup'), 1000 );
		add_action( 'wp_ajax_nopriv_apus_ajax_login',  array($this, 'processLogin') );
		add_action( 'wp_ajax_nopriv_apus_ajax_forgotpass',  array($this, 'processForgotPassword') );
		add_action( 'wp_ajax_nopriv_apus_ajax_register',  array($this, 'processRegister') );

		add_action( 'wp_ajax_cityo_process_change_profile_form', array($this, 'process_change_profile_form') );
		add_action( 'wp_ajax_nopriv_cityo_process_change_profile_form',  array($this, 'process_change_profile_form') );

		add_action( 'wp_ajax_cityo_process_change_password', array($this, 'process_change_password') );
		add_action( 'wp_ajax_nopriv_cityo_process_change_password',  array($this, 'process_change_password') );


		// backend user profile
		add_action( 'show_user_profile', array($this, 'user_profile_fields') );
		add_action( 'edit_user_profile', array($this, 'user_profile_fields') );
		// backend save user profile
		add_action( 'personal_options_update', array( $this, 'save_user_profile_fields' ) );
		add_action( 'edit_user_profile_update', array( $this, 'save_user_profile_fields' ) );

		// get avatar
		add_filter('get_avatar', array($this, 'get_avatar'), 10, 100);

		// permission
		add_action('init', array($this, 'set_user_permissions'));
		add_action( 'pre_get_posts', array( $this, 'media_files' ) );

		add_action( 'admin_enqueue_scripts', array($this, 'admin_script') );
	}

	public static function all_employee_roles() {
		$roles = array( 'employer', 'administrator' );
		if ( cityo_is_dokan_activated() ) {
			$roles[] = 'seller';
		}
		return apply_filters('cityo_all_employee_roles', $roles);
	}

	public static function check_role_employee($user_roles) {
		$employee_roles = self::all_employee_roles();
		if ( !empty($user_roles) ) {
			if ( is_array($user_roles) ) {
				foreach ($employee_roles as $role) {
					if ( in_array($role, $user_roles) ) {
						return true;
					}
				}
			} elseif ( in_array($user_roles, $employee_roles) ) {
				return true;
			}
		}
		return false;
	}

	public function processLogin() {
		// First check the nonce, if it fails the function will break
   		check_ajax_referer( 'ajax-apus-login-nonce', 'security_login' );

   		$info = array();
   		
   		$info['user_login'] = isset($_POST['username']) ? $_POST['username'] : '';
	    $info['user_password'] = isset($_POST['password']) ? $_POST['password'] : '';
	    $info['remember'] = isset($_POST['remember']) ? true : false;

		$user_signon = wp_signon( $info, false );
	    if ( is_wp_error($user_signon) ){
			$result = json_encode(array('loggedin' => false, 'msg' => esc_html__('Wrong username or password. Please try again!!!', 'cityo')));
	    } else {
			wp_set_current_user($user_signon->ID); 
	        $result = json_encode(array('loggedin' => true, 'msg' => esc_html__('Signin successful, redirecting...', 'cityo')));
	    }

   		echo trim($result);
   		die();
	}

	public function processForgotPassword() {
	 	
		// First check the nonce, if it fails the function will break
	    check_ajax_referer( 'ajax-apus-lostpassword-nonce', 'security_lostpassword' );
		
		global $wpdb;
		
		$account = isset($_POST['user_login']) ? $_POST['user_login'] : '';
		
		if( empty( $account ) ) {
			$error = esc_html__( 'Enter an username or e-mail address.', 'cityo' );
		} else {
			if(is_email( $account )) {
				if( email_exists($account) ) {
					$get_by = 'email';
				} else {
					$error = esc_html__( 'There is no user registered with that email address.', 'cityo' );			
				}
			} else if (validate_username( $account )) {
				if( username_exists($account) ) {
					$get_by = 'login';
				} else {
					$error = esc_html__( 'There is no user registered with that username.', 'cityo' );				
				}
			} else {
				$error = esc_html__(  'Invalid username or e-mail address.', 'cityo' );		
			}
		}	
		
		if (empty ($error)) {
			$random_password = wp_generate_password();

			$user = get_user_by( $get_by, $account );
				
			$update_user = wp_update_user( array ( 'ID' => $user->ID, 'user_pass' => $random_password ) );
				
			if( $update_user ) {
				
				$from = get_option('admin_email');
				
				
				$to = $user->user_email;
				$subject = esc_html__( 'Your new password', 'cityo' );
				$sender = 'From: '.get_option('name').' <'.$from.'>' . "\r\n";
				
				$message = esc_html__( 'Your new password is: ', 'cityo' ) .$random_password;
					
				$headers[] = 'MIME-Version: 1.0' . "\r\n";
				$headers[] = 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
				$headers[] = "X-Mailer: PHP \r\n";
				$headers[] = $sender;
				
				$mail = false;
				if ( function_exists('apus_wjm_send_mail') ) {
					$mail = apus_wjm_send_mail( $to, $subject, $message, $headers );
				}
				
				if( $mail ) {
					$success = esc_html__( 'Check your email address for you new password.', 'cityo' );
				} else {
					$error = esc_html__( 'System is unable to send you mail containg your new password.', 'cityo' );						
				}
			} else {
				$error =  esc_html__( 'Oops! Something went wrong while updating your account.', 'cityo' );
			}
		}
	
		if ( ! empty( $error ) ) {
			echo json_encode(array('loggedin'=> false, 'msg'=> $error));
		}
				
		if ( ! empty( $success ) ) {
			echo json_encode(array('loggedin' => true, 'msg'=> $success ));	
		}
		die();
	}


	/**
	 * add all actions will be called when user login.
	 */
	public function setup() {
		add_action('wp_footer', array( $this, 'popupForm' ) );
		add_action( 'apus-account-buttons', array( $this, 'button' ) );
	}

	/**
	 * render link login or show greeting when user logined in
	 *
	 * @return String.
	 */
	public function button(){
		if ( !is_user_logged_in() ) {
			?>
			<div class="account-login">
				<ul class="login-account">
					<li><a href="#apus_login_forgot_tab" class="apus-user-login wel-user"><?php esc_html_e( 'Login','cityo' ); ?></a> </li>
					<li class="space">/</li>
					<li><a href="#apus_register_tab" class="apus-user-register wel-user"><?php esc_html_e( 'Register','cityo' ); ?></a></li>
				</ul>
			</div>
			<?php
		} else {
			$user_id = get_current_user_id();
            $user = get_userdata( $user_id );
			?>
			<div class="pull-right">
                <div class="setting-account">
            		<div class="profile-menus flex-middle clearfix">
                        <div class="profile-avarta pull-left"><?php echo get_avatar($user_id, 32); ?></div>
                        <div class="profile-info pull-left">
                            <span><?php echo esc_html($user->data->display_name); ?></span>
                            <span class="fas fa-angle-down"></span>
                        </div>
                    </div>
                    <div class="user-account">
	                    <ul class="user-log">
	                        
	                        <?php
	                        	if ( has_nav_menu( 'myaccount-menu' ) ) {
	                        		?>
	                        		<li>
		                        		<?php
				                            $args = array(
				                                'theme_location'  => 'myaccount-menu',
				                                'menu_class'      => 'list-line',
				                                'fallback_cb'     => '',
				                                'walker' => new Cityo_Nav_Menu()
				                            );
				                            wp_nav_menu($args);
			                            ?>
		                            </li>
		                            <?php
		                        } 
	                        ?>
	                        <li class="last"><a href="<?php echo esc_url(wp_logout_url(home_url('/'))); ?>"><?php esc_html_e('Log out ','cityo'); ?></a></li>
	                    </ul>
	                </div>
                </div>
            </div>
			<?php
		}
	}

	/**
	 * check if user not login that showing the form
	 */
	public function popupForm() {
		if ( !is_user_logged_in() ) {
 			get_template_part( 'template-parts/login-register' );
		}	
	}

	public function registration_validation( $username, $email, $password, $confirmpassword ) {
		global $reg_errors;
		$reg_errors = new WP_Error;
		if ( Cityo_Recaptcha::is_recaptcha_enabled() && cityo_get_config('use_recaptcha_register_form', true) ) {
			$is_recaptcha_valid = array_key_exists( 'g-recaptcha-response', $_POST ) ? Cityo_Recaptcha::is_recaptcha_valid( sanitize_text_field( $_POST['g-recaptcha-response'] ) ) : false;
			if ( !$is_recaptcha_valid ) {
				$reg_errors->add('field', esc_html__( 'reCAPTCHA is a required field', 'cityo' ) );
			}
		}
		if ( empty( $username ) || empty( $password ) || empty( $email ) || empty( $confirmpassword ) ) {
		    $reg_errors->add('field', esc_html__( 'Required form field is missing', 'cityo' ) );
		}

		if ( 4 > strlen( $username ) ) {
		    $reg_errors->add( 'username_length', esc_html__( 'Username too short. At least 4 characters is required', 'cityo' ) );
		}

		if ( username_exists( $username ) ) {
	    	$reg_errors->add('user_name', esc_html__( 'That username already exists!', 'cityo' ) );
		}

		if ( ! validate_username( $username ) ) {
		    $reg_errors->add( 'username_invalid', esc_html__( 'The username you entered is not valid', 'cityo' ) );
		}

		if ( 5 > strlen( $password ) ) {
	        $reg_errors->add( 'password', esc_html__( 'Password length must be greater than 5', 'cityo' ) );
	    }

	    if ( $password != $confirmpassword ) {
	        $reg_errors->add( 'password', esc_html__( 'Password must be equal Confirm Password', 'cityo' ) );
	    }

	    if ( !is_email( $email ) ) {
		    $reg_errors->add( 'email_invalid', esc_html__( 'Email is not valid', 'cityo' ) );
		}

		if ( email_exists( $email ) ) {
		    $reg_errors->add( 'email', esc_html__( 'Email Already in use', 'cityo' ) );
		}
	}

	public function complete_registration($username, $password, $email) {
        $userdata = array(
	        'user_login' => $username,
	        'user_email' => $email,
	        'user_pass' => $password,
        );
	    if ( isset($_POST['role']) && $_POST['role'] == 'owner') {
	    	if ( cityo_is_dokan_activated() ) {
	    		$userdata['role'] = 'seller';
	    	} else {
		        $userdata['role'] = 'employer';
		    }
	    }
        return wp_insert_user( $userdata );
	}

	public function processRegister() {
		global $reg_errors;
		check_ajax_referer( 'ajax-apus-register-nonce', 'security_register' );
        $this->registration_validation( $_POST['username'], $_POST['email'], $_POST['password'], $_POST['confirmpassword'] );
        if ( 1 > count( $reg_errors->get_error_messages() ) ) {
	        $username = sanitize_user( $_POST['username'] );
	        $email = sanitize_email( $_POST['email'] );
	        $password = esc_attr( $_POST['password'] );
	 		
	        $user_id = $this->complete_registration($username, $password, $email);
	        if ( ! is_wp_error( $user_id ) ) {

	        	$jsondata = array('loggedin' => true, 'msg' => esc_html__( 'You have registered, redirecting ...', 'cityo' ) );
	        	$info['user_login'] = $username;
			    $info['user_password'] = $password;
			    $info['remember'] = 1;
				
				wp_signon( $info, false );
	        } else {
		        $jsondata = array('loggedin' => false, 'msg' => esc_html__( 'Register user error!', 'cityo' ) );
		    }
	    } else {
	    	$jsondata = array('loggedin' => false, 'msg' => implode(', <br>', $reg_errors->get_error_messages()) );
	    }
	    echo json_encode($jsondata);
	    exit;
	}

	
	public function process_change_profile_form() {
		check_ajax_referer( 'cityo-ajax-edit-profile-nonce', 'security_edit_profile' );

		$return = array();
		$user = wp_get_current_user();

		$nickname = isset($_POST['nickname']) ? sanitize_user( $_POST['nickname'] ) : '';
		$email = isset($_POST['email']) ? sanitize_email( $_POST['email'] ) : '';

		$general_keys = array( 'first_name', 'last_name', 'phone', 'description', 'url' );
		$keys = array(
			'current_user_avatar', 'address', 'birthday', 'socials'
		);

		if ( empty( $nickname ) ) {
			$return['msg'] = '<div class="text-danger">'.esc_html__( 'Nickname is required.', 'cityo' ).'</div>';
			echo json_encode($return); exit;
		}

		if ( empty( $email ) ) {
			$return['msg'] = '<div class="text-danger">'.esc_html__( 'E-mail is required.', 'cityo' ).'</div>';
			echo json_encode($return); exit;
		}

		do_action('cityo_before_change_profile');

		update_user_meta( $user->ID, 'nickname', $nickname );

		update_user_meta( $user->ID, 'user_email', $email );
		wp_update_user( array(
			'ID'            => $user->ID,
			'user_email'    => $email,
		) );
		foreach ($general_keys as $key) {
			$value = isset($_POST[$key]) ? sanitize_text_field( $_POST[$key] ) : '';
			update_user_meta( $user->ID, $key, $value );
		}
		foreach ($keys as $key) {
			if ( $key !== 'socials' ) {
				$value = isset($_POST[$key]) ? sanitize_text_field( $_POST[$key] ) : '';
				if ( $key == 'current_user_avatar' ) {
					$attachment_id = cityo_create_attachment($value);
					update_user_meta( $user->ID, 'apus_user_avatar', $attachment_id );
				} else {
					update_user_meta( $user->ID, 'apus_'.$key, $value );
				}
			} else {
				$value = isset($_POST[$key]) ? $_POST[$key] : '';
				update_user_meta( $user->ID, 'apus_'.$key, $value );
			}
		}
		$return['msg'] = '<div class="text-success">'.esc_html__( 'Profile has been successfully updated.', 'cityo' ).'</div>';
		echo json_encode($return); exit;
	}

	public function process_change_password() {
		check_ajax_referer( 'cityo-ajax-change-pass-nonce', 'security_change_pass' );
		
		if ( !is_user_logged_in() ) {
			return;
		}

		$old_password = sanitize_text_field( $_POST['old_password'] );
		$new_password = sanitize_text_field( $_POST['new_password'] );
		$retype_password = sanitize_text_field( $_POST['retype_password'] );

		if ( empty( $old_password ) || empty( $new_password ) || empty( $retype_password ) ) {
			$return['msg'] = '<div class="text-danger">'.esc_html__( 'All fields are required.', 'cityo' ).'</div>';
			echo json_encode($return); exit;
		}

		if ( $new_password != $retype_password ) {
			$return['msg'] = '<div class="text-danger">'.esc_html__( 'New and retyped password are not same.', 'cityo' ).'</div>';
			echo json_encode($return); exit;
		}
		
		do_action('cityo_before_change_password');

		$user = wp_get_current_user();

		if ( ! wp_check_password( $old_password, $user->data->user_pass, $user->ID ) ) {
			$return['msg'] = '<div class="text-danger">'.esc_html__( 'Your old password is not correct.', 'cityo' ).'</div>';
			echo json_encode($return); exit;
		}

		wp_set_password( $new_password, $user->ID );
		
    	$info['user_login'] = $user->nickname;
	    $info['user_password'] = $new_password;
	    $info['remember'] = 1;
		wp_signon( $info, false );

		$return['msg'] = '<div class="text-success">'.esc_html__( 'Your password has been successfully changed.', 'cityo' ).'</div>';
		echo json_encode($return); exit;
	}

	public function get_avatar($avatar, $id_or_email='', $size='', $default='', $alt='') {
	    if (is_object($id_or_email)) {
	        
	        $avatar_id = get_the_author_meta( 'apus_user_avatar', $id_or_email->ID );
	        if ( !empty($avatar_id) ) {
	            $avatar_url = wp_get_attachment_image_src($avatar_id, 'thumbnail');
	            if ( !empty($avatar_url[0]) ) {
	                $avatar = '<img src="'.esc_url($avatar_url[0]).'" width="'.esc_attr($size).'" height="'.esc_attr($size).'" alt="'.esc_attr($alt).'" class="avatar avatar-'.esc_attr($size).' wp-user-avatar wp-user-avatar-'.esc_attr($size).' photo avatar-default" />';
	            }
	        }
	    } else {
	        $avatar_id = get_the_author_meta( 'apus_user_avatar', $id_or_email );
	        if ( !empty($avatar_id) ) {
	            $avatar_url = wp_get_attachment_image_src($avatar_id, 'thumbnail');
	            if ( !empty($avatar_url[0]) ) {
	                $avatar = '<img src="'.esc_url($avatar_url[0]).'" width="'.esc_attr($size).'" height="'.esc_attr($size).'" alt="'.esc_attr($alt).'" class="avatar avatar-'.esc_attr($size).' wp-user-avatar wp-user-avatar-'.esc_attr($size).' photo avatar-default" />';
	            }
	        }
	    }
	    return $avatar;
	}

	public function set_user_permissions() {
        $role = get_role( 'subscriber' );
        if ( is_object($role) ) {
	        $role->add_cap('upload_files');
	    }

        $role = get_role( 'customer' );
        if ( is_object($role) ) {
	        $role->add_cap('upload_files');
	    }
	}

	public function media_files( $wp_query ) {
		global $current_user;

		if ( ! current_user_can( 'manage_options' ) && ( is_admin() && $wp_query->query['post_type'] === 'attachment' ) ) {
			$wp_query->set( 'author', $current_user->ID );
		}
	}

	public function admin_script() {
		wp_enqueue_media();
		wp_enqueue_script( 'cityo-upload', get_template_directory_uri() . '/js/upload.js', array( 'jquery' ), '20150330', true );
	}
	/*
	 * back/end settings
	 *
	 */
	function user_profile_fields( $user ) {
		$data = get_userdata( $user->ID );
		$avatar = get_the_author_meta( 'apus_user_avatar', $user->ID );
		$avatar_url = wp_get_attachment_image_src($avatar, 'full');
		
		$address = get_the_author_meta( 'apus_address', $user->ID );
		$birthday = get_the_author_meta( 'apus_birthday', $user->ID );
		$marital_status = get_the_author_meta( 'apus_marital_status', $user->ID );
		$sex = get_the_author_meta( 'apus_sex', $user->ID );
		?>
		<h3><?php esc_html_e( 'User Profile', 'cityo' ); ?></h3>

		<table class="form-table">
			<tbody>
			
			<tr>
				<th>
					<label for="lecturer_job"><?php esc_html_e( 'Avatar', 'cityo' ); ?></label>
				</th>
				<td>
					<div class="screenshot-user avatar-screenshot">
			            <?php if ( !empty($avatar_url[0]) ) { ?>
			                <img src="<?php echo esc_url($avatar_url[0]); ?>" alt="<?php esc_attr_e( 'Avatar', 'cityo' ); ?>" />
			            <?php } ?>
			        </div>
			        <input class="widefat upload_image" name="current_user_avatar" type="hidden" value="<?php echo esc_attr($avatar); ?>" />
			        <div class="upload_image_action">
			            <input type="button" class="button radius-3x btn btn-theme user-add-image" value="<?php esc_attr_e( 'Add Avatar', 'cityo' ); ?>">
			            <input type="button" class="button radius-3x btn btn-theme-second user-remove-image" value="<?php esc_attr_e( 'Remove Avatar', 'cityo' ); ?>">
			        </div>
				</td>
			</tr>
			<tr>
				<th>
					<label for="lecturer_mobile"><?php esc_html_e( 'Address', 'cityo' ); ?></label>
				</th>
				<td>
					<input id="change-profile-form-address" type="text" name="address" class="form-control" value="<?php echo ! empty( $address ) ? esc_attr( $address ) : ''; ?>">
				</td>
			</tr>
			<tr>
				<th>
					<label for="lecturer_facebook"><?php esc_html_e( 'Birthday', 'cityo' ); ?></label>
				</th>
				<td>
					<input id="change-profile-form-birthday" type="text" name="birthday" class="form-control" value="<?php echo ! empty( $birthday ) ? esc_attr( $birthday ) : ''; ?>">
				</td>
			</tr>
			<?php
				$options = cityo_user_social_defaults();
				$socials = get_user_meta( $user->ID, 'apus_socials', true );
				foreach ($options as $key => $label) {
					$value = isset($socials[$key]) ? $socials[$key] : '';
					?>
					<tr>
						<th>
							<label class="col-sm-2 control-label <?php echo esc_attr($key); ?>" for="change-profile-form-<?php echo esc_attr($key); ?>"> <i class="icon-<?php echo esc_attr($key); ?>"></i> <?php echo esc_attr($label); ?></label>
						</th>
						<td>
							<input id="change-profile-form-<?php echo esc_attr($key); ?>" type="text" name="socials[<?php echo esc_attr($key); ?>]" class="form-control" value="<?php echo esc_attr( $value ); ?>">
						</td>
					</tr><!-- /.form-group -->
					<?php
				}
			?>
			</tbody>
		</table>
		<?php
	}

	public function save_user_profile_fields( $user_id ) {
		if ( !current_user_can( 'edit_user', $user_id ) ) {
			return false;
		}

		$keys = array(
			'current_user_avatar', 'address', 'birthday', 'socials'
		);

		foreach ($keys as $key) {
			if ( $key !== 'socials' ) {
				$value = isset($_POST[$key]) ? sanitize_text_field( $_POST[$key] ) : '';
				update_user_meta( $user_id, 'apus_'.$key, $value );
			} else {
				$value = isset($_POST[$key]) ? $_POST[$key] : '';
				update_user_meta( $user_id, 'apus_'.$key, $value );
			}
		}
	}

}

new Cityo_Apus_Userinfo();
?>