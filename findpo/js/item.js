/*$(document).ready(function () {
	$(".pro_detail_nav:eq(0)").mouseover(function () {
		$(this).css("background", "#ffffff");
	});
	$(".pro_detail_nav:eq(0)").mouseout(function () {
		$(this).css("background", "");
	});
});

$(document).ready(function () {
	$(".pro_detail_nav:eq(1)").mouseover(function () {
		$(this).css("background", "#ffffff");
	});
	$(".pro_detail_nav:eq(1)").mouseout(function () {
		$(this).css("background", "");
	});
});

$(document).ready(function () {
	$(".pro_detail_nav:eq(2)").mouseover(function () {
		$(this).css("background", "#ffffff");
	});
	$(".pro_detail_nav:eq(2)").mouseout(function () {
		$(this).css("background", "");
	});
});*/

$(document).ready(function () {
	$(".pro_detail_nav:eq(0)").click(function () {
		$(".pro_detailcon:eq(0)").css("display", "block");
		$(".pro_detail_nav:eq(0)").css("background", "#E6E6FA");
		$(".pro_detail_nav:eq(0)").css("font-weight", "bold");
		$(".pro_detail_nav:eq(0)").css("border-bottom", "1px solid #E6E6FA");
		$(".pro_detailcon:eq(1)").css("display", "none");
		$(".pro_detail_nav:eq(1)").css("background", "transparent");
		$(".pro_detail_nav:eq(1)").css("font-weight", "normal");
		$(".pro_detail_nav:eq(1)").css("border-bottom", "none");
		$(".pro_detailcon:eq(2)").css("display", "none");
		$(".pro_detail_nav:eq(2)").css("background", "transparent");
		$(".pro_detail_nav:eq(2)").css("font-weight", "normal");
		$(".pro_detail_nav:eq(2)").css("border-bottom", "none");
	});
});

$(document).ready(function () {
	$(".pro_detail_nav:eq(1)").click(function () {
		$(".pro_detailcon:eq(0)").css("display", "none");
		$(".pro_detail_nav:eq(0)").css("background", "transparent");
		$(".pro_detail_nav:eq(0)").css("font-weight", "normal");
		$(".pro_detail_nav:eq(0)").css("border-bottom", "none");
		$(".pro_detailcon:eq(1)").css("display", "block");
		$(".pro_detail_nav:eq(1)").css("background", "#E6E6FA");
		$(".pro_detail_nav:eq(1)").css("font-weight", "bold");
		$(".pro_detail_nav:eq(1)").css("border-bottom", "1px solid #E6E6FA");
		$(".pro_detailcon:eq(2)").css("display", "none");
		$(".pro_detail_nav:eq(2)").css("background", "transparent");
		$(".pro_detail_nav:eq(2)").css("font-weight", "normal");
		$(".pro_detail_nav:eq(2)").css("border-bottom", "none");
	});
});

$(document).ready(function () {
	$(".pro_detail_nav:eq(2)").click(function () {
		$(".pro_detailcon:eq(0)").css("display", "none");
		$(".pro_detail_nav:eq(0)").css("background", "transparent");
		$(".pro_detail_nav:eq(0)").css("font-weight", "normal");
		$(".pro_detail_nav:eq(0)").css("border-bottom", "none");
		$(".pro_detailcon:eq(1)").css("display", "none");
		$(".pro_detail_nav:eq(1)").css("background", "transparent");
		$(".pro_detail_nav:eq(1)").css("font-weight", "normal");
		$(".pro_detail_nav:eq(1)").css("border-bottom", "none");
		$(".pro_detailcon:eq(2)").css("display", "block");
		$(".pro_detail_nav:eq(2)").css("background", "#E6E6FA");
		$(".pro_detail_nav:eq(2)").css("font-weight", "bold");
		$(".pro_detail_nav:eq(2)").css("border-bottom", "1px solid #E6E6FA");
	});
});