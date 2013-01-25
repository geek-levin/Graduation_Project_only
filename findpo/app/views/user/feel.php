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
	<h3>评价商品</h3>
</div>
<div class="con_fav">
	<?php echo form_open(base_url().'i/feel'); ?>
		<input type="hidden" name="oid" value="
<?php
if (!empty($oid)) {
	echo $oid;
} else {
	echo set_value('oid');
}
?>
" />
		<div class="contain">
			<div class="field"><?php echo nbs(8); ?>对卖家的评价：
			</div>
			<div style="display: inline;">
				<span><input type="radio" name="shopfeel" id="shopfeel1" value="1" /><label for="shopfeel1"><?php echo nbs(2); ?>好评</label></span><?php echo nbs(4); ?>
				<span><input type="radio" name="shopfeel" id="shopfeel2" value="2" /><label for="shopfeel2"><?php echo nbs(2); ?>中评</label></span><?php echo nbs(4); ?>
				<span><input type="radio" name="shopfeel" id="shopfeel3" value="3" /><label for="shopfeel3"><?php echo nbs(2); ?>差评</label></span>
			</div>
		</div>
		<div class="conerror">
			<?php echo form_error('shopfeel','<div class="error">','</div>'); ?>
		</div>
		<div class="contain">
			<div class="field"><?php echo nbs(8); ?>对商品的评价：
			</div>
			<div style="display: inline;">
				<span><input type="radio" name="profeel" id="profeel1" value="1" /><label for="profeel1"><?php echo nbs(2); ?>满意</label></span><?php echo nbs(4); ?>
				<span><input type="radio" name="profeel" id="profeel2" value="2" /><label for="profeel2"><?php echo nbs(2); ?>一般</label></span><?php echo nbs(4); ?>
				<span><input type="radio" name="profeel" id="profeel3" value="3" /><label for="profeel3"><?php echo nbs(2); ?>不满意</label></span>
			</div>
		</div>
		<div class="conerror">
			<?php echo form_error('profeel','<div class="error">','</div>'); ?>
		</div>
		<div class="contain">
			<div class="field" style="float: left;"><?php echo nbs(16); ?>商品评价：
			</div>
			<textarea id="comment" name="comment" placeholder="写些感受吧~" style="width: 520px; height: 170px;"></textarea>
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
			<?php echo form_error('comment','<div class="error">','</div>'); ?>
		</div>
		<div>
			<input type="submit" class="button" style="margin-left: 300px;" value="提交" />
			<input type="reset" class="button" value="重置" />
		</div>
	</form>
</div>
</body>
</html>