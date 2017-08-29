<?php defined('InShopNC') or exit('Access Invalid!');?>

<div class="wrap">
  <div class="tabmenu">
    <?php include template('layout/submenu');?>
  </div>
  <form id="voucher_list_form" method="get">
    <table class="ncm-search-table">
      <input type="hidden" id='act' name='act' value='member_voucher' />
      <input type="hidden" id='op' name='op' value='donateList' />
      <tr>
        <td class="tr"><?php echo '代金券类型';?></td>
        <td class="w100 tr">
          <select name="donate">
            <option value="0" <?php if ($_GET['donate'] == '0'){echo 'selected=true';}?>><?php echo '接收'; ?> </option>
            <option value="1" <?php if ($_GET['donate'] == '1'){echo 'selected=true';}?>><?php echo '转赠'; ?> </option>
          </select></td>
        <td class="w70 tc"><label class="submit-border">
            <input type="submit" class="submit"  value="<?php echo $lang['nc_search'];?>" />
          </label></td>
      </tr>
    </table>
  </form>
  <table class="ncm-default-table">
    <thead>
      <tr>
        <th class="w10"></th>
        <th class="w70">代金券编码</th>
        <th class="w70">转赠者</th>
        <th class="w80">接收者</th>
        <th class="w80">面额（元）</th>
        <th class="w60">转赠时间</th>
      </tr>
    </thead>
    <tbody>
    <?php  if (count($output['list'])>0) { ?>
      <?php foreach($output['list'] as $key=> $val) { ?>
        <tr class="bd-line">
          <td></td>
          <td class="w70">
              <dt><?php echo $val['voucher_code'];?>
          </td>
          <td class="w70"><?php echo $val['donate_name']; ?></td>
          <td class="w70"><?php echo $val['accept_name']; ?></td>
          <td class="w80"><?php echo $val['voucher_price'];?></td>
          <td class="w60"><?php echo date("Y-m-d H:m:s",$val['add_time']);?></td>
        </tr>
      <?php }?>
    <?php } else { ?>
      <tr>
        <td colspan="20" class="norecord"><div class="warning-option"><i>&nbsp;</i><span><?php echo $lang['no_record'];?></span></div></td>
      </tr>
    <?php } ?>
    </tbody>
  </table>
</div>
<link type="text/css" rel="stylesheet" href="<?php echo RESOURCE_SITE_URL."/js/jquery-ui/themes/ui-lightness/jquery.ui.css";?>"/>
<script type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/js/jquery-ui/i18n/zh-CN.js" charset="utf-8" ></script>
<script type="text/javascript">
  $(document).ready(function(){
    $('#txt_startdate').datepicker();//日期
    $('#txt_enddate').datepicker();
  });
</script>
