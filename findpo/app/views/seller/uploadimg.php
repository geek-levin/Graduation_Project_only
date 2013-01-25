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
	form > input:last-child {
		margin-left: 40px;
		background: -moz-linear-gradient(top, #F5F5F5, #F1F1F1);
		background: -webkit-linear-gradient(top, #F5F5F5, #F1F1F1);
		background: -o-linear-gradient(top, #F5F5F5, #F1F1F1);
		border: solid 1px rgba(0, 0, 0, 0.1);
		padding-left: 10px;
		padding-right: 10px;
		border-radius: 2px;
		-webkit-border-radius: 2px;
	}
	form > input:last-child:hover {
		background: -moz-linear-gradient(top, #F8F8F8, #F1F1F1);
		background: -webkit-linear-gradient(top, #F8F8F8, #F1F1F1);
		background: -o-linear-gradient(top, #F8F8F8, #F1F1F1);
		border: solid 1px #C6C6C6;
		box-shadow: 0 1px 1px rgba(0, 0, 0, 0.1);
	}
	.favimg {
		width: 150px;
		height: 150px;
		margin: 5px;
		border-radius: 5px;
		-webkit-border-radius: 5px;
	}
	.favimg img {
		height: 150px;
	}
	.favimg:hover {
		-moz-box-shadow: 10px 10px 5px #888888;
		-webkit-box-shadow: 10px 10px 5px #888888;
		box-shadow: 10px 10px 5px #888888;
		border: 1px solid #606060;
	}
	.view_fav {
		margin-bottom: 50px;
	}
	p {
		padding: 15px;
	}
	</style>
</head>
<body>
<div class="view_banner">
	<h3>上传商品图片</h3>
</div>
<div class="con_fav">

	<table class="view_fav">
		<tr>
<?php
if (!empty($image_one)) {
?>
			<td>
				<div id="img1" class="favimg">
					<img src="<?php echo base_url().'images/user/proview/'.$image_one; ?>" />
				</div>
			</td>
<?php
}
?>
<?php
if (!empty($image_two)) {
?>
			<td>
				<div id="img2" class="favimg">
					<img src="<?php echo base_url().'images/user/proview/'.$image_two; ?>" />
				</div>
			</td>
<?php
}
?>
<?php
if (!empty($image_three)) {
?>
			<td>
				<div id="img3" class="favimg">
					<img src="<?php echo base_url().'images/user/proview/'.$image_three; ?>" />
				</div>
			</td>
<?php
}
?>
<?php
if (!empty($image_four)) {
?>
			<td>
				<div id="img4" class="favimg">
					<img src="<?php echo base_url().'images/user/proview/'.$image_four; ?>" />
				</div>
			</td>
<?php
}
?>
<?php
if (!empty($image_five)) {
?>
			<td>
				<div id="img5" class="favimg">
					<img src="<?php echo base_url().'images/user/proview/'.$image_five; ?>" />
				</div>
			</td>
<?php
}
?>
		</tr>
	</table>
<?php echo form_open_multipart('seller/uploadimg');?>
<input type="file" name="userfile" size="20" />
<input type="submit" value="上传" />
</form>
<div style="padding: 20px; color: #FF0000;">
<?php
if (!empty($error)) {
	echo $error;
}
?>
</div>
<p>双击图片可将图片删除。
</p>
<p>上传的图片大小不超过<b>1.5mb</b>，宽高不超过<b>1280*800</b>，格式为<b>jpg|gif|png</b>，至少上传<b>1</b>张，最多上传<b>5</b>张。
</p>
</div>
<div id="releasesucc"></div>
<div id="infowindow"></div>
<div id="clearboth"></div>
<script type="text/javascript">
<?php
for ($i = 1; $i < 6; $i++) {
?>
$(document).ready(function(){
	$("#img<?php echo $i; ?>").dblclick(function(){
		$.ajax({
			type: "post",
			data: "del=" + "<?php echo $i; ?>",
			url: "<?php echo base_url(); ?>ajax/delimg",
			success: function(data) {
				if (data == 1) {
					$("#img<?php echo $i; ?>").remove();
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
$(document).ready(function(){
	$("#releasesucc").click(function(){
		$.ajax({
			type: "post",
			url: "<?php echo base_url(); ?>ajax/release",
			success: function(data){
				if (data == 1) {
					$("#infowindow").text("商品发布成功");
					$("#infowindow").fadeTo("fast", 1, function(){
						$(this).fadeTo("normal", 0, function(){
							window.location.href = "<?php echo base_url().'seller/portal'; ?>";
						});
					});
				} else {
					if (data == 2) {
						$("#infowindow").text("至少上传一张图片");
						$("#infowindow").fadeTo("fast", 1, function(){
							$(this).fadeTo(3000, 0);
						});
					}
				}
			},
			error: function(){
				/*alert("ajax error");*/
			}
		});
	});
});
</script>
</body>
</html>