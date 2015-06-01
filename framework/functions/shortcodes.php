<?php
function related_posts_shortcode( $atts ) {
	extract(shortcode_atts(array(
	    'limit' => '5',
	), $atts));

	global $wpdb, $post, $table_prefix;

	if ($post->ID) {
		$retval = '<div class="widget"><ul>';
 		// Get tags
		$tags = wp_get_post_tags($post->ID);
		$tagsarray = array();
		foreach ($tags as $tag) {
			$tagsarray[] = $tag->term_id;
		}
		$tagslist = implode(',', $tagsarray);

		// Do the query
		$q = "SELECT p.*, count(tr.object_id) as count
			FROM $wpdb->term_taxonomy AS tt, $wpdb->term_relationships AS tr, $wpdb->posts AS p WHERE tt.taxonomy ='post_tag' AND tt.term_taxonomy_id = tr.term_taxonomy_id AND tr.object_id  = p.ID AND tt.term_id IN ($tagslist) AND p.ID != $post->ID
				AND p.post_status = 'publish'
				AND p.post_date_gmt < NOW()
 			GROUP BY tr.object_id
			ORDER BY count DESC, p.post_date_gmt DESC
			LIMIT $limit;";

		$related = $wpdb->get_results($q);
 		if ( $related ) {
			foreach($related as $r) {
				$retval .= '<li><a title="'.wptexturize($r->post_title).'" href="'.get_permalink($r->ID).'">'.wptexturize($r->post_title).'</a></li>';
			}
		} else {
			$retval .= '
		<li>' . __('No related posts found', 'gabfire') .  '</li>';
		}
		$retval .= '</ul></div>';
		return $retval;
	}
	return;
}
add_shortcode('related_posts', 'related_posts_shortcode');

// [quote]Some text[/quote] 
function quote($atts, $content = null) {
	extract(shortcode_atts(array(
		'by' => ''
	), $atts));
	$content = '<blockquote class="quote"><p>'.$content;
	if($by!='') $content .= '</p><cite>&#126; '.$by.'</cite>';
	$content .= '</blockquote>';
	return $content;
}
add_shortcode( 'quote', 'quote' );


// [hr] 
function hr($atts, $content = null) {
	extract(shortcode_atts(array(
		'width' => ''
	), $atts));
	return '<div class="hr" style="width:'.$width.'"><hr /></div>';
}
add_shortcode( 'hr', 'hr' );


// access capability
function access_check( $attr, $content = null ) {
    extract( shortcode_atts( array( 'capability' => 'read' ), $attr ) );
    if ( current_user_can( $capability ) && !is_null( $content ) && !is_feed() )
        return $content;

    return;
}

add_shortcode( 'access', 'access_check' );

// Success  [success] text [/success]
function successbox($atts, $content=null, $code="") {
	$return = '<div class="gabfire_success">';
	$return .= $content;
	$return .= '</div>';
	return $return;
}
add_shortcode('success' , 'successbox' );

//Info [info] text [/info]
function infobox($atts, $content=null, $code="") {
	$return = '<div class="gabfire_info">';
	$return .= $content;
	$return .= '</div>';
	return $return;
}
add_shortcode('info', 'infobox');

//Warning [warning] text [/warning]
function warningbox($atts, $content=null, $code="") {
	$return = '<div class="gabfire_warning">';
	$return .= $content;
	$return .= '</div>';
	return $return;
}
add_shortcode('warning', 'warningbox');

//Danger [danger] text [/danger]
function danberbox($atts, $content=null, $code="") {
	$return = '<div class="gabfire_danger">';
	$return .= $content;
	$return .= '</div>';
	return $return;
}
add_shortcode('danger', 'danberbox');

// Callouts
function dn_callout( $atts, $content = null ) {
	$style = '';
	extract(shortcode_atts(array(
		'width' => '',
		'align' => ''
    ), $atts));
	$style;
	if ($width || $align) {
	 $style .= 'style="';
	 if ($width) $style .= 'width:'.$width.'px;';
	 if ($align == 'left' || 'right') $style .= 'float:'.$align.';';
	 if ($align == 'center') $style .= 'margin:0px auto;';
	 $style .= '"';
	}
   return '<p class="cta" '.$style.'>' . do_shortcode($content) . '</p><div class="clearfix"></div>';
}
add_shortcode('callout', 'dn_callout');

// Buttons
function dn_button( $atts, $content = null ) {
	$button ='';
	extract(shortcode_atts(array(
		'link' => '',
		'color' => '',
		'align' => '',
		'target' => '_self',
		'caption' => '',
    ), $atts));	
	$button;
	$button .= '<a target="'.$target.'" class="button '.$color.' '.$align.'" href="'.$link.'">';
	$button .= '<span class="btn_caption">'. $caption .'</span>';
	$button .= '</a>';
	return $button;
}
add_shortcode('button', 'dn_button');

// Tabs
add_shortcode( 'tabgroup', 'st_tabgroup' );
function st_tabgroup( $atts, $content ){
	$GLOBALS['tab_count'] = 0;
	do_shortcode( $content );
	if( is_array( $GLOBALS['tabs'] ) ){
		foreach( $GLOBALS['tabs'] as $tab ){
			$tabs[] = '<li><a href="#'.$tab['id'].'">'.$tab['title'].'</a></li>';
			$panes[] = '<div id="'.$tab['id'].'Tab">'.$tab['content'].'</div>';
		}
		$return = "\n".'<!-- the tabs --><ul class="sc_tabs">'.implode( "\n", $tabs ).'</ul>'."\n".'<!-- tab "sc_panes" --><div class="sc_tabs-content">'.implode( "\n", $panes ).'</div>'."\n";
	}
	return $return;
}

add_shortcode( 'tab', 'st_tab' );
function st_tab( $atts, $content ){
	extract(shortcode_atts(array(
		'title' => "%d",
		'id' => "%d"
	), $atts));

	$x = $GLOBALS['tab_count'];
	$GLOBALS['tabs'][$x] = array(
		'title' => sprintf( $title, $GLOBALS['tab_count'] ),
		'content' =>  $content,
		'id' =>  $id );

	$GLOBALS['tab_count']++;
}

function simple_table( $atts ) {
    extract( shortcode_atts( array(
        'cols' => 'none',
        'data' => 'none',
    ), $atts ) );
    $cols = explode(',',$cols);
    $data = explode(',',$data);
    $total = count($cols);
    $output = '<table class="theme-table"><thead><tr>';
    foreach($cols as $col):
        $output .= "<th>{$col}</strong></th>";
    endforeach;
    $output .= '</thead></tr><tr>';
    $counter = 1;
    foreach($data as $datum):
        $output .= "<td>{$datum}</td>";
        if($counter%$total==0):
            $output .= '</tr>';
        endif;
        $counter++;
    endforeach;
        $output .= '</table>';
    return $output;
}
add_shortcode( 'table', 'simple_table' );



// cols
function one_third( $atts, $content = null ) {
   return '<div class="one_third">' . do_shortcode($content) . '</div>';
}
add_shortcode('one_third', 'one_third');

function one_third_last( $atts, $content = null ) {
   return '<div class="one_third lastcolumn">' . do_shortcode($content) . '</div><div class="clear"></div>';
}
add_shortcode('one_third_last', 'one_third_last');

function two_third( $atts, $content = null ) {
   return '<div class="two_third">' . do_shortcode($content) . '</div>';
}
add_shortcode('two_third', 'two_third');

function two_third_last( $atts, $content = null ) {
   return '<div class="two_third lastcolumn">' . do_shortcode($content) . '</div><div class="clear"></div>';
}
add_shortcode('two_third_last', 'two_third_last');

function one_half( $atts, $content = null ) {
   return '<div class="one_half">' . do_shortcode($content) . '</div>';
}
add_shortcode('one_half', 'one_half');

function one_half_last( $atts, $content = null ) {
   return '<div class="one_half lastcolumn">' . do_shortcode($content) . '</div><div class="clear"></div>';
}
add_shortcode('one_half_last', 'one_half_last');

function one_fourth( $atts, $content = null ) {
   return '<div class="one_fourth">' . do_shortcode($content) . '</div>';
}
add_shortcode('one_fourth', 'one_fourth');

function one_fourth_last( $atts, $content = null ) {
   return '<div class="one_fourth lastcolumn">' . do_shortcode($content) . '</div><div class="clear"></div>';
}
add_shortcode('one_fourth_last', 'one_fourth_last');

function three_fourth( $atts, $content = null ) {
   return '<div class="three_fourth">' . do_shortcode($content) . '</div>';
}
add_shortcode('three_fourth', 'three_fourth');

function three_fourth_last( $atts, $content = null ) {
   return '<div class="three_fourth lastcolumn">' . do_shortcode($content) . '</div><div class="clear"></div>';
}
add_shortcode('three_fourth_last', 'three_fourth_last');

function one_fifth( $atts, $content = null ) {
   return '<div class="one_fifth">' . do_shortcode($content) . '</div>';
}
add_shortcode('one_fifth', 'one_fifth');

function one_fifth_last( $atts, $content = null ) {
   return '<div class="one_fifth lastcolumn">' . do_shortcode($content) . '</div><div class="clear"></div>';
}
add_shortcode('one_fifth_last', 'one_fifth_last');

function two_fifth( $atts, $content = null ) {
   return '<div class="two_fifth">' . do_shortcode($content) . '</div>';
}
add_shortcode('two_fifth', 'two_fifth');

function two_fifth_last( $atts, $content = null ) {
   return '<div class="two_fifth lastcolumn">' . do_shortcode($content) . '</div><div class="clear"></div>';
}
add_shortcode('two_fifth_last', 'two_fifth_last');

function three_fifth( $atts, $content = null ) {
   return '<div class="three_fifth">' . do_shortcode($content) . '</div>';
}
add_shortcode('three_fifth', 'three_fifth');

function three_fifth_last( $atts, $content = null ) {
   return '<div class="three_fifth lastcolumn">' . do_shortcode($content) . '</div><div class="clear"></div>';
}
add_shortcode('three_fifth_last', 'three_fifth_last');

function four_fifth( $atts, $content = null ) {
   return '<div class="four_fifth">' . do_shortcode($content) . '</div>';
}
add_shortcode('four_fifth', 'four_fifth');

function four_fifth_last( $atts, $content = null ) {
   return '<div class="four_fifth lastcolumn">' . do_shortcode($content) . '</div><div class="clear"></div>';
}
add_shortcode('four_fifth_last', 'four_fifth_last');

function one_sixth( $atts, $content = null ) {
   return '<div class="one_sixth">' . do_shortcode($content) . '</div>';
}
add_shortcode('one_sixth', 'one_sixth');

function one_sixth_last( $atts, $content = null ) {
   return '<div class="one_sixth lastcolumn">' . do_shortcode($content) . '</div><div class="clear"></div>';
}
add_shortcode('one_sixth_last', 'one_sixth_last');

function five_sixth( $atts, $content = null ) {
   return '<div class="five_sixth">' . do_shortcode($content) . '</div>';
}
add_shortcode('five_sixth', 'five_sixth');

function five_sixth_last( $atts, $content = null ) {
   return '<div class="five_sixth lastcolumn">' . do_shortcode($content) . '</div><div class="clear"></div>';
}
add_shortcode('five_sixth_last', 'five_sixth_last');


/* By default Wordpress's wpautop and wptexturize filters inject p tags and br tags around the outputted column content which is a problem if you need your site to validate. */
function webtreats_formatter($content) {
	$new_content = '';

	/* Matches the contents and the open and closing tags */
	$pattern_full = '{(\[raw\].*?\[/raw\])}is';

	/* Matches just the contents */
	$pattern_contents = '{\[raw\](.*?)\[/raw\]}is';

	/* Divide content into pieces */
	$pieces = preg_split($pattern_full, $content, -1, PREG_SPLIT_DELIM_CAPTURE);

	/* Loop over pieces */
	foreach ($pieces as $piece) {
		/* Look for presence of the shortcode */
		if (preg_match($pattern_contents, $piece, $matches)) {

			/* Append to content (no formatting) */
			$new_content .= $matches[1];
		} else {

			/* Format and append to content */
			$new_content .= wptexturize(wpautop($piece));
		}
	}

	return $new_content;
}

// Remove the 2 main auto-formatters
remove_filter('the_content', 'wpautop');
remove_filter('the_content', 'wptexturize');

// Before displaying for viewing, apply this function
add_filter('the_content', 'webtreats_formatter', 99);
add_filter('widget_text', 'webtreats_formatter', 99);
