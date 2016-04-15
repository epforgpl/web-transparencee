<?php get_header() ?>
<?php $src = get_template_directory_uri(); ?>

<?php if ( have_posts() ): ?>
	<?php while ( have_posts() ): the_post(); ?>
		<?php	get_template_part('map'); ?>
		<section class="content-wrapper">
			<div class="row">
				<div class="small-12 large-2 columns sidebar text-center">
					<h2>About</h2>
					<div class="white-margin mt15">
						<a href="javascript: history.go(-1)" class="btn grey-border smaller">&larr;&nbsp; back</a>
					</div>
				</div>
				<div class="small-12 large-9 columns large-offset-1 large-pt10 content">
					<?php the_field('about'); ?>
					<?php if (get_field('twitter')!=''): ?>
						<a href="https://twitter.com/<?php the_field('twitter'); ?>" class="btn red-border mt20">Follow on Twitter</a>
					<?php endif; ?>
				</div>
			</div>
			<?php
				function my_posts_where( $where )
				{
					$where = str_replace("meta_key = 'speakers_%_member'", "meta_key LIKE 'speakers_%_member'", $where);
					return $where;
				}
				add_filter('posts_where', 'my_posts_where');

				$args = array(
					'post_type'	=> 'event',
					'meta_query' => array(
						array(
							'key' => 'speakers_%_member',
							'value' => '"' . get_the_ID() . '"',
							'compare' => 'LIKE'
						)
					)
				);
				$the_query = new WP_Query( $args );
			?>
			<?php if ($the_query->have_posts()): ?>
			<div class="row mt70">
				<div class="small-12 large-2 columns sidebar">
					<h2>Events</h2>
				</div>
				<div class="small-12 large-9 columns large-offset-1 large-pt10">
					<ul class="small-block-grid-1 medium-block-grid-3">
						
						<?php while ( $the_query->have_posts() ) : $the_query->the_post(); ?>
						<li>
							<div class="post-block">
								<div class="pb-wrapper">
									<h3><?php the_title(); ?></h3>
									<div class="excerpt"><?php echo acf_excerpt( get_field( 'about') ); ?></div>
								</div>
								<a href="<?php the_permalink(); ?>" class="btn red-border smaller mt10">learn more</a>
							</div>
						</li>
						<?php endwhile; ?>
						<?php wp_reset_postdata(); ?>
					</ul>
				</div>
			</div>
			<?php endif; ?>
		</section>
	<?php endwhile; ?>
<?php endif; ?>


<?php get_footer() ?>
