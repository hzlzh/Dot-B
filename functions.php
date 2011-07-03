<?php
// Register nav_menu
if ( function_exists('register_nav_menu') ) { register_nav_menu('primary', 'header_menu'); }

// Register sidebar
register_sidebar(array(
	'before_widget' => '<div class="side_box" id="%2$s">'."\n",
	'after_widget' => "</div>\n",
	'before_title' => '<h3 class="sidebar_title">',
	'after_title' => "</h3>\n",
	'name' => 'Sidebar',
	'id' => 'right-sidebar'
));

// Wp_tag_cloud Widget
function colorCloud($text) { 
$text = preg_replace_callback('|<a (.+?)>|i', 'colorCloudCallback', $text);
return $text;
} 
function colorCloudCallback($matches) { 
$text = $matches[1];
$color = dechex(rand(0,16777215));//修改此处可以控制随机色彩值的范围
$pattern = '/style=(\'|\")(.*)(\'|\")/i';
$text = preg_replace($pattern, "style=\"color:#{$color};$2;\"", $text);
return "<a $text>";
} 
add_filter('wp_tag_cloud', 'colorCloud', 1);

// Custom Comments List.
function mytheme_comment( $comment, $args, $depth ) {
	$GLOBALS['comment'] = $comment;
	if ( $post = get_post($post_id) ) {
                       if ( $comment->user_id === $post->post_author )
                               $bypostauthor = 'by-post-author';
               }
	switch ( $comment->comment_type ) :
		case '' :
	?>
	<li <?php comment_class(); ?> id="li-comment-<?php comment_ID(); ?>">
		<div id="comment-<?php comment_ID(); ?>" class="<?php echo $bypostauthor;?>">
		<div class="comment-author vcard">
			<?php echo get_avatar( $comment, 40 ); ?>
			<?php printf( sprintf( '<cite class="fn">%s</cite>', get_comment_author_link() ) ); ?>
			<span class="comment-meta commentmetadata">
			<?php
				/* translators: 1: date, 2: time */
				printf( __( '%1$s at %2$s', 'dot-b' ), get_comment_date(),  get_comment_time() ); ?><a href="<?php echo esc_url( get_comment_link( $comment->comment_ID ) ); ?>"> # </a><?php edit_comment_link( __( '(Edit)', 'dot-b' ), ' ' );
			?>
		</span><!-- .comment-meta .commentmetadata -->
		</div><!-- .comment-author .vcard -->
		<?php if ( $comment->comment_approved == '0' ) : ?>
			<em><?php _e( 'Your comment is awaiting moderation.', 'dot-b' ); ?></em>
			<br />
		<?php endif; ?>



		<div class="comment-body"><?php comment_text(); ?></div>

		<div class="reply">
			<?php comment_reply_link( array_merge( $args, array( 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) ); ?>
		</div><!-- .reply -->
	</div><!-- #comment-##  -->

	<?php
			break;
		case 'pingback'  :
		case 'trackback' :
	?>
	<li class="post pingback">
		<p><?php comment_author_link(); ?> - <?php echo $comment->comment_type; ?> on <?php echo date("Y/m/d H:i",$comment->comment_date);?><?php edit_comment_link( __('(Edit)', 'dot-b'), ' ' ); ?></p>
	<?php
			break;
	endswitch;
}


/*Start of Theme Options*/
 
$themename = "Dot-B";
$shortname = "dotb";
$options = array (
 
array( "name" => "General Setting",
	"type" => "title"),
 
array( "type" => "open"),
//----------------------------------------------

array("name" => "Rss Feed URL",
        "desc" => " ( With \"<code>http://</code>\" )   Keep blank to use WordPress default Rss Feed URL.",
        "id" => $shortname."_rss_url",
        "std" => "",
        "type" => "text"),
		
 array(  "name" => "Display Excerpt",
	"desc" => "Display excerpt on Index and Achives page?",
	"id" => $shortname."_is_excerpt",
	"type" => "checkbox",
	"std" => "false"),
	
array(  "name" => "Use Google Analytics?",
	"desc" => "You can get you GA code <a href=\"https://www.google.com/analytics/settings/check_status_profile_handler\" target=\"_blank\">here</a>.",
	"id" => $shortname."_is_ga",
	"type" => "checkbox",
	"std" => "false"),
array( "name" => "Analytics Code",
	"desc" => "",
	"id" => $shortname."_header_stuff",
	"type" => "textarea",
	"std" => ""),
 
array( "type" => "close")
 
);

function mytheme_add_admin() {
 
global $themename, $shortname, $options;
 
if ( $_GET['page'] == basename(__FILE__) ) {
 
if ( 'save' == $_REQUEST['action'] ) {
 
foreach ($options as $value) {
update_option( $value['id'], $_REQUEST[ $value['id'] ] ); }
 
foreach ($options as $value) {
if( isset( $_REQUEST[ $value['id'] ] ) ) { update_option( $value['id'], $_REQUEST[ $value['id'] ]  ); } else { delete_option( $value['id'] ); } }
 
header("Location: themes.php?page=functions.php&saved=true");
die;
 
} else if( 'reset' == $_REQUEST['action'] ) {
 
foreach ($options as $value) {
delete_option( $value['id'] ); }
 
header("Location: themes.php?page=functions.php&reset=true");
die;
 
}
}
 
add_theme_page($themename." Options", "".$themename." Theme Options", 'edit_themes', basename(__FILE__), 'mytheme_admin');
 
}
 
function mytheme_admin() {
 
global $themename, $shortname, $options;
 
if ( $_REQUEST['saved'] ) echo '<div id="message" class="updated fade"><p><strong>'.$themename.' options saved successfully.</strong></p></div>';
if ( $_REQUEST['reset'] ) echo '<div id="message" class="updated fade"><p><strong>'.$themename.' settings reset successfully.</strong></p></div>';
 
?>
<div class="wrap">
<div class="icon32" id="icon-themes"><br></div>
<h2 class="nav-tab-wrapper"><a class="nav-tab nav-tab-active" href="#"><?php echo $themename; ?>Theme Options</a></h2>
<form method="post">
 
<?php foreach ($options as $value) {
switch ( $value['type'] ) {
 
case "open":
?>
<table class="form-table">
<tbody>
<?php break;
 
case "close":
?>
 </tbody>
</table><br />
 
<?php break;
 
case "title":
?>
<h3><?php echo $value['name']; ?></h3>
 
<?php break;
 
case 'text':
?>
<tr valign="top">
<th scope="row"><?php echo $value['name']; ?></th>
<td><fieldset><legend class="screen-reader-text"><span><?php echo $value['name']; ?></span></legend>
<label for="<?php echo $value['id']; ?>">
<input type="<?php echo $value['type']; ?>" value="<?php if ( get_settings( $value['id'] ) != "") { echo get_settings( $value['id'] ); } else { echo $value['std']; } ?>" id="<?php echo $value['id']; ?>" name="<?php echo $value['id']; ?>" id="<?php echo $value['id']; ?>">
<?php echo $value['desc']; ?></label><br>
</fieldset></td>
</tr>
 
<?php
break;
 
case 'textarea':
?>
 
 
 <tr valign="top">
<th scope="row"><?php echo $value['name']; ?></th>
<td><fieldset><legend class="screen-reader-text"><span><?php echo $value['name']; ?></span></legend>
<p><label for="<?php echo $value['id']; ?>"><?php echo $value['desc']; ?></label></p>
<p>
<textarea class="large-text code" id="<?php echo $value['id']; ?>" cols="50" rows="10" name="<?php echo $value['id']; ?>"><?php if ( get_settings( $value['id'] ) != "") { echo get_settings( $value['id'] ); } else { echo $value['std']; } ?></textarea>
</p>
</fieldset></td>
</tr>
 
 
<?php
break;
 
case 'select':
?>

<tr valign="top">
<th scope="row"><label for="<?php echo $value['id']; ?>"><?php echo $value['name']; ?></label></th>
<td><fieldset><legend class="screen-reader-text"><span><?php echo $value['name']; ?></span></legend>
<td>
<select id="<?php echo $value['id']; ?>" name="<?php echo $value['id']; ?>"><?php foreach ($value['options'] as $option) { ?><option<?php if ( get_settings( $value['id'] ) == $option) { echo ' selected="selected"'; } elseif ($option == $value['std']) { echo ' selected="selected"'; } ?>><?php echo $option; ?></option><?php } ?></select>
<?php echo $value['desc']; ?>
</td>
</tr>

 
<?php
break;
 
case "checkbox":
?>

<tr valign="top">
<th scope="row"><?php echo $value['name']; ?></th>
<td><fieldset><legend class="screen-reader-text"><span><?php echo $value['name']; ?></span></legend>
<label for="enable_app"><?php if(get_option($value['id'])){ $checked = "checked=\"checked\""; }else{ $checked = "";} ?>
<input type="checkbox" value="true" id="<?php echo $value['id']; ?>" name="<?php echo $value['id']; ?>" <?php echo $checked; ?> />
<?php echo $value['desc']; ?></label><br>
</fieldset></td>
</tr>

<?php break;
 
}
}
?>
 
<p class="submit">
<input class="button-primary" name="save" type="submit" value="Save Changes" />
<input type="hidden" name="action" value="save" />
</p>
</form>
<form method="post">
<p class="submit" style="text-align: center; margin: 0pt; padding: 0pt;">
<input class="button" name="reset" type="submit" value="Reset All Settings" />
<input type="hidden" name="action" value="reset" />
</p>
</form>
 <div class="updated" id="donate">
<div style="text-align: center;">
		<span style="font-size: 20px;margin: 5px 0;display: block;"><a href="http://zlz.im/">Dot-B 1.5.5</a></span>
		<br>
		Created, Developed and maintained by <a href="http://zlz.im/">HzlzH</a><br>
		If you like the <code>Dot-B</code> theme, please donate.  It will help in developing new features and versions.		<table style="margin:0 auto;">
			<tbody><tr>
				<td style="width:200px;">
					<form action="https://www.paypal.com/cgi-bin/webscr" method="post">
					<input type="hidden" name="cmd" value="_donations">
					<input type="hidden" name="business" value="admin@hzlzh.com">
					<input type="hidden" name="lc" value="US">
					<input type="hidden" name="item_name" value="HzlzH's WordPress Dev">
					<input type="hidden" name="item_number" value="thanks 02">
					<input type="hidden" name="no_note" value="0">
					<input type="hidden" name="currency_code" value="USD">
					<input type="hidden" name="bn" value="PP-DonationsBF:btn_donateCC_LG.gif:NonHostedGuest">
					<input type="image" src="https://www.paypalobjects.com/en_US/i/btn/btn_donateCC_LG.gif" border="0" name="submit" alt="PayPal - The safer, easier way to pay online!">
					<img alt="" border="0" src="https://www.paypalobjects.com/zh_XC/i/scr/pixel.gif" width="1" height="1">
					</form>

				</td>
				
			</tr>
		</tbody></table>
	</div>
</div>
<?php
}
add_action('admin_menu', 'mytheme_add_admin');
?>
