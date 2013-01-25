<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Admin_model extends CI_Model {
	
	function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->_po_admin = 'po_admin';
        $this->_po_shop = 'po_shop';
        $this->_po_user = 'po_user';
        $this->_po_user_pass = 'po_user_pass';
        $this->_po_real = 'po_real';
	}
	
	//登录验证
	function getuser($username, $password) {
		$this->db->where('name', $username);
		$this->db->where('password', $password);
		$this->db->select('aid, realname, permission, lastlogin, login_count');
		$query = $this->db->get($this->_po_admin)->row_array();
		if (!empty($query['aid'])) {
			$now = date('Y-m-d H:i:s');
			$count = $query['login_count'];
			$count += 1;
			$this->db->where('aid', $query['aid']);
			$data = array(
			'lastlogin' => $now,
			'login_count' => $count
			);
			$this->db->update($this->_po_admin, $data);
			return $query;
		} else {
			return false;
		}
	}
	
	//获取待认证店铺的用户
	function getcert() {
		$this->db->where('usertype', 4);
		$this->db->select('uid, username');
		$query = $this->db->get($this->_po_user)->result_array();
		$c = count($query);
		for ($i = 0; $i < $c; $i++) {
			$this->db->where('uid', $query[$i]['uid']);
			$this->db->select('read');
			$data = $this->db->get($this->_po_user_pass)->row_array();
			$query[$i] = array_merge($query[$i], $data);
			unset($data);
			$this->db->where('uid', $query[$i]['uid']);
			$this->db->select('shop, reg_date');
			$data = $this->db->get($this->_po_shop)->row_array();
			$query[$i] = array_merge($query[$i], $data);
			unset($data);
			$this->db->where('uid', $query[$i]['uid']);
			$this->db->select('name, college, idnumber, idimage');
			$data = $this->db->get($this->_po_real)->row_array();
			$query[$i] = array_merge($query[$i], $data);
			unset($data);
		}
		return $query;
	}
	
	//认证个人卖家成功
	function certuser($uid) {
		$this->db->where('uid', $uid);
		$this->db->select('shop');
		$query = $this->db->get($this->_po_shop)->row_array();
		if (empty($query['shop'])) {
			return false;
		} else {
			$data['usertype'] = 2;
			$this->db->where('uid', $uid);
			$this->db->update($this->_po_user, $data);
			unset($data);
			$data['read'] = 0;
			$data['reg_date'] = date('Y-m-d H:i:s');
			$this->db->where('uid', $uid);
			$this->db->update($this->_po_shop, $data);
			unset($data);
			return true;
		}
	}
	
	//认证企业卖家成功
	function certbusi($uid) {
		$this->db->where('uid', $uid);
		$this->db->select('shop');
		$query = $this->db->get($this->_po_shop)->row_array();
		if (empty($query['shop'])) {
			return false;
		} else {
			$data['usertype'] = 3;
			$this->db->where('uid', $uid);
			$this->db->update($this->_po_user, $data);
			unset($data);
			$data['read'] = 0;
			$data['reg_date'] = date('Y-m-d H:i:s');
			$this->db->where('uid', $uid);
			$this->db->update($this->_po_shop, $data);
			unset($data);
			return true;
		}
	}
	
	//认证失败
	function certnot($uid) {
		$this->db->where('uid', $uid);
		$this->db->select('shop');
		$query = $this->db->get($this->_po_shop)->row_array();
		if (empty($query['shop'])) {
			return false;
		} else {
			$data['usertype'] = 5;
			$this->db->where('uid', $uid);
			$this->db->update($this->_po_user, $data);
			unset($data);
			return true;
		}
	}
	
}
?>