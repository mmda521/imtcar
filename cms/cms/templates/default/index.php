<?php defined('InShopNC') or exit('Access Invalid!');?>
<link href="<?php echo (APP_SITE_URL.'/templates/cms_special.css')?>" rel="stylesheet" type="text/css"/>
<script type="text/javascript" src="<?php echo(BASE_SITE_URL.'/data/resource/js/jcarousel/jquery.jcarousel.min.js')?>" charset="utf-8"></script>
<script type="text/javascript" src="<?php echo(BASE_SITE_URL.'/data/resource/js/slidesjs/jquery.slides.min.js')?>" charset="utf-8"></script>
<link href="<?php echo(BASE_SITE_URL.'/data/resource/js/jcarousel/skins/personal/skin.css')?>" rel="stylesheet" type="text/css">
<script type="text/javascript">
$(document).ready(function() {
    if($('#index1_1_1_content').children().length > 0) {
        $('#index1_1_1_content').slidesjs({
            play: {
                active: true,
                    interval: 5000,
                    auto: true,
                    pauseOnHover: false,
                    restartDelay: 2500
            },
            callback: {
                complete: function(number) {
                    var $item = $(".slidesjs-pagination-item");
                    $item.removeClass("current");
                    $item.eq(number - 1).addClass("current");
                }
            },
                width: 380,
                height: 260
        });
        $(".slidesjs-pagination-item").eq(0).addClass("current");
    }

    //图片延迟加载
    $(".lazyload_container").nc_lazyload_init();
    $("img").nc_lazyload();

    //计算自定义块高度
    var frames = $('.cms-module-frame');
    $.each(frames, function(index, frame) {
        var boxs = $(frame).find('[nctype="cms_module_content"]');
        var height = 0;
        $.each(boxs, function(index2, box) {
            var box_height = $(box).height();
            if(box_height > height) {
                height = box_height;
            }
        });
        boxs.height(height);
    });
});
</script>
<div class="cms-content">
	<div><?php echo loadadv(1050);?></div>	
	<?php include template('layout/section1');?>
	<?php include template('layout/section2');?>
	<?php include template('layout/section3');?>
	<?php include template('layout/section4');?>
	<?php include template('layout/section5');?>
	<?php include template('layout/section6');?>
	<?php include template('layout/section7');?>
	<div><?php echo loadadv(1051);?></div>
	<?php include template('layout/section8');?>
</div>
