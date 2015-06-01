<?php
	/*
		Template Name: Blog
	*/
?>

<?php get_header(); ?>

	<div id="blog-default">

		<section class="container pagewrap">
			<div class="row">
				<div class="col-xs-12 col-md-8 col-sm-8">

					<?php
					if ( get_query_var( 'paged') ) {
						$paged = get_query_var( 'paged' );
					} elseif ( get_query_var( 'page') ) {
						$paged = get_query_var( 'page' );
					} else {
						$paged = 1;
					}

					$args = array(
						'post_type' => 'post',
						'paged' => $paged,
						'posts_per_page' => 5
					);

					query_posts( $args );
					get_template_part('loop', 'default');
					?>

				</div><!-- col-md-8 -->

				<?php get_sidebar(); ?>

			</div>
		</section><!-- container content-wrapper -->
	</div>

<?php get_footer(); ?>