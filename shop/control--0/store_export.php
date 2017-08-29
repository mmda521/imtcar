<?php
/**
 * 商家中心订单导出
 *
 *
 *
 **/


defined('InShopNC') or exit('Access Invalid!');
class store_exportControl extends BaseSellerControl {
    const EXPORT_SIZE = 1000;
    public function __construct() {
        parent::__construct();
        Language::read('member_store_index');
    }


 /**
     * 导出订单
     *
     */
    public function export_orderOp_disable(){
        /*
        $lang   = Language::getLangContent();

        $model_order = Model('order');
        $condition  = array();
        if($_GET['order_sn']) {
            $condition['order_sn'] = $_GET['order_sn'];
        }
        if($_GET['store_name']) {
            $condition['store_name'] = $_GET['store_name'];
        }
        if(in_array($_GET['order_state'],array('0','10','20','30','40'))){
            $condition['order_state'] = $_GET['order_state'];
        }
        if($_GET['payment_code']) {
            $condition['payment_code'] = $_GET['payment_code'];
        }
        if($_GET['buyer_name']) {
            $condition['buyer_name'] = $_GET['buyer_name'];
        }
        if ($_GET['is_mode'] != '') {
            $condition['is_mode'] = $_GET['is_mode'];
        }
        $condition['store_id'] = $_SESSION['store_id']; 

        $if_start_time = preg_match('/^20\d{2}-\d{2}-\d{2}$/',$_GET['query_start_date']);
        $if_end_time = preg_match('/^20\d{2}-\d{2}-\d{2}$/',$_GET['query_end_date']);
        $start_unixtime = $if_start_time ? strtotime($_GET['query_start_date']) : null;
        $end_unixtime = $if_end_time ? strtotime($_GET['query_end_date']): null;
        if ($start_unixtime || $end_unixtime) {
            $condition['add_time'] = array('time',array($start_unixtime,$end_unixtime));
        }

        if (!is_numeric($_GET['curpage'])){
            $count = $model_order->getOrderCount($condition);
            $array = array();
            if ($count > self::EXPORT_SIZE ){   //显示下载链接
                $page = ceil($count/self::EXPORT_SIZE);
                for ($i=1;$i<=$page;$i++){
                    $limit1 = ($i-1)*self::EXPORT_SIZE + 1;
                    $limit2 = $i*self::EXPORT_SIZE > $count ? $count : $i*self::EXPORT_SIZE;
                    $array[$i] = $limit1.' ~ '.$limit2 ;
                }
                Tpl::output('list',$array);
                Tpl::output('murl','index.php?act=order&op=index');
                Tpl::showpage('export.excel');
            }else{  //如果数量小，直接下载
                $data = $model_order->getOrderList($condition,'','*','order_id desc',self::EXPORT_SIZE);
                $this->createExcel($data);
            }
        }else{  //下载
            $limit1 = ($_GET['curpage']-1) * self::EXPORT_SIZE;
            $limit2 = self::EXPORT_SIZE;
            $data = $model_order->getOrderList($condition,'','*','order_id desc',"{$limit1},{$limit2}");
            $this->createExcel($data);
        }
        */
    }


/**
     * 导出订单
     *
     */
    public function export_orderOp(){
        $lang   = Language::getLangContent();
        $model_order = Model('order');
        $condition  = array();
        if($_GET['order_sn']) {
            $condition['order.order_sn'] = $_GET['order_sn'];
        }
        if($_GET['store_name']) {
            $condition['order.store_name'] = $_GET['store_name'];
        }
        if(in_array($_GET['order_state'],array('0','10','20','30','40'))){
            $condition['order.order_state'] = $_GET['order_state'];
        }
        if($_GET['payment_code']) {
            $condition['order.payment_code'] = $_GET['payment_code'];
        }
        if($_GET['buyer_name']) {
            $condition['order.buyer_name'] = $_GET['buyer_name'];
        }

        if ($_GET['consignee_name'] != '') {
        $condition['order_common.reciver_name']=$_GET['consignee_name'];
        }

        if ($_GET['is_mode'] != '') {
            $condition['order.is_mode'] = $_GET['is_mode'];
        }

        //支付方式
        if ($_GET['pay_code'] != '') {
            $condition['order.payment_code'] = $_GET['pay_code'];
        }

        //退款状态
        //if ($_GET['refund_state'] != '') {
        //    $condition['order.refund_state'] = $_GET['refund_state'];
        //}

        //订单状态
        if ($_GET['order_state'] != '') {
            $condition['order.order_state'] = $_GET['order_state'];
        }

        //已关闭订单
        if ($_GET['skip_off'] == 1) {
            $condition['order.order_state'] = array('neq',0);
        }

        $condition['order.store_id'] = $_SESSION['store_id']; 

        //下单时间
        $if_start_time = preg_match('/^20\d{2}-\d{2}-\d{2}$/',$_GET['query_start_date']);
        $if_end_time = preg_match('/^20\d{2}-\d{2}-\d{2}$/',$_GET['query_end_date']);
        $start_unixtime = $if_start_time ? strtotime($_GET['query_start_date']) : null;
        $end_unixtime = $if_end_time ? strtotime($_GET['query_end_date']): null;
        if ($start_unixtime || $end_unixtime) {
            $condition['order.add_time'] = array('time',array($start_unixtime,$end_unixtime));
        }

        //发货时间
        $if_start_time_fahuo = preg_match('/^20\d{2}-\d{2}-\d{2}$/',$_GET['query_start_date_fahuo']);
        $if_end_time_fahuo = preg_match('/^20\d{2}-\d{2}-\d{2}$/',$_GET['query_end_date_fahuo']);
        $start_unixtime_fahuo = $if_start_time_fahuo ? strtotime($_GET['query_start_date_fahuo']) : null;
        $end_unixtime_fahuo = $if_end_time_fahuo ? strtotime($_GET['query_end_date_fahuo']): null;
        if ($start_unixtime_fahuo || $end_unixtime_fahuo) {
            $condition['order_common.shipping_time'] = array('time',array($start_unixtime_fahuo,$end_unixtime_fahuo));
        }

        //支付时间  xinzeng
        $if_start_time_pay = preg_match('/^20\d{2}-\d{2}-\d{2}$/',$_GET['query_start_date_pay']);
        $if_end_time_pay = preg_match('/^20\d{2}-\d{2}-\d{2}$/',$_GET['query_end_date_pay']);
        $start_unixtime_pay = $if_start_time_pay ? strtotime($_GET['query_start_date_pay']) : null;
        $end_unixtime_pay = $if_end_time_pay ? strtotime($_GET['query_end_date_pay']): null;
        if ($start_unixtime_pay || $end_unixtime_pay) {
            $condition['order.payment_time'] = array('time',array($start_unixtime_pay,$end_unixtime_pay));
        }

        //订单完成时间  xinzeng
        $if_start_time_finish = preg_match('/^20\d{2}-\d{2}-\d{2}$/',$_GET['query_start_date_finish']);
        $if_end_time_finish = preg_match('/^20\d{2}-\d{2}-\d{2}$/',$_GET['query_end_date_finish']);
        $start_unixtime_finish = $if_start_time_finish ? strtotime($_GET['query_start_date_finish']) : null;
        $end_unixtime_finish = $if_end_time_finish ? strtotime($_GET['query_end_date_finish']): null;
        if ($start_unixtime_finish || $end_unixtime_finish) {
            $condition['order.finnshed_time'] = array('time',array($start_unixtime_finish,$end_unixtime_finish));
        }


        if (!is_numeric($_GET['curpage'])){
            $count = $model_order->getOrderCount($condition);
            $array = array();
            if ($count > self::EXPORT_SIZE ){   //显示下载链接
                $page = ceil($count/self::EXPORT_SIZE);
                for ($i=1;$i<=$page;$i++){
                    $limit1 = ($i-1)*self::EXPORT_SIZE + 1;
                    $limit2 = $i*self::EXPORT_SIZE > $count ? $count : $i*self::EXPORT_SIZE;
                    $array[$i] = $limit1.' ~ '.$limit2 ;
                }
                Tpl::output('list',$array);
                Tpl::output('murl','index.php?act=order&op=index');
                Tpl::showpage('export.excel');
            }else{  //如果数量小，直接下载
                $data = $model_order->getOrderList2($consignee_name,$condition,'','*','order_id desc',self::EXPORT_SIZE,array('order_goods','order_common','member','goods_kuajing_d'));
                $this->createExcel($data);
            }
        }else{  //下载
            $limit1 = ($_GET['curpage']-1) * self::EXPORT_SIZE;
            $limit2 = self::EXPORT_SIZE;
            $data = $model_order->getOrderList2($consignee_name,$condition,'','*','order_id desc',"{$limit1},{$limit2}",array('order_goods','order_common','member','goods_kuajing_d'));
            $this->createExcel($data);
        }
    }


    /**
     * 导出子订单
     *
     */
    public function export_order_subOp(){
        $lang   = Language::getLangContent();

        $model_order = Model('order');
        $condition  = array();
        if($_GET['order_sn']) {
            $condition['order.order_sn'] = $_GET['order_sn'];
        }
        if($_GET['store_name']) {
            $condition['order.store_name'] = $_GET['store_name'];
        }
        if(in_array($_GET['order_state'],array('0','10','20','30','40'))){
            $condition['order.order_state'] = $_GET['order_state'];
        }
        if($_GET['payment_code']) {
            $condition['order.payment_code'] = $_GET['payment_code'];
        }
        if($_GET['buyer_name']) {
            $condition['order.buyer_name'] = $_GET['buyer_name'];
        }

        //模式
        if ($_GET['is_mode'] != '') {
            $condition['order.is_mode'] = $_GET['is_mode'];
        }

        //支付方式
        if ($_GET['pay_code'] != '') {
            $condition['order.payment_code'] = $_GET['pay_code'];
        }

        //退款状态
        //if ($_GET['refund_state'] != '') {
        //    $condition['order.refund_state'] = $_GET['refund_state'];
        //}

        //订单状态
        if ($_GET['order_state'] != '') {
            $condition['order.order_state'] = $_GET['order_state'];
        }

        //已关闭订单
        if ($_GET['skipoff2'] == 1) {
            $condition['order.order_state'] = array('neq',0);
        }

        $condition['order.store_id'] = $_SESSION['store_id']; 
        
        if ($_GET['goods_name'] != '') {
            $goods_name = $_GET['goods_name'];
        }
        if ($_GET['goods_serial'] != '') {
            $goods_serial = $_GET['goods_serial'];
        }
        if ($_GET['consignee_name'] != '') {
        $condition['order_common.reciver_name']=$_GET['consignee_name'];
        }

        //下单时间
        $if_start_time = preg_match('/^20\d{2}-\d{2}-\d{2}$/',$_GET['query_start_date2']);
        $if_end_time = preg_match('/^20\d{2}-\d{2}-\d{2}$/',$_GET['query_end_date2']);
        $start_unixtime = $if_start_time ? strtotime($_GET['query_start_date2']) : null;
        $end_unixtime = $if_end_time ? strtotime($_GET['query_end_date2']): null;
        if ($start_unixtime || $end_unixtime) {
            $condition['order.add_time'] = array('time',array($start_unixtime,$end_unixtime));
        }

        //发货时间
        $if_start_time_fahuo = preg_match('/^20\d{2}-\d{2}-\d{2}$/',$_GET['query_start_date2_fahuo']);
        $if_end_time_fahuo = preg_match('/^20\d{2}-\d{2}-\d{2}$/',$_GET['query_end_date2_fahuo']);
        $start_unixtime_fahuo = $if_start_time_fahuo ? strtotime($_GET['query_start_date2_fahuo']) : null;
        $end_unixtime_fahuo = $if_end_time_fahuo ? strtotime($_GET['query_end_date2_fahuo']): null;
        if ($start_unixtime_fahuo || $end_unixtime_fahuo) {
            $condition['order_common.shipping_time'] = array('time',array($start_unixtime_fahuo,$end_unixtime_fahuo));
        }

        if (!is_numeric($_GET['curpage'])){
            $count = $model_order->getOrderCount($condition);
            $array = array();
            if ($count > self::EXPORT_SIZE ){   //显示下载链接
                $page = ceil($count/self::EXPORT_SIZE);
                for ($i=1;$i<=$page;$i++){
                    $limit1 = ($i-1)*self::EXPORT_SIZE + 1;
                    $limit2 = $i*self::EXPORT_SIZE > $count ? $count : $i*self::EXPORT_SIZE;
                    $array[$i] = $limit1.' ~ '.$limit2 ;
                }
                Tpl::output('list',$array);
                Tpl::output('murl','index.php?act=order&op=index');
                Tpl::showpage('export.excel');
            }else{  //如果数量小，直接下载
                $data = $model_order->getOrderList2($consignee_name,$condition,'','*','order_id desc',self::EXPORT_SIZE);
                $this->createExcel_sub($data,$goods_name,$goods_serial);
            }
        }else{  //下载
            $limit1 = ($_GET['curpage']-1) * self::EXPORT_SIZE;
            $limit2 = self::EXPORT_SIZE;
            $data = $model_order->getOrderList2($consignee_name,$condition,'','*','order_id desc',"{$limit1},{$limit2}");
            $this->createExcel_sub($data,$goods_name,$goods_serial);
        }
    }

    /**
     * 生成excel
     *
     * @param array $data
     */
    private function createExcel_disable($data = array()){
        /*
        Language::read('export');
        import('libraries.excel');
        $excel_obj = new Excel();
        $excel_data = array();
        $model_common = Model('order_common');
        //设置样式
        $excel_obj->setStyle(array('id'=>'s_title','Font'=>array('FontName'=>'宋体','Size'=>'12','Bold'=>'1')));
        //header
        $excel_data[0][] = array('styleid'=>'s_title','data'=>'订单号');
        $excel_data[0][] = array('styleid'=>'s_title','data'=>'店铺');
        $excel_data[0][] = array('styleid'=>'s_title','data'=>'买家');
        $excel_data[0][] = array('styleid'=>'s_title','data'=>'买家ID');
        $excel_data[0][] = array('styleid'=>'s_title','data'=>'买家Email');        
        $excel_data[0][] = array('styleid'=>'s_title','data'=>'下单时间');
        $excel_data[0][] = array('styleid'=>'s_title','data'=>'订单总额');
        $excel_data[0][] = array('styleid'=>'s_title','data'=>'运费');       
        $excel_data[0][] = array('styleid'=>'s_title','data'=>'支付方式');
        $excel_data[0][] = array('styleid'=>'s_title','data'=>'订单状态');
        $excel_data[0][] = array('styleid'=>'s_title','data'=>'店铺ID');
        $excel_data[0][] = array('styleid'=>'s_title','data'=>'收货人姓名');
        $excel_data[0][] = array('styleid'=>'s_title','data'=>'发货时间');
        $excel_data[0][] = array('styleid'=>'s_title','data'=>'支付方式');
        //$excel_data[0][] = array('styleid'=>'s_title','data'=>'支付单号');
        $excel_data[0][] = array('styleid'=>'s_title','data'=>'商品模式');
        $excel_data[0][] = array('styleid'=>'s_title','data'=>'交易流水号'); 

        //data
        foreach ((array)$data as $k=>$v){
            $tmp = array();
            $tmp[] = array('data'=>$v['order_sn']);
            $tmp[] = array('data'=>$v['store_name']);
            $tmp[] = array('data'=>$v['buyer_name']);
            $tmp[] = array('data'=>$v['buyer_id']);
            $tmp[] = array('data'=>$v['buyer_email']);            
            $tmp[] = array('data'=>date('Y-m-d H:i:s',$v['add_time']));
            $tmp[] = array('format'=>'Number','data'=>ncPriceFormat($v['order_amount']));
            $tmp[] = array('format'=>'Number','data'=>ncPriceFormat($v['shipping_fee']));
            $tmp[] = array('data'=>orderPaymentName($v['payment_code']));
            $tmp[] = array('data'=>orderState($v));
            $tmp[] = array('data'=>$v['store_id']);
            $tmp[] = array('data'=>$model_common->getfby_order_id($v['order_id'],'reciver_name'));
            //发货时间
            $shipping_time = $model_common->getfby_order_id($v['order_id'],'shipping_time'); 
            if($shipping_time != 0) {
                $tmp[] = array('data'=>date('Y-m-d H:i:s',$shipping_time));
            } else {
                $tmp[] = array('data'=>'');
            }
            
            $tmp[] = array('data'=>$v['payment_code']);
            //$tmp[] = array('data'=>$v['pay_sn']);
            //商品模式
            if($v['is_mode']==0){
                $mode = '一般贸易';
            }else if($v['is_mode']==2){
                $mode = '集货模式';
            }else if($v['is_mode']==1){
                $mode = '备货模式';
            }
            $tmp[] = array('data'=>$mode);

            //交易流水号
            $model_order_log = Model('order_log');
            $logdata = $model_order_log->where(array('order_id'=>$v['order_id'],'log_msg'=>array('like','%支付平台交易号%')))->select();
            $tradeNo = explode(' ',$logdata[0]['log_msg']);
            $tmp[] = array('data'=>$tradeNo[4]);

            $excel_data[] = $tmp;
        }
        $excel_data = $excel_obj->charset($excel_data,CHARSET);
        $excel_obj->addArray($excel_data);
        $excel_obj->addWorksheet($excel_obj->charset('订单',CHARSET));
        $excel_obj->generateXML($excel_obj->charset('订单',CHARSET).$_GET['curpage'].'-'.date('Y-m-d-H',time()));
        */
    }


    /**
     * 生成excel
     *
     * @param array $data
     */
    private function createExcel($data = array()){
        // print_r($data);
        // break;
        Language::read('export');
        import('libraries.excel');
        $excel_obj = new Excel();
        $excel_data = array();
        $model_common = Model('order_common');
        //设置样式
        $excel_obj->setStyle(array('id'=>'s_title','Font'=>array('FontName'=>'宋体','Size'=>'12','Bold'=>'1')));
        //header
        $excel_data[0][] = array('styleid'=>'s_title','data'=>'订单号');
        $excel_data[0][] = array('styleid'=>'s_title','data'=>'店铺');
        $excel_data[0][] = array('styleid'=>'s_title','data'=>'买家');
        $excel_data[0][] = array('styleid'=>'s_title','data'=>'买家ID');
        $excel_data[0][] = array('styleid'=>'s_title','data'=>'买家Email');        
        $excel_data[0][] = array('styleid'=>'s_title','data'=>'下单时间');
        $excel_data[0][] = array('styleid'=>'s_title','data'=>'支付时间');//xinzeng
        $excel_data[0][] = array('styleid'=>'s_title','data'=>'订单完成时间');//xinzeng
        $excel_data[0][] = array('styleid'=>'s_title','data'=>'订单总额');
        $excel_data[0][] = array('styleid'=>'s_title','data'=>'运费');       
        $excel_data[0][] = array('styleid'=>'s_title','data'=>'支付方式');
        $excel_data[0][] = array('styleid'=>'s_title','data'=>'预存款支付金额');
        $excel_data[0][] = array('styleid'=>'s_title','data'=>'充值卡支付金额');
        $excel_data[0][] = array('styleid'=>'s_title','data'=>'订单状态');
        $excel_data[0][] = array('styleid'=>'s_title','data'=>'店铺ID');
        $excel_data[0][] = array('styleid'=>'s_title','data'=>'收货人姓名');
        $excel_data[0][] = array('styleid'=>'s_title','data'=>'收货人身份证号');
        $excel_data[0][] = array('styleid'=>'s_title','data'=>'收货人电话');
        $excel_data[0][] = array('styleid'=>'s_title','data'=>'收货地址');
        $excel_data[0][] = array('styleid'=>'s_title','data'=>'发货时间');
        $excel_data[0][] = array('styleid'=>'s_title','data'=>'支付方式');
        //$excel_data[0][] = array('styleid'=>'s_title','data'=>'支付单号');
        $excel_data[0][] = array('styleid'=>'s_title','data'=>'商品模式');
        $excel_data[0][] = array('styleid'=>'s_title','data'=>'交易流水号'); 

        //data
        foreach ((array)$data as $k=>$v){
            $tmp = array();
            $tmp[] = array('data'=>$v['order_sn']);
            $tmp[] = array('data'=>$v['store_name']);
            $tmp[] = array('data'=>$v['buyer_name']);
            $tmp[] = array('data'=>$v['buyer_id']);
            $tmp[] = array('data'=>$v['buyer_email']);            
            $tmp[] = array('data'=>date('Y-m-d H:i:s',$v['add_time']));

            //支付时间
            if($v['payment_time'] != 0) {
            	$tmp[] = array('data'=>date('Y-m-d H:i:s',$v['payment_time']));//xinzeng
            } else {
                $tmp[] = array('data'=>'');
            }
            
            if($v['finnshed_time'] !=0){
            	$tmp[] = array('data'=>date('Y-m-d H:i:s',$v['finnshed_time']));//xinzeng
            } else {
                $tmp[] = array('data'=>'');
            }


            $tmp[] = array('format'=>'Number','data'=>ncPriceFormat($v['order_amount']));
            $tmp[] = array('format'=>'Number','data'=>ncPriceFormat($v['shipping_fee']));
            $tmp[] = array('data'=>orderPaymentName($v['payment_code']));
            //预存款
            $tmp[] = array('format'=>'Number','data'=>ncPriceFormat($v['pd_amount']));
            // /充值卡
            $tmp[] = array('format'=>'Number','data'=>ncPriceFormat($v['rcb_amount']));
            
            $tmp[] = array('data'=>orderState($v));
            $tmp[] = array('data'=>$v['store_id']);
            
            //收货人姓名
            $reciver_name_tmp = $model_common->getfby_order_id($v['order_id'],'reciver_name');
            $tmp[] = array('data'=>$reciver_name_tmp);

            //收货人身份证号
            $buy_id_tmp = $v['buyer_id'];
            $id_card_arr = Model()->query("SELECT id_card FROM `718shop_address` where (member_id=\"$buy_id_tmp\" and true_name=\"$reciver_name_tmp\") LIMIT 10");
            $id_card = "";
            foreach ((array)$id_card_arr as $k_idcard=>$v_idcard) {
                $id_card .= $v_idcard['id_card']."  ";
            }
            $tmp[] = array('data'=>$id_card);

            //地址和电话
            $tmp[] = array('data'=>$v['extend_order_common']['reciver_info']['phone']);
            $address = str_replace(" ","1",$v['extend_order_common']['reciver_info']['address']);
            //$address = $v['extend_order_common']['reciver_info']['address'];
            $tmp[] = array('data'=>$address);

            //发货时间
            $shipping_time = $model_common->getfby_order_id($v['order_id'],'shipping_time'); 
            if($shipping_time != 0) {
                $tmp[] = array('data'=>date('Y-m-d H:i:s',$shipping_time));
            } else {
                $tmp[] = array('data'=>'');
            }
            
            $tmp[] = array('data'=>$v['payment_code']);
            //$tmp[] = array('data'=>$v['pay_sn']);
            //商品模式
            if($v['is_mode']==0){
                $mode = '一般贸易';
            }else if($v['is_mode']==2){
                $mode = '集货模式';
            }else if($v['is_mode']==1){
                $mode = '备货模式';
            }
            $tmp[] = array('data'=>$mode);

            //交易流水号
            $model_order_log = Model('order_log');
            $logdata = $model_order_log->where(array('order_id'=>$v['order_id'],'log_msg'=>array('like','%支付平台交易号%')))->select();
            $tradeNo = explode(' ',$logdata[0]['log_msg']);
            $tmp[] = array('data'=>$tradeNo[4]);

            $excel_data[] = $tmp;
        }
        $excel_data = $excel_obj->charset($excel_data,CHARSET);
        $excel_obj->addArray($excel_data);
        $excel_obj->addWorksheet($excel_obj->charset('订单',CHARSET));
        $excel_obj->generateXML($excel_obj->charset('订单',CHARSET).$_GET['curpage'].'-'.date('Y-m-d-H',time()));
    }


    /**
     * 生成excel子订单
     *
     * @param array $data
     */
    private function createExcel_sub($data = array(),$goods_name,$goods_serial){
        Language::read('export');
        import('libraries.excel');
        $excel_obj = new Excel();
        $excel_data = array();
        $model_common = Model('order_common');
        $model_order_goods = Model('order_goods');
        $model_goods = Model('goods');
        //设置样式
        $excel_obj->setStyle(array('id'=>'s_title','Font'=>array('FontName'=>'宋体','Size'=>'12','Bold'=>'1')));
        //header
        $excel_data[0][] = array('styleid'=>'s_title','data'=>'订单号');
        $excel_data[0][] = array('styleid'=>'s_title','data'=>'子订单号');
        $excel_data[0][] = array('styleid'=>'s_title','data'=>'店铺');
        $excel_data[0][] = array('styleid'=>'s_title','data'=>'买家');
        $excel_data[0][] = array('styleid'=>'s_title','data'=>'下单时间');
        $excel_data[0][] = array('styleid'=>'s_title','data'=>'商品货号');
        $excel_data[0][] = array('styleid'=>'s_title','data'=>'商品名称');
        $excel_data[0][] = array('styleid'=>'s_title','data'=>'商品数量');
        $excel_data[0][] = array('styleid'=>'s_title','data'=>'商品单价');
        
        $excel_data[0][] = array('styleid'=>'s_title','data'=>'商品总价');
        
        $excel_data[0][] = array('styleid'=>'s_title','data'=>'运费');
        //预存款支付金额
        $excel_data[0][] = array('styleid'=>'s_title','data'=>'预存款支付金额');
        //充值卡支付金额
        $excel_data[0][] = array('styleid'=>'s_title','data'=>'充值卡支付金额');
        $excel_data[0][] = array('styleid'=>'s_title','data'=>'优惠券优惠');
        $excel_data[0][] = array('styleid'=>'s_title','data'=>'实际支付金额');
        $excel_data[0][] = array('styleid'=>'s_title','data'=>'支付方式');
        
        $excel_data[0][] = array('styleid'=>'s_title','data'=>'收货人姓名');
        $excel_data[0][] = array('styleid'=>'s_title','data'=>'发货时间');
        $excel_data[0][] = array('styleid'=>'s_title','data'=>'买家留言');
        $excel_data[0][] = array('styleid'=>'s_title','data'=>'商品模式');
        $excel_data[0][] = array('styleid'=>'s_title','data'=>'订单状态');

        //交易流水号
        $excel_data[0][] = array('styleid'=>'s_title','data'=>'交易流水号');

        //$model_goods = Model('goods');
        if ($goods_serial != '') {
        $goods_id_arr = Model()->query("SELECT goods_id FROM `718shop_goods` where goods_serial=\"$goods_serial\" LIMIT 10");
        $goods_id = $goods_id_arr[0]['goods_id'];
        }
        //$goods_id = $model_goods->getfby_goods_serial($goods_serial,'goods_id');
       // print_r($goods_id);
        //break;



        //data
        foreach ((array)$data as $k=>$v){
        	$condition  = array();
        	$condition['order_id'] = $v['order_id'];
        	$condition['goods_name'] = array('like','%'.$goods_name.'%');

            //特别修正
        	if ($goods_serial != '') {
                $condition['goods_id'] = $goods_id; 
        	}

        	$sub_data = $model_order_goods->where($condition)->select();

            //$sub_data = $model_order_goods->where(array('order_id'=>$v['order_id'],'goods_name'=>array('like','%'.$goods_name.'%'),'goods_id'=>$goods_id))->select();
            //print_r($sub_data);
            //break;
            $ii = 0;
           foreach ((array)$sub_data as $k1=>$v1){
            $ii++;
            $tmp = array();
            if($ii==1){
                $tmp[] = array('data'=>$v['order_sn']);
            }
            else {
                $tmp[] = array('data'=>'');
            }
            $tmp[] = array('data'=>$v['order_sn'].$v1['goods_id']);
            
            if($ii==1){
                $tmp[] = array('data'=>$v['store_name']);
                $tmp[] = array('data'=>$v['buyer_name']);
                $tmp[] = array('data'=>date('Y-m-d H:i:s',$v['add_time']));
            } else {
                $tmp[] = array('data'=>'');
                $tmp[] = array('data'=>'');
                $tmp[] = array('data'=>'');
            }
            //商品货号
            $goid = $v1['goods_id'];
            $serial = Model()->query("SELECT goods_serial FROM `718shop_goods` where goods_id=\"$goid\" LIMIT 10");
            $tmp[] = array('data'=>$serial[0]['goods_serial']);


            //$tmp[] = array('data'=>$v1['goods_name']);
            //商品长度过长，临时修正
           // $goid = $v1['goods_id'];
            $goods_name_tmp = Model()->query("SELECT goods_name FROM `718shop_goods` where goods_id=\"$goid\" LIMIT 10");
            $tmp[] = array('data'=>$goods_name_tmp[0]['goods_name']);

            //商品数量
            $tmp[] = array('data'=>$v1['goods_num']);

            //商品单价
            $tmp[] = array('data'=>$v1['goods_price']);

            //$tmp[] = array('data'=>$v1['goods_pay_price']);
            $tmp[] = array('data'=>number_format($v1['goods_price']*$v1['goods_num'],2));
            if($ii==1){
                
                //运费
                $tmp[] = array('data'=>$v['shipping_fee']);

                //充值卡支付金额
                $tmp[] = array('data'=>$v['pd_amount']);
                //充值卡支付金额
                $tmp[] = array('data'=>$v['rcb_amount']);
                //优惠券
                $voucher_tmp_num = $model_common->getfby_order_id($v['order_id'],'voucher_price');
                if ($voucher_tmp_num != ''){$voucher_tmp = '-'.number_format($voucher_tmp_num,2);}
                else {$voucher_tmp = '0.00';}
                $tmp[] = array('data'=>$voucher_tmp);

            //实际支付金额
            $tmp[] = array('data'=>$v['order_amount']);
            //支付方式
            $tmp[] = array('data'=>orderPaymentName($v['payment_code']));
            
            //$tmp[] = array('data'=>);
            //$tmp[] = array('data'=>);
            // $tmp[] = array('data'=>);
            
             //收货人姓名
             $reciver_name_tmp = $model_common->getfby_order_id($v['order_id'],'reciver_name');
             $tmp[] = array('data'=>$reciver_name_tmp);

            
            
              $shipping_time = $model_common->getfby_order_id($v['order_id'],'shipping_time'); 
              if($shipping_time != 0) {
                  $tmp[] = array('data'=>date('Y-m-d H:i:s',$shipping_time));
              } else {
                 $tmp[] = array('data'=>'');
             }
              $tmp[] = array('data'=>$model_common->getfby_order_id($v['order_id'],'order_message'));

                //商品模式
                 if($v['is_mode']==0){
                 $mode = '一般贸易';
                }else if($v['is_mode']==2){
                    $mode = '集货模式';
                }else if($v['is_mode']==1){
                    $mode = '备货模式';
                }
                $tmp[] = array('data'=>$mode);
            } else {
                $tmp[] = array('data'=>'');
                $tmp[] = array('data'=>'');
                $tmp[] = array('data'=>'');
                $tmp[] = array('data'=>'');
                $tmp[] = array('data'=>'');
                $tmp[] = array('data'=>'');
                $tmp[] = array('data'=>'');
                $tmp[] = array('data'=>'');
                $tmp[] = array('data'=>'');
                $tmp[] = array('data'=>'');
                
            }
            $tmp[] = array('data'=>orderState($v));

            //交易流水号
            $model_order_log = Model('order_log');
            $logdata = $model_order_log->where(array('order_id'=>$v['order_id'],'log_msg'=>array('like','%支付平台交易号%')))->select();
            $tradeNo = explode(' ',$logdata[0]['log_msg']);
            $tmp[] = array('data'=>$tradeNo[4]);

            $excel_data[] = $tmp;
           }   
        }
        $excel_data = $excel_obj->charset($excel_data,CHARSET);
        $excel_obj->addArray($excel_data);
        $excel_obj->addWorksheet($excel_obj->charset('子订单',CHARSET));
        $excel_obj->generateXML($excel_obj->charset('子订单',CHARSET).$_GET['curpage'].'-'.date('Y-m-d-H',time()));
    }



	/**
	 * 订单列表
	 *
	 */
	public function indexOp() {
        $model_order = Model('order');
        $condition = array();
        $condition['store_id'] = $_SESSION['store_id'];
        if ($_GET['order_sn'] != '') {
            $condition['order_sn'] = $_GET['order_sn'];
        }
        if ($_GET['buyer_name'] != '') {
            $condition['buyer_name'] = $_GET['buyer_name'];
        }
        if ($_GET['is_mode'] != '') {
            $condition['is_mode'] = $_GET['is_mode'];
        }
        $allow_state_array = array('state_new','state_pay','state_send','state_success','state_cancel');
        if (in_array($_GET['state_type'],$allow_state_array)) {
            $condition['order_state'] = str_replace($allow_state_array,
                    array(ORDER_STATE_NEW,ORDER_STATE_PAY,ORDER_STATE_SEND,ORDER_STATE_SUCCESS,ORDER_STATE_CANCEL), $_GET['state_type']);
        } else {
            $_GET['state_type'] = 'store_order';
        }
        $if_start_date = preg_match('/^20\d{2}-\d{2}-\d{2}$/',$_GET['query_start_date']);
        $if_end_date = preg_match('/^20\d{2}-\d{2}-\d{2}$/',$_GET['query_end_date']);
        $start_unixtime = $if_start_date ? strtotime($_GET['query_start_date']) : null;
        $end_unixtime = $if_end_date ? strtotime($_GET['query_end_date']): null;
        if ($start_unixtime || $end_unixtime) {
            $condition['add_time'] = array('time',array($start_unixtime,$end_unixtime));
        }

        if ($start_unixtime || $end_unixtime) {
            $condition['payment_time'] = array('time',array($start_unixtime,$end_unixtime));//xinzeng       
        }

        if ($_GET['skip_off'] == 1) {
            $condition['order_state'] = array('neq',ORDER_STATE_CANCEL);
        }

        $order_list = $model_order->getOrderList($condition, 20, '*', 'order_id desc','', array('order_goods','order_common','member'));

        //页面中显示那些操作
        foreach ($order_list as $key => $order_info) {

        	//显示取消订单
        	$order_info['if_cancel'] = $model_order->getOrderOperateState('store_cancel',$order_info);

        	//显示调整运费
        	$order_info['if_modify_price'] = $model_order->getOrderOperateState('modify_price',$order_info);
			
		//显示修改价格
        	$order_info['if_spay_price'] = $model_order->getOrderOperateState('spay_price',$order_info);

        	//显示发货
        	$order_info['if_send'] = $model_order->getOrderOperateState('send',$order_info);

        	//显示锁定中
        	$order_info['if_lock'] = $model_order->getOrderOperateState('lock',$order_info);

        	//显示物流跟踪
        	$order_info['if_deliver'] = $model_order->getOrderOperateState('deliver',$order_info);

        	foreach ($order_info['extend_order_goods'] as $value) {
        	    $value['image_60_url'] = cthumb($value['goods_image'], 60, $value['store_id']);
        	    $value['image_240_url'] = cthumb($value['goods_image'], 240, $value['store_id']);
        	    $value['goods_type_cn'] = orderGoodsType($value['goods_type']);
        	    $value['goods_url'] = urlShop('goods','index',array('goods_id'=>$value['goods_id']));
        	    if ($value['goods_type'] == 5) {
        	        $order_info['zengpin_list'][] = $value;
        	    } else {
        	        $order_info['goods_list'][] = $value;
        	    }
        	}

        	if (empty($order_info['zengpin_list'])) {
        	    $order_info['goods_count'] = count($order_info['goods_list']);
        	} else {
        	    $order_info['goods_count'] = count($order_info['goods_list']) + 1;
        	}
        	$order_list[$key] = $order_info;

        }

        Tpl::output('order_list',$order_list);
        Tpl::output('show_page',$model_order->showpage());
        self::profile_menu('list',$_GET['state_type']);

        Tpl::showpage('store_export.index');
	}

	/**
	 * 卖家订单详情
	 *
	 */
	public function show_orderOp() {
		Language::read('member_member_index');
	    $order_id = intval($_GET['order_id']);
	    if ($order_id <= 0) {
	        showMessage(Language::get('wrong_argument'),'','html','error');
	    }
	    $model_order = Model('order');
	    $condition = array();
        $condition['order_id'] = $order_id;
        $condition['store_id'] = $_SESSION['store_id'];
	    $order_info = $model_order->getOrderInfo($condition,array('order_common','order_goods','member'));
	    if (empty($order_info)) {
	        showMessage(Language::get('store_order_none_exist'),'','html','error');
	    }

        $model_refund_return = Model('refund_return');
        $order_list = array();
        $order_list[$order_id] = $order_info;
        $order_list = $model_refund_return->getGoodsRefundList($order_list,1);//订单商品的退款退货显示
        $order_info = $order_list[$order_id];
        $refund_all = $order_info['refund_list'][0];
        if (!empty($refund_all) && $refund_all['seller_state'] < 3) {//订单全部退款商家审核状态:1为待审核,2为同意,3为不同意
            Tpl::output('refund_all',$refund_all);
        }

        //显示锁定中
        $order_info['if_lock'] = $model_order->getOrderOperateState('lock',$order_info);

    	//显示调整运费
    	$order_info['if_modify_price'] = $model_order->getOrderOperateState('modify_price',$order_info);
		
		//显示调整价格
    	$order_info['if_spay_price'] = $model_order->getOrderOperateState('spay_price',$order_info);

        //显示取消订单
        $order_info['if_cancel'] = $model_order->getOrderOperateState('buyer_cancel',$order_info);

    	//显示发货
    	$order_info['if_send'] = $model_order->getOrderOperateState('send',$order_info);

        //显示物流跟踪
        $order_info['if_deliver'] = $model_order->getOrderOperateState('deliver',$order_info);

        //显示系统自动取消订单日期
        if ($order_info['order_state'] == ORDER_STATE_NEW) {
            //$order_info['order_cancel_day'] = $order_info['add_time'] + ORDER_AUTO_CANCEL_DAY * 24 * 3600;
			// by www.shopnc.net
			$order_info['order_cancel_day'] = $order_info['add_time'] + ORDER_AUTO_CANCEL_DAY + 3 * 24 * 3600;
        }

        //显示快递信息
        if ($order_info['shipping_code'] != '') {
            $express = rkcache('express',true);
            $order_info['express_info']['e_code'] = $express[$order_info['extend_order_common']['shipping_express_id']]['e_code'];
            $order_info['express_info']['e_name'] = $express[$order_info['extend_order_common']['shipping_express_id']]['e_name'];
            $order_info['express_info']['e_url'] = $express[$order_info['extend_order_common']['shipping_express_id']]['e_url'];
        }

        //显示系统自动收获时间
        if ($order_info['order_state'] == ORDER_STATE_SEND) {
            //$order_info['order_confirm_day'] = $order_info['delay_time'] + ORDER_AUTO_RECEIVE_DAY * 24 * 3600;
			//by www.shopnc.net
			$order_info['order_confirm_day'] = $order_info['delay_time'] + ORDER_AUTO_RECEIVE_DAY + 15 * 24 * 3600;
        }

        //如果订单已取消，取得取消原因、时间，操作人
        if ($order_info['order_state'] == ORDER_STATE_CANCEL) {
            $order_info['close_info'] = $model_order->getOrderLogInfo(array('order_id'=>$order_info['order_id']),'log_id desc');
        }

        foreach ($order_info['extend_order_goods'] as $value) {
            $value['image_60_url'] = cthumb($value['goods_image'], 60, $value['store_id']);
            $value['image_240_url'] = cthumb($value['goods_image'], 240, $value['store_id']);
            $value['goods_type_cn'] = orderGoodsType($value['goods_type']);
            $value['goods_url'] = urlShop('goods','index',array('goods_id'=>$value['goods_id']));
            if ($value['goods_type'] == 5) {
                $order_info['zengpin_list'][] = $value;
            } else {
                $order_info['goods_list'][] = $value;
            }
        }
        
        if (empty($order_info['zengpin_list'])) {
            $order_info['goods_count'] = count($order_info['goods_list']);
        } else {
            $order_info['goods_count'] = count($order_info['goods_list']) + 1;
        }

	    Tpl::output('order_info',$order_info);

        //发货信息
        if (!empty($order_info['extend_order_common']['daddress_id'])) {
            $daddress_info = Model('daddress')->getAddressInfo(array('address_id'=>$order_info['extend_order_common']['daddress_id']));
            Tpl::output('daddress_info',$daddress_info);
        }

		Tpl::showpage('store_order.show');
	}

	/**
	 * 卖家订单状态操作
	 *
	 */
	public function change_stateOp() {
		$state_type	= $_GET['state_type'];
		$order_id	= intval($_GET['order_id']);

		$model_order = Model('order');
		$condition = array();
		$condition['order_id'] = $order_id;
		$condition['store_id'] = $_SESSION['store_id'];
		$order_info	= $model_order->getOrderInfo($condition);

		if ($_GET['state_type'] == 'order_cancel') {
		    $result = $this->_order_cancel($order_info,$_POST);
		} elseif ($_GET['state_type'] == 'modify_price') {
		    $result = $this->_order_ship_price($order_info,$_POST);
		} elseif ($_GET['state_type'] == 'spay_price') {
			$result = $this->_order_spay_price($order_info,$_POST);
    		}
        if (!$result['state']) {
            showDialog($result['msg'],'','error',empty($_GET['inajax']) ?'':'CUR_DIALOG.close();');
        } else {
            showDialog($result['msg'],'reload','succ',empty($_GET['inajax']) ?'':'CUR_DIALOG.close();');
        }
	}

	/**
	 * 取消订单
	 * @param unknown $order_info
	 */
	private function _order_cancel($order_info, $post) {
	    $model_order = Model('order');
	    $logic_order = Logic('order');

	    if(!chksubmit()) {
            Tpl::output('order_info',$order_info);
            Tpl::output('order_id',$order_info['order_id']);
            Tpl::showpage('store_order.cancel','null_layout');
            exit();
	     } else {
	         $if_allow = $model_order->getOrderOperateState('store_cancel',$order_info);
	         if (!$if_allow) {
	             return callback(false,'无权操作');
	         }
	         $msg = $post['state_info1'] != '' ? $post['state_info1'] : $post['state_info'];
	         return $logic_order->changeOrderStateCancel($order_info,'seller',$_SESSION['member_name'], $msg);
	     }
	}

	/**
	 * 修改运费
	 * @param unknown $order_info
	 */
	private function _order_ship_price($order_info, $post) {
	    $model_order = Model('order');
	    $logic_order = Logic('order');
	    if(!chksubmit()) {
	        Tpl::output('order_info',$order_info);
	        Tpl::output('order_id',$order_info['order_id']);
            Tpl::showpage('store_order.edit_price','null_layout');
            exit();
        } else {
            $if_allow = $model_order->getOrderOperateState('modify_price',$order_info);
            if (!$if_allow) {
                return callback(false,'无权操作');
            }
            return $logic_order->changeOrderShipPrice($order_info,'seller',$_SESSION['member_name'],$post['shipping_fee']);           
        }

	}
	/**
	 * 修改商品价格
	 * @param unknown $order_info
	 */
	private function _order_spay_price($order_info, $post) {
        $model_order = Model('order');
	    $logic_order = Logic('order');
	    if(!chksubmit()) {
	        Tpl::output('order_info',$order_info);
	        Tpl::output('order_id',$order_info['order_id']);
            Tpl::showpage('store_order.edit_spay_price','null_layout');
            exit();
        } else {
            $if_allow = $model_order->getOrderOperateState('spay_price',$order_info);
            if (!$if_allow) {
                return callback(false,'无权操作');
            }
            return $logic_order->changeOrderSpayPrice($order_info,'seller',$_SESSION['member_name'],$post['goods_amount']); 
	    }
	}


	/**
	 * 用户中心右边，小导航
	 *
	 * @param string	$menu_type	导航类型
	 * @param string 	$menu_key	当前导航的menu_key
	 * @return
     */
    private function profile_menu($menu_type='',$menu_key='') {
        Language::read('member_layout');
        switch ($menu_type) {
        	case 'list':
            $menu_array = array(
            array('menu_key'=>'store_order',		'menu_name'=>Language::get('nc_member_path_all_order'),	'menu_url'=>'index.php?act=store_order'),
            array('menu_key'=>'state_new',			'menu_name'=>Language::get('nc_member_path_wait_pay'),	'menu_url'=>'index.php?act=store_order&op=index&state_type=state_new'),
            array('menu_key'=>'state_pay',	        'menu_name'=>Language::get('nc_member_path_wait_send'),	'menu_url'=>'index.php?act=store_order&op=store_order&state_type=state_pay'),
            array('menu_key'=>'state_send',		    'menu_name'=>Language::get('nc_member_path_sent'),	    'menu_url'=>'index.php?act=store_order&op=index&state_type=state_send'),
            array('menu_key'=>'state_success',		'menu_name'=>Language::get('nc_member_path_finished'),	'menu_url'=>'index.php?act=store_order&op=index&state_type=state_success'),
            array('menu_key'=>'state_cancel',		'menu_name'=>Language::get('nc_member_path_canceled'),	'menu_url'=>'index.php?act=store_order&op=index&state_type=state_cancel'),
            );
            break;
        }
        Tpl::output('member_menu',$menu_array);
        Tpl::output('menu_key',$menu_key);
    }
}
