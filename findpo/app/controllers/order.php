<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Order extends CI_Controller {
	
	public function __construct()
	{
        parent::__construct();
        $this->load->model('Item_model','itemmodel');
        $this->load->model('User_model','usermodel');
        $this->load->helper('url');
	}
	
	function index() {
		$oid = $this->input->get('oid');
		if (preg_match('/^[0-9]+$/', $oid)) {
			$query = $this->usermodel->getoneorder($oid);
			if (!empty($query)) {
				$data['order'] = $query;
				$this->load->view('user/vieworder', $data);
			} else {
				show_404();
			}
		} else {
			show_404();
		}
	}
	
}
?>