<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Buy_model extends CI_Model {
	
	function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->_po_product = 'po_product';
        $this->_po_user_pass = 'po_user_pass';
        $this->_po_user = 'po_user';
        $this->_po_shop = 'po_shop';
        $this->_po_cart = 'po_cart';
        $this->_po_order = 'po_order';
        $this->_po_account = 'po_account';
        $this->_po_trade = 'po_trade';
        $this->_po_comment = 'po_comment';
	}
	
	//获取商品信息并检查用户购物车数据
	function getproinfo($uid, $pid, $amount) {
		$this->db->where('pid', $pid);
		$this->db->select('uid, sid, amount, visible, end, read');
		$proinfo = $this->db->get($this->_po_product)->row_array();
		date_default_timezone_set('PRC');
		if ($proinfo['amount'] < $amount) {
			return 2;
		} elseif ($proinfo['visible'] != 0 or strtotime($proinfo['end']) < time() or $proinfo['read'] != 0) {
			return 1;
		} else {
			$this->db->where('uid', $proinfo['uid']);
			$this->db->select('read');
			$sellerread = $this->db->get($this->_po_user_pass)->row_array();
			$this->db->where('sid', $proinfo['sid']);
			$this->db->select('read');
			$shopread = $this->db->get($this->_po_shop)->row_array();
			if ($sellerread['read'] != 0 or $shopread['read'] !=0) {
				return 3;
			} else {
				$this->db->where('uid', $uid);
				$query = $this->db->get($this->_po_cart)->row_array();
				foreach (range('a', 'j') as $i) {
					if (!empty($query['item_'.$i])) {
						$cpid = explode('*', $query['item_'.$i]);
						if ($pid == $cpid[0]) {
							$newcart = $cpid[0].'*'.$cpid[1].'*'.$amount.'*'.$cpid[3].'*'.$cpid[4];
							$data['item_'.$i] = $newcart;
							$this->db->where('uid', $uid);
							$this->db->update($this->_po_cart, $data);
							return 4;
						}
					}
				}
			}
		}
	}
	
	//购物车生成订单
	function insertorder($uid, $add) {
		$this->db->where('uid', $uid);
		$cartinfo = $this->db->get($this->_po_cart)->row_array();
		date_default_timezone_set('PRC');
		$now = date('Y-m-d H:i:s');
		$alltotal = 0;
		$oid = '';
		foreach (range('a', 'j') as $i) {
			if (!empty($cartinfo['item_'.$i])) {
				$cart = explode('*', $cartinfo['item_'.$i]);
				$this->db->where('pid', $cart[0]);
				$this->db->select('uid');
				$seller = $this->db->get($this->_po_product)->row_array();
				$this->db->where('uid', $uid);
				$this->db->select('username, nickname');
				$buy = $this->db->get($this->_po_user)->row_array();
				$total = $cart[1]*$cart[2]+$cart[3];
				$alltotal += $total;
				$data = array(
				'pid' => $cart[0],
				'saleuid' => $seller['uid'],
				'buyuid' => $uid,
				'username' => $buy['username'],
				'nickname' => $buy['nickname'],
				'price' => $cart[1],
				'amount' => $cart[2],
				'total' => $total,
				'address' => $add,
				'time' => $now,
				'status' => 0,
				);
				$this->db->insert($this->_po_order, $data);
				$oid .= '*'.$this->db->insert_id();
				unset($data);
				$data['item_'.$i] = '';
				$this->db->where('uid', $uid);
				$this->db->update($this->_po_cart, $data);
			}
		}
		$order = array(
		'total'=>$alltotal,
		'oids'=>$oid
		);
		return $order;
	}
	
	//获取账户余额
	function getbalance($uid) {
		$this->db->where('uid', $uid);
		$this->db->select('balance');
		$query = $this->db->get($this->_po_account)->row_array();
		return $query;
	}
	
	//充值虚拟账户
	function charge($uid, $charge) {
		$this->db->where('uid', $uid);
		$this->db->select('balance');
		$query = $this->db->get($this->_po_account)->row_array();
		$charge += $query['balance'];
		$charge = round($charge, 2);
		if (preg_match('/^\d{1,6}(\.\d{1,2})?$/', $charge)) {
			$data['balance'] = $charge;
			$this->db->where('uid', $uid);
			$this->db->update($this->_po_account, $data);
			unset($data);
			date_default_timezone_set('PRC');
			$now = date('Y-m-d H:i:s');
			$data = array(
			'uid' => $uid,
			'oid' => null,
			'amount' => $charge,
			'type' => 1,
			'time' => $now
			);
			$this->db->insert($this->_po_trade, $data);
			return 1;
		} else {
			return 2;
		}
	}
	
	//付款成功扣费，商品减库存
	function getfee($uid, $total, $oids) {
		$this->db->where('uid', $uid);
		$this->db->select('balance');
		$balance = $this->db->get($this->_po_account)->row_array();
		$balance['balance'] -= $total;
		$balance['balance'] = round($balance['balance'], 2);
		$data['balance'] = $balance['balance'];
		$this->db->where('uid', $uid);
		$this->db->update($this->_po_account, $data);
		unset($data);
		$oid = explode('*', $oids);
		date_default_timezone_set('PRC');
		$now = date('Y-m-d H:i:s');
		$total = round($total, 2);
		for ($i = 0; $i < count($oid); $i++) {
			if ($i == 0) {
				continue;
			}
			$this->db->where('oid', $oid[$i]);
			$this->db->select('pid, amount, total');
			$pid = $this->db->get($this->_po_order)->row_array();
			$this->db->where('pid', $pid['pid']);
			$this->db->select('amount');
			$product = $this->db->get($this->_po_product)->row_array();
			$data['amount'] = $product['amount'] - $pid['amount'];
			$this->db->where('pid', $pid['pid']);
			$this->db->update($this->_po_product, $data);
			unset($data);
			$data = array(
			'uid' => $uid,
			'oid' => $oid[$i],
			'amount' => -$pid['total'],
			'type' => 2,
			'time' => $now
			);
			$this->db->insert($this->_po_trade, $data);
			unset($data);
		}
	}
	
	//付款成功标记订单状态
	function markpay($uid, $oids) {
		$oid = explode('*', $oids);
		date_default_timezone_set('PRC');
		$now = date('Y-m-d H:i:s');
		for ($i = 0; $i < count($oid); $i++) {
			if ($i == 0) {
				continue;
			}
			$data = array(
			'time_pay' => $now,
			'status' => 2
			);
			$this->db->where('oid', $oid[$i]);
			$this->db->update($this->_po_order, $data);
		}
	}
	
	//获取卖家订单的uid
	function getsaleuid($oid) {
		$this->db->where('oid', $oid);
		$this->db->select('saleuid');
		$query = $this->db->get($this->_po_order)->row_array();
		return $query;
	}
	
	//标记订单为已发货
	function markship($oid) {
		date_default_timezone_set('PRC');
		$now = date('Y-m-d H:i:s');
		$data = array(
		'time_ship' => $now,
		'status' => 3,
		);
		$this->db->where('oid', $oid);
		$this->db->update($this->_po_order, $data);
		return true;
	}
	
	//获取买家订单的uid
	function getbuyuid($oid) {
		$this->db->where('oid', $oid);
		$this->db->select('buyuid');
		$query = $this->db->get($this->_po_order)->row_array();
		return $query;
	}
	
	//标记订单为已付款
	function markspay($uid, $oid) {
		$this->db->where('uid', $uid);
		$this->db->select('balance');
		$balance = $this->db->get($this->_po_account)->row_array();
		$this->db->where('oid', $oid);
		$this->db->select('pid, amount, total, status');
		$order = $this->db->get($this->_po_order)->row_array();
		if ($order['status'] == 0) {
			if ($order['total'] <= $balance['balance']) {
				$this->db->where('pid', $order['pid']);
				$this->db->select('amount, visible, read');
				$pro = $this->db->get($this->_po_product)->row_array();
				if ($pro['amount'] >= $order['amount'] && $pro['visible'] == 0 && $pro['read'] == 0) {
					$balance['balance'] -= $order['total'];
					$balance['balance'] = round($balance['balance'], 2);
					date_default_timezone_set('PRC');
					$now = date('Y-m-d H:i:s');
					$data['balance'] = $balance['balance'];
					$this->db->where('uid', $uid);
					$this->db->update($this->_po_account, $data);
					unset($data);
					$data = array(
					'uid' => $uid,
					'oid' => $oid,
					'amount' => -$balance['balance'],
					'type' => 2,
					'time' => $now
					);
					$this->db->insert($this->_po_trade, $data);
					unset($data);
					$data = array(
					'time_pay' => $now,
					'status' => 2
					);
					$this->db->where('oid', $oid);
					$this->db->update($this->_po_order, $data);
					unset($data);
					$data['amount'] = $pro['amount'] - $order['amount'];
					$this->db->where('pid', $order['pid']);
					$this->db->update($this->_po_product, $data);
					return 1;
				} elseif ($pro['visible'] != 0 or $pro['read'] != 0) {
					return 4;
				} else {
					return 5;
				}
			} else {
				return 3;
			}
		} else {
			return 2;
		}
	}
	
	//买家付款给卖家
	function paytoseller($uid, $oid) {
		$this->db->where('oid', $oid);
		$this->db->select('saleuid, total, status');
		$order = $this->db->get($this->_po_order)->row_array();
		if ($order['status'] == 3 or $order['status'] == 1) {
			$this->db->where('uid', $order['saleuid']);
			$this->db->select('balance');
			$account = $this->db->get($this->_po_account)->row_array();
			$data['balance'] = $account['balance'] + $order['total'];
			$this->db->where('uid', $order['saleuid']);
			$this->db->update($this->_po_account, $data);
			unset($data);
			date_default_timezone_set('PRC');
			$now = date('Y-m-d H:i:s');
			$data = array(
			'uid' => $order['saleuid'],
			'oid' => $oid,
			'amount' => $order['total'],
			'type' => 3,
			'time' => $now
			);
			$this->db->where('uid', $order['saleuid']);
			$this->db->insert($this->_po_trade, $data);
			unset($data);
			$data = array(
			'time_over' => $now,
			'status' => 7,
			);
			$this->db->where('oid', $oid);
			$this->db->update($this->_po_order, $data);
			unset($data);
			$this->db->where('uid', $uid);
			$this->db->select('exchange');
			$exchange = $this->db->get($this->_po_user)->row_array();
			$data['exchange'] = $exchange['exchange'] + 1;
			$this->db->where('uid', $uid);
			$this->db->update($this->_po_user, $data);
			unset($data);
			$this->db->where('uid', $order['saleuid']);
			$this->db->select('exchange_seller');
			$exchange_seller = $this->db->get($this->_po_user)->row_array();
			$data['exchange_seller'] = $exchange_seller['exchange_seller'] + 1;
			$this->db->where('uid', $order['saleuid']);
			$this->db->update($this->_po_user, $data);
			unset($data);
			$this->db->where('uid', $order['saleuid']);
			$this->db->select('sale_count');
			$shop = $this->db->get($this->_po_shop)->row_array();
			$data['sale_count'] = $shop['sale_count'] + 1;
			$this->db->where('uid', $order['saleuid']);
			$this->db->update($this->_po_shop, $data);
			unset($data);
			return 1;
		}
	}
	
	//检查买家是否已经评价
	function checkiffeel($oid) {
		$this->db->where('oid', $oid);
		$this->db->select('status, feel');
		$query = $this->db->get($this->_po_order)->row_array();
		if (empty($query['feel']) && $query['status'] == 7) {
			return true;
		} else {
			return false;
		}
	}
	
	//买家评价
	function buyfeel($uid, $oid, $shopfeel, $profeel, $comment) {
		$this->db->where('uid', $uid);
		$this->db->select('username, nickname');
		$userinfo = $this->db->get($this->_po_user)->row_array();
		$this->db->where('oid', $oid);
		$this->db->select('pid, saleuid');
		$order = $this->db->get($this->_po_order)->row_array();
		date_default_timezone_set('PRC');
		$now = date('Y-m-d H:i:s');
		$data = array(
		'uid' => $uid,
		'username' => $userinfo['username'],
		'nickname' => $userinfo['nickname'],
		'pid' => $order['pid'],
		'comment' => $comment,
		'time' => $now
		);
		$this->db->insert($this->_po_comment, $data);
		unset($data);
		$data['feel'] = $profeel;
		$this->db->where('oid', $oid);
		$this->db->update($this->_po_order, $data);
		unset($data);
		$this->db->where('uid', $order['saleuid']);
		$this->db->select('sale_good, sale_neutral, sale_bad');
		$seller = $this->db->get($this->_po_user)->row_array();
		switch ($shopfeel) {
			case 1:
				$data['sale_good'] = $seller['sale_good'] + 1;
				break;
			case 2:
				$data['sale_neutral'] = $seller['sale_neutral'] + 1;
				break;
			case 3:
				$data['sale_bad'] = $seller['sale_bad'] + 1;
				break;
			default:
				break;
		}
		$this->db->where('uid', $order['saleuid']);
		$this->db->update($this->_po_user, $data);
		unset($data);
		return true;
	}
	
	//检查卖家是否已经评价
	function checkifmark($oid) {
		$this->db->where('oid', $oid);
		$this->db->select('status, mark');
		$query = $this->db->get($this->_po_order)->row_array();
		if (empty($query['mark']) && $query['status'] == 7) {
			return true;
		} elseif ($query['mark'] == 1) {
			return false;
		}
	}
	
	//卖家评价
	function sellfeel($uid, $oid, $feel) {
		$this->db->where('oid', $oid);
		$this->db->select('buyuid');
		$order = $this->db->get($this->_po_order)->row_array();
		$data['mark'] = 1;
		$this->db->where('oid', $oid);
		$this->db->update($this->_po_order, $data);
		unset($data);
		$this->db->where('uid', $order['buyuid']);
		$this->db->select('buy_good, buy_neutral, buy_bad');
		$buyer = $this->db->get($this->_po_user)->row_array();
		switch ($feel) {
			case 1:
				$data['buy_good'] = $buyer['buy_good'] + 1;
				break;
			case 2:
				$data['buy_neutral'] = $buyer['buy_neutral'] + 1;
				break;
			case 3:
				$data['buy_bad'] = $buyer['buy_bad'] + 1;
				break;
			default:
				break;
		}
		$this->db->where('uid', $order['buyuid']);
		$this->db->update($this->_po_user, $data);
		unset($data);
		return true;
	}
	
}
?>