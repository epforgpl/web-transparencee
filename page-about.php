<?php
/*
 * Template name: About
 */
?>
<?php get_header() ?>
<?php $src = get_template_directory_uri(); ?>

<?php if ( have_posts() ): ?>
	<?php while ( have_posts() ): the_post(); ?>
		<?php	get_template_part('map'); ?>
		<section class="content-wrapper">
			<div class="row pb30">
				<div class="small-12 large-2 columns sidebar text-center">
					<h2>About</h2>
				</div>
				<div class="small-12 large-9 columns large-offset-1 large-pt10">
					<?php the_content(); ?>
				</div>
			</div>
			
				<div class="row">
					<div class="small-12 large-2 columns sidebar">
						<h2 class="smaller">Transparencee<br />is run by</h2>
					</div>
					<div class="small-12 large-9 columns large-offset-1 large-pt10">
						<?php foreach (get_field('organizations') as $org): ?>
						<div class="about-organization">
							<?php echo $org['description']; ?>
							<ul class="small-block-grid-1 medium-block-grid-3 mt20">
								<?php foreach (get_field('members',$org['organization'][0]->ID) as $member): ?>
								<li>
									<a href="" class="member-block">
										<?php 
											$photo = get_field('photo',$member['member'][0]); 
											$flname = get_the_title($member['member'][0]);
										?>
										<img src="<?php echo $photo['sizes']['thumbnail']; ?>" alt="<?php echo $flname; ?>" />
										<h3><?php echo $flname; ?></h3>
										<span><?php echo $member['function']; ?></span>
									</a>
								</li>
								<?php endforeach; ?>
							</ul>
						</div>
						<?php endforeach; ?>
					</div>
				</div>
		</section>
	<?php endwhile; ?>
<?php endif; ?>


<?php get_footer() ?>
