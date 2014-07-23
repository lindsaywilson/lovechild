<?php the_post(); get_header(); ?>

	<div id="content">
		<div class="box">
			<h1><?php the_lang_content($post->ID, 'page', 'post_title'); ?></h1>
			<div class="separator grey"></div>
			<?php the_lang_content($post->ID); ?>
		</div>
	</div>
	
<?php get_footer(); ?>