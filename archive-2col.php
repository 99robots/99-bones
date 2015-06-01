  <?php if(of_get_option('of_2col') <> '' && is_category(explode(',', of_get_option('of_2col')))) { ?>
				
	<div id="blog-default">
		
		<section class="container pagewrap">
			<div class="row">
				<div class="col-xs-12 col-md-8 col-sm-8">
					<div class="gabfire_breadcrumb">
						<?php gabfire_breadcrumb(); ?>
					</div>					

					<?php get_template_part('loop', '2col'); ?>
					
				</div><!-- col-md-8 -->
				
				<?php get_sidebar(); ?>
				
			</div>	
		</section><!-- container pagewrap -->
		
	</div>

<?php } else { ?>

	<div id="blog-fullwidth">
		
		<section class="container pagewrap">
			<div class="row">
				<div class="col-xs-12 col-md-12 col-sm-12">
				
					<div class="gabfire_breadcrumb">
						<?php gabfire_breadcrumb(); ?>
					</div>

					<?php get_template_part('loop', '2col'); ?>

				</div><!-- col-md-12 -->

			</div>	
		</section><!-- container content-wrapper -->
	</div>
	
<?php } ?>