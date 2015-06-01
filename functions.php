<?php
/* ********************
 * Load theme control panel
 * and framework files
 ******************************************************************** */
	if ( !function_exists( 'optionsframework_init' ) ) {
		define( 'OPTIONS_FRAMEWORK_DIRECTORY', get_template_directory_uri() . '/framework/admin/' );
		require_once dirname( __FILE__ ) . '/framework/admin/options-framework.php';

		// FRAMEWORK FILES
		get_template_part( 'framework/functions/misc-functions');
		get_template_part( 'framework/functions/breadcrumb');
		get_template_part( 'framework/functions/gabfire-media');

	}

/* ********************
 * Setup Theme
 ******************************************************************** */
if ( ! function_exists( 'gabfire_setup_theme' ) ) {
	function gabfire_setup_theme() {

		// Translations can be added to the inc/lang/ directory.
		load_theme_textdomain('gabfire', get_template_directory() . '/inc/lang');

		// Adds RSS feed links to <head> for posts and comments.
		add_theme_support( 'automatic-feed-links' );

		// Custom Navigation Suport
		add_theme_support( 'menus' );

		/*
		 * Switches default core markup for search form, comment form,
		 * and comments to output valid HTML5.
		 */
		add_theme_support( 'html5', array(
			'search-form', 'comment-form', 'comment-list', 'gallery', 'caption'
		) );

		if ( ! isset( $content_width ) ) $content_width = 750;

		add_theme_support('custom-background');

		// This theme uses wp_nav_menu() in one location.
		register_nav_menu( 'primary', __( 'Navigation Menu', 'gabfire' ) );

		// Enable support for Post Thumbnails.
		add_theme_support( 'post-thumbnails' );
		set_post_thumbnail_size( 250, 250, true);
		add_image_size( 'z-post', 700, 350, true );
		add_image_size( 'figure', 415, 284, true );
		add_image_size( 'figure-single', 432, 296, true );
		add_image_size( 'small-figure', 70, 66, true );
		add_image_size( 'post-nosidebar', 1030, 480, true );
		add_image_size( 'post-sidebar', 700, 380, true );

	}
	add_action( 'after_setup_theme', 'gabfire_setup_theme' );
}

/* ********************
 * Load theme styles and custom scripts
 ******************************************************************** */
	if ( !function_exists( 'gabfire_theme_scripts' ) ) {

		function gabfire_theme_scripts() {
			wp_enqueue_style('bootstrap', get_template_directory_uri() .'/framework/bootstrap/css/bootstrap.min.css');
			wp_enqueue_style('font-awesome', get_template_directory_uri() .'/framework/font-awesome/css/font-awesome.min.css');
			wp_enqueue_style('bootstrap-social', get_template_directory_uri() .'/css/bootstrap-social.css');
			wp_enqueue_style('colorbox-css', get_template_directory_uri() .'/css/colorbox.css');
			wp_enqueue_style('animate-css', get_template_directory_uri() .'/css/animate.css');
			wp_enqueue_style('theme-style', get_stylesheet_uri(), false);

			// NEW: Add Ion Icons
			wp_enqueue_style('ion-icons', get_template_directory_uri() .'/framework/ion-icons/css/ionicons.min.css');

			get_template_part( 'css/customizedcss', '' );

			wp_enqueue_script( 'jquery' );
			wp_enqueue_script('bootstrap', get_template_directory_uri() .'/framework/bootstrap/js/bootstrap.min.js');
			wp_enqueue_script('modernizr', get_template_directory_uri() .'/inc/js/modernizr.custom.js');
			wp_enqueue_script('responsive-nav', get_template_directory_uri() .'/inc/js/responsive-menu.js');
			wp_enqueue_script('jquery-colorbox', get_template_directory_uri() .'/inc/js/jquery.colorbox-min.js');

			if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
				wp_enqueue_script( 'comment-reply' );
			}

			if(file_exists(get_stylesheet_directory() . '/custom.css')) {
				wp_enqueue_style('custom-style', get_stylesheet_directory_uri() .'/custom.css');
			} elseif(file_exists(get_template_directory_uri() . '/custom.css')) {
				wp_enqueue_style('custom-style', get_template_directory_uri() .'/custom.css');
			}

		}

		add_action( 'wp_enqueue_scripts', 'gabfire_theme_scripts' );
	}

/* ********************
 * Define content width
 ******************************************************************** */
	if ( ! isset( $content_width ) ) {
		$content_width = 900;
	}

 /* ********************
 * Get Youtube embed URL using actual bar
 ******************************************************************** */
	 if ( !function_exists( 'gabfire_get_youtubeembed' ) ) {
		function gabfire_get_youtubeembed($string,$autoplay=0)
		{
			preg_match('#(?:http://)?(?:www\.)?(?:youtube\.com/(?:v/|watch\?v=)|youtu\.be/)([\w-]+)(?:\S+)?#', $string, $match);
			$embed = "www.youtube.com/embed/$match[1]?autoplay=$autoplay";
			return str_replace($match[0], $embed, $string);
		}
	}

/* ********************
 * Initialize theme scripts
 ******************************************************************** */
	if ( !function_exists( 'gabfire_initialize_scripts' ) ) {

		function gabfire_initialize_scripts() {	?>

	<script type='text/javascript'>
	<!--
		(function($) {
			$(document).ready(function() {
				$(".children").parent("li").addClass("has-child-menu");
				$(".sub-menu").parent("li").addClass("has-child-menu");
				$(".drop").parent("li").addClass("has-child-menu");

				$('.mainnav li ul').hide().removeClass('fallback');
				$('.mainnav li').hover(
					function () {
						$('ul', this).stop().slideDown(250);
					},
					function () {
						$('ul', this).stop().slideUp(250);
					}
				);
				// Responsive Menu (TinyNav)
				$(".responsive_menu").tinyNav({
					active: 'current_page_item', // Set the "active" class for default menu
					label: ''
				});
				$(".tinynav").selectbox();

				/* Colorbox */
				$(".video_colorbox").colorbox({iframe:true, width:"66%", height:"80%"});

				/* Slide to ID & remove 80px as top offset (for navigation) when sliding down */
				$('a[href*=#]:not([href=#])').click(function() {
					if (location.pathname.replace(/^\//, '') == this.pathname.replace(/^\//, '') || location.hostname == this.hostname) {

						var target = $(this.hash);
						target = target.length ? target : $('[name=' + this.hash.slice(1) + ']');
						if (target.length) {
							$('html,body').animate({
								scrollTop: target.offset().top - 65
							}, 1000);
							return false;
						}
					}
				});

				/* Slide to Top */
				//$('a[href=#top]').click(function(){	$('html, body').animate({scrollTop:0}, 'slow');	return false; });

			});
		})(jQuery);

		/*Youtube Video*/
		var player;
		function onYouTubeIframeAPIReady() {player = new YT.Player('player');}
		if(window.opera){
			addEventListener('load', onYouTubeIframeAPIReady, false);
		}
	// -->
	</script>

		<?php
		}

		add_action("wp_head", "gabfire_initialize_scripts");
	}

/* ********************
 * Get number of Facebook Fans
 * <?php echo gabfire_fbcount('gabfire');?> User name
 * <?php echo gabfire_fbcount('330773148827'); ?> Profile ID
 ******************************************************************** */
function gabfire_fbcount( $value = '' ) {
	if($value){
		$url='http://api.facebook.com/method/fql.query?query=SELECT fan_count FROM page WHERE';

		if(is_numeric($value)) {
			$qry=' page_id="'.$value.'"';
		} else {
			$qry=' username="'.$value.'"';
		}

		$xml = @simplexml_load_file($url.$qry) or die ("invalid operation");

		$gabfire_fbcount = $xml->page->fan_count;
		return $gabfire_fbcount;

		} else {
			return '0';
		}
	}

/* ********************
 * Set number of entries per category
 ******************************************************************** */
	if ( ! function_exists( 'entrynr_perCat' ) ) {
		function entrynr_perCat( $query ) {
			if ( is_admin() || ! $query->is_main_query() )
				return;

			if ( is_category(explode(',', of_get_option('of_2col'))) ) {
				$query->set( 'posts_per_page', 6 );
				return;
			}

			if ( is_category(explode(',', of_get_option('of_2col_full'))) ) {
				$query->set( 'posts_per_page', 6 );
				return;
			}

			if ( is_category(explode(',', of_get_option('of_3col_full'))) ) {
				$query->set( 'posts_per_page', 12 );
				return;
			}

			if ( is_category(explode(',', of_get_option('of_4col_full'))) ) {
				$query->set( 'posts_per_page', 12 );
				return;
			}

			if ( is_category(explode(',', of_get_option('of_authorcat'))) ) {
				$query->set( 'posts_per_page', 6 );
				return;
			}

			if ( ( is_category(explode(',', of_get_option('of_w_slider'))) ) ) {
				$query->set( 'posts_per_page', 8 );
				return;
			}

		}
		add_action( 'pre_get_posts', 'entrynr_perCat', 1 );
	}

/* ********************
 * Custom field panels below text editor
 ******************************************************************** */
if ( !function_exists( 'gabfire_meta_box_add' ) ) {

	add_action( 'add_meta_boxes', 'gabfire_meta_box_add' );

	function gabfire_meta_box_add()
	{
		add_meta_box( '', __('Gabfire Custom Fields', 'gabfire'), 'gabfire_meta_box_post', 'post', 'normal', 'high' );
		add_meta_box( '', __('Gabfire Custom Fields', 'gabfire'), 'gabfire_meta_box_post', 'page', 'normal', 'high' );
	}

	/* Create Post and Page Custom Fields */
	function gabfire_meta_box_post( $post )
	{
		$values = get_post_custom( $post->ID );
		$video = isset( $values['iframe'] ) ? esc_attr( $values['iframe'][0] ) : '';
		$feapost = isset( $values['featured'] ) ? esc_attr( $values['featured'][0] ) : '';
		$audio = isset( $values['audio'] ) ? esc_attr( $values['audio'][0] ) : '';
		$postslider = isset( $values['disable_postslider'] ) ? esc_attr( $values['disable_postslider'][0] ) : '';
		$disable_feaimage = isset( $values['post_feaimage'] ) ? esc_attr( $values['post_feaimage'][0] ) : '';
		$subtitle = isset( $values['subtitle'] ) ? esc_attr( $values['subtitle'][0] ) : '';
		$selected = isset( $values['gabfire_post_template'] ) ? esc_attr( $values['gabfire_post_template'][0] ) : '';

		wp_nonce_field( 'my_meta_box_nonce', 'meta_box_nonce' );
		?>

		<div class="gabfire_fieldgroup">
			<p class="gabfire_fieldcaption"><?php _e('Post Entrance', 'gabfire'); ?></p>

			<p class="gabfire_fieldrow">
				<label for="subtitle"><?php _e('Enter a paragraph of text to display with a larger font size above entry.','gabfire'); ?></label>
				<textarea class="gabfire_textinput" name="subtitle" id="subtitle"><?php echo $subtitle; ?></textarea>
			</p>
		</div>

		<div class="gabfire_fieldgroup">
			<p class="gabfire_fieldcaption"><?php _e('Video URL', 'gabfire'); ?></p>
			<p class="gabfire_fieldrow">
				<label for="iframe"><?php _e('You can add any Youtube, Vimeo, Dailymotion or Screenr video url into this box','gabfire'); ?></label>
				<input type="text" class="gabfire_textinput" name="iframe" id="iframe" value="<?php echo $video; ?>" />
			</p>
		</div>

		<div class="gabfire_fieldgroup">
			<p class="gabfire_fieldcaption"><?php _e('Post Layout?', 'gabfire'); ?></p>
			<p>
				<label for="gabfire_post_template"><?php _e('Select a Post layout</br><strong>Note:</strong> Select Big Picture only if you have uploaded more than 1 photo','gabfire'); ?></label>

				<select name="gabfire_post_template" id="gabfire_post_template">
					<?php
					$posttemplate = get_post_meta( get_the_ID(), 'gabfire_post_template', true );?>
					<option value="default" <?php selected( $selected, 'defaults' ); ?>><?php _e('Default Blog Post','gabfire'); ?></option>
					<option value="bigpicture" <?php selected( $selected, 'bigpicture' ); ?>><?php _e('Big Picture','gabfire'); ?></option>
					<option value="leftsidebar" <?php selected( $selected, 'leftsidebar' ); ?>><?php _e('Left Sidebar','gabfire'); ?></option>
					<option value="fullwidth" <?php selected( $selected, 'fullwidth' ); ?>><?php _e('No Sidebar','gabfire'); ?></option>

					<!-- CP: Added the Plugin Post Layout -->
					<option value="narrow" <?php selected( $selected, 'narrow' ); ?>><?php _e('Narrow Layout','gabfire'); ?></option>


				</select>
			</p>
		</div>

		<?php if ( ( get_current_post_type() == 'post' ) or  ( get_current_post_type() == 'page' ) ){ ?>

			<div class="gabfire_fieldgroup field_checkbox">
				<p class="gabfire_fieldcaption"><?php _e('Disable Featured Image on this post?', 'gabfire'); ?></p>
				<p class="gabfire_fieldrow">
					<label for="post_feaimage"><?php _e('If you have enabled featured post on single post page option, the featured image shows at top of every post automatically. You may check this box to disable that image for certain posts.','gabfire'); ?></label>
					<span class="gabfire_checkbox"><input type="checkbox" id="post_feaimage" name="post_feaimage" <?php checked( $disable_feaimage, 'true' ); ?> /></span>
				</p>
			</div>

			<div class="gabfire_fieldgroup field_checkbox">
				<p class="gabfire_fieldcaption"><?php _e('Disable innerpage slider for this post', 'gabfire'); ?></p>
				<p class="gabfire_fieldrow">
					<label for="disable_postslider"><?php _e('If you have enabled innerpage slider sitewide, but specifically want to disable it for this post, check this box.','gabfire'); ?></label>
					<span class="gabfire_checkbox"><input type="checkbox" id="disable_postslider" name="disable_postslider" <?php checked( $postslider, 'true' ); ?> /></span>
				</p>
			</div>


		<?php
		}
	}

	add_action( 'save_post', 'gabfire_meta_box_save' );
	function gabfire_meta_box_save( $post_id )
	{
		// Bail if we're doing an auto save
		if( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) return;

		// if our nonce isn't there, or we can't verify it, bail
		if( !isset( $_POST['meta_box_nonce'] ) || !wp_verify_nonce( $_POST['meta_box_nonce'], 'my_meta_box_nonce' ) ) return;

		// if our current user can't edit this post, bail
		if( !current_user_can( 'edit_post' ) ) return;

		// now we can actually save the data
		$allowed = array(
			'a' => array( // on allow a tags
				'href' => array() // and those anchords can only have href attribute
			)
		);

		if (( get_current_post_type() == 'post' ) or  ( get_current_post_type() == 'page' ) ){

			if( isset( $_POST['iframe'] ) && !empty( $_POST['iframe'] ) )
				update_post_meta( $post_id, 'iframe', wp_kses( $_POST['iframe'], $allowed ) );

			if( isset( $_POST['gabfire_post_template'] ) && !empty( $_POST['gabfire_post_template'] ) )
				update_post_meta( $post_id, 'gabfire_post_template', esc_attr( $_POST['gabfire_post_template'] ) );

			if( isset( $_POST['subtitle'] ) && !empty( $_POST['subtitle'] ) )
				update_post_meta( $post_id, 'subtitle', wp_kses( $_POST['subtitle'], $allowed ) );

			$chk3 = isset( $_POST['disable_postslider'] ) && $_POST['disable_postslider'] ? 'true' : 'false';
			update_post_meta( $post_id, 'disable_postslider', $chk3 );

			$chk2 = isset( $_POST['post_feaimage'] ) && $_POST['post_feaimage'] ? 'true' : 'false';
			update_post_meta( $post_id, 'post_feaimage', $chk2 );

			if( isset( $_POST['form_id'] ) && !empty( $_POST['form_id'] ) )
				update_post_meta( $post_id, 'form_id', wp_kses( $_POST['form_id'], $allowed ) );

		}
	}

	function gabfire_custom_fields_css() {
		wp_enqueue_style('gabfire-customfields-style', get_template_directory_uri() .'/framework/functions/css/custom-fields.css' );
	}
	add_action('admin_head-post.php', 'gabfire_custom_fields_css');
	add_action('admin_head-post-new.php', 'gabfire_custom_fields_css');


	/* Add a little more niceness and assign post template class to body tag */
	add_filter('body_class','gabfire_custom_body_classes');
	function gabfire_custom_body_classes( $classes ) {

		if ( get_post_meta( get_the_ID(), 'gabfire_post_template', true ) ) {

			$classes[] = 'body-' . get_post_meta( get_the_ID(), 'gabfire_post_template', true );

		}

		// return the $classes array
		return $classes;

	}
}

/* ********************
 * Theme comment style
 ******************************************************************** */
	if ( ! function_exists( 'gabfire_comment' ) ) {

		function gabfire_comment( $comment, $args, $depth ) {
			$GLOBALS['comment'] = $comment;
			switch ( $comment->comment_type ) :
				case '' :
			?>
			<li <?php comment_class(); ?> id="li-comment-<?php comment_ID(); ?>">

				<div class="comment-inner" id="comment-<?php comment_ID(); ?>">

					<div class="comment-top">
						<div class="comment-avatar">
							<?php echo get_avatar( $comment, 50 ); ?>
						</div>
						<span class="comment-author">
							<i class="fa fa-user"></i>
							<?php printf( __( '%s ', 'gabfire'), sprintf( '<cite class="fn">%s</cite>', get_comment_author_link() ) ); ?>
						</span>
						<span class="comment-date-link">
							<i class="fa fa-calendar"></i>&nbsp;&nbsp;<?php printf(esc_attr__('%1$s at %2$s','gabfire'), get_comment_date(), get_comment_time()); edit_comment_link( __( 'Edit', 'gabfire'), ' ' , ''); ?>
						</span>
					</div>

					<?php if ( $comment->comment_approved == '0' ) : ?>
						<p class="waiting_approval"><?php _e( 'Your comment is awaiting moderation.', 'gabfire' ); ?></p>
					<?php endif; ?>

					<?php comment_text(); ?>

					<?php comment_reply_link( array_merge( $args, array( 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) ); ?>

				</div><!-- comment-inner  -->

			<?php
					break;
				case 'pingback'  :
				case 'trackback' :
			?>
			<li class="post pingback">
				<p><?php _e( 'Pingback:', 'gabfire' ); ?> <?php comment_author_link(); ?><?php edit_comment_link( __( 'Edit', 'gabfire' ), ' ' ); ?></p>
			<?php
					break;
			endswitch;
		}
	}

/* ********************
 * Widgetize theme
 ******************************************************************** */
 if ( !function_exists( 'gabfire_register_sidebar' ) ) {

	function gabfire_register_sidebar($args) {
		$common = array(
			'before_widget' => '<div id="%1$s" class="widget %2$s"><div class="widgetinner">',
			'after_widget'  => "</div></div>\n",
			'before_title'  => '<h3 class="widgettitle">',
			'after_title'   => "</h3>\n"
		);
		$args = wp_parse_args($args, $common);
		return register_sidebar($args);
	}

	function gabfire_init_widgets() {
		gabfire_register_sidebar(array('name' => __('Sidebar-1', 'gabfire'),'id' => 'Sidebar-1','description' => __('Blog Posts Sidebar - Above Portfolio Widget', 'gabfire')));
		gabfire_register_sidebar(array('name' => __('Sidebar-2', 'gabfire'),'id' => 'Sidebar-2','description' => __('Blog Posts Sidebar - Below Portfolio Widget', 'gabfire')));
		gabfire_register_sidebar(array('name' => __('Sidebar-Portfolio', 'gabfire'),'id' => 'Sidebar-Portfolio','description' => __('Portfolio Posts Sidebar - Below Portfolio Widget', 'gabfire')));
		gabfire_register_sidebar(array('name' => __('Footer 1', 'gabfire'), 'id' => 'footer-1','description' => __('Footer 1st column', 'gabfire')));
		gabfire_register_sidebar(array('name' => __('Footer 2', 'gabfire'), 'id' => 'footer-2','description' => __('Footer 2nd column', 'gabfire')));
		gabfire_register_sidebar(array('name' => __('Footer 3', 'gabfire'), 'id' => 'footer-3','description' => __('Footer 3rd column', 'gabfire')));
		gabfire_register_sidebar(array('name' => __('PostWidget', 'gabfire'),'id' => 'PostWidget','description' => __('Single post page - below entry', 'gabfire')));
		gabfire_register_sidebar(array('name' => __('Services', 'gabfire'),'id' => 'services','description' => __('Services Sidebar', 'gabfire')));
	}

	add_action( 'widgets_init', 'gabfire_init_widgets' );
}

/**
 * Extract Youtube ID from URL
 * @param string $url
 * @return string Youtube video id or FALSE if none found.
 * http://stackoverflow.com/questions/6556559/youtube-api-extract-video-id
 */
function gabfire_youtube_id($url) {
    $pattern =
        '%^# Match any youtube URL
        (?:https?://)?  # Optional scheme. Either http or https
        (?:www\.)?      # Optional www subdomain
        (?:             # Group host alternatives
          youtu\.be/    # Either youtu.be,
        | youtube\.com  # or youtube.com
          (?:           # Group path alternatives
            /embed/     # Either /embed/
          | /v/         # or /v/
          | /watch\?v=  # or /watch\?v=
          )             # End path alternatives.
        )               # End host alternatives.
        ([\w-]{10,12})  # Allow 10-12 for 11 char youtube id.
        $%x'
        ;
    $result = preg_match($pattern, $url, $matches);
    if (false !== $result) {
        return $matches[1];
    }
    return false;
}
/**
 * Extract Vimeo ID from URL
 * @param string $url
 * http://blog.luutaa.com/php/extract-youtube-and-vimeo-video-id-from-link/
 */
function gabfire_vimeo_id($url) {
        $regexstr = '~
            # Match Vimeo link and embed code
            (?:<iframe [^>]*src=")?       # If iframe match up to first quote of src
            (?:                         # Group vimeo url
                https?:\/\/             # Either http or https
                (?:[\w]+\.)*            # Optional subdomains
                vimeo\.com              # Match vimeo.com
                (?:[\/\w]*\/videos?)?   # Optional video sub directory this handles groups links also
                \/                      # Slash before Id
                ([0-9]+)                # $1: VIDEO_ID is numeric
                [^\s]*                  # Not a space
            )                           # End group
            "?                          # Match end quote if part of src
            (?:[^>]*></iframe>)?        # Match the end of the iframe
            (?:<p>.*</p>)?              # Match any title information stuff
            ~ix';

        preg_match($regexstr, $url, $matches);
        return $matches[1];
}

/* ********************
 * Single Post Page
 * Header Image
 ******************************************************************** */
function gabfire_postheader() {
	$queried_object = get_queried_object();
	$featured_image = wp_get_attachment_url( get_post_thumbnail_id($queried_object->ID) );
	?>
	<section id="featured-image-holder" data-stellar-background-ratio="0.5" style="background-image:url(<?php echo $featured_image; ?>);">
		<div class="add-pattern">
			<div class="container pagewrap nmtop">
				<div class="row">


						<div class="title-wrapper">
							<h1 class="entry-title"><?php the_title(); ?></h1>
						</div>


				</div>
			</div>
		</div>
	</section>
<?php
}