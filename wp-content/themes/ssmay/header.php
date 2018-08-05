<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type"
          content="<?php bloginfo( 'html_type' ); ?>; charset=<?php bloginfo( 'charset' ); ?>"/>
    <link href="<?php bloginfo( 'stylesheet_url' ); ?>" rel="stylesheet" type="text/css"/>
    <script type="text/javascript" src="http://lib.sinaapp.com/js/jquery/1.4.2/jquery.min.js"></script>
    <script type="text/javascript">window.jQuery || document.write('<script type="text/javascript" src="<?php bloginfo( 'template_url' ); ?>/js/jquery.js">\x3C/script>')</script>
    <script type="text/javascript" src="<?php bloginfo( 'template_url' ); ?>/js/jquery_cmhello.js"></script>
	<?php if ( is_home() ) { ?>
        <script type="text/javascript" src="<?php bloginfo( 'template_url' ); ?>/js/jquery.cycle.all.min.js"></script>
	<?php } ?>
    <script type="text/javascript">HcmsLazyload("<?php bloginfo( 'template_url' ); ?>/images/space.gif");</script>
    <!--[if IE 6]>
    <link href="<?php bloginfo('template_url'); ?>/ie6.css" rel="stylesheet" type="text/css"/>
    <script src="http://letskillie6.googlecode.com/svn/trunk/letskillie6.zh_CN.pack.js"></script>
    <script src="<?php bloginfo('template_url'); ?>/js/PNG.js"></script>
    <script>DD_belatedPNG.fix('.png_bg');</script>
    <![endif]-->
    <title><?php if ( is_home() ) { ?><?php bloginfo( 'name' ); ?> - <?php bloginfo( 'description' ); ?><?php } else { ?><?php wp_title( '&laquo;', true, 'right' ); ?><?php bloginfo( 'name' ); ?><?php } ?></title>
	<?php if ( is_home() ) {
		$description = get_option( 'swt_description' );
		$keywords    = get_option( 'swt_keywords' );
	} elseif ( is_category() ) {
		$description = category_description();
		$keywords    = single_cat_title( '', false );
	} elseif ( is_tag() ) {
		$description = tag_description();
		$keywords    = single_tag_title( '', false );
	} elseif ( is_single() ) {
		if ( $post->post_excerpt ) {
			$description = $post->post_excerpt;
		} else {
			$description = substr( strip_tags( $post->post_content ), 0, 240 );
		}
		$keywords = "";
		$tags     = wp_get_post_tags( $post->ID );
		foreach ( $tags as $tag ) {
			$keywords = $keywords . $tag->name . ", ";
		}
	}
	?>
    <meta name="keywords" content="<?php echo $keywords ?>"/>
    <meta name="description" content="<?php echo $description ?>"/>
    <link rel="shortcut icon" href="<?php get_site_url() ?>/favicon.ico"/>
    <link rel="alternate" type="application/rss+xml" title="<?php bloginfo( 'name' ); ?> RSS Feed"
          href="<?php bloginfo( 'rss2_url' ); ?>"/>
    <link rel="alternate" type="application/atom+xml" title="<?php bloginfo( 'name' ); ?> Atom Feed"
          href="<?php bloginfo( 'atom_url' ); ?>"/>
    <link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>"/>
	<?php wp_head(); ?>
    <meta name="chinaz-site-verification" content="bcfe4f0f-5dd6-4e0b-8b92-e4cafb075ef9"/>    <!-- 站长之家 -->
</head>


<body>
<!--<div id="ssmay">   -->
<!--        <ul id="navleft">-->
<!--            <li><a href="http://yuanssi.com/">首 页</a></li>--><?php //wp_list_pages('title_li='); ?>
<!--			<li><a rel="nofollow" href="http://wap.yuanssi.com/">手机版</a></li>-->
<!--			<li><a rel="nofollow" href="http://mail.ssmay.com/">时美邮箱</a></li>-->
<!--        </ul>-->
<!--        <div id="navright" class="m-r-8">-->
<!--            <ul>-->
<!--			   --><?php
//                 global $user_ID, $user_identity, $user_email, $user_login;
//                 get_currentuserinfo();
//                 if (!$user_ID) {
//               ?>
<!--               <li class="toploginbg">-->
<!--                    <form id="loginform" action="-->
<?php //echo get_settings('siteurl'); ?><!--/wp-login.php" method="post">用户名：<input class="toplogin_input" type="text" name="log" id="log" />　密码：<input class="toplogin_input" type="password" name="pwd" id="pwd" />-->
<!--                </li>-->
<!--                <li class="but_login">-->
<!--				        <input type="submit" class="but_loginlogin" value="登录" name="submit" /></form>-->
<!--				</li>-->
<!--				-->
<!--				 <li><a rel="nofollow" href="http://t.qq.com/happy_182010" class="tqq" title="关注我的微博">微博</a></li><li><div class="topline"></div></li><li><a href="mailto:737258678@qq.com" class="rssmail" title="给我发邮件" rel="nofollow">邮箱</a></li>-->
<!--				<li><a href="http://yuanssi.com/" class="help" title="订阅我的文章">订阅</a></li>-->
<!--				--><?php //}
//                              else { ?><!--<div id="navrightr" class="m-r-8"><div class="navrightlogin"><ul><li><a href="-->
<?php //bloginfo('url') ?><!--/wp-admin/">控制面板</a></li>-->
<!--                <li><div class="topline"></div></li>-->
<!--				<li><a href="-->
<?php //bloginfo('url'); ?><!--/wp-admin/post-new.php">撰写文章</a></li><li><div class="topline"></div></li>-->
<!--				<li><a href="-->
<?php //bloginfo('url'); ?><!--/wp-admin/edit-comments.php">评论管理</a></li><li><div class="topline"></div></li>-->
<!--				<li><a href="--><?php //bloginfo('url'); ?><!--/wp-login.php?action=logout&amp;redirect_to=-->
<?php //echo urlencode($_SERVER['REQUEST_URI']) ?><!--">登出</a></li></ul></div></div>--><?php //} ?>
<!--				-->
<!--             </ul>-->
<!--        </div>-->
<!--</div>-->


<div id="header" class="png_bg">
    <div id="search_bg">
        <div id="search_main">
            <div class="logo">
                <a href="/"><img style="width: 360px;height: 120px;" atl="吐槽菌"
                                                 src="<?php bloginfo( 'template_url' ); ?>/images/logo.png"></a>
            </div>

            <div class="logo4"><!--图片广告-->
				<?php if ( get_option( 'swt_top' ) == 'Hide' ) { ?>
					<?php {
						echo '';
					} ?>
				<?php } else {
					include( TEMPLATEPATH . '/includes/ad_c1.php' );
				} ?>
            </div>
        </div>

        <div class="topnav"><!-- 菜单 -->
			<?php wp_nav_menu( array(
				'container'   => '',
				'items_wrap'  => '<ul id="menu" class="menu">%3$s</ul>',
				'fallback_cb' => ''
			) ); ?>
			<?php include( TEMPLATEPATH . '/searchform.php' ); ?>
        </div>

        <div class="logo9"><!-- 菜单附页开始 -->
            <div class="logo1">
                <div class="aa"><strong>
                        梗<br>
                        词</strong>
                </div>
                <div class="logo2">
                    <ul>
                        <li><a href="<?php get_site_url() ?>/tag/fanxiangchouyan">反向抽烟</a></li>
                        <li><a href="<?php get_site_url() ?>/tag/laixinkan">来信砍</a></li>
                        <li><a href="<?php get_site_url() ?>/tag/tiandechi">天德池</a></li>
                        <li id="chanping"><a href="<?php get_site_url() ?>/zhexue">哲学</a>
                        </li>
                    </ul>
                    <ul>
                        <li><a href="<?php get_site_url() ?>/tag/shuangfen">爽粉</a></li>
                        <li><a href="<?php get_site_url() ?>/tag/pipixia">皮皮虾</a></li>
                        <li id="chanping"><a href="<?php get_site_url() ?>/tag/taiquanjinggao">泰拳警告</a>
                        </li>
                        <li><a href="<?php get_site_url() ?>/tag/taigang">抬杠</a></li>
                    </ul>
                </div>
            </div>
            <div class="logo1">
                <div class="aa"><strong>
                        健<br>
                        身</strong>
                </div>
                <div class="logo2">
                    <ul>
                        <li><a href="<?php get_site_url() ?>/tag/yujia">瑜伽</a></li>
                        <li><a href="<?php get_site_url() ?>/tag/youyong">游泳</a></li>
                        <li id="chanping"><a
                                             href="<?php get_site_url() ?>/tag/paobu">跑步</a></li>
                        <li><a href="<?php get_site_url() ?>/tag/pingpengqiu">乒乓球</a></li>
                        <li><a href="<?php get_site_url() ?>/tag/anmo">按摩</a></li>
                    </ul>
                    <ul>
                        <li><a href="<?php get_site_url() ?>/tag/wangqiu">网球</a></li>
                        <li><a href="<?php get_site_url() ?>/tag/lanqiu">篮球</a></li>
                        <li><a href="<?php get_site_url() ?>/tag/zuqiu">足球</a></li>
                        <li id="chanping"><a
                                             href="<?php get_site_url() ?>/tag/ticao">广场舞</a></li>
                    </ul>
                </div>
            </div>
            <div class="logo1">
                <div class="aa"><strong>
                        美<br>
                        食</strong>
                </div>
                <div class="logo2">
                    <ul>
                        <li><a href="<?php get_site_url() ?>/tag/kafei">咖啡</a></li>
                        <li><a href="<?php get_site_url() ?>/tag/maizhiping">麦制品</a></li>
                        <li><a href="<?php get_site_url() ?>/tag/shupian">薯片</a></li>
                        <li id="chanping"><a
                                             href="<?php get_site_url() ?>/tag/xuegao">雪糕</a></li>
                    </ul>
                    <ul>
                        <li><a href="<?php get_site_url() ?>/tag/chuantongxiaochi">传统小吃</a></li>
                        <li><a href="<?php get_site_url() ?>/tag/miantiao">面条</a></li>
                        <li><a href="<?php get_site_url() ?>/tag/qiaokeli">巧克力</a></li>
                        <li><a href="<?php get_site_url() ?>/tag/shengxian">生鲜</a></li>
                    </ul>
                </div>
            </div>
            <div class="logo1">
                <div class="aa"><strong>
                        娱<br>
                        乐</strong>
                </div>
                <div class="logo2">
                    <ul>
                        <li><a href="<?php get_site_url() ?>/tag/erciyuan">二次元</a></li>
                        <li id="chanping"><a href="<?php get_site_url() ?>/tag/wangyou">网游</a>
                        </li>
                        <li><a href="<?php get_site_url() ?>/tag/danji">单机</a></li>
                        <li><a href="<?php get_site_url() ?>/tag/henban">横版</a></li>
                    </ul>
                    <ul>
                        <li><a href="<?php get_site_url() ?>/tag/bagua">八卦</a></li>
                        <li><a href="<?php get_site_url() ?>/tag/huoyingrenzhe">火影忍者</a></li>
                        <li><a href="<?php get_site_url() ?>/tag/mingxing">明星</a></li>
                        <li id="chanping"><a
                                             href="<?php get_site_url() ?>/zhuanti-jianfei.html">高分电影</a></li>
                    </ul>
                </div>
            </div>
        </div> <!-- 菜单附页完 -->


        <div class="clearfix"></div>
    </div>
</div>