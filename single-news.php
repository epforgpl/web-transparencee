<?php get_header() ?>
<?php $src = get_template_directory_uri(); ?>

<?php if ( have_posts() ): ?>
	<?php while ( have_posts() ): the_post(); ?>
		<?php	get_template_part('map'); ?>
		<section class="content-wrapper">
			<div class="row">
				<div class="small-12 large-2 columns sidebar text-center">
					<div class="white-margin">
						<a href="javascript: history.go(-1)" class="btn grey-border smaller">&larr;&nbsp; back</a>
						<?php
							$author = get_field('author');
							$photo = get_field('photo',$author[0]);
						?>
					</div>
					<a href="<?php echo get_permalink($author[0]); ?>" class="author-box show-for-large">
						<img src="<?php echo $photo['sizes']['medium']; ?>" />
						<div class="flname"><?php echo get_the_title($author[0]); ?></div>
						
						<?php
							function my_posts_where( $where )
							{
								$where = str_replace("meta_key = 'members_%_member'", "meta_key LIKE 'members_%_member'", $where);
								return $where;
							}
							add_filter('posts_where', 'my_posts_where');

							$args = array(
								'post_type'	=> 'organization',
								'meta_query' => array(
									array(
										'key' => 'members_%_member',
										'value' => '"' . $author[0] . '"',
										'compare' => 'LIKE'
									)
								)
							);
							$the_query = new WP_Query( $args );
						?>
						<?php if ($the_query->have_posts()): ?>
							<?php while ( $the_query->have_posts() ) : $the_query->the_post(); ?>
								<?php foreach (get_field('members') as $member): ?>
									<?php if ($member['member'][0] == $author[0]): ?>
										<div class="function"><?php echo $member['function']; ?></div>
									<?php endif; ?>
								<?php endforeach; break; ?>
							<?php endwhile; ?>
							<?php wp_reset_postdata(); ?>
						<?php endif; ?>
					</a>
				</div>
				<div class="small-12 large-9 columns large-offset-1 large-pt10 content">
					<?php the_title('<h2>','</h2>'); ?>
					<?php 
						if (get_field('show_quote') == true):
					?>
					<div class="quote">
						<?php the_field('quote'); ?>
						<a href="<?php the_field('website'); ?>" class="btn red-border mt15 mb40">See original post</a>
					</div>
					<?php endif; ?>
					<?php the_field('about'); ?>
				</div>
			</div>
			
			<?php
			
				$topics = wp_get_post_terms(get_the_ID(),'filter');
				foreach ($topics as $t):
					if ($t->parent == 5) {
						$ts[] = $t->slug;
					}
				endforeach;
			
			$org = get_field('others');

			if (is_array($org)):
		?>
			<div class="content-wrapper">
				<div class="text-center">
				<a href="<?php echo get_permalink($author[0]); ?>" class="author-box hide-for-large">
						<img src="<?php echo $photo['sizes']['medium']; ?>" />
						<div class="flname"><?php echo get_the_title($author[0]); ?></div>
						
						<?php
							function my_posts_where( $where )
							{
								$where = str_replace("meta_key = 'members_%_member'", "meta_key LIKE 'members_%_member'", $where);
								return $where;
							}
							add_filter('posts_where', 'my_posts_where');

							$args = array(
								'post_type'	=> 'organization',
								'meta_query' => array(
									array(
										'key' => 'members_%_member',
										'value' => '"' . $author[0] . '"',
										'compare' => 'LIKE'
									)
								)
							);
							$the_query = new WP_Query( $args );
						?>
						<?php if ($the_query->have_posts()): ?>
							<?php while ( $the_query->have_posts() ) : $the_query->the_post(); ?>
								<?php foreach (get_field('members') as $member): ?>
									<?php if ($member['member'][0] == $author[0]): ?>
										<div class="function"><?php echo $member['function']; ?></div>
									<?php endif; ?>
								<?php endforeach; break; ?>
							<?php endwhile; ?>
							<?php wp_reset_postdata(); ?>
						<?php endif; ?>
					</a>
				</div>
				<div class="row">
					<div class="small-12 large-2 columns sidebar">
						<h2>Read<br />also</h2>
					</div>
					<div class="small-12 large-9 columns large-offset-1 large-pt10">
						<ul class="small-block-grid-1 medium-block-grid-3">
							<?php foreach ($org as $post): ?>
								<?php setup_postdata($post); ?>
								<li>
									<div class="post-block">
										<a href="" class="filter-link lc-<?php echo get_post_type(); ?>"><?php echo get_post_type(); ?></a>
										<div class="pb-wrapper">
											<h3><?php the_title(); ?></h3>
											<div class="excerpt"><?php echo acf_excerpt( get_field( 'about') ); ?></div>
										</div>
										<a href="<?php the_permalink(); ?>" class="btn red-border smaller mt10">learn more</a>
									</div>
								</li>
							<?php endforeach; ?>
							<?php wp_reset_postdata(); ?>
						</ul>
					</div>
				</div>
			</div>
			<?php else: ?>
			<?php
				$args = array(
						'post_type'	=> 'news',
						'posts_per_page' => 3,
						'tax_query' => array(
							'relation' => 'AND',
								array(
									'taxonomy' => 'filter',
									'field'    => 'slug',
									'terms'    => $ts
								),
							),
						'post__not_in' => array(get_the_ID())					
					);
					$query = new WP_Query( $args );
					
				if ($query->found_posts > 0): 
			?>
				<div class="content-wrapper">
					<div class="row">
						<div class="small-12 large-2 columns sidebar">
							<h2>Read<br />also</h2>
						</div>
						<div class="small-12 large-9 columns large-offset-1 large-pt10">
							<ul class="small-block-grid-1 medium-block-grid-3">

								<?php
										while ( $query->have_posts() ) : $query->the_post();
								?>
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
				</div>
			<?php endif; ?>
		<?php endif; ?>
		</section>
		
	<?php endwhile; ?>
<?php endif; ?>


<?php get_footer() ?>
