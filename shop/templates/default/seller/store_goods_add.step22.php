<?php defined('InShopNC') or exit('Access Invalid!');?>
<script src="<?php echo RESOURCE_SITE_URL;?>/js/jquery.ajaxContent.pack.js"></script>
<script src="<?php echo RESOURCE_SITE_URL;?>/js/jquery-ui/i18n/zh-CN.js"></script>
<script src="<?php echo RESOURCE_SITE_URL;?>/js/common_select.js"></script>
<script type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/js/fileupload/jquery.iframe-transport.js" charset="utf-8"></script>
<script type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/js/fileupload/jquery.ui.widget.js" charset="utf-8"></script>
<script type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/js/fileupload/jquery.fileupload.js" charset="utf-8"></script>
<script src="<?php echo RESOURCE_SITE_URL;?>/js/jquery.poshytip.min.js"></script>
<script src="<?php echo RESOURCE_SITE_URL;?>/js/jquery.mousewheel.js"></script>
<script type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/js/jquery.charCount.js"></script>
<!--[if lt IE 8]>
  <script src="<?php echo RESOURCE_SITE_URL;?>/js/json2.js"></script>
<![endif]-->
<script src="<?php echo SHOP_RESOURCE_SITE_URL;?>/js/store_goods_add.step2.js"></script>
<link rel="stylesheet" type="text/css" href="<?php echo RESOURCE_SITE_URL;?>/js/jquery-ui/themes/ui-lightness/jquery.ui.css"  />
<style type="text/css">
#fixedNavBar { filter:progid:DXImageTransform.Microsoft.gradient(enabled='true',startColorstr='#CCFFFFFF', endColorstr='#CCFFFFFF');background:rgba(255,255,255,0.8); width: 90px; margin-left: 510px; border-radius: 4px; position: fixed; z-index: 999; top: 172px; left: 50%;}
#fixedNavBar h3 { font-size: 12px; line-height: 24px; text-align: center; margin-top: 4px;}
#fixedNavBar ul { width: 80px; margin: 0 auto 5px auto;}
#fixedNavBar li { margin-top: 5px;}
#fixedNavBar li a { font-family: Arial, Helvetica, sans-serif; font-size: 12px; line-height: 20px; background-color: #F5F5F5; color: #999; text-align: center; display: block;  height: 20px; border-radius: 10px;}
#fixedNavBar li a:hover { color: #FFF; text-decoration: none; background-color: #27a9e3;}
</style>

<div id="fixedNavBar">
<h3>页面导航</h3>
  <ul>
    <li><a id="demo1Btn" href="#demo1" class="demoBtn">基本信息</a></li>
    <li><a id="demo2Btn" href="#demo2" class="demoBtn">详情描述</a></li>
    <li><a id="demo3Btn" href="#demo3" class="demoBtn">特殊商品</a></li>
    <li><a id="demo4Btn" href="#demo4" class="demoBtn">物流运费</a></li>
    <li><a id="demo5Btn" href="#demo5" class="demoBtn">发票信息</a></li>
    <li><a id="demo6Btn" href="#demo6" class="demoBtn">其他信息</a></li>
  </ul>
</div>
<?php if ($output['edit_goods_sign']) {?>
<div class="tabmenu">
  <?php include template('layout/submenu');?>
</div>
<?php } else {?>
<ul class="add-goods-step">
  <li><i class="icon icon-list-alt"></i>
    <h6>STEP.1</h6>
    <h2>选择商品分类</h2>
    <i class="arrow icon-angle-right"></i> </li>
  <li class="current"><i class="icon icon-edit"></i>
    <h6>STEP.2</h6>
    <h2>填写商品详情</h2>
    <i class="arrow icon-angle-right"></i> </li>
  <li><i class="icon icon-camera-retro "></i>
    <h6>STEP.3</h6>
    <h2>上传商品图片</h2>
    <i class="arrow icon-angle-right"></i> </li>
  <li><i class="icon icon-ok-circle"></i>
    <h6>STEP.4</h6>
    <h2>商品发布成功</h2>
  </li>
</ul>
<?php }?>
<div class="item-publish">
  <form method="post" id="goods_form" action="<?php if ($output['edit_goods_sign']) { echo urlShop('store_goods_online', 'save_edit_goods2');} else { echo urlShop('store_goods_add', 'car_configsave');}?>">
    <input type="hidden" name="form_submit" value="ok" />
    <input type="hidden" name="commonid" value="<?php echo $output['goods']['goods_commonid'];?>" />
      <input type="hidden" name="common_id" value="<?php echo $output['common_id'];?>" />
    <input type="hidden" name="kuajingDid" value="<?php echo $output['goods_kuajingD']['id'];?>" />
    <input type="hidden" name="type_id" value="<?php echo $output['goods_class']['type_id'];?>" />
    <input type="hidden" name="ref_url" value="<?php echo $_GET['ref_url'] ? $_GET['ref_url'] : getReferer();?>" />
    <div class="ncsc-form-goods">
      <h3 id="demo1">变速箱</h3>
      <dl>
        <dt><i class="required">*</i>简称<?php echo $lang['nc_colon'];?></dt>
        <dd>
          <input name="gearbox_referred" type="text" class="text w400" value="<?php echo $output['gearbox']['gearbox_referred']; ?>" />
          <span></span>

        </dd>
      </dl>
     
      <dl>
        <dt><i class="required">*</i>挡位个数<?php echo $lang['nc_colon'];?></dt>
         <dd>
          <input name="car_gears_num" value="<?php echo $output['gearbox']['car_gears_num']; ?>" type="text" class="text w60" /> <span></span>

        </dd>
      </dl>
	   <dl>
        <dt><i class="required">*</i>变速箱类型<?php echo $lang['nc_colon'];?></dt>
        <dd>
          <input name="gearbox_type" type="text" class="text w400" value="<?php echo $output['gearbox']['gearbox_type']; ?>" />
          <span></span>

        </dd>
      </dl>
	  
	   <h3 id="demo2">底盘转向</h3>
     
      <dl>
       <dt><i class="required">*</i>驱动方式<?php echo $lang['nc_colon'];?></dt>
        <dd>
          <input name="car_dirvemode" type="text" class="text w400" value="<?php echo $output['steer']['car_dirvemode']; ?>" />
          <span></span>

        </dd>
      </dl>
    
	 <dl>
        <dt>前悬架类型<?php echo $lang['nc_colon'];?></dt>
         <dd>
          <input name="front_suspension_type" value="<?php echo $output['steer']['front_suspension_type']; ?>" type="text" class="text w400" /> 
		  <span></span>

        </dd>
      </dl>
  

    <dl>
        <dt>后悬架类型<?php echo $lang['nc_colon'];?></dt>
         <dd>
          <input name="rear_suspension_type" value="<?php echo $output['steer']['rear_suspension_type']; ?>" type="text" class="text w400" />
		  <span></span>

        </dd>
      </dl>
   
     <dl>
        <dt>助力类型<?php echo $lang['nc_colon'];?></dt>
         <dd>
          <input name="car_powertype" value="<?php echo $output['steer']['car_powertype']; ?>" type="text" class="text w400" /> 
		  <span></span>

        </dd>
      </dl>
   
     <dl>
        <dt>车体结构<?php echo $lang['nc_colon'];?></dt>
         <dd>
          <input name="body_structure" value="<?php echo $output['steer']['body_structure']; ?>" type="text" class="text w400" /> 
		  <span></span>

        </dd>
      </dl>
   <h3 id="demo3">车轮制动</h3>
     <dl>
        <dt>前制动器类型<?php echo $lang['nc_colon'];?></dt>
         <dd>
          <input name="front_brake_type" value="<?php echo $output['wheel']['front_brake_type']; ?>" type="text" class="text w400" /> 
		  <span></span>

        </dd>
      </dl>
	  
	   <dl>
        <dt>后制动器类型<?php echo $lang['nc_colon'];?></dt>
         <dd>
          <input name="rear_brake_type" value="<?php echo $output['wheel']['rear_brake_type']; ?>" type="text" class="text w400" />
		  <span></span>

        </dd>
      </dl>
	  
	   <dl>
        <dt>驻车制动类型<?php echo $lang['nc_colon'];?></dt>
         <dd>
          <input name="parking_brake_type" value="<?php echo $output['wheel']['parking_brake_type']; ?>" type="text" class="text w400" />
		  <span></span>

        </dd>
      </dl>
	  
	   <dl>
        <dt>前轮胎规格<?php echo $lang['nc_colon'];?></dt>
         <dd>
          <input name="front_tire_type" value="<?php echo $output['wheel']['front_tire_type']; ?>" type="text" class="text w400" />
		  <span></span>
        </dd>
      </dl>
	  
	   <dl>
        <dt>后轮胎规格<?php echo $lang['nc_colon'];?></dt>
         <dd>
          <input name="rear_tire_type" value="<?php echo $output['wheel']['rear_tire_type']; ?>" type="text" class="text w400" /> 
		  <span></span>
        </dd>
      </dl>
	  
	   <dl>
        <dt>备胎规格<?php echo $lang['nc_colon'];?></dt>
         <dd>
          <input name="spare_tire_type" value="<?php echo $output['wheel']['spare_tire_type']; ?>" type="text" class="text w400" />
		  <span></span>

        </dd>
      </dl>
	 <h3 id="demo4">主/被动安全装备</h3>
	  <dl>
        <dt>主/副驾驶座安全气囊<?php echo $lang['nc_colon'];?></dt>
         <dd>
             <ul class="ncsc-form-radio-list">
                 <li>
                     <label>
                         <input name="seat_srs" value="1" <?php if (!empty($output['safe_items']) && $output['safe_items']['seat_srs'] == 1) { ?>checked="checked" <?php } ?> type="radio" />
                         <?php echo $lang['nc_yes'];?></label>
                 </li>
                 <li>
                     <label>
                         <input name="seat_srs" value="0" <?php if (empty($output['safe_items']) || $output['safe_items']['seat_srs'] == 0) { ?>checked="checked" <?php } ?> type="radio"/>
                         <?php echo $lang['nc_no'];?></label>
                 </li>
             </ul>
        </dd>
      </dl>
	  
	   <dl>
        <dt>前/后排侧气囊<?php echo $lang['nc_colon'];?></dt>
         <dd>
             <ul class="ncsc-form-radio-list">
                 <li>
                     <label>
                         <input name="side_srs" value="1" <?php if (!empty($output['safe_items']) && $output['safe_items']['side_srs'] == 1) { ?>checked="checked" <?php } ?> type="radio" />
                         <?php echo $lang['nc_yes'];?></label>
                 </li>
                 <li>
                     <label>
                         <input name="side_srs" value="0" <?php if (empty($output['safe_items']) || $output['safe_items']['side_srs'] == 0) { ?>checked="checked" <?php } ?> type="radio"/>
                         <?php echo $lang['nc_no'];?></label>
                 </li>
             </ul>
        </dd>
      </dl>
	  
	   <dl>
        <dt>前/后排头部气囊<?php echo $lang['nc_colon'];?></dt>
         <dd>
             <ul class="ncsc-form-radio-list">
                 <li>
                     <label>
                         <input name="head_srs" value="1" <?php if (!empty($output['safe_items']) && $output['safe_items']['head_srs'] == 1) { ?>checked="checked" <?php } ?> type="radio" />
                         <?php echo $lang['nc_yes'];?></label>
                 </li>
                 <li>
                     <label>
                         <input name="head_srs" value="0" <?php if (empty($output['safe_items']) || $output['safe_items']['head_srs'] == 0) { ?>checked="checked" <?php } ?> type="radio"/>
                         <?php echo $lang['nc_no'];?></label>
                 </li>
             </ul>
        </dd>
      </dl>
	  
	   <dl>
        <dt>膝部气囊<?php echo $lang['nc_colon'];?></dt>
         <dd>
             <ul class="ncsc-form-radio-list">
                 <li>
                     <label>
                         <input name="knee_bolster" value="1" <?php if (!empty($output['safe_items']) && $output['safe_items']['knee_bolster'] == 1) { ?>checked="checked" <?php } ?> type="radio" />
                         <?php echo $lang['nc_yes'];?></label>
                 </li>
                 <li>
                     <label>
                         <input name="knee_bolster" value="0" <?php if (empty($output['safe_items']) || $output['safe_items']['knee_bolster'] == 0) { ?>checked="checked" <?php } ?> type="radio"/>
                         <?php echo $lang['nc_no'];?></label>
                 </li>
             </ul>
        </dd>
      </dl>
	  
	  <dl>
        <dt>胎压监测装置<?php echo $lang['nc_colon'];?></dt>
         <dd>
             <ul class="ncsc-form-radio-list">
                 <li>
                     <label>
                         <input name="tpms" value="1" <?php if (!empty($output['safe_items']) && $output['safe_items']['tpms'] == 1) { ?>checked="checked" <?php } ?> type="radio" />
                         <?php echo $lang['nc_yes'];?></label>
                 </li>
                 <li>
                     <label>
                         <input name="tpms" value="0" <?php if (empty($output['safe_items']) || $output['safe_items']['tpms'] == 0) { ?>checked="checked" <?php } ?> type="radio"/>
                         <?php echo $lang['nc_no'];?></label>
                 </li>
             </ul>
        </dd>
      </dl>
	  
	  <dl>
        <dt>零胎压继续行驶<?php echo $lang['nc_colon'];?></dt>
         <dd>
             <ul class="ncsc-form-radio-list">
                 <li>
                     <label>
                         <input name="zero_psi" value="1" <?php if (!empty($output['safe_items']) && $output['safe_items']['zero_psi'] == 1) { ?>checked="checked" <?php } ?> type="radio" />
                         <?php echo $lang['nc_yes'];?></label>
                 </li>
                 <li>
                     <label>
                         <input name="zero_psi" value="0" <?php if (empty($output['safe_items']) || $output['safe_items']['zero_psi'] == 0) { ?>checked="checked" <?php } ?> type="radio"/>
                         <?php echo $lang['nc_no'];?></label>
                 </li>
             </ul>
        </dd>
      </dl>
	  
	    <dl>
        <dt>安全带未系提示<?php echo $lang['nc_colon'];?></dt>
         <dd>
             <ul class="ncsc-form-radio-list">
                 <li>
                     <label>
                         <input name="belt_notice" value="1" <?php if (!empty($output['safe_items']) && $output['safe_items']['belt_notice'] == 1) { ?>checked="checked" <?php } ?> type="radio" />
                         <?php echo $lang['nc_yes'];?></label>
                 </li>
                 <li>
                     <label>
                         <input name="belt_notice" value="0" <?php if (empty($output['safe_items']) || $output['safe_items']['belt_notice'] == 0) { ?>checked="checked" <?php } ?> type="radio"/>
                         <?php echo $lang['nc_no'];?></label>
                 </li>
             </ul>
        </dd>
      </dl>
	  
	   <dl>
        <dt>ISOFIX儿童座椅接口<?php echo $lang['nc_colon'];?></dt>
         <dd>
             <ul class="ncsc-form-radio-list">
                 <li>
                     <label>
                         <input name="isofix" value="1" <?php if (!empty($output['safe_items']) && $output['safe_items']['isofix'] == 1) { ?>checked="checked" <?php } ?> type="radio" />
                         <?php echo $lang['nc_yes'];?></label>
                 </li>
                 <li>
                     <label>
                         <input name="isofix" value="0" <?php if (empty($output['safe_items']) || $output['safe_items']['isofix'] == 0) { ?>checked="checked" <?php } ?> type="radio"/>
                         <?php echo $lang['nc_no'];?></label>
                 </li>
             </ul>
        </dd>
      </dl>
	  
	  
	     <dl>
        <dt>发动机电子防盗<?php echo $lang['nc_colon'];?></dt>
         <dd>
             <ul class="ncsc-form-radio-list">
                 <li>
                     <label>
                         <input name="engine_safe" value="1" <?php if (!empty($output['safe_items']) && $output['safe_items']['engine_safe'] == 1) { ?>checked="checked" <?php } ?> type="radio" />
                         <?php echo $lang['nc_yes'];?></label>
                 </li>
                 <li>
                     <label>
                         <input name="engine_safe" value="0" <?php if (empty($output['safe_items']) || $output['safe_items']['engine_safe'] == 0) { ?>checked="checked" <?php } ?> type="radio"/>
                         <?php echo $lang['nc_no'];?></label>
                 </li>
             </ul>
        </dd>
      </dl>
	  
	  <dl>
        <dt>车内中控锁<?php echo $lang['nc_colon'];?></dt>
         <dd>
             <ul class="ncsc-form-radio-list">
                 <li>
                     <label>
                         <input name="central_lock" value="1" <?php if (!empty($output['safe_items']) && $output['safe_items']['central_lock'] == 1) { ?>checked="checked" <?php } ?> type="radio" />
                         <?php echo $lang['nc_yes'];?></label>
                 </li>
                 <li>
                     <label>
                         <input name="central_lock" value="0" <?php if (empty($output['safe_items']) || $output['safe_items']['central_lock'] == 0) { ?>checked="checked" <?php } ?> type="radio"/>
                         <?php echo $lang['nc_no'];?></label>
                 </li>
             </ul>
        </dd>
      </dl>
	  
	  <dl>
        <dt>遥控钥匙<?php echo $lang['nc_colon'];?></dt>
         <dd>
             <ul class="ncsc-form-radio-list">
                 <li>
                     <label>
                         <input name="rke" value="1" <?php if (!empty($output['safe_items']) && $output['safe_items']['rke'] == 1) { ?>checked="checked" <?php } ?> type="radio" />
                         <?php echo $lang['nc_yes'];?></label>
                 </li>
                 <li>
                     <label>
                         <input name="rke" value="0" <?php if (empty($output['safe_items']) || $output['safe_items']['rke'] == 0) { ?>checked="checked" <?php } ?> type="radio"/>
                         <?php echo $lang['nc_no'];?></label>
                 </li>
             </ul>
        </dd>
      </dl>
	  
	    <dl>
        <dt>无钥匙启动系统<?php echo $lang['nc_colon'];?></dt>
         <dd>
             <ul class="ncsc-form-radio-list">
                 <li>
                     <label>
                         <input name="peps" value="1" <?php if (!empty($output['safe_items']) && $output['safe_items']['peps'] == 1) { ?>checked="checked" <?php } ?> type="radio" />
                         <?php echo $lang['nc_yes'];?></label>
                 </li>
                 <li>
                     <label>
                         <input name="peps" value="0" <?php if (empty($output['safe_items']) || $output['safe_items']['peps'] == 0) { ?>checked="checked" <?php } ?> type="radio"/>
                         <?php echo $lang['nc_no'];?></label>
                 </li>
             </ul>
        </dd>
      </dl>
	  
	   <dl>
        <dt>无钥匙进入系统<?php echo $lang['nc_colon'];?></dt>
         <dd>
             <ul class="ncsc-form-radio-list">
                 <li>
                     <label>
                         <input name="pke" value="1" <?php if (!empty($output['safe_items']) && $output['safe_items']['pke'] == 1) { ?>checked="checked" <?php } ?> type="radio" />
                         <?php echo $lang['nc_yes'];?></label>
                 </li>
                 <li>
                     <label>
                         <input name="pke" value="0" <?php if (empty($output['safe_items']) || $output['safe_items']['pke'] == 0) { ?>checked="checked" <?php } ?> type="radio"/>
                         <?php echo $lang['nc_no'];?></label>
                 </li>
             </ul>
        </dd>
      </dl>
	  
	   <h3 id="demo5">座椅配置</h3>
	  <dl>
        <dt><i class="required">*</i>座椅材质<?php echo $lang['nc_colon'];?></dt>
         <dd>
          <input name="seat_mat" value="<?php echo $output['seat_config']['seat_mat']; ?>" type="text" class="text w400" /> 
		  <span></span>

        </dd>
      </dl>
	  
	   <dl>
        <dt>运动风格座椅<?php echo $lang['nc_colon'];?></dt>
         <dd>
             <ul class="ncsc-form-radio-list">
                 <li>
                     <label>
                         <input name="mov_seat" value="1" <?php if (!empty($output['seat_config']) && $output['seat_config']['mov_seat'] == 1) { ?>checked="checked" <?php } ?> type="radio" />
                         <?php echo $lang['nc_yes'];?></label>
                 </li>
                 <li>
                     <label>
                         <input name="mov_seat" value="0" <?php if (empty($output['seat_config']) || $output['seat_config']['mov_seat'] == 0) { ?>checked="checked" <?php } ?> type="radio"/>
                         <?php echo $lang['nc_no'];?></label>
                 </li>
             </ul>
        </dd>
      </dl>
	  
	   <dl>
        <dt>座椅高度调节<?php echo $lang['nc_colon'];?></dt>
         <dd>
             <ul class="ncsc-form-radio-list">
                 <li>
                     <label>
                         <input name="height_set" value="1" <?php if (!empty($output['seat_config']) && $output['seat_config']['height_set'] == 1) { ?>checked="checked" <?php } ?> type="radio" />
                         <?php echo $lang['nc_yes'];?></label>
                 </li>
                 <li>
                     <label>
                         <input name="height_set" value="0" <?php if (empty($output['seat_config']) || $output['seat_config']['height_set'] == 0) { ?>checked="checked" <?php } ?> type="radio"/>
                         <?php echo $lang['nc_no'];?></label>
                 </li>
             </ul>
        </dd>
      </dl>
	  
	   <dl>
        <dt>要不支撑调节<?php echo $lang['nc_colon'];?></dt>
         <dd>
             <ul class="ncsc-form-radio-list">
                 <li>
                     <label>
                         <input name="sup_set" value="1" <?php if (!empty($output['seat_config']) && $output['seat_config']['sup_set'] == 1) { ?>checked="checked" <?php } ?> type="radio" />
                         <?php echo $lang['nc_yes'];?></label>
                 </li>
                 <li>
                     <label>
                         <input name="sup_set" value="0" <?php if (empty($output['seat_config']) || $output['seat_config']['sup_set'] == 0) { ?>checked="checked" <?php } ?> type="radio"/>
                         <?php echo $lang['nc_no'];?></label>
                 </li>
             </ul>
        </dd>
      </dl>
	  
	  <dl>
        <dt>肩部支撑调节<?php echo $lang['nc_colon'];?></dt>
         <dd>
             <ul class="ncsc-form-radio-list">
                 <li>
                     <label>
                         <input name="bear_sup_set" value="1" <?php if (!empty($output['seat_config']) && $output['seat_config']['bear_sup_set'] == 1) { ?>checked="checked" <?php } ?> type="radio" />
                         <?php echo $lang['nc_yes'];?></label>
                 </li>
                 <li>
                     <label>
                         <input name="bear_sup_set" value="0" <?php if (empty($output['seat_config']) || $output['seat_config']['bear_sup_set'] == 0) { ?>checked="checked" <?php } ?> type="radio"/>
                         <?php echo $lang['nc_no'];?></label>
                 </li>
             </ul>
        </dd>
      </dl>
	  
	  <dl>
        <dt>主/副驾驶座电动调节<?php echo $lang['nc_colon'];?></dt>
         <dd>
             <ul class="ncsc-form-radio-list">
                 <li>
                     <label>
                         <input name="ele_set" value="1" <?php if (!empty($output['seat_config']) && $output['seat_config']['ele_set'] == 1) { ?>checked="checked" <?php } ?> type="radio" />
                         <?php echo $lang['nc_yes'];?></label>
                 </li>
                 <li>
                     <label>
                         <input name="ele_set" value="0" <?php if (empty($output['seat_config']) || $output['seat_config']['ele_set'] == 0) { ?>checked="checked" <?php } ?> type="radio"/>
                         <?php echo $lang['nc_no'];?></label>
                 </li>
             </ul>
        </dd>
      </dl>
	  
	    <dl>
        <dt>第二排靠背角度调节<?php echo $lang['nc_colon'];?></dt>
         <dd>
             <ul class="ncsc-form-radio-list">
                 <li>
                     <label>
                         <input name="angle_set" value="1" <?php if (!empty($output['seat_config']) && $output['seat_config']['angle_set'] == 1) { ?>checked="checked" <?php } ?> type="radio" />
                         <?php echo $lang['nc_yes'];?></label>
                 </li>
                 <li>
                     <label>
                         <input name="angle_set" value="0" <?php if (empty($output['seat_config']) || $output['seat_config']['angle_set'] == 0) { ?>checked="checked" <?php } ?> type="radio"/>
                         <?php echo $lang['nc_no'];?></label>
                 </li>
             </ul>
        </dd>
      </dl>
	  
	   <dl>
        <dt>第二排座椅移动<?php echo $lang['nc_colon'];?></dt>
         <dd>
             <ul class="ncsc-form-radio-list">
                 <li>
                     <label>
                         <input name="seat_mov" value="1" <?php if (!empty($output['seat_config']) && $output['seat_config']['seat_mov'] == 1) { ?>checked="checked" <?php } ?> type="radio" />
                         <?php echo $lang['nc_yes'];?></label>
                 </li>
                 <li>
                     <label>
                         <input name="seat_mov" value="0" <?php if (empty($output['seat_config']) || $output['seat_config']['seat_mov'] == 0) { ?>checked="checked" <?php } ?> type="radio"/>
                         <?php echo $lang['nc_no'];?></label>
                 </li>
             </ul>
        </dd>
      </dl>
	  
	  
	  	  <dl>
        <dt>后排座椅电动调节<?php echo $lang['nc_colon'];?></dt>
         <dd>
             <ul class="ncsc-form-radio-list">
                 <li>
                     <label>
                         <input name="seat_ele_set" value="1" <?php if (!empty($output['seat_config']) && $output['seat_config']['seat_ele_set'] == 1) { ?>checked="checked" <?php } ?> type="radio" />
                         <?php echo $lang['nc_yes'];?></label>
                 </li>
                 <li>
                     <label>
                         <input name="seat_ele_set" value="0" <?php if (empty($output['seat_config']) || $output['seat_config']['seat_ele_set'] == 0) { ?>checked="checked" <?php } ?> type="radio"/>
                         <?php echo $lang['nc_no'];?></label>
                 </li>
             </ul>
        </dd>
      </dl>
	  
	   <dl>
        <dt>电动座椅记忆<?php echo $lang['nc_colon'];?></dt>
         <dd>
             <ul class="ncsc-form-radio-list">
                 <li>
                     <label>
                         <input name="seat_memory" value="1" <?php if (!empty($output['seat_config']) && $output['seat_config']['seat_memory'] == 1) { ?>checked="checked" <?php } ?> type="radio" />
                         <?php echo $lang['nc_yes'];?></label>
                 </li>
                 <li>
                     <label>
                         <input name="seat_memory" value="0" <?php if (empty($output['seat_config']) || $output['seat_config']['seat_memory'] == 0) { ?>checked="checked" <?php } ?> type="radio"/>
                         <?php echo $lang['nc_no'];?></label>
                 </li>
             </ul>
        </dd>
      </dl>
	  
	   <dl>
        <dt>前/后排座椅加热<?php echo $lang['nc_colon'];?></dt>
         <dd>
             <ul class="ncsc-form-radio-list">
                 <li>
                     <label>
                         <input name="seat_heat" value="1" <?php if (!empty($output['seat_config']) && $output['seat_config']['seat_heat'] == 1) { ?>checked="checked" <?php } ?> type="radio" />
                         <?php echo $lang['nc_yes'];?></label>
                 </li>
                 <li>
                     <label>
                         <input name="seat_heat" value="0" <?php if (empty($output['seat_config']) || $output['seat_config']['seat_heat'] == 0) { ?>checked="checked" <?php } ?> type="radio"/>
                         <?php echo $lang['nc_no'];?></label>
                 </li>
             </ul>
        </dd>
      </dl>
	  
	   <dl>
        <dt>前/后排座椅通风<?php echo $lang['nc_colon'];?></dt>
         <dd>
             <ul class="ncsc-form-radio-list">
                 <li>
                     <label>
                         <input name="seat_dra" value="1" <?php if (!empty($output['seat_config']) && $output['seat_config']['seat_dra'] == 1) { ?>checked="checked" <?php } ?> type="radio" />
                         <?php echo $lang['nc_yes'];?></label>
                 </li>
                 <li>
                     <label>
                         <input name="seat_dra" value="0" <?php if (empty($output['seat_config']) || $output['seat_config']['seat_dra'] == 0) { ?>checked="checked" <?php } ?> type="radio"/>
                         <?php echo $lang['nc_no'];?></label>
                 </li>
             </ul>
        </dd>
      </dl>
	  
	  <dl>
        <dt>前/后排座椅按摩<?php echo $lang['nc_colon'];?></dt>
         <dd>
             <ul class="ncsc-form-radio-list">
                 <li>
                     <label>
                         <input name="mas_seat" value="1" <?php if (!empty($output['seat_config']) && $output['seat_config']['mas_seat'] == 1) { ?>checked="checked" <?php } ?> type="radio" />
                         <?php echo $lang['nc_yes'];?></label>
                 </li>
                 <li>
                     <label>
                         <input name="mas_seat" value="0" <?php if (empty($output['seat_config']) || $output['seat_config']['mas_seat'] == 0) { ?>checked="checked" <?php } ?> type="radio"/>
                         <?php echo $lang['nc_no'];?></label>
                 </li>
             </ul>
        </dd>
      </dl>
	  
	  <dl>
        <dt>第三排座椅<?php echo $lang['nc_colon'];?></dt>
         <dd>
             <ul class="ncsc-form-radio-list">
                 <li>
                     <label>
                         <input name="third_seat" value="1" <?php if (!empty($output['seat_config']) && $output['seat_config']['third_seat'] == 1) { ?>checked="checked" <?php } ?> type="radio" />
                         <?php echo $lang['nc_yes'];?></label>
                 </li>
                 <li>
                     <label>
                         <input name="third_seat" value="0" <?php if (empty($output['seat_config']) || $output['seat_config']['third_seat'] == 0) { ?>checked="checked" <?php } ?> type="radio"/>
                         <?php echo $lang['nc_no'];?></label>
                 </li>
             </ul>
        </dd>
      </dl>
	  
	    <dl>
        <dt>后排座椅放倒方式<?php echo $lang['nc_colon'];?></dt>
         <dd>
          <input name="put_way" value="<?php echo $output['seat_config']['put_way']; ?>" type="text" class="text w400" />
		  <span></span>
        </dd>
      </dl>
	  
	   <dl style="display: none">
        <dt><i class="required">*</i>后桥限滑差速器/差速锁<?php echo $lang['nc_colon'];?></dt>
         <dd>
             <ul class="ncsc-form-radio-list">
                 <li>
                     <label>
                         <input name="isofix" value="1" <?php if (!empty($output['goods']) && $output['goods']['isofix'] == 1) { ?>checked="checked" <?php } ?> type="radio" />
                         <?php echo $lang['nc_yes'];?></label>
                 </li>
                 <li>
                     <label>
                         <input name="isofix" value="0" <?php if (empty($output['goods']) || $output['goods']['isofix'] == 0) { ?>checked="checked" <?php } ?> type="radio"/>
                         <?php echo $lang['nc_no'];?></label>
                 </li>
             </ul>
        </dd>
      </dl>
	  
	   <dl>
        <dt>前/后中央扶手<?php echo $lang['nc_colon'];?></dt>
         <dd>
             <ul class="ncsc-form-radio-list">
                 <li>
                     <label>
                         <input name="central_arm" value="1" <?php if (!empty($output['seat_config']) && $output['seat_config']['central_arm'] == 1) { ?>checked="checked" <?php } ?> type="radio" />
                         <?php echo $lang['nc_yes'];?></label>
                 </li>
                 <li>
                     <label>
                         <input name="central_arm" value="0" <?php if (empty($output['seat_config']) || $output['seat_config']['central_arm'] == 0) { ?>checked="checked" <?php } ?> type="radio"/>
                         <?php echo $lang['nc_no'];?></label>
                 </li>
             </ul>
        </dd>
      </dl>
	  
	   <dl>
        <dt>后排杯架<?php echo $lang['nc_colon'];?></dt>
         <dd>
             <ul class="ncsc-form-radio-list">
                 <li>
                     <label>
                         <input name="cup_holder" value="1" <?php if (!empty($output['seat_config']) && $output['seat_config']['cup_holder'] == 1) { ?>checked="checked" <?php } ?> type="radio" />
                         <?php echo $lang['nc_yes'];?></label>
                 </li>
                 <li>
                     <label>
                         <input name="cup_holder" value="0" <?php if (empty($output['seat_config']) || $output['seat_config']['cup_holder'] == 0) { ?>checked="checked" <?php } ?> type="radio"/>
                         <?php echo $lang['nc_no'];?></label>
                 </li>
             </ul>
        </dd>
      </dl>
	  
	  
	    <h3 id="demo6">多媒体配置</h3>
	  <dl>
        <dt>GPS导航系统<?php echo $lang['nc_colon'];?></dt>
         <dd>
             <ul class="ncsc-form-radio-list">
                 <li>
                     <label>
                         <input name="gps" value="1" <?php if (!empty($output['wmm_config']) && $output['wmm_config']['gps'] == 1) { ?>checked="checked" <?php } ?> type="radio" />
                         <?php echo $lang['nc_yes'];?></label>
                 </li>
                 <li>
                     <label>
                         <input name="gps" value="0" <?php if (empty($output['wmm_config']) || $output['wmm_config']['gps'] == 0) { ?>checked="checked" <?php } ?> type="radio"/>
                         <?php echo $lang['nc_no'];?></label>
                 </li>
             </ul>
        </dd>
      </dl>
	  
	   <dl>
        <dt>定位互动服务<?php echo $lang['nc_colon'];?></dt>
         <dd>
             <ul class="ncsc-form-radio-list">
             <li>
                 <label>
                     <input name="int_serv" value="1" <?php if (!empty($output['wmm_config']) && $output['wmm_config']['int_serv'] == 1) { ?>checked="checked" <?php } ?> type="radio" />
                     <?php echo $lang['nc_yes'];?></label>
             </li>
             <li>
                 <label>
                     <input name="int_serv" value="0" <?php if (empty($output['wmm_config']) || $output['wmm_config']['int_serv'] == 0) { ?>checked="checked" <?php } ?> type="radio"/>
                     <?php echo $lang['nc_no'];?></label>
             </li>
                 </ul>
        </dd>
      </dl>
	  
	   <dl>
        <dt>中控台彩色大屏<?php echo $lang['nc_colon'];?></dt>
         <dd>
             <ul class="ncsc-form-radio-list">
             <li>
                 <label>
                     <input name="color_creen" value="1" <?php if (!empty($output['wmm_config']) && $output['wmm_config']['color_creen'] == 1) { ?>checked="checked" <?php } ?> type="radio" />
                     <?php echo $lang['nc_yes'];?></label>
             </li>
             <li>
                 <label>
                     <input name="color_creen" value="0" <?php if (empty($output['wmm_config']) || $output['wmm_config']['color_creen'] == 0) { ?>checked="checked" <?php } ?> type="radio"/>
                     <?php echo $lang['nc_no'];?></label>
             </li>
                 </ul>
        </dd>
      </dl>
	  
	   <dl>
        <dt>蓝牙/车载电话<?php echo $lang['nc_colon'];?></dt>
         <dd>
             <ul class="ncsc-form-radio-list">
             <li>
                 <label>
                     <input name="car_kit" value="1" <?php if (!empty($output['wmm_config']) && $output['wmm_config']['car_kit'] == 1) { ?>checked="checked" <?php } ?> type="radio" />
                     <?php echo $lang['nc_yes'];?></label>
             </li>
             <li>
                 <label>
                     <input name="car_kit" value="0" <?php if (empty($output['wmm_config']) || $output['wmm_config']['car_kit'] == 0) { ?>checked="checked" <?php } ?> type="radio"/>
                     <?php echo $lang['nc_no'];?></label>
             </li>
                 </ul>
        </dd>
      </dl>
	  
	  <dl>
        <dt>车载电视<?php echo $lang['nc_colon'];?></dt>
         <dd>
             <ul class="ncsc-form-radio-list">
             <li>
                 <label>
                     <input name="tv" value="1" <?php if (!empty($output['wmm_config']) && $output['wmm_config']['tv'] == 1) { ?>checked="checked" <?php } ?> type="radio" />
                     <?php echo $lang['nc_yes'];?></label>
             </li>
             <li>
                 <label>
                     <input name="tv" value="0" <?php if (empty($output['wmm_config']) || $output['wmm_config']['tv'] == 0) { ?>checked="checked" <?php } ?> type="radio"/>
                     <?php echo $lang['nc_no'];?></label>
             </li>
                 </ul>
        </dd>
      </dl>
	  
	  <dl>
        <dt>后排液晶屏<?php echo $lang['nc_colon'];?></dt>
         <dd>
             <ul class="ncsc-form-radio-list">
             <li>
                 <label>
                     <input name="lcd" value="1" <?php if (!empty($output['wmm_config']) && $output['wmm_config']['lcd'] == 1) { ?>checked="checked" <?php } ?> type="radio" />
                     <?php echo $lang['nc_yes'];?></label>
             </li>
             <li>
                 <label>
                     <input name="lcd" value="0" <?php if (empty($output['wmm_config']) || $output['wmm_config']['lcd'] == 0) { ?>checked="checked" <?php } ?> type="radio"/>
                     <?php echo $lang['nc_no'];?></label>
             </li>
                 </ul>
        </dd>
      </dl>
	  
	    <dl>
        <dt>220/230v电源<?php echo $lang['nc_colon'];?></dt>
         <dd>
             <ul class="ncsc-form-radio-list">
             <li>
                 <label>
                     <input name="power" value="1" <?php if (!empty($output['wmm_config']) && $output['wmm_config']['power'] == 1) { ?>checked="checked" <?php } ?> type="radio" />
                     <?php echo $lang['nc_yes'];?></label>
             </li>
             <li>
                 <label>
                     <input name="power" value="0" <?php if (empty($output['wmm_config']) || $output['wmm_config']['power'] == 0) { ?>checked="checked" <?php } ?> type="radio"/>
                     <?php echo $lang['nc_no'];?></label>
             </li>
                 </ul>
        </dd>
      </dl>
	  
	   <dl>
        <dt>外接音源接口<?php echo $lang['nc_colon'];?></dt>
         <dd>
          <input name="port" value="<?php echo $output['wmm_config']['port']; ?>" type="text" class="text w400" />
		  <span></span>
        </dd>
      </dl>
	  
	  
	  	  <dl>
        <dt>CD支持MP3/WMA<?php echo $lang['nc_colon'];?></dt>
         <dd>
             <ul class="ncsc-form-radio-list">
             <li>
                 <label>
                     <input name="mp3" value="1" <?php if (!empty($output['wmm_config']) && $output['wmm_config']['mp3'] == 1) { ?>checked="checked" <?php } ?> type="radio" />
                     <?php echo $lang['nc_yes'];?></label>
             </li>
             <li>
                 <label>
                     <input name="mp3" value="0" <?php if (empty($output['wmm_config']) || $output['wmm_config']['mp3'] == 0) { ?>checked="checked" <?php } ?> type="radio"/>
                     <?php echo $lang['nc_no'];?></label>
             </li>
                 </ul>
        </dd>
      </dl>
	  
	   <dl>
        <dt>多媒体系统<?php echo $lang['nc_colon'];?></dt>
         <dd>
             <ul class="ncsc-form-radio-list">
             <li>
                 <label>
                     <input name="mat_sys" value="1" <?php if (!empty($output['wmm_config']) && $output['wmm_config']['mat_sys'] == 1) { ?>checked="checked" <?php } ?> type="radio" />
                     <?php echo $lang['nc_yes'];?></label>
             </li>
             <li>
                 <label>
                     <input name="mat_sys" value="0" <?php if (empty($output['wmm_config']) || $output['wmm_config']['mat_sys'] == 0) { ?>checked="checked" <?php } ?> type="radio"/>
                     <?php echo $lang['nc_no'];?></label>
             </li>
                 </ul>
        </dd>
      </dl>
	  
	   <dl>
        <dt>扬声器品牌<?php echo $lang['nc_colon'];?></dt>
         <dd>
             <input name="spk" value="<?php echo $output['wmm_config']['spk']; ?>" type="text" class="text w400" />
             <span></span>
        </dd>
      </dl>
	  
	   <dl>
        <dt>扬声器数量<?php echo $lang['nc_colon'];?></dt>
         <dd>
          <input name="spk_number" value="<?php echo $output['wmm_config']['spk_number']; ?>" type="text" class="text w400" />
		  <span></span>
        </dd>
      </dl>	  	
	  
    </div>
    <div class="bottom tc hr32">
      <label class="submit-border">
        <input type="submit" class="submit" value="<?php if ($output['edit_goods_sign']) {echo '下一步';} else {?><?php echo $lang['store_goods_add_next'];?>，上传商品图片<?php }?>" />
      </label>
    </div>
  </form>
</div>
<script type="text/javascript">
    var SITEURL = "<?php echo SHOP_SITE_URL; ?>";
    var DEFAULT_GOODS_IMAGE = "<?php echo thumb(array(), 60);?>";
    var SHOP_RESOURCE_SITE_URL = "<?php echo SHOP_RESOURCE_SITE_URL;?>";
    //var RE123 = /^spec[i_\d\d\d][sku]$/gi;

    $(function(){
        //电脑端手机端tab切换
        $(".tabs").tabs();


        $('#goods_form').validate({
            errorPlacement: function(error, element){
                $(element).nextAll('span').append(error);
            },
            <?php if ($output['edit_goods_sign']) {?>
            submitHandler:function(form){
                ajaxpost('goods_form', '', '', 'onerror');
            },
            <?php }?>
            rules : {
                //变速箱
                gearbox_referred : {
                    required    : true
                },
                car_gears_num : {
                    required    : true,
                    digits      : true
                },
                gearbox_type : {
                    required    : true
                },


                //底盘转向
                car_dirvemode : {
                    required    : true
                },
                /*front_suspension_type : {
                    required    : true
                },
                rear_suspension_type : {
                    required    : true
                },
                car_powertype : {
                    required    : true
                },
                body_structure : {
                    required    : true
                },*/

                //车轮制动
               /* front_brake_type : {
                    required    : true
                },
                rear_brake_type : {
                    required    : true
                },
                parking_brake_type : {
                    required    : true
                },
                front_tire_type: {
                    required    : true
                },
                rear_tire_type : {
                    required    : true
                },
                spare_tire_type : {
                    required    : true
                },*/


                //座椅配置
                seat_mat : {
                    required    : true
                },


                //jinp0902 件数

                image_path : {
                    required    : true
                },
                g_vindate : {
                    required    : function() {if ($("#is_gv_1").prop("checked")) {return true;} else {return false;}}
                },
                g_vlimit : {
                    required	: function() {if ($("#is_gv_1").prop("checked")) {return true;} else {return false;}},
                    range		: [1,10]
                },
                g_fccount : {
                    <?php if (!$output['edit_goods_sign']) {?>required	: function() {if ($("#is_fc_1").prop("checked")) {return true;} else {return false;}},<?php }?>
                    range		: [1,100]
                },
                g_fcprefix : {
                    <?php if (!$output['edit_goods_sign']) {?>required	: function() {if ($("#is_fc_1").prop("checked")) {return true;} else {return false;}},<?php }?>
                    checkFCodePrefix : true,
                    rangelength	: [3,5]
                },
                g_saledate : {
                    required	: function () {if ($('#is_appoint_1').prop("checked")) {return true;} else {return false;}}
                },
                g_deliverdate : {
                    required	: function () {if ($('#is_presell_1').prop("checked")) {return true;} else {return false;}}
                }
            },
            messages : {
                //变速箱
                gearbox_referred : {
                    required    : '<i class="icon-exclamation-sign"></i>请填写变速箱简称'
                },
                car_gears_num : {
                    required    : '<i class="icon-exclamation-sign"></i>请填写挡位个数',
                    digits      : '<i class="icon-exclamation-sign"></i>只填写整数'
                },
                gearbox_type : {
                    required    : '<i class="icon-exclamation-sign"></i>请填写变速箱类型'
                },

                //底盘转向
                car_dirvemode : {
                    required    : '<i class="icon-exclamation-sign"></i>请填写驱动方式'
                },
               /* front_suspension_type : {
                    required    : '<i class="icon-exclamation-sign"></i>请填写前悬架类型'
                },
                rear_suspension_type : {
                    required    : '<i class="icon-exclamation-sign"></i>请填写后悬架类型'
                },
                car_powertype : {
                    required    : '<i class="icon-exclamation-sign"></i>请填写助力类型'
                },
                body_structure : {
                    required    : '<i class="icon-exclamation-sign"></i>请填写车体结构'
                },*/

                //车轮制动
                /*front_brake_type : {
                    required    : '<i class="icon-exclamation-sign"></i>请填写前制动器类型'
                },
                rear_brake_type : {
                    required    : '<i class="icon-exclamation-sign"></i>请填写后制动器类型'
                },
                parking_brake_type : {
                    required    : '<i class="icon-exclamation-sign"></i>请填写驻车制动类型'
                },
                front_tire_type: {
                    required    : '<i class="icon-exclamation-sign"></i>请填写前轮胎规格'
                },
                rear_tire_type : {
                    required    : '<i class="icon-exclamation-sign"></i>请填写后轮胎规格'
                },
                spare_tire_type : {
                    required    : '<i class="icon-exclamation-sign"></i>请填写备胎规格'
                },*/

                //座椅配置
                seat_mat : {
                    required    : '<i class="icon-exclamation-sign"></i>请填写座椅配置'
                },

                //jinp0902 件数

                g_packages : {
                    required    : '<i class="icon-exclamation-sign"></i>请填写商品件数',
                    number      : '<i class="icon-exclamation-sign"></i>请填写正确的件数',
                    min         : '<i class="icon-exclamation-sign"></i>请填写1~9999999之间的数字',
                    max         : '<i class="icon-exclamation-sign"></i>请填写1~9999999之间的数字'
                },

                g_storage : {
                    required    : '<i class="icon-exclamation-sign"></i><?php echo $lang['store_goods_index_goods_stock_null'];?>',
                    digits      : '<i class="icon-exclamation-sign"></i><?php echo $lang['store_goods_index_goods_stock_error'];?>',
                    min         : '<i class="icon-exclamation-sign"></i><?php echo $lang['store_goods_index_goods_stock_checking'];?>',
                    max         : '<i class="icon-exclamation-sign"></i><?php echo $lang['store_goods_index_goods_stock_checking'];?>'
                },
                image_path : {
                    required    : '<i class="icon-exclamation-sign"></i>请设置商品主图'
                },
                g_vindate : {
                    required    : '<i class="icon-exclamation-sign"></i>请选择有效期'
                },
                g_vlimit : {
                    required	: '<i class="icon-exclamation-sign"></i>请填写1~10之间的数字',
                    range		: '<i class="icon-exclamation-sign"></i>请填写1~10之间的数字'
                },
                g_fccount : {
                    required	: '<i class="icon-exclamation-sign"></i>请填写1~100之间的数字',
                    range		: '<i class="icon-exclamation-sign"></i>请填写1~100之间的数字'
                },
                g_fcprefix : {
                    required	: '<i class="icon-exclamation-sign"></i>请填写3~5位的英文字母',
                    rangelength	: '<i class="icon-exclamation-sign"></i>请填写3~5位的英文字母'
                },
                g_saledate : {
                    required	: '<i class="icon-exclamation-sign"></i>请选择有效期'
                },
                g_deliverdate : {
                    required	: '<i class="icon-exclamation-sign"></i>请选择有效期'
                }
            }
        });


        $("input[id*='speci']").each(function() {
            $(this).rules('add', {
                required: true,
                minlength: 50,
                messages: {
                    required: "Required input",
                    minlength: jQuery.format("At least {0} characters are necessary")
                }
            });
        });


        <?php if (isset($output['goods'])) {?>
        setTimeout("setArea(<?php echo $output['goods']['areaid_1'];?>, <?php echo $output['goods']['areaid_2'];?>)", 1000);
        <?php }?>
    });
    // 按规格存储规格值数据
    var spec_group_checked = [<?php for ($i=0; $i<$output['sign_i']; $i++){if($i+1 == $output['sign_i']){echo "''";}else{echo "'',";}}?>];
    var str = '';
    var V = new Array();

    <?php for ($i=0; $i<$output['sign_i']; $i++){?>
    var spec_group_checked_<?php echo $i;?> = new Array();
    <?php }?>

    $(function(){
        $('dl[nctype="spec_group_dl"]').on('click', 'span[nctype="input_checkbox"] > input[type="checkbox"]',function(){
            into_array();
            goods_stock_set();
        });

        // 提交后不没有填写的价格或库存的库存配置设为默认价格和0
        // 库存配置隐藏式 里面的input加上disable属性
        $('input[type="submit"]').click(function(){
            $('input[data_type="price"]').each(function(){
                if($(this).val() == ''){
                    $(this).val($('input[name="g_price"]').val());
                }
            });
            $('input[data_type="stock"]').each(function(){
                if($(this).val() == ''){
                    $(this).val('0');
                }
            });
            $('input[data_type="alarm"]').each(function(){
                if($(this).val() == ''){
                    $(this).val('0');
                }
            });
            if($('dl[nc_type="spec_dl"]').css('display') == 'none'){
                $('dl[nc_type="spec_dl"]').find('input').attr('disabled','disabled');
            }
        });

    });

    // 将选中的规格放入数组
    function into_array(){
        <?php for ($i=0; $i<$output['sign_i']; $i++){?>

        spec_group_checked_<?php echo $i;?> = new Array();
        $('dl[nc_type="spec_group_dl_<?php echo $i;?>"]').find('input[type="checkbox"]:checked').each(function(){
            i = $(this).attr('nc_type');
            v = $(this).val();
            c = null;
            if ($(this).parents('dl:first').attr('spec_img') == 't') {
                c = 1;
            }
            spec_group_checked_<?php echo $i;?>[spec_group_checked_<?php echo $i;?>.length] = [v,i,c];
        });

        spec_group_checked[<?php echo $i;?>] = spec_group_checked_<?php echo $i;?>;

        <?php }?>
    }

    // 生成库存配置
    function goods_stock_set(){
        //  店铺价格 商品库存改为只读, g_app_price需要吗？
        $('input[name="g_price"]').attr('readonly','readonly').css('background','#E7E7E7 none');
        $('input[name="g_app_price"]').attr('readonly','readonly').css('background','#E7E7E7 none');
        $('input[name="g_storage"]').attr('readonly','readonly').css('background','#E7E7E7 none');

        $('dl[nc_type="spec_dl"]').show();
        str = '<tr>';
        <?php recursionSpec(0,$output['sign_i']);?>
        if(str == '<tr>'){
            //  店铺价格 商品库存取消只读
            $('input[name="g_price"]').removeAttr('readonly').css('background','');
            $('input[name="g_app_price"]').removeAttr('readonly').css('background','');
            $('input[name="g_storage"]').removeAttr('readonly').css('background','');
            $('dl[nc_type="spec_dl"]').hide();
        }else{
            $('tbody[nc_type="spec_table"]').empty().html(str)
                .find('input[nc_type]').each(function(){
                s = $(this).attr('nc_type');
                try{$(this).val(V[s]);}catch(ex){$(this).val('');};
                if ($(this).attr('data_type') == 'marketprice' && $(this).val() == '') {
                    $(this).val($('input[name="g_marketprice"]').val());
                }
                if ($(this).attr('data_type') == 'price' && $(this).val() == ''){
                    $(this).val($('input[name="g_price"]').val());
                }
                if ($(this).attr('data_type') == 'app_price' && $(this).val() == ''){
                    $(this).val($('input[name="g_app_price"]').val());
                }
                if ($(this).attr('data_type') == 'stock' && $(this).val() == ''){
                    $(this).val('0');
                }
                if ($(this).attr('data_type') == 'alarm' && $(this).val() == ''){
                    $(this).val('0');
                }
            }).end()
                .find('input[data_type="stock"]').change(function(){
                computeStock();    // 库存计算
            }).end()
                .find('input[data_type="price"]').change(function(){
                computePrice();     // 价格计算
            }).end()
                .find('input[nc_type]').change(function(){
                s = $(this).attr('nc_type');
                V[s] = $(this).val();
            });
        }
    }

    <?php
    /**
     *
     *
     *  生成需要的js循环。递归调用	PHP
     *
     *  形式参考 （ 2个规格）
     *  $('input[type="checkbox"]').click(function(){
     *      str = '';
     *      for (var i=0; i<spec_group_checked[0].length; i++ ){
     *      td_1 = spec_group_checked[0][i];
     *          for (var j=0; j<spec_group_checked[1].length; j++){
     *              td_2 = spec_group_checked[1][j];
     *              str += '<tr><td>'+td_1[0]+'</td><td>'+td_2[0]+'</td><td><input type="text" /></td><td><input type="text" /></td><td><input type="text" /></td>';
     *          }
     *      }
     *      $('table[class="spec_table"] > tbody').empty().html(str);
     *  });
     */
    function recursionSpec($len,$sign) {
        if($len < $sign){
            echo "for (var i_".$len."=0; i_".$len."<spec_group_checked[".$len."].length; i_".$len."++){td_".(intval($len)+1)." = spec_group_checked[".$len."][i_".$len."];\n";
            $len++;
            recursionSpec($len,$sign);
        }else{
            echo "var tmp_spec_td = new Array();\n";
            for($i=0; $i< $len; $i++){
                echo "tmp_spec_td[".($i)."] = td_".($i+1)."[1];\n";
            }
            echo "tmp_spec_td.sort(function(a,b){return a-b});\n";
            echo "var spec_bunch = 'i_';\n";
            for($i=0; $i< $len; $i++){
                echo "spec_bunch += tmp_spec_td[".($i)."];\n";
            }
            echo "str += '<input type=\"hidden\" name=\"spec['+spec_bunch+'][goods_id]\" nc_type=\"'+spec_bunch+'|id\" value=\"\" />';";
            for($i=0; $i< $len; $i++){
                echo "if (td_".($i+1)."[2] != null) { str += '<input type=\"hidden\" name=\"spec['+spec_bunch+'][color]\" value=\"'+td_".($i+1)."[1]+'\" />';}";
                echo "str +='<td><input type=\"hidden\" name=\"spec['+spec_bunch+'][sp_value]['+td_".($i+1)."[1]+']\" value=\"'+td_".($i+1)."[0]+'\" />'+td_".($i+1)."[0]+'</td>';\n";
            }
            echo "str +='<td><input class=\"text price\" type=\"text\" name=\"spec['+spec_bunch+'][marketprice]\" data_type=\"marketprice\" nc_type=\"'+spec_bunch+'|marketprice\" value=\"\" /><em class=\"add-on\"><i class=\"icon-renminbi\"></i></em></td><td><input class=\"text price\" type=\"text\" name=\"spec['+spec_bunch+'][price]\" data_type=\"price\" nc_type=\"'+spec_bunch+'|price\" value=\"\" /><em class=\"add-on\"><i class=\"icon-renminbi\"></i></em></td><td><input class=\"text price\" type=\"text\" name=\"spec['+spec_bunch+'][app_price]\" data_type=\"app_price\" nc_type=\"'+spec_bunch+'|app_price\" value=\"\" /><em class=\"add-on\"><i class=\"icon-renminbi\"></i></em></td><td><input class=\"text price\" type=\"text\" name=\"spec['+spec_bunch+'][weight]\" data_type=\"weight\" nc_type=\"'+spec_bunch+'|weight\" value=\"\" /><em class=\"add-on\"><i class=\"icon-renminbi\"></i></em></td><td><input class=\"text price\" type=\"text\" name=\"spec['+spec_bunch+'][all_weight]\" data_type=\"all_weight\" nc_type=\"'+spec_bunch+'|all_weight\" value=\"\" /><em class=\"add-on\"><i class=\"icon-renminbi\"></i></em></td><td><input class=\"text price\" type=\"text\" name=\"spec['+spec_bunch+'][packages]\" data_type=\"packages\" nc_type=\"'+spec_bunch+'|packages\" value=\"\" /><em class=\"add-on\"><i class=\"icon-renminbi\"></i></em></td><td><input class=\"text stock\" type=\"text\" name=\"spec['+spec_bunch+'][stock]\" data_type=\"stock\" nc_type=\"'+spec_bunch+'|stock\" value=\"\" /></td><td><input class=\"text stock\" type=\"text\" name=\"spec['+spec_bunch+'][alarm]\" data_type=\"alarm\" nc_type=\"'+spec_bunch+'|alarm\" value=\"\" /></td><td><input class=\"text sku\" type=\"text\" name=\"spec['+spec_bunch+'][sku]\" nc_type=\"'+spec_bunch+'|sku\" value=\"\" /></td></tr>';\n";
            for($i=0; $i< $len; $i++){
                echo "}\n";
            }
        }
    }

    ?>


    <?php if (!empty($output['goods']) && $_GET['class_id'] <= 0 && !empty($output['sp_value']) && !empty($output['spec_checked']) && !empty($output['spec_list'])){?>
    //  编辑商品时处理JS
    $(function(){
        var E_SP = new Array();
        var E_SPV = new Array();
        <?php
        $string = '';
        foreach ($output['spec_checked'] as $v) {
            $string .= "E_SP[".$v['id']."] = '".$v['name']."';";
        }
        echo $string;
        echo "\n";
        $string = '';
        foreach ($output['sp_value'] as $k=>$v) {
            $string .= "E_SPV['{$k}'] = '{$v}';";
        }
        echo $string;
        ?>
        V = E_SPV;
        $('dl[nc_type="spec_dl"]').show();
        $('dl[nctype="spec_group_dl"]').find('input[type="checkbox"]').each(function(){
            //  店铺价格 商品库存改为只读
            $('input[name="g_price"]').attr('readonly','readonly').css('background','#E7E7E7 none');
            $('input[name="g_app_price"]').attr('readonly','readonly').css('background','#E7E7E7 none');
            $('input[name="g_storage"]').attr('readonly','readonly').css('background','#E7E7E7 none');
            s = $(this).attr('nc_type');
            if (!(typeof(E_SP[s]) == 'undefined')){
                $(this).attr('checked',true);
                v = $(this).parents('li').find('span[nctype="pv_name"]');
                if(E_SP[s] != ''){
                    $(this).val(E_SP[s]);
                    v.html('<input type="text" maxlength="20" value="'+E_SP[s]+'" />');
                }else{
                    v.html('<input type="text" maxlength="20" value="'+v.html()+'" />');
                }
                change_img_name($(this));			// 修改相关的颜色名称
            }
        });

        into_array();	// 将选中的规格放入数组
        str = '<tr>';
        <?php recursionSpec(0,$output['sign_i']);?>
        if(str == '<tr>'){
            $('dl[nc_type="spec_dl"]').hide();
            $('input[name="g_price"]').removeAttr('readonly').css('background','');
            $('input[name="g_app_price"]').removeAttr('readonly').css('background','');
            $('input[name="g_storage"]').removeAttr('readonly').css('background','');
        }else{
            $('tbody[nc_type="spec_table"]').empty().html(str)
                .find('input[nc_type]').each(function(){
                s = $(this).attr('nc_type');
                try{$(this).val(E_SPV[s]);}catch(ex){$(this).val('');};
            }).end()
                .find('input[data_type="stock"]').change(function(){
                computeStock();    // 库存计算
            }).end()
                .find('input[data_type="price"]').change(function(){
                computePrice();     // 价格计算
            }).end()
                .find('input[type="text"]').change(function(){
                s = $(this).attr('nc_type');
                V[s] = $(this).val();
            });
        }
    });
    <?php }?>
</script>
<script src="<?php echo SHOP_RESOURCE_SITE_URL;?>/js/scrolld.js"></script>
<script type="text/javascript">$("[id*='Btn']").stop(true).on('click', function (e) {e.preventDefault();$(this).scrolld();})</script>
