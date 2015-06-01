<?php
/**
 * A unique identifier is defined to store the options in the database and reference them from the theme.
 * By default it uses the theme name, in lowercase and without spaces, but this can be changed if needed.
 * If the identifier changes, it'll appear as if the options have been reset.
 */

function optionsframework_option_name() {

	// This gets the theme name from the stylesheet
	$themename = wp_get_theme();
	$themename = $themename->{'Name'};
	$themename = preg_replace('/\W/', '_', strtolower($themename) );

	$optionsframework_settings = get_option( 'optionsframework' );
	$optionsframework_settings['id'] = $themename;
	update_option( 'optionsframework', $optionsframework_settings );
}

/**
 * Defines an array of options that will be used to generate the settings page and be saved in the database.
 * When creating the 'id' fields, make sure to use all lowercase and no spaces.
 * 
 */

function optionsframework_options() {

	// VARIABLES
	$themeurl = get_template_directory_uri();
	$themename = wp_get_theme();
	$themename = $themename->{'Name'};
	$shortname = 'of';
	$themeid = '_th';
	
	// Test data
	$test_array = array(
	'one' => 'One',
	'two' => 'Two',
	'three' =>'Three',
	'four' => 'Four',
	'five' => 'Five'
	);
	
	// Background options
	$patterns_path = get_template_directory_uri() . '/framework/images/patterns/';
	$patterns_array = array(
	'none' => $patterns_path . 'none.jpg',
	'subtle-1' => $patterns_path . 'subtle-1.jpg',
	'subtle-2' => $patterns_path . 'subtle-2.jpg',
	'subtle-3' => $patterns_path . 'subtle-3.jpg',
	'subtle-4' => $patterns_path . 'subtle-4.jpg',
	'subtle-5' => $patterns_path . 'subtle-5.jpg',
	'subtle-6' => $patterns_path . 'subtle-6.jpg',
	'subtle-7' => $patterns_path . 'subtle-7.jpg',
	'subtle-8' => $patterns_path . 'subtle-8.jpg',
	'subtle-9' => $patterns_path . 'subtle-9.jpg',
	'subtle-10' => $patterns_path . 'subtle-10.jpg',
	'subtle-11' => $patterns_path . 'subtle-11.jpg',
	'subtle-12' => $patterns_path . 'subtle-12.jpg',
	'subtle-13' => $patterns_path . 'subtle-13.jpg',
	'subtle-14' => $patterns_path . 'subtle-14.jpg',
	'subtle-15' => $patterns_path . 'subtle-15.jpg',
	'subtle-16' => $patterns_path . 'subtle-16.jpg',
	'subtle-17' => $patterns_path . 'subtle-17.jpg',
	);
	
	// Multicheck Array
	$multicheck_array = array(
	'one' => 'French Toast',
	'two' => 'Pancake',
	'three' =>'Omelette',
	'four' => 'Crepe',
	'five' => 'Waffle'
	);
	
	// Cycle2 Options
	$cycle2_slidefx = array(
		'fade' => 'Fade',
		'fadeout' => 'Fade-Out',
		'scrollHorz' => 'Scroll Horizontally',
		'none' => 'None'
	);

	// Multicheck Defaults
	$multicheck_defaults = array(
		'one' => '1',
		'five' => '1'
	);
	
	// Background Defaults
	$background_defaults = array(
		'color' => '',
		'image' => '',
		'repeat' => 'repeat',
		'position' => 'top center',
		'attachment'=>'scroll' );

	// Typography Defaults
	$typography_defaults = array(
		'size' => '15px',
		'face' => 'georgia',
		'style' => 'bold',
		'color' => '#bada55' );
		
	// Typography Options
	$typography_options = array(
		'sizes' => array( '6','12','14','16','20' ),
		'faces' => array( 'Helvetica Neue' => 'Helvetica Neue','Arial' => 'Arial' ),
		'styles' => array( 'normal' => 'Normal','bold' => 'Bold' ),
		'color' => false
	);
	
	// Pull all the categories into an array
	$options_categories = array();
	$options_categories_obj = get_categories();
	foreach ($options_categories_obj as $category) {
		$options_categories[$category->cat_ID] = $category->cat_name;
	}
	
	// Pull all tags into an array
	$options_tags = array();
	$options_tags_obj = get_tags();
	foreach ( $options_tags_obj as $tag ) {
		$options_tags[$tag->term_id] = $tag->name;
	}
	
	// Pull all the pages into an array
	$options_pages = array();
	$options_pages_obj = get_pages('sort_column=post_parent,menu_order');
	$options_pages[''] = 'Select a page:';
	foreach ($options_pages_obj as $page) {
		$options_pages[$page->ID] = $page->post_title;
	}

	// If using image radio buttons, define a directory path
	$imagepath = get_template_directory_uri() . '/framework/admin/images/';
	
	//Default Arrays 
	$options_nr = array(0,1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20);
	$options_inslider = array(__('Disable', 'gabfire'), __('Tag-based', 'gabfire'), __('Site Wide', 'gabfire'));
	$options_sort = array('ASC' => 'asc', 'desc' => 'desc');
	$options_order = array('id' => 'id', 'name' => 'name', 'count' => 'count');
	$options_logo = array('text' => __('Text Based Logo', 'gabfire'), 'image' => __('Image Based Logo', 'gabfire'));
	$options_feaslide = array('scrollUp', 'scrollDown', 'scrollLeft', 'scrollRight', 'turnUp', 'turnDown', 'turnLeft', 'turnRight', 'fade');


	$options = array();
		
	$options[] = array( 'name' => __('General Settings', 'gabfire'), 'type' => 'heading');

		$options[] = array( 'name' => __('Logo Type', 'gabfire'),
							'desc' => __('If text-based logo is selected, set sitename and tagline on WordPress settings page.', 'gabfire'),
							'id' => $shortname.'_logo_type',
							'std' => 'Text Based Logo',
							'type' => 'select',
							'options' => $options_logo);
							
		$options[] = array( 'name' => __('Custom Logo', 'gabfire'),
							'desc' => __('If image-based logo is selected, upload a logo for your theme, or specify the image address of your online logo. (http://yoursite.com/logo.png) [Max height: 50px]', 'gabfire'),
							'id' => $shortname.'_logo',
							'type' => 'upload');
							
		$options[] = array( 'name' => __('Text Logo', 'gabfire'),
							'desc' => __('If text-based logo is selected, enter text to display on first row.', 'gabfire'),
							'id' => $shortname.'_logo1',
							'type' => 'text');
							
		$options[] = array( 'desc' => __('Text Logo Color', 'gabfire'),
							'id' => $shortname.'_logocolor1',
							'std' => '#eeeeee',
							'type' => 'color');								
							
		$options[] = array( 'desc' => __('Text Logo Hover Color', 'gabfire'),
							'id' => $shortname.'_logocolor2',
							'std' => '#ffffff',
							'type' => 'color');							
							
		$options[] = array( 'name' => __('Logo Padding Top', 'gabfire'),
							'desc' => __('Set a padding value between logo and top line.', 'gabfire'),
							'id' => $shortname.'_padding_top',
							'std' => 8,
							'class' => 'mini',
							'type' => 'text');
							
		$options[] = array( 'name' => __('Logo Padding Bottom', 'gabfire'),
							'desc' => __('Set a padding value between logo and bottom line.', 'gabfire'),
							'id' => $shortname.'_padding_bottom',
							'std' => 9,
							'type' => 'text');							
							
		$options[] = array( 'name' => __('Logo Padding Left', 'gabfire'),
							'desc' => __('Set a padding value between logo and left line.', 'gabfire'),
							'id' => $shortname.'_padding_left',
							'std' => 9,
							'type' => 'text');
							
		$options[] = array( 'name' => __('Custom Favicon', 'gabfire'),
							'desc' => __('Upload a 16px x 16px Png/Gif image that will represent your website\'s favicon.', 'gabfire'),
							'id' => $shortname.'_custom_favicon',
							'type' => 'upload');
							
		$options[] = array( 'name' => __('RSS', 'gabfire'),
							'desc' => __('Link to third party feed handler. <br/> [http://www.url.com]', 'gabfire'),
							'id' => $shortname.'_rssaddr',
							'type' => 'text');
		
		$options[] = array( 'name' => __('Tracking Code', 'gabfire'),
							'desc' => __('Paste your Google Analytics (or other) tracking code here. This will be added into the footer template of your theme.', 'gabfire'),
							'id' => $shortname.'_google_analytics',
							'type' => 'textarea');
							
	$options[] = array( 'name' => __('Intro', 'gabfire'), 'type' => 'heading');
	
		$options[] = array( 'name' => __('Intro Type', 'gabfire'),
							'desc' => __('Select and Intro type and Save Changes. Additional configuration options will appear below based on intro selection', 'gabfire'),
							'id' => $shortname.'_introtype',
							'std' => 'Z Creative',
							'type' => 'select',
							'options' => array(
								'static' => __('Single Image', 'gabfire'),
								'youtube' => __('Youtube', 'gabfire'),
								'vimeo' => __('Vimeo', 'gabfire'),
								'callout' => __('Callout', 'gabfire'),
								'bgslider' => __('Background Slider', 'gabfire')
							));
	
			$options[] = array( 'name' => __('Intro Message', 'gabfire'),
								'desc' => __('Welcome Message - First Line', 'gabfire'),
								'id' => $shortname.'_intro_firstline',
								'std' => 'Z Creative',
								'type' => 'text');
								
			$options[] = array( 'desc' => __('Welcome Message - Second Line (wrap text with &lt;strong&gt;&lt;/strong&gt; to color it)', 'gabfire'),
								'id' => $shortname.'_intro_secondline',
								'std' => 'TURNING IDEAS INTO <strong>REALITY</strong>',
								'type' => 'textarea');
								
			if (of_get_option('of_introtype') == 'bgslider') { 
			
				$options[] = array( 'name' => __('Image Slider as Background', 'gabfire'),
									'desc' => __('Select number of images to upload', 'gabfire'),
									'id' => $shortname.'_bgslidernr',
									'std' => 5,
									'type' => 'select',
									'options' => array(
										'1' => __('One', 'gabfire'),
										'2' => __('Two', 'gabfire'),
										'3' => __('Three', 'gabfire'),
										'4' => __('Four', 'gabfire'),
										'5' => __('Five', 'gabfire')
									));	
			}
								
			$options[] = array(	'desc' => __('Upload a custom background image', 'gabfire'),
								'id' => $shortname.'_introbg1',
								'std' => $themeurl . '/images/defaults/01.jpg',
								'type' => 'upload');

			if (of_get_option('of_introtype') == 'static') { 
				$options[] = array( 'desc' => __('Define a scroll speed ratio (parallax effect) to scroll background and elements with a different speed', 'gabfire'),
									'id' => $shortname.'_parallax1',
									'std' => '0.3',
									'class' => 'mini',
									'type' => 'text');
			}					
			if (of_get_option('of_introtype') == 'youtube') { 
				$options[] = array( 'name' => __('Youtube Video', 'gabfire'),
									'desc' => __('Enter Youtube Video below to display on top of background image - (N.B - Video will not be displayed on tablet and mobile devices)', 'gabfire'),
									'id' => $shortname.'_youtubevideo',
									'std' => '',
									'type' => 'text');
			}

			if (of_get_option('of_introtype') == 'vimeo') { 
				$options[] = array( 'name' => __('Vimeo Video', 'gabfire'),
									'desc' => __('If you want to stream a video from Vimeo instead of youtube, Enter a vimeo.com video link below', 'gabfire'),
									'id' => $shortname.'_vimeovideo',
									'std' => '',
									'type' => 'text');
			}
		
		if (of_get_option('of_introtype') == 'bgslider') { 
				
			$options[] = array(	'desc' => __('Upload a custom background image', 'gabfire'),
								'id' => $shortname.'_introbg2',
								'type' => 'upload');	

			$options[] = array(	'desc' => __('Upload a custom background image', 'gabfire'),
								'id' => $shortname.'_introbg3',
								'type' => 'upload');	

			$options[] = array(	'desc' => __('Upload a custom background image', 'gabfire'),
								'id' => $shortname.'_introbg4',
								'type' => 'upload');	

			$options[] = array('desc' => __('Upload a custom background image', 'gabfire'),
								'id' => $shortname.'_introbg5',
								'type' => 'upload');									
		}		

		$options[] = array( 'name' => __('About Us', 'gabfire'), 'type' => 'heading');

			$options[] = array(	'name' => __('About Us - Enable / Disable', 'gabfire'),
								'desc' => __('Disable About Section', 'gabfire'),
								'id' => $shortname.'_about',
								'std' => 0,
								'type' => 'checkbox');
								
			$options[] = array(	'desc' => __('Upload a custom background image', 'gabfire'),
								'id' => $shortname.'_aboutimg',
								'std' => $themeurl . '/images/defaults/aboutus.png',
								'type' => 'upload');
								
			$options[] = array( 'name' => __('Section Titles', 'gabfire'),
								'desc' => __('First Title Line (wrap text with &lt;strong&gt;&lt;/strong&gt; to color it)', 'gabfire'),
								'id' => $shortname.'_about_firstline',
								'std' => 'Play & Love - We Bring <strong>Good Things</strong> to Life',
								'type' => 'textarea');
								
			$options[] = array( 'desc' => __('Second Title Line (wrap text with &lt;strong&gt;&lt;/strong&gt; to color it)', 'gabfire'),
								'id' => $shortname.'_about_secondline',
								'std' => 'Lets Market Your Idea and Create a Brand Around It',
								'type' => 'textarea');
								
			$options[] = array( 'name' => __('Paragraph Below Section Titles', 'gabfire'),
								'desc' => __('Paragraph Title', 'gabfire'),
								'id' => $shortname.'_about_thirdline',
								'std' => 'Innovation and Excellence',
								'type' => 'text');

			$options[] = array( 'desc' => __('Paragraph Text', 'gabfire'),
								'id' => $shortname.'_about_paragraph',
								'std' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Mauris quis fermentum nulla. Nam nec vehicula purus. Proin libero neque, sagittis non nulla eu, malesuada blandit neque. Suspendisse ultrices urna elit, sit amet pretium lectus tempus ut. ',
								'type' => 'textarea');

			$options[] = array( 'desc' => __('Button Text (leave this field empty to disable button)', 'gabfire'),
								'id' => $shortname.'_about_btntext',
								'std' => 'Introduction Video',
								'class' => 'mini',
								'type' => 'text');

			$options[] = array( 'desc' => __('Button Link', 'gabfire'),
								'id' => $shortname.'_about_btnlink',
								'std' => 'http://vimeo.com/23237102',
								'type' => 'text');
								
			$options[] = array(	'desc' => __('Check this box if the button links to a youtube/vimeo/dailymotion video', 'gabfire'),
								'id' => $shortname.'_its_a_video',
								'std' => 1,
								'type' => 'checkbox');
								
		$options[] = array( 'name' => __('Services', 'gabfire'), 'type' => 'heading');
		
			$options[] = array(	'name' => __('Services - Enable / Disable', 'gabfire'),
								'desc' => __('Disable Service Section', 'gabfire'),
								'id' => $shortname.'_services',
								'std' => 0,
								'type' => 'checkbox');
								
			$options[] = array(	'name' => __('Service Items', 'gabfire'),
								'desc' => __('Number of Service Items to Show (MAX: 12)', 'gabfire'),
								'id' => $shortname.'_services_count',
								'std' => 12,
								'type' => 'select',
								"options" => $options_nr);
		
			$options[] = array( 'name' => __('Service #1', 'gabfire'),
								'desc' => __('Service Title', 'gabfire'),
								'id' => $shortname.'_servicetitle_1',
								'std' => 'Identity Design',
								'type' => 'text');

			$options[] = array( 'desc' => __('Service Text', 'gabfire'),
								'id' => $shortname.'_servicetext_1',
								'std' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nulla consectetur diam dolor, ac dapibus',
								'type' => 'textarea');
								
			$options[] = array( 'desc' => __('Service Icon - Select an icon name at http://fortawesome.github.io/Font-Awesome/icons/', 'gabfire'),
								'id' => $shortname.'_serviceicon_1',
								'std' => 'fa-paper-plane',
								'type' => 'text');

			$options[] = array(	'desc' => __('Change Color', 'gabfire'),
								'id' => $shortname.'_changecolor1',
								'std' => 0,
								'type' => 'checkbox');								
								
			$options[] = array( 'desc' => __('Select a color', 'gabfire'),
								'id' => $shortname.'_color1',
								'std' => '#42bdc2',
								'type' => 'color');
								
			$options[] = array( 'name' => __('Service #2', 'gabfire'),
								'desc' => __('Service Title', 'gabfire'),
								'id' => $shortname.'_servicetitle_2',
								'std' => 'App Development',
								'type' => 'text');

			$options[] = array( 'desc' => __('Service Text', 'gabfire'),
								'id' => $shortname.'_servicetext_2',
								'std' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nulla consectetur diam dolor, ac dapibus',
								'type' => 'textarea');
								
			$options[] = array( 'desc' => __('Service Icon - Select an icon name at http://fortawesome.github.io/Font-Awesome/icons/', 'gabfire'),
								'id' => $shortname.'_serviceicon_2',
								'std' => 'fa-cloud',
								'type' => 'text');

			$options[] = array(	'desc' => __('Change Color', 'gabfire'),
								'id' => $shortname.'_changecolor2',
								'std' => 0,
								'type' => 'checkbox');								
								
			$options[] = array( 'desc' => __('Select a color', 'gabfire'),
								'id' => $shortname.'_color2',
								'std' => '#ff8a3c',
								'type' => 'color');

			$options[] = array( 'name' => __('Service #3', 'gabfire'),
								'desc' => __('Service Title', 'gabfire'),
								'id' => $shortname.'_servicetitle_3',
								'std' => 'Network Design',
								'type' => 'text');

			$options[] = array( 'desc' => __('Service Text', 'gabfire'),
								'id' => $shortname.'_servicetext_3',
								'std' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nulla consectetur diam dolor, ac dapibus',
								'type' => 'textarea');
								
			$options[] = array( 'desc' => __('Service Icon - Select an icon name at http://fortawesome.github.io/Font-Awesome/icons/', 'gabfire'),
								'id' => $shortname.'_serviceicon_3',
								'std' => 'fa-cubes',
								'type' => 'text');									

			$options[] = array(	'desc' => __('Change Color', 'gabfire'),
								'id' => $shortname.'_changecolor3',
								'std' => 0,
								'type' => 'checkbox');								
								
			$options[] = array( 'desc' => __('Select a color', 'gabfire'),
								'id' => $shortname.'_color3',
								'std' => '#7fc242',
								'type' => 'color');
								
			$options[] = array( 'name' => __('Service #4', 'gabfire'),
								'desc' => __('Service Title', 'gabfire'),
								'id' => $shortname.'_servicetitle_4',
								'std' => 'WordPress',
								'type' => 'text');

			$options[] = array( 'desc' => __('Service Text', 'gabfire'),
								'id' => $shortname.'_servicetext_4',
								'std' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nulla consectetur diam dolor, ac dapibus',
								'type' => 'textarea');

			$options[] = array( 'desc' => __('Service Icon - Select an icon name at http://fortawesome.github.io/Font-Awesome/icons/', 'gabfire'),
								'id' => $shortname.'_serviceicon_4',
								'std' => 'fa-wordpress',
								'type' => 'text');
								
			$options[] = array(	'desc' => __('Change Color', 'gabfire'),
								'id' => $shortname.'_changecolor4',
								'std' => 0,
								'type' => 'checkbox');								
								
			$options[] = array( 'desc' => __('Select a color', 'gabfire'),
								'id' => $shortname.'_color4',
								'std' => '#edc900',
								'type' => 'color');
								
			$options[] = array( 'name' => __('Service #5', 'gabfire'),
								'desc' => __('Service Title', 'gabfire'),
								'id' => $shortname.'_servicetitle_5',
								'std' => 'Marketing',
								'type' => 'text');

			$options[] = array( 'desc' => __('Service Text', 'gabfire'),
								'id' => $shortname.'_servicetext_5',
								'std' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nulla consectetur diam dolor, ac dapibus',
								'type' => 'textarea');				

			$options[] = array( 'desc' => __('Service Icon - Select an icon name at http://fortawesome.github.io/Font-Awesome/icons/', 'gabfire'),
								'id' => $shortname.'_serviceicon_5',
								'std' => 'fa-bullhorn',
								'type' => 'text');	
								
			$options[] = array(	'desc' => __('Change Color', 'gabfire'),
								'id' => $shortname.'_changecolor5',
								'std' => 0,
								'type' => 'checkbox');								
								
			$options[] = array( 'desc' => __('Select a color', 'gabfire'),
								'id' => $shortname.'_color5',
								'std' => '#388bd1',
								'type' => 'color');
								
			$options[] = array( 'name' => __('Service #6', 'gabfire'),
								'desc' => __('Service Title', 'gabfire'),
								'id' => $shortname.'_servicetitle_6',
								'std' => 'Public Relations',
								'type' => 'text');

			$options[] = array( 'desc' => __('Service Text', 'gabfire'),
								'id' => $shortname.'_servicetext_6',
								'std' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nulla consectetur diam dolor, ac dapibus',
								'type' => 'textarea');

			$options[] = array( 'desc' => __('Service Icon - Select an icon name at http://fortawesome.github.io/Font-Awesome/icons/', 'gabfire'),
								'id' => $shortname.'_serviceicon_6',
								'std' => 'fa-heart',
								'type' => 'text');
								
			$options[] = array(	'desc' => __('Change Color', 'gabfire'),
								'id' => $shortname.'_changecolor6',
								'std' => 0,
								'type' => 'checkbox');								
								
			$options[] = array( 'desc' => __('Select a color', 'gabfire'),
								'id' => $shortname.'_color6',
								'std' => '#e44554',
								'type' => 'color');
								
			$options[] = array( 'name' => __('Service #7', 'gabfire'),
								'desc' => __('Service Title', 'gabfire'),
								'id' => $shortname.'_servicetitle_7',
								'std' => 'Social Interactions',
								'type' => 'text');

			$options[] = array( 'desc' => __('Service Text', 'gabfire'),
								'id' => $shortname.'_servicetext_7',
								'std' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nulla consectetur diam dolor, ac dapibus',
								'type' => 'textarea');		

			$options[] = array( 'desc' => __('Service Icon - Select an icon name at http://fortawesome.github.io/Font-Awesome/icons/', 'gabfire'),
								'id' => $shortname.'_serviceicon_7',
								'std' => 'fa-thumbs-up',
								'type' => 'text');	

			$options[] = array(	'desc' => __('Change Color', 'gabfire'),
								'id' => $shortname.'_changecolor7',
								'std' => 0,
								'type' => 'checkbox');								
								
			$options[] = array( 'desc' => __('Select a color', 'gabfire'),
								'id' => $shortname.'_color7',
								'std' => '#cc6699',
								'type' => 'color');
								
			$options[] = array( 'name' => __('Service #8', 'gabfire'),
								'desc' => __('Service Title', 'gabfire'),
								'id' => $shortname.'_servicetitle_8',
								'std' => 'Media Relations',
								'type' => 'text');

			$options[] = array( 'desc' => __('Service Text', 'gabfire'),
								'id' => $shortname.'_servicetext_8',
								'std' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nulla consectetur diam dolor, ac dapibus',
								'type' => 'textarea');		

			$options[] = array( 'desc' => __('Service Icon - Select an icon name at http://fortawesome.github.io/Font-Awesome/icons/', 'gabfire'),
								'id' => $shortname.'_serviceicon_8',
								'std' => 'fa-newspaper-o',
								'type' => 'text');	

			$options[] = array(	'desc' => __('Change Color', 'gabfire'),
								'id' => $shortname.'_changecolor8',
								'std' => 0,
								'type' => 'checkbox');								
								
			$options[] = array( 'desc' => __('Select a color', 'gabfire'),
								'id' => $shortname.'_color8',
								'std' => '#f48d3e',
								'type' => 'color');
								
			$options[] = array( 'name' => __('Service #9', 'gabfire'),
								'desc' => __('Service Title', 'gabfire'),
								'id' => $shortname.'_servicetitle_9',
								'std' => 'Managed Services',
								'type' => 'text');

			$options[] = array( 'desc' => __('Service Text', 'gabfire'),
								'id' => $shortname.'_servicetext_9',
								'std' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nulla consectetur diam dolor, ac dapibus',
								'type' => 'textarea');		

			$options[] = array( 'desc' => __('Service Icon - Select an icon name at http://fortawesome.github.io/Font-Awesome/icons/', 'gabfire'),
								'id' => $shortname.'_serviceicon_9',
								'std' => 'fa-umbrella',
								'type' => 'text');	

			$options[] = array(	'desc' => __('Change Color', 'gabfire'),
								'id' => $shortname.'_changecolor9',
								'std' => 0,
								'type' => 'checkbox');								
								
			$options[] = array( 'desc' => __('Select a color', 'gabfire'),
								'id' => $shortname.'_color9',
								'std' => '#b5cc7a',
								'type' => 'color');
								
			$options[] = array( 'name' => __('Service #10', 'gabfire'),
								'desc' => __('Service Title', 'gabfire'),
								'id' => $shortname.'_servicetitle_10',
								'std' => 'eCommerce',
								'type' => 'text');

			$options[] = array( 'desc' => __('Service Text', 'gabfire'),
								'id' => $shortname.'_servicetext_10',
								'std' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nulla consectetur diam dolor, ac dapibus',
								'type' => 'textarea');		

			$options[] = array( 'desc' => __('Service Icon - Select an icon name at http://fortawesome.github.io/Font-Awesome/icons/', 'gabfire'),
								'id' => $shortname.'_serviceicon_10',
								'std' => 'fa-shopping-cart',
								'type' => 'text');	

			$options[] = array(	'desc' => __('Change Color', 'gabfire'),
								'id' => $shortname.'_changecolor10',
								'std' => 0,
								'type' => 'checkbox');								
								
			$options[] = array( 'desc' => __('Select a color', 'gabfire'),
								'id' => $shortname.'_color10',
								'std' => '#7ecac1',
								'type' => 'color');
								
			$options[] = array( 'name' => __('Service #11', 'gabfire'),
								'desc' => __('Service Title', 'gabfire'),
								'id' => $shortname.'_servicetitle_11',
								'std' => 'UI Design',
								'type' => 'text');

			$options[] = array( 'desc' => __('Service Text', 'gabfire'),
								'id' => $shortname.'_servicetext_11',
								'std' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nulla consectetur diam dolor, ac dapibus',
								'type' => 'textarea');		

			$options[] = array( 'desc' => __('Service Icon - Select an icon name at http://fortawesome.github.io/Font-Awesome/icons/', 'gabfire'),
								'id' => $shortname.'_serviceicon_11',
								'std' => 'fa-desktop',
								'type' => 'text');	

			$options[] = array(	'desc' => __('Change Color', 'gabfire'),
								'id' => $shortname.'_changecolor11',
								'std' => 0,
								'type' => 'checkbox');								
								
			$options[] = array( 'desc' => __('Select a color', 'gabfire'),
								'id' => $shortname.'_color11',
								'std' => '#f17293',
								'type' => 'color');
								
			$options[] = array( 'name' => __('Service #12', 'gabfire'),
								'desc' => __('Service Title', 'gabfire'),
								'id' => $shortname.'_servicetitle_12',
								'std' => 'Copywriting',
								'type' => 'text');

			$options[] = array( 'desc' => __('Service Text', 'gabfire'),
								'id' => $shortname.'_servicetext_12',
								'std' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nulla consectetur diam dolor, ac dapibus',
								'type' => 'textarea');		

			$options[] = array( 'desc' => __('Service Icon - Select an icon name at http://fortawesome.github.io/Font-Awesome/icons/', 'gabfire'),
								'id' => $shortname.'_serviceicon_12',
								'std' => 'fa-edit',
								'type' => 'text');

			$options[] = array(	'desc' => __('Change Color', 'gabfire'),
								'id' => $shortname.'_changecolor12',
								'std' => 0,
								'type' => 'checkbox');								
								
			$options[] = array( 'desc' => __('Select a color', 'gabfire'),
								'id' => $shortname.'_color12',
								'std' => '#daa520',
								'type' => 'color');		

		$options[] = array( 'name' => __('Skills', 'gabfire'), 'type' => 'heading');
		
			$options[] = array(	'name' => __('Skills - Enable / Disable', 'gabfire'),
								'desc' => __('Disable Service Section', 'gabfire'),
								'id' => $shortname.'_skills',
								'std' => 0,
								'type' => 'checkbox');
								
			$options[] = array( 'name' => __('Section Titles', 'gabfire'),
								'desc' => __('First Title Line (wrap text with &lt;strong&gt;&lt;/strong&gt; to color it)', 'gabfire'),
								'id' => $shortname.'_skill_firstline',
								'std' => 'Our Skills',
								'type' => 'textarea');
								
			$options[] = array( 'desc' => __('Second Title Line (wrap text with &lt;strong&gt;&lt;/strong&gt; to color it)', 'gabfire'),
								'id' => $shortname.'_skill_secondline',
								'std' => 'Lorem ipsum dolor sit amet. Aenean <strong>aliquam commodo</strong> imperdiet porttitor eu diam eu.',
								'type' => 'textarea');

			$options[] = array(	'name' => __('Skill Bars', 'gabfire'),
								'desc' => __('Number of Skill Bars to Display (MAX: 6)', 'gabfire'),
								'id' => $shortname.'_skills_count',
								'std' => 4,
								'type' => 'select',
								"options" => $options_nr);								
								
			$options[] = array( 'name' => __('Skill #1', 'gabfire'),
								'desc' => __('Enter a Skill Name', 'gabfire'),
								'id' => $shortname.'_skill_title_1',
								'std' => 'WordPress',
								'type' => 'text');
								
			$options[] = array( 'desc' => __('Skill Percentage', 'gabfire'),
								'id' => $shortname.'_skill_percent_1',
								'class' => 'mini',
								'std' => '90%',
								'type' => 'text');

			$options[] = array(	'desc' => __('Change Color', 'gabfire'),
								'id' => $shortname.'_skillcolor_1',
								'std' => 0,
								'type' => 'checkbox');								
								
			$options[] = array( 'desc' => __('Title Background Color', 'gabfire'),
								'id' => $shortname.'_skilltitlecolor_1',
								'std' => '#d35400',
								'type' => 'color');	

			$options[] = array( 'desc' => __('Progress Bar Color', 'gabfire'),
								'id' => $shortname.'_skillbarcolor_1',
								'std' => '#e67e22',
								'type' => 'color');	

			$options[] = array( 'name' => __('Skill #2', 'gabfire'),
								'desc' => __('Enter a Skill Name', 'gabfire'),
								'id' => $shortname.'_skill_title_2',
								'std' => 'Marketing',
								'type' => 'text');
								
			$options[] = array( 'desc' => __('Skill Percentage', 'gabfire'),
								'id' => $shortname.'_skill_percent_2',
								'class' => 'mini',
								'std' => '80%',
								'type' => 'text');

			$options[] = array(	'desc' => __('Change Color', 'gabfire'),
								'id' => $shortname.'_skillcolor_2',
								'std' => 0,
								'type' => 'checkbox');								
								
			$options[] = array( 'desc' => __('Title Background Color', 'gabfire'),
								'id' => $shortname.'_skilltitlecolor_2',
								'std' => '#2980b9',
								'type' => 'color');	

			$options[] = array( 'desc' => __('Progress Bar Color', 'gabfire'),
								'id' => $shortname.'_skillbarcolor_2',
								'std' => '#3498db',
								'type' => 'color');		

			$options[] = array( 'name' => __('Skill #3', 'gabfire'),
								'desc' => __('Enter a Skill Name', 'gabfire'),
								'id' => $shortname.'_skill_title_3',
								'std' => 'PHP',
								'type' => 'text');
								
			$options[] = array( 'desc' => __('Skill Percentage', 'gabfire'),
								'id' => $shortname.'_skill_percent_3',
								'class' => 'mini',
								'std' => '85%',
								'type' => 'text');

			$options[] = array(	'desc' => __('Change Color', 'gabfire'),
								'id' => $shortname.'_skillcolor_3',
								'std' => 0,
								'type' => 'checkbox');								
								
			$options[] = array( 'desc' => __('Title Background Color', 'gabfire'),
								'id' => $shortname.'_skilltitlecolor_3',
								'std' => '#2c3e50',
								'type' => 'color');	

			$options[] = array( 'desc' => __('Progress Bar Color', 'gabfire'),
								'id' => $shortname.'_skillbarcolor_3',
								'std' => '#3c556e',
								'type' => 'color');	

			$options[] = array( 'name' => __('Skill #4', 'gabfire'),
								'desc' => __('Enter a Skill Name', 'gabfire'),
								'id' => $shortname.'_skill_title_4',
								'std' => 'CSS3',
								'type' => 'text');
								
			$options[] = array( 'desc' => __('Skill Percentage', 'gabfire'),
								'id' => $shortname.'_skill_percent_4',
								'class' => 'mini',
								'std' => '95%',
								'type' => 'text');

			$options[] = array(	'desc' => __('Change Color', 'gabfire'),
								'id' => $shortname.'_skillcolor_4',
								'std' => 0,
								'type' => 'checkbox');								
								
			$options[] = array( 'desc' => __('Title Background Color', 'gabfire'),
								'id' => $shortname.'_skilltitlecolor_4',
								'std' => '#46465e',
								'type' => 'color');	

			$options[] = array( 'desc' => __('Progress Bar Color', 'gabfire'),
								'id' => $shortname.'_skillbarcolor_4',
								'std' => '#5a68a5',
								'type' => 'color');		

			$options[] = array( 'name' => __('Skill #5', 'gabfire'),
								'desc' => __('Enter a Skill Name', 'gabfire'),
								'id' => $shortname.'_skill_title_5',
								'std' => 'HTML5',
								'type' => 'text');
								
			$options[] = array( 'desc' => __('Skill Percentage', 'gabfire'),
								'id' => $shortname.'_skill_percent_5',
								'class' => 'mini',
								'std' => '90%',
								'type' => 'text');

			$options[] = array(	'desc' => __('Change Color', 'gabfire'),
								'id' => $shortname.'_skillcolor_5',
								'std' => 0,
								'type' => 'checkbox');								
								
			$options[] = array( 'desc' => __('Title Background Color', 'gabfire'),
								'id' => $shortname.'_skilltitlecolor_5',
								'std' => '#a3c980',
								'type' => 'color');	

			$options[] = array( 'desc' => __('Progress Bar Color', 'gabfire'),
								'id' => $shortname.'_skillbarcolor_5',
								'std' => '#b6e08f',
								'type' => 'color');	
								
			$options[] = array( 'name' => __('Skill #6', 'gabfire'),
								'desc' => __('Enter a Skill Name', 'gabfire'),
								'id' => $shortname.'_skill_title_6',
								'std' => 'Rubby',
								'type' => 'text');
								
			$options[] = array( 'desc' => __('Skill Percentage', 'gabfire'),
								'id' => $shortname.'_skill_percent_6',
								'class' => 'mini',
								'std' => '90%',
								'type' => 'text');

			$options[] = array(	'desc' => __('Change Color', 'gabfire'),
								'id' => $shortname.'_skillcolor_6',
								'std' => 0,
								'type' => 'checkbox');								
								
			$options[] = array( 'desc' => __('Title Background Color', 'gabfire'),
								'id' => $shortname.'_skilltitlecolor_6',
								'std' => '#c9606d',
								'type' => 'color');	

			$options[] = array( 'desc' => __('Progress Bar Color', 'gabfire'),
								'id' => $shortname.'_skillbarcolor_6',
								'std' => '#e06b79',
								'type' => 'color');	
								
		$options[] = array( 'name' => __('Plain Text', 'gabfire'), 'type' => 'heading');
		
			$options[] = array(	'name' => __('Plain Text - Enable / Disable', 'gabfire'),
								'desc' => __('Disable Plain Text Section', 'gabfire'),
								'id' => $shortname.'_plntext',
								'std' => 0,
								'type' => 'checkbox');
									
			$options[] = array(	'desc' => __('Upload a custom background image', 'gabfire'),
								'id' => $shortname.'_plntextbg',
								'std' => $themeurl . '/images/defaults/capri.jpg',
								'type' => 'upload');								
		
			$options[] = array( 'name' => __('Large Text', 'gabfire'),
								'desc' => __('Large text (use &lt;br /&gt; to break the sentence to second line)', 'gabfire'),
								'id' => $shortname.'_largetext',
								'std' => 'We Create Customer Ecosystem Using Brand <br/>Experience with a Value',
								'type' => 'textarea');		
								
			$options[] = array( 'name' => __('Small Text', 'gabfire'),
								'desc' => __('Small Text', 'gabfire'),
								'id' => $shortname.'_smalltext',
								'std' => 'Want to learn more?',
								'type' => 'textarea');
								
			$options[] = array( 'desc' => __('Button Text (leave this field empty to disable button)', 'gabfire'),
								'id' => $shortname.'_text_btntext',
								'std' => 'Introduction Video',
								'class' => 'mini',
								'type' => 'text');

			$options[] = array( 'desc' => __('Button Link', 'gabfire'),
								'id' => $shortname.'_text_btnlink',
								'std' => 'http://vimeo.com/23237102',
								'type' => 'text');
								
			$options[] = array(	'desc' => __('Check this box if the button links to a youtube/vimeo/dailymotion vimeo', 'gabfire'),
								'id' => $shortname.'_its_also_video',
								'std' => 1,
								'type' => 'checkbox');
								
			$options[] = array( 'name' => __('Pricing Table', 'gabfire'), 'type' => 'heading');
			
				$options[] = array(	'name' => __('Pricing Table - Enable / Disable', 'gabfire'),
									'desc' => __('Disable Service Section', 'gabfire'),
									'id' => $shortname.'_pricing',
									'std' => 0,
									'type' => 'checkbox');				
									
				$options[] = array( 'name' => __('Section Titles', 'gabfire'),
									'desc' => __('First Title Line (wrap text with &lt;strong&gt;&lt;/strong&gt; to color it)', 'gabfire'),
									'id' => $shortname.'_pricing_firstline',
									'std' => 'Pricing',
									'type' => 'textarea');
									
				$options[] = array( 'desc' => __('Second Title Line (wrap text with &lt;strong&gt;&lt;/strong&gt; to color it)', 'gabfire'),
									'id' => $shortname.'_pricing_secondline',
									'std' => 'Lorem ipsum dolor sit amet. Aenean aliquam <strong>commodo</strong> eu diam eu.',
									'type' => 'textarea');

				$options[] = array(	'name' => __('Popular Pack', 'gabfire'),
									'desc' => __('Select the Column to be Highlighted as Popular', 'gabfire'),
									'id' => $shortname.'_pricing_popular',
									'std' => 3,
									'type' => 'select',
									"options" => array(0,1,2,3,4));
									
				$options[] = array( 'name' => __('Pricing 1st Column', 'gabfire'),
									'desc' => __('Enter a Name for the Package', 'gabfire'),
									'id' => $shortname.'_pricing_name_1',
									'std' => 'Basic',
									'class' => 'mini',
									'type' => 'text');
									
				$options[] = array( 'desc' => __('Enter a Price for the Package', 'gabfire'),
									'id' => $shortname.'_pricing_price_1',
									'std' => '$8',
									'class' => 'mini',
									'type' => 'text');
									
				$options[] = array( 'desc' => __('Signup Button Text (Leave empty to disable button)', 'gabfire'),
									'id' => $shortname.'_pricing_btn_1',
									'std' => 'Signup',
									'class' => 'mini',
									'type' => 'text');		

				$options[] = array( 'desc' => __('Enter a Link to Redirect When Signup Button is Clicked', 'gabfire'),
									'id' => $shortname.'_pricing_btnlink_1',
									'std' => '#',
									'type' => 'text');										
									
				$options[] = array( 'desc' => __('Features. Wrap each featured between &lt;li&gt; ... &lt;/li&gt; - To bold a text, use &lt;strong&gt;&lt;/strong&gt;', 'gabfire'),
									'id' => $shortname.'_features_1',
									'std' => '<li><strong>1GB</strong> Disk Space<li> </li><strong>5GB</strong> Monthly Bandwidth<li> </li><strong>2</strong> Email Accounts<li> </li><strong>Unlimited</strong> subdomains</li>',
									'type' => 'textarea');	
									
				$options[] = array( 'name' => __('Pricing 2nd Column', 'gabfire'),
									'desc' => __('Enter a Name for the Package', 'gabfire'),
									'id' => $shortname.'_pricing_name_2',
									'std' => 'Standard',
									'class' => 'mini',
									'type' => 'text');
									
				$options[] = array( 'desc' => __('Enter a Price for the Package', 'gabfire'),
									'id' => $shortname.'_pricing_price_2',
									'std' => '$14',
									'class' => 'mini',
									'type' => 'text');
									
				$options[] = array( 'desc' => __('Signup Button Text (Leave empty to disable button)', 'gabfire'),
									'id' => $shortname.'_pricing_btn_2',
									'std' => 'Signup',
									'class' => 'mini',
									'type' => 'text');		

				$options[] = array( 'desc' => __('Enter a Link to Redirect When Signup Button is Clicked', 'gabfire'),
									'id' => $shortname.'_pricing_btnlink_2',
									'std' => '#',
									'type' => 'text');										
									
				$options[] = array( 'desc' => __('Wrap each featured between &lt;li&gt; ... &lt;/li&gt; - To bold a text, use &lt;strong&gt;&lt;/strong&gt;', 'gabfire'),
									'id' => $shortname.'_features_2',
									'std' => '<li><strong>3GB</strong> Disk Space<li> </li><strong>25GB</strong> Monthly Bandwidth<li> </li><strong>5</strong> Email Accounts<li> </li><strong>Unlimited</strong> subdomains</li>',
									'type' => 'textarea');	

				$options[] = array( 'name' => __('Pricing 3rd Column', 'gabfire'),
									'desc' => __('Enter a Name for the Package', 'gabfire'),
									'id' => $shortname.'_pricing_name_3',
									'std' => 'Professional',
									'class' => 'mini',
									'type' => 'text');
									
				$options[] = array( 'desc' => __('Enter a Price for the Package', 'gabfire'),
									'id' => $shortname.'_pricing_price_3',
									'std' => '$16',
									'class' => 'mini',
									'type' => 'text');
									
				$options[] = array( 'desc' => __('Signup Button Text (Leave empty to disable button)', 'gabfire'),
									'id' => $shortname.'_pricing_btn_3',
									'std' => 'Signup',
									'class' => 'mini',
									'type' => 'text');		

				$options[] = array( 'desc' => __('Enter a Link to Redirect When Signup Button is Clicked', 'gabfire'),
									'id' => $shortname.'_pricing_btnlink_3',
									'std' => '#',
									'type' => 'text');										
									
				$options[] = array( 'desc' => __('Wrap each featured between &lt;li&gt; ... &lt;/li&gt; - To bold a text, use &lt;strong&gt;&lt;/strong&gt;', 'gabfire'),
									'id' => $shortname.'_features_3',
									'std' => '<li><strong>5GB</strong> Disk Space<li> </li><strong>50GB</strong> Monthly Bandwidth<li> </li><strong>10</strong> Email Accounts<li> </li><strong>Unlimited</strong> subdomains</li>',
									'type' => 'textarea');	

				$options[] = array( 'name' => __('Pricing 4th Column', 'gabfire'),
									'desc' => __('Enter a Name for the Package', 'gabfire'),
									'id' => $shortname.'_pricing_name_4',
									'std' => 'Enterprise',
									'class' => 'mini',
									'type' => 'text');
									
				$options[] = array( 'desc' => __('Enter a Price for the Package', 'gabfire'),
									'id' => $shortname.'_pricing_price_4',
									'std' => '$28',
									'class' => 'mini',
									'type' => 'text');
									
				$options[] = array( 'desc' => __('Signup Button Text (Leave empty to disable button)', 'gabfire'),
									'id' => $shortname.'_pricing_btn_4',
									'std' => 'Signup',
									'class' => 'mini',
									'type' => 'text');		

				$options[] = array( 'desc' => __('Enter a Link to Redirect When Signup Button is Clicked', 'gabfire'),
									'id' => $shortname.'_pricing_btnlink_4',
									'std' => '#',
									'type' => 'text');										

				$options[] = array( 'desc' => __('Wrap each featured between &lt;li&gt; ... &lt;/li&gt; - To bold a text, use &lt;strong&gt;&lt;/strong&gt;', 'gabfire'),
									'id' => $shortname.'_features_4',
									'std' => '<li><strong>10GB</strong> Disk Space<li> </li><strong>100GB</strong> Monthly Bandwidth<li> </li><strong>20</strong> Email Accounts<li> </li><strong>Unlimited</strong> subdomains</li>',
									'type' => 'textarea');

			$options[] = array( 'name' => __('Team Members', 'gabfire'), 'type' => 'heading');
			
				$options[] = array(	'name' => __('Team Members - Enable / Disable', 'gabfire'),
									'desc' => __('Disable Team Members Section', 'gabfire'),
									'id' => $shortname.'_team',
									'std' => 0,
									'type' => 'checkbox');				
									
				$options[] = array( 'name' => __('Section Titles', 'gabfire'),
									'desc' => __('First Title Line (wrap text with &lt;strong&gt;&lt;/strong&gt; to color it)', 'gabfire'),
									'id' => $shortname.'_team_firstline',
									'std' => 'Team Members',
									'type' => 'textarea');
									
				$options[] = array( 'desc' => __('Second Title Line (wrap text with &lt;strong&gt;&lt;/strong&gt; to color it)', 'gabfire'),
									'id' => $shortname.'_team_secondline',
									'std' => 'Lorem ipsum dolor sit <strong>imperdiet</strong> porttitor eu diam eu.',
									'type' => 'textarea');
									
				$options[] = array(	'desc' => __('Number of Team Members to Show on Front Page', 'gabfire'),
									'id' => $shortname.'_team_members',
									'std' => 6,
									'type' => 'select',
									"options" => $options_nr);
									
		$options[] = array( 'name' => __('Post Layout', 'gabfire'),
							'desc' => __('By Default, when a team member is selected - CV template is defined to load. You can change that CV template to any blog layout by simply selecting another option below.', 'gabfire'),
							'id' => $shortname.'_teamsinglelayout',
							'std' => 'CV',
							'type' => 'select',
							'options' => array(
								'cv' => __('CV Layout', 'gabfire'),
								'default-blog' => __('Default Blog Layout', 'gabfire'),
								'nosidebar-blog' => __('No Sidebar Blog Layout', 'gabfire')
							));									

			$options[] = array( 'name' => __('Portfolio', 'gabfire'), 'type' => 'heading');
			
				$options[] = array(	'name' => __('Portfolio - Enable / Disable', 'gabfire'),
									'desc' => __('Disable Portfolio Section', 'gabfire'),
									'id' => $shortname.'_portfolio',
									'std' => 0,
									'type' => 'checkbox');				
									
				$options[] = array( 'name' => __('Section Titles', 'gabfire'),
									'desc' => __('First Title Line (wrap text with &lt;strong&gt;&lt;/strong&gt; to color it)', 'gabfire'),
									'id' => $shortname.'_portfolio_firstline',
									'std' => 'Our Portfolio',
									'type' => 'textarea');
									
				$options[] = array( 'desc' => __('Second Title Line (wrap text with &lt;strong&gt;&lt;/strong&gt; to color it)', 'gabfire'),
									'id' => $shortname.'_portfolio_secondline',
									'std' => 'Take a look at the awesomeness that we built.',
									'type' => 'textarea');									

				$options[] = array(	'desc' => __('Number of Portfolio Items to Show on Front Page', 'gabfire'),
									'id' => $shortname.'_portfolionr',
									'std' => 8,
									'type' => 'select',
									"options" => $options_nr);

				$options[] = array(
									'desc' => __('By default theme will query most recent portfolio entries and it will dispaly all portfolio categories on front page. That might not work well. We strongly suggest you to enter the ID number of portfolio categories to show on front page into the field below. Check this tutorial - http://www.gabfirethemes.com/how-to-check-category-ids/ - if you are not sure how to get category id.', 'gabfire'),
									'type' => 'info');								
									
				$options[] = array( 'desc' => __('ID Number of Category ID\'s to display. Use comma as separator.', 'gabfire'),
									'id' => $shortname.'_portfolio_cats',
									'std' => '',
									'type' => 'text');	
									
				$options[] = array(	'name' => __('Portfolio Sidebar Widget - Enable / Disable', 'gabfire'),
									'desc' => __('Check to Disable Portfolio  Widget on Innerpage Sidebars', 'gabfire'),
									'id' => $shortname.'_portfolio_sidebar',
									'std' => 0,
									'type' => 'checkbox');
									
				$options[] = array( 'desc' => __('Title to Display Above Portfolio Posts', 'gabfire'),
									'id' => $shortname.'_portfolio_posts_title',
									'std' => 'Random Portfolio Posts',
									'type' => 'text');									
									
			$options[] = array( 'name' => __('Testimonials', 'gabfire'), 'type' => 'heading');
			
				$options[] = array(	'name' => __('Testimonials - Enable / Disable', 'gabfire'),
									'desc' => __('Disable Testimonials Section', 'gabfire'),
									'id' => $shortname.'_testimonials',
									'std' => 0,
									'type' => 'checkbox');				
									
				$options[] = array( 'name' => __('Section Title', 'gabfire'),
									'desc' => __('Title Line (wrap text with &lt;strong&gt;&lt;/strong&gt; to color it)', 'gabfire'),
									'id' => $shortname.'_testimonial_firstline',
									'std' => 'Testimonials',
									'type' => 'textarea');
									
				$options[] = array(	'name' => __('Background', 'gabfire'),
									'desc' => __('Upload a custom background image', 'gabfire'),
									'id' => $shortname.'_testimonialsbg',
									'std' => $themeurl . '/images/defaults/11.jpg',
									'type' => 'upload');									
									
				$options[] = array(	'desc' => __('Number of Testimonials to Show (We Suggest Max 4)', 'gabfire'),
									'id' => $shortname.'_testimonialsnr',
									'std' => 3,
									'type' => 'select',
									"options" => $options_nr);	

				$options[] = array( 'name' => __('Testimonial #1', 'gabfire'),
									'desc' => __('Enter Testimonial Text', 'gabfire'),
									'id' => $shortname.'_testimonial_1',
									'std' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vestibulum a est et ipsum posuere tristique. Vestibulum lacinia porttitor rhoncus. Quisque fermentum nunc ut lobortis vestibulum.',
									'type' => 'textarea');
									
				$options[] = array( 'desc' => __('Testimonial By', 'gabfire'),
									'id' => $shortname.'_testimonial_by_1',
									'std' => 'John Doe, ABC Design Studio',
									'type' => 'text');	
									
				$options[] = array( 'desc' => __('Image of Testimonial Owner', 'gabfire'),
									'id' => $shortname.'_testimonialspicture_1',
									'std' => $themeurl . '/images/defaults/figures/01.jpg',
									'type' => 'upload');
									
				$options[] = array( 'name' => __('Testimonial #2', 'gabfire'),
									'desc' => __('Enter Testimonial Text', 'gabfire'),
									'id' => $shortname.'_testimonial_2',
									'std' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vestibulum a est et ipsum posuere tristique. Vestibulum lacinia porttitor rhoncus. Quisque fermentum nunc ut lobortis vestibulum.',
									'type' => 'textarea');
									
				$options[] = array( 'desc' => __('Testimonial By', 'gabfire'),
									'id' => $shortname.'_testimonial_by_2',
									'std' => 'John Doe, ABC Design Studio',
									'type' => 'text');	
									
				$options[] = array( 'desc' => __('Image of Testimonial Owner', 'gabfire'),
									'id' => $shortname.'_testimonialspicture_2',
									'std' => $themeurl . '/images/defaults/figures/02.jpg',
									'type' => 'upload');
									
				$options[] = array( 'name' => __('Testimonial #3', 'gabfire'),
									'desc' => __('Enter Testimonial Text', 'gabfire'),
									'id' => $shortname.'_testimonial_3',
									'std' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vestibulum a est et ipsum posuere tristique. Vestibulum lacinia porttitor rhoncus. Quisque fermentum nunc ut lobortis vestibulum.',
									'type' => 'textarea');
									
				$options[] = array( 'desc' => __('Testimonial By', 'gabfire'),
									'id' => $shortname.'_testimonial_by_3',
									'std' => 'John Doe, ABC Design Studio',
									'type' => 'text');	
									
				$options[] = array( 'desc' => __('Image of Testimonial Owner', 'gabfire'),
									'id' => $shortname.'_testimonialspicture_3',
									'std' => $themeurl . '/images/defaults/figures/03.jpg',
									'type' => 'upload');
									
				$options[] = array( 'name' => __('Testimonial #4', 'gabfire'),
									'desc' => __('Enter Testimonial Text', 'gabfire'),
									'id' => $shortname.'_testimonial_4',
									'std' => '',
									'type' => 'textarea');
									
				$options[] = array( 'desc' => __('Testimonial By', 'gabfire'),
									'id' => $shortname.'_testimonial_by_4',
									'std' => '',
									'type' => 'text');	
									
				$options[] = array( 'desc' => __('Image of Testimonial Owner', 'gabfire'),
									'id' => $shortname.'_testimonialspicture_4',
									'std' => '',
									'type' => 'upload');
									
				$options[] = array( 'name' => __('Testimonial #5', 'gabfire'),
									'desc' => __('Enter Testimonial Text', 'gabfire'),
									'id' => $shortname.'_testimonial_5',
									'std' => '',
									'type' => 'textarea');
									
				$options[] = array( 'desc' => __('Testimonial By', 'gabfire'),
									'id' => $shortname.'_testimonial_by_5',
									'std' => '',
									'type' => 'text');	
									
				$options[] = array( 'desc' => __('Image of Testimonial Owner', 'gabfire'),
									'id' => $shortname.'_testimonialspicture_5',
									'std' => '',
									'type' => 'upload');
									
				$options[] = array( 'name' => __('Testimonial #6', 'gabfire'),
									'desc' => __('Enter Testimonial Text', 'gabfire'),
									'id' => $shortname.'_testimonial_6',
									'std' => '',
									'type' => 'textarea');
									
				$options[] = array( 'desc' => __('Testimonial By', 'gabfire'),
									'id' => $shortname.'_testimonial_by_6',
									'std' => '',
									'type' => 'text');	
									
				$options[] = array( 'desc' => __('Image of Testimonial Owner', 'gabfire'),
									'id' => $shortname.'_testimonialspicture_6',
									'std' => '',
									'type' => 'upload');
									
				$options[] = array( 'name' => __('Testimonial #7', 'gabfire'),
									'desc' => __('Enter Testimonial Text', 'gabfire'),
									'id' => $shortname.'_testimonial_7',
									'std' => '',
									'type' => 'textarea');
									
				$options[] = array( 'desc' => __('Testimonial By', 'gabfire'),
									'id' => $shortname.'_testimonial_by_7',
									'std' => '',
									'type' => 'text');	
									
				$options[] = array( 'desc' => __('Image of Testimonial Owner', 'gabfire'),
									'id' => $shortname.'_testimonialspicture_7',
									'std' => '',
									'type' => 'upload');
									
				$options[] = array( 'name' => __('Testimonial #8', 'gabfire'),
									'desc' => __('Enter Testimonial Text', 'gabfire'),
									'id' => $shortname.'_testimonial_8',
									'std' => '',
									'type' => 'textarea');
									
				$options[] = array( 'desc' => __('Testimonial By', 'gabfire'),
									'id' => $shortname.'_testimonial_by_8',
									'std' => '',
									'type' => 'text');	
									
				$options[] = array( 'desc' => __('Image of Testimonial Owner', 'gabfire'),
									'id' => $shortname.'_testimonialspicture_8',
									'std' => '',
									'type' => 'upload');
									
				$options[] = array( 'name' => __('Testimonial #9', 'gabfire'),
									'desc' => __('Enter Testimonial Text', 'gabfire'),
									'id' => $shortname.'_testimonial_9',
									'std' => '',
									'type' => 'textarea');
									
				$options[] = array( 'desc' => __('Testimonial By', 'gabfire'),
									'id' => $shortname.'_testimonial_by_9',
									'std' => '',
									'type' => 'text');	
									
				$options[] = array( 'desc' => __('Image of Testimonial Owner', 'gabfire'),
									'id' => $shortname.'_testimonialspicture_9',
									'std' => '',
									'type' => 'upload');
									
				$options[] = array( 'name' => __('Testimonial #10', 'gabfire'),
									'desc' => __('Enter Testimonial Text', 'gabfire'),
									'id' => $shortname.'_testimonial_10',
									'std' => '',
									'type' => 'textarea');
									
				$options[] = array( 'desc' => __('Testimonial By', 'gabfire'),
									'id' => $shortname.'_testimonial_by_10',
									'std' => '',
									'type' => 'text');	
									
				$options[] = array( 'desc' => __('Image of Testimonial Owner', 'gabfire'),
									'id' => $shortname.'_testimonialspicture_10',
									'std' => '',
									'type' => 'upload');
	
			$options[] = array( 'name' => __('Timeline', 'gabfire'), 'type' => 'heading');
			
				$options[] = array(	'name' => __('Timeline - Enable / Disable', 'gabfire'),
									'desc' => __('Disable Timeline Section', 'gabfire'),
									'id' => $shortname.'_timeline',
									'std' => 0,
									'type' => 'checkbox');				
									
				$options[] = array( 'name' => __('Section Titles', 'gabfire'),
									'desc' => __('First Title Line (wrap text with &lt;strong&gt;&lt;/strong&gt; to color it)', 'gabfire'),
									'id' => $shortname.'_timeline_firstline',
									'std' => 'From Blog',
									'type' => 'textarea');
									
				$options[] = array( 'desc' => __('Second Title Line (wrap text with &lt;strong&gt;&lt;/strong&gt; to color it)', 'gabfire'),
									'id' => $shortname.'_timeline_secondline',
									'std' => 'Most Recent News From <strong>Company Name</strong>',
									'type' => 'textarea');
	
				$options[] = array( 'name' => __('Blog Entries', 'gabfire'),
									'desc' => __('Select a base query type to determine how this content area is populated', 'gabfire'),
									'id' => $shortname.'_featype',
									'std' => 'catbased',
									'type' => 'images',
									'options' => array(
										'catbased' => $imagepath . 'fea-category.gif',
										'mrecent' => $imagepath . 'fea-recent.gif'));
	
				$options[] = array(
					'desc' => __('If base query type is Category or Tag-based, please identify the category or tag. </br>If base query type is Custom Field, posts which are marked as featured (checkbox labeled as <strong>Is Featured</strong> is enabled on <strong>Add/Edit Post</strong> screen) will be displayed).', 'gabfire'),
					'type' => 'info');
		
				$options[] = array( 'desc' => __('If category based: Select a category for entries.', 'gabfire'),
									'id' => $shortname.'_cat',
									'type' => 'select',
									'options' => $options_categories);

				$options[] = array( 'desc' => __('If tag based: Select a tag for entries.', 'gabfire'),
									'id' => $shortname.'_tag',
									'type' => 'text');

				$options[] = array( 'desc' => __('Number of Entries to display', 'gabfire'),
									'id' => $shortname.'_nr',
									'std' => 4,
									'class' => 'mini',
									'type' => 'select',
									'options' => $options_nr);	
	
				$options[] = array( 'name' => __('Button Below Blog Posts', 'gabfire'),
									'desc' => __( 'Enter a Link for Button.', 'gabfire'),
									'id' => $shortname.'_linktimeline',
									'std' => '',
									'type' => 'text'); 	
			
				$options[] = array( 'name' => __('Button Below Blog Posts', 'gabfire'),
									'desc' => 'Go to pages -> add new -> Enter a Blog Title ->  make sure select Blog Template on right hand below publish button -> publish the page and select that page on dropdown below',
									'id' => $shortname.'_bloglink',
									'type' => 'select',
									'options' => $options_pages);										

				$options[] = array( 'desc' => __( 'Text to Display on Button', 'gabfire'),
									'id' => $shortname.'_linktexttimeline',
									'std' => '',
									'type' => 'text');

			$options[] = array( 'name' => __('Footer Contact', 'gabfire'), 'type' => 'heading');
			
				$options[] = array(	'name' => __('Contact - Enable / Disable', 'gabfire'),
									'desc' => __('Disable Contact Section', 'gabfire'),
									'id' => $shortname.'_contact',
									'std' => 0,
									'type' => 'checkbox');				
									
				$options[] = array( 'name' => __('Section Titles', 'gabfire'),
									'desc' => __('First Title Line (wrap text with &lt;strong&gt;&lt;/strong&gt; to color it)', 'gabfire'),
									'id' => $shortname.'_contact_firstline',
									'std' => 'Contact',
									'type' => 'textarea');
									
				$options[] = array( 'desc' => __('Second Title Line (wrap text with &lt;strong&gt;&lt;/strong&gt; to color it)', 'gabfire'),
									'id' => $shortname.'_contact_secondline',
									'std' => 'Get in Touch With Us',
									'type' => 'textarea');		
									
			$options[] = array(	'desc' => __('Upload a custom background image', 'gabfire'),
								'id' => $shortname.'_contactbg',
								'std' => $themeurl . '/images/defaults/contact-bg.jpg',
								'type' => 'upload');									

				$options[] = array( 'name' => __('Contact Details', 'gabfire'),
									'desc' => __( 'Company Name', 'gabfire'),
									'id' => $shortname.'_company',
									'std' => 'Company LLC',
									'type' => 'text');		

				$options[] = array( 'desc' => __( 'Streeet address', 'gabfire'),
									'id' => $shortname.'_address1',
									'std' => '125 Maiden Lane, 11th Floor',
									'type' => 'text');	

				$options[] = array( 'desc' => __( 'City & State', 'gabfire'),
									'id' => $shortname.'_address2',
									'std' => 'New York, NY',
									'type' => 'text');	

				$options[] = array( 'desc' => __( 'Post Code', 'gabfire'),
									'id' => $shortname.'_address3',
									'std' => '84574',
									'type' => 'text');										

				$options[] = array( 'desc' => __( 'Country', 'gabfire'),
									'id' => $shortname.'_address4',
									'std' => 'USA ',
									'type' => 'text');		

				$options[] = array( 'desc' => __( 'Email - Contact form emails are also will be sent to this address', 'gabfire'),
									'id' => $shortname.'_emailaddr',
									'std' => 'contact@example.com',
									'type' => 'text');
									
				$options[] = array( 'desc' => __( 'Phone', 'gabfire'),
									'id' => $shortname.'_phonenr',
									'std' => '+1 (234) 5678 912345',
									'type' => 'text');
									
				$options[] = array( 'desc' => __( 'Facebook', 'gabfire'),
									'id' => $shortname.'_cn_facebook',
									'std' => 'http://www.facebook.com',
									'type' => 'text');
									
				$options[] = array( 'desc' => __( 'Twitter', 'gabfire'),
									'id' => $shortname.'_cn_twitter',
									'std' => 'http://www.twitter.com',
									'type' => 'text');
									
				$options[] = array( 'desc' => __( 'Google+', 'gabfire'),
									'id' => $shortname.'_cn_gplus',
									'std' => 'http://plus.google.com',
									'type' => 'text');
									
				$options[] = array( 'desc' => __( 'LinkedIn', 'gabfire'),
									'id' => $shortname.'_cn_linkedin',
									'std' => 'http://www.linkedin.com',
									'type' => 'text');

			$options[] = array( 'name' => __('Miscellaneous', 'gabfire'), 'type' => 'heading');
			
				$options[] = array( 'name' => __('Navigation', 'gabfire'),
									'desc' => __( 'You can edit Navigation Links below. If you do not want any of the links below to show up on navigation, simply leave the field empty. If you create a custom navigation and assign it to show on Primary nav zone, it will display right after HOME link', 'gabfire'),
									'type' => 'info');
									
				$options[] = array( 'desc' => __( 'Link #1 - Link to Home', 'gabfire'),
									'id' => $shortname.'_nav_1',
									'class' => 'mini',
									'std' => 'HOME',
									'type' => 'text');									
									
				$options[] = array( 'desc' => __( 'Link #2 - Link to About Section', 'gabfire'),
									'id' => $shortname.'_nav_2',
									'class' => 'mini',
									'std' => 'ABOUT',
									'type' => 'text'); 		

				$options[] = array(	'desc' => __( 'Link #3 - Link to Services Section', 'gabfire'),
									'id' => $shortname.'_nav_3',
									'class' => 'mini',
									'std' => 'SERVICES',
									'type' => 'text'); 		

				$options[] = array(	'desc' => __( 'Link #4 - Link to Pricing Section', 'gabfire'),
									'id' => $shortname.'_nav_4',
									'class' => 'mini',
									'std' => 'PRICING',
									'type' => 'text'); 		

				$options[] = array(	'desc' => __( 'Link #5 - Link to Team Section', 'gabfire'),
									'id' => $shortname.'_nav_5',
									'class' => 'mini',
									'std' => 'TEAM',
									'type' => 'text'); 

				$options[] = array(	'desc' => __( 'Link #6 - Link to Portfolio Section', 'gabfire'),
									'id' => $shortname.'_nav_6',
									'class' => 'mini',
									'std' => 'PORTFOLIO',
									'type' => 'text'); 	

				$options[] = array(	'desc' => __( 'Link #7 - Link to Blog Section', 'gabfire'),
									'id' => $shortname.'_nav_7',
									'class' => 'mini',
									'std' => 'BLOG',
									'type' => 'text'); 	

				$options[] = array(	'desc' => __( 'Link #8 - Link to Contact Section', 'gabfire'),
									'id' => $shortname.'_nav_8',
									'class' => 'mini',
									'std' => 'CONTACT',
									'type' => 'text'); 										
			
				$options[] = array( 'name' => __('Featured Image Post Display', 'gabfire'),
									'desc' => __('Auto resize and display featured image on single post - above entry.', 'gabfire'),
									'id' => $shortname.'_autoimage',
									'std' => 0,
									'type' => 'checkbox');
			
				$options[] = array(	'name' => __( '2 column category template', 'gabfire'),
									'desc' => __( 'ID number of cat(s) to use 2 cols category template Separate with comma if more than 1 category is entered. (ex: 1,5,99)', 'gabfire'),
									'id' => $shortname.'_2col',
									'class' => 'mini',
									'type' => 'text'); 	
																
				$options[] = array(	'name' => __( '2 column no sidebar category template', 'gabfire'),
									'desc' => __( 'ID number of cat(s) to use 2 cols category template Separate with comma if more than 1 category is entered. (ex: 1,5,99)', 'gabfire'),
									'id' => $shortname.'_2col_full',
									'class' => 'mini',
									'type' => 'text'); 	
									
				$options[] = array(	'name' => __( '3 column no sidebar category template', 'gabfire'),
									'desc' => __( 'ID number of cat(s) to use 3 cols category template. Separate with comma if more than 1 category is entered. (ex: 1,5,99)', 'gabfire'),
									'id' => $shortname.'_3col_full',
									'class' => 'mini',
									'type' => 'text'); 	
									
				$options[] = array(	'name' => __( '4 column no sidebar category template', 'gabfire'),
									'desc' => __( 'ID number of cat(s) to use 4 cols category template. Separate with comma if more than 1 category is entered. (ex: 1,5,99)', 'gabfire'),
									'id' => $shortname.'_4col_full',
									'class' => 'mini',
									'type' => 'text'); 
									
				$options[] = array(	'name' => __( 'Portfolio Style Archive (With Slider)', 'gabfire'),
									'desc' => __( 'ID number of cat(s) to use 4 cols category template. Separate with comma if more than 1 category is entered. (ex: 1,5,99)', 'gabfire'),
									'id' => $shortname.'_w_slider',
									'class' => 'mini',
									'type' => 'text'); 	
			
				$options[] = array( 'name' => __('Inner-Page Slider', 'gabfire'),
									'desc' => __( 'Automatically create slideshow of uploaded photos in post entries to be displayed below post title. [Note: Select options include displaying slider site-wide, tag-based, or to disable completely].', 'gabfire'),
									'id' => $shortname.'_inslider',
									'std' => 'Disable',
									'type' => 'select',
									'class' => 'mini',
									'options' => $options_inslider);
									
				$options[] = array( 'desc' => __( 'If tag-based option is selected, display posts assigned this tag to be shown in inner-page slider. <br/> [Note: Posts with multiple image attachments and tagged with this key will display within slider].', 'gabfire'),
									'id' => $shortname.'_inslider_tag',
									'std' => '',
									'class' => 'mini',
									'type' => 'text'); 										
										
				$options[] = array( 'name' => __('Shortcodes', 'gabfire'),
									'desc' => __('Enable shortcodes functionality', 'gabfire'),
									'id' => $shortname.'_shortcodes',
									'std' => 0,
									'type' => 'checkbox');
									
				$options[] = array( 'name' => __('Widget Map', 'gabfire'),
									'desc' => __('Display the location of widgets on front page. After reviewing widget locations be sure to disable this option.', 'gabfire'),
									'id' => $shortname.'_widget',
									'std' => 0,
									'type' => 'checkbox');

	$options[] = array( 'name' => 'Custom Styling', 'type' => 'heading');
	
		$options[] = array( 'name' => __('Custom CSS', 'gabfire'),
							'desc' => __('Quickly add some CSS to your theme by adding it to this block.', 'gabfire'),
							'id' => $shortname.'_custom_css',
							'type' => 'textarea');
							
		$options[] = array( 'name' => __('Change Primary Color', 'gabfire'),
							'desc' => __('Check this box and select a color below', 'gabfire'),
							'id' => $shortname.'_change_primarycolor',
							'std' => 0,
							'type' => 'checkbox');									
							
		$options[] = array( 'desc' => __('Primary Color', 'gabfire'),
							'id' => $shortname.'_primarycolor',
							'std' => '#f33768',
							'type' => 'color');		

		$options[] = array( 'name' => __('Change Link Color', 'gabfire'),
							'desc' => __('Check this box and select a color below', 'gabfire'),
							'id' => $shortname.'_change_alink',
							'std' => 0,
							'type' => 'checkbox');							
							
		$options[] = array( 'desc' => __('Link Color', 'gabfire'),
							'id' => $shortname.'_alink',
							'std' => '#f33768',
							'type' => 'color');	

		$options[] = array( 'name' => __('Change Hovered Link Color', 'gabfire'),
							'desc' => __('Check this box and select a color below', 'gabfire'),
							'id' => $shortname.'_change_ahover',
							'std' => 0,
							'type' => 'checkbox');						
							
		$options[] = array( 'desc' => __('Hovered Link Color', 'gabfire'),
							'id' => $shortname.'_ahover',
							'std' => '#f17293',
							'type' => 'color');

		$options[] = array( 'name' => __('Edit Navigation Colors', 'gabfire'),
							'desc' => __('This is a master trigger to enable main navigation color edit below', 'gabfire'),
							'id' => $shortname.'_change_nav',
							'std' => 0,
							'type' => 'checkbox');

		$options[] = array( 'desc' => __('Navigation bar background color', 'gabfire'),
							'id' => $shortname.'_navbg',
							'std' => '#f33768',
							'type' => 'color');

		$options[] = array( 'desc' => __('Link color', 'gabfire'),
							'id' => $shortname.'_licolor',
							'std' => '#ffffff',
							'type' => 'color');

		$options[] = array( 'desc' => __('Current/Active Link color', 'gabfire'),
							'id' => $shortname.'_licurrent',
							'std' => '#222222',
							'type' => 'color');

		$options[] = array( 'desc' => __('Hovered Link color', 'gabfire'),
							'id' => $shortname.'_lihover',
							'std' => '#222222',
							'type' => 'color');

		$options[] = array( 'desc' => __('Dropdown border color', 'gabfire'),
							'id' => $shortname.'_liulborder',
							'std' => '#efefef',
							'type' => 'color');		

		$options[] = array( 'desc' => __('Dropdown background color', 'gabfire'),
							'id' => $shortname.'_liulbg',
							'std' => '#ffffff',
							'type' => 'color');		

		$options[] = array( 'desc' => __('Dropdown link color', 'gabfire'),
							'id' => $shortname.'_lilicolor',
							'std' => '#555555',
							'type' => 'color');		

		$options[] = array( 'desc' => __('Dropdown hovered link color', 'gabfire'),
							'id' => $shortname.'_lilihover',
							'std' => '#000000',
							'type' => 'color');									
									
	return $options;
}