<div id="navi">
	<div id="navicon">
		<div id="navileft">
<?php
if (!empty($username)) {
	echo '<a href="'.base_url().'i?app=1"><strong>'.$username.'</strong></a>&nbsp;&nbsp;';
}
echo '欢迎光临&nbsp;<a href="#">'.$setting['city'].'</a>&nbsp;寻宝网'.'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
if (empty($username)) {
?>
			<a href="<?php echo base_url(); ?>login">请登录
			</a>
			&nbsp;
			<a target="_blank" href="<?php echo base_url(); ?>reg">注册
			</a>
<?php
}
?>
		</div>
		<div id="naviright">
			<a href="<?php echo base_url(); ?>index">寻宝网首页
			</a>&nbsp;&nbsp;|&nbsp;&nbsp;
			<a href="<?php echo base_url(); ?>i">我的寻宝
			</a>&nbsp;&nbsp;|&nbsp;&nbsp;
			<a href="<?php echo base_url(); ?>seller">卖家中心
			</a>&nbsp;&nbsp;|&nbsp;&nbsp;
			<a href="<?php echo base_url(); ?>i?app=2">购物车&nbsp;<?php if (!empty($cartcount)) {echo $cartcount;} else {echo '0';} ?>&nbsp;件
			</a>&nbsp;&nbsp;|&nbsp;&nbsp;
			<a href="<?php echo base_url(); ?>i?app=3">收藏夹
			</a>
			<?php if (!empty($username)) { ?>
			&nbsp;&nbsp;|&nbsp;&nbsp;
			<a href="<?php echo base_url(); ?>i/logout">退出
			</a>
<?php
}
?>
		</div>
	</div>
</div>
<div id="navihelp">
</div>
<div id="logo_banner">
	<div id="logocon">
		<div id="logo">
		</div>
		<div id="search">
			<input id="searchvalue" placeholder="typing ur words" type="text" value="" />
			<input id="searchpo" class="button" type="button" value="搜索" />
<script type="text/javascript">
$(document).ready(function(){
	$("#searchpo").click(function(){
		var search = $("#searchvalue").val();
		if (/^\s+$/.exec(search) || search == "") {
		} else {
			window.location.href="<?php echo base_url().'search?word=' ?>" + search;
		}
	});
});
</script>
		</div>
	</div>
</div>