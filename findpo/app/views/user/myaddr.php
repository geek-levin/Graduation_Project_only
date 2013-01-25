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
	<h3>我的收货地址</h3>
</div>
<div id="con_addr">
<table id="view_addr">
	<tr>
		<th id="addr_consig">收货人
		</th>
		<th id="addr_detail">详细地址
		</th>
		<th id="addr_phone">电话/手机
		</th>
		<th id="addr_act">操作
		</th>
	</tr>
<?php
if (empty($address['consignee_one']) and empty($address['consignee_two']) and empty($address['consignee_three'])) {
	echo '<tr><td colspan="4" id="no_addr">您还未保存收货地址</td></tr>';
} else {
	if (!empty($address['consignee_one'])) {
?>
<script type="text/javascript">
$(document).ready(function(){
	$("#deleteaddr1").click(function(){
		$.ajax({
			type: "post",
			data: "deleteaddr=1",
			url: "<?php echo base_url(); ?>ajax/deleteaddr",
			success: function(data) {
				if (data != 0) {
					$("#delete1").css({"display":"none"});
				}
			},
			error: function() {
				/*alert("ajax error");*/
			}
		});
	});
});
</script>
	<tr id="delete1">
		<td><?php echo $address['consignee_one']; ?>
		</td>
		<td><?php echo $address['college_one'].', '.$address['address_one'].', '.$address['zipcode_one']; ?>
		</td>
		<td><?php echo $address['phone_one']; ?>
		</td>
		<td>
			<a href="javascript:void(0);" id="deleteaddr1">删除
			</a>
		</td>
	</tr>
<?php
	}
	if (!empty($address['consignee_two'])) {
?>
<script type="text/javascript">
$(document).ready(function(){
	$("#deleteaddr2").click(function(){
		$.ajax({
			type: "post",
			data: "deleteaddr=2",
			url: "<?php echo base_url(); ?>ajax/deleteaddr",
			success: function(data) {
				if (data != 0) {
					$("#delete2").css({"display":"none"});
				}
			},
			error: function() {
				/*alert("ajax error");*/
			}
		});
	});
});
</script>
	<tr id="delete2">
		<td><?php echo $address['consignee_two']; ?>
		</td>
		<td><?php echo $address['college_two'].', '.$address['address_two'].', '.$address['zipcode_two']; ?>
		</td>
		<td><?php echo $address['phone_two']; ?>
		</td>
		<td>
			<a href="javascript:void(0);" id="deleteaddr2">删除
			</a>
		</td>
	</tr>
<?php
	}
	if (!empty($address['consignee_three'])) {
?>
<script type="text/javascript">
$(document).ready(function(){
	$("#deleteaddr3").click(function(){
		$.ajax({
			type: "post",
			data: "deleteaddr=3",
			url: "<?php echo base_url(); ?>ajax/deleteaddr",
			success: function(data) {
				if (data != 0) {
					$("#delete3").css({"display":"none"});
				}
			},
			error: function() {
				/*alert("ajax error");*/
			}
		});
	});
});
</script>
	<tr id="delete3">
		<td><?php echo $address['consignee_three']; ?>
		</td>
		<td><?php echo $address['college_three'].', '.$address['address_three'].', '.$address['zipcode_three']; ?>
		</td>
		<td><?php echo $address['phone_three']; ?>
		</td>
		<td>
			<a href="javascript:void(0);" id="deleteaddr3">删除
			</a>
		</td>
	</tr>
<?php
	}
}
?>

</table>
</div>

<?php
if (empty($address['consignee_one']) or empty($address['consignee_two']) or empty($address['consignee_three'])) {
?>

<div class="form">
<?php echo form_open(base_url().'i/address'); ?>
	<div class="contain">
		<div class="field">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;收货人
		</div>
		<div class="write"><input type="text" class="input" id="consignee" name="consignee" value="<?php echo set_value('consignee');?>" placeholder="请输入收货人名字" size="25" />
		</div>
	</div>
	<div class="conerror">
		<?php echo form_error('consignee','<div class="error">','</div>'); ?>
	</div>
	<div class="contain">
		<div class="field">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;学校
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
		<div class="field">&nbsp;&nbsp;&nbsp;&nbsp;详细地址
		</div>
		<div class="write"><input type="text" class="input" id="address" name="address" value="<?php echo set_value('address');?>" placeholder="请输入详细地址" size="25" />
		</div>
	</div>
	<div class="conerror">
		<?php echo form_error('address','<div class="error">','</div>'); ?>
	</div>
	<div class="contain">
		<div class="field">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;邮编
		</div>
		<div class="write"><input type="text" class="input" id="zipcode" name="zipcode" value="<?php echo set_value('zipcode');?>" placeholder="请输入邮编" size="25" />
		</div>
	</div>
	<div class="conerror">
		<?php echo form_error('zipcode','<div class="error">','</div>'); ?>
	</div>
	<div class="contain">
		<div class="field">手机或电话
		</div>
		<div class="write"><input type="text" class="input" id="phone" name="phone" value="<?php echo set_value('phone');?>" placeholder="请输入手机或电话" size="25" />
		</div>
	</div>
	<div class="conerror">
		<?php if (!empty($error)) {
			?><div class="error"><?php echo $error; ?></div>
		<?php } ?>
		<?php echo form_error('phone','<div class="error">','</div>'); ?>
	</div>
	<br />
	
	<div>
		<input type="submit" class="button" value="添加" />
		<input type="button" class="button" value="重置" onclick="reSet_address('consignee','college','address','zipcode','phone');" />
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