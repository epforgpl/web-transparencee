<?php get_header() ?>
<?php $src = get_template_directory_uri(); ?>

<?php if ( have_posts() ): ?>
	<?php while ( have_posts() ): the_post(); ?>
		<?php	get_template_part('map'); ?>
		<section class="content-wrapper">
			<div class="row">
				<div class="small-12 large-2 columns sidebar text-center">
					<h2>About<br />event</h2>
					<div class="white-margin mt15">
						<a href="" class="btn grey-border smaller">&larr;&nbsp; back</a>
					</div>
				</div>
				<div class="small-12 large-9 columns large-offset-1 large-pt10">
					<?php $img = get_field('logo'); ?>
                                        <?php if ($img['url']!=''): ?>
                                                <img src="<?php echo $img['sizes']['medium']; ?>" alt="Logo - <?php the_title(); ?>" class="mb50" />
                                        <?php endif; ?>

					<?php the_field('about'); ?>
					<a href="<?php the_field('website'); ?>" class="btn red-border mt20">Event website</a>
				</div>
			</div>
			<?php
				$org = get_field('organizers');
				
				if (is_array($org)):
			?>
				<div class="row mt70">
					<div class="small-12 large-2 columns sidebar">
						<h2>Organizers</h2>
					</div>
					<div class="small-12 large-9 columns large-offset-1 large-pt10">
						<ul class="small-block-grid-1 medium-block-grid-3">
							<?php foreach ($org as $post): ?>
							<?php setup_postdata($post); ?>
							<li>
								<div class="post-block">
									<?php $img = get_field('logo'); ?>
									<a href="<?php the_permalink(); ?>" class=""><img src="<?php echo $img['sizes']['medium']; ?>" alt="<?php the_title(); ?>" /></a>
								</div>
							</li>
							<?php endforeach; ?>
							<?php wp_reset_postdata(); ?>
						</ul>
					</div>
				</div>
			<?php endif; ?>
			
			<?php
				$org = get_field('speakers');
				
				if (is_array($org)):
			?>
			<div class="row mt70">
				<div class="small-12 large-2 columns sidebar">
					<h2>Speakers</h2>
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
								<span><?php echo $member['session']; ?></span>
							</a>
						</li>
						<?php endforeach; ?>
					</ul>
				</div>
			</div>
		<?php endif; ?>
		</section>
			<?php
				$org = get_field('others');
				
				if (is_array($org)):
			?>
		<section class="others-wrapper">
			<div class="content-wrapper">
				<div class="row">
					<div class="small-12 large-2 columns sidebar">
						<h2>Other<br />events</h2>
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
		'post_type'	=> 'event',
		'posts_per_page' => 3,
		'post__not_in' => array(get_the_ID())
);

$query = new WP_Query( $args );
if ($query->found_posts > 0): 

?>
	<section class="others-wrapper">
		<div class="content-wrapper">
			<div class="row">
				<div class="small-12 large-2 columns sidebar">
					<h2>Other<br />events</h2>
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
