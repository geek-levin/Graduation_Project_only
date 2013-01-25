<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<link href="<?php echo base_url(); ?>css/admin.css" type="text/css" rel="stylesheet">
	<link href="<?php echo base_url(); ?>css/i.css" type="text/css" rel="stylesheet">
	<link href="<?php echo base_url(); ?>css/main.css" type="text/css" rel="stylesheet" />
	<script type="text/javascript" src="<?php echo base_url(); ?>js/jquery-1.7.2.min.js"></script>
	<title>后台管理 - findpo</title>
</head>
<body>
<?php
include('banner.php');
?>
<div id="page">
	<div id="logininfo">
		<ul>
			<li>欢迎，<font color="#4169E1">
<?php
echo $realname;
?>
			</font></li>
			<li>&nbsp;&nbsp;&nbsp;&nbsp;最后登陆：<font color="#999999">
<?php
echo $lastlogin;
?>
			</font></li>
			<li>&nbsp;&nbsp;&nbsp;&nbsp;登录次数：<font color="#222222">
<?php
echo $login_count;
?>
			</font></li>
		</ul>
	</div>
	<div id="left">
		<div id="banner">
			<a href="<?php echo base_url(); ?>admin/portal" target="rightiframe">管理中心
			</a>
		</div>
		<div class="menu banner menu_top">店铺管理
		</div>
		<div class="menu">
			<a href="<?php echo base_url(); ?>admin/getcert" target="rightiframe">开店认证
			</a>
		</div>
		<div class="menu">
			<a href="#">店铺管理
			</a>
		</div>
		<div class="menu banner">商品管理
		</div>
		<div class="menu">
			<a href="#">商品管理
			</a>
		</div>
		<div class="menu">
			<a href="#">分类信息
			</a>
		</div>
		<div class="menu banner">用户管理
		</div>
		<div class="menu">
			<a href="#">用户管理
			</a>
		</div>
		<div class="menu">
			<a href="#">评论管理
			</a>
		</div>
		<div class="menu">
			<a href="#">二手信息
			</a>
		</div>
		<div class="menu banner">网站管理
		</div>
		<div class="menu">
			<a href="#">信息设置
			</a>
		</div>
		<div class="menu">
			<a href="#">图片管理
			</a>
		</div>
		
		<div class="menu banner">帐号管理
		</div>
		<div class="menu">
			<a href="#">个人信息
			</a>
		</div>
		
		<div class="menu menu_bottom">
			<a href="#">密码管理
			</a>
		</div>
	</div>

	<div id="right">
		<iframe name="rightiframe" id="rightiframe" scrolling="no" frameborder="0" width="826px" marginheight="0px" marginwidth="0px" src="
<?php
if (!empty($app)) {
	switch ($app) {
		case 1:
			echo base_url().'i/portal';
			break;
		case 2:
			echo base_url().'i/cart';
			break;
		case 3:
			echo base_url().'i/pfav';
			break;
		case 4:
			echo base_url().'i/charge';
			break;
		default:
			echo base_url().'admin/portal';
			break;
	}
} else {
	echo base_url().'admin/portal';
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