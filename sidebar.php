<nav class="sidebar">
	<ul>
		<?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar() ) : ?>
		<li id="search"><?php include(TEMPLATEPATH . '/searchform.php'); ?></li>
		<li><a href="feed:<?php bloginfo('rss2_url'); ?>">Articles (RSS)</a></li>
	
	<?php endif; ?>
	</ul>
</nav>