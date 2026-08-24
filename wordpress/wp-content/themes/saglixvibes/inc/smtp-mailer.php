<?php
/**
 * SMTP mail settings for the site theme.
 *
 * @package SiteTheme
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

const SITE_THEME_SMTP_OPTION = 'site_theme_smtp_mailer';

function site_theme_smtp_defaults() {
	return array(
		'from_email'       => get_option( 'admin_email' ),
		'force_from_email' => 0,
		'from_name'        => get_bloginfo( 'name' ),
		'force_from_name'  => 1,
		'return_path'      => 1,
		'host'             => '',
		'encryption'       => 'tls',
		'port'             => 587,
		'auth'             => 1,
		'username'         => '',
		'password'         => '',
		'test_to'          => get_option( 'admin_email' ),
		'test_html'        => 1,
	);
}

function site_theme_smtp_options() {
	$saved = get_option( SITE_THEME_SMTP_OPTION, array() );

	if ( ! is_array( $saved ) ) {
		$saved = array();
	}

	return wp_parse_args( $saved, site_theme_smtp_defaults() );
}

function site_theme_smtp_sanitize( $input ) {
	$current = site_theme_smtp_options();
	$input   = is_array( $input ) ? $input : array();

	$password = $current['password'];
	if ( ! empty( $input['remove_password'] ) ) {
		$password = '';
	} elseif ( isset( $input['password'] ) && '' !== $input['password'] ) {
		$password = sanitize_text_field( wp_unslash( $input['password'] ) );
	}

	$encryption = isset( $input['encryption'] ) ? sanitize_key( $input['encryption'] ) : 'tls';
	if ( ! in_array( $encryption, array( 'tls', 'ssl', 'none' ), true ) ) {
		$encryption = 'tls';
	}

	return array(
		'from_email'       => isset( $input['from_email'] ) ? sanitize_email( wp_unslash( $input['from_email'] ) ) : '',
		'force_from_email' => empty( $input['force_from_email'] ) ? 0 : 1,
		'from_name'        => isset( $input['from_name'] ) ? sanitize_text_field( wp_unslash( $input['from_name'] ) ) : '',
		'force_from_name'  => empty( $input['force_from_name'] ) ? 0 : 1,
		'return_path'      => empty( $input['return_path'] ) ? 0 : 1,
		'host'             => isset( $input['host'] ) ? sanitize_text_field( wp_unslash( $input['host'] ) ) : '',
		'encryption'       => $encryption,
		'port'             => isset( $input['port'] ) ? absint( $input['port'] ) : 587,
		'auth'             => empty( $input['auth'] ) ? 0 : 1,
		'username'         => isset( $input['username'] ) ? sanitize_text_field( wp_unslash( $input['username'] ) ) : '',
		'password'         => $password,
		'test_to'          => isset( $input['test_to'] ) ? sanitize_email( wp_unslash( $input['test_to'] ) ) : '',
		'test_html'        => empty( $input['test_html'] ) ? 0 : 1,
	);
}

function site_theme_smtp_register_settings() {
	register_setting(
		'site_theme_smtp_mailer',
		SITE_THEME_SMTP_OPTION,
		array(
			'type'              => 'array',
			'sanitize_callback' => 'site_theme_smtp_sanitize',
			'default'           => site_theme_smtp_defaults(),
		)
	);
}
add_action( 'admin_init', 'site_theme_smtp_register_settings' );

function site_theme_smtp_add_settings_page() {
	add_options_page(
		'SMTP Mailer',
		'SMTP Mailer',
		'manage_options',
		'site-smtp-mailer',
		'site_theme_smtp_render_page'
	);
}
add_action( 'admin_menu', 'site_theme_smtp_add_settings_page' );

function site_theme_smtp_checkbox( $name, $value ) {
	printf(
		'<label><input type="checkbox" name="%1$s[%2$s]" value="1" %3$s> %4$s</label>',
		esc_attr( SITE_THEME_SMTP_OPTION ),
		esc_attr( $name ),
		checked( 1, (int) $value, false ),
		esc_html__( 'פעיל', 'site-theme' )
	);
}

function site_theme_smtp_render_page() {
	if ( ! current_user_can( 'manage_options' ) ) {
		return;
	}

	$options = site_theme_smtp_options();
	?>
	<div class="wrap site-settings-page" dir="rtl">
		<h1><?php esc_html_e( 'SMTP Mailer', 'site-theme' ); ?></h1>

		<?php settings_errors( 'site_theme_smtp_mailer' ); ?>

		<form method="post" action="options.php" class="site-settings-card">
			<?php settings_fields( 'site_theme_smtp_mailer' ); ?>

			<h2><?php esc_html_e( 'פרטי השולח', 'site-theme' ); ?></h2>
			<table class="form-table" role="presentation">
				<tr>
					<th scope="row"><label for="site-smtp-from-email"><?php esc_html_e( 'אימייל שולח', 'site-theme' ); ?></label></th>
					<td>
						<input id="site-smtp-from-email" class="regular-text ltr" type="email" name="<?php echo esc_attr( SITE_THEME_SMTP_OPTION ); ?>[from_email]" value="<?php echo esc_attr( $options['from_email'] ); ?>">
						<p class="description"><?php esc_html_e( 'כתובת האימייל שממנה ההודעות יישלחו.', 'site-theme' ); ?></p>
					</td>
				</tr>
				<tr>
					<th scope="row"><?php esc_html_e( 'לאלץ אימייל שולח', 'site-theme' ); ?></th>
					<td>
						<?php site_theme_smtp_checkbox( 'force_from_email', $options['force_from_email'] ); ?>
						<p class="description"><?php esc_html_e( 'כאשר פעיל, כתובת השולח הזו תשמש לכל המיילים באתר.', 'site-theme' ); ?></p>
					</td>
				</tr>
				<tr>
					<th scope="row"><label for="site-smtp-from-name"><?php esc_html_e( 'שם שולח', 'site-theme' ); ?></label></th>
					<td>
						<input id="site-smtp-from-name" class="regular-text" type="text" name="<?php echo esc_attr( SITE_THEME_SMTP_OPTION ); ?>[from_name]" value="<?php echo esc_attr( $options['from_name'] ); ?>">
						<p class="description"><?php esc_html_e( 'השם שיופיע כשולח ההודעות.', 'site-theme' ); ?></p>
					</td>
				</tr>
				<tr>
					<th scope="row"><?php esc_html_e( 'לאלץ שם שולח', 'site-theme' ); ?></th>
					<td><?php site_theme_smtp_checkbox( 'force_from_name', $options['force_from_name'] ); ?></td>
				</tr>
				<tr>
					<th scope="row"><?php esc_html_e( 'Return Path', 'site-theme' ); ?></th>
					<td>
						<?php site_theme_smtp_checkbox( 'return_path', $options['return_path'] ); ?>
						<p class="description"><?php esc_html_e( 'מגדיר לאן יישלחו הודעות חזרה או שגיאות מסירה.', 'site-theme' ); ?></p>
					</td>
				</tr>
			</table>

			<h2><?php esc_html_e( 'הגדרות שרת SMTP', 'site-theme' ); ?></h2>
			<table class="form-table" role="presentation">
				<tr>
					<th scope="row"><label for="site-smtp-host"><?php esc_html_e( 'שרת SMTP', 'site-theme' ); ?></label></th>
					<td><input id="site-smtp-host" class="regular-text ltr" type="text" name="<?php echo esc_attr( SITE_THEME_SMTP_OPTION ); ?>[host]" value="<?php echo esc_attr( $options['host'] ); ?>" placeholder="smtp.example.com"></td>
				</tr>
				<tr>
					<th scope="row"><?php esc_html_e( 'הצפנה', 'site-theme' ); ?></th>
					<td>
						<fieldset>
							<label><input type="radio" name="<?php echo esc_attr( SITE_THEME_SMTP_OPTION ); ?>[encryption]" value="tls" <?php checked( 'tls', $options['encryption'] ); ?>> TLS</label>
							<label><input type="radio" name="<?php echo esc_attr( SITE_THEME_SMTP_OPTION ); ?>[encryption]" value="ssl" <?php checked( 'ssl', $options['encryption'] ); ?>> SSL</label>
							<label><input type="radio" name="<?php echo esc_attr( SITE_THEME_SMTP_OPTION ); ?>[encryption]" value="none" <?php checked( 'none', $options['encryption'] ); ?>> <?php esc_html_e( 'ללא', 'site-theme' ); ?></label>
						</fieldset>
						<p class="description"><?php esc_html_e( 'ברוב השרתים TLS היא האפשרות המומלצת.', 'site-theme' ); ?></p>
					</td>
				</tr>
				<tr>
					<th scope="row"><label for="site-smtp-port"><?php esc_html_e( 'פורט SMTP', 'site-theme' ); ?></label></th>
					<td><input id="site-smtp-port" class="small-text ltr" type="number" min="1" max="65535" name="<?php echo esc_attr( SITE_THEME_SMTP_OPTION ); ?>[port]" value="<?php echo esc_attr( $options['port'] ); ?>"></td>
				</tr>
				<tr>
					<th scope="row"><?php esc_html_e( 'אימות', 'site-theme' ); ?></th>
					<td><?php site_theme_smtp_checkbox( 'auth', $options['auth'] ); ?></td>
				</tr>
				<tr>
					<th scope="row"><label for="site-smtp-username"><?php esc_html_e( 'שם משתמש SMTP', 'site-theme' ); ?></label></th>
					<td><input id="site-smtp-username" class="regular-text ltr" type="text" name="<?php echo esc_attr( SITE_THEME_SMTP_OPTION ); ?>[username]" value="<?php echo esc_attr( $options['username'] ); ?>"></td>
				</tr>
				<tr>
					<th scope="row"><label for="site-smtp-password"><?php esc_html_e( 'סיסמת SMTP', 'site-theme' ); ?></label></th>
					<td>
						<input id="site-smtp-password" class="regular-text ltr" type="password" name="<?php echo esc_attr( SITE_THEME_SMTP_OPTION ); ?>[password]" value="" placeholder="<?php echo esc_attr( $options['password'] ? '••••••••••••' : '' ); ?>">
						<?php if ( $options['password'] ) : ?>
							<label class="site-inline-control"><input type="checkbox" name="<?php echo esc_attr( SITE_THEME_SMTP_OPTION ); ?>[remove_password]" value="1"> <?php esc_html_e( 'הסר סיסמה שמורה', 'site-theme' ); ?></label>
						<?php endif; ?>
						<p class="description"><?php esc_html_e( 'מטעמי אבטחה, השדה נשאר ריק לאחר השמירה. הזנת ערך חדש תחליף את הסיסמה השמורה.', 'site-theme' ); ?></p>
					</td>
				</tr>
			</table>

			<?php submit_button( __( 'שמירת הגדרות', 'site-theme' ) ); ?>
		</form>

		<form method="post" class="site-settings-card">
			<?php wp_nonce_field( 'site_theme_smtp_test_mail', 'site_theme_smtp_test_mail_nonce' ); ?>
			<input type="hidden" name="site_theme_smtp_action" value="test_mail">

			<h2><?php esc_html_e( 'שליחת מייל בדיקה', 'site-theme' ); ?></h2>
			<table class="form-table" role="presentation">
				<tr>
					<th scope="row"><label for="site-smtp-test-to"><?php esc_html_e( 'שליחה אל', 'site-theme' ); ?></label></th>
					<td>
						<input id="site-smtp-test-to" class="regular-text ltr" type="email" name="site_theme_smtp_test_to" value="<?php echo esc_attr( $options['test_to'] ); ?>">
						<p class="description"><?php esc_html_e( 'כתובת שאליה יישלח מייל הבדיקה.', 'site-theme' ); ?></p>
					</td>
				</tr>
				<tr>
					<th scope="row">HTML</th>
					<td>
						<label><input type="checkbox" name="site_theme_smtp_test_html" value="1" <?php checked( 1, (int) $options['test_html'] ); ?>> <?php esc_html_e( 'פעיל', 'site-theme' ); ?></label>
						<p class="description"><?php esc_html_e( 'שליחת מייל הבדיקה בפורמט HTML.', 'site-theme' ); ?></p>
					</td>
				</tr>
			</table>

			<?php submit_button( __( 'שליחת מייל בדיקה', 'site-theme' ), 'secondary', 'submit', false ); ?>
		</form>
	</div>
	<?php
}

function site_theme_smtp_handle_test_mail() {
	if ( empty( $_POST['site_theme_smtp_action'] ) || 'test_mail' !== $_POST['site_theme_smtp_action'] ) {
		return;
	}

	if ( ! current_user_can( 'manage_options' ) || empty( $_POST['site_theme_smtp_test_mail_nonce'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['site_theme_smtp_test_mail_nonce'] ) ), 'site_theme_smtp_test_mail' ) ) {
		return;
	}

	$options              = site_theme_smtp_options();
	$options['test_to']   = isset( $_POST['site_theme_smtp_test_to'] ) ? sanitize_email( wp_unslash( $_POST['site_theme_smtp_test_to'] ) ) : '';
	$options['test_html'] = empty( $_POST['site_theme_smtp_test_html'] ) ? 0 : 1;

	update_option( SITE_THEME_SMTP_OPTION, $options );

	$to      = $options['test_to'] ? $options['test_to'] : get_option( 'admin_email' );
	$subject = sprintf( 'בדיקת SMTP - %s', wp_specialchars_decode( get_bloginfo( 'name' ), ENT_QUOTES ) );
	$message = $options['test_html'] ? '<p>מייל הבדיקה נשלח בהצלחה מהאתר.</p>' : 'מייל הבדיקה נשלח בהצלחה מהאתר.';
	$headers = $options['test_html'] ? array( 'Content-Type: text/html; charset=UTF-8' ) : array();

	if ( wp_mail( $to, $subject, $message, $headers ) ) {
		add_settings_error( 'site_theme_smtp_mailer', 'test-mail-sent', __( 'מייל הבדיקה נשלח בהצלחה.', 'site-theme' ), 'updated' );
	} else {
		add_settings_error( 'site_theme_smtp_mailer', 'test-mail-failed', __( 'שליחת מייל הבדיקה נכשלה. כדאי לבדוק את פרטי השרת והאימות.', 'site-theme' ), 'error' );
	}
}
add_action( 'admin_init', 'site_theme_smtp_handle_test_mail' );

function site_theme_smtp_apply_from_email( $email ) {
	$options = site_theme_smtp_options();

	if ( $options['force_from_email'] && is_email( $options['from_email'] ) ) {
		return $options['from_email'];
	}

	return $email;
}
add_filter( 'wp_mail_from', 'site_theme_smtp_apply_from_email' );

function site_theme_smtp_apply_from_name( $name ) {
	$options = site_theme_smtp_options();

	if ( $options['force_from_name'] && $options['from_name'] ) {
		return $options['from_name'];
	}

	return $name;
}
add_filter( 'wp_mail_from_name', 'site_theme_smtp_apply_from_name' );

function site_theme_smtp_configure_phpmailer( $phpmailer ) {
	$options = site_theme_smtp_options();

	if ( ! $options['host'] ) {
		return;
	}

	$phpmailer->isSMTP();
	$phpmailer->Host       = $options['host'];
	$phpmailer->Port       = (int) $options['port'];
	$phpmailer->SMTPAuth   = (bool) $options['auth'];
	$phpmailer->SMTPSecure = 'none' === $options['encryption'] ? '' : $options['encryption'];

	if ( $options['auth'] ) {
		$phpmailer->Username = $options['username'];
		$phpmailer->Password = $options['password'];
	}

	if ( $options['from_email'] && is_email( $options['from_email'] ) ) {
		$phpmailer->From = $options['from_email'];
	}

	if ( $options['from_name'] ) {
		$phpmailer->FromName = $options['from_name'];
	}

	if ( $options['return_path'] && $options['from_email'] && is_email( $options['from_email'] ) ) {
		$phpmailer->Sender = $options['from_email'];
	}
}
add_action( 'phpmailer_init', 'site_theme_smtp_configure_phpmailer' );
