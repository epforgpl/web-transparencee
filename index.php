<?php get_header() ?>
<?php $src = get_template_directory_uri(); ?>


<?php if ( have_posts() ): ?>
	<?php while ( have_posts() ): the_post(); ?>

	<?php endwhile; ?>
<?php endif; ?>

<?php get_footer() ?>
