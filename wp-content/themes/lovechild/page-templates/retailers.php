<?php 

	/* Template Name: Retailers */
	
	get_header();
	
?>

<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyD7kPByvJ-kScfgM2oWOkoJFYFsLp8nc90&sensor=true"></script>
<script type="text/javascript" src="<?php bloginfo('template_url'); ?>/js/infobox.js"></script>
<script type="text/javascript">
window.retailers = <?php echo get_option('retailer_list'); ?>;
</script>

<div id="content">
	<div class="box">
		<h1><?php the_lang_content($post->ID, 'page', 'post_title'); ?></h1>
		<div id="locator">
			<a href="#" id="locate"><?php lang_split('Click to find your location', 'Cliquez pour trouver votre position'); ?></a>
			<form action="#" method="post">
				<label for="locale"><?php lang_split('or search by', 'ou recherche par'); ?></label> <input type="text" id="locale" name="locale" placeholder="<?php lang_split('City or Postal Code', 'Ville ou code postal', 'City or Zip Code'); ?>">
				<input type="submit">
			</form>
		</div>
        <div class="the-content">
		<?php the_lang_content($post->ID); ?>
        </div>
		<div class="separator grey"></div>
		<?php retailer_logos(); ?>
		<div id="map">
			<div id="map-canvas"></div>
		</div>
        <div id="retailers">
			<input type="text" id="search" placeholder="<?php lang_split('Filter by store', 'Trier par magasin'); ?>">
			<ol>
			</ol>
		</div>
		<div class="clear"></div>
		<br />
        <div class="online-logos">
		<?php retailer_logos('online'); ?>
        </div>
	</div>
</div>

<?php get_footer(); ?>