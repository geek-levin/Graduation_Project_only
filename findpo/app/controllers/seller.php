<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Seller extends CI_Controller {
	
	public function __construct()
	{
        parent::__construct();
        $this->load->model('User_model','usermodel');
        $this->load->model('Item_model','itemmodel');
        $this->load->model('Buy_model','buymodel');
        $this->load->helper('url');
        $uid = $this->session->userdata('uid');
        $read = $this->session->userdata('read');
		if (empty($uid)) {
			redirect('login','location');
		} elseif ($read != 0) {
			$logindata = array('uid'=>'', 'username'=>'', 'password'=>'', 'read'=>'');
			$this->session->unset_userdata($logindata);
			redirect('login','location');
		}
	}
	
	function index() {
		$data['app'] = $this->input->get('app');
		$data['setting'] = $this->usermodel->import_setting();
		$uid = $this->session->userdata('uid');
		$data['cookie'] = $this->session->all_userdata();
		$data['username'] = $this->session->userdata('username');
		$data['cartcount'] = $this->usermodel->viewcart($uid);
		$data['shopinfo'] = $this->itemmodel->getshopinfo($uid);
		$data['userinfo'] = $this->usermodel->getuserinfo($uid);
		$data['realinfo'] = $this->usermodel->getuserreal($uid);
		$this->load->view('seller/i', $data);
	}
	
	//右侧面板
	function portal() {
		$this->load->view('seller/myportal');
	}
	
	//我要开店
	function openshop() {
		$uid = $this->session->userdata('uid');
		$userinfo = $this->usermodel->getusertype($uid);
		if ($userinfo['usertype'] == 2 or $userinfo['usertype'] == 3) {
		} else {
			if (empty($userinfo['idimage'])) {
				redirect('seller/uploadidpre', 'location');
			} else {
				if ($userinfo['usertype'] == 0) {
					$this->load->library('form_validation');
					$this->load->helper('form');
					$this->form_validation->set_rules('name', '真实姓名', 'trim|required|max_length[30]');
					$this->form_validation->set_rules('college', '学校', 'trim|required|max_length[50]');
					$this->form_validation->set_rules('idnumber', '身份证号码', 'trim|required|min_length[15]|max_length[18]');
					$this->form_validation->set_rules('shop', '商店名称', 'trim|required|max_length[50]');
					if ($this->form_validation->run() == false) {
						$data['setting'] = $this->usermodel->import_setting();
						$this->load->view('seller/openshop', $data);
					} else {
						$name = $this->input->get_post('name');
						$college = $this->input->get_post('college');
						$idnumber = $this->input->get_post('idnumber');
						$shop = $this->input->get_post('shop');
						$this->usermodel->updateshop($uid, $name, $college, $idnumber, $shop);
						$data['message'] = '您的信息已经提交审核，请耐心等待';
						$this->load->view('seller/openshop', $data);
					}
				} elseif ($userinfo['usertype'] == 4) {
					$data['message'] = '您的信息已经提交审核，请耐心等待';
					$this->load->view('seller/openshop', $data);
				} elseif ($userinfo['usertype'] == 2 or $userinfo['usertype'] == 3) {
					$data['message'] = '恭喜，认证成功';
					$this->load->view('seller/openshop', $data);
				} elseif ($userinfo['usertype'] == 5) {
					$data['message'] = '认证失败';
					$this->load->view('seller/openshop', $data);
				}
			}
		}
	}
	
	//上传身份证表单页面
	function uploadidpre() {
		$uid = $this->session->userdata('uid');
		$userinfo = $this->usermodel->getusertype($uid);
		if (empty($userinfo['idimage'])) {
			$this->load->helper(array('form', 'file'));
			$this->load->view('seller/uploadid');
		}
	}
	
	//上传身份证处理
	function uploadid() {
		$uid = $this->session->userdata('uid');
		$userinfo = $this->usermodel->getusertype($uid);
		if (!empty($userinfo['idimage'])) {
			return;
		}
		$this->load->helper(array('form', 'file'));
		
		$config['upload_path'] = './images/user/idcardview';
		$config['allowed_types'] = 'gif|jpg|png';
		$config['max_size'] = '1536';
		$config['max_width']  = '1280';
		$config['max_height']  = '800';
		$config['overwrite']  = FALSE;
		$config['encrypt_name']  = TRUE;
		$this->load->library('upload', $config);
		
		if (!$this->upload->do_upload()) {
			$data['error'] = $this->upload->display_errors();
			$this->load->view('seller/uploadid', $data);
		} else {
			$upload_data = $this->upload->data();
			$idimage = $upload_data['file_name'];
			$this->usermodel->uploadid($uid, $idimage);
			redirect('seller/openshop', 'location');
		}
	}
	
	//店铺信息管理
	function shopinfo() {
		$uid = $this->session->userdata('uid');
		$userinfo = $this->usermodel->getusertype($uid);
		if ($userinfo['usertype'] == 2 or $userinfo['usertype'] == 3) {
			$this->load->library('form_validation');
			$this->load->helper('form');
			$this->form_validation->set_rules('shop', '商店名称', 'trim|required|max_length[50]');
			$this->form_validation->set_rules('introduce', '商店介绍', 'trim|max_length[500]');
			$this->form_validation->set_rules('notice', '商店公告', 'trim|max_length[150]');
			if ($this->form_validation->run() == false) {
				$data['shopinfo'] = $this->itemmodel->getshopinfo($uid);
				$this->load->view('seller/shopinfo', $data);
			} else {
				$shop = $this->input->get_post('shop');
				$introduce = $this->input->get_post('introduce');
				$notice = $this->input->get_post('notice');
				$query = $this->usermodel->updateshopinfo($uid, $shop, $introduce, $notice);
				if ($query == true) {
					$data['error'] = '修改成功';
					$data['shopinfo'] = $this->itemmodel->getshopinfo($uid);
					$this->load->view('seller/shopinfo', $data);
				}
			}
		}
	}
	
	//卖家真实信息
	function real() {
		$uid = $this->session->userdata('uid');
		$data['real'] = $this->usermodel->getuserreal($uid);
		$this->load->view('seller/real', $data);
	}
	
	//发布商品
	function release() {
		$this->load->library('form_validation');
		$this->load->helper('form');
		$this->load->helper('html');
		
		$this->form_validation->set_rules('catid_one', '商品分类', 'trim|required|max_length[3]');
		$this->form_validation->set_rules('catid_two', '商品分类', 'trim|max_length[3]');
		$this->form_validation->set_rules('catid_three', '商品分类', 'trim|max_length[3]');
		$this->form_validation->set_rules('title', '商品标题', 'trim|required|max_length[50]');
		$this->form_validation->set_rules('mprice', '市场价', 'trim|numeric|max_length[8]');
		$this->form_validation->set_rules('price', '价格', 'trim|required|numeric|max_length[8]');
		$this->form_validation->set_rules('new_old', '新旧程度', 'trim|required|is_natural|max_length[2]|min_length[1]');
		$this->form_validation->set_rules('detail', '商品描述', 'trim|required|max_length[2000]|min_length[10]');
		$this->form_validation->set_rules('amount', '商品数量', 'trim|required|is_natural_no_zero|max_length[8]');
		$this->form_validation->set_rules('visible', '是否暂存', 'trim|greater_than[0]|less_than[2]|is_natural');
		$this->form_validation->set_rules('cost', '运费', 'trim|numeric|max_length[3]');
		$this->form_validation->set_rules('ex_range', '交易范围', 'trim|required|max_length[50]');
		$this->form_validation->set_rules('wot', '交易方式', 'trim|required|less_than[5]|greater_than[0]|is_natural_no_zero');
		
		if ($this->form_validation->run() == false) {
			$data['cat_one'] = $this->itemmodel->getcatp();
			$data['setting'] = $this->usermodel->import_setting();
			$this->load->view('seller/release', $data);
		} else {
			$catid_one = $this->input->get_post('catid_one');
			$catid_two = $this->input->get_post('catid_two');
			$catid_three = $this->input->get_post('catid_three');
			$title = $this->input->get_post('title');
			$mprice = $this->input->get_post('mprice');
			$price = $this->input->get_post('price');
			$new_old = $this->input->get_post('new_old');
			$detail = $this->input->get_post('detail');
			$amount = $this->input->get_post('amount');
			$visible = $this->input->get_post('visible');
			$cost = $this->input->get_post('cost');
			$ex_range = $this->input->get_post('ex_range');
			$wot = $this->input->get_post('wot');
			$this->load->helper('cookie');
			$try = array(
			'name' => 'catid_one',
			'value' => $catid_one,
			'expire' => 7200
			);
			$this->input->set_cookie($try);
			unset($try);
			$try = array(
			'name' => 'catid_two',
			'value' => $catid_two,
			'expire' => 7200
			);
			$this->input->set_cookie($try);
			unset($try);
			$try = array(
			'name' => 'catid_three',
			'value' => $catid_three,
			'expire' => 7200
			);
			$this->input->set_cookie($try);
			unset($try);
			$try = array(
			'name' => 'title',
			'value' => $title,
			'expire' => 7200
			);
			$this->input->set_cookie($try);
			unset($try);
			$try = array(
			'name' => 'mprice',
			'value' => $mprice,
			'expire' => 7200
			);
			$this->input->set_cookie($try);
			unset($try);
			$try = array(
			'name' => 'price',
			'value' => $price,
			'expire' => 7200
			);
			$this->input->set_cookie($try);
			unset($try);
			$try = array(
			'name' => 'new_old',
			'value' => $new_old,
			'expire' => 7200
			);
			$this->input->set_cookie($try);
			unset($try);
			$try = array(
			'name' => 'detail',
			'value' => $detail,
			'expire' => 7200
			);
			$this->input->set_cookie($try);
			unset($try);
			$try = array(
			'name' => 'amount',
			'value' => $amount,
			'expire' => 7200
			);
			$this->input->set_cookie($try);
			unset($try);
			$try = array(
			'name' => 'visible',
			'value' => $visible,
			'expire' => 7200
			);
			$this->input->set_cookie($try);
			unset($try);
			$try = array(
			'name' => 'cost',
			'value' => $cost,
			'expire' => 7200
			);
			$this->input->set_cookie($try);
			unset($try);
			$try = array(
			'name' => 'ex_range',
			'value' => $ex_range,
			'expire' => 7200
			);
			$this->input->set_cookie($try);
			unset($try);
			$try = array(
			'name' => 'wot',
			'value' => $wot,
			'expire' => 7200
			);
			$this->input->set_cookie($try);
			unset($try);
			redirect('seller/uploadimg', 'location');
		}
	}
	
	//上传商品图片页面
	function uploadimgpre() {
		$this->load->helper('cookie');
		$check = get_cookie('title');
		if (!empty($check) and $check != 0) {
			$this->load->helper(array('form', 'file'));
			$this->load->view('seller/uploadimg');
		} else {
			return false;
		}
	}
	
	//上传商品图片
	function uploadimg() {
		$this->load->helper(array('form', 'file'));
		$config['upload_path'] = './images/user/proview';
		$config['allowed_types'] = 'gif|jpg|png';
		$config['max_size'] = '1536';
		$config['max_width']  = '1280';
		$config['max_height']  = '800';
		$config['overwrite']  = FALSE;
		$config['encrypt_name']  = TRUE;
		$this->load->library('upload', $config);
		$image_one = $this->session->userdata('image_one');
		$image_two = $this->session->userdata('image_two');
		$image_three = $this->session->userdata('image_three');
		$image_four = $this->session->userdata('image_four');
		$image_five = $this->session->userdata('image_five');
		$n = 0;
		if (!empty($image_one)) {
			$n++;
		}
		if (!empty($image_two)) {
			$n++;
		}
		if (!empty($image_three)) {
			$n++;
		}
		if (!empty($image_four)) {
			$n++;
		}
		if (!empty($image_five)) {
			$n++;
		}
		if ($n < 5) {
			if (!$this->upload->do_upload()) {
				$data['error'] = $this->upload->display_errors();
				$data['image_one'] = $this->session->userdata('image_one');
				$data['image_two'] = $this->session->userdata('image_two');
				$data['image_three'] = $this->session->userdata('image_three');
				$data['image_four'] = $this->session->userdata('image_four');
				$data['image_five'] = $this->session->userdata('image_five');
				$this->load->view('seller/uploadimg', $data);
			} else {
				$upload_data = $this->upload->data();
				$image = $upload_data['file_name'];
				$image_one = $this->session->userdata('image_one');
				$image_two = $this->session->userdata('image_two');
				$image_three = $this->session->userdata('image_three');
				$image_four = $this->session->userdata('image_four');
				$image_five = $this->session->userdata('image_five');
				if (empty($image_one)) {
					$this->session->set_userdata('image_one', $image);
					$data['image_one'] = $image;
					$data['image_two'] = $image_two;
					$data['image_three'] = $image_three;
					$data['image_four'] = $image_four;
					$data['image_five'] = $image_five;
					$this->load->view('seller/uploadimg', $data);
				} elseif (empty($image_two)) {
					$this->session->set_userdata('image_two', $image);
					$data['image_two'] = $image;
					$data['image_one'] = $image_one;
					$data['image_three'] = $image_three;
					$data['image_four'] = $image_four;
					$data['image_five'] = $image_five;
					$this->load->view('seller/uploadimg', $data);
				} elseif (empty($image_three)) {
					$this->session->set_userdata('image_three', $image);
					$data['image_three'] = $image;
					$data['image_one'] = $image_one;
					$data['image_two'] = $image_two;
					$data['image_four'] = $image_four;
					$data['image_five'] = $image_five;
					$this->load->view('seller/uploadimg', $data);
				} elseif (empty($image_four)) {
					$this->session->set_userdata('image_four', $image);
					$data['image_four'] = $image;
					$data['image_one'] = $image_one;
					$data['image_two'] = $image_two;
					$data['image_three'] = $image_three;
					$data['image_five'] = $image_five;
					$this->load->view('seller/uploadimg', $data);
				} elseif (empty($image_five)) {
					$this->session->set_userdata('image_five', $image);
					$data['image_five'] = $image;
					$data['image_one'] = $image_one;
					$data['image_two'] = $image_two;
					$data['image_three'] = $image_three;
					$data['image_four'] = $image_four;
					$this->load->view('seller/uploadimg', $data);
				} else {
					$data['error'] = '最多上传5张图片';
					$data['image_one'] = $image_one;
					$data['image_two'] = $image_two;
					$data['image_three'] = $image_three;
					$data['image_four'] = $image_four;
					$data['image_five'] = $image_five;
					$this->load->view('seller/uploadimg', $data);
				}
			}
		} else {
			$data['error'] = '最多上传5张图片';
			$data['image_one'] = $image_one;
			$data['image_two'] = $image_two;
			$data['image_three'] = $image_three;
			$data['image_four'] = $image_four;
			$data['image_five'] = $image_five;
			$this->load->view('seller/uploadimg', $data);
		}
	}
	
	//卖家我的商品模块
	function product() {
		$uid = $this->session->userdata('uid');
		$data['proinfos'] = $this->itemmodel->getsellerpro($uid);
		if (empty($data['proinfos'])) {
			$data['error'] = '你还没有商品哦，快去发布吧~';
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
		$this->load->view('seller/mypro', $data);
	}
	
	//卖家管理订单模块
	function order() {
		$uid = $this->session->userdata('uid');
		$data['orders'] = $this->itemmodel->getsellerorder($uid);
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
		$this->load->view('seller/myorder', $data);
	}
	
	//卖家评价订单
	function feel() {
		$uid = $this->session->userdata('uid');
		$this->load->library('form_validation');
		$this->load->helper('form');
		$this->load->helper('html');
		$oid = $this->input->get_post('oid');
		$this->form_validation->set_rules('oid', '订单信息', 'trim|required|is_natural_no_zero');
		$this->form_validation->set_rules('feel', '评价', 'trim|required|is_natural_no_zero|less_than[3.5]');
		if ($this->form_validation->run() == false) {
			$data['oid'] = $oid;
			$this->load->view('seller/feel', $data);
		} else {
			$oid = $this->input->get_post('oid');
			$check = $this->buymodel->getsaleuid($oid);
			$checkifmark = $this->buymodel->checkifmark($oid);
			if ($uid == $check['saleuid'] && $checkifmark == true) {
				$feel = $this->input->get_post('feel');
				$query = $this->buymodel->sellfeel($uid, $oid, $feel);
				if ($query == true) {
					redirect('seller/order', 'location');
				}
			}
		}
	}
	
}
?>