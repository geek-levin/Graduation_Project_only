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
	p {
	padding: 10px 20px;
	}
	</style>
</head>
<body>

	<div class="view_banner">
		<h3>我的店铺信息</h3>
	</div>
	<p>
		<span>我的小店：
		</span>
		<span class="wantedli">
<?php
if (!empty($shopinfo['shop'])) {
	echo $shopinfo['shop'];
}
?>
		</span>
	</p>
	<p>
		<span>开店时间：
		</span>
		<span class="wantedli">
<?php
if (!empty($shopinfo['reg_date'])) {
	echo $shopinfo['reg_date'];
}
?>
		</span>
	</p>
	<p>
		<span>已经卖出的商品数量：
		</span>
		<span class="wantedli"><?php echo $shopinfo['sale_count']; ?>件
		</span>
	</p>
	<div class="view_banner">
		<h3>修改店铺信息</h3>
	</div>
	<div class="wantedform">
	<?php echo form_open(base_url().'seller/shopinfo'); ?>
		<div class="contain">
			<div class="field">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;商店名称
			</div>
			<div class="write"><input type="text" class="input" id="shop" name="shop" value="<?php if (!empty($shopinfo['shop'])) {echo $shopinfo['shop'];} ?>" size="50" />
			</div>
		</div>
		<div class="conerror">
			<?php echo form_error('shop','<div class="error">','</div>'); ?>
		</div>
		<div class="contain">
			<div class="field" style="float: left;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;商店公告
			</div>
			<textarea id="notice" name="notice"><?php if (!empty($shopinfo['notice'])) {echo $shopinfo['notice'];} ?></textarea>
		</div>
		<br />
		<br />
		<br />
		<br />
		<br />
		<br />
		<div class="conerror">
			<?php echo form_error('notice','<div class="error">','</div>'); ?>
		</div>
		<div class="contain">
			<div class="field" style="float: left;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;商店介绍
			</div>
			<textarea id="introduce" name="introduce" ><?php if (!empty($shopinfo['introduce'])) {echo $shopinfo['introduce'];} ?></textarea>
		</div>
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
			<?php echo form_error('introduce','<div class="error">','</div>'); ?>
		</div>
		<br />
		
		<div>
			<input type="submit" class="button" value="修改" />
			<input type="button" class="button" value="重置" onclick="reSet_shopinfo('shop', 'notice', 'introduce');" />
		</div>
	</form>
	</div>

</body>
</html>