<?php
/*
Template Name: Les collections
*/
?>
<?php get_header(); ?>

<!-- page-les-collections.php -->

<content>

	<?php dimox_breadcrumbs(); ?>

	<?php
	
	if(have_posts()) : ?><?php while(have_posts()) : the_post(); ?>
		<!--<h1><?php the_title();?></h1>-->
		<div class="post_content">
		<?php the_content();?>
		</div>
	<?php endwhile; ?>

	<?php else : ?>
	<h2>Oooopppsss...</h2>
	<p>Désolé, mais vous cherchez quelque chose qui ne se trouve pas ici .</p>
	<?php include (TEMPLATEPATH . "/searchform.php"); ?>
	<?php endif; ?>

	<?php

	$paged = ( get_query_var( 'paged' ) ) ? absint( get_query_var( 'paged' ) ) : 1;

	$custom_posts = new WP_Query(array(
						'post_type'=>'collection',
						'posts_per_page'=>10,
						'paged'=>$paged,
						'orderby'=>'name',
						'order'=>'ASC',
					));
	
		
?>
		<div class="navigation">
	<?php
	$big = 999999999; // need an unlikely integer

	$pages = paginate_links( array(
            'base' 		=> str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
            'format' 	=> '?paged=%#%',
            'current' 	=> max( 1, get_query_var('paged') ),
            'total' 	=> $custom_posts->max_num_pages,
            'prev_next' => false,
            'type'  	=> 'array',
            'prev_next' => false,
			'prev_text' => __('«'),
			'next_text' => __('»'),
        ) );
        if( is_array( $pages ) ) {
            $paged = ( get_query_var('paged') == 0 ) ? 1 : get_query_var('paged');
            echo '<ul class="pagination">';
            foreach ( $pages as $page ) {
                    echo "<li>$page</li>";
            }
           echo '</ul>';
        }
	?>
	</div>

	<?php if ($custom_posts->have_posts() ):
	while ($custom_posts->have_posts()): $custom_posts->the_post(); ?>
        <article class="post" id="post-<?php the_ID(); ?>">
        	<h2><a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a></h2>
				
			<p class="postmetadata">Publiée le <?php the_time('j F Y') ?><!-- par <?php the_author() ?> --> | Cat&eacute;gorie: <?php the_category(', ') ?> <?php edit_post_link('Editer', ' &#124; ', ''); ?></p>
			
			<div class="post_content">
				<?php the_content(); ?>
			</div>
        </article>
    <?php endwhile; ?>


    <?php endif; ?>



	
	
</content>

<!-- end page-les-collections.php -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>

