<?php 
	get_header(); 

	if((of_get_option('of_2col') <> '' && is_category(explode(',', of_get_option('of_2col'))))
		or (of_get_option('of_2col_full') <> '' && is_category(explode(',', of_get_option('of_2col_full'))))) {
		get_template_part( 'archive', '2col' );
	}
	
	elseif( ((of_get_option('of_3col') <> '' && is_category(explode(',',of_get_option('of_3col')))))
		or (of_get_option('of_3col_full') <> '' && is_category(explode(',', of_get_option('of_3col_full'))))) {
		 get_template_part( 'archive', '3col' );
	}

	elseif( (of_get_option('of_4col') <> '' && is_category(explode(',', of_get_option('of_4col'))))
		or (of_get_option('of_4col_full') <> '' && is_category(explode(',', of_get_option('of_4col_full'))))) {
		get_template_part( 'archive', '4col' );
	}
		
	elseif(of_get_option('of_w_slider') <> '' && is_category(explode(',', of_get_option('of_w_slider')))) {
		get_template_part( 'archive', 'portfolio' );
	}
		
	else {
		get_template_part( 'archive', 'default' );
	}
	
	get_footer();