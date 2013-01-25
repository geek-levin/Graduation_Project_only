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
		<h3>我的交易信息</h3>
	</div>

<?php
if (empty($wanted)) {
	echo '<p style="padding: 20px;">您还未发布过交易信息哦，现在发一条吧。</p>';
} else {
	$wanted = array_reverse($wanted);
	$items = count($wanted);
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
		switch ($wanted[$i]['type']) {
			case 1:
				$wanted[$i]['type'] = '求购信息';
				break;
			case 2:
				$wanted[$i]['type'] = '出售信息';
				break;
			default:
				break;
		}
?>
	<div class="conwanted">
		<p>
			<span class="wantedli">信息种类：
			</span>
			<span><?php echo $wanted[$i]['type']; ?>
			</span>
		</p>
		<p>
			<span class="wantedli">标题：
			</span>
			<span class="wantedname"><?php echo $wanted[$i]['name']; ?>
			</span>
			<span class="wantedli">发布时间：
			</span>
			<span class="wantedtime"><?php echo $wanted[$i]['time']; ?>
			</span>
		</p>
		<p>
			<span class="wantedli">期望价格：
			</span>
			<span><?php echo $wanted[$i]['price']; ?>元
			</span>
			<span class="wantedli">
			</span>
			<span class="wantedli">数量：
			</span>
			<span><?php echo $wanted[$i]['amount']; ?>
			</span>
		</p>
		<p>
			<span class="wantedli">详细信息：
			</span>
			<span><?php echo $wanted[$i]['detail']; ?>
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
<div class="view_banner">
	<h3>发布交易信息</h3>
</div>

	<div class="wantedform">
	<?php echo form_open(base_url().'i/mywanted'); ?>
		<div class="contain">
			<div class="field">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;种类
			</div>
			<div style="display: inline;">
				<span><input type="radio" name="type" id="type1" value="1" /><label for="type1">&nbsp;&nbsp;求购</label></span>
				<span><input type="radio" name="type" id="type2" value="2" /><label for="type2">&nbsp;&nbsp;出售</label></span>
			</div>
		</div>
		<div class="conerror">
			<?php echo form_error('type','<div class="error">','</div>'); ?>
		</div>
		<div class="contain">
			<div class="field">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;标题
			</div>
			<div class="write"><input type="text" class="input" id="name" name="name" value="<?php echo set_value('name');?>" placeholder="请输入标题或商品名" size="50" />
			</div>
		</div>
		<div class="conerror">
			<?php echo form_error('name','<div class="error">','</div>'); ?>
		</div>
		<div class="contain">
			<div class="field">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;价格
			</div>
			<div class="write"><input type="text" class="input" id="price" name="price" value="<?php echo set_value('price');?>" placeholder="请输入你的期望价格" size="50" />
			</div>
		</div>
		<div class="conerror">
			<?php echo form_error('price','<div class="error">','</div>'); ?>
		</div>
		<div class="contain">
			<div class="field">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;数量
			</div>
			<div class="write"><input type="text" class="input" id="amount" name="amount" value="<?php echo set_value('amount');?>" placeholder="请输入商品数量" size="50" />
			</div>
		</div>
		<div class="conerror">
			<?php echo form_error('amount','<div class="error">','</div>'); ?>
		</div>
		<div class="contain">
			<div class="field" style="float: left;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;描述
			</div>
			<textarea id="detail" name="detail" placeholder="请输入商品描述和联系方式"></textarea>
		</div>
		<br />
		<br />
		<br />
		<br />
		<br />
		<br />
		<div class="conerror">
			<?php if (!empty($error)) {
				?><div class="error"><?php echo $error; ?></div>
			<?php } ?>
			<?php echo form_error('detail','<div class="error">','</div>'); ?>
		</div>
		<br />
		
		<div>
			<input type="submit" class="button" value="发布" />
			<input type="button" class="button" value="重置" onclick="reSet_wanted('name','price','amount','detail');" />
		</div>
	</form>
	</div>

</body>
</html>