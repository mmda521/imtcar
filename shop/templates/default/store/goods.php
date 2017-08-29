<?php defined('InShopNC') or exit('Access Invalid!');?>
<link href="<?php echo SHOP_TEMPLATES_URL;?>/css/home_goods.css" rel="stylesheet" type="text/css">
<script type="text/javascript" src="<?php echo RESOURCE_SITE_URL?>/js/cloudzoom.js"></script>
<style type="text/css">
.ncs-goods-picture .levelB, .ncs-goods-picture .levelC { cursor: url(<?php echo SHOP_TEMPLATES_URL;
?>/images/shop/zoom.cur), pointer;
}
.ncs-goods-picture .levelD { cursor: url(<?php echo SHOP_TEMPLATES_URL;
?>/images/shop/hand.cur), move\9;
}
.nch-sidebar-all-viewed { display: block; height: 20px; text-align: center; padding: 9px 0; }
</style>

<div class="wrapper pr">
  <input type="hidden" id="lockcompare" value="unlock" />
  <div class="ncs-detail<?php if ($output['store_info']['is_own_shop']) echo ' ownshop'; ?>"> 
    <!-- S 商品图片 --> 

<div id="ncs-goods-picture" class="ncs-goods-picture">
      <div class="gallery_wrap">
        <div class="gallery"><img title="鼠标滚轮向上或向下滚动，能放大或缩小图片哦~" src="<?php echo $output["goods_image"]["0"]["1"] ?>" class="cloudzoom" data-cloudzoom="zoomImage: '<?php echo $output["goods_image"]["0"]["2"] ?>'"> </div>
      </div>
      <div class="controller_wrap">
        <div class="controller">
          <ul>
            <?php
    foreach ($output["goods_image"] as $key => $value) {
 ?>
            <li><img title="鼠标滚轮向上或向下滚动，能放大或缩小图片哦~" class='cloudzoom-gallery' src="<?php echo $value['0'] ?>" data-cloudzoom="useZoom: '.cloudzoom', image: '<?php echo $value['1'] ?>', zoomImage: '<?php echo $value['2'] ?>' " width="60" height="60"></li>
             <?php  }?>
          </ul>
        </div>
      </div>
    </div>
    
    <!-- S 商品基本信息 -->
    <div class="ncs-goods-summary">
      <div class="name">
        <h1><?php echo $output['goods']['goods_name']; ?></h1>
        <strong><?php echo str_replace("\n", "<br>", $output['goods']['goods_jingle']);?></strong> </div>
      <div class="ncs-meta"> 
        
        <!-- S 商品参考价格 -->
        <?php if($output['goods']['goods_marketprice'] != 0) {?>
        <dl>
          <dt><?php echo $lang['goods_index_goods_cost_price'];?><?php echo $lang['nc_colon'];?></dt>
          <dd class="cost-price"><strong><?php echo $lang['currency'].ncPriceFormat($output['goods']['goods_marketprice']);?></strong></dd>
        </dl>
        <?php }?>
        <!-- E 商品参考价格 --> 
        <!-- S 商品发布价格 -->
        <dl>
          <dt><?php echo '一口价';?><?php echo $lang['nc_colon'];?></dt>
          <dd class="price">
            <?php if (isset($output['goods']['promotion_price']) && !empty($output['goods']['promotion_price'])) {?>
            <strong><?php echo $lang['currency'];?><?php echo ncPriceFormat($output['goods']['promotion_price']);?></strong><em>(原售价<?php echo $lang['nc_colon'];?><?php echo $lang['currency'].ncPriceFormat($output['goods']['goods_price']);?>)</em>
            <?php } else {?>
            <strong><?php echo $lang['currency'].ncPriceFormat($output['goods']['goods_price']);?></strong>
            <?php }?>
          </dd>
        </dl>
        <dl>
          <dt>库存<?php echo $lang['nc_colon'];?></dt>
          <dd><?php echo $output['goods']['goods_storage']; ?></dd>
        </dl>
        <dl>
          <dt>累计销量<?php echo $lang['nc_colon'];?></dt>
          <dd><?php echo $output['goods']['goods_salenum']; ?></dd>
        </dl>
        <div class="ncs-key">
        <dl nctype="nc-spec">
          <dt>购车方式<?php echo $lang['nc_colon'];?></dt>
          <dd>
              <ul nctyle="ul_sign">
                    <!-- 文字类型规格-->
                <?php if($output['goods']['pay_type']==1){?>
                    <li class="sp-txt"><a href="javascript:void(0)" class="<?php echo 'hovered'; ?>" data-param="{valid:<?php echo '分期付款';?>}"><?php echo '分期付款';?><i></i></a></li>
                <?php }else if($output['goods']['pay_type']==0){?>
                  <li class="sp-txt"><a href="javascript:void(0)" class="<?php echo 'hovered'; ?>" data-param="{valid:<?php echo '全款购车';?>}"><?php echo '全款购车';?><i></i></a></li>
                <?php }else{?>
                  <li class="sp-txt"><a href="javascript:void(0)"  data-param="{valid:<?php echo '全款购车';?>}"><?php echo '全款购车';?><i></i></a></li>
                  <li class="sp-txt"><a href="javascript:void(0)" class="<?php echo 'hovered'; ?>" data-param="{valid:<?php echo '分期付款';?>}"><?php echo '分期付款';?><i></i></a></li>
                <?php  }?>
              </ul>
          </dd>
        </dl>
          </div>
        <?php if($output['goods']['goods_app_price']!=0) { ?>        
        <dl style="display: none">
          <dt>App专享<?php echo $lang['nc_colon'];?></dt>
          <dd class=""><strong>
          <?php echo $lang['currency'].ncPriceFormat($output['goods']['goods_app_price']);
          ?>
          </strong></dd>
        </dl>
        <?php }?>
        <dl style="display: none">
          <dt>单件税金<?php echo $lang['nc_colon'];?></dt>
          <dd class=""><strong>
          <?php if (isset($output['goods']['promotion_price']) && !empty($output['goods']['promotion_price'])) {?>
            <?php echo $lang['currency'];?><?php echo ncPriceFormat($output['goods']['promotion_price']*$output['goods']['goods_tax_rate']);?>
            <?php } else {?>
            <?php echo $lang['currency'].ncPriceFormat($output['goods']['goods_price']*$output['goods']['goods_tax_rate']);?>
            <?php }?>
          </strong></dd>
        </dl>
        <dl style="display: none">
          <dt>综合税率<?php echo $lang['nc_colon'];?></dt>
          <dd class=""><strong>
          <?php 
           printf("%0.2f%%",$output['goods']['goods_tax_rate']*100);
          ?>
          </strong></dd>
        </dl>
        <dl class="rate" style="display: none">
          <dt>商品评分：</dt>
          <!-- S 描述相符评分 -->
          <dd><span class="raty" data-score="<?php echo $output['goods_evaluate_info']['star_average'];?>"></span><a href="#ncGoodsRate">共有<?php echo $output['goods']['evaluation_count']; ?>条评价</a></dd>
          <!-- E 描述相符评分 -->
        </dl>
        <dl style="display: none" >
          <dt>已购买人数</dt>
          <dd style="color:#F00"><?php echo $output['goods']['goods_presalenum']; ?></dd>
        </dl>
        <!-- E 商品发布价格 -->
        <div class="ncs-goods-code" style="display: none">
          <p><img src="<?php echo goodsQRCode($output['goods']);?>"  title="用商城手机客户端扫描二维码直达商品详情内容"></p>
          <span class="ncs-goods-code-note"><i></i></span> </div>
      </div>
      <?php if($output['goods']['goods_state'] != 10 && $output['goods']['goods_verify'] == 1){?>
      <!-- S 促销 -->
      <?php //PC::debug($output['mansong_all']);?>
      <?php if (isset($output['goods']['promotion_type']) || $output['goods']['have_gift'] == 'gift' || !empty($output['goods']['jjg_explain']) || !empty($output['mansong_info']) || !empty($output['mansong_all']) ) {?>
      <div class="ncs-sale">
        <?php if (isset($output['goods']['promotion_type']) || !empty($output['goods']['jjg_explain']) || !empty($output['mansong_info']) || !empty($output['mansong_all']) ) {?>
        <dl>
          <dt>促&#12288;&#12288;销：</dt>
          <dd class="promotion-info">
            <?php if (isset($output['goods']['title']) && $output['goods']['title'] != '') {?>
            <span class="sale-name"><?php echo $output['goods']['title'];?></span>
            <?php }?>
            <!-- S 限时折扣 -->
            <?php if ($output['goods']['promotion_type'] == 'xianshi') {?>
            <span class="sale-rule w400">直降<em><?php echo $lang['currency'].ncPriceFormat($output['goods']['down_price']);?></em>
            <?php if($output['goods']['lower_limit']) {?>
            <?php echo sprintf('最低%s件起，',$output['goods']['lower_limit']);?><?php echo $output['goods']['explain'];?>
            <?php } ?>
            </span>
            <?php }?>
            <!-- E 限时折扣  --> 
            <!-- S 团购-->
            <?php if ($output['goods']['promotion_type'] == 'groupbuy') {?>
            <?php if ($output['goods']['upper_limit']) {?>
            <em><?php echo sprintf('最多限购%s件',$output['goods']['upper_limit']);?></em>
            <?php } ?>
            <span><?php echo $output['goods']['remark'];?></span><br>
            <?php }?>
            <!-- E 团购 --> 
            <!--S 满就送 //gai-->
	        <?php if($output['mansong_all']) { ?>
              <div class="ncs-mansong"> <span class="sale-name">满即送
			 <?php if($output['mansong_all']['mansong_gc_id']==1){?>
			    (<?php echo '全部商品类';//xingai?>)
				  <?php }else{?>
				  (<?php echo $output['mansong_all']['mansong_gc_id'];//xingai?>)
				  <?php }?>
			  </span> <span class="sale-rule">
              <?php $rule = $output['mansong_all']['rules'][0]; echo $lang['nc_man'];?>
                  <em><?php echo $lang['currency'].ncPriceFormat($rule['price']);?></em>
                  <?php if(!empty($rule['discount'])) { ?>
                    ,&nbsp<?php echo $lang['nc_reduce'];?><em><?php echo $lang['currency'].ncPriceFormat($rule['discount']);?></em>
                  <?php } ?>
                  <?php if(!empty($rule['goods_id'])) { ?>
                    ,&nbsp<?php echo $lang['nc_gift'];?><a href="<?php echo $rule['goods_url'];?>" title="<?php echo $rule['mansong_goods_name'];?>" target="_blank">[赠品]</a>
                  <?php } ?>
              </span> <span class="sale-rule-more" nctype="show-rule"><a href="javascript:void(0);">共<strong><?php echo count($output['mansong_all']['rules']);?></strong>项，展开查看<i></i></a></span>
                <div class="sale-rule-content" style="display: none;" nctype="rule-content">
                  <div class="title"><span class="sale-name">满即送
				  <?php if($output['mansong_all']['mansong_gc_id']==1){?>
			    (<?php echo '全部商品类';//xingai?>)
				  <?php }else{?>
				  (<?php echo $output['mansong_all']['mansong_gc_id'];//xingai?>)
				  <?php }?>
				</span>共<strong><?php echo count($output['mansong_all']['rules']);?></strong>项，促销活动规则<a href="javascript:;" nctype="hide-rule">关闭</a></div>
                  <div class="content">
                    <div class="mjs-tit"><?php echo $output['mansong_all']['mansong_name'];?>
                      <time>( <?php echo $lang['nc_promotion_time'];?><?php echo $lang['nc_colon'];?><?php echo date('Y-m-d',$output['mansong_all']['start_time']).'--'.date('Y-m-d',$output['mansong_all']['end_time']);?> )</time>
                    </div>
                    <ul class="mjs-info">
                      <?php foreach($output['mansong_all']['rules'] as $rule) { ?>
                        <li> <span class="sale-rule"><?php echo $lang['nc_man'];?><em><?php echo $lang['currency'].ncPriceFormat($rule['price']);?></em>
                            <?php if(!empty($rule['discount'])) { ?>
                              ,&nbsp<?php echo $lang['nc_reduce'];?><em><?php echo $lang['currency'].ncPriceFormat($rule['discount']);?></em>
                            <?php } ?>
                            <?php if(!empty($rule['goods_id'])) { ?>
                              ,&nbsp<?php echo $lang['nc_gift'];?> <a href="<?php echo $rule['goods_url'];?>" title="<?php echo $rule['mansong_goods_name'];?>" target="_blank" class="gift"> <img src="<?php echo cthumb($rule['goods_image'], 60);?>" alt="<?php echo $rule['mansong_goods_name'];?>"> </a>
                            <?php } ?>
                      </span> </li>
                      <?php } ?>
                    </ul>
                    <div class="mjs-remark"><?php echo $output['mansong_all']['remark'];?></div>
                  </div>
                  <div class="bottom"><a href="<?php echo urlShop('show_store', 'mansong_goods', array('store_id' => $output['store_info']['store_id']));?>" class="url" target="_blank">查看更多店铺“满即送”活动商品</a></div>
                </div>
              </div>
            <?php } ?>
            <?php if($output['mansong_info']) { ?>
            <div class="ncs-mansong"> <span class="sale-name">满即送
      (<?php foreach($output['gc_list'] as $key =>$value) {
					if($key==$output['mansong_info']['mansong_gc_id'])
					{
						echo $value['gc_name'];
					}
				}?>)
        </span> <span class="sale-rule">
              <?php $rule = $output['mansong_info']['rules'][0]; echo $lang['nc_man'];?>
              <em><?php echo $lang['currency'].ncPriceFormat($rule['price']);?></em>
              <?php if(!empty($rule['discount'])) { ?>
              ,&nbsp<?php echo $lang['nc_reduce'];?><em><?php echo $lang['currency'].ncPriceFormat($rule['discount']);?></em>
              <?php } ?>
              <?php if(!empty($rule['goods_id'])) { ?>
              ,&nbsp<?php echo $lang['nc_gift'];?><a href="<?php echo $rule['goods_url'];?>" title="<?php echo $rule['mansong_goods_name'];?>" target="_blank">[赠品]</a>
              <?php } ?>
              </span> <span class="sale-rule-more" nctype="show-rule"><a href="javascript:void(0);">共<strong><?php echo count($output['mansong_info']['rules']);?></strong>项，展开查看<i></i></a></span>
              <div class="sale-rule-content" style="display: none;" nctype="rule-content">
                <div class="title"><span class="sale-name">满即送
				(<?php foreach($output['gc_list'] as $key =>$value) {
					if($key==$output['mansong_info']['mansong_gc_id'])
					{
						echo $value['gc_name'];
					}
				}?>)
        </span>共<strong><?php echo count($output['mansong_info']['rules']);?></strong>项，促销活动规则<a href="javascript:;" nctype="hide-rule">关闭</a></div>
                <div class="content">
                  <div class="mjs-tit"><?php echo $output['mansong_info']['mansong_name'];?>
                    <time>( <?php echo $lang['nc_promotion_time'];?><?php echo $lang['nc_colon'];?><?php echo date('Y-m-d',$output['mansong_info']['start_time']).'--'.date('Y-m-d',$output['mansong_info']['end_time']);?> )</time>
                  </div>
                  <ul class="mjs-info">
                    <?php foreach($output['mansong_info']['rules'] as $rule) { ?>
                    <li> <span class="sale-rule"><?php echo $lang['nc_man'];?><em><?php echo $lang['currency'].ncPriceFormat($rule['price']);?></em>
                      <?php if(!empty($rule['discount'])) { ?>
                     ,&nbsp<?php echo $lang['nc_reduce'];?><em><?php echo $lang['currency'].ncPriceFormat($rule['discount']);?></em>
                      <?php } ?>
                      <?php if(!empty($rule['goods_id'])) { ?>
                     ,&nbsp<?php echo $lang['nc_gift'];?> <a href="<?php echo $rule['goods_url'];?>" title="<?php echo $rule['mansong_goods_name'];?>" target="_blank" class="gift"> <img src="<?php echo cthumb($rule['goods_image'], 60);?>" alt="<?php echo $rule['mansong_goods_name'];?>"> </a>
                      <?php } ?>
                      </span> </li>
                    <?php } ?>
                  </ul>
                  <div class="mjs-remark"><?php echo $output['mansong_info']['remark'];?></div>
                </div>
                <div class="bottom"><a href="<?php echo urlShop('show_store', 'mansong_goods', array('store_id' => $output['store_info']['store_id']));?>" class="url" target="_blank">查看更多店铺“满即送”活动商品</a></div>
              </div>
            </div>
            <?php } ?>
            <!--E 满就送 --> 
            
          </dd>
        </dl>
        <?php }?>
        <!-- S 赠品 -->
        <?php if ($output['goods']['have_gift'] == 'gift') {?>
        <hr/>
        <dl>
          <dt>赠&#12288;&#12288;品：</dt>
          <dd class="goods-gift" id="ncsGoodsGift"> <span>数量有限，赠完为止。</span>
            <?php if (!empty($output['gift_array'])) {?>
            <ul>
              <?php foreach ($output['gift_array'] as $val){?>
              <li>
                <div class="goods-gift-thumb"><span><img src="<?php echo cthumb($val['gift_goodsimage'], '60', $output['goods']['store_id']);?>"></span></div>
                <a href="<?php echo urlShop('goods', 'index', array('goods_id' => $val['gift_goodsid']));?>" class="goods-gift-name" target="_blank"><?php echo $val['gift_goodsname']?></a><em>x<?php echo $val['gift_amount'];?></em> </li>
              <?php }?>
            </ul>
            <?php }?>
          </dd>
        </dl>
        <?php }?>
        <!-- E 赠品 --> 
        
      </div>
      <?php }?>
      <!-- E 促销 -->
      <!--送达时间 begin  -->
        
        <?php if ($output['store_info']['store_free_time'] >= '1') {?>
        <dl>
          <dt>服　　务：</dt>
          <dd>由 <a href="<?php echo urlShop('show_store', 'index', array('store_id' => $output['store_info']['store_id']), $output['store_info']['store_domain']);?>" title="进入店铺" ><font color="#D93600"><b><?php echo $output['store_info']['store_name']; ?></b></font></a> 发货并提供售后服务。<span id="store-free-time">18:00 前完成下单，预计(<font color="#D93600"><b>
            <?php $showtime=date("Y-m-d H:i:s"); echo date('m月d日',strtotime($showtime . '+'. $output['store_info']['store_free_time'].' day')); ?>
            </b></font>) 送达</span></dd>
        </dl>
        <?php }?>
        
        <!-- 年前物流修改170117 
        <?php if ($output['store_info']['store_free_time'] >= '1') {?>
         <dl>
          <dt>温馨提示：</dt>
          <dd>春节临近，海关放假快递停运原因，本店已停止发货，1月21日-2月2日可正常下单，期间的订单将于2月3日开始统一按照订单付款时间先后顺序，逐一进行审核申报（跨境商品）和发货！由此带来不便，深感抱歉！
          </dd>
        </dl>
        <?php }?>
        -->
        <!--送达时间 end  --> 
      
      <div class="ncs-logistics"><!-- S 物流与运费新布局展示  -->
        <?php if($output['goods']['goods_state'] == 1 && $output['goods']['goods_verify'] == 1 && $output['goods']['is_virtual'] == 0){ ?>
        <dl id="ncs-freight" class="ncs-freight">
          <dt>配&nbsp;&nbsp;送&nbsp;&nbsp;至：</dt>
          <dd class="ncs-freight_box">
            <div id="ncs-freight-selector" class="ncs-freight-select">
              <div class="text">
                <div><?php echo $output['store_info']['deliver_region'] ? str_replace(' ','',$output['store_info']['deliver_region'][1]) : '请选择地区'?></div>
                <b>∨</b> </div>
              <div class="content">
                <div id="ncs-stock" class="ncs-stock" data-widget="tabs">
                  <div class="mt">
                    <ul class="tab">
                      <li data-index="0" data-widget="tab-item" class="curr"><a href="#none" class="hover"><em><?php echo $output['store_info']['deliver_region_names'][0] ? $output['store_info']['deliver_region_names'][0] : '请选择'?></em><i> ∨</i></a></li>
                    </ul>
                  </div>
                  <div id="stock_province_item" data-widget="tab-content" data-area="0">
                    <ul class="area-list">
                    </ul>
                  </div>
                  <div id="stock_city_item" data-widget="tab-content" data-area="1" style="display: none;">
                    <ul class="area-list">
                    </ul>
                  </div>
                  <div id="stock_area_item" data-widget="tab-content" data-area="2" style="display: none;">
                    <ul class="area-list">
                    </ul>
                  </div>
                </div>
              </div>
              <a href="javascript:;" class="close" onclick="$('#ncs-freight-selector').removeClass('hover')">关闭</a> </div>
            <div id="ncs-freight-prompt"> <strong><?php echo $output['goods']['goods_storage'] > 0 ? '有货' : '无货'?></strong>
              <?php if (!$output['goods']['transport_id']) { ?>
              <?php echo $output['goods']['goods_freight'] > 0 ? '运费：'.ncPriceFormat($output['goods']['goods_freight']).' 元' : '免运费' ?>
              <?php } ?>
            </div>
          </dd>
        </dl>
        <!-- S 物流与运费新布局展示  -->
        <?php } ?>
      </div>
      <div class="ncs-key"> 
        
        <!-- S 商品规格值-->
        <?php if (is_array($output['goods']['spec_name'])) { ?>
        <hr/>
        <?php foreach ($output['goods']['spec_name'] as $key => $val) {?>
        <dl nctype="nc-spec">
          <dt><?php echo $val;?><?php echo $lang['nc_colon'];?></dt>
          <dd>
            <?php if (is_array($output['goods']['spec_value'][$key]) and !empty($output['goods']['spec_value'][$key])) {?>
            <ul nctyle="ul_sign">
              <?php foreach($output['goods']['spec_value'][$key] as $k => $v) {?>
              <?php if( $key == 1 ){?>
              <!-- 图片类型规格-->
              <li class="sp-img"><a href="javascript:void(0);" class="<?php if (isset($output['goods']['goods_spec'][$k])) {echo 'hovered';}?>" data-param="{valid:<?php echo $k;?>}" title="<?php echo $v;?>"><img src="<?php echo $output['spec_image'][$k];?>"/><?php echo $v;?><i></i></a></li>
              <?php }else{?>
              <!-- 文字类型规格-->
              <li class="sp-txt"><a href="javascript:void(0)" class="<?php if (isset($output['goods']['goods_spec'][$k])) { echo 'hovered';} ?>" data-param="{valid:<?php echo $k;?>}"><?php echo $v;?><i></i></a></li>
              <?php }?>
              <?php }?>
            </ul>
            <?php }?>
          </dd>
        </dl>
        <?php }?>
        <?php }?>
        <!-- E 商品规格值-->
        <?php if ($output['goods']['is_virtual'] == 1) {?>
        <dl>
          <dt>提货方式：</dt>
          <dd>
            <ul>
              <li class="sp-txt"><a href="javascript:void(0)" class="hovered">电子兑换券<i></i></a></li>
            </ul>
          </dd>
        </dl>
        <!-- 虚拟商品有效期 -->
        <dl>
          <dt>有&nbsp;效&nbsp;期：</dt>
          <dd>即日起 到 <?php echo date('Y-m-d H:i:s', $output['goods']['virtual_indate']);?></dd>
        </dl>
        <?php }else if ($output['goods']['is_presell'] == 1) {?>
        <!-- 预售商品发货时间 -->
        <dl>
          <dt>预&#12288;&#12288;售：</dt>
          <dd>
            <ul>
              <li class="sp-txt"><a href="javascript:void(0)" class="hovered"><?php echo date('Y-m-d', $output['goods']['presell_deliverdate']);?>&nbsp;日发货<i></i></a></li>
            </ul>
          </dd>
        </dl>
        <?php }?>
        <?php if ($output['goods']['is_fcode']) {?>
        <!-- 预售商品发货时间 -->
        <dl>
          <dt>购买类型：</dt>
          <dd>
            <ul>
              <li class="sp-txt"><a href="javascript:void(0)" class="hovered">F码优先购买<i></i></a></li>
            </ul>
          </dd>
        </dl>
        <?php }?>
      </div>
      <!-- S 购买数量及库存 -->
      <div class="ncs-buy">
        <?php if ($output['goods']['goods_state'] != 0 && $output['goods']['goods_storage'] >= 0) {?>
        <div class="ncs-figure-input">
          <input type="text" name="" id="quantity" value="1" size="3" maxlength="6" class="input-text" <?php if ($output['goods']['is_fcode'] == 1) {?>readonly<?php }?>>
          <a href="javascript:void(0)" class="increase" <?php if ($output['goods']['is_fcode'] != 1) {?>nctype="increase"<?php }?>>&nbsp;</a> <a href="javascript:void(0)" class="decrease" <?php if ($output['goods']['is_fcode'] != 1) {?>nctype="decrease"<?php }?>>&nbsp;</a> </div>
        <div class="ncs-point" style="display: none;"><i></i> 
          <!-- S 库存 --> 
          <span>您选择的商品库存<strong nctype="goods_stock"><?php echo $output['goods']['goods_storage']; ?></strong><?php echo $lang['nc_jian'];?></span> 
          <!-- E 库存 -->
          <?php if ($output['goods']['is_virtual'] == 1 && $output['goods']['virtual_limit'] > 0) { ?>
          <!-- 虚拟商品限购数 --> 
          <span class="look">，每人次限购<strong> 
          <!-- 虚拟团购 设置了虚拟团购限购数 该数小于原商品限购数 --> 
          <?php echo ($output['goods']['promotion_type'] == 'groupbuy' && $output['goods']['upper_limit'] > 0 && $output['goods']['upper_limit'] < $output['goods']['virtual_limit']) ? $output['goods']['upper_limit'] : $output['goods']['virtual_limit'];?> </strong>件商品。</span>
          <?php } else if ($output['goods']['promotion_type'] == 'groupbuy' && $output['goods']['upper_limit'] > 0){ ?>
          <!-- 团购限购 --> 
          <span class="look">，每人次限购<strong> <?php echo $output['goods']['upper_limit'];?> </strong>件商品。</span>
          <?php }?>
          <?php if ($output['goods']['is_fcode'] == 1) {?>
          <span class="look">，每个F码可优先购买一件商品。</span>
          <?php }?>
        </div>
        <?php } ?>
        
        <!-- S 提示已选规格及库存不足无法购买 -->
        <?php if ($output['goods']['goods_state'] == 0 || $output['goods']['goods_storage'] <= 0) {?>
        <div nctype="goods_prompt" class="ncs-point"><i></i> <span>您选择的商品<strong>库存不足</strong>；请选择店内其它商品或申请<a href="javascript:void(0);" nctype="arrival_notice" class="arrival" title="到货通知">到货通知</a>提示。</span> </div>
        <?php }?>
        <!-- E 提示已选规格及库存不足无法购买 --> 
        <div class="ncs-btn"> 
          <!-- v3-b10 限制购买-->
          <?php if ($output['IsHaveBuy']=="0") {?>
          <?php if ($output['goods']['cart'] == true) {?>
          <!-- 加入购物车--> 
          <a href="javascript:void(0);" nctype="addcart_submit" class="addcart <?php if ($output['goods']['goods_state'] == 0 || $output['goods']['goods_storage'] <= 0) {?>no-addcart<?php }?>" title="<?php echo $lang['goods_index_add_to_cart'];?>"><i class="icon-shopping-cart"></i><?php echo $lang['goods_index_add_to_cart'];?></a>
          <?php } ?>
          <!-- 立即购买--> 
          <a href="javascript:void(0);" nctype="buynow_submit" class="buynow <?php if ($output['goods']['goods_state'] == 0 || $output['goods']['goods_storage'] <= 0 || ($output['goods']['is_virtual'] == 1 && $output['goods']['virtual_indate'] < TIMESTAMP)) {?>no-buynow<?php }?>" title="<?php echo $output['goods']['buynow_text'];?>"><?php echo $output['goods']['buynow_text'];?></a>
          <?php } ?>
          <?php if ($output['IsHaveBuy']=="1") {?>
          <a href="javascript:void(0);" class="buynow no-buynow" title="您已参加本次抢购">您已参加本次抢购</a>
          <?php } ?>
          
          <!-- v3-b10 end--> 
          
          <!-- S 加入购物车弹出提示框 -->
          <div class="ncs-cart-popup">
            <dl>
              <dt><?php echo $lang['goods_index_cart_success'];?><a title="<?php echo $lang['goods_index_close'];?>" onClick="$('.ncs-cart-popup').css({'display':'none'});">X</a></dt>
              <dd><?php echo $lang['goods_index_cart_have'];?> <strong id="bold_num"></strong> <?php echo $lang['goods_index_number_of_goods'];?> <?php echo $lang['goods_index_total_price'];?><?php echo $lang['nc_colon'];?><em id="bold_mly" class="saleP"></em></dd>
              <dd class="btns"><a href="javascript:void(0);" class="ncs-btn-mini ncs-btn-green" onclick="location.href='<?php echo SHOP_SITE_URL.DS?>index.php?act=cart'"><?php echo $lang['goods_index_view_cart'];?></a> <a href="javascript:void(0);" class="ncs-btn-mini" value="" onclick="$('.ncs-cart-popup').css({'display':'none'});"><?php echo $lang['goods_index_continue_shopping'];?></a></dd>
            </dl>
          </div>
          <!-- E 加入购物车弹出提示框 --> 
        </div>
        <!-- E 购买按钮 --> 
      </div>
      <?php }else{?>
      <div class="ncs-buy">
        <div class="ncs-saleout">
          <dl>
            <dt><i class="icon-info-sign"></i><?php echo $lang['goods_index_is_no_show'];?></dt>
            <dd><?php echo $lang['goods_index_is_no_show_message_one'];?></dd>
            <dd><?php echo $lang['goods_index_is_no_show_message_two_1'];?>&nbsp;<a href="<?php echo urlShop('show_store', 'index', array('store_id'=>$output['goods']['store_id']), $output['store_info']['store_domain']);?>" class="ncbtn-mini"><?php echo $lang['goods_index_is_no_show_message_two_2'];?></a>&nbsp;<?php echo $lang['goods_index_is_no_show_message_two_3'];?> </dd>
          </dl>
        </div>
      </div>
      <?php }?>
      <!-- E 购买数量及库存 --> 
      
      <!--E 商品信息 --> 
    </div>
    <!-- E 商品图片及收藏分享 -->
    <div class="ncs-handle"> 
      <!-- S 分享 --> 
      <a href="javascript:void(0);" class="share" nc_type="sharegoods" data-param='{"gid":"<?php echo $output['goods']['goods_id'];?>"}'><i></i><?php echo $lang['goods_index_snsshare_goods'];?><span>(<em nc_type="sharecount_<?php echo $output['goods']['goods_id'];?>"><?php echo intval($output['goods']['sharenum'])>0?intval($output['goods']['sharenum']):0;?></em>)</span></a> 
      <!-- S 收藏 --> 
      <a href="javascript:collect_goods('<?php echo $output['goods']['goods_id']; ?>','count','goods_collect');" class="favorite"><i></i><?php echo $lang['goods_index_favorite_goods'];?><span>(<em nctype="goods_collect"><?php echo $output['goods']['goods_collect']?></em>)</span></a> 
      <!-- S 对比 --> 
      <a href="javascript:void(0);" class="compare" nc_type="compare_<?php echo $output['goods']['goods_id'];?>" data-param='{"gid":"<?php echo $output['goods']['goods_id'];?>"}'><i></i>加入对比</a><!-- S 举报 -->
     <!-- <?php if($output['inform_switch']) { ?>
      <a href="<?php if ($_SESSION['is_login']) {?>index.php?act=member_inform&op=inform_submit&goods_id=<?php echo $output['goods']['goods_id'];?><?php } else {?>javascript:login_dialog();<?php }?>" title="<?php echo $lang['goods_index_goods_inform'];?>" class="inform"><i></i><?php echo $lang['goods_index_goods_inform'];?></a>
      <?php } ?>-->
      <!-- End --> </div>
    
    <!--S 店铺信息-->
    <div style="position: absolute; z-index: 2; top: -1px; right: -1px;">
      <?php include template('store/info');?>
      <?php if ($output['store_info']['is_own_shop']) { ?>
      <!--S 看了又看 -->
      <div class="ncs-lal" style="display: none">
        <div class="title">看了又看</div>
        <div class="content">
          <ul>
            <?php foreach ((array) $output['goods_rand_list'] as $g) { ?>
            <li>
              <div class="goods-pic"><a title="<?php echo $g['goods_name']; ?>" href="<?php echo urlShop('goods', 'index', array('goods_id' => $g['goods_id'], )); ?>"> <img alt="" src="<?php echo UPLOAD_SITE_URL;?>/shop/common/loading.gif" rel="lazy" data-url="<?php echo cthumb($g['goods_image'], 60); ?>" /> </a></div>
              <div class="goods-price">￥<?php echo ncPriceFormat($g['goods_promotion_price']); ?></div>
            </li>
            <?php } ?>
          </ul>
        </div>
      </div>
      <!--E 看了又看 -- > 
      
    </div>
    <?php } ?>
    <!--E 店铺信息 --> 
  </div>
  <div class="clear"></div>
</div>
<!-- S 优惠套装 -->
<div class="ncs-promotion" id="nc-bundling" style="display:none;"></div>
<!-- E 优惠套装 -->
<div id="content" class="ncs-goods-layout expanded" >
  <div class="ncs-goods-main" id="main-nav-holder">
    <div class="tabbar pngFix" id="main-nav">
      <div class="ncs-goods-title-nav">
        <ul id="categorymenu">
          <li class="current"><a id="tabGoodsIntro" href="#content"><?php echo $lang['goods_index_goods_info'];?></a></li>
		  <li><a id="tabGoodsConfiguration" href="#content">参数配置</a></li>
          <li><a id="tabGoodsRate" href="#content"><?php echo $lang['goods_index_evaluation'];?><em>(<?php echo $output['goods_evaluate_info']['all'];?>)</em></a></li>
          <li><a id="tabGoodsTraded" href="#content">近期销量</a></li>
          <!--<li><a id="tabGoodsTraded" >总销售量<em>(<?php echo $output['goods']['goods_presalenum']; ?>)</em></a></li>-->
          <!--<li><a id="tabGuestbook" href="#content"><?php echo $lang['goods_index_goods_consult'];?></a></li>-->

        </ul>
        <div class="switch-bar"><a href="javascript:void(0)" id="fold">&nbsp;</a></div>
      </div>
    </div>
    <div class="ncs-intro">
      <div class="content bd" id="ncGoodsIntro"> 
        <?php if(is_array($output['goods']['goods_attr']) || isset($output['goods']['brand_name'])){?>
        <ul class="nc-goods-sort">
          <?php if ($output['goods']['goods_serial']) {?>
          <li>商家货号：<?php echo $output['goods']['goods_serial'];?></li>
          <?php }?>
          <?php if(isset($output['goods']['brand_name'])){echo '<li>'.$lang['goods_index_brand'].$lang['nc_colon'].$output['goods']['brand_name'].'</li>';}?>
          <?php if(is_array($output['goods']['goods_attr']) && !empty($output['goods']['goods_attr'])){?>
          <?php foreach ($output['goods']['goods_attr'] as $val){ $val= array_values($val);echo '<li>'.$val[0].$lang['nc_colon'].$val[1].'</li>'; }?>
          <?php }?>
        </ul>
        <?php }?>
        <div class="ncs-goods-info-content">
          <?php if (isset($output['plate_top'])) {?>
          <div class="top-template"><?php echo $output['plate_top']['plate_content']?></div>
          <?php }?>
          <div class="default"><?php echo $output['goods']['goods_body']; ?></div>
          <?php if (isset($output['plate_bottom'])) {?>
          <div class="bottom-template"><?php echo $output['plate_bottom']['plate_content']?></div>
          <?php }?>
        </div>
      </div>
    </div>

  <div class="ncs-goods-info-content bd" id="ncGoodsConfiguration">
	  <div class="sleft">
          <ul id="clickli">
              <li><a href="javascript:void(0);" class="ln1">基本参数</a></li>
              <li><a href="javascript:void(0);" class="ln2">车身</a></li>
              <li><a href="javascript:void(0);" class="ln3">发动机</a></li>
              <li><a href="javascript:void(0);" class="ln4">变速箱</a></li>
			  
			  <li><a href="javascript:void(0);" class="ln5">底盘转向</a></li>
              <li><a href="javascript:void(0);" class="ln6">车轮制动</a></li>
              <li><a href="javascript:void(0);" class="ln7">主/被动安全装备</a></li>
              <li><a href="javascript:void(0);" class="ln8">座椅配置</a></li>
			  
			  <li><a href="javascript:void(0);" class="ln9">多媒体配置</a></li>
              <li><a href="javascript:void(0);" class="ln10">内部配置</a></li>
              <li><a href="javascript:void(0);" class="ln11">外部/防盗配置</a></li>
              <li><a href="javascript:void(0);" class="ln12">操控配置</a></li>
			  
			  <li><a href="javascript:void(0);" class="ln13">灯光配置</a></li>
              <li><a href="javascript:void(0);" class="ln14">玻璃/后视镜</a></li>
              <li><a href="javascript:void(0);" class="ln15">高科技配置</a></li>
              <li><a href="javascript:void(0);" class="ln16">空调/冰箱</a></li>
          </ul>
      </div>	 

        <div class="sright">
           <table id="ltable">
              <tbody>
			   <tr id="jbcs" class="title">
                      <td>基本参数</td>
               </tr>
			    <tr>
                      <td>车型名称</td>
                      <td><?php if(isset($output['goods']['goods_name'])&&!empty($output['goods']['goods_name'])) {echo $output['goods']['goods_name'];} else {echo '-';} ?></td>
                </tr>
            <tr>
			   <td>厂商指导价(元)</td>
			   <td><?php if(isset($output['goods']['goods_marketprice'])&&!empty($output['goods']['goods_marketprice'])) {echo $output['goods']['goods_marketprice'];} else {echo '-';} ?></td>
			</tr>
           <tr>
			   <td>厂商</td>
			   <td><?php if(isset($output['basic']['car_manufacturers'])&&!empty($output['basic']['car_manufacturers'])) {echo $output['basic']['car_manufacturers'];} else {echo '-';} ?></td>
			</tr>			
           
			<tr>
			   <td>级别</td>
			   <td><?php if(isset($output['basic']['car_level'])&&!empty($output['basic']['car_level'])) {echo $output['basic']['car_level'];} else {echo '-';} ?></td>
			</tr>
		    
			<tr>
			   <td>发动机</td>
			   <td><?php if(isset($output['basic']['car_engine'])&&!empty($output['basic']['car_engine'])) {echo $output['basic']['car_engine'];} else {echo '-';} ?></td>
			</tr>
           
			<tr>
			   <td>变速箱</td>
			   <td><?php if(isset($output['basic']['car_gearbox'])&&!empty($output['basic']['car_gearbox'])) {echo $output['basic']['car_gearbox'];} else {echo '-';} ?></td>
			</tr>
           
			<tr>
			   <td>长*宽*高(mm)</td>
			   <td><?php if(isset($output['basic']['car_longwidehigh'])&&!empty($output['basic']['car_longwidehigh'])) {echo $output['basic']['car_longwidehigh'];} else {echo '-';} ?></td>
			</tr>
			
			<tr>
			   <td>车身结构</td>
			   <td><?php if(isset($output['basic']['car_body_structure'])&&!empty($output['basic']['car_body_structure'])) {echo $output['basic']['car_body_structure'];} else {echo '-';} ?></td>
			</tr>
          
			<tr>
			   <td>最高车速(km/h)</td>
			   <td><?php if(isset($output['basic']['car_maxspeed'])&&!empty($output['basic']['car_maxspeed'])) {echo $output['basic']['car_maxspeed'];} else {echo '-';} ?></td>
			</tr>
           
			<tr>
			   <td>官方0-100km/h加速(s)</td>
			   <td><?php if(isset($output['basic']['office_accelerate'])&&!empty($output['basic']['office_accelerate'])) {echo $output['basic']['office_accelerate'];} else {echo '-';} ?></td>
			</tr>
		  
			<tr>
			   <td>实测0-100km/h加速(s)</td>
			   <td><?php if(isset($output['basic']['fact_accelerate'])&&!empty($output['basic']['fact_accelerate'])) {echo $output['basic']['fact_accelerate'];} else {echo '-';} ?></td>
			</tr>
           
			<tr>
			   <td>实测100-0km/h制动(m)</td>
			   <td><?php if(isset($output['basic']['fact_brake'])&&!empty($output['basic']['fact_brake'])) {echo $output['basic']['fact_brake'];} else {echo '-';} ?></td>
			</tr>
			
			<tr>
			   <td>实测油耗(L/100km)</td>
			   <td><?php if(isset($output['basic']['car_fuel'])&&!empty($output['basic']['car_fuel'])) {echo $output['basic']['car_fuel'];} else {echo '-';} ?></td>
			</tr>

			<tr>
			   <td>工信部综合油耗(L/100km)</td>
			   <td><?php if(isset($output['basic']['car_intefuel'])&&!empty($output['basic']['car_intefuel'])) {echo $output['basic']['car_intefuel'];} else {echo '-';} ?></td>
			</tr>

			<tr>
			   <td>实测离地间隙(mm)</td>
			   <td><?php if(isset($output['basic']['fact_ground_clearance'])&&!empty($output['basic']['fact_ground_clearance'])) {echo $output['basic']['fact_ground_clearance'];} else {echo '-';} ?></td>
			</tr>
			<tr>
			   <td>整车质保</td>
			   <td><?php if(isset($output['basic']['vehicle_warranty'])&&!empty($output['basic']['vehicle_warranty'])) {echo $output['basic']['vehicle_warranty'];} else {echo '-';} ?></td>
			</tr>
          
			
             <tr id="cs" class="title">
                  <td>车身参数</td>
             </tr>
			 <tr>
                <td>长度(mm)</td>
                <td><?php if(isset($output['carbody']['car_length'])&&!empty($output['carbody']['car_length'])) {echo $output['carbody']['car_length'];} else {echo '-';} ?></td>
             </tr>
			 <tr>
                <td>宽度(mm)</td>
                <td><?php if(isset($output['carbody']['car_width'])&&!empty($output['carbody']['car_width'])) {echo $output['carbody']['car_width'];} else {echo '-';} ?></td>
             </tr>
			 <tr>
                <td>高度(mm)</td>
                <td><?php if(isset($output['carbody']['car_height'])&&!empty($output['carbody']['car_height'])) {echo $output['carbody']['car_height'];} else {echo '-';} ?></td>
             </tr>
			 <tr>
                <td>轴距(mm)</td>
                <td><?php if(isset($output['carbody']['car_wheelbase'])&&!empty($output['carbody']['car_wheelbase'])) {echo $output['carbody']['car_wheelbase'];} else {echo '-';} ?></td>
             </tr>
			 <tr>
                <td>前轮距(mm)</td>
                <td><?php if(isset($output['carbody']['front_track'])&&!empty($output['carbody']['front_track'])) {echo $output['carbody']['front_track'];} else {echo '-';} ?></td>
             </tr>
           
			 <tr>
                <td>后轮距(mm)</td>
                <td><?php if(isset($output['carbody']['rear_track'])&&!empty($output['carbody']['rear_track'])) {echo $output['carbody']['rear_track'];} else {echo '-';} ?></td>
             </tr>
			 <tr>
                <td>最小离地间隙(mm)</td>
                <td><?php if(isset($output['carbody']['min_ground_clearance'])&&!empty($output['carbody']['min_ground_clearance'])) {echo $output['carbody']['min_ground_clearance'];} else {echo '-';} ?></td>
             </tr>
			 <tr>
                <td>整备质量(kg)</td>
                <td><?php if(isset($output['carbody']['curb_quality'])&&!empty($output['carbody']['curb_quality'])) {echo $output['carbody']['curb_quality'];} else {echo '-';} ?></td>
             </tr>
			 <tr>
                <td>车身结构</td>
                <td><?php if(isset($output['carbody']['body_structure'])&&!empty($output['carbody']['body_structure'])) {echo $output['carbody']['body_structure'];} else {echo '-';} ?></td>
             </tr>
			 <tr>
                <td>车门数(个)</td>
                <td><?php if(isset($output['carbody']['car_doors_num'])&&!empty($output['carbody']['car_doors_num'])) {echo $output['carbody']['car_doors_num'];} else {echo '-';} ?></td>
             </tr>
			 <tr>
                <td>座位数(个)</td>
                <td><?php if(isset($output['carbody']['car_seats_num'])&&!empty($output['carbody']['car_seats_num'])) {echo $output['carbody']['car_seats_num'];} else {echo '-';} ?></td>
             </tr>
           
			 <tr>
                <td>油箱容积(L)</td>
                <td><?php if(isset($output['carbody']['fuel_capacity'])&&!empty($output['carbody']['fuel_capacity'])) {echo $output['carbody']['fuel_capacity'];} else {echo '-';} ?></td>
             </tr>
			 <tr>
                <td>行李厢容积(L)</td>
                <td><?php if(isset($output['carbody']['car_luggage'])&&!empty($output['carbody']['car_luggage'])) {echo $output['carbody']['car_luggage'];} else {echo '-';} ?></td>
             </tr>

			<tr id="fdj" class="title">
                      <td>发动机参数</td>
            </tr>
			 <tr>
                      <td>发动机型号</td>
                      <td><?php if(isset($output['engine']['car_emodel'])&&!empty($output['engine']['car_emodel'])) {echo $output['engine']['car_emodel'];} else {echo '-';} ?></td>
             </tr>

			 <tr>
                      <td>排量(mL)</td>
                      <td><?php if(isset($output['engine']['car_displace'])&&!empty($output['engine']['car_displace'])) {echo $output['engine']['car_displace'];} else {echo '-';} ?></td>
             </tr>

			 <tr>
                      <td>排量(L)</td>
                      <td><?php if(isset($output['engine']['car_displacement'])&&!empty($output['engine']['car_displacement'])) {echo $output['engine']['car_displacement'];} else {echo '-';} ?></td>
             </tr>

			 <tr>
                      <td>进气形式</td>
                      <td><?php if(isset($output['engine']['car_airin'])&&!empty($output['engine']['car_airin'])) {echo $output['engine']['car_airin'];} else {echo '-';} ?></td>
             </tr>
		 
			 <tr>
                      <td>气缸排列形式</td>
                      <td><?php if(isset($output['engine']['car_cylinder'])&&!empty($output['engine']['car_cylinder'])) {echo $output['engine']['car_cylinder'];} else {echo '-';} ?></td>
             </tr>

			 <tr>
                      <td>气缸数(个)</td>
                      <td><?php if(isset($output['engine']['car_ncylinders'])&&!empty($output['engine']['car_ncylinders'])) {echo $output['engine']['car_ncylinders'];} else {echo '-';} ?></td>
             </tr>
         
			 <tr>
                      <td>每缸气门数(个)</td>
                      <td><?php if(isset($output['engine']['car_npcylinder'])&&!empty($output['engine']['car_npcylinder'])) {echo $output['engine']['car_npcylinder'];} else {echo '-';} ?></td>
             </tr>
			 <tr>
                      <td>压缩比</td>
                      <td><?php if(isset($output['engine']['car_ratio'])&&!empty($output['engine']['car_ratio'])) {echo $output['engine']['car_ratio'];} else {echo '-';} ?></td>
             </tr>

			 <tr>
                      <td>配气机构</td>
                      <td><?php if(isset($output['engine']['car_air_supply'])&&!empty($output['engine']['car_air_supply'])) {echo $output['engine']['car_air_supply'];} else {echo '-';} ?></td>
             </tr>
          
			 <tr>
                      <td>缸径(mm)</td>
                      <td><?php if(isset($output['engine']['car_bore'])&&!empty($output['engine']['car_bore'])) {echo $output['engine']['car_bore'];} else {echo '-';} ?></td>
             </tr>

			 <tr>
                      <td>行程(mm)</td>
                      <td><?php if(isset($output['engine']['car_stroke'])&&!empty($output['engine']['car_stroke'])) {echo $output['engine']['car_stroke'];} else {echo '-';} ?></td>
             </tr>
           
			 <tr>
                      <td>最大马力(Ps)</td>
                      <td><?php if(isset($output['engine']['car_mps'])&&!empty($output['engine']['car_mps'])) {echo $output['engine']['car_mps'];} else {echo '-';} ?></td>
             </tr>
			 <tr>
                      <td>最大功率(kW)</td>
                      <td><?php if(isset($output['engine']['car_mkw'])&&!empty($output['engine']['car_mkw'])) {echo $output['engine']['car_mkw'];} else {echo '-';} ?></td>
             </tr>
			 <tr>
                      <td>最大功率转速(rpm)</td>
                      <td><?php if(isset($output['engine']['car_mrpm'])&&!empty($output['engine']['car_mrpm'])) {echo $output['engine']['car_mrpm'];} else {echo '-';} ?></td>
             </tr>
		   
			 <tr>
                      <td>最大扭矩(N·m)</td>
                      <td><?php if(isset($output['engine']['car_mNm'])&&!empty($output['engine']['car_mNm'])) {echo $output['engine']['car_mNm'];} else {echo '-';} ?></td>
             </tr>
          
			 <tr>
                      <td>最大扭矩转速(rpm)</td>
                      <td><?php if(isset($output['engine']['car_mmrpm'])&&!empty($output['engine']['car_mmrpm'])) {echo $output['engine']['car_mmrpm'];} else {echo '-';} ?></td>
             </tr>

			 <tr>
                      <td>发动机特有技术</td>
                      <td><?php if(isset($output['engine']['car_engine_technology'])&&!empty($output['engine']['car_engine_technology'])) {echo $output['engine']['car_engine_technology'];} else {echo '-';} ?></td>
             </tr>
			
			 <tr>
                      <td>燃料形式</td>
                      <td><?php if(isset($output['engine']['car_fuel_form'])&&!empty($output['engine']['car_fuel_form'])) {echo $output['engine']['car_fuel_form'];} else {echo '-';} ?></td>
             </tr>

			 <tr>
                      <td>燃油标号</td>
                      <td><?php if(isset($output['engine']['car_fuel_label'])&&!empty($output['engine']['car_fuel_label'])) {echo $output['engine']['car_fuel_label'];} else {echo '-';} ?></td>
             </tr>

			 <tr>
                      <td>供油方式</td>
                      <td><?php if(isset($output['engine']['car_oil_supply'])&&!empty($output['engine']['car_oil_supply'])) {echo $output['engine']['car_oil_supply'];} else {echo '-';} ?></td>
             </tr>

			 <tr>
                      <td>缸盖材料</td>
                      <td><?php if(isset($output['engine']['cylinder_head_material'])&&!empty($output['engine']['cylinder_head_material'])) {echo $output['engine']['cylinder_head_material'];} else {echo '-';} ?></td>
             </tr>

			 <tr>
                      <td>缸体材料</td>
                      <td><?php if(isset($output['engine']['cylinder_material'])&&!empty($output['engine']['cylinder_material'])) {echo $output['engine']['cylinder_material'];} else {echo '-';} ?></td>
             </tr>

			 <tr>
                      <td>环保标准</td>
                      <td><?php if(isset($output['engine']['environmental_standards'])&&!empty($output['engine']['environmental_standards'])) {echo $output['engine']['environmental_standards'];} else {echo '-';} ?></td>
             </tr>
			
			
			<tr id="bsx" class="title">
                      <td>变速箱</td>
            </tr> 
		  <tr>
                      <td>简称</td>
                      <td><?php if(isset($output['gearbox']['gearbox_referred'])&&!empty($output['gearbox']['gearbox_referred'])) {echo $output['gearbox']['gearbox_referred'];} else {echo '-';} ?></td>
             </tr>

			 <tr>
                      <td>挡位个数</td>
                      <td><?php if(isset($output['gearbox']['car_gears_num'])&&!empty($output['gearbox']['car_gears_num'])) {echo $output['gearbox']['car_gears_num'];} else {echo '-';} ?></td>
             </tr>
           
			 <tr>
                      <td>变速箱类型</td>
                      <td><?php if(isset($output['gearbox']['gearbox_type'])&&!empty($output['gearbox']['gearbox_type'])) {echo $output['gearbox']['gearbox_type'];} else {echo '-';} ?></td>
             </tr>
         
			
			
			
		  <tr id="dpzx" class="title">
                    <td>底盘转向</td>
          </tr>
           <tr>
                      <td>驱动方式</td>
                      <td><?php if(isset($output['steer']['car_dirvemode'])&&!empty($output['steer']['car_dirvemode'])) {echo $output['steer']['car_dirvemode'];} else {echo '-';} ?></td>
             </tr>		  
			
			  <tr>
                      <td>前悬架类型</td>
                      <td><?php if(isset($output['steer']['front_suspension_type'])&&!empty($output['steer']['front_suspension_type'])) {echo $output['steer']['front_suspension_type'];} else {echo '-';} ?></td>
             </tr>	

			  <tr>
                      <td>后悬架类型</td>
                      <td><?php if(isset($output['steer']['rear_suspension_type'])&&!empty($output['steer']['rear_suspension_type'])) {echo $output['steer']['rear_suspension_type'];} else {echo '-';} ?></td>
             </tr>	

			  <tr>
                      <td>助力类型</td>
                      <td><?php if(isset($output['steer']['car_powertype'])&&!empty($output['steer']['car_powertype'])) {echo $output['steer']['car_powertype'];} else {echo '-';} ?></td>
             </tr>	

			  <tr>
                      <td>车体结构</td>
                      <td><?php if(isset($output['steer']['body_structure'])&&!empty($output['steer']['body_structure'])) {echo $output['steer']['body_structure'];} else {echo '-';} ?></td>
             </tr>	
 


         <tr id="clzd" class="title">
                    <td>车轮制动</td>
          </tr>
	       <tr>
                      <td>前制动器类型</td>
                      <td><?php if(isset($output['wheel']['front_brake_type'])&&!empty($output['wheel']['front_brake_type'])) {echo $output['wheel']['front_brake_type'];} else {echo '-';} ?></td>
           </tr>	

			  <tr>
                      <td>后制动器类型</td>
                      <td><?php if(isset($output['wheel']['rear_brake_type'])&&!empty($output['wheel']['rear_brake_type'])) {echo $output['wheel']['rear_brake_type'];} else {echo '-';} ?></td>
             </tr>	

			  <tr>
                      <td>驻车制动类型</td>
                      <td><?php if(isset($output['wheel']['parking_brake_type'])&&!empty($output['wheel']['parking_brake_type'])) {echo $output['wheel']['parking_brake_type'];} else {echo '-';} ?></td>
             </tr>	

			  <tr>
                      <td>前轮胎规格</td>
                      <td><?php if(isset($output['wheel']['front_tire_type'])&&!empty($output['wheel']['front_tire_type'])) {echo $output['wheel']['front_tire_type'];} else {echo '-';} ?></td>
             </tr>	

			  <tr>
                      <td>后轮胎规格</td>
                      <td><?php if(isset($output['wheel']['rear_tire_type'])&&!empty($output['wheel']['rear_tire_type'])) {echo $output['wheel']['rear_tire_type'];} else {echo '-';} ?></td>
             </tr>	

			  <tr>
                      <td>备胎规格</td>
                      <td><?php if(isset($output['wheel']['spare_tire_type'])&&!empty($output['wheel']['spare_tire_type'])) {echo $output['wheel']['spare_tire_type'];} else {echo '-';} ?></td>
             </tr>	

         
     <tr id="zbdaqzb" class="title">
                    <td>主/被动安全装备</td>
          </tr>
    <tr>
                      <td>主/副驾驶座安全气囊</td>
                      <td><?php if(isset($output['safe_items']['seat_srs'])&&!empty($output['safe_items']['seat_srs'])) {echo '●';} else {echo '-';} ?></td>
             </tr>	
			
			  <tr>
                      <td>前/后排侧气囊</td>
                      <td><?php if(isset($output['safe_items']['side_srs'])&&!empty($output['safe_items']['side_srs'])) {echo '●';} else {echo '-';} ?></td>
             </tr>	

			  <tr>
                      <td>前/后排头部气囊</td>
                      <td><?php if(isset($output['safe_items']['head_srs'])&&!empty($output['safe_items']['head_srs'])) {echo '●';} else {echo '-';} ?></td>
             </tr>	

			  <tr>
                      <td>膝部气囊</td>
                      <td><?php if(isset($output['safe_items']['knee_bolster'])&&!empty($output['safe_items']['knee_bolster'])) {echo '●';} else {echo '-';} ?></td>
             </tr>	

			  <tr>
                      <td>胎压监测装置</td>
                      <td><?php if(isset($output['safe_items']['tpms'])&&!empty($output['safe_items']['tpms'])) {echo '●';} else {echo '-';} ?></td>
             </tr>	

			  <tr>
                      <td>零胎压继续行驶</td>
                      <td><?php if(isset($output['safe_items']['zero_psi'])&&!empty($output['safe_items']['zero_psi'])) {echo '●';} else {echo '-';} ?></td>
             </tr>	

           <tr>
                      <td>安全带未系提示</td>
                      <td><?php if(isset($output['safe_items']['belt_notice'])&&!empty($output['safe_items']['belt_notice'])) {echo '●';} else {echo '-';} ?></td>
            </tr>				

			  <tr>
                      <td>ISOFIX儿童座椅接口</td>
                      <td><?php if(isset($output['safe_items']['isofix'])&&!empty($output['safe_items']['isofix'])) {echo '●';} else {echo '-';} ?></td>
             </tr>	

			  <tr>
                      <td>发动机电子防盗</td>
                      <td><?php if(isset($output['safe_items']['engine_safe'])&&!empty($output['safe_items']['engine_safe'])) {echo '●';} else {echo '-';} ?></td>
             </tr>	

			  <tr>
                      <td>车内中控锁</td>
                      <td><?php if(isset($output['safe_items']['central_lock'])&&!empty($output['safe_items']['central_lock'])) {echo '●';} else {echo '-';} ?></td>
             </tr>	

			  <tr>
                      <td>遥控钥匙</td>
                      <td><?php if(isset($output['safe_items']['rke'])&&!empty($output['safe_items']['rke'])) {echo '●';} else {echo '-';} ?></td>
             </tr>	

			  <tr>
                      <td>无钥匙启动系统</td>
                      <td><?php if(isset($output['safe_items']['peps'])&&!empty($output['safe_items']['peps'])) {echo '●';} else {echo '-';} ?></td>
             </tr>	

            <tr>
                      <td>无钥匙进入系统</td>
                      <td><?php if(isset($output['safe_items']['pke'])&&!empty($output['safe_items']['pke'])) {echo '●';} else {echo '-';} ?></td>
             </tr>				



        <tr id="zypz" class="title">
                    <td>座椅配置</td>
          </tr>
	      <tr>
                      <td>座椅材质</td>
                      <td><?php if(isset($output['seat_config']['seat_mat'])&&!empty($output['seat_config']['seat_mat'])) {echo $output['seat_config']['seat_mat'];} else {echo '-';} ?></td>
          </tr>	

	      <tr>
                      <td>运动风格座椅</td>
                      <td><?php if(isset($output['seat_config']['mov_seat'])&&!empty($output['seat_config']['mov_seat'])) {echo '●';} else {echo '-';} ?></td>
          </tr>	

	     <tr>
                      <td>座椅高度调节</td>
                      <td><?php if(isset($output['seat_config']['height_set'])&&!empty($output['seat_config']['height_set'])) {echo '●';} else {echo '-';} ?></td>
         </tr>	

	     <tr>
                      <td>要不支撑调节</td>
                      <td><?php if(isset($output['seat_config']['sup_set'])&&!empty($output['seat_config']['sup_set'])) {echo '●';} else {echo '-';} ?></td>
         </tr>	

	     <tr>
                      <td>肩部支撑调节</td>
                      <td><?php if(isset($output['seat_config']['bear_sup_set'])&&!empty($output['seat_config']['bear_sup_set'])) {echo '●';} else {echo '-';} ?></td>
         </tr>	

	      <tr>
                      <td>主/副驾驶座电动调节</td>
                      <td><?php if(isset($output['seat_config']['ele_set'])&&!empty($output['seat_config']['ele_set'])) {echo '●';} else {echo '-';} ?></td>
          </tr>	

	      <tr>
                      <td>第二排靠背角度调节</td>
                      <td><?php if(isset($output['seat_config']['angle_set'])&&!empty($output['seat_config']['angle_set'])) {echo '●';} else {echo '-';} ?></td>
          </tr>	

	      <tr>
                      <td>第二排座椅移动</td>
                      <td><?php if(isset($output['seat_config']['seat_mov'])&&!empty($output['seat_config']['seat_mov'])) {echo '●';} else {echo '-';} ?></td>
          </tr>	

	     <tr>
                      <td>后排座椅电动调节</td>
                      <td><?php if(isset($output['seat_config']['seat_ele_set'])&&!empty($output['seat_config']['seat_ele_set'])) {echo '●';} else {echo '-';} ?></td>
         </tr>	

	     <tr>
                      <td>电动座椅记忆</td>
                      <td><?php if(isset($output['seat_config']['seat_memory'])&&!empty($output['seat_config']['seat_memory'])) {echo '●';} else {echo '-';} ?></td>
         </tr>	

	     <tr>
                      <td>前/后排座椅加热</td>
                      <td><?php if(isset($output['seat_config']['seat_heat'])&&!empty($output['seat_config']['seat_heat'])) {echo '●';} else {echo '-';} ?></td>
          </tr>	

	      <tr>
                      <td>前/后排座椅通风</td>
                      <td><?php if(isset($output['seat_config']['seat_dra'])&&!empty($output['seat_config']['seat_dra'])) {echo '●';} else {echo '-';} ?></td>
          </tr>	

	      <tr>
                      <td>前/后排座椅按摩</td>
                      <td><?php if(isset($output['seat_config']['mas_seat'])&&!empty($output['seat_config']['mas_seat'])) {echo '●';} else {echo '-';} ?></td>
         </tr>	

	      <tr>
                      <td>第三排座椅</td>
                      <td><?php if(isset($output['seat_config']['third_seat'])&&!empty($output['seat_config']['third_seat'])) {echo '●';} else {echo '-';} ?></td>
          </tr>	

	      <tr>
                      <td>后排座椅放倒方式</td>
                      <td><?php if(isset($output['seat_config']['put_way'])&&!empty($output['seat_config']['put_way'])) {echo $output['seat_config']['put_way'];} else {echo '-';} ?></td>
          </tr>	

	       <tr>
                      <td>前/后中央扶手</td>
                      <td><?php if(isset($output['seat_config']['central_arm'])&&!empty($output['seat_config']['central_arm'])) {echo '●';} else {echo '-';} ?></td>
          </tr>	

	       <tr>
                      <td>后排杯架</td>
                      <td><?php if(isset($output['seat_config']['cup_holder'])&&!empty($output['seat_config']['cup_holder'])) {echo '●';} else {echo '-';} ?></td>
          </tr>	



       <tr id="dmtpz" class="title">
                    <td>多媒体配置</td>
        </tr>
	    <tr>
                      <td>GPS导航系统</td>
                      <td><?php if(isset($output['wmm_config']['gps'])&&!empty($output['wmm_config']['gps'])) {echo '●';} else {echo '-';} ?></td>
         </tr>	

	 <tr>
                      <td>定位互动服务</td>
                      <td><?php if(isset($output['wmm_config']['int_serv'])&&!empty($output['wmm_config']['int_serv'])) {echo '●';} else {echo '-';} ?></td>
             </tr>	

	 <tr>
                      <td>中控台彩色大屏</td>
                      <td><?php if(isset($output['wmm_config']['color_creen'])&&!empty($output['wmm_config']['color_creen'])) {echo '●';} else {echo '-';} ?></td>
             </tr>	

	 <tr>
                      <td>蓝牙/车载电话</td>
                      <td><?php if(isset($output['wmm_config']['car_kit'])&&!empty($output['wmm_config']['car_kit'])) {echo '●';} else {echo '-';} ?></td>
             </tr>	

	 <tr>
                      <td>车载电视</td>
                      <td><?php if(isset($output['wmm_config']['tv'])&&!empty($output['wmm_config']['tv'])) {echo '●';} else {echo '-';} ?></td>
             </tr>	

	 <tr>
                      <td>后排液晶屏</td>
                      <td><?php if(isset($output['wmm_config']['lcd'])&&!empty($output['wmm_config']['lcd'])) {echo '●';} else {echo '-';} ?></td>
             </tr>	

	 <tr>
                      <td>220/230v电源</td>
                      <td><?php if(isset($output['wmm_config']['power'])&&!empty($output['wmm_config']['power'])) {echo '●';} else {echo '-';} ?></td>
             </tr>	

	 <tr>
                      <td>外接音源接口</td>
                      <td><?php if(isset($output['wmm_config']['port'])&&!empty($output['wmm_config']['port'])) {echo $output['wmm_config']['port'];} else {echo '-';} ?></td>
             </tr>	

	 <tr>
                      <td>CD支持MP3/WMA</td>
                      <td><?php if(isset($output['wmm_config']['mp3'])&&!empty($output['wmm_config']['mp3'])) {echo '●';} else {echo '-';} ?></td>
             </tr>	

	 <tr>
                      <td>多媒体系统</td>
                      <td><?php if(isset($output['wmm_config']['mat_sys'])&&!empty($output['wmm_config']['mat_sys'])) {echo '●';} else {echo '-';} ?></td>
             </tr>	

	 <tr>
                      <td>扬声器品牌</td>
                      <td><?php if(isset($output['wmm_config']['spk'])&&!empty($output['wmm_config']['spk'])) {echo $output['wmm_config']['spk'];} else {echo '-';} ?></td>
             </tr>	

	 <tr>
                      <td>扬声器数量</td>
                      <td><?php if(isset($output['wmm_config']['spk_number'])&&!empty($output['wmm_config']['spk_number'])) {echo $output['wmm_config']['spk_number'];} else {echo '-';} ?></td>
             </tr>	


	
   <tr id="nbpz" class="title">
        <td>内部配置</td>
    </tr>
    <tr>
      <td>真皮方向盘</td>
       <td><?php if(isset($output['inner_config']['lea_st_wheel'])&&!empty($output['inner_config']['lea_st_wheel'])) {echo '●';} else {echo '-';} ?></td>
    </tr>
    <tr>
      <td>方向盘调节</td>
      <td><?php if(isset($output['inner_config']['wel_adjust'])&&!empty($output['inner_config']['wel_adjust'])) {echo '●';} else {echo '-';} ?></td>
    </tr>
    <tr>
      <td>方向盘电动调节</td>
      <td><?php if(isset($output['inner_config']['wel_ele_adjust'])&&!empty($output['inner_config']['wel_ele_adjust'])) {echo '●';} else {echo '-';} ?></td>
    </tr>
    <tr>
      <td>多功能方向盘</td>
      <td><?php if(isset($output['inner_config']['mfl'])&&!empty($output['inner_config']['mfl'])) {echo '●';} else {echo '-';} ?></td>
    </tr>
    <tr>
      <td>方向盘换挡</td>
      <td><?php if(isset($output['inner_config']['wel_shift'])&&!empty($output['inner_config']['wel_shift'])) {echo '●';} else {echo '-';} ?></td>
    </tr>
    <tr>
      <td>方向盘加热</td>
      <td><?php if(isset($output['inner_config']['lhz'])&&!empty($output['inner_config']['lhz'])) {echo '●';} else {echo '-';} ?></td>
    </tr>
    <tr>
      <td>方向盘记忆</td>
      <td><?php if(isset($output['inner_config']['wel_memory'])&&!empty($output['inner_config']['wel_memory'])) {echo '●';} else {echo '-';} ?></td>
    </tr>
    <tr>
      <td>定速巡航</td>
       <td><?php if(isset($output['inner_config']['cru_control'])&&!empty($output['inner_config']['cru_control'])) {echo '●';} else {echo '-';} ?></td>
    </tr>
    <tr>
      <td>前/后驻车雷达</td>
      <td><?php if(isset($output['inner_config']['park_radar'])&&!empty($output['inner_config']['park_radar'])) {echo '●';} else {echo '-';} ?></td>
    </tr>
    <tr>
      <td>倒车视频影像</td>
      <td><?php if(isset($output['inner_config']['rev_video'])&&!empty($output['inner_config']['rev_video'])) {echo '●';} else {echo '-';} ?></td>
    </tr>
    <tr>
      <td>行车电脑显示屏</td>
      <td><?php if(isset($output['inner_config']['com_screen'])&&!empty($output['inner_config']['com_screen'])) {echo '●';} else {echo '-';} ?></td>
    </tr>
    <tr>
      <td>全夜景仪表盘</td>
      <td><?php if(isset($output['inner_config']['lcd_panel'])&&!empty($output['inner_config']['lcd_panel'])) {echo '●';} else {echo '-';} ?></td>
    </tr>
    <tr>
      <td>hud抬头数字显示</td>
      <td><?php if(isset($output['inner_config']['hud'])&&!empty($output['inner_config']['hud'])) {echo '●';} else {echo '-';} ?></td>
    </tr>



     <tr id="wbfdpz" class="title">
         <td>外部/防盗配置</td>
      </tr>

    <tr>
      <td>电动天窗</td>
      <td><?php if(isset($output['external_config']['ele_sunroof'])&&!empty($output['external_config']['ele_sunroof'])) {echo '●';} else {echo '-';} ?></td>
    </tr>
    <tr>
      <td>全景天窗</td>
       <td><?php if(isset($output['external_config']['pan_sunroof'])&&!empty($output['external_config']['pan_sunroof'])) {echo '●';} else {echo '-';} ?></td>
    </tr>
    <tr>
      <td>运动外观套件</td>
      <td><?php if(isset($output['external_config']['motion_suite'])&&!empty($output['external_config']['motion_suite'])) {echo '●';} else {echo '-';} ?></td>
    </tr>
    <tr>
      <td>铝合金轮圈</td>
      <td><?php if(isset($output['external_config']['alloy_rim'])&&!empty($output['external_config']['alloy_rim'])) {echo '●';} else {echo '-';} ?></td>
    </tr>
    <tr>
      <td>电动吸合门</td>
      <td><?php if(isset($output['external_config']['suction_door'])&&!empty($output['external_config']['suction_door'])) {echo '●';} else {echo '-';} ?></td>
    </tr>
    <tr>
      <td>侧滑门</td>
      <td><?php if(isset($output['external_config']['siding_door'])&&!empty($output['external_config']['siding_door'])) {echo '●';} else {echo '-';} ?></td>
    </tr>
    <tr>
      <td>电动后备箱</td>
      <td><?php if(isset($output['external_config']['ele_trunk'])&&!empty($output['external_config']['ele_trunk'])) {echo '●';} else {echo '-';} ?></td>
    </tr>
    <tr>
      <td>感应后背箱</td>
      <td><?php if(isset($output['external_config']['ind_trunk'])&&!empty($output['external_config']['ind_trunk'])) {echo '●';} else {echo '-';} ?></td>
    </tr>
    <tr>
      <td>车顶行李架</td>
      <td><?php if(isset($output['external_config']['roof_rack'])&&!empty($output['external_config']['roof_rack'])) {echo '●';} else {echo '-';} ?></td>
    </tr>



       <tr id="ckpz" class="title">
            <td>操控配置</td>
       </tr>
    <tr>
      <td>abs防抱死</td>
      <td><?php if(isset($output['control_config']['abs'])&&!empty($output['control_config']['abs'])) {echo '●';} else {echo '-';} ?></td>
    </tr>
    <tr>
      <td>制动力分配</td>
      <td><?php if(isset($output['control_config']['ebd'])&&!empty($output['control_config']['ebd'])) {echo '●';} else {echo '-';} ?></td>
    </tr>
    <tr>
      <td>刹车辅助系统</td>
       <td><?php if(isset($output['control_config']['bas'])&&!empty($output['control_config']['bas'])) {echo '●';} else {echo '-';} ?></td>
    </tr>
    <tr>
      <td>牵引力控制</td>
      <td><?php if(isset($output['control_config']['asr'])&&!empty($output['control_config']['asr'])) {echo '●';} else {echo '-';} ?></td>
    </tr>
    <tr>
      <td>车身稳定控制</td>
      <td><?php if(isset($output['control_config']['esp'])&&!empty($output['control_config']['esp'])) {echo '●';} else {echo '-';} ?></td>
    </tr>
    <tr>
      <td>上坡辅助系统</td>
      <td><?php if(isset($output['control_config']['hac'])&&!empty($output['control_config']['hac'])) {echo '●';} else {echo '-';} ?></td>
    </tr>
    <tr>
      <td>自动驻车系统</td>
      <td><?php if(isset($output['control_config']['auto_hold'])&&!empty($output['control_config']['auto_hold'])) {echo '●';} else {echo '-';} ?></td>
    </tr>
    <tr>
      <td>陡坡缓降</td>
      <td><?php if(isset($output['control_config']['hdc'])&&!empty($output['control_config']['hdc'])) {echo '●';} else {echo '-';} ?></td>
    </tr>
    <tr>
      <td>可变悬架</td>
      <td><?php if(isset($output['control_config']['avs'])&&!empty($output['control_config']['avs'])) {echo '●';} else {echo '-';} ?></td>
    </tr>
    <tr>
      <td>空气悬架</td>
       <td><?php if(isset($output['control_config']['ecas'])&&!empty($output['control_config']['ecas'])) {echo '●';} else {echo '-';} ?></td>
    </tr>
    <tr>
      <td>可变转向比</td>
       <td><?php if(isset($output['control_config']['vgrs'])&&!empty($output['control_config']['vgrs'])) {echo '●';} else {echo '-';} ?></td>
    </tr>
    <tr>
      <td>前桥防滑差速器/差速锁</td>
       <td><?php if(isset($output['control_config']['front_limit'])&&!empty($output['control_config']['front_limit'])) {echo '●';} else {echo '-';} ?></td>
    </tr>
    <tr>
      <td>中央差速器锁止功能</td>
      <td><?php if(isset($output['control_config']['cent_diff_lock'])&&!empty($output['control_config']['cent_diff_lock'])) {echo '●';} else {echo '-';} ?></td>
    </tr>
    <tr>
      <td>后桥限滑差速器/差速锁</td>
      <td><?php if(isset($output['control_config']['rear_limit'])&&!empty($output['control_config']['rear_limit'])) {echo '●';} else {echo '-';} ?></td>
    </tr>

      <tr id="dgpz" class="title">
           <td>灯光配置</td>
       </tr>
    <tr>
      <td>近光灯</td>
        <td><?php if(isset($output['light_config']['dip_helight'])&&!empty($output['light_config']['dip_helight'])) {echo '●';} else {echo '-';} ?></td>
    </tr>
    <tr>
      <td>远光灯</td>
       <td><?php if(isset($output['light_config']['high_beam'])&&!empty($output['light_config']['high_beam'])) {echo '●';} else {echo '-';} ?></td>
    </tr>
    <tr>
      <td>日间行车灯</td>
       <td><?php if(isset($output['light_config']['drl'])&&!empty($output['light_config']['drl'])) {echo '●';} else {echo '-';} ?></td>
    </tr>
    <tr>
      <td>自适应远近光</td>
       <td><?php if(isset($output['light_config']['dist_light'])&&!empty($output['light_config']['dist_light'])) {echo '●';} else {echo '-';} ?></td>
    </tr>
    <tr>
      <td>自动头灯</td>
       <td><?php if(isset($output['light_config']['auto_helamp'])&&!empty($output['light_config']['auto_helamp'])) {echo '●';} else {echo '-';} ?></td>
    </tr>
    <tr>
      <td>转向辅助灯</td>
       <td><?php if(isset($output['light_config']['corn_lamp'])&&!empty($output['light_config']['corn_lamp'])) {echo '●';} else {echo '-';} ?></td>
    </tr>
    <tr>
      <td>转向头灯</td>
       <td><?php if(isset($output['light_config']['ste_helights'])&&!empty($output['light_config']['ste_helights'])) {echo '●';} else {echo '-';} ?></td>
    </tr>
    <tr>
      <td>前雾灯</td>
       <td><?php if(isset($output['light_config']['front_fog_lamp'])&&!empty($output['light_config']['front_fog_lamp'])) {echo '●';} else {echo '-';} ?></td>
    </tr>
    <tr>
      <td>大灯高度可调</td>
       <td><?php if(isset($output['light_config']['helight_adjust'])&&!empty($output['light_config']['helight_adjust'])) {echo '●';} else {echo '-';} ?></td>
    </tr>
    <tr>
      <td>大灯清洗装置</td>
       <td><?php if(isset($output['light_config']['lean_device'])&&!empty($output['light_config']['lean_device'])) {echo '●';} else {echo '-';} ?></td>
    </tr>
    <tr>
      <td>车内氛围灯</td>
        <td><?php if(isset($output['light_config']['atmos_lamp'])&&!empty($output['light_config']['atmos_lamp'])) {echo '●';} else {echo '-';} ?></td>
    </tr>


     <tr id="blhsj" class="title">
        <td>玻璃/后视镜</td>
    </tr>
    <tr>
      <td>前/后电动车窗</td>
     <td><?php if(isset($output['rearview_mirror']['power_wind'])&&!empty($output['rearview_mirror']['power_wind'])) {echo '●';} else {echo '-';} ?></td>
    </tr>
    <tr>
      <td>车窗防夹手功能</td>
     <td><?php if(isset($output['rearview_mirror']['anti_pin_func'])&&!empty($output['rearview_mirror']['anti_pin_func'])) {echo '●';} else {echo '-';} ?></td>
    </tr>
    <tr>
      <td>防紫外线/隔热玻璃</td>
      <td><?php if(isset($output['rearview_mirror']['heat_pro_gla'])&&!empty($output['rearview_mirror']['heat_pro_gla'])) {echo '●';} else {echo '-';} ?></td>
    </tr>
    <tr>
      <td>后视镜电动调节</td>
     <td><?php if(isset($output['rearview_mirror']['elec_control'])&&!empty($output['rearview_mirror']['elec_control'])) {echo '●';} else {echo '-';} ?></td>
    </tr>
    <tr>
      <td>后视镜加热</td>
     <td><?php if(isset($output['rearview_mirror']['revw_mirr_heat'])&&!empty($output['rearview_mirror']['revw_mirr_heat'])) {echo '●';} else {echo '-';} ?></td>
    </tr>
    <tr>
      <td>内/外后视镜自动防眩目</td>
     <td><?php if(isset($output['rearview_mirror']['auto_glare'])&&!empty($output['rearview_mirror']['auto_glare'])) {echo '●';} else {echo '-';} ?></td>
    </tr>
    <tr>
      <td>后视镜电动折叠</td>
     <td><?php if(isset($output['rearview_mirror']['elec_fold_mirr'])&&!empty($output['rearview_mirror']['elec_fold_mirr'])) {echo '●';} else {echo '-';} ?></td>
    </tr>
    <tr>
      <td>后视镜记忆</td>
      <td><?php if(isset($output['rearview_mirror']['revw_mirr_my'])&&!empty($output['rearview_mirror']['revw_mirr_my'])) {echo '●';} else {echo '-';} ?></td>
    </tr>
    <tr>
      <td>后风挡遮阳帘</td>
     <td><?php if(isset($output['rearview_mirror']['rear_win_sunshd'])&&!empty($output['rearview_mirror']['rear_win_sunshd'])) {echo '●';} else {echo '-';} ?></td>
    </tr>
    <tr>
      <td>后排侧遮阳帘</td>
     <td><?php if(isset($output['rearview_mirror']['rear_sd_sun_curt'])&&!empty($output['rearview_mirror']['rear_sd_sun_curt'])) {echo '●';} else {echo '-';} ?></td>
    </tr>
    <tr>
      <td>后排侧隐私玻璃</td>
     <td><?php if(isset($output['rearview_mirror']['priv_glass'])&&!empty($output['rearview_mirror']['priv_glass'])) {echo '●';} else {echo '-';} ?></td>
    </tr>
    <tr>
      <td>遮阳板化妆镜</td>
      <td><?php if(isset($output['rearview_mirror']['sun_visor'])&&!empty($output['rearview_mirror']['sun_visor'])) {echo '●';} else {echo '-';} ?></td>
    </tr>
    <tr>
      <td>后雨刷</td>
      <td><?php if(isset($output['rearview_mirror']['rear_wiper'])&&!empty($output['rearview_mirror']['rear_wiper'])) {echo '●';} else {echo '-';} ?></td>
    </tr>
    <tr>
      <td>感应雨刷</td>
     <td><?php if(isset($output['rearview_mirror']['induc_wiper'])&&!empty($output['rearview_mirror']['induc_wiper'])) {echo '●';} else {echo '-';} ?></td>
    </tr>

      <tr id="gkjpz" class="title">
             <td>高科技配置</td>
       </tr>
    <tr>
      <td>自动泊车入位</td>
      <td><?php if(isset($output['high_tech_config']['auto_pa_ps'])&&!empty($output['high_tech_config']['auto_pa_ps'])) {echo '●';} else {echo '-';} ?></td>
    </tr>
    <tr>
      <td>发动机启停技术</td>
      <td><?php if(isset($output['high_tech_config']['en_st_sp'])&&!empty($output['high_tech_config']['en_st_sp'])) {echo '●';} else {echo '-';} ?></td>
    </tr>
    <tr>
      <td>并线辅助</td>
      <td><?php if(isset($output['high_tech_config']['auxiliary'])&&!empty($output['high_tech_config']['auxiliary'])) {echo '●';} else {echo '-';} ?></td>
    </tr>
    <tr>
      <td>车道偏离预警系统</td>
      <td><?php if(isset($output['high_tech_config']['ldws'])&&!empty($output['high_tech_config']['ldws'])) {echo '●';} else {echo '-';} ?></td>
    </tr>
    <tr>
      <td>主动刹车/主动安全系统</td>
      <td><?php if(isset($output['high_tech_config']['act_brake'])&&!empty($output['high_tech_config']['act_brake'])) {echo '●';} else {echo '-';} ?></td>
    </tr>
    <tr>
      <td>中控液晶屏分屏显示</td>
      <td><?php if(isset($output['high_tech_config']['scr_display'])&&!empty($output['high_tech_config']['scr_display'])) {echo '●';} else {echo '-';} ?></td>
    </tr>
    <tr>
      <td>自适应巡航</td>
      <td><?php if(isset($output['high_tech_config']['ada_cruise'])&&!empty($output['high_tech_config']['ada_cruise'])) {echo '●';} else {echo '-';} ?></td>
    </tr>
    <tr>
      <td>全景摄像头</td>
      <td><?php if(isset($output['high_tech_config']['pan_cam'])&&!empty($output['high_tech_config']['pan_cam'])) {echo '●';} else {echo '-';} ?></td>
    </tr>

      <tr id="bxkt" class="title">
           <td>空调/冰箱</td>
      </tr>

    <tr>
      <td>空调控制方式</td>
      <td><?php if(isset($output['refrigerator']['con_metd'])&&!empty($output['refrigerator']['con_metd'])) {echo $output['refrigerator']['con_metd'];} else {echo '-';} ?></td>
    </tr>
    <tr>
      <td>后排独立空调</td>
      <td><?php if(isset($output['refrigerator']['bac_row_air_cond'])&&!empty($output['refrigerator']['bac_row_air_cond'])) {echo '●';} else {echo '-';} ?></td>
    </tr>
    <tr>
      <td>后座出风口</td>
      <td><?php if(isset($output['refrigerator']['rear_outlet'])&&!empty($output['refrigerator']['rear_outlet'])) {echo '●';} else {echo '-';} ?></td>
    </tr>
    <tr>
      <td>温度分区控制</td>
     <td><?php if(isset($output['refrigerator']['temp_zone_con'])&&!empty($output['refrigerator']['temp_zone_con'])) {echo '●';} else {echo '-';} ?></td>
    </tr>
    <tr>
      <td>车内空气调节/花粉过滤</td>
      <td><?php if(isset($output['refrigerator']['pollen_filtra'])&&!empty($output['refrigerator']['pollen_filtra'])) {echo '●';} else {echo '-';} ?></td>
    </tr>
    <tr>
      <td>车载冰箱</td>
      <td><?php if(isset($output['refrigerator']['car_refrig'])&&!empty($output['refrigerator']['car_refrig'])) {echo '●';} else {echo '-';} ?></td>
    </tr>
      </tbody>
    </table>
  </div>
 </div>


   <div class="ncs-comment">
      <div class="ncs-goods-title-bar hd">
        <h4><a href="javascript:void(0);"><?php echo $lang['goods_index_evaluation'];?></a></h4>
      </div>
      <div class="ncs-goods-info-content bd" id="ncGoodsRate">
        <div class="top">
          <div class="rate">
            <p><strong><?php echo $output['goods_evaluate_info']['good_percent'];?></strong><sub>%</sub>好评</p>
            <span>共有<?php echo $output['goods_evaluate_info']['all'];?>人参与评分</span></div>
          <div class="percent">
            <dl>
              <dt>好评<em>(<?php echo $output['goods_evaluate_info']['good_percent'];?>%)</em></dt>
              <dd><i style="width: <?php echo $output['goods_evaluate_info']['good_percent'];?>%"></i></dd>
            </dl>
            <dl>
              <dt>中评<em>(<?php echo $output['goods_evaluate_info']['normal_percent'];?>%)</em></dt>
              <dd><i style="width: <?php echo $output['goods_evaluate_info']['normal_percent'];?>%"></i></dd>
            </dl>
            <dl>
              <dt>差评<em>(<?php echo $output['goods_evaluate_info']['bad_percent'];?>%)</em></dt>
              <dd><i style="width: <?php echo $output['goods_evaluate_info']['bad_percent'];?>%"></i></dd>
            </dl>
          </div>
          <div class="btns"><span>您可对已购商品进行评价</span>
            <p><a href="<?php if ($output['goods']['is_virtual']) { echo urlShop('member_vr_order', 'index');} else { echo urlShop('member_order', 'index');}?>" class="ncs-btn ncs-btn-red" target="_blank"><i class="icon-comment-alt"></i>评价商品</a></p>
          </div>
        </div>
        <div class="ncs-goods-title-nav">
          <ul id="comment_tab">
            <li data-type="all" class="current"><a href="javascript:void(0);"><?php echo $lang['goods_index_evaluation'];?>(<?php echo $output['goods_evaluate_info']['all'];?>)</a></li>
            <li data-type="1"><a href="javascript:void(0);">好评(<?php echo $output['goods_evaluate_info']['good'];?>)</a></li>
            <li data-type="2"><a href="javascript:void(0);">中评(<?php echo $output['goods_evaluate_info']['normal'];?>)</a></li>
            <li data-type="3"><a href="javascript:void(0);">差评(<?php echo $output['goods_evaluate_info']['bad'];?>)</a></li>
          </ul>
        </div>
        <!-- 商品评价内容部分 -->
        <div id="goodseval" class="ncs-commend-main"></div>
      </div>
    </div>
    <div class="ncg-salelog">
      <div class="ncs-goods-title-bar hd">
        <h4><a href="javascript:void(0);"><?php echo $lang['goods_index_sold_record'];?></a></h4>
      </div>
      <div class="ncs-goods-info-content bd" id="ncGoodsTraded">
        <div class="top">
          <div class="price"><?php echo $lang['goods_index_goods_price'];?><strong><?php echo $output['goods']['goods_price'];?></strong><?php echo $lang['goods_index_yuan'];?><span><?php echo $lang['goods_index_price_note'];?></span></div>
        </div>
        <!-- 成交记录内容部分 -->
        <div id="salelog_demo" class="ncs-loading"> </div>
      </div>
    </div>
    <div class="ncs-consult">
      <div class="ncs-goods-title-bar hd">
        <h4><a href="javascript:void(0);"><?php echo $lang['goods_index_goods_consult'];?></a></h4>
      </div>
      <div class="ncs-goods-info-content bd" id="ncGuestbook"> 
        <!-- 咨询留言内容部分 -->
        <div id="consulting_demo" class="ncs-loading"> </div>
      </div>
    </div>
    <?php if(!empty($output['goods_commend']) && is_array($output['goods_commend']) && count($output['goods_commend'])>1){?>
    <div class="ncs-recommend">
      <div class="title">
        <h4><?php echo $lang['goods_index_goods_commend'];?></h4>
      </div>
      <div class="content">
        <ul>
          <?php foreach($output['goods_commend'] as $goods_commend){?>
          <?php if($output['goods']['goods_id'] != $goods_commend['goods_id']){?>
          <li>
            <dl>
              <dt class="goods-name"><a href="<?php echo urlShop('goods', 'index', array('goods_id' => $goods_commend['goods_id']));?>" target="_blank" title="<?php echo $goods_commend['goods_jingle'];?>"><?php echo $goods_commend['goods_name'];?><em><?php echo $goods_commend['goods_jingle'];?></em></a></dt>
              <dd class="goods-pic"><a href="<?php echo urlShop('goods', 'index', array('goods_id' => $goods_commend['goods_id']));?>" target="_blank" title="<?php echo $goods_commend['goods_jingle'];?>"><img src="<?php echo UPLOAD_SITE_URL;?>/shop/common/loading.gif" rel="lazy" data-url="<?php echo thumb($goods_commend, 240);?>" alt="<?php echo $goods_commend['goods_name'];?>"/></a></dd>
              <dd class="goods-price"><?php echo $lang['currency'];?><?php echo $goods_commend['goods_price'];?></dd>
            </dl>
          </li>
          <?php }?>
          <?php }?>
        </ul>
        <div class="clear"></div>
      </div>
    </div>
    <?php }?>
  </div>
  <div class="ncs-sidebar">
    <?php include template('store/callcenter'); ?>
    <?php if ($output['left_bar_type_mall_related']) {
        include template('store/left_mall_related');
    } else {
        include template('store/left');
    } ?>
    <?php if ($output['viewed_goods']) { ?>
    <!-- 最近浏览 -->
    <div class="ncs-sidebar-container ncs-top-bar" style="display: none">
      <div class="title">
        <h4>最近浏览</h4>
      </div>
      <div class="content">
        <div id="hot_sales_list" class="ncs-top-panel">
          <ol>
            <?php foreach ((array) $output['viewed_goods'] as $g) { ?>
            <li>
              <dl>
                <dt><a href="<?php echo urlShop('goods', 'index', array('goods_id' => $g['goods_id'])); ?>"><?php echo $g['goods_name']; ?></a></dt>
                <dd class="goods-pic"><a href="<?php echo urlShop('goods', 'index', array('goods_id' => $g['goods_id'])); ?>"><span class="thumb size40"><i></i><img src="<?php echo thumb($g, 60); ?>"  onload="javascript:DrawImage(this,40,40);"></span></a>
                  <p><span class="thumb size100"><i></i><img src="<?php echo thumb($g, 240); ?>" onload="javascript:DrawImage(this,100,100);" title="<?php echo $g['goods_name']; ?>"><big></big><small></small></span></p>
                </dd>
                <dd class="price pngFix"><?php echo ncPriceFormat($g['goods_promotion_price']); ?></dd>
              </dl>
            </li>
            <?php } ?>
          </ol>
        </div>
        <a href="<?php echo SHOP_SITE_URL;?>/index.php?act=member_goodsbrowse&op=list" class="nch-sidebar-all-viewed">全部浏览历史</a> </div>
    </div>
    <?php } ?>
  </div>
</div>
</div>
<form id="buynow_form" method="post" action="<?php echo SHOP_SITE_URL;?>/index.php">
  <input id="act" name="act" type="hidden" value="buy" />
  <input id="op" name="op" type="hidden" value="buy_step1" />
  <input id="cart_id" name="cart_id[]" type="hidden"/>
</form>
<script type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/js/jquery.charCount.js"></script> 
<script src="<?php echo RESOURCE_SITE_URL;?>/js/jquery.ajaxContent.pack.js" type="text/javascript"></script> 
<script src="<?php echo RESOURCE_SITE_URL;?>/js/sns.js" type="text/javascript" charset="utf-8"></script> 
<script src="<?php echo RESOURCE_SITE_URL;?>/js/jquery.F_slider.js" type="text/javascript" charset="utf-8"></script> 
<script type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/js/waypoints.js"></script> 
<script type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/js/jquery.raty/jquery.raty.min.js"></script> 
<script type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/js/jquery.nyroModal/custom.min.js" charset="utf-8"></script>
<link href="<?php echo RESOURCE_SITE_URL;?>/js/jquery.nyroModal/styles/nyroModal.css" rel="stylesheet" type="text/css" id="cssfile2" />
<script type="text/javascript">
/** 辅助浏览 **/
jQuery(function($){
	// 放大镜效果 产品图片
     CloudZoom.quickStart();
     
     		    // 图片切换效果
                $(".controller li").first().addClass('current');
                $('.controller').find('li').mouseover(function(){
                $(this).first().addClass("current").siblings().removeClass("current");
                });
});

    //收藏分享处下拉操作
    jQuery.divselect = function(divselectid,inputselectid) {
      var inputselect = $(inputselectid);
      $(divselectid).mouseover(function(){
          var ul = $(divselectid+" ul");
          ul.slideDown("fast");
          if(ul.css("display")=="none"){
              ul.slideDown("fast");
          }
      });
      $(divselectid).live('mouseleave',function(){
          $(divselectid+" ul").hide();
      });
    };
$(function(){
	//赠品处滚条
	$('#ncsGoodsGift').perfectScrollbar({suppressScrollX:true});
    <?php if ($output['goods']['goods_state'] == 1 && $output['goods']['goods_storage'] > 0 ) {?>
    // 加入购物车
    $('a[nctype="addcart_submit"]').click(function(){
    	if (typeof(allow_buy) != 'undefined' && allow_buy === false) return ;
      <?php if ($_SESSION['is_login'] !== '1'){?>
  login_dialog();
<?php }else{?>
        addcart(<?php echo $output['goods']['goods_id'];?>, checkQuantity(),'addcart_callback');
        <?php } ?>
    });
        <?php if (!($output['goods']['is_virtual'] == 1 && $output['goods']['virtual_indate'] < TIMESTAMP)) {?>
        // 立即购买
        $('a[nctype="buynow_submit"]').click(function(){
        	if (typeof(allow_buy) != 'undefined' && allow_buy === false) return ;
            buynow(<?php echo $output['goods']['goods_id']?>,checkQuantity());
        });
        <?php }?>
    <?php }?>
    // 到货通知
    <?php if ($output['goods']['goods_storage'] == 0 || $output['goods']['goods_state'] == 0) {?>
    $('a[nctype="arrival_notice"]').click(function(){
        <?php if ($_SESSION['is_login'] !== '1'){?>
        login_dialog();
        <?php }else{?>
        ajax_form('arrival_notice', '到货通知','<?php echo urlShop('goods', 'arrival_notice', array('goods_id' => $output['goods']['goods_id']));?>', 350);
        <?php }?>
    });
    <?php }?>
    <?php if (($output['goods']['goods_state'] == 0 || $output['goods']['goods_storage'] <= 0) && $output['goods']['is_appoint'] == 1) {?>
    $('a[nctype="appoint_submit"]').click(function(){
        <?php if ($_SESSION['is_login'] !== '1'){?>
        login_dialog();
        <?php }else{?>
        ajax_form('arrival_notice', '立即预约', '<?php echo urlShop('goods', 'arrival_notice', array('goods_id' => $output['goods']['goods_id'], 'type' => 2));?>', 350);
        <?php }?>
    });
    <?php }?>
    //浮动导航  waypoints.js
    $('#main-nav').waypoint(function(event, direction) {
        $(this).parent().parent().parent().toggleClass('sticky', direction === "down");
        event.stopPropagation();
    });

    // 分享收藏下拉操作
    $.divselect("#handle-l");
    $.divselect("#handle-r");

    // 规格选择
    $('dl[nctype="nc-spec"]').find('a').each(function(){
        $(this).click(function(){
            if ($(this).hasClass('hovered')) {
                return false;
            }
            $(this).parents('ul:first').find('a').removeClass('hovered');
            $(this).addClass('hovered');
            checkSpec();
        });
    });

});

function checkSpec() {
    var spec_param = <?php echo $output['spec_list'];?>;
    var spec = new Array();
    $('ul[nctyle="ul_sign"]').find('.hovered').each(function(){
        var data_str = ''; eval('data_str =' + $(this).attr('data-param'));
        spec.push(data_str.valid);
    });
    spec1 = spec.sort(function(a,b){
        return a-b;
    });
    var spec_sign = spec1.join('|');
    $.each(spec_param, function(i, n){
        if (n.sign == spec_sign) {
            window.location.href = n.url;
        }
    });
}

// 验证购买数量
function checkQuantity(){
    var quantity = parseInt($("#quantity").val());
    if (quantity < 1) {
        alert("<?php echo $lang['goods_index_pleaseaddnum'];?>");
        $("#quantity").val('1');
        return false;
    }
    max = parseInt($('[nctype="goods_stock"]').text());
    <?php if ($output['goods']['is_virtual'] == 1 && $output['goods']['virtual_limit'] > 0) {?>
    max = <?php echo $output['goods']['virtual_limit'];?>;
    if(quantity > max){
        alert('最多限购'+max+'件');
        return false;
    }
    <?php } ?>
    <?php if (!empty($output['goods']['upper_limit'])) {?>
    max = <?php echo $output['goods']['upper_limit'];?>;
    if(quantity > max){
        alert('最多限购'+max+'件');
        return false;
    }
    <?php } ?>
    if(quantity > max){
        alert("<?php echo $lang['goods_index_add_too_much'];?>");
        return false;
    }
    return quantity;
}

// 立即购买js
function buynow(goods_id,quantity){
<?php if ($_SESSION['is_login'] !== '1'){?>
	login_dialog();
<?php }else{?>
    if (!quantity) {
        return;
    }
    <?php if ($_SESSION['store_id'] == $output['goods']['store_id']) { ?>
    alert('不能购买自己店铺的商品');return;
    <?php } ?>
    $("#cart_id").val(goods_id+'|'+quantity);
    $("#buynow_form").submit();
<?php }?>
}

$(function(){
    //选择地区查看运费
    $('#transport_pannel>a').click(function(){
    	var id = $(this).attr('nctype');
    	if (id=='undefined') return false;
    	var _self = this,tpl_id = '<?php echo $output['goods']['transport_id'];?>';
	    var url = 'index.php?act=goods&op=calc&rand='+Math.random();
	    $('#transport_price').css('display','none');
	    $('#loading_price').css('display','');
	    $.getJSON(url, {'id':id,'tid':tpl_id}, function(data){
	    	if (data == null) return false;
	        if(data != 'undefined') {$('#nc_kd').html('运费<?php echo $lang['nc_colon'];?><em>' + data + '</em><?php echo $lang['goods_index_yuan'];?>');}else{'<?php echo $lang['goods_index_trans_for_seller'];?>';}
	        $('#transport_price').css('display','');
	    	$('#loading_price').css('display','none');
	        $('#ncrecive').html($(_self).html());
	    });
    });
    $("#nc-bundling").load('index.php?act=goods&op=get_bundling&goods_id=<?php echo $output['goods']['goods_id'];?>', function(){
        if($(this).html() != '') {
            $(this).show();
        }
    });
    $("#salelog_demo").load('index.php?act=goods&op=salelog&goods_id=<?php echo $output['goods']['goods_id'];?>&store_id=<?php echo $output['goods']['store_id'];?>&vr=<?php echo $output['goods']['is_virtual'];?>', function(){
        // Membership card
        $(this).find('[nctype="mcard"]').membershipCard({type:'shop'});
    });
	$("#consulting_demo").load('index.php?act=goods&op=consulting&goods_id=<?php echo $output['goods']['goods_id'];?>&store_id=<?php echo $output['goods']['store_id'];?>', function(){
		// Membership card
		$(this).find('[nctype="mcard"]').membershipCard({type:'shop'});
	});

/** goods.php **/
	// 商品内容部分折叠收起侧边栏控制
	$('#fold').click(function(){
  		$('.ncs-goods-layout').toggleClass('expanded');
	});
	// 商品内容介绍Tab样式切换控制
	$('#categorymenu').find("li").click(function(){
		$('#categorymenu').find("li").removeClass('current');
		$(this).addClass('current');
	});
	// 商品详情默认情况下显示全部
	$('#tabGoodsIntro').click(function(){
		$('.bd').css('display','');
		$('.hd').css('display','');
	});
	// 点击地图隐藏其他以及其标题栏
	$('#tabStoreMap').click(function(){
		$('.bd').css('display','none');
		$('#ncStoreMap').css('display','');
		$('.hd').css('display','none');
	});
	
	// 点击参数配置隐藏其他以及其标题栏
	$('#tabGoodsConfiguration').click(function(){
		$('.bd').css('display','none');
		$('#ncGoodsConfiguration').css('display','');
		$('.hd').css('display','none');
	});
	// 点击评价隐藏其他以及其标题栏
	$('#tabGoodsRate').click(function(){
		$('.bd').css('display','none');
		$('#ncGoodsRate').css('display','');
		$('.hd').css('display','none');
	});
	// 点击成交隐藏其他以及其标题
	$('#tabGoodsTraded').click(function(){
		$('.bd').css('display','none');
		$('#ncGoodsTraded').css('display','');
		$('.hd').css('display','none');
	});
	// 点击咨询隐藏其他以及其标题
	$('#tabGuestbook').click(function(){
		$('.bd').css('display','none');
		$('#ncGuestbook').css('display','');
		$('.hd').css('display','none');
	});
	//商品排行Tab切换
	$(".ncs-top-tab > li > a").mouseover(function(e) {
		if (e.target == this) {
			var tabs = $(this).parent().parent().children("li");
			var panels = $(this).parent().parent().parent().children(".ncs-top-panel");
			var index = $.inArray(this, $(this).parent().parent().find("a"));
			if (panels.eq(index)[0]) {
				tabs.removeClass("current ").eq(index).addClass("current ");
				panels.addClass("hide").eq(index).removeClass("hide");
			}
		}
	});
	//信用评价动态评分打分人次Tab切换
	$(".ncs-rate-tab > li > a").mouseover(function(e) {
		if (e.target == this) {
			var tabs = $(this).parent().parent().children("li");
			var panels = $(this).parent().parent().parent().children(".ncs-rate-panel");
			var index = $.inArray(this, $(this).parent().parent().find("a"));
			if (panels.eq(index)[0]) {
				tabs.removeClass("current ").eq(index).addClass("current ");
				panels.addClass("hide").eq(index).removeClass("hide");
			}
		}
	});

//触及显示缩略图
	$('.goods-pic > .thumb').hover(
		function(){
			$(this).next().css('display','block');
		},
		function(){
			$(this).next().css('display','none');
		}
	);

	/* 商品购买数量增减js */
	// 增加
	$('a[nctype="increase"]').click(function(){
		num = parseInt($('#quantity').val());
	    <?php if ($output['goods']['is_virtual'] == 1 && $output['goods']['virtual_limit'] > 0) {?>
	    max = <?php echo $output['goods']['virtual_limit'];?>;
	    if(num >= max){
	        alert('最多限购'+max+'件');
	        return false;
	    }
	    <?php } ?>
	    <?php if (!empty($output['goods']['upper_limit'])) {?>
	    max = <?php echo $output['goods']['upper_limit'];?>;
	    if(num >= max){
	        alert('最多限购'+max+'件');
	        return false;
	    }
	    <?php } ?>
		max = parseInt($('[nctype="goods_stock"]').text());
		if(num < max){
			$('#quantity').val(num+1);
		}
	});
	//减少
	$('a[nctype="decrease"]').click(function(){
		num = parseInt($('#quantity').val());
		if(num > 1){
			$('#quantity').val(num-1);
		}
	});

    //评价列表
    $('#comment_tab').on('click', 'li', function() {
        $('#comment_tab li').removeClass('current');
        $(this).addClass('current');
        load_goodseval($(this).attr('data-type'));
    });
    load_goodseval('all');
    function load_goodseval(type) {
        var url = '<?php echo urlShop('goods', 'comments', array('goods_id' => $output['goods']['goods_id']));?>';
        url += '&type=' + type;
        $("#goodseval").load(url, function(){
            $(this).find('[nctype="mcard"]').membershipCard({type:'shop'});
        });
    }

    //记录浏览历史
	$.get("index.php?act=goods&op=addbrowse",{gid:<?php echo $output['goods']['goods_id'];?>});
	//初始化对比按钮
	initCompare();

    <?php if ($output['goods']['jjg_explain']) { ?>
        $('.couRuleScrollbar').perfectScrollbar({suppressScrollX:true});
    <?php }?>

    // 满即送、加价购显示隐藏
    $('[nctype="show-rule"]').click(function(){
        $(this).parent().find('[nctype="rule-content"]').show();
    });
    $('[nctype="hide-rule"]').click(function(){
        $(this).parents('[nctype="rule-content"]:first').hide()
    });

    $('.ncs-buy').bind({
        mouseover:function(){$(".ncs-point").show();},
        mouseout:function(){$(".ncs-point").hide();}
    });
    
});

/* 加入购物车后的效果函数 */
function addcart_callback(data){

	$('#bold_num').html(data.num);
    $('#bold_mly').html(price_format(data.amount));
    $('.ncs-cart-popup').fadeIn('fast');
   
}

<?php if($output['goods']['goods_state'] == 1 && $output['goods']['goods_verify'] == 1 && $output['goods']['is_virtual'] == 0){ ?>
var $cur_area_list,$cur_tab,next_tab_id = 0,cur_select_area = [],calc_area_id = '',calced_area = [],cur_select_area_ids = [];
$(document).ready(function(){
	$("#ncs-freight-selector").hover(function() {
		//如果店铺没有设置默认显示区域，马上异步请求
		<?php if (!$output['store_info']['deliver_region']) { ?>
		if (typeof nc_a === "undefined") {
	 		$.getJSON(SITEURL + "/index.php?act=index&op=json_area&callback=?", function(data) {
	 			nc_a = data;
	 			$cur_tab = $('#ncs-stock').find('li[data-index="0"]');
	 			_loadArea(0);
	 		});
		}
		<?php } ?>
		$(this).addClass("hover");
		$(this).on('mouseleave',function(){
			$(this).removeClass("hover");
		});
	});

	$('ul[class="area-list"]').on('click','a',function(){
		$('#ncs-freight-selector').unbind('mouseleave');
		var tab_id = parseInt($(this).parents('div[data-widget="tab-content"]:first').attr('data-area'));
		if (tab_id == 0) {cur_select_area = [];cur_select_area_ids = []};
		if (tab_id == 1 && cur_select_area.length > 1) {
			cur_select_area.pop();
			cur_select_area_ids.pop();
			if (cur_select_area.length > 1) {
				cur_select_area.pop();
				cur_select_area_ids.pop();
			}
		}
		next_tab_id = tab_id + 1;
		var area_id = $(this).attr('data-value');
		$cur_tab = $('#ncs-stock').find('li[data-index="'+tab_id+'"]');
		$cur_tab.find('em').html($(this).html());
		$cur_tab.find('i').html(' ∨');
		if (tab_id < 2) {
			calc_area_id = area_id;
			cur_select_area.push($(this).html());
			cur_select_area_ids.push(area_id);
			$cur_tab.find('a').removeClass('hover');
			$cur_tab.nextAll().remove();
			if (typeof nc_a === "undefined") {
    	 		$.getJSON(SITEURL + "/index.php?act=index&op=json_area&callback=?", function(data) {
    	 			nc_a = data;
    	 			_loadArea(area_id);
    	 		});
			} else {
				_loadArea(area_id);
			}
		} else {
			//点击第三级，不需要显示子分类
			if (cur_select_area.length == 3) {
				cur_select_area.pop();
				cur_select_area_ids.pop();
			}
			cur_select_area.push($(this).html());
			cur_select_area_ids.push(area_id);
			$('#ncs-freight-selector > div[class="text"] > div').html(cur_select_area.join(''));
			$('#ncs-freight-selector').removeClass("hover");
			_calc();
		}
		$('#ncs-stock').find('li[data-widget="tab-item"]').on('click','a',function(){
			var tab_id = parseInt($(this).parent().attr('data-index'));
			if (tab_id < 2) {
				$(this).parent().nextAll().remove();
				$(this).addClass('hover');
				$('#ncs-stock').find('div[data-widget="tab-content"]').each(function(){
					if ($(this).attr("data-area") == tab_id) {
						$(this).show();
					} else {
						$(this).hide();
					}
				});
			}
		});
	});
	function _loadArea(area_id){
		if (nc_a[area_id] && nc_a[area_id].length > 0) {
			$('#ncs-stock').find('div[data-widget="tab-content"]').each(function(){
				if ($(this).attr("data-area") == next_tab_id) {
					$(this).show();
					$cur_area_list = $(this).find('ul');
					$cur_area_list.html('');
				} else {
					$(this).hide();
				}
			});
			var areas = [];
			areas = nc_a[area_id];
			for (i = 0; i < areas.length; i++) {
				if (areas[i][1].length > 8) {
					$cur_area_list.append("<li class='longer-area'><a data-value='" + areas[i][0] + "' href='#none'>" + areas[i][1] + "</a></li>");
				} else {
				    $cur_area_list.append("<li><a data-value='" + areas[i][0] + "' href='#none'>" + areas[i][1] + "</a></li>");
				}
			}
			if (area_id > 0){
				$cur_tab.after('<li data-index="' + (next_tab_id) + '" data-widget="tab-item"><a class="hover" href="#none" ><em>请选择</em><i> ∨</i></a></li>');
			}
		} else {
			//点击第一二级时，已经到了最后一级
			$cur_tab.find('a').addClass('hover');
			$('#ncs-freight-selector > div[class="text"] > div').html(cur_select_area);
			$('#ncs-freight-selector').removeClass("hover");
			_calc();
		}
	}
	//计算运费，是否配送
	function _calc() {
		$.cookie('dregion', cur_select_area_ids.join(' ')+'|'+cur_select_area.join(' '), { expires: 30 });
		<?php if (! $output['goods']['transport_id']) { ?>
		return;
		<?php } ?>
		var _args = '';
		_args += "&tid=<?php echo $output['goods']['transport_id']?>";
		<?php if ($output['store_info']['is_own_shop']) { ?>
		_args += "&super=1";
				<?php } ?>
		if (_args != '') {
			_args += '&area_id=' + calc_area_id ;
			if (typeof calced_area[calc_area_id] == 'undefined') {
				//需要请求配送区域设置
				$.getJSON(SITEURL + "/index.php?act=goods&op=calc&" + _args + "&myf=<?php echo $output['store_info']['store_free_price']?>&callback=?", function(data){
					allow_buy = data.total ? true : false;
					calced_area[calc_area_id] = data.total;
					if (data.total === false) {
						$('#ncs-freight-prompt > strong').html('无货').next().remove();
						$('a[nctype="buynow_submit"]').addClass('no-buynow');
						$('a[nctype="addcart_submit"]').addClass('no-buynow');
						$('#store-free-time').hide();
					} else {
						$('#ncs-freight-prompt > strong').html('有货 ').next().remove();
						$('#ncs-freight-prompt > strong').after('<span>' + data.total + '</span>');
						$('a[nctype="buynow_submit"]').removeClass('no-buynow');
						$('a[nctype="addcart_submit"]').removeClass('no-buynow');
						$('#store-free-time').show();
					}
				});	
			} else {
				if (calced_area[calc_area_id] === false) {
					$('#ncs-freight-prompt > strong').html('无货').next().remove();
					$('a[nctype="buynow_submit"]').addClass('no-buynow');
					$('a[nctype="addcart_submit"]').addClass('no-buynow');
					$('#store-free-time').hide();
				} else {
					$('#ncs-freight-prompt > strong').html('有货 ').next().remove();
					$('#ncs-freight-prompt > strong').after('<span>' + calced_area[calc_area_id] + '</span>');
					$('a[nctype="buynow_submit"]').removeClass('no-buynow');
					$('a[nctype="addcart_submit"]').removeClass('no-buynow');
					$('#store-free-time').show();
				}
			}
		}
	}
	//如果店铺设置默认显示配送区域
	<?php if ($output['store_info']['deliver_region']) { ?>
	if (typeof nc_a === "undefined") {
 		$.getJSON(SITEURL + "/index.php?act=index&op=json_area&callback=?", function(data) {
 			nc_a = data;
 			$cur_tab = $('#ncs-stock').find('li[data-index="0"]');
 			_loadArea(0);
 			$('ul[class="area-list"]').find('a[data-value="<?php echo $output['store_info']['deliver_region_ids'][0]?>"]').click();
 		    <?php if ($output['store_info']['deliver_region_ids'][1]) { ?>
 			$('ul[class="area-list"]').find('a[data-value="<?php echo $output['store_info']['deliver_region_ids'][1]?>"]').click();
 		    <?php } ?>
  		    <?php if ($output['store_info']['deliver_region_ids'][2]) { ?>
 			$('ul[class="area-list"]').find('a[data-value="<?php echo $output['store_info']['deliver_region_ids'][2]?>"]').click();
 			<?php } ?>
 		});
	}
	<?php } ?>
});
<?php }?>
</script> 