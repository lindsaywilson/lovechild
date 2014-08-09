<?php 

	/* Template Name: Product Types */
	
	the_post();
	
	$ancestors = get_post_ancestors($post->ID);
	$parent = get_post($post->post_parent);
	
	get_header();
	
?>

<div id="content">
	<div class="box">
    	<ul id="breadcrumb">
			<?php if (count($ancestors) > 1) { ?>
			<li><a href="<?php echo home_url().'/products'; ?>"><?php lang_split('Products', 'Produits'); ?></a></li>
			<li>></li>
			<li><a href="<?php echo home_url().'/products/'.$parent->post_name; ?>"><?php the_lang_content($parent->ID, 'page', 'post_title'); ?></a></li>
			<?php }else{ ?>
			<li><a href="<?php echo home_url().'/products'; ?>"><?php lang_split('Back to products', 'Retour aux Produits'); ?></a></li>
			<?php } ?>
		</ul>
        
		<h1><?php the_lang_content($post->ID, 'page', 'post_title'); ?></h1>
		
		<?php

			$productTypes = pods('product_type', $post->post_name);
			
			$productSubTypes = get_product_types($productTypes->display('term_id'));
		
			$products = pods('product', array(
				'where' => 'product_type.slug = "'.$post->post_name.'"'
			));
			
		?>
		<?php if ($products->total() === 0 && $productSubTypes->total() === 0) { ?>
		<div class="separator grey"></div>
		<?php 
			
			the_lang_content($post->ID); 
			
		}else{
			
			the_lang_content($post->ID); 
			
		?>
		<div class="separator red"></div>
		<?php if ($productSubTypes->total() > 0) { ?> 
		<ul id="productSubTypes">
		<?php while ($productSubTypes->fetch()) { ?>
			<li>
				<a href="<?php echo get_the_permalink().$productSubTypes->display('slug') ?>">
					<img src="<?php the_lang_content($productSubTypes->id(), 'product_type', 'packaging'); ?>">
					<h2 <?php if ($productSubTypes->position()%2 === 0) { echo 'class="alt"'; } ?>><?php the_lang_content($productSubTypes->id(), 'product_type', 'name'); ?> <span><?php the_lang_content($productSubTypes->id(), 'product_type', 'description', true); ?></span></h2>
				</a>
			</li>
		<?php } ?>
		</ul>
		<?php }else{ ?>
		<ul id="products">
		<?php while ($products->fetch()) { ?>
			<li>
				<a href="<?php echo home_url().'/product/'.$products->display('post_name') ?>">
					<img src="<?php the_lang_content($products->id(), 'product', 'packaging'); ?>">
					<h2 style="color:<?php echo $products->field('colour'); ?>;"><?php the_lang_content($products->id(), 'product', 'post_title'); ?> <span><?php the_lang_content($products->id(), 'product', 'suggested_age', true); ?></span></h2>
				</a>
			</li>
		<?php } ?>
		</ul>
		<?php } ?>
		<?php } ?>
	</div>
</div>

<?php get_footer(); ?>