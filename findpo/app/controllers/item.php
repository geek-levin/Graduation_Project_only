<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Item extends CI_Controller {
	
	public function __construct()
	{
        parent::__construct();
        $this->load->model('Item_model','itemmodel');
        $this->load->model('User_model','usermodel');
        $this->load->helper('url');
	}
	
	//商品详情
	function index() {
		$uid = $this->session->userdata('uid');
		$pid = $this->input->get('pid');
		if (preg_match('/^[0-9]+$/', $pid)) {
			$detail = $this->itemmodel->detail($pid);
			if (!empty($detail)) {
				$sellerinfo = $this->itemmodel->getsellerinfo($detail['uid']);
				$shopinfo = $this->itemmodel->getshopinfo($detail['uid']);
				if ($detail['read'] != '0' or $sellerinfo['read'] != '0' or $shopinfo['read'] != '0') {
					show_404();
				} else {
					if ($detail['visible'] != '0' && $uid != $detail['uid']) {
						show_404();
					} elseif ($detail['visible'] != '0' && $uid == $detail['uid']) {
						$data['detail'] = $detail;
						$data['setting'] = $this->usermodel->import_setting();
						$uid = $this->session->userdata('uid');
						if (!empty($uid)) {
							$data['username'] = $this->session->userdata('username');
							$data['cartcount'] = $this->usermodel->viewcart($uid);
						}
						$data['sellerinfo'] = $sellerinfo;
						$data['catinfo'] = $this->itemmodel->getcatinfo($detail['catid']);
						$data['comment'] = $this->itemmodel->getcomment($detail['pid']);
						$data['shopinfo'] = $shopinfo;
						$data['favcount'] = $this->itemmodel->getfav($detail['pid']);
						$data['orderinfo'] = $this->itemmodel->getorder($detail['pid']);
						$this->itemmodel->addviews($pid);
						$this->load->view('item/detail', $data);
					} elseif ($detail['visible'] == '0') {
						$data['detail'] = $detail;
						$data['setting'] = $this->usermodel->import_setting();
						$uid = $this->session->userdata('uid');
						if (!empty($uid)) {
							$data['username'] = $this->session->userdata('username');
							$data['cartcount'] = $this->usermodel->viewcart($uid);
						}
						$data['sellerinfo'] = $sellerinfo;
						$data['catinfo'] = $this->itemmodel->getcatinfo($detail['catid']);
						$data['comment'] = $this->itemmodel->getcomment($detail['pid']);
						$data['shopinfo'] = $shopinfo;
						$data['favcount'] = $this->itemmodel->getfav($detail['pid']);
						$data['orderinfo'] = $this->itemmodel->getorder($detail['pid']);
						$this->itemmodel->addviews($pid);
						$this->load->view('item/detail', $data);
					}
				}
			} else {
				show_404();
			}
		} else {
			show_404();
		}
	}
	
	//分类页面
	function cat() {
		$catid = $this->input->get('cid');
		if (preg_match('/^[0-9]*$/', $catid)) {
			echo $catid;exit;
		} else {
			show_404();
		}
	}
	
}
?>