document.addEventListener('DOMContentLoaded', beginFunctions());

function beginFunctions() {
	//all currency input
	var vals = ["searchMinPrice","searchMaxPrice"];
	for (var i in vals) {
		document.getElementById(vals[i]).addEventListener("keyup", function() {
			this.value = formatCurrency(this.value);
		});
	}
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
