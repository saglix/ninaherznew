<?php
/**
 * Site footer.
 *
 * @package SiteTheme
 */
?>
<footer class="site-footer">
	<div class="site-footer__inner">
		&copy; <?php echo esc_html( gmdate( 'Y' ) ); ?> <?php bloginfo( 'name' ); ?>
	</div>
</footer>
<?php wp_footer(); ?>
</body>
</html>
