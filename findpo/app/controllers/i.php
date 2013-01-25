<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class I extends CI_Controller {
	
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
		if (!empty($uid)) {
			$data['username'] = $this->session->userdata('username');
			$data['cartcount'] = $this->usermodel->viewcart($uid);
		}
		$this->load->view('user/i', $data);
	}
	
	//右侧面板
	function portal() {
		$this->load->view('user/myportal');
	}
	
	//订单付款成功页面
	function orderpaysuccess() {
		$referer = $this->input->get_request_header('Referer', true);
		if ($referer == base_url().'i/ordertopay') {
			$uid = $this->session->userdata('uid');
			$order = $this->session->userdata('order');
			if (!empty($order)) {
				$this->buymodel->getfee($uid, $order['total'], $order['oids']);
				$this->buymodel->markpay($uid, $order['oids']);
				$this->session->unset_userdata('order');
				$this->load->view('user/orderpaysuccess');
			}
		}
	}
	
	//账户充值页面
	function charge() {
		$uid = $this->session->userdata('uid');
		$query = $this->buymodel->getbalance($uid);
		$data['balance'] = $query['balance'];
		$this->load->view('user/mycharge', $data);
	}
	
	//订单转向付款页面
	function ordertopay() {
		$uid = $this->session->userdata('uid');
		$data['order'] = $this->session->userdata('order');
		if (empty($data['order'])) {
			$data['error'] = '暂无待处理的购物车订单，浏览订单请查看我的订单';
		}
		$query = $this->buymodel->getbalance($uid);
		$data['balance'] = $query['balance'];
		$this->load->view('user/pay', $data);
	}
	
	//从购物车转向的订单页面
	function order() {
		$uid = $this->session->userdata('uid');
		$cartinfo = $this->usermodel->getcart($uid);
		if (empty($cartinfo['item_a'])) {
			if (empty($cartinfo['item_b']) && empty($cartinfo['item_c']) && empty($cartinfo['item_d']) && empty($cartinfo['item_e']) && empty($cartinfo['item_f']) && empty($cartinfo['item_g']) && empty($cartinfo['item_h']) && empty($cartinfo['item_i']) && empty($cartinfo['item_j'])) {
				$data['error'] = '暂时无订单确认';
			}
		}
		$data['cartinfo'] = $cartinfo;
		$data['address'] = $this->usermodel->view_address($uid);
		$this->load->view('user/order', $data);
	}
	
	//我的购物车
	function cart() {
		$uid = $this->session->userdata('uid');
		$cartinfo = $this->usermodel->getcart($uid);
		if (empty($cartinfo['item_a'])) {
			if (empty($cartinfo['item_b']) && empty($cartinfo['item_c']) && empty($cartinfo['item_d']) && empty($cartinfo['item_e']) && empty($cartinfo['item_f']) && empty($cartinfo['item_g']) && empty($cartinfo['item_h']) && empty($cartinfo['item_i']) && empty($cartinfo['item_j'])) {
				$data['error'] = '你的购物车空空如也，快去浏览商品吧~';
			}
		}
		$data['cartinfo'] = $cartinfo;
		$this->load->view('user/mycart', $data);
	}
	
	//我的订单
	function myorder() {
		$uid = $this->session->userdata('uid');
		$data['orders'] = $this->usermodel->getorder($uid);
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
		$this->load->view('user/myorder', $data);
	}
	
	//查看商品收藏
	function pfav() {
		$uid = $this->session->userdata('uid');
		$pfav = $this->usermodel->getpfav($uid);
		if (empty($pfav)) {
			$data['error'] = '您还未收藏任何商品哦！';
		} else {
			$pfavcount = count($pfav);
			for ($i = 0; $i < $pfavcount; $i++) {
				$favinfo[$i] = $this->itemmodel->detail($pfav[$i]['pid']);
				$favinfo[$i]['time'] = $pfav[$i]['time'];
			}
			$data['favinfo'] = $favinfo;
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
		$this->load->view('user/mypfav', $data);
	}
	
	//查看店铺收藏
	function sfav() {
		$uid = $this->session->userdata('uid');
		$sfav = $this->usermodel->getsfav($uid);
		if (empty($sfav)) {
			$data['error'] = '您还未收藏任何店铺哦！';
		} else {
			$sfavcount = count($sfav);
			for ($i = 0; $i < $sfavcount; $i++) {
				$favinfo[$i] = $this->usermodel->getsfavinfo($sfav[$i]['sid']);
				$favinfo[$i]['time'] = $sfav[$i]['time'];
				$sellerinfo = $this->usermodel->getuserinfo($favinfo[$i]['uid']);
				$favinfo[$i]['username'] = $sellerinfo['username'];
				$favinfo[$i]['nickname'] = $sellerinfo['nickname'];
			}
			$data['favinfo'] = $favinfo;
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
		$this->load->view('user/mysfav', $data);
	}
	
	//求购信息
	function mywanted() {
		$uid = $this->session->userdata('uid');
		$this->load->library('form_validation');
		$this->load->helper('form');
		$this->form_validation->set_rules('type', '信息种类', 'trim|required|less_than[2.5]|greater_than[0.5]|is_natural_no_zero');
		$this->form_validation->set_rules('name', '标题', 'trim|required|max_length[50]');
		$this->form_validation->set_rules('detail', '描述', 'trim|required|max_length[300]');
		$this->form_validation->set_rules('price', '价格', 'trim|required|numeric|max_length[8]');
		$this->form_validation->set_rules('amount', '数量', 'trim|required|is_natural|max_length[5]');
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
		if ($this->form_validation->run() == false) {
			$data['wanted'] = $this->usermodel->getuserwanted($uid);
			$this->load->view('user/mywanted', $data);
		} else {
			$type = $this->input->get_post('type');
			$name = $this->input->get_post('name');
			$detail = $this->input->get_post('detail');
			$price = $this->input->get_post('price');
			$amount = $this->input->get_post('amount');
			$query = $this->usermodel->insertwanted($uid, $type, $name, $detail, $price, $amount);
			if ($query == true) {
				$data['error'] = '发布求购信息成功';
				$data['wanted'] = $this->usermodel->getuserwanted($uid);
				$this->load->view('user/mywanted', $data);
			}
		}
	}
	
	//交易明细
	function trade() {
		$uid = $this->session->userdata('uid');
		$data['trades'] = $this->usermodel->gettrade($uid);
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
		$this->load->view('user/mytrade', $data);
	}
	
	//评价已购商品
	function feel() {
		$uid = $this->session->userdata('uid');
		$this->load->library('form_validation');
		$this->load->helper('form');
		$this->load->helper('html');
		$oid = $this->input->get_post('oid');
		$this->form_validation->set_rules('oid', '订单信息', 'trim|required|is_natural_no_zero');
		$this->form_validation->set_rules('shopfeel', '商店评价', 'trim|required|is_natural_no_zero|less_than[3.5]');
		$this->form_validation->set_rules('profeel', '商品评价', 'trim|required|is_natural_no_zero|less_than[3.5]');
		$this->form_validation->set_rules('comment', '评价内容', 'trim|max_length[300]');
		if ($this->form_validation->run() == false) {
			$data['oid'] = $oid;
			$this->load->view('user/feel', $data);
		} else {
			$oid = $this->input->get_post('oid');
			$check = $this->buymodel->getbuyuid($oid);
			$checkiffeel = $this->buymodel->checkiffeel($oid);
			if ($uid == $check['buyuid'] && $checkiffeel == true) {
				$shopfeel = $this->input->get_post('shopfeel');
				$profeel = $this->input->get_post('profeel');
				$comment = $this->input->get_post('comment');
				$query = $this->buymodel->buyfeel($uid, $oid, $shopfeel, $profeel, $comment);
				if ($query == true) {
					redirect('i/myorder', 'location');
				}
			}
		}
	}
	
	//收货地址
	function address() {
		$uid = $this->session->userdata('uid');
		$this->load->library('form_validation');
		$this->load->helper('form');
		$this->form_validation->set_rules('consignee', '收货人', 'trim|required|max_length[50]');
		$this->form_validation->set_rules('college', '学校', 'trim|required|max_length[50]');
		$this->form_validation->set_rules('address', '详细地址', 'trim|required|max_length[100]');
		$this->form_validation->set_rules('zipcode', '邮编', 'trim|is_natural|exact_length[6]');
		$this->form_validation->set_rules('phone', '手机或电话', 'trim|required|max_length[50]');
		if ($this->form_validation->run() == false) {
			$data['address'] = $this->usermodel->view_address($uid);
			$data['setting'] = $this->usermodel->import_setting();
			$this->load->view('user/myaddr', $data);
		} else {
			$ifwritten = $this->usermodel->view_address($uid);
			if (empty($ifwritten['consignee_one'])) {
				$consignee = $this->input->get_post('consignee');
				$college = $this->input->get_post('college');
				$address = $this->input->get_post('address');
				$zipcode = $this->input->get_post('zipcode');
				if (empty($zipcode)) {
					$zipcode = null;
				}
				$phone = $this->input->get_post('phone');
				$act = $this->usermodel->add_address_one($uid, $consignee, $college, $address, $zipcode, $phone);
				if ($act == true) {
					$data['address'] = $this->usermodel->view_address($uid);
					$data['setting'] = $this->usermodel->import_setting();
					$data['error'] = '添加收货地址成功';
					$this->load->view('user/myaddr', $data);
				}
			}
			elseif (empty($ifwritten['consignee_two'])) {
				$consignee = $this->input->get_post('consignee');
				$college = $this->input->get_post('college');
				$address = $this->input->get_post('address');
				$zipcode = $this->input->get_post('zipcode');
				if (empty($zipcode)) {
					$zipcode = null;
				}
				$phone = $this->input->get_post('phone');
				$act = $this->usermodel->add_address_two($uid, $consignee, $college, $address, $zipcode, $phone);
				if ($act == true) {
					$data['address'] = $this->usermodel->view_address($uid);
					$data['setting'] = $this->usermodel->import_setting();
					$data['error'] = '添加收货地址成功';
					$this->load->view('user/myaddr', $data);
				}
			}
			elseif (empty($ifwritten['consignee_three'])) {
				$consignee = $this->input->get_post('consignee');
				$college = $this->input->get_post('college');
				$address = $this->input->get_post('address');
				$zipcode = $this->input->get_post('zipcode');
				if (empty($zipcode)) {
					$zipcode = null;
				}
				$phone = $this->input->get_post('phone');
				$act = $this->usermodel->add_address_three($uid, $consignee, $college, $address, $zipcode, $phone);
				if ($act == true) {
					$data['address'] = $this->usermodel->view_address($uid);
					$data['setting'] = $this->usermodel->import_setting();
					$data['error'] = '添加收货地址成功';
					$this->load->view('user/myaddr', $data);
				}
			}
			else {
				$data['address'] = $this->usermodel->view_address($uid);
				$data['setting'] = $this->usermodel->import_setting();
				$data['error'] = '收货地址暂时只能填写3个';
				$this->load->view('user/myaddr', $data);
			}
		}
	}
	
	//修改密码
	function password() {
		$this->load->library('form_validation');
		$this->load->helper('form');
		
		$this->form_validation->set_rules('po_password', '初始密码', 'required|min_length[6]|max_length[16]|md5');
		$this->form_validation->set_rules('newpassword', '新密码', 'required|matches[conpassword]|min_length[6]|max_length[16]|md5');
		$this->form_validation->set_rules('conpassword', '确认新密码', 'required');
		if ($this->form_validation->run() == false){
			$this->load->view('user/mypass');
			} else {
				$inputpassword = $this->input->get_post('po_password');
				$newpassword = $this->input->get_post('newpassword');
				$inputpassword = substr($inputpassword, 6, 16);
				$newpassword = substr($newpassword, 6, 16);
				$password = $this->session->userdata('password');
				if ($password != $inputpassword) {
					$data['error'] = '帐号密码错误';
					$this->load->view('user/mypass', $data);
				} else {
					if ($password == $newpassword) {
						$data['error'] = '密码未改变，请重新输入';
						$this->load->view('user/mypass', $data);
					} else {
						$uid = $this->session->userdata('uid');
						$pass = $this->usermodel->password($uid, $newpassword);
						if ($pass == true) {
							$this->session->set_userdata('password', $newpassword);
							$data['error'] = '密码修改成功';
							$this->load->view('user/mypass', $data);
						}
					}
				}
			}
	}
	
	//修改虚拟账户密码
	function accpass() {
		$this->load->library('form_validation');
		$this->load->helper('form');
		
		$this->form_validation->set_rules('po_password', '初始密码', 'required|min_length[6]|max_length[16]|md5');
		$this->form_validation->set_rules('newpassword', '新密码', 'required|matches[conpassword]|min_length[6]|max_length[16]|md5');
		$this->form_validation->set_rules('conpassword', '确认新密码', 'required');
		if ($this->form_validation->run() == false){
			$this->load->view('user/myaccpass');
			} else {
				$inputpassword = $this->input->get_post('po_password');
				$newpassword = $this->input->get_post('newpassword');
				$inputpassword = substr($inputpassword, 6, 16);
				$newpassword = substr($newpassword, 6, 16);
				$uid = $this->session->userdata('uid');
				$password = $this->usermodel->getaccpass($uid);
				if ($password != $inputpassword) {
					$data['error'] = '虚拟账户密码错误';
					$this->load->view('user/myaccpass', $data);
				} else {
					if ($password == $newpassword) {
						$data['error'] = '密码未改变，请重新输入';
						$this->load->view('user/myaccpass', $data);
					} else {
						$pass = $this->usermodel->accpass($uid, $newpassword);
						if ($pass == true) {
							$data['error'] = '密码修改成功';
							$this->load->view('user/myaccpass', $data);
						}
					}
				}
			}
	}
	
	//登出
	function logout() {
		$logindata = array('uid'=>'', 'username'=>'', 'password'=>'', 'read'=>'');
		$this->session->unset_userdata($logindata);
		redirect('index','location');
	}
}
?>