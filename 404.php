<?php get_header(); ?>

<div id="blog-fullwidth">
	<section class="container pagewrap">
		<div class="row">
			<div class="col-md-12">
				<div class="row">
					<div class="col-md-5 col-md-offset-1">
						<h2>404 - <?php _e('Page Not Found'); ?></h2>
						<p><?php _e('Oops, looks like we gave you the wrong link. Try searching for what you were looking for instead.'); ?></p>
					</div>
					<div class="col-md-5 pt30">
						<?php get_search_form(); ?>
					</div>
				</div>

				<h2 class="mt50 textcenter"><?php _e('Recent Blog Posts'); ?></h2>

				<?php
				$args = array(
					'post_type' => 'post',
					'paged' => $paged,
					'posts_per_page' => 9
				);

				query_posts( $args );
				get_template_part('loop', '3col');
				?>
				<div class="clearfix"></div>
			</div><!-- col-md-12 -->

		</div>
	</section><!-- container -->
</div>


<?php get_footer(); ?>