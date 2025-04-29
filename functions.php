<?php
/**
 * Catenda Theme Functions and Definitions
 *
 * This file contains the core functionality and setup for the Catenda WordPress theme.
 * It includes theme setup, script and style enqueuing, custom menu walkers, 
 * custom block patterns, and other utility functions.
 *
 * Key Features:
 * - Theme setup: Adds support for features like custom logos, post thumbnails, and HTML5 markup.
 * - Script and style enqueuing: Loads theme stylesheets and JavaScript files.
 * - Custom menu walkers: Implements custom navigation menu structures for desktop and mobile.
 * - Social sharing links: Generates shareable URLs for social media platforms.
 * - ACF options pages: Adds theme settings pages for multilingual support using Polylang.
 * - Custom block patterns: Registers reusable block patterns for the WordPress block editor.
 * - Post sorting by language: Groups and sorts posts alphabetically by language.
 * - SVG upload support: Enables uploading of SVG files in the WordPress media library.
 *
 * @package Catenda
 */
// Define theme version if not already defined.
if ( ! defined( '_S_VERSION' ) ) {
	define( '_S_VERSION', '1.0.0' );
}

/**
 * Sets up theme defaults and registers support for various WordPress features.
 */
function catenda_setup() {
	// Make theme available for translation.
	load_theme_textdomain( 'catenda', get_template_directory() . '/languages' );

	// Add default posts and comments RSS feed links to head.
	add_theme_support( 'automatic-feed-links' );

	// Let WordPress manage the document title.
	add_theme_support( 'title-tag' );

	// Enable support for Post Thumbnails on posts and pages.
	add_theme_support( 'post-thumbnails' );

	// Register primary navigation menus.
	register_nav_menus(
		array(
			'menu-primary' => esc_html__( 'Primary', 'catenda' ),
			'menu-primary-mobile' => esc_html__( 'Primary Mobile', 'catenda' ),
		)
	);

	// Switch default core markup for search form, comment form, and comments to output valid HTML5.
	add_theme_support(
		'html5',
		array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
			'style',
			'script',
		)
	);

	// Enable WordPress core custom background feature.
	add_theme_support(
		'custom-background',
		apply_filters(
			'catenda_custom_background_args',
			array(
				'default-color' => 'ffffff',
				'default-image' => '',
			)
		)
	);

	// Add theme support for selective refresh for widgets.
	add_theme_support( 'customize-selective-refresh-widgets' );

	// Add support for core custom logo.
	add_theme_support(
		'custom-logo',
		array(
			'height'      => 250,
			'width'       => 250,
			'flex-width'  => true,
			'flex-height' => true,
		)
	);
}
add_action( 'after_setup_theme', 'catenda_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 */
function catenda_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'catenda_content_width', 640 );
}
add_action( 'after_setup_theme', 'catenda_content_width', 0 );


/**
 * Enqueue scripts and styles.
 */
function catenda_scripts() {
	wp_enqueue_style( 'catenda-style', get_stylesheet_uri(), array(), _S_VERSION );
	wp_enqueue_style('swiper', "https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.css", array(), rand(111,9999));
	wp_enqueue_style('style', get_template_directory_uri(). '/styles/style.css', array(), rand(111,9999));
	wp_enqueue_style('reset', get_template_directory_uri(). '/styles/reset.css', array(), rand(111,9999));
	
	wp_enqueue_script( 'swiper',"https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.js", array(), _S_VERSION, true );
	wp_enqueue_script( 'index', get_template_directory_uri() . '/js/index.js', array(), rand(111,9999), true );
	wp_enqueue_script( 'glossary', get_template_directory_uri() . '/js/glossary.js', array(), rand(111,9999), true );

}
add_action( 'wp_enqueue_scripts', 'catenda_scripts' );


/**
 * Generates a social share link for a post (Twitter, Facebook, or LinkedIn).
 */

function social_share_link($post_id, $type) {
	$siteurlfromsettingsgeneral =  get_bloginfo( 'url' );
	$domainparts = parse_url($siteurlfromsettingsgeneral);
	$domain = isset($domainparts['host']) ? $domainparts['host'] : '';
	$post_url = urlencode( get_page_link($post_id) );
	$post_title = str_replace( ' ', '%20', get_the_title($post_id));
// Generate appropriate URL based on the social platform.
	if($type == 'twitter'){
		$URL = 'https://twitter.com/intent/tweet?url='.$post_url.'&text='.$post_title.'';
	}
	else if($type == 'facebook'){
		$URL = 'https://www.facebook.com/sharer/sharer.php?u='.$post_url.'';
	}else{
		$URL = 'https://www.linkedin.com/sharing/share-offsite/?url='.$post_url.'';
	}
	
	return $URL;
}


/**
 * Adds SCF options page for theme settings.
 */

 if ( function_exists( 'acf_add_options_page' ) ) {

  
	// Main Theme Settings Page
	$parent = acf_add_options_page( array(
	  'page_title' => 'Theme General Settings',
	  'menu_title' => 'Theme Settings',
	  'redirect'   => 'Theme Settings',
	) );

	// Adds sub-pages for language-specific options (using Polylang).

	
	$languages = pll_languages_list( );
  
	foreach ( $languages as $lang ) {
	

	  acf_add_options_sub_page( array(
		'page_title' => 'Theme Settings (' . strtoupper( $lang ) . ')',
		'menu_title' => __('Theme Settings (' . strtoupper( $lang ) . ')', 'catenda'),
		'menu_slug'  => "theme-settings-{$lang}",
		'post_id'    => $lang,
		'parent'     => $parent['menu_slug']
	  ) );
	
	}
  
  }

/**
 * Custom Walker class for desktop menu.
 */
class Catenda_Menu_Walker_Desktop extends Walker_Nav_Menu {
	function start_lvl(&$output, $depth=0, $args=null) { 
		// Wrap first level menu in a div for styling.
		if($depth == 0){
			$output .= '<div><div>';
		}
	}

	function end_lvl(&$output, $depth=0, $args=null) {
		// Close div wrapper for first level menu.
		if($depth == 0){
			$output .= '</div></div>';
		}
	}

	function start_el(&$output, $item, $depth=0, $args=[], $id=0) {
		// Custom styling for items with children.
		if (is_object($args) && $args->walker->has_children) {
			if($depth == 0){
				$output .= '<li class="' .  implode(' ', $item->classes) . '">';
				$output .= '<a class="" role="button"><span>' . $item->title . '</span><button><img src="'.get_template_directory_uri().'/img/arrow-bottom.svg" alt=""></button></a>';
			}
		} else {
			if($depth == 0){
				$output .= "<li >";
				$output .= '<a href="' . $item->url . '"><span>';
				$output .= $item->title;
				$output .= '</span></a>';
			}else{
				$output .= '<a href="' . $item->url . '">';
				$output .= $item->title;
				$output .= '</a>';
			}
		}
	}

	function end_el(&$output, $item, $depth=0, $args=null) { 
		// Close list item for menu items with/without children.
		if ($args->walker->has_children) {
			if($depth == 0){
				$output .= '</li>';
			}
		} else {
			if($depth == 0){
				$output .= '</li>';
			}
		}
	}
}

/**
 * Custom Walker class for mobile menu.
 */
class Catenda_Menu_Walker_Mobile extends Walker_Nav_Menu {
	function start_lvl(&$output, $depth=0, $args=null) { 
		// Wrap first level menu in a div for mobile styling.
		if($depth == 0){
			$output .= '<div>';
		}
	}

	function end_lvl(&$output, $depth=0, $args=null) {
		// Close div wrapper for mobile menu.
		if($depth == 0){
			$output .= '</div>';
		}
	}

	function start_el(&$output, $item, $depth=0, $args=[], $id=0) {
		// Custom mobile item with accordion arrow.
		if ($args->walker->has_children) {
			if($depth == 0){
				$output .= '<li>';
				$output .= '<a class="" role="button"><span>' . $item->title . '</span><div class="accordion__arrow"> <svg width="14" height="8" viewBox="0 0 8 4"
                                                    fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <path
                                                        d="M6.78421 0L4 2.64169L1.21579 0L0.5 0.679154L4 4L7.5 0.679154L6.78421 0Z"
                                                        fill="#647273" />
                                                </svg>
                                            </div></a>';
			}
		} else {
			if($depth == 0){
				$output .= "<li>";
				$output .= '<a href="' . $item->url . '"><span>';
				$output .= $item->title;
				$output .= '</span></a>';
			}else{
				$output .= '<a href="' . $item->url . '">';
				$output .= $item->title;
				$output .= '</a>';
			}
		}
	}

	function end_el(&$output, $item, $depth=0, $args=null) { 
		// Close list item for mobile menu items.
		if ($args->walker->has_children) {
			if($depth == 0){
				$output .= '</li>';
			}
		} else {
			if($depth == 0){
				$output .= '</li>';
			}
		}
	}
}


/**
 * Registers custom block pattern categories and patterns.
 */
add_action( 'init', 'themeslug_register_pattern_categories' );
function themeslug_register_pattern_categories() {
	register_block_pattern_category( 'catenda/custom', array( 
		'label'       => __( 'Catenda', 'catenda' ),
		'description' => __( 'Custom patterns for Catenda theme.', 'catenda' )
	) );
}

add_action( 'init', 'themeslug_register_patterns' );
function themeslug_register_patterns() {
	// Register custom quote block pattern.
	register_block_pattern( 'catenda/quote', array(
		'title'      => __( 'Quote', 'catenda' ),
		'categories' => array( 'custom' ),
		'source'     => 'theme',
		'content'    => '<!-- wp:group {"tagName":"section","layout":{"type":"constrained"}} -->
<section class="quote-section wp-block-group ">
    <!-- wp:paragraph -->
    <p>
        "Ipsum sit mattis nulla quam nulla. Gravida id gravida ac enim mauris id. Non
        pellentesque congue eget consectetur turpis."
    </p>
    <!-- /wp:paragraph -->
    <!-- wp:paragraph -->
    <p>Mark Brean</p>
    <!-- /wp:paragraph -->
    <!-- wp:paragraph -->
    <p>Founder &amp; Director</p>
    <!-- /wp:paragraph -->
</section>
<!-- /wp:group -->'
	) );
}


/**
 * Custom save post function to update sorted post IDs by language.
 */
function my_save_post_function($post_id, $post, $update) {
	if ($post->post_type !== 'post' || wp_is_post_autosave($post_id) || wp_is_post_revision($post_id)) {
		return;
	}
	if($post->post_status == 'draft' || $post->post_status == 'pending'){
		return;
	}else{	
    	update_sorted_post_ids_by_language();
	}
}

add_action('save_post', 'my_save_post_function', 10, 3);

/**
 * Get sorted post IDs by language.
 */
function get_sorted_post_ids_by_language($language = 'en') {
    $sorted_post_ids = get_option('sorted_post_ids', array());

    return isset($sorted_post_ids[$language]) ? $sorted_post_ids[$language] : array();
}

/**
 * Update sorted post IDs by language.
 */
function update_sorted_post_ids_by_language() {
  

    $current_language = pll_current_language();
	if (!$current_language || !is_string($current_language)) {
        return;
    }
    $args = array(
        'post_type'      => 'post',
        'posts_per_page' => -1,
        'orderby'        => 'title',
        'order'          => 'ASC',
		'lang'           => $current_language, // Filter by current language
    );

    $posts_for_filter = new WP_Query($args);
    $posts_array = array();

    while ($posts_for_filter->have_posts()) : $posts_for_filter->the_post();
		$slug = sanitize_title(basename(get_permalink()));
		$first_letter = strtolower(substr($slug, 0, 1));
        $post_id = get_the_ID();

        if (is_numeric($first_letter)) {
            $first_letter = '0-9';
        }

        if (!isset($posts_array[$first_letter])) {
            $posts_array[$first_letter] = array();
        }

        $posts_array[$first_letter][] = $post_id;
    endwhile;

    wp_reset_postdata();

    // Retrieve and update the sorted array for the current language
    $sorted_post_ids = get_option('sorted_post_ids', array());
    $sorted_post_ids[$current_language] = $posts_array;

    // Store the sorted post IDs array in WordPress options
    update_option('sorted_post_ids', $sorted_post_ids);
}

/**
 * Enable SVG file uploads in WordPress.
 */
function enable_svg_upload($mimes) {
	$mimes['svg'] = 'image/svg+xml';
	return $mimes;
}
add_filter('upload_mimes', 'enable_svg_upload');
