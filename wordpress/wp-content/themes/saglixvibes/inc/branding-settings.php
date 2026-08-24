<?php
/**
 * General branding settings.
 *
 * @package SiteTheme
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function site_theme_logo_id() {
	$logo_id = absint( get_option( 'site_theme_logo_id', 0 ) );

	if ( $logo_id ) {
		return $logo_id;
	}

	return absint( get_theme_mod( 'custom_logo', 0 ) );
}

function site_theme_logo_width() {
	$width = absint( get_option( 'site_theme_logo_width', 200 ) );

	if ( $width < 50 || $width > 500 ) {
		return 200;
	}

	return $width;
}

function site_theme_email_logo_id() {
	return absint( get_option( 'site_theme_email_logo_id', 0 ) );
}

function site_theme_email_design_defaults() {
	return array(
		'email_background_color'   => '#f3f4f6',
		'content_background_color' => '#ffffff',
		'email_text_color'         => '#000000',
	);
}

function site_theme_email_design_options() {
	return array(
		'email_background_color'   => get_option( 'site_theme_email_background_color', '#f3f4f6' ),
		'content_background_color' => get_option( 'site_theme_email_content_background_color', '#ffffff' ),
		'email_text_color'         => get_option( 'site_theme_email_text_color', '#000000' ),
	);
}

function site_theme_register_branding_settings() {
	register_setting(
		'general',
		'site_theme_logo_id',
		array(
			'type'              => 'integer',
			'sanitize_callback' => 'absint',
			'default'           => 0,
		)
	);

	register_setting(
		'general',
		'site_theme_logo_width',
		array(
			'type'              => 'integer',
			'sanitize_callback' => 'site_theme_sanitize_logo_width',
			'default'           => 200,
		)
	);

	register_setting(
		'general',
		'site_theme_email_logo_id',
		array(
			'type'              => 'integer',
			'sanitize_callback' => 'site_theme_sanitize_email_logo_id',
			'default'           => 0,
		)
	);

	register_setting(
		'general',
		'site_theme_email_background_color',
		array(
			'type'              => 'string',
			'sanitize_callback' => 'site_theme_sanitize_hex_color',
			'default'           => '#f3f4f6',
		)
	);

	register_setting(
		'general',
		'site_theme_email_content_background_color',
		array(
			'type'              => 'string',
			'sanitize_callback' => 'site_theme_sanitize_hex_color',
			'default'           => '#ffffff',
		)
	);

	register_setting(
		'general',
		'site_theme_email_text_color',
		array(
			'type'              => 'string',
			'sanitize_callback' => 'site_theme_sanitize_hex_color',
			'default'           => '#000000',
		)
	);

	add_settings_field(
		'site-theme-logo',
		__( 'לוגו', 'site-theme' ),
		'site_theme_render_logo_field',
		'general'
	);

	add_settings_field(
		'site-theme-email-logo',
		__( 'לוגו למיילים', 'site-theme' ),
		'site_theme_render_email_logo_field',
		'general'
	);

	add_settings_field(
		'site-theme-email-background-color',
		__( 'צבע רקע למיילים', 'site-theme' ),
		'site_theme_render_email_background_color_field',
		'general'
	);

	add_settings_field(
		'site-theme-email-content-background-color',
		__( 'צבע רקע לתוכן המייל', 'site-theme' ),
		'site_theme_render_email_content_background_color_field',
		'general'
	);

	add_settings_field(
		'site-theme-email-text-color',
		__( 'צבע טקסט במיילים', 'site-theme' ),
		'site_theme_render_email_text_color_field',
		'general'
	);

	add_settings_field(
		'site-theme-logo-width',
		__( 'רוחב לוגו', 'site-theme' ),
		'site_theme_render_logo_width_field',
		'general'
	);
}
add_action( 'admin_init', 'site_theme_register_branding_settings' );

function site_theme_sanitize_logo_width( $value ) {
	$value = absint( $value );

	if ( $value < 50 ) {
		return 50;
	}

	if ( $value > 500 ) {
		return 500;
	}

	return $value;
}

function site_theme_sanitize_hex_color( $value ) {
	$value = sanitize_hex_color( $value );

	return $value ? $value : '#000000';
}

function site_theme_sanitize_email_logo_id( $value ) {
	$attachment_id = absint( $value );

	if ( ! $attachment_id ) {
		return 0;
	}

	$mime_type = get_post_mime_type( $attachment_id );
	$allowed   = array( 'image/png', 'image/jpeg', 'image/webp' );

	return in_array( $mime_type, $allowed, true ) ? $attachment_id : 0;
}

function site_theme_render_logo_field() {
	$logo_id  = site_theme_logo_id();
	$logo_url = $logo_id ? wp_get_attachment_image_url( $logo_id, 'medium' ) : '';
	?>
	<div class="site-logo-setting" dir="rtl">
		<input type="hidden" id="site-theme-logo-id" name="site_theme_logo_id" value="<?php echo esc_attr( $logo_id ); ?>">

		<div class="site-logo-setting__preview" id="site-theme-logo-preview">
			<?php if ( $logo_url ) : ?>
				<img src="<?php echo esc_url( $logo_url ); ?>" alt="">
			<?php endif; ?>
		</div>

		<button type="button" class="button" id="site-theme-logo-select">
			<?php esc_html_e( 'בחירת לוגו', 'site-theme' ); ?>
		</button>
		<button type="button" class="button" id="site-theme-logo-remove" <?php disabled( ! $logo_id ); ?>>
			<?php esc_html_e( 'הסרת לוגו', 'site-theme' ); ?>
		</button>
		<p class="description"><?php esc_html_e( 'הלוגו יוצג באתר ובמיילים של האתר.', 'site-theme' ); ?></p>
	</div>
	<?php
}

function site_theme_render_email_logo_field() {
	$logo_id  = site_theme_email_logo_id();
	$logo_url = $logo_id ? wp_get_attachment_image_url( $logo_id, 'medium' ) : '';
	?>
	<div class="site-logo-setting" dir="rtl">
		<input type="hidden" id="site-theme-email-logo-id" name="site_theme_email_logo_id" value="<?php echo esc_attr( $logo_id ); ?>">

		<div class="site-logo-setting__preview" id="site-theme-email-logo-preview">
			<?php if ( $logo_url ) : ?>
				<img src="<?php echo esc_url( $logo_url ); ?>" alt="">
			<?php endif; ?>
		</div>

		<button type="button" class="button" id="site-theme-email-logo-select">
			<?php esc_html_e( 'בחירת לוגו למיילים', 'site-theme' ); ?>
		</button>
		<button type="button" class="button" id="site-theme-email-logo-remove" <?php disabled( ! $logo_id ); ?>>
			<?php esc_html_e( 'הסרת לוגו למיילים', 'site-theme' ); ?>
		</button>
		<p class="description"><?php esc_html_e( 'יש לבחור קובץ PNG, JPG או WEBP בלבד. מיילים לא תומכים היטב ב־SVG.', 'site-theme' ); ?></p>
	</div>
	<?php
}

function site_theme_render_color_field( $option_name, $default, $description ) {
	$value = get_option( $option_name, $default );
	$value = sanitize_hex_color( $value ) ? $value : $default;
	?>
	<input type="color" name="<?php echo esc_attr( $option_name ); ?>" value="<?php echo esc_attr( $value ); ?>">
	<input class="regular-text ltr site-color-text" type="text" value="<?php echo esc_attr( $value ); ?>" readonly>
	<p class="description"><?php echo esc_html( $description ); ?></p>
	<?php
}

function site_theme_render_email_background_color_field() {
	site_theme_render_color_field(
		'site_theme_email_background_color',
		'#f3f4f6',
		__( 'ברירת מחדל: אפור בהיר מאוד.', 'site-theme' )
	);
}

function site_theme_render_email_content_background_color_field() {
	site_theme_render_color_field(
		'site_theme_email_content_background_color',
		'#ffffff',
		__( 'ברירת מחדל: לבן.', 'site-theme' )
	);
}

function site_theme_render_email_text_color_field() {
	site_theme_render_color_field(
		'site_theme_email_text_color',
		'#000000',
		__( 'ברירת מחדל: שחור.', 'site-theme' )
	);
}

function site_theme_render_logo_width_field() {
	$width = site_theme_logo_width();
	?>
	<div class="site-logo-width-setting" dir="rtl">
		<input type="range" id="site-theme-logo-width" name="site_theme_logo_width" min="50" max="500" step="1" value="<?php echo esc_attr( $width ); ?>">
		<output for="site-theme-logo-width" id="site-theme-logo-width-value"><?php echo esc_html( $width ); ?>px</output>
		<p class="description"><?php esc_html_e( 'ברירת מחדל: 200px. הטווח האפשרי הוא 50px עד 500px.', 'site-theme' ); ?></p>
	</div>
	<?php
}

function site_theme_branding_admin_assets( $hook_suffix ) {
	if ( 'options-general.php' !== $hook_suffix ) {
		return;
	}

	wp_enqueue_media();
	wp_enqueue_style(
		'site-admin-settings',
		get_template_directory_uri() . '/admin-settings.css',
		array(),
		(string) filemtime( get_template_directory() . '/admin-settings.css' )
	);
	wp_enqueue_script(
		'site-branding-settings',
		get_template_directory_uri() . '/admin-branding-settings.js',
		array( 'jquery' ),
		(string) filemtime( get_template_directory() . '/admin-branding-settings.js' ),
		true
	);
	wp_localize_script(
		'site-branding-settings',
		'siteBrandingSettings',
		array(
			'title'           => __( 'בחירת לוגו', 'site-theme' ),
			'button'          => __( 'שימוש בלוגו זה', 'site-theme' ),
			'emailTitle'      => __( 'בחירת לוגו למיילים', 'site-theme' ),
			'emailButton'     => __( 'שימוש בלוגו זה למיילים', 'site-theme' ),
			'invalidEmailLogo' => __( 'יש לבחור קובץ PNG, JPG או WEBP בלבד.', 'site-theme' ),
		)
	);
}
add_action( 'admin_enqueue_scripts', 'site_theme_branding_admin_assets' );

function site_theme_logo_html() {
	$logo_id = site_theme_logo_id();

	if ( ! $logo_id ) {
		return '';
	}

	$url = wp_get_attachment_image_url( $logo_id, 'full' );

	if ( ! $url ) {
		return '';
	}

	return sprintf(
		'<img src="%1$s" alt="%2$s" width="%3$d" style="max-width:%3$dpx;height:auto;">',
		esc_url( $url ),
		esc_attr( get_bloginfo( 'name' ) ),
		site_theme_logo_width()
	);
}

function site_theme_email_logo_html() {
	$logo_id = site_theme_email_logo_id();

	if ( ! $logo_id ) {
		$logo_id = site_theme_logo_id();
	}

	if ( ! $logo_id ) {
		return '';
	}

	$mime_type = get_post_mime_type( $logo_id );
	if ( ! in_array( $mime_type, array( 'image/png', 'image/jpeg', 'image/webp' ), true ) ) {
		return '';
	}

	$url = wp_get_attachment_image_url( $logo_id, 'full' );

	if ( ! $url ) {
		return '';
	}

	return sprintf(
		'<img src="%1$s" alt="%2$s" width="%3$d" style="max-width:%3$dpx;height:auto;">',
		esc_url( $url ),
		esc_attr( get_bloginfo( 'name' ) ),
		site_theme_logo_width()
	);
}

function site_theme_normalize_mail_headers( $headers ) {
	if ( empty( $headers ) ) {
		return array();
	}

	return is_array( $headers ) ? $headers : explode( "\n", str_replace( "\r\n", "\n", $headers ) );
}

function site_theme_add_html_content_type_header( $headers ) {
	$headers = site_theme_normalize_mail_headers( $headers );
	$clean   = array();

	foreach ( $headers as $header ) {
		if ( is_string( $header ) && false !== stripos( $header, 'Content-Type:' ) ) {
			continue;
		}

		$clean[] = $header;
	}

	$clean[] = 'Content-Type: text/html; charset=UTF-8';

	return $clean;
}

function site_theme_message_is_html( $message, $headers ) {
	foreach ( site_theme_normalize_mail_headers( $headers ) as $header ) {
		if ( is_string( $header ) && false !== stripos( $header, 'Content-Type: text/html' ) ) {
			return true;
		}
	}

	return preg_match( '/<([a-z][a-z0-9]*)\b[^>]*>/i', $message );
}

function site_theme_design_email_message( $args ) {
	if ( empty( $args['message'] ) ) {
		return $args;
	}

	$design             = site_theme_email_design_options();
	$background_color   = sanitize_hex_color( $design['email_background_color'] ) ? $design['email_background_color'] : '#f3f4f6';
	$content_background = sanitize_hex_color( $design['content_background_color'] ) ? $design['content_background_color'] : '#ffffff';
	$text_color         = sanitize_hex_color( $design['email_text_color'] ) ? $design['email_text_color'] : '#000000';
	$logo               = site_theme_email_logo_html();
	$headers            = isset( $args['headers'] ) ? $args['headers'] : array();
	$message            = (string) $args['message'];

	if ( str_contains( $message, 'data-site-email-template="1"' ) ) {
		return $args;
	}

	if ( ! site_theme_message_is_html( $message, $headers ) ) {
		$message = nl2br( esc_html( $message ) );
	}

	$logo_html = $logo ? '<div style="margin:0 0 32px;text-align:center;">' . $logo . '</div>' : '';

	$args['message'] = sprintf(
		'<!doctype html><html><body style="margin:0;padding:0;background:%1$s;color:%3$s;"><div data-site-email-template="1" style="background:%1$s;padding:40px 16px;font-family:Arial,sans-serif;color:%3$s;line-height:1.6;"><div style="max-width:760px;margin:0 auto;background:%2$s;border-radius:12px;padding:40px;color:%3$s;">%4$s<div style="color:%3$s;font-size:16px;">%5$s</div></div></div></body></html>',
		esc_attr( $background_color ),
		esc_attr( $content_background ),
		esc_attr( $text_color ),
		$logo_html,
		$message
	);
	$args['headers'] = site_theme_add_html_content_type_header( $headers );

	return $args;
}
add_filter( 'wp_mail', 'site_theme_design_email_message' );
