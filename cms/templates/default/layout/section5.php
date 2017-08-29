<div class="cms-page-module-frame module-style-style1">
<div class="cms-module-frame">
<div nctype="cms_module_content" class="cms-module-frame-w5">
                        <!-- 文章　-->
<div class="cms-module-assembly-html">
<div class="content-box">
<?php if(is_array($output['new_car_list']) && !empty($output['new_car_list'])){?>
<div id="block1_html_content" nctype="object_module_edit">
<div id="section5">
	<div id="section5-title">
		<h3>
			<a>新车图库</a> 
		</h3>
	</div>
	<div class="span12" id="imagegallery">
		<div id="gallerybox">
			<div>
				<ul>
				<?php foreach($output['new_car_list'] as $new_car){?>
					<li>
						<a href="<?php echo getCMSPictureUrl($new_car['picture_id']);?>" target="_blank"><img src="<?php echo(getCMSArticleImageUrl($new_car['picture_attachment_path'], $new_car['picture_image'], 'max'))?>" /> <span><?php echo($new_car['picture_title'])?></span></a> 
					</li>
				<?php }?>
				</ul>
			</div>
		</div>
	</div>
	<?php }?>
</div>
</div>
</div>
</div>
</div>
</div>
</div>