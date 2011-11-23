<?php
$theme_data = get_theme_data(TEMPLATEPATH.'/style.css');
// Get author information
global $dotb_options;
$settings = get_option( 'dotb_options', $dotb_options );
// Default options values
$temp_copyright = 'Copyright &copy; '.date("Y").' '.'<a href="'.home_url( '/' ).'" title="'.esc_attr( get_bloginfo( 'name') ).'" rel="home">'.esc_attr( get_bloginfo( 'name') ).'</a>';
$temp_readmore = __('>>Read more' , 'dot-b');

$dotb_options = array(
	'dotb_rss_url' => get_bloginfo('rss2_url'),
	'dotb_is_excerpt' => false,
	'dotb_excerpt_length' => 55,
	'dotb_readmore' => $temp_readmore,
	'dotb_is_ga' => false,
	'dotb_analytics_code' => '',
	'dotb_footer' => $temp_copyright,
	'dotb_is_colorbar' => true,
	'dotb_is_sqlcount' => false,
	'dotb_version' => $theme_data['Version'],
	'dotb_is_comment_note' => true
);

function dotb_validate_options( $input ) {
	global $dotb_options;

	$settings = get_option( 'dotb_options', $dotb_options );
	
	if ( ! isset( $input['dotb_rss_url'] ) )
	$input['dotb_rss_url'] = null;
	$input['dotb_rss_url'] = esc_url_raw( $input['dotb_rss_url'] );
	
	if ( ! isset( $input['dotb_is_excerpt'] ) )
	$input['dotb_is_excerpt'] = null;
	$input['dotb_is_excerpt'] = ( $input['dotb_is_excerpt'] == 1 ? 1 : 0 );
	
	if ( ! isset( $input['dotb_excerpt_length'] ) )
	$input['dotb_excerpt_length'] = null;
	$input['dotb_excerpt_length'] = intval($input['dotb_excerpt_length']);
	
	if ( ! isset( $input['dotb_readmore'] ) )
	$input['dotb_readmore'] = null;
	$input['dotb_readmore'] = balanceTags($input['dotb_readmore']);
	
	if ( ! isset( $input['dotb_is_ga'] ) )
	$input['dotb_is_ga'] = null;
	$input['dotb_is_ga'] = ( $input['dotb_is_ga'] == 1 ? 1 : 0 );
	
	if ( ! isset( $input['dotb_analytics_code'] ) )
	$input['dotb_analytics_code'] = null;
	$input['dotb_analytics_code'] = balanceTags($input['dotb_analytics_code']);
	
	if ( ! isset( $input['dotb_footer'] ) )
	$input['dotb_footer'] = null;
	$input['dotb_footer'] = balanceTags($input['dotb_footer']);

	if ( ! isset( $input['dotb_is_colorbar'] ) )
	$input['dotb_is_colorbar'] = null;
	$input['dotb_is_colorbar'] = ( $input['dotb_is_colorbar'] == 1 ? 1 : 0 );
	
	if ( ! isset( $input['dotb_is_sqlcount'] ) )
	$input['dotb_is_sqlcount'] = null;
	$input['dotb_is_sqlcount'] = ( $input['dotb_is_sqlcount'] == 1 ? 1 : 0 );
	
	if ( ! isset( $input['dotb_version'] ) )
	$input['dotb_version'] = null;
	$input['dotb_version'] = intval( $input['dotb_version'] );
	
	if ( ! isset( $input['dotb_is_comment_note'] ) )
	$input['dotb_is_comment_note'] = null;
	$input['dotb_is_comment_note'] = ( $input['dotb_is_comment_note'] == 1 ? 1 : 0 );
	
	return $input;
}

// Custom excerpt number
function dotb_excerpt_length($length) {
global $settings;

	return $settings['dotb_excerpt_length'];
}
add_filter('excerpt_length', 'dotb_excerpt_length');

// Custom excerpt read more text
function dotb_continue_reading_link() {
	global $settings;
	return '<p class="read-more"><a href="'. get_permalink() . '">' . $settings['dotb_readmore'] . '</a></p>';
}

function dotb_auto_excerpt_more( $more ) {
	return ' ...' . dotb_continue_reading_link();
}
add_filter( 'excerpt_more', 'dotb_auto_excerpt_more' );

function dotb_custom_excerpt_more( $output ) {
	if ( has_excerpt() && ! is_attachment() ) {
		$output .= dotb_continue_reading_link();
	}
	return $output;
}
add_filter( 'get_the_excerpt', 'dotb_custom_excerpt_more' );

//

function dotb_changing_comment_form_defaults($defaults){
  $defaults['comment_notes_after']='';
  return $defaults;
}
if(!$settings['dotb_is_comment_note']) add_filter('comment_form_defaults','dotb_changing_comment_form_defaults');

if ( is_admin() ) : // Load only if we are viewing an admin page

function dotb_register_settings() {
	// Register settings and call sanitation functions
	register_setting( 'dotb_theme_options', 'dotb_options', 'dotb_validate_options' );
}

add_action( 'admin_init', 'dotb_register_settings' );

// Store categories in array

function dotb_theme_options() {
	// Add theme options page to the addmin menu
	add_theme_page('Dot-B '.__('Theme Options','dot-b'), 'Dot-B '.__('Theme Options','dot-b'), 'edit_theme_options', 'theme_options', 'dotb_theme_options_page' );
}

add_action( 'admin_menu', 'dotb_theme_options' );




function dotb_default_options() {
     global $dotb_options;
     $dotb_options_temp = $dotb_options;
     $options = get_option( 'dotb_options', $dotb_options );
	foreach ( $dotb_options as $dotb_option_key => $dotb_option_value ) {
		if ( isset($options[$dotb_option_key])) {
			$dotb_options[$dotb_option_key] = $options[$dotb_option_key];
		}
	}
     $dotb_options['dotb_version'] = $dotb_options_temp['dotb_version'];
     update_option( 'dotb_options', $dotb_options );
}
add_action( 'init', 'dotb_default_options' );

// Function to generate options page
function dotb_theme_options_page() {
	global $dotb_options;
	if ( ! isset( $_REQUEST['settings-updated'] ) )
		$_REQUEST['settings-updated'] = false;
	if( isset( $_REQUEST['action'])&&('reset' == $_REQUEST['action']) ) 
		delete_option( 'dotb_options' );
	// This checks whether the form has just been submitted. 
?>

	<div class="wrap">
	<style>
	textarea,input[type='text']{width:50%;}
	</style>
	<?php screen_icon(); echo "<h2>" . get_current_theme() .' '.__( 'Theme Options' ,'dot-b' ) . "</h2>";
	// This shows the page's name and an icon if one has been provided ?>
	<?php if ( isset( $_REQUEST['action'])&&('reset' == $_REQUEST['action']) ) : ?>
	<div class="updated fade"><p><strong><?php _e( 'Options reset successfully!','dot-b' ); ?></strong></p></div>
	<?php elseif ( $_REQUEST['settings-updated'] ) : ?>
	<div class="updated fade"><p><strong><?php _e( 'Options saved successfully!','dot-b' ); ?></strong></p></div>
	<?php endif; // If the form has just been submitted, this shows the notification ?>
	
	<form method="post" action="options.php">

	<?php $settings = get_option( 'dotb_options', $dotb_options ); ?>
	
	<?php settings_fields( 'dotb_theme_options' );
	/* This function outputs some hidden fields required by the form,
	including a nonce, a unique number used to ensure the form has been submitted from the admin page
	and not somewhere else, very important for security */ ?>
	<table class="form-table"><!-- Grab a hot cup of coffee, yes we're using tables! -->
	<tbody>

	
	<tr valign="top"><th scope="row"><?php _e( 'Rss Feed URL','dot-b' ); ?></th>
	<td><label for="dotb_rss_url">
	<input id="dotb_rss_url" name="dotb_options[dotb_rss_url]" type="text" value="<?php esc_attr_e($settings['dotb_rss_url']); ?>" /><br><?php _e( '( With "<code>http://</code>" )   Keep blank to use WordPress default Rss Feed URL.','dot-b' ); ?></label>
	</td>
	</tr>

	<tr valign="top"><th scope="row"><?php _e( 'Enable Excerpt','dot-b' ); ?></th>
	<td><label for="dotb_is_excerpt">
	<input type="checkbox" id="dotb_is_excerpt" name="dotb_options[dotb_is_excerpt]" value="1" <?php checked( true, $settings['dotb_is_excerpt'] ); ?> />
	<?php _e( 'Show excerpt in Home and Archives with','dot-b' ); ?></label> 
	<label for="dotb_excerpt_length">
	<input type="text" id="dotb_excerpt_length" style="width:50px;" name="dotb_options[dotb_excerpt_length]" value="<?php esc_attr_e($settings['dotb_excerpt_length']); ?>" /> 
	<?php _e( 'length','dot-b' ); ?>.</label>
	</td>
	</tr>
	
	<tr valign="top"><th scope="row"><?php _e( 'Text of Read More link','dot-b' ); ?></th>
	<td><label for="dotb_readmore">
	<input id="dotb_readmore" name="dotb_options[dotb_readmore]" type="text" value="<?php echo stripslashes($settings['dotb_readmore']); ?>" /><p><strong><?php _e( 'Preview','dot-b' ); ?>:&nbsp;&nbsp;</strong><?php echo '<a>'.esc_attr_e($settings['dotb_readmore']).'</a>'; ?></p></label>
	</td>
	</tr>
	
	<tr valign="top"><th scope="row"><?php _e( 'Use Google Analytics?','dot-b' ); ?></th>
	<td><label for="dotb_is_ga">
	<input type="checkbox" id="dotb_is_ga" name="dotb_options[dotb_is_ga]" value="1" <?php checked( true, $settings['dotb_is_ga'] ); ?> />
	<?php _e( 'You can get you <code>Google Analytics</code> code <a target="_blank" href="https://www.google.com/analytics/settings/check_status_profile_handler">here</a>.','dot-b' ); ?></label>
	</td>
	</tr>
	
	
	<tr valign="top"><th scope="row"><label for="dotb_analytics_code"><?php _e( 'Analytics Code','dot-b' ); ?></label></th>
	<td>
	<textarea id="dotb_analytics_code" name="dotb_options[dotb_analytics_code]" rows="5" cols="30"><?php echo stripslashes($settings['dotb_analytics_code']); ?></textarea>
	</td>
	</tr>

	<tr valign="top"><th scope="row"><label for="dotb_footer"><?php _e( 'Footer Copyright','dot-b' ); ?></label></th>
	<td>
	<textarea id="dotb_footer" name="dotb_options[dotb_footer]" rows="5" cols="30"><?php echo stripslashes($settings['dotb_footer']); ?></textarea><p><strong><?php _e( 'Preview','dot-b' ); ?>:&nbsp;&nbsp;</strong><?php echo stripslashes($settings['dotb_footer']); ?></p>
	</td>
	</tr>

	<tr valign="top"><th scope="row"><?php _e( 'Display colourful bar on header and footer?','dot-b' ); ?></th>
	<td><label for="dotb_is_colorbar">
	<input type="checkbox" id="dotb_is_colorbar" name="dotb_options[dotb_is_colorbar]" value="1" <?php checked( true, $settings['dotb_is_colorbar'] ); ?> />
	<strong><?php _e( 'Preview','dot-b' ); ?>:&nbsp;&nbsp;</strong><span style="font-size: 20px;font-weight: bolder;"><span style="color:#0065cc;">&bull;&bull;&bull;&bull;</span><span style="color:#0fabff;">&bull;&bull;&bull;</span><span style="color:#2a5599;">&bull;&bull;&bull;</span><span style="color:#ff6f6f;">&bull;&bull;&bull;</span><span style="color:#ff0f00;">&bull;&bull;</span><span style="color:#be0800;">&bull;&bull;</span><span style="color:#5b1301;">&bull;&bull;</span><span style="color:#edb012">&bull;</span><span style="color:#9fcf67">&bull;</span><span style="color:#0b9938">&bull;</span></span>
	</label>
	</td>
	</tr>
	
	<tr valign="top"><th scope="row"><?php _e( 'Display SQL count at footer?','dot-b' ); ?></th>
	<td><label for="dotb_is_sqlcount">
	<input type="checkbox" id="dotb_is_sqlcount" name="dotb_options[dotb_is_sqlcount]" value="1" <?php checked( true, $settings['dotb_is_sqlcount'] ); ?> />
	<strong><?php _e( 'Preview','dot-b' ); ?>:&nbsp;&nbsp;</strong><code>{ 29 <?php _e('queries in', 'dot-b');?> 1.018 <?php _e('seconds', 'dot-b');?> }</code>
	</label>
	</td>
	</tr>
	
	<tr valign="top"><th scope="row"><?php _e( 'Display Comment Note below comment form?','dot-b' ); ?></th>
	<td><label for="dotb_is_comment_note">
	<input type="checkbox" id="dotb_is_comment_note" name="dotb_options[dotb_is_comment_note]" value="1" <?php checked( true, $settings['dotb_is_comment_note'] ); ?> />
	<strong><?php _e( 'Preview','dot-b' ); ?>:&nbsp;&nbsp;</strong><code>You may use these <abbr title="HyperText Markup Language">HTML</abbr> &lt;a href=&quot;&quot; title=&quot;&quot;  ...</code>
	</label>
	</td>
	</tr>
	
	</table>
	<input name="dotb_options[dotb_version]" type="hidden" value="<?php esc_attr_e($settings['dotb_version']); ?>">
	<p class="submit"><input type="submit" class="button-primary" value="Save Options" /></p>
	</form>
	<form method="post">
	<p class="submit">
	<input class="button" name="reset" type="submit" value="Reset All Settings" />
	<input type="hidden" name="action" value="reset" />
	</p>
	</form>
	<div class="tips">
	<div id="icon-edit" class="icon32"><br></div>
	<h2><?php _e( 'Some Tips Here','dot-b' ); ?></h2>
	<ul>
		<li><?php _e( '1.Customize your Social Media (Facebook, Twitter, Google+ .etc) according to this','dot-b' ); ?> -> <a href="http://zlz.im/how-to-control-social-media-icons-display-with-wordpress-menu-function/">[<?php _e( 'Instructions','dot-b' ); ?>]</a></li>
		<li><?php _e( '2.Your threaded (nested) comments','dot-b' ); ?> <strong>[<?php echo get_option('thread_comments_depth');?>]</strong> <?php _e( 'levels deep, change it here','dot-b' ); ?> -> <a target="_blank" href="./options-discussion.php">[<?php _e('Settings','dot-b' ); ?>]->[<?php _e('Discussion','dot-b' ); ?>]</a></li>
		<li><?php _e( '3.Change <code>&lt;Body&gt;</code> background image here','dot-b' ); ?> -> <a target="_blank" href="./themes.php?page=custom-background">[<?php _e('Appearance','dot-b' ); ?>]->[<?php _e('Background','dot-b' ); ?>]</a></li>
		<li><?php _e( '4.Customize <code>&lt;Header&gt;</code> image here','dot-b' ); ?> -> <a target="_blank" href="./themes.php?page=custom-header">[<?php _e('Appearance','dot-b' ); ?>]->[<?php _e('Header','dot-b' ); ?>]</a></li>
		<li><?php _e( '5.Download & Customize <code>Social Media Icons</code> from PSD source files here','dot-b' ); ?> -> <a target="_blank" href="http://zlz.im/dot-b-social-media-icons-set-release/">[<?php _e( 'Instructions','dot-b' ); ?>]</a></li>
		<li><?php _e( '6.Use <code>Dot-B Colorful Tag Cloud</code> widget at sidebar','dot-b' ); ?> -> <a href="./widgets.php">[<?php _e('Appearance','dot-b' ); ?>]->[<?php _e( 'Widgets','dot-b' ); ?>]</a></li>
		<li><?php _e( '========= Feel free to get my help by both Twitter: <a href="http://twitter.com/hzlzh">@hzlzh</a> and Email: <a href="mailto:hzlzh.dev@gmail.com">hzlzh.dev@gmail.com</a> =========','dot-b' ); ?></li>
	</ul>
	</div>
<div class="updated" id="donate">
<div style="text-align: center;">
		<span style="font-size: 20px;margin: 5px 0;display: block;"><a href="http://zlz.im/">Dot-B v<?php echo esc_attr_e($settings['dotb_version']);?></a></span>
		<br>
		<?php _e('Created, Developed and maintained by <a href="http://zlz.im/">hzlzh</a><br>If you like the <code>Dot-B</code> theme, please donate. It will help in developing new features and versions.','dot-b' ); ?>
		<table style="margin:0 auto;">
			<tbody><tr>
				<td style="width:200px;">
					<form action="https://www.paypal.com/cgi-bin/webscr" method="post">
					<input type="hidden" name="cmd" value="_donations">
					<input type="hidden" name="business" value="hzlzh.dev@gmail.com">
					<input type="hidden" name="lc" value="US">
					<input type="hidden" name="item_name" value="hzlzh's WordPress Dev">
					<input type="hidden" name="item_number" value="thanks 02">
					<input type="hidden" name="no_note" value="0">
					<input type="hidden" name="currency_code" value="USD">
					<input type="hidden" name="bn" value="PP-DonationsBF:btn_donateCC_LG.gif:NonHostedGuest">
					<input type="image" src="https://www.paypalobjects.com/en_US/i/btn/btn_donateCC_LG.gif" border="0" name="submit" alt="PayPal - The safer, easier way to pay online!">
					<img alt="" border="0" src="https://www.paypalobjects.com/zh_XC/i/scr/pixel.gif" width="1" height="1">
					</form>
				</td>
			</tr>
			</tbody>
		</table>
		<div style="color:#777"><strong><?php _e('Alipay', 'dot-b');?>:</strong> hzlzh.dev@gmail.com</div>
	</div>
</div>
	</div>

	<?php
}

endif;  // EndIf is_admin()