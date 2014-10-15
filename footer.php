<?php
/**
 * The Footer
 *
 * @package WordPress
 * @subpackage Tangra
 * @since Tangra 1.0
 */
?>
	<footer class="site-footer" role="contentinfo">
		<p class="link-to-top"><a href="<?php echo get_permalink(); ?>#" title="zum Seitenanfang">nach Oben<span>. </span></a></p>
		<?php if (has_nav_menu('footer')) : ?>
		<nav class="sitemap" aria-labelledby="nav-sitemap-title" role="navigation">
			<h2 id="nav-sitemap-title" class="hidden">Seitenverzeichnis</h2>
			<ul role="menu">
				<?php echo tangra_menu('footer'); ?>
			</ul>
		</nav>
		<?php endif; ?>
		<small class="copyright">&#169; <?php echo date('Y'); ?> | <?php bloginfo( 'name' ); ?></small>
	</footer>
<?php wp_footer(); ?>
</body>
</html>