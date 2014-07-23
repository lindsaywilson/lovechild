<?php
	
	the_post();
	
	get_header();
	
?>

<div id="content">
	
	<?php get_sidebar(); ?>
	
	<div class="box">
		<h2><a href="<?php 
			echo home_url().'/';
			if (in_category('news')) {
				echo 'news';
			}else{
				echo 'blog';
			}
		?>"><?php the_lang_content(get_the_ID(), 'post', 'post_title'); ?></a></h2>
		<p class="meta">
			<?php 
				echo date('M j, Y', strtotime(get_the_date()));
				// echo ' |  By: '.get_the_author(); 
			?>
		</p>
		<?php if (get_the_post_thumbnail() !== '') { ?>
		<div class="teaser wide">
			<?php the_post_thumbnail(); ?>
		</div>
		<?php } ?>
		<div class="entry">
			<?php the_content(); ?>
			<?php if (get_slug() === 'news') {
				$external_link = pods('post', get_the_ID())->display('external_link');
				if ($external_link !== '') {
					echo '<a href="'.$external_link.'" target="_blank" style="margin-left:auto;margin-right:auto;" class="link">Link to original article</a>';
				}
			} ?>
			<div class="clear"></div>
		</div>
		<a href="#comments" class="count">
			<span><?php comments_number(0,1,'%'); ?></span>
			<img src="<?php bloginfo('template_url'); ?>/images/design/speech-bubble.png">
		</a>
		<?php echo get_share_buttons($post); ?>
	</div>
	<a name="comments"></a>
	<div class="box comments">
		<?php comments_template(); ?>
	</div>
	
</div>

<?php get_footer(); ?>