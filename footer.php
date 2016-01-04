<?php $src = get_template_directory_uri(); global $couns; ?>

	<div class="footer-logos">
		<div class="row">
			<div class="small-12 large-6 columns large-offset-3 end">
				<ul class="small-block-grid-1 medium-block-grid-3 text-center">
					<li>
						<a href="http://transparencee.org/organization/epanstwo-foundation/"><img src="<?php echo $src ?>/images/epanstwo.png" /></a>
					</li>
					<li>
						<a href="http://transparencee.org/organization/techsoup-europe/"><img src="<?php echo $src ?>/images/techsoup-footer.png" /></a>
					</li>
					<li>
						<a href="http://transparencee.org/organization/why-not/"><img src="http://transparencee.org/wp-content/uploads/2015/09/zastone_color.png" /></a>
					</li>
				</ul>
			</div>
		</div>
		<div class="row">
			<div class="small-12 large-6 columns large-offset-3 end pt20">
				<div class="text-center">
				<a href="http://www.state.gov/"><img src="<?php echo $src ?>/images/usa-flag.jpg" /></a><br /><br />
				<a href="http://www.state.gov/">The project is possible thanks to the generosity<br />of the U. S. Department of State</a>
				</div>
			</div>
		</div>
	</div>
	<div class="footer">
		<div class="row text-center">
			<div class="small-12 columns">
				<?php echo wp_nav_menu( array('theme_location' => 'primary', 'menu_class' => 'footer-menu inline-list') ); ?>
			</div>
			<div class="small-12 columns pt25">
				<a href="<?php echo home_url(); ?>"><img src="<?php echo $src ?>/images/logo-footer.png" alt="Logo" /></a>
			</div>
		</div>
	</div>


	<div class="mobile-overlay text-center">
		<?php wp_nav_menu(array('theme_location' => 'primary', 'menu_class' => 'text-center mobile-menu')); ?><div class="row icons">
	</div>
		
  <script src="<?php echo $src ?>/js/vendor/jquery.js"></script>
	<script src="<?php echo $src ?>/js/vendor/fastclick.js"></script>
  <script src="<?php echo $src ?>/js/foundation.min.js"></script>
  <script src="<?php echo $src ?>/js/jquery-ui.min.js"></script>
  <script src="<?php echo $src ?>/js/jquery.dotdotdot.min.js"></script>
  <script>
		$(document).foundation();
  </script>
  <script src="<?php echo $src ?>/js/main.js"></script>
	
	<style>
		<?php if (is_array($couns)): ?>
			<?php echo join(',',$couns); ?> {
				fill:#91dccc;
			}
		<?php endif; ?>
		
		
		<?php
			$current = str_replace(' ','_',ucfirst(get_query_var('country')));
			if ($current != 'all' && $current != ''):
		?>
		#<?php echo $current; ?>, #<?php echo $current; ?> * {
			fill:#91dccc;
		}
		<?php endif; ?>
		
		<?php 
			global $post;
			$countries = wp_get_post_terms($post->ID,'filter');
			foreach ($countries as $country):
				if ($country->parent == 2): 
		?>
			#<?php echo str_replace(' ','_',ucfirst($country->name)); ?>, #<?php echo str_replace(' ','_',ucfirst($country->name)); ?> * {
				fill:#91dccc;
			}
			<?php endif; ?>
		<?php endforeach; ?>
			
		<?php
			$ct = get_query_var('content-type');
			if ($ct=='event') {
				$menuitem = '114';
			}
			elseif ($ct=='project') {
				$menuitem = '115';
			}
			elseif ($ct=='news') {
				$menuitem = '117';
			}
			elseif ($ct=='article') {
				$menuitem = '118';
			}
			elseif ($ct=='organization') {
				$menuitem = '116';
			}
			else {
				$menuitem = '';
			}
			if ($menuitem!=''):
		?>
		.main-menu  .menu-item-<?php echo $menuitem; ?> a {
			background:#fff;
			color:#5c74b8;
		}
		<?php else: ?>
			.main-menu .current_page_item a {
				background:#fff;
				color:#5c74b8;
			}
		<?php endif; ?>
			
			#Poland:after {
				content:"10 organizations";
				display:block;
				position:absolute;
				left:80%;
				top:50%;
			}
	</style>
	
	
	<script>
		$('#Bosnia_and_Herzegovina,#Montenegro,#Moldova,#Estonia,#Latvia,#Lithuania,#Poland,#Belarus,#Ukraine,#Azerbaijan,#Armenia,#Turkey,#Romania,#Slovakia,#Czech_Republic,#Hungary,#Slovenia,#Croatia,#Albania,#Macedonia,#Bulgaria,#Cyprus,#Russia').on('click',
		function() {
			location.href = '<?php echo home_url().'/content-type/'.tc_get_query_var('content-type').'/country/'; ?>' + $(this).attr('id').toLowerCase() + '<?php echo '/org/'.tc_get_query_var('org').'/technology/'.tc_get_query_var('technology').'/topic/'.tc_get_query_var('topic').'/'; ?>';
		});
		
		<?php
			$chs = get_terms('filter', array('parent' => 2, 'hide_empty'=> false));
			foreach ($chs as $ch):
				$args2 = array(
						'post_type'	=> 'organization',
						'posts_per_page' => 3,
						'tax_query' => array(
							'relation' => 'AND',
							array(
								'taxonomy' => 'filter',
								'field'    => 'slug',
								'terms'    => $ch->slug,
								'operator' => 'AND'
							),
						),				
				);
				$query = new WP_Query( $args2 );
				
				if ( $query->found_posts == 0) {
					$orgs = '0 organizations';
				}
				elseif ( $query->found_posts == 1) {
					$orgs = '1 organization';
				}
				else {
					$orgs = $query->found_posts.' organizations';
				}
		?>
		$('#<?php echo ucwords($ch->slug); ?>').attr('title','<?php echo ucwords($ch->name); ?>');
		<?php endforeach; ?>
		
		<?php if ($menuitem != ''): ?>
			$('.menu-item-29').removeClass('current-menu-item, current_page_item');
		<?php endif; ?>
	</script>
	

	
<?php
	wp_footer();
?>



</body>
</html>
