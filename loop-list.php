<div class="article-wrapper archive-default">

	<?php if (have_posts()) : while (have_posts()) : the_post(); ?>

		<article <?php post_class('entry archivepage'); ?>>

			<h2 class="entry-title">
				<a href="<?php the_permalink() ?>" rel="bookmark" title="<?php printf( esc_attr__( 'Permalink to %s', 'gabfire' ), the_title_attribute( 'echo=0' ) ); ?>" >
					<?php the_title(); ?>
				</a>
			</h2>

			<p class="archive_postmeta">
				<span>
					<?php
					$authorlink = '<a href="'.get_author_posts_url(get_the_author_meta( 'ID' )).'" rel="author" class="author vcard"><span class="fn">'.  get_the_author() . '</span></a>';
					$date = '<time class="published updated" datetime="'. get_the_date() . 'T' . get_the_time() .'">'. get_the_date() . '</time>&nbsp;&nbsp;';
					printf(esc_attr__('By %1$s on %2$s','gabfire'), $authorlink, $date); ?>
				</span>

				<?php the_tags('<span class="hidden-xs"><i class="fa fa-tags"></i>',', ','&nbsp;&nbsp;</span>'); ?>
				<span><i class="fa fa-folder-o"></i><?php the_category(', '); ?>&nbsp;&nbsp;</span>
				<?php edit_post_link('Edit', '<span><i class="fa fa-pencil-square-o"></i>', '</span>'); ?>
			</p>

			<?php the_excerpt(); ?>

		</article>

	<?php endwhile; else : endif; ?>

	<?php gabfire_archivepagination(); ?>

	<div class="clearfix"></div>

</div><!-- articles-wrapper -->