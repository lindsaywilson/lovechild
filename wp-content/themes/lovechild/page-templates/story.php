<?php 

	/* Template Name: Story */

	$stories = get_stories($post->ID);

	get_header();

?>

<div id="content">
	<ul id="sidebar" class="brushed">
		<?php foreach ($stories as $story) { if ($story->intro === false) { ?>
		<li>
			<table>
				<tr>
					<td>
						<a href="#"><?php the_lang_content($story->ID, 'page', 'post_title'); ?></a>
					</td>
				</tr>
			</table>
		</li>
		<?php } } ?>
	</ul>
	<?php 
	$intro = false;
	foreach ($stories as $k => $story) { ?>
	<div class="box <?php
	
		if ($story->intro === true) {
			$intro = true;
			echo 'intro';
		}
		
		if ($intro === true && $k === 1) {
			echo 'first';
		}
	
	?>">
		<a class="anchor" name="<?php echo $story->post_name; ?>"></a>
		<h1><?php the_lang_content($story->ID, 'page', 'post_title'); ?></h1>
		<?php the_lang_content($story->ID); ?>
	</div>
	<?php } ?>
</div>

<?php get_footer(); ?>