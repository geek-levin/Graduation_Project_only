<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<link href="<?php echo base_url(); ?>css/item.css" type="text/css" rel="stylesheet" />
	<link href="<?php echo base_url(); ?>css/main.css" type="text/css" rel="stylesheet" />
	<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>css/jquery.popeye.css" media="screen" />
	<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>css/jquery.popeye.style.css" media="screen" />
	<script type="text/javascript" src="<?php echo base_url(); ?>js/jquery-1.7.2.min.js"></script>
	<script type="text/javascript" src="<?php echo base_url(); ?>js/jquery.popeye-2.1.min.js"></script>
	<script type="text/javascript" src="<?php echo base_url(); ?>js/item.js"></script>
	<title><?php echo $detail['title']; ?> - 浏览商品 - findpo</title>
</head>
<body>
<?php
include('banner.php');
?>

<div id="wherenow">
所属类目：
<?php
$catname = explode('*', $catinfo['classname']);
$catid = explode('*', $catinfo['catid']);
$catcount = count($catid);
for ($i = $catcount-1; $i >= 0; $i--) {
	$cat[$catid[$i]] = $catname[$i];
}
foreach ($cat as $k => $v) {
	echo '<a target="_blank" href="'.base_url().'item/cat?cid='.$k.'">'.$v.'</a>&nbsp;&gt;&nbsp;';
}
?>
商品详情
</div>

<div id="nav">
	<ul>
		<li><a target="_blank" href="<?php echo base_url().'shop?sid='.$shopinfo['sid'].'">'.$shopinfo['shop'] ?></a>
		</li>
		<li>
			<a target="_blank" href="<?php echo base_url().'shop?sid='.$shopinfo['sid']; ?>">进入店铺
			</a>
		</li>
		<li>
			<a href="javascript:void(0);" class="favshop">收藏店铺
			</a>
		</li>
		<li>
<?php
if (!empty($sellerinfo['qq_wp'])) {
	echo $sellerinfo['qq_wp'];
}
?>
		</li>
	</ul>
</div>



<div id="page">
	



	<div id="product">
		<div id="pro_titlecon">
			<h1 id="pro_title">
<?php
echo $detail['title'];
?>
			</h1>
			<div id="sale">
				<img src="<?php echo base_url().'images/site/onsale.png'; ?>" />
			</div>
			<p id="report">
				<a href="#">举报此商品
				</a>
			</p>
		</div>
	
		<div id="pro_introcon">
	
			<div class="ppy" id="ppy1">
				<ul class="ppy-imglist">
<?php
if (!empty($detail['image_one'])) {
?>
					<li>
						<a href="<?php echo base_url().'images/user/proview/'.$detail['image_one']; ?>">
							<img src="<?php echo base_url().'images/user/proview/'.$detail['image_one']; ?>" alt="" />
						</a>
						<span class="ppy-extcaption">
						</span>
					</li>
<?php
}
if (!empty($detail['image_two'])) {
?>
					<li>
						<a href="<?php echo base_url().'images/user/proview/'.$detail['image_two']; ?>">
							<img src="<?php echo base_url().'images/user/proview/'.$detail['image_two']; ?>" alt="" />
						</a>
						<span class="ppy-extcaption">
						</span>
					</li>
<?php
}
if (!empty($detail['image_three'])) {
?>
					<li>
						<a href="<?php echo base_url().'images/user/proview/'.$detail['image_three']; ?>">
							<img src="<?php echo base_url().'images/user/proview/'.$detail['image_three']; ?>" alt="" />
						</a>
						<span class="ppy-extcaption">
						</span>
					</li>
<?php
}
if (!empty($detail['image_four'])) {
?>
					<li>
						<a href="<?php echo base_url().'images/user/proview/'.$detail['image_four']; ?>">
							<img src="<?php echo base_url().'images/user/proview/'.$detail['image_four']; ?>" alt="" />
						</a>
						<span class="ppy-extcaption">
						</span>
					</li>
<?php
}
if (!empty($detail['image_five'])) {
?>
					<li>
						<a href="<?php echo base_url().'images/user/proview/'.$detail['image_five']; ?>">
							<img src="<?php echo base_url().'images/user/proview/'.$detail['image_five']; ?>" alt="" />
						</a>
						<span class="ppy-extcaption">
						</span>
					</li>
<?php
}
?>
				</ul>
				<div class="ppy-outer">
					<div class="ppy-stage">
						<div class="ppy-nav">
							<a class="ppy-prev" title="上一张">上一张</a>
							<a class="ppy-switch-enlarge" title="看大图">看大图</a>
							<a class="ppy-switch-compact" title="关闭">关闭</a>
							<a class="ppy-next" title="下一张">下一张</a>
						</div>
					</div>
				</div>
				<div class="ppy-caption">
					<div class="ppy-counter">
						第<strong class="ppy-current"></strong>张，共<strong class="ppy-total"></strong>张
					</div>
					<span class="ppy-text"></span>
				</div>
			</div>
			
			<div id="pro_intro">
				<ul id="pro_intro_list">
					<li class="pro_intro_li">
						<span>售价：
						</span>
						<strong id="pro_price">
<?php
echo $detail['price'];
?>
						</strong>元
					</li>
<?php
if (!empty($detail['mprice'])) {
	echo '<li class="pro_intro_li"><span>市场参考价：'.$detail['mprice'].'元</span></li>';
}
?>
					<li class="pro_intro_li">
						<span>运费：
<?php
if ($detail['cost'] == '0') {
	echo '无';
} else {
	echo $detail['cost'].'元';
}
?>
						</span>
					</li>
					<li class="pro_intro_li">
						<span>交易范围：
<?php
echo $detail['ex_range'];
?>
						</span>
					</li>
					<li class="pro_intro_li">
						<span>新旧程度：
<?php
echo $detail['new_old'];
?>
						</span>
					</li>
<?php
if ($detail['wot'] == '1') {
	echo '<li class="pro_intro_li"><span>交易方式：该卖家支持当面交易</span></li>';
} elseif ($detail['wot'] == '2') {
	echo '<li class="pro_intro_li"><span>交易方式：该卖家支持货到付款</span></li>';
} elseif ($detail['wot'] == '3') {
	echo '<li class="pro_intro_li"><span>交易方式：该卖家支持当面交易与货到付款</span></li>';
} else {
}
?>
				</ul>
			</div>
			
			<div id="buy">
				<div id="countcon">购买数量：
					<input type="text" value="1" maxlength="4" size="4" id="count" name="count" />&nbsp;件 还剩
<?php
echo $detail['amount'];
?>
				件
				</div>
				<input type="hidden" value="<?php echo $detail['pid'] ?>" id="pid" />
				<a href="javascript:void(0);"><img src="<?php echo base_url(); ?>images/site/gotobuy.png" /></a>
				<a href="javascript:void(0);"><img src="<?php echo base_url(); ?>images/site/addcart.png" /></a>
			</div>
		</div>
		
		<div id="pro_share">
			<span><a href="javascript:void(0);">收藏该商品</a></span>
			<span>人气：<?php echo $favcount; ?>人收藏</span>
			<span><?php echo $detail['views'] ?>人看过</span>
			<span style="float: right;">分享到：蘑菇街 美丽说 腾讯微博 新浪微博 人人网</span>
		</div>
		
		<div id="pro_detail">
			<div id="pro_detail_nav_con">
				<ul>
					<li class="pro_detail_nav">
						<a href="javascript:void(0);">商品详情</a>
					</li>
					<li class="pro_detail_nav">
						<a href="javascript:void(0);">评价详情</a><b></b>
					</li>
					<li class="pro_detail_nav">
						<a href="javascript:void(0);">购买记录</a><b></b>
					</li>
				</ul>
			</div>
			
			<div class="pro_detailcon" style="display: block;">
				<div class="pro_ttl">
					<ul>
						<li>商品发布时间：<?php echo $detail['release']; ?>
						</li>
						<li>最后修改时间：<?php echo $detail['update']; ?>
						</li>
						<li>商品剩余时间：
<?php
$end = lasttime($detail['end']);
if (preg_match('/-+/', $end)) {
	echo '<b style="color: #ff0000;">此商品已下架</b>';
} else {
	echo $end;
}
?>
						</li>
						<li>商品下架时间：<?php echo $detail['end']; ?>
						</li>
					</ul>
				</div>
				<pre>
<?php
echo $detail['detail'];
?>
				</pre>
			</div>
			<div class="pro_detailcon">
<?php
$ordercount = count($orderinfo);
if ($ordercount == 0) {
	echo '<div class="pro_ttl"><p>此商品暂无评分。</p></div>';
} else {
	$feelg = 0;
	$feeln = 0;
	$feelb = 0;
	for ($i = 0; $i < $ordercount; $i++) {
		switch ($orderinfo[$i]['feel']) {
			case 1:
				$feelg++;
				break;
			case 2:
				$feeln++;
				break;
			case 3:
				$feelb++;
				break;
			default:
				break;
		}
	}
	if (($feelg+$feeln+$feelb) == 0) {
		echo '<div class="pro_ttl"><p>此商品暂无评分。</p></div>';
	} else {
		echo '<div class="pro_ttl"><p>';
		echo $feelg.'人觉得不错</p><p>';
		echo $feeln.'人觉得一般</p><p>';
		echo $feelb.'人觉得不好</p></div>';
	}
}
$comcount = count($comment);
if ($comcount == 0) {
	echo '<div class="pro_commt pro_comm_odd"><p>此商品暂无评论。</p></div>';
} else {
	for ($i = 0; $i < $comcount; $i++) {
		if ($comment[$i]['read'] == 0 && !empty($comment[$i]['comment'])) {
			echo '<div class="'.cssforcom($i).'"><p>'.$comment[$i]['comment'].'</p><span>';
			if (!empty($comment[$i]['nickname'])) {
				echo $comment[$i]['time'].'</span><span><a target="_blank" href="'.base_url().'user?uid='.$comment[$i]['uid'].'">'.$comment[$i]['nickname'].'</a></span></div>';
			} else {
				echo $comment[$i]['time'].'</span><span><a target="_blank" href="'.base_url().'user?uid='.$comment[$i]['uid'].'">'.$comment[$i]['username'].'</a></span></div>';
			}
		} else {
			continue;
		}
	}
}
?>
			</div>
			<div class="pro_detailcon">
<?php
if ($ordercount == 0) {
	echo '<div class="pro_ttl"><p>此商品暂无购买记录。</p></div>';
} else {
	echo '<div class="pro_ttl"><p>成交价格可能会有所不一样，详情请咨询卖家。</p><div id="pro_order_bancon"><span class="pro_order_ban">买家</span><span class="pro_order_ban">价格</span><span class="pro_order_ban">数量</span><span class="pro_order_ban">成交时间</span></div></div>';
	for ($i = 0; $i < $ordercount; $i++) {
		if ($orderinfo[$i]['status'] == '7') {
			echo '<div class="pro_order"><span>';
			if (!empty($orderinfo[$i]['nickname'])) {
				echo '<a target="_blank" href="'.base_url().'user?uid='.$orderinfo[$i]['buyuid'].'">'.$orderinfo[$i]['nickname'].'</a></span><span>';
			} else {
				echo '<a target="_blank" href="'.base_url().'user?uid='.$orderinfo[$i]['buyuid'].'">'.$orderinfo[$i]['username'].'</a></span><span>';
			}
			echo $orderinfo[$i]['price'].'</span><span>'.$orderinfo[$i]['amount'].'</span><span>';
			if (!empty($orderinfo[$i]['time_pay'])) {
				echo substr($orderinfo[$i]['time_pay'], 0, 10).'</span></div>';
			} else {
				echo substr($orderinfo[$i]['time_over'], 0, 10).'</span></div>';
			}
		}
	}
}
?>
			</div>
			

		</div>
		
	</div>
	
	

	<div id="shopdetail">
		<ul>
			<li>店铺信息
			</li>
			<li>店主：
<?php
if (!empty($sellerinfo['nickname'])) {
	echo $sellerinfo['nickname'];
} else {
	echo $sellerinfo['username'];
}
?>
			</li>
			<li>认证：
<?php
if ($sellerinfo['usertype'] == '2') {
	echo '认证卖家';
} elseif ($sellerinfo['usertype'] == '3') {
	echo '认证企业卖家';
} else {
	echo '此卖家未认证';
}
?>
			</li>
			<li>所在学校：<?php echo $sellerinfo['college']; ?>
			</li>
			<li>交易次数：<?php echo $sellerinfo['exchange_seller'] ?>
			</li>
<?php
if (($sellerinfo['sale_good']+$sellerinfo['sale_neutral']+$sellerinfo['sale_bad']) != 0) {
	echo '<li>好评率：'.($sellerinfo['sale_good']/($sellerinfo['sale_good']+$sellerinfo['sale_neutral']+$sellerinfo['sale_bad'])*100).'%</li>';
}
?>
			<li>开店时间：<?php echo substr($shopinfo['reg_date'], 0, 10); ?>
			</li>
			<li>
				<span>
					<a target="_blank" href="<?php echo base_url().'shop?sid='.$shopinfo['sid']; ?>">进入店铺
					</a>
				</span>
				<span>
					<a href="javascript:void(0);" class="favshop">收藏店铺
					</a>
				</span>
			</li>
		</ul>
	</div>
	<div id="suggest">推荐商品
	</div>
	
	
	
</div>


<div id="infowindow"></div>

<div id="gototop" onclick="window.scrollTo('0', '0')">
	<a href="javascript:void(0);">
		<img src="<?php echo base_url().'images/site/gototop.png' ?>" />
	</a>
</div>



<script type="text/javascript">
	$(document).ready(function () {
		var options1 = {
		}
		var options2 = {
			caption: false,
			navigation: 'permanent',
			direction: 'left'
		}
		var options3 = {
			caption: 'permanent',
			opacity: 1
		}
		
		$('#ppy1').popeye(options1);
		$('#ppy2').popeye(options2);
		$('#ppy3').popeye(options3);
	});
</script>
<script type="text/javascript">
	var getcommcount = $(".pro_comm").size();
	$(".pro_detail_nav:eq(1)>b").text("("+getcommcount+")");
	var getordercount = $(".pro_order").size();
	$(".pro_detail_nav:eq(2)>b").text("("+getordercount+")");
	$(document).ready(function(){
		$("#pro_share>span:eq(0)").click(function(){
			$.ajax({
				type: "get",
				data: "pid=" + $("#pid").attr("value"),
				url: "<?php echo base_url(); ?>ajax/insertfav",
				success: function(data) {
					$("#infowindow").text(data);
					$("#infowindow").fadeTo("fast", 1, function(){
						$(this).fadeTo(3000, 0);
					});
				},
				error: function() {
					/*alert("ajax error");*/
				}
			});
		});
	});
	$(document).ready(function(){
		$(".favshop").click(function(){
			$.ajax({
				type: "get",
				data: "sid=" + "<?php echo 's'.$shopinfo['sid']; ?>",
				url: "<?php echo base_url(); ?>ajax/insertfav",
				success: function(data) {
					$("#infowindow").text(data);
					$("#infowindow").fadeTo("fast", 1, function(){
						$(this).fadeTo(3000, 0);
					});
				},
				error: function() {
					/*alert("ajax error");*/
				}
			});
		});
	});
	$(document).ready(function(){
		$("#buy>a:eq(0)").click(function(){
			$.ajax({
				type: "post",
				url: "<?php echo base_url(); ?>ajax/checklogin",
				success: function(data) {
					if (data == 1) {
						$.ajax({
							type: "post",
							data: { pid: $("#pid").val(), pcount: $("#count").val(), pmax: "<?php echo $detail['amount']; ?>" },
							url: "<?php echo base_url(); ?>ajax/gotobuy",
							success: function(data) {
								if (data == 1) {
									window.location.href = "<?php echo base_url().'i?app=2'; ?>";
								} else {
									$("#infowindow").text(data);
									$("#infowindow").fadeTo("fast", 1, function(){
										$(this).fadeTo(3000, 0);
									});
								}
							},
							error: function() {
								/*alert("ajax error");*/
							}
						});
					} else {
						$("#infowindow").text(data);
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
		$("#buy>a:eq(1)").click(function(){
			$.ajax({
				type: "post",
				url: "<?php echo base_url(); ?>ajax/checklogin",
				success: function(data) {
					if (data == 1) {
						$.ajax({
							type: "post",
							data: { pid: $("#pid").val(), pcount: $("#count").val(), pmax: "<?php echo $detail['amount']; ?>" },
							url: "<?php echo base_url(); ?>ajax/insertcart",
							success: function(data) {
								$("#infowindow").text(data);
								$("#infowindow").fadeTo("fast", 1, function(){
									$(this).fadeTo(3000, 0);
								});
							},
							error: function() {
								/*alert("ajax error");*/
							}
						});
					} else {
						$("#infowindow").text(data);
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
</script>
<?php
function lasttime($end) {
	date_default_timezone_set('PRC');
	$lasttime = strtotime($end)-time();
	$last = (int)($lasttime/86400).'天';
	$last .= (int)($lasttime%86400/3600).'小时';
	$last .= (int)($lasttime%86400%3600/60).'分';
	return $last;
}
function cssforcom($i) {
	$i = $i%2;
	if ($i == 0) {
		return 'pro_comm pro_comm_odd';
	} else {
		return 'pro_comm pro_comm_even';
	}
}
include('foot.php');
?>
</body>
</html>