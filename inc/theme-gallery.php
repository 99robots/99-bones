<?php
global $post_layout;
$number_photos = -1; 		// -1 to display all
$photo_size = 'large';		// The standard WordPress size to use for the large image
$thumb_size = 'thumbnail';	// The standard WordPress size to use for the thumbnail
$thumb_width = 65;			// Size of thumbnails to embed into img tag
$thumb_height = 50;			// Size of thumbnails to embed into img tag
$photo_width = 900;		// Width of photo
$photo_height = 500;		// Width of photo
$themeurl = get_template_directory_uri();

$attachments = get_children( array(
'post_parent' => $post->ID,
'numberposts' => $number_photos,
'post_type' => 'attachment',
'post_mime_type' => 'image',
'order' => 'ASC', 
'orderby' => 'menu_order date')
);

if ( !empty($attachments) ) :
	$counter = 0;
	$photo_output = '';
	$thumb_output = '';	
	foreach ( $attachments as $att_id => $attachment ) {
		$counter++;
		
		# Caption
		$caption = "";
		if ($attachment->post_excerpt) {
			$caption = '<div class="postcaption"><p class="innerslide_text">' . $attachment->post_excerpt . '</p></div>';
		}
	
		# Large photo
		$src = wp_get_attachment_image_src($attachment->ID, 'ev-postfull-fullwidth', true);
		$full = wp_get_attachment_image_src($attachment->ID, 'large', true);
		
		if (of_get_option('of_wpmumode')==0) {
			$photo_output .= '<div class="carousel_item"><img src="'. $src[0] .'" alt="" />'. $caption .'</div>';
		}	
	}  
endif; ?>

<?php if ($counter > 1) : ?>
	<div class="innerslider-wrapper">
		<div class="carousel-four-controls">
			<span class="carousel-four-prev pull-left"><i class="fa fa-angle-left"></i></span>
			<span class="carousel-four-next pull-right"><i class="fa fa-angle-right"></i></span>
		</div>
		
		<div class="carousel-four">	
			<?php echo $photo_output; ?>
		</div>
	</div>
<?php endif; ?>
