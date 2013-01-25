<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Login extends CI_Controller {
	
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
			$referer = $this->input->get_request_header('Referer', true);
			switch ($referer) {
				case base_url().'login':
					break;
				default:
					$this->session->set_userdata('referer', $referer);
					break;
			}
			$this->load->library('form_validation');
			$this->load->helper('form');
			
			$this->form_validation->set_rules('po_username', '帐号', 'trim|required|alpha_numeric|min_length[4]|max_length[16]|xss_clean');
			$this->form_validation->set_rules('po_password', '密码', 'required|min_length[6]|max_length[16]|md5');
			
			if ($this->form_validation->run() == false) {
				$this->load->view('user/login', $data);
			} else {
				$username = $this->input->get_post('po_username');
				$password = $this->input->get_post('po_password');
				$password = substr($password, 6, 16);
				$logindata = $this->usermodel->getuser($username,$password);
				if (!empty($logindata['uid'])) {
					if ($logindata['read'] == 0) {
						$this->session->set_userdata($logindata);
						$referer = $this->session->userdata('referer');
						$aid = $this->session->userdata('aid');
						if (!empty($aid)) {
							$admin = array(
							'aid' => '',
							'realname' => '',
							'permission' => ''
							);
							$this->session->unset_userdata($admin);
						}
						if (empty($referer)) {
							$refer['referer'] = '';
							$this->session->unset_userdata($refer);
							redirect('i', 'location');
						} else {
							$refer['referer'] = '';
							$this->session->unset_userdata($refer);
							redirect($referer, 'location');
						}
					} else {
						$data['error'] = '您已被限制登录';
						$this->load->view('user/login', $data);
					}
				} else {
					$data['error'] = '帐号或密码错误';
					$this->load->view('user/login', $data);
				}
			}
		}
	}
}
?>