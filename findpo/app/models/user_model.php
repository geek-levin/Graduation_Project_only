<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class User_model extends CI_Model {
	
	function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->_po_user_pass = 'po_user_pass';
        $this->_po_user = 'po_user';
        $this->_po_real = 'po_real';
        $this->_po_address = 'po_address';
        $this->_po_cart = 'po_cart';
        $this->_po_order = 'po_order';
        $this->_po_favorite = 'po_favorite';
        $this->_po_wanted = 'po_wanted';
        $this->_po_account = 'po_account';
        $this->_po_trade = 'po_trade';
        $this->_po_product = 'po_product';
        $this->_po_cart = 'po_cart';
        $this->_po_shop = 'po_shop';
        $this->_po_setting = 'po_setting';
	}
	
	//用户名是否已存在
	function ifexistuser($username='') {
		$this->db->where('username', $username);
		$ifexistuser = $this->db->get($this->_po_user_pass)->row_array();
		if ($ifexistuser) {
			return true;
		} else {
			return false;
		}
	}
	
	//邮箱是否已存在
	function ifexistemail($email='') {
		$this->db->where('email', $email);
		$ifexistemail = $this->db->get($this->_po_user)->row_array();
		if ($ifexistemail) {
			return true;
		} else {
			return false;
		}
	}
	
	//插入密码表并返回uid
	function reg($username='', $password='') {
		$data = array (
		'username'=>$username,
		'password'=>$password,
		);
		$this->db->insert($this->_po_user_pass, $data);
		$uid = $this->db->insert_id();
		return $uid;
	}
	
	//将注册信息插入各相应表中
	function register($username, $password, $email, $uid, $now) {
		$data = array (
		'uid'=>$uid,
		'username'=>$username,
		'email'=>$email,
		'reg_date'=>$now,
		'lastlogin'=>$now,
		);
		$this->db->insert($this->_po_user, $data);
		unset($data);
		$data = array (
		'uid'=>$uid,
		);
		$this->db->insert($this->_po_real, $data);
		$this->db->insert($this->_po_address, $data);
		$this->db->insert($this->_po_cart, $data);
		unset($data);
		$data = array (
		'uid'=>$uid,
		'paypassword'=>$password,
		);
		$this->db->insert($this->_po_account, $data);
		$this->db->where('uid', $uid);
		$reginfo = $this->db->get($this->_po_user_pass)->row_array();
		return $reginfo;
	}
	
	//测试ajax
	function getusername($username='') {
		$this->db->where('username', $username);
		$ifexistuser = $this->db->get($this->_po_user_pass)->row_array();
		if ($ifexistuser) {
			return true;
		} else {
			return false;
		}
	}
	
	//登录验证
	function getuser($username='', $password='') {
		$this->db->where('username', $username);
		$this->db->where('password', $password);
		$uid = $this->db->get($this->_po_user_pass)->row_array();
		if (!empty($uid['uid'])) {
			return $uid;
		} else {
			return false;
		}
	}
	
	//计算购物车件数
	function viewcart($uid='') {
		$this->db->where('uid', $uid);
		$cart = $this->db->get($this->_po_cart)->row_array();
		$count = 0;
		foreach (range('a', 'j') as $i) {
			if (!empty($cart['item_'.$i])) {
				$count +=1;
			}
		}
		return $count;
	}
	
	//获取收藏商品id
	function getpfav($uid) {
		$this->db->where('uid', $uid);
		$this->db->where('pid !=', '');
		$query = $this->db->get($this->_po_favorite)->result_array();
		return $query;
	}
	
	//获取收藏商店id
	function getsfav($uid) {
		$this->db->where('uid', $uid);
		$this->db->where('sid !=', '');
		$query = $this->db->get($this->_po_favorite)->result_array();
		return $query;
	}
	
	//获取商店信息
	function getsfavinfo($sid) {
		$this->db->where('sid', $sid);
		$query = $this->db->get($this->_po_shop)->row_array();
		return $query;
	}

	//删除收藏商品
	function deletepfav($pid, $uid) {
		$this->db->where('pid', $pid);
		$this->db->where('uid', $uid);
		$this->db->delete($this->_po_favorite);
		return true;
	}
	
	//删除收藏商店
	function deletesfav($sid, $uid) {
		$this->db->where('sid', $sid);
		$this->db->where('uid', $uid);
		$this->db->delete($this->_po_favorite);
		return true;
	}
	
	//查看收货地址
	function view_address($uid='') {
		$this->db->where('uid', $uid);
		$address = $this->db->get($this->_po_address)->row_array();
		return $address;
	}
	
	//增加收货地址1
	function add_address_one($uid='', $consignee='', $college='', $address='', $zipcode='', $phone='') {
		$data = array(
		'consignee_one'=>$consignee,
		'college_one'=>$college,
		'address_one'=>$address,
		'zipcode_one'=>$zipcode,
		'phone_one'=>$phone,
		);
		$this->db->where('uid', $uid);
		$this->db->update($this->_po_address, $data);
		return true;
	}
	
	//增加收货地址2
	function add_address_two($uid='', $consignee='', $college='', $address='', $zipcode='', $phone='') {
		$data = array(
		'consignee_two'=>$consignee,
		'college_two'=>$college,
		'address_two'=>$address,
		'zipcode_two'=>$zipcode,
		'phone_two'=>$phone,
		);
		$this->db->where('uid', $uid);
		$this->db->update($this->_po_address, $data);
		return true;
	}
	
	//增加收货地址3
	function add_address_three($uid='', $consignee='', $college='', $address='', $zipcode='', $phone='') {
		$data = array(
		'consignee_three'=>$consignee,
		'college_three'=>$college,
		'address_three'=>$address,
		'zipcode_three'=>$zipcode,
		'phone_three'=>$phone,
		);
		$this->db->where('uid', $uid);
		$this->db->update($this->_po_address, $data);
		return true;
	}
	
	//删除收货地址
	function deleteaddr($uid='', $deleteaddr='') {
		if ($deleteaddr == 1) {
			$data = array(
			'consignee_one'=>NULL,
			'college_one'=>NULL,
			'address_one'=>NULL,
			'zipcode_one'=>NULL,
			'phone_one'=>NULL,
			);
			$this->db->where('uid', $uid);
			$this->db->update($this->_po_address, $data);
			return true;
		} elseif($deleteaddr == 2) {
			$data = array(
			'consignee_two'=>NULL,
			'college_two'=>NULL,
			'address_two'=>NULL,
			'zipcode_two'=>NULL,
			'phone_two'=>NULL,
			);
			$this->db->where('uid', $uid);
			$this->db->update($this->_po_address, $data);
			return true;
		} elseif($deleteaddr == 3) {
			$data = array(
			'consignee_three'=>NULL,
			'college_three'=>NULL,
			'address_three'=>NULL,
			'zipcode_three'=>NULL,
			'phone_three'=>NULL,
			);
			$this->db->where('uid', $uid);
			$this->db->update($this->_po_address, $data);
			return true;
		} else {
			return false;
		}
	}
	
	//取出学校设置
	function import_setting() {
		$this->db->where('setting_id', '1');
		$setting = $this->db->get($this->_po_setting)->row_array();
		return $setting;
	}
		
	//修改密码
	function password($uid='', $newpassword='') {
		$data['password'] = $newpassword;
		$this->db->where('uid', $uid);
		$pass = $this->db->get($this->_po_user_pass)->row_array();
		$this->db->where('uid', $uid);
		$this->db->update($this->_po_user_pass, $data);
		$this->db->where('uid', $uid);
		$query = $this->db->get($this->_po_account)->row_array();
		if ($query['paypassword'] == $pass['password']) {
			unset($data);
			$data['paypassword'] = $newpassword;
			$this->db->where('uid',$uid);
			$this->db->update($this->_po_account, $data);
		}
		return true;
	}
	
	//修改虚拟账户密码
	function accpass($uid, $newpassword) {
		$data['paypassword'] = $newpassword;
		$this->db->where('uid', $uid);
		$this->db->update($this->_po_account, $data);
		return true;
	}
	
	//获取虚拟账户密码
	function getaccpass($uid) {
		$this->db->where('uid', $uid);
		$this->db->select('paypassword');
		$query = $this->db->get($this->_po_account)->row_array();
		return $query['paypassword'];
	}
	
	//获取用户详细信息
	function getuserinfo($uid) {
		$this->db->where('uid', $uid);
		$userinfo = $this->db->get($this->_po_user)->row_array();
		return $userinfo;
	}
	
	//商品加入购物车
	function insertcart($uid, $pid, $pcount) {
		$this->db->where('pid', $pid);
		$this->db->select('price, amount, visible, cost, end, read');
		$query = $this->db->get($this->_po_product)->row_array();
		if ($query['visible'] != 0 or $query['read'] != 0) {
			return 4;
		}
		if (time() > strtotime($query['end'])) {
			return 5;
		}
		if (!empty($query)) {
			if ($pcount <= $query['amount']) {
				$this->db->where('uid', $uid);
				$cartinfo = $this->db->get($this->_po_cart)->row_array();
				foreach (range('a', 'j') as $i) {
					if (!empty($cartinfo['item_'.$i])) {
						$cpid = explode('*', $cartinfo['item_'.$i]);
						if ($pid == $cpid[0]) {
							return 2;
						}
					}
				}
				foreach (range('a', 'j') as $i) {
					if (empty($cartinfo['item_'.$i])) {
						date_default_timezone_set('PRC');
						$now = date('Y-m-d H:i:s');
						$data['item_'.$i] = $pid.'*'.$query['price'].'*'.$pcount.'*'.$query['cost'].'*'.$now;
						$this->db->where('uid', $uid);
						$this->db->update($this->_po_cart, $data);
						return 3;
					}
				}
				return 1;
			} else {
				return false;
			}
		} else {
			return false;
		}
	}
	
	//用户查看购物车
	function getcart($uid) {
		$this->db->where('uid', $uid);
		$query = $this->db->get($this->_po_cart)->row_array();
		date_default_timezone_set('PRC');
		foreach (range('a', 'j') as $i) {
			if (!empty($query['item_'.$i])) {
				$end = explode('*', $query['item_'.$i]);
				if (strtotime($end[4])+432000 < time()) {
					$data['item_'.$i] = '';
					$this->db->where('uid', $uid);
					$this->db->update($this->_po_cart, $data);
				}
			}
		}
		$this->db->where('uid', $uid);
		$cart = $this->db->get($this->_po_cart)->row_array();
		return $cart;
	}
	
	//删除购物车商品
	function deletecart($uid, $pid) {
		$this->db->where('uid', $uid);
		$query = $this->db->get($this->_po_cart)->row_array();
		if (!empty($query)) {
			foreach (range('a', 'j') as $i) {
				if (!empty($query['item_'.$i])) {
					$cpid = explode('*', $query['item_'.$i]);
					if ($cpid[0] == $pid) {
						$data['item_'.$i] = '';
						$this->db->where('uid', $uid);
						$this->db->update($this->_po_cart, $data);
						return true;
					}
				}
			}
		} else {
			return false;
		}
	}
	
	//获取订单信息
	function getorder($uid) {
		$this->db->where('buyuid', $uid);
		$query = $this->db->get($this->_po_order)->result_array();
		return $query;
	}
	
	//获取单条订单信息
	function getoneorder($oid) {
		$this->db->where('oid', $oid);
		$query = $this->db->get($this->_po_order)->row_array();
		return $query;
	}
	
	//获取用户求购信息
	function getuserwanted($uid) {
		$this->db->where('uid', $uid);
		$query = $this->db->get($this->_po_wanted)->result_array();
		return $query;
	}
	
	//插入用户求购信息
	function insertwanted($uid, $type, $name, $detail, $price, $amount) {
		date_default_timezone_set('PRC');
		$now = date('Y-m-d H:i:s');
		$deadline = date('Y-m-d H:i:s', time()+1728000);
		$data = array(
		'uid' => $uid,
		'type' => $type,
		'name' => $name,
		'detail' => $detail,
		'price' => $price,
		'amount' => $amount,
		'deadline' => $deadline,
		'time' => $now,
		);
		$this->db->insert($this->_po_wanted, $data);
		return true;
	}
	
	//获取用户虚拟账户交易信息
	function gettrade($uid) {
		$this->db->where('uid', $uid);
		$query = $this->db->get($this->_po_trade)->result_array();
		return $query;
	}
	
	//获取用户真实信息
	function getuserreal($uid) {
		$this->db->where('uid', $uid);
		$query = $this->db->get($this->_po_real)->row_array();
		return $query;
	}
	
	//获取卖家类型和商店可读信息
	function getusertype($uid) {
		$this->db->where('uid', $uid);
		$this->db->select('usertype');
		$query = $this->db->get($this->_po_user)->row_array();
		$this->db->where('uid', $uid);
		$this->db->select('idimage');
		$idimage = $this->db->get($this->_po_real)->row_array();
		$query['idimage'] = $idimage['idimage'];
		return $query;
	}
	
	//上传身份证图片
	function uploadid($uid, $idimage) {
		$data['uid'] = $uid;
		$this->db->insert($this->_po_shop, $data);
		unset($data);
		$data['idimage'] = $idimage;
		$this->db->where('uid', $uid);
		$this->db->update($this->_po_real, $data);
		return true;
	}
	
	//更新商店及用户真实信息
	function updateshop($uid, $name, $college, $idnumber, $shop) {
		date_default_timezone_set('PRC');
		$now = date('Y-m-d H:i:s');
		$data = array(
		'shop' => $shop,
		'reg_date' => $now,
		'read' => 1
		);
		$this->db->where('uid', $uid);
		$this->db->update($this->_po_shop, $data);
		unset($data);
		$data = array(
		'name' => $name,
		'college' => $college,
		'idnumber' => $idnumber
		);
		$this->db->where('uid', $uid);
		$this->db->update($this->_po_real, $data);
		unset($data);
		$data['usertype'] = 4;
		$this->db->where('uid', $uid);
		$this->db->update($this->_po_user, $data);
		return true;
	}
	
	//更新店铺信息
	function updateshopinfo($uid, $shop, $introduce, $notice) {
		$data = array(
		'shop' => $shop,
		'introduce' => $introduce,
		'notice' => $notice
		);
		$this->db->where('uid', $uid);
		$this->db->update($this->_po_shop, $data);
		return true;
	}
	
}
?>