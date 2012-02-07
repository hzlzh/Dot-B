<?php

/* Mini Gavatar Cache by Willin Kan. */
function my_avatar( $email, $size = '42', $default = '', $alt = false ) {
  $alt = (false === $alt) ? '' : esc_attr( $alt );
  $f = md5( strtolower( $email ) );
  $a =  'http://img.zlz.im/avatar/'. $f. '.jpg';
  $e = '/home/zlz/domains/img.zlz.im/public_html/avatar/'. $f. '.jpg';
  $t = 600; //設定14天, 單位:秒
  if ( empty($default) ) $default = 'http://img.zlz.im/avatar/default.jpg';
  if ( !is_file($e) || (time() - filemtime($e)) > $t ){ //當頭像不存在或文件超過14天才更新
    $r = get_option('avatar_rating');
    //$g = sprintf( "http://%d.gravatar.com", ( hexdec( $f{0} ) % 2 ) ). '/avatar/'. $f. '?s='. $size. '&d='. $default. '&r='. $r; // wp 3.0 的服務器
    $g = 'http://www.gravatar.com/avatar/'. $f. '?s='. $size. '&d='. $default. '&r='. $r; // 舊服務器 (哪個快就開哪個)
    copy($g, $e); $a = esc_attr($g);
  }
  if (filesize($e) < 500) copy($default, $e);
  $avatar = "<img title='{$alt}' alt='{$alt}' src='{$a}' class='avatar avatar-{$size} photo' height='{$size}' width='{$size}' />";
  return apply_filters('my_avatar', $avatar, $email, $size, $default, $alt);
}

function copyright($content) {
	if(is_single()||is_feed()) {
		$content.='<div style="background:#FDFDFD;border: 5px solid #EEEEEE;padding: 5px;">
<span style="font-weight: bold;">版权所有&copy; HzlzH </span>| 本文采用 <a href="http://zlz.im/#copyright" title="署名-非商业性使用-相同方式共享">BY-NC-SA</a> 进行授权
<br>
转载需注明 转自: 《<a title="'.get_the_title().'" href="'.get_permalink().'">'.get_the_title().'</a>》
</div>
';
	}
	return $content;
}
add_filter ('the_content', 'copyright');

/**Mp3 player */
function player($atts, $content=null){
extract(shortcode_atts(array("auto"=>'no',"loop"=>'no'),$atts));	
return '<embed src="'.get_bloginfo("template_url").'/player.swf?soundFile='.$content.'&bg=0xeeeeee&leftbg=0x357dce&lefticon=0xFFFFFF&rightbg=0xf06a51&rightbghover=0xaf2910&righticon=0xFFFFFF&righticonhover=0xffffff&text=0x666666&slider=0x666666&track=0xFFFFFF&border=0x666666&loader=0x9FFFB8&loop='.$loop.'&autostart='.$auto.'" type="application/x-shockwave-flash" wmode="transparent" allowscriptaccess="always" width="290" height="30">';
}
add_shortcode('music','player');
/**FLV player */
function flvplayer($atts, $content=null){
extract(shortcode_atts(array("width"=>'460',"height"=>'330'),$atts));	
return '<embed width="'.$width.'" height="'.$height.'" type="application/x-shockwave-flash" pluginspage="http://www.macromedia.com/go/getflashplayer" quality="high" allowfullscreen="true" src="'.get_bloginfo("template_url").'/flvplayer.swf?&IsAutoPlay=0&IsContinue=0&BarPosition=0&IsShowBar=0&vcastr_file='.$content.'">
';
}
add_shortcode('mv','flvplayer');
 /** Download Image */
function download($atts, $content = null)
    {
     return '<a href="'.$content.'" rel="external nofollow" target="_blank" title="download-Link"><img src="http://zlz.im/up/download.gif" border="0" /></a>';
    }
    add_shortcode("download", "download");
 /** URL **/
function myUrl($atts, $content = null) {
extract(shortcode_atts(array(
"href" => 'http://'
), $atts));
return '<a target="_blank" href="'.$href.'" rel="nofollow">'.$content.'</a>';
}
add_shortcode("url", "myUrl");
/** title **/
function Title($atts, $content=null){
	return '<span style="color: rgb(230, 230, 250);background-color: rgb(0, 100, 0);font-weight:bolder;">'.$content.'</span>';
}
add_shortcode("title", "Title");
// -- END ----------------------------------------
function no_self_ping( &$links ) {
	$home = get_option( 'home' );
	foreach ( $links as $l => $link )
		if ( 0 === strpos( $link, $home ) )
			unset($links[$l]);
}
//no-self-pingback
add_action( 'pre_ping', 'no_self_ping' );
remove_action( 'wp_head', 'feed_links', 2 );//remove default Rss feed
?>