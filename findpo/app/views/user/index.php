<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<link href="<?php echo base_url(); ?>css/main.css" type="text/css" rel="stylesheet" />
	<script type="text/javascript" src="<?php echo base_url(); ?>js/jquery-1.7.2.min.js"></script>
	<title>首页 - findpo</title>
	<style type="text/css">
	em {
		color: rgba(255, 87, 0, 0.8);
	}
	</style>
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
				<a target="_self" href="<?php echo base_url().'index/wanted'; ?>">二手信息
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
switch ($app) {
	case 1:
		foreach ($proinfos as $k => $v) {
			$views[$k] = $v['views'];
			$release[$k] = strtotime($v['release']);
		}
		array_multisort($views, SORT_NUMERIC, SORT_DESC, $release, SORT_NUMERIC, SORT_DESC, $proinfos);
		break;
	case 2:
		foreach ($proinfos as $k => $v) {
			if ($v['catid'] < 114 || $v['catid'] > 121) {
				unset($proinfos[$k]);
			}
		}
		$c = 0;
		foreach ($proinfos as $k) {
			$newpro[$c] = $k;
			$c++;
		}
		unset($proinfos);
		$proinfos = $newpro;
		break;
	case 3:
		echo '<p style="padding: 20px;">此模块正在建设，已为您跳转到首页。</p>';
		break;
	case 4:
		echo '<p style="padding: 20px;">此模块正在建设，已为您跳转到首页。</p>';
		break;
	default:
		break;
}
for ($i = 0; $i < count($proinfos); $i++) {
	$last = strtotime($proinfos[$i]['end'])-time();
	if ($last <= 0 or $proinfos[$i]['visible'] != 0 or $proinfos[$i]['read'] != 0 or empty($proinfos[$i])) {
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
}
?>
</div>
<div id="gototop" onclick="window.scrollTo('0', '0')">
	<a href="javascript:void(0);">
		<img src="<?php echo base_url().'images/site/gototop.png' ?>" />
	</a>
</div>
<script type="text/javascript">
$(document).ready(function(){
	var url = window.location.href;
	var app = url.substr(-1, 1);
	if (app == 1) {
		$("li:eq(2)").html("热门商品");
	}
	if (app == 2) {
		$("li:eq(3)").html("教材市场");
	}
	if (app == 3) {
		$("li:eq(4)").html("大四街铺");
	}
	if (app == 4) {
		$("li:eq(5)").html("商城");
	}
});
</script>
<?php
include('foot.php');
?>
</body>
</html>