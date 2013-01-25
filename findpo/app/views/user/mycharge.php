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
	#infowindow {
		top: 100px;
	}
	</style>
</head>
<body>
<div class="view_banner">
	<h3>账户充值</h3>
</div>

<div class="con_fav">
	<p>目前账户余额：<b id="balance"><?php echo $balance; ?></b>&nbsp;元
	</p>
	<br />
	<p>请输入充值金额：
	</p>
	<br />
	<input type="text" id="charge" maxlength="9" value="" size="50" />&nbsp;元
	<br />
	<br />
	<input class="button" type="button" id="confirm" value="提交" />
</div>

<script type="text/javascript">
$(document).ready(function(){
	$("#confirm").click(function(){
		var charge = $("#charge").val();
		$.ajax({
			type: "post",
			data: "charge=" + charge,
			url: "<?php echo base_url(); ?>ajax/charge",
			success: function(data) {
				if (data.substr(0, 1) == "1") {
					$("#balance").text(data.substr(2));
					$("#infowindow").text("充值成功");
					$("#infowindow").fadeTo("fast", 1, function(){
						$(this).fadeTo(3000, 0);
					});
				} else {
					if (data.substr(0, 1) == "2") {
						$("#infowindow").text("充值金额达到上限");
						$("#infowindow").fadeTo("fast", 1, function(){
							$(this).fadeTo(3000, 0);
						});
					} else {
						if (data == 3) {
							$("#infowindow").text("请输入正确金额");
							$("#infowindow").fadeTo("fast", 1, function(){
								$(this).fadeTo(3000, 0);
							});
						}
					}
				}
			},
			error: function() {
				/*alert("ajax error");*/
			}
		});
	});
});
</script>
<div id="infowindow"></div>
<div id="clearboth">
</body>
</html>