<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Search extends CI_Controller {
	
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
		$word = $this->input->get('word');
		$search = trim($word);
		$reg = array(
		'/\s+/',
		'/~?!?@?#?\$?%?\^?&?\*?\(?\)?-?=?_?\+?/',
		'/\[?\]?{?}?\|?\\?;?:?"?\.?<?>?\/?\??/',
		'/,?\'?/',
		'/`/'
		);
		$replace = array(
		' ',
		'',
		'',
		'',
		''
		);
		$search = preg_replace($reg, $replace, $search);
		$data['word'] = $word;
		if (empty($search)) {
			$data['error'] = '你的搜索词<b>'.$word.'</b>无效，请重新输入';
			$this->load->view('user/search', $data);
		} else {
			if (preg_match('/\s{1}/', $search)) {
				$searcharr = explode(' ', $search);
				$data['proinfos'] = $this->itemmodel->search($searcharr);
				$this->load->view('user/search', $data);
			} else {
				$searcharr = array();
				$searcharr[0] = $search;
				$data['proinfos'] = $this->itemmodel->search($searcharr);
				$this->load->view('user/search', $data);
			}
		}
	}
	
}
?>