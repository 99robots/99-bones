<?php
/* Single Post, Page and Custom Post Loop */

/* Post layout was called in single.php
 * define media width/height based on post layout
 */

 global $post_layout;
	/* Call user defined post template */
	if ( ($post_layout == 'fullwidth')  or (is_page_template('tpl-fullwidth.php')) )
	{
		$name = 'post-nosidebar';
		$media_width = 1030;
		$media_height = 480;
		$media_name = 'single-fullwidth';
	} else {
		$name = 'post-sidebar';
		$media_width = 700;
		$media_height = 380;
		$media_name = 'single';
	} ?>

<div class="article-wrapper">
	<?php
	if (have_posts()) : while (have_posts()) : the_post();
	$disable_postslider = get_post_meta($post->ID, 'disable_postslider', true);
	$disable_feaimage = get_post_meta($post->ID, 'post_feaimage', true);
	?>
		<article <?php post_class('entry'); ?>>

<!--
			<?php if(is_page()) { ?>
				<h1 class="entry-title"><?php the_title(); ?></h1>
			<?php } ?>
-->

			<h1 class="entry-title"><?php the_title(); ?></h1>


			<?php
			if ( $disable_postslider !== 'true') {
				if ( is_singular(array ('post','page') ) ) {
					gabfire_innerslider();
				} elseif ( is_singular('portfolio') ) {
					get_template_part( 'inc/portfolio-gallery-default', '' );
					echo '<div class="add-some-space"></div>';
				}
			}

			$enablevideo = 1;

			if (of_get_option('of_autoimage') == 1) {
				if ($disable_feaimage == 'true') {
					$enableimage = 0;
					$enablevideo = 0;
				} else {
					$enableimage = 1;
				}
			} else {
				$enableimage = 0;
			}

			gabfire_media(array(
				'name' => $name,
				'imgtag' => 1,
				'link' => 0,
				'enable_video' => 1,
				'video_id' => 'postfull',
				'enable_thumb' => $enableimage,
				'resize_type' => 'w',
				'media_width' => $media_width,
				'media_height' => $media_height,
				'thumb_align' => 'aligncenter',
				'enable_default' => 0
			));
			?>

			<?php
				$subtitle = get_post_meta($post->ID, 'subtitle', true);
				if ($subtitle != '') {
					echo "<p class='subtitle'>$subtitle</p>";
				}

				// Display edit post link to site admin
				edit_post_link(__('Edit This Post','gabfire'),'<p>','</p>');

				echo '<div class="entry-content">'; the_content(); echo '</div>';

				// Display pagination
				$args = array(
					'before'           => '<p class="post-pagination">' . __('<strong>Pages:</strong>','gabfire'),
					'after'            => '</p>',
					'link_before'      => '<span>',
					'link_after'       => '</span>',
					'next_or_number'   => 'number',
					'nextpagelink'     => __('Next page', 'gabfire'),
					'previouspagelink' => __('Previous page', 'gabfire'),
					'pagelink'         => '%',
					'echo'             => 1
				);

				wp_link_pages($args);

				if( 'post' == get_post_type() ) { ?>
					<div class="single_postmeta">
						<?php echo get_avatar( get_the_author_email(), '32' ); ?>
						<p>
							<?php
							$title = '<strong class="entry-title">'.get_the_title().'</strong>';
							$authorlink = '<a href="'.get_author_posts_url(get_the_author_meta( 'ID' )).'" rel="author" class="author vcard"><span class="fn">'.  get_the_author() . '</span></a>';
							$date = '<time class="published updated" datetime="'. get_the_date() . 'T' . get_the_time() .'">'. get_the_date() . '</time>';

							printf(esc_attr__('%1$s added by %2$s on %3$s','gabfire'), $title, $authorlink, $date); ?>
							<br />
							<a class="block" href="<?php echo get_author_posts_url( get_the_author_meta( 'ID' ) ); ?>">
								<?php printf( __( 'View all posts by %s &rarr;', 'journey' ), get_the_author() ); ?>
							</a>
						</p>
					</div>
				<?php }

				// Post/Page Widget
				if ('page' == get_post_type()) {
					gabfire_dynamic_sidebar('PageWidget');
				} elseif ('post' == get_post_type()) {
					gabfire_dynamic_sidebar('PostWidget');
				}
				?>

		</article>



		<?php if(!is_page()) { comments_template(); } ?>



	<?php endwhile; else : endif; ?>

	<?php if (is_page_template('tpl-archives.php')) { ?>
		<article <?php post_class('entry'); ?>>
		<?php the_content(); ?>

		<?php
	   // This is where loop for archives list starts
		$cats = get_categories();
		foreach ($cats as $cat) {
		query_posts('cat='.$cat->cat_ID);
		?>
			<div class="widget">
			<h4><?php echo $cat->cat_name; ?></h4>
			<ul>
				<?php while (have_posts()) : the_post(); ?>
				<li><a href="<?php the_permalink() ?>"><?php the_title(); ?></a> - (<?php echo $post->comment_count ?>)</li>
				<?php endwhile;  ?>
			</ul>
			</div>
		<?php } ?>
		</article>
	<?php } ?>
		<div class="clearfix"></div>
	</div><!-- articles-wrapper -->