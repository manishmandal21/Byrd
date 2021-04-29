<h3 class="title-account"><?php echo esc_html__('Register','cityo'); ?></h3>
<?php if ( defined('CITYO_DEMO_MODE') && CITYO_DEMO_MODE ) { ?>
  <div class="sign-in-demo-notice">
    Username: <strong>guest</strong> or <strong>owner</strong><br>
    Password: <strong>demo</strong>
  </div>
<?php } ?>
<div class="form-register">
  <div class="inner">
  	<div class="container-form">
          <form name="apusRegisterForm" method="post" class="apus-register-form">
              <div id="apus-reg-loader-info" class="apus-loader hidden">
                  <span><?php esc_html_e('Please wait ...', 'cityo'); ?></span>
              </div>
              <div id="apus-register-alert" class="alert alert-danger" role="alert" style="display:none;"></div>
              <div id="apus-mail-alert" class="alert alert-danger" role="alert" style="display:none;"></div>

              <div class="form-group no-margin">
                  <div class="flex-middle list-roles">
                    <div class="role-wrapper">
                      <input id="guest" type="radio" name="role" value="guest" checked="checked">
                      <label for="guest"><?php esc_html_e('Guest', 'cityo'); ?></label>
                    </div>
                    <div class="role-wrapper">
                      <input id="owner" type="radio" name="role" value="owner">
                      <label for="owner"><?php esc_html_e('Owner', 'cityo'); ?></label>
                    </div>
                  </div>
              </div>

             	<div class="form-group">
                	<label class="hidden" for="username"><?php esc_html_e('Username', 'cityo'); ?></label>
                	<sup class="apus-required-field hidden">*</sup>
                	<input type="text" class="form-control style2" name="username" id="username" placeholder="<?php esc_attr_e("Enter Username",'cityo'); ?>">
            	</div>
            	<div class="form-group">
                	<label class="hidden" for="reg-email"><?php esc_html_e('Email', 'cityo'); ?></label>
                	<sup class="apus-required-field hidden">*</sup>
                	<input type="text" class="form-control style2" name="email" id="reg-email" placeholder="<?php esc_attr_e("Enter Email",'cityo'); ?>">
            	</div>
              <div class="form-group">
                  <label class="hidden" for="password"><?php esc_html_e('Password', 'cityo'); ?></label>
                  <sup class="apus-required-field hidden">*</sup>
                  <input type="password" class="form-control style2" name="password" id="password" placeholder="<?php esc_attr_e("Enter Password",'cityo'); ?>">
              </div>
              <div class="form-group space-bottom-30">
                  <label class="hidden" for="confirmpassword"><?php esc_html_e('Confirm Password', 'cityo'); ?></label>
                  <sup class="apus-required-field hidden">*</sup>
                  <input type="password" class="form-control style2" name="confirmpassword" id="confirmpassword" placeholder="<?php esc_attr_e("Confirm Password",'cityo'); ?>">
              </div>
              
              <?php wp_nonce_field('ajax-apus-register-nonce', 'security_register'); ?>

              <?php if ( Cityo_Recaptcha::is_recaptcha_enabled() && cityo_get_config('use_recaptcha_register_form', true) ) { ?>
                    <div id="recaptcha-register-form" class="ga-recaptcha" data-sitekey="<?php echo esc_attr(get_option( 'job_manager_recaptcha_site_key' )); ?>"></div>
              <?php } ?>

              <div class="form-group clear-submit">
                <button type="submit" class="btn btn-theme btn-block" name="submitRegister">
                    <?php echo esc_html__('Register now', 'cityo'); ?>
                </button>
              </div>

              <?php do_action('register_form'); ?>
          </form>
    </div>
	</div>
</div>
<div class="bottom-login text-center">
  <?php echo esc_html__('Already have an account?','cityo') ?>
</div>