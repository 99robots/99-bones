<?php get_header(); ?>

<div id="blog-default">
	<section class="container pagewrap">
		<div class="row">
			<div class="col-xs-12 col-md-8 col-sm-8 panelwrap">
			
<!--
				<div class="gabfire_breadcrumb">
					<?php gabfire_breadcrumb(); ?>
				</div>
-->
				
				<?php get_template_part('loop','single'); ?>
				
			</div><!-- col-md-8 -->
			
			<?php get_sidebar(); ?>
			
		</div>	
	</section><!-- container content-wrapper -->
</div>

<?php get_footer(); ?>