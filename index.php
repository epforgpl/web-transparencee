<?php get_header() ?>
<?php $src = get_template_directory_uri(); ?>

<?php if ( have_posts() ): ?>
	<?php while ( have_posts() ): the_post(); ?>
		<?php	get_template_part('map'); ?>

		<?php
			$ct = get_query_var('content-type');
			if ($ct=='event') {
				$posttype = 'event';
			}
			elseif ($ct=='project') {
				$posttype = 'project';
			}
			elseif ($ct=='news') {
				$posttype = 'news';
			}
			elseif ($ct=='article') {
				$posttype = 'article';
			}
			elseif ($ct=='organization') {
				$posttype = 'organization';
			}
			else {
				$posttype = array('event','project','news','article','organization');
			}

			$country = get_query_var('country');
			$org = get_query_var('org');
			$technology = get_query_var('technology');
			$topic = get_query_var('topic');

			$terms_query = '';
			if ($country != 'all' && $country != '') {
				$terms_query[] = $country;
			}
			if ($org != 'all' && $org != '') {
				$terms_query[] = $org;
			}
			if ($technology != 'all' && $technology != '') {
				$terms_query[] = $technology;
			}
			if ($topic != 'all' && $topic != '') {
				$terms_query[] = $topic;
			}
		?>

		<section class="home-content-wrapper" id="list">
			<div class="row">
				<div class="small-12 columns text-right">
					<?php if ($ct != '' && $ct != 'all'): ?>
						<div class="sorting">
							<span>Sort by</span>
							<?php if ($ct == 'news' || $ct == 'article' || $ct == 'event'): ?>
								<?php if ($_GET['orderby']=='date' && $_GET['order']=='asc'): ?>
									<a href="?order=desc&orderby=date">Date</a> 
								<?php else: ?>
									<a href="?order=asc&orderby=date">Date</a> 
								<?php endif; ?>
							<?php endif; ?>
							<?php if ($ct != 'news'): ?>
								<?php if ($_GET['orderby']=='az' && $_GET['order']=='asc'): ?>
									<a href="?order=desc&orderby=az">AZ</a> 
								<?php else: ?>
									<a href="?order=asc&orderby=az">AZ</a> 
								<?php endif; ?>
							<?php endif; ?>
						</div>
					<?php endif; ?>
				</div>
				<div class="small-12 large-3 columns sidebar text-left filters pb30">
					<a href="#" class="open-filter">Show filters</a>
					<span class="nom uppercase show-for-large-up">Click below to filter</span>
					<div class="all-filter">
						<a href="<?php echo home_url(); ?>/content-type/<?php echo tc_get_query_var('content-type'); ?>/country/all/org/all/technology/all/topic/all/" class="<?php if (empty($terms_query)): ?>current<?php endif; ?>">All</a>
						<?php
							$terms = get_terms('filter', array('parent' => 0, 'hide_empty'=> false));
							foreach ($terms as $term):
								$j=0;
							?>
							<div class="filter-wrapper">
								<div class="filter-title">
								<?php echo $term->name; ?>
								</div>
								<div class="filter-list">
									<?php
										$chs = get_terms('filter', array('parent' => $term->term_id, 'hide_empty'=> false));
										foreach ($chs as $ch):
											$terms_query2 = $terms_query;
											$terms_query2[] = $ch->slug;
											if (is_array($terms_query2)) {
												$tax_query2 = array(
														'tax_query' => array(
														'relation' => 'AND',
														array(
															'taxonomy' => 'filter',
															'field'    => 'slug',
															'terms'    => $terms_query2,
															'operator' => 'AND'
														),
													));	
											}
											else {
												$tax_query2 = array();
											}


											$args2 = array(
													'post_type'	=> $posttype,
													'posts_per_page' => 3,
											);

											$args2 = array_merge($tax_query2,$args2);
											$query = new WP_Query( $args2 );
									?>
									<?php if ( $query->found_posts > 0): ?>
									<a href="<?php echo url_change($ch->slug,$term->slug); ?>#list" data-filter="<?php echo $ch->slug; ?>" class="<?php if (in_array($ch->slug, $terms_query)): ?>current<?php endif; ?>"><?php echo $ch->name; ?> <span class="fright">(<?php echo $query->found_posts; ?>)</span></a>
									<?php $j++; endif; ?>
								<?php endforeach; ?>
									<?php if ($j==0): ?>
									<span class="nom">no matching content</span>
									<?php endif; ?>
								</div>
							</div>
						<?php endforeach; ?>
						<h5>Type of content</h5>
						<a href="<?php echo url_change('all','content-type'); ?>#list" class="<?php if ($ct=='all' || $ct==''):?>current<?php endif; ?>">All</a>
						
						<?php
						
							if (is_array($terms_query)) {
									$tax_query3 = array('tax_query' => array(
											'relation' => 'AND',
											array(
												'taxonomy' => 'filter',
												'field'    => 'slug',
												'terms'    => $terms_query,
												'operator' => 'AND'
											),
										));					
								}
								else {
									$tax_query3 = array();
								}
								$args3 = array(
										'post_type'	=> 'event',
								);

								$args3 = array_merge($tax_query3,$args3);
								$query3 = new WP_Query( $args3 );
								$event_counter = $query3->found_posts;
								
								$args3['post_type'] = 'project';
								$query3 = new WP_Query( $args3 );
								$project_counter = $query3->found_posts;
								
								$args3['post_type'] = 'organization';
								$query3 = new WP_Query( $args3 );
								$organization_counter = $query3->found_posts;
								
								$args3['post_type'] = 'news';
								$query3 = new WP_Query( $args3 );
								$news_counter = $query3->found_posts;
								
								$args3['post_type'] = 'article';
								$query3 = new WP_Query( $args3 );
								$article_counter = $query3->found_posts;
						?>
						
						<?php if ($event_counter>0): ?><a href="<?php echo url_change('event','content-type'); ?>#list" class="<?php if ($ct=='event'):?>current<?php endif; ?>">Events<span class="fright">(<?php echo $event_counter; ?>)</span></a><?php endif; ?>
						<?php if ($project_counter>0): ?><a href="<?php echo url_change('project','content-type'); ?>#list" class="<?php if ($ct=='project'):?>current<?php endif; ?>">Projects<span class="fright">(<?php echo $project_counter; ?>)</span></a><?php endif; ?>
						<?php if ($organization_counter>0): ?><a href="<?php echo url_change('organization','content-type'); ?>#list" class="<?php if ($ct=='organization'):?>current<?php endif; ?>">Community<span class="fright">(<?php echo $organization_counter; ?>)</span></a><?php endif; ?>
						<?php if ($news_counter>0): ?><a href="<?php echo url_change('news','content-type'); ?>#list" class="<?php if ($ct=='news'):?>current<?php endif; ?>">News<span class="fright">(<?php echo $news_counter; ?>)</span></a><?php endif; ?>
						<?php if ($article_counter>0): ?><a href="<?php echo url_change('article','content-type'); ?>#list" class="<?php if ($ct=='article'):?>current<?php endif; ?>">Analysis<span class="fright">(<?php echo $article_counter; ?>)</span></a><?php endif; ?>
					</div>
				</div>
				<div class="small-12 large-9 columns large-pt10">
					<div class="search-title">
						<h2>Search results for</h2>
						<h3><?php echo $_GET['s']; ?></h3>
					</div>
					<ul class="small-block-grid-1 medium-block-grid-3">
						<?php
						
							
							if (is_array($terms_query)) {
								$tax_query = array('tax_query' => array(
										'relation' => 'AND',
										array(
											'taxonomy' => 'filter',
											'field'    => 'slug',
											'terms'    => $terms_query,
											'operator' => 'AND'
										),
									));					
							}
							else {
								$tax_query = array();
							}
							$order = array();
							if ($_GET['order']!='') {
								if ($_GET['orderby']=='az') {
									$order = array(
											'order' => $_GET['order'],
											'orderby' => 'title'
									);
								}
								elseif ($_GET['orderby']=='date') {
									if ($ct == 'event') {
										$order = array(	'meta_key' => 'date_for_sorting',
										'orderby' => 'meta_value_num',
										'order' => $_GET['order']);
									}
									else {
										$order = array(
												'order' => $_GET['order'],
												'orderby' => 'date'
										);
									}
								}
							}
							else {
								$order = array(	'meta_key' => 'is_sticky',
										'orderby' => 'meta_value',
										'order' => 'DESC');
								?>
						<?php
							}
							
							$args = array(
									'post_type'	=> $posttype,
									'posts_per_page' => 12,
									'paged' => (get_query_var('page')) ? get_query_var('page') : 1,
									'meta_query' => array(
										'relation' => 'OR',	
										array(
											'key'     => 'about',
											'value'   => $_GET['s'],
											'compare' => 'LIKE',
										),
										array(
											'key'     => 'title',
											'value'   => $_GET['s'],
											'compare' => 'LIKE',
										),
									),
							);
							
							$args = array_merge($tax_query,$args);
							$args = array_merge($args,$order);
							$query = new WP_Query( $args );
							if ($query->have_posts()): 
							while ( $query->have_posts() ) : $query->the_post();
							$img = get_field('bg_photo');
						?>
							<li>
								<div class="post-block<?php if ($img['url']!=''): ?> with-bg<?php endif; ?>" <?php if ($img['url']!=''): ?>style="background-image:url(<?php echo $img['sizes']['medium']; ?>)<?php endif; ?>">
									<a href="" class="filter-link lc-<?php echo get_post_type(); ?>"><?php echo tc_get_post_type(); ?></a>
									<div class="pb-wrapper">
										<h3><?php the_title(); ?></h3>
										<div class="excerpt"><?php echo acf_excerpt( get_field( 'about') ); ?></div>
									</div>
									<a href="<?php the_permalink(); ?>" class="btn red-border smaller mt10">learn more</a>
								</div>
							</li>
						<?php 
							endwhile; 
							else:
						?>
							No content found. Disable filters or click <a href="<?php echo home_url(); ?>" class="red">here</a> to show everything.
							<?php endif; ?>
					</ul>
					<div class="pagination">
						<?php
							$big = 999999999; 
							echo paginate_links( array(
								'base' => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
								'format' => '?page=%#%',
								'current' => max( 1, get_query_var('page') ),
								'total' => $query->max_num_pages,
								'prev_text' => '&LT;',
								'next_text' => '&GT;'
							) );
						?> 
					</div>
				</div>
			</div>
		</section>

<?php
$args['posts_per_page'] = 9999;
$args['paged'] = 1;
$query = new WP_Query( $args );
while ( $query->have_posts() ) : $query->the_post();

	$countries = wp_get_post_terms(get_the_ID(),'filter');
	foreach ($countries as $country):
		if ($country->parent == 2) {
			$couns[] = '#'.str_replace(' ','_',ucfirst($country->name)).', #'.str_replace(' ','_',ucfirst($country->name)).' *';
		}
	endforeach;
endwhile;
						wp_reset_query(); 
?>



	<?php endwhile; ?>
<?php endif; ?>


<?php get_footer() ?>
