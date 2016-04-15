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
					<?php $img = get_field('logo'); ?>
					<?php if ($img['url']!=''): ?>
						<img src="<?php echo $img['sizes']['medium']; ?>" alt="Logo - <?php the_title(); ?>" class="mb30" /><br />
					<?php endif; ?>
					<?php the_field('about'); ?>
					<a href="<?php the_field('website'); ?>" class="btn red-border mt20">Organization website</a>
				</div>
			</div>
			
			<?php
				$org = get_field('members');

				if (is_array($org)):
			?>
			<div class="row mt70">
				<div class="small-12 large-2 columns sidebar">
					<h2>Members</h2>
				</div>
				<div class="small-12 large-9 columns large-offset-1 large-pt10">
					<ul class="small-block-grid-1 medium-block-grid-3">
						<?php foreach ($org as $member): ?>
						<li>
							<a href="<?php echo get_permalink($member['member'][0]); ?>" class="member-block">
								<?php 
									$photo = get_field('photo',$member['member'][0]); 
									$flname = get_the_title($member['member'][0]);
								?>
								<img src="<?php echo $photo['sizes']['medium']; ?>" alt="<?php echo $flname; ?>" />
								<h3><?php echo $flname; ?></h3>
								<span><?php echo $member['function']; ?></span>
							</a>
						</li>
						<?php endforeach; ?>
					</ul>
				</div>
			</div>
			<?php endif; ?>
			<?php
						$args = array(
							'post_type'	=> 'project',
							'meta_query' => array(
								array(
									'key' => 'deployed_by',
									'value' => '"' . get_the_ID() . '"',
									'compare' => 'LIKE'
								)
							)
						);

						// get results
						$the_query = new WP_Query( $args );
						?>
			<?php if ($the_query->have_posts()):?>
			<div class="row mt40">
				<div class="small-12 large-2 columns sidebar">
					<h2>Projects</h2>
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
			<?php
						$args = array(
							'post_type'	=> 'event',
							'meta_query' => array(
								array(
									'key' => 'organizers',
									'value' => '"' . get_the_ID() . '"',
									'compare' => 'LIKE'
								)
							)
						);

						// get results
						$the_query = new WP_Query( $args );
						?>
			<?php if ($the_query->have_posts()) :?>
			<div class="row mt40">
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
		<?php
			$countries = wp_get_post_terms(get_the_ID(),'filter');
			foreach ($countries as $country):
				if ($country->parent == 2) {
					$couns[] = $country->slug;
				}
			endforeach;
		
			$org = get_field('others');

			if (is_array($org)):
		?>
		<section class="others-wrapper">
			<div class="content-wrapper">
				<div class="row">
					<div class="small-12 large-2 columns sidebar">
						<h2>Others</h2>
					</div>
					<div class="small-12 large-9 columns large-offset-1 large-pt10">
						<ul class="small-block-grid-1 medium-block-grid-3">
							<?php foreach ($org as $post): ?>
								<?php setup_postdata($post); ?>
								<li>
									<div class="post-block">
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
		</section>

		<?php else: ?>
		<?php
				$args = array(
					'post_type'	=> 'organization',
					'posts_per_page' => 3,
					'tax_query' => array(
						'relation' => 'AND',
							array(
								'taxonomy' => 'filter',
								'field'    => 'slug',
								'terms'    => $couns
							),
						),
						'post__not_in' => array(get_the_ID())						
				);
				$query = new WP_Query( $args );
				if ($query->found_posts > 0): 
		?>
			<section class="others-wrapper">
				<div class="content-wrapper">
					<div class="row">
						<div class="small-12 large-2 columns sidebar">
							<h2>Others</h2>
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
			</section>
			<?php endif; ?>
		<?php endif; ?>
	<?php endwhile; ?>
<?php endif; ?>


<?php get_footer() ?>
