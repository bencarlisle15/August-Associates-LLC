document.addEventListener('DOMContentLoaded', function() {
	editArrow();
	setTimeout(function() {
		editArrow();
	}, 1000);
});

window.addEventListener("resize", function() {
	editArrow()
});

//all currency input
var vals = ["searchMinPrice","searchMaxPrice"];
for (var i in vals) {
	document.getElementById(vals[i]).addEventListener("keyup", function() {
		this.value = formatCurrency(this.value);
	});
}

//automatically updates currency input
function formatCurrency(oldVal) {
	var num = oldVal.replace(/(,)/g, '');
	var val = num.replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1,");
	if (val.slice(0,1)!='$' && val != '') {
		val = '$'+ val;
	}
	return val;
}

function editArrow() {
	var top = parseInt(document.getElementById("bigImage").style.marginTop);
	if (top > 0 && getHeight("#largeImage")*0.12 > 0) {
		document.getElementById("arrow").style.top = top + getHeight("#largeImage")*0.11 + "px";
	} else {
		document.getElementById("arrow").style.top = 89 + getHeight("#largeImage")*0.11 + "px";
		setTimeout(function() {
			editArrow();
		}, 100);
	}
}

function submitSearch() {
	window.location.href = "/find-homes"+buildUrl();
}

function buildUrl() {
	var inputs = document.querySelectorAll("#searchAddresses, #searchCities, #searchZips, #searchPropertyType, #searchMinPrice, #searchMaxPrice, #searchMinFeet, #searchMaxFeet");
	var urlAdd = "";
	for (var i = 0; i < inputs.length; i++) {
		if (inputs[i].value != '') {
			var val = inputs[i].value;
			if (inputs[i].id == "searchMinPrice" || inputs[i].id == "searchMaxPrice") {
				val = val.replace(/(,)/g, '').substr(1);
			}
			urlAdd += urlAdd.length > 0 ? "&" : "?" + inputs[i].id + "=" + addPluses(val);
		}
	}
	return urlAdd;
}

function addPluses(str) {
	return str.split(' ').join('+');
}

function submitContactForm() {
	var xhr = new XMLHttpRequest();
	xhr.open("POST", '/phpRequests/apiRequests.php', true);
	xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
	xhr.send("functionname=sendEmail&body=" + createBody());
	document.getElementById("contactForm").reset();
}

function createBody() {
	var body = "Source: Website Home Page Contact Form\nName: " + document.getElementById("contactFormName").value + "\nEmail: " + document.getElementById("contactFormEmail").value + "\nPhone: " + document.getElementById("contactFormPhone").value + "\nAddress: \nMLS Number: \nNotes: " + document.getElementById("contactFormText").value
	return body;
}
