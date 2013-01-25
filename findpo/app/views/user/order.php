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
	<h3>确认订单</h3>
</div>

<div class="con_fav">
<?php
if (!empty($error)) {
	echo '<p style="padding: 20px;">'.$error.'</p>';
} else {
?>
	<div class="view_banner">
	<h3>商品信息</h3>
	</div>
	<table class="view_fav">
<?php
$n = 0;
$total = 0;
foreach ($cartinfo as $v) {
	if (!preg_match('/^[0-9]+$/', $v) && !empty($v)) {
		$cart = explode('*', $v);
		$total += $cart[1]*$cart[2] + $cart[3];
		echo '<tr class="carttr pfavtr pfavtr'.$n.'"><input type="hidden" value="'.$cart[0].'" /><td><div class="favimg"><a target="_blank" href="'.base_url().'item?pid='.$cart[0].'"><img class="img'.$n.'" src="" /></a></div></td><td class="carttd1"></td><td class="carttd2"></td><td class="carttd3"><b style="color: #ff0000;">￥'.$cart[1]*$cart[2].'</b></td><td class="carttd5">数量：'.$cart[2].'</td><td>运费：'.$cart[3].'元</td></tr>';
?>
<script type="text/javascript">
$(document).ready(function() {
	$.ajax({
		type: "get",
		data: "pid=" + "<?php echo $cart[0]; ?>",
		url: "<?php echo base_url(); ?>ajax/getpinfo",
		success: function(data) {
			var pinfo = eval("(" + data + ")");
			var wot = getwot(pinfo);
			$(".img<?php echo $n; ?>").attr("src", "<?php echo base_url().'images/user/proview/'; ?>" + pinfo.image_one);
			$(".pfavtr<?php echo $n; ?>>td:eq(1)").html("<a target='_blank' style='display:block;' href='<?php echo base_url().'item?pid='.$cart[0]; ?>'>" + pinfo.title + "</a><p>交易范围：" + pinfo.ex_range + "</p><p>" + wot + "</p>");
			$(".pfavtr<?php echo $n; ?>>td:eq(2)").text(pinfo.new_old + "成新");
		},
		error: function() {
			/*alert("ajax error");*/
		}
	});
});
</script>
<?php
$n++;
}
}
?>
	</table>
	<div class="view_banner">
	<h3>确认收货地址</h3>
	</div>
<?php
if (empty($address['consignee_one']) and empty($address['consignee_two']) and empty($address['consignee_three'])) {
	echo '您还未保存任何收货地址，'.'<a href="'.base_url().'i/address">点此先保存收货地址</a>';
} else {
?>
		<table id="view_addr">
			<tr>
				<td id="addr_select">选择
				</td>
				<th id="addr_consig">收货人
				</th>
				<th id="addr_detail">详细地址
				</th>
				<th id="addr_phone">电话/手机
				</th>
			</tr>
<?php
if (!empty($address['consignee_one'])) {
?>
			<tr>
				<td><input type="radio" name="addselect" value="1" />
				</td>
				<td><?php echo $address['consignee_one']; ?>
				</td>
				<td><?php echo $address['college_one'].', '.$address['address_one'].', '.$address['zipcode_one']; ?>
				</td>
				<td><?php echo $address['phone_one']; ?>
				</td>
			</tr>
<?php
}
if (!empty($address['consignee_two'])) {
?>
			<tr>
				<td><input type="radio" name="addselect" value="2" />
				</td>
				<td><?php echo $address['consignee_two']; ?>
				</td>
				<td><?php echo $address['college_two'].', '.$address['address_two'].', '.$address['zipcode_two']; ?>
				</td>
				<td><?php echo $address['phone_two']; ?>
				</td>
			</tr>
<?php
}
if (!empty($address['consignee_three'])) {
?>
			<tr>
				<td><input type="radio" name="addselect" value="3" />
				</td>
				<td><?php echo $address['consignee_three']; ?>
				</td>
				<td><?php echo $address['college_three'].', '.$address['address_three'].', '.$address['zipcode_three']; ?>
				</td>
				<td><?php echo $address['phone_three']; ?>
				</td>
			</tr>
<?php
}
?>
		</table>
<?php
}
}
?>
</div>
<div id="gotopay">
</div>
<div id="backtocart">
	<a href="javascript:void(0);">返回购物车
	</a>
</div>
<script type="text/javascript">
$(document).ready(function(){
	$("#backtocart>a").click(function(){
		window.location.href = "<?php echo base_url().'i/cart'; ?>";
	});
});
$(document).ready(function(){
	$("#gotopay").click(function(){
		var radios = document.getElementsByName("addselect");
		var select = $(radios + "[checked]").val();
		if (/^[1-3]{1}$/.exec(select)) {
			$.ajax({
				type: "post",
				data: "addselect=" + select,
				url: "<?php echo base_url(); ?>ajax/getadd",
				success: function(data) {
					if (data == 1) {
						window.location.href = "<?php echo base_url().'i/ordertopay'; ?>";
					} else {
						if (data == 2) {
							$("#infowindow").text("请在我的订单中查看您的订单");
							$("#infowindow").fadeTo("fast", 1, function(){
								$(this).fadeTo(3000, 0);
							});
						}
					}
				},
				error: function() {
					/*alert("ajax error");*/
				}
			});
		} else {
			$("#infowindow").text("请选择收货地址");
			$("#infowindow").fadeTo("fast", 1, function(){
				$(this).fadeTo(3000, 0);
			});
		}
	});
});
</script>
<div id="total">
	<p>
<?php
echo '共计：'.$total.'元（含运费）';
?>
	</p>
</div>
<div id="infowindow"></div>
<div id="clearboth">
</div>
</body>
</html>