<h3 class="title-account"><?php echo esc_html__('Signin','cityo'); ?></h3>

<?php if ( defined('CITYO_DEMO_MODE') && CITYO_DEMO_MODE ) { ?>
	<div class="sign-in-demo-notice">
		Username: <strong>guest</strong> or <strong>owner</strong><br>
		Password: <strong>demo</strong>
	</div>
<?php } ?>
<div class="form-acount" tabindex="-1" role="dialog">
	<div class="inner">
		<div id="apus_login_form" class="form-container">
			<form class="apus-login-form" action="<?php echo esc_url( home_url( '/' ) ); ?>" method="post">
				<div class="form-group">
					<label class="hidden" for="username_or_email"><?php esc_html_e('Username Or Email', 'cityo'); ?></label>
	                <sup class="apus-required-field hidden">*</sup>
					<input autocomplete="off" type="text" name="username" class="form-control style2" id="username_or_email" placeholder="<?php esc_attr_e("Enter username or email",'cityo'); ?>">
				</div>
				<div class="form-group">
					<label class="hidden" for="login_password"><?php echo esc_html__("Password",'cityo'); ?></label>
	                <sup class="apus-required-field hidden">*</sup>
					<input name="password" type="password" class="password required form-control style2" id="login_password" placeholder="<?php esc_attr_e("Enter Password",'cityo'); ?>">
				</div>
				<div class="row flex-middle action-login">
					<div class="col-sm-6">
						<div class="form-group">
							<label for="apus-user-remember">
								<input type="checkbox" name="remember" id="apus-user-remember" value="true"> <?php echo esc_html__("Keep me signed in",'cityo'); ?>
							</label>
						</div>
					</div>
					<div class="col-sm-6 ali-right">
						<p>
							<a href="#apus_forgot_password_form" class="back-link" title="<?php esc_attr_e("Forgot Password",'cityo'); ?>"><?php echo esc_html__("Lost Your Password?",'cityo'); ?></a>
						</p>
					</div>
				</div>
				<div class="form-group clear-submit">
					<input type="submit" class="btn btn-theme btn-outline btn-block" name="submit" value="<?php esc_attr_e("Login",'cityo'); ?>"/>
				</div>
				<?php
					do_action('login_form');
					wp_nonce_field('ajax-apus-login-nonce', 'security_login');
				?>
			</form>

			<?php do_action('cityo_login_form'); ?>
		</div>
		<!-- reset form -->
		<div id="apus_forgot_password_form" class="form-container">
			<form name="forgotpasswordform" class="forgotpassword-form" action="<?php echo esc_url( site_url('wp-login.php?action=lostpassword', 'login_post') ); ?>" method="post">
				<h3><?php echo esc_html__('Reset Password', 'cityo'); ?></h3>
				<div class="lostpassword-fields">
					<div class="form-group">
						<label for="lostpassword_username" class="hidden"><?php echo esc_html__("Username or E-mail",'cityo'); ?></label>
                		<sup class="apus-required-field hidden">*</sup>
						<input type="text" name="user_login" class="user_login form-control style2" id="lostpassword_username" placeholder="<?php esc_attr_e("Username or E-mail",'cityo'); ?>">
					</div>
					<?php
						do_action('lostpassword_form');
						wp_nonce_field('ajax-apus-lostpassword-nonce', 'security_lostpassword');
					?>
					<div class="form-group">
						<input type="submit" class="btn btn-theme btn-block" name="wp-submit" value="<?php esc_attr_e('Get New Password', 'cityo'); ?>" tabindex="100" />
						<input type="button" class="btn btn-danger btn-block btn-cancel" value="<?php esc_attr_e('Cancel', 'cityo'); ?>" tabindex="101" />
					</div>
				</div>
					<div class="lostpassword-link"><a href="#apus_login_form" class="back-link text-danger"><?php echo esc_html__('Back To Login', 'cityo'); ?></a></div>
			</form>
		</div>
	</div>
</div>
<div class="bottom-login text-center">
	<?php echo esc_html__('Don\'t have an account','cityo') ?>
</div>