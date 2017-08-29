<?php defined('InShopNC') or exit('Access Invalid!');?>
<link href="<?php echo SHOP_TEMPLATES_URL;?>/css/index.css" rel="stylesheet" type="text/css">
<script src="<?php echo RESOURCE_SITE_URL;?>/js/waypoints.js"></script>
<script type="text/javascript" src="<?php echo SHOP_RESOURCE_SITE_URL;?>/js/home_index.js" charset="utf-8"></script>
<!--[if IE 6]>
<script type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/js/ie6.js" charset="utf-8"></script>
<![endif]-->
<style type="text/css">
.category { display: block !important; }
.left-layout ul li
  {
	float:left;
    list-style:none;
	margin: 3px; 
    padding:5px; 
    width: auto; 
  }
</style>
<div class="clear"></div>
<!--首页弹窗广告-->
<script type="text/javascript">         
 function showMask(){     
        $("#mask").css("height",$(document).height());   
        $("#mask").css("width",$(document).width());     
        $("#mask").show();
    $("#mask_adv").show();
    }  
    //隐藏遮罩层  
    function hideMask(){ 
        $("#mask").hide(); 
    $("#mask_adv").hide();    
    }    
</script>
<div id="mask" class="mask" style="display:none"></div>  
<div id="mask_adv" class="mask_adv"  style="display:none">
  <div class="mask_h">
    <a href="javascript:;" onclick="hideMask();" >关闭</a><br />
  </div>
   <div>
    <a href="http://www.zosc.com/shop/index.php?act=search&op=index&keyword=1212" target="_blank">
    <img src="<?php echo RESOURCE_SITE_URL;?>/other/mask.png"/>
    </a>
   </div>
</div>
<!--首页弹窗广告结束-->
<!-- HomeFocusLayout Begin-->
<div class="home-focus-layout"> <?php echo $output['web_html']['index_pic'];?>
  <div class="right-sidebar">
    <div class="right-panel">

  <div style="cursor: hand; margin:0; padding:0;" >
    <div class="panelimg-side">
      <ul>
        <li><?php echo loadadv(1054);?></li>
      </ul>
    </div>
    </div>
    <!--
      <?php if ($_SESSION['is_login']) {?>
      <div class="loginBox">
        <div class="exitPanel"> <img src="<?php echo getMemberAvatar($_SESSION['avatar']);?>" alt="" />
          <div class="message">
            <p class="name">Hi, <a href="<?php echo urlShop('member','home');?>"><?php echo $_SESSION['member_name'];?></a></p>
            <p class="logOut qiueExt">[<a href="<?php echo urlShop('login','logout');?>">退出登录</a>]</p>
          </div>
          <div class="clear"></div>
        </div>
      -->
        <!-- 买家信息 -->
        <!--
        <div class="txtPanel"> <a href="index.php?act=member_order&state_type=state_new" class="line">
          <p class="num"><?php echo $output['member_order_info']['order_nopay_count'];?></p>
          <p class="txt">待付款</p>
          </a> <a target="_blank" href="index.php?act=member_order&op=index" class="line">
          <p class="num"><?php echo $output['member_order_info']['order_noreceipt_count'];?></p>
          <p class="txt">待收货</p>
          </a> <a target="_blank" href="index.php?act=member_refund&op=index">
          <p class="num"><?php echo $output['member_order_info']['order_noeval_count'];?></p>
          <p class="txt">待评价</p>
          </a> </div>
      </div>
      <?php } else {?>
      <div class="loginBox">
        <div class="welcomePanel"> <img src="<?php echo getMemberAvatar($_SESSION['avatar']);?>">
          <p>Hi，欢迎来<?php echo $output['setting_config']['site_name']; ?>，请登录</p>
        </div>
        <div class="loginPanel"> <a href="<?php echo urlShop('login','logout');?>" rel="nofollow"> <span class="loginTxt"><img alt="" src="<?php echo SHOP_TEMPLATES_URL;?>/images/u-me.png">登录</span> </a> <a href="index.php?act=login&op=register&ref_url=<?php echo urlencode($output['ref_url']);?>" rel="nofollow"> <span class="reigsterTxt"><img alt="" src="<?php echo SHOP_TEMPLATES_URL;?>/images/u-pencil.png">注册</span> </a> </div>
      </div>
      <?php } ?>
      <div class="securePanel">
        <li><img alt="买家保障" src="<?php echo SHOP_TEMPLATES_URL;?>/images/u-promise.png">
          <p>买家保障</p>
        </li>
        <li><img alt="商家认证" src="<?php echo SHOP_TEMPLATES_URL;?>/images/u-quality.png">
          <p>商家认证</p>
        </li>
        <li><img alt="安全交易" src="<?php echo SHOP_TEMPLATES_URL;?>/images/u-safe.png">
          <p>安全交易</p>
        </li>
      </div>
-->

      <div class="panelimg-side">
        <ul>
          <li><?php echo loadadv(1049);?></li>
        </ul>
      </div>
      <div class="clear"></div>
    </div>
  </div>
</div>
<!--HomeFocusLayout End-->


<div class="home-sale-layout wrapper">
  <div class="left-layout">
      <ul class="tabs-nav">
           <li class="tabs-selected"><i class="arrow"></i><h3>商家</h3></li>
      </ul>
   <ul>
    <?php if(!empty($output['store_list']) && is_array($output['store_list'])){?>
    <?php foreach($output['store_list'] as $skey => $store){?>
       <li>
         <dl>
            <dd class="goods-thumb"><a href="<?php echo urlShop('show_store','', array('store_id'=>$store['store_id']),$store['store_domain']);?>" title="" target="_blank"><span class="size72"><img src="<?php echo getStoreLogo($store['store_avatar']);?>"  alt="<?php echo $store['store_name'];?>" title="<?php echo $store['store_name'];?>" class="size72" /></span></a></dd> 
            <!--<dt class="goods-name"><a href="<?php echo urlShop('show_store','', array('store_id'=>$store['store_id']),$store['store_domain']);?>" target="_blank"><?php echo $store['store_name'];?></a></dt>-->
		 </dl>
        </li>
	 <?php }?>
    <?php }?>
	<a href="http://localhost:8080/imtcar/shop/index.php?act=store&amp;op=index" title="" target="_blank">更多</a>
	 <ul>
  </div>
  <?php if(!empty($output['xianshi_item']) && is_array($output['xianshi_item'])) { ?>
  <div class="right-sidebar">
    <div class="title">
      <h3><?php echo $lang['nc_xianshi'];?></h3>
    </div>
    <div id="saleDiscount" class="sale-discount">
      <ul>
        <?php foreach($output['xianshi_item'] as $val) { ?>
        <li>
          <dl>
            <dt class="goods-name"><?php echo $val['goods_name']; ?></dt>
            <dd class="goods-thumb"><a href="<?php echo urlShop('goods','index',array('goods_id'=> $val['goods_id']));?>"> <img src="<?php echo thumb($val, 240);?>"></a></dd>
            <dd class="goods-price"><?php echo ncPriceFormatForList($val['xianshi_price']); ?> <span class="original"><?php echo ncPriceFormatForList($val['goods_price']);?></span></dd>
            <dd class="goods-price-discount"><em><?php echo $val['xianshi_discount']; ?></em></dd>
            <dd class="time-remain" count_down="<?php echo $val['end_time']-TIMESTAMP;?>"><i></i><em time_id="d">0</em><?php echo $lang['text_tian'];?><em time_id="h">0</em><?php echo $lang['text_hour'];?> <em time_id="m">0</em><?php echo $lang['text_minute'];?><em time_id="s">0</em><?php echo $lang['text_second'];?> </dd>
            <dd class="goods-buy-btn"></dd>
          </dl>
        </li>
        <?php } ?>
      </ul>
    </div>
  </div>
  <?php } ?>
</div>
<!--
<div class="wrapper">
  <div class="mt10">
    <div class="mt10"><?php echo loadadv(11,'html');?></div>
  </div>
</div>
-->
<!--StandardLayout Begin--> 
<?php echo $output['web_html']['index'];?> 
<!--StandardLayout End--> 
<!--热门晒单str v3-b12-->

<!--热门晒单end-->
</div>
<div class="footer-line"></div>
<!--首页底部保障开始-->

<!--首页底部保障结束--> 
<!--StandardLayout Begin-->
<!--
<div id="nav_box">
  <ul>
    <li class="nav_h_1"><a href="javascript:;" class="num">1F</a> <a href="javascript:;" class="word">Whoo</a></li>
    <li class="nav_h_2"><a href="javascript:;" class="num">2F</a> <a href="javascript:;" class="word">母婴</a></li>
    <li class="nav_h_3"><a href="javascript:;" class="num">3F</a> <a href="javascript:;" class="word">美妆</a></li>
    <li class="nav_h_4"><a href="javascript:;" class="num">4F</a> <a href="javascript:;" class="word">悦诗</a></li>
    <li class="nav_h_5"><a href="javascript:;" class="num">5F</a> <a href="javascript:;" class="word">饮品</a></li>
    <li class="nav_h_6"><a href="javascript:;" class="num">6F</a> <a href="javascript:;" class="word">名酒</a></li>
    <li class="nav_h_7"><a href="javascript:;" class="num">7F</a> <a href="javascript:;" class="word">食品</a></li>
      <!-- <li class="nav_h_5"><a href="javascript:;" class="num">5F</a> <a href="javascript:;" class="word">皮具</a></li>
    <li class="nav_h_6"><a href="javascript:;" class="num">6F</a> <a href="javascript:;" class="word">户外</a></li>
 <li class="nav_h_7"><a href="javascript:;" class="num">7F</a> <a href="javascript:;" class="word">配饰</a></li>
<li class="nav_h_8"><a href="javascript:;" class="num">8F</a> <a href="javascript:;" class="word">家居</a></li>
  </ul>
</div>
-->
<?php function hideStar($str) { //用户名、邮箱、手机账号中间字符串以*隐藏。 用户名隐藏函数。
      $rs = mb_substr($str, 0, 1, 'utf-8') . "***" . mb_substr($str, -1, 1,'utf-8'); 
    return $rs;
    }?>
<!--StandardLayout End-->