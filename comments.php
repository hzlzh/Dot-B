<?php
// Do not delete these lines
	if (!empty($_SERVER['SCRIPT_FILENAME']) && 'comments.php' == basename($_SERVER['SCRIPT_FILENAME']))
		die ('Please do not load this page directly. Thanks!');
	if ( post_password_required() ) { ?>
		<p class="nocomments"><?php _e('This post is password protected. Enter the password to view comments.', 'dot-b'); ?></p>
	<?php
		return;
	}
?>
<!-- You can start editing here. -->
	<?php if ( have_comments() ) { ?>
			<h2 id="comments-title"><span>{ <a href="#respond"  rel="nofollow" title="<?php _e('Leave a comment ?', 'dot-b'); ?>"><?php _e('Leave a comment ?', 'dot-b'); ?></a> }</span></h2>
			<ol class="commentlist" id="thecomments">
					<?php wp_list_comments('type=all&callback=mytheme_comment'); ?>
			</ol>
			<div class="navigation"><?php paginate_comments_links(); ?></div>
	<?php } else { // this is displayed if there are no comments so far ?>
	<?php if ( ! comments_open() && !is_page() ) { ?>
			<h2 id="comments"><?php _e('Comments are closed.','dot-b'); ?></h2>
	<?php } // end ! comments_open() ?>

	<?php } // end have_comments()
	comment_form(); ?>