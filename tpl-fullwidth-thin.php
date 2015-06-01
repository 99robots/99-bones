<?php
	/*
		Template Name: FullWidth Thin
	*/
?>

<?php get_header(); ?>

<div id="blog-fullwidth">
	<section class="container pagewrap">
		<div class="row">
			<div class="col-md-10 col-md-offset-1">

				<div class="gabfire_breadcrumb">
					<?php gabfire_breadcrumb(); ?>
				</div>

				<?php get_template_part('loop','single'); ?>

			</div><!-- col-md-12 -->

		</div>
	</section><!-- container -->
</div>


<?php get_footer(); ?>