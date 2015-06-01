<div id="blog-leftsidebar">
	<?php gabfire_postheader(); ?>
	
	<section class="container pagewrap">
		<div class="row">
			
			<?php
			$sidebar = '';
			if ( is_singular('portfolio') )  { 
				$sidebar = 'portfolios';
			}
			get_sidebar($sidebar); ?>
					
			<div class="col-xs-12 col-md-8 col-sm-8">
			
				<div class="gabfire_breadcrumb">
					<?php gabfire_breadcrumb(); ?>
				</div>	
						
				<?php get_template_part('loop','single'); ?>
				
			</div><!-- col-md-8 -->				
		</div>	
	</section><!-- container content-wrapper -->
</div>