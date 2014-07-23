<?php 
	
	/* Template Name: Questions */

	the_post();
	
	$questionTypes = pods('question_type', array());
	
	get_header();
	
?>

<div id="content">
	<div class="box">
		<h1><?php the_lang_content($post->ID, 'page', 'post_title'); ?></h1>
		<input type="text" id="search">
		<?php the_lang_content($post->ID); ?>
		<div class="separator grey"></div>
		<ul id="faqs">
			<?php while ($questionTypes->fetch()) { ?>
			<li>
				<h2><?php the_lang_content($questionTypes->id(), 'question_type', 'name'); ?></h2>
				<ul>
					<?php
					
						$questions = pods('question', array(
							'where' => 'question_type.slug = "'.$questionTypes->field('slug').'"'
						));
						
						while ($questions->fetch()) {
						
					?>
					<li>
						<h3><a href="#"><?php the_lang_content($questions->id(), 'question', 'post_title'); ?></a></h3>
						<div class="answer">
							<?php the_lang_content($questions->id(), 'question'); ?>
						</div>
					</li>
					<?php } ?>
				</ul>
			</li>
			<?php } ?>
		</ul>
		<div class="separator grey"></div>
		<h2 class="small"><?php lang_split('Have a question not listed above? Simply ask us below.', 'Vous avez une question ne figurant pas ci-dessus? Il suffit de nous demander ci-dessous.'); ?></h2>
		<?php echo do_shortcode('[contact-form-7 id="92" title="Contact form 1"]'); ?>
	</div>
</div>

<?php get_footer(); ?>