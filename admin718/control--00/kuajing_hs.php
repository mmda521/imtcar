<?php
/**
 * 网站设置
 *
 *
 *
 **by 好商城V3 www.shopnc.net 运营版*/

//defined('InShopNC') or exit('Access Invalid!');
class kuajing_hsControl extends SystemControl{
	private $links = array(
		//array('url'=>'act=bhcs&op=base','lang'=>'web_set'),
		//array('url'=>'act=bhcs&op=dump','lang'=>'dis_dump'),
	);
	public function __construct(){
		parent::__construct();
		Language::read('setting');
	}

	/**
	 * 基本信息
	 */
	public function bas1eOp(){
		$model_setting = Model('setting');
		if (chksubmit()){
			//上传网站Logo
			if (!empty($_FILES['site_logo']['name'])){
				$upload = new UploadFile();
				$upload->set('default_dir',ATTACH_COMMON);
				$result = $upload->upfile('site_logo');
				if ($result){
					$_POST['site_logo'] = $upload->file_name;
				}else {
					showMessage($upload->error,'','','error');
				}
			}
			
			// 上传wap手机客户端LOGO
			if (!empty($_FILES['site_mobile_logo']['name'])){
				$upload = new UploadFile();
				$upload->set('default_dir',ATTACH_COMMON);
				$upload->file_name='home_logo.png';
				$result = $upload->upfile('site_mobile_logo');
				if ($result){
					$_POST['site_mobile_logo'] = $upload->file_name;
				}else {
					showMessage($upload->error,'','','error');
				}
			}
			
			//二维码微信图片 
			if (!empty($_FILES['site_logowx']['name'])){
				$upload = new UploadFile();
				$upload->set('default_dir',ATTACH_COMMON);
				$result = $upload->upfile('site_logowx');
				if ($result){
					$_POST['site_logowx'] = $upload->file_name;
				}else {
					showMessage($upload->error,'','','error');
				}
			}
			if (!empty($_FILES['member_logo']['name'])){
				$upload = new UploadFile();
				$upload->set('default_dir',ATTACH_COMMON);
				$result = $upload->upfile('member_logo');
				if ($result){
					$_POST['member_logo'] = $upload->file_name;
				}else {
					showMessage($upload->error,'','','error');
				}
			}
			if (!empty($_FILES['seller_center_logo']['name'])){
				$upload = new UploadFile();
				$upload->set('default_dir',ATTACH_COMMON);
				$result = $upload->upfile('seller_center_logo');
				if ($result){
					$_POST['seller_center_logo'] = $upload->file_name;
				}else {
					showMessage($upload->error,'','','error');
				}
			}
			$list_setting = $model_setting->getListSetting();
			$update_array = array();
			$update_array['time_zone'] = $this->setTimeZone($_POST['time_zone']);
			$update_array['site_name'] = $_POST['site_name'];
			$update_array['site_phone'] = $_POST['site_phone'];
			$update_array['site_bank_account'] = $_POST['site_bank_account'];
			$update_array['site_email'] = $_POST['site_email'];
			$update_array['statistics_code'] = $_POST['statistics_code'];
			if (!empty($_POST['site_logo'])){
				$update_array['site_logo'] = $_POST['site_logo'];
			}
			//  V3-B11
			if (!empty($_POST['site_mobile_logo'])){
				$update_array['site_mobile_logo'] = $_POST['site_mobile_logo'];
			}
			if (!empty($_POST['site_logowx'])){
				$update_array['site_logowx'] = $_POST['site_logowx'];
			}
			if (!empty($_POST['member_logo'])){
				$update_array['member_logo'] = $_POST['member_logo'];
			}
			if (!empty($_POST['seller_center_logo'])){
				$update_array['seller_center_logo'] = $_POST['seller_center_logo'];
			}
			$update_array['icp_number'] = $_POST['icp_number'];
			//设置表 400电话 by www.shopnc.net
			$update_array['site_tel400'] = $_POST['site_tel400'];
			$update_array['site_status'] = $_POST['site_status'];
			$update_array['closed_reason'] = $_POST['closed_reason'];
			$result = $model_setting->updateSetting($update_array);
			if ($result === true){
				//判断有没有之前的图片，如果有则删除
				if (!empty($list_setting['site_logo']) && !empty($_POST['site_logo'])){
					@unlink(BASE_UPLOAD_PATH.DS.ATTACH_COMMON.DS.$list_setting['site_logo']);
				}
				if (!empty($list_setting['site_logowx']) && !empty($_POST['site_logowx'])){
			        @unlink(BASE_UPLOAD_PATH.DS.ATTACH_COMMON.DS.$list_setting['site_logowx']);
			    }
				if (!empty($list_setting['member_logo']) && !empty($_POST['member_logo'])){
					@unlink(BASE_UPLOAD_PATH.DS.ATTACH_COMMON.DS.$list_setting['member_logo']);
				}
				if (!empty($list_setting['seller_center_logo']) && !empty($_POST['seller_center_logo'])){
					@unlink(BASE_UPLOAD_PATH.DS.ATTACH_COMMON.DS.$list_setting['seller_center_logo']);
                }
				$this->log(L('nc_edit,web_set'),1);
				showMessage(L('nc_common_save_succ'));
			}else {
				$this->log(L('nc_edit,web_set'),0);
				showMessage(L('nc_common_save_fail'));
			}
		}
		$list_setting = $model_setting->getListSetting();
		foreach ($this->getTimeZone() as $k=>$v) {
			if ($v == $list_setting['time_zone']){
				$list_setting['time_zone'] = $k;break;
			}
		}
		Tpl::output('list_setting',$list_setting);

		//输出子菜单
		Tpl::output('top_link',$this->sublink($this->links,'base'));


		//备货参数
		$model = Model('ctax_hs');
		$result=$model->select();

		//Tpl::output('like_sg_name',trim($_POST['like_sg_name']));
		Tpl::output('hs',$result);
		Tpl::showpage('kuajing_hs.index');

	}


	public function startOp(){

		$model = Model('ctax_hs');
		$result=$model->limit(100)->select();

		//Tpl::output('like_sg_name',trim($_POST['like_sg_name']));
		Tpl::output('hs',$result);
		Tpl::showpage('kuajing_hs.index');
	}

	/**
     * 跨境HS参数增加
     */
    public function addOp() {

    	Tpl::showpage('kuajing_hs.add');

}


	/**
     * 跨境HS参数增加  gai
     */
    public function add_hsOp() {
       $model_hs = Model ( 'ctax_hs' );
     	if (chksubmit()){
			//验证表单信息
			$hs_code=$_POST['hs'];
			$condition = array();
            $condition['hs'] = array('in',$hs_code);
            $count = $model_hs->where($condition)->count();
            if ($count >= 1) {
			    showMessage('保存失败，此HS码已保存不能重复输入','index.php?act=kuajing_hs&op=start');
            }
			$obj_validate = new Validate();
			$obj_validate->validateparam = array(
				array("input"=>$_POST["hs"],"require"=>"true","message"=>'请输入hs码'),
				array("input"=>$_POST["xiaofie_rate"],"require"=>"true","validator"=>"Number","message"=>'请输入消费税'),
				array("input"=>$_POST["zengzhi_rate"],"require"=>"true","validator"=>"Number","message"=>'请输入增值税')
			);
			$error = $obj_validate->validate();
			$error = $obj_validate->validate();
			if ($error != ''){
				showMessage($error);
			}else {
			   if(isset($_POST['hs'])&&isset($_POST['xiaofei_rate'])&&isset($_POST['zengzhi_rate'])&&$_POST['hs']!=null&&$_POST['xiaofei_rate']!=null&&$_POST['zengzhi_rate']!=null) {
				$data = array();
				$data['id']         = $_POST['id'];
				$data['hs']         = $_POST['hs'];
				//$data['guan_rate']         = $_POST['guan_rate'];
				$data['xiaofei_rate']       = $_POST['xiaofei_rate'];
				$data['zengzhi_rate']       = $_POST['zengzhi_rate'];
				$model_hs->insert($data);
				$result=$model_hs->select();
	            Tpl::output('hs',$result);
	            Tpl::showpage('kuajing_hs.index');

			    }
           }
       }
}
	/**
     * 跨境HS参数编辑 xinzeng
     */
    public function editOp() {
		$hs_id = trim($_GET['hs_id']);
	    $model = Model();
		$condition = array();
        $condition['id'] = array('in',$hs_id);
        $result = $model->table('ctax_hs')->where($condition)->find();
		Tpl::output('hs',$result);
    	Tpl::showpage('kuajing_hs.edit');
}

	/**
     * 跨境HS参数编辑  xinzeng
     */
   public function edit_hsOp() {
	    $lang	= Language::getLangContent();
		$hs_id = $_POST['id'];
	    $model = Model();
        $condition = array();
        $condition['id'] = array('in',$hs_id);
		$data['hs']         = $_POST['hs'];
		//$data['guan_rate']         = $_POST['guan_rate'];
		$data['xiaofei_rate']       = $_POST['xiaofei_rate'];
		$data['zengzhi_rate']       = $_POST['zengzhi_rate'];
		$result=$model->table('ctax_hs')->where($condition)->update($data);
		if ($result){
			showMessage($lang['nc_common_save_succ'],'index.php?act=kuajing_hs&op=start');
		}else {
			showMessage($lang['nc_common_save_fail'],'index.php?act=kuajing_hs&op=start');
		}
	}

	
	
	/**
	 * 跨境HS参数删除  xinzeng
	 */
	public function del_hsOp(){
		$lang	= Language::getLangContent();
		$hs_id = trim($_POST['hs_id']);
        $model= Model();
        $condition = array();
        $condition['id'] = array('in',$hs_id);
        $result = $model->table('ctax_hs')->where($condition)->delete();
        if($result) {
            $this->log(Language::get('hs_code_del').$_POST['hs_id'], 1);
            showMessage(Language::get('nc_common_del_succ'),'index.php?act=kuajing_hs&op=start');
        } else {
            $this->log(Language::get('hs_code_del').$_POST['hs_id'], 0);
            showMessage(Language::get('nc_common_del_fail'),'ndex.php?act=kuajing_hs&op=start');
        }


	}



    /**
	 * ajax操作
	 */
	public function ajaxOp(){
		switch ($_GET['branch']){
			/**
			 * 店铺等级：验证是否有重复的名称
			 */
			case 'check_grade_name':
				if ($this->checkGradeName($_GET)){
					echo 'true'; exit;
				}else{
					echo 'false'; exit;
				}
				break;
			case 'check_grade_sort':
				if ($this->checkGradeSort($_GET)){
					echo 'true'; exit;
				}else{
					echo 'false'; exit;
				}
				break;
		}
	}
	/**
	 * 查询店铺等级名称是否存在
	 */
	private function checkGradeName($param){
		$model_grade = Model('store_grade');
		$condition['sg_name'] = $param['sg_name'];
		$condition['no_sg_id'] = $param['sg_id'];
		$list = $model_grade->getGradeList($condition);
		if (empty($list)){
			return true;
		}else {
			return false;
		}
	}

	
}
