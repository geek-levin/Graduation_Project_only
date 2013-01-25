<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<link href="<?php echo base_url(); ?>css/admin.css" type="text/css" rel="stylesheet">
	<link href="<?php echo base_url(); ?>css/i.css" type="text/css" rel="stylesheet">
	<link href="<?php echo base_url(); ?>css/main.css" type="text/css" rel="stylesheet" />
	<script type="text/javascript" src="<?php echo base_url(); ?>js/jquery-1.7.2.min.js"></script>
	<title>后台管理 - findpo</title>
	<style type="text/css">
	.view_fav p {
		padding: 5px 0;
	}
	.time {
		color: #999999;
	}
	.realinfo {
		color: rgba(255, 140, 0, 0.9);
		letter-spacing: 0.1em;
	}
	</style>
</head>
<body>
<?php
if (empty($shopinfo)) {
	echo '<p style="padding: 20px;">目前还没有店铺需要认证。</p>';
} else {
?>
	<table class="view_fav">
		<tr>
			<th style="width: 140px;">用户名
			</th>
			<th style="width: 180px;">店铺名
			</th>
			<th style="width: 200px;">真实信息
			</th>
			<th style="width: 100px;">申请时间
			</th>
			<th style="width: 200px;">操作
			</th>
		</tr>
<?php
$items = count($shopinfo);
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
	if ($shopinfo[$i]['read'] != 0) {
		continue;
	} else {
		echo '<tr id="del'.$shopinfo[$i]['uid'].'"><td><a href="';
		echo base_url().'user?uid='.$shopinfo[$i]['uid'];
		echo '" target="_blank">';
		echo $shopinfo[$i]['username'];
		echo '</a></td><td>';
		echo $shopinfo[$i]['shop'];
		echo '</td><td class="realinfo"><p>';
		echo $shopinfo[$i]['name'];
		echo '</p><p>';
		echo $shopinfo[$i]['college'];
		echo '</p><p>';
		echo $shopinfo[$i]['idnumber'];
		echo '</p></td><td class="time">';
		echo $shopinfo[$i]['reg_date'];
		echo '</td><td id="'.$shopinfo[$i]['uid'].'"><p><a href="';
		echo base_url().'images/user/idcardview/'.$shopinfo[$i]['idimage'];
		echo '" target="_blank">查看认证图片</a></p><p class="certuser"><a href="javascript:;">认证为个人卖家</a></p><p class="certbusi"><a href="javascript:;">认证为企业卖家</a></p><p class="certnot"><a href="javascript:;">不通过此认证</a></p>';
	}
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
<script type="text/javascript">
$(document).ready(function(){
	$(".certuser").click(function(){
		var i = $(this).parent("td").attr("id");
		$.ajax({
			type: "post",
			data: "uid=" + i,
			url: "<?php echo base_url(); ?>ajax/certuser",
			success: function(data){
				if (data == 1) {
					$("#infowindow").text("操作成功");
					$("#del" + i).remove();
					$("#infowindow").fadeTo("fast", 1, function(){
						$(this).fadeTo(3000, 0);
					});
				}
			},
			error: function(){
				/*alert("ajax error");*/
			}
		});
	});
});
$(document).ready(function(){
	$(".certbusi").click(function(){
		var i = $(this).parent("td").attr("id");
		$.ajax({
			type: "post",
			data: "uid=" + i,
			url: "<?php echo base_url(); ?>ajax/certbusi",
			success: function(data){
				if (data == 1) {
					$("#infowindow").text("操作成功");
					$("#del" + i).remove();
					$("#infowindow").fadeTo("fast", 1, function(){
						$(this).fadeTo(3000, 0);
					});
				}
			},
			error: function(){
				/*alert("ajax error");*/
			}
		});
	});
});

$(document).ready(function(){
	$(".certnot").click(function(){
		var i = $(this).parent("td").attr("id");
		$.ajax({
			type: "post",
			data: "uid=" + i,
			url: "<?php echo base_url(); ?>ajax/certnot",
			success: function(data){
				if (data == 1) {
					$("#infowindow").text("操作成功");
					$("#del" + i).remove();
					$("#infowindow").fadeTo("fast", 1, function(){
						$(this).fadeTo(3000, 0);
					});
					
				}
			},
			error: function(){
				/*alert("ajax error");*/
			}
		});
	});
});
</script>
<?php
}
?>

<div id="infowindow"></div>
<div id="clearboth"></div>

</body>
</html>