<?php
//* Ladies and Gentlemen...Start your engines
include_once( get_template_directory() . '/lib/init.php' );

//* Child theme (do not remove)
define( 'CHILD_THEME_NAME', 'Solace' );
define( 'CHILD_THEME_URL', 'http://bpmo.re/' );
define( 'CHILD_THEME_VERSION', '1.0' );

//* Add HTML5 markup structure
add_theme_support( 'html5' );

//* Add viewport meta tag for mobile browsers
add_theme_support( 'genesis-responsive-viewport' );

//* Add new featured image size
//TBD

//* Add Featured Image to Page and Post Above Title
add_action ( 'genesis_entry_header', 'solace_featured_image_title_singular', 9 );
function solace_featured_image_title_singular() {
 
	if ( !is_singular() || !has_post_thumbnail() )
		return;
 
	echo '<div class="singular-thumbnail">';
	genesis_image( array( 'size' => 'singular' ) );
	echo '</div>';
 
}

//* Add Previous and Next Navigation to Post
add_action('genesis_entry_footer', 'solace_custom_pagination_links', 15 );
function solace_custom_pagination_links() {
if( !is_single() ) 
      return;

    previous_post_link('<div class="single-post-nav">&laquo; %link', ' ' . get_previous_post_link('%title') , FALSE);
    echo ' / ';
    next_post_link('%link  &raquo;</div>', get_next_post_link('%title') . ' ' , FALSE);
}

//add_action('genesis_after_comments', 'custom_post_navigation');

//* Enqueue Josefin Slab and Old Standard TT Google fonts
add_action( 'wp_enqueue_scripts', 'solace_google_fonts' );
function solace_google_fonts() {

	wp_enqueue_style( 'google-fonts', '//fonts.googleapis.com/css?family=Josefin+Sans:300,400|Old+Standard+TT:400,300', array(), CHILD_THEME_VERSION );
	
}

//* Add support for post format images
//add_theme_support( 'genesis-post-format-images' );

//* Add support for post formats
//add_theme_support( 'post-formats', array(
//	'aside',
//	'audio',
//	'chat',
//	'gallery',
//	'image',
//	'link',
//	'quote',
//	'status',
//	'video'
//) );

//* Enable shortcodes in widgets
add_filter('widget_text', 'do_shortcode');

//* If you want to have the front page of your site display a static page named "home", this function will remove the page title
add_action( 'get_header', 'child_remove_page_titles' );
function child_remove_page_titles() {
if (is_page('home')) {
remove_action( 'genesis_entry_header', 'genesis_do_post_title' );
}
}

//* Unregister navigation menus
remove_theme_support( 'genesis-menus' );

//* Unregister layout settings
genesis_unregister_layout( 'sidebar-content' );
genesis_unregister_layout( 'content-sidebar-sidebar' );
genesis_unregister_layout( 'sidebar-content-sidebar' );
genesis_unregister_layout( 'sidebar-sidebar-content' );

//* Remove the entry header markup
remove_action( 'genesis_entry_header', 'genesis_entry_header_markup_open', 5 );
remove_action( 'genesis_entry_header', 'genesis_post_info', 12 );
remove_action( 'genesis_entry_header', 'genesis_entry_header_markup_close', 15 );

//* Modify the WordPress read more link
add_filter( 'the_content_more_link', 'solace_read_more' );
function solace_read_more() {

	return '<a class="more-link" href="' . get_permalink() . '">Continue Reading</a>';

}

//* Customize the entry meta in the entry footer
add_filter( 'genesis_post_meta', 'unfiltered_post_meta_filter' );
function unfiltered_post_meta_filter($post_meta) {

	$post_meta = 'Published on [post_date] by [post_author_posts_link] in [post_categories before=""] [post_edit]';
	return $post_meta;

}

//* Remove the header right widget area
unregister_sidebar( 'header-right' );

//* Unregister secondary sidebar
unregister_sidebar( 'sidebar-alt' );

//* Customize entry meta in the entry header
//add_filter( 'genesis_post_info', 'solace_post_info_filter' );
//function solace_post_info_filter($post_info) {
//	$post_info = '[post_date] [post_edit]';
//	return $post_info;
//}

//* Remove the breadcrumb
remove_action( 'genesis_before_loop', 'genesis_do_breadcrumbs' );

//* Change the footer text
add_filter('genesis_footer_creds_text', 'solace_footer_creds_filter');
function solace_footer_creds_filter( $creds ) {
	$creds = '[footer_copyright] &middot; <a href="http://brentpassmore.com">Brent Passmore</a>';
	return $creds;
}

/** Remove unused theme settings - Thank you Bill Erickson */
add_action( 'genesis_theme_settings_metaboxes', 'child_remove_metaboxes' );
function child_remove_metaboxes( $_genesis_theme_settings_pagehook ) {
    remove_meta_box( 'genesis-theme-settings-header', $_genesis_theme_settings_pagehook, 'main' );
//    remove_meta_box( 'genesis-theme-settings-nav', $_genesis_theme_settings_pagehook, 'main' );
    remove_meta_box( 'genesis-theme-settings-layout', $_genesis_theme_settings_pagehook, 'main' );
    remove_meta_box( 'genesis-theme-settings-breadcrumb', $_genesis_theme_settings_pagehook, 'main' );
//  remove_meta_box( 'genesis-theme-settings-comments', $_genesis_theme_settings_pagehook, 'main' );
//  remove_meta_box( 'genesis-theme-settings-blogpage', $_genesis_theme_settings_pagehook, 'main' );
}