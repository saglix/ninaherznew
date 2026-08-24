<?php
/**
 * Homepage events section.
 *
 * @package SiteTheme
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function site_theme_home_events() {
	return get_posts(
		array(
			'post_type'      => 'event',
			'post_status'    => 'publish',
			'posts_per_page' => 6,
			'orderby'        => 'date',
			'order'          => 'DESC',
		)
	);
}

function site_theme_event_time( $post_id ) {
	$display_date = get_post_meta( $post_id, '_event_display_date', true );

	if ( preg_match( '/\b([0-2]?\d:[0-5]\d)\b/u', $display_date, $matches ) ) {
		return $matches[1];
	}

	return '';
}

function site_theme_event_status_label( $post_id ) {
	$capacity = absint( get_post_meta( $post_id, '_event_capacity', true ) );

	if ( 0 === $capacity ) {
		return __( 'אזל המלאי', 'site-theme' );
	}

	return sprintf(
		/* translators: %d: tickets remaining. */
		__( 'נותרו %d כרטיסים', 'site-theme' ),
		$capacity
	);
}

function site_theme_event_price_label( $post_id ) {
	$is_paid = '1' === get_post_meta( $post_id, '_event_is_paid', true );
	$price   = get_post_meta( $post_id, '_event_ticket_price', true );

	if ( ! $is_paid ) {
		return __( 'חינם', 'site-theme' );
	}

	if ( '' === $price ) {
		return '';
	}

	return '₪' . number_format_i18n( (float) $price, 0 );
}

function site_theme_event_card_image( $post_id ) {
	if ( has_post_thumbnail( $post_id ) ) {
		return get_the_post_thumbnail(
			$post_id,
			'large',
			array(
				'class'   => 'site-event-card__image',
				'loading' => 'lazy',
			)
		);
	}

	return '';
}

function site_theme_render_home_events() {
	$events = site_theme_home_events();

	if ( ! $events ) {
		return;
	}
	?>
	<section class="site-home-events" dir="rtl" aria-labelledby="site-home-events-title">
		<div class="site-home-events__head">
			<h2 id="site-home-events-title"><?php esc_html_e( 'אירועים קרובים בנינא', 'site-theme' ); ?></h2>
			<a class="site-home-events__all" href="<?php echo esc_url( get_post_type_archive_link( 'event' ) ); ?>">
				<span><?php esc_html_e( 'לכל האירועים', 'site-theme' ); ?></span>
				<i class="fa-solid fa-arrow-left" aria-hidden="true"></i>
			</a>
		</div>

		<div class="site-home-events__grid">
			<?php foreach ( $events as $event ) : ?>
				<?php
				$event_link   = get_post_meta( $event->ID, '_event_registration_url', true );
				$event_link   = $event_link ? $event_link : get_permalink( $event );
				$short_date   = get_post_meta( $event->ID, '_event_short_date', true );
				$event_time   = site_theme_event_time( $event->ID );
				$status_label = site_theme_event_status_label( $event->ID );
				$price_label  = site_theme_event_price_label( $event->ID );
				$image_html   = site_theme_event_card_image( $event->ID );
				?>
				<a class="site-event-card" href="<?php echo esc_url( $event_link ); ?>">
					<?php if ( $image_html ) : ?>
						<?php echo $image_html; ?>
					<?php endif; ?>

					<span class="site-event-card__badges">
						<?php if ( $price_label ) : ?>
							<span class="site-event-card__badge site-event-card__badge--price"><?php echo esc_html( $price_label ); ?></span>
						<?php endif; ?>
						<span class="site-event-card__badge site-event-card__badge--status"><?php echo esc_html( $status_label ); ?></span>
					</span>

					<span class="site-event-card__date">
						<strong><?php echo esc_html( $short_date ); ?></strong>
						<?php if ( $event_time ) : ?>
							<span><?php echo esc_html( $event_time ); ?></span>
						<?php endif; ?>
					</span>

					<span class="site-event-card__title"><?php echo esc_html( get_the_title( $event ) ); ?></span>
				</a>
			<?php endforeach; ?>
		</div>
	</section>
	<?php
}
