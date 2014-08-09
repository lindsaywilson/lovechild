<?php
	
	add_theme_support('post-thumbnails');

	function my_filter_head() {
		remove_action('wp_head', '_admin_bar_bump_cb');
	}
	add_action('get_header', 'my_filter_head');
	
	function my_login_logo() { ?>
	    <style type="text/css">
	        body.login div#login h1 a {
	            background-image: url(<?php echo get_bloginfo('template_url'); ?>/images/design/logo-login.png);
				-webkit-background-size: 100px 92px;
				background-size: 100px 92px;
				width:100px;
				height:92px;
	        }
	    </style>
	<?php }
	add_action('login_enqueue_scripts', 'my_login_logo');
	
	function respond() {
		wp_enqueue_style('fonts', get_stylesheet_directory_uri().'/fonts.css');
		wp_enqueue_style('respond', get_stylesheet_directory_uri().'/respond.css');
	}
	
	add_action('wp_enqueue_scripts', 'respond');
	
	function my_login_logo_url() {
	    return get_bloginfo('url');
	}
	add_filter('login_headerurl', 'my_login_logo_url');

	function my_login_logo_url_title() {
	    return 'Love Child Organics';
	}
	add_filter('login_headertitle', 'my_login_logo_url_title');
	
	function get_slug() {
		global $post;
		if ($post->post_parent)	{
			$ancestors=get_post_ancestors($post->ID);
			$root=count($ancestors)-1;
			$parent = get_post($ancestors[$root]);
		} else {
			$parent = get_post($post->ID);
		}
		if (is_home() || is_single()) {
			if (in_category('news')) {
				return 'news';
			}else if (pods('product', $post->ID)->exists()) {
				return 'products';
			}else{
				return 'blog';
			}
		}else if (is_tag() || is_archive() || is_search()) {
			if (get_query_var('cat') === 2) {
				return 'news';
			}else{
				return 'blog';
			}
		}else if (is_front_page()){
			return 'home';
		}else{
			return $parent->post_name;
			//return get_post($post)->post_name;
		}
	}
	
	function get_seo_title($post) {
		
		$seo_title = wp_title('', false);
		
		if (get_the_lang() === 'fr_can') {
			$seo_title = get_the_lang_content($post->ID, get_post_type($post->ID), 'post_title').' - '.get_bloginfo('name');
		}
		
		return $seo_title;
		
	}
	
	function nav_title($slug) {
		$titles = array(
			'products' => array(
				'en' => 'Products',
				'fr' => 'Produits'
			),
			'our-story' => array(
				'en' => 'About Us',
				'fr' => 'Histoire'
			),
			'questions' => array(
				'en' => 'Questions?',
				'fr' => 'Infos'
			),
			'news' => array(
				'en' => 'News',
				'fr' => 'Nouvelles'
			),
			'nutrition' => array(
				'en' => 'Nutrition',
				'fr' => 'Nutrition'
			),
			'blog' => array(
				'en' => 'Blog',
				'fr' => 'Blogue'
			),
			'retailers' => array(
				'en' => 'Stores',
				'fr' => 'Magasins'
			),
			'contact' => array(
				'en' => 'Talk to Us',
				'fr' => 'Contact'
			)
		);
		echo $titles[$slug][get_the_lang() === 'fr_can' ? 'fr' : 'en'];
	}
	
	function get_product() {
		global $post;
		if (pods('product', $post->ID)->exists()) {
			return 'product';
		}
	}
	
	function is_selected($slug) {
		if (get_slug() === $slug) {
			echo 'class="selected"';
		}
	}
	
	function get_product_types($id = 0) {
		$available_us = get_the_lang() === 'en_us' ? ' AND us_availability = 1' : '';
		return pods('product_type', array(
			'where' => 'tt.parent = '.$id.$available_us,
			'orderby' => 'sort_order'
		));
	}
	
	function get_stories($id) {
		$stories = get_pages(array(
			'child_of' => $id,
			'sort_column' => 'menu_order',
			'post_type' => 'page'
		));
		array_unshift($stories, get_page($id));
		
		foreach ($stories as $story) {
			$intro = pods('page', $story->ID)->display('intro');
			$story->intro = $intro === 'Yes' ? true : false;
		}
		
		return $stories;
	}
	
	function get_drop($slug, $id) {
		$menu = '<ul class="drop '.$slug.'">';
		$drops = get_stories($id);
		foreach ($drops as $drop) {
			if ($drop->intro === false) {
				$menu .= '<li><a href="'.home_url().'/'.$slug.'/#'.$drop->post_name.'">'.get_the_lang_content($drop->ID, 'page', 'post_title').'</a></li>';
			} 
		}
		$menu .= '</ul>';
		return $menu;
	}
	
	function tiered_archive() {
		global $wpdb;
		$limit = 0;
		$year_prev = null;
		$months = $wpdb->get_results("SELECT DISTINCT MONTH(`p`.`post_date`) AS `month`, YEAR(`p`.`post_date`) AS `year`, COUNT(`p`.`id`) as `post_count` FROM `$wpdb->posts` AS `p` LEFT JOIN `$wpdb->term_relationships` AS `tr` ON `p`.`id` = `tr`.`object_id` WHERE `p`.`post_status` = 'publish' AND `p`.`post_date` <= NOW() AND `p`.`post_type` = 'post' AND `tr`.`term_taxonomy_id` = ".(get_slug() === 'news' ? 2 : 1)." GROUP BY `month`, `year` ORDER BY `post_date` DESC");
		$archive = array();
		foreach ($months as $month) {
			if (!isset($archive[$month->year])) {
				$archive[$month->year] = array(
					'post_count' => 0,
					'months' => array()
				);
			}
			$archive[$month->year]['months'][] = array(
				'name' => date('F', strtotime('1-'.$month->month.'-2000')),
				'number' => $month->month,
				'post_count' => (int)$month->post_count
			);
			$archive[$month->year]['post_count'] += (int)$month->post_count;
		}
		return $archive;
	}
	
	function get_box($entry, $first) {
		
		if (is_tag() || pods('post', $entry->ID)->display('hide_'.get_the_lang()) !== 'Yes') {
		
			$content = get_the_lang_content($entry->ID, 'post');
			if ($content !== '') {
				$content = strip_tags($content);
				if (strlen($content) >= 260) {
					$content = substr($content, 0, strpos($content, ' ', 260));
					$content .= '... <a href="'.get_permalink($entry->ID).'" class="more">Read more</a>';
				}
				$content = preg_replace('/<img[^>]+./','', $content);
				$content = preg_replace('/<iframe.*?\/iframe>/i','', $content);
				$content = apply_filters('the_content', $content);
				$entry->excerpt_content = str_replace(']]>', ']]&gt;', $content);
			}else{
				$entry->excerpt_content = '';
			}
	
			$entry->external_link = pods('post', $entry->ID)->display('external_link');
	
			if ($first === true) {
				$first = 'first';
			}else{
				$first = '';
			}
		
			$box = '<div class="box '.$first.'">';
			if ($entry->excerpt_content !== '' || get_the_post_thumbnail($entry->ID) !== '') {
				$box .= '<div class="left">';
			}
		
			$box .= '<h2><a href="'.get_permalink($entry->ID).'">'.get_the_lang_content($entry->ID, 'post', 'post_title').'</a></h2>';
			$box .= '<p class="meta">'.date('M j, Y', strtotime($entry->post_date));
			// $box .= '  |  By: '.get_the_author_meta('user_nicename', $entry->post_author).'</p>';
		
			if ($entry->excerpt_content !== '' || get_the_post_thumbnail($entry->ID) !== '') {
				if (get_the_post_thumbnail($entry->ID) !== '') {
					$box .= $entry->excerpt_content;
				}
				$box .= '</div>';
				$box .= '<div class="right">';
				if (get_the_post_thumbnail($entry->ID) !== '') {
					$box .= '<a href="'.get_permalink($entry->ID).'" class="teaser">'.get_the_post_thumbnail($entry->ID).'</a>';
				}else{
					$box .= $entry->excerpt_content;	
				}
				$box .= '</div>';
			}
		
			$box .= '<div class="clear"></div>';
		
			if (get_slug() === 'news' && $entry->external_link !== '') {
				$box .= '<a href="'.$entry->external_link.'" target="_blank" class="link">Link to original article</a>';
			}
		
			$box .= '<a href="'.get_permalink($entry->ID).'#comments" class="count">';
			$box .= '<span>'.$entry->comment_count.'</span>';
			$box .= '<img src="'.get_bloginfo('template_url').'/images/design/speech-bubble.png">';
			$box .= '</a>';
			$box .= get_share_buttons($entry);
			$box .= '</div>';
		
			return $box;
		
		}else{
			return '';
		}
		
	}
	
	function get_client_ip() {
	    $ipaddress = '';
	    if (getenv('HTTP_CLIENT_IP'))
	        $ipaddress = getenv('HTTP_CLIENT_IP');
	    else if(getenv('HTTP_X_FORWARDED_FOR'))
	        $ipaddress = getenv('HTTP_X_FORWARDED_FOR');
	    else if(getenv('HTTP_X_FORWARDED'))
	        $ipaddress = getenv('HTTP_X_FORWARDED');
	    else if(getenv('HTTP_FORWARDED_FOR'))
	        $ipaddress = getenv('HTTP_FORWARDED_FOR');
	    else if(getenv('HTTP_FORWARDED'))
	       $ipaddress = getenv('HTTP_FORWARDED');
	    else if(getenv('REMOTE_ADDR'))
	        $ipaddress = getenv('REMOTE_ADDR');
	    else
	        $ipaddress = 'UNKNOWN';
	    return $ipaddress;
	}
	
	function set_the_lang($langcode) {
		setcookie('lang', $langcode, 0, '/');
	}
	
	function get_the_lang() {
		return $_COOKIE['lang'];
	}
	
	function is_canada() {
		if (in_array(get_the_lang(), array('en_can', 'fr_can'))) {
			return true;
		}else{
			return false;
		}
	}
	
	function is_english() {
		if (get_the_lang() === 'fr_can') {
			return false;
		}else{
			return true;
		}
	}
	
	function is_alt_lang($id, $pod = 'page', $field = 'post_content') {
		$pods = pods($pod, $id);
		if (get_the_lang() === 'en_can' || (is_english() && (int)$pods->field($field.'_en_share') === 1)) {
			return false;
		}else{
			return true;
		}
	}
	
	function get_the_lang_content($id, $pod = 'page', $field = 'post_content', $raw = false) {
		$entry = pods($pod, $id);
		$lang = get_the_lang() !== 'en_can' ? '_'.get_the_lang() : '';
		if ($raw) {
			$content = $entry->field($field.$lang);
			if (empty($content)) {
				$content = $entry->field($field);
			}
		} else {
			$content = $entry->display($field.$lang);
			if (empty($content)) {
				$content = $entry->display($field);
			}
		}
		if ($field === 'post_content') {
			$content = apply_filters('the_content', $content);
		}
		return $content;
	}
	
	function the_lang_content($id, $pod = 'page', $field = 'post_content', $raw = false) {
		echo get_the_lang_content($id, $pod, $field, $raw);
	}
	
	function get_lang_split($english, $french, $american = null) {
		if (is_english()) {
			if ($american !== null && get_the_lang() === 'en_us') {
				return $american;
			}else{
				return $english;
			}
		}else{
			return $french;
		}
	}
	
	function lang_split($english, $french, $american = null) {
		echo get_lang_split($english, $french, $american);
	}
	
	function get_share_buttons($entry) {
		
		$featured_image = wp_get_attachment_image_src(get_post_thumbnail_id($entry->ID), 'full');
		
		$fb = 'https://www.facebook.com/dialog/feed?
			app_id=598729373557113&
			display=popup&
			caption='.urlencode($entry->post_title).'&
			link='.urlencode(get_permalink($entry->ID)).'&
			redirect_uri='.urlencode(get_permalink($entry->ID));
		$twi = 'https://twitter.com/share?
			url='.urlencode(get_permalink($entry->ID)).'&
			text='.urlencode($entry->post_title);
		$pin = '//www.pinterest.com/pin/create/button/?
			url='.urlencode(get_permalink($entry->ID)).'&
			description='.urlencode($entry->post_title).'&
			media='.urlencode($featured_image[0]);
			
		$share = '<div class="share">';
		$share .= '<a href="'.$fb.'" class="fb"><img src="'.get_bloginfo('template_url').'/images/social/fb-xsmall.png" alt="Share on Facebook"></a>';
		$share .= '<a href="'.$twi.'" class="twi"><img src="'.get_bloginfo('template_url').'/images/social/twi-xsmall.png" alt="Share on Twitter"></a>';
		$share .= '<a href="'.$pin.'" class="pin"><img src="'.get_bloginfo('template_url').'/images/social/pin-xsmall.png" alt="Share on Pinterest"></a>';
		$share .= '</div>';
		
		return $share;
		
	}
	
	/* if(!wp_next_scheduled('generate_retailer_list')) {
	   wp_schedule_event(time(), 'daily', 'refresh_retailer_list');
	}
	
	add_action('refresh_retailer_list', 'generate_retailer_list'); */
	
	function generate_retailer_list() {
		
		$retailers = array();

		$results = pods('retailer', array( 
			'orderby' => 'menu_order DESC',
			'limit' => '-1'
		));
	
		while ($results->fetch()) {
		
			$retailers[] = array(
				'name' => $results->display('store_name'),
				'address' => $results->display('address'),
				'lat' => (float)$results->display('latitude'),
				'lon' => (float)$results->display('longitude')
			);
		
		}
	
		update_option('retailer_list', json_encode($retailers));
		
	}
	
	function retailer_logos($avail = 'in-store') {
		
		$retailer_logos = pods('retailer_logo', array(
			'limit' => -1,
			'orderby' => 'menu_order DESC',
			'where' => "(locale.meta_value = '".(is_canada() ? 'canada' : 'usa')."' OR locale.meta_value = 'both') AND (availability.meta_value = '".$avail."' OR availability.meta_value = 'both')"
		));
		
		$retailers_list = '';
		
		if ($retailer_logos->total() > 0) {
			
			$retailers_list = '<h2>';
			$retailers_list .= $avail === 'in-store' ? get_lang_split('Available at these major retailers:', 'Disponible à ces grands détaillants:') : get_lang_split('Or order online at:', 'Ou en ligne à:');
			$retailers_list .= '</h2><div class="stores"><div class="grad left"></div><ul>';
		
			while($retailer_logos->fetch()) {
				$retailer_link = get_the_lang_content($retailer_logos->id(), 'retailer_logo', 'link');
				$retailers_list .= '<li>';
				if (!empty($retailer_link)) {
					$retailers_list .= '<a href="'.$retailer_link.'" target="_blank">';
				}
				$retailers_list .= '<img src="'.$retailer_logos->display('logo').'" alt="'.$retailer_logos->display('post_title').'">';
				if (!empty($retailer_link)) {
					$retailers_list .= '</a>';
				}
				$retailers_list .= '</li>';
			}
		
			$retailers_list .= '</ul><div class="grad right"></div></div>';
		
		}
		
		echo $retailers_list;
		
	}
	
?>