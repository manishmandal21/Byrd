<?php if ( is_user_logged_in() ) : ?>

	<fieldset>
		<div class="field account-sign-in">
			<?php
				$user = wp_get_current_user();
				esc_html_e( 'You are currently signed in as ', 'cityo' );
			?>
			<strong><?php echo wp_kses_post($user->user_login); ?></strong>.
			<a class="button btn btn-theme logout-link" href="<?php echo apply_filters( 'submit_job_form_logout_url', wp_logout_url( get_permalink() ) ); ?>"><?php esc_html_e( 'Sign out', 'cityo' ); ?></a>
		</div>
	</fieldset>

<?php else :

	$account_required             = job_manager_user_requires_account();
	$registration_enabled         = job_manager_enable_registration();
	$generate_username_from_email = job_manager_generate_username_from_email();
	?>
			<fieldset>
				<label><?php esc_html_e( 'Have an account?', 'cityo' ); ?></label>
				<div class="field account-sign-in">
					<a class="button btn btn-theme btn-xs" href="<?php echo apply_filters( 'submit_job_form_login_url', wp_login_url( get_permalink() ) ); ?>"><?php esc_html_e( 'Sign in', 'cityo' ); ?></a>

					<?php if ( $registration_enabled ) : ?>

						<?php printf( esc_html__( 'If you don&rsquo;t have an account you can %screate one below by entering your email address/username. Your account details will be confirmed via email.', 'cityo' ), $account_required ? '' : esc_html__( 'optionally', 'cityo' ) . ' ' ); ?>

					<?php elseif ( $account_required ) : ?>

						<?php echo apply_filters( 'submit_job_form_login_required_message',  esc_html__('You must sign in to create a new listing.', 'cityo' ) ); ?>

					<?php endif; ?>
				</div>
			</fieldset>
			<?php if ( $registration_enabled ) : ?>
				<?php if ( ! $generate_username_from_email ) : ?>
					<fieldset>
						<label><?php esc_html_e( 'Username', 'cityo' ); ?> <?php echo apply_filters( 'submit_job_form_required_label', ( ! $account_required ) ? ' <small>' . esc_html__( '(optional)', 'cityo' ) . '</small>' : '' ); ?></label>
						<div class="field">
							<input type="text" class="input-text" name="create_account_username" id="account_username" value="<?php echo empty( $_POST['create_account_username'] ) ? '' : esc_attr( sanitize_text_field( stripslashes( $_POST['create_account_username'] ) ) ); ?>" />
						</div>
					</fieldset>
				<?php endif; ?>
				<fieldset>
					<label><?php esc_html_e( 'Your email', 'cityo' ); ?> <?php echo apply_filters( 'submit_job_form_required_label', ( ! $account_required ) ? ' <small>' . esc_html__( '(optional)', 'cityo' ) . '</small>' : '' ); ?></label>
					<div class="field">
						<input type="email" class="input-text" name="create_account_email" id="account_email" placeholder="<?php esc_attr_e( 'you@yourdomain.com', 'cityo' ); ?>" value="<?php echo empty( $_POST['create_account_email'] ) ? '' : esc_attr( sanitize_text_field( stripslashes( $_POST['create_account_email'] ) ) ); ?>" />
					</div>
				</fieldset>
				<?php do_action( 'job_manager_register_form' ); ?>
			<?php endif; ?>
<?php endif; ?>
