<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Shop extends CI_Controller {
	
	public function __construct()
	{
        parent::__construct();
        $this->load->model('Item_model','itemmodel');
        $this->load->model('User_model','usermodel');
        $this->load->helper('url');
	}
	
	function index() {
		$sid = $this->input->get('sid');
		if (preg_match('/^[0-9]+$/', $sid)) {
			$shopinfo = $this->itemmodel->getshopinfo($sid);
			if (!empty($shopinfo)) {
				if ($shopinfo['read'] != 0) {
					show_404();
				} else {
					print_r($shopinfo);
				}
			} else {
				show_404();
			}
		} else {
			show_404();
		}
	}
	
}
?>