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
	<h3>我的商品</h3>
</div>

<div class="con_fav">
<?php
if (!empty($error)) {
	echo '<p style="padding: 20px;">'.$error.'</p>';
} else {
?>
	<table class="view_fav">
		<tr>
			<th colspan="2" style="width: 500px;">商品信息
			</th>
			<th style="width: 90px;">价格
			</th>
			<th style="width: 90px;">数量
			</th>
			<th style="width: 90px;">新旧程度
			</th>
			<th style="width: 150px;">操作
			</th>
		</tr>
<?php
$proinfos = array_reverse($proinfos);
$items = count($proinfos);
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
	if ($proinfos[$i]['read'] == 1) {
		continue;
	}
?>
		<tr id="del<?php echo $i; ?>">
			<input type="hidden" value="<?php echo $proinfos[$i]['pid']; ?>" />
			<td>
				<div class="favimg">
					<a target="_blank" href="<?php echo base_url().'item?pid='.$proinfos[$i]['pid']; ?>">
						<img src="<?php echo base_url().'images/user/proview/'.$proinfos[$i]['image_one']; ?>" />
					</a>
				</div>
			</td>
			<td>
				<p>
					<a target="_blank" href="<?php echo base_url().'item?pid='.$proinfos[$i]['pid']; ?>">
						<b style="font-size: 14px;"><?php echo $proinfos[$i]['title']; ?></b>
					</a>
				</p>
				<p class="pfavtd4"><?php echo $proinfos[$i]['release']; ?>发布
				</p>
				<p><em style="color: #FF4500;"><?php echo $proinfos[$i]['views']; ?></em>人看过
				</p>
			</td>
			<td><b><?php echo $proinfos[$i]['price']; ?></b>元
			</td>
			<td><?php echo $proinfos[$i]['amount']; ?>
			</td>
			<td><em><?php echo $proinfos[$i]['new_old']; ?></em>成新
			</td>
			<td>
				<p>
<?php
if ($proinfos[$i]['visible'] == 1) {
	echo '<span id="succ'.$i.'"><a id="release'.$i.'" href="javascript:void(0);">发布</a>|</span>';
}
?>
					<span>
						<a target="_blank" href="<?php echo base_url().'item?pid='.$proinfos[$i]['pid']; ?>">查看</a>|
					</span>
					<span><a href="javascript:;">编辑</a>|
					</span>
					<span>
						<a id="delete<?php echo $i; ?>" href="javascript:void(0);">删除</a>
					</span>
				</p>
		</tr>
<script type="text/javascript">
$(document).ready(function(){
	$("#delete<?php echo $i; ?>").click(function(){
		if (confirm("确定要删除吗？")) {
			$.ajax({
				type: "post",
				data: "del=<?php echo $proinfos[$i]['pid']; ?>",
				url: "<?php echo base_url(); ?>ajax/delpro",
				success: function(data) {
					if (data == 1) {
						$("#infowindow").text("删除成功");
						$("#infowindow").fadeTo("fast", 1, function(){
							$(this).fadeTo(1000, 0, function(){
								$("#del<?php echo $i; ?>").fadeTo(1000, 0, function(){
									$(this).remove();
								});
							});
						});
					}
				},
				error: function() {
					/*alert("ajax error");*/
				}
			});
		} else {
			return false;
		}
	});
});
<?php
if ($proinfos[$i]['visible'] == 1) {
?>
$(document).ready(function(){
	$("#release<?php echo $i; ?>").click(function(){
		$.ajax({
			type: "post",
			data: "release=<?php echo $proinfos[$i]['pid']; ?>",
			url: "<?php echo base_url(); ?>ajax/releasepro",
			success: function(data) {
				if (data == 1) {
					$("#infowindow").text("发布成功");
					$("#infowindow").fadeTo("fast", 1, function(){
						$(this).fadeTo(3000, 0, function(){
							$("#succ<?php echo $i; ?>").fadeTo(1000, 0, function(){
								$(this).remove();
							});
						});
					});
				}
			},
			error: function() {
				/*alert("ajax error");*/
			}
		});
	});
});
<?php
}
?>
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
<script type="text/javascript">
window.setInterval("ifempty()", 100);
</script>
</body>
</html>