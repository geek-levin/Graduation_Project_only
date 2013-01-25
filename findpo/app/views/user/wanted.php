<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<link href="<?php echo base_url(); ?>css/main.css" type="text/css" rel="stylesheet" />
	<script type="text/javascript" src="<?php echo base_url(); ?>js/jquery-1.7.2.min.js"></script>
	<title>首页 - findpo</title>
</head>
<body>
<?php
include('banner.php');
?>
<div id="index">
	<div id="header">
		<ul>
			<li>
				<a target="_self" href="<?php echo base_url().'index'; ?>">首页
				</a>
			</li>
			<li>交易信息
			</li>&gt;
			<li style="font-weight: normal; font-size: 12px; margin-left: 5px;">
				<a id="showsale" href="javascript:void(0);"><b>出售</b>信息
				</a>
			</li>
			<li style="font-weight: normal; font-size: 12px; margin-left: 5px;">
				<a id="showwanted" href="javascript:void(0);"><b>求购</b>信息
				</a>
			</li>
			<li>
				<a target="_self" href="<?php echo base_url().'index?app=1'; ?>">热门商品
				</a>
			</li>
			<li>
				<a target="_self" href="<?php echo base_url().'index?app=2'; ?>">教材市场
				</a>
			</li>
			<li>
				<a target="_self" href="<?php echo base_url().'index?app=3'; ?>">大四街铺
				</a>
			</li>
			<li>
				<a target="_self" href="<?php echo base_url().'index?app=4'; ?>">商城
				</a>
			</li>
		</ul>
	</div>
<?php
date_default_timezone_set('PRC');
if (!empty($wanteds)) {
$wanteds = array_reverse($wanteds);
$items = count($wanteds);
$pagecount = (int) ($items/20);
if (!preg_match('/^[0-9]+$/', ($items/20))) {
	$pagecount++;
}
if ($pagecount == $page) {
	$start = ($page-1)*20;
	$end = $items;
} elseif ($pagecount > $page) {
	$start = ($page-1)*20;
	$end = $start+20;
} elseif ($pagecount < $page) {
	$page = 1;
	$start = 0;
	$end = 20;
	if ($items < $end) {
		$end = $items;
	}
}
for ($i = $start; $i < $end; $i++) {
	$last = strtotime($wanteds[$i]['deadline'])-time();
	if ($last <= 0 or $wanteds[$i]['read'] != 0) {
		continue;
	}
	switch ($wanteds[$i]['type']) {
		case 1:
			$wanteds[$i]['type'] = '求购信息';
			break;
		case 2:
			$wanteds[$i]['type'] = '出售信息';
			break;
		default:
			break;
	}
?>
	<div class="conwanteds <?php echo whichcss($wanteds[$i]['type']); ?> mark<?php echo type($wanteds[$i]['type']); ?>">
		<p>
			<span class="wantedlis">信息种类：
			</span>
			<span><?php echo $wanteds[$i]['type']; ?>
			</span>
		</p>
		<p>
			<span class="wantedlis">标题：
			</span>
			<span class="wantednames"><?php echo mb_substr($wanteds[$i]['name'], 0, 16, 'utf-8'); ?>
			</span>
			<span class="wantedlis">发布时间：
			</span>
			<span class="wantedtimes"><?php echo $wanteds[$i]['time']; ?>
			</span>
		</p>
		<p>
			<span class="wantedlis">期望价格：
			</span>
			<span><?php echo $wanteds[$i]['price']; ?>元
			</span>
			<span class="wantedlis">
			</span>
			<span class="wantedlis">数量：
			</span>
			<span><?php echo $wanteds[$i]['amount']; ?>
			</span>
		</p>
		<p>
			<span class="wantedlis">详细信息：
			</span>
			<span>
				<font color="#666666"><?php echo mb_substr($wanteds[$i]['detail'], 0, 30, 'utf-8'); ?>
				</font>
			</span>
		</p>
	</div>
<?php
}
?>
	<div id="pagerankw">
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
}
?>
	</div>
</div>
<div id="gototop" onclick="window.scrollTo('0', '0')">
	<a href="javascript:void(0);">
		<img src="<?php echo base_url().'images/site/gototop.png' ?>" />
	</a>
</div>
<script type="text/javascript">
$(document).ready(function() {
	$("#showwanted").click(function() {
		$(".mark2").slideUp("slow");
		$(".mark1").slideDown("slow");
	});
	$("#showsale").click(function() {
		$(".mark1").slideUp("slow");
		$(".mark2").slideDown("slow");
	});
});
</script>
<?php
function whichcss($type) {
	if ($type == '求购信息') {
		return 'conwantedsodd';
	} else {
		return 'conwantedseven';
	}
}
function type($type) {
	if ($type == '求购信息') {
		return 1;
	} else {
		return 2;
	}
}
include('foot.php');
?>
</body>
</html>