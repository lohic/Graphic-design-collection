<?php get_header(); ?>

<!-- page-la-carte.php -->

<content>
	
	<?php dimox_breadcrumbs(); ?>

	<?php
	
	if(have_posts()) : ?><?php while(have_posts()) : the_post(); ?>
			<div class="post" id="post-<?php the_ID(); ?>">
				<h2><?php the_title(); ?></h2>
			</div>
			
			<?php the_content();?>
			
	<?php endwhile; ?>
	<div class="navigation">
	<?php posts_nav_link(' - ','page suivante','page pr&eacute;c&eacute;dente'); ?>
	</div>
	<?php else : ?>
	<h2>Oooopppsss...</h2>
	<p>Désolé, mais vous cherchez quelque chose qui ne se trouve pas ici .</p>
	<?php include (TEMPLATEPATH . "/searchform.php"); ?>
	<?php endif; ?>

	
	<div id="map">
	</div>

	<script>
		var points = Array();
		points.push({
			x : 51.5,
			y : -0.09,
			legend : 'A pretty CSS3 popup. <br> Easily customizable.'
		});
	</script>


</content>

<!-- end page-la-carte.php -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>