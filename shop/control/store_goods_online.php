<?php
/**
 * 商品管理 v3-b12
 *
 *
 *
 **by 好商城V3 www.shopnc.net 运营版*/


defined('InShopNC') or exit ('Access Invalid!');
class store_goods_onlineControl extends BaseSellerControl {
    public function __construct() {
        parent::__construct ();
        Language::read ('member_store_goods_index');
    }
    public function indexOp() {
        $this->goods_listOp();
    }

    /**
     * 出售中的商品列表
     */
    public function goods_listOp() {
        $model_goods = Model('goods');

        $where = array();
        $where['store_id'] = $_SESSION['store_id'];
        if (intval($_GET['stc_id']) > 0) {
            $where['goods_stcids'] = array('like', '%,' . intval($_GET['stc_id']) . ',%');
        }
        if (trim($_GET['keyword']) != '') {
            switch ($_GET['search_type']) {
                case 0:
                    $where['goods_name'] = array('like', '%' . trim($_GET['keyword']) . '%');
                    break;
                case 1:
                    $where['goods_serial'] = array('like', '%' . trim($_GET['keyword']) . '%');
                    break;
                case 2:
                    $where['goods_commonid'] = intval($_GET['keyword']);
                    break;
            }
        }
        $goods_list = $model_goods->getGoodsCommonOnlineList($where);
        Tpl::output('show_page', $model_goods->showpage());
        Tpl::output('goods_list', $goods_list);

        // 计算库存
        $storage_array = $model_goods->calculateStorage($goods_list);
        Tpl::output('storage_array', $storage_array);

        // 商品分类
        $store_goods_class = Model('store_goods_class')->getClassTree(array('store_id' => $_SESSION['store_id'], 'stc_state' => '1'));
        Tpl::output('store_goods_class', $store_goods_class);

        $this->profile_menu('goods_list', 'goods_list');
        Tpl::showpage('store_goods_list.online');
    }

    /**
     * 编辑商品页面
     */
    public function edit_goodsOp() {
        $common_id = $_GET['commonid'];
        if ($common_id <= 0) {
            showMessage(L('wrong_argument'), '', 'html', 'error');
        }
        $model_goods = Model('goods');
        $goodscommon_info = $model_goods->getGoodeCommonInfoByID($common_id);
        if (empty($goodscommon_info) || $goodscommon_info['store_id'] != $_SESSION['store_id'] || $goodscommon_info['goods_lock'] == 1) {
            showMessage(L('wrong_argument'), '', 'html', 'error');
        }

        $where = array('goods_commonid' => $common_id, 'store_id' => $_SESSION['store_id']);
        $goodscommon_info['g_storage'] = $model_goods->getGoodsSum($where, 'goods_storage');
        $goodscommon_info['spec_name'] = unserialize($goodscommon_info['spec_name']);
        if ($goodscommon_info['mobile_body'] != '') {
            $goodscommon_info['mb_body'] = unserialize($goodscommon_info['mobile_body']);
            // v3-b12
	    if (is_array($goodscommon_info['mb_body'])) {
                $mobile_body = '[';
                foreach ($goodscommon_info['mb_body'] as $val ) {
                    $mobile_body .= '{"type":"' . $val['type'] . '","value":"' . $val['value'] . '"},';
                }
                $mobile_body = rtrim($mobile_body, ',') . ']';
            }
            $goodscommon_info['mobile_body'] = $mobile_body;
        }
        Tpl::output('goods', $goodscommon_info);

		
		
		//车辆基本参数	
		 $goodsbasic_info = $model_goods->getbasicInfo($common_id);
		 Tpl::output('basic', $goodsbasic_info);
		 //车身参数
		 $goodscarbody_info = $model_goods->getcarbodyInfo($common_id);
		 Tpl::output('carbody', $goodscarbody_info);
		 //汽车发动机参数
		 $goodsengine_info = $model_goods->getengineInfo($common_id);
		 Tpl::output('engine', $goodsengine_info);
		
		
        //获取goods_kuajing_d数据
        //$model_goods_kuajing_d = Model('goods_kuajing_d');
        $kuajing_id = $model_goods->getfby_goods_commonid($common_id,'goods_kuajingD_id');
        if ($kuajing_id > 0) { 
            $goods_kuajing_info = $model_goods->getGoodeKuajingInfo(array('id'=>$kuajing_id));
        Tpl::output('goods_kuajingD', $goods_kuajing_info);

        }
        else {

            Tpl::output('goods_kuajingD', array('id' => $kuajing_id));
        }

        if (intval($_GET['class_id']) > 0) {
            $goodscommon_info['gc_id'] = intval($_GET['class_id']);
        }
        $goods_class = Model('goods_class')->getGoodsClassLineForTag($goodscommon_info['gc_id']);
        Tpl::output('goods_class', $goods_class);

        $model_type = Model('type');
        // 获取类型相关数据
        $typeinfo = $model_type->getAttr($goods_class['type_id'], $_SESSION['store_id'], $goodscommon_info['gc_id']);
        list($spec_json, $spec_list, $attr_list, $brand_list) = $typeinfo;
        Tpl::output('spec_json', $spec_json);
        Tpl::output('sign_i', count($spec_list));
        Tpl::output('spec_list', $spec_list);
        Tpl::output('attr_list', $attr_list);
        Tpl::output('brand_list', $brand_list);

        // 取得商品规格的输入值
        $goods_array = $model_goods->getGoodsList($where, 'goods_id,goods_marketprice,goods_price,goods_app_price,goods_storage,goods_serial,goods_storage_alarm,goods_spec,is_mode,goods_hs,goods_tax,goods_shipper_id');
        $sp_value = array();
        if (is_array($goods_array) && !empty($goods_array)) {

            // 取得已选择了哪些商品的属性
            $attr_checked_l = $model_type->typeRelatedList ( 'goods_attr_index', array (
                    'goods_id' => intval ( $goods_array[0]['goods_id'] )
            ), 'attr_value_id' );
            if (is_array ( $attr_checked_l ) && ! empty ( $attr_checked_l )) {
                $attr_checked = array ();
                foreach ( $attr_checked_l as $val ) {
                    $attr_checked [] = $val ['attr_value_id'];
                }
            }
            Tpl::output ( 'attr_checked', $attr_checked );

            $spec_checked = array();
            foreach ( $goods_array as $k => $v ) {
                $a = unserialize($v['goods_spec']);
                if (!empty($a)) {
                    foreach ($a as $key => $val){
                        $spec_checked[$key]['id'] = $key;
                        $spec_checked[$key]['name'] = $val;
                    }
                    $matchs = array_keys($a);
                    sort($matchs);
                    $id = str_replace ( ',', '', implode ( ',', $matchs ) );
                    $sp_value ['i_' . $id . '|marketprice'] = $v['goods_marketprice'];
                    $sp_value ['i_' . $id . '|price'] = $v['goods_price'];
					$sp_value ['i_' . $id . '|app_price'] = $v['goods_app_price'];
                    $sp_value ['i_' . $id . '|id'] = $v['goods_id'];
                    $sp_value ['i_' . $id . '|stock'] = $v['goods_storage'];
                    $sp_value ['i_' . $id . '|alarm'] = $v['goods_storage_alarm'];
                    $sp_value ['i_' . $id . '|sku'] = $v['goods_serial'];
                }
            }
            Tpl::output('spec_checked', $spec_checked);
        }
        Tpl::output ( 'sp_value', $sp_value );

        // 实例化店铺商品分类模型
        $store_goods_class = Model('store_goods_class')->getClassTree(array('store_id' => $_SESSION ['store_id'], 'stc_state' => '1'));
        Tpl::output('store_goods_class', $store_goods_class);
        //处理商品所属分类
        $store_goods_class_tmp = array();
        if (!empty($store_goods_class)){
            foreach ($store_goods_class as $k=>$v) {
                $store_goods_class_tmp[$v['stc_id']] = $v;
                if (is_array($v['child'])) {
                    foreach ($v['child'] as $son_k=>$son_v){
                        $store_goods_class_tmp[$son_v['stc_id']] = $son_v;
                    }
                }
            }
        }
        $goodscommon_info['goods_stcids'] = trim($goodscommon_info['goods_stcids'], ',');
        $goods_stcids = empty($goodscommon_info['goods_stcids'])?array():explode(',', $goodscommon_info['goods_stcids']);
        $goods_stcids_tmp = $goods_stcids_new = array();
        if (!empty($goods_stcids)){
            foreach ($goods_stcids as $k=>$v){
                $stc_parent_id = $store_goods_class_tmp[$v]['stc_parent_id'];
                //分类进行分组，构造为array('1'=>array(5,6,8));
                if ($stc_parent_id > 0){//如果为二级分类，则分组到父级分类下
                    $goods_stcids_tmp[$stc_parent_id][] = $v;
                } elseif (empty($goods_stcids_tmp[$v])) {//如果为一级分类而且分组不存在，则建立一个空分组数组
                    $goods_stcids_tmp[$v] = array();
                }
            }
            foreach ($goods_stcids_tmp as $k=>$v){
                if (!empty($v) && count($v) > 0){
                    $goods_stcids_new = array_merge($goods_stcids_new,$v);
                } else {
                    $goods_stcids_new[] = $k;
                }
            }
        }
        Tpl::output('store_class_goods', $goods_stcids_new);

        // 是否能使用编辑器
        if(checkPlatformStore()){ // 平台店铺可以使用编辑器
            $editor_multimedia = true;
        } else {    // 三方店铺需要
            $editor_multimedia = false;
            if ($this->store_grade['sg_function'] == 'editor_multimedia') {
                $editor_multimedia = true;
            }
        }
        Tpl::output ( 'editor_multimedia', $editor_multimedia );

        // 小时分钟显示
        $hour_array = array('00', '01', '02', '03', '04', '05', '06', '07', '08', '09', '10', '11', '12', '13', '14', '15', '16', '17', '18', '19', '20', '21', '22', '23');
        Tpl::output('hour_array', $hour_array);
        $minute_array = array('05', '10', '15', '20', '25', '30', '35', '40', '45', '50', '55');
        Tpl::output('minute_array', $minute_array);

        // 关联版式
        $plate_list = Model('store_plate')->getStorePlateList(array('store_id' => $_SESSION['store_id']), 'plate_id,plate_name,plate_position');
        $plate_list = array_under_reset($plate_list, 'plate_position', 2);
        Tpl::output('plate_list', $plate_list);

        // F码
        if ($goodscommon_info['is_fcode'] == 1) {
            $fcode_array = Model('goods_fcode')->getGoodsFCodeList(array('goods_commonid' => $goodscommon_info['goods_commonid']));
            Tpl::output('fcode_array', $fcode_array);
        }
        $menu_promotion = array(
            'lock' => $goodscommon_info['goods_lock'] == 1 ? true : false,
            'gift' => $model_goods->checkGoodsIfAllowGift($goodscommon_info),
            'combo' => $model_goods->checkGoodsIfAllowCombo($goodscommon_info)
        );
        $this->profile_menu('edit_detail','edit_detail', $menu_promotion);
        Tpl::output('edit_goods_sign', true);

        //抛出国家变量
        $model_country = Model('kuajing_country');
        $kuajing_country= $model_country->select();
        Tpl::output('kuajing_country', $kuajing_country);

        //抛出本店铺的发货人变量
        $model_shipper = Model('shipper_kuajing_d');
        $kuajing_shipper= $model_shipper->where(array('store_id'=>$_SESSION ['store_id']))->select();
        Tpl::output('kuajing_shipper', $kuajing_shipper);

        Tpl::showpage('store_goods_add.step2');
    }
	
	
	

 /**
     * 备货参数页面
     */
    public function edit_goodsOp1() {
        $common_id = $_GET['commonid'];
        if ($common_id <= 0) {
            showMessage(L('wrong_argument'), '', 'html', 'error');
        }
        $model_goods = Model('goods');
        $goodscommon_info = $model_goods->getGoodeCommonInfoByID($common_id);
        if (empty($goodscommon_info) || $goodscommon_info['store_id'] != $_SESSION['store_id'] || $goodscommon_info['goods_lock'] == 1) {
            showMessage(L('wrong_argument'), '', 'html', 'error');
        }

        $where = array('goods_commonid' => $common_id, 'store_id' => $_SESSION['store_id']);
        $goodscommon_info['g_storage'] = $model_goods->getGoodsSum($where, 'goods_storage');
        $goodscommon_info['spec_name'] = unserialize($goodscommon_info['spec_name']);
        if ($goodscommon_info['mobile_body'] != '') {
            $goodscommon_info['mb_body'] = unserialize($goodscommon_info['mobile_body']);
            // v3-b12
	    if (is_array($goodscommon_info['mb_body'])) {
                $mobile_body = '[';
                foreach ($goodscommon_info['mb_body'] as $val ) {
                    $mobile_body .= '{"type":"' . $val['type'] . '","value":"' . $val['value'] . '"},';
                }
                $mobile_body = rtrim($mobile_body, ',') . ']';
            }
            $goodscommon_info['mobile_body'] = $mobile_body;
        }
        Tpl::output('goods', $goodscommon_info);

        if (intval($_GET['class_id']) > 0) {
            $goodscommon_info['gc_id'] = intval($_GET['class_id']);
        }
        $goods_class = Model('goods_class')->getGoodsClassLineForTag($goodscommon_info['gc_id']);
        Tpl::output('goods_class', $goods_class);

        $model_type = Model('type');
        // 获取类型相关数据
        $typeinfo = $model_type->getAttr($goods_class['type_id'], $_SESSION['store_id'], $goodscommon_info['gc_id']);
        list($spec_json, $spec_list, $attr_list, $brand_list) = $typeinfo;
        Tpl::output('spec_json', $spec_json);
        Tpl::output('sign_i', count($spec_list));
        Tpl::output('spec_list', $spec_list);
        Tpl::output('attr_list', $attr_list);
        Tpl::output('brand_list', $brand_list);

        // 取得商品规格的输入值
        $goods_array = $model_goods->getGoodsList($where, 'goods_id,goods_marketprice,goods_price,goods_app_price,goods_storage,goods_serial,goods_storage_alarm,goods_spec');
        $sp_value = array();
        if (is_array($goods_array) && !empty($goods_array)) {

            // 取得已选择了哪些商品的属性
            $attr_checked_l = $model_type->typeRelatedList ( 'goods_attr_index', array (
                    'goods_id' => intval ( $goods_array[0]['goods_id'] )
            ), 'attr_value_id' );
            if (is_array ( $attr_checked_l ) && ! empty ( $attr_checked_l )) {
                $attr_checked = array ();
                foreach ( $attr_checked_l as $val ) {
                    $attr_checked [] = $val ['attr_value_id'];
                }
            }
            Tpl::output ( 'attr_checked', $attr_checked );

            $spec_checked = array();
            foreach ( $goods_array as $k => $v ) {
                $a = unserialize($v['goods_spec']);
                if (!empty($a)) {
                    foreach ($a as $key => $val){
                        $spec_checked[$key]['id'] = $key;
                        $spec_checked[$key]['name'] = $val;
                    }
                    $matchs = array_keys($a);
                    sort($matchs);
                    $id = str_replace ( ',', '', implode ( ',', $matchs ) );
                    $sp_value ['i_' . $id . '|marketprice'] = $v['goods_marketprice'];
                    $sp_value ['i_' . $id . '|price'] = $v['goods_price'];
					$sp_value ['i_' . $id . '|app_price'] = $v['goods_app_price'];
                    $sp_value ['i_' . $id . '|id'] = $v['goods_id'];
                    $sp_value ['i_' . $id . '|stock'] = $v['goods_storage'];
                    $sp_value ['i_' . $id . '|alarm'] = $v['goods_storage_alarm'];
                    $sp_value ['i_' . $id . '|sku'] = $v['goods_serial'];
                }
            }
            Tpl::output('spec_checked', $spec_checked);
        }
        Tpl::output ( 'sp_value', $sp_value );

        // 实例化店铺商品分类模型
        $store_goods_class = Model('store_goods_class')->getClassTree(array('store_id' => $_SESSION ['store_id'], 'stc_state' => '1'));
        Tpl::output('store_goods_class', $store_goods_class);
        //处理商品所属分类
        $store_goods_class_tmp = array();
        if (!empty($store_goods_class)){
            foreach ($store_goods_class as $k=>$v) {
                $store_goods_class_tmp[$v['stc_id']] = $v;
                if (is_array($v['child'])) {
                    foreach ($v['child'] as $son_k=>$son_v){
                        $store_goods_class_tmp[$son_v['stc_id']] = $son_v;
                    }
                }
            }
        }
        $goodscommon_info['goods_stcids'] = trim($goodscommon_info['goods_stcids'], ',');
        $goods_stcids = empty($goodscommon_info['goods_stcids'])?array():explode(',', $goodscommon_info['goods_stcids']);
        $goods_stcids_tmp = $goods_stcids_new = array();
        if (!empty($goods_stcids)){
            foreach ($goods_stcids as $k=>$v){
                $stc_parent_id = $store_goods_class_tmp[$v]['stc_parent_id'];
                //分类进行分组，构造为array('1'=>array(5,6,8));
                if ($stc_parent_id > 0){//如果为二级分类，则分组到父级分类下
                    $goods_stcids_tmp[$stc_parent_id][] = $v;
                } elseif (empty($goods_stcids_tmp[$v])) {//如果为一级分类而且分组不存在，则建立一个空分组数组
                    $goods_stcids_tmp[$v] = array();
                }
            }
            foreach ($goods_stcids_tmp as $k=>$v){
                if (!empty($v) && count($v) > 0){
                    $goods_stcids_new = array_merge($goods_stcids_new,$v);
                } else {
                    $goods_stcids_new[] = $k;
                }
            }
        }
        Tpl::output('store_class_goods', $goods_stcids_new);

        // 是否能使用编辑器
        if(checkPlatformStore()){ // 平台店铺可以使用编辑器
            $editor_multimedia = true;
        } else {    // 三方店铺需要
            $editor_multimedia = false;
            if ($this->store_grade['sg_function'] == 'editor_multimedia') {
                $editor_multimedia = true;
            }
        }
        Tpl::output ( 'editor_multimedia', $editor_multimedia );

        // 小时分钟显示
        $hour_array = array('00', '01', '02', '03', '04', '05', '06', '07', '08', '09', '10', '11', '12', '13', '14', '15', '16', '17', '18', '19', '20', '21', '22', '23');
        Tpl::output('hour_array', $hour_array);
        $minute_array = array('05', '10', '15', '20', '25', '30', '35', '40', '45', '50', '55');
        Tpl::output('minute_array', $minute_array);

        // 关联版式
        $plate_list = Model('store_plate')->getStorePlateList(array('store_id' => $_SESSION['store_id']), 'plate_id,plate_name,plate_position');
        $plate_list = array_under_reset($plate_list, 'plate_position', 2);
        Tpl::output('plate_list', $plate_list);

        // F码
        if ($goodscommon_info['is_fcode'] == 1) {
            $fcode_array = Model('goods_fcode')->getGoodsFCodeList(array('goods_commonid' => $goodscommon_info['goods_commonid']));
            Tpl::output('fcode_array', $fcode_array);
        }
        $menu_promotion = array(
            'lock' => $goodscommon_info['goods_lock'] == 1 ? true : false,
            'gift' => $model_goods->checkGoodsIfAllowGift($goodscommon_info),
            'combo' => $model_goods->checkGoodsIfAllowCombo($goodscommon_info)
        );
        $this->profile_menu('edit_detail','edit_detail', $menu_promotion);
        Tpl::output('edit_goods_sign', true);
        Tpl::showpage('store_goods_add.step2');
    }

    /**
     * 编辑商品保存
     */
    public function edit_save_goodsOp() {

        $common_id = intval ( $_POST ['commonid'] );
        if (!chksubmit() || $common_id <= 0) {
            showDialog(L('store_goods_index_goods_edit_fail'), urlShop('store_goods_online', 'index'));
        }
        // 验证表单
        $obj_validate = new Validate ();
        $obj_validate->validateparam = array (
            array (
                "input" => $_POST["g_name"],
                "require" => "true",
                "message" => L('store_goods_index_goods_name_null')
            ),
            array (
                "input" => $_POST["g_price"],
                "require" => "true",
                "validator" => "Double",
                "message" => L('store_goods_index_goods_price_null')
            ),
			array (
                "input" => $_POST["g_app_price"],
                "require" => "true",
                "validator" => "Double",
                "message" => L('store_goods_index_goods_price_null')
            )
        );
        $error = $obj_validate->validate ();
        if ($error != '') {
            showDialog(L('error') . $error, urlShop('store_goods_online', 'index'));
        }

        $gc_id = intval($_POST['cate_id']);

        // 验证商品分类是否存在且商品分类是否为最后一级
        $data = Model('goods_class')->getGoodsClassForCacheModel();
        if (!isset($data[$gc_id]) || isset($data[$gc_id]['child']) || isset($data[$gc_id]['childchild'])) {
            showDialog(L('store_goods_index_again_choose_category1'));
        }

        // 三方店铺验证是否绑定了该分类
        if (!checkPlatformStore()) {
            //商品分类 by 33hao. com 提供批量显示所有分类插件
            $model_bind_class = Model('store_bind_class');
            $goods_class = Model('goods_class')->getGoodsClassForCacheModel();
            $where['store_id'] = $_SESSION['store_id'];
            $class_2 = $goods_class[$gc_id]['gc_parent_id'];
            $class_1 = $goods_class[$class_2]['gc_parent_id'];
            $where['class_1'] =  $class_1;
            $where['class_2'] =  $class_2;
            $where['class_3'] =  $gc_id;
            $bind_info = $model_bind_class->getStoreBindClassInfo($where);
            if (empty($bind_info))
            {
                $where['class_3'] =  0;
                $bind_info = $model_bind_class->getStoreBindClassInfo($where);
                if (empty($bind_info))
                {
                    $where['class_2'] =  0;
                    $where['class_3'] =  0;
                    $bind_info = $model_bind_class->getStoreBindClassInfo($where);
                    if (empty($bind_info))
                    {
                        $where['class_1'] =  0;
                        $where['class_2'] =  0;
                        $where['class_3'] =  0;
                        $bind_info = $model_bind_class->getStoreBindClassInfo($where);
                        if (empty($bind_info))
                        {
                            showDialog(L('store_goods_index_again_choose_category2'));
                        }
                    }

                }

            }
        }
        // 分类信息
        $goods_class = Model('goods_class')->getGoodsClassLineForTag(intval($_POST['cate_id']));

        $model_goods = Model ( 'goods' );

        $update_common = array();
        $update_common['goods_name']         = $_POST['g_name'];
        $update_common['goods_jingle']       = $_POST['g_jingle'];
        $update_common['gc_id']              = $gc_id;
        $update_common['gc_id_1']            = intval($goods_class['gc_id_1']);
        $update_common['gc_id_2']            = intval($goods_class['gc_id_2']);
        $update_common['gc_id_3']            = intval($goods_class['gc_id_3']);
        $update_common['gc_name']            = $_POST['cate_name'];
        $update_common['brand_id']           = $_POST['b_id'];
        $update_common['brand_name']         = $_POST['b_name'];
        $update_common['type_id']            = intval($_POST['type_id']);
        $update_common['goods_image']        = $_POST['image_path'];
        $update_common['goods_price']        = floatval($_POST['g_price']);
		$update_common['goods_app_price']    = floatval($_POST['g_app_price']);
        $update_common['goods_marketprice']  = floatval($_POST['g_marketprice']);
        $update_common['goods_costprice']    = floatval($_POST['g_costprice']);
        $update_common['goods_discount']     = floatval($_POST['g_discount']);
        $update_common['goods_presalenum']     = intval($_POST['g_presalenum']);
        $update_common['goods_serial']       = $_POST['g_serial'];
        $update_common['goods_storage_alarm']= intval($_POST['g_alarm']);
        $update_common['goods_attr']         = serialize($_POST['attr']);
        $update_common['goods_body']         = $_POST['g_body'];
        // 序列化保存手机端商品描述数据
        if ($_POST['m_body'] != '') {
            $_POST['m_body'] = str_replace('&quot;', '"', $_POST['m_body']);
            $_POST['m_body'] = json_decode($_POST['m_body'], true);
            if (!empty($_POST['m_body'])) {
                $_POST['m_body'] = serialize($_POST['m_body']);
            } else {
                $_POST['m_body'] = '';
            }
        }
        $update_common['mobile_body']        = $_POST['m_body'];
        $update_common['goods_commend']      = intval($_POST['g_commend']);
        $update_common['goods_state']        = ($this->store_info['store_state'] != 1) ? 0 : intval($_POST['g_state']);            // 店铺关闭时，商品下架
        $update_common['goods_selltime']     = strtotime($_POST['starttime']) + intval($_POST['starttime_H'])*3600 + intval($_POST['starttime_i'])*60;
        $update_common['goods_verify']       = (C('goods_verify') == 1) ? 10 : 1;
        $update_common['spec_name']          = is_array($_POST['spec']) ? serialize($_POST['sp_name']) : serialize(null);
        $update_common['spec_value']         = is_array($_POST['spec']) ? serialize($_POST['sp_val']) : serialize(null);
        $update_common['goods_vat']          = intval($_POST['g_vat']);
        $update_common['areaid_1']           = intval($_POST['province_id']);
        $update_common['areaid_2']           = intval($_POST['city_id']);
        $update_common['transport_id']       = ($_POST['freight'] == '0') ? '0' : intval($_POST['transport_id']); // 售卖区域
        $update_common['transport_title']    = $_POST['transport_title'];
        $update_common['goods_freight']      = floatval($_POST['g_freight']);
        //查询店铺商品分类
        $goods_stcids_arr = array();
        if (!empty($_POST['sgcate_id'])){
            $sgcate_id_arr = array();
            foreach ($_POST['sgcate_id'] as $k=>$v){
                $sgcate_id_arr[] = intval($v);
            }
            $sgcate_id_arr = array_unique($sgcate_id_arr);
            $store_goods_class = Model('store_goods_class')->getStoreGoodsClassList(array('store_id' => $_SESSION['store_id'], 'stc_id' => array('in', $sgcate_id_arr), 'stc_state' => '1'));
            if (!empty($store_goods_class)){
                foreach ($store_goods_class as $k=>$v){
                    if ($v['stc_id'] > 0){
                        $goods_stcids_arr[] = $v['stc_id'];
                    }
                    if ($v['stc_parent_id'] > 0){
                        $goods_stcids_arr[] = $v['stc_parent_id'];
                    }
                }
                $goods_stcids_arr = array_unique($goods_stcids_arr);
                sort($goods_stcids_arr);
            }
        }
        if (empty($goods_stcids_arr)){
            $update_common['goods_stcids'] = '';
        } else {
            $update_common['goods_stcids'] = ','.implode(',',$goods_stcids_arr).',';
        }
        $update_common['plateid_top']        = intval($_POST['plate_top']) > 0 ? intval($_POST['plate_top']) : '';
        $update_common['plateid_bottom']     = intval($_POST['plate_bottom']) > 0 ? intval($_POST['plate_bottom']) : '';
        $update_common['is_virtual']         = intval($_POST['is_gv']);
        $update_common['virtual_indate']     = $_POST['g_vindate'] != '' ? (strtotime($_POST['g_vindate']) + 24*60*60 -1) : 0;  // 当天的最后一秒结束
        $update_common['virtual_limit']      = intval($_POST['g_vlimit']) > 10 || intval($_POST['g_vlimit']) < 0 ? 10 : intval($_POST['g_vlimit']);
        $update_common['virtual_invalid_refund'] = intval($_POST['g_vinvalidrefund']);
        $update_common['is_fcode']           = intval($_POST['is_fc']);
        $update_common['is_appoint']         = intval($_POST['is_appoint']);     // 只有库存为零的商品可以预约
        $update_common['appoint_satedate']   = $update_common['is_appoint'] == 1 ? strtotime($_POST['g_saledate']) : '';   // 预约商品的销售时间
        $update_common['is_presell']         = $update_common['goods_state'] == 1 ? intval($_POST['is_presell']) : 0;     // 只有出售中的商品可以预售
        $update_common['presell_deliverdate']= $update_common['is_presell'] == 1? strtotime($_POST['g_deliverdate']) : ''; // 预售商品的发货时间
        $update_common['is_own_shop']        = in_array($_SESSION['store_id'], model('store')->getOwnShopIds()) ? 1 : 0;
        $update_common['is_mode']            = $_POST['is_mode'];
        if($update_common['is_mode'] == 0){$update_common['goods_shipper_id'] = 0;}
        else {$update_common['goods_shipper_id']   = $_POST['goods_shipper_id'];}
        
        $update_common['goods_hs']           = $_POST['goods_hs'];
        $model_hs = Model('ctax_hs');
            $xiaofei_rate = $model_hs->getfby_hs($_POST['goods_hs'],'xiaofei_rate');
            $zengzhi_rate = $model_hs->getfby_hs($_POST['goods_hs'],'zengzhi_rate');  
            //综合税率
            $update_common['goods_tax_rate'] = $model_hs->getfby_hs($_POST['goods_hs'],'tax_rate');         
            $tax_all = array();
            $tax_all = $model_hs->getgoodsTax($update_common['goods_price'],$xiaofei_rate,$zengzhi_rate);
            $update_common['goods_tax'] =  $tax_all['tax'];

            //跨境参数
            $kuajing_array = array();
            $kuajing_array['is_mode']           = intval($_POST['is_mode']);
            //$kuajing_array['goods_id']        = '';
            $kuajing_array['country_origin']    = $_POST['source_country'];
            $kuajing_array['country_trade']     = $_POST['trade_country'];
            $kuajing_array['hs']                = $_POST['goods_hs'];
            $kuajing_array['weight_unit']       = $_POST['net_weight_unit'];
            $kuajing_array['net_weight']        = $_POST['net_weight'];
            $kuajing_array['gross_weight']      = $_POST['gross_weight'];
            $kuajing_array['record_no_guan']    = $_POST['record_no_guan'];
            $kuajing_array['record_no_jian']    = $_POST['record_no_jian'];
            $kuajing_array['unit_guan']         = $_POST['unit_guan'];
            $kuajing_array['unit_jian']         = $_POST['unit_jian'];
            $kuajing_array['unit1']         = $_POST['unit1'];
            $kuajing_array['unit2']         = $_POST['unit2'];
            $kuajing_array['qty1']         = $_POST['qty1'];
            $kuajing_array['qty2']         = $_POST['qty2'];
            $kuajing_array['tax']               = $tax_all['tax'];
            $kuajing_array['vat']               = $tax_all['vat'];
            $kuajing_array['consumption_tax']   = $tax_all['consumption_tax'];

            $kuajing_array['specification']     = $_POST['guige'];

            $kuajing_id = $_POST['kuajingDid'];
            
            //$kuajing_id = $model_goods->getfby_goods_commonid($common_id,'goods_kuajingD_id');
            //$kuajing_id = 3;
            //如果是跨境产品，保存到跨境参数
            if($kuajing_array['is_mode'] == 2) {
                if ($kuajing_id == 0) {
                    $kuajing_id = $model_goods->addGoodsKuajingD($kuajing_array);
                } else if ($kuajing_id > 0) {
                    $resultKuajingID = $model_goods->editGoodsKuajingById($kuajing_array,$kuajing_id);
                }
            } else {
                $kuajing_id = 0;
            }

        
        


        // 开始事务
        Model()->beginTransaction();
        $model_gift = Model('goods_gift');
        // 清除原有规格数据
        $model_type = Model('type');
        $model_type->delGoodsAttr(array('goods_commonid' => $common_id));
            // 生成商品二维码
            require_once(BASE_RESOURCE_PATH.DS.'phpqrcode'.DS.'index.php');
            $PhpQRCode = new PhpQRCode();
            $PhpQRCode->set('pngTempDir',BASE_UPLOAD_PATH.DS.ATTACH_STORE.DS.$_SESSION['store_id'].DS);
                    
        // 更新商品规格
        $goodsid_array = array();
        $colorid_array = array();
        if (is_array ( $_POST ['spec'] )) {
            foreach ($_POST['spec'] as $value) {
                $goods_info = $model_goods->getGoodsInfo(array('goods_id' => $value['goods_id'], 'goods_commonid' => $common_id, 'store_id' => $_SESSION['store_id']), 'goods_id');
                if (!empty($goods_info)) {
                    $goods_id = $goods_info['goods_id'];
                    $update = array ();
                    $update['goods_commonid']    = $common_id;
                    $update['goods_kuajingD_id'] = $kuajing_id;    
                    $update['goods_name']        = $update_common['goods_name'] . ' ' . implode(' ', $value['sp_value']);
                    $update['goods_jingle']      = $update_common['goods_jingle'];
                    $update['store_id']          = $_SESSION['store_id'];
                    $update['store_name']        = $_SESSION['store_name'];
                    $update['gc_id']             = $update_common['gc_id'];
                    $update['gc_id_1']           = $update_common['gc_id_1'];
                    $update['gc_id_2']           = $update_common['gc_id_2'];
                    $update['gc_id_3']           = $update_common['gc_id_3'];
                    $update['brand_id']          = $update_common['brand_id'];
                    $update['goods_price']       = $value['price'];
					$update['goods_app_price']       = $value['app_price'];
                    $update['goods_marketprice'] = $value['marketprice'] == 0 ? $update_common['goods_marketprice'] : $value['marketprice'];
                    $update['goods_presalenum']  = $update_common['goods_presalenum'];
                    $update['goods_serial']      = $value['sku'];
                    $update['goods_storage_alarm']= intval($value['alarm']);
                    $update['goods_spec']        = serialize($value['sp_value']);
                    $update['goods_storage']     = $value['stock'];
                    $update['goods_state']       = $update_common['goods_state'];
                    $update['goods_verify']      = $update_common['goods_verify'];
                    $update['goods_edittime']    = TIMESTAMP;
                    $update['areaid_1']          = $update_common['areaid_1'];
                    $update['areaid_2']          = $update_common['areaid_2'];
                    $update['color_id']          = intval($value['color']);
                    $update['transport_id']      = $update_common['transport_id'];
                    $update['goods_freight']     = $update_common['goods_freight'];
                    $update['goods_vat']         = $update_common['goods_vat'];
                    $update['goods_commend']     = $update_common['goods_commend'];
                    $update['goods_stcids']      = $update_common['goods_stcids'];
                    $update['is_virtual']        = $update_common['is_virtual'];
                    $update['virtual_indate']    = $update_common['virtual_indate'];
                    $update['virtual_limit']     = $update_common['virtual_limit'];
                    $update['virtual_invalid_refund'] = $update_common['virtual_invalid_refund'];
                    $update['is_fcode']          = $update_common['is_fcode'];
                    $update['is_appoint']        = $update_common['is_appoint'];
                    $update['is_presell']        = $update_common['is_presell'];
                    $update['is_mode']           = $update_common['is_mode'];
                    if($update['is_mode'] == 0) {$update['goods_shipper_id'] = 0;}
                    else {$update['goods_shipper_id']  = $update_common['goods_shipper_id'];}
                    
                    $update['goods_hs']          = $update_common['goods_hs'];
                    //$update['goods_tax']         = $update_common['goods_tax'];
                    $model_hs = Model('ctax_hs');
                    $xiaofei_rate = $model_hs->getfby_hs($update_common['goods_hs'],'xiaofei_rate');
                    $zengzhi_rate = $model_hs->getfby_hs($update_common['goods_hs'],'zengzhi_rate');
                    //综合税率
                    if($update['is_mode'] == 0) {$update['goods_tax_rate'] = 0;}
                    else {$update['goods_tax_rate'] = $model_hs->getfby_hs($update_common['goods_hs'],'tax_rate');}
                    $tax_all = $model_hs->getgoodsTax($value['price'],$xiaofei_rate,$zengzhi_rate);
                    $update['goods_tax'] = $tax_all['tax'];

                    // 虚拟商品不能有赠品
                    if ($update_common['is_virtual'] == 1) {
                        $update['have_gift']    = 0;
                        $model_gift->delGoodsGift(array('goods_id' => $goods_id));
                    }
                    $update['is_own_shop']       = $update_common['is_own_shop'];
                    $model_goods->editGoodsById($update, $goods_id);
		    // 生成商品二维码
                        //$PhpQRCode->set('date',WAP_SITE_URL . '/tmpl/product_detail.html?goods_id='.$goods_id);
                        $PhpQRCode->set('date',WAP_SITE_URL . '/goods/goodsDetail.shtml?goodsId='.$goods_id);
                        $PhpQRCode->set('pngTempName', $goods_id . '.png');
                        $PhpQRCode->init();
                } else {
                    $insert = array();
                    $insert['goods_commonid']    = $common_id;
                    $insert['goods_kuajingD_id'] = $kuajing_id;
                    $insert['goods_name']        = $update_common['goods_name'] . ' ' . implode(' ', $value['sp_value']);
                    $insert['goods_jingle']      = $update_common['goods_jingle'];
                    $insert['store_id']          = $_SESSION['store_id'];
                    $insert['store_name']        = $_SESSION['store_name'];
                    $insert['gc_id']             = $update_common['gc_id'];
                    $insert['gc_id_1']           = $update_common['gc_id_1'];
                    $insert['gc_id_2']           = $update_common['gc_id_2'];
                    $insert['gc_id_3']           = $update_common['gc_id_3'];
                    $insert['brand_id']          = $update_common['brand_id'];
                    $insert['goods_price']       = $value['price'];
					$insert['goods_app_price']   = $value['app_price'];
                    $insert['goods_promotion_price']=$value['price'];
                    $insert['goods_marketprice'] = $value['marketprice'] == 0 ? $update_common['goods_marketprice'] : $value['marketprice'];
                    $insert['goods_presalenum']  = $update_common['goods_presalenum'];
                    $insert['goods_serial']      = $value['sku'];
                    $insert['goods_storage_alarm']= intval($value['alarm']);
                    $insert['goods_spec']        = serialize($value['sp_value']);
                    $insert['goods_storage']     = $value['stock'];
                    $insert['goods_image']       = $update_common['goods_image'];
                    $insert['goods_state']       = $update_common['goods_state'];
                    $insert['goods_verify']      = $update_common['goods_verify'];
                    $insert['goods_addtime']     = TIMESTAMP;
                    $insert['goods_edittime']    = TIMESTAMP;
                    $insert['areaid_1']          = $update_common['areaid_1'];
                    $insert['areaid_2']          = $update_common['areaid_2'];
                    $insert['color_id']          = intval($value['color']);
                    $insert['transport_id']      = $update_common['transport_id'];
                    $insert['goods_freight']     = $update_common['goods_freight'];
                    $insert['goods_vat']         = $update_common['goods_vat'];
                    $insert['goods_commend']     = $update_common['goods_commend'];
                    $insert['goods_stcids']      = $update_common['goods_stcids'];
                    $insert['is_virtual']        = $update_common['is_virtual'];
                    $insert['virtual_indate']    = $update_common['virtual_indate'];
                    $insert['virtual_limit']     = $update_common['virtual_limit'];
                    $insert['virtual_invalid_refund'] = $update_common['virtual_invalid_refund'];
                    $insert['is_fcode']          = $update_common['is_fcode'];
                    $insert['is_appoint']        = $update_common['is_appoint'];
                    $insert['is_presell']        = $update_common['is_presell'];
                    $insert['is_own_shop']       = $update_common['is_own_shop'];
                    $insert['is_mode']          = $update_common['is_mode'];
                    if($insert['is_mode'] == 0) {$insert['goods_shipper_id'] = 0;}
                    else {$insert['goods_shipper_id']  = $update_common['goods_shipper_id'];}
                    
                    $insert['goods_hs']          = $update_common['goods_hs'];
                    //$insert['goods_tax']          = $update_common['goods_tax'];
                     $model_hs = Model('ctax_hs');
                    $xiaofei_rate = $model_hs->getfby_hs($update_common['goods_hs'],'xiaofei_rate');
                    $zengzhi_rate = $model_hs->getfby_hs($update_common['goods_hs'],'xiaofei_rate');
                    //综合税率
                    if($insert['is_mode'] == 0) {$insert['goods_tax_rate'] = 0;}
                    else {$insert['goods_tax_rate'] = $model_hs->getfby_hs($update_common['goods_hs'],'tax_rate');}
                    $tax_all = $model_hs->getgoodsTax($value['price'],$xiaofei_rate,$zengzhi_rate);
                    $insert['goods_tax'] = $tax_all['tax'];

                    $goods_id = $model_goods->addGoods($insert);
                        // 生成商品二维码
                        //$PhpQRCode->set('date',WAP_SITE_URL . '/tmpl/product_detail.html?goods_id='.$goods_id);
                        $PhpQRCode->set('date',WAP_SITE_URL . '/goods/goodsDetail.shtml?goodsId='.$goods_id);
                        $PhpQRCode->set('pngTempName', $goods_id . '.png');
                        $PhpQRCode->init();
                }
                $goodsid_array[] = intval($goods_id);
                $colorid_array[] = intval($value['color']);
                $model_type->addGoodsType($goods_id, $common_id, array('cate_id' => $_POST['cate_id'], 'type_id' => $_POST['type_id'], 'attr' => $_POST['attr']));
            }
        } else {
            $goods_info = $model_goods->getGoodsInfo(array('goods_spec' => serialize(null), 'goods_commonid' => $common_id, 'store_id' => $_SESSION['store_id']), 'goods_id');
            if (!empty($goods_info)) {
                $goods_id = $goods_info['goods_id'];
                $update = array ();
                $update['goods_commonid']    = $common_id;
                $update['goods_kuajingD_id'] = $kuajing_id;
                $update['goods_name']        = $update_common['goods_name'];
                $update['goods_jingle']      = $update_common['goods_jingle'];
                $update['store_id']          = $_SESSION['store_id'];
                $update['store_name']        = $_SESSION['store_name'];
                $update['gc_id']             = $update_common['gc_id'];
                $update['gc_id_1']           = $update_common['gc_id_1'];
                $update['gc_id_2']           = $update_common['gc_id_2'];
                $update['gc_id_3']           = $update_common['gc_id_3'];
                $update['brand_id']          = $update_common['brand_id'];
                $update['goods_price']       = $update_common['goods_price'];
				$update['goods_app_price']   = $update_common['goods_app_price'];
                $update['goods_marketprice'] = $update_common['goods_marketprice'];
                $update['goods_presalenum']  = $update_common['goods_presalenum'];
                $update['goods_serial']      = $update_common['goods_serial'];
                $update['goods_storage_alarm']= $update_common['goods_storage_alarm'];
                $update['goods_spec']        = serialize(null);
                $update['goods_storage']     = intval($_POST['g_storage']);
                $update['goods_state']       = $update_common['goods_state'];
                $update['goods_verify']      = $update_common['goods_verify'];
                $update['goods_edittime']    = TIMESTAMP;
                $update['areaid_1']          = $update_common['areaid_1'];
                $update['areaid_2']          = $update_common['areaid_2'];
                $update['color_id']          = 0;
                $update['transport_id']      = $update_common['transport_id'];
                $update['goods_freight']     = $update_common['goods_freight'];
                $update['goods_vat']         = $update_common['goods_vat'];
                $update['goods_commend']     = $update_common['goods_commend'];
                $update['goods_stcids']      = $update_common['goods_stcids'];
                $update['is_virtual']        = $update_common['is_virtual'];
                $update['virtual_indate']    = $update_common['virtual_indate'];
                $update['virtual_limit']     = $update_common['virtual_limit'];
                $update['virtual_invalid_refund'] = $update_common['virtual_invalid_refund'];
                $update['is_fcode']          = $update_common['is_fcode'];
                $update['is_appoint']        = $update_common['is_appoint'];
                $update['is_presell']        = $update_common['is_presell'];
                $update['is_mode']          = $update_common['is_mode'];
                if($update['is_mode'] == 0){$update['goods_shipper_id'] = 0;}
                else {$update['goods_shipper_id']  = $update_common['goods_shipper_id'];}
                
                $update['goods_hs']          = $update_common['goods_hs'];
                $update['goods_tax']          = $update_common['goods_tax'];
                $update['goods_tax_rate']          = $update_common['goods_tax_rate'];
                if ($update_common['is_virtual'] == 1) {
                    $update['have_gift']    = 0;
                    $model_gift->delGoodsGift(array('goods_id' => $goods_id));
                }
                $update['is_own_shop']       = $update_common['is_own_shop'];
                $model_goods->editGoodsById($update, $goods_id);
		 // 生成商品二维码
                    //$PhpQRCode->set('date',WAP_SITE_URL . '/tmpl/product_detail.html?goods_id='.$goods_id);
                    $PhpQRCode->set('date',WAP_SITE_URL . '/goods/goodsDetail.shtml?goodsId='.$goods_id);
                    $PhpQRCode->set('pngTempName', $goods_id . '.png');
                    $PhpQRCode->init();
		
            } else {
                $insert = array();
                $insert['goods_commonid']    = $common_id;
                $insert['goods_kuajingD_id'] = $kuajing_id;
                $insert['goods_name']        = $update_common['goods_name'];
                $insert['goods_jingle']      = $update_common['goods_jingle'];
                $insert['store_id']          = $_SESSION['store_id'];
                $insert['store_name']        = $_SESSION['store_name'];
                $insert['gc_id']             = $update_common['gc_id'];
                $insert['gc_id_1']           = $update_common['gc_id_1'];
                $insert['gc_id_2']           = $update_common['gc_id_2'];
                $insert['gc_id_3']           = $update_common['gc_id_3'];
                $insert['brand_id']          = $update_common['brand_id'];
                $insert['goods_price']       = $update_common['goods_price'];
				$insert['goods_app_price']   = $update_common['goods_app_price'];
                $insert['goods_promotion_price']=$update_common['goods_price'];
                $insert['goods_marketprice'] = $update_common['goods_marketprice'];
                $insert['goods_presalenum'] = $update_common['goods_presalenum'];
                $insert['goods_serial']      = $update_common['goods_serial'];
                $insert['goods_storage_alarm']= $update_common['goods_storage_alarm'];
                $insert['goods_spec']        = serialize(null);
                $insert['goods_storage']     = intval($_POST['g_storage']);
                $insert['goods_image']       = $update_common['goods_image'];
                $insert['goods_state']       = $update_common['goods_state'];
                $insert['goods_verify']      = $update_common['goods_verify'];
                $insert['goods_addtime']     = TIMESTAMP;
                $insert['goods_edittime']    = TIMESTAMP;
                $insert['areaid_1']          = $update_common['areaid_1'];
                $insert['areaid_2']          = $update_common['areaid_2'];
                $insert['color_id']          = 0;
                $insert['transport_id']      = $update_common['transport_id'];
                $insert['goods_freight']     = $update_common['goods_freight'];
                $insert['goods_vat']         = $update_common['goods_vat'];
                $insert['goods_commend']     = $update_common['goods_commend'];
                $insert['goods_stcids']      = $update_common['goods_stcids'];
                $insert['is_virtual']        = $update_common['is_virtual'];
                $insert['virtual_indate']    = $update_common['virtual_indate'];
                $insert['virtual_limit']     = $update_common['virtual_limit'];
                $insert['virtual_invalid_refund'] = $update_common['virtual_invalid_refund'];
                $insert['is_fcode']          = $update_common['is_fcode'];
                $insert['is_appoint']        = $update_common['is_appoint'];
                $insert['is_presell']        = $update_common['is_presell'];
                $insert['is_own_shop']       = $update_common['is_own_shop'];
                $insert['is_mode']          = $update_common['is_mode'];
                if($insert['is_mode'] == 0){$insert['goods_shipper_id'] = 0;}
                else {$insert['goods_shipper_id']  = $update_common['goods_shipper_id'];}
                
                $insert['goods_hs']          = $update_common['goods_hs'];
                $insert['goods_tax']          = $update_common['goods_tax'];
                $insert['goods_tax_rate']          = $update_common['goods_tax_rate'];
                $goods_id = $model_goods->addGoods($insert);
            }
            $goodsid_array[] = intval($goods_id);
            $colorid_array[] = 0;
            $model_type->addGoodsType($goods_id, $common_id, array('cate_id' => $_POST['cate_id'], 'type_id' => $_POST['type_id'], 'attr' => $_POST['attr']));
        }




         //车辆基本参数
        $goodsbasic_info = $model_goods->getbasicInfo($common_id);
        $basic=array();
        if(!empty($goodsbasic_info)){

            $basic['goods_commonid']=$common_id;
            // $basic['car_name']=$_POST['goods_name'];
            //$basic['car_guid_price']=$_POST['goods_price'];
            $basic['car_manufacturers']=$_POST['car_manufacturers'];
            $basic['car_level']=$_POST['car_level'];
            $basic['car_engine']=$_POST['car_engine'];
            $basic['car_gearbox']=$_POST['car_gearbox'];
            $basic['car_longwidehigh']=$_POST['car_longwidehigh'];
            $basic['car_body_structure']=$_POST['car_body_structure'];
            $basic['car_maxspeed']=$_POST['car_maxspeed'];
            $basic['office_accelerate']=$_POST['office_accelerate'];
            $basic['fact_accelerate']=$_POST['fact_accelerate'];
            $basic['fact_brake']=$_POST['fact_brake'];
            $basic['car_fuel']=$_POST['car_fuel'];
            $basic['car_intefuel']=$_POST['car_intefuel'];
            $basic['fact_ground_clearance']=$_POST['fact_ground_clearance'];
            $basic['vehicle_warranty']=$_POST['vehicle_warranty'];
            $car_id = $model_goods->editbaisc($basic, $common_id);
            if(empty($car_id)){
                showMessage('汽车基本参数编辑失败', getReferer(), 'html', 'error');
            }
        }else{
            $basic['goods_commonid']=$common_id;
            // $basic['car_name']=$common_array['goods_name'];
            // $basic['car_guid_price']=$common_array['goods_price'];
            $basic['car_manufacturers']=$_POST['car_manufacturers'];
            $basic['car_level']=$_POST['car_level'];
            $basic['car_engine']=$_POST['car_engine'];
            $basic['car_gearbox']=$_POST['car_gearbox'];
            $basic['car_longwidehigh']=$_POST['car_longwidehigh'];
            $basic['car_body_structure']=$_POST['car_body_structure'];
            $basic['car_maxspeed']=$_POST['car_maxspeed'];
            $basic['office_accelerate']=$_POST['office_accelerate'];
            $basic['fact_accelerate']=$_POST['fact_accelerate'];
            $basic['fact_brake']=$_POST['fact_brake'];
            $basic['car_fuel']=$_POST['car_fuel'];
            $basic['car_intefuel']=$_POST['car_intefuel'];
            $basic['fact_ground_clearance']=$_POST['fact_ground_clearance'];
            $basic['vehicle_warranty']=$_POST['vehicle_warranty'];
            $car_id = $model_goods->addbaisc($basic);
            if(empty($car_id)){
                showMessage('汽车基本参数添加失败', getReferer(), 'html', 'error');
            }
        }


          //车身
        $goodscarbody_info = $model_goods->getcarbodyInfo($common_id);
        $body=array();
        if(!empty($goodscarbody_info)){
            $body['car_length']=$_POST['car_length'];
            $body['car_width']=$_POST['car_width'];
            $body['car_height']=$_POST['car_height'];
            $body['car_wheelbase']=$_POST['car_wheelbase'];
            $body['front_track']=$_POST['front_track'];
            $body['rear_track']=$_POST['rear_track'];
            $body['min_ground_clearance']=$_POST['min_ground_clearance'];
            $body['curb_quality']=$_POST['curb_quality'];
            $body['body_structure']=$_POST['body_structure'];
            $body['car_doors_num']=$_POST['car_doors_num'];
            $body['car_seats_num']=$_POST['car_seats_num'];
            $body['fuel_capacity']=$_POST['fuel_capacity'];
            $body['car_luggage']=$_POST['car_luggage'];
            $body['goods_commonid']=$common_id;
            $body_id=$model_goods->editbody($body, $common_id);
            if(empty($body_id)){
                showMessage('汽车车身参数编辑失败', getReferer(), 'html', 'error');
            }
        }else{
            $body['car_length']=$_POST['car_length'];
            $body['car_width']=$_POST['car_width'];
            $body['car_height']=$_POST['car_height'];
            $body['car_wheelbase']=$_POST['car_wheelbase'];
            $body['front_track']=$_POST['front_track'];
            $body['rear_track']=$_POST['rear_track'];
            $body['min_ground_clearance']=$_POST['min_ground_clearance'];
            $body['curb_quality']=$_POST['curb_quality'];
            $body['body_structure']=$_POST['body_structure'];
            $body['car_doors_num']=$_POST['car_doors_num'];
            $body['car_seats_num']=$_POST['car_seats_num'];
            $body['fuel_capacity']=$_POST['fuel_capacity'];
            $body['car_luggage']=$_POST['car_luggage'];
            $body['goods_commonid']=$common_id;
            $body_id=$model_goods->body($body);
            if(empty($body_id)){
                showMessage('汽车车身参数添加失败', getReferer(), 'html', 'error');
            }
        }




           //发动机
        $goodsengine_info = $model_goods->getengineInfo($common_id);
        $engine=array();
        if(!empty($goodsengine_info)){
            $engine['goods_commonid']=$common_id;
            $engine['car_emodel']=$_POST['car_emodel'];
            $engine['car_displace']=$_POST['car_displace'];
            $engine['car_displacement']=$_POST['car_displacement'];
            $engine['car_airin']=$_POST['car_airin'];
            $engine['car_cylinder']=$_POST['car_cylinder'];
            $engine['car_ncylinders']=$_POST['car_ncylinders'];
            $engine['car_npcylinder']=$_POST['car_npcylinder'];
            $engine['car_ratio']=$_POST['car_ratio'];
            $engine['car_air_supply']=$_POST['car_air_supply'];
            $engine['car_bore']=$_POST['car_bore'];
            $engine['car_stroke']=$_POST['car_stroke'];
            $engine['car_mps']=$_POST['car_mps'];
            $engine['car_mkw']=$_POST['car_mkw'];
            $engine['car_mrpm']=$_POST['car_mrpm'];
            $engine['car_mNm']=$_POST['car_mNm'];
            $engine['car_mmrpm']=$_POST['car_mmrpm'];
            $engine['car_engine_technology']=$_POST['car_engine_technology'];
            $engine['car_fuel_form']=$_POST['car_fuel_form'];
            $engine['car_fuel_label']=$_POST['car_fuel_label'];
            $engine['car_oil_supply']=$_POST['car_oil_supply'];
            $engine['cylinder_head_material']=$_POST['cylinder_head_material'];
            $engine['cylinder_material']=$_POST['cylinder_material'];
            $engine['environmental_standards']=$_POST['environmental_standards'];
            $engine_id=$model_goods->editengine($engine, $common_id);
            if(empty($engine_id)){
                showMessage('汽车发动机参数编辑失败', getReferer(), 'html', 'error');
            }
        }else{
            $engine['goods_commonid']=$common_id;
            $engine['car_emodel']=$_POST['car_emodel'];
            $engine['car_displace']=$_POST['car_displace'];
            $engine['car_displacement']=$_POST['car_displacement'];
            $engine['car_airin']=$_POST['car_airin'];
            $engine['car_cylinder']=$_POST['car_cylinder'];
            $engine['car_ncylinders']=$_POST['car_ncylinders'];
            $engine['car_npcylinder']=$_POST['car_npcylinder'];
            $engine['car_ratio']=$_POST['car_ratio'];
            $engine['car_air_supply']=$_POST['car_air_supply'];
            $engine['car_bore']=$_POST['car_bore'];
            $engine['car_stroke']=$_POST['car_stroke'];
            $engine['car_mps']=$_POST['car_mps'];
            $engine['car_mkw']=$_POST['car_mkw'];
            $engine['car_mrpm']=$_POST['car_mrpm'];
            $engine['car_mNm']=$_POST['car_mNm'];
            $engine['car_mmrpm']=$_POST['car_mmrpm'];
            $engine['car_engine_technology']=$_POST['car_engine_technology'];
            $engine['car_fuel_form']=$_POST['car_fuel_form'];
            $engine['car_fuel_label']=$_POST['car_fuel_label'];
            $engine['car_oil_supply']=$_POST['car_oil_supply'];
            $engine['cylinder_head_material']=$_POST['cylinder_head_material'];
            $engine['cylinder_material']=$_POST['cylinder_material'];
            $engine['environmental_standards']=$_POST['environmental_standards'];
            $engine_id=$model_goods->engine($engine);
            if(empty($engine_id)){
                showMessage('汽车发动机参数添加失败', getReferer(), 'html', 'error');
            }
        }







        // 生成商品二维码
        if (!empty($goodsid_array)) {
            //QueueClient::push('createGoodsQRCode', array('store_id' => $_SESSION['store_id'], 'goodsid_array' => $goodsid_array));
             // 生成商品二维码
                    //$PhpQRCode->set('date',WAP_SITE_URL . '/tmpl/product_detail.html?goods_id='.$goods_id);
                    $PhpQRCode->set('date',WAP_SITE_URL . '/goods/goodsDetail.shtml?goodsId='.$goods_id);
                    $PhpQRCode->set('pngTempName', $goods_id . '.png');
                    $PhpQRCode->init();	
	}

        // 清理商品数据
        $model_goods->delGoods(array('goods_id' => array('not in', $goodsid_array), 'goods_commonid' => $common_id, 'store_id' => $_SESSION['store_id']));
        // 清理商品图片表
        $colorid_array = array_unique($colorid_array);
        $model_goods->delGoodsImages(array('goods_commonid' => $common_id, 'color_id' => array('not in', $colorid_array)));
        // 更新商品默认主图
        $default_image_list = $model_goods->getGoodsImageList(array('goods_commonid' => $common_id, 'is_default' => 1), 'color_id,goods_image');
        if (!empty($default_image_list)) {
            foreach ($default_image_list as $val) {
                $model_goods->editGoods(array('goods_image' => $val['goods_image']), array('goods_commonid' => $common_id, 'color_id' => $val['color_id']));
            }
        }

        // 商品加入上架队列
        if (isset($_POST['starttime'])) {
            $selltime = strtotime($_POST['starttime']) + intval($_POST['starttime_H'])*3600 + intval($_POST['starttime_i'])*60;
            if ($selltime > TIMESTAMP) {
                $this->addcron(array('exetime' => $selltime, 'exeid' => $common_id, 'type' => 1), true);
            }
        }
        // 添加操作日志
        $this->recordSellerLog('编辑商品，平台货号：'.$common_id);

        if ($update_common['is_virtual'] == 1 || $update_common['is_fcode'] == 1 || $update_common['is_presell'] == 1) {
            // 如果是特殊商品清理促销活动，抢购、限时折扣、组合销售
            QueueClient::push('clearSpecialGoodsPromotion', array('goods_commonid' => $common_id, 'goodsid_array' => $goodsid_array));
        } else {
            // 更新商品促销价格
            QueueClient::push('updateGoodsPromotionPriceByGoodsCommonId', $common_id);
        }

        // 生成F码
        if ($update_common['is_fcode'] == 1) {
            QueueClient::push('createGoodsFCode', array('goods_commonid' => $common_id, 'fc_count' => intval($_POST['g_fccount']), 'fc_prefix' => $_POST['g_fcprefix']));
        }
        $return = $model_goods->editGoodsCommon($update_common, array('goods_commonid' => $common_id, 'store_id' => $_SESSION['store_id']));
        if ($return) {
            //提交事务
            Model()->commit();
          //showDialog(L('nc_common_op_succ'), $_POST['ref_url'], 'succ');
            //redirect(urlShop('store_goods_online', 'edit_goods2', array('commonid' => $common_id)));
            showDialog(L('nc_common_op_succ'),urlShop('store_goods_online', 'edit_goods2', array('commonid' => $common_id)), 'succ');
        } else {
            //回滚事务
            Model()->rollback();
            showDialog(L('store_goods_index_goods_edit_fail'), urlShop('store_goods_online', 'index'));
        }
    }


    /**
     * 编辑商品第二个页面
     *
     */
    public function edit_goods2Op(){
        echo $_GET['commonid'];
        $common_id = $_GET['commonid'];
        $model_goods = Model('goods');
        //变速箱基本参数
        $goodsgearbox_info = $model_goods->getgearboxInfo($common_id);
        Tpl::output('gearbox', $goodsgearbox_info);
        //底盘转向基本参数
        $goodssteer_info = $model_goods->getsteerInfo($common_id);
        Tpl::output('steer', $goodssteer_info);
        //车轮制动基本参数
        $goodswheel_info = $model_goods->getwheelInfo($common_id);
        Tpl::output('wheel', $goodswheel_info);
        //主/被动安全装备基本参数
        $goodssafe_items_info = $model_goods->getsafe_itemsInfo($common_id);
        Tpl::output('safe_items', $goodssafe_items_info);
        //座椅配置基本参数
        $goodsseat_config_info = $model_goods->getseat_configInfo($common_id);
        Tpl::output('seat_config', $goodsseat_config_info);
        //多媒体配置基本参数
        $goodswmm_config_info = $model_goods->getwmm_configInfo($common_id);
        Tpl::output('wmm_config', $goodswmm_config_info);
        Tpl::output('edit_goods_sign', true);
        Tpl::output('common_id', $common_id);
        Tpl::showpage('store_goods_add.step22');
    }


    /**
     *保存商品第二个页面修改的数据
     *
     */
    public function save_edit_goods2Op(){
        $common_id = intval($_POST['common_id']);
        $model_goods = Model('goods');
        /*echo "<pre>";
        var_dump($_POST);
        echo "</pre>";
        die;*/

        //变速箱
        $goodsgearbox_info = $model_goods->getgearboxInfo($common_id);
        $gearbox=array();
        if(!empty($goodsgearbox_info)){

            $gearbox['goods_commonid']=$common_id;
            $gearbox['gearbox_referred']=$_POST['gearbox_referred'];
            $gearbox['car_gears_num']=$_POST['car_gears_num'];
            $gearbox['gearbox_type']=$_POST['gearbox_type'];
            $gearbox_id=$model_goods->edit_gearbox($gearbox,$common_id);
            if(empty($gearbox_id)){
                showMessage('汽车变速箱参数修改失败', getReferer(), 'html', 'error');
            }
        }else{
            $gearbox['goods_commonid']=$common_id;
            $gearbox['gearbox_referred']=$_POST['gearbox_referred'];
            $gearbox['car_gears_num']=$_POST['car_gears_num'];
            $gearbox['gearbox_type']=$_POST['gearbox_type'];
            $gearbox_id=$model_goods->gearbox($gearbox);
            if(empty($gearbox_id)){
                showMessage('汽车变速箱参数添加失败', getReferer(), 'html', 'error');
            }
        }




         //底盘转向
        $goodssteer_info = $model_goods->getsteerInfo($common_id);
        $steer=array();
        if(!empty($goodssteer_info)){
            $steer['goods_commonid']=$common_id;
            $steer['car_dirvemode']=$_POST['car_dirvemode'];
            $steer['front_suspension_type']=$_POST['front_suspension_type'];
            $steer['rear_suspension_type']=$_POST['rear_suspension_type'];
            $steer['car_powertype']=$_POST['car_powertype'];
            $steer['body_structure']=$_POST['body_structure'];
            $steer_id=$model_goods->edit_steer($steer,$common_id);
            if(empty($steer_id)){
                showMessage('汽车底盘转向参数编辑失败', getReferer(), 'html', 'error');
            }
        }else{
            $steer['goods_commonid']=$common_id;
            $steer['car_dirvemode']=$_POST['car_dirvemode'];
            $steer['front_suspension_type']=$_POST['front_suspension_type'];
            $steer['rear_suspension_type']=$_POST['rear_suspension_type'];
            $steer['car_powertype']=$_POST['car_powertype'];
            $steer['body_structure']=$_POST['body_structure'];
            $steer_id=$model_goods->steer($steer);
            if(empty($steer_id)){
                showMessage('汽车底盘转向参数添加失败', getReferer(), 'html', 'error');
            }
        }



        //车轮制动
        $goodswheel_info = $model_goods->getwheelInfo($common_id);
        $wheel=array();
        if(!empty($goodswheel_info)){
            $wheel['goods_commonid']=$common_id;
            $wheel['front_brake_type']=$_POST['front_brake_type'];
            $wheel['rear_brake_type']=$_POST['rear_brake_type'];
            $wheel['parking_brake_type']=$_POST['parking_brake_type'];
            $wheel['front_tire_type']=$_POST['front_tire_type'];
            $wheel['rear_tire_type']=$_POST['rear_tire_type'];
            $wheel['spare_tire_type']=$_POST['spare_tire_type'];
            $wheel_id=$model_goods->edit_wheel($wheel,$common_id);
            if(empty($wheel_id)){
                showMessage('汽车车轮制动参数编辑失败', getReferer(), 'html', 'error');
            }
        }else{
            $wheel['goods_commonid']=$common_id;
            $wheel['front_brake_type']=$_POST['front_brake_type'];
            $wheel['rear_brake_type']=$_POST['rear_brake_type'];
            $wheel['parking_brake_type']=$_POST['parking_brake_type'];
            $wheel['front_tire_type']=$_POST['front_tire_type'];
            $wheel['rear_tire_type']=$_POST['rear_tire_type'];
            $wheel['spare_tire_type']=$_POST['spare_tire_type'];
            $wheel_id=$model_goods->wheel($wheel);
            if(empty($wheel_id)){
                showMessage('汽车车轮制动参数添加失败', getReferer(), 'html', 'error');
            }
        }



        //安全装备
        $safe_item=array();
        $goodssafe_items_info = $model_goods->getsafe_itemsInfo($common_id);
        if(!empty($goodssafe_items_info)){
            $safe_item['goods_commonid']=$common_id;
            $safe_item['seat_srs']=$_POST['seat_srs'];
            $safe_item['side_srs']=$_POST['side_srs'];
            $safe_item['head_srs']=$_POST['head_srs'];
            $safe_item['knee_bolster']=$_POST['knee_bolster'];
            $safe_item['tpms']=$_POST['tpms'];
            $safe_item['zero_psi']=$_POST['zero_psi'];
            $safe_item['belt_notice']=$_POST['belt_notice'];
            $safe_item['isofix']=$_POST['isofix'];
            $safe_item['engine_safe']=$_POST['engine_safe'];
            $safe_item['central_lock']=$_POST['central_lock'];
            $safe_item['rke']=$_POST['rke'];
            $safe_item['peps']=$_POST['peps'];
            $safe_item['pke']=$_POST['pke'];
            $safe_id=$model_goods->edit_safe_item($safe_item,$common_id);
            if(empty($safe_id)){
                showMessage('汽车安全装备参数修改失败', getReferer(), 'html', 'error');
            }
        }else{
            $safe_item['goods_commonid']=$common_id;
            $safe_item['seat_srs']=$_POST['seat_srs'];
            $safe_item['side_srs']=$_POST['side_srs'];
            $safe_item['head_srs']=$_POST['head_srs'];
            $safe_item['knee_bolster']=$_POST['knee_bolster'];
            $safe_item['tpms']=$_POST['tpms'];
            $safe_item['zero_psi']=$_POST['zero_psi'];
            $safe_item['belt_notice']=$_POST['belt_notice'];
            $safe_item['isofix']=$_POST['isofix'];
            $safe_item['engine_safe']=$_POST['engine_safe'];
            $safe_item['central_lock']=$_POST['central_lock'];
            $safe_item['rke']=$_POST['rke'];
            $safe_item['peps']=$_POST['peps'];
            $safe_item['pke']=$_POST['pke'];
            $safe_id=$model_goods->safe_item($safe_item);
            if(empty($safe_id)){
                showMessage('汽车安全装备参数添加失败', getReferer(), 'html', 'error');
            }
        }


        //座椅配置
        $seat_congif=array();
        $goodsseat_config_info = $model_goods->getseat_configInfo($common_id);
        if(!empty($goodsseat_config_info)){
            $seat_congif['goods_commonid']=$common_id;
            $seat_congif['seat_mat']=$_POST['seat_mat'];
            $seat_congif['mov_seat']=$_POST['mov_seat'];
            $seat_congif['height_set']=$_POST['height_set'];
            $seat_congif['sup_set']=$_POST['sup_set'];
            $seat_congif['bear_sup_set']=$_POST['bear_sup_set'];
            $seat_congif['ele_set']=$_POST['ele_set'];
            $seat_congif['angle_set']=$_POST['angle_set'];
            $seat_congif['seat_mov']=$_POST['seat_mov'];
            $seat_congif['seat_ele_set']=$_POST['seat_ele_set'];
            $seat_congif['seat_memory']=$_POST['seat_memory'];
            $seat_congif['seat_heat']=$_POST['seat_heat'];
            $seat_congif['seat_dra']=$_POST['seat_dra'];
            $seat_congif['mas_seat']=$_POST['mas_seat'];
            $seat_congif['third_seat']=$_POST['third_seat'];
            $seat_congif['put_way']=$_POST['put_way'];
            $seat_congif['central_arm']=$_POST['central_arm'];
            $seat_congif['cup_holder']=$_POST['cup_holder'];
            $seat_congif_id=$model_goods->edit_seat_congifig($seat_congif,$common_id);
            if(empty($seat_congif_id)){
                showMessage('汽车座椅配置参数修改失败', getReferer(), 'html', 'error');
            }
        }else{
            $seat_congif['goods_commonid']=$common_id;
            $seat_congif['seat_mat']=$_POST['seat_mat'];
            $seat_congif['mov_seat']=$_POST['mov_seat'];
            $seat_congif['height_set']=$_POST['height_set'];
            $seat_congif['sup_set']=$_POST['sup_set'];
            $seat_congif['bear_sup_set']=$_POST['bear_sup_set'];
            $seat_congif['ele_set']=$_POST['ele_set'];
            $seat_congif['angle_set']=$_POST['angle_set'];
            $seat_congif['seat_mov']=$_POST['seat_mov'];
            $seat_congif['seat_ele_set']=$_POST['seat_ele_set'];
            $seat_congif['seat_memory']=$_POST['seat_memory'];
            $seat_congif['seat_heat']=$_POST['seat_heat'];
            $seat_congif['seat_dra']=$_POST['seat_dra'];
            $seat_congif['mas_seat']=$_POST['mas_seat'];
            $seat_congif['third_seat']=$_POST['third_seat'];
            $seat_congif['put_way']=$_POST['put_way'];
            $seat_congif['central_arm']=$_POST['central_arm'];
            $seat_congif['cup_holder']=$_POST['cup_holder'];
            $safe_congif_id=$model_goods->seat_congifig($seat_congif);
            if(empty($safe_congif_id)){
                showMessage('汽车座椅配置参数添加失败', getReferer(), 'html', 'error');
            }
        }

        //多媒体配置
        $wmm=array();
        $goodswmm_config_info = $model_goods->getwmm_configInfo($common_id);
        if(!empty($goodswmm_config_info)){
            $wmm['goods_commonid']=$common_id;
            $wmm['gps']=$_POST['gps'];
            $wmm['int_serv']=$_POST['int_serv'];
            $wmm['color_creen']=$_POST['color_creen'];
            $wmm['car_kit']=$_POST['car_kit'];
            $wmm['tv']=$_POST['tv'];
            $wmm['lcd']=$_POST['lcd'];
            $wmm['power']=$_POST['power'];
            $wmm['port']=$_POST['port'];
            $wmm['mp3']=$_POST['mp3'];
            $wmm['mat_sys']=$_POST['mat_sys'];
            $wmm['spk']=$_POST['spk'];
            $wmm['spk_number']=$_POST['spk_number'];
            $safe_congif_id=$model_goods->edit_wmm($wmm,$common_id);
            if(empty($safe_congif_id)){
                showMessage('汽车多媒体配置参数修改失败', getReferer(), 'html', 'error');
            }
        }else{
            $wmm['goods_commonid']=$common_id;
            $wmm['gps']=$_POST['gps'];
            $wmm['int_serv']=$_POST['int_serv'];
            $wmm['color_creen']=$_POST['color_creen'];
            $wmm['car_kit']=$_POST['car_kit'];
            $wmm['tv']=$_POST['tv'];
            $wmm['lcd']=$_POST['lcd'];
            $wmm['power']=$_POST['power'];
            $wmm['port']=$_POST['port'];
            $wmm['mp3']=$_POST['mp3'];
            $wmm['mat_sys']=$_POST['mat_sys'];
            $wmm['spk']=$_POST['spk'];
            $wmm['spk_number']=$_POST['spk_number'];
            $safe_congif_id=$model_goods->wmm($wmm);
            if(empty($safe_congif_id)){
                showMessage('汽车多媒体配置参数添加失败', getReferer(), 'html', 'error');
            }
        }

        if($safe_congif_id&$gearbox_id&$safe_id&$steer_id&$seat_congif_id&$steer_id){
            Model()->commit();
            showDialog(L('nc_common_op_succ'),urlShop('store_goods_online', 'edit_goods3', array('commonid' => $common_id)), 'succ');
        }else{
            //回滚事务
            Model()->rollback();
            showDialog(L('store_goods_index_goods_edit_fail'), urlShop('store_goods_online', 'index'));
        }



    }

    /**
     * 商品发布第三个页面
     *
     */
    public function edit_goods3Op(){
        $common_id = $_GET['commonid'];
        $model_goods = Model('goods');
        //内部配置基本参数
        $goodsinner_config_info = $model_goods->getinner_configInfo($common_id);
        Tpl::output('inner_config', $goodsinner_config_info);
        //外部/防盗配置基本参数
        $goodsexternal_config_info = $model_goods->getexternal_configInfo($common_id);
        Tpl::output('external_config', $goodsexternal_config_info);
        //操控配置基本参数
        $goodscontrol_config_info = $model_goods->getcontrol_configInfo($common_id);
        Tpl::output('control_config', $goodscontrol_config_info);
        //灯光配置基本参数
        $goodslight_config_info = $model_goods->getlight_configInfo($common_id);
        Tpl::output('light_config', $goodslight_config_info);
        //玻璃/后视镜基本参数
        $goodsrearview_mirror_info = $model_goods->getrearview_mirrorInfo($common_id);
        Tpl::output('rearview_mirror', $goodsrearview_mirror_info);
        //高科技配置基本参数
        $goodshigh_tech_config_info = $model_goods->gethigh_tech_configInfo($common_id);
        Tpl::output('high_tech_config', $goodshigh_tech_config_info);
        //空调/冰箱基本参数
        $goodsrefrigerator_info= $model_goods->getrefrigeratorInfo($common_id);
        Tpl::output('refrigerator',$goodsrefrigerator_info);
        Tpl::output('edit_goods_sign', true);
        Tpl::output('common_id', $common_id);
        Tpl::showpage('store_goods_add.step23');
    }


    /*
     * 编辑商品发布第三个页面
     *
     */
    public function save_edit_goods3Op(){
        $common_id = intval($_POST['common_id']);
        $model_goods = Model('goods');

        //内部配置
        $inner=array();
        $goodsinner_config_info = $model_goods->getinner_configInfo($common_id);
        if(!empty($goodsinner_config_info)){
            $inner['goods_commonid']=$common_id;
            $inner['lea_st_wheel']=$_POST['lea_st_wheel'];
            $inner['wel_adjust']=$_POST['wel_adjust'];
            $inner['wel_ele_adjust']=$_POST['wel_ele_adjust'];
            $inner['mfl']=$_POST['mfl'];
            $inner['wel_shift']=$_POST['wel_shift'];
            $inner['lhz']=$_POST['lhz'];
            $inner['wel_memory']=$_POST['wel_memory'];
            $inner['cru_control']=$_POST['cru_control'];
            $inner['park_radar']=$_POST['park_radar'];
            $inner['rev_video']=$_POST['rev_video'];
            $inner['com_screen']=$_POST['com_screen'];
            $inner['hud']=$_POST['hud'];
            $inner['lcd_panel']=$_POST['lcd_panel'];
            $inner_id=$model_goods->edit_inner_config($inner,$common_id);
            if(empty($inner_id)){
                showMessage('汽车内部配置参数修改失败', getReferer(), 'html', 'error');
            }
        }else{
            $inner['goods_commonid']=$common_id;
            $inner['lea_st_wheel']=$_POST['lea_st_wheel'];
            $inner['wel_adjust']=$_POST['wel_adjust'];
            $inner['wel_ele_adjust']=$_POST['wel_ele_adjust'];
            $inner['mfl']=$_POST['mfl'];
            $inner['wel_shift']=$_POST['wel_shift'];
            $inner['lhz']=$_POST['lhz'];
            $inner['wel_memory']=$_POST['wel_memory'];
            $inner['cru_control']=$_POST['cru_control'];
            $inner['park_radar']=$_POST['park_radar'];
            $inner['rev_video']=$_POST['rev_video'];
            $inner['com_screen']=$_POST['com_screen'];
            $inner['hud']=$_POST['hud'];
            $inner['lcd_panel']=$_POST['lcd_panel'];
            $inner_id=$model_goods->inner_config($inner);
            if(empty($inner_id)){
                showMessage('汽车内部配置参数添加失败', getReferer(), 'html', 'error');
            }
        }


        //外部/防盗配置
        $external=array();
        $goodsexternal_config_info = $model_goods->getexternal_configInfo($common_id);
        if(!empty($goodsexternal_config_info)){
            $external['goods_commonid']=$common_id;
            $external['ele_sunroof']=$_POST['ele_sunroof'];
            $external['pan_sunroof']=$_POST['pan_sunroof'];
            $external['motion_suite']=$_POST['motion_suite'];
            $external['alloy_rim']=$_POST['alloy_rim'];
            $external['suction_door']=$_POST['suction_door'];
            $external['siding_door']=$_POST['siding_door'];
            $external['ele_trunk']=$_POST['ele_trunk'];
            $external['ind_trunk']=$_POST['ind_trunk'];
            $external['roof_rack']=$_POST['roof_rack'];
            $external_id=$model_goods->edit_external($external,$common_id);
            if(empty($external_id)){
                showMessage('汽车外部/防盗配置参数修改失败', getReferer(), 'html', 'error');
            }
        }else{
            $external['goods_commonid']=$common_id;
            $external['ele_sunroof']=$_POST['ele_sunroof'];
            $external['pan_sunroof']=$_POST['pan_sunroof'];
            $external['motion_suite']=$_POST['motion_suite'];
            $external['alloy_rim']=$_POST['alloy_rim'];
            $external['suction_door']=$_POST['suction_door'];
            $external['siding_door']=$_POST['siding_door'];
            $external['ele_trunk']=$_POST['ele_trunk'];
            $external['ind_trunk']=$_POST['ind_trunk'];
            $external['roof_rack']=$_POST['roof_rack'];
            $external_id=$model_goods->external($external);
            if(empty($external_id)){
                showMessage('汽车外部/防盗配置参数添加失败', getReferer(), 'html', 'error');
            }
        }


        //操控配置
        $goodscontrol_config_info = $model_goods->getcontrol_configInfo($common_id);
        $array=array();
        if(!empty($goodscontrol_config_info)){
            $array['goods_commonid']=$common_id;
            $array['abs']=$_POST['abs'];
            $array['ebd']=$_POST['ebd'];
            $array['bas']=$_POST['bas'];
            $array['asr']=$_POST['asr'];
            $array['esp']=$_POST['esp'];
            $array['hac']=$_POST['hac'];
            $array['auto_hold']=$_POST['auto_hold'];
            $array['hdc']=$_POST['hdc'];
            $array['avs']=$_POST['avs'];
            $array['ecas']=$_POST['ecas'];
            $array['vgrs']=$_POST['vgrs'];
            $array['front_limit']=$_POST['front_limit'];
            $array['cent_diff_lock']=$_POST['cent_diff_lock'];
            $array['rear_limit']=$_POST['rear_limit'];
            $array_id = $model_goods->edit_control_config($array,$common_id);
            if(empty($array_id))
            {
                showMessage('汽车操控配置参数修改失败', getReferer(), 'html', 'error');
            }
        }else{
            $array['goods_commonid']=$common_id;
            $array['abs']=$_POST['abs'];
            $array['ebd']=$_POST['ebd'];
            $array['bas']=$_POST['bas'];
            $array['asr']=$_POST['asr'];
            $array['esp']=$_POST['esp'];
            $array['hac']=$_POST['hac'];
            $array['auto_hold']=$_POST['auto_hold'];
            $array['hdc']=$_POST['hdc'];
            $array['avs']=$_POST['avs'];
            $array['ecas']=$_POST['ecas'];
            $array['vgrs']=$_POST['vgrs'];
            $array['front_limit']=$_POST['front_limit'];
            $array['cent_diff_lock']=$_POST['cent_diff_lock'];
            $array['rear_limit']=$_POST['rear_limit'];
            $array_id = $model_goods->add_control_config($array);
            if(empty($array_id))
            {
                showMessage('汽车操控配置参数添加失败', getReferer(), 'html', 'error');
            }
        }



        //灯光配置
        $goodslight_config_info = $model_goods->getlight_configInfo($common_id);
        $num=array();
        if(!empty($goodslight_config_info)){
            $num['goods_commonid']=$common_id;
            $num['dip_helight']=$_POST['dip_helight'];
            $num['high_beam']=$_POST['high_beam'];
            $num['drl']=$_POST['drl'];
            $num['dist_light']=$_POST['dist_light'];
            $num['auto_helamp']=$_POST['auto_helamp'];
            $num['corn_lamp']=$_POST['corn_lamp'];
            $num['ste_helights']=$_POST['ste_helights'];
            $num['front_fog_lamp']=$_POST['front_fog_lamp'];
            $num['helight_adjust']=$_POST['helight_adjust'];
            $num['lean_device']=$_POST['lean_device'];
            $num['atmos_lamp']=$_POST['atmos_lamp'];
            $num_id = $model_goods->edit_light_config($num,$common_id);
            if(empty($num_id))
            {
                showMessage('汽车灯光配置参数修改失败', getReferer(), 'html', 'error');
            }
        }else{
            $num['goods_commonid']=$common_id;
            $num['dip_helight']=$_POST['dip_helight'];
            $num['high_beam']=$_POST['high_beam'];
            $num['drl']=$_POST['drl'];
            $num['dist_light']=$_POST['dist_light'];
            $num['auto_helamp']=$_POST['auto_helamp'];
            $num['corn_lamp']=$_POST['corn_lamp'];
            $num['ste_helights']=$_POST['ste_helights'];
            $num['front_fog_lamp']=$_POST['front_fog_lamp'];
            $num['helight_adjust']=$_POST['helight_adjust'];
            $num['lean_device']=$_POST['lean_device'];
            $num['atmos_lamp']=$_POST['atmos_lamp'];
            $num_id = $model_goods->add_light_config($num);
            if(empty($num_id))
            {
                showMessage('汽车灯光配置参数添加失败', getReferer(), 'html', 'error');
            }
        }



        //玻璃、后视镜
        $mirror=array();
        $goodsrearview_mirror_info = $model_goods->getrearview_mirrorInfo($common_id);
        if(!empty($goodsrearview_mirror_info)){
            $mirror['goods_commonid']=$common_id;
            $mirror['power_wind']=$_POST['power_wind'];
            $mirror['anti_pin_func']=$_POST['anti_pin_func'];
            $mirror['heat_pro_gla']=$_POST['heat_pro_gla'];
            $mirror['elec_control']=$_POST['elec_control'];
            $mirror['revw_mirr_heat']=$_POST['revw_mirr_heat'];
            $mirror['elec_fold_mirr']=$_POST['elec_fold_mirr'];
            $mirror['revw_mirr_my']=$_POST['revw_mirr_my'];
            $mirror['rear_win_sunshd']=$_POST['rear_win_sunshd'];
            $mirror['rear_sd_sun_curt']=$_POST['rear_sd_sun_curt'];
            $mirror['priv_glass']=$_POST['priv_glass'];
            $mirror['sun_visor']=$_POST['sun_visor'];
            $mirror['rear_wiper']=$_POST['rear_wiper'];
            $mirror['induc_wiper']=$_POST['induc_wiper'];
            $mirror_id=$model_goods->edit_mirror($mirror,$common_id);
            if(empty($mirror_id)){
                showMessage('汽车玻璃、后视镜配置参数修改失败', getReferer(), 'html', 'error');
            }
        }else{
            $mirror['goods_commonid']=$common_id;
            $mirror['power_wind']=$_POST['power_wind'];
            $mirror['anti_pin_func']=$_POST['anti_pin_func'];
            $mirror['heat_pro_gla']=$_POST['heat_pro_gla'];
            $mirror['elec_control']=$_POST['elec_control'];
            $mirror['revw_mirr_heat']=$_POST['revw_mirr_heat'];
            $mirror['elec_fold_mirr']=$_POST['elec_fold_mirr'];
            $mirror['revw_mirr_my']=$_POST['revw_mirr_my'];
            $mirror['rear_win_sunshd']=$_POST['rear_win_sunshd'];
            $mirror['rear_sd_sun_curt']=$_POST['rear_sd_sun_curt'];
            $mirror['priv_glass']=$_POST['priv_glass'];
            $mirror['sun_visor']=$_POST['sun_visor'];
            $mirror['rear_wiper']=$_POST['rear_wiper'];
            $mirror['induc_wiper']=$_POST['induc_wiper'];
            $mirror_id=$model_goods->mirror($mirror);
            if(empty($mirror_id)){
                showMessage('汽车外部/防盗配置参数添加失败', getReferer(), 'html', 'error');
            }
        }


        //高科技配置
        $high=array();
        $goodshigh_tech_config_info = $model_goods->gethigh_tech_configInfo($common_id);
        if(!empty($goodshigh_tech_config_info)){
            $high['goods_commonid']=$common_id;
            $high['auto_pa_ps']=$_POST['auto_pa_ps'];
            $high['en_st_sp']=$_POST['en_st_sp'];
            $high['auxiliary']=$_POST['auxiliary'];
            $high['ldws']=$_POST['ldws'];
            $high['act_brake']=$_POST['act_brake'];
            $high['scr_display']=$_POST['scr_display'];
            $high['ada_cruise']=$_POST['ada_cruise'];
            $high['pan_cam']=$_POST['pan_cam'];
            $high_id=$model_goods->edit_high($high,$common_id);
            if(empty($high_id)){
                showMessage('汽车高科技配置参数修改失败', getReferer(), 'html', 'error');
            }
        }else{
            $high['goods_commonid']=$common_id;
            $high['auto_pa_ps']=$_POST['auto_pa_ps'];
            $high['en_st_sp']=$_POST['en_st_sp'];
            $high['auxiliary']=$_POST['auxiliary'];
            $high['ldws']=$_POST['ldws'];
            $high['act_brake']=$_POST['act_brake'];
            $high['scr_display']=$_POST['scr_display'];
            $high['ada_cruise']=$_POST['ada_cruise'];
            $high['pan_cam']=$_POST['pan_cam'];
            $high_id=$model_goods->high($high);
            if(empty($high_id)){
                showMessage('汽车高科技配置参数添加失败', getReferer(), 'html', 'error');
            }
        }


        //空调/冰箱
        $refrigerator=array();
        $goodsrefrigerator_info= $model_goods->getrefrigeratorInfo($common_id);
        if(!empty($goodsrefrigerator_info)){
            $refrigerator['goods_commonid']=$common_id;
            $refrigerator['con_metd']=$_POST['con_metd'];
            $refrigerator['bac_row_air_cond']=$_POST['bac_row_air_cond'];
            $refrigerator['rear_outlet']=$_POST['rear_outlet'];
            $refrigerator['temp_zone_con']=$_POST['temp_zone_con'];
            $refrigerator['pollen_filtra']=$_POST['pollen_filtra'];
            $refrigerator['car_refrig']=$_POST['car_refrig'];
            $refrigerator_id=$model_goods->edit_refrigerator($refrigerator,$common_id);
            if(empty($refrigerator_id)){
                showMessage('汽车空调/冰箱配置参数修改失败', getReferer(), 'html', 'error');
            }
        }else{
            $refrigerator['goods_commonid']=$common_id;
            $refrigerator['con_metd']=$_POST['con_metd'];
            $refrigerator['bac_row_air_cond']=$_POST['bac_row_air_cond'];
            $refrigerator['rear_outlet']=$_POST['rear_outlet'];
            $refrigerator['temp_zone_con']=$_POST['temp_zone_con'];
            $refrigerator['pollen_filtra']=$_POST['pollen_filtra'];
            $refrigerator['car_refrig']=$_POST['car_refrig'];
            $refrigerator_id=$model_goods->refrigerator($refrigerator);
            if(empty($refrigerator_id)){
                showMessage('汽车空调/冰箱配置参数添加失败', getReferer(), 'html', 'error');
            }
        }



        if($inner_id&$high_id&$refrigerator_id&$mirror_id&$num_id&$array_id&$external_id){
            Model()->commit();
            showDialog(L('nc_common_op_succ'), urlShop('store_goods_online', 'index'), 'succ');
        }else{
            //回滚事务
            Model()->rollback();
            showDialog(L('store_goods_index_goods_edit_fail'), urlShop('store_goods_online', 'index'));
        }



    }




    /**
     * 编辑图片
     */
    public function edit_imageOp() {
        $common_id = intval($_GET['commonid']);
        if ($common_id <= 0) {
            showMessage(L('wrong_argument'), urlShop('seller_center'), 'html', 'error');
        }
        $model_goods = Model('goods');
        $common_list = $model_goods->getGoodeCommonInfoByID($common_id, 'store_id,goods_lock,spec_value,is_virtual,is_fcode,is_presell');
        if ($common_list['store_id'] != $_SESSION['store_id'] || $common_list['goods_lock'] == 1) {
            showMessage(L('wrong_argument'), urlShop('seller_center'), 'html', 'error');
        }
        
        $spec_value = unserialize($common_list['spec_value']);
        Tpl::output('value', $spec_value['1']);

        $image_list = $model_goods->getGoodsImageList(array('goods_commonid' => $common_id));
        $image_list = array_under_reset($image_list, 'color_id', 2);

        $img_array = $model_goods->getGoodsList(array('goods_commonid' => $common_id), 'color_id,goods_image', 'color_id');
        // 整理，更具id查询颜色名称
        if (!empty($img_array)) {
            foreach ($img_array as $val) {
                if (isset($image_list[$val['color_id']])) {
                    $image_array[$val['color_id']] = $image_list[$val['color_id']];
                } else {
                    $image_array[$val['color_id']][0]['goods_image'] = $val['goods_image'];
                    $image_array[$val['color_id']][0]['is_default'] = 1;
                }
                $colorid_array[] = $val['color_id'];
            }
        }
        Tpl::output('img', $image_array);


        $model_spec = Model('spec');
        $value_array = $model_spec->getSpecValueList(array('sp_value_id' => array('in', $colorid_array), 'store_id' => $_SESSION['store_id']), 'sp_value_id,sp_value_name');
        if (empty($value_array)) {
            $value_array[] = array('sp_value_id' => '0', 'sp_value_name' => '无颜色');
        }
        Tpl::output('value_array', $value_array);

        Tpl::output('commonid', $common_id);

        $menu_promotion = array(
                'lock' => $common_list['goods_lock'] == 1 ? true : false,
                'gift' => $model_goods->checkGoodsIfAllowGift($common_list),
                'combo' => $model_goods->checkGoodsIfAllowCombo($common_list)
        );
        $this->profile_menu('edit_detail', 'edit_image', $menu_promotion);
        Tpl::output('edit_goods_sign', true);
        Tpl::showpage('store_goods_add.step3');
    }

    /**
     * 保存商品图片
     */
    public function edit_save_imageOp() {
        if (chksubmit()) {
            $common_id = intval($_POST['commonid']);
            if ($common_id <= 0 || empty($_POST['img'])) {
                showDialog(L('wrong_argument'), urlShop('store_goods_online', 'index'));
            }
            $model_goods = Model('goods');
            // 删除原有图片信息
            $model_goods->delGoodsImages(array('goods_commonid' => $common_id, 'store_id' => $_SESSION['store_id']));
            // 保存
            $insert_array = array();
            foreach ($_POST['img'] as $key => $value) {
                foreach ($value as $v) {
                    if ($v['name'] == '') {
                        continue;
                    }
                    //$k = 0;
                    // 商品默认主图
                    $update_array = array();        // 更新商品主图
                    $update_where = array();
                    $update_array['goods_image']    = $v['name'];
                    $update_where['goods_commonid'] = $common_id;
                    $update_where['store_id']       = $_SESSION['store_id'];
                    $update_where['color_id']       = $key;
                    if ($k == 0 || $v['default'] == 1) {
                        $k++;
                        $update_array['goods_image']    = $v['name'];
                        $update_where['goods_commonid'] = $common_id;
                        $update_where['store_id']       = $_SESSION['store_id'];
                        $update_where['color_id']       = $key;
                        // 更新商品主图
                        $model_goods->editGoods($update_array, $update_where);
                    }
                    $tmp_insert = array();
                    $tmp_insert['goods_commonid']   = $common_id;
                    $tmp_insert['store_id']         = $_SESSION['store_id'];
                    $tmp_insert['color_id']         = $key;
                    $tmp_insert['goods_image']      = $v['name'];
                    $tmp_insert['goods_image_sort'] = ($v['default'] == 1) ? 0 : $v['sort'];
                    $tmp_insert['is_default']       = $v['default'];
                    $insert_array[] = $tmp_insert;
                }
            }
            $rs = $model_goods->addGoodsImagesAll($insert_array);
            if ($rs) {
            // 添加操作日志
            $this->recordSellerLog('编辑商品，平台货号：'.$common_id);
                showDialog(L('nc_common_op_succ'), $_POST['ref_url'], 'succ');
            } else {
                showDialog(L('nc_common_save_fail'), urlShop('store_goods_online', 'index'));
            }
        }
    }

    /**
     * 编辑分类
     */
    public function edit_classOp() {
        // 实例化商品分类模型
        $model_goodsclass = Model('goods_class');
        // 商品分类
        $goods_class = $model_goodsclass->getGoodsClass($_SESSION['store_id']);

        // 常用商品分类
        $model_staple = Model('goods_class_staple');
        $param_array = array();
        $param_array['member_id'] = $_SESSION['member_id'];
        $staple_array = $model_staple->getStapleList($param_array);

        Tpl::output('staple_array', $staple_array);
        Tpl::output('goods_class', $goods_class);

        Tpl::output('commonid', $_GET['commonid']);
        $this->profile_menu('edit_class', 'edit_class');
        Tpl::output('edit_goods_sign', true);
        Tpl::showpage('store_goods_add.step1');
    }

    /**
     * 删除商品
     */
    public function drop_goodsOp() {
        $common_id = $this->checkRequestCommonId($_GET['commonid']);
        $commonid_array = explode(',', $common_id);
        $model_goods = Model('goods');
        $where = array();
        $where['goods_commonid'] = array('in', $commonid_array);
        $where['store_id'] = $_SESSION['store_id'];
        $return = $model_goods->delGoodsNoLock($where);
        if ($return) {
            // 添加操作日志
            $this->recordSellerLog('删除商品，平台货号：'.$common_id);
            showDialog(L('store_goods_index_goods_del_success'), 'reload', 'succ');
        } else {
            showDialog(L('store_goods_index_goods_del_fail'), '', 'error');
        }
    }

    /**
     * 商品下架
     */
    public function goods_unshowOp() {
        $common_id = $this->checkRequestCommonId($_GET['commonid']);
        $commonid_array = explode(',', $common_id);
        $model_goods = Model('goods');
        $where = array();
        $where['goods_commonid'] = array('in', $commonid_array);
        $where['store_id'] = $_SESSION['store_id'];
        $return = Model('goods')->editProducesOffline($where);
        if ($return) {
            // 更新优惠套餐状态关闭
            $goods_list = $model_goods->getGoodsList($where, 'goods_id');
            if (!empty($goods_list)) {
                $goodsid_array = array();
                foreach ($goods_list as $val) {
                    $goodsid_array[] = $val['goods_id'];
                }
                Model('p_bundling')->editBundlingCloseByGoodsIds(array('goods_id' => array('in', $goodsid_array)));
            }
            // 添加操作日志
            $this->recordSellerLog('商品下架，平台货号：'.$common_id);
            showDialog(L('store_goods_index_goods_unshow_success'), getReferer() ? getReferer() : 'index.php?act=store_goods_online&op=goods_list', 'succ', '', 2);
        } else {
            showDialog(L('store_goods_index_goods_unshow_fail'), '', 'error');
        }
    }

    /**
     * 设置广告词
     */
    public function edit_jingleOp() {
        if (chksubmit()) {
            $common_id = $this->checkRequestCommonId($_POST['commonid']);
            $commonid_array = explode(',', $common_id);
            $where = array('goods_commonid' => array('in', $commonid_array), 'store_id' => $_SESSION['store_id']);
            $update = array('goods_jingle' => trim($_POST['g_jingle']));
            $return = Model('goods')->editProducesNoLock($where, $update);
            if ($return) {
                // 添加操作日志
                $this->recordSellerLog('设置广告词，平台货号：'.$common_id);
                showDialog(L('nc_common_op_succ'), 'reload', 'succ');
            } else {
                showDialog(L('nc_common_op_fail'), 'reload');
            }
        }
        $common_id = $this->checkRequestCommonId($_GET['commonid']);

        Tpl::showpage('store_goods_list.edit_jingle', 'null_layout');
    }

    /**
     * 设置关联版式
     */
    public function edit_plateOp() {
        if (chksubmit()) {
            $common_id = $this->checkRequestCommonId($_POST['commonid']);
            $commonid_array = explode(',', $common_id);
            $where = array('goods_commonid' => array('in', $commonid_array), 'store_id' => $_SESSION['store_id']);
            $update = array();
            $update['plateid_top']        = intval($_POST['plate_top']) > 0 ? intval($_POST['plate_top']) : '';
            $update['plateid_bottom']     = intval($_POST['plate_bottom']) > 0 ? intval($_POST['plate_bottom']) : '';
            $return = Model('goods')->editGoodsCommon($update, $where);
            if ($return) {
                // 添加操作日志
                $this->recordSellerLog('设置关联版式，平台货号：'.$common_id);
                showDialog(L('nc_common_op_succ'), 'reload', 'succ');
            } else {
                showDialog(L('nc_common_op_fail'), 'reload');
            }
        }
        $common_id = $this->checkRequestCommonId($_GET['commonid']);

        // 关联版式
        $plate_list = Model('store_plate')->getStorePlateList(array('store_id' => $_SESSION['store_id']), 'plate_id,plate_name,plate_position');
        $plate_list = array_under_reset($plate_list, 'plate_position', 2);
        Tpl::output('plate_list', $plate_list);

        Tpl::showpage('store_goods_list.edit_plate', 'null_layout');
    }

    /**
     * 添加赠品
     */
    public function add_giftOp() {
        $common_id = intval($_GET['commonid']);
        if ($common_id <= 0) {
            showMessage(L('wrong_argument'), urlShop('seller_center'), 'html', 'error');
        }
        $model_goods = Model('goods');
        $goodscommon_info = $model_goods->getGoodeCommonInfoByID($common_id, 'store_id,goods_lock');
        if (empty($goodscommon_info) || $goodscommon_info['store_id'] != $_SESSION['store_id']) {
            showMessage(L('wrong_argument'), urlShop('seller_center'), 'html', 'error');
        }

        // 商品列表
        $goods_array = $model_goods->getGoodsListForPromotion(array('goods_commonid' => $common_id), '*', 0, 'gift');
        Tpl::output('goods_array', $goods_array);

        // 赠品列表
        $gift_list = Model('goods_gift')->getGoodsGiftList(array('goods_commonid' => $common_id));
        $gift_array = array();
        if (!empty($gift_list)) {
            foreach ($gift_list as $val) {
                $gift_array[$val['goods_id']][] = $val;
            }
        }
        Tpl::output('gift_array', $gift_array);
        $menu_promotion = array(
                'lock' => $goodscommon_info['goods_lock'] == 1 ? true : false,
                'gift' => $model_goods->checkGoodsIfAllowGift($goods_array[0]),
                'combo' => $model_goods->checkGoodsIfAllowCombo($goods_array[0])
        );
        $this->profile_menu('edit_detail', 'add_gift', $menu_promotion);
        Tpl::showpage('store_goods_edit.add_gift');
    }

    /**
     * 保存赠品
     */
    public function save_giftOp() {
        if (!chksubmit()) {
            showDialog(L('wrong_argument'));
        }
        $data = $_POST['gift'];
        $commonid = intval($_POST['commonid']);
        if ($commonid <= 0) {
            showDialog(L('wrong_argument'));
        }

        $model_goods = Model('goods');
        $model_gift = Model('goods_gift');

        // 验证商品是否存在
        $goods_list = $model_goods->getGoodsListForPromotion(array('goods_commonid' => $commonid, 'store_id' => $_SESSION['store_id']), 'goods_id', 0, 'gift');
        if (empty($goods_list)) {
            showDialog(L('wrong_argument'));
        }
        // 删除该商品原有赠品
        $model_gift->delGoodsGift(array('goods_commonid' => $commonid));
        // 重置商品礼品标记
        $model_goods->editGoods(array('have_gift' => 0), array('goods_commonid' => $commonid));
        // 商品id
        $goodsid_array = array();
        foreach ($goods_list as $val) {
            $goodsid_array[] = $val['goods_id'];
        }

        $insert = array();
        $update_goodsid = array();
        foreach ($data as $key => $val) {

            $owner_gid = intval($key);  // 主商品id
            // 验证主商品是否为本店铺商品,如果不是本店商品继续下一个循环
            if (!in_array($owner_gid, $goodsid_array)) {
                continue;
            }
            $update_goodsid[] = $owner_gid;
            foreach ($val as $k => $v) {
                $gift_gid = intval($k); // 礼品id
                // 验证赠品是否为本店铺商品，如果不是本店商品继续下一个循环
                $gift_info = $model_goods->getGoodsInfoByID($gift_gid, 'goods_name,store_id,goods_image,is_virtual,is_fcode,is_presell');
                $is_general = $model_goods->checkIsGeneral($gift_info);     // 验证是否为普通商品
                if ($gift_info['store_id'] != $_SESSION['store_id'] || $is_general == false) {
                    continue;
                }

                $array = array();
                $array['goods_id'] = $owner_gid;
                $array['goods_commonid'] = $commonid;
                $array['gift_goodsid'] = $gift_gid;
                $array['gift_goodsname'] = $gift_info['goods_name'];
                $array['gift_goodsimage'] = $gift_info['goods_image'];
                $array['gift_amount'] = intval($v);
                $insert[] = $array;
            }
        }
        // 插入数据
        if (!empty($insert)) $model_gift->addGoodsGiftAll($insert);
        // 更新商品赠品标记
        if (!empty($update_goodsid)) $model_goods->editGoodsById(array('have_gift' => 1), $update_goodsid);
        showDialog(L('nc_common_save_succ'), $_POST['ref_url'], 'succ');
    }

    /**
     * 推荐搭配
     */
    public function add_comboOp() {
        $common_id = intval($_GET['commonid']);
        if ($common_id <= 0) {
            showMessage(L('wrong_argument'), urlShop('seller_center'), 'html', 'error');
        }
        $model_goods = Model('goods');
        $goodscommon_info = $model_goods->getGoodeCommonInfoByID($common_id, 'store_id,goods_lock');
        if (empty($goodscommon_info) || $goodscommon_info['store_id'] != $_SESSION['store_id']) {
            showMessage(L('wrong_argument'), urlShop('seller_center'), 'html', 'error');
        }

        $goods_array = $model_goods->getGoodsListForPromotion(array('goods_commonid' => $common_id), '*', 0, 'combo');
        Tpl::output('goods_array', $goods_array);

        // 推荐组合商品列表
        $combo_list = Model('goods_combo')->getGoodsComboList(array('goods_commonid' => $common_id));
        $combo_goodsid_array = array();
        if (!empty($combo_list)) {
            foreach ($combo_list as $val) {
                $combo_goodsid_array[] = $val['combo_goodsid'];
            }
        }

        $combo_goods_array = $model_goods->getGeneralGoodsList(array('goods_id' => array('in', $combo_goodsid_array)), 'goods_id,goods_name,goods_image,goods_price');
        $combo_goods_list = array();
        if (!empty($combo_goods_array)) {
            foreach ($combo_goods_array as $val) {
                $combo_goods_list[$val['goods_id']] = $val;
            }
        }

        $combo_array = array();
        foreach ($combo_list as $val) {
            $combo_array[$val['goods_id']][] = $combo_goods_list[$val['combo_goodsid']];
        }
        Tpl::output('combo_array', $combo_array);

        $menu_promotion = array(
                'lock' => $goodscommon_info['goods_lock'] == 1 ? true : false,
                'gift' => $model_goods->checkGoodsIfAllowGift($goods_array[0]),
                'combo' => $model_goods->checkGoodsIfAllowCombo($goods_array[0])
        );
        $this->profile_menu('edit_detail', 'add_combo', $menu_promotion);
        Tpl::showpage('store_goods_edit.add_combo');
    }

    /**
     * 保存赠品
     */
    public function save_comboOp() {
        if (!chksubmit()) {
            showDialog(L('wrong_argument'));
        }
        $data = $_POST['combo'];
        $commonid = intval($_POST['commonid']);
        if ($commonid <= 0) {
            showDialog(L('wrong_argument'));
        }

        $model_goods = Model('goods');
        $model_combo = Model('goods_combo');

        // 验证商品是否存在
        $goods_list = $model_goods->getGoodsListForPromotion(array('goods_commonid' => $commonid, 'store_id' => $_SESSION['store_id']), 'goods_id', 0, 'combo');
        if (empty($goods_list)) {
            showDialog(L('wrong_argument'));
        }
        // 删除该商品原有赠品
        $model_combo->delGoodsCombo(array('goods_commonid' => $commonid));
        // 商品id
        $goodsid_array = array();
        foreach ($goods_list as $val) {
            $goodsid_array[] = $val['goods_id'];
        }

        $insert = array();
        if (!empty($data)) {
            foreach ($data as $key => $val) {
    
                $owner_gid = intval($key);  // 主商品id
                // 验证主商品是否为本店铺商品,如果不是本店商品继续下一个循环
                if (!in_array($owner_gid, $goodsid_array)) {
                    continue;
                }
                $val = array_unique($val);
                foreach ($val as $v) {
                    $combo_gid = intval($v); // 礼品id
                    // 验证推荐组合商品是否为本店铺商品，如果不是本店商品继续下一个循环
                    $combo_info = $model_goods->getGoodsInfoByID($combo_gid, 'store_id,is_virtual,is_fcode,is_presell');
                    $is_general = $model_goods->checkIsGeneral($combo_info);     // 验证是否为普通商品
                    if ($combo_info['store_id'] != $_SESSION['store_id'] || $is_general == false || $owner_gid ==$combo_gid) {
                        continue;
                    }
    
                    $array = array();
                    $array['goods_id'] = $owner_gid;
                    $array['goods_commonid'] = $commonid;
                    $array['combo_goodsid'] = $combo_gid;
                    $insert[] = $array;
                }
            }
            // 插入数据
            $model_combo->addGoodsComboAll($insert);
        }
        showDialog(L('nc_common_save_succ'), $_POST['ref_url'], 'succ');
    }

    /**
     * 搜索商品（添加赠品/推荐搭配)
     */
    public function search_goodsOp() {
        $where = array();
        $where['store_id'] = $_SESSION['store_id'];
        if ($_POST['name']) {
            $where['goods_name'] = array('like', '%'. $_POST['name'] .'%');
        }
        $model_goods = Model('goods');
        $goods_list = $model_goods->getGeneralGoodsList($where, '*', 5);
        Tpl::output('show_page', $model_goods->showpage(2));
        Tpl::output('goods_list', $goods_list);
        Tpl::showpage('store_goods_edit.search_goods', 'null_layout');
    }
    
    /**
     * 下载F码
     */
    public function download_f_code_excelOp() {
        $common_id = $_GET['commonid'];
        if ($common_id <= 0) {
            showMessage(L('wrong_argument'), '', '', 'error');
        }
        $common_info = Model('goods')->getGoodeCommonInfoByID($common_id);
        if (empty($common_info) || $common_info['store_id'] != $_SESSION['store_id']) {
            showMessage(L('wrong_argument'), '', '', 'error');
        }
        import('libraries.excel');
        $excel_obj = new Excel();
        $excel_data = array();
        //设置样式
        $excel_obj->setStyle(array('id'=>'s_title','Font'=>array('FontName'=>'宋体','Size'=>'12','Bold'=>'1')));
        //header
        $excel_data[0][] = array('styleid'=>'s_title','data'=>'号码');
        $excel_data[0][] = array('styleid'=>'s_title','data'=>'使用状态');
        $data = Model('goods_fcode')->getGoodsFCodeList(array('goods_commonid' => $common_id));
        foreach ($data as $k=>$v){
            $tmp = array();
            $tmp[] = array('data'=>$v['fc_code']);
            $tmp[] = array('data'=>$v['fc_state'] ? '已使用' : '未使用');
            $excel_data[] = $tmp;
        }
        $excel_data = $excel_obj->charset($excel_data,CHARSET);
        $excel_obj->addArray($excel_data);
        $excel_obj->addWorksheet($excel_obj->charset($common_info['goods_name'],CHARSET));
        $excel_obj->generateXML($excel_obj->charset($common_info['goods_name'],CHARSET).'-'.date('Y-m-d-H',time()));
    }

    /**
     * 验证commonid
     */
    private function checkRequestCommonId($common_ids) {
        if (!preg_match('/^[\d,]+$/i', $common_ids)) {
            showDialog(L('para_error'), '', 'error');
        }
        return $common_ids;
    }

    /**
     * ajax获取商品列表
     */
    public function get_goods_list_ajaxOp() {
        $common_id = $_GET['commonid'];
        if ($common_id <= 0) {
            echo 'false';exit();
        }
        $model_goods = Model('goods');
        $goodscommon_list = $model_goods->getGoodeCommonInfoByID($common_id, 'spec_name,store_id');
        if (empty($goodscommon_list) || $goodscommon_list['store_id'] != $_SESSION['store_id']) {
            echo 'false';exit();
        }
        $goods_list = $model_goods->getGoodsList(array('store_id' => $_SESSION['store_id'], 'goods_commonid' => $common_id), 'goods_id,goods_spec,store_id,goods_price,goods_serial,goods_storage_alarm,goods_storage,goods_image');
        if (empty($goods_list)) {
            echo 'false';exit();
        }

        $spec_name = array_values((array)unserialize($goodscommon_list['spec_name']));
        foreach ($goods_list as $key => $val) {
            $goods_spec = array_values((array)unserialize($val['goods_spec']));
            $spec_array = array();
            foreach ($goods_spec as $k => $v) {
                $spec_array[] = '<div class="goods_spec">' . $spec_name[$k] . L('nc_colon') . '<em title="' . $v . '">' . $v .'</em>' . '</div>';
            }
            $goods_list[$key]['goods_image'] = thumb($val, '60');
            $goods_list[$key]['goods_spec'] = implode('', $spec_array);
            $goods_list[$key]['alarm'] = ($val['goods_storage_alarm'] != 0 && $val['goods_storage'] <= $val['goods_storage_alarm']) ? 'style="color:red;"' : '';
            $goods_list[$key]['url'] = urlShop('goods', 'index', array('goods_id' => $val['goods_id']));
        }

        /**
         * 转码
         */
        if (strtoupper(CHARSET) == 'GBK') {
            Language::getUTF8($goods_list);
        }
        echo json_encode($goods_list);
    }

    /**
     * 用户中心右边，小导航
     *
     * @param string $menu_type 导航类型
     * @param string $menu_key 当前导航的menu_key
     * @param boolean $allow_promotion
     * @return
     */
    private function profile_menu($menu_type,$menu_key, $allow_promotion = array()) {
        $menu_array = array();
        switch ($menu_type) {
            case 'goods_list':
                $menu_array = array(
                   array('menu_key' => 'goods_list',    'menu_name' => '出售中的商品', 'menu_url' => urlShop('store_goods_online', 'index'))
                );
                break;
            case 'edit_detail':
                if ($allow_promotion['lock'] === false) {
                    $menu_array = array(
                        array('menu_key' => 'edit_detail',  'menu_name' => '编辑商品', 'menu_url' => urlShop('store_goods_online', 'edit_goods', array('commonid' => $_GET['commonid'], 'ref_url' => $_GET['ref_url']))),
                        array('menu_key' => 'edit_image',   'menu_name' => '编辑图片', 'menu_url' => urlShop('store_goods_online', 'edit_image', array('commonid' => $_GET['commonid'], 'ref_url' => ($_GET['ref_url'] ? $_GET['ref_url'] : getReferer())))),
                    );
                }
                if ($allow_promotion['gift']) {
                    $menu_array[] = array('menu_key' => 'add_gift', 'menu_name' => '赠送赠品', 'menu_url' => urlShop('store_goods_online', 'add_gift', array('commonid' => $_GET['commonid'], 'ref_url' => ($_GET['ref_url'] ? $_GET['ref_url'] : getReferer()))));
                }
                if ($allow_promotion['combo']) {
                    $menu_array[] = array('menu_key' => 'add_combo', 'menu_name' => '推荐组合', 'menu_url' => urlShop('store_goods_online', 'add_combo', array('commonid' => $_GET['commonid'], 'ref_url' => ($_GET['ref_url'] ? $_GET['ref_url'] : getReferer()))));
                }
                break;
            case 'edit_class':
                $menu_array = array(
                    array('menu_key' => 'edit_class',   'menu_name' => '选择分类', 'menu_url' => urlShop('store_goods_online', 'edit_class', array('commonid' => $_GET['commonid'], 'ref_url' => $_GET['ref_url']))),
                    array('menu_key' => 'edit_detail',  'menu_name' => '编辑商品', 'menu_url' => urlShop('store_goods_online', 'edit_goods', array('commonid' => $_GET['commonid'], 'ref_url' => $_GET['ref_url']))),
                    array('menu_key' => 'edit_image',   'menu_name' => '编辑图片', 'menu_url' => urlShop('store_goods_online', 'edit_image', array('commonid' => $_GET['commonid'], 'ref_url' => ($_GET['ref_url'] ? $_GET['ref_url'] : getReferer())))),
                );
                break;
        }
        Tpl::output ( 'member_menu', $menu_array );
        Tpl::output ( 'menu_key', $menu_key );
    }
	//好商城V3-B11 批量生成二维码
	public function maker_qrcodeOp()
	{
	header("Content-Type: text/html; charset=utf-8");
		echo '正在生成，请耐心等待...';
		echo '<br/>';
		$store_id=$_SESSION['store_id'];
        require_once(BASE_RESOURCE_PATH.DS.'phpqrcode'.DS.'index.php');
        $PhpQRCode = new PhpQRCode();
        $PhpQRCode->set('pngTempDir',BASE_UPLOAD_PATH.DS.ATTACH_STORE.DS.$_SESSION['store_id'].DS);
		//print_r($PhpQRCode);
		$model_goods = Model('goods');
		$where=array();
	    $where['store_id'] = $store_id;
		//$count=$model_goods->getGoodsCount($where);
		$lst=$model_goods->getGoodsList($where,'goods_id');
		if(empty($lst))
		{
			echo '未找到商品信息';
			retrun;
		}
		foreach($lst as $k=>$v)
		{
			$goods_id=$v['goods_id'];
			//$qrcode_url=WAP_SITE_URL . '/tmpl/product_detail.html?goods_id='.$goods_id;
            $qrcode_url=WAP_SITE_URL . '/goods/goodsDetail.shtml?goodsId='.$goods_id;
			$PhpQRCode->set('date',$qrcode_url);
			$PhpQRCode->set('pngTempName', $goods_id . '.png');
			$PhpQRCode->init();
			echo '生成成功'.$qrcode_url;
			echo '<br/>';
		}
		
		//生成店铺二维码
		//$qrcode_url=WAP_SITE_URL . '/tmpl/product_store.html?store_id='.$store_id;
        $qrcode_url=WAP_SITE_URL . '/goods/store.shtml?storeId='.$store_id;
		$PhpQRCode->set('date',$qrcode_url);
		$PhpQRCode->set('pngTempName', $store_id . '_store.png');
		$PhpQRCode->init();
		echo '生成店铺二维码成功'.$qrcode_url;
		echo '<br/>';
		echo '<br/><b>全部生成完成</b>';
		
		
		
		
		
	}

}
