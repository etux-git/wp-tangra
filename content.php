<?php
/**
 * Page content
 *
 * @package WordPress
 * @subpackage Tangra
 * @since Tangra 1.0
 */
?>
<main class="main" role="main">
	<article id="<?php global $post; echo $post->post_name; ?>" class="hentry" itemscope itemType="http://schema.org/Article">
		<header class="entry-header"><h1 class="entry-title" itemprop="title"><?php the_title(); ?></h1></header>
		<div class="entry-content" itemprop="articleBody">
			<?php the_content(); ?>
		</div>
		<footer class="entry-footer">
			<ul class="entry-meta">
				<li class="published">Publiziert am <time datetime="<?php the_time('c'); ?>" itemprop="datePublished"><?php the_date(); ?> um <?php the_time(); ?></time>.</li>
				<?php if (get_the_modified_time() != get_the_time()) { ?>
				<li class="updated modified">Zuletzt aktuallisiert am <time datetime="<?php the_modified_time('c'); ?>" itemprop="dateModified"><?php the_modified_time('d F Y'); ?></time>.</li>
				<?php } ?>
			</ul>
		</footer>
	</article>
</main>