<div id="sider" class="fr">
	<?php if (get_option('swt_email') == 'Hide') { ?>
		<?php { echo ''; } ?>
		<?php } else { include(TEMPLATEPATH . '/includes/feed_email.php'); } ?>
<div class="clear"></div>

<div id="top_nav">
			<form name="formsearch" method="get" action="<?php bloginfo('home'); ?>">
				<div class="form clearfix">
           		<label for="s" ></label>
           		<input type="text" name="s" class="search-keyword" onfocus="if (this.value == '请输入关键字进行搜索') {this.value = '';}" onblur="if (this.value == '') {this.value = '请输入关键字进行搜索';}" value="请输入关键字进行搜索" />   
         		<button type="submit" class="select_class" onmouseout="this.className='select_class'" onmouseover="this.className='select_over'" />搜索</button>
				</div>
			</form>
            </div>

	<div class="con_box htabs_art clearfix"> 
		<ul class="cooltab_nav sj_nav clearfix">	
		    <li><a href="#" class="active" title="new_art">最新文章</a></li>			
			<li><a href="#" title="hot_art">热门文章</a></li>
					
		</ul>   
		<div id="new_art" class="com_cont">   
			<ul>
				<?php query_posts('posts_per_page=5&caller_get_posts=1'); ?>
				<?php while (have_posts()) : the_post(); ?>
				<li>
				<a target="_blank" href="<?php the_permalink(); ?>" title="<?php the_title(); ?>" class="title"><?php echo cut_str($post->post_title,34); ?></a>
				</li>
				<?php endwhile; ?>
			</ul>                    
		</div>
        <div id="hot_art" class="com_cont">  
            <ul>
				<?php query_posts('posts_per_page=5&caller_get_posts=1&orderby=comment_count'); ?>
				<?php while (have_posts()) : the_post(); ?>
				<li>
				<a target="_blank" href="<?php the_permalink(); ?>" class="title" title="<?php the_title(); ?>"><?php echo cut_str($post->post_title,34); ?></a>
				</li>
				<?php endwhile; ?>
			</ul>      
		</div>		
	</div>
	
	
	
	<div class="con_box hot_box">
		<h3>最新评论</h3>
		<div class="r_comments">
			<ul>
			<?php Get_Recent_Comment(); ?>
			</ul>
		</div>				
	</div>
	
	<div class="con_box htabs_art clearfix"> 
		<ul class="con_box hot_box">			
			<h3>随机推荐</h3>
		</ul>   
		
		<div id="rand_art" >  
			<ul>
				<?php query_posts('posts_per_page=10&caller_get_posts=1&orderby=rand'); ?>
				<?php while (have_posts()) : the_post(); ?>
				<li>
				<a target="_blank" href="<?php the_permalink(); ?>" class="title" title="<?php the_title(); ?>"><?php echo cut_str($post->post_title,34); ?></a>
				</li>
				<?php endwhile; ?>
			</ul>
		</div>   
	</div>
	
	<div class="con_box htabs_art clearfix"> 
		<div id="rand_art" >  
			<script type="text/javascript"> alimama_pid="mm_12995397_2664194_10884097"; 
			alimama_width=265; 
			alimama_height=300; 
			</script> 
			<script src="http://a.alimama.cn/inf.js" type="text/javascript"> 
			</script>
		</div>   
	</div>
	
	


	
	
	<div class="con_box hot_box">
		<h3>热门标签</h3>
			<ul class="tagcloudy">
				<li>
				<?php wp_tag_cloud('number=30&largest=18&smallest=12&unit=px'); ?>
				</li>
				</ul>
	</div> 
	
	<div id="rollstart"></div>
	<?php wp_reset_query(); if (is_singular()) : ?>
		<?php if (get_option('swt_ads') == 'Hide') { ?>
		<?php { echo ''; } ?>
		<?php } else { include(TEMPLATEPATH . '/includes/ad_s.php'); } ?>
		<div class="clear"></div>
	<?php endif; ?>
	</div>
</div> 
</div><!-- //wrapper -->