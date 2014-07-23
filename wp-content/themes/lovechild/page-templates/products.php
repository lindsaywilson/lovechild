<?php 

	/* Template Name: Products */
	
	the_post();
	
	get_header();
	
?>

<div id="content">
	<div class="box">
		<h1><?php the_lang_content($post->ID, 'page', 'post_title'); ?></h1>
		<?php $productTypes = get_product_types(); if ($productTypes->total() > 1) { ?>
		<table id="productsNav">
			<tr>
				<?php while ($productTypes->fetch()) { ?>
				<td class="<?php echo $productTypes->display('slug'); ?>">
					<a href="<?php echo home_url().'/products/'.$productTypes->display('slug'); ?>"><?php the_lang_content($productTypes->id(), 'product_type', 'name'); ?></a>
				</td>
				<?php
				
					} 
		
				?>
			</tr>
		</table>
		<?php } ?>
		<?php the_lang_content($post->ID); ?>
		<div class="separator red"></div>
		<ul id="productTypes">
			<?php $productTypes = get_product_types(); ?>
			<?php while ($productTypes->fetch()) { ?>
			<li>
				<a href="<?php echo get_the_permalink().$productTypes->display('slug'); ?>">
					<img src="<?php the_lang_content($productTypes->id(), 'product_type', 'packaging'); ?>">
					<h2 class="<?php echo $productTypes->display('slug'); ?>"><?php the_lang_content($productTypes->id(), 'product_type', 'name'); ?> <span><?php the_lang_content($productTypes->id(), 'product_type', 'description', true); ?></span></h2>
				</a>
			</li>
			<?php } ?>
		</table>
	</div>
</div>

<?php get_footer(); ?>