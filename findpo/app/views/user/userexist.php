<html>
<head>
<script type="text/javascript" src="<?php echo base_url(); ?>js/jquery-1.7.2.min.js"></script>
<script type="text/javascript">
$(document).ready(function(){
	$("#user_sugg").keyup(function(){
		$.ajax({
			type: "post",
			data: "username=" + $("#user_sugg").attr("value"),
			url: "<?php echo base_url(); ?>ajax/getusername",
			success: function(data) {
				$("#suggest").html(data);
			},
			error: function() {
				alert("ajax error");
			}
		});
	});
});
</script>
<style type="text/css">
input {
	border: none;
	background: #c7edcc;
	outline: none;
	height: 25px;
	font-size: 16px;
	padding: 0;
	margin: 0;
}
</style>
</head>
<body>
<input type="text" name="username" id="user_sugg" value="" />
<div id="suggest"></div>
</body>
</html>