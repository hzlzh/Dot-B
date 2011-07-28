<?php global $dotb_options;
$dotb_settings = get_option( 'dotb_options', $dotb_options ); ?>
	<div id="footer">
		<div id="copyright">
			<div id="site-info">
				<?php echo $dotb_settings['dotb_footer'];?>
			</div>
			<div id="site-generator">
				Powered by <a href="http://wordpress.org/">WordPress</a>
				 | Theme <abbr title="Dot-B v<?php echo $dotb_settings['dotb_version'];?>">Dot-B</abbr> by <a href="http://zlz.im/" >hzlzh</a> <?php if ($dotb_settings['dotb_is_sqlcount']) 
				{ echo '{ '.get_num_queries().' '.__('queries in', 'dot-b').' '.timer_stop(0,3).' '.__('seconds', 'dot-b').' }';}?>
			</div>
		</div><!-- #copyright -->
		<a id="return_top" href="#wrapper" rel="nofollow" title="<?php _e('Back to top', 'dot-b'); ?>"> Δ <?php _e('Top', 'dot-b'); ?></a>
	</div><!-- #footer -->
</div><!-- #wrapper -->
<?php if($dotb_settings['dotb_is_colorbar']) : ?><div id="bottom-bar"></div><?php endif;?>
<?php wp_footer(); ?>
<script type="text/javascript" src="<?php echo get_template_directory_uri();?>/all.js"></script>
<?php if (!$dotb_settings['dotb_is_ga']) echo $dotb_settings['dotb_analytics_code']; ?>
</body>
</html>