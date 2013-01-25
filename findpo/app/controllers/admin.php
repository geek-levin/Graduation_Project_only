<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Admin extends CI_Controller {
	
	public function __construct()
	{
        parent::__construct();
        $this->load->model('Admin_model','adminmodel');
        $this->load->helper('url');
        $aid = $this->session->userdata('aid');
		if (empty($aid)) {
			redirect('adminlogin', 'location');
		}
	}
	
	function index() {
		$data['cookie'] = $this->session->all_userdata();
		$data['app'] = $this->input->get('app');
		$data['realname'] = $this->session->userdata('realname');
		$data['lastlogin'] = $this->session->userdata('lastlogin');
		$data['login_count'] = $this->session->userdata('login_count');
		$this->load->view('admin/index', $data);
	}
	
	//右侧面板
	function portal() {
		$this->load->view('admin/myportal');
	}
	
	//传递待认证店铺用户信息
	function getcert() {
		$data['shopinfo'] = $this->adminmodel->getcert();
		$page = $this->input->get('page');
		if (!empty($page)) {
			if (preg_match('/^[0-9]+$/', $page)) {
				if ($page == 0) {
					$data['page'] = 1;
				} else {
					$data['page'] = $page;
				}
			} else {
				$data['page'] = 1;
			}
		} else {
			$data['page'] = 1;
		}
		$this->load->view('admin/cert', $data);
	}
	
	//登出
	function logout() {
		$logindata = array('aid'=>'', 'realname'=>'', 'permission'=>'', 'lastlogin'=>'', 'login_count'=>'');
		$this->session->unset_userdata($logindata);
		redirect('admin', 'location');
	}
	
}
?>