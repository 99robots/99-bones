<?php
// Exit if accessed directly
if ( !defined('ABSPATH')) exit;

/* ********************
 * Load theme shortcodes css file and include shortcodes.php file
 * only if shortcodes option is activated on theme control panel
 ******************************************************************** */
	if (of_get_option('of_shortcodes') == 1) {
		if (!is_admin()) add_action( 'wp_print_styles', 'gabfire_shortcodecss' );
			if (!function_exists('gabfire_shortcodecss')) {
				function gabfire_shortcodecss() {
					if(file_exists(get_stylesheet_directory() . '/framework/functions/css/shortcodes.css')) { 
						wp_enqueue_style('gabfire_shortcodes', get_template_directory_uri() .'/framework/functions/css/shortcodes.css');
					} else {
						wp_enqueue_style('gabfire_shortcodes', get_template_directory_uri() .'/framework/functions/css/shortcodes.css');
					}
				}
		}
		get_template_part( 'framework/functions/shortcodes', '' );
	}	
	
/* ********************
 * Modify dynamic_sidebar widget function slightly to return a
 * variable and display name of widget zone to ste admin if the
 * option 'display widget map' is activated on theme control panel
 ******************************************************************** */
	function gabfire_dynamic_sidebar($widgetname)
	{
	  dynamic_sidebar($widgetname);  
	  if((of_get_option('of_widget', 0) == 1) and is_user_logged_in() ) { 
		echo '<span class="widgetmapname">'.$widgetname.'</span>'; 
	  }  
	}

/* ********************
 * Some navigations displays pages and cats side by side. If there is
 * not any registered category within site, 'No Categories' string shows
 * on navigation together with pages. bm_dont_display_it function is going
 * to hide 'no categories' string incase of this scenario.
 ******************************************************************** */
	function bm_dont_display_it($dont_display) {
	  if (!empty($dont_display)) {
		$dont_display = str_ireplace('<li>' .__( "No categories", "gabfire" ). '</li>', "", $dont_display);
	  }
	  return $dont_display;
	}
	add_filter('wp_list_categories','bm_dont_display_it');

/* ********************
 * The site title that is displayed in header
 * between <title></title> tags
 ******************************************************************** */
add_filter( 'wp_title', 'gabfire_wp_title', 10, 3 );

function gabfire_wp_title( $old_title, $sep, $sep_location ) {
    global $page, $paged;
    /** Set initial title text */
    $title = get_bloginfo( 'name' );
    /** Add wrapping spaces to separator character */
    $sep = ' ' . $sep . ' ';

    $gabfire_title_text = $title;

    /** Add the blog description (tagline) for the home/front page */
    $site_tagline = get_bloginfo( 'description', 'display' );
    if ( $site_tagline && ( is_home() || is_front_page() ) )
        $gabfire_title_text = $title . $sep . $site_tagline;

    if ( is_page() || is_single() )
        $gabfire_title_text = get_the_title() . $sep . $title;

    if ( is_category() ) {
        $gabfire_title_text = sprintf( __( '%s Archive', 'gabfire' ), single_cat_title( '', false ) ) . $sep . $title;
    } elseif ( is_day() ) {
        $gabfire_title_text = sprintf( __( 'Archive for %s', 'gabfire' ), get_the_time( 'F jS, Y' ) ) . $sep . $title;
    } elseif ( is_month() ) {
        $gabfire_title_text = sprintf( __( 'Archive for %s', 'gabfire' ), get_the_time( 'F, Y' ) ) . $sep . $title;
    } elseif ( is_year() ) {
        $gabfire_title_text = sprintf( __( 'Archive for %s', 'gabfire' ), get_the_time( 'Y' ) ) . $sep . $title;
    } elseif ( is_search() ) {
        $gabfire_title_text = sprintf( __( 'Search Results for %s', 'gabfire' ), $_GET['s'] ) . $sep . $title;
    } elseif ( is_author() ) {
        $gabfire_title_text = __( 'Author Archive', 'gabfire' ) . $sep . $title;
    } elseif ( is_tag() ) {
        $gabfire_title_text = __( 'Tag Archive', 'gabfire' ) . $sep . $title;
    } elseif ( is_feed() ) {
        $gabfire_title_text ='';
    }

    /** Add a page number if necessary */
    if ( $paged >= 2 || $page >= 2 )
        $gabfire_title_text .= $sep . sprintf( __( 'Page %s', 'gabfire' ), max( $paged, $page ) );

    return strip_tags(($gabfire_title_text));
}

/* ********************
 * Source framework has support to display category based ads.
 * Using current_catID; we check whether a file exist with
 * current_catID.php name or not.
 ******************************************************************** */
	function current_catID() {
		global $wp_query,  $cat_obj, $currentcat;

		if (is_category()) {	
			$cat_obj = $wp_query->get_queried_object();
			$currentcat = $cat_obj->term_id;
		} 
		elseif (is_single() and !is_attachment()) {
			$category = get_the_category();
			$currentcat = $category[0]->cat_ID;
		}
		
		return $currentcat;
	}

/* ********************
 * Category based ad function.
 * Using current_catID function, we check if an ad file per cat
 * is available or not.
 ******************************************************************** */
 	function gabfire_categoryad($path) {
		if((is_single() or is_category()) and (file_exists(get_template_directory() . '/ads/'.$path.'/'. current_catID() .'.php'))) {
			get_template_part('/ads/'.$path.'/'. gabfire_current_catID());
		} else {
			get_template_part('/ads/'.$path);
		}
	}

/* ********************
 * Limit post excerpts. Within theme files used as 
 * print string_limit_words(get_the_excerpt(), 16);
 ******************************************************************** */
	function string_limit_words($string, $word_limit) {
		global $post, $page;
		
		if( $post->post_excerpt ) {
			$word_limit = 999;
		}
		$words = explode(' ', $string, ($word_limit + 1));
		if(count($words) > $word_limit)
		array_pop($words);
		return implode(' ', $words);

	}

/* ********************
 * The post meta display below post excerpts on front page
 * default usage gabfire_postmeta(date, comment, permalink, edit-post)
 ******************************************************************** */
	function gabfire_permalink() { /* We first create a function to get the post permalink with read more anchor */
		echo '<span class="meta_permalink">';
		echo '<a href="'; the_permalink(); echo '" title="'; printf( esc_attr__( 'Permalink to %s', 'gabfire' ), the_title_attribute( 'echo=0' ) ); echo'" rel="bookmark">'; esc_attr_e('Read More', 'gabfire'); echo '</a>';
		echo '</span>';
	}
	function gabfire_postcomment() { /* We first create a function to get the post permalink with read more anchor */
		echo '<span class="meta_comment">';
		comments_popup_link(__('No Comment','gabfire'), __('1 Comment','gabfire'), __('% Comments','gabfire'));
		echo '</span>';
	}	
	
	function gabfire_postmeta($date = true,$comment = true,$permalink = true,$edit = true) {
		echo '<p class="postmeta">';
			echo (true === $date) ? '<span class="meta_date">' . get_the_date() . '</span>' : "";
			echo (true === $comment) ? gabfire_postcomment() : "";
			echo (true === $permalink) ?  gabfire_permalink() : "";
			(true === $edit) ? edit_post_link(__('#','gabfire'),'<span class="meta_edit">','</span>') : "";
		echo '</p>';
	}

/* ********************
 * Truncate post title. 
 * default usage gabfire_posttitle(title length,string after title)
 ******************************************************************** */
    function gabfire_posttitle($t_length,$t_end) {
        global $post;
        $thetitle = $post->post_title;
        if( function_exists('mb_strlen') ) {
            $getlength = mb_strlen($thetitle, 'UTF-8');
            $thelength = $t_length;
            echo mb_substr($thetitle, 0, $thelength, 'UTF-8');
        } else {
            $getlength = strlen($thetitle);
            $thelength = $t_length;
            echo substr($thetitle, 0, $thelength);
        }
        if ($getlength > $thelength) echo $t_end;
    }  
	

/* ********************
 * Adding the Open Graph in the Language Attributes
 ******************************************************************** */
if (of_get_option('of_fbonhead', 0) == 1) {
add_filter('language_attributes', 'add_og_xml_ns');
function add_og_xml_ns($content) {
  return ' xmlns:og="http://ogp.me/ns#" ' . $content;
}
add_filter('language_attributes', 'add_fb_xml_ns');

function add_fb_xml_ns($content) {
  return ' xmlns:fb="https://www.facebook.com/2008/fbml" ' . $content;
}
	//Lets add Open Graph Meta Info
	function facebookmeta_head() {
		global $post;
		if ( is_single() ) {
			echo '<meta property="og:title" content="' . get_the_title() . '"/>'."\n"; 
			echo '<meta property="og:type" content="article"/>'."\n"; 
			echo '<meta property="og:url" content="' . get_permalink() . '"/>'."\n"; 
			echo '<meta property="og:site_name" content="' . get_bloginfo('name') . '"/>'."\n"; 
			
			$thumbnail_src = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'medium' );
			echo '<meta property="og:image" content="' . esc_attr( $thumbnail_src[0] ) . '"/>';
		echo "\n";
		}
	}
	add_action( 'wp_head', 'facebookmeta_head', 5 );
}

/* ********************
 * Innerpage Slider
 * single postpage slider that auto grabs all attached pictures
 * and displays them with a nice slider
 ******************************************************************** */
 function gabfire_innerslider() {
	global $post, $page;
	if (of_get_option('of_inslider') == 2) {
		get_template_part( 'inc/theme-gallery', '' );
	} 
	elseif (
			( of_get_option('of_inslider') == 1) and (has_tag(of_get_option('of_inslider_tag')) ) 
		or 
			(  has_term( of_get_option('of_inslider_tag') , 'gallery-tag', '' )) ) 
	{
		get_template_part( 'inc/theme-gallery', '' );
	}
} 

/* ********************
 * Ad video-post class
 * add video-post as a class into post_class function
 * based on custom fields defined within post.
 ******************************************************************** */
	add_filter('post_class','gabfire_post_classes');

	function gabfire_post_classes( $classes ) {
		if ( (get_post_meta( get_the_ID(), 'iframe', true )) or (get_post_meta( get_the_ID(), 'videoflv', true )) ){
			$classes[] = 'video-post';
		}
		return $classes;
	}

/* ********************
 * WordPress [gallery] style
 * Remove native gallery style
 ******************************************************************** */
	function remove_native_gallery_style( $css ) {
		return preg_replace( "#<style type='text/css'>(.*?)</style>#s", '', $css );
	}
	add_filter( 'gallery_style', 'remove_native_gallery_style' );
	
/* ********************
 * Get the current post type in WordPress Admin
 * sample snippet to use
 * if ( get_current_post_type() == 'post' ) { }
 ******************************************************************** */
	function get_current_post_type() {
	  global $post, $typenow, $current_screen;
		
	  //we have a post so we can just get the post type from that
	  if ( $post && $post->post_type )
		return $post->post_type;
		
	  //check the global $typenow - set in admin.php
	  elseif( $typenow )
		return $typenow;
		
	  //check the global $current_screen object - set in sceen.php
	  elseif( $current_screen && $current_screen->post_type )
		return $current_screen->post_type;
	  
	  //lastly check the post_type querystring
	  elseif( isset( $_REQUEST['post_type'] ) )
		return sanitize_key( $_REQUEST['post_type'] );
		
	  //we do not know the post type!
	  return null;
	}
	
/* ********************
 * Add css class last_archivepost to last posts
 * in archive query
 * used in conjunction with post_class('archive-post')
 ******************************************************************** */	
add_filter('post_class', 'last_post_class');
function last_post_class($classes) {

	global $wp_query;
	if(($wp_query->current_post+1) == $wp_query->post_count) {
		$classes[] = 'last_archivepost';
	}
	
	return $classes;
}

/* ********************
 * Return WordPress Archive Pagination
 * into a function 
 ******************************************************************** */	
 function gabfire_archivepagination() {
	if((get_next_posts_link()) or (get_previous_posts_link())) { ?>
		<div class="archive-pagination">
			<?php
			// load pagination
			global $wp_query;

			$big = 999999999;
			echo paginate_links( array(
				'base' => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
				'format' => '?paged=%#%',
				'current' => max( 1, get_query_var('paged') ),
				'total' => $wp_query->max_num_pages
			) );
			?>
		</div>
	<?php
	}
}