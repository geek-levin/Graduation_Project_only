reSet = function(po_password,newpassword,conpassword){
	document.getElementById(po_password).value = "";
	document.getElementById(newpassword).value = "";
	document.getElementById(conpassword).value = "";
}

reSet_address = function(consignee,college,address,zipcode,phone){
	document.getElementById(consignee).value = "";
	document.getElementById(college).value = "";
	document.getElementById(address).value = "";
	document.getElementById(zipcode).value = "";
	document.getElementById(phone).value = "";
}

function getwot(pinfo) {
	var wot = pinfo.wot;
	var output = "";
	if (wot == 1) {
		output = "交易方式：支持当面交易";
		return output;
	} else {
		if (wot == 2) {
			output = "交易方式：支持货到付款";
			return output;
		} else {
			if (wot == 3) {
				output = "交易方式：支持当面交易与货到付款";
				return output;
			} else {
				return output;
			}
		}
	}
}

function check() {
	var check = $("input").size();
	if (check == 0) {
		$("#gotoorder").remove();
	}
}

reSet_wanted = function(name, price, amount, detail) {
	document.getElementById(name).value = "";
	document.getElementById(price).value = "";
	document.getElementById(amount).value = "";
	document.getElementById(detail).value = "";
}

reSet_shopinfo = function(name, college, idnumber, shop) {
	document.getElementById(name).value = "";
	document.getElementById(college).value = "";
	document.getElementById(idnumber).value = "";
	document.getElementById(shop).value = "";
}

reSet_shopinfo = function(shop, notice, introduce) {
	document.getElementById(shop).value = "";
	document.getElementById(notice).value = "";
	document.getElementById(introduce).value = "";
}

function ifempty() {
	var check = $("input").size();
	if (check == 0) {
		$(".con_fav").html("<p style='padding: 20px;'>你还没有商品哦，快去发布吧~</p>");
	}
}