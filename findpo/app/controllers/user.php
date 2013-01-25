<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class User extends CI_Controller {
	
	public function __construct()
	{
        parent::__construct();
        $this->load->model('Item_model','itemmodel');
        $this->load->model('User_model','usermodel');
        $this->load->helper('url');
	}
	
	function index() {
		$uid = $this->input->get('uid');
		if (preg_match('/^[0-9]+$/', $uid)) {
			$userinfo = $this->usermodel->getuserinfo($uid);
			if (!empty($userinfo)) {
				print_r($userinfo);
			} else {
				show_404();
			}
		} else {
			show_404();
		}
	}
	
}
?>