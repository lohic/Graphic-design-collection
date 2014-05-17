<!doctype html>
<html>
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
 
	<title><?php bloginfo('name') ?><?php if ( is_404() ) : ?> &raquo; <?php _e('Not Found') ?><?php elseif ( is_home() ) : ?> &raquo; <?php bloginfo('description') ?><?php else : ?><?php wp_title() ?><?php endif ?></title>
	
	<meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>" />
	<meta name="generator" content="WordPress <?php bloginfo('version'); ?>" />
	<!-- leave this for stats -->
	<link rel="stylesheet" href="<?php bloginfo('stylesheet_url'); ?>" type="text/css" media="screen" />
	<link rel="alternate"  type="application/rss+xml" title="RSS 2.0" href="<?php bloginfo('rss2_url'); ?>" />
	<link rel="alternate"  type="text/xml" title="RSS .92" href="<?php bloginfo('rss_url'); ?>" />
	<link rel="alternate"  type="application/atom+xml" title="Atom 0.3" href="<?php bloginfo('atom_url'); ?>" />
	<link rel="pingback"   href="<?php bloginfo('pingback_url'); ?>" />
	
	<script src="//ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>
  
	<?php wp_get_archives('type=monthly&format=link'); ?>
	<?php //comments_popup_script(); // off by default ?>
	<?php wp_head(); ?>
  
</head>
<body>

<div id="page">
	<header>
		<div class='lang'>
		<?php
				languages_list();
				function languages_list(){
				    $languages = icl_get_languages('skip_missing=0'); // &orderby=code
				    if(!empty($languages)){
				    	$i = 0;
				        foreach($languages as $l){
				        	echo $i>0 ? ' / ' : '';
				            echo ' <span>';
				            if(!$l['active']) echo '<a href="'.$l['url'].'">';
				            echo substr( icl_disp_language($l['native_name'] ),0,2 );
				            if(!$l['active']) echo '</a>';
				            echo '</span>';
				            $i++;
				        }
				    }
				}
			?>
		</div>
		<h1><a href="<?php echo icl_get_home_url(); //bloginfo('url'); ?>"><?php bloginfo('name'); ?></a></h1>
		<nav><?php wp_nav_menu( array('menu' => 'Menu principal' )); ?>
		</nav>
		<?php //do_action('icl_language_selector'); ?>
		<div class="clear"></div>
	</header>
	
	<!-- end header.php -->
	