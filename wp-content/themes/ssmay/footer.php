<!-- //底部模板 -->

<div id="footer" class="clearfix">

    <div class="con_box ">

	<?php wp_reset_query();if ( is_home()){ ?>

    	<div class="flink">

			<strong>友情链接:</strong>

		<?php Hcms_links("txt",24) ?>

		<a target="_blank" title="点击此处申请链接" href="http://yuanssi.com/liuyanban" class="curflink">申请链接</a>

      </div>

	  <?php } ?>

          <div class="footer_bug">
			 <a target="_blank" href="http://yuanssi.com/sitemap.html">网站导航</a> | <a href="<?php echo get_option('home'); ?> ">望远镜基础</a> | <a href="<?php echo get_option('home'); ?> ">望远镜选购</a> | <a href="<?php echo get_option('home'); ?> ">望远镜使用</a> | <a href="<?php echo get_option('home'); ?>">望远镜保养</a> | <a target="_blank" href="http://yuanssi.com/sitemap_baidu.xml">网站地图</a>
          </div>
    </div>

    	<div class="copyright">

      	 <p>
		    Copyright (c) 2012  All rights reserved   | 版权所有: 
			<a href="<?php echo home_url( '/' ); ?>" target="_parent"><?php bloginfo('name'); ?></a>
			<?php echo stripslashes(get_option('swt_track_code')); ?>  <?php echo get_num_queries(); ?>次查询 
		</p>
		<p>广告联系QQ：737258678 广告服务 意见反馈 E-mail： 737258678@qq.com</p>
		<p>
		郑重声明：未经授权，禁止转载、复制，如有违反，追究法律责任
		</p>
        <p id="ssmay">
		
<!--		 <script type="text/javascript" src="http://js.tongji.linezing.com/302341806/tongji.js"></script><script type="text/javascript" src="http://js.tongji.linezing.com/302341806/tongji.js"></script><script type="text/javascript" src="http://js.tongji.linezing.com/302341806/tongji.js"></script><script type="text/javascript" src="http://js.tongji.linezing.com/302341806/tongji.js"></script><script type="text/javascript" src="http://js.tongji.linezing.com/302341806/tongji.js"></script>Powered by<a href="http://yuanssi.com/" target="_blank">望远镜什么牌子的好</a><script type="text/javascript" src="http://js.tongji.linezing.com/302341806/tongji.js"></script>-->
		 
		 
		 </p>

<!-- /powered -->

   </div>

   

   <?php wp_footer(); ?>

		<div id="shangxia"><div id="shang" title="↑ 返回顶部"></div>

		<?php if ( is_singular() ){ ?>

		<div id="comt" title="查看评论"></div>

		<script type="text/javascript" src="<?php bloginfo('template_directory'); ?>/comments-ajax.js"></script>

		<?php } ?>

		<div id="xia" title="↓ 移至底部"></div>

		<div id="myrss" title="<?php echo get_option('swt_rss'); ?>" onClick="window.open('<?php echo get_option('swt_rsssub'); ?>','_blank');"></div></div>

</div>

</body>

</html>

