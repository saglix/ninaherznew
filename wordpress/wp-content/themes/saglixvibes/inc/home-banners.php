<?php
/**
 * Homepage banners component.
 *
 * @package SiteTheme
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function site_theme_active_home_banners() {
	return get_posts(
		array(
			'post_type'      => 'banner',
			'post_status'    => 'publish',
			'posts_per_page' => 8,
			'orderby'        => 'menu_order date',
			'order'          => 'ASC',
			'meta_key'       => '_banner_active',
			'meta_value'     => '1',
		)
	);
}

function site_theme_banner_background_url( $post_id ) {
	$background  = get_post_meta( $post_id, '_banner_background', true );
	$backgrounds = function_exists( 'site_theme_banner_backgrounds' ) ? site_theme_banner_backgrounds() : array();

	if ( ! $background || ! isset( $backgrounds[ $background ] ) ) {
		$background = 'banner-5.webp';
	}

	return get_template_directory_uri() . '/assets/banners/' . $background;
}

function site_theme_banner_image_html( $post_id ) {
	if ( ! has_post_thumbnail( $post_id ) ) {
		return '';
	}

	return get_the_post_thumbnail(
		$post_id,
		'large',
		array(
			'class'   => 'site-home-banners__image',
			'loading' => 'eager',
		)
	);
}

function site_theme_render_home_banners() {
	$banners = site_theme_active_home_banners();

	if ( ! $banners ) {
		return;
	}

	$count = count( $banners );
	?>
	<section class="site-home-banners" dir="rtl" aria-label="<?php esc_attr_e( 'באנרים ראשיים', 'site-theme' ); ?>">
		<div class="site-home-banners__viewport" data-site-home-banners>
			<div class="site-home-banners__track">
				<?php foreach ( $banners as $index => $banner ) : ?>
					<?php
					$secondary_title = get_post_meta( $banner->ID, '_banner_secondary_title', true );
					$eyebrow_text    = get_post_meta( $banner->ID, '_banner_eyebrow_text', true );
					$button_text     = get_post_meta( $banner->ID, '_banner_button_text', true );
					$button_link     = get_post_meta( $banner->ID, '_banner_button_link', true );
					$image_html      = site_theme_banner_image_html( $banner->ID );
					$background_url  = site_theme_banner_background_url( $banner->ID );
					?>
					<article
						class="site-home-banners__slide<?php echo 0 === $index ? ' is-active' : ''; ?>"
						style="--banner-background-image: url('<?php echo esc_url( $background_url ); ?>');"
						aria-hidden="<?php echo 0 === $index ? 'false' : 'true'; ?>"
					>
						<div class="site-home-banners__inner">
							<?php if ( $image_html ) : ?>
								<div class="site-home-banners__media">
									<?php echo $image_html; ?>
								</div>
							<?php endif; ?>

							<div class="site-home-banners__content">
								<?php if ( $eyebrow_text ) : ?>
									<div class="site-home-banners__eyebrow"><?php echo esc_html( $eyebrow_text ); ?></div>
								<?php endif; ?>

								<h1 class="site-home-banners__title"><?php echo esc_html( get_the_title( $banner ) ); ?></h1>

								<?php if ( $secondary_title ) : ?>
									<p class="site-home-banners__subtitle"><?php echo esc_html( $secondary_title ); ?></p>
								<?php endif; ?>

								<?php if ( $button_text && $button_link ) : ?>
									<a class="site-home-banners__button" href="<?php echo esc_url( $button_link ); ?>">
										<?php echo esc_html( $button_text ); ?>
									</a>
								<?php endif; ?>
							</div>
						</div>
					</article>
				<?php endforeach; ?>
			</div>

			<?php if ( 1 < $count ) : ?>
				<button class="site-home-banners__arrow site-home-banners__arrow--prev" type="button" data-banner-prev aria-label="<?php esc_attr_e( 'באנר קודם', 'site-theme' ); ?>">
					<i class="fa-solid fa-chevron-left" aria-hidden="true"></i>
				</button>
				<button class="site-home-banners__arrow site-home-banners__arrow--next" type="button" data-banner-next aria-label="<?php esc_attr_e( 'באנר הבא', 'site-theme' ); ?>">
					<i class="fa-solid fa-chevron-right" aria-hidden="true"></i>
				</button>

				<div class="site-home-banners__dots" aria-label="<?php esc_attr_e( 'בחירת באנר', 'site-theme' ); ?>">
					<?php foreach ( $banners as $index => $banner ) : ?>
						<button
							class="site-home-banners__dot<?php echo 0 === $index ? ' is-active' : ''; ?>"
							type="button"
							data-banner-dot="<?php echo esc_attr( $index ); ?>"
							aria-label="<?php echo esc_attr( sprintf( __( 'באנר %d', 'site-theme' ), $index + 1 ) ); ?>"
							aria-current="<?php echo 0 === $index ? 'true' : 'false'; ?>"
						></button>
					<?php endforeach; ?>
				</div>
			<?php endif; ?>
		</div>
	</section>
	<?php
}
