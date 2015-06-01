<?php
	/*
		Template Name: LeftSidebar
	*/
?>

<?php get_header(); ?>

<div id="blog-leftsidebar">
	
	<section class="container pagewrap">
		<div class="row">
		
			<?php get_sidebar(); ?>
					
			<div class="col-xs-12 col-md-8 col-sm-8">
			
				<div class="gabfire_breadcrumb">
					<?php gabfire_breadcrumb(); ?>
				</div>	
						
				<?php get_template_part('loop','single'); ?>
				
			</div><!-- col-md-8 -->				
		</div>	
	</section><!-- container -->
	
</div>

<?php get_footer(); ?>