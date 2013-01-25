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
			<li>
				<a target="_self" href="<?php echo base_url().'index/wanted'; ?>">交易信息
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
if (!empty($proinfos)) {
$proinfos = array_reverse($proinfos);
$items = count($proinfos);
$pagecount = (int) ($items/50);
if (!preg_match('/^[0-9]+$/', ($items/50))) {
	$pagecount++;
}
if ($pagecount == $page) {
	$start = ($page-1)*50;
	$end = $items;
} elseif ($pagecount > $page) {
	$start = ($page-1)*50;
	$end = $start+50;
} elseif ($pagecount < $page) {
	$page = 1;
	$start = 0;
	$end = 50;
	if ($items < $end) {
		$end = $items;
	}
}
echo '<p style="padding: 25px; padding-top: 10px;">以下是对&nbsp;&nbsp;<b>'.$word.'</b>&nbsp;&nbsp;进行搜索产生的结果</p>';
for ($i = $start; $i < $end; $i++) {
	$last = strtotime($proinfos[$i]['end'])-time();
	if ($last <= 0 or $proinfos[$i]['visible'] != 0 or $proinfos[$i]['read'] != 0) {
		continue;
	}
?>
	<div class="pin">
		<div class="pinimg">
			<a target="_blank" href="<?php echo base_url().'item?pid='.$proinfos[$i]['pid']; ?>">
				<img src="<?php echo base_url().'images/user/proview/'.$proinfos[$i]['image_one']; ?>" />
			</a>
		</div>
		<div class="content">
			<p>
				<b>
					<a target="_blank" href="<?php echo base_url().'item?pid='.$proinfos[$i]['pid']; ?>"><?php echo mb_substr($proinfos[$i]['title'], 0, 10, 'utf-8'); ?>
					</a>
				</b>
			</p>
			<span style="margin-right: 10px;"><?php echo $proinfos[$i]['price']; ?>元
			</span>
			<span style="color: #C0C0C0;"><em><?php echo $proinfos[$i]['views']; ?></em>人看过
			</span>
		</div>
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
?>
	</div>
</div>
<div id="gototop" onclick="window.scrollTo('0', '0')">
	<a href="javascript:void(0);">
		<img src="<?php echo base_url().'images/site/gototop.png' ?>" />
	</a>
</div>
<?php
} elseif (!empty($error)) {
	echo '<p style="padding: 25px; padding-top: 10px;">'.$error.'</p>';
} else {
	echo '<div id="nf"></div><p style="margin-left: 125px; padding: 25px;">抱歉，你要找的商品不存在</p>';
}
include('foot.php');
?>
</body>
</html>