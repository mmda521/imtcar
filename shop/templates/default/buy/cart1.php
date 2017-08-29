<?php defined('InShopNC') or exit('Access Invalid!');?>
<style>
.ncc-table-style tbody tr.item_disabled td {
	background: none repeat scroll 0 0 #F9F9F9;
	height: 30px;
	padding: 10px 0;
	text-align: center;
}
</style>
<div class="ncc-main">
  <div class="ncc-title">
    <h3><?php echo $lang['cart_index_ensure_order'];?></h3>
    <h5>查看购物车商品清单，增加减少商品数量，并勾选想要的商品进入下一步操作。</h5>
  </div>
<?php
//print_r($output['store_cart_list']);
//break;



?>

<?php 
//$modeCount_0 = 0;
//$modeCount_1 = 0;
//$modeCount_2 = 0;
$modeCount_0 = array();
$modeCount_1 = array();
$modeCount_2 = array();
$shipperArr  = array();

 foreach($output['store_cart_list'] as $store_id => $cart_list) {


       foreach($cart_list as $cart_info) {
  $shipperArr = Model()->query("SELECT shipper_id FROM `718shop_shipper_kuajing_d` ");
  $shipperArr[]['shipper_id'] = '0';
          foreach($shipperArr as $shipper_id_arr) {
            $shipper_id = $shipper_id_arr['shipper_id'];

if($cart_info['is_mode'] == 0 && $cart_info['goods_shipper_id'] == $shipper_id){$modeCount_0[$store_id][$shipper_id] = $modeCount_0[$store_id][$shipper_id] + 1;}
else if($cart_info['is_mode'] == 1 && $cart_info['goods_shipper_id'] == $shipper_id){$modeCount_1[$store_id][$shipper_id] = $modeCount_1[$store_id][$shipper_id] + 1;}
else if($cart_info['is_mode'] == 2 && $cart_info['goods_shipper_id'] == $shipper_id){$modeCount_2[$store_id][$shipper_id] = $modeCount_2[$store_id][$shipper_id] + 1;}
            }

      }
    
  }
  //print_r($modeCount_0);
 //print_r($modeCount_1);
  //print_r($modeCount_2);
 //break;

?>
<?php 
$checked_string           = '';
$calc_cart_price_String   = '';
$next_submit_string       = '';
?>

  <?php for($is_mode=0;$is_mode<3;$is_mode++) { ?>
  <?php foreach($output['store_cart_list'] as $store_id => $cart_list) {?>

  <?php $shipperArr = Model()->query("SELECT shipper_id FROM `718shop_shipper_kuajing_d` "); 

$shipperArr[]['shipper_id'] = '0';

  //print_r($shipperArr);?>
  <?php foreach($shipperArr as $shipper_id_arr) {?>
    <?php //print_r($shipper_id_arr['shipper_id']);  ?>

  <?php 
    $shipper_id = $shipper_id_arr['shipper_id'];
    $modeCount = 'modeCount_'.$is_mode;
    //print_r(${$modeCount}[$store_id]);
    //print_r($cart_list);
    if (${$modeCount}[$store_id][$shipper_id] > 0) { 
  ?>
      
  <form action="<?php echo urlShop('buy','buy_step1');?>" method="POST" id="<?php echo 'form_buy'.$is_mode.'_'.$store_id.'_'.$shipper_id;?>" name="form_buy">
    <input type="hidden" value="1" name="ifcart">
    <table class="ncc-table-style" nc_type="<?php echo 'table_cart'.$is_mode.'_'.$store_id.'_'.$shipper_id;?>">
      <thead>
        <tr>
          <th class="w50"><label>
              <input type="checkbox" checked value="1" nc_type="eachGoodsCheckBox" id="<?php echo 'Checked'.$is_mode.'_'.$store_id.'_'.$shipper_id;?>">
              全选</label></th>
          <th></th>
          <th><?php echo $lang['cart_index_store_goods'];?></th>
          <th class="w120"><?php echo $lang['cart_index_price'].'('.$lang['currency_zh'].')';?></th>
          <th class="w120"><?php echo $lang['cart_index_amount'];?></th>
          <th class="w120"><?php echo $lang['cart_index_sum'].'('.$lang['currency_zh'].')';?></th>
          <th class="w80">税金</th>
          <th class="w80"><?php echo $lang['cart_index_handle'];?></th>
        </tr>
      </thead>
      <?php if ($is_mode==0) {?>
            <tr>
          <th class="w50"colspan="20" >一般贸易</th>
      </tr>
      <?php }else if ($is_mode==1) {?>
       <tbody>
            <tr>
          <th colspan="20">保税直购</th>
      </tr>
      <?php }else if ($is_mode==2) {?>
      <tbody>
            <tr>
          <th colspan="20"><font size="" color="">跨境直邮</font></th>
      </tr>
      <?php }?>

      <?php foreach($output['store_cart_list'] as $store_id => $cart_list) {?>
      <?php $is_count=0;?>
      <?php foreach($cart_list as $cart_info) {?>  
      <?php if($cart_info['is_mode'] == $is_mode && $is_count=='0' && $cart_info['goods_shipper_id'] == $shipper_id ){?>
      <?php $is_count=1;?>
      <tbody>
        <tr>
          <th colspan="20"><strong>店铺：<a href="<?php echo urlShop('show_store','index',array('store_id'=>$store_id), $output['store_list'][$store_id]['store_domain']);?>"><?php echo $cart_list[0]['store_name']; ?></a></strong> <span member_id="<?php echo $output['store_list'][$store_id]['member_id'];?>"></span>
            <?php if (!empty($output['free_freight_list'][$store_id])) {?>
            <div class="store-sale"><em><i class="icon-gift"></i>免运费</em><?php echo $output['free_freight_list'][$store_id];?>&emsp;</div>
            <?php } ?>
          </th>
        </tr>
		<!--gai满送列表显示在店铺下方-->
        <?php if (!empty($output['mansong_rule_list'][$store_id]) && is_array($output['mansong_rule_list'][$store_id])) {?>
        <tr nc_group="<?php echo $cart_info['cart_id'];?>" >
		    <td  colspan="2" style="vertical-align:middle;border-right:solid 1px #DDD;background-color:#E8F4FC;"><strong>店铺满即送活动</strong></td>
		    <td colspan="18" style="padding:0px;background-color:#E8F4FC;">
				<ul >
				  <?php foreach($output['mansong_rule_list'][$store_id] as $mansong_rule_list){//gai?>
					  <li style="text-align:left;padding:1px 20px;">
						  <div class="store-sale"><em> <i class="icon-gift"></i> 满即送(				
					<?php foreach($output['gc_list'] as $v =>$gc) {?>
                        <?php if($mansong_rule_list['mansong_gc_id']==$v) {?>
                            <?php echo $gc['gc_name'];?>
                            <?php }?>
                    <?php }?>				  
				  )-<?php echo $mansong_rule_list['desc'];?></em>&nbsp;:&nbsp;&nbsp;&nbsp;<?php echo $mansong_list['desc'];?></div>
					   </li>
				  <?php } ?>
			    </ul>
			</td>
        </tr>
        <?php }?>
<?php }}?>
        <!-- S one store list -->
        <?php foreach($cart_list as $cart_info) {?>
        <?php if($cart_info['is_mode'] == $is_mode && $cart_info['goods_shipper_id'] == $shipper_id) {?>
        <tr id="cart_item_<?php echo $cart_info['cart_id'];?>" selectV="<?php echo $is_mode.'_'.$store_id.'_'.$shipper_id;?>" nc_group="<?php echo $cart_info['cart_id'];?>" class="shop-list <?php echo $cart_info['state'] ? '' : 'item_disabled';?>">
          <td><input type="checkbox" <?php echo $cart_info['state'] ? 'checked' : 'disabled';?> nc_type="eachGoodsCheckBox" value="<?php echo $cart_info['cart_id'].'|'.$cart_info['goods_num'];?>" id="cart_id<?php echo $cart_info['cart_id'];?>" name="cart_id[]" ></td>
          <?php if ($cart_info['bl_id'] == '0') {?>
          <td class="w60"><a href="<?php echo urlShop('goods','index',array('goods_id'=>$cart_info['goods_id']));?>" target="_blank" class="ncc-goods-thumb"><img src="<?php echo thumb($cart_info,60);?>" alt="<?php echo $cart_info['goods_name']; ?>" /></a></td>
          <?php } ?>
          <td class="tl" <?php if ($cart_info['bl_id'] != '0') {?>colspan="2"<?php }?>><dl class="ncc-goods-info">
       <dt><a href="<?php echo urlShop('goods','index',array('goods_id'=>$cart_info['goods_id']));?>" target="_blank"><?php echo $cart_info['goods_name']."abc".$cart_info['is_mode']; ?></a></dt>
              <?php if (!empty($cart_info['xianshi_info'])) {?>
              <dd> <span class="xianshi">满<strong><?php echo $cart_info['xianshi_info']['lower_limit'];?></strong>件，单价直降<em>￥<?php echo $cart_info['xianshi_info']['down_price']; ?></em></span> </dd>
              <?php }?>
              <?php if ($cart_info['ifgroupbuy']) {?>
              <dd> <span class="groupbuy">抢购<?php if ($cart_info['upper_limit']) {?>，最多限购<strong><?php echo $cart_info['upper_limit']; ?></strong>件<?php } ?></span></dd>
              <?php }?>
              <?php if ($cart_info['bl_id'] != '0') {?>
              <dd><span class="buldling">优惠套装，单套直降<em>￥<?php echo $cart_info['down_price']; ?></em></span></dd>
              <?php }?>

              <!-- S gift list -->
              <?php if (!empty($cart_info['gift_list'])) {?>
              <dd><span class="ncc-goods-gift">赠</span>
                <ul class="ncc-goods-gift-list">
                  <?php foreach ($cart_info['gift_list'] as $goods_info) { ?>
                  <li nc_group="<?php echo $cart_info['cart_id'];?>"><a href="<?php echo urlShop('goods','index',array('goods_id'=>$goods_info['gift_goodsid']));?>" target="_blank" class="thumb" title="赠品：<?php echo $goods_info['gift_goodsname']; ?> * <?php echo $goods_info['gift_amount'] * $cart_info['goods_num']; ?>"><img src="<?php echo cthumb($goods_info['gift_goodsimage'],60,$store_id);?>" alt="<?php echo $goods_info['gift_goodsname']; ?>" /></a>
                    <?php } ?>
                  </li>
                </ul>
              </dd>
              <?php  } ?>
              <!-- E gift list -->
            </dl></td>
          <td class="w120"><em id="item<?php echo $cart_info['cart_id']; ?>_price"><?php echo $cart_info['goods_price']; ?></em></td>
          <?php if ($cart_info['state']) {?>
          <td class="w120 ws0"><a href="JavaScript:void(0);" onclick="decrease_quantity(<?php echo $cart_info['cart_id']; ?>);" title="<?php echo $lang['cart_index_reduse'];?>" class="add-substract-key tip">-</a>
            <input id="input_item_<?php echo $cart_info['cart_id']; ?>" value="<?php echo $cart_info['goods_num']; ?>" orig="<?php echo $cart_info['goods_num']; ?>" changed="<?php echo $cart_info['goods_num']; ?>" onkeyup="change_quantity(<?php echo $cart_info['cart_id']; ?>, this);" type="text" class="text w20"/>
            <a href="JavaScript:void(0);" onclick="add_quantity(<?php echo $cart_info['cart_id']; ?>);" title="<?php echo $lang['cart_index_increase'];?>" class="add-substract-key tip" >+</a></td>
          <?php } else {?>
          <td class="w120">无效
            <input type="hidden" value="<?php echo $cart_info['cart_id']; ?>" name="invalid_cart[]"></td>
          <?php }?>
          <td class="w120"><?php if ($cart_info['state']) {?>
            <em id="item<?php echo $cart_info['cart_id']; ?>_subtotal" nc_type="eachGoodsTotal"><?php echo $cart_info['goods_total']; ?></em>
            <?php }?></td>
          <td class="w120"><?php if ($cart_info['state']) {?>
            <em id="item<?php echo $cart_info['cart_id']; ?>_subtotal_tax" nc_type="eachGoodsTotal_tax"><?php echo $cart_info['goods_tax_total']; ?></em>
            <?php }?></td>  
          <td class="w80"><?php if ($cart_info['bl_id'] == '0') {?>
            <a href="javascript:void(0)" onclick="collect_goods('<?php echo $cart_info['goods_id']; ?>');"><?php echo $lang['cart_index_favorite'];?></a><br/>
            <?php } ?>
            <a href="javascript:void(0)" onclick="drop_cart_item(<?php echo $cart_info['cart_id']; ?>);"><?php echo $lang['cart_index_del'];?></a></td>
        </tr>
        <?php }?>

        <!-- S bundling goods list -->
        <?php if (is_array($cart_info['bl_goods_list'])) {?>
        <?php foreach ($cart_info['bl_goods_list'] as $goods_info) { ?>
        <tr class="shop-list <?php echo $cart_info['state'] ? '' : 'item_disabled';?>" nc_group="<?php echo $cart_info['cart_id'];?>">
          <td></td>
          <td class="w60"><a href="<?php echo urlShop('goods','index',array('goods_id'=>$goods_info['goods_id']));?>" target="_blank" class="ncc-goods-thumb"><img src="<?php echo cthumb($goods_info['goods_image'],60,$store_id);?>" alt="<?php echo $goods_info['goods_name']; ?>" /></a></td>
          <td class="tl"><dl class="ncc-goods-info">
              <dt><a href="<?php echo urlShop('goods','index',array('goods_id'=>$goods_info['goods_id']));?>" target="_blank"><?php echo $goods_info['goods_name']; ?></a> </dt>
            </dl></td>
          <td><em><?php echo $goods_info['bl_goods_price'];?></em></td>
          <td><?php echo $cart_info['state'] ? '' : '无效';?></td>
          <td></td>
          <td></td>
          <td><a href="javascript:void(0)" onclick="collect_goods('<?php echo $goods_info['goods_id']; ?>');"><?php echo $lang['cart_index_favorite'];?></a><br/></td>
        </tr>
        <?php } ?>
        <?php  } ?>
        <!-- E bundling goods list -->

        <?php } ?>
        <!-- E one store list -->

        <!-- S mansong list -->
	<!--gai  满送列表显示在商品下方
        <?php if (!empty($output['mansong_rule_list'][$store_id]) && is_array($output['mansong_rule_list'][$store_id])) {?>
        <tr nc_group="<?php echo $cart_info['cart_id'];?>">
		    <td colspan="20">
			  <ul >
				  <li style="display:inline;float:left;width:80px;"><strong><a href="<?php echo urlShop('show_store','index',array('store_id'=>$store_id), $output['store_list'][$store_id]['store_domain']);?>"><?php echo $cart_list[0]['store_name']; ?></a><br/>店铺活动</strong></li>

				  <?php foreach($output['mansong_rule_list'][$store_id] as $mansong_rule_list){//gai?>
				
				  <span>满即送(				
					<?php foreach($output['gc_list'] as $v =>$gc) {?>
                        <?php if($mansong_rule_list['mansong_gc_id']==$v) {?>
                            <?php echo $gc['gc_name'];?>
                            <?php }?>
                    <?php }?>				  
				  )-<?php echo $mansong_rule_list['desc'];?>
				</span>
			<?php } ?>
			   </ul>
			</td>
        </tr>
         <?php }?>-->
        <!-- E mansong list -->
        <?php foreach($cart_list as $cart_info) {?>
        <?php if($cart_info['is_mode'] == $is_mode && $is_count==0 && $cart_info['goods_shipper_id'] == $shipper_id) {?>
        <?php $is_count=1;?>
        <tr>
          <td class="tr" colspan="20"><div class="ncc-store-account">
              <dl>
                <dt>店铺合计：</dt>
                <dd><em nc_type="eachStoreTotal"></em><?php echo $lang['currency_zh'];?></dd>
              </dl>
            </div></td>
        </tr>
        <?php }}?>
         <?php }?>
        
      </tbody>
      <tfoot>
        <tr>
          <td colspan="20"><div class="ncc-all-account"><?php echo $lang['cart_index_goods_sumary'];?><em id="<?php echo 'cartTotal'.$is_mode.'_'.$store_id.'_'.$shipper_id;?>"><?php echo $output['cart_totals']; ?></em><?php echo $lang['currency_zh'];?></div></td>
        </tr>
      </tfoot>
    </table>
  </form>
  <div class="ncc-bottom"><a id="<?php echo 'next_submit'.$is_mode.'_'.$store_id.'_'.$shipper_id;?>" href="javascript:void(0)" class="ncc-btn ncc-btn-acidblue fr"><i class="icon-pencil"></i><?php echo $lang['cart_index_input_next'].$lang['cart_index_ensure_info'];?></a></div>

<?php $checked_string = $checked_string.'
$("#Checked'.$is_mode.'_'.$store_id.'_'.$shipper_id.'").click(function(){    
    if(this.checked){    
        $("[selectV=\''.$is_mode.'_'.$store_id.'_'.$shipper_id.'\']  :checkbox").attr("checked", true);   
    }else{    
        $("[selectV=\''.$is_mode.'_'.$store_id.'_'.$shipper_id.'\']  :checkbox").attr("checked", false); 
    }    
});';
 
  
  //总价计算
  $calc_cart_price_String = $calc_cart_price_String.'
  //每个店铺商品价格小计
    obj'.$is_mode.'_'.$store_id.'_'.$shipper_id.' = $(\'table[nc_type="table_cart'.$is_mode.'_'.$store_id.'_'.$shipper_id.'"]\');
    //购物车已选择商品的总价格
    var allTotal'.$is_mode.'_'.$store_id.'_'.$shipper_id.' = 0;
    obj'.$is_mode.'_'.$store_id.'_'.$shipper_id.'.children(\'tbody\').each(function(){
        //购物车每个店铺已选择商品的总价格
        var eachTotal = 0;
    var eachTotal_tax = 0;
        $(this).find(\'em[nc_type="eachGoodsTotal"]\').each(function(){
            if ($(this).parent().parent().find(\'input[type="checkbox"]\').eq(0).attr(\'checked\') != \'checked\') return;
            eachTotal = eachTotal + parseFloat($(this).html());  
        });
    $(this).find(\'em[nc_type="eachGoodsTotal_tax"]\').each(function(){
            if ($(this).parent().parent().find(\'input[type="checkbox"]\').eq(0).attr(\'checked\') != \'checked\') return;
            eachTotal_tax = eachTotal_tax + parseFloat($(this).html());  
        });
        allTotal'.$is_mode.'_'.$store_id.'_'.$shipper_id.' = allTotal'.$is_mode.'_'.$store_id.'_'.$shipper_id.' + eachTotal + eachTotal_tax;
        $(this).children(\'tr\').last().find(\'em[nc_type="eachStoreTotal"]\').eq(0).html(number_format(eachTotal,2));
    });
    $(\'#cartTotal'.$is_mode.'_'.$store_id.'_'.$shipper_id.'\').html(number_format(allTotal'.$is_mode.'_'.$store_id.'_'.$shipper_id.',2));';

    //提交按钮
    $next_submit_string = $next_submit_string.'
    $(\'#next_submit'.$is_mode.'_'.$store_id.'_'.$shipper_id.'\').on(\'click\',function(){
        if ($(document).find(\'input[nc_type="eachGoodsCheckBox"]:checked\').size() == 0) {
            showDialog(\'请选中要结算的商品\', \'error\',\'\',\'\',\'\',\'\',\'\',\'\',\'\',\'\',2);
            return false;
        }else {
            $(\'#form_buy'.$is_mode.'_'.$store_id.'_'.$shipper_id.'\').submit();
        }
    });';
?>
<?php }?>
<?php }?>
<?php }?>
<?php }?>
  <!-- 猜你喜欢 -->
  <div id="guesslike_div"></div>
</div>
<script type="text/javascript">
$(function(){
	//猜你喜欢
	$('#guesslike_div').load('<?php echo urlShop('search', 'get_guesslike', array()); ?>', function(){
        $(this).show();
    });
});
<?php echo $checked_string;?>
</script>
<script>
  /**
 * 删除购物车
 * @param cart_id
 */
function drop_cart_item(cart_id){
    var parent_tr = $('#cart_item_' + cart_id).parent();
    var amount_span = $('#cart_totals');
    showDialog('确认删除吗?', 'confirm', '', function(){
        $.getJSON('index.php?act=cart&op=del&cart_id=' + cart_id, function(result){
            if(result.state){
                //删除成功
                if(result.quantity == 0){//判断购物车是否为空
                    window.location.reload();    //刷新
                } else {
                  $('tr[nc_group="'+cart_id+'"]').remove();//移除本商品或本套装
                //if (parent_tr.children('tr').length == 2) {//只剩下店铺名头和店铺合计尾，则全部移除
                    //parent_tr.remove();
               // }
                calc_cart_price();
                }
            }else{
              alert(result.msg);
            }
        });     
    });
}

/**
 * 更改购物车数量
 * @param cart_id
 * @param input
 */
function change_quantity(cart_id, input){
    var subtotal = $('#item' + cart_id + '_subtotal');
    //暂存为局部变量，否则如果用户输入过快有可能造成前后值不一致的问题
    var _value = input.value;
    $.getJSON('index.php?act=cart&op=update&cart_id=' + cart_id + '&quantity=' + _value, function(result){
      $(input).attr('changed', _value);
      if(result.state == 'true'){
            $('#item' + cart_id + '_price').html(number_format(result.goods_price,2));
            subtotal.html(number_format(result.subtotal,2));
      $('#item' + cart_id + '_subtotal_tax').html(result.subtotal_tax,2);
            $('#cart_id'+cart_id).val(cart_id+'|'+_value);
        }

        if(result.state == 'invalid'){
          subtotal.html(0.00);
      $('#item' + cart_id + '_subtotal_tax').html(0.00);
          $('#cart_id'+cart_id).remove();
          $('tr[nc_group="'+cart_id+'"]').addClass('item_disabled');
          $(input).parent().next().html('');
          $(input).parent().removeClass('ws0').html('已下架');
          showDialog(result.msg, 'error','','','','','','','','',2);
          return;
        }

        if(result.state == 'shortage'){
          $('#item' + cart_id + '_price').html(number_format(result.goods_price,2));
          $('#cart_id'+cart_id).val(cart_id+'|'+result.goods_num);
          $(input).val(result.goods_num);
          showDialog(result.msg, 'error','','','','','','','','',2);
          return;
        }

        if(result.state == '') {
            //更新失败
          showDialog(result.msg, 'error','','','','','','','','',2);
            $(input).val($(input).attr('changed'));
        }
        calc_cart_price();
    });
}

/**
 * 购物车减少商品数量
 * @param cart_id
 */
function decrease_quantity(cart_id){
    var item = $('#input_item_' + cart_id);
    var orig = Number(item.val());
    if(orig > 1){
        item.val(orig - 1);
        item.keyup();
    }
}

/**
 * 购物车增加商品数量
 * @param cart_id
 */
function add_quantity(cart_id){
    var item = $('#input_item_' + cart_id);
    var orig = Number(item.val());
    item.val(orig + 1);
    item.keyup();
}

/**
 * 购物车商品统计
 */
function calc_cart_price() {
  <?php echo $calc_cart_price_String;?>
}


$(function(){
    calc_cart_price();
    $('#selectAll').on('click',function(){
        if ($(this).attr('checked')) {
            $('input[type="checkbox"]').attr('checked',true);
            $('input[type="checkbox"]:disabled').attr('checked',false);
        } else {
            $('input[type="checkbox"]').attr('checked',false);
        }
        calc_cart_price();
    });
    $('input[nc_type="eachGoodsCheckBox"]').on('click',function(){
        if (!$(this).attr('checked')) {
            $('#selectAll').attr('checked',false);
        }
        calc_cart_price();
    });
   <?php echo $next_submit_string;?>
});



</script>