<?php get_header(); ?>

<!-- single-collection.php -->

<content>
	<?php if(have_posts()) : ?><?php while(have_posts()) : the_post(); ?>
			<article id="post-<?php the_ID(); ?>">
				<?php dimox_breadcrumbs(); ?>

				<h1><?php the_title(); ?></h1>				
					<div class="post_content">
						<p class="url"><a href="<?php the_field('collection_url');?>"><?php the_field('collection_url');?></a></p>
						<?php //the_content(); ?>
						<?php the_field('collection_description');?>
						<address>
						<p><?php the_field('collection_adresse');?></p>
						<p><?php the_field('collection_telephone');?></p>
						<p><?php the_field('collection_fax');?></p>
						<p><a href="<?php the_field('collection_email');?>"><?php the_field('collection_email');?></a></p>
						</address>
						<ol>
						<?php while(the_repeater_field('collection_administrator')): ?>
							<li>
								<ul>
									<li><?php the_sub_field('col_admin_name');?></li>
									<li><?php the_sub_field('col_admin_title');?></li>
									<li><a href="mailto:<?php the_sub_field('col_admin_mail');?>"><?php the_sub_field('col_admin_mail');?></a></li>
									<li><?php the_sub_field('col_admin_role');?></li>
								</ul>
							</li>
						<?php endwhile; ?>
						</ol>
					</div>
			</article>
	
	<?php endwhile; ?>
	<?php else : ?>
	<h2>Oooopppsss...</h2>
	<p>Désolé, mais vous cherchez quelque chose qui ne se trouve pas ici.</p>
	<?php include (TEMPLATEPATH . "/searchform.php"); ?>
	<?php edit_post_link('Modifier cette page', '<p>', '</p>'); ?>
	<?php endif; ?>
</content>

<!-- end single-collection.php -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>