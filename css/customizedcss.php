<?php
function gabfire_custom_css() 
	{ ?>
		<style type="text/css" media="screen">
			.topslider {background-image:url(<?php echo of_get_option('of_introbg1');?>) }
			#watchabout {background-image:url(<?php echo of_get_option('of_plntextbg');?>) }
			#testimonials {background-image:url(<?php echo of_get_option('of_testimonialsbg');?>) }
			.awesome-logo a {color:<?php echo of_get_option('of_logocolor1');?>}
			.awesome-logo a:hover {text-decoration:none;color:<?php echo of_get_option('of_logocolor2');?>}
			#contact {background-image:url(<?php echo of_get_option('of_contactbg');?>) }
			
			<?php if ( of_get_option('of_change_primary') <> "" ) { ?>
				body {webkit-tap-highlight-color: <?php echo of_get_option('of_primarycolor'); ?>;}
				::-moz-selection,::selection,#timeline .btn,.single figure.active_member, .single figure.active_member:hover {background: <?php echo of_get_option('of_primarycolor'); ?>;}
				.featured-text h2 strong,.carousel-two .item:hover p.member-name,.singlepage_position,.resume strong,.resume h3 {color: <?php echo of_get_option('of_primarycolor'); ?>}
				#timeline .btn {background-color:<?php echo of_get_option('of_primarycolor'); ?>;border-color: <?php echo of_get_option('of_primarycolor'); ?> }	
			<?php } ?>
			
			<?php if (of_get_option('of_change_alink') == 1) { ?>
				a {color: <?php echo of_get_option('of_alink');?>}
			<?php } ?>
			
			<?php if ( of_get_option('of_change_ahover') <> "" ) { ?>
				a:hover,a:focus,a:active,a.active {color: <?php echo of_get_option('of_ahover');?>}
				#timeline .btn:hover, #timeline .btn:focus, #timeline .btn:active, #timeline .btn.active {border-color: <?php echo of_get_option('of_ahover');?>;background-color: <?php echo of_get_option('of_ahover');?>}
			<?php } ?>

			<?php if ( of_get_option('of_change_nav') <> "" ) { ?>
				#mainnav {background:<?php echo of_get_option('of_navbg'); ?>}
				#mainnav li a {color:<?php echo of_get_option('of_licolor'); ?>}
				nav .mainnav li.current_page_item > a,
				nav .mainnav li.current-cat > a, 
				nav .mainnav li.current-menu-item > a,
				nav .mainnav li.current-cat-parent > a {color:<?php echo of_get_option('of_licurrent'); ?>}
				nav .mainnav li a:hover {color:<?php echo of_get_option('of_lihover'); ?>}
				nav .mainnav li ul {border-bottom:1px solid <?php echo of_get_option('of_liulborder'); ?>;}
				nav .mainnav li ul li {background-color:<?php echo of_get_option('of_liulbg'); ?>}
				nav .mainnav li ul li a {color:<?php echo of_get_option('of_lilicolor'); ?>;font-size:13px;border:1px solid <?php echo of_get_option('of_liulborder'); ?>}
				nav .mainnav li ul li a:hover {color:<?php echo of_get_option('of_lilihover'); ?>;}
			<?php } ?>
			
			<?php		
			for ($i=1; $i <= of_get_option('of_services_count'); $i++) { 
				if (of_get_option('of_changecolor'.$i) == 1) {
				?>	
				.carousel-one .color<?php echo $i; ?> {background:<?php echo of_get_option('of_color'.$i); ?>}
				.carousel-one .color<?php echo $i; ?>:after {border-top-color:<?php echo of_get_option('of_color'.$i); ?>}
				<?php
				}
			} ?>			
			
			<?php		
			for ($i=1; $i <= of_get_option('of_skills_count'); $i++) { 
				if (of_get_option('of_skillcolor_1') == 1) {
				?>	
				.skill<?php echo $i; ?> .skillbar-title {background:<?php echo of_get_option('of_skilltitlecolor_'.$i); ?>}
				.skill<?php echo $i; ?> .skillbar-bar {background:<?php echo of_get_option('of_skillbarcolor_'.$i); ?>}
				<?php
				}
			} ?>			
		</style>
	<?php
	}
	
	add_action( 'wp_head', 'gabfire_custom_css' );