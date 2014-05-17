<?php get_header(); ?>

<content>
<?php if(have_posts()) : ?><?php while(have_posts()) : the_post(); ?>
		<article class="post" id="post-<?php the_ID(); ?>">
			<h2><a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a></h2>
				
				<p class="postmetadata"><?php the_time('j F Y') ?> par <?php the_author() ?> | Cat&eacute;gorie: <?php the_category(', ') ?> | <?php comments_popup_link('Pas de commentaires', '1 Commentaire', '% Commentaires'); ?> <?php edit_post_link('Editer', ' &#124; ', ''); ?></p>
				
				<div class="post_content">
					<?php the_excerpt(); ?>
				</div>
		</article>

<?php endwhile; ?>
<?php endif; ?>
</content>

<?php get_sidebar(); ?>
<?php get_footer(); ?>

</div><!-- fermeture div "page" -->
</body>
</html>