<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Adminlogin extends CI_Controller {
	
	public function __construct()
	{
        parent::__construct();
        $this->load->model('Admin_model','adminmodel');
        $this->load->helper('url');
	}
	
	function index() {
		$aid = $this->session->userdata('aid');
		if (!empty($aid)) {
			redirect('admin', 'location');
		} else {
			$this->load->library('form_validation');
			$this->load->helper('form');
			
			$this->form_validation->set_rules('username', '帐号', 'trim|required|alpha_numeric|min_length[4]|max_length[16]|xss_clean');
			$this->form_validation->set_rules('password', '密码', 'required|min_length[6]|max_length[16]|md5');
			
			if ($this->form_validation->run() == false) {
				$this->load->view('admin/login');
			} else {
				$username = $this->input->get_post('username');
				$password = $this->input->get_post('password');
				$password = substr($password, 6, 16);
				$logindata = $this->adminmodel->getuser($username,$password);
				if (!empty($logindata['aid'])) {
					$uid = $this->session->userdata('uid');
					if (!empty($uid)) {
						$userdata = array('uid'=>'', 'username'=>'', 'password'=>'', 'read'=>'');
						$this->session->unset_userdata($userdata);
					}
					$this->session->set_userdata($logindata);
					redirect('admin', 'location');
				} else {
					$data['error'] = '帐号或密码错误';
					$this->load->view('admin/login', $data);
				}
			}
		}
	}
	
}
?>