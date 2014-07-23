<?php

	/* Template Name: Contact */
	
	the_post();
	
	require_once(get_theme_root().'/lovechild/lib/twitteroauth.php');
	$twitter = new TwitterOAuth('vj6dvhND0Xs9dIikwZnroW5Os', 'pA2Tx7gMwkZAl3tdBnMBmnAGPLL6j1lzgmkQuAbm3z5k3dzM9G');

	$tweets = $twitter->get('statuses/user_timeline', array(
		'screen_name' => 'lc_organics',
		'count' => 1
	));
	$tweet = $tweets[0];

	get_header();
	
	$social = pods('social_media', array()); 

?>

<div id="content">
	<div class="box">
		<h1><?php the_title(); ?></h1>
		
		<?php if (is_english()) { ?>
		<div id="newsletter" <?php if (isset($_GET['newsletter'])) { echo 'class="focus"'; } ?>>
			<form action="http://lovechildorganics.us8.list-manage.com/subscribe/post?u=97c59452c051b4a17dfda605a&amp;id=da6f73d822" method="post" id="mc-embedded-subscribe-form" name="mc-embedded-subscribe-form" class="validate" target="_blank" novalidate>
			<h3><?php lang_split('Join our Family! Sign up for our newsletter', 'Inscrivez-vous à notre newsletter'); ?></h3>
			<div id="mce-responses" class="clear">
				<div class="response" id="mce-error-response" style="display:none"></div>
				<div class="response" id="mce-success-response" style="display:none"></div>
			</div>
			<div style="position: absolute; left: -5000px;"><input type="text" name="b_97c59452c051b4a17dfda605a_da6f73d822" value=""></div>
			<input type="text" value="" name="FNAME" class="" placeholder="<?php lang_split('First name', 'Prénom'); ?>">
			<input type="text" value="" name="LNAME" class="" placeholder="<?php lang_split('Last name', 'Nom'); ?>">
			<input type="email" value="" name="EMAIL" class="required email" placeholder="Email">
			<input type="submit" name="subscribe" id="mc-embedded-subscribe" class="button">
			</form>
		</div>
		<?php } ?>
		
		<div class="separator grey"></div>
		<?php the_lang_content($post->ID); ?>
		<ul id="socialLarge">
			<li>
				<a href="http://www.facebook.com/<?php echo $social->display('facebook'); ?>" target="_blank"><img src="<?php bloginfo('template_url'); ?>/images/social/fb-large.png" alt="Love Child on Facebook"></a>
			</li>
			<li>
				<a href="http://www.twitter.com/<?php echo $social->display('twitter'); ?>" target="_blank"><img src="<?php bloginfo('template_url'); ?>/images/social/twi-large.png" alt="Love Child on Twitter"></a>
			</li>
			<li>
				<a href="http://www.pinterest.com/<?php echo $social->display('pinterest'); ?>" target="_blank"><img src="<?php bloginfo('template_url'); ?>/images/social/pin-large.png" alt="Love Child on Pinterest"></a>
			</li>
			<li>
				<a href="http://www.instagram.com/<?php echo $social->display('instagram'); ?>" target="_blank"><img src="<?php bloginfo('template_url'); ?>/images/social/insta-large.png" alt="Love Child on Instagram"></a>
			</li>
			<li>
				<a href="http://www.youtube.com/<?php echo $social->display('youtube'); ?>" target="_blank"><img src="<?php bloginfo('template_url'); ?>/images/social/yt-large.png" alt="Love Child on YouTube"></a>
			</li>
		</ul>
		<img src="<?php bloginfo('template_url'); ?>/images/bg/apricot-reverse.png" id="apricot">
		<img src="<?php bloginfo('template_url'); ?>/images/bg/rice-cake.png" id="riceCake">
	</div>
</div>

<?php get_footer(); ?>