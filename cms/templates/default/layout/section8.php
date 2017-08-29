<div class="cms-page-module-frame module-style-style1">
<div class="cms-module-frame">
<div nctype="cms_module_content" class="cms-module-frame-w5">
                        <!-- 文章　-->
<div class="cms-module-assembly-html">
<div class="content-box">
<div id="block1_html_content" nctype="object_module_edit">
<div class="friendly span12">
	<div id="flinks">
		<div class="friendly-head">
			<ul class="biaoti">
				<li class="focused">
					友情链接
				</li>
				<li>
					热门品牌
				</li>
				<li>
					热门车型
				</li>
			</ul>
		</div>
		<div class="friendly-content">
			<div class="tab-panel focused">
				<ul class="neirong">
					<?php if(is_array($output['link_list']) and !empty($output['link_list'])){
      					foreach ($output['link_list'] as $link) {?>
						<li><a href="<?php echo $link['link_url'];?>"> <?php echo $link['link_title'];?></a></li>
					<?php }} ?>
				</ul>
			</div>
			<div class="tab-panel">
				<ul>
					<?php if(is_array($output['hot_brand_list']) && !empty($output['hot_brand_list'])){
						foreach($output['hot_brand_list'] as $hot_brand){ ?>
						<li><a href="<?php echo('#');?>"><?php echo($hot_brand['brand_name']);?></a></li>
					<?php }} ?>
				</ul>
			</div>
			<div class="tab-panel">
				<ul>
					<li>
						<a>凌渡</a>
					</li>
					<li>
						<a>高尔夫</a>
					</li>
					<li>
						<a>大众CC</a>
					</li>
					<li>
						<a>奥迪A3</a>
					</li>
					<li>
						<a>奥迪Q3</a>
					</li>
					<li>
						<a>奥迪TT</a>
					</li>
					<li>
						<a>宝马3系</a>
					</li>
					<li>
						<a>宝马5系</a>
					</li>
					<li>
						<a>宝马X1</a>
					</li>
					<li>
						<a>奔驰E级</a>
					</li>
				</ul>
			</div>
		</div>
	</div>
</div>
</div>
</div>
</div>
</div>
</div>
</div>