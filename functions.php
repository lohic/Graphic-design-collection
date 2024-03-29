<?php

add_action( 'after_setup_theme', 'GDC_setup' );


if ( ! function_exists( 'GDC_setup' ) ){

	function GDC_setup() {
		if ( function_exists('register_sidebar') )
		register_sidebar();
		
		
		if ( function_exists( 'register_nav_menus' ) )
		register_nav_menus(	array( 'main_menu' => 'Menu principal' ) );
		
		
		if ( function_exists('my_register_post_types') )
		add_action( 'init', 'my_register_post_types' );
	}
}


if( ! function_exists (my_register_post_types)) {
	function my_register_post_types() {
		register_post_type(
			'collection',
			array(
				'label' => __('Collections'),
				'singular_label' => __('Collection'),
				'public' => true,
				'show_ui' => true,
				//'show_in_menu' => false,
				'menu_icon'=> 'dashicons-media-spreadsheet',
				'show_in_nav_menus'=> false,
				'capability_type' => 'post',
				'rewrite' => array("slug" => "collection"),
				'hierarchical' => false,
				'query_var' => false,
				'supports' => array('title','editor','custom-fields','thumbnail'),
				//'taxonomies' => 
			)
		);		
	}
}




/**
 * wp_enqueue_scripts action hook to link only on the front-end
 * @return [type] [description]
 */
function my_scripts_method() {
    wp_enqueue_script( 'jquery' );
	wp_enqueue_script( 'leaflet',      get_template_directory_uri() . '/js/leaflet-0.7.2/leaflet.js', false, '0.7.2', true );
	wp_enqueue_script( 'gdc',     	   get_template_directory_uri() . '/js/script.js', array('jquery','leaflet'),'1.0.1', true );
	wp_enqueue_style( 'leaflet-style', get_template_directory_uri() . '/js/leaflet-0.7.2/leaflet.css', false, '0.7.2', 'all' );
}

add_action( 'wp_enqueue_scripts', 'my_scripts_method' ); 




/**
 * BREADCRUMB
 * @return [type] [description]
 */
function dimox_breadcrumbs() {

	$showOnHome = 0; // 1 - show breadcrumbs on the homepage, 0 - don't show
	$delimiter = '<span class="divider"></span>'; // delimiter between crumbs
	$home = 'Accueil'; // text for the 'Home' link
	$showCurrent = 1; // 1 - show current post/page title in breadcrumbs, 0 - don't show
	$before = '<li class="active"><span class="current">'; // tag before the current crumb
	$after = '</span></li>'; // tag after the current crumb

	global $post;
	$homeLink = get_bloginfo('url');

	if (is_home() || is_front_page()) {

		if ($showOnHome == 1) echo '<ul class="breadcrumb"><li><a href="' . $homeLink . '">' . $home . '</a></li></ul>';

	} else {

		echo '<ol class="breadcrumb"><li><a href="' . $homeLink . '">' . $home . '</a> ' . $delimiter . '</li> ';

		if ( is_category() ) {
			$thisCat = get_category(get_query_var('cat'), false);
			if ($thisCat->parent != 0) echo '<li>'.get_category_parents($thisCat->parent, TRUE, ' ' . $delimiter . ' ').'</li>';
			echo $before . '' . single_cat_title('', false) . '' . $after;

		} elseif ( is_search() ) {
			echo $before . 'Search results for "' . get_search_query() . '"' . $after;

		} elseif ( is_day() ) {
			echo '<li><a href="' . get_year_link(get_the_time('Y')) . '">' . get_the_time('Y') . '</a> ' . $delimiter . '</li> ';
			echo '<li><a href="' . get_month_link(get_the_time('Y'),get_the_time('m')) . '">' . get_the_time('F') . '</a> ' . $delimiter . '</li> ';
			echo $before . get_the_time('d') . $after;

		} elseif ( is_month() ) {
			echo '<li><a href="' . get_year_link(get_the_time('Y')) . '">' . get_the_time('Y') . '</a> ' . $delimiter . '</li> ';
			echo $before . get_the_time('F') . $after;

		} elseif ( is_year() ) {
			echo $before . get_the_time('Y') . $after;

		} elseif ( is_single() && !is_attachment() ) {
			if ( get_post_type() != 'post' ) {
				$post_type = get_post_type_object(get_post_type());
				$slug = $post_type->rewrite;
				echo '<li><a href="' . $homeLink . '/' . $slug['slug'] . '/">' . $post_type->labels->singular_name . '</a>';
				if ($showCurrent == 1) echo ' ' . $delimiter . '</li> ' . $before . get_the_title() . $after;
			} else {
				$cat = get_the_category(); $cat = $cat[0];
				$cats = '<li>'.get_category_parents($cat, TRUE, ' ' . $delimiter . '</li><li> ').'</li>';
				if ($showCurrent == 0) $cats = preg_replace("#^(.+)\s$delimiter\s$#", "$1", $cats);
				echo str_replace('<li> </li>','',$cats);
				if ($showCurrent == 1) echo $before . get_the_title() . $after;
			}

		} elseif ( !is_single() && !is_page() && get_post_type() != 'post' && !is_404() ) {
			$post_type = get_post_type_object(get_post_type());
			echo $before . $post_type->labels->singular_name . $after;

		} elseif ( is_attachment() ) {
			$parent = get_post($post->post_parent);
			$cat = get_the_category($parent->ID); $cat = $cat[0];
			echo get_category_parents($cat, TRUE, ' ' . $delimiter . '</li> ');
			echo '<li><a href="' . get_permalink($parent) . '">' . $parent->post_title . '</a>';
			if ($showCurrent == 1) echo ' ' . $delimiter . '</li> ' . $before . get_the_title() . $after;

		} elseif ( is_page() && !$post->post_parent ) {
			if ($showCurrent == 1) echo $before . get_the_title() . $after;

		} elseif ( is_page() && $post->post_parent ) {
			$parent_id = $post->post_parent;
			$breadcrumbs = array();
			while ($parent_id) {
				$page = get_page($parent_id);
				$breadcrumbs[] = '<li><a href="' . get_permalink($page->ID) . '">' . get_the_title($page->ID) . '</a>';
				$parent_id = $page->post_parent;
			}
			$breadcrumbs = array_reverse($breadcrumbs);
			for ($i = 0; $i < count($breadcrumbs); $i++) {
				echo $breadcrumbs[$i];
				if ($i != count($breadcrumbs)-1) echo ' ' . $delimiter . '</li> ';
			}
			if ($showCurrent == 1) echo ' ' . $delimiter . '</li> ' . $before . get_the_title() . $after;

		} elseif ( is_tag() ) {
			echo $before . 'Posts tagged "' . single_tag_title('', false) . '"' . $after;

		} elseif ( is_author() ) {
			global $author;
			$userdata = get_userdata($author);
			echo $before . 'Articles posted by ' . $userdata->display_name . $after;

		} elseif ( is_404() ) {
			echo $before . 'Error 404' . $after;
		}

		if ( get_query_var('paged') ) {
			if ( is_category() || is_day() || is_month() || is_year() || is_search() || is_tag() || is_author() ) echo ' (';
			echo __(' Page') . ' ' . get_query_var('paged');
			if ( is_category() || is_day() || is_month() || is_year() || is_search() || is_tag() || is_author() ) echo ')';
		}

		echo '</ol>';

	}
} // end dimox_breadcrumbs()

