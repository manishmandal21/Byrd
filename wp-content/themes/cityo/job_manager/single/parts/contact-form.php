<?php
global $post;
// get our custom meta
$author_email = get_post_meta( $post->ID, '_job_email', true);
if ( empty($author_email) ) {
	$author_email = get_the_author_meta('user_email');
}
?>


<div class="contact-form widget">
	<h2 class="widget-title">
		<span><?php esc_html_e('Contact Business', 'cityo'); ?></span>
	</h2>
	<?php if ( ! empty( $_POST ) && array_key_exists( 'contact-form', $_POST ) ) : ?>
	    <?php
		$is_form_filled = ! empty( $_POST['email'] ) && ! empty( $_POST['subject'] ) && ! empty( $_POST['message'] );
		if ( Cityo_Recaptcha::is_recaptcha_enabled() ) {
			$is_recaptcha_valid = array_key_exists( 'g-recaptcha-response', $_POST ) ? Cityo_Recaptcha::is_recaptcha_valid( sanitize_text_field( $_POST['g-recaptcha-response'] ) ) : false;
			if ( !$is_recaptcha_valid ) {
				$is_form_filled = false;
			}
		}
		?>

	    <?php if ( $is_form_filled ) : ?>
	        <?php
	        $email = sanitize_text_field( $_POST['email'] );
	        $subject = sanitize_text_field( $_POST['subject'] );
	        $message = sanitize_text_field( $_POST['message'] );
	        $headers = sprintf( "From: %s <%s>\r\n Content-type: text/html", $email, $email );
	        
	        $result = false;
			if ( function_exists('apus_wjm_send_mail') ) {
				$result = apus_wjm_send_mail( $author_email, $subject, $message, $headers );
			}
	        ?>

	        <?php if ( $result ) : ?>
	            <div class="alert alert-success"><?php echo esc_html__( 'Your message has been successfully sent.', 'cityo' ); ?></div>
	        <?php else : ?>
	            <div class="alert alert-warning"><?php echo esc_html__( 'An error occurred when sending an email.', 'cityo' ); ?></div>
	        <?php endif; ?>
	    <?php else : ?>
	        <div class="alert alert-warning"><?php echo esc_html__( 'Form has been not filled correctly.', 'cityo' ); ?></div>
	    <?php endif; ?>
	<?php endif; ?>

	<?php if ( ! empty( $author_email ) ) : ?>
	    <form method="post" action="?">
	    	<div class="row">
		        <div class="col-sm-12">
			        <div class="form-group">
			            <input type="text" class="form-control style2" name="subject" placeholder="<?php esc_attr_e( 'Subject', 'cityo' ); ?>" required="required">
			        </div><!-- /.form-group -->
			    </div>
			    <div class="col-sm-12">
			        <div class="form-group">
			            <input type="email" class="form-control style2" name="email" placeholder="<?php esc_attr_e( 'E-mail', 'cityo' ); ?>" required="required">
			        </div><!-- /.form-group -->
			    </div>
	        </div>

	        <?php do_action('cityo-single-listing-contact-form', $post); ?>

	        <div class="form-group space-30">
	            <textarea class="form-control style2" name="message" placeholder="<?php esc_attr_e( 'Message', 'cityo' ); ?>" required="required"></textarea>
	        </div><!-- /.form-group -->

	        <?php if ( Cityo_Recaptcha::is_recaptcha_enabled() ) { ?>
                <div id="recaptcha-contact-form" class="ga-recaptcha" data-sitekey="<?php echo esc_attr(get_option( 'job_manager_recaptcha_site_key' )); ?>"></div>
          	<?php } ?>


	        <button class="button btn btn-theme btn-block" name="contact-form"><?php echo esc_html__( 'Send Message', 'cityo' ); ?></button>
	    </form>
	<?php endif; ?>
</div>
