
<?php defined('InShopNC') or exit('Access Invalid!');?>

<div class="page">
  <div class="fixed-bar">
    <div class="item-title">
      <h3>平台参数编辑</h3>
      <ul class="tab-base">
        <li><a href="index.php?act=kuajing_packing&op=index" ><span>管理</span></a></li>
        <li><a href="index.php?act=kuajing_packing&op=add"><span><?php echo $lang['nc_new'];?></span></a></li>
		<li><a href="JavaScript:void(0);" class="current"><span><?php echo $lang['nc_edit'];?></span></a></li>
      </ul>
    </div>
  </div>
  <div class="fixed-empty"></div>
  <form id="grade_form" name="grade_form" method="post" action="index.php?act=kuajing_packing&op=edit_save">
    <input type="hidden" name="packing_id" value="ok" />
	<input type="hidden" name="packing_id" value="<?php echo $output['result']['packing_id'];?>" />
    <table class="table tb-type2">
      <tbody>
        <tr class="noborder">
          <td colspan="2" class="required"><label class="validation" for="packing_name">包装方式名称:</label></td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform"><input type="text" value="<?php echo $output['result']['packing_name']?>" id="packing_name" name="packing_name" maxlength="50" class="txt"></td>
          <td class="vatop tips"></td>
        </tr>
       <tr class="noborder">
          <td colspan="2" class="required"><label class="validation" for="code_guan">海关代码:</label></td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform"><input type="text" value="<?php echo $output['result']['code_guan']?>" id="code_guan" name="code_guan" maxlength="10" class="txt"></td>
          <td class="vatop tips"></td>
        </tr>
        <tr class="noborder">
          <td colspan="2" class="required"><label class="validation" for="code_jian">国检代码:</label></td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform"><input type="text" value="<?php echo $output['result']['code_jian']?>" id="code_jian" name="code_jian" maxlength="10"class="txt"></td>
          <td class="vatop tips"></td>
        </tr>
       
      </tbody>
      <tfoot>
        <tr class="tfoot">
          <td colspan="15"><a href="JavaScript:void(0);" class="btn" id="submitBtn2" type="submit"><span><?php echo $lang['nc_submit'];?></span></a></td>
        </tr>
      </tfoot>
    </table>
  </form>
</div>
<script type="text/javascript">
$(function(){$("#submitBtn2").click(function(){
    if($("#grade_form").valid()){
       $("#grade_form").submit();
	}
	});
});
$(document).ready(function(){
    $('#grade_form').validate({
		errorPlacement: function(error, element){
			error.appendTo(element.parent().parent().prev().find('td:first'));
        },

        rules : {
      packing_name:{
        required : true
      },
        code_guan:{
        required : true
      },
      code_jian:{
        required : true
      }
        },
        messages : {
            packing_name: {
                required : '<?php echo '请输入包装方式名称';?>'

            },
            code_guan: {
                required : '<?php echo '请输入海关代码';?>'

            },
            code_jian: {
                required : '<?php echo '请输入国检代码';?>'

            }
        },
      
    });
		
});

</script>

