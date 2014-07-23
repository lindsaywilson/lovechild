<?php 

	/* Template Name: Posts */
	
	the_post();
	
	$cat = '-2';
	if (get_slug() === 'news') {
		$cat = '2';
	}
	
	$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
	
	$query = new WP_Query(array(
		'posts_per_page' => get_option('posts_per_page'),
		'paged' => $paged,
		'cat' => $cat
	));
	
	$entries = $query->posts;
	
	get_header();
	
?>

<div id="content">
	
	<?php get_sidebar(); ?>
	
	<?php if (get_the_content() !== '') { ?>
	<div class="box intro">
		<h1><?php the_title(); ?></h1>
		<?php the_content(); ?>
		<div class="clear"></div>
	</div>
	<?php } ?>
	
	<?php foreach ($entries as $k => $entry) {
		$first = $k === 0 ? true : false;
		echo get_box($entry, $first);
	} ?>
	
	<div id="pagination">
		<?php if ($query->max_num_pages > $paged) { ?>
		<a class="next" href="<?php echo get_permalink().'?paged='.($paged+1); ?>">Older</a>
		<?php } if ($paged > 1) { ?>
		<a class="prev" href="<?php echo get_permalink().'?paged='.($paged-1); ?>">Newer</a>
		<?php } ?>
	</div>
	
</div>

<?php get_footer(); ?>