<?php
/**
 * Main template file.
 *
 * @package SiteTheme
 */

get_header();

if ( is_front_page() || is_home() ) {
	site_theme_render_home_banners();
}
?>

<main id="primary" class="site-main">
	<?php
	if ( is_front_page() || is_home() ) {
		site_theme_render_home_events();
		site_theme_render_home_about();
	}
	?>

	<?php if ( ! is_front_page() && ! is_home() ) : ?>
	<section class="content-area">
		<?php if ( have_posts() ) : ?>
			<?php
			while ( have_posts() ) :
				the_post();
				?>
				<article id="post-<?php the_ID(); ?>" <?php post_class( 'post-card' ); ?>>
					<h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
					<?php the_excerpt(); ?>
				</article>
			<?php endwhile; ?>

			<?php the_posts_pagination(); ?>
		<?php else : ?>
			<article class="post-card">
				<h2><?php esc_html_e( 'ברוכים הבאים', 'site-theme' ); ?></h2>
				<p><?php esc_html_e( 'אתר הוורדפרס החדש שלך מוכן לתוכן.', 'site-theme' ); ?></p>
			</article>
		<?php endif; ?>
	</section>
	<?php endif; ?>
</main>

<?php
get_footer();
