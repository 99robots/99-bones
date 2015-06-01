<?php
	get_header();

		global $wp_query;
		/* post template defined on custom fields? */
		$post_layout = get_post_meta($wp_query->post->ID, 'gabfire_post_template', true);
		wp_reset_query();

		/* Call user defined post template */
		if ($post_layout == 'bigpicture') {
			get_template_part( 'single', 'bigpicture' );

		} elseif ($post_layout == 'fullwidth') {
			get_template_part( 'single', 'fullwidth' );

		} elseif ($post_layout == 'leftsidebar') {
			get_template_part( 'single', 'leftsidebar' );

		} elseif ($post_layout == 'portfolio') {
			get_template_part( 'single', 'portfolios' );

		} elseif ($post_layout == 'narrow') {
			get_template_part( 'single', 'narrow' );

/*
		} elseif ($post_layout == 'plugin') {
			get_template_part( 'single', 'plugin' );
			
*/
		} else { 
			get_template_part( 'single', 'default' );
		}

	get_footer();