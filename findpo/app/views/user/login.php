<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<link href="<?php echo base_url(); ?>css/login.css" type="text/css" rel="stylesheet">
	<link href="<?php echo base_url(); ?>css/main.css" type="text/css" rel="stylesheet">
	<script type="text/javascript" src="<?php echo base_url(); ?>js/login.js"></script>
	<script type="text/javascript" src="<?php echo base_url(); ?>js/jquery-1.7.2.min.js"></script>
	<title>用户登录 - findpo</title>
</head>
<body>
<?php
include('banner.php');
?>

<div id="page">
	<div id="img">
	</div>
	<div id="login">
		<?php echo form_open(base_url().'login'); ?>
		
			<div class="contain">
				<div class="field">帐号
				</div>
				<div class="write"><input type="text" class="input" id="po_username" name="po_username" value="<?php echo set_value('po_username');?>" placeholder="在此输入帐号" size="25" />
				</div>
			</div>
			<div class="conerror">
				<?php echo form_error('po_username','<div class="error">','</div>'); ?>
			</div>
			
			<div class="contain">
				<div class="field">密码
				</div>
				<div class="write"><input type="password" class="input" id="po_password" name="po_password" placeholder="在此输入密码" size="25" />
				</div>
			</div>
			<div class="conerror">
				<?php if (!empty($error)) {
					?><div class="error"><?php echo $error; ?></div>
				<?php } ?>
				<?php echo form_error('po_password','<div class="error">','</div>'); ?>
			</div>
			
			<div>
				<input type="submit" value="登录" class="button" />&nbsp;&nbsp;&nbsp;
				<input type="button" value="重置" class="button" onclick="reSet('po_username','po_password');" />
			</div>
			
		</form>
	</div>
</div>
<?php
include('foot.php');
?>
</body>
</html>