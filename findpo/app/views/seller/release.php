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
	.conerror {
		margin-left: 140px;
	}
	select {
	width: 110px;
	}
	</style>
</head>
<body>
<div class="view_banner">
	<h3>商品发布</h3>
</div>
<div class="wantedform">
	<?php echo form_open(base_url().'seller/release'); ?>
		<div class="contain">
			<div class="field"><?php echo nbs(24); ?>商品标题
			</div>
			<div class="write"><input type="text" class="input" id="title" name="title" value="<?php echo set_value('title');?>" placeholder="请输入商品标题" size="60" />
			</div>
		</div>
		<div class="conerror">
			<?php echo form_error('title','<div class="error">','</div>'); ?>
		</div>
		<div class="contain">
			<div class="field"><?php echo nbs(32); ?>价格
			</div>
			<div class="write"><input type="text" class="input" id="price" name="price" value="<?php echo set_value('price');?>" placeholder="请输入你的期望价格" size="60" />
			</div>
		</div>
		<div class="conerror">
			<?php echo form_error('price','<div class="error">','</div>'); ?>
		</div>
		<div class="contain">
			<div class="field"><?php echo nbs(28); ?>市场价
			</div>
			<div class="write"><input type="text" class="input" id="mprice" name="mprice" value="<?php echo set_value('mprice');?>" placeholder="请输入市场大概价格，此项可为空" size="60" />
			</div>
		</div>
		<div class="conerror">
			<?php echo form_error('mprice','<div class="error">','</div>'); ?>
		</div>
		<div class="contain">
			<div class="field"><?php echo nbs(24); ?>商品分类
			</div>
			<div class="write">
				<span>
					<select id="catid_one" name="catid_one">
					<option value="">请选择</option>
<?php
for ($i = 0; $i < count($cat_one); $i++) {
	echo '<option value="'.$cat_one[$i]['catid'].'">'.$cat_one[$i]['classname'].'</option>';
}
?>
					</select>
				</span>
				<span>
					<select id="catid_two" name="catid_two">
					<option value="">请选择</option>
					</select>
				</span>
				<span>
					<select id="catid_three" name="catid_three">
					<option value="">请选择</option>
					</select>
				</span>
			</div>
		</div>
		<div class="conerror">
			<?php echo form_error('catid_one','<div class="error">','</div>'); ?>
		</div>
		<div class="contain">
			<div class="field"><?php echo nbs(24); ?>新旧程度
			</div>
			<div class="write"><input type="text" class="input" id="new_old" name="new_old" value="<?php echo set_value('new_old');?>" placeholder="请输入1-10表示新旧程度" size="60" />
			</div>
		</div>
		<div class="conerror">
			<?php echo form_error('new_old','<div class="error">','</div>'); ?>
		</div>
		<div class="contain">
			<div class="field"><?php echo nbs(24); ?>商品数量
			</div>
			<div class="write"><input type="text" class="input" id="amount" name="amount" value="<?php echo set_value('amount');?>" placeholder="请输入商品数量" size="60" />
			</div>
		</div>
		<div class="conerror">
			<?php echo form_error('amount','<div class="error">','</div>'); ?>
		</div>
		<div class="contain">
			<div class="field"><?php echo nbs(24); ?>交易范围
			</div>
			<div class="write">
				<select id="ex_range" name="ex_range">
				<option value="">请选择</option>
<?php
if (!empty($setting)) {
	echo "<option value=".$setting['city'].">".$setting['city'].'</option>';
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
			<?php echo form_error('ex_range','<div class="error">','</div>'); ?>
		</div>
		<div class="contain">
			<div class="field"><?php echo nbs(32); ?>运费
			</div>
			<div class="write"><input type="text" class="input" id="cost" name="cost" value="<?php echo set_value('cost');?>" placeholder="请输入运费，为0可不填" size="60" />
			</div>
		</div>
		<div class="conerror">
			<?php echo form_error('cost','<div class="error">','</div>'); ?>
		</div>
		<div class="contain">
			<div class="field"><?php echo nbs(8); ?>支持的交易方式：
			</div>
			<div style="display: inline;">
				<span><input type="radio" name="wot" id="wot1" value="1" /><label for="wot1"><?php echo nbs(2); ?>支持当面交易</label></span>
				<span><input type="radio" name="wot" id="wot2" value="2" /><label for="wot2"><?php echo nbs(2); ?>支持货到付款</label></span>
				<span><input type="radio" name="wot" id="wot3" value="3" /><label for="wot3"><?php echo nbs(2); ?>支持当面交易和货到付款</label></span>
				<span><input type="radio" name="wot" id="wot4" value="4" /><label for="wot4"><?php echo nbs(2); ?>只支持线上交易</label></span>
			</div>
		</div>
		<div class="conerror">
			<?php echo form_error('wot','<div class="error">','</div>'); ?>
		</div>
		<div class="contain">
			<div class="field" style="float: left;"><?php echo nbs(24); ?>商品描述
			</div>
			<textarea id="detail" name="detail" placeholder="描述下你的商品吧" style="width: 520px; height: 170px;"></textarea>
		</div>
		<br />
		<br />
		<br />
		<br />
		<br />
		<br />
		<br />
		<br />
		<br />
		<br />
		<br />
		<div class="conerror">
			<?php if (!empty($error)) {
				?><div class="error"><?php echo $error; ?></div>
			<?php } ?>
			<?php echo form_error('detail','<div class="error">','</div>'); ?>
		</div>
		<br />
		<input type="checkbox" id="visible" name="visible" style="margin-left: 160px;" value="1"><label for="visible"><?php echo nbs(2); ?>先暂存，以后再发布</label>
		<br />
		<br />
		<div>
			<input type="submit" class="button" style="margin-left: 300px;" value="下一步，上传图片" />
			<input type="reset" class="button" value="重置" />
		</div>
	</form>
</div>
<script type="text/javascript">
$(document).ready(function(){
	$("#catid_one").change(function(){
		var catid = $(this).children("option:selected").val();
		$.ajax({
			type: "get",
			data: "catid=" + catid,
			url: "<?php echo base_url(); ?>ajax/getcatid",
			success: function(data) {
				if (data == "[]") {
					var cattext = "<option value=''>请选择</option><option value=''>无</option>";
					$("#catid_two").html(cattext);
				} else {
					var cat = eval("(" + data + ")");
					var cattext = "<option value=''>请选择</option>";
					for (var i in cat) {
						cattext += "<option value='" + cat[i].catid + "'>" + cat[i].classname + "</option>";
					}
					$("#catid_two").html(cattext);
				}
			},
			error: function() {
				/*alert("ajax error");*/
			},
		});
	});
});
$(document).ready(function(){
	$("#catid_two").change(function(){
		var catid = $(this).children("option:selected").val();
		$.ajax({
			type: "get",
			data: "catid=" + catid,
			url: "<?php echo base_url(); ?>ajax/getcatid",
			success: function(data) {
				if (data == "[]") {
					var cattext = "<option value=''>请选择</option><option value=''>无</option>";
					$("#catid_three").html(cattext);
				} else {
					var cat = eval("(" + data + ")");
					var cattext = "<option value=''>请选择</option>";
					for (var i in cat) {
						cattext += "<option value='" + cat[i].catid + "'>" + cat[i].classname + "</option>";
					}
					$("#catid_three").html(cattext);
				}
			},
			error: function() {
				/*alert("ajax error");*/
			},
		});
	});
});
</script>
</body>
</html>