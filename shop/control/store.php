<?php
/**
 * 默认展示页面
 *
 *
 **by 好商城V3 www.shopnc.net 好商城V3 运营版*/


defined('InShopNC') or exit('Access Invalid!');
class storeControl extends BaseHomeControl{
	public function indexOp(){
		//商家列表	
		 $search = array();
		 //$search['store_state'] = 1;
		 $order = 'store_sort asc';
		 $model_store = Model('store');
         $store_list = $model_store->getStoreList($search,null,$order);
		 Tpl::output('store_list',$store_list);
		 Tpl::showpage('store');
	
	}

}
