<div class="cms-page-module-frame module-style-style1">
<div class="cms-module-frame">
<div nctype="cms_module_content" class="cms-module-frame-w5">
                        <!-- 文章　-->
<div class="cms-module-assembly-html">
<div class="content-box">
<div id="block1_html_content" nctype="object_module_edit">
<div id="section3">
	<div class="span9">
		<div class="newstitle">
			<h2>
				<span>头条：</span> <a href="<?php echo getCMSArticleUrl($value['article_id']);?>"><?php echo $value['article_title'];?>豪华紧凑型两厢来袭 身材虽小质感不减</a>
			</h2>
			<ul>
				<li>
					<a>奥迪A3购车手册</a>
				</li>
				<li>
					<a>奔驰A级</a>
				</li>
				<li>
					<a>宝马1系</a>
				</li>
				<li>
					<a>雷克萨斯CT</a>
				</li>
			</ul>
		</div>
		<div class="row1">
			<div class="span5 newsimg">
				<a href="<?php echo(CMS_SITE_URL.'/index.php?act=article&op=article_detail&article_id='.$output['art_img_list'][0]['article_id']);?>"><img src="../cms/templates/default/images/cms_index/imgnews1.jpg" /><span><?php echo($output['art_img_list'][0]['article_title']);?></span></a>
			</div>
			<div class="span7">
				<div class="newsul">
				<?php if(is_array($output['art_top_list']) && !empty($output['art_top_list'])){;?>
					<h4>
						<a><?php echo($output['art_top_list'][0]['article_title']);?></a>
					</h4>
					<ul>
					<?php $count = count($output['art_top_list']);
						if($count>1){
						for($i=1;$i<($count-1);$i++){?>
						<li><a><?php echo($output['art_top_list'][$i]['article_title'])?></a></li>
					<?php }}?>
					</ul>
				<?php }?>
				</div>
			</div>
		</div>
		<div class="row2">
			<?php if(is_array($output['art_img_list'][2]) && !empty($output['art_img_list'][1])){?>
			<div class="span5 newsimg">
				<a href="<?php echo(CMS_SITE_URL.'/index.php?act=article&op=article_detail&article_id='.$output['art_img_list'][1]['article_id']);?>"><img class="image_lazy_load" data-src="<?php echo getCMSArticleImageUrl($value['article_attachment_path'], $value['article_image'], 'list');?>" src="<?php echo getLoadingImage();?>" alt="" /><!-- <img src="<?php echo(BASE_SITE_URL.'/data/upload/cms/article/1/05482611715432475_max.jpg')?>" /> --> <span><?php echo($output['art_img_list'][1]['article_title']);?></span> </a>
			</div>
			<?php }?>
			<div class="span7">
				<div class="newsul">
					<h4>
						<a>告别微面 消费升级！不到10万就可以提走的MPV</a>
					</h4>
					<ul>
						<li>
							<a>新款GLA标准版谍照</a> <a>新汉兰达专利图</a> <a>宝沃BX5入门车型谍照</a> 
						</li>
						<li>
							<a>比速T7谍照曝光</a> <a>现代两厢性能车i30 N谍照</a> <a>特斯拉Model Y</a> 
						</li>
						<li>
							<a>大众将推出19款新车</a> <a>幻速S6新增5MT车型</a> <a>MG两款全新SUV</a> 
						</li>
						<li>
							<a>试东风风行CM7</a> <a>试哈弗H6 Coupe</a> <a>测启辰M50V 1.6L尊享版</a> 
						</li>
					</ul>
				</div>
			</div>
		</div>
	</div>
	<div class="span3 sright">
		<h3>
			<a>精彩推荐</a>
		</h3>
		<ul>
			<?php if(is_array($output['article_com_list']) && !empty($output['article_com_list'])){
				foreach($output['article_com_list'] as $com_article){?>
				<li><a href="<?php echo APP_SITE_URL.'/index.php?act=article&op=article_detail&article_id='.$com_article['article_id'];?>"><?php echo($com_article['article_title']);?></a></li>
			<?php }}?>
		</ul>
	</div>
</div>
</div>
</div>
</div>
</div>
</div>
</div>