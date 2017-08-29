<?php defined('InShopNC') or exit('Access Invalid!');?>

<ul>
  <?php foreach((array)$output['address_list'] as $k=>$val){ ?>
     <li class="receiver_add address_item <?php// echo $k == 0 ? 'ncc-selected-item' : null; ?>">
		<input address="<?php echo intval($val['dlyp_id']) ? '[自提服务站] ' : '';?><?php echo $val['area_info'].'&nbsp;'.$val['address']; ?>" true_name="<?php echo $val['true_name'];?>" id="addr_<?php echo $val['address_id']; ?>" nc_type="addr" type="radio" class="radio" city_id="<?php echo $val['city_id']?>" area_id=<?php echo $val['area_id'];?> name="addr" value="<?php echo $val['address_id']; ?>" phone="<?php echo $val['mob_phone'] ? $val['mob_phone'] : $val['tel_phone'];?>" <?php echo $val['is_default'] == '1' ? 'checked' : null; ?>" />
		<label for="addr_<?php echo $val['address_id']; ?>">
		  <span class="true-name"><?php echo $val['true_name'];?></span><br/>
		  <span class="address"><?php echo intval($val['dlyp_id']) ? '[自提服务站]' : '';?><?php echo $val['area_info']; ?></span><br/>
		  <span><?php echo $val['address']; ?></span><br/>
		  <span class="phone"><i class="icon-mobile-phone"></i><?php echo $val['mob_phone'] ? $val['mob_phone'] : $val['tel_phone'];?></span>
		</label>
		<a href="javascript:void(0);" onclick="delAddr(<?php echo $val['address_id']?>);" class="del">[ 删除 ]</a>
     </li>
  <?php } ?><br/>
  <li class="receive_add addr_item">
    <input value="0" nc_type="addr" id="add_addr" type="radio" name="addr">
    <label for="add_addr">使用新地址
		<?php if (C('delivery_isuse')) { ?>
		<!--使用自提服务站    echo urlShop('member_address','address'); <a class="del" href="" target="_blank">（包含自提地址）</a>-->
		<a class="del"  target="_blank">（包含自提地址）</a>
		<?php } ?>
	</label>
  </li>
  <div id="add_addr_box"><!-- 存放新增地址表单 --></div>
</ul>
<script type="text/javascript">
function delAddr(id){
    $('#addr_list').load(SITEURL+'/index.php?act=buy&op=load_addr&id='+id);
}
$(function(){
    $('input[nc_type="addr"]').on('click',function(){
        if ($(this).val() == '0') {
            $('#add_addr_box').load(SITEURL+'/index.php?act=buy&op=add_addr');
        } else {
            $('#add_addr_box').html('');
            if ($('input[nc_type="addr"]:checked').size() == 0) {
                return false;
            }
            var city_id = $('input[name="addr"]:checked').attr('city_id');
            var area_id = $('input[name="addr"]:checked').attr('area_id');
            var addr_id = $('input[name="addr"]:checked').val();
            var true_name = $('input[name="addr"]:checked').attr('true_name');
            var address = $('input[name="addr"]:checked').attr('address');
            var phone = $('input[name="addr"]:checked').attr('phone');
            showShippingPrice(city_id,area_id);
            hideAddrList(addr_id,true_name,area_id,address,phone);

        }
    });
});
</script>