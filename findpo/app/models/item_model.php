<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Item_model extends CI_Model {
	
	function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->_po_product = 'po_product';
        $this->_po_user_pass = 'po_user_pass';
        $this->_po_user = 'po_user';
        $this->_po_real = 'po_real';
        $this->_po_category = 'po_category';
        $this->_po_order = 'po_order';
        $this->_po_favorite = 'po_favorite';
        $this->_po_comment = 'po_comment';
        $this->_po_shop = 'po_shop';
        $this->_po_wanted = 'po_wanted';
	}
	
	//主页
	function index() {
		$this->db->select('pid, catid, title, price, visible, release, image_one, end, views, read');
		$query = $this->db->get($this->_po_product)->result_array();
		return $query;
	}
	
	//交易信息
	function wanted() {
		$this->db->select('type, name, detail, price, amount, deadline, time, read');
		$query = $this->db->get($this->_po_wanted)->result_array();
		return $query;
	}
	
	//商品详细信息
	function detail($pid='') {
		$this->db->where('pid', $pid);
		$detail = $this->db->get($this->_po_product)->row_array();
		return $detail;
	}
	
	//获取卖家信息
	function getsellerinfo($uid='') {
		$this->db->where('uid', $uid);
		$sellerread = $this->db->get($this->_po_user_pass)->row_array();
		$this->db->where('uid', $uid);
		$sellercoll = $this->db->get($this->_po_real)->row_array();
		$this->db->where('uid', $uid);
		$sellerinfo = $this->db->get($this->_po_user)->row_array();
		$sellerinfo['read'] = $sellerread['read'];
		$sellerinfo['college'] = $sellercoll['college'];
		return $sellerinfo;
	}
	
	//获取商品分类信息
	function getcatinfo($catid='') {
		$this->db->where('catid', $catid);
		$catdetail = $this->db->get($this->_po_category)->row_array();
		$classname = $catdetail['classname'];
		$parentid = $catdetail['parentid'];
		while (!empty($parentid)) {
			$this->db->where('catid', $parentid);
			$catdetail = $this->db->get($this->_po_category)->row_array();
			$classname .= '*'.$catdetail['classname'];
			$catid .= '*'.$catdetail['catid'];
			$parentid = $catdetail['parentid'];
			if (!empty($parentid)) {
				continue;
			}
		}
		$catinfo['classname'] = $classname;
		$catinfo['catid'] = $catid;
		return $catinfo;
	}
	
	//获取商品评论
	function getcomment($pid='') {
		$this->db->where('pid', $pid);
		$comment = $this->db->get($this->_po_comment)->result_array();
		return $comment;
	}
	
	//获取商店信息
	function getshopinfo($uid='') {
		$this->db->where('uid', $uid);
		$shopinfo = $this->db->get($this->_po_shop)->row_array();
		return $shopinfo;
	}
	
	//获取商品被收藏信息
	function getfav($pid) {
		$this->db->where('pid', $pid);
		$favinfo = $this->db->get($this->_po_favorite)->result_array();
		$favcount = count($favinfo);
		return $favcount;
	}
	
	//获取商品被购买信息
	function getorder($pid) {
		$this->db->where('pid', $pid);
		$orderinfo = $this->db->get($this->_po_order)->result_array();
		return $orderinfo;
	}
	
	//用户添加商品和店铺收藏
	function insertfav($uid, $psid) {
		if (preg_match('/^[0-9]+$/', $psid)) {
			$this->db->where('uid', $uid);
			$this->db->where('pid', $psid);
			$favinfo = $this->db->get($this->_po_favorite)->row_array();
			if (!empty($favinfo)) {
				return 2;
			} else {
				date_default_timezone_set('PRC');
				$now = date('Y-m-d H:i:s');
				$data = array(
				'uid' => $uid,
				'pid' => $psid,
				'time' => $now
				);
				$this->db->insert($this->_po_favorite, $data);
				return 1;
			}
		} elseif (preg_match('/^s{1}[0-9]+$/', $psid)) {
			$psid = substr($psid, 1);
			$this->db->where('uid', $uid);
			$this->db->where('sid', $psid);
			$favinfo = $this->db->get($this->_po_favorite)->row_array();
			if (!empty($favinfo)) {
				return 2;
			} else {
				date_default_timezone_set('PRC');
				$now = date('Y-m-d H:i:s');
				$data = array(
				'uid' => $uid,
				'sid' => $psid,
				'time' => $now
				);
				$this->db->insert($this->_po_favorite, $data);
				return 1;
			}
		} else {
			return false;
		}
	}
	
	//获取购物车商品某些信息
	function getpinfo($pid) {
		$this->db->where('pid', $pid);
		$this->db->select('pid, title, price, new_old, amount, cost, ex_range, wot, image_one');
		$pinfo = $this->db->get($this->_po_product)->row_array();
		return $pinfo;
	}
	
	//浏览次数加1
	function addviews($pid) {
		$this->db->where('pid', $pid);
		$this->db->select('views');
		$query = $this->db->get($this->_po_product)->row_array();
		$query['views'] += 1;
		$data['views'] = $query['views'];
		$this->db->where('pid', $pid);
		$this->db->update($this->_po_product, $data);
	}
	
	//取出最顶级的分类
	function getcatp() {
		$this->db->where('parentid', null);
		$this->db->select('catid, classname');
		$query = $this->db->get($this->_po_category)->result_array();
		return $query;
	}
	
	//根据父分类获取子分类
	function getchildcatid($catid) {
		$this->db->where('parentid', $catid);
		$this->db->select('catid, classname');
		$query = $this->db->get($this->_po_category)->result_array();
		return $query;
	}
	
	//发布商品
	function insertpro($uid, $sid, $catid, $title, $mprice, $price, $new_old, $detail, $amount, $visible, $cost, $ex_range, $wot, $image_one, $image_two, $image_three, $image_four, $image_five) {
		date_default_timezone_set('PRC');
		$now = date('Y-m-d H:i:s');
		$end = date('Y-m-d H:i:s', time()+2592000);
		$data = array(
		'uid' => $uid,
		'sid' => $sid,
		'catid' => $catid,
		'title' => $title,
		'mprice' => $mprice,
		'price' => $price,
		'new_old' => $new_old,
		'detail' => $detail,
		'amount' => $amount,
		'visible' => $visible,
		'cost' => $cost,
		'ex_range' => $ex_range,
		'wot' => $wot,
		'release' => $now,
		'image_one' => $image_one,
		'image_two' => $image_two,
		'image_three' => $image_three,
		'image_four' => $image_four,
		'image_five' => $image_five,
		'end' => $end,
		'update' => $now
		);
		$this->db->insert($this->_po_product, $data);
		return true;
	}
	
	//获取卖家已上传的商品
	function getsellerpro($uid) {
		$this->db->where('uid', $uid);
		$this->db->select('pid, title, price, new_old, amount, visible, release, image_one, views, read');
		$query = $this->db->get($this->_po_product)->result_array();
		return $query;
	}
	
	//卖家删除商品
	function delpro($pid) {
		$data['read'] = 1;
		$this->db->where('pid', $pid);
		$this->db->update($this->_po_product, $data);
		return true;
	}
	
	//卖家确认发布商品
	function releasepro($pid) {
		$data['visible'] = 0;
		$this->db->where('pid', $pid);
		$this->db->update($this->_po_product, $data);
		return true;
	}
	
	//获取卖家订单
	function getsellerorder($uid) {
		$this->db->where('saleuid', $uid);
		$query = $this->db->get($this->_po_order)->result_array();
		return $query;
	}
	
	//搜索
	function search($search) {
		$count = count($search);
		for ($i = 0; $i < $count; $i++) {
			if (empty($search[$i])) {
				array_splice($search, $i, 1);
			}
		}
		$count = count($search);
		$query = array();
		for ($i = 0; $i < $count; $i++) {
			$this->db->like('title', $search[$i]);
			$this->db->or_like('detail', $search[$i]);
			$this->db->select('pid');
			$query[$i] = $this->db->get($this->_po_product)->result_array();
		}
		$result = array();
		for ($i = 0; $i < $count; $i++) {
			if (!empty($query[$i])) {
				$c = count($query[$i]);
				for ($n = 0; $n < $c; $n++) {
					array_push($result, $query[$i][$n]['pid']);
				}
			}
		}
		$result = array_flip(array_flip($result));
		$result = array_merge($result);
		$count = count($result);
		for ($k = 0; $k < $count; $k++) {
			$this->db->where('pid', $result[$k]);
			$this->db->select('pid, title, price, visible, image_one, end, views, read');
			$result[$k] = $this->db->get($this->_po_product)->row_array();
		}
		return $result;
	}
	
}
?>