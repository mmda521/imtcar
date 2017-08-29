<?php defined('InShopNC') or exit('Access Invalid!');?>
<!--v3-v12-->
<link href="<?php echo ADMIN_TEMPLATES_URL;?>/css/font/font-awesome/css/font-awesome.min.css" rel="stylesheet" />
<!--[if IE 7]>
  <link rel="stylesheet" href="<?php echo ADMIN_TEMPLATES_URL;?>/css/font/font-awesome/css/font-awesome-ie7.min.css">
<![endif]-->
<style type="text/css">
h3.dialog_head {
	margin: 0 !important;
}
.dialog_content {
	width: 610px;
	padding: 0 15px 15px 15px !important;
	overflow: hidden;
}
</style>

<script type="text/javascript">
var SHOP_SITE_URL = "<?php echo SHOP_SITE_URL; ?>";
var UPLOAD_SITE_URL = "<?php echo UPLOAD_SITE_URL; ?>";
</script>
<div class="page">
  <div class="fixed-bar">
    <div class="item-title">
      <h3><?php echo $lang['web_config_index'];?></h3>
      <ul class="tab-base">
        <li><a href="index.php?act=web_config&op=web_config"><span><?php echo '板块区';?></span></a></li>
        <li><a href="index.php?act=web_config&op=web_edit&web_id=<?php echo $_GET['web_id'];?>"><span><?php echo $lang['web_config_web_edit'];?></span></a></li>
        <li><a href="JavaScript:void(0);" class="current"><span><?php echo $lang['web_config_code_edit'];?></span></a></li>
      </ul>
    </div>
  </div>
  <div class="fixed-empty"></div>
  <table class="tb-type1 noborder">
    <tbody>
      <tr>
        <th><label><?php echo $lang['web_config_web_name'];?>:</label></th>
        <td><label><?php echo $output['web_array']['web_name']?></label></td>
        <th><label><?php echo $lang['web_config_style_name'];?>:</label></th>
        <td><label><?php echo $output['style_array'][$output['web_array']['style_name']];?></label></td>
      </tr>
    </tbody>
  </table>
  <table class="table tb-type2" id="prompt">
    <tbody>
      <tr class="space odd">
        <th colspan="12"><div class="title"><h5><?php echo $lang['nc_prompts'];?></h5><span class="arrow"></span></div></th>
      </tr>
      <tr>
        <td>
        <ul>
            <li><?php echo $lang['web_config_edit_help1'];?></li>
            <li><?php echo $lang['web_config_edit_help2'];?></li>
            <li><?php echo $lang['web_config_edit_help3'];?></li>
          </ul></td>
      </tr>
    </tbody>
  </table>
  <table class="table tb-type2 nohover">
    <tbody>
      <tr>
        <td colspan="2" class="required"><label><?php echo $lang['web_config_edit_html'].$lang['nc_colon'];?></label></td>
      </tr>
      <tr class="noborder"> 
        <td colspan="2" class="vatop"><div class="home-templates-board-layout style-<?php echo $output['web_array']['style_name'];?>">
            <div style="float:left; width:720px;">
            <div class="right" style="float: left">
            <div class="add-tab" id="btn_add_list"><a href="JavaScript:add_recommend();"><i class="icon-plus-sign-alt"></i><?php echo $lang['web_config_add_recommend'];?></a><?php echo $lang['web_config_recommend_max'];?></div>
              <div><?php if (is_array($output['code_recommend_list']['code_info']) && !empty($output['code_recommend_list']['code_info'])) { ?>
              <?php foreach ($output['code_recommend_list']['code_info'] as $key => $val) { ?>
              <dl recommend_id="<?php echo $key;?>">
                <dt>
                  <h4><?php echo $val['recommend']['name'];?></h4>
                  <a href="JavaScript:del_recommend(<?php echo $key;?>);"><i class="icon-remove-sign "></i><?php echo $lang['nc_del'];?></a>
                <a href="JavaScript:show_recommend_dialog(<?php echo $key;?>);"><i class="icon-shopping-cart"></i><?php echo '商品块';?></a>
                  </dt>
                <dd>
                    <?php if(!empty($val['goods_list']) && is_array($val['goods_list'])) { ?>
                    <ul class="goods-list">
                        <?php foreach($val['goods_list'] as $k => $v) { ?>
                        <li><span><a href="javascript:void(0);">
                            <img title="<?php echo $v['goods_name'];?>" src="<?php echo strpos($v['goods_pic'],'http')===0 ? $v['goods_pic']:UPLOAD_SITE_URL."/".$v['goods_pic'];?>"/></a></span>
                        </li>
                        <?php } ?>
                    </ul>
                    <?php } elseif (!empty($val['pic_list']) && is_array($val['pic_list'])) { ?>
                        <div class="middle-banner">
                            <a href="javascript:void(0);" class="left-a"><img pic_url="<?php echo $val['pic_list']['11']['pic_url'];?>" title="<?php echo $val['pic_list']['11']['pic_name'];?>" src="<?php echo UPLOAD_SITE_URL.'/'.$val['pic_list']['11']['pic_img'];?>"/></a>
                            <a href="javascript:void(0);" class="left-b"><img pic_url="<?php echo $val['pic_list']['12']['pic_url'];?>" title="<?php echo $val['pic_list']['12']['pic_name'];?>" src="<?php echo UPLOAD_SITE_URL.'/'.$val['pic_list']['12']['pic_img'];?>"/></a>
                            <a href="javascript:void(0);" class="middle-a"><img pic_url="<?php echo $val['pic_list']['14']['pic_url'];?>" title="<?php echo $val['pic_list']['14']['pic_name'];?>" src="<?php echo UPLOAD_SITE_URL.'/'.$val['pic_list']['14']['pic_img'];?>"/></a>
                            <a href="javascript:void(0);" class="right-a"><img pic_url="<?php echo $val['pic_list']['21']['pic_url'];?>" title="<?php echo $val['pic_list']['21']['pic_name'];?>" src="<?php echo UPLOAD_SITE_URL.'/'.$val['pic_list']['21']['pic_img'];?>"/></a>
                            <a href="javascript:void(0);" class="right-b"><img pic_url="<?php echo $val['pic_list']['24']['pic_url'];?>" title="<?php echo $val['pic_list']['24']['pic_name'];?>" src="<?php echo UPLOAD_SITE_URL.'/'.$val['pic_list']['24']['pic_img'];?>"/></a>
                            <a href="javascript:void(0);" class="bottom-a"><img pic_url="<?php echo $val['pic_list']['31']['pic_url'];?>" title="<?php echo $val['pic_list']['31']['pic_name'];?>" src="<?php echo UPLOAD_SITE_URL.'/'.$val['pic_list']['31']['pic_img'];?>"/></a>
                            <a href="javascript:void(0);" class="bottom-b"><img pic_url="<?php echo $val['pic_list']['32']['pic_url'];?>" title="<?php echo $val['pic_list']['32']['pic_name'];?>" src="<?php echo UPLOAD_SITE_URL.'/'.$val['pic_list']['32']['pic_img'];?>"/></a>
                            <a href="javascript:void(0);" class="bottom-c"><img pic_url="<?php echo $val['pic_list']['33']['pic_url'];?>" title="<?php echo $val['pic_list']['33']['pic_name'];?>" src="<?php echo UPLOAD_SITE_URL.'/'.$val['pic_list']['33']['pic_img'];?>"/></a>
                            <a href="javascript:void(0);" class="bottom-d"><img pic_url="<?php echo $val['pic_list']['34']['pic_url'];?>" title="<?php echo $val['pic_list']['34']['pic_name'];?>" src="<?php echo UPLOAD_SITE_URL.'/'.$val['pic_list']['34']['pic_img'];?>"/></a>
                        </div>
                    <?php }else { ?>
                    <ul class="goods-list">
                        <li><span><i class="icon-gift"></i></span></li>
                        <li><span><i class="icon-gift"></i></span></li>
                        <li><span><i class="icon-gift"></i></span></li>
                        <li><span><i class="icon-gift"></i></span></li>
                        <li><span><i class="icon-gift"></i></span></li>
                        <li><span><i class="icon-gift"></i></span></li>
                        <li><span><i class="icon-gift"></i></span></li>
                        <li><span><i class="icon-gift"></i></span></li>
                    </ul>
                    <?php } ?>
                </dd>
              </dl>
              <?php } ?>
              <?php } ?>
              
              </div>
            </div>
            </div>
			
			<!--V3-B12 楼层下面banner-->
			<div class="footer-banner">
              <dl id="banner_tit">
                <dt>
                  <h4><?php echo $lang['web_config_picture_banner'];?></h4>
                  <a href="JavaScript:show_dialog('upload_banner');"><i class="icon-picture"></i><?php echo $lang['nc_edit'];?></a>
                </dt>
                <dd class="banner-pic">
                  <div id="picture_banner" class="picture">
                    <?php if(!empty($output['code_act']['code_info']['pic'])) { ?>
                    <img src="<?php echo UPLOAD_SITE_URL.'/'.$output['code_banner']['code_info']['pic'];?>"/>
                    <?php } ?>
                  </div>
                </dd>
              </dl>
            </div>
			<!--V3-B12 楼层下面banner end-->
          </div>
		  </td>
      </tr>
    </tbody>
    <tfoot>
        <tr class="tfoot">
          <td colspan="2" ><a href="index.php?act=web_config&op=web_html&web_id=<?php echo $_GET['web_id'];?>" class="btn" id="submitBtn"><span><?php echo $lang['web_config_web_html'];?></span></a></td>
        </tr>
      </tfoot>
  </table>
</div>

<!-- 标题图片 -->

<!-- 推荐分类模块 -->
<!-- 活动图片 -->
<!-- 商品推荐模块 -->
<div id="recommend_list_dialog" style="display:none;">
  <form id="recommend_list_form">
    <input type="hidden" name="web_id" value="<?php echo $output['code_recommend_list']['web_id'];?>">
    <input type="hidden" name="code_id" value="<?php echo $output['code_recommend_list']['code_id'];?>">
    <div id="recommend_input_list" style="display:none;"><!-- 推荐拖动排序 --></div>
    <?php if (is_array($output['code_recommend_list']['code_info']) && !empty($output['code_recommend_list']['code_info'])) { ?>
    <?php foreach ($output['code_recommend_list']['code_info'] as $key => $val) { ?>
            <dl select_recommend_id="<?php echo $key;?>">
              <dt>
                <h4 class="dialog-handle-title"><?php echo $lang['web_config_recommend_title'];?></h4>
                <div class="dialog-handle-box"><span class="left">
                  <input name="recommend_list[<?php echo $key;?>][recommend][name]" value="<?php echo $val['recommend']['name'];?>" type="text" class="w200">
                  </span><span class="right"><?php echo $lang['web_config_recommend_tips'];?></span>
                  <div class="clear"></div>
                </div>
              </dt>
              <dd>
                <h4 class="dialog-handle-title"><?php echo $lang['web_config_recommend_goods'];?></h4>
                  <div class="s-tips"><i></i><?php echo $lang['web_config_recommend_goods_tips'];?></div>
                <ul class="dialog-goodslist-s1 goods-list">
                  <?php if(!empty($val['goods_list']) && is_array($val['goods_list'])) { ?>
                      <?php foreach($val['goods_list'] as $k => $v) { ?>
                      <li id="select_recommend_<?php echo $key;?>_goods_<?php echo $k;?>">
                        <div ondblclick="del_recommend_goods(<?php echo $v['goods_id'];?>);" class="goods-pic">
                        <span class="ac-ico" onclick="del_recommend_goods(<?php echo $v['goods_id'];?>);"></span> <span class="thumb size-72x72"><i></i><img select_goods_id="<?php echo $v['goods_id'];?>" title="<?php echo $v['goods_name'];?>" src="<?php echo strpos($v['goods_pic'],'http')===0 ? $v['goods_pic']:UPLOAD_SITE_URL."/".$v['goods_pic'];?>" onload="javascript:DrawImage(this,72,72);" /></span></div>
                        <div class="goods-name"><a href="<?php echo SHOP_SITE_URL."/index.php?act=goods&goods_id=".$v['goods_id'];?>" target="_blank"><?php echo $v['goods_name'];?></a></div>
                        <input name="recommend_list[<?php echo $key;?>][goods_list][<?php echo $v['goods_id'];?>][goods_id]" value="<?php echo $v['goods_id'];?>" type="hidden">
                        <input name="recommend_list[<?php echo $key;?>][goods_list][<?php echo $v['goods_id'];?>][market_price]" value="<?php echo $v['market_price'];?>" type="hidden">
                        <input name="recommend_list[<?php echo $key;?>][goods_list][<?php echo $v['goods_id'];?>][goods_name]" value="<?php echo $v['goods_name'];?>" type="hidden">
                        <input name="recommend_list[<?php echo $key;?>][goods_list][<?php echo $v['goods_id'];?>][goods_price]" value="<?php echo $v['goods_price'];?>" type="hidden">
                        <input name="recommend_list[<?php echo $key;?>][goods_list][<?php echo $v['goods_id'];?>][goods_pic]" value="<?php echo $v['goods_pic'];?>" type="hidden">
                      </li>
                      <?php } ?>
                  <?php } elseif (!empty($val['pic_list']) && is_array($val['pic_list'])) { ?>
                      <?php foreach($val['pic_list'] as $k => $v) { ?>
                      <li id="select_recommend_<?php echo $key;?>_pic_<?php echo $k;?>" style="display:none;">
                        <input name="recommend_list[<?php echo $key;?>][pic_list][<?php echo $v['pic_id'];?>][pic_id]" value="<?php echo $v['pic_id'];?>" type="hidden">
                        <input name="recommend_list[<?php echo $key;?>][pic_list][<?php echo $v['pic_id'];?>][pic_name]" value="<?php echo $v['pic_name'];?>" type="hidden">
                        <input name="recommend_list[<?php echo $key;?>][pic_list][<?php echo $v['pic_id'];?>][pic_url]" value="<?php echo $v['pic_url'];?>" type="hidden">
                        <input name="recommend_list[<?php echo $key;?>][pic_list][<?php echo $v['pic_id'];?>][pic_img]" value="<?php echo $v['pic_img'];?>" type="hidden">
                      </li>
                      <?php } ?>
                  <?php } ?>
                </ul>
              </dd>
            </dl>
    <?php } ?>
    <?php } ?>
    <div id="add_recommend_list" style="display:none;"></div>
    <h4 class="dialog-handle-title"><?php echo $lang['web_config_recommend_add_goods'];?></h4>
    <div class="dialog-show-box">
    <table class="tb-type1 noborder search">
      <tbody>
        <tr>
          <th><label><?php echo $lang['web_config_recommend_gcategory'];?></label></th>
          <td class="dialog-select-bar" id="recommend_gcategory">
		        <input type="hidden" id="cate_id" name="cate_id" value="0" class="mls_id" />
		        <input type="hidden" id="cate_name" name="cate_name" value="" class="mls_names" />
		        <select>
		          <option value="0">-<?php echo $lang['nc_please_choose'];?>-</option>
		          <?php if(!empty($output['goods_class']) && is_array($output['goods_class'])) { ?>
		          <?php foreach($output['goods_class'] as $k => $v) { ?>
		          <option value="<?php echo $v['gc_id'];?>"><?php echo $v['gc_name'];?></option>
		          <?php } ?>
		          <?php } ?>
		        </select>
		      </td>
        </tr>
        <tr>
          <th><label for="recommend_goods_name"><?php echo $lang['web_config_recommend_goods_name'];?></label></th>
          <td><input type="text" value="" name="recommend_goods_name" id="recommend_goods_name" class="txt">
		        <a href="JavaScript:void(0);" onclick="get_recommend_goods();" class="btn-search " title="<?php echo $lang['nc_query'];?>"></a>
          	</td>
        </tr>
      </tbody>
    </table>
      <div id="show_recommend_goods_list" class="show-recommend-goods-list"></div>
      <div class="clear"></div>
    </div>
    <div class="clear"></div>
    <a href="JavaScript:void(0);" onclick="update_recommend();" class="btn"><span><?php echo $lang['web_config_save'];?></span></a>
  </form>
</div>
<!-- 中部推荐图片 -->

<!-- 品牌模块 -->

<!-- 切换广告图片 -->


<!-- 热卖促销模块 -->


<!-- 楼层横幅 -->
<div id="upload_banner_dialog" class="upload_banner_dialog" style="display:none;">
  <table class="table tb-type2">
    <tbody>
      <tr class="space odd" id="prompt">
        <th class="nobg" colspan="12"><div class="title">
            <h5><?php echo $lang['nc_prompts'];?></h5>
            <span class="arrow"></span></div></th>
      </tr>
      <tr>
        <td><ul>
            <li><?php echo $lang['web_config_prompt_banner'];?></li>
          </ul></td>
      </tr>
    </tbody>
  </table>
  <form id="upload_banner_form" name="upload_banner_form" enctype="multipart/form-data" method="post" action="index.php?act=web_api&op=upload_pic" target="upload_pic">
    <input type="hidden" name="form_submit" value="ok" />
    <input type="hidden" name="web_id" value="<?php echo $output['code_banner']['web_id'];?>">
    <input type="hidden" name="code_id" value="<?php echo $output['code_banner']['code_id'];?>">
    <input type="hidden" name="banner[pic]" value="<?php echo $output['code_banner']['code_info']['pic'];?>">
    <input type="hidden" name="banner[type]" value="pic">
    <table class="table tb-type2" id="upload_act_type_pic" <?php if($output['code_banner']['code_info']['type'] == 'adv') { ?>style="display:none;"<?php } ?>>
      <tbody>
        <tr>
          <td colspan="2" class="required"><?php echo $lang['web_config_banner_tit'].$lang['nc_colon'];?></td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform">
            <input class="txt" type="text" name="banner[title]" value="<?php echo $output['code_banner']['code_info']['title'];?>">
            </td>
          <td class="vatop tips"><?php echo '';?></td>
        </tr>
        <tr>
          <td colspan="2" class="required"><label><?php echo $lang['web_config_upload_url'].$lang['nc_colon'];?></label></td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform"><input name="banner[url]" value="<?php echo !empty($output['code_banner']['code_info']['url']) ? $output['code_banner']['code_info']['url']:SHOP_SITE_URL;?>" class="txt" type="text"></td>
          <td class="vatop tips"><?php echo $lang['web_config_upload_act_url'];?></td>
        </tr>
        <tr>
          <td colspan="2" class="required"><label><?php echo $lang['web_config_upload_act'].$lang['nc_colon'];?></label></td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform"><span class="type-file-box">
            <input type='text' name='textfield' id='textfield1' class='type-file-text' />
            <input type='button' name='button' id='button1' value='' class='type-file-button' />
            <input name="pic" id="pic" type="file" class="type-file-file" size="30">
            </span></td>
          <td class="vatop tips"><?php echo $lang['web_config_upload_banner_tips'];?></td>
        </tr>
                <tr>
          <td colspan="2" class="required"><label><?php echo $lang['nc_display'];?>:</label></td>
        </tr>
        
        <tr class="noborder">
          <td class="vatop rowform onoff"><label for="show1" class="cb-enable <?php if($output['code_banner']['code_info']['show'] == '1'){ ?>selected<?php } ?>" title="<?php echo $lang['nc_yes'];?>"><span><?php echo $lang['nc_yes'];?></span></label>
            <label for="show0" class="cb-disable <?php if($output['code_banner']['code_info']['show'] == '0'){ ?>selected<?php } ?>" title="<?php echo $lang['nc_no'];?>"><span><?php echo $lang['nc_no'];?></span></label>
            <input id="show1" name="banner[show]" <?php if($output['code_banner']['code_info']['show'] == '1'){ ?>checked="checked"<?php } ?>  value="1" type="radio">
            <input id="show0" name="banner[show]" <?php if($output['code_banner']['code_info']['show'] == '0'){ ?>checked="checked"<?php } ?> value="0" type="radio"></td>
          <td class="vatop tips"></td>
        </tr>
        
        
        
      </tbody>
    </table>
    <a href="JavaScript:void(0);" onclick="$('#upload_banner_form').submit();" class="btn"><span><?php echo $lang['nc_submit'];?></span></a>
  </form>
  <script>
$(document).ready( function(){ 
	$(".cb-enable").click(function(){
		var parent = $(this).parents('.onoff');
		$('.cb-disable',parent).removeClass('selected');
		$(this).addClass('selected');
		$('.checkbox',parent).attr('checked', true);
	});
	$(".cb-disable").click(function(){
		var parent = $(this).parents('.onoff');
		$('.cb-enable',parent).removeClass('selected');
		$(this).addClass('selected');
		$('.checkbox',parent).attr('checked', false);
	});
});
</script>
</div>
<iframe style="display:none;" src="" name="upload_pic"></iframe>
<script src="<?php echo RESOURCE_SITE_URL;?>/js/jquery.ajaxContent.pack.js"></script>
<script src="<?php echo RESOURCE_SITE_URL;?>/js/jquery-ui/jquery.ui.js"></script>
<script src="<?php echo RESOURCE_SITE_URL;?>/js/dialog/dialog.js" id="dialog_js"></script>
<script src="<?php echo RESOURCE_SITE_URL;?>/js/common_select.js"></script>
<script src="<?php echo RESOURCE_SITE_URL;?>/js/jquery.mousewheel.js"></script>
<script src="<?php echo RESOURCE_SITE_URL;?>/js/waypoints.js"></script>
<script src="<?php echo RESOURCE_SITE_URL;?>/web_config/web_index.js"></script>
