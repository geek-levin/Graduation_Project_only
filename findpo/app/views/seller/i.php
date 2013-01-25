<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<link href="<?php echo base_url(); ?>css/i.css" type="text/css" rel="stylesheet">
	<link href="<?php echo base_url(); ?>css/main.css" type="text/css" rel="stylesheet" />
	<script type="text/javascript" src="<?php echo base_url(); ?>js/i.js"></script>
	<script type="text/javascript" src="<?php echo base_url(); ?>js/jquery-1.7.2.min.js"></script>
	<title>卖家中心 - findpo</title>
</head>
<body>
<?php
include('banner.php');
?>
<div id="page">

	<div id="left">
		<div id="banner">
			<a href="<?php echo base_url(); ?>seller/portal" target="rightiframe">卖家中心
			</a>
		</div>
		<div class="menu banner menu_top">店铺管理
		</div>
<?php
if ($userinfo['usertype'] == 2 or $userinfo['usertype'] == 3) {
?>
		<div class="menu">
			<a href="<?php echo base_url(); ?>seller/shopinfo" target="rightiframe">店铺信息
			</a>
		</div>
<?php
} else {
?>
		<div class="menu">
			<a href="<?php echo base_url(); ?>seller/openshop" target="rightiframe">我要开店
			</a>
		</div>
<?php
}
?>
		<div class="menu banner">交易管理
		</div>
		<div class="menu">
			<a href="<?php echo base_url(); ?>seller/release" target="rightiframe">发布商品
			</a>
		</div>
		<div class="menu">
			<a href="<?php echo base_url(); ?>seller/product" target="rightiframe">我的商品
			</a>
		</div>
		<div class="menu">
			<a href="<?php echo base_url(); ?>seller/order" target="rightiframe">我的订单
			</a>
		</div>
		<div class="menu">
			<a href="#">评价查看
			</a>
		</div>
		<div class="menu banner">虚拟账户
		</div>
		<div class="menu">
			<a href="<?php echo base_url(); ?>i/charge" target="rightiframe">账户充值
			</a>
		</div>
		<div class="menu">
			<a href="#">账户提现
			</a>
		</div>
		<div class="menu">
			<a href="<?php echo base_url(); ?>i/trade" target="rightiframe">交易明细
			</a>
		</div>
		<div class="menu">
			<a href="<?php echo base_url(); ?>i/accpass" target="rightiframe">密码管理
			</a>
		</div>
		<div class="menu banner">帐号管理
		</div>
		<div class="menu">
			<a href="<?php echo base_url(); ?>seller/real" target="rightiframe">真实信息
			</a>
		</div>
		<div class="menu menu_bottom">
			<a href="<?php echo base_url(); ?>i/password" target="rightiframe">密码管理
			</a>
		</div>
	</div>

	<div id="right">
		<iframe name="rightiframe" id="rightiframe" scrolling="no" frameborder="0" width="826px" marginheight="0px" marginwidth="0px" src="
<?php
if (!empty($app)) {
	switch ($app) {
		case 1:
			echo base_url().'seller/portal';
			break;
		default:
			echo base_url().'seller/portal';
			break;
	}
} else {
	echo base_url().'seller/portal';
}
?>
		">
		</iframe>
		<script type="text/javascript">
			function reinitIframe() {
				var iframe = document.getElementById("rightiframe");
				try {
					var bHeight = iframe.contentWindow.document.body.scrollHeight;
					var dHeight = iframe.contentWindow.document.documentElement.scrollHeight;
<?php
if (preg_match('/WebKit/', $cookie['user_agent'])) {
	echo 'var bHeight = 0;';
} elseif (preg_match('/Firefox/', $cookie['user_agent'])) {
	echo 'var dHeight = 0;';
} else {}
?>
					var height = Math.max(bHeight, dHeight);
					iframe.height = height;
				}
				catch (ex) {
				}
			}
			window.setInterval("reinitIframe()", 100);
		</script>
	</div>
	
</div>
<?php
include('foot.php');
?>
</body>
</html>