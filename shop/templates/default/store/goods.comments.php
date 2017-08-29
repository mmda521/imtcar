<?php defined('InShopNC') or exit('Access Invalid!');?>
<?php if(!empty($output['goodsevallist']) && is_array($output['goodsevallist'])){?>
<?php foreach($output['goodsevallist'] as $k=>$v){?>
<div id="t" class="ncs-commend-floor">
    <div class="user-avatar">
        <a <?php if($v['geval_isanonymous'] == "1注释掉不等于1"){?>href="index.php?act=member_snshome&mid=<?php echo $v['geval_frommemberid'];?>" target="_blank" data-param="{'id':<?php echo $v['geval_frommemberid'];?>}" nctype="mcard"<?php }?>> 
            <img src="<?php echo getMemberAvatarForID($v['geval_frommemberid']);?>">
        </a>
    </div>
  <dl class="detail">
      <dt>
      <span class="user-name">
       <!--
       <a href="index.php?act=member_snshome&mid=<?php //echo $v['geval_frommemberid'];?>" target="_blank" data-param="{'id':<?php //echo $v['geval_frommemberid'];?>" nctype="mcard"></a>
       -->
       <?php echo hideStar($v['geval_frommembername']);?>
      </span>
      <time pubdate="pubdate">[<?php echo @date('Y-m-d',$v['geval_addtime']);?>]</time>
    </dt>
    <dd>用户评分：<span class="raty" data-score="<?php echo $v['geval_scores'];?>"></span></dd>
    <dd class="content">评价详情：<span><?php echo $v['geval_content'];?></span></dd>
    <?php if (!empty($v['geval_explain'])){?>
    <dd class="explain"><?php echo $lang['nc_credit_explain'];?>：<span><?php echo $v['geval_explain'];?></span></dd>
    <?php } ?>
    <?php if(!empty($v['geval_image'])) {?>
    <dd>
    晒单图片：
    <ul class="photos-thumb"><?php $image_array = explode(',', $v['geval_image']);?>
        <?php foreach ($image_array as $value) { ?>
        <li><a nctype="nyroModal"  href="<?php echo snsThumb($value, 1024);?>">
            <img src="<?php echo snsThumb($value);?>">
        </a></li>
        <?php } ?></ul>
    </dd>
    <?php } ?>
  </dl>
</div>
<?php }?>
<div class="tr pr5 pb5 pr">
  <a href="<?php echo urlShop('goods', 'comments_list', array('goods_id' => $_GET['goods_id']));?>" target="_blank" class="more-commend">查看全部评价>></a><div class="pagination"> <?php echo $output['show_page'];?></div>
</div>
<?php }else{?>
<div class="ncs-norecord"><?php echo $lang['no_record'];?></div>
<?php }?>
<?php function hideStar($str) { //用户名、邮箱、手机账号中间字符串以*隐藏。 用户名隐藏函数。
	    $rs = mb_substr($str, 0, 1, 'utf-8') . "***" . mb_substr($str, -1, 1,'utf-8'); 
		return $rs;
}?>
<script type="text/javascript">
$(document).ready(function(){
   $('.raty').raty({
        path: "<?php echo RESOURCE_SITE_URL;?>/js/jquery.raty/img",
        readOnly: true,
        score: function() {
          return $(this).attr('data-score');
        }
    });

   $('a[nctype="nyroModal"]').nyroModal();

    $('#goodseval').find('.demo').ajaxContent({
        event:'click', //mouseover
        loaderType:"img",
        loadingMsg:"<?php echo SHOP_TEMPLATES_URL;?>/images/transparent.gif",
        target:'#goodseval'
    });
});
</script> 
