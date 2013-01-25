<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<link href="<?php echo base_url(); ?>css/i.css" type="text/css" rel="stylesheet">
	<link href="<?php echo base_url(); ?>css/main.css" type="text/css" rel="stylesheet" />
	<script type="text/javascript" src="<?php echo base_url(); ?>js/jquery-1.7.2.min.js"></script>
	<script type="text/javascript" src="<?php echo base_url(); ?>js/i.js"></script>
	<title>个人中心 - findpo</title>
</head>
<body>
<div class="view_banner">
	<h3>我的真实信息</h3>
</div>

<div class="conwanted">

	<p>
		<span>真实姓名：
		</span>
		<span class="wantedli">
<?php
if (!empty($real['name'])) {
	echo $real['name'];
}
?>
		</span>
	</p>
	<p>
		<span>所在学校：
		</span>
		<span class="wantedli">
<?php
if (!empty($real['college'])) {
	echo $real['college'];
}
?>
		</span>
	</p>
	<p>
		<span>身份证号码：
		</span>
		<span class="wantedli">
<?php
if (!empty($real['idnumber'])) {
	$id = substr($real['idnumber'], 0, 4).'**********';
	$id .= substr($real['idnumber'], -4, 4);
	echo $id;
}
?>
		</span>
	</p>

</div>

</body>
</html>