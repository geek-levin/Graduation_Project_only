<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Ajax extends CI_Controller {
	
	public function __construct()
	{
        parent::__construct();
        $this->load->helper('url');
	}
	
	function index() {
		$this->load->view('user/userexist');
	}
	
	//用户名是否被注册
	function getusername() {
		$this->load->model('User_model','usermodel');
		$this->load->library('form_validation');
		$this->form_validation->set_rules('username', '帐号', 'trim|required|alpha_numeric|min_length[4]|max_length[16]|xss_clean');
		if ($this->form_validation->run() == true) {
			$query = $this->usermodel->getusername($this->input->post('username'));
			if($query) {
				$output = "该用户名已被注册";
			} else {
				$output = "该用户名可用";
			}
			$this->output->append_output($output);
		}
	}
	
	//删除收货地址
	function deleteaddr() {
		$uid = $this->session->userdata('uid');
        $read = $this->session->userdata('read');
		if (empty($uid) or $read != 0) {
			return false;
		}
		$this->load->model('User_model','usermodel');
		$deleteaddr = $this->input->post('deleteaddr');
		$delete = $this->usermodel->deleteaddr($uid, $deleteaddr);
		if ($delete) {
			$output = $deleteaddr;
		} else {
			$output = 0;
		}
		$this->output->append_output($output);
	}
	
	//收藏商品或店铺
	function insertfav() {
		$uid = $this->session->userdata('uid');
		$read = $this->session->userdata('read');
		if (empty($uid) or $read != 0) {
			$this->output->append_output('请先登录');
			return false;
		}
		$pid = $this->input->get('pid');
		$sid = $this->input->get('sid');
		if (preg_match('/^[0-9]+$/', $pid)) {
			$this->load->model('Item_model','itemmodel');
			$insertfav = $this->itemmodel->insertfav($uid, $pid);
			if ($insertfav == 1) {
				$output = '添加收藏成功';
			} elseif ($insertfav == 2) {
				$output = '此商品已加入收藏夹';
			} else {
				$output = '添加收藏失败，请重试';
			}
			$this->output->append_output($output);
		} elseif (preg_match('/^s{1}[0-9]+$/', $sid)) {
			$this->load->model('Item_model','itemmodel');
			$insertfav = $this->itemmodel->insertfav($uid, $sid);
			if ($insertfav == 1) {
				$output = '添加收藏成功';
			} elseif ($insertfav == 2) {
				$output = '此店铺已加入收藏夹';
			} else {
				$output = '添加收藏失败，请重试';
			}
			$this->output->append_output($output);
		} else {
			return false;
		}
	}
	
	//删除商品收藏
	function deletepfav() {
		$uid = $this->session->userdata('uid');
        $read = $this->session->userdata('read');
		if (empty($uid) or $read != 0) {
			return false;
		}
		$deletepfav = $this->input->post('deletepfav');
		if (preg_match('/^[0-9]+$/', $deletepfav)) {
			$this->load->model('User_model','usermodel');
			$query = $this->usermodel->deletepfav($deletepfav, $uid);
			if ($query) {
				$this->output->append_output(1);
			} else {
				return false;
			}
		} else {
			return false;
		}
	}
	
	//删除商店收藏
	function deletesfav() {
		$uid = $this->session->userdata('uid');
        $read = $this->session->userdata('read');
		if (empty($uid) or $read != 0) {
			return false;
		}
		$deletesfav = $this->input->post('deletesfav');
		if (preg_match('/^[0-9]+$/', $deletesfav)) {
			$this->load->model('User_model','usermodel');
			$query = $this->usermodel->deletesfav($deletesfav, $uid);
			if ($query) {
				$this->output->append_output(1);
			} else {
				return false;
			}
		} else {
			return false;
		}
	}
	
	//检查用户是否登录
	function checklogin() {
		$uid = $this->session->userdata('uid');
        $read = $this->session->userdata('read');
		if (!empty($uid) and $read == 0) {
			$this->output->append_output(1);
		} else {
			$this->output->append_output('请先登录');
		}
	}
	
	//直接购买跳转购物车
	function gotobuy() {
		$uid = $this->session->userdata('uid');
		$read = $this->session->userdata('read');
		if (!empty($uid) and $read == 0) {
			$pid = $this->input->post('pid');
			$pcount = $this->input->post('pcount');
			$pmax = $this->input->post('pmax');
			if (preg_match('/^[0-9]+$/', $pid) and preg_match('/^[0-9]+$/', $pcount) and $pcount <= $pmax and $pcount >= 1) {
				$this->load->model('User_model','usermodel');
				$query = $this->usermodel->insertcart($uid, $pid, $pcount);
				if ($query == 1) {
					$this->output->append_output(1);
				} elseif ($query == 2) {
					$this->output->append_output(1);
				} elseif ($query == 3) {
					$this->output->append_output(1);
				} elseif ($query == 4) {
					$this->output->append_output('该商品正在被编辑，请稍后再试');
				} elseif ($query == 5) {
					$this->output->append_output('抱歉，该商品已下架');
				}
			} elseif (preg_match('/^[0-9]+$/', $pcount) and $pcount > $pmax) {
				$this->output->append_output('超过商品库存，请更改数量后重试');
			} else {
				$this->output->append_output('请正确输入');
			}
		} else {
			return false;
		}
	}
	
	//加入购物车
	function insertcart() {
		$uid = $this->session->userdata('uid');
		$read = $this->session->userdata('read');
		if (!empty($uid) and $read == 0) {
			$pid = $this->input->post('pid');
			$pcount = $this->input->post('pcount');
			$pmax = $this->input->post('pmax');
			if (preg_match('/^[0-9]+$/', $pid) and preg_match('/^[0-9]+$/', $pcount) and $pcount <= $pmax and $pcount >= 1) {
				$this->load->model('User_model','usermodel');
				$query = $this->usermodel->insertcart($uid, $pid, $pcount);
				if ($query == 1) {
					$this->output->append_output('很抱歉，您的购物车已满');
				} elseif ($query == 2) {
					$this->output->append_output('此商品已被加入购物车');
				} elseif ($query == 3) {
					$this->output->append_output('添加成功');
				} elseif ($query == 4) {
					$this->output->append_output('该商品正在被编辑，请稍后再试');
				} elseif ($query == 5) {
					$this->output->append_output('抱歉，该商品已下架');
				}
			} elseif (preg_match('/^[0-9]+$/', $pcount) and $pcount > $pmax) {
				$this->output->append_output('超过商品库存，请更改数量后重试');
			} else {
				$this->output->append_output('请正确输入');
			}
		} else {
			return false;
		}
	}
	
	//购物车获取商品信息
	function getpinfo() {
		$pid = $this->input->get('pid');
		if (preg_match('/^[0-9]+$/', $pid)) {
			$this->load->model('Item_model','itemmodel');
			$pinfo = $this->itemmodel->getpinfo($pid);
			$output = json_encode($pinfo);
		}
		$this->output->append_output($output);
	}
	
	//删除购物车商品
	function deletecart() {
		$uid = $this->session->userdata('uid');
        $read = $this->session->userdata('read');
		if (!empty($uid) and $read == 0) {
			$pid = $this->input->post('deletecart');
			if (preg_match('/^[0-9]+$/', $pid)) {
				$this->load->model('User_model', 'usermodel');
				$query = $this->usermodel->deletecart($uid, $pid);
				if ($query) {
					$this->output->append_output(1);
				}
			}
		} else {
			return false;
		}
	}
	
	//购物车转向订单前确认信息
	function gotoorder() {
		$uid = $this->session->userdata('uid');
		$read = $this->session->userdata('read');
		if (!empty($uid) and $read == 0) {
			$cart = $this->input->post('cart');
			if (!empty($cart)) {
				if (preg_match('/\*{1}/', $cart)) {
					$cartinfos = explode('*', $cart);
					$this->load->model('Buy_model', 'buymodel');
					$check = 0;
					$cartcount = count($cartinfos);
					for ($i = 0; $i < $cartcount; $i++) {
						$cartinfo = explode('t', $cartinfos[$i]);
						$pid = $cartinfo[0];
						$amount = $cartinfo[1];
						if (preg_match('/^[0-9]+$/', $pid) && preg_match('/^[0-9]+$/', $amount) && $amount >= 1) {
							$query = $this->buymodel->getproinfo($uid, $pid, $amount);
							$check += $query;
						}
					}
					if ($check == $cartcount*4) {
						$this->output->append_output(4);
					} else {
						$this->output->append_output(2);
					}
				} else {
					if (preg_match('/t{1}/', $cart)) {
						$cartinfo = explode('t', $cart);
						$pid = $cartinfo[0];
						$amount = $cartinfo[1];
						if (preg_match('/^[0-9]+$/', $pid) && preg_match('/^[0-9]+$/', $amount) && $amount >= 1) {
							$this->load->model('Buy_model', 'buymodel');
							$query = $this->buymodel->getproinfo($uid, $pid, $amount);
							if ($query == 1) {
								$this->output->append_output(1);
							} elseif ($query == 2) {
								$this->output->append_output(2);
							} elseif ($query == 3) {
								$this->output->append_output(3);
							} elseif ($query == 4) {
								$this->output->append_output(4);
							}
						} else {
							$this->output->append_output(2);
						}
					} else {
						$this->output->append_output(2);
					}
				}
			} else {
				$this->output->append_output(2);
			}
		} else {
			return false;
		}
	}
	
	//进入付款界面前验证收货地址并生成订单并清空购物车
	function getadd() {
		$uid = $this->session->userdata('uid');
		$read = $this->session->userdata('read');
		if (!empty($uid) and $read == 0) {
			$add = $this->input->post('addselect');
			if (preg_match('/^[1-3]{1}$/', $add)) {
				$this->load->model('User_model', 'usermodel');
				$address = $this->usermodel->view_address($uid);
				if ($add == 1) {
					if (empty($address['zipcode_one'])) {
						$address['zipcode_one'] = '邮编无';
					}
					$add = $address['consignee_one'].', '.$address['college_one'].', '.$address['address_one'].', '.$address['zipcode_one'].', '.$address['phone_one'];
					$this->load->model('Buy_model', 'buymodel');
					$query = $this->buymodel->insertorder($uid, $add);
					if (!empty($query['oids'])) {
						$this->session->set_userdata('order', $query);
						$this->output->append_output(1);
					} else {
						$this->output->append_output(2);
					}
				} elseif ($add == 2) {
					if (empty($address['zipcode_two'])) {
						$address['zipcode_two'] = '邮编无';
					}
					$add = $address['consignee_two'].', '.$address['college_two'].', '.$address['address_two'].', '.$address['zipcode_two'].', '.$address['phone_two'];
					$this->load->model('Buy_model', 'buymodel');
					$query = $this->buymodel->insertorder($uid, $add);
					if (!empty($query['oids'])) {
						$this->session->set_userdata('order', $query);
						$this->output->append_output(1);
					} else {
						$this->output->append_output(2);
					}
				} elseif ($add == 3) {
					if (empty($address['zipcode_three'])) {
						$address['zipcode_three'] = '邮编无';
					}
					$add = $address['consignee_three'].', '.$address['college_three'].', '.$address['address_three'].', '.$address['zipcode_three'].', '.$address['phone_three'];
					$this->load->model('Buy_model', 'buymodel');
					$query = $this->buymodel->insertorder($uid, $add);
					if (!empty($query['oids'])) {
						$this->session->set_userdata('order', $query);
						$this->output->append_output(1);
					} else {
						$this->output->append_output(2);
					}
				} else {
					return false;
				}
			} else {
				return false;
			}
		} else {
			return false;
		}
	}
	
	//获取用户账户余额
	function getbalance() {
		$uid = $this->session->userdata('uid');
		$this->load->model('Buy_model', 'buymodel');
		$query = $this->buymodel->getbalance($uid);
		if (!empty($query)) {
			$this->output->append_output($query['balance']);
		}
	}
	
	//确认用户满足支付条件
	function confirmbalance() {
		$uid = $this->session->userdata('uid');
		$order = $this->session->userdata('order');
		$this->load->model('Buy_model', 'buymodel');
		$query = $this->buymodel->getbalance($uid);
		if (!empty($order['total']) && !empty($query)) {
			if ($query['balance'] < $order['total']) {
				$this->output->append_output(2);
			} elseif ($query['balance'] >= $order['total']) {
				$this->output->append_output(1);
			}
		}
	}
	
	//用户充值虚拟账户
	function charge() {
		$uid = $this->session->userdata('uid');
		$read = $this->session->userdata('read');
		if (!empty($uid) and $read == 0) {
			$charge = $this->input->post('charge');
			if (preg_match('/^\d{1,6}(\.\d{1,2})?$/', $charge)) {
				$this->load->model('Buy_model', 'buymodel');
				$query = $this->buymodel->charge($uid, $charge);
				$balance = $this->buymodel->getbalance($uid);
				$query .= '*'.$balance['balance'];
				$this->output->append_output($query);
			} else {
				$this->output->append_output(3);
			}
		}
	}
	
	//获取子catid
	function getcatid() {
		$catid = $this->input->get('catid');
		if (preg_match('/^[0-9]+$/', $catid)) {
			$this->load->model('Item_model', 'itemmodel');
			$query = $this->itemmodel->getchildcatid($catid);
			$output = json_encode($query);
			$this->output->append_output($output);
		}
	}
	
	//卖家发布商品
	function release() {
		$uid = $this->session->userdata('uid');
		$read = $this->session->userdata('read');
		if (!empty($uid) and $read == 0) {
			$this->load->model('User_model', 'usermodel');
			$userinfo = $this->usermodel->getusertype($uid);
			if ($userinfo['usertype'] == 2 or $userinfo['usertype'] == 3) {
				$this->load->helper('cookie');
				$catid_one = get_cookie('catid_one');
				$catid_two = get_cookie('catid_two');
				$catid_three = get_cookie('catid_three');
				$title = get_cookie('title');
				$mprice = get_cookie('mprice');
				$price = get_cookie('price');
				$new_old = get_cookie('new_old');
				$detail = get_cookie('detail');
				$amount = get_cookie('amount');
				$visible = get_cookie('visible');
				$cost = get_cookie('cost');
				$ex_range = get_cookie('ex_range');
				$wot = get_cookie('wot');
				$image_one = $this->session->userdata('image_one');
				$image_two = $this->session->userdata('image_two');
				$image_three = $this->session->userdata('image_three');
				$image_four = $this->session->userdata('image_four');
				$image_five = $this->session->userdata('image_five');
				if ($mprice == 0) {
					$mprice = null;
				}
				if ($wot == 4) {
					$wot = 0;
				}
				$n = 0;
				if (!empty($image_one)) {
					$n++;
				} else {
					$image_one = '';
				}
				if (!empty($image_two)) {
					$n++;
				} else {
					$image_two = '';
				}
				if (!empty($image_three)) {
					$n++;
				} else {
					$image_three = '';
				}
				if (!empty($image_four)) {
					$n++;
				} else {
					$image_four = '';
				}
				if (!empty($image_five)) {
					$n++;
				} else {
					$image_five = '';
				}
				if ($n == 0) {
					$this->output->append_output(2);
				} else {
					if (empty($image_one)) {
						if (!empty($image_two)) {
							$image_one = $image_two;
							$image_two = '';
						} elseif (!empty($image_three)) {
							$image_one = $image_three;
							$image_three = '';
						} elseif (!empty($image_four)) {
							$image_one = $image_four;
							$image_four = '';
						} elseif (!empty($image_five)) {
							$image_one = $image_five;
							$image_five = '';
						}
					}
					if ($catid_three == 0) {
						if ($catid_two == 0) {
							$catid = $catid_one;
						} else {
							$catid = $catid_two;
						}
					} else {
						$catid = $catid_three;
					}
					$this->load->model('Item_model', 'itemmodel');
					$shopinfo = $this->itemmodel->getshopinfo($uid);
					$query = $this->itemmodel->insertpro($uid, $shopinfo['sid'], $catid, $title, $mprice, $price, $new_old, $detail, $amount, $visible, $cost, $ex_range, $wot, $image_one, $image_two, $image_three, $image_four, $image_five);
					if ($query == true) {
						$try = array(
						'image_one' => '',
						'image_two' => '',
						'image_three' => '',
						'image_four' => '',
						'image_five' => ''
						);
						$this->session->unset_userdata($try);
						delete_cookie('catid_one');
						delete_cookie('catid_two');
						delete_cookie('catid_three');
						delete_cookie('title');
						delete_cookie('mprice');
						delete_cookie('price');
						delete_cookie('new_old');
						delete_cookie('detail');
						delete_cookie('amount');
						delete_cookie('visible');
						delete_cookie('cost');
						delete_cookie('ex_range');
						delete_cookie('wot');
						$this->output->append_output(1);
					} else {
						$this->output->append_output(3);
					}
				}
			}
		}
	}
	
	//删除上传的图片
	function delimg() {
		$del = $this->input->post('del');
		if (preg_match('/^[1-5]{1}$/', $del)) {
			$img = 'images/user/proview/';
			switch ($del) {
				case 1:
					$img .= $this->session->userdata('image_one');
					unlink($img);
					$try = array('image_one' => '');
					$this->session->unset_userdata($try);
					unset($try);
					break;
				case 2:
					$img .= $this->session->userdata('image_two');
					unlink($img);
					$try = array('image_two' => '');
					$this->session->unset_userdata($try);
					unset($try);
					break;
				case 3:
					$img .= $this->session->userdata('image_three');
					unlink($img);
					$try = array('image_three' => '');
					$this->session->unset_userdata($try);
					unset($try);
					break;
				case 4:
					$img .= $this->session->userdata('image_four');
					unlink($img);
					$try = array('image_four' => '');
					$this->session->unset_userdata($try);
					unset($try);
					break;
				case 5:
					$img .= $this->session->userdata('image_five');
					unlink($img);
					$try = array('image_five' => '');
					$this->session->unset_userdata($try);
					unset($try);
					break;
				default:
					break;
			}
			$this->output->append_output(1);
		}
	}
	
	//卖家删除商品
	function delpro() {
		$pid = $this->input->post('del');
		$uid = $this->session->userdata('uid');
		$read = $this->session->userdata('read');
		if (!empty($uid) and $read == 0) {
			if (preg_match('/^[0-9]+$/', $pid)) {
				$this->load->model('Item_model', 'itemmodel');
				$check = $this->itemmodel->detail($pid);
				if ($check['uid'] == $uid) {
					$query = $this->itemmodel->delpro($pid);
					if ($query == true) {
						$this->output->append_output(1);
					}
				}
			}
		}
	}
	
	//卖家确认发布商品
	function releasepro() {
		$pid = $this->input->post('release');
		$uid = $this->session->userdata('uid');
		$read = $this->session->userdata('read');
		if (!empty($uid) and $read == 0) {
			if (preg_match('/^[0-9]+$/', $pid)) {
				$this->load->model('Item_model', 'itemmodel');
				$check = $this->itemmodel->detail($pid);
				if ($check['uid'] == $uid) {
					$query = $this->itemmodel->releasepro($pid);
					if ($query == true) {
						$this->output->append_output(1);
					}
				}
			}
		}
	}
	
	//卖家确认发货
	function confship() {
		$oid = $this->input->post('oid');
		$uid = $this->session->userdata('uid');
		$read = $this->session->userdata('read');
		if (!empty($uid) and $read == 0) {
			if (preg_match('/^[0-9]+$/', $oid)) {
				$this->load->model('Buy_model', 'buymodel');
				$check = $this->buymodel->getsaleuid($oid);
				if ($uid == $check['saleuid']) {
					$query = $this->buymodel->markship($oid);
					if ($query == true) {
						$this->output->append_output(1);
					}
				}
			}
		}
	}
	
	//买家订单付款
	function pay() {
		$oid = $this->input->post('oid');
		$uid = $this->session->userdata('uid');
		$read = $this->session->userdata('read');
		if (!empty($uid) and $read == 0) {
			if (preg_match('/^[0-9]+$/', $oid)) {
				$this->load->model('Buy_model', 'buymodel');
				$check = $this->buymodel->getbuyuid($oid);
				if ($uid == $check['buyuid']) {
					$query = $this->buymodel->markspay($uid, $oid);
					if ($query == 1) {
						$this->output->append_output(1);
					} elseif ($query == 2) {
						$this->output->append_output(2);
					} elseif ($query == 3) {
						$this->output->append_output(3);
					} elseif ($query == 4) {
						$this->output->append_output(4);
					} elseif ($query == 5) {
						$this->output->append_output(5);
					}
				} else {
					return false;
				}
			}
		}
	}
	
	//确认收货
	function confirmpay() {
		$oid = $this->input->post('oid');
		$uid = $this->session->userdata('uid');
		$read = $this->session->userdata('read');
		if (!empty($uid) and $read == 0) {
			if (preg_match('/^[0-9]+$/', $oid)) {
				$this->load->model('Buy_model', 'buymodel');
				$check = $this->buymodel->getbuyuid($oid);
				if ($uid == $check['buyuid']) {
					$query = $this->buymodel->paytoseller($uid, $oid);
					if ($query == 1) {
						$this->output->append_output(1);
					}
				} else {
					return false;
				}
			} else {
				return false;
			}
		} else {
			return false;
		}
	}
	
	//个人店铺认证成功
	function certuser() {
		$this->load->model('Admin_model','adminmodel');
		$aid = $this->session->userdata('aid');
		if (empty($aid)) {
			return false;
		} else {
			$uid = $this->input->post('uid');
			if (preg_match('/^[0-9]+$/', $uid)) {
				$query = $this->adminmodel->certuser($uid);
				if ($query == true) {
					$this->output->append_output('1');
				} else {
					return false;
				}
			} else {
				return false;
			}
		}
	}
	
	//企业店铺认证成功
	function certbusi() {
		$this->load->model('Admin_model','adminmodel');
		$aid = $this->session->userdata('aid');
		if (empty($aid)) {
			return false;
		} else {
			$uid = $this->input->post('uid');
			if (preg_match('/^[0-9]+$/', $uid)) {
				$query = $this->adminmodel->certbusi($uid);
				if ($query == true) {
					$this->output->append_output('1');
				} else {
					return false;
				}
			} else {
				return false;
			}
		}
	}
	
	//店铺认证失败
	function certnot() {
		$this->load->model('Admin_model','adminmodel');
		$aid = $this->session->userdata('aid');
		if (empty($aid)) {
			return false;
		} else {
			$uid = $this->input->post('uid');
			if (preg_match('/^[0-9]+$/', $uid)) {
				$query = $this->adminmodel->certnot($uid);
				if ($query == true) {
					$this->output->append_output('1');
				} else {
					return false;
				}
			} else {
				return false;
			}
		}
	}
	
}
?>