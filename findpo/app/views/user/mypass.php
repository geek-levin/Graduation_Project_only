<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<link href="<?php echo base_url(); ?>css/i.css" type="text/css" rel="stylesheet">
	<link href="<?php echo base_url(); ?>css/main.css" type="text/css" rel="stylesheet">
	<script type="text/javascript" src="<?php echo base_url(); ?>js/i.js"></script>
	<title>个人中心 - findpo</title>
</head>
<body>
	<div class="view_banner"><h3>修改密码</h3>
	</div>
	<div class="form">
		<?php echo form_open(base_url().'i/password'); ?>
		
			<div class="contain">
				<div class="field">&nbsp;&nbsp;&nbsp;&nbsp;初始密码
				</div>
				<div class="write"><input type="password" class="input" id="po_password" name="po_password" placeholder="在此输入当前密码" size="25" />
				</div>
			</div>
			<div class="conerror">
				<?php echo form_error('po_password','<div class="error">','</div>'); ?>
			</div>
			
			<div class="contain">
				<div class="field">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;新密码
				</div>
				<div class="write"><input type="password" class="input" id="newpassword" name="newpassword" placeholder="在此输入新密码" size="25" />
				</div>
			</div>
			<div class="conerror">
				<?php echo form_error('newpassword','<div class="error">','</div>'); ?>
			</div>
			
			<div class="contain">
				<div class="field">确认新密码
				</div>
				<div class="write"><input type="password" class="input" id="conpassword" name="conpassword" placeholder="在此再次输入新密码" size="25" />
				</div>
			</div>
			<div class="conerror">
				<?php if (!empty($error)) {
					?><div class="error"><?php echo $error; ?></div>
				<?php } ?>
				<?php echo form_error('conpassword','<div class="error">','</div>'); ?>
			</div>
			<br />
			
			<div>
				<input type="submit" value="确定" class="button" />&nbsp;&nbsp;&nbsp;
				<input type="button" value="重置" class="button" onclick="reSet('po_password','newpassword','conpassword');" />
			</div>
			
		</form>
	</div>

</body>
</html>