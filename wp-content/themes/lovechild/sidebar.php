<?php

	require_once(get_theme_root().'/lovechild/lib/twitteroauth.php');
	$twitter = new TwitterOAuth('vj6dvhND0Xs9dIikwZnroW5Os', 'pA2Tx7gMwkZAl3tdBnMBmnAGPLL6j1lzgmkQuAbm3z5k3dzM9G');

	$tweets = $twitter->get('statuses/user_timeline', array(
		'screen_name' => 'lc_organics',
		'count' => 1
	));
	
	$tweet = $tweets[0];
	
	$tags = get_tags(array(
		'orderby' => 'count',
		'number' => 6
	));
	
	$years = tiered_archive();
	
?>
<div id="sidebar">
	<form action="<?php echo home_url(); ?>" method="get">
		<input type="text" id="search" name="s">
		<input type="hidden" name="post_type" value="post" />
		<input type="hidden" name="cat" value="<?php echo get_slug() === 'news' ? '' : '-'; ?>2" />
		<input type="submit">
	</form>
	<?php if (count($tags)) { ?>
	<div id="tags">
		<h3>Tags</h3>
		<ul>
			<?php foreach ($tags as $tag) { ?>
			<li>
				<a href="<?php echo get_tag_link($tag->term_id); ?>"><?php echo $tag->name; ?> <span>(<?php echo $tag->count; ?>)</span></a>
			</li>
			<?php } ?>
		</ul>
	</div>
	<?php } ?>
	<div id="archive">
		<h3>Date</h3>
		<ul>
			<?php foreach ($years as $k => $year) { ?>
			<li>
				<a href="#" class="year"><?php echo $k; ?> <span>(<?php echo $year['post_count']; ?>)</span></a>
				<ul>
					<?php foreach ($year['months'] as $month) { ?>
					<li>
						<a href="<?php echo get_month_link($k, $month['number']); ?>?cat=<?php echo get_slug() === 'news' ? '2' : '-2'; ?>"><?php echo $month['name']; ?> <span>(<?php echo $month['post_count']; ?>)</span></a>
					</li>
					<?php } ?>
				</ul>
			</li>
			<?php } ?>
		</ul>
	</div>
	<div id="twidget">
		<img src="<?php bloginfo('template_url'); ?>/images/social/twi-medium.png" alt="Twitter">
		<h3><?php echo $tweet->user->name; ?></h3>
		<h4><a href="http://twitter.com/<?php echo $tweet->user->screen_name; ?>" target="_blank">@<?php echo $tweet->user->screen_name; ?></a> <?php
		
			$minutesSince = round((time() - strtotime($tweet->created_at))/60);
			if ($minutesSince >= 60) {
				$hoursSince = round($minutesSince/60);
				if ($hoursSince >= 24) {
					echo round(($hoursSince/24)).'d';
				}else{
					echo $hoursSince.'h';
				}
			}else{
				echo $minutesSince.'m';
			}
		
		?></h4>
		<p><?php echo $tweet->text; ?></p>
	</div>
</div>