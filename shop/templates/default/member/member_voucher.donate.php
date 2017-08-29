<?php defined('InShopNC') or exit('Access Invalid!');?>

<div class="wrap">
  <div class="tabmenu">
    <?php include template('layout/submenu');?>
  </div>
  <form id="voucher_list_form" method="get">
    <table class="ncm-search-table">
      <input type="hidden" id='act' name='act' value='member_voucher' />
      <input type="hidden" id='op' name='op' value='voucher_list' />
      <tr>
        <td>&nbsp;</td>
        <td class="w100 tr"><select name="select_detail_state">
            <option value="0" <?php if (!$_GET['select_detail_state'] == '0'){echo 'selected=true';}?>> <?php echo $lang['voucher_voucher_state']; ?> </option>
            <?php if (!empty($output['voucherstate_arr'])){?>
            <?php foreach ($output['voucherstate_arr'] as $k=>$v){?>
            <option value="<?php echo $k;?>" <?php if ($_GET['select_detail_state'] == $k){echo 'selected=true';}?>> <?php echo $v;?> </option>
            <?php }?>
            <?php }?>
          </select></td>
        <td class="w70 tc"><label class="submit-border">
            <input type="submit" class="submit" onclick="submit_search_form()" value="<?php echo $lang['nc_search'];?>" />
          </label></td>
      </tr>
    </table>
  </form>
  <table class="ncm-default-table">
    <thead>
      <tr>
        <th class="w10"></th>
        <th class="w70"></th>
        <th class="tl">代金券编码</th>
        <th class="w80">面额（元）</th>
        <th class="w200"><?php echo $lang['voucher_voucher_indate'];?></th>
        <th class="w60"><?php echo $lang['voucher_voucher_state'];?></th>
      </tr>
    </thead>
    <?php //var_dump($output['list']);?>
    <tbody>
      <?php  if (count($output['list'])>0) { ?>
      <tr class="bd-line">
        <td></td>
        <td><div class="ncm-goods-thumb"><a href="javascript:void(0);"><img src="<?php echo $output['list']['voucher_t_customimg'];?>" onMouseOver="toolTip('<img src=<?php echo $output['list']['voucher_t_customimg'];?>>')" onMouseOut="toolTip()" /></a></div></td>
        <td class="tl"><dl class="goods-name">
            <dt><?php echo $output['list']['voucher_code'];?></dt>
            <dd><a href="<?php echo urlShop('show_store', 'index', array('store_id'=>$output['list']['voucher_store_id']));?>" title="<?php echo $lang['voucher_voucher_storename'];?>"><?php echo $output['list']['voucher_store_name'];?></a>（<?php echo $lang['voucher_voucher_usecondition'];?>：<?php echo $lang['voucher_voucher_usecondition_desc'].$output['list']['voucher_limit'].$lang['currency_zh'];?>）</dd>
          </dl></td>
        <td class="goods-price"><?php echo $output['list']['voucher_price'];?></td>
		<?php $end=$output['list']['voucher_end_date']-3600*24*1;?>
        <td class="goods-time"><?php echo date("Y-m-d",$output['list']['voucher_start_date']).'~'.date("Y-m-d",$end);?></td>
        <td ><?php echo $output['list']['voucher_state_text'];?></td>

      </tr>
      <?php } else { ?>
      <tr>
        <td colspan="20" class="norecord"><div class="warning-option"><i>&nbsp;</i><span><?php echo $lang['no_record'];?></span></div></td>
      </tr>
      <?php } ?>
    </tbody>
  </table>
  <div class="ncsc-form-default">
    <form method="post" action="index.php?act=member_voucher&op=donaten" id="myform" name="myform">
    <input type="hidden" id="tid" name="tid" value="<?php echo $_GET['voucher_id']?>">
    <div class="normal">
      <?php echo '好友id:'; ?></dt><input type="text" class="w200 text" id="member_id" name="member_id">
      <div class="bottom">
        <td>&nbsp;&nbsp;</td>
        <td>&nbsp;&nbsp;</td>
        <td>&nbsp;&nbsp;&nbsp;&nbsp;<th><input id='btn_add' type="submit" class="submit" value="<?php echo $lang['nc_submit'];?>" /></th></td>

      </div>
    </div>
  </form>
    </div>
</div>
