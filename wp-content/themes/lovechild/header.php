<?php
	
	$social = pods('social_media', array()); 
	
	if (!isset($_COOKIE['lang'])) {
		$geo = json_decode(file_get_contents('http://freegeoip.net/json/'.get_client_ip()));
		if ($geo->country_code === 'US') {
			set_the_lang('en_us');
		}else{
			if ($geo->region_code === 'QC') {
				set_the_lang('fr_can');
			}else{
				set_the_lang('en_can');
			}
		}
	}
	
	$langs = array(
		array(
			'name' => 'Canada (English)',
			'code' => 'en_can',
			'icon' => 'canada'
		),
		array(
			'name' => 'Canada (Français)',
			'code' => 'fr_can',
			'icon' => 'canada'
		),
		array(
			'name' => 'United States',
			'code' => 'en_us',
			'icon' => 'usa'
		)
	);
	$langcodes = array();
	
	foreach ($langs as $k => $lang) {
		$langcodes[] = $lang['code'];
		if ($lang['code'] === get_the_lang()) {
			unset($langs[$k]);
			array_unshift($langs, $lang);
		}
	}
	
	if (isset($_GET['lang'])) {
		$langcode = in_array($_GET['lang'], $langcodes) ? $_GET['lang'] : 'en_can';
		set_the_lang($langcode);
		header('Location: '.get_the_permalink());
	}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
   "http://www.w3.org/TR/html4/loose.dtd">

<html lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<title><?php echo get_seo_title($post); ?></title>
	<link rel="shortcut icon" href="<?php bloginfo('template_url'); ?>/favicon.ico" type="image/x-icon">
	<link rel="stylesheet" type="text/css" href="//cloud.typography.com/6482872/688624/css/fonts.css" />
	<link rel="stylesheet" href="<?php bloginfo('template_url'); ?>/css/normalize.css" type="text/css">
	<link rel="stylesheet" href="<?php bloginfo('template_url'); ?>/css/style.css" type="text/css">
	<?php require_once 'lib/Mobile_Detect.php'; $detect = new Mobile_Detect; ?>
	<meta name="viewport" content="width=device-width, initial-scale=<?php
		if ($detect->isMobile()) {
			if ($detect->isTablet()) {
				echo '0.7';
			}else{
				echo '0.3';
			}
		}else{
			echo '1';
		}
	?>">
	<?php wp_head(); ?>
	<script type="text/javascript">

	  var _gaq = _gaq || [];
	  _gaq.push(['_setAccount', 'UA-38619453-1']);
	  _gaq.push(['_trackPageview']);

	  (function() {
	    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
	    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
	    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
	  })();

	</script>
</head>
<body class="<?php echo get_slug(); ?> <?php echo get_product(); ?>">
	<div id="header">
		<ul id="social">
			<li id="lang">
				<ul>
					<?php foreach ($langs as $lang) { ?>
					<li>
						<a href="<?php the_permalink(); ?>?lang=<?php echo $lang['code']; ?>">
							<img src="<?php bloginfo('template_url'); ?>/images/nav/<?php echo $lang['icon']; ?>.png" alt="<?php echo $lang['name']; ?>"> <?php echo $lang['name']; ?>
						</a>
					</li>
					<?php } ?>
				</ul>
			</li>
			<li>
				<a href="http://www.facebook.com/<?php lang_split($social->display('facebook'), $social->display('facebook_fr_can')); ?>" target="_blank"><img src="<?php bloginfo('template_url'); ?>/images/social/fb-small.png" alt="Love Child on Facebook"></a>
			</li>
			<li>
				<a href="http://www.twitter.com/<?php lang_split($social->display('twitter'), $social->display('twitter_fr_can')); ?>" target="_blank"><img src="<?php bloginfo('template_url'); ?>/images/social/twi-small.png" alt="Love Child on Twitter"></a>
			</li>
			<li>
				<a href="http://www.pinterest.com/<?php echo $social->display('pinterest'); ?>" target="_blank"><img src="<?php bloginfo('template_url'); ?>/images/social/pin-small.png" alt="Love Child on Pinterest"></a>
			</li>
			<li>
				<a href="http://www.instagram.com/<?php echo $social->display('instagram'); ?>" target="_blank"><img src="<?php bloginfo('template_url'); ?>/images/social/insta-small.png" alt="Love Child on Instagram"></a>
			</li>
			<li>
				<a href="http://www.youtube.com/<?php echo $social->display('youtube'); ?>" target="_blank"><img src="<?php bloginfo('template_url'); ?>/images/social/yt-small.png" alt="Love Child on YouTube"></a>
			</li>
		</ul>
		<ul id="nav">
			<li <?php is_selected('products'); ?>>
				<a href="<?php echo home_url(); ?>/products"><span class="button products"><span class="wrap"><span class="main"><?php nav_title('products'); ?></span></span></span><img src="<?php bloginfo('template_url'); ?>/images/nav/products.png" alt="<?php nav_title('products'); ?>"></a>
				<ul id="productsDrop">
					<?php
					
						$productTypes = get_product_types();
						
						while ($productTypes->fetch()) {
						
					?>
					<li class="<?php echo $productTypes->display('slug'); ?>">
						<a href="<?php echo home_url().'/products/'.$productTypes->display('slug'); ?>"><?php the_lang_content($productTypes->id(), 'product_type', 'name'); ?></a>
						<?php
							
							$productSubTypes = get_product_types($productTypes->display('term_id'));
							
							if ($productSubTypes->total() > 0) {
							
						?>
						<div class="connector"></div>
						<ul>
							<?php while ($productSubTypes->fetch()) { ?>
							<li>
								<a href="<?php echo home_url().'/products/'.$productTypes->display('slug').'/'.$productSubTypes->display('slug'); ?>"><?php the_lang_content($productSubTypes->id(), 'product_type', 'name'); ?> <span><?php echo strip_tags(get_the_lang_content($productSubTypes->id(), 'product_type', 'description')); ?></span></a>
								<ul>
									<?php
									
										$products = pods('product', array(
											'where' => 'product_type.term_id = '.$productSubTypes->display('term_id')
										));
								
										while ($products->fetch()) { 
												
									?>
									<li><a href="<?php echo home_url().'/product/'.$products->display('post_name'); ?>"><?php the_lang_content($products->id(), 'product', 'post_title'); ?></a></li>
									<?php
										
										}
										
									?>
								</ul>
							</li>
							<?php } ?>
						</ul>
						<?php 
							
							}else{ 
							
								$products = pods('product', array(
									'where' => 'product_type.term_id = '.$productTypes->display('term_id')
								));
								
								if ($products->total() > 0) { 
							
						?>
							<div class="connector"></div>
							<ul>
							<?php while ($products->fetch()) { ?>
								<li><a href="<?php echo home_url().'/product/'.$products->display('post_name'); ?>"><?php the_lang_content($products->id(), 'product', 'post_title'); ?> <span><?php echo $products->field('suggested_age'); ?></span></a></li>
							<?php } ?>
							</ul>
							<?php }
						} ?>
					</li>
					<?php } ?>
				</ul>
			</li>
			<li <?php is_selected('our-story'); ?>>
				<a href="<?php echo home_url(); ?>/our-story">
					<span class="button our-story">
						<span class="wrap">
							<span class="main"><?php nav_title('our-story'); ?></span>
						</span>
					</span>
					<img src="<?php bloginfo('template_url'); ?>/images/nav/our-story.png" alt="<?php nav_title('our-story'); ?>">
				</a>
				<?php echo get_drop('our-story', 17); ?>
			</li>
			<li <?php is_selected('questions'); ?>>
				<a href="<?php echo home_url(); ?>/questions">
					<span class="button questions">
						<span class="wrap">
							<span class="main"><?php nav_title('questions'); ?></span>
						</span>
					</span>
					<img src="<?php bloginfo('template_url'); ?>/images/nav/questions.png" alt="<?php nav_title('questions'); ?>">
				</a>
			</li>
			<li <?php is_selected('news'); ?>>
				<a href="<?php echo home_url(); ?>/news">
					<span class="button news">
						<span class="wrap">
							<span class="main"><?php nav_title('news'); ?></span>
						</span>
					</span>
					<img src="<?php bloginfo('template_url'); ?>/images/nav/news.png" alt="<?php nav_title('news'); ?>">
				</a>
			</li>
			<li id="logo">
				<a href="<?php echo home_url(); ?>/">
					<img src="<?php bloginfo('template_url'); ?>/images/design/logo.png" alt="Love Child Organics">
				</a>
			</li>
			<li <?php is_selected('blog'); ?>>
				<a href="<?php echo home_url(); ?>/blog">
					<span class="button blog">
						<span class="wrap">
							<span class="main"><?php nav_title('blog'); ?></span>
						</span>
					</span>
					<img src="<?php bloginfo('template_url'); ?>/images/nav/blog.png" alt="<?php nav_title('blog'); ?>">
				</a>
			</li>
			<li <?php is_selected('nutrition'); ?>>
				<a href="<?php echo home_url(); ?>/nutrition">
					<span class="button nutrition">
						<span class="wrap">
							<span class="main"><?php nav_title('nutrition'); ?></span>
						</span>
					</span>
					<img src="<?php bloginfo('template_url'); ?>/images/nav/nutrition.png" alt="<?php nav_title('nutrition'); ?>">
				</a>
				<?php echo get_drop('nutrition', 56); ?>
			</li>
			<li <?php is_selected('retailers'); ?>>
				<a href="<?php echo home_url(); ?>/retailers">
					<span class="button retailers">
						<span class="wrap">
							<span class="main"><?php nav_title('retailers'); ?></span>
						</span>
					</span>
					<img src="<?php bloginfo('template_url'); ?>/images/nav/retailers.png" alt="<?php nav_title('retailers'); ?>">
				</a>
			</li>
			<li <?php is_selected('contact'); ?>>
				<a href="<?php echo home_url(); ?>/contact">
					<span class="button contact">
						<span class="wrap">
							<span class="main"><?php nav_title('contact'); ?></span>
						</span>
					</span>
					<img src="<?php bloginfo('template_url'); ?>/images/nav/contact.png" alt="<?php nav_title('contact'); ?>">
				</a>
			</li>
		</ul>
		<div id="bar">
			<div class="corner left"></div>
			<div class="corner right"></div>
		</div>
	</div>
	<div id="frame">