<div class="cms-page-module-frame module-style-style1">
<div class="cms-module-frame">
<div nctype="cms_module_content" class="cms-module-frame-w5">
                        <!-- 文章　-->
<div class="cms-module-assembly-html">
<div class="content-box">
<div id="block1_html_content" nctype="object_module_edit">
<?php if(is_array($output['car_news_list']) && !empty($output['car_news_list'])){?>
<div class="news">
	<div class="news-titles">
		<h3>
			<a>汽车新闻</a> 
		</h3>
<a href="<?php echo(CMS_SITE_URL.'/index.php?act=article&op=article_list&class_id=1')?>"> <span>更多&gt;&gt;</span> </a> 
	</div>
	<div class="news-content">
		<ul class="ul-left">
		<?php foreach($output['car_news_list'][0] as $car_news_left){?>
			<li>
				<a href="<?php echo getCMSArticleUrl($car_news_left['article_id']);?>" target="_blank"> <span><?php echo($car_news_left['article_title']);?></span> </a> 
			</li>
		<?php }?>
		</ul>
		<?php if(!empty($output['car_news_list'][1])){?>
		<ul class="ul-right">
			<?php foreach($output['car_news_list'][1] as $car_news_right){?>
			<li>
				<a href="<?php echo getCMSArticleUrl($car_news_right['article_id']);?>" target="_blank"> <span><?php echo($car_news_right['article_title']);?></span> </a> 
			</li>
		<?php }?>
		</ul>
		<?php }?>
	</div>
</div>
<?php }?>
</div>
</div>
</div>
</div>
</div>
</div>