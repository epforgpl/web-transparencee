<?php
$src = get_template_directory_uri();
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?> >
	<head>
		<meta charset="<?php bloginfo('charset'); ?>" />
		<title><?php
			global $page, $paged;

			wp_title('|', true, 'right');

			bloginfo('name');

			$site_description = get_bloginfo('description', 'display');
			if ($site_description && ( is_home() || is_front_page() ))
				echo " | $site_description";
			?></title>

		<link rel="stylesheet" type="text/css" media="all" href="<?php echo $src ?>/css/normalize.css" />
		<link rel="stylesheet" type="text/css" media="all" href="<?php echo $src ?>/css/foundation.min.css" />
		<link rel="stylesheet" type="text/css" media="all" href="<?php echo $src ?>/css/fonts.css" />
		<link rel="stylesheet" type="text/css" media="all" href="<?php echo $src ?>/css/jquery-ui.min.css" />
		<link rel="stylesheet" type="text/css" media="all" href="<?php echo $src ?>/style.css?v=1.04" />
		<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />
		<link rel="icon" href="<?php echo $src ?>/images/favicon.png" type="image/png"/>
		<?php
		if (is_singular() && get_option('thread_comments'))
			wp_enqueue_script('comment-reply');


		wp_head();
		?>
		<?php
		global $post;
		$posttype = get_post_type($post);
		$fbimg = get_field('facebook_image', $post->ID);
		if ($fbimg):
			?>
			<meta property="og:image" content="<?php echo $fbimg['url']; ?>" />
			<?php
		else:
			if ($posttype == 'event' || $posttype == 'project' || $posttype == 'organization'):

				$logo = get_field('logo');
				if ($logo):
					?>
					<meta property="og:image" content="<?php echo $logo['url']; ?>" />
					<?php
				endif;
			elseif ($posttype == 'person'):
				$photo = get_field('photo');
				if ($photo):
					?>
					<meta property="og:image" content="<?php echo $photo['url']; ?>" />
					<?php
				endif;
			endif;
			?>
		<?php endif; ?>
		<meta name="viewport" content="width=device-width" />
		<script src="<?php echo $src ?>/js/vendor/modernizr.js"></script>

		<link href="//cdn-images.mailchimp.com/embedcode/horizontal-slim-10_7.css" rel="stylesheet" type="text/css">
		<style type="text/css">
			#mc_embed_signup{clear:left; font:14px Helvetica,Arial,sans-serif; width:100%;}  #mc_embed_signup label { color: #fff } 
		</style>
	</head>


	<body <?php body_class(); ?> >

		<div class="topbar">
			<div class="row">
				<div class="small-12 columns text-right">				
					<div class="hamburger show-for-medium-down fright">
						<div class="line line1"></div>
						<div class="line line2"></div>
						<div class="line line3"></div>
					</div>
					<a href="https://twitter.com/Transparen_CEE" class="dblock fright social-icon ml10"><img src="<?php echo $src ?>/images/twitter.png" /></a>
					<a href="https://www.facebook.com/transparencee?fref=ts" class="dblock fright social-icon ml20"><img src="<?php echo $src ?>/images/facebook.png" /></a>

					<form method="get" action="/" class="fright searchform">
						<input type="text" placeholder="Search" value="<?php echo $_GET['s']; ?>" name="s" />
						<input type="submit" value="" />
					</form>

					<?php echo wp_nav_menu(array('theme_location' => 'primary', 'menu_class' => 'main-menu inline-list fleft show-for-large-up')); ?>
				</div>
			</div>
		</div>
