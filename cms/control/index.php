<?php
/**
 * cms首页
 *
 *
 **by 好商城V3 www.shopnc.net 运营版*/

defined('InShopNC') or exit('Access Invalid!');
class indexControl extends CMSHomeControl{

	public function __construct() {
		parent::__construct();
        Tpl::output('index_sign','index');
    }
	public function indexOp(){
		//获取最近发表的推荐画报列表
		$condition1 = array(
			//'pcture_class_id' => '',
			'picture_state' => 3,
			'picture_commend_flag' => 1
			);
		$model_picture = Model('cms_picture');
		$pic_com_list = $model_picture->getList($condition1, null, 'picture_publish_time desc', null, 5);
		Tpl::output('pic_com_list', $pic_com_list);

		//获取最新的画报列表
		$condition2 = array(
			'picture_state' => 3
			);
		$pic_latest_list = $model_picture->getList($condition2, null, 'picture_publish_time desc', null, 4);
		Tpl::output('pic_latest_list', $pic_latest_list);

		//新车图库
		$condition14 = array(
			'picture_class_id' => 2,
			'picture_state' => 3
			);
		$new_car_list = $model_picture->getList($condition14, null, 'picture_publish_time desc', null, 6);
		Tpl::output('new_car_list', $new_car_list);

		//获取发表的文章推荐列表
		$condition3 = array(
			'article_class_id' => 1,
			'article_state' => 3,
			'article_commend_flag' => 1
			);
		$model_article = Model(cms_article);
		$article_com_list = $model_article->getList($condition3, null, 'article_publish_time desc', null, 16);
		Tpl::output('article_com_list',$article_com_list);

		//头条文章

		//头条文章
		$condition4 = array(
			'article_class_id' => 1,
			'article_state' => 3
			);
		$art_top_list = $model_article->getList($condition4, null, 'article_publish_time desc', null, 13);
		Tpl::output('art_top_list', $art_top_list);

		//新车资讯
		$condition13 = array(
			'article_class_id' => 2,
			'article_state' => 3
			);
		$art_new_list = $model_article->getList($condition4, null, 'article_publish_time desc', null, 13);
		Tpl::output('art_new_list', $art_new_list);
		
		//获取推荐的图文文章
		$condition5 = array(
			'article_state' => 3,
			'article_commend_image_flag' => 1
			);
		$art_img_list = $model_article->getList($condition5, null, 'article_publish_time desc', null, 3);
		Tpl::output('art_img_list', $art_img_list);

		//获取最新上市的3辆车
		$model_goods = Model('goods');
		$condition6 = array(
			'goods_state' => 1,
			'goods_verify' => 1
			);

		// //获取即将上市的6辆车辆 通过goods_common表获取 通过预约/预售获取
		// $goods_common_model = Model('goods_common');
		// $condition7 = array(
		// 	'goods_verify' = 1;
		// 	'' = ;
		// 	);

		// //根据画报分类获取新车图库
		$condition8 = array(
			'pcture_class_id' => '',
			'picture_state' => 3,
			'picture_commend_flag' => 1,
			);
		$model_picture = Model('cms_picture');
		$pic_new_list = $model_picture->getList($condition8, null, 'picture_publish_time desc', null, 6);
		Tpl::output('$pic_new_list', $pic_new_list);

		//汽车导购

		//汽车新闻 来自网站中的文章分类中的新闻资讯
		$condition9 = array(
			'article_class_id' => 1,
			'article_state' => 3 
			);
		$car_news_list = $model_article->getList($condition9, null, 'article_publish_time desc', null, 8);
		$car_news = array_chunk($car_news_list, 4);
		Tpl::output('car_news_list', $car_news);

		
		//友情链接
		$link_model = Model('link');
		$condition11 = array();
		$link_list = $link_model->getLinkList($condition11);
		Tpl::output('link_list', $link_list);

		//获取8个推荐品牌
		$brand_model = Model('brand');
		$condition10 = array('brand_recommend' => 1);
		$com_brand_list = $brand_model->getBrandList($condition10, null, null, null, 8);
		Tpl::output('com_brand_list', $com_brand_list);
		
		//热门推荐品牌
		//$condition10 = array('brand_recommend' => 1);
		$hot_brand_list = $brand_model->getBrandList($condition10);
		Tpl::output('hot_brand_list', $hot_brand_list);
		
		//热门车型,车型确定一个父级分类id
		$goods_class_model = Model('goods_class');
		$condition12 = array(
			'gc_parent_id' => 0
			);
		$hot_model_list = $goods_class_model->getGoodsClassList($condition12);
		Tpl::output('hot_model_list',$hot_model_list);

        Tpl::showpage('index');
	}
}
