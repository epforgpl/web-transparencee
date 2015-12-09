<?php global $src; ?>
<section class="europe-map">
	<div class="logo-wrapper">
		<a href="<?php echo home_url(); ?>" class="zindex5"><img src="<?php echo $src ?>/images/logo.png" /></a>
	</div>
	<div class="row zindex5 penone">
		<div class="small-12 large-4 columns pt30 relative small-text-center medium-text-left">
			<div class="gradient"><img src="<?php echo $src ?>/images/logo-bg.png" /></div>
		</div>
	</div>
	<?php if (is_front_page()): ?>
	<div class="map-text">
		<h1>transparen<span>cee</span></h1>
		<div class="oneliner">Technology for Transparency in CEE and Eurasia.</div>
		<a href="<?php echo get_the_permalink(8); ?>" class="btn black-border mt25">Learn & Connect</a>
	</div>
	<?php elseif (is_singular('person')): ?>
		<div class="row zindex5">
			<div class="small-12 medium-6 large-2 columns pt80 mt60 relative end">
				<?php $img = get_field('photo'); ?>
				<img src="<?php echo $img['sizes']['medium']; ?>" alt="<?php the_title(); ?>" />
			</div>
		</div>
		<div class="row zindex5">
			<div class="small-12 medium-6 large-6 columns pt30 relative end">
				<h1><?php the_title(); ?></h1>
				<?php
						function my_posts_where2( $where )
						{
							$where = str_replace("meta_key = 'members_%_member'", "meta_key LIKE 'members_%_member'", $where);
							return $where;
						}
						add_filter('posts_where', 'my_posts_where2');

						$args = array(
							'post_type'	=> 'organization',
							'meta_query' => array(
								array(
									'key' => 'members_%_member',
									'value' => '"' . get_the_ID() . '"',
									'compare' => 'LIKE'
								)
							)
						);
				
						$the_query = new WP_Query( $args );
						?>
						<?php while ( $the_query->have_posts() ) : $the_query->the_post(); ?>
				
							<a href="<?php the_permalink(); ?>" class="oneliner"><?php the_title(); ?></a>
				
						<?php endwhile; ?>
						<?php wp_reset_postdata(); ?>
			</div>
		</div>
	<?php elseif (is_singular('organization') || is_singular('project') || is_singular('event')): ?>
		<div class="row zindex5 <?php if (is_singular('event')): ?>mt40<?php else: ?><?php endif; ?>">
			<div class="small-12 large-4 columns pt100 mt40 relative end">
				<h1 class="mb15"><?php the_title(); ?></h1>
				<div class="oneliner"><?php the_field('oneliner'); ?></div>
				<?php if (is_singular('organization')): ?>
					<a href="<?php the_field('website'); ?>" class="btn black-border mt25">Organization website</a>
				<?php elseif (is_singular('project')): ?>
					<a href="<?php the_field('website'); ?>" class="btn black-border mt25">Project website</a>
				<?php elseif (is_singular('event')): ?>
					<a href="<?php the_field('website'); ?>" class="btn black-border mt25">Event website</a>
				<?php endif; ?>
			</div>
		</div>
	<?php elseif (is_singular('news') || is_singular('article')): ?>
		<div class="row zindex5">
			<div class="small-12 large-4 columns pt100 mt40 relative end">
				<h1 class="mb15"><?php the_title(); ?></h1>
			</div>
		</div>
	<?php else: ?>
		<div class="row zindex5">
			<div class="small-12 large-4 columns pt100 mt100 relative end">
				<h1 class="mb15"><?php the_title(); ?></h1>
			</div>
		</div>
	<?php endif; ?>
		<?php $tc = get_query_var('content-type'); ?>
	
		<div class="breadcrumbs">
			<?php if ($tc != '' && $tc != 'all'): ?>
				<a href="<?php echo home_url(); ?>">transparencee</a> &GT; <?php echo $tc; ?>
			<?php elseif(is_singular('organization')): ?>
				<a href="<?php echo home_url(); ?>">transparencee</a> &GT; organization &GT; <?php the_title(); ?>
			<?php elseif(is_singular('project')): ?>
				<a href="<?php echo home_url(); ?>">transparencee</a> &GT; project &GT; <?php the_title(); ?>
			<?php elseif(is_singular('event')): ?>
				<a href="<?php echo home_url(); ?>">transparencee</a> &GT; event &GT; <?php the_title(); ?>
			<?php elseif(is_singular('news')): ?>
				<a href="<?php echo home_url(); ?>">transparencee</a> &GT; news &GT; <?php the_title(); ?>
			<?php elseif(is_singular('article')): ?>
				<a href="<?php echo home_url(); ?>">transparencee</a> &GT; analysis &GT; <?php the_title(); ?>
			<?php endif; ?>
		</div>
	<?php $svg_map = file_get_contents($src.'/images/europe2.svg'); ?>
	<div class="map-svg show-for-large-up">
		<?php echo $svg_map; ?>
	</div>

</section>