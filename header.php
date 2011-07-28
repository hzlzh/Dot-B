<?php
global $dotb_options;
$dotb_settings = get_option( 'dotb_options', $dotb_options );
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" <?php language_attributes(); ?>>
<head>
<meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>" />
<title><?php
        // Logic of printing the <title> tag 
        global $page, $paged;
        echo trim(wp_title( '', false, 'right' ));
        if ( !is_home() ) echo " | ";
			bloginfo( 'name' );
        // Add the blog description only for home.
        $site_description = get_bloginfo( 'description', 'display' );
        if ( $site_description && is_home() && !$paged )
            echo " | $site_description";
        // Paged format
        if ( $paged >= 2 || $page >= 2 )
			echo ' - ' . sprintf( __( 'Page %s', 'dot-b' ), max( $paged, $page ) );
        ?></title>
<link rel="profile" href="http://gmpg.org/xfn/11" />
<link rel="stylesheet" type="text/css" media="all" href="<?php bloginfo( 'stylesheet_url' ); ?>" />
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
<?php 
if ( is_singular() && get_option( 'thread_comments' ) ) wp_enqueue_script( 'comment-reply' );
wp_enqueue_script('jquery','/wp-includes/js/jquery/jquery.js','','','true'); ?>
<?php wp_head(); ?>
<?php if ($dotb_settings['dotb_is_ga']) echo $dotb_settings['dotb_analytics_code']; ?>
</head>
<body <?php body_class(); ?>>
<?php if($dotb_settings['dotb_is_colorbar']) : ?><div id="top-bar"></div><?php endif;?>
<div id="wrapper">
	<div id="header">
		<div id="logo">
			<a href="<?php echo home_url( '/' ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a>
			<div id="description"><?php bloginfo( 'description' ); ?></div>
		</div>
		<div id="header_right">
			<div id="header_meta">
				<div id="header_search_area"><?php get_search_form(); ?>
				</div>
				<a id="rss" rel="external nofollow" href="<?php if($dotb_settings['dotb_rss_url'] != '') { echo $dotb_settings['dotb_rss_url']; } else { bloginfo('rss2_url'); } ?>" title="<?php _e('RSS Feed', 'dot-b'); ?>" ><?php _e('RSS Feed', 'dot-b'); ?></a>
			</div>
			<div class="clear"></div>
			<div id="social">
				<?php if(has_nav_menu( 'social_media' )) : wp_nav_menu(array('theme_location' => 'social_media','depth' => '1', 'fallback_cb' => false)); else : ?>
				<div class="menu-default-container">
					<ul class="menu" id="menu-default">
						<li class="facebook"><a target="_blank" href="http://#">Facebook</a></li>
						<li class="twitter"><a target="_blank" href="http://#">Twitter</a></li>
					</ul>
				</div>
				<?php endif;?>
			</div>
		</div>
		<?php if ( get_header_image() ) : ?>
		<img src="<?php header_image(); ?>" width="<?php echo HEADER_IMAGE_WIDTH; ?>" height="<?php echo HEADER_IMAGE_HEIGHT; ?>" alt="" />
		<?php endif; ?>
		<div class="header_menu"><?php wp_nav_menu('link_before=<span>&link_after=</span>'); ?></div>
	</div>