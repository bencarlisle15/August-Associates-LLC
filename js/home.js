document.addEventListener('DOMContentLoaded', function() {
	editArrow();
	setTimeout(function() {
		editArrow();
	}, 1000);
});

window.addEventListener("resize", function() {
	editArrow()
});

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
			urlAdd += urlAdd.length > 0 ? "&" : "?" + inputs[i].id + "=" + inputs[i].value;
		}
	}
	return urlAdd;
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
