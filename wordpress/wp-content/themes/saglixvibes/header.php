<?php
/**
 * Site header.
 *
 * @package SiteTheme
 */
?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>
<header class="site-header">
	<?php
	$announcements = get_posts(
		array(
			'post_type'      => 'announcement',
			'post_status'    => 'publish',
			'posts_per_page' => 3,
			'orderby'        => 'menu_order date',
			'order'          => 'ASC',
			'meta_key'       => '_announcement_active',
			'meta_value'     => '1',
		)
	);
	?>
	<div class="site-announcements" aria-label="<?php esc_attr_e( 'הכרזות', 'site-theme' ); ?>">
		<?php if ( $announcements ) : ?>
			<ul class="site-announcements__list">
				<?php foreach ( $announcements as $announcement ) : ?>
					<?php $announcement_link = get_post_meta( $announcement->ID, '_announcement_link', true ); ?>
					<li>
						<?php if ( $announcement_link ) : ?>
							<a href="<?php echo esc_url( $announcement_link ); ?>"><?php echo esc_html( get_the_title( $announcement ) ); ?></a>
						<?php else : ?>
							<?php echo esc_html( get_the_title( $announcement ) ); ?>
						<?php endif; ?>
					</li>
				<?php endforeach; ?>
			</ul>
		<?php else : ?>
			<span><?php esc_html_e( 'הודעות מתחלפות', 'site-theme' ); ?></span>
		<?php endif; ?>
	</div>

	<div class="site-header__bar">
		<div class="site-header__inner">
			<a class="site-branding" href="<?php echo esc_url( home_url( '/' ) ); ?>">
				<span class="site-branding__stage" aria-hidden="true"></span>
			<?php
			$site_logo = function_exists( 'site_theme_logo_html' ) ? site_theme_logo_html() : '';
			?>
			<?php if ( $site_logo ) : ?>
				<span class="site-logo"><?php echo $site_logo; ?></span>
			<?php else : ?>
				<span class="site-title"><?php bloginfo( 'name' ); ?></span>
			<?php endif; ?>
				<span class="site-description"><?php bloginfo( 'description' ); ?></span>
			</a>

			<button class="site-menu-toggle" type="button" aria-controls="site-navigation" aria-expanded="false">
				<span class="site-menu-toggle__line"></span>
				<span class="site-menu-toggle__text"><?php esc_html_e( 'תפריט', 'site-theme' ); ?></span>
			</button>

			<nav id="site-navigation" class="site-nav" aria-label="<?php esc_attr_e( 'תפריט ראשי', 'site-theme' ); ?>">
				<?php
				wp_nav_menu(
					array(
						'theme_location' => 'primary',
						'container'      => false,
						'fallback_cb'    => 'site_theme_header_menu_fallback',
					)
				);
				?>
			</nav>

			<div class="site-header__tools" aria-label="<?php esc_attr_e( 'כלים', 'site-theme' ); ?>">
				<a class="site-header__tool" href="<?php echo esc_url( home_url( '/?s=' ) ); ?>" aria-label="<?php esc_attr_e( 'חיפוש', 'site-theme' ); ?>">
					<i class="fa-solid fa-magnifying-glass" aria-hidden="true"></i>
				</a>
				<a class="site-header__tool" href="https://api.whatsapp.com/send?phone=97299707900" target="_blank" rel="noreferrer" aria-label="<?php esc_attr_e( 'וואטסאפ', 'site-theme' ); ?>">
					<i class="fa-brands fa-whatsapp" aria-hidden="true"></i>
				</a>
			</div>
		</div>
	</div>
</header>
