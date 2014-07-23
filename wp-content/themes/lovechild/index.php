<?php

	$query = null;
	if (is_search()) {
		$query = array(
			'Search',
			get_search_query()
		);
	}else if (is_tag()) {
		$query = array(
			'Tag',
			get_query_var('tag')
		);
	}else if (is_archive()) {
		$query = array(
			'Date',
			date('F', strtotime('1-'.get_query_var('monthnum').'-2000')).' '.get_query_var('year')
		);
	}

	get_header();

?>

<div id="content">
	
	<?php get_sidebar(); ?>
	
	<?php if (is_array($query)) { ?>
	<h1 id="query">
		<?php echo $query[0]; ?>: <span><?php echo $query[1]; ?> <a href="<?php echo home_url().'/blog'; ?>" class="close"><img src="<?php bloginfo('template_url'); ?>/images/design/close.png" alt="Close"></a></span>
	</h1>
	<?php } ?>
	
	<?php while (have_posts()) { 
		the_post(); 
		echo get_box($post, false);
	} ?>
	
</div>

<?php get_footer(); ?>