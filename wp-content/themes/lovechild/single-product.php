<?php
	
	global $post;
	$product = pods('product', $post->ID);
	
	$breadcrumbs = array();
	$firstType = wp_get_object_terms($post->ID, 'product_type');
	$firstType = $firstType[0];
	
	$breadcrumbs[] = array(
		'name' => get_the_lang_content($firstType->term_id, 'product_type', 'name'),
		'slug' => $firstType->slug
	);
	
	$secondType = pods('product_type', array(
		'where' => 't.term_id = '.$firstType->parent
	))->fetch();
	
	if ($secondType) {
		$breadcrumbs[] = array(
			'name' => get_the_lang_content($secondType['term_id'], 'product_type', 'name'),
			'slug' => $secondType['slug']
		);
		$breadcrumbs[0]['slug'] = $breadcrumbs[1]['slug'].'/'.$breadcrumbs[0]['slug'];
	}
	
	$breadcrumbs = array_reverse($breadcrumbs);
	
	get_header();
	
?>

<div id="content">
	<div class="box" style="color:<?php echo $product->display('colour'); ?>;border-color:<?php echo $product->display('colour'); ?>;">
		<h1><?php the_lang_content($product->id(), 'product', 'post_title'); ?></h1>
		<ul id="breadcrumb">
			<li><a href="<?php echo home_url().'/products'; ?>"><?php lang_split('Products', 'Produits'); ?></a></li>
			<?php foreach ($breadcrumbs as $breadcrumb) { ?>
			<li>></li>
			<li><a href="<?php echo home_url().'/products/'.$breadcrumb['slug']; ?>"><?php echo $breadcrumb['name']; ?></a></li>
			<?php } ?>
		</ul>
		<?php if ($product->field('new') === '1') { ?>
		<div class="new">New</div>
		<?php } ?>
		<img src="<?php echo $product->display('illustration'); ?>" class="illustration">
		<h2 style="color:<?php echo $product->display('colour'); ?>;"><?php echo strip_tags(get_the_lang_content($product->id(), 'product')); ?></h2>
		<div class="clear"></div>
		<div class="separator grey"><span><?php lang_split('Other products', 'Autres produits'); ?></span></div>
		<ul id="productTypes">
			<?php $productTypes = get_product_types(); ?>
			<?php while ($productTypes->fetch()) {  ?>
			<li>
				<a href="<?php echo home_url().'/products/'.$productTypes->display('slug'); ?>">
					<img src="<?php echo $productTypes->display('packaging'); ?>">
					<h2 <?php if ($productTypes->position()%2 > 0) { echo 'class="alt"'; } ?>><?php the_lang_content($productTypes->id(), 'product_type', 'name'); ?> <span><?php echo $productTypes->field('description'); ?></span></h2>
				</a>
			</li>
			<?php } ?>
		</ul>
	</div>
	<div id="productInfo" style="background-color:<?php echo $product->display('colour'); ?>;color:<?php echo $product->field('colour'); ?>;">		
		<?php
			
			$ingredients = $product->field('ingredient');
			if (count($ingredients) > 0) {
			
		?>
		<div id="fruit">
		<?php foreach ($ingredients as $ingredient) { 
			$fruit = pods('ingredient', $ingredient['term_id']); ?>		
			<a href="#" data-description="<?php echo rawurlencode(get_the_lang_content($fruit->id(), 'ingredient', 'description')); ?>"><img src="<?php echo $fruit->display('icon'); ?>" alt="<?php the_lang_content($fruit->id(), 'ingredient', 'name'); ?>"></a>
		<?php } ?>
			<div id="fact">
				<h3></h3>
				<p></p>
			</div>
		</div>
		<?php } ?>
		<div id="ingredients">
			<h3>Ingredients:</h3>
			<p><?php the_lang_content($product->id(), 'product', 'ingredients'); ?></p>
		</div>
		<div id="circles">
			<?php if (is_canada() && ($firstType->slug === 'fruity-chomps' || $secondType['slug'] === 'purees')) { ?>
			<img src="<?php bloginfo('template_url'); ?>/images/products/prepared-in-canada.png" alt="Prepared in Canada">
			<?php } ?>
			<img src="<?php bloginfo('template_url'); ?>/images/products/organic-<?php echo is_canada() ? 'canada' : 'usa'; ?>.png" alt="Organic">
			<img src="<?php bloginfo('template_url'); ?>/images/products/gluten-free.png" alt="Gluten Free">
			<div id="age"><?php the_lang_content($product->id(), 'product', 'suggested_age', true); ?></div>
		</div>
		<div id="facts">
			<h3>Nutrition Facts</h3>
			<h4><?php the_lang_content($product->id(), 'product', 'portion_size'); ?></h4>
			<table>
				<tr>
					<th colspan="2">Amount</th>
				</tr>
				<tr>
					<td>Calories</td>
					<td><?php the_lang_content($product->id(), 'product', 'calories'); ?></td>
				</tr>
				<tr>
					<td>Fat</td>
					<td><?php the_lang_content($product->id(), 'product', 'fat'); ?></td>
				</tr>
				<tr>
					<td>Sodium</td>
					<td><?php the_lang_content($product->id(), 'product', 'sodium'); ?></td>
				</tr>
				<tr>
					<td>Carbohydrates</td>
					<td><?php the_lang_content($product->id(), 'product', 'carbohydrates'); ?></td>
				</tr>
				<tr>
					<td class="alt">Fibre</td>
					<td><?php the_lang_content($product->id(), 'product', 'fibre'); ?></td>
				</tr>
				<tr>
					<td class="alt">Sugars</td>
					<td><?php the_lang_content($product->id(), 'product', 'sugars'); ?></td>
				</tr>
				<tr>
					<td>Protein</td>
					<td><?php the_lang_content($product->id(), 'product', 'protein'); ?></td>
				</tr>
			</table>
			<table>
				<tr>
					<th colspan="2">% Daily Value</th>
				</tr>
				<tr>
					<td>Vitamin A</td>
					<td><?php the_lang_content($product->id(), 'product', 'vitamin_a'); ?>%</td>
				</tr>
				<tr>
					<td>Vitamin C</td>
					<td><?php the_lang_content($product->id(), 'product', 'vitamin_c'); ?>%</td>
				</tr>
				<tr>
					<td>Calcium</td>
					<td><?php the_lang_content($product->id(), 'product', 'calcium'); ?>%</td>
				</tr>
				<tr>
					<td>Iron</td>
					<td><?php the_lang_content($product->id(), 'product', 'iron'); ?>%</td>
				</tr>
			</table>
		</div>
	</div>
	<div class="clear"></div>
</div>

<?php get_footer(); ?>