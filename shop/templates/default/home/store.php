<?php defined('InShopNC') or exit('Access Invalid!');?>
<link href="<?php echo SHOP_TEMPLATES_URL;?>/css/layout.css" rel="stylesheet" type="text/css">
<style type="text/css">
.nc-appbar-tabs a.compare { display: none !important;}
</style>
<br/>
<div class="nch-container wrapper">
  <div class="nch-all-menu">
    <ul class="tab-bar">
      <li class="current"><a href="javascript:void(0);">全部商家</a></li>
    </ul>
  </div>

      <?php if(!empty($output['store_list'])) {?>
   
    <div class="nch-barnd-list tabs-panel ">
      <ul>
        <?php foreach($output['store_list'] as $key=>$store){?>
        <li>
          <dl>
            <dt><a href="<?php echo urlShop('show_store','', array('store_id'=>$store['store_id']),$store['store_domain']);?>"><img src="<?php echo getStoreLogo($store['store_avatar']);?>" rel="lazy"  alt="<?php echo $store['store_name'];?>" /></a></dt>
            <dd><a href="<?php echo urlShop('show_store','', array('store_id'=>$store['store_id']),$store['store_domain']);?>"><?php echo $store['store_name'];?></a></dd>
           </dl>
        </li>
        <?php }?>
       
      </ul>
   
    </div>
    <?php }?>
</div>
<script>
//首页Tab标签卡滑门切换
$(".tabs-nav > li > a").live('mousedown', (function(e) {
	if (e.target == this) {
		var tabs = $(this).parents('ul:first').children("li");
		var panels = $(this).parents('.nch-brand-class:first').children(".tabs-panel");
		var index = $.inArray(this, $(this).parents('ul:first').find("a"));
		if (panels.eq(index)[0]) {
			tabs.removeClass("tabs-selected").eq(index).addClass("tabs-selected");
			panels.addClass("tabs-hide").eq(index).removeClass("tabs-hide");
		}
	}
}));
</script>