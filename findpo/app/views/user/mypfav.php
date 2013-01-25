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
	<h3>我的商品收藏</h3>
</div>
<div class="con_fav">
<?php
if (!empty($error)) {
	echo '<p style="padding: 20px;">'.$error.'</p>';
} else {
?>
	<table class="view_fav">
		<tr>
			<th colspan="2">商品
			</th>
			<th>价格
			</th>
			<th>新旧程度
			</th>
			<th>收藏时间
			</th>
			<th>操作
			</th>
		</tr>
<?php
$favinfo = array_reverse($favinfo);
$items = count($favinfo);
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
	echo '<tr class="pfavtr pfavtrs pfavtr'.$i.'"><td><div class="favimg"><a target="_blank" href="'.base_url().'item?pid='.$favinfo[$i]['pid'].'"><img src="'.base_url().'images/user/proview/'.$favinfo[$i]['image_one'].'" /></a></div></td><td class="pfavtd1"><a target="_blank" href="'.base_url().'item?pid='.$favinfo[$i]['pid'].'">'.$favinfo[$i]['title'].'</a></td><td class="pfavtd2"><b>￥'.$favinfo[$i]['price'].'</b></td><td class="pfavtd3">'.$favinfo[$i]['new_old'].'成新</td><td class="pfavtd4">'.$favinfo[$i]['time'].'</td><td><a href="javascript:void(0)" title="删除该收藏"><b>X</b></a></td></tr>';
?>
<script type="text/javascript">
$(document).ready(function(){
	$(".pfavtr<?php echo $i; ?>>td:eq(5)>a").click(function(){
		$.ajax({
			type: "post",
			data: "deletepfav=" + "<?php echo $favinfo[$i]['pid']; ?>",
			url: "<?php echo base_url(); ?>ajax/deletepfav",
			success: function(data) {
				if (data == 1) {
					$(".pfavtr:eq(<?php echo $i; ?>)").fadeTo(2000, 0, function(){
						$(".pfavtr:eq(<?php echo $i; ?>)").css("display", "none");
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
</body>
</html>