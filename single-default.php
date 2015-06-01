<div id="blog-default">
	<?php/*  gabfire_postheader();  */?>

	<section class="container pagewrap">
		<div class="row">
			<div class="col-xs-12 col-md-8 col-sm-8 panelwrap">

				<?php get_template_part('loop','single'); ?>

			</div><!-- col-md-8 -->

			<?php
			$sidebar = '';
			if ( is_singular('portfolio') )  {
				$sidebar = 'portfolios';
			}
			get_sidebar($sidebar); ?>

		</div>
	</section><!-- container pagewrap -->
</div>