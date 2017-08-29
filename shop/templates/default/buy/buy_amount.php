<?php defined('InShopNC') or exit('Access Invalid!');?>
<div class="ncc-bottom"> <a href="javascript:void(0)" id='submitOrder' class="ncc-btn ncc-btn-acidblue fr"><?php echo $lang['cart_index_submit_order'];?></a> </div>
<script>
function submitNext(){
	if (!SUBMIT_FORM) return;

	if ($('input[name="cart_id[]"]').size() == 0) {
		showDialog('所购商品无效', 'error','','','','','','','','',2);
		return;
	}
    if ($('#address_id').val() == ''){
		showDialog('<?php echo $lang['cart_step1_please_set_address'];?>', 'error','','','','','','','','',2);
		return;
	}
	//xinzeng
    if($('#area_id').html()=='45058'&&$('input[name="is_mode"]').val() != 0){
		showDialog('跨境商品不支持自提，请重新选择收货地址','error','','','','','','','','',5);
		return;
	}
	
	if ($('#buy_city_id').val() == '') {
		showDialog('有商品不支持该地区的配送,请返回重新选择商品', 'error','','','','','','','','',2);
		return;
	}
	if (($('input[name="pd_pay"]').attr('checked') || $('input[name="rcb_pay"]').attr('checked')) && $('#password_callback').val() != '1') {
		showDialog('使用充值卡/预存款支付，需输入支付密码并使用  ', 'error','','','','','','','','',2);
		return;
	}
	if ($('input[name="fcode"]').size() == 1 && $('#fcode_callback').val() != '1') {
		showDialog('请输入并使用F码', 'error','','','','','','','','',2);
		return;
	}
    if ($('#goodstotal').text() > 2000 && $('input[name="is_mode"]').val() != 0){
		showDialog('跨境商品单个订单不能超过2000元', 'error','','','','','','','','',2);
		return;
	}

	SUBMIT_FORM = false;

	$('#order_form').submit();
}
$(function(){
    $(document).keydown(function(e) {
        if (e.keyCode == 13) {
        	submitNext();
        	return false;
        }
    });
	//$('#submitOrder').on('click',function(){submitNext();history.go(-1);setTimeout("location.replace(document.referrer)",1000)});
	$('#submitOrder').on('click',function(){submitNext()});
	calcOrder();

});

</script>