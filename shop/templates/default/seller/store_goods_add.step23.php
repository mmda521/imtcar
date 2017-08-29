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
  <form method="post" id="goods_form" action="<?php if ($output['edit_goods_sign']) { echo urlShop('store_goods_online', 'save_edit_goods3');} else { echo urlShop('store_goods_add', 'car_configsave1');}?>">
    <input type="hidden" name="form_submit" value="ok" />
    <input type="hidden" name="commonid" value="<?php echo $output['goods']['goods_commonid'];?>" />
      <input type="hidden" name="common_id" value="<?php echo $output['common_id'];?>" />
    <input type="hidden" name="kuajingDid" value="<?php echo $output['goods_kuajingD']['id'];?>" />
    <input type="hidden" name="type_id" value="<?php echo $output['goods_class']['type_id'];?>" />
    <input type="hidden" name="ref_url" value="<?php echo $_GET['ref_url'] ? $_GET['ref_url'] : getReferer();?>" />
    <div class="ncsc-form-goods">
      <h3 id="demo1">内部配置</h3>
      <dl>
        <dt>真皮方向盘<?php echo $lang['nc_colon'];?></dt>
        <dd>
            <ul class="ncsc-form-radio-list">
                <li>
                    <label>
                        <input name="lea_st_wheel" value="1" <?php if (!empty($output['inner_config']) && $output['inner_config']['lea_st_wheel'] == 1) { ?>checked="checked" <?php } ?> type="radio" />
                        <?php echo $lang['nc_yes'];?></label>
                </li>
                <li>
                    <label>
                        <input name="lea_st_wheel" value="0" <?php if (empty($output['inner_config']) || $output['inner_config']['lea_st_wheel'] == 0) { ?>checked="checked" <?php } ?> type="radio"/>
                        <?php echo $lang['nc_no'];?></label>
                </li>
            </ul>
        </dd>
      </dl>
     
      <dl>
        <dt><i class="required">*</i>方向盘调节<?php echo $lang['nc_colon'];?></dt>
         <dd>
             <ul class="ncsc-form-radio-list">
                 <li>
                     <label>
                         <input name="wel_adjust" value="1" <?php if (!empty($output['inner_config']) && $output['inner_config']['wel_adjust'] == 1) { ?>checked="checked" <?php } ?> type="radio" />
                         <?php echo $lang['nc_yes'];?></label>
                 </li>
                 <li>
                     <label>
                         <input name="wel_adjust" value="0" <?php if (empty($output['inner_config']) || $output['inner_config']['wel_adjust'] == 0) { ?>checked="checked" <?php } ?> type="radio"/>
                         <?php echo $lang['nc_no'];?></label>
                 </li>
             </ul>
                
        </dd>
      </dl>
	  
      <dl>
        <dt>方向盘电动调节<?php echo $lang['nc_colon'];?></dt>
        <dd>
            <ul class="ncsc-form-radio-list">
                <li>
                    <label>
                        <input name="wel_ele_adjust" value="1" <?php if (!empty($output['inner_config']) && $output['inner_config']['wel_ele_adjust'] == 1) { ?>checked="checked" <?php } ?> type="radio" />
                        <?php echo $lang['nc_yes'];?></label>
                </li>
                <li>
                    <label>
                        <input name="wel_ele_adjust" value="0" <?php if (empty($output['inner_config']) || $output['inner_config']['wel_ele_adjust'] == 0) { ?>checked="checked" <?php } ?> type="radio"/>
                        <?php echo $lang['nc_no'];?></label>
                </li>
            </ul>
        </dd>
      </dl>
     
      <dl>
        <dt>多功能方向盘<?php echo $lang['nc_colon'];?></dt>
         <dd>
             <ul class="ncsc-form-radio-list">
                 <li>
                     <label>
                         <input name="mfl" value="1" <?php if (!empty($output['inner_config']) && $output['inner_config']['mfl'] == 1) { ?>checked="checked" <?php } ?> type="radio" />
                         <?php echo $lang['nc_yes'];?></label>
                 </li>
                 <li>
                     <label>
                         <input name="mfl" value="0" <?php if (empty($output['inner_config']) || $output['inner_config']['mfl'] == 0) { ?>checked="checked" <?php } ?> type="radio"/>
                         <?php echo $lang['nc_no'];?></label>
                 </li>
             </ul>
        </dd>
      </dl>
	  
	   <dl>
        <dt>方向盘换挡<?php echo $lang['nc_colon'];?></dt>
        <dd>
            <ul class="ncsc-form-radio-list">
                <li>
                    <label>
                        <input name="wel_shift" value="1" <?php if (!empty($output['inner_config']) && $output['inner_config']['wel_shift'] == 1) { ?>checked="checked" <?php } ?> type="radio" />
                        <?php echo $lang['nc_yes'];?></label>
                </li>
                <li>
                    <label>
                        <input name="wel_shift" value="0" <?php if (empty($output['inner_config']) || $output['inner_config']['wel_shift'] == 0) { ?>checked="checked" <?php } ?> type="radio"/>
                        <?php echo $lang['nc_no'];?></label>
                </li>
            </ul>

        </dd>
      </dl>
     
      <dl>
        <dt>方向盘加热<?php echo $lang['nc_colon'];?></dt>
         <dd>
             <ul class="ncsc-form-radio-list">
                 <li>
                     <label>
                         <input name="lhz" value="1" <?php if (!empty($output['inner_config']) && $output['inner_config']['lhz'] == 1) { ?>checked="checked" <?php } ?> type="radio" />
                         <?php echo $lang['nc_yes'];?></label>
                 </li>
                 <li>
                     <label>
                         <input name="lhz" value="0" <?php if (empty($output['inner_config']) || $output['inner_config']['lhz'] == 0) { ?>checked="checked" <?php } ?> type="radio"/>
                         <?php echo $lang['nc_no'];?></label>
                 </li>
             </ul>

        </dd>
      </dl>
	  
      <dl>
        <dt>方向盘记忆<?php echo $lang['nc_colon'];?></dt>
        <dd>
            <ul class="ncsc-form-radio-list">
                <li>
                    <label>
                        <input name="wel_memory" value="1" <?php if (!empty($output['inner_config']) && $output['inner_config']['wel_memory'] == 1) { ?>checked="checked" <?php } ?> type="radio" />
                        <?php echo $lang['nc_yes'];?></label>
                </li>
                <li>
                    <label>
                        <input name="wel_memory" value="0" <?php if (empty($output['inner_config']) || $output['inner_config']['wel_memory'] == 0) { ?>checked="checked" <?php } ?> type="radio"/>
                        <?php echo $lang['nc_no'];?></label>
                </li>
            </ul>

        </dd>
      </dl>
     
      <dl>
        <dt>定速巡航<?php echo $lang['nc_colon'];?></dt>
         <dd>
             <ul class="ncsc-form-radio-list">
                 <li>
                     <label>
                         <input name="cru_control" value="1" <?php if (!empty($output['inner_config']) && $output['inner_config']['cru_control'] == 1) { ?>checked="checked" <?php } ?> type="radio" />
                         <?php echo $lang['nc_yes'];?></label>
                 </li>
                 <li>
                     <label>
                         <input name="cru_control" value="0" <?php if (empty($output['inner_config']) || $output['inner_config']['cru_control'] == 0) { ?>checked="checked" <?php } ?> type="radio"/>
                         <?php echo $lang['nc_no'];?></label>
                 </li>
             </ul>

        </dd>
      </dl>
	  
	        <dl>
        <dt>前/后驻车雷达<?php echo $lang['nc_colon'];?></dt>
         <dd>
             <ul class="ncsc-form-radio-list">
                 <li>
                     <label>
                         <input name="park_radar" value="1" <?php if (!empty($output['inner_config']) && $output['inner_config']['park_radar'] == 1) { ?>checked="checked" <?php } ?> type="radio" />
                         <?php echo $lang['nc_yes'];?></label>
                 </li>
                 <li>
                     <label>
                         <input name="park_radar" value="0" <?php if (empty($output['inner_config']) || $output['inner_config']['park_radar'] == 0) { ?>checked="checked" <?php } ?> type="radio"/>
                         <?php echo $lang['nc_no'];?></label>
                 </li>
             </ul>

        </dd>
      </dl>
	  
	   <dl>
        <dt>倒车视频影像<?php echo $lang['nc_colon'];?></dt>
        <dd>
            <ul class="ncsc-form-radio-list">
                <li>
                    <label>
                        <input name="rev_video" value="1" <?php if (!empty($output['inner_config']) && $output['inner_config']['rev_video'] == 1) { ?>checked="checked" <?php } ?> type="radio" />
                        <?php echo $lang['nc_yes'];?></label>
                </li>
                <li>
                    <label>
                        <input name="rev_video" value="0" <?php if (empty($output['inner_config']) || $output['inner_config']['rev_video'] == 0) { ?>checked="checked" <?php } ?> type="radio"/>
                        <?php echo $lang['nc_no'];?></label>
                </li>
            </ul>

        </dd>
      </dl>
     
      <dl>
        <dt>行车电脑显示屏<?php echo $lang['nc_colon'];?></dt>
         <dd>
             <ul class="ncsc-form-radio-list">
                 <li>
                     <label>
                         <input name="com_screen" value="1" <?php if (!empty($output['inner_config']) && $output['inner_config']['com_screen'] == 1) { ?>checked="checked" <?php } ?> type="radio" />
                         <?php echo $lang['nc_yes'];?></label>
                 </li>
                 <li>
                     <label>
                         <input name="com_screen" value="0" <?php if (empty($output['inner_config']) || $output['inner_config']['com_screen'] == 0) { ?>checked="checked" <?php } ?> type="radio"/>
                         <?php echo $lang['nc_no'];?></label>
                 </li>
             </ul>

        </dd>
      </dl>
	  
      <dl>
        <dt>全夜景仪表盘<?php echo $lang['nc_colon'];?></dt>
        <dd>
            <ul class="ncsc-form-radio-list">
                <li>
                    <label>
                        <input name="lcd_panel" value="1" <?php if (!empty($output['inner_config']) && $output['inner_config']['lcd_panel'] == 1) { ?>checked="checked" <?php } ?> type="radio" />
                        <?php echo $lang['nc_yes'];?></label>
                </li>
                <li>
                    <label>
                        <input name="lcd_panel" value="0" <?php if (empty($output['inner_config']) || $output['inner_config']['lcd_panel'] == 0) { ?>checked="checked" <?php } ?> type="radio"/>
                        <?php echo $lang['nc_no'];?></label>
                </li>
            </ul>

        </dd>
      </dl>
     
      <dl>
        <dt>hud抬头数字显示<?php echo $lang['nc_colon'];?></dt>
         <dd>
             <ul class="ncsc-form-radio-list">
                 <li>
                     <label>
                         <input name="hud" value="1" <?php if (!empty($output['inner_config']) && $output['inner_config']['hud'] == 1) { ?>checked="checked" <?php } ?> type="radio" />
                         <?php echo $lang['nc_yes'];?></label>
                 </li>
                 <li>
                     <label>
                         <input name="hud" value="0" <?php if (empty($output['inner_config']) || $output['inner_config']['hud'] == 0) { ?>checked="checked" <?php } ?> type="radio"/>
                         <?php echo $lang['nc_no'];?></label>
                 </li>
             </ul>

        </dd>
      </dl>
	  
	  
	  
	  
	   <h3 id="demo2">外部/防盗配置</h3>
      <dl>
       <dt><i class="required">*</i>电动天窗<?php echo $lang['nc_colon'];?></dt>
        <dd nc_type="no_spec">
            <ul class="ncsc-form-radio-list">
                <li>
                    <label>
                        <input name="ele_sunroof" value="1" <?php if (!empty($output['external_config']) && $output['external_config']['ele_sunroof'] == 1) { ?>checked="checked" <?php } ?> type="radio" />
                        <?php echo $lang['nc_yes'];?></label>
                </li>
                <li>
                    <label>
                        <input name="ele_sunroof" value="0" <?php if (empty($output['external_config']) || $output['external_config']['ele_sunroof'] == 0) { ?>checked="checked" <?php } ?> type="radio"/>
                        <?php echo $lang['nc_no'];?></label>
                </li>
            </ul>
        </dd>
      </dl>
	  
      <dl>
       <dt><i class="required">*</i>全景天窗<?php echo $lang['nc_colon'];?></dt>
        <dd>
            <ul class="ncsc-form-radio-list">
                <li>
                    <label>
                        <input name="pan_sunroof" value="1" <?php if (!empty($output['external_config']) && $output['external_config']['pan_sunroof'] == 1) { ?>checked="checked" <?php } ?> type="radio" />
                        <?php echo $lang['nc_yes'];?></label>
                </li>
                <li>
                    <label>
                        <input name="pan_sunroof" value="0" <?php if (empty($output['external_config']) || $output['external_config']['pan_sunroof'] == 0) { ?>checked="checked" <?php } ?> type="radio"/>
                        <?php echo $lang['nc_no'];?></label>
                </li>
            </ul>

        </dd>
      </dl>
    
	 <dl>
        <dt>运动外观套件<?php echo $lang['nc_colon'];?></dt>
         <dd>
             <ul class="ncsc-form-radio-list">
                 <li>
                     <label>
                         <input name="motion_suite" value="1" <?php if (!empty($output['external_config']) && $output['external_config']['motion_suite'] == 1) { ?>checked="checked" <?php } ?> type="radio" />
                         <?php echo $lang['nc_yes'];?></label>
                 </li>
                 <li>
                     <label>
                         <input name="motion_suite" value="0" <?php if (empty($output['external_config']) || $output['external_config']['motion_suite'] == 0) { ?>checked="checked" <?php } ?> type="radio"/>
                         <?php echo $lang['nc_no'];?></label>
                 </li>
             </ul>

        </dd>
      </dl>
  

    <dl>
        <dt>铝合金轮圈<?php echo $lang['nc_colon'];?></dt>
         <dd>
             <ul class="ncsc-form-radio-list">
                 <li>
                     <label>
                         <input name="alloy_rim" value="1" <?php if (!empty($output['external_config']) && $output['external_config']['alloy_rim'] == 1) { ?>checked="checked" <?php } ?> type="radio" />
                         <?php echo $lang['nc_yes'];?></label>
                 </li>
                 <li>
                     <label>
                         <input name="alloy_rim" value="0" <?php if (empty($output['external_config']) || $output['external_config']['alloy_rim'] == 0) { ?>checked="checked" <?php } ?> type="radio"/>
                         <?php echo $lang['nc_no'];?></label>
                 </li>
             </ul>

        </dd>
      </dl>
   
     <dl>
        <dt>电动吸合门<?php echo $lang['nc_colon'];?></dt>
         <dd>
             <ul class="ncsc-form-radio-list">
                 <li>
                     <label>
                         <input name="suction_door" value="1" <?php if (!empty($output['external_config']) && $output['external_config']['suction_door'] == 1) { ?>checked="checked" <?php } ?> type="radio" />
                         <?php echo $lang['nc_yes'];?></label>
                 </li>
                 <li>
                     <label>
                         <input name="suction_door" value="0" <?php if (empty($output['external_config']) || $output['external_config']['suction_door'] == 0) { ?>checked="checked" <?php } ?> type="radio"/>
                         <?php echo $lang['nc_no'];?></label>
                 </li>
             </ul>

        </dd>
      </dl>
   
     <dl>
        <dt>侧滑门<?php echo $lang['nc_colon'];?></dt>
         <dd>
             <ul class="ncsc-form-radio-list">
                 <li>
                     <label>
                         <input name="siding_door" value="1" <?php if (!empty($output['external_config']) && $output['external_config']['siding_door'] == 1) { ?>checked="checked" <?php } ?> type="radio" />
                         <?php echo $lang['nc_yes'];?></label>
                 </li>
                 <li>
                     <label>
                         <input name="siding_door" value="0" <?php if (empty($output['external_config']) || $output['external_config']['siding_door'] == 0) { ?>checked="checked" <?php } ?> type="radio"/>
                         <?php echo $lang['nc_no'];?></label>
                 </li>
             </ul>

        </dd>
      </dl>
	  
	    <dl>
        <dt>电动后备箱<?php echo $lang['nc_colon'];?></dt>
         <dd>
             <ul class="ncsc-form-radio-list">
                 <li>
                     <label>
                         <input name="ele_trunk" value="1" <?php if (!empty($output['external_config']) && $output['external_config']['ele_trunk'] == 1) { ?>checked="checked" <?php } ?> type="radio" />
                         <?php echo $lang['nc_yes'];?></label>
                 </li>
                 <li>
                     <label>
                         <input name="ele_trunk" value="0" <?php if (empty($output['external_config']) || $output['external_config']['ele_trunk'] == 0) { ?>checked="checked" <?php } ?> type="radio"/>
                         <?php echo $lang['nc_no'];?></label>
                 </li>
             </ul>

        </dd>
      </dl>
   
     <dl>
        <dt>感应后背箱<?php echo $lang['nc_colon'];?></dt>
         <dd>
             <ul class="ncsc-form-radio-list">
                 <li>
                     <label>
                         <input name="ind_trunk" value="1" <?php if (!empty($output['external_config']) && $output['external_config']['ind_trunk'] == 1) { ?>checked="checked" <?php } ?> type="radio" />
                         <?php echo $lang['nc_yes'];?></label>
                 </li>
                 <li>
                     <label>
                         <input name="ind_trunk" value="0" <?php if (empty($output['external_config']) || $output['external_config']['ind_trunk'] == 0) { ?>checked="checked" <?php } ?> type="radio"/>
                         <?php echo $lang['nc_no'];?></label>
                 </li>
             </ul>

        </dd>
      </dl>
   
     <dl>
        <dt>车顶行李架<?php echo $lang['nc_colon'];?></dt>
         <dd>
             <ul class="ncsc-form-radio-list">
                 <li>
                     <label>
                         <input name="roof_rack" value="1" <?php if (!empty($output['external_config']) && $output['external_config']['roof_rack'] == 1) { ?>checked="checked" <?php } ?> type="radio" />
                         <?php echo $lang['nc_yes'];?></label>
                 </li>
                 <li>
                     <label>
                         <input name="roof_rack" value="0" <?php if (empty($output['external_config']) || $output['external_config']['roof_rack'] == 0) { ?>checked="checked" <?php } ?> type="radio"/>
                         <?php echo $lang['nc_no'];?></label>
                 </li>
             </ul>

        </dd>
      </dl>
	  
	  
	  
	  
   <h3 id="demo3">操控配置</h3>
     <dl>
        <dt><i class="required">*</i>abs防抱死<?php echo $lang['nc_colon'];?></dt>
         <dd>
             <ul class="ncsc-form-radio-list">
                 <li>
                     <label>
                         <input name="abs" value="1" <?php if (!empty($output['control_config']) && $output['control_config']['abs'] == 1) { ?>checked="checked" <?php } ?> type="radio" />
                         <?php echo $lang['nc_yes'];?></label>
                 </li>
                 <li>
                     <label>
                         <input name="abs" value="0" <?php if (empty($output['control_config']) || $output['control_config']['abs'] == 0) { ?>checked="checked" <?php } ?> type="radio"/>
                         <?php echo $lang['nc_no'];?></label>
                 </li>
             </ul>

        </dd>
      </dl>
	  
	   <dl>
        <dt><i class="required">*</i>制动力分配<?php echo $lang['nc_colon'];?></dt>
         <dd>
             <ul class="ncsc-form-radio-list">
                 <li>
                     <label>
                         <input name="ebd" value="1" <?php if (!empty($output['control_config']) && $output['control_config']['ebd'] == 1) { ?>checked="checked" <?php } ?> type="radio" />
                         <?php echo $lang['nc_yes'];?></label>
                 </li>
                 <li>
                     <label>
                         <input name="ebd" value="0" <?php if (empty($output['control_config']) || $output['control_config']['ebd'] == 0) { ?>checked="checked" <?php } ?> type="radio"/>
                         <?php echo $lang['nc_no'];?></label>
                 </li>
             </ul>

        </dd>
      </dl>
	  
	   <dl>
        <dt>刹车辅助系统<?php echo $lang['nc_colon'];?></dt>
         <dd>
             <ul class="ncsc-form-radio-list">
                 <li>
                     <label>
                         <input name="bas" value="1" <?php if (!empty($output['control_config']) && $output['control_config']['bas'] == 1) { ?>checked="checked" <?php } ?> type="radio" />
                         <?php echo $lang['nc_yes'];?></label>
                 </li>
                 <li>
                     <label>
                         <input name="bas" value="0" <?php if (empty($output['control_config']) || $output['control_config']['bas'] == 0) { ?>checked="checked" <?php } ?> type="radio"/>
                         <?php echo $lang['nc_no'];?></label>
                 </li>
             </ul>

        </dd>
      </dl>
	  
	   <dl>
        <dt>牵引力控制<?php echo $lang['nc_colon'];?></dt>
         <dd>
             <ul class="ncsc-form-radio-list">
                 <li>
                     <label>
                         <input name="asr" value="1" <?php if (!empty($output['control_config']) && $output['control_config']['asr'] == 1) { ?>checked="checked" <?php } ?> type="radio" />
                         <?php echo $lang['nc_yes'];?></label>
                 </li>
                 <li>
                     <label>
                         <input name="asr" value="0" <?php if (empty($output['control_config']) || $output['control_config']['asr'] == 0) { ?>checked="checked" <?php } ?> type="radio"/>
                         <?php echo $lang['nc_no'];?></label>
                 </li>
             </ul>
        </dd>
      </dl>
	  
	   <dl>
        <dt>车身稳定控制<?php echo $lang['nc_colon'];?></dt>
         <dd>
             <ul class="ncsc-form-radio-list">
                 <li>
                     <label>
                         <input name="esp" value="1" <?php if (!empty($output['control_config']) && $output['control_config']['esp'] == 1) { ?>checked="checked" <?php } ?> type="radio" />
                         <?php echo $lang['nc_yes'];?></label>
                 </li>
                 <li>
                     <label>
                         <input name="esp" value="0" <?php if (empty($output['control_config']) || $output['control_config']['esp'] == 0) { ?>checked="checked" <?php } ?> type="radio"/>
                         <?php echo $lang['nc_no'];?></label>
                 </li>
             </ul>
        </dd>
      </dl>
	  
	   <dl>
        <dt>上坡辅助系统<?php echo $lang['nc_colon'];?></dt>
         <dd>
             <ul class="ncsc-form-radio-list">
                 <li>
                     <label>
                         <input name="hac" value="1" <?php if (!empty($output['control_config']) && $output['control_config']['hac'] == 1) { ?>checked="checked" <?php } ?> type="radio" />
                         <?php echo $lang['nc_yes'];?></label>
                 </li>
                 <li>
                     <label>
                         <input name="hac" value="0" <?php if (empty($output['control_config']) || $output['control_config']['hac'] == 0) { ?>checked="checked" <?php } ?> type="radio"/>
                         <?php echo $lang['nc_no'];?></label>
                 </li>
             </ul>

        </dd>
      </dl>
	  
	       <dl>
        <dt>自动驻车系统<?php echo $lang['nc_colon'];?></dt>
         <dd>
             <ul class="ncsc-form-radio-list">
                 <li>
                     <label>
                         <input name="auto_hold" value="1" <?php if (!empty($output['control_config']) && $output['control_config']['auto_hold'] == 1) { ?>checked="checked" <?php } ?> type="radio" />
                         <?php echo $lang['nc_yes'];?></label>
                 </li>
                 <li>
                     <label>
                         <input name="auto_hold" value="0" <?php if (empty($output['control_config']) || $output['control_config']['auto_hold'] == 0) { ?>checked="checked" <?php } ?> type="radio"/>
                         <?php echo $lang['nc_no'];?></label>
                 </li>
             </ul>

        </dd>
      </dl>
	  
	   <dl>
        <dt>陡坡缓降<?php echo $lang['nc_colon'];?></dt>
         <dd>
             <ul class="ncsc-form-radio-list">
                 <li>
                     <label>
                         <input name="hdc" value="1" <?php if (!empty($output['control_config']) && $output['control_config']['hdc'] == 1) { ?>checked="checked" <?php } ?> type="radio" />
                         <?php echo $lang['nc_yes'];?></label>
                 </li>
                 <li>
                     <label>
                         <input name="hdc" value="0" <?php if (empty($output['control_config']) || $output['control_config']['hdc'] == 0) { ?>checked="checked" <?php } ?> type="radio"/>
                         <?php echo $lang['nc_no'];?></label>
                 </li>
             </ul>

        </dd>
      </dl>
	  
	   <dl>
        <dt>可变悬架<?php echo $lang['nc_colon'];?></dt>
         <dd>
             <ul class="ncsc-form-radio-list">
                 <li>
                     <label>
                         <input name="avs" value="1" <?php if (!empty($output['control_config']) && $output['control_config']['avs'] == 1) { ?>checked="checked" <?php } ?> type="radio" />
                         <?php echo $lang['nc_yes'];?></label>
                 </li>
                 <li>
                     <label>
                         <input name="avs" value="0" <?php if (empty($output['control_config']) || $output['control_config']['avs'] == 0) { ?>checked="checked" <?php } ?> type="radio"/>
                         <?php echo $lang['nc_no'];?></label>
                 </li>
             </ul>

        </dd>
      </dl>
	  
	   <dl>
        <dt>空气悬架<?php echo $lang['nc_colon'];?></dt>
         <dd>
             <ul class="ncsc-form-radio-list">
                 <li>
                     <label>
                         <input name="ecas" value="1" <?php if (!empty($output['control_config']) && $output['control_config']['ecas'] == 1) { ?>checked="checked" <?php } ?> type="radio" />
                         <?php echo $lang['nc_yes'];?></label>
                 </li>
                 <li>
                     <label>
                         <input name="ecas" value="0" <?php if (empty($output['control_config']) || $output['control_config']['ecas'] == 0) { ?>checked="checked" <?php } ?> type="radio"/>
                         <?php echo $lang['nc_no'];?></label>
                 </li>
             </ul>
        </dd>
      </dl>
	  
	   <dl>
        <dt>可变转向比<?php echo $lang['nc_colon'];?></dt>
         <dd>
             <ul class="ncsc-form-radio-list">
                 <li>
                     <label>
                         <input name="vgrs" value="1" <?php if (!empty($output['control_config']) && $output['control_config']['vgrs'] == 1) { ?>checked="checked" <?php } ?> type="radio" />
                         <?php echo $lang['nc_yes'];?></label>
                 </li>
                 <li>
                     <label>
                         <input name="vgrs" value="0" <?php if (empty($output['control_config']) || $output['control_config']['vgrs'] == 0) { ?>checked="checked" <?php } ?> type="radio"/>
                         <?php echo $lang['nc_no'];?></label>
                 </li>
             </ul>
        </dd>
      </dl>
	  
	   <dl>
        <dt>前桥防滑差速器/差速锁<?php echo $lang['nc_colon'];?></dt>
         <dd>
             <ul class="ncsc-form-radio-list">
                 <li>
                     <label>
                         <input name="front_limit" value="1" <?php if (!empty($output['control_config']) && $output['control_config']['front_limit'] == 1) { ?>checked="checked" <?php } ?> type="radio" />
                         <?php echo $lang['nc_yes'];?></label>
                 </li>
                 <li>
                     <label>
                         <input name="front_limit" value="0" <?php if (empty($output['control_config']) || $output['control_config']['front_limit'] == 0) { ?>checked="checked" <?php } ?> type="radio"/>
                         <?php echo $lang['nc_no'];?></label>
                 </li>
             </ul>

        </dd>
      </dl>
	  
	     <dl>
        <dt>中央差速器锁止功能<?php echo $lang['nc_colon'];?></dt>
         <dd>
             <ul class="ncsc-form-radio-list">
                 <li>
                     <label>
                         <input name="cent_diff_lock" value="1" <?php if (!empty($output['control_config']) && $output['control_config']['cent_diff_lock'] == 1) { ?>checked="checked" <?php } ?> type="radio" />
                         <?php echo $lang['nc_yes'];?></label>
                 </li>
                 <li>
                     <label>
                         <input name="cent_diff_lock" value="0" <?php if (empty($output['control_config']) || $output['control_config']['cent_diff_lock'] == 0) { ?>checked="checked" <?php } ?> type="radio"/>
                         <?php echo $lang['nc_no'];?></label>
                 </li>
             </ul>
        </dd>
      </dl>
	  
	   <dl>
        <dt>后桥限滑差速器/差速锁<?php echo $lang['nc_colon'];?></dt>
         <dd>
             <ul class="ncsc-form-radio-list">
                 <li>
                     <label>
                         <input name="rear_limit" value="1" <?php if (!empty($output['control_config']) && $output['control_config']['rear_limit'] == 1) { ?>checked="checked" <?php } ?> type="radio" />
                         <?php echo $lang['nc_yes'];?></label>
                 </li>
                 <li>
                     <label>
                         <input name="rear_limit" value="0" <?php if (empty($output['control_config']) || $output['control_config']['rear_limit'] == 0) { ?>checked="checked" <?php } ?> type="radio"/>
                         <?php echo $lang['nc_no'];?></label>
                 </li>
             </ul>

        </dd>
      </dl>
	  
	  
	  
	  
	  <h3 id="demo4">灯光配置</h3>
	  <dl>
        <dt><i class="required">*</i>近光灯<?php echo $lang['nc_colon'];?></dt>
         <dd>
             <ul class="ncsc-form-radio-list">
                 <li>
                     <label>
                         <input name="dip_helight" value="1" <?php if (!empty($output['light_config']) && $output['light_config']['dip_helight'] == 1) { ?>checked="checked" <?php } ?> type="radio" />
                         <?php echo $lang['nc_yes'];?></label>
                 </li>
                 <li>
                     <label>
                         <input name="dip_helight" value="0" <?php if (empty($output['light_config']) || $output['light_config']['dip_helight'] == 0) { ?>checked="checked" <?php } ?> type="radio"/>
                         <?php echo $lang['nc_no'];?></label>
                 </li>
             </ul>

        </dd>
      </dl>
	  
	   <dl>
        <dt><i class="required">*</i>远光灯<?php echo $lang['nc_colon'];?></dt>
         <dd>
             <ul class="ncsc-form-radio-list">
                 <li>
                     <label>
                         <input name="high_beam" value="1" <?php if (!empty($output['light_config']) && $output['light_config']['high_beam'] == 1) { ?>checked="checked" <?php } ?> type="radio" />
                         <?php echo $lang['nc_yes'];?></label>
                 </li>
                 <li>
                     <label>
                         <input name="high_beam" value="0" <?php if (empty($output['light_config']) || $output['light_config']['high_beam'] == 0) { ?>checked="checked" <?php } ?> type="radio"/>
                         <?php echo $lang['nc_no'];?></label>
                 </li>
             </ul>

        </dd>
      </dl>
	  
	   <dl>
        <dt>日间行车灯<?php echo $lang['nc_colon'];?></dt>
         <dd>
             <ul class="ncsc-form-radio-list">
                 <li>
                     <label>
                         <input name="drl" value="1" <?php if (!empty($output['light_config']) && $output['light_config']['drl'] == 1) { ?>checked="checked" <?php } ?> type="radio" />
                         <?php echo $lang['nc_yes'];?></label>
                 </li>
                 <li>
                     <label>
                         <input name="drl" value="0" <?php if (empty($output['light_config']) || $output['light_config']['drl'] == 0) { ?>checked="checked" <?php } ?> type="radio"/>
                         <?php echo $lang['nc_no'];?></label>
                 </li>
             </ul>
        </dd>
      </dl>
	  
	   <dl>
        <dt>自适应远近光<?php echo $lang['nc_colon'];?></dt>
         <dd>
             <ul class="ncsc-form-radio-list">
                 <li>
                     <label>
                         <input name="dist_light" value="1" <?php if (!empty($output['light_config']) && $output['light_config']['dist_light'] == 1) { ?>checked="checked" <?php } ?> type="radio" />
                         <?php echo $lang['nc_yes'];?></label>
                 </li>
                 <li>
                     <label>
                         <input name="dist_light" value="0" <?php if (empty($output['light_config']) || $output['light_config']['dist_light'] == 0) { ?>checked="checked" <?php } ?> type="radio"/>
                         <?php echo $lang['nc_no'];?></label>
                 </li>
             </ul>
        </dd>
      </dl>
	  
	  <dl>
        <dt>自动头灯<?php echo $lang['nc_colon'];?></dt>
         <dd>
             <ul class="ncsc-form-radio-list">
                 <li>
                     <label>
                         <input name="auto_helamp" value="1" <?php if (!empty($output['light_config']) && $output['light_config']['auto_helamp'] == 1) { ?>checked="checked" <?php } ?> type="radio" />
                         <?php echo $lang['nc_yes'];?></label>
                 </li>
                 <li>
                     <label>
                         <input name="auto_helamp" value="0" <?php if (empty($output['light_config']) || $output['light_config']['auto_helamp'] == 0) { ?>checked="checked" <?php } ?> type="radio"/>
                         <?php echo $lang['nc_no'];?></label>
                 </li>
             </ul>
        </dd>
      </dl>
	  
	  <dl>
        <dt>转向辅助灯<?php echo $lang['nc_colon'];?></dt>
         <dd>
             <ul class="ncsc-form-radio-list">
                 <li>
                     <label>
                         <input name="corn_lamp" value="1" <?php if (!empty($output['light_config']) && $output['light_config']['corn_lamp'] == 1) { ?>checked="checked" <?php } ?> type="radio" />
                         <?php echo $lang['nc_yes'];?></label>
                 </li>
                 <li>
                     <label>
                         <input name="corn_lamp" value="0" <?php if (empty($output['light_config']) || $output['light_config']['corn_lamp'] == 0) { ?>checked="checked" <?php } ?> type="radio"/>
                         <?php echo $lang['nc_no'];?></label>
                 </li>
             </ul>
        </dd>
      </dl>
	  
	    <dl>
        <dt>转向头灯<?php echo $lang['nc_colon'];?></dt>
         <dd>
             <ul class="ncsc-form-radio-list">
                 <li>
                     <label>
                         <input name="ste_helights" value="1" <?php if (!empty($output['light_config']) && $output['light_config']['ste_helights'] == 1) { ?>checked="checked" <?php } ?> type="radio" />
                         <?php echo $lang['nc_yes'];?></label>
                 </li>
                 <li>
                     <label>
                         <input name="ste_helights" value="0" <?php if (empty($output['light_config']) || $output['light_config']['ste_helights'] == 0) { ?>checked="checked" <?php } ?> type="radio"/>
                         <?php echo $lang['nc_no'];?></label>
                 </li>
             </ul>
        </dd>
      </dl>
	  
	   <dl>
        <dt>前雾灯<?php echo $lang['nc_colon'];?></dt>
         <dd>
             <ul class="ncsc-form-radio-list">
                 <li>
                     <label>
                         <input name="front_fog_lamp" value="1" <?php if (!empty($output['light_config']) && $output['light_config']['front_fog_lamp'] == 1) { ?>checked="checked" <?php } ?> type="radio" />
                         <?php echo $lang['nc_yes'];?></label>
                 </li>
                 <li>
                     <label>
                         <input name="front_fog_lamp" value="0" <?php if (empty($output['light_config']) || $output['light_config']['front_fog_lamp'] == 0) { ?>checked="checked" <?php } ?> type="radio"/>
                         <?php echo $lang['nc_no'];?></label>
                 </li>
             </ul>
        </dd>
      </dl>
	  
	   <dl>
        <dt>大灯高度可调<?php echo $lang['nc_colon'];?></dt>
         <dd>
             <ul class="ncsc-form-radio-list">
                 <li>
                     <label>
                         <input name="helight_adjust" value="1" <?php if (!empty($output['light_config']) && $output['light_config']['helight_adjust'] == 1) { ?>checked="checked" <?php } ?> type="radio" />
                         <?php echo $lang['nc_yes'];?></label>
                 </li>
                 <li>
                     <label>
                         <input name="helight_adjust" value="0" <?php if (empty($output['light_config']) || $output['light_config']['helight_adjust'] == 0) { ?>checked="checked" <?php } ?> type="radio"/>
                         <?php echo $lang['nc_no'];?></label>
                 </li>
             </ul>
        </dd>
      </dl>
	  
	    <dl>
        <dt>大灯清洗装置<?php echo $lang['nc_colon'];?></dt>
         <dd>
             <ul class="ncsc-form-radio-list">
                 <li>
                     <label>
                         <input name="lean_device" value="1" <?php if (!empty($output['light_config']) && $output['light_config']['lean_device'] == 1) { ?>checked="checked" <?php } ?> type="radio" />
                         <?php echo $lang['nc_yes'];?></label>
                 </li>
                 <li>
                     <label>
                         <input name="lean_device" value="0" <?php if (empty($output['light_config']) || $output['light_config']['lean_device'] == 0) { ?>checked="checked" <?php } ?> type="radio"/>
                         <?php echo $lang['nc_no'];?></label>
                 </li>
             </ul>
        </dd>
      </dl>
	  
	   <dl>
        <dt>车内氛围灯<?php echo $lang['nc_colon'];?></dt>
         <dd>
             <ul class="ncsc-form-radio-list">
                 <li>
                     <label>
                         <input name="atmos_lamp" value="1" <?php if (!empty($output['light_config']) && $output['light_config']['atmos_lamp'] == 1) { ?>checked="checked" <?php } ?> type="radio" />
                         <?php echo $lang['nc_yes'];?></label>
                 </li>
                 <li>
                     <label>
                         <input name="atmos_lamp" value="0" <?php if (empty($output['light_config']) || $output['light_config']['atmos_lamp'] == 0) { ?>checked="checked" <?php } ?> type="radio"/>
                         <?php echo $lang['nc_no'];?></label>
                 </li>
             </ul>
        </dd>
      </dl>
	  
	  
	  
	  
	   <h3 id="demo5">玻璃/后视镜</h3>
	  <dl>
        <dt>前/后电动车窗<?php echo $lang['nc_colon'];?></dt>
         <dd>
             <ul class="ncsc-form-radio-list">
                 <li>
                     <label>
                         <input name="power_wind" value="1" <?php if (!empty($output['rearview_mirror']) && $output['rearview_mirror']['power_wind'] == 1) { ?>checked="checked" <?php } ?> type="radio" />
                         <?php echo $lang['nc_yes'];?></label>
                 </li>
                 <li>
                     <label>
                         <input name="power_wind" value="0" <?php if (empty($output['rearview_mirror']) || $output['rearview_mirror']['power_wind'] == 0) { ?>checked="checked" <?php } ?> type="radio"/>
                         <?php echo $lang['nc_no'];?></label>
                 </li>
             </ul>

        </dd>
      </dl>
	  
	   <dl>
        <dt>车窗防夹手功能<?php echo $lang['nc_colon'];?></dt>
         <dd>
             <ul class="ncsc-form-radio-list">
                 <li>
                     <label>
                         <input name="anti_pin_func" value="1" <?php if (!empty($output['rearview_mirror']) && $output['rearview_mirror']['anti_pin_func'] == 1) { ?>checked="checked" <?php } ?> type="radio" />
                         <?php echo $lang['nc_yes'];?></label>
                 </li>
                 <li>
                     <label>
                         <input name="anti_pin_func" value="0" <?php if (empty($output['rearview_mirror']) || $output['rearview_mirror']['anti_pin_func'] == 0) { ?>checked="checked" <?php } ?> type="radio"/>
                         <?php echo $lang['nc_no'];?></label>
                 </li>
             </ul>

        </dd>
      </dl>
	  
	   <dl>
        <dt>防紫外线/隔热玻璃<?php echo $lang['nc_colon'];?></dt>
         <dd>
             <ul class="ncsc-form-radio-list">
                 <li>
                     <label>
                         <input name="heat_pro_gla" value="1" <?php if (!empty($output['rearview_mirror']) && $output['rearview_mirror']['heat_pro_gla'] == 1) { ?>checked="checked" <?php } ?> type="radio" />
                         <?php echo $lang['nc_yes'];?></label>
                 </li>
                 <li>
                     <label>
                         <input name="heat_pro_gla" value="0" <?php if (empty($output['rearview_mirror']) || $output['rearview_mirror']['heat_pro_gla'] == 0) { ?>checked="checked" <?php } ?> type="radio"/>
                         <?php echo $lang['nc_no'];?></label>
                 </li>
             </ul>
        </dd>
      </dl>
	  
	   <dl>
        <dt>后视镜电动调节<?php echo $lang['nc_colon'];?></dt>
         <dd>
             <ul class="ncsc-form-radio-list">
                 <li>
                     <label>
                         <input name="elec_control" value="1" <?php if (!empty($output['rearview_mirror']) && $output['rearview_mirror']['elec_control'] == 1) { ?>checked="checked" <?php } ?> type="radio" />
                         <?php echo $lang['nc_yes'];?></label>
                 </li>
                 <li>
                     <label>
                         <input name="elec_control " value="0" <?php if (empty($output['rearview_mirror']) || $output['rearview_mirror']['elec_control'] == 0) { ?>checked="checked" <?php } ?> type="radio"/>
                         <?php echo $lang['nc_no'];?></label>
                 </li>
             </ul>
        </dd>
      </dl>
	  
	  <dl>
        <dt>后视镜加热<?php echo $lang['nc_colon'];?></dt>
         <dd>
             <ul class="ncsc-form-radio-list">
                 <li>
                     <label>
                         <input name="revw_mirr_heat" value="1" <?php if (!empty($output['rearview_mirror']) && $output['rearview_mirror']['revw_mirr_heat'] == 1) { ?>checked="checked" <?php } ?> type="radio" />
                         <?php echo $lang['nc_yes'];?></label>
                 </li>
                 <li>
                     <label>
                         <input name="revw_mirr_heat" value="0" <?php if (empty($output['rearview_mirror']) || $output['rearview_mirror']['revw_mirr_heat'] == 0) { ?>checked="checked" <?php } ?> type="radio"/>
                         <?php echo $lang['nc_no'];?></label>
                 </li>
             </ul>
        </dd>
      </dl>
	  
	  <dl>
        <dt>内/外后视镜自动防眩目<?php echo $lang['nc_colon'];?></dt>
         <dd>
             <ul class="ncsc-form-radio-list">
                 <li>
                     <label>
                         <input name="auto_glare" value="1" <?php if (!empty($output['rearview_mirror']) && $output['rearview_mirror']['auto_glare'] == 1) { ?>checked="checked" <?php } ?> type="radio" />
                         <?php echo $lang['nc_yes'];?></label>
                 </li>
                 <li>
                     <label>
                         <input name="auto_glare" value="0" <?php if (empty($output['rearview_mirror']) || $output['rearview_mirror']['auto_glare'] == 0) { ?>checked="checked" <?php } ?> type="radio"/>
                         <?php echo $lang['nc_no'];?></label>
                 </li>
             </ul>
        </dd>
      </dl>
	  
	    <dl>
        <dt>后视镜电动折叠<?php echo $lang['nc_colon'];?></dt>
         <dd>
             <ul class="ncsc-form-radio-list">
                 <li>
                     <label>
                         <input name="elec_fold_mirr" value="1" <?php if (!empty($output['rearview_mirror']) && $output['rearview_mirror']['elec_fold_mirr'] == 1) { ?>checked="checked" <?php } ?> type="radio" />
                         <?php echo $lang['nc_yes'];?></label>
                 </li>
                 <li>
                     <label>
                         <input name="elec_fold_mirr" value="0" <?php if (empty($output['rearview_mirror']) || $output['rearview_mirror']['elec_fold_mirr'] == 0) { ?>checked="checked" <?php } ?> type="radio"/>
                         <?php echo $lang['nc_no'];?></label>
                 </li>
             </ul>
        </dd>
      </dl>
	  
	   <dl>
        <dt>后视镜记忆<?php echo $lang['nc_colon'];?></dt>
         <dd>
             <ul class="ncsc-form-radio-list">
                 <li>
                     <label>
                         <input name="revw_mirr_my" value="1" <?php if (!empty($output['rearview_mirror']) && $output['rearview_mirror']['revw_mirr_my'] == 1) { ?>checked="checked" <?php } ?> type="radio" />
                         <?php echo $lang['nc_yes'];?></label>
                 </li>
                 <li>
                     <label>
                         <input name="revw_mirr_my" value="0" <?php if (empty($output['rearview_mirror']) || $output['rearview_mirror']['revw_mirr_my'] == 0) { ?>checked="checked" <?php } ?> type="radio"/>
                         <?php echo $lang['nc_no'];?></label>
                 </li>
             </ul>
        </dd>
      </dl>
	  
	  
	  	  <dl>
        <dt>后风挡遮阳帘<?php echo $lang['nc_colon'];?></dt>
         <dd>
             <ul class="ncsc-form-radio-list">
                 <li>
                     <label>
                         <input name="rear_win_sunshd" value="1" <?php if (!empty($output['rearview_mirror']) && $output['rearview_mirror']['rear_win_sunshd'] == 1) { ?>checked="checked" <?php } ?> type="radio" />
                         <?php echo $lang['nc_yes'];?></label>
                 </li>
                 <li>
                     <label>
                         <input name="rear_win_sunshd" value="0" <?php if (empty($output['rearview_mirror']) || $output['rearview_mirror']['rear_win_sunshd'] == 0) { ?>checked="checked" <?php } ?> type="radio"/>
                         <?php echo $lang['nc_no'];?></label>
                 </li>
             </ul>

        </dd>
      </dl>
	  
	   <dl>
        <dt>后排侧遮阳帘<?php echo $lang['nc_colon'];?></dt>
         <dd>
             <ul class="ncsc-form-radio-list">
                 <li>
                     <label>
                         <input name="rear_sd_sun_curt" value="1" <?php if (!empty($output['rearview_mirror']) && $output['rearview_mirror']['rear_sd_sun_curt'] == 1) { ?>checked="checked" <?php } ?> type="radio" />
                         <?php echo $lang['nc_yes'];?></label>
                 </li>
                 <li>
                     <label>
                         <input name="rear_sd_sun_curt" value="0" <?php if (empty($output['rearview_mirror']) || $output['rearview_mirror']['rear_sd_sun_curt'] == 0) { ?>checked="checked" <?php } ?> type="radio"/>
                         <?php echo $lang['nc_no'];?></label>
                 </li>
             </ul>

        </dd>
      </dl>
	  
	   <dl>
        <dt>后排侧隐私玻璃<?php echo $lang['nc_colon'];?></dt>
         <dd>
             <ul class="ncsc-form-radio-list">
                 <li>
                     <label>
                         <input name="priv_glass" value="1" <?php if (!empty($output['rearview_mirror']) && $output['rearview_mirror']['priv_glass'] == 1) { ?>checked="checked" <?php } ?> type="radio" />
                         <?php echo $lang['nc_yes'];?></label>
                 </li>
                 <li>
                     <label>
                         <input name="priv_glass" value="0" <?php if (empty($output['rearview_mirror']) || $output['rearview_mirror']['priv_glass'] == 0) { ?>checked="checked" <?php } ?> type="radio"/>
                         <?php echo $lang['nc_no'];?></label>
                 </li>
             </ul>
        </dd>
      </dl>
	  
	   <dl>
        <dt>遮阳板化妆镜<?php echo $lang['nc_colon'];?></dt>
         <dd>
             <ul class="ncsc-form-radio-list">
                 <li>
                     <label>
                         <input name="sun_visor" value="1" <?php if (!empty($output['rearview_mirror']) && $output['rearview_mirror']['sun_visor'] == 1) { ?>checked="checked" <?php } ?> type="radio" />
                         <?php echo $lang['nc_yes'];?></label>
                 </li>
                 <li>
                     <label>
                         <input name="sun_visor" value="0" <?php if (empty($output['rearview_mirror']) || $output['rearview_mirror']['sun_visor'] == 0) { ?>checked="checked" <?php } ?> type="radio"/>
                         <?php echo $lang['nc_no'];?></label>
                 </li>
             </ul>
        </dd>
      </dl>
	  
	  <dl>
        <dt>后雨刷<?php echo $lang['nc_colon'];?></dt>
         <dd>
             <ul class="ncsc-form-radio-list">
                 <li>
                     <label>
                         <input name="rear_wiper" value="1" <?php if (!empty($output['rearview_mirror']) && $output['rearview_mirror']['rear_wiper'] == 1) { ?>checked="checked" <?php } ?> type="radio" />
                         <?php echo $lang['nc_yes'];?></label>
                 </li>
                 <li>
                     <label>
                         <input name="rear_wiper" value="0" <?php if (empty($output['rearview_mirror']) || $output['rearview_mirror']['rear_wiper'] == 0) { ?>checked="checked" <?php } ?> type="radio"/>
                         <?php echo $lang['nc_no'];?></label>
                 </li>
             </ul>
        </dd>
      </dl>
	  
	  <dl>
        <dt>感应雨刷<?php echo $lang['nc_colon'];?></dt>
         <dd>
             <ul class="ncsc-form-radio-list">
                 <li>
                     <label>
                         <input name="induc_wiper" value="1" <?php if (!empty($output['rearview_mirror']) && $output['rearview_mirror']['induc_wiper'] == 1) { ?>checked="checked" <?php } ?> type="radio" />
                         <?php echo $lang['nc_yes'];?></label>
                 </li>
                 <li>
                     <label>
                         <input name="induc_wiper" value="0" <?php if (empty($output['rearview_mirror']) || $output['rearview_mirror']['induc_wiper'] == 0) { ?>checked="checked" <?php } ?> type="radio"/>
                         <?php echo $lang['nc_no'];?></label>
                 </li>
             </ul>
        </dd>
      </dl>
	  
	  
	  
	    <h3 id="demo6">高科技配置</h3>
	  <dl>
        <dt>自动泊车入位<?php echo $lang['nc_colon'];?></dt>
         <dd>
             <ul class="ncsc-form-radio-list">
                 <li>
                     <label>
                         <input name="auto_pa_ps" value="1" <?php if (!empty($output['high_tech_config']) && $output['high_tech_config']['auto_pa_ps'] == 1) { ?>checked="checked" <?php } ?> type="radio" />
                         <?php echo $lang['nc_yes'];?></label>
                 </li>
                 <li>
                     <label>
                         <input name="auto_pa_ps" value="0" <?php if (empty($output['high_tech_config']) || $output['high_tech_config']['auto_pa_ps'] == 0) { ?>checked="checked" <?php } ?> type="radio"/>
                         <?php echo $lang['nc_no'];?></label>
                 </li>
             </ul>

        </dd>
      </dl>
	  
	   <dl>
        <dt>发动机启停技术<?php echo $lang['nc_colon'];?></dt>
         <dd>
             <ul class="ncsc-form-radio-list">
                 <li>
                     <label>
                         <input name="en_st_sp" value="1" <?php if (!empty($output['high_tech_config']) && $output['high_tech_config']['en_st_sp'] == 1) { ?>checked="checked" <?php } ?> type="radio" />
                         <?php echo $lang['nc_yes'];?></label>
                 </li>
                 <li>
                     <label>
                         <input name="en_st_sp" value="0" <?php if (empty($output['high_tech_config']) || $output['high_tech_config']['en_st_sp'] == 0) { ?>checked="checked" <?php } ?> type="radio"/>
                         <?php echo $lang['nc_no'];?></label>
                 </li>
             </ul>

        </dd>
      </dl>
	  
	   <dl>
        <dt>并线辅助<?php echo $lang['nc_colon'];?></dt>
         <dd>
             <ul class="ncsc-form-radio-list">
                 <li>
                     <label>
                         <input name="auxiliary" value="1" <?php if (!empty($output['high_tech_config']) && $output['high_tech_config']['auxiliary'] == 1) { ?>checked="checked" <?php } ?> type="radio" />
                         <?php echo $lang['nc_yes'];?></label>
                 </li>
                 <li>
                     <label>
                         <input name="auxiliary" value="0" <?php if (empty($output['high_tech_config']) || $output['high_tech_config']['auxiliary'] == 0) { ?>checked="checked" <?php } ?> type="radio"/>
                         <?php echo $lang['nc_no'];?></label>
                 </li>
             </ul>
        </dd>
      </dl>
	  
	   <dl>
        <dt>车道偏离预警系统<?php echo $lang['nc_colon'];?></dt>
         <dd>
             <ul class="ncsc-form-radio-list">
                 <li>
                     <label>
                         <input name="ldws" value="1" <?php if (!empty($output['high_tech_config']) && $output['high_tech_config']['ldws'] == 1) { ?>checked="checked" <?php } ?> type="radio" />
                         <?php echo $lang['nc_yes'];?></label>
                 </li>
                 <li>
                     <label>
                         <input name="ldws" value="0" <?php if (empty($output['high_tech_config']) || $output['high_tech_config']['ldws'] == 0) { ?>checked="checked" <?php } ?> type="radio"/>
                         <?php echo $lang['nc_no'];?></label>
                 </li>
             </ul>
        </dd>
      </dl>
	  
	  <dl>
        <dt><i class="required">*</i>主动刹车/主动安全系统<?php echo $lang['nc_colon'];?></dt>
         <dd>
             <ul class="ncsc-form-radio-list">
                 <li>
                     <label>
                         <input name="act_brake" value="1" <?php if (!empty($output['high_tech_config']) && $output['high_tech_config']['act_brake'] == 1) { ?>checked="checked" <?php } ?> type="radio" />
                         <?php echo $lang['nc_yes'];?></label>
                 </li>
                 <li>
                     <label>
                         <input name="act_brake" value="0" <?php if (empty($output['high_tech_config']) || $output['high_tech_config']['act_brake'] == 0) { ?>checked="checked" <?php } ?> type="radio"/>
                         <?php echo $lang['nc_no'];?></label>
                 </li>
             </ul>
        </dd>
      </dl>
	  
	  <dl>
        <dt>中控液晶屏分屏显示<?php echo $lang['nc_colon'];?></dt>
         <dd>
             <ul class="ncsc-form-radio-list">
                 <li>
                     <label>
                         <input name="scr_display" value="1" <?php if (!empty($output['high_tech_config']) && $output['high_tech_config']['scr_display'] == 1) { ?>checked="checked" <?php } ?> type="radio" />
                         <?php echo $lang['nc_yes'];?></label>
                 </li>
                 <li>
                     <label>
                         <input name="scr_display" value="0" <?php if (empty($output['high_tech_config']) || $output['high_tech_config']['scr_display'] == 0) { ?>checked="checked" <?php } ?> type="radio"/>
                         <?php echo $lang['nc_no'];?></label>
                 </li>
             </ul>
        </dd>
      </dl>
	  
	    <dl>
        <dt>自适应巡航<?php echo $lang['nc_colon'];?></dt>
         <dd>
             <ul class="ncsc-form-radio-list">
                 <li>
                     <label>
                         <input name="ada_cruise" value="1" <?php if (!empty($output['high_tech_config']) && $output['high_tech_config']['ada_cruise'] == 1) { ?>checked="checked" <?php } ?> type="radio" />
                         <?php echo $lang['nc_yes'];?></label>
                 </li>
                 <li>
                     <label>
                         <input name="ada_cruise" value="0" <?php if (empty($output['high_tech_config']) || $output['high_tech_config']['ada_cruise'] == 0) { ?>checked="checked" <?php } ?> type="radio"/>
                         <?php echo $lang['nc_no'];?></label>
                 </li>
             </ul>
        </dd>
      </dl>
	  
	   <dl>
        <dt>全景摄像头<?php echo $lang['nc_colon'];?></dt>
         <dd>
             <ul class="ncsc-form-radio-list">
                 <li>
                     <label>
                         <input name="pan_cam" value="1" <?php if (!empty($output['high_tech_config']) && $output['high_tech_config']['pan_cam'] == 1) { ?>checked="checked" <?php } ?> type="radio" />
                         <?php echo $lang['nc_yes'];?></label>
                 </li>
                 <li>
                     <label>
                         <input name="pan_cam" value="0" <?php if (empty($output['high_tech_config']) || $output['high_tech_config']['pan_cam'] == 0) { ?>checked="checked" <?php } ?> type="radio"/>
                         <?php echo $lang['nc_no'];?></label>
                 </li>
             </ul>
        </dd>
      </dl>
	  
	  
	  
	  
	  <h3 id="demo7">空调/冰箱</h3>
	  <dl>
        <dt>空调控制方式<?php echo $lang['nc_colon'];?></dt>
         <dd>
          <input name="con_metd" value="<?php echo $output['refrigerator']['con_metd']; ?>" type="text" class="text w400" /> 
		  <span></span>

        </dd>
      </dl>
	  
	   <dl>
        <dt>后排独立空调<?php echo $lang['nc_colon'];?></dt>
         <dd>
             <ul class="ncsc-form-radio-list">
                 <li>
                     <label>
                         <input name="bac_row_air_cond" value="1" <?php if (!empty($output['refrigerator']) && $output['refrigerator']['bac_row_air_cond'] == 1) { ?>checked="checked" <?php } ?> type="radio" />
                         <?php echo $lang['nc_yes'];?></label>
                 </li>
                 <li>
                     <label>
                         <input name="bac_row_air_cond" value="0" <?php if (empty($output['refrigerator']) || $output['refrigerator']['bac_row_air_cond'] == 0) { ?>checked="checked" <?php } ?> type="radio"/>
                         <?php echo $lang['nc_no'];?></label>
                 </li>
             </ul>

        </dd>
      </dl>
	  
	   <dl>
        <dt>后座出风口<?php echo $lang['nc_colon'];?></dt>
         <dd>
             <ul class="ncsc-form-radio-list">
                 <li>
                     <label>
                         <input name="rear_outlet" value="1" <?php if (!empty($output['refrigerator']) && $output['refrigerator']['rear_outlet'] == 1) { ?>checked="checked" <?php } ?> type="radio" />
                         <?php echo $lang['nc_yes'];?></label>
                 </li>
                 <li>
                     <label>
                         <input name="rear_outlet" value="0" <?php if (empty($output['refrigerator']) || $output['refrigerator']['rear_outlet'] == 0) { ?>checked="checked" <?php } ?> type="radio"/>
                         <?php echo $lang['nc_no'];?></label>
                 </li>
             </ul>

        </dd>
      </dl>
	  
	   <dl>
        <dt>温度分区控制<?php echo $lang['nc_colon'];?></dt>
         <dd>
             <ul class="ncsc-form-radio-list">
                 <li>
                     <label>
                         <input name="temp_zone_con" value="1" <?php if (!empty($output['refrigerator']) && $output['refrigerator']['temp_zone_con'] == 1) { ?>checked="checked" <?php } ?> type="radio" />
                         <?php echo $lang['nc_yes'];?></label>
                 </li>
                 <li>
                     <label>
                         <input name="temp_zone_con" value="0" <?php if (empty($output['refrigerator']) || $output['refrigerator']['temp_zone_con'] == 0) { ?>checked="checked" <?php } ?> type="radio"/>
                         <?php echo $lang['nc_no'];?></label>
                 </li>
             </ul>
        </dd>
      </dl>
	  
	  <dl>
        <dt>车内空气调节/花粉过滤<?php echo $lang['nc_colon'];?></dt>
         <dd>
             <ul class="ncsc-form-radio-list">
                 <li>
                     <label>
                         <input name="pollen_filtra" value="1" <?php if (!empty($output['refrigerator']) && $output['refrigerator']['pollen_filtra'] == 1) { ?>checked="checked" <?php } ?> type="radio" />
                         <?php echo $lang['nc_yes'];?></label>
                 </li>
                 <li>
                     <label>
                         <input name="pollen_filtra" value="0" <?php if (empty($output['refrigerator']) || $output['refrigerator']['pollen_filtra'] == 0) { ?>checked="checked" <?php } ?> type="radio"/>
                         <?php echo $lang['nc_no'];?></label>
                 </li>
             </ul>
        </dd>
      </dl>
	  
	  <dl>
        <dt>车载冰箱<?php echo $lang['nc_colon'];?></dt>
         <dd>
             <ul class="ncsc-form-radio-list">
                 <li>
                     <label>
                         <input name="car_refrig" value="1" <?php if (!empty($output['refrigerator']) && $output['refrigerator']['car_refrig'] == 1) { ?>checked="checked" <?php } ?> type="radio" />
                         <?php echo $lang['nc_yes'];?></label>
                 </li>
                 <li>
                     <label>
                         <input name="car_refrig" value="0" <?php if (empty($output['refrigerator']) || $output['refrigerator']['car_refrig'] == 0) { ?>checked="checked" <?php } ?> type="radio"/>
                         <?php echo $lang['nc_no'];?></label>
                 </li>
             </ul>
        </dd>
      </dl>
	  
	  
	  
    </div>
    <div class="bottom tc hr32">
      <label class="submit-border">
        <input type="submit" class="submit" value="<?php if ($output['edit_goods_sign']) {echo '提交';} else {?><?php echo $lang['store_goods_add_next'];?>，上传商品图片<?php }?>" />
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

        $.validator.addMethod('checkPrice', function(value,element){
            _g_price = parseFloat($('input[name="g_price"]').val());
            _g_marketprice = parseFloat($('input[name="g_marketprice"]').val());
            if (_g_price > _g_marketprice) {
                return false;
            }else {
                return true;
            }
        }, '<i class="icon-exclamation-sign"></i>商品价格不能高于市场价格');
        jQuery.validator.addMethod("checkFCodePrefix", function(value, element) {
            return this.optional(element) || /^[a-zA-Z]+$/.test(value);
        },'<i class="icon-exclamation-sign"></i>请填写不多于5位的英文字母');
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
                 lea_st_wheel : {
                required    : true,
            },
            wel_adjust : {
                required    : true,
            },
            /* wel_ele_adjust : {
                required    : true,               
            },
		
            mfl : {
                required    : true,
            },
            wel_shift : {
               required    : true,
            },
            lhz  : {
                required    : true,
            },

            wel_memory : {
                required    : true,
            },

            cru_control : {
                required    : true,
            },
            park_radar : {
                required    : true,
            },
			rev_video : {
				 required    : true,
			},
			com_screen : {
				 required    : true,
			},
			lcd_panel : {
				 required    : true,
			},
			hud : {
				 required    : true,
			}, */
            ele_sunroof : {
                required    : true,
            },
            pan_sunroof : {
                required    : true,               
            },
		
           /*  motion_suite : {
                required    : true,
            },
            alloy_rim : {
               required    : true,
            },
            suction_door  : {
                required    : true,
            },

            siding_door : {
                required    : true,
            },

            ele_trunk : {
                required    : true,
            },
            ind_trunk : {
                required    : true,
            },
			roof_rack : {
				 required    : true,
			}, */
			abs : {
				 required    : true,
			},
			ebd : {
				 required    : true,
			},
			/* bas : {
				 required    : true,
			},
            asr : {
                required    : true,
            },
            esp : {
                required    : true,               
            },
		
            hac : {
                required    : true,
            },
            auto_hold : {
               required    : true,
            },
            hdc  : {
                required    : true,
            },

            avs : {
                required    : true,
            },

            ecas : {
                required    : true,
            },
            vgrs : {
                required    : true,
            },
			front_limit : {
				 required    : true,
			},
			cent_diff_lock : {
				 required    : true,
			},
			rear_limit : {
				 required    : true,
			}, */
			dip_helight : {
				 required    : true,
			},
            high_beam : {
                required    : true,
            },
           /*  drl : {
                required    : true,               
            },
		
            dist_light : {
                required    : true,
            },
            auto_helamp : {
               required    : true,
            },
            corn_lamp  : {
                required    : true,
            },

            ste_helights : {
                required    : true,
            },

            front_fog_lamp : {
                required    : true,
            },
            helight_adjust : {
                required    : true,
            },
			lean_device : {
				 required    : true,
			},
			atmos_lamp : {
				 required    : true,
			}, */
			
			
			/*  power_wind : {
                required    : true,
            },
            anti_pin_func : {
                required    : true,               
            },
		
            heat_pro_gla : {
                required    : true,
            },
            elec_control : {
               required    : true,
            },
            revw_mirr_heat  : {
                required    : true,
            },

            auto_glare : {
                required    : true,
            },

            elec_fold_mirr : {
                required    : true,
            },
            revw_mirr_my : {
                required    : true,
            },
			rear_win_sunshd : {
				 required    : true,
			},
			rear_sd_sun_curt : {
				 required    : true,
			},
			priv_glass : {
				 required    : true,
			},
			sun_visor : {
				 required    : true,
			},
            rear_wiper : {
                required    : true,
            },
            induc_wiper : {
                required    : true,               
            }, */
			
			
            /* auto_pa_ps : {
                required    : true,
            },
            en_st_sp : {
               required    : true,
            },
            auxiliary  : {
                required    : true,
            },

            ldws : {
                required    : true,
            },

            act_brake : {
                required    : true,
            },
            scr_display : {
                required    : true,
            },
			ada_cruise : {
				 required    : true,
			},
			pan_cam : {
				 required    : true,
			}, */
			
			
			/* con_metd : {
				 required    : true,
			},
			bac_row_air_cond : {
				 required    : true,
			},
            rear_outlet : {
                required    : true,
            },
            temp_zone_con : {
                required    : true,               
            },
		
            pollen_filtra : {
                required    : true,
            },
            car_refrig : {
               required    : true,
            }, */
            },
            messages : {
               lea_st_wheel  : {
                required    : '<i class="icon-exclamation-sign"></i>真皮方向盘',
            },
            wel_adjust : {
                required    : '<i class="icon-exclamation-sign"></i>方向盘调节',
            },
            /* wel_ele_adjust : {
                required    : '<i class="icon-exclamation-sign"></i>方向盘电动调节',
            },
            mfl : {
                required    : '<i class="icon-exclamation-sign"></i>多功能方向盘',
            },
            wel_shift : {
                required    : '<i class="icon-exclamation-sign"></i>方向盘换挡',
            },
            lhz : {
                required    : '<i class="icon-exclamation-sign"></i>方向盘加热',               
            },
            wel_memory : {
                required    : '<i class="icon-exclamation-sign"></i>方向盘记忆',
            },
            cru_control : {
                required    : '<i class="icon-exclamation-sign"></i>定速巡航',
            },
			park_radar : {
				required	: '<i class="icon-exclamation-sign"></i>前/后驻车雷达',	
			},
			rev_video : {
				required	: '<i class="icon-exclamation-sign"></i>倒车视频影像',
			},
			com_screen : {
				required	: '<i class="icon-exclamation-sign"></i>行车电脑显示屏',
			},
			lcd_panel : {
				required	: '<i class="icon-exclamation-sign"></i>全夜景仪表盘'
			},
			hud : {
				required	: '<i class="icon-exclamation-sign"></i>hud抬头数字显示'
			}, */
            ele_sunroof : {
                required    : '<i class="icon-exclamation-sign"></i>电动天窗',
            },
            pan_sunroof : {
                required    : '<i class="icon-exclamation-sign"></i>全景天窗',
            },
           /*  motion_suite : {
                required    : '<i class="icon-exclamation-sign"></i>运动外观套件',
            },
            alloy_rim : {
                required    : '<i class="icon-exclamation-sign"></i>铝合金轮圈',
            },
            suction_door : {
                required    : '<i class="icon-exclamation-sign"></i>电动吸合门',               
            },
            siding_door : {
                required    : '<i class="icon-exclamation-sign"></i>侧滑门',
            },
            ele_trunk : {
                required    : '<i class="icon-exclamation-sign"></i>电动后备箱',
            },
			ind_trunk : {
				required	: '<i class="icon-exclamation-sign"></i>感应后背箱',	
			},
			roof_rack : {
				required	: '<i class="icon-exclamation-sign"></i>车顶行李架',
			}, */
			abs : {
				required	: '<i class="icon-exclamation-sign"></i>abs防抱死',
			},
			ebd : {
				required	: '<i class="icon-exclamation-sign"></i>制动力分配'
			},
			/* bas : {
				required	: '<i class="icon-exclamation-sign"></i>刹车辅助系统'
			},
            asr : {
                required    : '<i class="icon-exclamation-sign"></i>牵引力控制',
            },
            esp : {
                required    : '<i class="icon-exclamation-sign"></i>车身稳定控制',
            },
            hac : {
                required    : '<i class="icon-exclamation-sign"></i>上坡辅助系统',
            },
            auto_hold : {
                required    : '<i class="icon-exclamation-sign"></i>自动驻车系统',
            },
            hdc : {
                required    : '<i class="icon-exclamation-sign"></i>陡坡缓降',               
            },
            avs : {
                required    : '<i class="icon-exclamation-sign"></i>可变悬架',
            },
            ecas : {
                required    : '<i class="icon-exclamation-sign"></i>空气悬架',
            },
			vgrs : {
				required	: '<i class="icon-exclamation-sign"></i>可变转向比',	
			},
			front_limit : {
				required	: '<i class="icon-exclamation-sign"></i>前桥防滑差速器/差速锁',
			},
			cent_diff_lock : {
				required	: '<i class="icon-exclamation-sign"></i>中央差速器锁止功能',
			},
			rear_limit : {
				required	: '<i class="icon-exclamation-sign"></i>后桥限滑差速器/差速锁'
			}, */
			dip_helight : {
				required	: '<i class="icon-exclamation-sign"></i>近光灯'
			},
            high_beam : {
                required    : '<i class="icon-exclamation-sign"></i>远光灯',
            },
           /*  drl : {
                required    : '<i class="icon-exclamation-sign"></i>日间行车灯',
            },
            dist_light : {
                required    : '<i class="icon-exclamation-sign"></i>自适应远近光',
            },
            auto_helamp : {
                required    : '<i class="icon-exclamation-sign"></i>自动头灯',
            },
            corn_lamp : {
                required    : '<i class="icon-exclamation-sign"></i>转向辅助灯',               
            },
            ste_helights : {
                required    : '<i class="icon-exclamation-sign"></i>转向头灯',
            },
            front_fog_lamp : {
                required    : '<i class="icon-exclamation-sign"></i>前雾灯',
            },
			helight_adjust : {
				required	: '<i class="icon-exclamation-sign"></i>大灯高度可调',	
			},
			lean_device : {
				required	: '<i class="icon-exclamation-sign"></i>大灯清洗装置',
			},
			atmos_lamp : {
				required	: '<i class="icon-exclamation-sign"></i>车内氛围灯',
			}, */
			
			
            /* power_wind : {
                required    : '<i class="icon-exclamation-sign"></i>后电动车窗',
            },
            anti_pin_func : {
                required    : '<i class="icon-exclamation-sign"></i>车窗防夹手功能',
            },
            heat_pro_gla : {
                required    : '<i class="icon-exclamation-sign"></i>防紫外线/隔热玻璃',
            },
            elec_control : {
                required    : '<i class="icon-exclamation-sign"></i>后视镜电动调节',
            },
            revw_mirr_heat : {
                required    : '<i class="icon-exclamation-sign"></i>后视镜加热',               
            },
            auto_glare : {
                required    : '<i class="icon-exclamation-sign"></i>内/外后视镜自动防眩目',
            },
            elec_fold_mirr : {
                required    : '<i class="icon-exclamation-sign"></i>后视镜电动折叠',
            },
			revw_mirr_my : {
				required	: '<i class="icon-exclamation-sign"></i>后视镜记忆',	
			},
			rear_win_sunshd : {
				required	: '<i class="icon-exclamation-sign"></i>后风挡遮阳帘',
			},
			rear_sd_sun_curt : {
				required	: '<i class="icon-exclamation-sign"></i>后排侧遮阳帘',
			},
			priv_glass : {
				required	: '<i class="icon-exclamation-sign"></i>后排侧隐私玻璃'
			},
			sun_visor : {
				required	: '<i class="icon-exclamation-sign"></i>遮阳板化妆镜'
			},
            rear_wiper : {
                required    : '<i class="icon-exclamation-sign"></i>后雨刷',
            },
            induc_wiper : {
                required    : '<i class="icon-exclamation-sign"></i>感应雨刷',
            }, */
			
			
           /*  auto_pa_ps : {
                required    : '<i class="icon-exclamation-sign"></i>自动泊车入位',
            },
            en_st_sp : {
                required    : '<i class="icon-exclamation-sign"></i>发动机启停技术',
            },
            auxiliary : {
                required    : '<i class="icon-exclamation-sign"></i>并线辅助',               
            },
            ldws : {
                required    : '<i class="icon-exclamation-sign"></i>车道偏离预警系统',
            },
            act_brake : {
                required    : '<i class="icon-exclamation-sign"></i>主动刹车/主动安全系统',
            },
			scr_display : {
				required	: '<i class="icon-exclamation-sign"></i>中控液晶屏分屏显示',	
			},
			ada_cruise : {
				required	: '<i class="icon-exclamation-sign"></i>自适应巡航',
			},
			pan_cam : {
				required	: '<i class="icon-exclamation-sign"></i>全景摄像头',
			}, */
			
			
			/* con_metd : {
				required	: '<i class="icon-exclamation-sign"></i>空调控制方式'
			},
			bac_row_air_cond : {
				required	: '<i class="icon-exclamation-sign"></i>后排独立空调'
			},
            rear_outlet : {
                required    : '<i class="icon-exclamation-sign"></i>后座出风口',
            },
            temp_zone_con : {
                required    : '<i class="icon-exclamation-sign"></i>温度分区控制',
            },
            pollen_filtra : {
                required    : '<i class="icon-exclamation-sign"></i>车内空气调节/花粉过滤',
            },
            car_refrig : {
                required    : '<i class="icon-exclamation-sign"></i>车载冰箱',
            },  */
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
