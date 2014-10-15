<?php
/**
 * Functions
 *
 * @package WordPress
 * @subpackage Tangra
 * @since Tangra 1.0
 */


if ( ! function_exists( 'tangra_setup' ) ) :

	function tangra_setup() {
		// Enable post images
		add_theme_support( 'post-thumbnails' );
		// Thumbnail sizes
		add_image_size( 'thumb-small', 160, 160, true );
		add_image_size( 'thumb-medium', 800, 400, true );
		add_image_size( 'thumb-large', 1200, 600, true );
		// Custom menus
		register_nav_menus( array(
			'services'	=>	__( 'Services', 'tangra' ),
			'pages'			=>	__( 'Pages', 'tangra' ),
			'footer'		=>	__( 'Footer', 'tangra' ),
		));
		add_filter( 'nav_menu_item_id', create_function( '$a', ' return ""; ') );
		add_filter( 'nav_menu_css_class', create_function( '$a',' return array();' ) );
		add_filter( 'wp_nav_menu', create_function( '$a', 'return str_replace( " class=\"\"","", $a );' ) );
		function list_subpage_class($wp_list_pages) {
			$pattern = '/\<li class="page_item[^>]*>/';
			$replace_with = '<li>';
			return preg_replace($pattern, $replace_with, $wp_list_pages);
		}
		add_filter('wp_list_pages', 'list_subpage_class');
		// Single-View per Category
		add_filter('single_template', create_function('$the_template', 'foreach( (array) get_the_category() as $cat ) { if ( file_exists(TEMPLATEPATH . "/single-{$cat->slug}.php") ) return TEMPLATEPATH . "/single-{$cat->slug}.php"; } return $the_template;' ) );
		// Replaces the excerpt "more" text by a link
		function new_excerpt_more($more) {
			global $post;
			return '<a class="moretag" href="'. get_permalink($post->ID) . '"> ... weiter lesen</a>';
		}
		add_filter('excerpt_more', 'new_excerpt_more');
		function remove_wp_version() {
			return null;
		}
		add_filter('the_generator', 'remove_wp_version');
	}
endif; // tangra_setup
add_action( 'after_setup_theme', 'tangra_setup' );

/*  Register sidebars
/* ------------------------------------ */	
if ( ! function_exists( 'tangra_sidebars' ) ) :
	function tangra_sidebars()	{
		register_sidebar(array(
			'name' => 'Default Widget Area',
			'id' => 'widgets-default',
			'description' => 'Erscheint auf allen Seiten',
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget' => '</section>',
			'before_title' => '<h3>',
			'after_title' => '</h3>'
		));
		register_sidebar(array(
			'name' => 'Startseite Widget Area',
			'id' => 'widgets-startseite',
			'description' => 'Erscheint auf der Startseite',
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget' => '</section>',
			'before_title' => '<h3>',
			'after_title' => '</h3>'
		));
	}
endif;
add_action( 'widgets_init', 'tangra_sidebars' );

/*  Script for no-js / js class
/* ------------------------------------ */
if ( ! function_exists( 'tangra_html_js_class' ) ) {

	function tangra_html_js_class () {
		echo '
<script type="text/javascript">
	try {
		var html = document.getElementsByTagName("html")[0];
		html.className = html.className.replace("js-off", "js-on");
	} catch(err) {}
</script>
		';
	}
	
}
add_action( 'wp_footer', 'tangra_html_js_class', 1 );

/*  Enqueue javascript
/* ------------------------------------ */	
if ( ! function_exists( 'tangra_scripts' ) ) {
	
	function tangra_scripts() {
		wp_deregister_script('jquery');
		wp_enqueue_script('jquery', get_template_directory_uri() . '/js/jquery.min.js', array(), null, true);
		wp_enqueue_script('tangra', get_template_directory_uri() . '/js/tangra.js', array('jquery'), null, true);
	}  
	
}
add_action( 'wp_enqueue_scripts', 'tangra_scripts' );

if ( !function_exists( 'tangra_wp_title' ) ) :
	function tangra_wp_title( $title, $sep ) {
		global $page, $paged;
		if ( is_feed() ) {
			return $title;
		}
		// Add the site name.
		$title .= get_bloginfo( 'name' );
		// Add the site description for the home/front page.
		$site_description = get_bloginfo( 'description', 'display' );
		if ( $site_description && ( is_home() || is_front_page() ) ) {
			$title .= " $sep $site_description";
		}
		// Add a page number if necessary.
		if ( $paged >= 2 || $page >= 2 ) {
			$title .= " $sep " . sprintf( __( 'Page %s', 'tangra' ), max( $paged, $page ) );
		}
		return $title;
	}
	add_filter( 'wp_title', 'tangra_wp_title', 10, 2 );
endif;

if ( !function_exists( 'tangra_wp_description' ) ) :
	function pagedesc() {
		global $post;
		
		$desc_field = get_post_meta($post->ID, 'description', true);
		
		$the_post = get_post($post->ID);
		$the_excerpt = $the_post->post_content;
		$excerpt_length = 25;
		$the_excerpt = strip_tags(strip_shortcodes($the_excerpt));
		$desc_text = explode(' ', $the_excerpt, $excerpt_length + 1);
		
		if(count($desc_text) > $excerpt_length) :
			array_pop($desc_text);
			array_push($desc_text, '…');
			$the_excerpt = implode(' ', $desc_text);
		endif;
		$the_excerpt = $the_excerpt;
		
		if ($desc_field != '') :
			echo $desc_field;
		else :
			echo $the_excerpt;
		endif;
	}
endif;

function breadcrumb_classes() {
  global $post;
	$parents = get_post_ancestors( $post->ID );
	$id = ($parents) ? $parents[count($parents)-1]: $post->ID;
	$parent = get_page( $id );
	$class = $parent->post_name;
	if ($parents) {
		$class .= ' ';
		$class .= $post->post_name;
	}
	return $class;
}

function mobile_browser() {
	if ( wp_is_mobile() ) {
		$mobile_browser = '<meta name="viewport" content="width=device-width">';
		$mobile_browser .= '<link rel="apple-touch-icon" href="' . get_template_directory_uri() . '/img/apple-touch-icon.png">';
	}
	print_r($mobile_browser);
}

function msie_scripts() {
	if ( preg_match('/msie [6-8]/i',$_SERVER['HTTP_USER_AGENT'] )) {
		$msie_scripts = '<!--[if lt IE 9]><script src="' . get_template_directory_uri() . '/js/html5shiv.js"></script><![endif]-->';
		$msie_scripts .= '<!--[if lt IE 9]><script src="' . get_template_directory_uri() . '/js/css3-mediaqueries.js"></script><![endif]-->';
	}
	print_r($msie_scripts);
}

function internet_explorer() {
	if ( preg_match('/msie [8]/i',$_SERVER['HTTP_USER_AGENT'] )) {
		echo ' msie msie-8';
	}
	elseif ( preg_match('/msie [7]/i',$_SERVER['HTTP_USER_AGENT'] )) {
		echo ' msie msie-7';
	}
	elseif ( preg_match('/msie [6]/i',$_SERVER['HTTP_USER_AGENT'] )) {
		echo ' msie msie-6';
	}
	elseif ( preg_match('/msie [5]/i',$_SERVER['HTTP_USER_AGENT'] )) {
		echo ' msie msie-5';
	}
}

// ACCESSIBLE NAVIGATION
function tangra_menu($menu_name) {
	
	$locations = get_nav_menu_locations();
	$menu = wp_get_nav_menu_object( $locations[ $menu_name ] );
	$menu_items = wp_get_nav_menu_items($menu->term_id);
	foreach ($menu_items as $key => $value) {
		$include_pages[] = get_post_meta($value->ID, '_menu_item_object_id', true);
	}

  $pages = get_pages(array(
		'parent' => 0,
		'include' => $include_pages,
		'sort_column' => 'menu_order',
		'sort_order' => 'ASC'
	));
	
	$num_pages = count($pages);
	$p = 0;
	
	foreach($pages as &$page) :
		$children = get_pages(array(
			'sort_order' => 'ASC',
			'sort_column' => 'menu_order',
			'hierarchical' => 0,
			'childof' => $page->ID,
			'parent' => $page->ID,
			'exclude' => $exclude_list[0]->IDS
		));
		$num_children = count($children);
		$has_children = $num_children > 0;
		$li_class = $page->post_name;
		
		$accessible_navigation .= '<li' . ($has_children ? ' aria-haspopup="true"' : '') . ' class="' . ($li_class) . ($num_pages[0] == $p ? ' first-menuitem' : '') . ($num_pages == ++$p ? ' last-menuitem' : '') . '" role="menuitem">';
		$page_current = get_the_ID();
		$main_page = $page->ID;
		if ( $main_page == $page_current) :
			$accessible_navigation .= '<strong title="Die aktuelle Seite">' . $page->post_title . '</strong><span class="' . ($has_children ? 'hasSub' : 'hidden') . '">. </span>';
			else :
			$accessible_navigation .= '<a href="' . get_page_link($page->ID) . '">' . $page->post_title . '</a><span class="' . ($has_children ? 'hasSub' : 'hidden') . '">. </span>';
		endif;
		if($has_children) :
			$accessible_navigation .= '<ul class="sub-menu" role="menu">';
			$num_subpages = count($children);
			$c = 0;
			foreach($children as &$child) :
				$accessible_navigation .= '<li' . ($num_subpages[0] == $c ? ' class="first-subitem"' : '') . ($num_subpages == ++$c ? ' class="last-subitem"' : '') . ' role="menuitem">';
				$page_cur = get_the_ID();
				$child_page = $child->ID;
				if ( $child_page == $page_cur) :
					$accessible_navigation .= '<strong title="die aktuelle Seite">' . $child->post_title . '</strong>';
					else :
					$accessible_navigation .= '<a href="' . get_page_link($child->ID) . '">' . $child->post_title . '</a>';
				endif;
				$accessible_navigation .= '<span class="hidden">. </span>';
				$accessible_navigation .= '</li>';
			endforeach;
			$accessible_navigation .= '</ul>';
		endif;
		$accessible_navigation .= '</li>';
	endforeach;
	
	print_r($accessible_navigation);
}

?>

