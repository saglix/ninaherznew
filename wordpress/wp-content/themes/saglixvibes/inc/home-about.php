<?php
/**
 * Homepage about section.
 *
 * @package SiteTheme
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function site_theme_render_home_about() {
	$asset_base = get_template_directory_uri() . '/assets/about/';
	$partners   = array(
		array(
			'src' => 'partner-company.webp',
			'alt' => __( 'החברה למתנ״סים', 'site-theme' ),
		),
		array(
			'src' => 'partner-herzliya.webp',
			'alt' => __( 'עיריית הרצליה', 'site-theme' ),
		),
		array(
			'src' => 'partner-community-centers.webp',
			'alt' => __( 'מרכזים קהילתיים הרצליה', 'site-theme' ),
		),
	);
	?>
	<section class="site-home-about" dir="rtl" aria-labelledby="site-home-about-title">
		<div class="site-home-about__layout">
			<div class="site-home-about__media" aria-hidden="true">
				<img
					class="site-home-about__image"
					src="<?php echo esc_url( $asset_base . 'about-nina.webp' ); ?>"
					alt=""
					loading="lazy"
				>
			</div>

			<div class="site-home-about__content">
				<h2 id="site-home-about-title"><?php esc_html_e( 'נינא - הבית של הקהילה בהרצליה', 'site-theme' ); ?></h2>

				<p><?php esc_html_e( 'מרכז נינא הוא בית לקהילה, לתרבות ולפנאי בשכונות נווה ישראל ונוה אמירים בהרצליה. המרכז מציע מגוון רחב של חוגים סדנאות, אירועים ותוכניות העשרה לכל הגילאים - מפעילויות לגיל הרך, דרך חוגי ילדים ונוער בתחומי הספורט, האמנות, המוזיקה והחינוך, ועד פעילויות תרבות, מוזיקה וג׳אז למבוגרים ולגיל השלישי.', 'site-theme' ); ?></p>

				<p><?php esc_html_e( 'המרכז מהווה מקום למפגש, למידה, יצירה ופעילות משותפת, עם דגש על חיזוק הקהילה, פיתוח אישי ושיתוף פעולה בין התושבים', 'site-theme' ); ?></p>

				<div class="site-home-about__partners" aria-label="<?php esc_attr_e( 'בשיתוף', 'site-theme' ); ?>">
					<span><?php esc_html_e( 'בשיתוף', 'site-theme' ); ?></span>
					<?php foreach ( $partners as $partner ) : ?>
						<img
							src="<?php echo esc_url( $asset_base . $partner['src'] ); ?>"
							alt="<?php echo esc_attr( $partner['alt'] ); ?>"
							loading="lazy"
						>
					<?php endforeach; ?>
				</div>
			</div>
		</div>
	</section>
	<?php
}
