<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<link href="<?php echo base_url(); ?>css/reg.css" type="text/css" rel="stylesheet">
	<link href="<?php echo base_url(); ?>css/main.css" type="text/css" rel="stylesheet">
	<script type="text/javascript" src="<?php echo base_url(); ?>js/reg.js"></script>
	<script type="text/javascript" src="<?php echo base_url(); ?>js/jquery-1.7.2.min.js"></script>
	<title>用户注册 - findpo</title>
</head>
<body>
<?php
include('banner.php');
?>

<div id="page">
	<div id="reg">
		<?php echo form_open(base_url().'reg'); ?>
			<div class="contain">
				<div class="field">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;帐号
				</div>
				<div class="write"><input type="text" class="input" id="po_username" name="po_username" value="<?php echo set_value('po_username');?>" placeholder="请输入4-16位字母或数字" size="25" />
				</div>
			</div>
			<div class="conerror">
				<?php if (!empty($userexist)) {
					?><div class="error"><?php echo $userexist; ?></div>
				<?php } ?>
				<?php echo form_error('po_username','<div class="error">','</div>'); ?>
			</div>
			<div class="contain">
				<div class="field">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;密码
				</div>
				<div class="write"><input type="password" class="input" id="po_password" name="po_password" placeholder="请输入6-16位密码" size="25" />
				</div>
			</div>
			<div class="conerror">
				<?php echo form_error('po_password','<div class="error">','</div>'); ?>
			</div>
			<div class="contain">
				<div class="field">确认密码
				</div>
				<div class="write"><input type="password" class="input" id="conpassword" name="conpassword" placeholder="请确认密码" size="25" />
				</div>
			</div>
			<div class="conerror">
				<?php echo form_error('conpassword','<div class="error">','</div>'); ?>
			</div>
			<div class="contain">
				<div class="field">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;邮箱
				</div>
				<div class="write"><input type="text" class="input" id="email" name="email" value="<?php echo set_value('email');?>" placeholder="请输入有效邮箱" size="25" />
				</div>
			</div>
			<div class="conerror">
				<?php if (!empty($emailexist)) {
					?><div class="error"><?php echo $emailexist; ?></div>
				<?php } ?>
				<?php echo form_error('email','<div class="error">','</div>'); ?>
			</div>
		
			
			<div>
				<input type="submit" class="button" value="注册" />
				<input type="button" class="button" value="重置" onclick="reSet('po_username','po_password','conpassword','email');" />
			</div>
		</form>
	</div>
</div>
<?php
include('foot.php');
?>
</body>
</html>