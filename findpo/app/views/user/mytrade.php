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
	<h3>账户交易明细</h3>
</div>

<div class="con_fav">

<?php
if (empty($trades)) {
	echo '<p style="padding: 20px;">无账户交易明细。</p>';
}
else {
?>

	<table class="view_fav">
		<tr>
			<td style="width: 100px;">交易类型
			</td>
			<td style="width: 250px;">订单号
			</td>
			<td style="width: 150px;">数额
			</td>
			<td style="width: 200px;">发生时间
			</td>
		</tr>
<?php
$trades = array_reverse($trades);
$items = count($trades);
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
	switch ($trades[$i]['type']) {
		case 1:
			$trades[$i]['type'] = '充值';
			$trades[$i]['amount'] = '收入<b>'.$trades[$i]['amount'];
			break;
		case 2:
			$trades[$i]['type'] = '支付/转账';
			$trades[$i]['amount'] = '支出<b>'.substr($trades[$i]['amount'], 1);
			break;
		case 3:
			$trades[$i]['type'] = '接收款';
			$trades[$i]['amount'] = '收入<b>'.$trades[$i]['amount'];
			break;
		case 4:
			$trades[$i]['type'] = '取现';
			$trades[$i]['amount'] = '支出<b>'.substr($trades[$i]['amount'], 1);
			break;
		default:
			break;
	}
	echo '<tr><td>';
	echo $trades[$i]['type'];
	echo '</td><td>';
	if (!empty($trades[$i]['oid'])) {
		echo '<a target="_blank" href="'.base_url().'order?oid='.$trades[$i]['oid'].'">';
		echo $trades[$i]['oid'].'</a>';
	} else {
		echo '无';
	}
	echo '</td><td>';
	echo $trades[$i]['amount'].'</b>元</td><td class="wantedtime">';
	echo $trades[$i]['time'];
	echo '</td></tr>';
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
<script type="text/javascript">
$("b").css("color", "#FF4500");
</script>
</body>
</html>