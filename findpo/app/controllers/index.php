<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Index extends CI_Controller {
	
	public function __construct()
	{
        parent::__construct();
        $this->load->model('User_model','usermodel');
        $this->load->model('Item_model','itemmodel');
        $this->load->helper('url');
	}
	
	function index() {
		$data['setting'] = $this->usermodel->import_setting();
		$uid = $this->session->userdata('uid');
		if (!empty($uid)) {
			$data['username'] = $this->session->userdata('username');
			$data['cartcount'] = $this->usermodel->viewcart($uid);
		}
		$data['proinfos'] = $this->itemmodel->index();
		$data['app'] = $this->input->get('app');
		$this->load->view('user/index', $data);
	}
	
	//交易信息
	function wanted() {
		$data['setting'] = $this->usermodel->import_setting();
		$uid = $this->session->userdata('uid');
		if (!empty($uid)) {
			$data['username'] = $this->session->userdata('username');
			$data['cartcount'] = $this->usermodel->viewcart($uid);
		}
		$data['wanteds'] = $this->itemmodel->wanted();
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
		$this->load->view('user/wanted', $data);
	}
	
}
?>