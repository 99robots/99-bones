<?php
	/*
		Template Name: Contact
	*/
?>

<?php get_header(); ?>

	<div id="tpl-contact">

		<section class="row pt pb bg-white aligncenter">
			<h1 class="text-dkblue textcenter">Hire Us</h1>
			<h4 class="text-gray light italic textcenter">We're nice robots, we don't bite.</h4>
		</section>

		<section class="container pt pb mt mb">
			<div class="row">
				<div class="col-xs-12 col-md-6 col-md-offset-3 col-sm-6 col-sm-offset-3">

					<?php echo do_shortcode('[gravityform id="1" title="false" description="false"]'); ?>

				</div><!-- col-md-8 -->

			</div>
		</section><!-- container -->
	</div>

<?php get_footer(); ?>