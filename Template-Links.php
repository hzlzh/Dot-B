<?php
/*
Template Name: Template-Links
*/
get_header(); ?>
<style type="text/css">
.mylink{
	overflow: hidden;
	margin-bottom:1em;
}
.mylink li {
    background: none repeat scroll 0 0 #FFFFFF;
    border: 1px solid #AAAAAA;
    float: left;
    height: 16px;
    list-style: none outside none;
    margin: 5px 5px 0;
    padding: 2px;
    width: 140px;
}
.mylink li:hover{
background:#ddd;
}
.mylink li img{
	background: none repeat scroll 0 0 transparent;
	border: 0 none;
	float: left;
	padding: 0;
	height:16px;
	width:16px;
}
.mylink li a{
    height: 16px;
    line-height: 16px;
    padding-left: 5px;
}
</style>

<div id="main">
	<div id="content">
	<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
		<div <?php post_class(); ?> id="post-<?php the_ID(); ?>">
			<h2 class="post_title_h2"><a.href=""></a></h2>

			<div class="post_content">
				<div class="post_content">
								<p>&ndash; Home Page &ndash;</p>
				<div class="mylink">
				<ul>
				<li><a target="_blank".href=""></a></li>
				<li><a target="_blank".href=""></a></li>
				<li><a target="_blank".href=""></a></li>
				<li><a target="_blank".href=""></a></li>
				</ul>
				</div>
				<p>&ndash; Links Page &ndash;</p>
				<div class="mylink">
				<ul>
				<li><a target="_blank".href=""></a></li>
				<li><a target="_blank".href=""></a></li>
				<li><a target="_blank".href=""></a></li>
				<li><a target="_blank".href=""></a></li>
				</ul>
				</div>
				<p>&ndash; Page Rank &ndash;<br>
				<span style="overflow: hidden;"><span style="float: left; padding-left: 10px;"><a target="_blank".href=""></a>  PR: </span><img width="66" height="13" alt="Page Rank 5" src="http://zlz.im/up/pagerank5.gif" style="background: none repeat scroll 0pt 0pt transparent; border: 0pt none; padding: 0pt 0pt 0pt 33px;"><br>
				</span></p>
			</div>
				<?php wp_link_pages('before=<div id="page-links">&after=</div>'); ?>
			</div>
		</div>
		<div class="post_info_bootom">
			<div class="post_meta"><?php the_tags('<ul><li>','</li><li>','</li></ul>'); ?></div>  
			<div class="post_readmore"><?php comments_popup_link(__('Leave a Reply ?', 'dot-b'),__('[ 1 Reply ]', 'dot-b'),__('[ % Replies ]', 'dot-b'), '', ''); ?></div>	
		</div>		
	<?php endwhile; else: ?>
		<div <?php post_class(); ?> id="post-<?php the_ID(); ?>">
			<h2 class="post_title_h2"><?php _e('Nothing Found', 'dot-b'); ?></h2>
		</div>
	<?php endif; ?>
		<div id="comments">
		 <?php comments_template( '', true ); ?>
		</div>
	</div><!-- #content -->
<?php get_sidebar(); ?>
<div class="clear"></div>
</div><!-- #main -->
<?php get_footer(); ?>
<script type="text/javascript">
jQuery(document).ready(function(jQuery){
 
jQuery(".mylink a").each(function(e){
	jQuery(this).prepend("<img src=http://www.google.com/s2/favicons?domain="+this.href.replace(/^(http:\/\/[^\/]+).*$/, '$1').replace( 'http://', '' )+">");
});
 
});
</script>