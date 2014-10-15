<?php
/**
 * The Sidebar
 *
 * @package WordPress
 * @subpackage Tangra
 * @since Tangra 1.0
 */
?>
<?php if ( is_active_sidebar() ) : ?>
<aside class="sidebar" role="complementary">
  <?php if ( is_active_sidebar( 'widgets-default' ) ) : ?>
	<div class="default-sidebar widget-area" role="complementary">
		<?php dynamic_sidebar( 'widgets-default' ); ?>
	</div>
	<?php endif; ?>
</aside>
<?php endif; ?>