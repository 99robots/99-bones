<?php
$number_photos = -1; 		// -1 to display all
$photo_size = 'large';		// The standard WordPress size to use for the large image
$thumb_size = 'thumbnail';	// The standard WordPress size to use for the thumbnail
$thumb_width = 65;			// Size of thumbnails to embed into img tag
$thumb_height = 50;			// Size of thumbnails to embed into img tag
$photo_width = 1054;		// Width of photo
$themeurl = get_template_directory_uri();


$attachments = get_children( array(
'post_parent' => $post->ID,
'numberposts' => -1,
'post_type' => 'attachment',
'post_mime_type' => 'image',
'order' => 'ASC', 
'orderby' => 'menu_order')
);

if ( !empty($attachments) ) :
	$counter = 0;
	$photo_output = '';
	$thumb_output = '';	
	foreach ( $attachments as $att_id => $attachment ) {
		$counter++;
		
		# Caption
		$caption = "";
		if ($attachment->post_excerpt) 
			$caption = '<p class="sliderCaption">'.$attachment->post_excerpt.'</p>';	
			
		# Large photo
		$full = wp_get_attachment_image_src($attachment->ID, 'full', true);
		
		$photo_output .= '<div class="bigpicture_item"><img style="width:'.$photo_width.'px;display:block;" src="'. $full[0] .'" style="width:'.$photo_width.';height:auto;" alt="" />'.$caption.'</div>';	
	}  
endif; 

echo $photo_output;