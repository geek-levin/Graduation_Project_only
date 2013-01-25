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
	<h3>我的购物车</h3>
</div>

<div class="con_fav">
<?php
if (!empty($error)) {
	echo '<p style="padding: 20px;">'.$error.'</p>';
} else {
?>
	<table class="view_fav">
<?php
$n = 0;
foreach ($cartinfo as $v) {
	if (!preg_match('/^[0-9]+$/', $v) && !empty($v)) {
		$cart = explode('*', $v);
		echo '<tr class="carttr pfavtr pfavtr'.$n.'"><input type="hidden" value="'.$cart[0].'" /><td><div class="favimg"><a target="_blank" href="'.base_url().'item?pid='.$cart[0].'"><img class="img'.$n.'" src="" /></a></div></td><td class="carttd1"></td><td class="carttd2"></td><td class="carttd3"><b style="color: #ff0000;">￥'.$cart[1]*$cart[2].'</b></td><td class="carttd5"><img src="'.base_url().'images/site/minus.png" style="height: 8px;" class="cartminus" id="cartminus'.$n.'" />&nbsp;&nbsp;<input type="text" class="cartcount" id="cartcount'.$n.'" size="2" maxlength="4" value="'.$cart[2].'" />&nbsp;&nbsp;<img src="'.base_url().'images/site/plus.png" style="height: 8px;" class="cartplus" id="cartplus'.$n.'" /></td><td class="carttd6"><a title="删除此商品" href="javascript:void(0);"><b>X</b></a></td></tr>';
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
$(document).ready(function(){
	$("#cartplus<?php echo $n; ?>").click(function(){
		$.ajax({
			type: "get",
			data: "pid=" + "<?php echo $cart[0]; ?>",
			url: "<?php echo base_url(); ?>ajax/getpinfo",
			success: function(data) {
				var pinfo = eval("(" + data + ")");
				var cartcount = $("#cartcount<?php echo $n; ?>").val();
				cartcount = parseInt(cartcount);
				cartcount += 1;
				if (/^[0-9]+$/.exec(cartcount) != null) {
					if (cartcount > pinfo.amount) {
						$("#infowindow").text("该商品库存不足");
						$("#infowindow").fadeTo("fast", 1, function(){
							$(this).fadeTo(3000, 0);
						});
					} else {
						var cartprice = pinfo.price;
						cartprice = cartprice*cartcount;
						$("#cartcount<?php echo $n; ?>").val(cartcount);
						$(".pfavtr<?php echo $n; ?>>td:eq(3)").html("<b style='color: #ff0000;'>￥" + cartprice + "</b>");
					}
				} else {
					$("#infowindow").text("请正确输入商品数量");
					$("#infowindow").fadeTo("fast", 1, function(){
						$(this).fadeTo(3000, 0);
					});
				}
			},
			error: function() {
				/*alert("ajax error");*/
			}
		});
	});
});
$(document).ready(function(){
	$("#cartminus<?php echo $n; ?>").click(function(){
		$.ajax({
			type: "get",
			data: "pid=" + "<?php echo $cart[0]; ?>",
			url: "<?php echo base_url(); ?>ajax/getpinfo",
			success: function(data) {
				var pinfo = eval("(" + data + ")");
				var cartcount = $("#cartcount<?php echo $n; ?>").val();
				cartcount = parseInt(cartcount);
				cartcount -= 1;
				if (/^[0-9]+$/.exec(cartcount) != null) {
					if (cartcount < 1) {
						$("#infowindow").text("商品数量不能为0");
						$("#infowindow").fadeTo("fast", 1, function(){
							$(this).fadeTo(3000, 0);
						});
					} else {
						var cartprice = pinfo.price;
						cartprice = cartprice*cartcount;
						$("#cartcount<?php echo $n; ?>").val(cartcount);
						$(".pfavtr<?php echo $n; ?>>td:eq(3)").html("<b style='color: #ff0000;'>￥" + cartprice + "</b>");
					}
				} else {
					$("#infowindow").text("请正确输入商品数量");
					$("#infowindow").fadeTo("fast", 1, function(){
						$(this).fadeTo(3000, 0);
					});
				}
			},
			error: function() {
				/*alert("ajax error");*/
			}
		});
	});
});
$(document).ready(function(){
	$("#cartcount<?php echo $n; ?>").keyup(function(){
		$.ajax({
			type: "get",
			data: "pid=" + "<?php echo $cart[0]; ?>",
			url: "<?php echo base_url(); ?>ajax/getpinfo",
			success: function(data) {
				var pinfo = eval("(" + data + ")");
				var cartcount = $("#cartcount<?php echo $n; ?>").val();
				cartcount = parseInt(cartcount);
				if (/^[0-9]+$/.exec(cartcount) != null) {
					if (cartcount < 1) {
						$("#infowindow").text("商品数量不能为0或空");
						$("#infowindow").fadeTo("fast", 1, function(){
							$(this).fadeTo(3000, 0);
						});
					} else {
						if (cartcount > pinfo.amount) {
							$("#infowindow").text("该商品库存不足");
							$("#infowindow").fadeTo("fast", 1, function(){
								$(this).fadeTo(3000, 0);
							});
						} else {
							var cartprice = pinfo.price;
							cartprice = cartprice*cartcount;
							$(".pfavtr<?php echo $n; ?>>td:eq(3)").html("<b style='color: #ff0000;'>￥" + cartprice + "</b>");
						}
					}
				} else {
					$("#infowindow").text("请正确输入商品数量");
					$("#infowindow").fadeTo("fast", 1, function(){
						$(this).fadeTo(3000, 0);
					});
				}
			},
			error: function() {
				/*alert("ajax error");*/
			}
		});
	});
});
$(document).ready(function(){
	$(".pfavtr<?php echo $n; ?>>td:eq(5)>a").click(function(){
		$.ajax({
			type: "post",
			data: "deletecart=" + "<?php echo $cart[0]; ?>",
			url: "<?php echo base_url(); ?>ajax/deletecart",
			success: function(data) {
				if (data == 1) {
					$(".pfavtr:eq(<?php echo $n; ?>)").fadeTo(2000, 0, function(){
						$(".pfavtr:eq(<?php echo $n; ?>)").remove();
					});
				}
			},
			error: function() {
				/*alert("ajax error");*/
			}
		});
	});
});
</script>
<?php
$n++;
}
}
?>
	</table>
<?php
}
?>
</div>
<div id="gotoorder">
</div>
<script type="text/javascript">
$(document).ready(function(){
	$("#gotoorder").click(function(){
		var cartcount = $("input").size();
		var cart = "";
		for (var i = 0; i < cartcount; i += 2) {
			var pid = $("input:eq(" + i + ")").val();
			var amount = $("input:eq(" + (i+1) + ")").val();
			pid = parseInt(pid);
			amount = parseInt(amount);
			if ((/^[0-9]+$/.exec(amount) != null) && (/^[0-9]+$/.exec(pid) != null)) {
				if (i == (cartcount-2)) {
					cart = cart + pid + "t" +amount;
				} else {
					cart = cart + pid + "t" +amount + "*";
				}
			}
		}
		$.ajax({
			type: "post",
			data: "cart=" + cart,
			url: "<?php echo base_url(); ?>ajax/gotoorder",
			success: function(data) {
				if (data == 4) {
					window.location.href = "<?php echo base_url().'i/order'; ?>";
				} else {
					if (data ==2) {
						$("#infowindow").text("请正确输入商品数量");
						$("#infowindow").fadeTo("fast", 1, function(){
							$(this).fadeTo(3000, 0);
						});
					} else {
						if (data == 3) {
							$("#infowindow").text("该店铺不存在");
							$("#infowindow").fadeTo("fast", 1, function(){
								$(this).fadeTo(3000, 0);
							});
						} else {
							$("#infowindow").text("商品已下架或正在编辑");
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
window.setInterval("check()", 100);
</script>
<div id="infowindow"></div>
<div id="clearboth"></div>
</body>
</html>