<?php
/**
 * Site theme functions.
 *
 * @package SiteTheme
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

require_once get_template_directory() . '/inc/smtp-mailer.php';
require_once get_template_directory() . '/inc/branding-settings.php';
require_once get_template_directory() . '/inc/upload-types.php';
require_once get_template_directory() . '/inc/content-structure.php';
require_once get_template_directory() . '/inc/home-banners.php';
require_once get_template_directory() . '/inc/home-events.php';

function site_theme_setup() {
	load_theme_textdomain( 'site-theme', get_template_directory() . '/languages' );

	add_theme_support( 'title-tag' );
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'html5', array( 'search-form', 'comment-form', 'comment-list', 'gallery', 'caption', 'style', 'script' ) );
	add_theme_support( 'automatic-feed-links' );
	add_theme_support( 'custom-logo' );
	add_theme_support( 'responsive-embeds' );
	add_theme_support( 'editor-styles' );
	add_editor_style( 'style.css' );

	register_nav_menus(
		array(
			'primary' => __( 'תפריט ראשי', 'site-theme' ),
		)
	);
}
add_action( 'after_setup_theme', 'site_theme_setup' );

function site_theme_enqueue_assets() {
	wp_enqueue_style(
		'site-theme-icons',
		'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css',
		array(),
		'6.5.2'
	);

	wp_enqueue_style( 'site-theme-style', get_stylesheet_uri(), array( 'site-theme-icons' ), wp_get_theme()->get( 'Version' ) );
	wp_enqueue_script(
		'site-theme-navigation',
		get_template_directory_uri() . '/navigation.js',
		array(),
		(string) filemtime( get_template_directory() . '/navigation.js' ),
		true
	);

	wp_enqueue_script(
		'site-theme-home-banners',
		get_template_directory_uri() . '/home-banners.js',
		array(),
		(string) filemtime( get_template_directory() . '/home-banners.js' ),
		true
	);
}
add_action( 'wp_enqueue_scripts', 'site_theme_enqueue_assets' );

function site_theme_header_menu_fallback() {
	$items = array(
		array( 'label' => __( 'פעילות בקהילה', 'site-theme' ), 'url' => home_url( '/' ) ),
		array( 'label' => __( 'אירועים', 'site-theme' ), 'url' => home_url( '/events/' ) ),
		array( 'label' => __( 'חוגים', 'site-theme' ), 'url' => home_url( '/classes/' ) ),
		array( 'label' => __( 'מועדון הג׳אז', 'site-theme' ), 'url' => home_url( '/' ) ),
		array( 'label' => __( 'אולפנינא', 'site-theme' ), 'url' => home_url( '/' ) ),
		array( 'label' => __( 'גלריה', 'site-theme' ), 'url' => home_url( '/' ) ),
		array( 'label' => __( 'לוח חופשות וחגים', 'site-theme' ), 'url' => home_url( '/' ) ),
		array( 'label' => __( 'אולמות וחדרים להשכרה', 'site-theme' ), 'url' => home_url( '/' ) ),
		array( 'label' => __( 'יצירת קשר', 'site-theme' ), 'url' => home_url( '/contact/' ) ),
	);
	?>
	<ul class="menu">
		<?php foreach ( $items as $item ) : ?>
			<li><a href="<?php echo esc_url( $item['url'] ); ?>"><?php echo esc_html( $item['label'] ); ?></a></li>
		<?php endforeach; ?>
	</ul>
	<?php
}

function site_theme_admin_assets( $hook_suffix ) {
	if ( 'index.php' === $hook_suffix ) {
		wp_enqueue_style(
			'site-admin-dashboard',
			get_template_directory_uri() . '/admin-dashboard.css',
			array(),
			(string) filemtime( get_template_directory() . '/admin-dashboard.css' )
		);
	}

	if ( in_array( $hook_suffix, array( 'settings_page_site-smtp-mailer', 'options-general.php' ), true ) ) {
		wp_enqueue_style(
			'site-admin-settings',
			get_template_directory_uri() . '/admin-settings.css',
			array(),
			(string) filemtime( get_template_directory() . '/admin-settings.css' )
		);
	}
}
add_action( 'admin_enqueue_scripts', 'site_theme_admin_assets' );

function site_theme_reset_dashboard_widgets() {
	global $wp_meta_boxes;

	$wp_meta_boxes['dashboard'] = array();
}
add_action( 'wp_dashboard_setup', 'site_theme_reset_dashboard_widgets', 100 );

function site_theme_remove_welcome_panel() {
	remove_action( 'welcome_panel', 'wp_welcome_panel' );
}
add_action( 'admin_init', 'site_theme_remove_welcome_panel' );

function site_theme_manageable_items() {
	$items               = array();
	$excluded_post_types = array( 'wp_block', 'wp_template', 'wp_template_part', 'wp_global_styles', 'wp_navigation', 'wp_font_family', 'wp_font_face' );
	$post_types          = get_post_types( array( 'show_ui' => true ), 'objects' );

	foreach ( $post_types as $post_type ) {
		if ( ! isset( $post_type->cap->edit_posts ) || ! current_user_can( $post_type->cap->edit_posts ) ) {
			continue;
		}

		if ( in_array( $post_type->name, $excluded_post_types, true ) || str_starts_with( $post_type->name, 'wp_' ) ) {
			continue;
		}

		$count = wp_count_posts( $post_type->name );
		$total = 0;

		foreach ( get_object_vars( $count ) as $status_count ) {
			$total += (int) $status_count;
		}

		$items[] = array(
			'label' => $post_type->labels->name,
			'count' => $total,
			'url'   => 'post' === $post_type->name ? admin_url( 'edit.php' ) : admin_url( 'edit.php?post_type=' . $post_type->name ),
			'icon'  => $post_type->menu_icon,
		);
	}

	if ( current_user_can( 'list_users' ) ) {
		$user_count = count_users();
		$items[] = array(
			'label' => __( 'משתמשים', 'site-theme' ),
			'count' => (int) $user_count['total_users'],
			'url'   => admin_url( 'users.php' ),
			'icon'  => 'dashicons-admin-users',
		);
	}

	return $items;
}

function site_theme_dashboard_icon( $icon ) {
	if ( str_starts_with( $icon, 'dashicons-' ) ) {
		return '<span class="dashicons ' . esc_attr( $icon ) . '"></span>';
	}

	return '<span class="dashicons dashicons-admin-post"></span>';
}

function site_theme_render_dashboard_overview() {
	$current_user = wp_get_current_user();
	$items        = site_theme_manageable_items();
	?>
	<div class="site-dashboard" dir="rtl">
		<h1 class="site-dashboard__title">
			<span>שלום, </span><bdi><?php echo esc_html( $current_user->user_login ); ?></bdi>
		</h1>

		<div class="site-dashboard__grid">
			<?php foreach ( $items as $item ) : ?>
				<a class="site-dashboard__item" href="<?php echo esc_url( $item['url'] ); ?>">
					<span class="site-dashboard__icon" aria-hidden="true">
						<?php echo site_theme_dashboard_icon( $item['icon'] ); ?>
					</span>
					<span class="site-dashboard__label-row">
						<span class="site-dashboard__label"><?php echo esc_html( $item['label'] ); ?></span>
						<span class="site-dashboard__count">(<?php echo esc_html( number_format_i18n( $item['count'] ) ); ?>)</span>
					</span>
				</a>
			<?php endforeach; ?>
		</div>
	</div>
	<?php
}

function site_theme_render_dashboard_page() {
	$screen = get_current_screen();

	if ( ! $screen || 'dashboard' !== $screen->id ) {
		return;
	}

	site_theme_render_dashboard_overview();
}
add_action( 'all_admin_notices', 'site_theme_render_dashboard_page', 1 );
