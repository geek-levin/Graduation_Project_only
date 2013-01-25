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
	th {
		color: #606060;
	}
	</style>
</head>
<body>
<div class="view_banner">
	<h3>我收到的订单</h3>
</div>

<div class="con_fav">

<?php
if (empty($orders)) {
	echo '<p style="padding: 20px;">您还没有订单，要加油哦~</p>';
}
else {
?>

	<table class="view_fav">
		<tr>
			<th colspan="2" style="width: 400px;">商品
			</th>
			<th style="width: 60px;">单价
			</th>
			<th style="width: 50px;">数量
			</th>
			<th style="width: 60px;">实付款
			</th>
			<th style="width: 100px;">交易状态
			</th>
			<th style="width: 100px;">操作
			</th>
			<th style="width: 90px;">时间
			</th>
		</tr>
<?php
$orders = array_reverse($orders);
$items = count($orders);
$pagecount = (int) ($items/10);
if (!preg_match('/^[0-9]+$/', ($items/10))) {
	$pagecount++;
}
if ($pagecount == $page) {
	$start = ($page-1)*10;
	$end = $items;
} elseif ($pagecount > $page) {
	$start = ($page-1)*10;
	$end = $start+10;
} elseif ($pagecount < $page) {
	$page = 1;
	$start = 0;
	$end = 10;
	if ($items < $end) {
		$end = $items;
	}
}
for ($i = $start; $i < $end; $i++) {
	switch ($orders[$i]['status']) {
		case 0:
			$orders[$i]['status'] = '等待买家付款';
			break;
		case 1:
			$orders[$i]['status'] = '当面交易中';
			break;
		case 2:
			$orders[$i]['status'] = '等待卖家发货';
			break;
		case 3:
			$orders[$i]['status'] = '卖家已发货';
			break;
		case 4:
			$orders[$i]['status'] = '买家已退货';
			break;
		case 5:
			$orders[$i]['status'] = '卖家已退款';
			break;
		case 6:
			$orders[$i]['status'] = '交易关闭';
			break;
		case 7:
			$orders[$i]['status'] = '交易成功';
			break;
		default:
			break;
	}
	echo '<tr class="ordertr"><td style="width: 100px;"><div class="favimg"><a target="_blank" href="';
	echo base_url().'item?pid='.$orders[$i]['pid'];
	echo '"><img id="img'.$i.'" src="" /></a></div></td><td><a target="_blank" href="';
	echo base_url().'item?pid='.$orders[$i]['pid'];
	echo '" id="a'.$i.'"></a></td><td id="pr'.$i.'"></td><td>';
	echo $orders[$i]['amount'];
	echo '</td><td><b>';
	echo $orders[$i]['price']*$orders[$i]['amount'];
	echo '</b></td><td id="status'.$i.'">';
	echo $orders[$i]['status'];
	echo '</td><td><a target="_blank" style="display: block;" href="';
	echo base_url().'order?oid='.$orders[$i]['oid'];
	echo '">订单详情</a>';
	if ($orders[$i]['status'] == '等待卖家发货') {
		echo '<a id="confship'.$i.'" style="display: block;" href="javascript:void(0);">';
		echo '确认发货';
		echo '</a>';
?>
<script type="text/javascript">
$(document).ready(function(){
	$("#confship<?php echo $i; ?>").click(function(){
		$.ajax({
			type: "post",
			data: "oid=" + "<?php echo $orders[$i]['oid']; ?>",
			url: "<?php echo base_url(); ?>ajax/confship",
			success: function(data) {
				if (data == 1) {
					$("#confship<?php echo $i; ?>").remove();
					$("#status<?php echo $i; ?>").text("卖家已发货");
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
	}
	if ($orders[$i]['status'] == '交易成功' && empty($orders[$i]['mark'])) {
		echo '<a style="display: block;" href="'.base_url().'seller/feel?oid='.$orders[$i]['oid'];
		echo '">评价';
		echo '</a>';
	} elseif ($orders[$i]['status'] == '交易成功' && !empty($orders[$i]['feel']) && $orders[$i]['mark'] == 1) {
		echo '<p style="display: block;">双方已评</p>';
	} elseif ($orders[$i]['status'] == '交易成功' && !empty($orders[$i]['mark'])) {
		echo '<p style="display: block;">已评价</p>';
	} elseif ($orders[$i]['status'] == '当面交易中') {
		echo '<a id="confship'.$i.'" style="display: block;" href="javascript:void(0);">';
		echo '确认发货';
		echo '</a>';
?>
<script type="text/javascript">
$(document).ready(function(){
	$("#confship<?php echo $i; ?>").click(function(){
		$.ajax({
			type: "post",
			data: "oid=" + "<?php echo $orders[$i]['oid']; ?>",
			url: "<?php echo base_url(); ?>ajax/confship",
			success: function(data) {
				if (data == 1) {
					$("#confship<?php echo $i; ?>").remove();
					$("#status<?php echo $i; ?>").text("卖家已发货");
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
	}
	if (!empty($orders[$i]['feel'])) {
		if ($orders[$i]['mark'] != 1) {
			echo '<p style="display: block;">对方已评价</p>';
		}
	}
	echo '</td><td><font color="#999999">';
	echo $orders[$i]['time'];
	echo '</font></td></tr>';
?>
<script type="text/javascript">
$(document).ready(function(){
	$.ajax({
		type: "get",
		data: "pid=" + "<?php echo $orders[$i]['pid']; ?>",
		url: "<?php echo base_url(); ?>ajax/getpinfo",
		success: function(data) {
			var pinfo = eval("(" + data + ")");
			$("#img<?php echo $i ?>").attr("src", "<?php echo base_url().'images/user/proview/'; ?>" + pinfo.image_one);
			$("#a<?php echo $i ?>").html("<b style='font-size: 13px;'>" + pinfo.title + "</b>");
			$("#pr<?php echo $i ?>").text(pinfo.price);
		},
		error: function() {
			/*alert("ajax error");*/
		},
	});
});
</script>
<?php
}
?>
		<tr>
			<td id="pagerank" colspan="8">
<?php
if (($page-1) >= 1) {
	echo '<span><a target="_self" href="?page='.($page-1).'">上一页';
	echo '</a></span>';
} else {
	echo '<span>上一页</span>';
}
for ($i = 0; $i < $pagecount; $i++) {
	if ($i == $page-1) {
		echo '<span>';
		echo $page;
		echo '</span>';
	} else {
		echo '<span><a target="_self" href="?page='.($i+1).'">';
		echo $i+1;
		echo '</a></span>';
	}
}
if (($page+1) > $pagecount) {
	echo '<span>下一页</span>';
} else {
	echo '<span><a target="_self" href="?page='.($page+1).'">下一页';
	echo '</a></span>';
}
?>
			</td>
		</tr>
	</table>
<?php
}
?>
</div>
<div id="infowindow"></div>
<div id="clearboth"></div>
</body>
</html>