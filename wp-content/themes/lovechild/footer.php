		<div id="footer">
			&copy; Love Child (Brands) Inc. <?php echo date('Y'); ?>
		</div>
	</div>
	<script type="text/javascript">
		window.root_url = "<?php echo home_url(); ?>";
		window.template_url = "<?php bloginfo('template_url'); ?>";
		window.client_ip = "<?php echo $_SERVER['REMOTE_ADDR']; ?>";
	</script>
	<script type="text/javascript" src="<?php bloginfo('template_url'); ?>/js/jquery-1.10.1.min.js"></script>
	<script type="text/javascript" src="<?php bloginfo('template_url'); ?>/js/imagesloaded.min.js"></script>
	<script type="text/javascript" src="<?php bloginfo('template_url'); ?>/js/selectivizr.min.js"></script>
	<script type="text/javascript" src="<?php bloginfo('template_url'); ?>/js/placeholders.min.js"></script>
	<script type="text/javascript" src="<?php bloginfo('template_url'); ?>/js/index.js"></script>
	<?php //wp_footer(); ?>
</body>
</html>