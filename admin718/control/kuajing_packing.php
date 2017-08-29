<?php
/**
 * 电商平台跨境参数信息-包装方式
 *
 *
 *
 **/

defined('InShopNC') or exit('Access Invalid!');
class kuajing_packingControl extends SystemControl{
	
	public function __construct(){
		parent::__construct();
		Language::read('setting');
	}


	public function indexOp(){
		$lang	= Language::getLangContent();
		$model = Model('kuajing_packing');
		$condition	= array();
		
		
		if($_POST['like_sg_name']) {
        	$condition['packing_name'] = array('like','%'.$_POST['like_sg_name'].'%');
			
			$result=$model->where($condition)->select();
		}else{
			$result=$model->page('10')->select();
		}

		Tpl::output('like_sg_name',$_POST['like_sg_name']);
		Tpl::output('result',$result);
		Tpl::output('page',$model->showpage());
		Tpl::showpage('kuajing_packing.index');
	}


	/**
     * 跨境平台参数增加
     */
    public function addOp() {

    	Tpl::showpage('kuajing_packing.add');

}


	/**
     * 跨境平台参数增加  gai
     */
    public function add_saveOp() {
       $model_packing = Model ( 'kuajing_packing' );
     	if (chksubmit()){
			//验证表单信息
			//$packing_name=$_POST['packing_name'];
				$data = array();
				$data['packing_name']       = $_POST['packing_name'];
				$data['code_guan']       = $_POST['code_guan'];
				$data['code_jian']       = $_POST['code_jian'];
				
				$model_packing->insert($data);
				$result=$model_packing->page('10')->select();
	            Tpl::output('result',$result);
				Tpl::output('page',$model_packing->showpage());
	            Tpl::showpage('kuajing_packing.index');	    
           
       }
}
	/**
     * 跨境平台参数编辑 xinzeng
     */
    public function editOp() {
		//$packing_id = trim($_GET['packing_id']);
	    $model = Model();
		$condition = array();
        //$condition['packing_id'] = array('in',$packing_id);
        $condition['packing_id'] = $_GET['packing_id'];
        $result = $model->table('kuajing_packing')->where($condition)->find();
		Tpl::output('result',$result);
    	Tpl::showpage('kuajing_packing.edit');
}

	/**
     * 跨境平台参数编辑  xinzeng
     */
   public function edit_saveOp() {
   		$model_hs = Model ( 'kuajing_packing' );
	    $lang	= Language::getLangContent();
	    $model = Model();
        $condition = array();
        $condition['packing_id'] = $_POST['packing_id'];
		$data['packing_name']       = $_POST['packing_name'];
		$data['code_guan']       = $_POST['code_guan'];
		$data['code_jian']       = $_POST['code_jian'];
		$result=$model->table('kuajing_packing')->where($condition)->update($data);
		if ($result){
			showMessage($lang['nc_common_save_succ'],'index.php?act=kuajing_packing&op=index');
		}else {
			showMessage($lang['nc_common_save_fail'],'index.php?act=kuajing_packing&op=index');
		}
	}

	
	
	/**
	 * 跨境平台参数删除  xinzeng
	 */
	public function delOp(){
		$lang	= Language::getLangContent();
		$packing_id = trim($_POST['packing_id']);
        $model= Model();
        $condition = array();
        $condition['packing_id'] = array('in',$packing_id);
        $result = $model->table('kuajing_packing')->where($condition)->delete();
        if($result) {
            $this->log(Language::get('hs_code_del').$_POST['packing_id'], 1);
            showMessage(Language::get('nc_common_del_succ'),'index.php?act=kuajing_packing&op=index');
        } else {
            $this->log(Language::get('hs_code_del').$_POST['packing_id'], 0);
            showMessage(Language::get('nc_common_del_fail'),'ndex.php?act=kuajing_packing&op=index');
        }


	}


	
}
