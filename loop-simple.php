<div class="article-wrapper archive-default">

	<?php if (have_posts()) : while (have_posts()) : the_post(); ?>

		<article <?php post_class('entry'); ?>>
			<?php the_content(); ?>
		</article>

	<?php endwhile; else : endif; ?>

	<div class="clearfix"></div>

</div><!-- articles-wrapper -->