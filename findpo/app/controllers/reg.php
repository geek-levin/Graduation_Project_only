<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Reg extends CI_Controller {
	
	public function __construct()
	{
        parent::__construct();
        $this->load->model('User_model','usermodel');
        $this->load->helper('url');
	}
	
	function index() {
		$uid = $this->session->userdata('uid');
		$data['setting'] = $this->usermodel->import_setting();
		if (!empty($uid)) {
			redirect('i', 'location');
		} else {
			$this->load->library('form_validation');
			$this->load->helper('form');
			
			$this->form_validation->set_rules('po_username', '帐号', 'trim|required|alpha_numeric|min_length[4]|max_length[16]|xss_clean');
			$this->form_validation->set_rules('po_password', '密码', 'required|matches[conpassword]|min_length[6]|max_length[16]|md5');
			$this->form_validation->set_rules('conpassword', '确认密码', 'required');
			$this->form_validation->set_rules('email', '邮箱', 'trim|required|valid_email|xss_clean');
			
			if ($this->form_validation->run() == false) {
				$this->load->view('user/reg', $data);
			} else {
				$username = $this->input->get_post('po_username');
				$password = $this->input->get_post('po_password');
				$email = $this->input->get_post('email');
				$ifexistuser = $this->usermodel->ifexistuser($username);
				$ifexistemail = $this->usermodel->ifexistemail($email);
				if ($ifexistuser) {
					$data['userexist'] = '此用户已存在';
					$this->load->view('user/reg', $data);
				} else {
					if ($ifexistemail) {
						$data['emailexist'] = '此邮箱已使用';
						$this->load->view('user/reg', $data);
					} else {
						$password = substr($password, 6, 16);
						$uid = $this->usermodel->reg($username, $password);
						if (!empty($uid)) {
							date_default_timezone_set('PRC');
							$now = date('Y-m-d H:i:s');
							$success = $this->usermodel->register($username, $password, $email, $uid, $now);
							if (!empty($success)) {
								$this->session->set_userdata($success);
								redirect('index', 'location');
							}
						}
					}
				}
			}
		}
	}
}
?>