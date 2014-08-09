<?php 

	/* Template Name: Home */ 
	
	$spinbox = pods('spinbox', array( 
    	'orderby' => 'menu_order DESC'
	));
	
	get_header();
	
?>

<div id="content">
	<div id="spinbox">
		<ul id="slides">
			<?php while ($spinbox->fetch()) { $blank = $spinbox->field('borderless') == '1'; ?>
			<li class="<?php
			
				if ($spinbox->position() === 1) {
					echo 'on';
				}
				echo ' ';
				if ($blank) {
					echo 'blank';
				} 
				
			?>">
				<?php if (!$blank) { ?>
                <a class="link" href="<?php echo $spinbox->display('link'); ?>" target="<?php echo $spinbox->field('target'); ?>">
				<div class="overlay">
					<h2><?php the_lang_content($spinbox->id(), 'spinbox', 'post_title'); ?>
					<span><?php the_lang_content($spinbox->id(), 'spinbox', 'description'); ?></span></h2>
					<img src="<?php echo get_bloginfo('template_url').'/images/icons/'.$spinbox->field('icon'); ?>.png" class="icon">
				</div></a>
				<?php } ?>
                
				<img src="<?php the_lang_content($spinbox->id(), 'spinbox', 'image'); ?>" class="bg">
			</li>
			<?php } ?>
		</ul>
		<ul id="indicators">
			<?php for ($i=0; $i < $spinbox->total(); $i++) { 
				echo '<li'.($i===0 ? ' class="selected"' : '').'><a href="#"></a></li>';
			}?>
		</ul>
	</div>
	<ul id="boxes">
		<li>
			<a href="<?php echo home_url(); ?>/our-story/#spreading-the-love"><img src="<?php bloginfo('template_url'); ?>/images/home/spreading-the-love-<?php if (is_english()) { echo get_the_lang() === 'en_us' ? 'us' : 'en'; }else{ echo 'fr'; } ?>.png" alt="Spreading The Love"></a>
		</li>
		<li id="get-social">
			<?php $social = pods('social_media', array()); ?>
			<a href="http://www.twitter.com/<?php echo $social->display('twitter'); ?>" target="_blank" class="twi"><img src="<?php bloginfo('template_url'); ?>/images/design/pixel.gif"></a>
			<a href="http://www.pinterest.com/<?php echo $social->display('pinterest'); ?>" target="_blank" class="pin"><img src="<?php bloginfo('template_url'); ?>/images/design/pixel.gif"></a>
			<a href="http://www.facebook.com/<?php echo $social->display('facebook'); ?>" target="_blank" class="fb"><img src="<?php bloginfo('template_url'); ?>/images/design/pixel.gif"></a>
			<a href="http://www.instagram.com/<?php echo $social->display('instagram'); ?>" target="_blank" class="insta"><img src="<?php bloginfo('template_url'); ?>/images/design/pixel.gif"></a>
			<a href="http://www.youtube.com/<?php echo $social->display('youtube'); ?>" target="_blank" class="yt"><img src="<?php bloginfo('template_url'); ?>/images/design/pixel.gif"></a>
			<img src="<?php bloginfo('template_url'); ?>/images/home/get-social-<?php echo is_english() ? 'en' : 'fr'; ?>.png" alt="Get Social">
		</li>
		<li>
			<a href="<?php echo home_url(); ?>/our-story/#about-us"><img src="<?php bloginfo('template_url'); ?>/images/home/family-owned-<?php echo is_english() ? 'en' : 'fr'; ?>.png" alt="Family Owned"></a>
		</li>
		<li style="margin:0;">
			<a href="<?php echo home_url(); ?>/contact?newsletter"><img src="<?php bloginfo('template_url'); ?>/images/home/newsletter-<?php echo is_english() ? 'en' : 'fr'; ?>.png" alt="Sign Up For Our Newsletter"></a>
			<a href="<?php echo home_url(); ?>/blog"><img src="<?php bloginfo('template_url'); ?>/images/home/blog-<?php echo is_english() ? 'en' : 'fr'; ?>.png" alt="Read our Blog"></a>
		</li>
	</ul>
</div>
<div id="hills">
	<div class="overlay"></div>
	<div id="inner">
		<img src="<?php bloginfo('template_url'); ?>/images/bg/banana.png" id="banana">
		<img src="<?php bloginfo('template_url'); ?>/images/bg/apricot.png" id="apricot">
		<img src="<?php bloginfo('template_url'); ?>/images/bg/hill-left-large.png" class="hill left large">
		<img src="<?php bloginfo('template_url'); ?>/images/bg/hill-right-large.png" class="hill right large">
		<img src="<?php bloginfo('template_url'); ?>/images/bg/hill-left-small.png" class="hill left small">
		<img src="<?php bloginfo('template_url'); ?>/images/bg/hill-right-small.png" class="hill right small">
	</div>
</div>

<?php get_footer(); ?>