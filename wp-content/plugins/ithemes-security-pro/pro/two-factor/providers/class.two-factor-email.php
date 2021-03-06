<?php
/**
 * Class for creating an email provider.
 *
 * @since 0.1-dev
 *
 * @package Two_Factor
 */
class Two_Factor_Email extends Two_Factor_Provider {

	/**
	 * The user meta token key.
	 * @type string
	 */
	const TOKEN_META_KEY = '_two_factor_email_token';

	/**
	 * Ensures only one instance of this class exists in memory at any one time.
	 *
	 * @since 0.1-dev
	 */
	static function get_instance() {
		static $instance;
		$class = __CLASS__;
		if ( ! is_a( $instance, $class ) ) {
			$instance = new $class;
		}
		return $instance;
	}

	/**
	 * Class constructor.
	 *
	 * @since 0.1-dev
	 */
	protected function __construct() {
		add_action( 'two-factor-user-options-' . __CLASS__, array( $this, 'user_options' ) );
		add_action( 'two-factor-admin-options-' . __CLASS__, array( $this, 'description' ) );
		return parent::__construct();
	}

	/**
	 * Returns the name of the provider.
	 *
	 * @since 0.1-dev
	 */
	public function get_label() {
		return _x( 'Email', 'Provider Label', 'it-l10n-ithemes-security-pro' );
	}

	/**
	 * Generate the user token.
	 *
	 * @since 0.1-dev
	 *
	 * @param int $user_id User ID.
	 * @return string
	 */
	public function generate_token( $user_id ) {
		$token = $this->get_code();
		update_user_meta( $user_id, self::TOKEN_META_KEY, wp_hash( $token ) );
		return $token;
	}

	/**
	 * Validate the user token.
	 *
	 * @since 0.1-dev
	 *
	 * @param int    $user_id User ID.
	 * @param string $token User token.
	 * @return boolean
	 */
	public function validate_token( $user_id, $token ) {
		$hashed_token = get_user_meta( $user_id, self::TOKEN_META_KEY, true );
		if ( wp_hash( $token ) !== $hashed_token ) {
			$this->delete_token( $user_id );
			return false;
		}
		return true;
	}

	/**
	 * Delete the user token.
	 *
	 * @since 0.1-dev
	 *
	 * @param int $user_id User ID.
	 */
	public function delete_token( $user_id ) {
		delete_user_meta( $user_id, self::TOKEN_META_KEY );
	}

	/**
	 * Generate and email the user token.
	 *
	 * @since 0.1-dev
	 *
	 * @param WP_User $user WP_User object of the logged-in user.
	 */
	public function generate_and_email_token( $user ) {
		$token = $this->generate_token( $user->ID );

		$subject = wp_strip_all_tags( sprintf( __( 'Your login confirmation code for %s', 'it-l10n-ithemes-security-pro' ), get_bloginfo( 'name' ) ) );
		$message = wp_strip_all_tags( sprintf( __( 'Enter %s to log in.', 'it-l10n-ithemes-security-pro' ), $token ) );
		wp_mail( $user->user_email, $subject, $message );
	}

	/**
	 * Prints the form that prompts the user to authenticate.
	 *
	 * @since 0.1-dev
	 *
	 * @param WP_User $user WP_User object of the logged-in user.
	 */
	public function authentication_page( $user ) {
		$this->generate_and_email_token( $user );
		require_once( ABSPATH .  '/wp-admin/includes/template.php' );
		?>
		<p style="padding-bottom:1em;"><?php esc_html_e( 'A verification code has been sent to the email address associated with your account.', 'it-l10n-ithemes-security-pro' ); ?></p>
		<p>
			<label for="authcode"><?php esc_html_e( 'Verification Code:', 'it-l10n-ithemes-security-pro' ); ?></label>
			<input type="tel" name="two-factor-email-code" id="authcode" class="input" value="" size="20" pattern="[0-9]*" />
		</p>
		<script type="text/javascript">
			setTimeout( function(){
				var d;
				try{
					d = document.getElementById('authcode');
					d.value = '';
					d.focus();
				} catch(e){}
			}, 200);
		</script>
		<?php
		submit_button( __( 'Log In', 'it-l10n-ithemes-security-pro' ) );
	}

	/**
	 * Validates the users input token.
	 *
	 * @since 0.1-dev
	 *
	 * @param WP_User $user WP_User object of the logged-in user.
	 * @return boolean
	 */
	public function validate_authentication( $user ) {
		return $this->validate_token( $user->ID, $_REQUEST['two-factor-email-code'] );
	}

	/**
	 * Whether this Two-Factor provider is configured and available for the user specified.
	 *
	 * @since 0.1-dev
	 *
	 * @param WP_User $user WP_User object of the logged-in user.
	 * @return boolean
	 */
	public function is_available_for_user( $user ) {
		return true;
	}

	/**
	 * Inserts markup at the end of the user profile field for this provider.
	 *
	 * @since 0.1-dev
	 *
	 * @param WP_User $user WP_User object of the logged-in user.
	 */
	public function user_options( $user ) {
		$email = $user->user_email;
		?>
		<div>
			<?php echo esc_html( sprintf( __( 'Authentication codes will be sent to %1$s.', 'it-l10n-ithemes-security-pro' ), $email ) ); ?>
		</div>
		<?php
	}

	public function description() {
		echo '<p class="description">' . __( 'The email provider sends an email with a code after logging in with a valid username and password. The code in the email must be supplied in order to complete the login process.', 'it-l10n-ithemes-security-pro' ) . '</p>';
		echo '<p class="description">' . __( 'The emails sent by this provider are sent using the same method WordPress uses to send new account details, password reset details, etc. Only enable this method if you can confirm that emails sent by the site can be received. To confirm that emails from the site can be received, log out of the site, click the "Lost your password?" link, enter your user details, and confirm that you receive an email.', 'it-l10n-ithemes-security-pro' ) . '</p>';
	}

}
