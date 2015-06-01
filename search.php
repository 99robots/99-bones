<?php get_header(); ?>

<div id="blog-fullwidth">
	<section class="container pagewrap">
		<div class="row">

			<div class="col-md-5 col-md-offset-4">
				<?php get_search_form(); ?>
			</div>

			<div class="col-md-8 col-md-offset-2">

				<?php $my_searchterm = trim(esc_html($s)); ?>
				<h2 class="mt50 textcenter"><?php _e('Search Results for ');?>'<?php echo $my_searchterm;?>'</h2>

				<?php
				get_template_part('loop', 'list');
				?>
				<div class="clearfix"></div>
			</div><!-- col-md-12 -->

		</div>
	</section><!-- container -->
</div>


<?php get_footer(); ?>