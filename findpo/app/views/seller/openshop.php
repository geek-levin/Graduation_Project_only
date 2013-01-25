<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<link href="<?php echo base_url(); ?>css/i.css" type="text/css" rel="stylesheet">
	<link href="<?php echo base_url(); ?>css/main.css" type="text/css" rel="stylesheet">
	<script type="text/javascript" src="<?php echo base_url(); ?>js/i.js"></script>
	<script type="text/javascript" src="<?php echo base_url(); ?>js/jquery-1.7.2.min.js"></script>
	<title>个人中心 - findpo</title>
</head>
<body>
<div class="view_banner">
	<h3>填写开店信息</h3>
</div>

<?php
if (!empty($message)) {
	echo '<p style="padding: 20px;">'.$message.'</p>';
} else {
?>

<div class="form">
<?php echo form_open(base_url().'seller/openshop'); ?>
	<div class="contain">
		<div class="field">&nbsp;&nbsp;&nbsp;&nbsp;真实姓名
		</div>
		<div class="write"><input type="text" class="input" id="name" name="name" value="<?php echo set_value('name');?>" placeholder="请输入真实姓名" size="25" />
		</div>
	</div>
	<div class="conerror">
		<?php echo form_error('name','<div class="error">','</div>'); ?>
	</div>
	<div class="contain">
		<div class="field">学校或学院
		</div>
		<div class="write">
			<select id="college" name="college">
			<option value=""></option>
<?php
if (!empty($setting)) {
	$c = explode('*', $setting['college']);
	foreach ($c as $v) {
		echo "<option value=".$v.">".$v.'</option>';
	}
}
?>
			</select>
		</div>
	</div>
	<div class="conerror">
		<?php echo form_error('college','<div class="error">','</div>'); ?>
	</div>
	<div class="contain">
		<div class="field">身份证号码
		</div>
		<div class="write"><input type="text" class="input" id="idnumber" name="idnumber" value="<?php echo set_value('idnumber');?>" placeholder="请输入身份证号码" size="25" />
		</div>
	</div>
	<div class="conerror">
		<?php echo form_error('idnumber','<div class="error">','</div>'); ?>
	</div>
	<div class="contain">
		<div class="field">&nbsp;&nbsp;&nbsp;&nbsp;商店名称
		</div>
		<div class="write"><input type="text" class="input" id="shop" name="shop" value="<?php echo set_value('shop');?>" placeholder="请输入商店名称" size="25" />
		</div>
	</div>
	<div class="conerror">
		<?php if (!empty($error)) {
			?><div class="error"><?php echo $error; ?></div>
		<?php } ?>
		<?php echo form_error('shop','<div class="error">','</div>'); ?>
	</div>
	<br />
	
	<div>
		<input type="submit" class="button" value="确认" />
		<input type="button" class="button" value="重置" onclick="reSet_shopinfo('name', 'college', 'idnumber', 'shop');" />
	</div>
</form>
</div>

<?php
}
?>
<script>
document.getElementsByTagName("select")[0].value="<?php echo set_value('college'); ?>";
</script>
</body>
</html>