<?php
/**
 * The Header
 *
 * @package WordPress
 * @subpackage Tangra
 * @since Tangra 1.0
 */
?><!doctype html>
<html class="js-off<?php if ( wp_is_mobile() ) { echo ' mobile'; }?><?php internet_explorer(); ?>" <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<title><?php wp_title( '&#124;', true, 'right' ); ?></title>
	<meta content="<?php pagedesc(); ?>" name="description">
	<base href="<?php echo get_site_url(); ?>">
	<link rel="profile" href="http://gmpg.org/xfn/11">
	<?php mobile_browser(); ?>
	<?php msie_scripts(); ?>
	<?php wp_head(); ?>
</head>
<body class="<?php echo breadcrumb_classes(); ?><?php if($post->post_content == "") : echo ' content-false'; endif; ?>">
	<header class="site-header" role="banner">
		<nav id="nav-meta" aria-labelledby="nav-services-title" role="navigation">
			<h2 id="nav-services-title" class="hidden">Servises Menü</h2>
			<ul role="menu" class="nav-services">
				<li class="skip-link"><a href="#main">Direkt zum Inhalt</a></li>
				<li class="skip-link"><a href="#menu-pages">Zum Hauptmenü</a></li>
				<li class="search-form"><?php get_search_form(); ?></li>
				<?php if (has_nav_menu('services')) : echo tangra_menu('services'); endif; ?>
			</ul>
		</nav>
		<h1 class="site-title">
			<?php if(is_front_page()) : ?>
			<strong title="Sie sind auf der '<?php bloginfo( 'name' ); ?>' Startseite"><?php bloginfo( 'name' ); ?></strong>
			<?php else : ?>
			<a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a>
			<?php endif; ?>
		</h1>
		<p class="site-description"><?php $description = bloginfo( 'description' ); ?></p>
		<?php if (has_nav_menu('pages')) : ?>
		<nav class="nav" aria-labelledby="main-nav-title" role="navigation">
			<h2 id="main-nav-title"><span>Menü</span> <a href="<?php echo get_permalink(); ?>#menu-pages" class="menu-open">öffnen</a><span class="hidden">,</span> <a href="<?php echo get_permalink(); ?>#main-nav-title" class="menu-close">scliessen</a></h2>
			<ul role="menu" class="nav-main" id="menu-pages">
				<?php echo tangra_menu('pages'); ?>
			</ul>
		</nav>
		<?php endif; ?>
	</header>
