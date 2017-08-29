<?php defined('InShopNC') or exit('Access Invalid!');?>

<div class="eject_con">
  <div class="adds">
    <div id="warning"></div>
    <form method="post" action="index.php?act=store_deliver&op=STOPush&order_id=<?php echo $_GET['order_id'];?>" id="sto_form" target="_parent">
      <input type="hidden" name="form_submit" value="ok" />
      <dl>
        <dt class="required">总单号</dt>
        <dd>
          <input type="text" class="text" name="totalLogisticsNo" id="totalLogisticsNo" value=""/>
        </dd>
      </dl>
      <dl>
        <dt class="required">进/出境日期</dt>
        <dd>
          <input type="text" class="text" name="jcbOrderTime" id="jcbOrderTime" value=""/>
        </dd>
      </dl>
      <dl>
        <dt class="required">进/出境口岸(关)</dt>
        <dd>
          <input type="text" class="text" name="jcbOrderPort" id="jcbOrderPort" value=""/>
        </dd>
      </dl>
      <dl>
        <dt class="required">进/出境口岸(检)</dt>
        <dd>
          <input type="text" class="text" name="jcbOrderPortInsp" id="jcbOrderPortInsp" value=""/>
        </dd>
      </dl>
      <div class="bottom"><label class="submit-border"><a href="javascript:void(0);" id="submit" class="submit">发送</a></label></div>
    </form>
  </div>
</div>
<script type="text/javascript">
$(document).ready(function(){
    $('#sto_form').validate({
        rules : {
            totalLogisticsNo : {
                required : true
            },
            jcbOrderTime : {
                required : true
            },
            jcbOrderPort : {
                required : true
            },
            jcbOrderPortInsp : {
                required : true
            }
        },
        messages : {
            totalLogisticsNo: {
                required : '<i class="icon-exclamation-sign"></i>总单号不能为空'
            },
            jcbOrderTime: {
                required : '<i class="icon-exclamation-sign"></i>进/出境日期不能为空'
            },
            jcbOrderPort: {
                required : '<i class="icon-exclamation-sign"></i>进/出境口岸(关)不能为空'
            },
            jcbOrderPortInsp: {
                required : '<i class="icon-exclamation-sign"></i>进/出境口岸(检)不能为空'
            }
        }
    });
	$('#submit').on('click',function(){
		if ($('#sto_form').valid()) {
            var reciver_totalLogisticsNo = $('#totalLogisticsNo').val();
            var reciver_jcbOrderTime = $('#jcbOrderTime').val();
            var reciver_jcbOrderPort = $('#jcbOrderPort').val();
            var reciver_jcbOrderPortInsp = $('#jcbOrderPortInsp').val();

            $.post(
            "<?php echo urlShop('store_deliver', 'STOPush');?>", 
            {
                order_id: <?php echo $_GET['order_id'];?>,
                reciver_totalLogisticsNo: reciver_totalLogisticsNo,
                reciver_jcbOrderTime: reciver_jcbOrderTime,
                reciver_jcbOrderPort: reciver_jcbOrderPort,
                reciver_jcbOrderPortInsp: reciver_jcbOrderPortInsp
            })
            .done(function(data) {
                document.write("糟糕！文档消失了。");
                } else {
                    showError('报文发送失败');
                }
            });
		}
	});

});
</script>
