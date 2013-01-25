<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<link href="<?php echo base_url(); ?>css/i.css" type="text/css" rel="stylesheet">
	<link href="<?php echo base_url(); ?>css/main.css" type="text/css" rel="stylesheet" />
	<script type="text/javascript" src="<?php echo base_url(); ?>js/jquery-1.7.2.min.js"></script>
	<script type="text/javascript" src="<?php echo base_url(); ?>js/i.js"></script>
	<title>个人中心 - findpo</title>
	<style type="text/css">
	form > input:last-child {
		margin-left: 40px;
		background: -moz-linear-gradient(top, #F5F5F5, #F1F1F1);
		background: -webkit-linear-gradient(top, #F5F5F5, #F1F1F1);
		background: -o-linear-gradient(top, #F5F5F5, #F1F1F1);
		border: solid 1px rgba(0, 0, 0, 0.1);
		padding-left: 10px;
		padding-right: 10px;
		border-radius: 2px;
		-webkit-border-radius: 2px;
	}
	form > input:last-child:hover {
		background: -moz-linear-gradient(top, #F8F8F8, #F1F1F1);
		background: -webkit-linear-gradient(top, #F8F8F8, #F1F1F1);
		background: -o-linear-gradient(top, #F8F8F8, #F1F1F1);
		border: solid 1px #C6C6C6;
		box-shadow: 0 1px 1px rgba(0, 0, 0, 0.1);
	}
	</style>
</head>
<body>
<div class="view_banner">
	<h3>上传认证图片</h3>
</div>
<div class="con_fav">
<?php echo form_open_multipart('seller/uploadid');?>
<input type="file" name="userfile" size="20" />
<input type="submit" value="上传" />
</form>
<div style="padding: 20px; color: #FF0000;">
<?php
if (!empty($error)) {
	echo $error;
}
?>
</div>
<p>上传的认证图片大小不超过<b>1.5mb</b>，宽高不超过<b>1280*800</b>，格式为<b>jpg|gif|png</b>。
</p>
</div>

</body>
</html>