<?php defined('InShopNC') or exit('Access Invalid!');?> 
<style type="text/css">
#box { background: #FFF; width: 238px; height: 410px; margin: -390px 0 0 0; display: block; border: solid 4px #D93600; position: absolute; z-index: 999; opacity: .5 }
#infscr-loading { display: none; }
</style>
<script src="<?php echo SHOP_RESOURCE_SITE_URL.'/js/search_goods.js';?>"></script>
<link href="<?php echo SHOP_TEMPLATES_URL;?>/css/layout.css" rel="stylesheet" type="text/css">
<!--
<link href="./郑欧商城-国家馆详情页0_files/home_header.css" rel="stylesheet" type="text/css">
<link href="./郑欧商城-国家馆详情页0_files/font-awesome.min.css" rel="stylesheet">
<link href="./郑欧商城-国家馆详情页0_files/global.css" rel="stylesheet">
<link href="./郑欧商城-国家馆详情页0_files/mini_login.css" rel="stylesheet">
-->
<link href="./郑欧商城-国家馆详情页0_files/promotion.css" rel="stylesheet">
<link href="./郑欧商城-国家馆详情页0_files/promotionfloor.css" rel="stylesheet">
<!--
<script src="./郑欧商城-国家馆详情页0_files/jquery.js"></script>
<script src="./郑欧商城-国家馆详情页0_files/common.js" charset="utf-8"></script>
<script src="./郑欧商城-国家馆详情页0_files/jquery.ui.js"></script>
<script src="./郑欧商城-国家馆详情页0_files/jquery.validation.min.js"></script>
<script src="./郑欧商城-国家馆详情页0_files/jquery.masonry.js"></script>
<script src="./郑欧商城-国家馆详情页0_files/dialog.js" id="dialog_js" charset="utf-8"></script><link href="./郑欧商城-国家馆详情页0_files/dialog.css" rel="stylesheet" type="text/css">

<style type="text/css">
#box { background: #FFF; width: 238px; height: 410px; margin: -390px 0 0 0; display: block; border: solid 4px #D93600; position: absolute; z-index: 999; opacity: .5 }
#infscr-loading { display: none; }
</style>
<script src="./郑欧商城-国家馆详情页0_files/search_goods.js"></script>
<link href="./郑欧商城-国家馆详情页0_files/layout.css" rel="stylesheet" type="text/css">
-->
<div class="nch-container wrapper">

</div>

<div id="main" class="nch-category">
<!--StandardLayout Begin--> 
<?php echo $output['country_html']['index'];?> 
<!--StandardLayout End-->
</div>







<div id="page-more"><a href="index.php?act=promotion&gc_id=<?php echo $_GET['gc_id'];?>&curpage=2"></a></div>
<script type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/js/jquery.raty/jquery.raty.min.js"></script> 
<script src="<?php echo RESOURCE_SITE_URL;?>/js/jquery.masonry.js" type="text/javascript"></script> 
<script src="<?php echo RESOURCE_SITE_URL;?>/js/jquery.infinitescroll.js" type="text/javascript"></script> 
<script>
var $container = $('#promotionGoods');
$container.masonry({
    columnWidth: 305,
    itemSelector: '.item'
});
$(function(){
	$container.infinitescroll({  
        navSelector : '#page-more',
        nextSelector : '#page-more a',
        itemSelector : '.item',
        loading: {
        	selector:'#page-nav',
            img: '<?php echo SHOP_TEMPLATES_URL;?>/images/loading.gif',
            msgText:'努力加载中...',
            maxPage : <?php echo $output['total_page'];?>,
            finishedMsg : '没有记录了',
            finished : function() {
            	$('.raty').raty({
                    path: "<?php echo RESOURCE_SITE_URL;?>/js/jquery.raty/img",
                    readOnly: true,
                    width: 100,
                    score: function() {
                      return $(this).attr('data-score');
                    }
                });
            }
        }
    },function(newElements){
		var $newElems = $(newElements);
		$container.masonry('appended', $newElems, true);
	});

	$('.raty').raty({
        path: "<?php echo RESOURCE_SITE_URL;?>/js/jquery.raty/img",
        readOnly: true,
        width: 100,
        score: function() {
          return $(this).attr('data-score');
        }
    });
});
</script> 