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
	<h3>付款</h3>
</div>

<div class="con_fav">
<?php
if (!empty($error)) {
	echo '<p style="padding: 20px;">'.$error.'</p>';
} else {
?>

	<p>您共需支付
		<b style="color: #ff0000;"><?php echo $order['total']; ?>
		</b>元。
	</p>
	<br />
	<p>您的寻宝账户余额为
		<b id="balance"><?php echo $balance; ?>
		</b>元，
		<a href="javascript:void(0);">
			<b id="refresh">点此
			</b>
		</a>刷新
		<b>账户余额
		</b>，
		<a target="_blank" href="<?php echo base_url(); ?>i?app=4">
			<b>点此
			</b>
		</a>
		<b>充值账户
		</b>。
	</p>
	<br />
	<p>支付钱款由第三方寻宝保存，在货物到您手里之后才会支付到卖家账户里。
	</p>
	<div id="confirmpay">
	</div>

<?php
}
?>

</div>
<script type="text/javascript">
$(document).ready(function(){
	$("#refresh").click(function(){
		$.ajax({
			type: "post",
			url: "<?php echo base_url(); ?>ajax/getbalance",
			success: function(data) {
				$("#balance").text(data + " ");
			},
			error: function() {
				/*alert("ajax error");*/
			},
		});
	});
});
$(document).ready(function(){
	$("#confirmpay").click(function(){
		$.ajax({
			type: "post",
			url: "<?php echo base_url(); ?>ajax/confirmbalance",
			success: function(data) {
				if (data == 1) {
					$("#infowindow").text("付款成功");
					$("#infowindow").fadeTo("fast", 1, function(){
						$(this).fadeTo(3000, 0, function(){
							window.location.href = "<?php echo base_url().'i/orderpaysuccess'; ?>";
						});
					});
				} else {
					if (data == 2) {
						$("#infowindow").text("您的账户余额不足");
						$("#infowindow").fadeTo("fast", 1, function(){
							$(this).fadeTo(3000, 0);
						});
					}
				}
			},
			error: function() {
				/*alert("ajax error");*/
			},
		});
	});
});
</script>
<div id="infowindow"></div>
<div id="clearboth">
</div>
</body>
</html>