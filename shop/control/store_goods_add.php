<?php
/**
 * 商品管理
 *
 *
 *
 ***/


defined('InShopNC') or exit ('Access Invalid!');
class store_goods_addControl extends BaseSellerControl {
    /**
     * 三方店铺验证，商品数量，有效期
     */
    private function checkStore(){
        $goodsLimit = (int) $this->store_grade['sg_goods_limit'];
        if ($goodsLimit > 0) {
            // 是否到达商品数上限
            $goods_num = Model('goods')->getGoodsCommonCount(array('store_id' => $_SESSION['store_id']));
            if ($goods_num >= $goodsLimit) {
                showMessage(L('store_goods_index_goods_limit') . $goodsLimit . L('store_goods_index_goods_limit1'), 'index.php?act=store_goods_online&op=goods_list', 'html', 'error');
            }
        }
    }
    public function __construct() {
        parent::__construct();
        Language::read('member_store_goods_index');
    }
    public function indexOp() {
        $this->checkStore();
        $this->add_step_oneOp();
    }

    /**
     * 添加商品
     */
    public function add_step_oneOp() {
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
        Tpl::showpage('store_goods_add.step1');
    }

    /**
     * 添加商品
     */
    public function add_step_twoOp() {
        $pay_type=array();
        $pay_type[0]='全款';
        $pay_type[1]='分期付款';
        $pay_type[2]='两种都可以';
        Tpl::output('pay_type', $pay_type);
        // 实例化商品分类模型
        $model_goodsclass = Model('goods_class');
        // 现暂时改为从匿名“自营店铺专属等级”中判断
        $editor_multimedia = false;
        if ($this->store_grade['sg_function'] == 'editor_multimedia') {
            $editor_multimedia = true;
        }
        Tpl::output('editor_multimedia', $editor_multimedia);

        $gc_id = intval($_GET['class_id']);

        // 验证商品分类是否存在且商品分类是否为最后一级
        $data = Model('goods_class')->getGoodsClassForCacheModel();
        if (!isset($data[$gc_id]) || isset($data[$gc_id]['child']) || isset($data[$gc_id]['childchild'])) {
            showDialog(L('store_goods_index_again_choose_category1'));
        }

        // 如果不是自营店铺或者自营店铺未绑定全部商品类目，读取绑定分类
        if (!checkPlatformStoreBindingAllGoodsClass()) {
            //商品分类  by 33 hao.com 支持批量显示分类
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
                        $bind_info = Model('store_bind_class')->getStoreBindClassInfo($where);
                        if (empty($bind_info))
                        {
                            showDialog(L('store_goods_index_again_choose_category2'));
                        }
                    }

                }

            }
        }

        // 更新常用分类信息
        $goods_class = $model_goodsclass->getGoodsClassLineForTag($gc_id);
        Tpl::output('goods_class', $goods_class);
        Model('goods_class_staple')->autoIncrementStaple($goods_class, $_SESSION['member_id']);

        // 获取类型相关数据
        $typeinfo = Model('type')->getAttr($goods_class['type_id'], $_SESSION['store_id'], $gc_id);
        list($spec_json, $spec_list, $attr_list, $brand_list) = $typeinfo;
        Tpl::output('sign_i', count($spec_list));
        Tpl::output('spec_list', $spec_list);
        Tpl::output('attr_list', $attr_list);
        Tpl::output('brand_list', $brand_list);

        // 实例化店铺商品分类模型
        $store_goods_class = Model('store_goods_class')->getClassTree(array('store_id' => $_SESSION ['store_id'], 'stc_state' => '1'));
        Tpl::output('store_goods_class', $store_goods_class);

        // 小时分钟显示
        $hour_array = array('00', '01', '02', '03', '04', '05', '06', '07', '08', '09', '10', '11', '12', '13', '14', '15', '16', '17', '18', '19', '20', '21', '22', '23');
        Tpl::output('hour_array', $hour_array);
        $minute_array = array('05', '10', '15', '20', '25', '30', '35', '40', '45', '50', '55');
        Tpl::output('minute_array', $minute_array);

        // 关联版式
        $plate_list = Model('store_plate')->getStorePlateList(array('store_id' => $_SESSION['store_id']), 'plate_id,plate_name,plate_position');
        $plate_list = array_under_reset($plate_list, 'plate_position', 2);
        Tpl::output('plate_list', $plate_list);

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
     * 保存商品（商品发布第二步使用）
     */
    public function save_goodsOp() {
        if (chksubmit()) {
            // 验证表单
            $obj_validate = new Validate();
            $obj_validate->validateparam = array(
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
            $error = $obj_validate->validate();
            if ($error != '') {
                showMessage(L('error') . $error, urlShop('seller_center'), 'html', 'error');
            }
            $model_goods = Model('goods');
            $model_type = Model('type');

            // 分类信息
            $goods_class = Model('goods_class')->getGoodsClassLineForTag(intval($_POST['cate_id']));

            $common_array = array();
            $common_array['goods_name']         = $_POST['g_name'];
            $common_array['goods_jingle']       = $_POST['g_jingle'];
            $common_array['gc_id']              = intval($_POST['cate_id']);
            $common_array['gc_id_1']            = intval($goods_class['gc_id_1']);
            $common_array['gc_id_2']            = intval($goods_class['gc_id_2']);
            $common_array['gc_id_3']            = intval($goods_class['gc_id_3']);
            $common_array['gc_name']            = $_POST['cate_name'];
            $common_array['brand_id']           = $_POST['b_id'];
            $common_array['brand_name']         = $_POST['b_name'];
            $common_array['type_id']            = intval($_POST['type_id']);
            $common_array['goods_image']        = $_POST['image_path'];
            $common_array['goods_price']        = floatval($_POST['g_price']);
			$common_array['goods_app_price']    = floatval($_POST['g_app_price']);
            $common_array['goods_marketprice']  = floatval($_POST['g_marketprice']);
            $common_array['goods_costprice']    = floatval($_POST['g_costprice']);
            $common_array['goods_discount']     = floatval($_POST['g_discount']);
            $common_array['goods_presalenum']     = floatval($_POST['g_presalenum']);
            $common_array['goods_serial']       = $_POST['g_serial'];
            $common_array['goods_storage_alarm']= intval($_POST['g_alarm']);
            $common_array['goods_attr']         = serialize($_POST['attr']);
            $common_array['goods_body']         = $_POST['g_body'];
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
            $common_array['mobile_body']        = $_POST['m_body'];
            $common_array['goods_commend']      = intval($_POST['g_commend']);
            $common_array['goods_state']        = ($this->store_info['store_state'] != 1) ? 0 : intval($_POST['g_state']);            // 店铺关闭时，商品下架
            $common_array['goods_addtime']      = TIMESTAMP;
            $common_array['goods_selltime']     = strtotime($_POST['starttime']) + intval($_POST['starttime_H'])*3600 + intval($_POST['starttime_i'])*60;
            $common_array['goods_verify']       = (C('goods_verify') == 1) ? 10 : 1;
            $common_array['store_id']           = $_SESSION['store_id'];
            $common_array['store_name']         = $_SESSION['store_name'];
            $common_array['spec_name']          = is_array($_POST['spec']) ? serialize($_POST['sp_name']) : serialize(null);
            $common_array['spec_value']         = is_array($_POST['spec']) ? serialize($_POST['sp_val']) : serialize(null);
            $common_array['goods_vat']          = intval($_POST['g_vat']);
            $common_array['areaid_1']           = intval($_POST['province_id']);
            $common_array['areaid_2']           = intval($_POST['city_id']);
            $common_array['transport_id']       = ($_POST['freight'] == '0') ? '0' : intval($_POST['transport_id']); // 售卖区域
            $common_array['transport_title']    = $_POST['transport_title'];
            $common_array['goods_freight']      = floatval($_POST['g_freight']);
            //查询店铺商品分类
            $goods_stcids_arr = array();
            if (!empty($_POST['sgcate_id'])){
                $sgcate_id_arr = array();
                foreach ($_POST['sgcate_id'] as $k=>$v){
                    $sgcate_id_arr[] = intval($v);
                }
                $sgcate_id_arr = array_unique($sgcate_id_arr);
                $store_goods_class = Model('store_goods_class')->getStoreGoodsClassList(array('store_id' => $_SESSION ['store_id'], 'stc_id' => array('in', $sgcate_id_arr), 'stc_state' => '1'));
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
                $common_array['goods_stcids'] = '';
            } else {
                $common_array['goods_stcids'] = ','.implode(',',$goods_stcids_arr).',';// 首尾需要加,
            }
            $common_array['plateid_top']        = intval($_POST['plate_top']) > 0 ? intval($_POST['plate_top']) : '';
            $common_array['plateid_bottom']     = intval($_POST['plate_bottom']) > 0 ? intval($_POST['plate_bottom']) : '';
            $common_array['is_virtual']         = intval($_POST['is_gv']);
            $common_array['virtual_indate']     = $_POST['g_vindate'] != '' ? (strtotime($_POST['g_vindate']) + 24*60*60 -1) : 0;  // 当天的最后一秒结束
            $common_array['virtual_limit']      = intval($_POST['g_vlimit']) > 10 || intval($_POST['g_vlimit']) < 0 ? 10 : intval($_POST['g_vlimit']);
            $common_array['virtual_invalid_refund'] = intval($_POST['g_vinvalidrefund']);
            $common_array['is_fcode']           = intval($_POST['is_fc']);
            $common_array['is_appoint']         = intval($_POST['is_appoint']);     // 只有库存为零的商品可以预约
            $common_array['appoint_satedate']   = $common_array['is_appoint'] == 1 ? strtotime($_POST['g_saledate']) : '';   // 预约商品的销售时间
            $common_array['is_presell']         = $common_array['goods_state'] == 1 ? intval($_POST['is_presell']) : 0;     // 只有出售中的商品可以预售
            $common_array['presell_deliverdate']= $common_array['is_presell'] == 1? strtotime($_POST['g_deliverdate']) : ''; // 预售商品的发货时间
            $common_array['is_own_shop']        = in_array($_SESSION['store_id'], model('store')->getOwnShopIds()) ? 1 : 0;
            $common_array['is_mode']           = intval($_POST['is_mode']);
            if($common_array['is_mode'] == 0) {$common_array['goods_shipper_id'] = 0;}
            else {$common_array['goods_shipper_id']  = intval($_POST['goods_shipper_id']);}
            $common_array['goods_hs']           = $_POST['goods_hs'];
            $model_hs = Model('ctax_hs');
            $xiaofei_rate = $model_hs->getfby_hs($_POST['goods_hs'],'xiaofei_rate');
            $zengzhi_rate = $model_hs->getfby_hs($_POST['goods_hs'],'zengzhi_rate');
            //综合税率
            if($common_array['is_mode'] == 0) {$common_array['goods_tax_rate'] = 0;}
            else {$common_array['goods_tax_rate'] = $model_hs->getfby_hs($_POST['goods_hs'],'tax_rate');}
            $tax_all = array();
            $tax_all = $model_hs->getgoodsTax($common_array['goods_price'],$xiaofei_rate,$zengzhi_rate);
            $common_array['goods_tax'] =  $tax_all['tax'];


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
            $kuajing_array['tax']          		= $tax_all['tax'];
            $kuajing_array['vat']          		= $tax_all['vat'];
            $kuajing_array['consumption_tax']   = $tax_all['consumption_tax'];
            $kuajing_array['specification']     = $_POST['guige'];


            //如果是跨境产品，保存到跨境参数
            if($kuajing_array['is_mode'] == 2) {
            $kuajing_id = $model_goods->addGoodsKuajingD($kuajing_array);
        	} else {
        		$kuajing_id = 0;
        	}
            // 保存数据
            $common_id = $model_goods->addGoodsCommon($common_array);
            if ($common_id) {
                // 生成的商品id（SKU）
                $goodsid_array = array();
 		require_once(BASE_RESOURCE_PATH.DS.'phpqrcode'.DS.'index.php');
                $PhpQRCode = new PhpQRCode();
                $PhpQRCode->set('pngTempDir',BASE_UPLOAD_PATH.DS.ATTACH_STORE.DS.$_SESSION['store_id'].DS);
                // 商品规格
                if (is_array($_POST['spec'])) {
                    foreach ($_POST['spec'] as $value) {
                        $goods = array();
                        $goods['goods_commonid']    = $common_id;
                        $goods['goods_kuajingD_id'] = $kuajing_id;            
                        $goods['goods_name']        = $common_array['goods_name'] . ' ' . implode(' ', $value['sp_value']);
                        $goods['goods_jingle']      = $common_array['goods_jingle'];
                        $goods['store_id']          = $common_array['store_id'];
                        $goods['store_name']        = $_SESSION['store_name'];
                        $goods['gc_id']             = $common_array['gc_id'];
                        $goods['gc_id_1']           = $common_array['gc_id_1'];
                        $goods['gc_id_2']           = $common_array['gc_id_2'];
                        $goods['gc_id_3']           = $common_array['gc_id_3'];
                        $goods['brand_id']          = $common_array['brand_id'];
                        $goods['goods_price']       = $value['price'];
						$goods['goods_app_price']   = $value['app_price'];
                        $goods['goods_promotion_price']=$value['price'];
                        $goods['goods_marketprice'] = $value['marketprice'] == 0 ? $common_array['goods_marketprice'] : $value['marketprice'];
                        $goods['goods_presalenum']       = $common_array['goods_presalenum'];
                        $goods['goods_serial']      = $value['sku'];
                        $goods['goods_storage_alarm']= intval($value['alarm']);
                        $goods['goods_spec']        = serialize($value['sp_value']);
                        $goods['goods_storage']     = $value['stock'];
                        $goods['goods_image']       = $common_array['goods_image'];
                        $goods['goods_state']       = $common_array['goods_state'];
                        $goods['goods_verify']      = $common_array['goods_verify'];
                        $goods['goods_addtime']     = TIMESTAMP;
                        $goods['goods_edittime']    = TIMESTAMP;
                        $goods['areaid_1']          = $common_array['areaid_1'];
                        $goods['areaid_2']          = $common_array['areaid_2'];
                        $goods['color_id']          = intval($value['color']);
                        $goods['transport_id']      = $common_array['transport_id'];
                        $goods['goods_freight']     = $common_array['goods_freight'];
                        $goods['goods_vat']         = $common_array['goods_vat'];
                        $goods['goods_commend']     = $common_array['goods_commend'];
                        $goods['goods_stcids']      = $common_array['goods_stcids'];
                        $goods['is_virtual']        = $common_array['is_virtual'];
                        $goods['virtual_indate']    = $common_array['virtual_indate'];
                        $goods['virtual_limit']     = $common_array['virtual_limit'];
                        $goods['virtual_invalid_refund'] = $common_array['virtual_invalid_refund'];
                        $goods['is_fcode']          = $common_array['is_fcode'];
                        $goods['is_appoint']        = $common_array['is_appoint'];
                        $goods['is_presell']        = $common_array['is_presell'];
                        $goods['is_own_shop']       = $common_array['is_own_shop'];
                        $goods['is_mode']          = $common_array['is_mode'];
                        if($goods['is_mode'] == 0) {$goods['goods_shipper_id'] = 0;}
                        else {$goods['goods_shipper_id']  = $common_array['goods_shipper_id'];}
                        
                        $goods['goods_hs']          = $common_array['goods_hs'];
                        //$goods['goods_tax']          = $common_array['goods_tax'];
                        $model_hs = Model('ctax_hs');
                        $xiaofei_rate = $model_hs->getfby_hs($_POST['goods_hs'],'xiaofei_rate');
                        $zengzhi_rate = $model_hs->getfby_hs($_POST['goods_hs'],'zengzhi_rate');
                        //综合税率
                        if($goods['is_mode'] == 0) {$goods['goods_tax_rate'] = 0;}
                        else {$goods['goods_tax_rate'] = $model_hs->getfby_hs($_POST['goods_hs'],'tax_rate');}
                        $tax_all = $model_hs->getgoodsTax($value['price'],$xiaofei_rate,$zengzhi_rate);
                        $goods['goods_tax'] = $tax_all['tax'];
                        

                        $goods_id = $model_goods->addGoods($goods);
                        $model_type->addGoodsType($goods_id, $common_id, array('cate_id' => $_POST['cate_id'], 'type_id' => $_POST['type_id'], 'attr' => $_POST['attr']));

                        $goodsid_array[] = $goods_id;
			 // 生成商品二维码
                        //$PhpQRCode->set('date',WAP_SITE_URL . '/tmpl/product_detail.html?goods_id='.$goods_id);
                        $PhpQRCode->set('date',WAP_SITE_URL . '/goods/goodsDetail.shtml?goodsId='.$goods_id);
                        $PhpQRCode->set('pngTempName', $goods_id . '.png');
                        $PhpQRCode->init();
                    }
                } else {
                    $goods = array();
                    $goods['goods_commonid']    = $common_id;
                    $goods['goods_kuajingD_id'] = $kuajing_id; 
                    $goods['goods_name']        = $common_array['goods_name'];
                    $goods['goods_jingle']      = $common_array['goods_jingle'];
                    $goods['store_id']          = $common_array['store_id'];
                    $goods['store_name']        = $_SESSION['store_name'];
                    $goods['gc_id']             = $common_array['gc_id'];
                    $goods['gc_id_1']           = $common_array['gc_id_1'];
                    $goods['gc_id_2']           = $common_array['gc_id_2'];
                    $goods['gc_id_3']           = $common_array['gc_id_3'];
                    $goods['brand_id']          = $common_array['brand_id'];
                    $goods['goods_price']       = $common_array['goods_price'];
					$goods['goods_app_price']   = $common_array['goods_app_price'];
                    $goods['goods_promotion_price']=$common_array['goods_price'];
                    $goods['goods_marketprice'] = $common_array['goods_marketprice'];
                    $goods['goods_presalenum']  = $common_array['goods_presalenum'];
                    $goods['goods_serial']      = $common_array['goods_serial'];
                    $goods['goods_storage_alarm']= $common_array['goods_storage_alarm'];
                    $goods['goods_spec']        = serialize(null);
                    $goods['goods_storage']     = intval($_POST['g_storage']);
                    $goods['goods_image']       = $common_array['goods_image'];
                    $goods['goods_state']       = $common_array['goods_state'];
                    $goods['goods_verify']      = $common_array['goods_verify'];
                    $goods['goods_addtime']     = TIMESTAMP;
                    $goods['goods_edittime']    = TIMESTAMP;
                    $goods['areaid_1']          = $common_array['areaid_1'];
                    $goods['areaid_2']          = $common_array['areaid_2'];
                    $goods['color_id']          = 0;
                    $goods['transport_id']      = $common_array['transport_id'];
                    $goods['goods_freight']     = $common_array['goods_freight'];
                    $goods['goods_vat']         = $common_array['goods_vat'];
                    $goods['goods_commend']     = $common_array['goods_commend'];
                    $goods['goods_stcids']      = $common_array['goods_stcids'];
                    $goods['is_virtual']        = $common_array['is_virtual'];
                    $goods['virtual_indate']    = $common_array['virtual_indate'];
                    $goods['virtual_limit']     = $common_array['virtual_limit'];
                    $goods['virtual_invalid_refund'] = $common_array['virtual_invalid_refund'];
                    $goods['is_fcode']          = $common_array['is_fcode'];
                    $goods['is_appoint']        = $common_array['is_appoint'];
                    $goods['is_presell']        = $common_array['is_presell'];
                    $goods['is_own_shop']       = $common_array['is_own_shop'];
                    $goods['is_mode']          = $common_array['is_mode'];
                    if($goods['is_mode'] == 0){$goods['goods_shipper_id'] = 0;}
                    else {$goods['goods_shipper_id']  = $common_array['goods_shipper_id'];}
                    
                    $goods['goods_hs']          = $common_array['goods_hs'];
                    $goods['goods_tax']          = $common_array['goods_tax'];
                    $goods['goods_tax_rate']          = $common_array['goods_tax_rate'];
                    $goods_id = $model_goods->addGoods($goods);
                    $model_type->addGoodsType($goods_id, $common_id, array('cate_id' => $_POST['cate_id'], 'type_id' => $_POST['type_id'], 'attr' => $_POST['attr']));

                    $goodsid_array[] = $goods_id;
                }
                //基本配置

                $basic=array();
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

                //车身
                $body=array();
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


                //发动机
                 $engine=array();
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

                // 生成商品二维码
                if (!empty($goodsid_array)) {
                    //QueueClient::push('createGoodsQRCode', array('store_id' => $_SESSION['store_id'], 'goodsid_array' => $goodsid_array));
		    //$PhpQRCode->set('date',WAP_SITE_URL . '/tmpl/product_detail.html?goods_id='.$goods_id);
                	$PhpQRCode->set('date',WAP_SITE_URL . '/goods/goodsDetail.shtml?goodsId='.$goods_id);
                    $PhpQRCode->set('pngTempName', $goods_id . '.png');
                    $PhpQRCode->init();
                }

                // 商品加入上架队列
                if (isset($_POST['starttime'])) {
                    $selltime = strtotime($_POST['starttime']) + intval($_POST['starttime_H'])*3600 + intval($_POST['starttime_i'])*60;
                    if ($selltime > TIMESTAMP) {
                        $this->addcron(array('exetime' => $selltime, 'exeid' => $common_id, 'type' => 1), true);
                    }
                }
                // 记录日志
                $this->recordSellerLog('添加商品，平台货号:'.$common_id);

                // 生成F码
                if ($common_array['is_fcode'] == 1) {
                    QueueClient::push('createGoodsFCode', array('goods_commonid' => $common_id, 'fc_count' => intval($_POST['g_fccount']), 'fc_prefix' => $_POST['g_fcprefix']));
                }

                redirect(urlShop('store_goods_add', 'car_config', array('commonid' => $common_id)));
               // redirect(urlShop('store_goods_add', 'add_step_three', array('commonid' => $common_id)));
            } else {
                showMessage(L('store_goods_index_goods_add_fail'), getReferer(), 'html', 'error');
            }
        }
    }

    /**
     *
     * 变速箱到辅助操作控制基本参数
     *
     */
    public function car_configOp(){
        $common_id = intval($_GET['commonid']);
        Tpl::output('common_id', $common_id);
        Tpl::showpage('store_goods_add.step22');
    }
    /**
     *
     * 保存变速箱到辅助操作控制表的数据
     *
     */
    public function car_configsaveOp(){
        $common_id = intval($_POST['common_id']);
        $model_goods = Model('goods');

        //变速箱
        $gearbox=array();
        $gearbox['goods_commonid']=$common_id;
        $gearbox['gearbox_referred']=$_POST['gearbox_referred'];
        $gearbox['car_gears_num']=$_POST['car_gears_num'];
        $gearbox['gearbox_type']=$_POST['gearbox_type'];
        $gearbox_id=$model_goods->gearbox($gearbox);
        if(empty($gearbox_id)){
            showMessage('汽车变速箱参数添加失败', getReferer(), 'html', 'error');
        }


        //底盘转向
        $steer=array();
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


            //车轮制动

        $wheel=array();
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



             //安全装备
             $safe_item=array();
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



             //座椅配置
             $seat_congif=array();
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


             //多媒体配置
             $wmm=array();
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

        redirect(urlShop('store_goods_add', 'car_config1', array('commonid' => $common_id)));

       // redirect(urlShop('store_goods_add', 'add_step_three', array('commonid' => $common_id)));
    }
    /**
     *
     * 外部防盗配置到空调、冰箱基本参数
     *
     */
    public function car_config1Op(){
        $common_id = intval($_GET['commonid']);
        Tpl::output('common_id', $common_id);
        Tpl::showpage('store_goods_add.step23');
    }
    public function car_configsave1Op(){
        $common_id = intval($_POST['common_id']);
        $model_goods = Model('goods');

        //内部配置
        $inner=array();
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

        //外部/防盗配置
        $external=array();
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


        //操控配置
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



        //灯光配置
        $num=array();
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

        //玻璃、后视镜
        $mirror=array();
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
       
        //高科技配置
        $high=array();
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


        //空调/冰箱
        $refrigerator=array();
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

        redirect(urlShop('store_goods_add', 'add_step_three', array('commonid' => $common_id)));
    }
    /**
     * 第三步添加颜色图片
     */
    public function add_step_threeOp() {
        $common_id = intval($_GET['commonid']);
        if ($common_id <= 0) {
            showMessage(L('wrong_argument'), urlShop('seller_center'), 'html', 'error');
        }

        $model_goods = Model('goods');
        $img_array = $model_goods->getGoodsList(array('goods_commonid' => $common_id), 'color_id,goods_image', 'color_id');
        // 整理，更具id查询颜色名称
        if (!empty($img_array)) {
            $colorid_array = array();
            $image_array = array();
            foreach ($img_array as $val) {
                $image_array[$val['color_id']][0]['goods_image'] = $val['goods_image'];
                $image_array[$val['color_id']][0]['is_default'] = 1;
                $colorid_array[] = $val['color_id'];
            }
            Tpl::output('img', $image_array);
        }

        $common_list = $model_goods->getGoodeCommonInfoByID($common_id, 'spec_value');
        $spec_value = unserialize($common_list['spec_value']);
        Tpl::output('value', $spec_value['1']);

        $model_spec = Model('spec');
        $value_array = $model_spec->getSpecValueList(array('sp_value_id' => array('in', $colorid_array), 'store_id' => $_SESSION['store_id']), 'sp_value_id,sp_value_name');
        if (empty($value_array)) {
            $value_array[] = array('sp_value_id' => '0', 'sp_value_name' => '无颜色');
        }
        Tpl::output('value_array', $value_array);

        Tpl::output('commonid', $common_id);
        Tpl::showpage('store_goods_add.step3');
    }

    /**
     * 保存商品颜色图片
     */
    public function save_imageOp(){
        if (chksubmit()) {
            $common_id = intval($_POST['commonid']);
            if ($common_id <= 0 || empty($_POST['img'])) {
                showMessage(L('wrong_argument'));
            }
            $model_goods = Model('goods');
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
                    $update_where['color_id']       = $key;
                    if ($k == 0 || $v['default'] == 1) {
                        $k++;
                        $update_array['goods_image']    = $v['name'];
                        $update_where['goods_commonid'] = $common_id;
                        $update_where['color_id']       = $key;
                        // 更新商品主图
                        $model_goods->editGoods($update_array, $update_where);
                    }
                    $tmp_insert = array();
                    $tmp_insert['goods_commonid']   = $common_id;
                    $tmp_insert['store_id']         = $_SESSION['store_id'];
                    $tmp_insert['color_id']         = $key;
                    $tmp_insert['goods_image']      = $v['name'];
                    $tmp_insert['goods_image_sort'] = ($v['default'] == 1) ? 0 : intval($v['sort']);
                    $tmp_insert['is_default']       = $v['default'];
                    $insert_array[] = $tmp_insert;
                }
            }
            $rs = $model_goods->addGoodsImagesAll($insert_array);
            if ($rs) {
                redirect(urlShop('store_goods_add', 'add_step_four', array('commonid' => $common_id)));
            } else {
                showMessage(L('nc_common_save_fail'));
            }
        }
    }

    /**
     * 商品发布第四步
     */
    public function add_step_fourOp() {
        // 单条商品信息
        $goods_info = Model('goods')->getGoodsInfo(array('goods_commonid' => $_GET['commonid']));

        // 自动发布动态
        $data_array = array();
        $data_array['goods_id'] = $goods_info['goods_id'];
        $data_array['store_id'] = $goods_info['store_id'];
        $data_array['goods_name'] = $goods_info['goods_name'];
        $data_array['goods_image'] = $goods_info['goods_image'];
        $data_array['goods_price'] = $goods_info['goods_price'];
		$data_array['goods_app_price'] = $goods_info['goods_app_price'];
        $data_array['goods_transfee_charge'] = $goods_info['goods_freight'] == 0 ? 1 : 0;
        $data_array['goods_freight'] = $goods_info['goods_freight'];
        $this->storeAutoShare($data_array, 'new');

        Tpl::output('allow_gift', Model('goods')->checkGoodsIfAllowGift($goods_info));
        Tpl::output('allow_combo', Model('goods')->checkGoodsIfAllowCombo($goods_info));
        Tpl::output('goods_id', $goods_info['goods_id']);
        Tpl::showpage('store_goods_add.step4');
    }

    /**
     * 上传图片
     */
    public function image_uploadOp() {
        // 判断图片数量是否超限
        $model_album = Model('album');
        $album_limit = $this->store_grade['sg_album_limit'];
        if ($album_limit > 0) {
            $album_count = $model_album->getCount(array('store_id' => $_SESSION['store_id']));
            if ($album_count >= $album_limit) {
                $error = L('store_goods_album_climit');
                if (strtoupper(CHARSET) == 'GBK') {
                    $error = Language::getUTF8($error);
                }
                exit(json_encode(array('error' => $error)));
            }
        }
        $class_info = $model_album->getOne(array('store_id' => $_SESSION['store_id'], 'is_default' => 1), 'album_class');
        // 上传图片
        $upload = new UploadFile();
        $upload->set('default_dir', ATTACH_GOODS . DS . $_SESSION ['store_id'] . DS . $upload->getSysSetPath());
        $upload->set('max_size', C('image_max_filesize'));

        $upload->set('thumb_width', GOODS_IMAGES_WIDTH);
        $upload->set('thumb_height', GOODS_IMAGES_HEIGHT);
        $upload->set('thumb_ext', GOODS_IMAGES_EXT);
        $upload->set('fprefix', $_SESSION['store_id']);
        $upload->set('allow_type', array('gif', 'jpg', 'jpeg', 'png'));
        $result = $upload->upfile($_POST['name']);
        if (!$result) {
            if (strtoupper(CHARSET) == 'GBK') {
                $upload->error = Language::getUTF8($upload->error);
            }
            $output = array();
            $output['error'] = $upload->error;
            $output = json_encode($output);
            exit($output);
        }

        $img_path = $upload->getSysSetPath() . $upload->file_name;

        // 取得图像大小
        list($width, $height, $type, $attr) = getimagesize(BASE_UPLOAD_PATH . '/' . ATTACH_GOODS . '/' . $_SESSION['store_id'] . DS . $img_path);

        // 存入相册
        $image = explode('.', $_FILES[$_POST['name']]["name"]);
        $insert_array = array();
        $insert_array['apic_name'] = $image['0'];
        $insert_array['apic_tag'] = '';
        $insert_array['aclass_id'] = $class_info['aclass_id'];
        $insert_array['apic_cover'] = $img_path;
        $insert_array['apic_size'] = intval($_FILES[$_POST['name']]['size']);
        $insert_array['apic_spec'] = $width . 'x' . $height;
        $insert_array['upload_time'] = TIMESTAMP;
        $insert_array['store_id'] = $_SESSION['store_id'];
        $model_album->addPic($insert_array);

        $data = array ();
        $data ['thumb_name'] = cthumb($upload->getSysSetPath() . $upload->thumb_image, 240, $_SESSION['store_id']);
        $data ['name']      = $img_path;

        // 整理为json格式
        $output = json_encode($data);
        echo $output;
        exit();
    }

    /**
     * ajax获取商品分类的子级数据
     */
    public function ajax_goods_classOp() {
        $gc_id = intval($_GET['gc_id']);
        $deep = intval($_GET['deep']);
        if ($gc_id <= 0 || $deep <= 0 || $deep >= 4) {
            exit();
        }
        $model_goodsclass = Model('goods_class');
        $list = $model_goodsclass->getGoodsClass($_SESSION['store_id'], $gc_id, $deep);
        if (empty($list)) {
            exit();
        }
        /**
         * 转码
         */
        if (strtoupper ( CHARSET ) == 'GBK') {
            $list = Language::getUTF8 ( $list );
        }
        echo json_encode($list);
    }
    /**
     * ajax删除常用分类
     */
    public function ajax_stapledelOp() {
        Language::read ( 'member_store_goods_index' );
        $staple_id = intval($_GET ['staple_id']);
        if ($staple_id < 1) {
            echo json_encode ( array (
                    'done' => false,
                    'msg' => Language::get ( 'wrong_argument' )
            ) );
            die ();
        }
        /**
         * 实例化模型
         */
        $model_staple = Model('goods_class_staple');

        $result = $model_staple->delStaple(array('staple_id' => $staple_id, 'member_id' => $_SESSION['member_id']));
        if ($result) {
            echo json_encode ( array (
                    'done' => true
            ) );
            die ();
        } else {
            echo json_encode ( array (
                    'done' => false,
                    'msg' => ''
            ) );
            die ();
        }
    }
    /**
     * ajax选择常用商品分类
     */
    public function ajax_show_commOp() {
        $staple_id = intval($_GET['stapleid']);

        /**
         * 查询相应的商品分类id
         */
        $model_staple = Model('goods_class_staple');
        $staple_info = $model_staple->getStapleInfo(array('staple_id' => intval($staple_id), 'gc_id_1,gc_id_2,gc_id_3'));
        if (empty ( $staple_info ) || ! is_array ( $staple_info )) {
            echo json_encode ( array (
                    'done' => false,
                    'msg' => ''
            ) );
            die ();
        }

        $list_array = array ();
        $list_array['gc_id'] = 0;
        $list_array['type_id'] = $staple_info['type_id'];
        $list_array['done'] = true;
        $list_array['one'] = '';
        $list_array['two'] = '';
        $list_array['three'] = '';

        $gc_id_1 = intval ( $staple_info['gc_id_1'] );
        $gc_id_2 = intval ( $staple_info['gc_id_2'] );
        $gc_id_3 = intval ( $staple_info['gc_id_3'] );

        /**
         * 查询同级分类列表
         */
        $model_goods_class = Model ( 'goods_class' );
        // 1级
        if ($gc_id_1 > 0) {
            $list_array['gc_id'] = $gc_id_1;
            $class_list = $model_goods_class->getGoodsClass($_SESSION['store_id']);
            if (empty ( $class_list ) || ! is_array ( $class_list )) {
                echo json_encode ( array (
                        'done' => false,
                        'msg' => ''
                ) );
                die ();
            }
            foreach ( $class_list as $val ) {
                if ($val ['gc_id'] == $gc_id_1) {
                    $list_array ['one'] .= '<li class="" onclick="selClass($(this));" data-param="{gcid:' . $val ['gc_id'] . ', deep:1, tid:' . $val ['type_id'] . '}" nctype="selClass"> <a class="classDivClick" href="javascript:void(0)"><span class="has_leaf"><i class="icon-double-angle-right"></i>' . $val ['gc_name'] . '</span></a> </li>';
                } else {
                    $list_array ['one'] .= '<li class="" onclick="selClass($(this));" data-param="{gcid:' . $val ['gc_id'] . ', deep:1, tid:' . $val ['type_id'] . '}" nctype="selClass"> <a class="" href="javascript:void(0)"><span class="has_leaf"><i class="icon-double-angle-right"></i>' . $val ['gc_name'] . '</span></a> </li>';
                }
            }
        }
        // 2级
        if ($gc_id_2 > 0) {
            $list_array['gc_id'] = $gc_id_2;
            $class_list = $model_goods_class->getGoodsClass($_SESSION['store_id'], $gc_id_1, 2);
            if (empty ( $class_list ) || ! is_array ( $class_list )) {
                echo json_encode ( array (
                        'done' => false,
                        'msg' => ''
                ) );
                die ();
            }
            foreach ( $class_list as $val ) {
                if ($val ['gc_id'] == $gc_id_2) {
                    $list_array ['two'] .= '<li class="" onclick="selClass($(this));" data-param="{gcid:' . $val ['gc_id'] . ', deep:2, tid:' . $val ['type_id'] . '}" nctype="selClass"> <a class="classDivClick" href="javascript:void(0)"><span class="has_leaf"><i class="icon-double-angle-right"></i>' . $val ['gc_name'] . '</span></a> </li>';
                } else {
                    $list_array ['two'] .= '<li class="" onclick="selClass($(this));" data-param="{gcid:' . $val ['gc_id'] . ', deep:2, tid:' . $val ['type_id'] . '}" nctype="selClass"> <a class="" href="javascript:void(0)"><span class="has_leaf"><i class="icon-double-angle-right"></i>' . $val ['gc_name'] . '</span></a> </li>';
                }
            }
        }
        // 3级
        if ($gc_id_3 > 0) {
            $list_array['gc_id'] = $gc_id_3;
            $class_list = $model_goods_class->getGoodsClass($_SESSION['store_id'], $gc_id_2, 3);
            if (empty ( $class_list ) || ! is_array ( $class_list )) {
                echo json_encode ( array (
                        'done' => false,
                        'msg' => ''
                ) );
                die ();
            }
            foreach ( $class_list as $val ) {
                if ($val ['gc_id'] == $gc_id_3) {
                    $list_array ['three'] .= '<li class="" onclick="selClass($(this));" data-param="{gcid:' . $val ['gc_id'] . ', deep:3, tid:' . $val ['type_id'] . '}" nctype="selClass"> <a class="classDivClick" href="javascript:void(0)"><span class="has_leaf"><i class="icon-double-angle-right"></i>' . $val ['gc_name'] . '</span></a> </li>';
                } else {
                    $list_array ['three'] .= '<li class="" onclick="selClass($(this));" data-param="{gcid:' . $val ['gc_id'] . ', deep:3, tid:' . $val ['type_id'] . '}" nctype="selClass"> <a class="" href="javascript:void(0)"><span class="has_leaf"><i class="icon-double-angle-right"></i>' . $val ['gc_name'] . '</span></a> </li>';
                }
            }
        }
        // 转码
        if (strtoupper ( CHARSET ) == 'GBK') {
            $list_array = Language::getUTF8 ( $list_array );
        }
        echo json_encode ( $list_array );
        die ();
    }
    /**
     * AJAX添加商品规格值
     */
    public function ajax_add_specOp() {
        $name = trim($_GET['name']);
        $gc_id = intval($_GET['gc_id']);
        $sp_id = intval($_GET['sp_id']);
        if ($name == '' || $gc_id <= 0 || $sp_id <= 0) {
            echo json_encode(array('done' => false));die();
        }
        $insert = array(
            'sp_value_name' => $name,
            'sp_id' => $sp_id,
            'gc_id' => $gc_id,
            'store_id' => $_SESSION['store_id'],
            'sp_value_color' => null,
            'sp_value_sort' => 0,
        );
        $value_id = Model('spec')->addSpecValue($insert);
        if ($value_id) {
            echo json_encode(array('done' => true, 'value_id' => $value_id));die();
        } else {
            echo json_encode(array('done' => false));die();
        }
    }

    /**
     * AJAX查询品牌
     */
    public function ajax_get_brandOp() {
        $type_id = intval($_GET['tid']);
        $initial = trim($_GET['letter']);
        $keyword = trim($_GET['keyword']);
        $type = trim($_GET['type']);
        if (!in_array($type, array('letter', 'keyword')) || ($type == 'letter' && empty($initial)) || ($type == 'keyword' && empty($keyword))) {
            echo json_encode(array());die();
        }

        // 实例化模型
        $model_type = Model('type');
        $where = array();
        $where['type_id'] = $type_id;
        // 验证类型是否关联品牌
        $count = $model_type->getTypeBrandCount($where);
        if ($type == 'letter') {
            switch ($initial) {
            	case 'all':
            	    break;
            	case '0-9':
            	    $where['brand_initial'] = array('in', array(0,1,2,3,4,5,6,7,8,9));
            	    break;
            	default:
            	    $where['brand_initial'] = $initial;
            	    break;
            }
        } else {
            $where['brand_name|brand_initial'] = array('like', '%' . $keyword . '%');
        }
        if ($count > 0) {
            $brand_array = $model_type->typeRelatedJoinList($where, 'brand', 'brand.brand_id,brand.brand_name,brand.brand_initial');
        } else {
            unset($where['type_id']);
            $brand_array = Model('brand')->getBrandPassedList($where, 'brand_id,brand_name,brand_initial', 0, 'brand_initial asc, brand_sort asc');
        }
        echo json_encode($brand_array);die();
    }
}
