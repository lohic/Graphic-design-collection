<?php get_header(); ?>

<!-- page.php -->

<content>

	<?php dimox_breadcrumbs(); ?>

	<?php if(have_posts()) : ?><?php while(have_posts()) : the_post(); ?>
			<article class="post" id="post-<?php the_ID(); ?>">
				<h2><?php the_title(); ?></h2>				
					<div class="post_content">
						<?php the_content(); ?>
					</div>
			</article>
	
	<?php endwhile; ?>
	<?php else : ?>
	<h2>Oooopppsss...</h2>
	<p>Désolé, mais vous cherchez quelque chose qui ne se trouve pas ici .</p>
	<?php include (TEMPLATEPATH . "/searchform.php"); ?>
	<?php edit_post_link('Modifier cette page', '<p>', '</p>'); ?>
	<?php endif; ?>
</content>

<!-- end page.php -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>