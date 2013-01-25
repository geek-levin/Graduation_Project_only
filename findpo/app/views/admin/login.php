<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<link href="<?php echo base_url(); ?>css/login.css" type="text/css" rel="stylesheet">
	<link href="<?php echo base_url(); ?>css/main.css" type="text/css" rel="stylesheet">
	<title>后台登录 - findpo</title>
	<style type="text/css">
	h1 {
		font-family: '方正舒体';
		font-size: 45px;
	}
	</style>
</head>
<body>

<div id="page">
	<div id="adminlogin">
		<h1>后台管理登录
		</h1>
	</div>
	<div id="login">
		<?php echo form_open(base_url().'adminlogin'); ?>
		
			<div class="contain">
				<div class="field">帐号
				</div>
				<div class="write"><input type="text" class="input" id="username" name="username" value="<?php echo set_value('username');?>" placeholder="在此输入帐号" size="25" />
				</div>
			</div>
			<div class="conerror">
				<?php echo form_error('username','<div class="error">','</div>'); ?>
			</div>
			
			<div class="contain">
				<div class="field">密码
				</div>
				<div class="write"><input type="password" class="input" id="password" name="password" placeholder="在此输入密码" size="25" />
				</div>
			</div>
			<div class="conerror">
				<?php if (!empty($error)) {
					?><div class="error"><?php echo $error; ?></div>
				<?php } ?>
				<?php echo form_error('password','<div class="error">','</div>'); ?>
			</div>
			
			<div>
				<input type="submit" value="登录" class="button" />&nbsp;&nbsp;&nbsp;
				<input type="reset" value="重置" class="button" />
			</div>
			
		</form>
	</div>
</div>
<?php
include('foot.php');
?>
</body>
</html>