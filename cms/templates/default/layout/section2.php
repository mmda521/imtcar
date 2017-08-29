<div class="cms-page-module-frame module-style-style1">
<div class="cms-module-frame">
<div nctype="cms_module_content" class="cms-module-frame-w5">
                        <!-- 文章　-->
<div class="cms-module-assembly-html">
<div class="content-box">
<div id="block1_html_content" nctype="object_module_edit">
<div id="section2">
	<div class="span6">
		<div id="slide2">
			<?php if(is_array($output['pic_com_list']) && !empty($output['pic_com_list'])){?>
			<?php $count_num = count($output['pic_com_list']);?>
			<ul id="slidebox2" style="left:-600px;">
				<li>
					<a href="<?php echo getCMSPictureUrl($output['pic_com_list'][4]['picture_id']);?>" target="_blank"><img src="<?php echo getCMSArticleImageUrl($output['pic_com_list'][4]['picture_attachment_path'], $output['pic_com_list'][4]['picture_image']);?>" alt="<?php echo $output['pic_com_list'][4]['picture_title'];?>" class="t-img"/> 
					<div class="txt">
						<span><?php echo ($output['pic_com_list'][4]['picture_title']);?>></span> <em><b>5</b>/<b>5</b></em> 
					</div>
</a> 
				</li>
				<?php foreach($output['pic_com_list'] as $k => $pic_com){?>
				<li>
					<a href="<?php echo getCMSPictureUrl($pic_com['picture_id']);?>" target="_blank"> <img src="<?php echo(getCMSArticleImageUrl($pic_com['picture_attachment_path'], $pic_com['picture_image'], 'max'))?>" /> 
					<div class="txt">
						<span><?php echo($pic_com['picture_title']);?></span><em><b><?php echo($k+1);?></b>/<b>5</b></em> 
					</div>
</a> 
				</li>
				<?php }?>
				<li>
					<a href="<?php echo getCMSPictureUrl($output['pic_com_lsit'][0]['picture_id']);?>" target="_blank"><img src="<?php echo(getCMSArticleImageUrl($output['pic_com_lsit'][0]['picture_attachment_path'], $output['pic_com_lsit'][0]['picture_image'], 'max'))?>"/>
					<div class="txt">
						<span><?php echo($output['pic_com_lsit'][0]['picture_title'])?></span> <em><b>1</b>/<b>5</b></em> 
					</div>
</a> 
				</li>
			</ul>
			<?php }?>
<a href="javascript:;" id="prev2" class="arrow"> <img src="../cms/templates/default/images/cms_index/arrowl.png" /> </a> <a href="javascript:;" id="next2" class="arrow"> <img src="../cms/templates/default/images/cms_index/arrowr.png" /> </a> 
		</div>
	</div>
	<div class="span6 sright">
		<?php if(is_array($output['pic_latest_list']) && !empty($output['pic_latest_list'])){?>
		<ul class="w">
			<?php foreach($output['pic_latest_list'] as $pic_latest){?>
			<li>
				<a href="<?php echo getCMSPictureUrl($pic_latest['picture_id']);?>"> <img src="<?php echo(getCMSArticleImageUrl($pic_latest['picture_attachment_path'], $pic_latest['picture_image'], 'max'))?>"/> <span><?php echo($pic_latest['picture_title']);?></span> </a> 
			</li>
			<?php }?>
		</ul>
		<?php }?>
	</div>
</div>
</div>
</div>
</div>
</div>
</div>
</div>