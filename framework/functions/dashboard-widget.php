<?php
function gabfire_dashboard_widget_function() {
     $rss = fetch_feed( "http://feeds.feedburner.com/gabfirethemes" );
 
     if ( is_wp_error($rss) ) {
          if ( is_admin() || current_user_can('manage_options') ) {
               echo '<p><strong>';
               echo $rss->get_error_message();
               echo '</strong></p>';
          }
     return;
}
 
if ( !$rss->get_item_quantity() ) {
     echo '<p>Gabfire Themes!</p>';
     $rss->__destruct();
     unset($rss);
     return;
}
 
echo "<ul>\n";
 
if ( !isset($items) )
     $items = 3;
 
     foreach ( $rss->get_items(0, $items) as $item ) {
          $link = '';
          $content = '';
		  $date = '';
		  $title = '';
		  $title = strip_tags( $item->get_title() );
		  $date = strip_tags( $item->get_date('M j Y') );
          $link = esc_url( strip_tags( $item->get_link() ) );
 
          $content = $item->get_content();
          $content = wp_html_excerpt($content, 300) . ' ...';
 
         echo "<li><a class='rsswidget' href='$link'>$title</a> <span class='rss-date'>$date</span> <div class='rssSummary'>$content</div></li>\n";
}
echo "</ul>\n";
$rss->__destruct();
unset($rss);
} 
function gabfire_add_dashboard_widgets() {
	wp_add_dashboard_widget('gabfire_dashboard_widget', 'Gabfire Themes Blog', 'gabfire_dashboard_widget_function');	
} 
add_action('wp_dashboard_setup', 'gabfire_add_dashboard_widgets' );